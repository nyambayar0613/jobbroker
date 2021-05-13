<?php
	$alice_path = "../../../";
	
	$cat_path = "../../../";

	include_once $alice_path . "_core.php";

	@header("Content-Type: text/html; charset=UTF-8");

	/**************************************************************************
		파일명 : hs_cnfrm_popup3.php
		
		본인확인서비스 결과 화면(return url)
	**************************************************************************/
	
	/* 공통 리턴 항목 */
	$idcfMbrComCd			=	$_POST["idcf_mbr_com_cd"] ? $_POST["idcf_mbr_com_cd"] : $_GET["idcf_mbr_com_cd"];		// 고객사코드
	$hsCertSvcTxSeqno		=	$_POST["hs_cert_svc_tx_seqno"] ? $_POST["hs_cert_svc_tx_seqno"] : $_GET["hs_cert_svc_tx_seqno"];	// 거래번호
	$rqstSiteNm				=	$_POST["rqst_site_nm"] ? $_POST["rqst_site_nm"] : $_GET["rqst_site_nm"];			// 접속도메인	
	$hsCertRqstCausCd		=	$_POST["hs_cert_rqst_caus_cd"] ? $_POST["hs_cert_rqst_caus_cd"] : $_GET["hs_cert_rqst_caus_cd"];	// 인증요청사유코드 2byte  (00:회원가입, 01:성인인증, 02:회원정보수정, 03:비밀번호찾기, 04:상품구매, 99:기타)

	$resultCd				=	$_POST["result_cd"] ? $_POST["result_cd"] : $_GET["result_cd"];			// 결과코드
	$resultMsg				=	$_POST["result_msg"] ? $_POST["result_msg"] : $_GET["result_msg"];			// 결과메세지
	$certDtTm				=	$_POST["cert_dt_tm"] ? $_POST["cert_dt_tm"] : $_GET["cert_dt_tm"];			// 인증일시

	/**************************************************************************
	 * 모듈 호출	; 본인확인서비스 결과 데이터를 복호화한다.
	 **************************************************************************/
	$encInfo = $_POST["encInfo"] ? $_POST["encInfo"] : $_GET["encInfo"];

	$Ab = $_POST["WEBPUBKEY"] ? $_POST["WEBPUBKEY"] : $_GET["WEBPUBKEY"];
	$Ac = $_POST["WEBSIGNATURE"] ? $_POST["WEBSIGNATURE"] : $_GET["WEBSIGNATURE"];

	//KCB서버 공개키
	$WEBPUBKEY = trim($Ab);
	//KCB서버 서명값
	$WEBSIGNATURE = trim($Ac);

	// ########################################################################
	// # 운영전환시 변경 필요
	// ########################################################################
	// 데모일땐 테스트로
	$is_demo = false;
	if($is_demo){

		$endPointUrl = "http://tsafe.ok-name.co.kr:29080/KcbWebService/OkNameService";//EndPointURL, 테스트 서버

	} else {
	
		$endPointUrl = "http://safe.ok-name.co.kr/KcbWebService/OkNameService";// 운영 서버

	}
		  
	//okname 실행 정보
	// ########################################################################
	// # 모듈 경로 지정 및 권한 부여 (hs_cnfrm_popup2.php에서 설정된 값과 동일하게 설정)
	// ########################################################################
	$exe = $alice['okname_gblib_abs_path'] . "/okname";

	// ########################################################################
	// # 암호화키 파일 설정 (절대경로) - 파일은 주어진 파일명으로 자동 생성되며, 매월마다 갱신됨 
	// # 만일 키파일이 갱신되지 않으면 복화화데이터가 깨지는 현상이 발생됨.
	// ########################################################################
	$keyPath = $alice['okname_abs_path'] . "/okname.key";

	// ########################################################################
	// # 로그 경로 지정 및 권한 부여 (hs_cnfrm_popup2.asp에서 설정된 값과 동일하게 설정)
	// ########################################################################
	$logPath = $alice['okname_abs_path'] . "/log";

	// ########################################################################
	// # 옵션값에 'L'을 추가하는 경우에만 로그가 생성됨.
	// ########################################################################
	$options = "SL";	// S:인증결과복호화
		
	// 명령어
	$cmd = "$exe $keyPath $idcfMbrComCd $endPointUrl $WEBPUBKEY $WEBSIGNATURE $encInfo $logPath $options";

	//echo "$cmd<br>";

	// 실행
	exec($cmd, $out, $ret);

    //echo "ret=$ret<br/>";
    
	if($ret == 0) {
		//echo "복호화 요청 호출 성공.<br/>";
		$field = array();
		// 결과라인에서 값을 추출
		foreach($out as $a => $b) {
			if($a < 17) {
				$field[$a] = iconv("CP949", "UTF-8", $b);
			}
		}
	}
	else {
		echo "복호화 요청 호출 에러. 리턴값 : ".$ret."<br/>";		 
	}

	

	$_arr = $field;
	$_arr['name'] = $field['7'];
	$_arr['birth'] = $field['8'];
	$_arr['di'] = $field['4'];
	$_arr['ci'] = $field['5'];
	$_arr['hphone'] = $field['12'];
	$_arr['gender'] = !$field['9'] ? 1 : 0; // : 남자는 0으로 여자는 1로 설정

	// : 인증성공
	if($field[0]=='B000') {
		// : 성인인증
		if($env['use_adult']) {
			if($netfu_util->get_age(substr($field['8'],0,4))<20) {
				echo "<script>alert('성인이 아닙니다. 성인만 접근 가능합니다.');self.close();</script>";
				exit;
			}
		}

		if($netfu_util->get_age(substr($field['11'],0,4))>=20) $_SESSION['adult_view'] = 1;
		$_SESSION['certify_info'] = $_arr;

		if($is_member) {
			$mb_vals['mb_ssn'] = $field['ci'];
			$mb_vals['is_adult'] = 1;
			$mb_id = $member['mb_id'];
			$result = $user_control->user_update($mb_vals,$mb_id);
		}

		$_reload = 'opener.location.reload();';
		if(strpos($_SESSION['__auth_click_page__'], 'member/register.php')!==false) $_reload = 'opener.netfu_auth.auth_read=true;';

		echo "<script>".$_reload."self.close();</script>";

	// : 인증실패
	} else {
		$utility->popup_msg_close($field[1]);
	}
	exit;


    echo "복호화처리결과코드:$ret	<br/>";		 
    echo "처리결과코드		:$field[0]	<br/>";		 
    echo "처리결과메시지	:$field[1]	<br/>";		 
    echo "거래일련번호		:$field[2]	<br/>";		 
    echo "인증일시			:$field[3]	<br/>";		 
    echo "DI				:$field[4]	<br/>";		 
    echo "CI				:$field[5]	<br/>";		 
    echo "성명				:$field[7]	<br/>";		 
    echo "생년월일			:$field[8]	<br/>";		 
    echo "성별				:$field[9]	<br/>";		 
    echo "내외국인구분		:$field[10]	<br/>";	 
    echo "통신사코드		:$field[11]	<br/>";	 
    echo "휴대폰번호		:$field[12]	<br/>";	 
    echo "리턴메시지		:$field[16]	<br/>";	 
    
