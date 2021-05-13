<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<?php
	header('Content-Type: text/html; charset=euc-kr');

	//	본인확인서비스 결과 화면
	/* 공통 리턴 항목 */
	$memId				= $_POST["mem_id"];			// 회원사코드
	$svcTxSeqno			= $_POST["svc_tx_seqno"];	// 거래번호
	$rqstCausCd			= $_POST["rqst_caus_cd"];	// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타);// 

	$resultCd			= $_POST["result_cd"];		// 결과코드
	$resultMsg			= $_POST["result_msg"];		// 결과메세지
	$certDtTm			= $_POST["cert_dt_tm"];		// 인증일시
	$di					= $_POST["di"];				// DI
	$ci					= $_POST["ci"];				// CI
	$name				= $_POST["name"];			// 성명
	$birthday			= $_POST["birthday"];		// 생년월일
	$sex				= $_POST["sex"];			// 성별
	$nation				= $_POST["nation"];			// 내외국인구분
	$telComCd			= $_POST["tel_com_cd"];		// 통신사코드
	$telNo				= $_POST["tel_no"];			// 휴대폰번호
	$returnMsg			= $_POST["return_msg"];		// 리턴메시지
?>
<title>KCB 본인확인서비스 샘플</title>
</head>
<body>
<h3>확인결과</h3>
<ul>
  <li>회원사코드	: <?=$memId?> </li>
  <li>인증사유코드	: <?=$rqstCausCd?></li>
  <li>결과코드		: <?=$resultCd?></li>
  <li>결과메세지	: <?=$resultMsg?></li>
  <li>거래번호		: <?=$svcTxSeqno?> </li>
  <li>인증일시		: <?=$certDtTm?> </li>
  <li>DI			: <?=$di?> </li>
  <li>CI			: <?=$ci?> </li>
  <li>성명			: <?=$name?> </li>
  <li>생년월일		: <?=$birthday?> </li>
  <li>성별			: <?=$sex?> </li>
  <li>내외국인구분	: <?=$nation?> </li>
  <li>통신사코드	: <?=$telComCd?> </li>
  <li>휴대폰번호	: <?=$telNo?> </li>
  <li>리턴메시지	: <?=$returnMsg?> </li>
</ul>

<br/>
* 성별 - 1:남, 0:여
<br/>
* 내외국인구분 - 1:내국인, 2:외국인
<br/>
* 통신사 - 01:SKT, 02:KT, 03:LGU+, 04:SKT알뜰폰, 05:KT알뜰폰, 06:LGU+알뜰폰
</body>
</html>
