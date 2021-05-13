<?php
	$alice_path = "../../../";
	
	$cat_path = "../../../";

	include_once $alice_path . "_core.php";


	// 데모일땐 테스트로
	if($is_demo){	

		$idpUrl    = "https://tipin.ok-name.co.kr:8443/tis/ti/POTI90B_SendCertInfo.jsp";
		$endPointURL = "http://twww.ok-name.co.kr:8888/KcbWebService/OkNameService";// 테스트 서버
		$kcbInForm_action = "https://tipin.ok-name.co.kr:8443/tis/ti/POTI01A_LoginRP.jsp";

	} else {

		// KCB 운영서버를 호출할 경우
		$idpUrl    = "https://ipin.ok-name.co.kr/tis/ti/POTI90B_SendCertInfo.jsp";
		$endPointURL = "http://www.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버
		$kcbInForm_action = "https://ipin.ok-name.co.kr/tis/ti/POTI01A_LoginRP.jsp";

	}

	$returnUrl = $alice['url'] . "/okname/ipin/find_password2.php";		// 아이핀 인증을 마치고 돌아올 페이지 주소

	$idpCode	= "V";					// 고정값. KCB기관코드
	$cpCode	= $env['ipin_id'];	// 회원사코드 (테스트인 경우 'P00000000000'를 사용하며 운영시 발급받은 회원사코드를 설정)

	$exe = $alice['okname_gblib_abs_path'] . "/okname";		// 모듈 경로 지정 및 권한 부여 (절대경로)

	// 암호화키 파일 설정 (절대경로) - 파일은 주어진 파일명으로 자동 생성되며 매월마다 갱신됨. 웹서버에 해당파일을 생성할 권한 필요.
	$keyPath = $alice['okname_abs_path'] . "/okname.key";
	$memId = $cpCode;			// 회원사코드
	$reserved1 = "0";			//reserved1
	$reserved2 = "0";			//reserved2

	// 로그 경로 지정 및 권한 부여 (절대경로)
	// options값에 'L'을 추가하는 경우에만 로그가 생성됨.
	$logPath = $alice['okname_abs_path'] . "/log";					// 로그파일을 남기는 경우 로그파일이 생성될 경로
	$options = "CL";// Option

	$cmd = "$exe $keyPath $memId \"{$reserved1}\" \"{$reserved2}\" $endPointURL $logPath $options";	// 명령어

	exec($cmd, $out, $ret);	// 실행

	$retcode = "";	// 결과코드
	$pubkey = "";
	$sig = "";
	$curtime = "";

	if ($ret == 0) {	//성공일 경우 변수를 결과에서 얻음

		$retcode=sprintf("B%03d", $ret);
		$pubkey=$out[0];
		$sig=$out[1];
		$curtime=$out[2];

	} else {

		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);

	}
?>
<html>
  <head>
	<script language="JavaScript">
	//<!--
	function certKCBIpin(){
		document.kcbInForm.target = "_self";

		document.kcbInForm.action = "<?php echo $kcbInForm_action;?>";

		//인증요청
		document.kcbInForm.submit();
		return	;
	}
	//-->
	</script>
  </head>
<body onload="javascript:certKCBIpin();">
	<form name="kcbInForm" method="post" >
		<input type="hidden" name="IDPCODE" value="<?=$idpCode?>" />
		<input type="hidden" name="IDPURL" value="<?=$idpUrl?>" />
		<input type="hidden" name="CPCODE" value="<?=$cpCode?>" />
		<input type="hidden" name="CPREQUESTNUM" value="<?=$curtime?>" />
		<input type="hidden" name="RETURNURL" value="<?=$returnUrl?>" />
		<input type="hidden" name="WEBPUBKEY" value="<?=$pubkey?>" />
		<input type="hidden" name="WEBSIGNATURE" value="<?=$sig?>" />
		<input type="hidden" name="mode" value="company_find_id" />
	</form>
</body>
</html>