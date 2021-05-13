<?php
header("Content-Type:text/html; charset=euc-kr;"); 
require_once dirname(__FILE__).'./lib/nicepay/web/NicePayWEB.php';
require_once dirname(__FILE__).'./lib/nicepay/core/Constants.php';
require_once dirname(__FILE__).'./lib/nicepay/web/NicePayHttpServletRequestWrapper.php';

/*
*******************************************************
* <��� ��� ����>
* ����� ��� �ɼ��� ����� ȯ�濡 �µ��� �����ϼ���.
* �α� ���丮�� �� �����ϼ���.
*******************************************************
*/
$httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
$_REQUEST = $httpRequestWrapper->getHttpRequestMap();
$nicepayWEB = new NicePayWEB();

$nicepayWEB->setParam("NICEPAY_LOG_HOME","c:\log");             // �α� ���丮 ����
$nicepayWEB->setParam("APP_LOG","1");                           // �̺�Ʈ�α� ��� ����(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EVENT_LOG","1");                         // ���ø����̼Ƿα� ��� ����(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EncFlag","S");                           // ��ȣȭ�÷��� ����(N: ��, S:��ȣȭ)
$nicepayWEB->setParam("SERVICE_MODE", "CL0");                   // ���񽺸�� ����(���� ���� : PY0 , ��� ���� : CL0)

/*
*******************************************************
* <��� ��� �ʵ�>
*******************************************************
*/
$responseDTO = $nicepayWEB->doService($_REQUEST);
$resultCode  = $responseDTO->getParameter("ResultCode");        // ����ڵ� (��Ҽ���: 2001, ��Ҽ���(LGU ������ü):2211)
$resultMsg   = $responseDTO->getParameter("ResultMsg");         // ����޽���
$cancelAmt   = $responseDTO->getParameter("CancelAmt");         // ��ұݾ�
$cancelDate  = $responseDTO->getParameter("CancelDate");        // �����
$cancelTime  = $responseDTO->getParameter("CancelTime");        // ��ҽð�
$cancelNum   = $responseDTO->getParameter("CancelNum");         // ��ҹ�ȣ
$payMethod   = $responseDTO->getParameter("PayMethod");         // ��� ��������
$mid         = $responseDTO->getParameter("MID");               // ���� ID
$tid         = $responseDTO->getParameter("TID");               // �ŷ����̵� TID
?>
<!DOCTYPE html>
<html>
<head>
<title>NICEPAY CANCEL RESULT(EUC-KR)</title>
<meta charset="euc-kr">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes, target-densitydpi=medium-dpi" />
<link rel="stylesheet" type="text/css" href="./css/import.css"/>
</head>
<body>
  <div class="payfin_area">
    <div class="top">NICEPAY CANCEL RESULT(EUC-KR)</div>
    <div class="conwrap">
      <div class="con">
        <div class="tabletypea">
          <table>
            <tr>
              <th><span>�ŷ� ���̵�</span></th>
              <td><?=$tid?></td>
            </tr>
            <tr>
              <th><span>���� ����</span></th>
              <td><?=$payMethod?></td>
            </tr>         
            <tr>
              <th><span>��� ����</span></th>
              <td>[<?=$resultCode?>]<?=$resultMsg?></td>
            </tr>
            <tr>
              <th><span>��� �ݾ�</span></th>
              <td><?=$cancelAmt?></td>
            </tr>
            <tr>
              <th><span>�����</span></th>
              <td><?=$cancelDate?></td>
            </tr>
            <tr>
              <th><span>��ҽð�</span></th>
              <td><?=$cancelTime?></td>
            </tr>
          </table>
        </div>
      </div>
      <p>* ��Ұ� ������ ��쿡�� �ٽ� ���λ��·� ���� �� �� �����ϴ�.</p>
    </div>
  </div>
</body>
</html>