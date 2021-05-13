<?php

/**
 * 
 * @author kblee
 *
 */
class IoAdaptorTransport {
	
	/**
	 *
	 * @var $socket
	 */
	private $socket;
	private $useDomainEnable;
	protected $pg_server;
	
	// 특정 아이피 포트를 지정해서 사용할 수 있도록 추가 (달러결제)
	protected $requestPgIp;
	protected $requestPgPort;
	
	/**
	 */
	public function __construct($useDomainEnable) {
		$this->useDomainEnable = $useDomainEnable;
	}
	
	/**
	 *
	 * @param unknown_type $socket
	 */
	public function setSocket($socket) {
		$this->socket = $socket;
	}
	
	/**
	 *
	 * @param unknown_type $msg        	
	 */
	public function doTrx($msg) {
		// set_time_limit(CONNECT_TIMEOUT);

		$useDomainEnable = $this->useDomainEnable;
		
		if ("1" == $useDomainEnable) {
			if (LogMode::isAppLogable()) {
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("USE_DOMAIN -> " . $useDomainEnable);
			}
			try {
				$address = gethostbyname(NICEPAY_DOMAIN_NAME);
			} catch (Exception $e) {
				$address = NICEPAY_FRONT_L4_IP;
				if (LogMode::isAppLogable()) {
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->writeAppLog("PG SERVER NOT FOUND");
					$logJournal->writeAppLog("SET DEFAULT NICEPAY FRONT L4 IP -> " . NICEPAY_FRONT_L4_IP);
				}
				// throw new ServiceException("X001","서버 도메인명이 잘못 설정되었습니다. : "+$e->getMessage());
			}
		} else if ("2" == $useDomainEnable) {
			// 개발승인서버로 접근
			$address = NICEPAY_DEV_FRONT_L4_IP;
		} else if ($this->pg_server == "TEST") {
			$address = NICEPAY_DEV_FRONT_L4_IP;
		} else if ($this->pg_server == "PG1") {
			$address = NICEPAY_PG1_DOMAIN_NAME;
		} else if ($this->pg_server == "PG2") {
			$address = NICEPAY_PG2_DOMAIN_NAME;
		} else if ($this->pg_server == "SANGIL") {
			$address = NICEPAY_SANGIL_DOMAIN_NAME;
		} else if ($this->requestPgIp != "") {
			// 직접 IP를 설정한 경우
			$address = $this->requestPgIp;
		} else {
			// NICEPAY_FRONT_L4_IP는 IP이므로 gethostbyname()-PHP시스템메소드- 제거
			$address = NICEPAY_FRONT_L4_IP;
		}
		
		if (LogMode::isAppLogable()) {
			$logJournal = NicePayLogJournal::getInstance();
			$logJournal->writeAppLog("TRY SERVER CONNECT TO : " . $address . " PORT : " . NICEPAY_ADAPTOR_LISTEN_PORT);
		}

		$startTime = microtime();
		$socket = null;
		try{
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			socket_connect($socket, $address, NICEPAY_ADAPTOR_LISTEN_PORT);
		}catch(Exception $e){
			if (LogMode::isAppLogable()) {
				$endTime = microtime();
				$logJournal->writeAppLog("SERVER CONNECT ERROR" . $logJournal->getLapTime($startTime, $endTime));
			}
			throw new ServiceException("X002", "서버로 소켓 연결 중 오류가 발생하였습니다. : " + $e->getMessage());
		}
		
		if (LogMode::isAppLogable()) {
			$endTime = microtime();
			$logJournal->writeAppLog("SERVER CONNECT OK : " . $address . $logJournal->getLapTime($startTime, $endTime));
		}
		
		socket_write($socket, $msg);
		
		$recvMessage = $this->readData($socket);
		
		socket_close($socket);
		
		return $recvMessage;
	}
	
	/**
	 *
	 * @param unknown_type $socket        	
	 */
	private function readData($socket){
		$buffer = array();
		try {
			$data = socket_read($socket, 256, PHP_BINARY_READ);
			
			$dataLength = strlen($data);
			
			if ($dataLength >= LENGTH_END_POS){
				
				$readLengthStr = substr($data, LENGTH_START_POS, LENGTH_MSG_SIZE);
				
				$readLengthStr = $readLengthStr == null ? "0" : $readLengthStr;
				
				$mustReadLength = (int) $readLengthStr;
				
				$buffer = array_merge($buffer, str_split($data));
				
				$repeatReadCnt = 0;
				$readCnt = strlen($data);
				$readData = null;
				
				while(($readData = socket_read($socket, 1024, PHP_BINARY_READ)) !== false){
					$buffer = array_merge($buffer, str_split($readData));
					$repeatReadCount = strlen($readData);
					$readCnt += $repeatReadCount;
					if ($readCnt >= $mustReadLength) {
						break;
					}
				}
				
				return implode($buffer);
			} else {
				throw new ServiceException("T002", "비정상적인 수신 전문입니다.");
			}
		} catch(ServiceException $e){
			throw $e;
		} catch(Exception $e){
			throw new ServiceException("T002", "비정상적인 수신 전문입니다.");
		}
	}
	public function setTestFlag($flag) {
		$this->pg_server = $flag;
	}
	public function setPgIp($requestPgIp, $requestPgPort) {
		if (LogMode::isAppLogable()) {
			$logJournal = NicePayLogJournal::getInstance();
			$logJournal->writeAppLog("********************************************");
			$logJournal->writeAppLog("별도의 IP/PORT 를 지정합니다. (" . $requestPgIp . ":" . $requestPgPort . ")");
			$logJournal->writeAppLog("********************************************");
		}
		$this->requestPgIp = $requestPgIp;
		$this->requestPgPort = $requestPgPort;
	}
}

?>
