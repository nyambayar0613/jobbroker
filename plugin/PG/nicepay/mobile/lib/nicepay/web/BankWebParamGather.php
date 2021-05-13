<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class BankWebParamGather implements WebParamGather{

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

		$receitType = isset($request["CashReceiptType"]) ? $request["CashReceiptType"] : "";
		$hd_pi = isset($request["hd_pi"]) ? $request["hd_pi"] : "";
		$bankCode = isset($request["BankCode"]) ? $request["BankCode"] : "";
		$receitTypeNo = isset($request["ReceiptTypeNo"]) ? $request["ReceiptTypeNo"] : "";
		
		$webParam->setParameter(RECEIPT_TYPE,$receitType);
		$webParam->setParameter(RECEIPT_TYPE_NO,$receitTypeNo);
		$webParam->setParameter(BANK_ENC_DATA, $hd_pi);
		$webParam->setParameter(BANK_CODE, $bankCode);
		
		$transType = isset($request["TransType"]) ? $request["TransType"] : "0";
		$webParam->setParameter(TRANS_TYPE,$transType);
		
		$trKey = isset($request["TrKey"]) ? $request["TrKey"] : "0";
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
