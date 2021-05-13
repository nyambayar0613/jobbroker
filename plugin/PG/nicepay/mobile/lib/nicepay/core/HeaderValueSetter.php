<?php
require_once dirname(__FILE__).'/../util/KeyUtils.php';
require_once dirname(__FILE__).'/Constants.php';
/**
 * 
 * @author kblee
 *
 */
class HeaderValueSetter {
	
	/**
	 * 
	 */
	function __construct(){
		
	}
	
	/**
	 * 
	 * @param  $paramSet
	 */
	public function fillValue($paramSet){
		
		
		// 전문생성일시
		$paramSet->setParameter(EDIT_DATE, date("YmdHis"));
		
		// 전문길이
		$paramSet->setParameter(LENGTH, "0");
		
		// 거래ID (결제서비스일 경우만 설정, 취소서비스일 경우 JSP에서 설정)
		// [2017.09.07] 가맹점 요청 TID 사용여부 추가
		if ("1" == $paramSet->getParameter(USE_REQUEST_TID)) {
			// 가맹점 요청 TID 사용(가맹점 TID 유지)
			$logJournal = NicePayLogJournal::getInstance();
			$logJournal->writeAppLog("가맹점 요청 TID: ".$paramSet->getParameter(TID));
		} else if(PAY_SERVICE_CODE == $paramSet->getParameter(SERVICE_MODE)){
			$payMethod = $paramSet->getParameter(PAY_METHOD);
			
			// 여기 확인 필요!!!! SSG은행 직불일때도 TID새로 만들어야 하지는지 검토
			if($payMethod !== BANK_PAY_METHOD &&  $payMethod !== CELLPHONE_PAY_METHOD){
				$paramSet->setParameter(TID,$this->generateNewTid($paramSet));
				if(LogMode::isAppLogable()){
					$logJournal = NicePayLogJournal::getInstance();
					$logJournal->writeAppLog("새로운 TID 생성 : ".$paramSet->getParameter(TID));
				}
			}
		}

		/*if(LogMode::isAppLogable()){
			$logJournal = NicePayLogJournal::getInstance();
			$logJournal->writeAppLog("TID : ".$paramSet->getParameter(TID));
		}*/

		// 에러시스템명
		$paramSet->setParameter(ERROR_SYSTEM, "MALL");
		
		// 에러코드
		$paramSet->setParameter(ERROR_CODE, "00000");
		
		// 에러메시지
		$paramSet->setParameter(ERROR_MSG, "");
	
		return $paramSet;
	}
	
	
	/**
	 * 
	 * @param  $paramSet
	 */
	private function generateNewTid($paramSet){
		$mid = $paramSet->getParameter(MID);
		$payMethod = $paramSet->getParameter(PAY_METHOD);
		$svcCd = "";

		if(CARD_PAY_METHOD == $payMethod){
			$svcCd = SVC_CD_CARD;
		}else if(BANK_PAY_METHOD == $payMethod){
			$svcCd = SVC_CD_BANK;
		}else if(VBANK_PAY_METHOD == $payMethod){
			$svcCd = SVC_CD_VBANK;
		}else if(CELLPHONE_PAY_METHOD == $payMethod){
			$svcCd = SVC_CD_CELLPHONE;
		}else if(CPBILL_PAY_METHOD == $payMethod){
			$svcCd = SVC_CD_CPBILL;
		}else if(VBANK_BULK_PAY_METHOD == $payMethod){
			$svcCd = SVC_CD_VBANK;
		}else if(CASHRCPT_PAY_METHOD == $payMethod){
			$svcCd = SVC_CD_RECEIPT;
		}else if(GIFT_SSG_PAY_METHOD == $payMethod){
			// SSG머니
			$svcCd = SVC_CD_GIFT_SSG;
		}else if(BANK_SSG_PAY_METHOD == $payMethod){
			// SSG 은행직불
			$svcCd = SVC_CD_BANK_SSG;
		}else{
			throw new ServiceException("V005","지원하지 않는 지불수단입니다.");
		}
		
		
		return KeyUtils::genTID($mid, $svcCd, SVC_PRDT_CD_ONLINE);
	}
	
}
?>
