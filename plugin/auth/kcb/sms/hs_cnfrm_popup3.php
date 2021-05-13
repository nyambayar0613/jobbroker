<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<?php
	header('Content-Type: text/html; charset=euc-kr');
	/**************************************************************************
		파일명 : hs_cnfrm_popup3.php
		
		본인확인서비스 결과 화면(return url)
	**************************************************************************/
	
	/* 공통 리턴 항목 */
	$rqstSiteNm	=	$_POST["rqst_site_nm"];			// 접속도메인	
	$rqstCausCd	=	$_POST["hs_cert_rqst_caus_cd"];	// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)

	/**************************************************************************
	 * 모듈 호출	; 본인확인서비스 결과 데이터를 복호화한다.
	 **************************************************************************/

	// 인증결과 암호화 데이터
	$encInfo = $_POST["encInfo"];
	//KCB서버 공개키
	$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);
	//KCB서버 서명값
	$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);

	/**************************************************************************
	 * 파라미터에 대한 유효성여부를 검증한다.
	 **************************************************************************/
	if(preg_match('~[^0-9a-zA-Z+/=]~', $encInfo, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBPUBKEY, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBSIGNATURE, $match)) {echo "입력 값 확인이 필요합니다"; exit;}

	// ########################################################################
	// # KCB로부터 부여받은 회원사코드(아이디) 설정 (12자리)
	// ########################################################################
	$memId = "P00000000000";										// 회원사코드(아이디)

	// ########################################################################
	// # 운영전환시 변경 필요
	// ########################################################################
	$endPointUrl = "http://tsafe.ok-name.co.kr:29080/KcbWebService/OkNameService";//EndPointURL, 테스트 서버
	//$endPointUrl = "http://safe.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버
		  
	// ########################################################################
	// # 암호화키 파일 설정 (절대경로) - 파일은 주어진 파일명으로 자동 생성되며 생성되지 않으면 S211오류가 발생됨
	// # 파일은 매월초에 갱신되며 만일 파일이 갱신되지 않으면 복화화데이터가 깨지는 현상이 발생됨.
	// ########################################################################
	$keyPath = "/okname/safecert_".$memId."_test.key";	// 테스트  키파일
	//$keyPath = "/okname/safecert_".$memId.".key";	// 운영  키파일

	// ########################################################################
	// # 로그 경로 지정 및 권한 부여 (hs_cnfrm_popup2.asp에서 설정된 값과 동일하게 설정)
	// ########################################################################
	$logPath = "/okname/log";

	// ########################################################################
	// # 옵션값에 'D','L'을 추가하는 경우 로그(logPath변수에 설정된)가 생성됨.
	// # 시스템(환경변수 LANG설정)이 UTF-8인 경우 'U'옵션 추가 ex)$option='SLU'
	// ########################################################################
	$options = "S";	// S:인증결과복호화
		
	// 명령어
	$cmd = array($keyPath, $memId, $endPointUrl, $WEBPUBKEY, $WEBSIGNATURE, $encInfo, $logPath, $options);
//	echo "$cmd<br/>";
	
	/**************************************************************************
	okname 실행
	**************************************************************************/
	$output = NULL;
	// 실행
	$ret = okname($cmd, $output);
    //echo "ret=$ret<br/>";
    
	$retcode = "";

	if($ret == 0) {
		$result = explode("\n", $output);
		$retcode = $result[0];
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}
?>
<title>KCB 본인확인서비스 샘플</title>
<script language="javascript" type="text/javascript" >
	function fncOpenerSubmit() {
		opener.document.kcbResultForm.mem_id.value			= "<?=$memId?>";
		opener.document.kcbResultForm.rqst_caus_cd.value	= "<?=$rqstCausCd?>";
		opener.document.kcbResultForm.result_cd.value		= "<?=$retcode?>";
<?php
 	if ($ret == 0) {
?>
		opener.document.kcbResultForm.result_msg.value		= "<?=$result[1]?>";
		opener.document.kcbResultForm.svc_tx_seqno.value	= "<?=$result[2]?>";
		opener.document.kcbResultForm.cert_dt_tm.value		= "<?=$result[3]?>";
		opener.document.kcbResultForm.di.value				= "<?=$result[4]?>";
		opener.document.kcbResultForm.ci.value				= "<?=$result[5]?>";
		opener.document.kcbResultForm.name.value			= "<?=$result[7]?>";
		opener.document.kcbResultForm.birthday.value		= "<?=$result[8]?>";
		opener.document.kcbResultForm.sex.value				= "<?=$result[9]?>";
		opener.document.kcbResultForm.nation.value			= "<?=$result[10]?>";
		opener.document.kcbResultForm.tel_com_cd.value		= "<?=$result[11]?>";
		opener.document.kcbResultForm.tel_no.value			= "<?=$result[12]?>";
		opener.document.kcbResultForm.return_msg.value		= "<?=$result[16]?>";
<?php
	}
?>	
		opener.document.kcbResultForm.action = "hs_cnfrm_popup4.php";

		opener.document.kcbResultForm.submit();
		self.close();
	}	
</script>
</head>
<body>

<?php
	//**************************************************************************
	// 복호화된 본인확인 결과 데이터 
	// 개발시 확인 용도로 사용하며 운영시 주석 또는 삭제 처리 필요
	//**************************************************************************
?>
	<input type="hidden" name="회원사코드"			value="<?=$memId?>"/>
	<input type="hidden" name="인증요청사유코드"	value="<?=$rqstCausCd?>"/>
	<input type="hidden" name="접속도메인"			value="<?=$rqstSiteNm?>"/>
	<input type="hidden" name="처리결과코드"		value="<?=$retcode?>"/>		 
	
<?php
 	if ($ret == 0) {
?>
	<input type="hidden" name="처리결과메시지"		value="<?=$result[1] ?>"/>		 
	<input type="hidden" name="거래일련번호"		value="<?=$result[2] ?>"/>		 
	<input type="hidden" name="인증일시"			value="<?=$result[3] ?>"/>		 
	<input type="hidden" name="DI"					value="<?=$result[4] ?>"/>		 
	<input type="hidden" name="CI"					value="<?=$result[5] ?>"/>		 
	<input type="hidden" name="성명"				value="<?=$result[7] ?>"/>		 
	<input type="hidden" name="생년월일"			value="<?=$result[8] ?>"/>		 
	<input type="hidden" name="성별"				value="<?=$result[9] ?>"/>		 
	<input type="hidden" name="내외국인구분"		value="<?=$result[10]?>"/>	 
	<input type="hidden" name="통신사코드"			value="<?=$result[11]?>"/>	 
	<input type="hidden" name="휴대폰번호"			value="<?=$result[12]?>"/>	 
	<input type="hidden" name="리턴메시지"			value="<?=$result[16]?>"/>	 
<?php
	}
?>	
</body>
<?php
	if($ret == 0) {
		//인증결과 복호화 성공
		// 인증결과를 확인하여 페이지분기등의 처리를 수행해야한다.
	 	if ($retcode == "B000") {
			echo ("<script>alert('본인인증성공'); fncOpenerSubmit();</script>");
		}
		else {
			echo ("<script>alert('본인인증실패 : ".$retcode."'); fncOpenerSubmit();</script>");
		}
	} else {
		//인증결과 복호화 실패
		echo ("<script>alert('인증결과복호화 실패 : ".$ret."'); self.close(); </script>");
	}
?>
</html>
