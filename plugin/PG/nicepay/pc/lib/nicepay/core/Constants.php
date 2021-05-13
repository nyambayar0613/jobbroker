<?php

define("TX_VERSION","1.1.1");
define("TX_VERSION_RELEASED_DATE","20180219");
define("TX_VERSION_FINAL_WRITER","naun_cjlee");

define("NICEPAY_DOMAIN_NAME","connect.nicepay.co.kr");
define("NICEPAY_FRONT_L4_IP","121.133.126.1");
define("NICEPAY_DEV_FRONT_L4_IP","121.133.126.13");
define("NICEPAY_PG1_DOMAIN_NAME", "172.20.141.11");
define("NICEPAY_PG2_DOMAIN_NAME", "172.20.141.12");
define("NICEPAY_SANGIL_DOMAIN_NAME", "172.31.141.32");

define("NICEPAY_ADAPTOR_LISTEN_PORT",9001);
define("PAY_METHOD","PayMethod");	
define("CARD_PAY_METHOD","CARD");	
define("BANK_PAY_METHOD","BANK");	
define("VBANK_PAY_METHOD","VBANK");	
define("CELLPHONE_PAY_METHOD","CELLPHONE");	
define("CPBILL_PAY_METHOD","CPBILL");
define("CASHRCPT_PAY_METHOD","CASHRCPT");
define("VBANK_BULK_PAY_METHOD","VBANK_BULK");
define("TENPAY_PAY_METHOD", "TENPAY"); // 위쳇페이=텐페이
define("GIFT_SSG_PAY_METHOD", "GIFT_SSG"); // SSG머니
define("QQPAY_PAY_METHOD", "TENPAY"); // QQ페이=텐페이
define("ALIPAY_PAY_METHOD", "ALIPAY"); // 신세계
define("BANK_SSG_PAY_METHOD","SSG_BANK");
	
define("ESCROW_DELIVERY_REGISTER","DELVREG");
define("ESCROW_BUY_DECISION","BUYDECN");
define("ESCROW_BUY_REJECT","BUYREJT");	

define("SERVICE_MODE","SERVICE_MODE");	
define("PAY_SERVICE_CODE","PY0");	
define("CANCEL_SERVICE_CODE","CL0");	
define("CELLPHONE_REG_ITEM","CP0");	
define("CELLPHONE_SELF_DLVER","CP1");	
define("CELLPHONE_SMS_DLVER","CP2");	
define("CELLPHONE_ITEM_CONFM","CP4");	
define("ESCROW_SERVICE_CODE","EW0");

define("VERSION","Version");
define("ENC_FLAG","EncFlag");

define("GOODS_CNT","GoodsCnt");
define("GOODS_NAME","GoodsName");
define("GOODS_AMT","Amt");
define("MOID","Moid");
define("CURRENCY","Currency");
define("MID","MID");	
define("MERCHANT_KEY","LicenseKey");
define("MALL_IP","MallIP");
define("USER_IP","UserIP");
define("RETURN_URL","ReturnURL");	
define("MALL_USER_ID","MallUserID");	
define("BUYER_NAME","BuyerName");	
define("BUYER_AUTH_NO","BuyerAuthNum");	
define("BUYER_TEL","BuyerTel");	
define("BUYER_EMAIL","BuyerEmail");	
define("PARENT_EMAIL","ParentEmail");	
define("BUYER_ADDRESS","BuyerAddr");	
define("BUYER_POST_NO","BuyerPostNo");	
define("REQUEST_PG_IP", "requestPgIp");
define("REQUEST_PG_PORT", "requestPgPort");

define("CARD_TYPE","CardType");	
define("CARD_CODE","CardCode");	
define("CARD_NO","CardNum");

define("CARD_AUTH_FLAG","AuthFlag");	
define("CARD_KEYIN_CL","KeyInCl");
define("CARD_AUTH_TYPE","AuthType");

