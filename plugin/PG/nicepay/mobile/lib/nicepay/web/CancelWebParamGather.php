<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class CancelWebParamGather implements WebParamGather {
	
	/**
	 * Default Constructor
	 */
	public function __construct(){
		
	}

	/**
	 * 
	 * @see WebParamGather::gather()
	 */
	public function gather($request){
		
		$webParam = new WebMessageDTO();
		
		$tid = isset($request["TID"]) ? $request["TID"] : "";
		
		$svcCd = "";
		
		if(strlen($tid)>=30){
			$svcCd = substr($tid,10, 2);
		}
		$payMethod = "";
		if(SVC_CD_CARD == $svcCd){
			$payMethod = CARD_PAY_METHOD;
		}else if(SVC_CD_BANK == $svcCd){
			$payMethod = BANK_PAY_METHOD;
		}else if(SVC_CD_CELLPHONE == $svcCd){
			$payMethod = CELLPHONE_PAY_METHOD;
		}else if(SVC_CD_RECEIPT == $svcCd){
			$payMethod = CASHRCPT_PAY_METHOD;
		}else if(SVC_CD_VBANK == $svcCd){
			$payMethod = VBANK_PAY_METHOD;
		}else if(SVC_CD_TENPAY == $svcCd){
			// 텐페이-위챗페이
			$payMethod = TENPAY_PAY_METHOD;
		}else if(SVC_CD_GIFT_SSG == $svcCd){
			// SSG머니
			$payMethod = GIFT_SSG_PAY_METHOD;
		}else if(SVC_CD_QQPAY == $svcCd){
			// 텐페이-QQ페이
			$payMethod = QQPAY_PAY_METHOD;
		}else if(SVC_CD_ALIPAY == $svcCd){
			// 알리페이
			$payMethod = ALIPAY_PAY_METHOD;
		}else if(SVC_CD_BANK_SSG == $svcCd){
			// SSG은행직불
			$payMethod = BANK_SSG_PAY_METHOD;
		}

		$webParam->setParameter(PAY_METHOD, $payMethod);
		
		$cancelAmt = isset($request["CancelAmt"]) ? $request["CancelAmt"] : "";
		$webParam->setParameter(CANCEL_AMT, $cancelAmt);
		
		$cancelPwd = isset($request["CancelPwd"]) ? $request["CancelPwd"] : "";
		$webParam->setParameter(CANCEL_PWD, $cancelPwd);
		
		$cancelMsg = isset($request["CancelMsg"]) ? $request["CancelMsg"] : "";
		$webParam->setParameter(CANCEL_MSG, $cancelMsg);
		
		$cancelIP = isset($request["CancelIP"]) ? $request["CancelIP"] : "";
		$webParam->setParameter(CANCEL_IP, $cancelIP);
		
		$partialCancelCode = isset($request["PartialCancelCode"]) ? $request["PartialCancelCode"] : "";
		$webParam->setParameter(PARTIAL_CANCEL_CODE, $partialCancelCode);

		$ServiceAmt = isset($request["ServiceAmt"]) ? $request["ServiceAmt"] : "0";
		$webParam->setParameter("ServiceAmt",$ServiceAmt);
		
		$GoodsVat = isset($request["GoodsVat"]) ? $request["GoodsVat"] : "0";
		$webParam->setParameter("GoodsVat",$GoodsVat);
		
		$SupplyAmt = isset($request["SupplyAmt"]) ? $request["SupplyAmt"] : "0";
		$webParam->setParameter("SupplyAmt",$SupplyAmt);
		
		$TaxFreeAmt = isset($request["TaxFreeAmt"]) ? $request["TaxFreeAmt"] : "0";
		$webParam->setParameter("TaxFreeAmt",$TaxFreeAmt);
		
		$CcPartRemainAmt = isset($request["CcPartRemainAmt"]) ? $request["CcPartRemainAmt"] : "";
		$webParam->setParameter("CcPartRemainAmt",$CcPartRemainAmt);

		$TransCl = isset($request["TransCl"]) ? $request["TransCl"] : "";
		$webParam->setParameter("TransCl",$TransCl);

		$TrKey = isset($request["TrKey"]) ? $request["TrKey"] : "";
		$webParam->setParameter("TrKey",$TrKey);

		return $webParam;
	}
	
}
?>
