<?php
/********************************************************************************
*
* 파일명 : AGS_pay_ing.php
* 최종수정일자 : 2016/10/11
*
* 올더게이트 플러그인에서 리턴된 데이타를 받아서 소켓결제요청을 합니다.
*
* Copyright NICEPayments.Co.,Ltd. All rights reserved.
*
*
*  ※ 유의사항 ※
*  1.  "|"(파이프) 값은 결제처리 중 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
********************************************************************************/

$_POST['no'] = $pno;

// : 결제정보 불러오기
$pay_row = sql_fetch("select * from alice_payment where `no`='".addslashes($pno)."'");
$_post_un = unserialize(stripslashes($pay_row['post_un']));
// : 가격체크
$get_price = $netfu_payment->get_service_type($_post_un);

if($pay_row['pay_price']!=$get_price['use_price_hap']) {
	$arr['msg'] = "금액이 맞지 않습니다. 다시 시도해주시기 바랍니다.";
	return false;
}

	/****************************************************************************
	*
	* [1] 라이브러리(AGSLib.php)를 인클루드 합니다.
	*
	****************************************************************************/
	require (NFE_PATH."/plugin/PG/allthegate/source/lib/AGSLib.php");


	/****************************************************************************
	*
	* [2]. agspay4.0 클래스의 인스턴스를 생성합니다.
	*
	****************************************************************************/
	$agspay = new agspay40;



	/****************************************************************************
	*
	* [3] AGS_pay.html 로 부터 넘겨받을 데이타
	*
	****************************************************************************/
	/*공통사용*/
	//$agspay->SetValue("AgsPayHome","C:/htdocs/agspay");			//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)
	$agspay->SetValue("AgsPayHome",NFE_PATH."/plugin/PG/allthegate/source");			//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)
	$agspay->SetValue("StoreId",trim($netfu_payment->use_pg['pg_id']));		//상점아이디
	$agspay->SetValue("log","true");							//true : 로그기록, false : 로그기록안함.
	$agspay->SetValue("logLevel","INFO");						//로그레벨 : DEBUG, INFO, WARN, ERROR, FATAL (해당 레벨이상의 로그만 기록됨)
	$agspay->SetValue("UseNetCancel","true");					//true : 망취소 사용. false: 망취소 미사용
	$agspay->SetValue("Type", "Pay");							//고정값(수정불가)
	$agspay->SetValue("RecvLen", 7);							//수신 데이터(길이) 체크 에러시 6 또는 7 설정. 
	
	$agspay->SetValue("AuthTy",trim($_POST["AuthTy"]));			//결제형태
	$agspay->SetValue("SubTy",trim($_POST["SubTy"]));			//서브결제형태
	$agspay->SetValue("OrdNo",trim($_POST["OrdNo"]));			//주문번호
	$agspay->SetValue("Amt",trim($_POST["Amt"]));				//금액
	$agspay->SetValue("UserEmail",trim($_POST["UserEmail"]));	//주문자이메일
	$agspay->SetValue("ProdNm",trim($_POST["ProdNm"]));			//상품명
	$AGS_HASHDATA 		= trim( $_POST["AGS_HASHDATA"] );		//암호화 HASHDATA

	/*신용카드&가상계좌사용*/
	$agspay->SetValue("MallUrl",trim($_POST["MallUrl"]));		//MallUrl(무통장입금) - 상점 도메인 가상계좌추가
	$agspay->SetValue("UserId",trim($_POST["UserId"]));			//회원아이디


	/*신용카드사용*/
	$agspay->SetValue("OrdNm",trim($_POST["OrdNm"]));			//주문자명
	$agspay->SetValue("OrdPhone",trim($_POST["OrdPhone"]));		//주문자연락처
	$agspay->SetValue("OrdAddr",trim($_POST["OrdAddr"]));		//주문자주소 가상계좌추가
	$agspay->SetValue("RcpNm",trim($_POST["RcpNm"]));			//수신자명
	$agspay->SetValue("RcpPhone",trim($_POST["RcpPhone"]));		//수신자연락처
	$agspay->SetValue("DlvAddr",trim($_POST["DlvAddr"]));		//배송지주소
	$agspay->SetValue("Remark",trim($_POST["Remark"]));			//비고
	$agspay->SetValue("DeviId",trim($_POST["DeviId"]));			//단말기아이디
	$agspay->SetValue("AuthYn",trim($_POST["AuthYn"]));			//인증여부
	$agspay->SetValue("Instmt",trim($_POST["Instmt"]));			//할부개월수
	$agspay->SetValue("UserIp",$_SERVER["REMOTE_ADDR"]);		//회원 IP

	/*신용카드(ISP)*/
	$agspay->SetValue("partial_mm",trim($_POST["partial_mm"]));		//일반할부기간
	$agspay->SetValue("noIntMonth",trim($_POST["noIntMonth"]));		//무이자할부기간
	$agspay->SetValue("KVP_CURRENCY",trim($_POST["KVP_CURRENCY"]));	//KVP_통화코드
	$agspay->SetValue("KVP_CARDCODE",trim($_POST["KVP_CARDCODE"]));	//KVP_카드사코드
	$agspay->SetValue("KVP_SESSIONKEY",$_POST["KVP_SESSIONKEY"]);	//KVP_SESSIONKEY
	$agspay->SetValue("KVP_ENCDATA",$_POST["KVP_ENCDATA"]);			//KVP_ENCDATA
	$agspay->SetValue("KVP_CONAME",trim($_POST["KVP_CONAME"]));		//KVP_카드명
	$agspay->SetValue("KVP_NOINT",trim($_POST["KVP_NOINT"]));		//KVP_무이자=1 일반=0
	$agspay->SetValue("KVP_QUOTA",trim($_POST["KVP_QUOTA"]));		//KVP_할부개월

	/*신용카드(안심)*/
	$agspay->SetValue("CardNo",trim($_POST["CardNo"]));			//카드번호
	$agspay->SetValue("MPI_CAVV",$_POST["MPI_CAVV"]);			//MPI_CAVV
	$agspay->SetValue("MPI_ECI",$_POST["MPI_ECI"]);				//MPI_ECI
	$agspay->SetValue("MPI_MD64",$_POST["MPI_MD64"]);			//MPI_MD64

	/*신용카드(일반)*/
	$agspay->SetValue("ExpMon",trim($_POST["ExpMon"]));				//유효기간(월)
	$agspay->SetValue("ExpYear",trim($_POST["ExpYear"]));			//유효기간(년)
	$agspay->SetValue("Passwd",trim($_POST["Passwd"]));				//비밀번호
	$agspay->SetValue("SocId",trim($_POST["SocId"]));				//주민등록번호/사업자등록번호

	/*계좌이체사용*/
	$agspay->SetValue("ICHE_OUTBANKNAME",trim($_POST["ICHE_OUTBANKNAME"]));		//이체은행명
	$agspay->SetValue("ICHE_OUTACCTNO",trim($_POST["ICHE_OUTACCTNO"]));			//이체계좌번호
	$agspay->SetValue("ICHE_OUTBANKMASTER",trim($_POST["ICHE_OUTBANKMASTER"]));	//이체계좌소유주
	$agspay->SetValue("ICHE_AMOUNT",trim($_POST["ICHE_AMOUNT"]));				//이체금액

	/*핸드폰사용*/
	$agspay->SetValue("HP_SERVERINFO",trim($_POST["HP_SERVERINFO"]));	//SERVER_INFO(핸드폰결제)
	$agspay->SetValue("HP_HANDPHONE",trim($_POST["HP_HANDPHONE"]));		//HANDPHONE(핸드폰결제)
	$agspay->SetValue("HP_COMPANY",trim($_POST["HP_COMPANY"]));			//COMPANY(핸드폰결제)
	$agspay->SetValue("HP_ID",trim($_POST["HP_ID"]));					//HP_ID(핸드폰결제)
	$agspay->SetValue("HP_SUBID",trim($_POST["HP_SUBID"]));				//HP_SUBID(핸드폰결제)
	$agspay->SetValue("HP_UNITType",trim($_POST["HP_UNITType"]));		//HP_UNITType(핸드폰결제)
	$agspay->SetValue("HP_IDEN",trim($_POST["HP_IDEN"]));				//HP_IDEN(핸드폰결제)
	$agspay->SetValue("HP_IPADDR",trim($_POST["HP_IPADDR"]));			//HP_IPADDR(핸드폰결제)

	/*ARS사용*/
	$agspay->SetValue("ARS_NAME",trim($_POST["ARS_NAME"]));				//ARS_NAME(ARS결제)
	$agspay->SetValue("ARS_PHONE",trim($_POST["ARS_PHONE"]));			//ARS_PHONE(ARS결제)

	/*가상계좌사용*/
	$agspay->SetValue("VIRTUAL_CENTERCD",trim($_POST["VIRTUAL_CENTERCD"]));	//은행코드(가상계좌)
	$agspay->SetValue("VIRTUAL_DEPODT",trim($_POST["VIRTUAL_DEPODT"]));		//입금예정일(가상계좌)
	$agspay->SetValue("ZuminCode",trim($_POST["ZuminCode"]));				//주민번호(가상계좌)
	$agspay->SetValue("MallPage",trim($_POST["MallPage"]));					//상점 입/출금 통보 페이지(가상계좌)
	$agspay->SetValue("VIRTUAL_NO",trim($_POST["VIRTUAL_NO"]));				//가상계좌번호(가상계좌)

	/*에스크로사용*/
	$agspay->SetValue("ES_SENDNO",trim($_POST["ES_SENDNO"]));				//에스크로전문번호

	/*계좌이체(소켓) 결제 사용 변수*/
	$agspay->SetValue("ICHE_SOCKETYN",trim($_POST["ICHE_SOCKETYN"]));			//계좌이체(소켓) 사용 여부
	$agspay->SetValue("ICHE_POSMTID",trim($_POST["ICHE_POSMTID"]));				//계좌이체(소켓) 이용기관주문번호
	$agspay->SetValue("ICHE_FNBCMTID",trim($_POST["ICHE_FNBCMTID"]));			//계좌이체(소켓) FNBC거래번호
	$agspay->SetValue("ICHE_APTRTS",trim($_POST["ICHE_APTRTS"]));				//계좌이체(소켓) 이체 시각
	$agspay->SetValue("ICHE_REMARK1",trim($_POST["ICHE_REMARK1"]));				//계좌이체(소켓) 기타사항1
	$agspay->SetValue("ICHE_REMARK2",trim($_POST["ICHE_REMARK2"]));				//계좌이체(소켓) 기타사항2
	$agspay->SetValue("ICHE_ECWYN",trim($_POST["ICHE_ECWYN"]));					//계좌이체(소켓) 에스크로여부
	$agspay->SetValue("ICHE_ECWID",trim($_POST["ICHE_ECWID"]));					//계좌이체(소켓) 에스크로ID
	$agspay->SetValue("ICHE_ECWAMT1",trim($_POST["ICHE_ECWAMT1"]));				//계좌이체(소켓) 에스크로결제금액1
	$agspay->SetValue("ICHE_ECWAMT2",trim($_POST["ICHE_ECWAMT2"]));				//계좌이체(소켓) 에스크로결제금액2
	$agspay->SetValue("ICHE_CASHYN",trim($_POST["ICHE_CASHYN"]));				//계좌이체(소켓) 현금영수증발행여부
	$agspay->SetValue("ICHE_CASHGUBUN_CD",trim($_POST["ICHE_CASHGUBUN_CD"]));	//계좌이체(소켓) 현금영수증구분
	$agspay->SetValue("ICHE_CASHID_NO",trim($_POST["ICHE_CASHID_NO"]));			//계좌이체(소켓) 현금영수증신분확인번호

	/*계좌이체-텔래뱅킹(소켓) 결제 사용 변수*/
	$agspay->SetValue("ICHEARS_SOCKETYN", trim($_POST["ICHEARS_SOCKETYN"]));	//텔레뱅킹계좌이체(소켓) 사용 여부
	$agspay->SetValue("ICHEARS_ADMNO", trim($_POST["ICHEARS_ADMNO"]));			//텔레뱅킹계좌이체 승인번호       
	$agspay->SetValue("ICHEARS_POSMTID", trim($_POST["ICHEARS_POSMTID"]));		//텔레뱅킹계좌이체 이용기관주문번호
	$agspay->SetValue("ICHEARS_CENTERCD", trim($_POST["ICHEARS_CENTERCD"]));	//텔레뱅킹계좌이체 은행코드      
	$agspay->SetValue("ICHEARS_HPNO", trim($_POST["ICHEARS_HPNO"]));			//텔레뱅킹계좌이체 휴대폰번호   


	
	/****************************************************************************
	*
	* [4] 올더게이트 결제서버로 결제를 요청합니다.
	*
	****************************************************************************/
	$agspay->startPay();

	
	/****************************************************************************
	*
	* [5] 결제결과에 따른 상점DB 저장 및 기타 필요한 처리작업을 수행하는 부분입니다.
	*
	*	아래의 결과값들을 통하여 각 결제수단별 결제결과값을 사용하실 수 있습니다.
	*	
	*	-- 공통사용 --
	*	업체ID : $agspay->GetResult("rStoreId")
	*	주문번호 : $agspay->GetResult("rOrdNo")
	*	상품명 : $agspay->GetResult("rProdNm")
	*	거래금액 : $agspay->GetResult("rAmt")
	*	성공여부 : $agspay->GetResult("rSuccYn") (성공:y 실패:n)
	*	결과메시지 : $agspay->GetResult("rResMsg")
	*
	*	1. 신용카드
	*	
	*	전문코드 : $agspay->GetResult("rBusiCd")
	*	거래번호 : $agspay->GetResult("rDealNo")
	*	승인번호 : $agspay->GetResult("rApprNo")
	*	할부개월 : $agspay->GetResult("rInstmt")
	*	승인시각 : $agspay->GetResult("rApprTm")
	*	카드사코드 : $agspay->GetResult("rCardCd")
	*
	*	2.계좌이체(인터넷뱅킹/텔레뱅킹)
	*	에스크로주문번호 : $agspay->GetResult("ES_SENDNO") (에스크로 결제시)
	*
	*	3.가상계좌
	*	가상계좌의 결제성공은 가상계좌발급의 성공만을 의미하며 입금대기상태로 실제 고객이 입금을 완료한 것은 아닙니다.
	*	따라서 가상계좌 결제완료시 결제완료로 처리하여 상품을 배송하시면 안됩니다.
	*	결제후 고객이 발급받은 계좌로 입금이 완료되면 MallPage(상점 입금통보 페이지(가상계좌))로 입금결과가 전송되며
	*	이때 비로소 결제가 완료되게 되므로 결제완료에 대한 처리(배송요청 등)은  MallPage에 작업해주셔야 합니다.
	*	결제종류 : $agspay->GetResult("rAuthTy") (가상계좌 일반 : vir_n 유클릭 : vir_u 에스크로 : vir_s)
	*	승인일자 : $agspay->GetResult("rApprTm")
	*	가상계좌번호 : $agspay->GetResult("rVirNo")
	*
	*	4.핸드폰결제
	*	핸드폰결제일 : $agspay->GetResult("rHP_DATE")
	*	핸드폰결제 TID : $agspay->GetResult("rHP_TID")
	*
	*	5.ARS결제
	*	ARS결제일 : $agspay->GetResult("rHP_DATE")
	*	ARS결제 TID : $agspay->GetResult("rHP_TID")
	*
	****************************************************************************/

	if($agspay->GetResult("rSuccYn") == "y")
	{ 
		if($agspay->GetResult("AuthTy") == "virtual"){
			//가상계좌결제의 경우 입금이 완료되지 않은 입금대기상태(가상계좌 발급성공)이므로 상품을 배송하시면 안됩니다. 

		}else{
			$result = $payment_control->payment_status($agspay);
			$_pay_result = true;
			// 결제성공에 따른 상점처리부분
			//echo ("결제가 성공처리되었습니다. [" . $agspay->GetResult("rSuccYn")."]". $agspay->GetResult("rResMsg").". " );
		}
	}
	else
	{
		$update = sql_query("update alice_payment set `pg_un`='".base64_encode(serialize($agspay))."' where `no`='".addslashes($pno)."'");
		// 결제실패에 따른 상점처리부분
		//echo ("결제가 실패처리되었습니다. [" . $agspay->GetResult("rSuccYn")."]". $agspay->GetResult("rResMsg").". " );
	}
	

	/*******************************************************************
	* [6] 결제가 정상처리되지 못했을 경우 $agspay->GetResult("NetCancID") 값을 이용하여                                     
	* 결제결과에 대한 재확인요청을 할 수 있습니다.
	* 
	* 추가 데이터송수신이 발생하므로 결제가 정상처리되지 않았을 경우에만 사용하시기 바랍니다. 
	*
	* 사용방법 :
	* $agspay->checkPayResult($agspay->GetResult("NetCancID"));
	*                           
	*******************************************************************/
	
	/*
	$agspay->SetValue("Type", "Pay"); // 고정
	$agspay->checkPayResult($agspay->GetResult("NetCancID"));
	*/
	
	/*******************************************************************
	* [7] 상점DB 저장 및 기타 처리작업 수행실패시 강제취소                                      
	*   
	* $cancelReq : "true" 강제취소실행, "false" 강제취소실행안함.
	*
	* 결제결과에 따른 상점처리부분 수행 중 실패하는 경우    
	* 아래의 코드를 참조하여 거래를 취소할 수 있습니다.
	*	취소성공여부 : $agspay->GetResult("rCancelSuccYn") (성공:y 실패:n)
	*	취소결과메시지 : $agspay->GetResult("rCancelResMsg")
	*
	* 유의사항 :
	* 가상계좌(virtual)는 강제취소 기능이 지원되지 않습니다.
	*******************************************************************/
	
	// 상점처리부분 수행실패시 $cancelReq를 "true"로 변경하여 
	// 결제취소를 수행되도록 할 수 있습니다.
	// $cancelReq의 "true"값으로 변경조건은 상점에서 판단하셔야 합니다.
	
	/*
	$cancelReq = "false";

	if($cancelReq == "true")
	{
		$agspay->SetValue("Type", "Cancel"); // 고정
		$agspay->SetValue("CancelMsg", "DB FAIL"); // 취소사유
		$agspay->startPay();
	}
	*/
