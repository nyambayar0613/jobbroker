<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class VBankBulkWebParamGather implements WebParamGather{
	
	/**
	 * Default Constructor
	 */
	public function __construct(){
		
	}
	
	/**
	 * 
	 * @see WebParamGather::gather()
	 */
	public function gather($request) {
		$webParam = new WebMessageDTO();

		$vbankBankCode = isset($request["VbankBankCode"]) ? $request["VbankBankCode"] : "";
		$webParam->setParameter(VBANK_CODE, $vbankBankCode);

		$vbankNum = isset($request["VbankNum"]) ? $request["VbankNum"] : "";
		$webParam->setParameter("VbankNum", $vbankNum);

		$vBankAccountName = isset($request["VBankAccountName"]) ? $request["VBankAccountName"] : "";
		$webParam->setParameter(ACCT_NAME, $vBankAccountName);

		$vbankExpDate = isset($request["VbankExpDate"]) ? $request["VbankExpDate"] : "";
		$webParam->setParameter(EXP_DATE, $vbankExpDate);

		$vbankExpTime = isset($request["VbankExpTime"]) ? $request["VbankExpTime"] : "";
		$webParam->setParameter("VbankExpTime", $vbankExpTime);
		
		$transType = isset($request["TransType"]) ? $request["TransType"] : "0";
		$webParam->setParameter(TRANS_TYPE,$transType);
		
		$trKey = isset($request["TrKey"]) ? $request["TrKey"] : "";
		$webParam->setParameter(TR_KEY,$trKey);
		
		$CartCnt = isset($request["CartCnt"]) ? $request["CartCnt"] : "0";
		$webParam->setParameter("CartCnt",$CartCnt);

		$CartData = isset($request["CartData"]) ? $request["CartData"] : "";
		$webParam->setParameter("CartData",$CartData);
		
		return $webParam;
	}
	
}
?>
