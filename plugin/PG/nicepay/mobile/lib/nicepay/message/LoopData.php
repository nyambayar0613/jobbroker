<?php
/**
 * 
 * @author kblee
 *
 */
class LoopData {
	/**
	 * 
	 * @var $loopData
	 */
	private $loopData;
	
	/**
	 * 
	 */
	public function __construct(){
		$this->loopData = array();
	}
	
	/**
	 * 
	 * @param  $parameterSet
	 */
	public function add($parameterSet){
		foreach($parameterSet as $key=>$value){
			$this->loopData[$key] = $parameterSet[$key];
		}
	}
	
	/**
	 * 
	 * @param  $key
	 */
	public function getParameter($key){
		return $this->loopData[$key];
	}
	
	/**
	 * 
	 * @param $key
	 * @param $value
	 */
	public function setParameter($key,$value){
		$this->loopData[$key] = $value;
	}
}
?>