/*
?>
<html>
<head>
</head>
<body onload="javascript:frmAGS_pay_ing.submit();">
<form name=frmAGS_pay_ing method=post action=AGS_pay_result.php>

<!-- 각 결제 공통 사용 변수 -->
<input type=hidden name=AuthTy value="<?=$agspay->GetResult("AuthTy")?>">		<!-- 결제형태 -->
<input type=hidden name=SubTy value="<?=$agspay->GetResult("SubTy")?>">			<!-- 서브결제형태 -->
<input type=hidden name=rStoreId value="<?=$agspay->GetResult("rStoreId")?>">	<!-- 상점아이디 -->
<input type=hidden name=rOrdNo value="<?=$agspay->GetResult("rOrdNo")?>">		<!-- 주문번호 -->
<input type=hidden name=rProdNm value="<?=$agspay->GetResult("ProdNm")?>">		<!-- 상품명 -->
<input type=hidden name=rAmt value="<?=$agspay->GetResult("rAmt")?>">			<!-- 결제금액 -->
<input type=hidden name=rOrdNm value="<?=$agspay->GetResult("OrdNm")?>">		<!-- 주문자명 -->
<input type=hidden name=AGS_HASHDATA value="<?=$AGS_HASHDATA?>">				<!-- 암호화 HASHDATA -->

<input type=hidden name=rSuccYn value="<?=$agspay->GetResult("rSuccYn")?>">	<!-- 성공여부 -->
<input type=hidden name=rResMsg value="<?=$agspay->GetResult("rResMsg")?>">	<!-- 결과메시지 -->
<input type=hidden name=rApprTm value="<?=$agspay->GetResult("rApprTm")?>">	<!-- 결제시간 -->

<!-- 신용카드 결제 사용 변수 -->
<input type=hidden name=rBusiCd value="<?=$agspay->GetResult("rBusiCd")?>">		<!-- (신용카드공통)전문코드 -->
<input type=hidden name=rApprNo value="<?=$agspay->GetResult("rApprNo")?>">		<!-- (신용카드공통)승인번호 -->
<input type=hidden name=rCardCd value="<?=$agspay->GetResult("rCardCd")?>">	<!-- (신용카드공통)카드사코드 -->
<input type=hidden name=rDealNo value="<?=$agspay->GetResult("rDealNo")?>">			<!-- (신용카드공통)거래번호 -->

<input type=hidden name=rCardNm value="<?=$agspay->GetResult("rCardNm")?>">	<!-- (안심클릭,일반사용)카드사명 -->
<input type=hidden name=rMembNo value="<?=$agspay->GetResult("rMembNo")?>">	<!-- (안심클릭,일반사용)가맹점번호 -->
<input type=hidden name=rAquiCd value="<?=$agspay->GetResult("rAquiCd")?>">		<!-- (안심클릭,일반사용)매입사코드 -->
<input type=hidden name=rAquiNm value="<?=$agspay->GetResult("rAquiNm")?>">	<!-- (안심클릭,일반사용)매입사명 -->

<!-- 계좌이체 결제 사용 변수 -->
<input type=hidden name=ICHE_OUTBANKNAME value="<?=$agspay->GetResult("ICHE_OUTBANKNAME")?>">		<!-- 이체은행명 -->
<input type=hidden name=ICHE_OUTBANKMASTER value="<?=$agspay->GetResult("ICHE_OUTBANKMASTER")?>">	<!-- 이체계좌예금주 -->
<input type=hidden name=ICHE_AMOUNT value="<?=$agspay->GetResult("ICHE_AMOUNT")?>">					<!-- 이체금액 -->

<!-- 핸드폰 결제 사용 변수 -->
<input type=hidden name=rHP_HANDPHONE value="<?=$agspay->GetResult("HP_HANDPHONE")?>">		<!-- 핸드폰번호 -->
<input type=hidden name=rHP_COMPANY value="<?=$agspay->GetResult("HP_COMPANY")?>">			<!-- 통신사명(SKT,KTF,LGT) -->
<input type=hidden name=rHP_TID value="<?=$agspay->GetResult("rHP_TID")?>">					<!-- 결제TID -->
<input type=hidden name=rHP_DATE value="<?=$agspay->GetResult("rHP_DATE")?>">				<!-- 결제일자 -->

<!-- ARS 결제 사용 변수 -->
<input type=hidden name=rARS_PHONE value="<?=$agspay->GetResult("ARS_PHONE")?>">			<!-- ARS번호 -->

<!-- 가상계좌 결제 사용 변수 -->
<input type=hidden name=rVirNo value="<?=$agspay->GetResult("rVirNo")?>">					<!-- 가상계좌번호 -->
<input type=hidden name=VIRTUAL_CENTERCD value="<?=$agspay->GetResult("VIRTUAL_CENTERCD")?>">	<!--입금가상계좌은행코드(우리은행:20) -->

<!-- 에스크로 결제 사용 변수 -->
<input type=hidden name=ES_SENDNO value="<?=$agspay->GetResult("ES_SENDNO")?>">				<!-- 에스크로(전문번호) -->

</form>
</body> 
</html>
*/?>