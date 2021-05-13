<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class BuyerMessageDataValidator{
	
	/**
	 * Default constructor
	 */
	public function __construct(){
		
	}
	
	/**
	 * 
	 * @see BodyMessageValidator::validate()
	 */
	public function validate($mdto) {

		if($mdto->getParameter(PAY_METHOD) !="VBANK_BULK"){
			// 구매자 이름
			if($mdto->getParameter(BUYER_NAME)===null || $mdto->getParameter(BUYER_NAME) == ""){
				
				if(LogMode::isAppLogable())	{
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->errorAppLog("구매자이름 미설정 오류입니다.");
				}
				
				throw new ServiceException("V301","구매자이름 미설정 오류입니다.");	
			}
			
			
			// 구매자연락처
			if($mdto->getParameter(BUYER_TEL) == null || $mdto->getParameter(BUYER_TEL) == ""){
				
				if(LogMode::isAppLogable()) {
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->errorAppLog("구매자연락처 미설정 오류입니다.");
				}
				
				throw new ServiceException("V303","구매자연락처 미설정 오류입니다.");	
			}
			
			// 구매자메일주소
			if($mdto->getParameter(BUYER_EMAIL) == null || $mdto->getParameter(BUYER_EMAIL) == ""){
				if(LogMode::isAppLogable() == true){
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->errorAppLog("구매자메일주소 미설정 오류입니다.");
				}
				throw new ServiceException("V304","구매자메일주소 미설정 오류입니다.");
			}
		}
		
	}
	
	
}
?>
