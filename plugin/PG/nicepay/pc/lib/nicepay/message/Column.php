<?php
/**
 * 
 * @author kblee
 *
 */
class Column {
	/**
	 * 
	 * @var MODE_A
	 */
	const MODE_A = 1;
	
	/**
	 * 
	 * @var MODE_N
	 */
	const MODE_N = 2;
	
	/**
	 * 
	 * @var MODE_AN
	 */
	const MODE_AN = 3;
	
	/**
	 * 
	 * @var MODE_AH
	 */
	const MODE_AH = 4;
	
	/**
	 * 
	 * @var $name
	 */
	private $name;
	
	/**
	 * 
	 * @var $description
	 */
	private $description;
	
	/**
	 * 
	 * @var $mode
	 */
	private $mode;
	
	/**
	 * 
	 * @var $size
	 */
	private $size;
	
	/**
	 * 
	 * @var $encrypt
	 */
	private $encrypt;
	
	/**
	 * 
	 * @var $required
	 */
	private $required;
	
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
	public function isEncrypt() {
		return $this->encrypt;
	}
	
	/**
	 * 
	 * @param  $encrypt
	 */
	public function setEncrypt($encrypt) {
		$this->encrypt = $encrypt;
	}
	
	/**
	 * 
	 */
	public function getMode() {
		return $this->mode;
	}
	
	/**
	 * 
	 * @param  $mode
	 */
	public function setMode($mode) {
		$this->mode = $mode;
	}
	
	/**
	 * 
	 */
	public function getName() {
		
		return $this->name;
	}
	
	/**
	 * 
	 * @param  $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * 
	 */
	public function isRequired() {
		return $this->required;
	}
	
	/**
	 * 
	 * @param $required
	 */
	public function setRequired($required) {
		$this->required = $required;
	}
	
	/**
	 * 
	 */
	public function getSize() {
		return $this->size;
	}
	
	/**
	 * 
	 * @param  $size
	 */
	public function setSize($size) {
		$this->size = $size;
	}
	
	
	
}
?>
