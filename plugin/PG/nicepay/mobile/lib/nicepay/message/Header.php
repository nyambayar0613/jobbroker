<?php
/**
 * 
 * @author kblee
 *
 */
class Header {
	/**
	 * 
	 * @var HEADER_LENGTH_KEY
	 */
	const HEADER_LENGTH_KEY = "Length";
	
	/**
	 * 
	 * @var HEADER_ID_KEY
	 */
	const HEADER_ID_KEY = "ID";
	
	/**
	 * 
	 * @var HEADER_VERSION_KEY
	 */
	const HEADER_VERSION_KEY = "Version";
	
	/**
	 * 
	 * @var $length
	 */
	private $length = 0;
	
	/**
	 * 
	 * @var $lengthPosition
	 */
	private $lengthPosition = 0;
	
	/**
	 * 
	 * @var $lengthPoSize
	 */
	private $lengthPoSize = 0;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $map;
	
	/**
	 * 
	 */
	public function __construct(){
		$this->map = array();
	}
	
	/**
	 * 
	 */
	public function getLength(){
		return $this->length;
	}

	/**
	 * 
	 */
	public function getLengthPosition(){
		return $this->lengthPosition;
	}

	/**
	 * 
	 */
	public function getLengthPoSize(){
		return $this->lengthPoSize;
	}

	/**
	 * 
	 * @param $column
	 */
	public function add($column){
		$this->map[$column->getName()]=$column;
	}

	/**
	 * 
	 */
	public function setup(){
		$column = null;

		$sum = 0;
		
		foreach($this->map as $key => $value){
			$sum = $sum + $value->getSize();
		}
		
		$this->length = $sum;
		
		$lec = $this->map[Header::HEADER_LENGTH_KEY];
		$this->lengthPoSize = $lec->getSize();


		$lp = 0;
		
		foreach($this->map as $key=>$value){
			$col = $this->map[$key];
			if($col->getName() == Header::HEADER_LENGTH_KEY){
				break;
			}
			$lp+=($col->getSize());
		}
		
		$this->lengthPosition = $lp;
	}
	
	public function getMap(){
		return $this->map;
	}
}
?>
