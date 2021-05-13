<?php
/**
 * 
 * @author kblee
 *
 */
class LoopGroup{
	/**
	 * 
	 * @var $loopSet
	 */
	private $loopSet;
	
	/**
	 * 
	 * @var $index
	 */
	private $index;
	
	/**
	 * 
	 */
	public function __construct(){
		$this->loopSet = array();
		$this->index = 0;
	}
	
	/**
	 * 
	 * @param $loopData
	 */
	public function add($loopData){
		 $this->loopSet[$this->index++]  =  $loopData ;  
	}
	
	/**
	 * 
	 * @param $index
	 */
	public function get($index){
		return $this->loopSet[$index];
	}
	
	/**
	 * 
	 */
	public function size(){
		return sizeof($this->loopSet);
	}
	
}
?>