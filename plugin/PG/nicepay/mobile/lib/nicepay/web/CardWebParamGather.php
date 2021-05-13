<?php
require_once dirname(__FILE__).'/WebParamGather.php';

/**
 * 
 * @author kblee
 *
 */
class CardWebParamGather implements WebParamGather{
	
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
		
		//card code
		$cardCode = isset($request["FormBankCd"]) ? $request["FormBankCd"] : "";
		$webParam->setParameter(CARD_CODE,$cardCode);
		
		//card pwd
		$cardPwd = isset($request["CardPwd"]) ? $request["CardPwd"] : "";
		$webParam->setParameter(CARD_PWD, $cardPwd);
		
		// card no
		$cardNo = isset($request["CardNo"]) ? $request["CardNo"] : "";
		$webParam->setParameter(CARD_NO, $cardNo);
		
		// cardexpire
		$cardExpire =isset($request["CardExpire"]) ? $request["CardExpire"] : "";
		$webParam->setParameter(CARD_EXPIRE,$cardExpire);
		
		$cardPoint = isset($request["CardPoint"]) ? $request["CardPoint"] : "";
		$webParam->setParameter(CARD_POINT,$cardPoint);
		
		// card interest
		$cardInterest = isset($request["CardInterest"]) ? $request["CardInterest"] : "";
		$webParam->setParameter(CARD_INTEREST, $cardInterest);
		// card quota
		$cardQuota = isset($request["CardQuota"]) ? $request["CardQuota"] : "";
		$webParam->setParameter(CARD_QUOTA, $cardQuota);
		
		//AUTH_FLAG
		$authFlag = isset($request["AuthFlg"]) ? $request["AuthFlg"] : "";
		$webParam->setParameter(CARD_AUTH_FLAG, $authFlag);

		//AUTH_TYPE
		$authType = isset($request["AuthType"]) ? $request["AuthType"] : "";
		$webParam->setParameter(CARD_AUTH_TYPE, $authType);
		
		//KEYIN_CL
		$keyinCl = isset($request["KeyInCl"]) ? $request["KeyInCl"] : "";
		$webParam->setParameter(CARD_KEYIN_CL, $keyinCl);
		
		// CARD TYPE 설정
		$buyerAuthName = isset($request[BUYER_AUTH_NO]) ? $request[BUYER_AUTH_NO] : "";
		$cardType = "";
		if(strlen($buyerAuthName) == 10){
			$cardType = "02"; //기업
		}else{
			$cardType = "01"; //개인
		}
		$webParam->setParameter(CARD_TYPE, $cardType);
		
		
		// mpi
		/*
		$eci = isset($request["eci"]) ? $request["eci"] : "";
		$xid = $request["xid"];
		$cavv = $request["cavv"];
		$joinCode = $request["joinCode"];
		$webParam->setParameter(CARD_ECI, $eci);
		$webParam->setParameter(CARD_XID, $xid);
		$webParam->setParameter(CARD_CAVV, $cavv);
		$webParam->setParameter(CARD_JOIN_CODE,$joinCode);
		
		// isp
		$kvpPgid = $request["KVP_PGID"];
		$kvpCardCode = $request["KVP_CARDCODE"];
		$kvpSessionKeyEnc = $request["KVP_SESSIONKEY"];
		$kvpEncData = $request["KVP_ENCDATA"];
		$KVP_NOINT_INF = $request["KVP_NOINT_INF"];// 255
		$KVP_QUOTA_INF = $request["KVP_QUOTA_INF"];// 255
		  
		  
		$KVP_NOINT = $request["KVP_NOINT"];// 2
		$KVP_QUOTA = $request["KVP_QUOTA"];// 2
		  
		  
		$KVP_CARDCODE = $request["KVP_CARDCODE"]; // 20
		$KVP_CONAME = $request["KVP_CONAME"]; // 40
		
		$webParam->setParameter(ISP_PGID, $kvpPgid);
		$webParam->setParameter(ISP_CODE, $kvpCardCode);
		$webParam->setParameter(ISP_SESSION_KEY, $kvpSessionKeyEnc);
		$webParam->setParameter(ISP_ENC_DATA, $kvpEncData);
		
		$webParam->setParameter(ISP_NOINT_INF, $KVP_NOINT_INF);
		$webParam->setParameter(ISP_QUOTA_INF, $KVP_QUOTA_INF);
		
		$webParam->setParameter(ISP_NOINT,$KVP_NOINT);
		$webParam->setParameter(ISP_QUOTA, $KVP_QUOTA);
		$webParam->setParameter(ISP_CARDCODE, $KVP_CARDCODE);
		$webParam->setParameter(ISP_CONAME, $KVP_CONAME);
		*/
		
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

		$CartCnt = isset($request["CartCnt"]) ? $request["CartCnt"] : "0";
		$webParam->setParameter("CartCnt",$CartCnt);
		
		$CartData = isset($request["CartData"]) ? $request["CartData"] : "";
		$webParam->setParameter("CartData",$CartData);
		
		//ClickpayCl
		$ClickpayCl = isset($request["PayType"]) ? $request["PayType"] : "";
		$webParam->setParameter("ClickpayCl", $ClickpayCl);

		//CouponId
		$CouponId = isset($request["CouponId"]) ? $request["CouponId"] : "";
		$webParam->setParameter("CouponId", $CouponId);

		//CouponAmt
		$CouponAmt = isset($request["CouponAmt"]) ? $request["CouponAmt"] : "0";
		$webParam->setParameter("CouponAmt",$CouponAmt);
		
		//CVC
		$CVC = isset($request["CVC"]) ? $request["CVC"] : "";
		$webParam->setParameter("CVC", $CVC);

		//EscrowCustFee
		$EscrowCustFee = isset($request["EscrowCustFee"]) ? $request["EscrowCustFee"] : "";
		$webParam->setParameter("EscrowCustFee", $EscrowCustFee);
		
		//TransCl
		$TransCl = isset($request["TransCl"]) ? $request["TransCl"] : "";
		$webParam->setParameter("TransCl", $TransCl);

		return $webParam;
	}
	
}
?>
