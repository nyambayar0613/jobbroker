<?php
header("Content-Type:text/html; charset=euc-kr;"); 
require_once dirname(__FILE__).'./lib/nicepay/web/NicePayWEB.php';
require_once dirname(__FILE__).'./lib/nicepay/core/Constants.php';
require_once dirname(__FILE__).'./lib/nicepay/web/NicePayHttpServletRequestWrapper.php';

/*
*******************************************************
* <취소 결과 설정>
* 사용전 결과 옵션을 사용자 환경에 맞도록 변경하세요.
* 로그 디렉토리는 꼭 변경하세요.
*******************************************************
*/
$httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
$_REQUEST = $httpRequestWrapper->getHttpRequestMap();
$nicepayWEB = new NicePayWEB();

$nicepayWEB->setParam("NICEPAY_LOG_HOME","c:\log");             // 로그 디렉토리 설정
$nicepayWEB->setParam("APP_LOG","1");                           // 이벤트로그 모드 설정(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EVENT_LOG","1");                         // 어플리케이션로그 모드 설정(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EncFlag","S");                           // 암호화플래그 설정(N: 평문, S:암호화)
$nicepayWEB->setParam("SERVICE_MODE", "CL0");                   // 서비스모드 설정(결제 서비스 : PY0 , 취소 서비스 : CL0)

/*
*******************************************************
* <취소 결과 필드>
*******************************************************
*/
$responseDTO = $nicepayWEB->doService($_REQUEST);
$resultCode  = $responseDTO->getParameter("ResultCode");        // 결과코드 (취소성공: 2001, 취소성공(LGU 계좌이체):2211)
$resultMsg   = $responseDTO->getParameter("ResultMsg");         // 결과메시지
$cancelAmt   = $responseDTO->getParameter("CancelAmt");         // 취소금액
$cancelDate  = $responseDTO->getParameter("CancelDate");        // 취소일
$cancelTime  = $responseDTO->getParameter("CancelTime");        // 취소시간
$cancelNum   = $responseDTO->getParameter("CancelNum");         // 취소번호
$payMethod   = $responseDTO->getParameter("PayMethod");         // 취소 결제수단
$mid         = $responseDTO->getParameter("MID");               // 상점 ID
$tid         = $responseDTO->getParameter("TID");               // 거래아이디 TID
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
              <th><span>거래 아이디</span></th>
              <td><?=$tid?></td>
            </tr>
            <tr>
              <th><span>결제 수단</span></th>
              <td><?=$payMethod?></td>
            </tr>         
            <tr>
              <th><span>결과 내용</span></th>
              <td>[<?=$resultCode?>]<?=$resultMsg?></td>
            </tr>
            <tr>
              <th><span>취소 금액</span></th>
              <td><?=$cancelAmt?></td>
            </tr>
            <tr>
              <th><span>취소일</span></th>
              <td><?=$cancelDate?></td>
            </tr>
            <tr>
              <th><span>취소시간</span></th>
              <td><?=$cancelTime?></td>
            </tr>
          </table>
        </div>
      </div>
      <p>* 취소가 성공한 경우에는 다시 승인상태로 복구 할 수 없습니다.</p>
    </div>
  </div>
</body>
</html>