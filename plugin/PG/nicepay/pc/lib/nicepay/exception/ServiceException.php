<?php
require_once dirname(__FILE__).'/../core/ErrorMessagesMap.php';
/**
 * 
 * @author kblee
 *
 */
class ServiceException extends Exception{
	
	/**
	 * 
	 * @var $errorCode
	 */
	private $errorCode;
	
	/**
	 * 
	 * @var $errorMessage
	 */
	private $errorMessage;
	
	/**
	 * 
	 * @param  $errorCode
	 * @param  $errorMessage
	 */
	public function __construct($errorCode,$errorMessage){
		$this->errorCode = $errorCode;
		$this->errorMessage = $errorMessage;
	}
	
	/**
	 * 
	 */
	public function getErrorCode() {
		return $this->errorCode;
	}

	/**
	 * 
	 * @param  $errorCode
	 */
	public function setErrorCode($errorCode) {
		$this->errorCode = $errorCode;
	}
	
	/**
	 * 
	 */
	public function getErrorMessage() {
		if($this->errorMessage == null || "" == $this->errorMessage){
			return parent::getMessage();
		}else{
			if(ErrorMessagesMap::containsErrorCode($this->errorCode)){
				return ErrorMessagesMap::getErrorMessage($this->errorCode);
			}else{
				return $this->errorMessage;
			}
		}
	}
	
	/**
	 * 
	 * @param  $msg
	 */
	public function setMessage($msg){
		$this->errorMessage = $msg;
	}
	
}
?>
