<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class CpBillBodyMessageValidator implements BodyMessageValidator{

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
		// 이통사구분
		if($mdto->getParameter(CARRIER) == null || $mdto->getParameter(CARRIER) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("이통사구분 미설정 오류입니다.");
			}
			throw new ServiceException("VB02","이통사구분 미설정 오류입니다.");
		}
		
		// 휴대폰번호
		if($mdto->getParameter(DST_ADDR) == null || $mdto->getParameter(DST_ADDR) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("휴대폰번호 미설정 오류입니다.");
			}
			throw new ServiceException("VB05","휴대폰번호 미설정 오류입니다.");
		}
		
		// 고객고유번호
		if($mdto->getParameter(IDEN) == null || $mdto->getParameter(IDEN) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("고객고유번호(주민번호,사업자번호) 미설정 오류입니다.");
			}
			throw new ServiceException("VB09","고객고유번호(주민번호,사업자번호) 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(USER_IP) == null || $mdto->getParameter(USER_IP) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("고객 IP 미설정 오류입니다.");
			}
			throw new ServiceException("VB10","고객 IP 미설정 오류입니다.");
		}
		
	}	
}
?>
