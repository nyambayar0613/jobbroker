<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class BankBodyMessageValidator implements BodyMessageValidator{
	
	/**
	 * Default constructor
	 */
	public function __construct(){
		
	}
	
	/**
	 * 
	 * @see BodyMessageValidator::validate()
	 */
	public function validate($mdto){
	  
	  if ($mdto->getParameter(TR_KEY) == null) {
		// BankEncData
  		if($mdto->getParameter(BANK_ENC_DATA) == null || $mdto->getParameter(BANK_ENC_DATA) == ""){
  			
  			if(LogMode::isAppLogable()){
  				$logJournal = NicePayLogJournal::getInstance();
  				$logJournal->errorAppLog("���������� ��ȣȭ ������ �̼��������Դϴ�.");
  			}
  			
  			throw new ServiceException("V602","���������� ��ȣȭ ������ �̼��� �����Դϴ�.");
  		}		
  	}
	}
	
}
?>