define("CARD_QUOTA","CardQuota");	
define("CARD_INTEREST","CardInterest");	
define("CARD_EXPIRE","CardExpire");	
define("CARD_PWD","CardPwd");	
define("CARD_POINT","CardPoint");	
define("CARD_XID","CardXID");	
define("CARD_ECI","CardECI");	
define("CARD_CAVV","CardCAVV");	
define("CARD_JOIN_CODE","JoinCode");
define("ISP_PGID","ISPPGID");	
define("ISP_CODE","ISPCode");	
define("ISP_SESSION_KEY","ISPSessionKey");	
define("ISP_ENC_DATA","ISPEncData");	
define("BANK_CODE","BankCode");	
define("BANK_ENC_DATA","BankEncData");	
define("VBANK_EXPIRE_DATE","VbankExpDate");	
define("VBANK_EXPIRE_TIME","VbankExpTime");	
define("RECEIPT_AMT","ReceiptAmt");	
define("RECEIPT_TYPE","ReceiptType");	
define("RECEIPT_TYPE_NO","ReceiptTypeNo");	


define("CANCEL_AMT","CancelAmt");	
define("CANCEL_MSG","CancelMsg");	
define("CANCEL_PWD","CancelPwd");	
define("CANCEL_IP","CancelIP");	
define("SECURE_PARAMS","SECURE_PARAMS");	
define("PERSONAL_CARD_TYPE","01");	
define("BUSINESS_CARD_TYPE","02");	
define("CREDIT_CARD","0");	
define("CHECK_CARD","1");	
define("EACH_BY_CARD_SERVICE","0");	 // 신용카드 종류에 따라 인증 (X안심, ILK, ISP)
define("KEYIN","1");	             // 카드번호+유효기간 (비인증)
define("KEYIN_AUTH","2");	         // 카드번호+유효기간+비밀번호+주민번호

define("CARD_AUTH_TYPE_KEYIN","01");
define("CARD_AUTH_TYPE_ISP","02");
define("CARD_AUTH_TYPE_VISA3D","03");

// TR_KEY 추가
define("TR_KEY", "TrKey");


/* 전문템플릿 */	
define("NPG01FCD01","NPG01FCD01");
define("NPG01FBK01","NPG01FBK01");
define("NPG01FBK02","NPG01FBK02");
define("NPG01FVB01","NPG01FVB01");
define("NPG01FVK01","NPG01FVK01");
define("NPG01FVK02","NPG01FVK02");
define("NPG01FCP01","NPG01FCP01");
define("NPG01FCP02","NPG01FCP02");
define("NPG01FCB01","NPG01FCB01");
define("NPG01FCD02","NPG01FCD02");
define("NPG01FVB02","NPG01FVB02");

define("NPG01MALL1","NPG01MALL1");	
define("NPG01PGM01","NPG01PGM01");	
define("NPG01IPGC1","NPG01IPGC1");	
define("NPG01IPGC2","NPG01IPGC2");	
define("NPG01FCB02","NPG01FCB02");

define("NPG01FER01","NPG01FER01");
define("NPG01FER02","NPG01FER02");
define("NPG01FED01","NPG01FED01");
define("NPG01FED02","NPG01FED02");
define("NPG01FEF01","NPG01FEF01");
define("NPG01FEF02","NPG01FEF02");

define("NPG01CPR01","NPG01CPR01");	
define("NPG01CPR02","NPG01CPR02");	
define("NPG01CPD01","NPG01CPD01");	
define("NPG01CPD02","NPG01CPD02");	
define("NPG01CPE01","NPG01CPE01");	
define("NPG01CPE02","NPG01CPE02");	
define("NPG01CPF01","NPG01CPF01");	
define("NPG01CPF02","NPG01CPF02");	

define("NPG01FCH01","NPG01FCH01");	
define("NPG01FCH02","NPG01FCH02");	
define("NPG01FSB01","NPG01FSB01");	
define("NPG01FSB02","NPG01FSB02");	


/* 전문 공통부 필드명 */
define("ID","ID");
define("EDIT_DATE","EdiDate");
define("LENGTH","Length");
define("TID","TID");
define("ERROR_SYSTEM","ErrorSys");
define("ERROR_CODE","ErrorCD");
define("ERROR_MSG","ErrorMsg");
define("LENGTH_START_POS",24);
define("LENGTH_END_POS",30);
define("LENGTH_MSG_SIZE",6);
define("ENCRYPT_DATA","EncryptData");

