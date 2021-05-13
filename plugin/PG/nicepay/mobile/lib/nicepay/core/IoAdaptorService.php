<?php
require_once dirname(__FILE__).'/AbstractService.php';
require_once dirname(__FILE__).'/HeaderValueSetter.php';
require_once dirname(__FILE__).'/../util/IOUtils.php';
require_once dirname(__FILE__).'/../crypt/BlockEncrypt.php';
/**
 * 
 * @author kblee
 *
 */
class IoAdaptorService extends AbstractService{
	
	/** requestTemplateDocument. */
	private $requestTemplateDocument;
	
	/** The response template document. */
	private $responseTemplateDocument;
	
	/** The transport. */
	private $transport;
	
	/** SecureProcessor. */
	private $secureMessageProcessor;

	
	/**
	 * Instantiates a new io adaptor service.
	 */
	public function __construct(){
		
	}
	
	
	/**
	 * Register secure message processor.
	 * 
	 * @param secureMessageProcessor the secure message processor
	 */
	public function registerSecureMessageProcessor($secureMessageProcessor){
		$this->secureMessageProcessor = $secureMessageProcessor;
	}
	
	
	/**
	 * Sets the request template document.
	 * 
	 * @param requestTemplateDocument the request template document
	 */
	public function setRequestTemplateDocument($requestTemplateDocument) {
		$this->requestTemplateDocument = $requestTemplateDocument;
	}

	/**
	 * Sets the response template document.
	 * 
	 * @param responseTemplateDocument the response template document
	 */
	public function setResponseTemplateDocument($responseTemplateDocument) {
		$this->responseTemplateDocument = $responseTemplateDocument;
	}
	

	/**
	 * Sets the transport.
	 * 
	 * @param transport the new transport
	 */
	public function setTransport($transport) {
		$this->transport = $transport;
	}

	public function createMessage($mdto){
		
		if($this->requestTemplateDocument == null)
			throw new ServiceException("S001","요청전문 템플릿이 존재하지 않습니다.");
		
		
		// 헤더 메시지 Value 설정
		$headerValueSetter = new HeaderValueSetter();
		$headerValueSetter->fillValue($mdto);
		
		// secureMessageProcessor not null -> 결제승인이면 암호화 데이터 설정
		if($this->secureMessageProcessor!=null){
			$this->secureMessageProcessor->doProcess($mdto);
		}
		
		
		// body부분 데이터 생성 , header부분 데이터  생성
		$requestBytes = array();

		if("S" == $mdto->getParameter(ENC_FLAG)){
			$bodyBuffer = $this->makeBodyBytesMessage($this->requestTemplateDocument,$mdto);
			$headerBuffer = $this->makeHeaderBytesMessage($this->requestTemplateDocument,$mdto);
		
			$headerBuffer = str_split(implode($headerBuffer));	
	
			$nonCryptBuffer = array_slice($headerBuffer,0,172);

			
			$mergeBuffer = array();
			
			$mergeBuffer = array_merge($mergeBuffer,array_slice($headerBuffer,172));
			
			$mergeBuffer = array_merge($mergeBuffer,$bodyBuffer);
			
			
			$encryptData = BlockEncrypt::getInstance()->encrypt(implode($mergeBuffer));
			
			
			$encryptData = base64_encode($encryptData);
			

			$dataLength = strlen($encryptData)+sizeof($nonCryptBuffer);
			$dataStringLength = sizeof(str_split((string)$dataLength));
			$length = "";
			for($i = 0 ; $i < 6 - $dataStringLength ; $i++){
				$length=$length."0";
			}
				
			$length=$length.$dataLength;
			// 길이 데이터 설정하기
			$sendBytes = array();
			$sendBytes = array_merge($sendBytes,array_slice($nonCryptBuffer,0,24));
			$sendBytes = array_merge($sendBytes,str_split($length));
			$sendBytes = array_merge($sendBytes,array_slice($nonCryptBuffer,30));
			
			$sendBytes = array_merge($sendBytes,str_split($encryptData));
			
		        $requestBytes = array_merge($requestBytes,$sendBytes);	
			
		}else{
			$bodyBuffer = $this->makeBodyBytesMessage($this->requestTemplateDocument,$mdto);
			
		
			// 전체 길이 설정
			$mdto->setParameter(LENGTH, strlen(implode($bodyBuffer)) + $this->requestTemplateDocument->getHeader()->getLength());
			$headerBuffer = $this->makeHeaderBytesMessage($this->requestTemplateDocument,$mdto);
			
			$requestBytes = array_merge($requestBytes,$headerBuffer);
			$requestBytes = array_merge($requestBytes,$bodyBuffer);
		}
			
		return implode($requestBytes);
	}
	
