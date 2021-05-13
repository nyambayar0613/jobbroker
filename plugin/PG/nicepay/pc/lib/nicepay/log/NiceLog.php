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
class NICELog 
{
	var $handle;
	var $type;
	var $log;
	var $debug_mode;
	var	$array_key;
	var $debug_msg;
	var $starttime;
	var $debug;
	
	
  function __construct($mode, $type)
  {
	    $this->log = "true";
		$this->debug_msg = array( "", "CRITICAL", "ERROR", "NOTICE", "4", "INFO", "6", "DEBUG", "8"  );
		$this->debug_mode = $mode;
		$this->type = $type;
		$this->starttime= $this->GetMicroTime();
		$debug = 5;

	}
  function StartLog($dir) 
	{
		$logfile = $dir. "/".$this->type."_".date("ymd").".log";
		$this->handle = fopen( $logfile, "a+" );
		if( !$this->handle )
		{
			return false;
		}
		if($this->debug_mode != "INFO"){
			$this->WriteLog( "START NICEPAY TX (OS:".php_uname('s').php_uname('r').",PHP:".phpversion()."))" );
			$this->WriteLog( "TX VERSION INFO (".TX_VERSION."-".TX_VERSION_RELEASED_DATE."-".TX_VERSION_FINAL_WRITER.")" );
		}
		return true;
	}
	
	function WriteLog($data)
	{
		if( !$this->handle || $this->log == "false" ) return;
		$pfx = " [" . date("Y-m-d H:i:s") . "] <" . getmypid() . "> ";
		fwrite( $this->handle, $pfx . $data . "\r\n" );
		
	}
	
	function CloseNiceLog($msg){
		
		$laptime=$this->GetMicroTime()-$this->starttime;
		$this->WriteLog( "END ".$this->type." ".$msg ." Laptime:[".round($laptime,3)." sec]" );
		$this->WriteLog("===============================================================" );
		fclose( $this->handle );
	}

	function WriteArrayLog($data)
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

	/**
	 * 소요시간 반환
	 *
	 * @param timestamp $start
	 * @param timestamp $end
	 * @return string
	 */
	function getLapTime($start, $end) {
	
		list($usec, $sec) = explode(" ", $start);
		$start = (float)$usec + (float)$sec;
	
		list($usec, $sec) = explode(" ", $end);
		$end = (float)$usec + (float)$sec;
	
		$labtime = $end - $start;
	
		return " [" . round($labtime, 3) . " sec]";
	}

}

?>