<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class GoodsMessageDataValidator implements BodyMessageValidator{
	
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
		
		// 상품개수
		if($mdto->getParameter(GOODS_CNT) == null || $mdto->getParameter(GOODS_CNT) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("상품개수 미설정 오류입니다.");
			}
			throw new ServiceException("V104","상품개수 미설정 오류입니다.");
		}

		if($mdto->getParameter(PAY_METHOD) !="VBANK_BULK"){
				
			// 상품명
			if($mdto->getParameter(GOODS_NAME) == null || $mdto->getParameter(GOODS_NAME) == ""){
				if(LogMode::isAppLogable()){
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->errorAppLog("상품명 미설정 오류입니다.");
				}
				throw new ServiceException("V401","상품명 미설정 오류입니다.");
			}
			
			// 금액
			if($mdto->getParameter(GOODS_AMT) == null || $mdto->getParameter(GOODS_AMT) == ""){
				if(LogMode::isAppLogable()){
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->errorAppLog("상품금액 미설정 오류입니다.");
				}
				throw new ServiceException("V402","상품금액 미설정 오류입니다.");
			}
		}
		
		// 통화구분 
		if($mdto->getParameter(CURRENCY) == null || $mdto->getParameter(CURRENCY) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("통화구분 미설정 오류입니다.");
			}
			throw new ServiceException("V203","통화구분 미설정 오류입니다.");
		}
	}
}

?>
