<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class CashReceiptWebParamGather implements WebParamGather{
	
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

		// 주민 번호,휴대폰 번호 식별 값
		$receiptTypeNo = isset($request["ReceiptTypeNo"]) ? $request["ReceiptTypeNo"] : "";
		$webParam->setParameter(RECEIPT_TYPE_NO,$receiptTypeNo);

		// 소득공제 구분
		$receiptType = isset($request["ReceiptType"]) ? $request["ReceiptType"] : "";
		$webParam->setParameter(RECEIPT_TYPE, $receiptType);

		// 봉사료
		$receiptServiceAmt = isset($request["ReceiptServiceAmt"]) ? $request["ReceiptServiceAmt"] : "0";
		$webParam->setParameter(RECEIT_SERVICE_AMT, $receiptServiceAmt);

		//부가가치세
		$receiptVAT = isset($request["ReceiptVAT"]) ? $request["ReceiptVAT"] : "0";
		$webParam->setParameter(RECEIT_VAT, $receiptVAT);
		
		//부가가치세
		$receiptSupplyAmt = isset($request["ReceiptSupplyAmt"]) ? $request["ReceiptSupplyAmt"] : "0";
		$webParam->setParameter(RECEIT_SUPPLY_AMT, $receiptSupplyAmt);

		//현금 영수증 요청 금액
		$receiptAmt = isset($request["ReceiptAmt"]) ? $request["ReceiptAmt"] : "0";
		$webParam->setParameter(RECEIPT_AMT, $receiptAmt);
				
		//현금 영수증 서브몰 사업자번호
		$receiptSubNum = isset($request["ReceiptSubNum"]) ? $request["ReceiptSubNum"] : "";
		$webParam->setParameter(RECEIT_SUB_NUM, $receiptSubNum);

		//현금 영수증 서브몰 사업자 상호
		$receiptSubCoNm = isset($request["ReceiptSubCoNm"]) ? $request["ReceiptSubCoNm"] : "";
		$webParam->setParameter("ReceiptSubCoNm", $receiptSubCoNm);
		
		//현금 영수증 서브몰 사업자명
		$receiptSubBossNm = isset($request["ReceiptSubBossNm"]) ? $request["ReceiptSubBossNm"] : "";
		$webParam->setParameter("ReceiptSubBossNm", $receiptSubBossNm);
		
		//현금 영수증 서브몰 사업자 전화번호
		$receiptSubTel = isset($request["ReceiptSubTel"]) ? $request["ReceiptSubTel"] : "";
		$webParam->setParameter("ReceiptSubTel", $receiptSubTel);
				
		// 면세
		$TaxFreeAmt = isset($request["ReceiptTaxFreeAmt"]) ? $request["ReceiptTaxFreeAmt"] : "0";
		$webParam->setParameter(RECEIT_TAXFREE_AMT,$TaxFreeAmt);

		return $webParam;
	}
	
}
?>
