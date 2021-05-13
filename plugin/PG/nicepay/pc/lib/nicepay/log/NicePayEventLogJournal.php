<?php
require_once dirname(__FILE__).'/../core/Constants.php';
require_once dirname(__FILE__).'/NiceEventLog.php';

/**
 * 
 * @author kblee
 *
 */
class NicePayEventLogJournal{
	
	/**
	 * 
	 * @var $instance
	 */
	private static $instance;
	
	/** The event log path. */
	private $logPath;
	
	
	/** The event logger. */
	private $eventLogger;
	
	/**
	 * Create a MnBankLogJournal instance.
	 */
	private function __construct(){
		
	}
	
	/**
	 * get a Single MnBankLogJournal instance.
	 */
	public static function getInstance(){
		if(!isset(NicePayEventLogJournal::$instance)){
			NicePayEventLogJournal::$instance = new NicePayEventLogJournal();
		}
		return NicePayEventLogJournal::$instance;
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
		if(!isset($this->eventLogger)){
			try {
				$this->eventLogger = new NICEEventLog("DEBUG","event");
				if($this->eventLogger->StartEventLog($this->logPath)){
		
				} else {
					echo "로그 경로 설정 실패";
				}
			} catch (Exception $e) {
				echo "Exception  : Event Log Configuration Error";
			}
		}
	}
	
	public function writeEventLog($string, $response){
		$this->eventLogger->WriteEventLog($string, $response);
	}
	
	public function errorEventLog($string){
		$this->eventLogger->WriteEventLog($string);
	}
	
	public function warnEventLog($string){
		$this->eventLogger->WriteEventLog($string);
	}
	
	public function closeEventLog($string){
		$this->eventLogger->CloseNiceEventLog($string);
	}
	
}
?>
