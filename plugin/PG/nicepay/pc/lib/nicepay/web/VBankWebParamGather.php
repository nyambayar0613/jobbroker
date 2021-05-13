<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class VBankWebParamGather implements WebParamGather{
	
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
		
		$bankCode = isset($request["BankCode"]) ? $request["BankCode"] : "";
		$webParam->setParameter(VBANK_CODE,$bankCode);
		
		// accountName이 비었을 경우 구매자명으로 설정
		$vbankAccountName = isset($request["VbankAccountName"]) ? $request["VbankAccountName"] : "";
		if($vbankAccountName == null || $vbankAccountName == ""){
			$vbankAccountName = isset($request["BuyerName"]) ? $request["BuyerName"] : "";
		}
		
		$receitTypeNo = isset($request["ReceiptTypeNo"]) ? $request["ReceiptTypeNo"] : "";
		$webParam->setParameter(BUYER_AUTH_NO,$receitTypeNo);
		
		//$webParam->setParameter(ACCT_NAME,$vbankAccountName);
		
		$cashReceitType = isset($request["CashReceiptType"]) ? $request["CashReceiptType"] : "";
		$webParam->setParameter(RECEIPT_TYPE,$cashReceitType);
		
		$receiptTypeNo =  isset($request["ReceiptTypeNo"]) ? $request["ReceiptTypeNo"] : "";
		$webParam->setParameter(RECEIPT_TYPE_NO,$receiptTypeNo);
		
		$vbankExpDate = isset($request["VbankExpDate"]) ? $request["VbankExpDate"] : "";
		
		if (strlen($vbankExpDate) == 12 ){
			$vbankExpTime = substr($vbankExpDate,8,4)."59";
			$webParam->setParameter(VBANK_EXPIRE_DATE,substr($vbankExpDate,0,8));
			$webParam->setParameter(VBANK_EXPIRE_TIME,$vbankExpTime);
		}else{
			$webParam->setParameter(VBANK_EXPIRE_DATE,$vbankExpDate);
		}
		
		$transType = isset($request["TransType"]) ? $request["TransType"] : "0";
		$webParam->setParameter(TRANS_TYPE,$transType);
		
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
		
		$ReceiptAmt = isset($request["Amt"]) ? $request["Amt"] : "0";
		$webParam->setParameter("ReceiptAmt",$ReceiptAmt);
		
		$ReceiptSupplyAmt = isset($request["SupplyAmt"]) ? $request["SupplyAmt"] : "0";
		$webParam->setParameter("ReceiptSupplyAmt",$ReceiptSupplyAmt);
		
		$ReceiptVAT = isset($request["GoodsVat"]) ? $request["GoodsVat"] : "0";
		$webParam->setParameter("ReceiptVAT",$ReceiptVAT);
		
		$ReceiptServiceAmt = isset($request["ServiceAmt"]) ? $request["ServiceAmt"] : "0";
		$webParam->setParameter("ReceiptServiceAmt",$ReceiptServiceAmt);
		
		$ReceiptTaxFreeAmt = isset($request["TaxFreeAmt"]) ? $request["TaxFreeAmt"] : "0";
		$webParam->setParameter("ReceiptTaxFreeAmt",$ReceiptTaxFreeAmt);
		
		return $webParam;
	}
}
?>
