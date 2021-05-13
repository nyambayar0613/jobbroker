<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 * 
 * @author kblee
 *
 */
class CommonMessageValidator implements BodyMessageValidator{
	
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
	
		// 암호화 플래그 설정 체크
		if($mdto->getParameter(ENC_FLAG) == null || $mdto->getParameter(ENC_FLAG) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("암호화 플래그가 설정되지 않았습니다. N 또는 S로 설정되어야 합니다.");
			}
			throw new ServiceException("V101","암호화 플래그 미설정 오류입니다.");
		}
		
		// 서비스구분체크
		if($mdto->getParameter(SERVICE_MODE) == null || $mdto->getParameter(SERVICE_MODE) == ""){
			if(LogMode::isAppLogable()){
				$logJournal = NicePayLogJournal::getInstance();
				$logJournal->errorAppLog("서비스모드가 설정되지 않았습니다.");
			}
			throw new ServiceException("V102","서비스모드를 설정하지 않았습니다.");
		}
		
		// 서비스구분에 따른 지불수단 체크
		if(PAY_SERVICE_CODE == $mdto->getParameter(SERVICE_MODE)){
			if($mdto->getParameter(PAY_METHOD) == null || $mdto->getParameter(PAY_METHOD) == ""){
				if(LogMode::isAppLogable()){
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->errorAppLog("지불수단이 설정되지 않았습니다. 결제승인 서비스일 경우 BANK, CARD, VBANK, CELLPHONE 이 중 하나를 설정해야 합니다.");
				}
				throw new ServiceException("V103","지불수단을 설정하지 않았습니다.");
			}
		}
	}
}

?>
