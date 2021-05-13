<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class DeliveryRegisterBodyMessageValidator implements BodyMessageValidator{

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
		// TID
		if($mdto->getParameter(TID) == null || $mdto->getParameter(TID) == ""){
			
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("거래TID 미설정 오류입니다.");
			}
			throw new ServiceException("VC01","거래TID 미설정 오류입니다.");
		}	

		// INVOICE_NO
		if($mdto->getParameter(INVOICE_NO) == null || $mdto->getParameter(INVOICE_NO) == ""){
			
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("운송장번호 미설정 오류입니다.");
			}
			throw new ServiceException("VC02","운송장번호 미설정 오류입니다.");
		}	
		
		// REGISTER_NAME
		if($mdto->getParameter(REGISTER_NAME) == null || $mdto->getParameter(REGISTER_NAME) == ""){
			
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("등록자명 미설정 오류입니다.");
			}
			throw new ServiceException("VC03","등록자명 미설정 오류입니다.");
		}	
		
		if($mdto->getParameter(MID) == null || $mdto->getParameter(MID) == ""){
			
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("MID 미설정 오류입니다.");
			}
			throw new ServiceException("VC04","MID 미설정 오류입니다.");
		}
		
	}
}
?>