<html>
<head>
	<title>NICE평가정보 가상주민번호 서비스</title>
<style type="text/css"> 
BODY
{
    COLOR: #7f7f7f;
    FONT-FAMILY: "Dotum","DotumChe","Arial";
    BACKGROUND-COLOR: #ffffff;
}
</style>
</head>

<body>

<?php

//보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다. 

	session_start();
	/********************************************************************************************************************************************
		NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED
		
		서비스명 : 가상주민번호서비스 (IPIN) 서비스
		페이지명 : 가상주민번호서비스 (IPIN) 사용자 인증 정보 결과 페이지
		
				   수신받은 데이터(인증결과)를 복호화하여 사용자 정보를 확인합니다.
				   
			   
	*********************************************************************************************************************************************/
	/*****************************
	//아파치에서 모듈 로드가 되지 않았을경우 동적으로 모듈을 로드합니다.
	if(!extension_loaded('IPINClient')) {
		dl('IPINClient.' . PHP_SHLIB_SUFFIX);
	}
	$module = 'IPINClient';
	*****************************/
	
	$sSiteCode					= "";			// IPIN 서비스 사이트 코드		(NICE평가정보에서 발급한 사이트코드)
	$sSitePw					= "";			// IPIN 서비스 사이트 패스워드	(NICE평가정보에서 발급한 사이트패스워드)
	
	$sEncData					= "";			// 암호화 된 사용자 인증 정보
	$sDecData					= "";			// 복호화 된 사용자 인증 정보
	
	$sRtnMsg					= "";			// 처리결과 메세지
		
  $sEncData = $_POST['enc_data'];	// ipin_process.php 에서 리턴받은 암호화 된 사용자 인증 정보
  
		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $sEncData, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
    if(base64_encode(base64_decode($sEncData))!=$sEncData) {echo "입력 값 확인이 필요합니다!"; exit;}
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////  
	
	// ipin_main.php 에서 저장한 세션 정보를 추출합니다.
	// 데이타 위변조 방지를 위해 확인하기 위함이므로, 필수사항은 아니며 보안을 위한 권고사항입니다.
	$sCPRequest = $_SESSION['CPREQUEST'];
    
    if ($sEncData != "") {
    
    	// 사용자 정보를 복호화 합니다.
    	
			//if (extension_loaded($module)) {  // 동적으로 모듈 로드 했을경우 
				$sDecData = get_response_data($sSiteCode, $sSitePw, $sEncData);
			//} else {
			//	$sDecData = "Module get_response_data is not compiled into PHP";
			//}
			
    	if ($sDecData == -9) {
    		$sRtnMsg = "입력값 오류 : 복호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
    	} else if ($sDecData == -12) {
    		$sRtnMsg = "NICE평가정보에서 발급한 개발정보가 정확한지 확인해 보세요.";
    	} else {
    	
    		// 복호화된 데이타 구분자는 ^ 이며, 구분자로 데이타를 파싱합니다.
    		/*
    			- 복호화된 데이타 구성
    			가상주민번호확인처리결과코드^가상주민번호^성명^중복확인값(DupInfo)^연령정보^성별정보^생년월일(YYYYMMDD)^내외국인정보^고객사 요청 Sequence
    		*/
    		$arrData = split("\^", $sDecData);
    		$iCount = count($arrData);
    		
    		if ($iCount >= 5) {
    		
    			/*
					다음과 같이 사용자 정보를 추출할 수 있습니다.
					사용자에게 보여주는 정보는, '이름' 데이타만 노출 가능합니다.
				
					사용자 정보를 다른 페이지에서 이용하실 경우에는
					보안을 위하여 암호화 데이타($sEncData)를 통신하여 복호화 후 이용하실것을 권장합니다. (현재 페이지와 같은 처리방식)
					
					만약, 복호화된 정보를 통신해야 하는 경우엔 데이타가 유출되지 않도록 주의해 주세요. (세션처리 권장)
					form 태그의 hidden 처리는 데이타 유출 위험이 높으므로 권장하지 않습니다.
				*/
				
				$strResultCode	= $arrData[0];			// 결과코드
				if ($strResultCode == 1) {
					$strCPRequest	= $arrData[8];			// CP 요청번호
					
					if ($sCPRequest == $strCPRequest) {
				
						$sRtnMsg = "사용자 인증 성공";
						
						$strVno      		= $arrData[1];	// 가상주민번호 (13자리이며, 숫자 또는 문자 포함)
						$strUserName		= $arrData[2];	// 이름
						$strDupInfo			= $arrData[3];	// 중복가입 확인값 (64Byte 고유값)
						$strAgeInfo			= $arrData[4];	// 연령대 코드 (개발 가이드 참조)
					    $strGender			= $arrData[5];	// 성별 코드 (개발 가이드 참조)
					    $strBirthDate		= $arrData[6];	// 생년월일 (YYYYMMDD)
					    $strNationalInfo	= $arrData[7];	// 내/외국인 정보 (개발 가이드 참조)
					
					} else {
						$sRtnMsg = "CP 요청번호 불일치 : 세션에 넣은 $sCPRequest 데이타를 확인해 주시기 바랍니다.";
					}
				} else {
					$sRtnMsg = "리턴값 확인 후, NICE평가정보 개발 담당자에게 문의해 주세요. [$strResultCode]";
				}
    		
    		} else {
    			$sRtnMsg = "리턴값 확인 후, NICE평가정보 개발 담당자에게 문의해 주세요.";
    		}
    	
    	}
    } else {
    	$sRtnMsg = "처리할 암호화 데이타가 없습니다.";
    }
	
?>

	처리결과 : <?= $sRtnMsg ?><br>
	이름 : <?= $strUserName ?><br>

	<form name="user" method="post">
		<input type="hidden" name="enc_data" value="<?= $sEncData ?>"><br>
	</form>
</body>
</html>