<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class CellPhoneRegItemBodyValidator implements BodyMessageValidator{
	
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
		if($mdto->getParameter(MID) == null || $mdto->getParameter(MID) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("상점ID 미설정 오류입니다.");
			}
			throw new ServiceException("V201","상점ID 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(GOODS_NAME) == null || $mdto->getParameter(GOODS_NAME) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("상품명 미설정 오류입니다.");
			}
			throw new ServiceException("V401","상품명 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(GOODS_AMT) == null || $mdto->getParameter(GOODS_AMT) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("상품금액 미설정 오류입니다.");
			}
			throw new ServiceException("V402","상품금액 미설정 오류입니다.");
		}
		
	}
}

?>
