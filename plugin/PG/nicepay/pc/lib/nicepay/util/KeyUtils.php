<?php
abstract class KeyUtils {

	
	private function __construct(){
		
	}
	
	public static function genTID($mid,$svcCd,$svcPrdtCd){
		$buffer = array();
		
		$nanotime = microtime(true);
		
		$nanoString = str_replace(".","",$nanotime);
		
		$nanoStrLength = strlen($nanoString);
		
		$yyyyMMddHHmmss = date("YmdHis");
		
		$appendNanoStr = substr($nanoString,$nanoStrLength-2,2).mt_rand(10,99);
		
		$buffer = array_merge($buffer,str_split($mid));
		$buffer = array_merge($buffer,str_split($svcCd));
		$buffer = array_merge($buffer,str_split($svcPrdtCd));
		$buffer = array_merge($buffer,str_split(substr($yyyyMMddHHmmss,2,strlen($yyyyMMddHHmmss))));
		$buffer = array_merge($buffer,str_split($appendNanoStr));
		
		return implode($buffer);
	}
}
?>