	public function send($msg) {
		$responseBytes = $this->transport->doTrx($msg);
		return $responseBytes;
	}
	
	public function parseMessage($msg) {
		if($this->responseTemplateDocument == null)
			throw new ServiceException("S002","응답전문 템플릿이 존재하지 않습니다.");
		
		
		try {
			$responseMessageDTO = new WebMessageDTO();
		
			$recvBytesArray = str_split($msg);			

	
			// Header 처리
			$recvBytesArray = $this->parseHeaderMessage($recvBytesArray, $responseMessageDTO);
			
			// Body 처리
			$recvBytesArray = $this->parseBodyMessage($recvBytesArray, $responseMessageDTO);
			
			return $responseMessageDTO;
		} catch (Exception $e) {
			throw new ServiceException("T003","수신 데이터 파싱 중 예외가 발생하였습니다. : "+$e->getMessage());
		} 
	}

	/**
	 * Parses the body message.
	 * 
	 * @param bis the bis
	 * @param responseMessageDTO the response message dto
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private function parseBodyMessage($buffer, $responseMessageDTO) {
		$map = $this->responseTemplateDocument->getMap();
		foreach($map as $key=>$value){
			$column = $value;
			$buffer = IOUtils::readFromStream($buffer,$column,$responseMessageDTO);
		}
	}

	/**
	 * Parses the header message.
	 * 
	 * @param bis the bis
	 * @param responseMessageDTO the response message dto
	 * 
	 * @throws IOException Signals that an I/O exception has occurred.
	 */
	private function parseHeaderMessage($buffer, $responseMessageDTO)  {
		$header = $this->responseTemplateDocument->getHeader();
		$map = $header->getMap();
		foreach($map as $key=>$value){
			$column = $value;
			$buffer = IOUtils::readFromStream($buffer,$column,$responseMessageDTO);
					
		}	
		return $buffer;
	}

	/**
	 * Make header bytes message.
	 * 
	 * @param requestDocumentTemplate the request document template
	 * @param mdto the mdto
	 * 
	 * @return the byte[]
	 * 
	 * @throws ServiceException the service exception
	 */
	private function makeHeaderBytesMessage($requestDocumentTemplate,$mdto){
		$headerBuffer = array();
		try {
			
			$header = $requestDocumentTemplate->getHeader();
			$map = $header->getMap();
			foreach($map as $key=>$value){
				$column = $value;
				
				$headerBuffer = IOUtils::writeToStream($headerBuffer,$column,$mdto);
			}
			
		} catch (Exception $e) {
			throw new ServiceException("T004","요청 전문의 헤더부 생성 중 오류가 발생하였습니다. : "+e.getMessage());
		} 
		return $headerBuffer;
		
	}

	/**
	 * Make body bytes message.
	 * 
	 * @param requestDocumentTemplate the request document template
	 * @param mdto the mdto
	 * 
	 * @return the byte[]
	 * 
	 * @throws ServiceException the service exception
	 */
	private function makeBodyBytesMessage($requestDocumentTemplate,$mdto){
		$bodyBuffer = array();
		$map = $requestDocumentTemplate->getMap();

		$logJournal = NicePayLogJournal::getInstance();
		//$logJournal->writeAppLog("$requestDocumentTemplate  [".$requestDocumentTemplate."]");

		if(isset($map)){
			try {
				foreach($map as $key=>$value){
					$column = $value;
					$bodyBuffer = IOUtils::writeToStream($bodyBuffer,$column,$mdto);
				}
			} catch (Exception $e) {
				throw new ServiceException("T005","요청 전문의 바디부 생성 중 오류가 발생하였습니다. : "+$e->getMessage());
			}
		}
		
		return $bodyBuffer;
	}
}

?>