define("ETC_ERROR_MESSAGE","기타오류가 발생하였습니다.");


define("SOCKET_SO_TIMEOUT",120000);
define("CONNECT_TIMEOUT",1000);
define("EVENT_LOG","EVENT_LOG");
define("APP_LOG","APP_LOG");
define("NICEPAY_LOG_HOME","NICEPAY_LOG_HOME");
define("LOG_DIRECTORY_CONF_NAME","");
define("USE_DOMAIN","USE_DOMAIN");

/* 휴대폰결제 상품등록*/
define("CP_ID","CPID");
define("CP_PWD","CPPWD");
define("ITEM_TYPE","ItemType");
define("ITEM_COUNT","ItemCount");
define("ITEM_INFO","ItemInfo");
define("SERVICE","SERVICE");
define("EMAIL","Email");
define("IPADDR","IPADDR");


/* 휴대폰결제 본인인증 */
define("SERVER_INFO","ServerInfo");
define("DST_ADDR","DstAddr");
define("IDEN","Iden");
define("CARRIER","Carrier");
define("SMS_OTP","SmsOTP");
define("ENCODED_TID","EncodedTID");
define("CP_TID","CPTID");

define("GOODS_CL","GoodsCl");

/* 가상계좌 과오납 */
//define("CP_TID","CPTID");
    
    
define("VBANK_CODE","VbankBankCode");
define("EXP_DATE","VbankExpDate");
define("ACCT_NAME","VBankAccountName");
define("REFUND_ACCT","VbankRefundAccount");
define("REFUND_BANK_CODE","VbankRefundBankCode");
define("REFUND_ACCT_NAME","VbankRefundName");
define("RECEIT_SUPPLY_AMT","ReceiptSupplyAmt");
define("RECEIT_VAT","ReceiptVAT");
define("RECEIT_SERVICE_AMT","ReceiptServiceAmt");
define("RECEIT_TAXFREE_AMT","ReceiptTaxFreeAmt");    
define("RECEIT_SUB_NUM","ReceiptSubNum");
    		
define("NET_CANCEL_CODE","NetCancelCode");
        
define("SVC_CD_CARD","01"); //신용카드
define("SVC_CD_BANK","02"); //계좌이체
define("SVC_CD_VBANK","03"); //가상계좌
define("SVC_CD_RECEIPT","04"); //현금영수증
define("SVC_CD_CELLPHONE","05"); //휴대폰결제
define("SVC_CD_CPBILL","06"); //휴대폰결제
define("SVC_CD_TENPAY","20"); //텐페이=위챗페이
define("SVC_CD_GIFT_SSG","21"); //SSG머니
define("SVC_CD_QQPAY","22"); //QQ페이
define("SVC_CD_ALIPAY","23"); //알리페이
define("SVC_CD_BANK_SSG","24"); //SSG은행직불
	
define("CARD_KEYIN_CL01","01");  //카드번호+유효기간
	
define("CARD_KEYIN_CL11","11");  //카드번호+유효기간+주민번호7+비밀번호2

define("SVC_PRDT_CD_ONLINE","01"); // 온라인
define("SVC_PRDT_CD_MOBILE","02"); // 모바일
define("SVC_PRDT_CD_IPTV","03");   // IPTV

define("MALL_RESERVED","MallReserved");
define("RETRY_URL","RetryURL");

define("DELV_CORP_NAME","DeliveryCoNm");
define("INVOICE_NO","InvoiceNum");
define("REGISTER_NAME","RegisterName");

define("TRANS_TYPE","TransType");	
define("SUB_ID","SUB_ID");
define("REC_KEY","RecKey");
define("PHONE_ID","PhoneID");
define("FN_CD","FnCd");

define("PARTIAL_CANCEL_CODE","PartialCancelCode");

define("CHARSET","CHARSET");	

define("AUTH_DATE","AuthDate");

define("RESULT_CODE","ResultCode");
define("RESULT_MSG","ResultMsg");

define("USE_REQUEST_TID", "UseRequestTID"); // 가맹점 요청 TID 이용 여부
?>
