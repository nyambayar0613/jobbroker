<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class PayCommonWebParamGather implements WebParamGather{

	/**
	 * Default Constructor
	 */
	public function __construct(){
		
	}

	public $charset;

	/**
	 * 
	 * @see WebParamGather::gather()
	 */
	public function gather($request){
		$webParam = new WebMessageDTO();

		$tid = isset($request["TID"]) ? $request["TID"] : "";
		$webParam->setParameter(TID, $tid);

		$goodsCnt = isset($request["GoodsCnt"]) ? $request["GoodsCnt"] : "";
		$webParam->setParameter(GOODS_CNT, $goodsCnt);

		$goodsName = isset($request["GoodsName"]) ? $request["GoodsName"] : "";
		$buyerName = isset($request["BuyerName"]) ? $request["BuyerName"] : "";
		$buyerAddr = isset($request["BuyerAddr"]) ? $request["BuyerAddr"] : "";
		
		if($this->charset=="UTF8"){
			$webParam->setParameter(GOODS_NAME,iconv("UTF-8", "EUC-KR", $goodsName));
			$webParam->setParameter(BUYER_NAME,iconv("UTF-8", "EUC-KR", $buyerName));
			$webParam->setParameter(BUYER_ADDRESS,iconv("UTF-8", "EUC-KR", $buyerAddr));
		}else{
			$webParam->setParameter(GOODS_NAME, $goodsName);
			$webParam->setParameter(BUYER_NAME, $buyerName);
			$webParam->setParameter(BUYER_ADDRESS, $buyerAddr);
		}

		$amt = isset($request["Amt"]) ? $request["Amt"] : "0";
		$webParam->setParameter(GOODS_AMT, $amt);

		$moid = isset($request["Moid"]) ? $request["Moid"] : "";
		$webParam->setParameter(MOID, $moid);

		//$currency = isset($request["Currency"]) ? $request["Currency"] : "";
		//$webParam->setParameter(CURRENCY, $currency);

		$mid = isset($request["MID"]) ? $request["MID"] : "";
		$webParam->setParameter(MID, $mid);

		//$encodeKey = isset($request["EncodeKey"]) ? $request["EncodeKey"] : "";
		//$webParam->setParameter(MERCHANT_KEY, $encodeKey);

		$mallIp = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
		$webParam->setParameter(MALL_IP, $mallIp);

		$userIP = isset($request["UserIP"]) ? $request["UserIP"] : "";
		$webParam->setParameter(USER_IP, $userIP);

		$mallReserved = isset($request["MallReserved"]) ? $request["MallReserved"] : "";
		$webParam->setParameter(MALL_RESERVED, $mallReserved);

		$retryURL = isset($request["RetryURL"]) ? $request["RetryURL"] : "";
		$webParam->setParameter(RETRY_URL, $retryURL);

		$mallUserID = isset($request["MallUserID"]) ? $request["MallUserID"] : "";
		$webParam->setParameter(MALL_USER_ID, $mallUserID);

		$buyerAuthNum = isset($request["BuyerAuthNum"]) ? $request["BuyerAuthNum"] : "";
		$webParam->setParameter(BUYER_AUTH_NO, $buyerAuthNum);

		$buyerTel = isset($request["BuyerTel"]) ? $request["BuyerTel"] : "";
		$webParam->setParameter(BUYER_TEL, $buyerTel);

		$buyerEmail = isset($request["BuyerEmail"]) ? $request["BuyerEmail"] : "";
		$webParam->setParameter(BUYER_EMAIL, $buyerEmail);

		$parentEmail = isset($request["ParentEmail"]) ? $request["ParentEmail"] : "";
		$webParam->setParameter(PARENT_EMAIL, $parentEmail);

		$buyerPostNo = isset($request["BuyerPostNo"]) ? $request["BuyerPostNo"] : "";
		$webParam->setParameter(BUYER_POST_NO, $buyerPostNo);

		$subId = isset($request["SUB_ID"]) ? $request["SUB_ID"] : "";
		$webParam->setParameter(SUB_ID, $subId);
		
		// 파라미터로 승인 IP, 포트 직접 지정 추가
		$requestPgIp = isset($request["requestPgIp"]) ? $request["requestPgIp"] : "";
		$webParam->setParameter(REQUEST_PG_IP, $requestPgIp);

		$requestPgPort = isset($request["requestPgPort"]) ? $request["requestPgPort"] : NICEPAY_ADAPTOR_LISTEN_PORT;
		$webParam->setParameter(REQUEST_PG_PORT, $requestPgPort);

		$testFlag = isset($request["testFlag"]) ? $request["testFlag"] : "";
		$webParam->setParameter("testFlag", $testFlag);
		
		return $webParam;
	}
}
?>