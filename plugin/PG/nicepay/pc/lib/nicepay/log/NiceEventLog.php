<?php
/*____________________________________________________________

*	@ description		: 로그 사용을 위한 클래스
*	@ name				: NicepayLiteLog.php
*	@ auther			: NICEPAY I&T (tech@nicepay.co.kr)
*	@ date				: 
*	@ modify			
	
	2013.05.24			Update Log
	
*____________________________________________________________
*/
class NICEEventLog 
{
	var $handle;
	var $type;
	var $log;
	var $debug_mode;
	var	$array_key;
	var $debug_msg;
	var $starttime;
	var $debug;
	
	
  function __construct($mode)
  {
	    $this->log = "true";
		$this->debug_msg = array( "", "CRITICAL", "ERROR", "NOTICE", "4", "INFO", "6", "DEBUG", "8"  );
		$this->debug_mode = $mode;
		$this->type = "event";
		$this->starttime= $this->GetMicroTime();
		$debug = 5;

	}
  function StartEventLog($dir) 
	{
		$logfile = $dir. "/".$this->type."_".date("ymd").".log";
		$this->handle = fopen( $logfile, "a+" );
		if( !$this->handle )
		{
			return false;
		}
		return true;
	}
	
	function WriteEventLog($data, $response) 
	{
		$eventData = $this->makeEventData($data, $response);
		

		if( !$this->handle || $this->log == "false" ) return;	
		$pfx = " [" . date("Y-m-d H:i:s") . "] <" . getmypid() . "> ";
		
		
		
		fwrite( $this->handle, $pfx . $eventData . "\r\n" );
	}
	

	function WriteArrayEventLog($data)
	{
		if( !$this->handle || $this->log == "false" ) return;
		
		$pfx = $this->debug_msg[$debug]." [" . date("Y-m-d H:i:s") . "] <" . getmypid() . "> ";
    
		$this->printArray($data,$pfx);
		fflush( $this->handle );
	}

	
	function printArray($array, $pfx=''){
		
		if(!empty($array)){
			if (is_array($array)){
			foreach ($array as $key => $val){
				
				if( $key == "CardNo" && strlen($val)>14){
            		fwrite( $this->handle, $pfx . $key . ":[" .substr($val,0,12)."****" . "]\r\n");
				}else if( $key == "CardPw" && strlen($val)==2){
            		fwrite( $this->handle, $pfx . $key . ":[" ."**" . "]\r\n");
				}else{ 
					fwrite( $this->handle, $pfx . $key . ":[" . $val . "]\r\n");
				}
				if(is_array($val)){
					$this->printArray($value, $pfx.' ');
				}  
			} 
			}
		}
	}

	function makeEventData( $data , $response) {
		$resultCode = trim($response->getParameter(RESULT_CODE));
		
		if($data->getParameter(SERVICE_MODE) == PAY_SERVICE_CODE) {
			$eventData = "P|";
		} else {
			$eventData = "C|";
		}
		
		if($resultCode == "3001" || $resultCode == "4000" || $resultCode == "4100" || $resultCode == "A000") {
			$eventData .= "TE|";
		} else {
			$eventData .= "TF|";
		}
		
		$newDate = substr_replace(trim($response->getParameter(AUTH_DATE)), "|", 6, 0);

		$eventData .= $newDate.("|");
		$eventData .= trim($response->getParameter(PAY_METHOD)).("|");
		$eventData .= trim($response->getParameter(GOODS_NAME)).("|");
		
		if($data->getParameter(SERVICE_MODE) == PAY_SERVICE_CODE) {
			$eventData .= trim($response->getParameter(GOODS_AMT)).("|");
		} else {
			$eventData .= trim($response->getParameter(CANCEL_AMT)).("|");
		}
	
		$eventData .= trim($data->getParameter(MALL_USER_ID)).("|");
		$eventData .= trim($response->getParameter(RESULT_CODE)).("|");
		$eventData .= trim($response->getParameter(RESULT_MSG));
		
		return $eventData;
	}
	function Base64Encode( $str )
	{   
	  return substr(chunk_split(base64_encode( $str ),64,"\n"),0,-1)."\n";
	}   
	function GetMicroTime()
	{
		list($usec, $sec) = explode(" ", microtime());
		return (float)$usec + (float)$sec;
	}
	function SetTimestamp()
	{
		$m = explode(' ',microtime());
		list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0]*1000,3));
		return date("Y-m-d H:i:s", $totalSeconds) . ":$extraMilliseconds";
	}
	function SetTimestamp1()
	{
		$m = explode(' ',microtime());
		list($totalSeconds, $extraMilliseconds) = array($m[1], (int)round($m[0]*10000,4));
		return date("ymdHis", $totalSeconds) . "$extraMilliseconds";
	}

}

?>