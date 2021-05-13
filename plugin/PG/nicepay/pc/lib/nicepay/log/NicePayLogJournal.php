<?php
require_once dirname(__FILE__).'/../core/Constants.php';
require_once dirname(__FILE__).'/NiceLog.php';

/**
 * 
 * @author kblee
 *
 */
class NicePayLogJournal{
	
	/**
	 * 
	 * @var $instance
	 */
	private static $instance;
	
	/** The event log path. */
	private $logPath;
	
	
	/** The event logger. */
	private $eventLogger;

	private $appLogger;
	
	/**
	 * Create a MnBankLogJournal instance.
	 */
	private function __construct(){
		
	}
	
	/**
	 * get a Single MnBankLogJournal instance.
	 */
	public static function getInstance(){
		if(!isset(NicePayLogJournal::$instance)){
			NicePayLogJournal::$instance = new NicePayLogJournal();
		}
		return NicePayLogJournal::$instance;
	}
	
	/**
	 * 
	 * @param  $eventLogPath
	 */
	public function setLogDirectoryPath($logPath){
		$this->logPath = $logPath;
	}
	
	/**
	 * 
	 */
	public function configureNicePayLog4PHP(){
		if(!isset($this->appLogger) || !isset($this->eventLogger)){
			try {
				$this->appLogger = new NICELog("DEBUG","application");
				if($this->appLogger->StartLog($this->logPath)){
						
				} else {
					echo "로그 경로 설정 실패";
				}	
			} catch (Exception $e) {
				echo "Exception  : Application Log Configuration Error";
			}
		}
	}

	public function writeAppLog($string){
		$this->appLogger->WriteLog($string);
	}

	public function errorAppLog($string){
		$this->appLogger->WriteLog($string);
	}

	public function warnAppLog($string){
		$this->appLogger->WriteLog($string);
	}

	public function closeAppLog($string){
		$this->appLogger->CloseNiceLog($string);
	}
	
	public function getLapTime($start, $end){
		return $this->appLogger->getLapTime($start, $end);
	}
}
?>