exit;

//*/
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html" charset="euc-kr">
	<title>KCB 본인확인서비스 샘플</title>
    <script language="javascript" type="text/javascript" >
	function fncOpenerSubmit() {
		opener.document.kcbResultForm.idcf_mbr_com_cd.value = "<?=$idcfMbrComCd?>";
		opener.document.kcbResultForm.hs_cert_rqst_caus_cd.value = "<?=$hsCertRqstCausCd?>";
		opener.document.kcbResultForm.result_cd.value = "<?=$field[0]?>";
		opener.document.kcbResultForm.result_msg.value = "<?=$field[1]?>";
		opener.document.kcbResultForm.hs_cert_svc_tx_seqno.value = "<?=$field[2]?>";
		opener.document.kcbResultForm.cert_dt_tm.value = "<?=$field[3]?>";
		opener.document.kcbResultForm.di.value = "<?=$field[4]?>";
		opener.document.kcbResultForm.ci.value = "<?=$field[5]?>";
		opener.document.kcbResultForm.name.value = "<?=$field[7]?>";
		opener.document.kcbResultForm.birthday.value = "<?=$field[8]?>";
		opener.document.kcbResultForm.gender.value = "<?=$field[9]?>";
		opener.document.kcbResultForm.nation.value = "<?=$field[10]?>";
		opener.document.kcbResultForm.tel_com_cd.value = "<?=$field[11]?>";
		opener.document.kcbResultForm.tel_no.value = "<?=$field[12]?>";
		opener.document.kcbResultForm.return_msg.value = "<?=$field[16]?>";
		opener.document.kcbResultForm.action = "register_form.php";

		opener.document.kcbResultForm.submit();
		self.close();
	}	
	</script>
</head>
<body>
	<b>본인확인결과</b>
 	결과코드		: <?=$resultCd?><br />
 	결과메세지		: <?=$resultMsg?><br />
	거래번호		: <?=$hsCertSvcTxSeqno?><br />
 	인증일시		: <?=$certDtTm?><br />
	고객사코드		: <?=$idcfMbrComCd?><br />
	접속도메인		: <?=$rqstSiteNm?><br />
	인증요청사유코드: <?=$hsCertRqstCausCd?><br />
</body>
<?php
	if($ret == 0) {
		//인증결과 복호화 성공
		echo ("<script>fncOpenerSubmit();</script>");
	} else {
		//인증결과 복호화 실패
		echo ("<script>alert(\"인증결과복호화 실패 : $ret.\"); self.close(); </script>");
	}
?>
</html>
