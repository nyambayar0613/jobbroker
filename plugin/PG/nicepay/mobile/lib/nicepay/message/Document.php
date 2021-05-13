<?php

/**
 * 
 * @author kblee
 *
 */
class Document {

	/**
	 * 
	 * @var $header
	 */
	private $header = null;
	
	/**
	 * 
	 * @var $map
	 */
	private $map = null;

	/**
	 * 
	 * @var $id
	 */
	private $id=null;
	
	/**
	 * 
	 * @var $version
	 */
	private $version=null;
	
	/**
	 * @var $description string
	 */
	private $description=null;
	
	/**
	 * 
	 * @var $prefixId
	 */
	private $prefixId = null;
	
	/**
	 * 
	 */
	public function __construct(){
		
	}
	
	/**
	 * 
	 */
	public function getVersion() {
		return $this->version;
	}
	
	/**
	 * 
	 * @param  $version
	 */
	public function setVersion($version) {
		$this->version = $version;
	}

	/**
	 * 
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * 
	 * @param  $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
	/**
	 * 
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * 
	 * @param  $id
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * 
	 */
	public function getPrefixId() {
		return $this->prefixId;
	}
	
	/**
	 * 
	 * @param  $prefixId
	 */
	public function setPrefixId($prefixId) {
		$this->prefixId = $prefixId;
	}
	
	/**
	 * 
	 */
	public function getHeader() {
		return $this->header;
	}
	
	/**
	 * 
	 * @param  $header
	 */
	public function setHeader($header) {
		$this->header = $header;
	}

	/**
	 * 
	 */
	public function getMap(){
		return $this->map;
	}

	/**
	 * 
	 * @param  $column
	 */
	public function add($column){
		$this->map[$column->getName()] = $column;
	}

	/**
	 * 
	 * @param  $message
	 */
	protected function appendPrefix($message){
		$newMap = array();
		
		foreach($message as $key=>$value){
			$newMap[$key] = $message[$key];
		}
		
		foreach($this->map as $key=>$value){
			$newMap[$key] = $this->map[$key];
		}
		
		$this->map = $newMap;
	}
}
?>
