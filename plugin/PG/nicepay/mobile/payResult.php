<?php 
$_POST['no'] = $pno;

// : �������� �ҷ�����
$pay_row = sql_fetch("select * from alice_payment where `no`='".addslashes($pno)."'");
$_post_un = unserialize(stripslashes($pay_row['post_un']));
$_pg_un = unserialize(stripslashes($pay_row['pg_un']));

// : ����üũ
$get_price = $netfu_payment->get_service_type($_post_un);

if($get_price['price_hap']!=$_POST['Amt']) {
	$arr['msg'] = "�ݾ��� ���� �ʽ��ϴ�. �ٽ� �õ����ֽñ� �ٶ��ϴ�.";
	return false;
}

require_once dirname(__FILE__).'/lib/nicepay/web/NicePayWEB.php';
require_once dirname(__FILE__).'/lib/nicepay/core/Constants.php';
require_once dirname(__FILE__).'/lib/nicepay/web/NicePayHttpServletRequestWrapper.php';

/*
*******************************************************
* <���� ���>
*******************************************************
*/
$authResultCode          = $_REQUEST['AuthResultCode'];             // ������� : 0000(����)
$authResultMsg           = $_REQUEST['AuthResultMsg'];              // ������� �޽���

if($authResultCode == '0000'){
    /*
    *******************************************************
    * <���� ��� ����>
    * ����� ��� �ɼ��� ����� ȯ�濡 �µ��� �����ϼ���.
    * �α� ���丮�� �� �����ϼ���.
    *******************************************************
    */   
    $nicepayWEB         = new NicePayWEB();
	$nicepayWEB->setParam("CHARSET", "UTF8"); 
    $httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
    $_REQUEST           = $httpRequestWrapper->getHttpRequestMap();
    $payMethod          = $_REQUEST['PayMethod'];
    $merchantKey        = $netfu_payment->use_pg['pg_key'];

    $nicepayWEB->setParam("NICEPAY_LOG_HOME",NFE_PATH."/plugin/PG/nicepay/mobile/log");             // �α� ���丮 ����
    $nicepayWEB->setParam("APP_LOG","1");                           // ���ø����̼Ƿα� ��� ����(0: DISABLE, 1: ENABLE)
    $nicepayWEB->setParam("EVENT_LOG","1");                         // �̺�Ʈ�α� ��� ����(0: DISABLE, 1: ENABLE)
    $nicepayWEB->setParam("EncFlag","S");                           // ��ȣȭ�÷��� ����(N: ��, S:��ȣȭ)
    $nicepayWEB->setParam("SERVICE_MODE", "PY0");                   // ���񽺸�� ����(���� ���� : PY0 , ��� ���� : CL0)
    $nicepayWEB->setParam("Currency", "KRW");                       // ��ȭ ����(���� KRW(��ȭ) ����)
    $nicepayWEB->setParam("PayMethod",$payMethod);                  // �������
    $nicepayWEB->setParam("LicenseKey",$merchantKey);               // ����Ű

    /*
    *******************************************************
    * <���� ��� �ʵ�>
    * �Ʒ� ���� ������ �ܿ��� ���� Header�� ������ ������ Get ����
    *******************************************************
    */
    $responseDTO    = $nicepayWEB->doService($_REQUEST);

    $resultCode     = $responseDTO->getParameter("ResultCode");     // ����ڵ� (���� ����ڵ�:3001)
    $resultMsg      = $responseDTO->getParameter("ResultMsg");      // ����޽���
    $authDate       = $responseDTO->getParameter("AuthDate");       // �����Ͻ� (YYMMDDHH24mmss)
    $authCode       = $responseDTO->getParameter("AuthCode");       // ���ι�ȣ
    $buyerName      = $responseDTO->getParameter("BuyerName");      // �����ڸ�
    $mallUserID     = $responseDTO->getParameter("MallUserID");     // ȸ�����ID
    $goodsName      = $responseDTO->getParameter("GoodsName");      // ��ǰ��
    $mallUserID     = $responseDTO->getParameter("MallUserID");     // ȸ����ID
    $mid            = $responseDTO->getParameter("MID");            // ����ID
    $tid            = $responseDTO->getParameter("TID");            // �ŷ�ID
    $moid           = $responseDTO->getParameter("Moid");           // �ֹ���ȣ
    $amt            = $responseDTO->getParameter("Amt");            // �ݾ�
    $cardQuota      = $responseDTO->getParameter("CardQuota");      // ī�� �Һΰ��� (00:�Ͻú�,02:2����)
    $cardCode       = $responseDTO->getParameter("CardCode");       // ����ī����ڵ�
    $cardName       = $responseDTO->getParameter("CardName");       // ����ī����
    $bankCode       = $responseDTO->getParameter("BankCode");       // �����ڵ�
    $bankName       = $responseDTO->getParameter("BankName");       // �����
    $rcptType       = $responseDTO->getParameter("RcptType");       // ���� ������ Ÿ�� (0:�����������,1:�ҵ����,2:��������)
    $rcptAuthCode   = $responseDTO->getParameter("RcptAuthCode");   // ���ݿ����� ���ι�ȣ
    $carrier        = $responseDTO->getParameter("Carrier");        // ����籸��
    $dstAddr        = $responseDTO->getParameter("DstAddr");        // �޴�����ȣ
    $vbankBankCode  = $responseDTO->getParameter("VbankBankCode");  // ������������ڵ�
    $vbankBankName  = $responseDTO->getParameter("VbankBankName");  // ������������
    $vbankNum       = $responseDTO->getParameter("VbankNum");       // ������¹�ȣ
    $vbankExpDate   = $responseDTO->getParameter("VbankExpDate");   // ��������Աݿ�����

    /*
    *******************************************************
    * <���� ���� ���� Ȯ��>
    *******************************************************
    */
    $paySuccess = false;
    if($payMethod == "CARD"){
        if($resultCode == "3001") $paySuccess = true;               // �ſ�ī��(���� ����ڵ�:3001)
    }else if($payMethod == "BANK"){
        if($resultCode == "4000") $paySuccess = true;               // ������ü(���� ����ڵ�:4000)
    }else if($payMethod == "CELLPHONE"){
        if($resultCode == "A000") $paySuccess = true;               // �޴���(���� ����ڵ�:A000)
    }else if($payMethod == "VBANK"){
        if($resultCode == "4100") $paySuccess = true;               // �������(���� ����ڵ�:4100)
    }else if($payMethod == "SSG_BANK"){
		if($resultCode == "0000") $paySuccess = true;               // SSG�������(���� ����ڵ�:0000)
	}

	if($paySuccess) {
		$result = $payment_control->payment_status($responseDTO);
		$_pay_result = true;
	} else {
		$update = sql_query("update alice_payment set `pg_un`='".addslashes(serialize($responseDTO))."' where `no`='".addslashes($pno)."'");
	}

}else{
    $resultCode = $authResultCode;
    $resultMsg = $authResultMsg;
}
?>