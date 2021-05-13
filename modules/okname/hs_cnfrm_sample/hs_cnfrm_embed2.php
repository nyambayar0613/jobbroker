<?php
	/*
	 * OkName 본인확인서비스(임베디드)
	 * hs_cnfrm_embed2.php
	 * 최종 수정 : 2013.05.22
	 */

	// 서비스거래번호를 생성한다.
	function generateSvcTxSeqno() {   
		$numbers  = "0123456789";   
		$svcTxSeqno = date("YmdHis");   
		$nmr_loops = 6;   
		while ($nmr_loops--) {   
			$svcTxSeqno .= $numbers[mt_rand(0, strlen($numbers))];   
		}   
		return $svcTxSeqno;   
	}   

	/**************************************************************************
	 * okname 파라미터
	 **************************************************************************/
	$name		= $_POST["name"]			== "" ? "x" : $_POST["name"];					// 성명
	$birthday	= $_POST["birthday"]		== "" ? "x" : $_POST["birthday"];				// 생년월일
	$gender		= $_POST["gender"]			== "" ? "x" : $_POST["gender"];					// 성별
	$nation		= $_POST["nation"]			== "" ? "x" : $_POST["nation"];					// 내외국인구분
	$telCmmCd	= $_POST["tel_cmm_cd"]		== "" ? "x" : $_POST["tel_cmm_cd"];				// 이동통신사코드
	$mbphnNo	= $_POST["mbphn_no"]		== "" ? "x" : $_POST["mbphn_no"];				// 휴대폰번호
	$rqstCausCd	= $_POST["rqst_caus_cd"]	== "" ? "x" : $_POST["rqst_caus_cd"];			// 인증요청사유코드 (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)
	$smsReSndYn	= $_POST["sms_re_snd_yn"]	== "" ? "N" : $_POST["sms_re_snd_yn"];			// SMS재전송여부
	$svcTxSeqno	= $_POST["svc_tx_seqno"]	== "" ? "x" : $_POST["svc_tx_seqno"];			// 거래고유번호. SMS재전송시에는 원거래고유번호로 요청해야 함.

	// 재전송 여부에 따라 거래번호를 설정
	if ("Y" != $smsReSndYn) {
		// 재전송이 아니면 거래고유번호 생성
		$svcTxSeqno = generateSvcTxSeqno();				// 거래번호. 동일문자열을 두번 사용할 수 없음. (최대 30자리의 문자열. 0-9,A-Z,a-z 사용)
	}

	// ########################################################################
	// # 운영전환시 확인 필요
	// ########################################################################
	$memId = "P00000000000";							// 회원사코드
	$serverIp = "x";									// 회원사 서버 IP
	$siteUrl = "www.test.co.kr";						// 회원사 사이트 URL
	$siteDomain = "test.co.kr";							// 회원사 도메인,  SMS인증번호문자에 표시됨.

    // 예비
    $rsv1= "0";
    $rsv2= "0";

    $rqstMsrCd= "10";									// 요청수단코드 (10:핸드폰)

	// ########################################################################
	// # 운영전환시 변경 필요
	// ########################################################################
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
	$options = "JL";


	$cmd = "$exe $svcTxSeqno \"$name\" $birthday $gender $nation $telCmmCd $mbphnNo $smsReSndYn $rsv1 $rsv2 $rqstMsrCd $rqstCausCd $memId $serverIp $siteUrl $siteDomain $endPointURL $logPath $options";
	
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
			<td>인증통신사코드</td>
			<td><?=$out[4]?></td>
		</tr>
		<tr>
			<td>인증통신사결과코드</td>
			<td><?=$out[5]?></td>
		</tr>
		<tr>
			<td>SMS재전송횟수</td>
			<td><?=$out[6]?></td>
		</tr>
	</table>

<%
 	if ($retcode == "B000") {
%>
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
<%
	}
%>
<input type="button" name="restart" value="처음부터" onclick="javascript:document.location.href='hs_cnfrm_embed1.php';"/>

</body>
</html>
