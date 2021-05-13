<?php
/**
 * 
 * @author kblee
 *
 */
class Loop extends Column{
	
	/**
	 * 
	 * @var $map
	 */
	private $map = array();
	
	/**
	 * 
	 */
	public function __construct(){
		
	}
	
	/**
	 * 
	 */
	public function getMap(){
		return $this->map;
	}
	
	/**
	 * 
	 * @param $column
	 */
	public function add($column){
		$this->map[$column->getName()] = $column;
	}
}
?>