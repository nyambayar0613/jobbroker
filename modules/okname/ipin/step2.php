<?php
	$alice_path = "../../../";
	
	$cat_path = "../../../";

	include_once $alice_path . "_core.php";

	@header("Content-Type: text/html; charset=EUC-KR");

	//아이핀팝업에서 조회한 PERSONALINFO이다.
	@$encPsnlInfo = $_POST["encPsnlInfo"];
	
	//KCB서버 공개키
	@$WEBPUBKEY = trim($_POST["WEBPUBKEY"]);
	//KCB서버 서명값
	@$WEBSIGNATURE = trim($_POST["WEBSIGNATURE"]);
  
	/*
	echo "$encPsnlInfo<br>";
	echo "$WEBPUBKEY<br>";
	echo "$WEBSIGNATURE<br>";
	*/
  
	//아이핀 서버와 통신을 위한 키파일 생성
	// 파라미터 정의
    // 모듈 경로 지정 및 권한 부여 (ipin1.php에서 설정된 값과 동일)
	$exe = $alice['okname_gblib_abs_path'] . "/okname";
	// /home/alba/public_html/n_alba/modules/okname/linux32_nonstatic_glibc2.3.4/okname

    // 암호화키 파일 설정 (ipin1.php에서 설정된 값과 동일)
	$keyPath	= $alice['okname_abs_path'] . "/okname.key";
	$cpCode	= $env['ipin_id'];			// 회원사코드 (테스트인 경우 'P00000000000'를 사용하며 운영시 발급받은 회원사코드를 설정)

	// 데모일땐 테스트로
	if($is_demo){	

		$endPointURL = "http://twww.ok-name.co.kr:8888/KcbWebService/OkNameService";// 테스트 서버

	} else {

		$endPointURL = "http://www.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버

	}

	$cpubkey = $WEBPUBKEY;       //server publickey
	$csig = $WEBSIGNATURE;    //server signature
	$encdata = $encPsnlInfo;     //PERSONALINFO

    // 로그 경로 지정 및 권한 부여 (ipin1.php에서 설정된 값과 동일)
	$logPath = $alice['okname_abs_path'] . "/log";
	$options = "SL";
		
	// 명령어
	$cmd = "$exe $keyPath $cpCode $endPointURL $cpubkey $csig $encdata $logPath $options";
	
	// 실행
	exec($cmd, $out, $ret);

	$field = array();	
	// 결과라인에서 값을 추출
	foreach($out as $a => $b) {
		if($a < 13) {
			$field[$a] = $b;
		}
	}

	// 회원 가입 중복 체크
	$ssn_check = $user_control->ssn_checking($field[0]);
	if($ssn_check){
		echo "<script>alert('".iconv('UTF-8','EUC-KR','이미 가입 하셨습니다.\n\n가입하신 아이디로 로그인 하시기 바랍니다.')."');window.opener.location.href = '".$alice['member_path']."/login.php';self.close();</script>";
		exit;
	}

/*

	$field_name_IPIN_DEC = array(
		"dupInfo        ",	// 0
		"coinfo1        ",	// 1
		"coinfo2        ",	// 2
		"ciupdate       ",	// 3
		"virtualNo      ",	// 4
		"cpCode         ",	// 5
		"realName       ",	// 6
		"cpRequestNumber",	// 7
		"age            ",	// 8
		"sex            ",	// 9
		"nationalInfo   ",	// 10
		"birthDate      ",	// 11
		"authInfo       ",	// 12
	);
	
	echo "encPsnlInfo=$encPsnlInfo<br>";	
	// 추출된 값 프린트
foreach($field as $a => $b) {
	echo $field_name_IPIN_DEC[$a].": ".$field[$a]."<br>";
}

	print_R($_POST);
	print_r($out);
	print_R($field);

	exit;
*/

?>
<html>
<head>
<script language="JavaScript">
function fncOpenerSubmit() {
	opener.document.kcbOutForm.encPsnlInfo.value = document.dForm.encPsnlInfo.value;
	opener.document.kcbOutForm.dupinfo.value = document.dForm.dupinfo.value;
	opener.document.kcbOutForm.coinfo1.value = document.dForm.coinfo1.value;
	opener.document.kcbOutForm.coinfo2.value = document.dForm.coinfo2.value;
	opener.document.kcbOutForm.ciupdate.value = document.dForm.ciupdate.value;
	opener.document.kcbOutForm.virtualno.value = document.dForm.virtualno.value;
	opener.document.kcbOutForm.cpcode.value = document.dForm.cpcode.value;
	opener.document.kcbOutForm.realname.value = document.dForm.realname.value;
	opener.document.kcbOutForm.cprequestnumber.value=document.dForm.cprequestnumber.value;
	opener.document.kcbOutForm.age.value = document.dForm.age.value;
	opener.document.kcbOutForm.sex.value = document.dForm.sex.value;
	opener.document.kcbOutForm.nationalinfo.value = document.dForm.nationalinfo.value;
	opener.document.kcbOutForm.birthdate.value = document.dForm.birthdate.value;
	opener.document.kcbOutForm.authinfo.value = document.dForm.authinfo.value;
	opener.document.kcbOutForm.action = "register_form.php";
	opener.document.kcbOutForm.submit();
	self.close();
}
</script>
</head>
<body onLoad="javascript:fncOpenerSubmit();">
<form name="dForm" method="post">
  <input type="hidden" name="encPsnlInfo" 	value ="<?=$encPsnlInfo ?>" />
  <input type="hidden" name="dupinfo" 		value="<?=$field[0]?>" />
  <input type="hidden" name="coinfo1" 		value="<?=$field[1]?>" />
  <input type="hidden" name="coinfo2" 		value="<?=$field[2]?>" />
  <input type="hidden" name="ciupdate" 		value="<?=$field[3]?>" />
  <input type="hidden" name="virtualno"  	value="<?=$field[4]?>" />
  <input type="hidden" name="cpcode"        value="<?=$field[5]?>" />
  <input type="hidden" name="realname" 		value="<?=$field[6]?>" />
  <input type="hidden" name="cprequestnumber"	 value="<?=$field[7]?>" />
  <input type="hidden" name="age" 			value="<?=$field[8]?>" />
  <input type="hidden" name="sex" 			value="<?=$field[9]?>" />
  <input type="hidden" name="nationalinfo" 	value="<?=$field[10]?>" />
  <input type="hidden" name="birthdate" 	value="<?=$field[11]?>" />
  <input type="hidden" name="authinfo"      value="<?=$field[12]?>" />
</form>
</body>
</html>
