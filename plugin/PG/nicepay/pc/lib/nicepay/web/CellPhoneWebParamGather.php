<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class CellPhoneWebParamGather implements WebParamGather{
	
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
		
		$serverInfo = isset($request["ServerInfo"]) ? $request["ServerInfo"] : "";
		$webParam->setParameter(SERVER_INFO,$serverInfo);
		
		$carrier = isset($request["Carrier"]) ? $request["Carrier"] : "";
		$webParam->setParameter(CARRIER,$carrier);

		$smsOTP = isset($request["OTP"]) ? $request["OTP"] : "";
		$webParam->setParameter(SMS_OTP,$smsOTP);
		
		$cpTID = isset($request["CPID"]) ? $request["CPID"] : "";
		$webParam->setParameter(CP_TID,$cpTID);
		
		$dstAddr = isset($request["DstAddr"]) ? $request["DstAddr"] : "";
		$webParam->setParameter(DST_ADDR,$dstAddr);
		
		$encodeTID = isset($request["EncodeTID"]) ? $request["EncodeTID"] : "";
		$webParam->setParameter(ENCODED_TID,$encodeTID);

		$iden = isset($request["Iden"]) ? $request["Iden"] : "";
		$webParam->setParameter(IDEN,$iden);
		
		$recKey = isset($request["RecKey"]) ? $request["RecKey"] : "";
		$webParam->setParameter(REC_KEY,$recKey);
		
		$phoneID = isset($request["PhoneID"]) ? $request["PhoneID"] : "";
		$webParam->setParameter(PHONE_ID,$phoneID);
		
		$fnCd = isset($request["FnCd"]) ? $request["FnCd"] : "";
		$webParam->setParameter(FN_CD,$fnCd);
		
		$goodsCl = isset($request["GoodsCl"]) ? $request["GoodsCl"] : "";
		$webParam->setParameter(GOODS_CL,$goodsCl);

		$trKey = isset($request["TrKey"]) ? $request["TrKey"] : "";
		$webParam->setParameter(TR_KEY,$trKey);
		
		$ServiceAmt = isset($request["ServiceAmt"]) ? $request["ServiceAmt"] : "0";
		$webParam->setParameter("ServiceAmt",$ServiceAmt);

		$GoodsVat = isset($request["GoodsVat"]) ? $request["GoodsVat"] : "0";
		$webParam->setParameter("GoodsVat",$GoodsVat);

		$SupplyAmt = isset($request["SupplyAmt"]) ? $request["SupplyAmt"] : "0";
		$webParam->setParameter("SupplyAmt",$SupplyAmt);

		$TaxFreeAmt = isset($request["TaxFreeAmt"]) ? $request["TaxFreeAmt"] : "0";
		$webParam->setParameter("TaxFreeAmt",$TaxFreeAmt);
		
		return $webParam;
	}
	
}
?>
