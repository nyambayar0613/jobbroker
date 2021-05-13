<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class CellPhoneSelfDeliverBodyValidator implements BodyMessageValidator{
	
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
		if($mdto->getParameter(SERVER_INFO) == null || $mdto->getParameter(SERVER_INFO) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("거래KEY 미설정 오류입니다.");
			}
			throw new ServiceException("VA01","거래KEY 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(DST_ADDR) == null || $mdto->getParameter(DST_ADDR) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("휴대폰번호 미설정 오류입니다.");
			}
			throw new ServiceException("VA05","휴대폰번호 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(IDEN) == null || $mdto->getParameter(IDEN) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("고객고유번호(주민번호,사업자번호) 미설정 오류입니다.");
			}
			throw new ServiceException("VA09","고객고유번호(주민번호,사업자번호) 미설정 오류입니다.");
		}
		
		if($mdto->getParameter(CARRIER) == null || $mdto->getParameter(CARRIER) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->writeAppLog("이통사구분 미설정 오류입니다.");
			}
			throw new ServiceException("VA02","이통사구분 미설정 오류입니다.");
		}

	}
}
?>
