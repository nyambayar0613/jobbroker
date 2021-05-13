<?php
/**
 * 
 * @author kblee
 *
 */
class DynamicColumn extends Column{
	/**
	 * 
	 * @var $column
	 */
	private $column;
	
	/**
	 * 
	 * @param  $column
	 */
	public function __construct($column){
		$this->column = $column;
	}
	
	/**
	 * 
	 */
	public function getColumn(){
		return $this->column;
	}
}

?>
