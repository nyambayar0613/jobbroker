<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class VBankBulkBodyMessageValidator implements BodyMessageValidator{
	
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
		// 가상계좌입금만료일
		/*
		if($mdto->getParameter(VBANK_EXPIRE_DATE) == null || $mdto->getParameter(VBANK_EXPIRE_DATE) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("가상계좌입금만료일 미설정 오류입니다.");
			}
			throw new ServiceException("V701","가상계좌입금만료일 미설정 오류입니다.");
		}*/
	}	
}

?>
