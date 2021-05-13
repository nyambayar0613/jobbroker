<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class CellPhoneBodyMessageValidator implements BodyMessageValidator{
	
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
		/*
		if($mdto->getParameter(SERVER_INFO) == null || $mdto->getParameter(SERVER_INFO) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("거래KEY 미설정 오류입니다.");
			}
			throw new ServiceException("VA01","거래KEY 미설정 오류입니다.");
		}
		*/
		
		if($mdto->getParameter(CARRIER) == null || $mdto->getParameter(CARRIER) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("이통사구분 미설정 오류입니다.");
			}
			throw new ServiceException("VA02","이통사구분 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(SMS_OTP) == null || $mdto->getParameter(SMS_OTP) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("SMS승인번호 미설정 오류입니다.");
			}
			throw new ServiceException("VA03","SMS승인번호 미설정 오류입니다.");
		}
		
		
		if($mdto->getParameter(DST_ADDR) == null || $mdto->getParameter(DST_ADDR) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("휴대폰번호 미설정 오류입니다.");
			}
			throw new ServiceException("VA05","휴대폰번호 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(GOODS_CL) == null || $mdto->getParameter(GOODS_CL) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("상품구분코드 미설정 오류입니다.");
			}
			throw new ServiceException("VA11","상품구분코드 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(PHONE_ID) == null || $mdto->getParameter(PHONE_ID) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("모빌PhoneID 미설정 오류입니다.");
			}
			throw new ServiceException("VA12","모빌PhoneID 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(REC_KEY) == null || $mdto->getParameter(REC_KEY) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("모빌RecKey 미설정 오류입니다.");
			}
			throw new ServiceException("VA13","모빌RecKey 미설정 오류입니다.");
		}
	}
}

?>
