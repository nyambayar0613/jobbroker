<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<?php
	header('Content-Type: text/html; charset=euc-kr');

	//아이핀팝업에서 조회한 PERSONALINFO
	@$encPsnlInfo = $_POST["encPsnlInfo"];
	//KCB서버 공개키
	@$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);
	//KCB서버 서명값
	@$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);

	//파라미터에 대한 유효성여부를 검증한다.
	if(preg_match('~[^0-9a-zA-Z+/=]~', $encPsnlInfo, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBPUBKEY, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
	if(preg_match('~[^0-9a-zA-Z+/=]~', $WEBSIGNATURE, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
  
	/*
	echo "$encPsnlInfo<br>";
	echo "$WEBPUBKEY<br>";
	echo "$WEBSIGNATURE<br>";
	*/
  
	//아이핀 서버와 통신을 위한 키파일 생성
	// 파라미터 정의
    // 암호화키 파일 설정 (ipin1.php에서 설정된 값과 동일)
	$keyPath = "/okname/okname_test.key";	// 테스트 키파일
	//$keyPath = "/okname/okname.key";		// 운영 키파일

	$cpCode    = "P00000000000";			// 회원사코드 (테스트인 경우 'P00000000000'를 사용하며 운영시 발급받은 회원사코드를 설정)
	$endPointUrl = "http://twww.ok-name.co.kr:8888/KcbWebService/OkNameService";// 테스트 서버
	//$endPointURL = "http://www.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버

    // 로그 경로 지정 및 권한 부여 (ipin1.php에서 설정된 값과 동일)
	$logPath = "/okname/log";
	$options = "SL";
		
	// 명령어
	$cmd = array($keyPath, $cpCode, $endPointUrl, $WEBPUBKEY, $WEBSIGNATURE, $encPsnlInfo, $logPath, $options);
	//echo "$cmd<br>";
	
	/**************************************************************************
	 * okname 실행
	 **************************************************************************/
	$output = NULL;
	// 실행
	$ret = okname($cmd, $output);
    //echo "ret=$ret<br/>";
    
	$retcode = "";

	if($ret == 0) {
		$result = explode("\n", $output);
		$retcode=sprintf("B%03d", $ret);
	}
	else {
		if($ret <=200)
			$retcode=sprintf("B%03d", $ret);
		else
			$retcode=sprintf("S%03d", $ret);
	}
?>
<script language="JavaScript">
function fncOpenerSubmit() {
	opener.document.kcbOutForm.encPsnlInfo.value 		= "<?=$encPsnlInfo ?>";
<?php
	if ($ret == 0) { 
?>	
	opener.document.kcbOutForm.dupinfo.value 			= "<?=$result[0] ?>";
	opener.document.kcbOutForm.coinfo1.value            = "<?=$result[1] ?>";
	opener.document.kcbOutForm.coinfo2.value            = "<?=$result[2] ?>";
	opener.document.kcbOutForm.ciupdate.value           = "<?=$result[3] ?>";
	opener.document.kcbOutForm.virtualno.value 			= "<?=$result[4] ?>";
	opener.document.kcbOutForm.cpcode.value             = "<?=$result[5] ?>";
	opener.document.kcbOutForm.realname.value 			= "<?=$result[6] ?>";
	opener.document.kcbOutForm.cprequestnumber.value 	= "<?=$result[7] ?>";
	opener.document.kcbOutForm.age.value 				= "<?=$result[8] ?>";
	opener.document.kcbOutForm.sex.value 				= "<?=$result[9] ?>";
	opener.document.kcbOutForm.nationalinfo.value 		= "<?=$result[10]?>";
	opener.document.kcbOutForm.birthdate.value 			= "<?=$result[11]?>";
	opener.document.kcbOutForm.authinfo.value           = "<?=$result[12]?>";
<?php
	} 
?>	
	opener.document.kcbOutForm.action = "ipin4.php";
	opener.document.kcbOutForm.submit();
	self.close();
}
</script>
</head>
<body>
<?php
	if ($ret == 0) { 
?>	
  <input type="hidden" name="encPsnlInfo" 		value ="<?=$encPsnlInfo?>"/>
  <input type="hidden" name="dupinfo" 			value="<?=$result[0]?>"/>
  <input type="hidden" name="coinfo1" 			value="<?=$result[1]?>"/>
  <input type="hidden" name="coinfo2" 			value="<?=$result[2]?>"/>
  <input type="hidden" name="ciupdate" 			value="<?=$result[3]?>"/>
  <input type="hidden" name="virtualno"  		value="<?=$result[4]?>"/>
  <input type="hidden" name="cpcode"        	value="<?=$result[5]?>"/>
  <input type="hidden" name="realname" 			value="<?=$result[6]?>"/>
  <input type="hidden" name="cprequestnumber"	value="<?=$result[7]?>"/>
  <input type="hidden" name="age" 				value="<?=$result[8]?>"/>
  <input type="hidden" name="sex" 				value="<?=$result[9]?>"/>
  <input type="hidden" name="nationalinfo" 		value="<?=$result[10]?>"/>
  <input type="hidden" name="birthdate" 		value="<?=$result[11]?>"/>
  <input type="hidden" name="authinfo"      	value="<?=$result[12]?>"/>
<?php
	} 
?>	
</body>
<?php
	if($ret == 0) {
		echo("<script>alert('본인인증성공'); fncOpenerSubmit();</script>");
	} else {
		//인증결과 복호화 실패
		echo("<script>alert('인증결과복호화 실패 : ".$ret."'); self.close(); </script>");
	}
?>
</html>
