<?php
require_once dirname(__FILE__).'/BodyMessageValidator.php';
require_once dirname(__FILE__).'/../exception/ServiceException.php';
require_once dirname(__FILE__).'/../log/LogMode.php';

/**
 *
 * @author kblee
 *
 */
class CardBodyMessageValidator implements BodyMessageValidator{

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
	  		// 카드형태(개인, 법인, 해외)
	  		if($mdto->getParameter(CARD_TYPE) == null || $mdto->getParameter(CARD_TYPE) == ""){
	  			if(LogMode::isAppLogable()){
	  				$logJournal = NicePayLogJournal::getInstance();
	  				$logJournal->errorAppLog("카드형태 미설정 오류입니다.");
	  			}
	  			throw new ServiceException("V501","카드형태 미설정 오류입니다.");
	  		}
	  
	  		// 카드코드
	  		if($mdto->getParameter(CARD_CODE) == null || $mdto->getParameter(CARD_CODE) == ""){
	  			if(LogMode::isAppLogable()){
	  				$logJournal = NicePayLogJournal::getInstance();
	  				$logJournal->errorAppLog("카드코드 미설정 오류입니다.");
	  			}
	  			throw new ServiceException("V503","카드코드 미설정 오류입니다.");
	  		}
	  
	  		// 무이자여부
	  		if($mdto->getParameter(CARD_INTEREST) == null || $mdto->getParameter(CARD_INTEREST) == ""){
	  			if(LogMode::isAppLogable()){
	  				$logJournal = NicePayLogJournal::getInstance();
	  				$logJournal->errorAppLog("카드 무이자여부 미설정 오류입니다.");
	  			}
	  			throw new ServiceException("V505","카드 무이자여부 미설정 오류입니다.");
	  		}
	  
	  		// 카드형태 값 체
	  		if((PERSONAL_CARD_TYPE != $mdto->getParameter(CARD_TYPE)) &&
	  		(BUSINESS_CARD_TYPE != $mdto->getParameter(CARD_TYPE))){
	  				
	  			if(LogMode::isAppLogable()){
	  				$logJournal = NicePayLogJournal::getInstance();
	  				$logJournal->errorAppLog("카드형태 설정 오류입니다. 개인(0), 기업(1), 해외(2) 카드형태만  설정 가능합니다. 현 설정값 :".$mdto->getParameter(CARD_TYPE));
	  			}
	  				
	  			throw new ServiceException("V508","카드형태 허용하지 않는 값을 설정하였습니다.");
	  		}
	  
	  		// KeyIn인증일 경우
	  		if(CARD_AUTH_TYPE_KEYIN == $mdto->getParameter(CARD_AUTH_FLAG)){
	  			// 카드번호+유효기간
	  			if( (CARD_KEYIN_CL01 == $mdto->getParameter(CARD_KEYIN_CL)) || (CARD_KEYIN_CL11 == $mdto->getParameter(Constants.CARD_KEYIN_CL))) {
	  				// 유효기간
	  				if($mdto->getParameter(CARD_EXPIRE) == null || $mdto->getParameter(CARD_EXPIRE) == ""){
	  					if(LogMode::isAppLogable()){
	  						$logJournal = NicePayLogJournal::getInstance();
	  						$logJournal->errorAppLog("유효기간 미설정 오류입니다.");
	  					}
	  					throw new ServiceException("V510","유효기간 미설정 오류입니다.");
	  				}
	  
	  				//유효기간 자리수 체크
	  				$expireYYMM = $mdto->getParameter(CARD_EXPIRE);
	  				if(strlen($expireYYMM) != 4){
	  					if(LogMode::isAppLogable()){
	  						$logJournal = NicePayLogJournal::getInstance();
	  						$logJournal->errorAppLog("유효기간은  4자리여야 합니다.");
	  					}
	  					throw new ServiceException("V511","유효기간 허용하지 않는 값을 설정하였습니다.");
	  				}
	  				// 유효기간 범위 체크
	  				$expireMonth =  (int) substr($expireYYMM,2,2);
	  				if($expireMonth <0 || $expireMonth > 12){
	  					if(LogMode::isAppLogable()){
	  						$logJournal = NicePayLogJournal::getInstance();
	  						$logJournal->errorAppLog("유효기간의 월 형태가 잘못 설정되었습니다. 1월에서 12월사이 입력 가능합니다. 현 입력값 :".$expireMonth);
	  					}
	  					throw new ServiceException("V512","유효기간의 월 형태가 잘못 설정되었습니다.");
	  				}
	  			}
	  				
	  			if(CARD_KEYIN_CL11 == $mdto->getParameter(CARD_KEYIN_CL)){
	  				// 비밀번호 체크
	  				if($mdto->getParameter(CARD_PWD) == null || $mdto->getParameter(CARD_PWD) == ""){
	  					if(LogMode::isAppLogable()){
	  						$logJournal = NicePayLogJournal::getInstance();
	  						$logJournal->errorAppLog("카드 비밀번호가 입력되지 않았습니다. 본인인증시 비밀번호가 필요합니다.");
	  					}
	  					throw new ServiceException("V513","카드 비밀번호 미입력 오류입니다.");
	  				}
	  			}
	  		}

	    } else {
		
		
		
		}
		
	}

}
?>
