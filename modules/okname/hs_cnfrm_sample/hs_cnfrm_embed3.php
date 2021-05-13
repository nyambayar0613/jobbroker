<?php
	/*
	 * OkName 본인확인서비스(임베디드)
	 * hs_cnfrm_embed3.php
	 * 최종 수정 : 2013.05.22
	 */

	/**************************************************************************
	 * okname 파라미터
	 **************************************************************************/
    $memId      = $_POST["mem_id"];				// 회원사코드
	$svcTxSeqno	= $_POST["svc_tx_seqno"];	// 원거래거래고유번호.
	$mbphnNo	= $_POST["mbphn_no"];		// 휴대폰번호
	$smsCertNo  = $_POST["sms_cert_no"];	// SMS인증번호

	// ########################################################################
	// # 운영전환시 확인 필요
	// ########################################################################
	$serverIp = "x";									// 회원사 서버 IP
	//$endPointURL = "http://tsafe.ok-name.co.kr:29080/KcbWebService/OkNameService";	// 테스트 서버
	$endPointURL = "http://safe.ok-name.co.kr/KcbWebService/OkNameService"; // 운영 서버 
	
    //okname 실행 정보
	// ########################################################################
	// # 모듈 경로 지정 및 권한 부여 (절대경로)
	// ########################################################################
	$exe = "c:\\okname\\win32\\okname.exe";				// okname 실행 정보

	// ########################################################################
	// # 로그 경로 지정 및 권한 부여 (절대경로)
	// # 옵션값에 'L'을 추가하는 경우에만 로그가 생성됨.
	// ########################################################################
	$logPath = "c:\\okname\\";
	$options = "ML";


	$cmd = "$exe $svcTxSeqno $mbphnNo $smsCertNo $memId $serverIp $endPointURL $logPath $options";
	
	echo $cmd."<br>";
	
	/**************************************************************************
	okname 실행
	**************************************************************************/
	
	//cmd 실행
	exec($cmd, $out, $ret);
	echo "ret=".$ret."<br>";
	
	/**************************************************************************
	okname 응답 정보
	**************************************************************************/
	$retcode = "";										// 결과코드
	
	if ($ret == 0) {//성공일 경우 변수를 결과에서 얻음
		$retcode = $out[0];
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}
?>
<html>
<head>
<title>KCB 본인확인서비스(임베디드)</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<script>
<!--
	function jsSmsReSend(){	
		var form1 = document.smsReSendForm;
		form1.submit();
	}

	function jsCertNoConfirm(){	
		var form1 = document.certNoConfirmForm;
		form1.submit();
	}
//-->
</script></head>
<body>
<b>처리 결과</b>
	<table>
		<tr>
			<td>프로세스 리턴값</td>
			<td><?=$ret?></td>
		</tr>
		<tr>
			<td>결과코드</td>
			<td><?=$retcode?></td>
		</tr>
		<tr>
			<td>결과메세지</td>
			<td><?=$out[1]?></td>
		</tr>
		<tr>
			<td>회원사코드</td>
			<td><?=$out[2]?></td>
		</tr>
		<tr>
			<td>거래일련번호</td>
			<td><?=$out[3]?></td>
		</tr>
		<tr>
			<td>DI</td>
			<td><?=$out[4]?></td>
		</tr>
		<tr>
			<td>CI</td>
			<td><?=$out[5]?></td>
		</tr>
	</table>

<?
 	if ($retcode <> "B000") {
?>
	<form name="smsReSendForm" action="hs_cnfrm_embed2.php" method="post">
		<input type="hidden" name="mem_id" value="<?=$memId?>"/>
		<input type="hidden" name="svc_tx_seqno" value="<?=$svcTxSeqno?>"/>
		<input type="hidden" name="mbphn_no" value="<?=$mbphnNo?>"/>
		<input type="hidden" name="sms_re_snd_yn" value="Y"/>
		<input type="button" name="reSnd" value="SMS 재전송 요청" onclick="jsSmsReSend();"/>
	</form>

	<form name="certNoConfirmForm" action="hs_cnfrm_embed3.php" method="post">
		SMS인증번호 : <input type="text" name="sms_cert_no" value=""/>
		<input type="hidden" name="mem_id" value="<?=$memId?>"/>
		<input type="hidden" name="svc_tx_seqno" value="<?=$svcTxSeqno?>"/>
		<input type="hidden" name="mbphn_no" value="<?=$mbphnNo?>"/>
		<input type="button" name="confirm" value="인증번호 확인 요청" onclick="jsCertNoConfirm();"/>
	</form>
<?
	}
?>
<input type="button" name="restart" value="처음부터" onclick="javascript:document.location.href='hs_cnfrm_embed1.php';"/>

</body>
</html>
