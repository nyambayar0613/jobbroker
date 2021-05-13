<?php

//*******************************************************************************
// MD5 결제 데이터 암호화 처리
// 형태 : 상점아이디(StoreId) + 주문번호(OrdNo) + 결제금액(Amt)
//*******************************************************************************

$StoreId 	= "aegis";
$OrdNo 		= "1000000001";
$amt 		= "1000";

$AGS_HASHDATA = md5($StoreId . $OrdNo . $amt); 

?>

<html>
<head>
<title>올더게이트</title>
<style type="text/css">
<!--
body { font-family:"돋움"; font-size:9pt; color:#333333; font-weight:normal; letter-spacing:0pt; line-height:180%; }
td { font-family:"돋움"; font-size:9pt; color:#333333; font-weight:normal; letter-spacing:0pt; line-height:180%; }
.clsright { padding-right:10px; text-align:right; }
.clsleft { padding-left:10px; text-align:left; }
-->
</style>
<script language=javascript src="http://www.allthegate.com/plugin/AGSWallet_utf8.js"></script>
<!-- ※ UTF8 언어 형식으로 페이지 제작시 아래 경로의 js 파일을 사용할 것!! -->
<!-- script language=javascript src="http://www.allthegate.com/plugin/AGSWallet_utf8.js"></script -->
<!-- Euc-kr 이 아닌 다른 charset 을 이용할 경우에는 AGS_pay_ing(결제처리페이지) 상단의 
	[ AGS_pay.html 로 부터 넘겨받을 데이터파라미터 ] 선언부에서 파라미터 값들을 euc-kr로
	인코딩 변환을 해주시기 바랍니다.
<!-- ※ SSL 보안을 이용할 경우 아래 경로의 js 파일을 사용할 것!! -->
<!-- script language=javascript src="https://www.allthegate.com/plugin/AGSWallet_ssl.js"></script -->
<script>
var submits = function(){
	//var PayGateFrm = document.getElementById('PayGateFrm');
	//document.frmAGS_pay.submit();
	return Pay(frmAGS_pay);
}
</script>
<script language=javascript>
<!--
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 올더게이트 플러그인 설치를 확인합니다.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

StartSmartUpdate();  

function Pay(form){
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MakePayMessage() 가 호출되면 올더게이트 플러그인이 화면에 나타나며 Hidden 필드
	// 에 리턴값들이 채워지게 됩니다.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(form.Flag.value == "enable"){
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 입력된 데이타의 유효성을 검사합니다.
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		if(Check_Common(form) == true){
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			// 올더게이트 플러그인 설치가 올바르게 되었는지 확인합니다.
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if(document.AGSPay == null || document.AGSPay.object == null){
				alert("플러그인 설치 후 다시 시도 하십시오.");
			}else{
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// 올더게이트 플러그인 설정값을 동적으로 적용하기 JavaScript 코드를 사용하고 있습니다.
				// 상점설정에 맞게 JavaScript 코드를 수정하여 사용하십시오.
				//
				// [1] 일반/무이자 결제여부
				// [2] 일반결제시 할부개월수
				// [3] 무이자결제시 할부개월수 설정
				// [4] 인증여부
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [1] 일반/무이자 결제여부를 설정합니다.
				//
				// 할부판매의 경우 구매자가 이자수수료를 부담하는 것이 기본입니다. 그러나,
				// 상점과 올더게이트간의 별도 계약을 통해서 할부이자를 상점측에서 부담할 수 있습니다.
				// 이경우 구매자는 무이자 할부거래가 가능합니다.
				//
				// 예제)
				// 	(1) 일반결제로 사용할 경우
				// 	form.DeviId.value = "9000400001";
				//
				// 	(2) 무이자결제로 사용할 경우
				// 	form.DeviId.value = "9000400002";
				//
				// 	(3) 만약 결제 금액이 100,000원 미만일 경우 일반할부로 100,000원 이상일 경우 무이자할부로 사용할 경우
				// 	if(parseInt(form.Amt.value) < 100000)
				//		form.DeviId.value = "9000400001";
				// 	else
				//		form.DeviId.value = "9000400002";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				form.DeviId.value = "9000400001";
				
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [2] 일반 할부기간을 설정합니다.
				// 
				// 일반 할부기간은 2 ~ 12개월까지 가능합니다.
				// 0:일시불, 2:2개월, 3:3개월, ... , 12:12개월
				// 
				// 예제)
				// 	(1) 할부기간을 일시불만 가능하도록 사용할 경우
				// 	form.QuotaInf.value = "0";
				//
				// 	(2) 할부기간을 일시불 ~ 12개월까지 사용할 경우
				//		form.QuotaInf.value = "0:3:4:5:6:7:8:9:10:11:12";
				//
				// 	(3) 결제금액이 일정범위안에 있을 경우에만 할부가 가능하게 할 경우
				// 	if((parseInt(form.Amt.value) >= 100000) || (parseInt(form.Amt.value) <= 200000))
				// 		form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				// 	else
				// 		form.QuotaInf.value = "0";
				//////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				//결제금액이 5만원 미만건을 할부결제로 요청할경우 결제실패
				if(parseInt(form.Amt.value) < 50000)
					form.QuotaInf.value = "0";
				else
					form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
				
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// [3] 무이자 할부기간을 설정합니다.
				// (일반결제인 경우에는 본 설정은 적용되지 않습니다.)
				// 
				// 무이자 할부기간은 2 ~ 12개월까지 가능하며, 
				// 올더게이트에서 제한한 할부 개월수까지만 설정해야 합니다.
				// 
				// 100:BC
				// 200:국민
				// 201:NH 
				// 300:외환
				// 310:하나SK
				// 400:삼성
				// 500:신한
				// 800:현대
				// 900:롯데
				// 
				// 예제)
				// 	(1) 모든 할부거래를 무이자로 하고 싶을때에는 ALL로 설정
				// 	form.NointInf.value = "ALL";
				//
				// 	(2) 국민카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "200-2:3:4:5:6";
				//
				// 	(3) 외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "300-2:3:4:5:6";
				//
				// 	(4) 국민,외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
				// 	form.NointInf.value = "200-2:3:4:5:6,300-2:3:4:5:6";
				//	
				//	(5) 무이자 할부기간 설정을 하지 않을 경우에는 NONE로 설정
				//	form.NointInf.value = "NONE";
				//
				//	(6) 전카드사 특정개월수만 무이자를 하고 싶은경우(2:3:6개월)
				//	form.NointInf.value = "100-2:3:6,200-2:3:6,201-2:3:6,300-2:3:6,310-2:3:6,400-2:3:6,500-2:3:6,800-2:3:6,900-2:3:6";
				//
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				
				if(form.DeviId.value == "9000400002")
					form.NointInf.value = "ALL";
				   
				if(MakePayMessage(form) == true){										
					Disable_Flag(form);
					
					var openwin = window.open("AGS_progress.html","popup","width=300,height=160"); //"지불처리중"이라는 팝업창연결 부분
					
					form.submit();
				}else{
					alert("지불에 실패하였습니다.");// 취소시 이동페이지 설정부분
				}
			}
		}
	}
}

function Enable_Flag(form){
        form.Flag.value = "enable"
}

function Disable_Flag(form){
        form.Flag.value = "disable"
}

function Check_Common(form){
	if(form.StoreId.value == ""){
		alert("상점아이디를 입력하십시오.");
		return false;
	}
	else if(form.StoreNm.value == ""){
		alert("상점명을 입력하십시오.");
		return false;
	}
	else if(form.OrdNo.value == ""){
		alert("주문번호를 입력하십시오.");
		return false;
	}
	else if(form.ProdNm.value == ""){
		alert("상품명을 입력하십시오.");
		return false;
	}
	else if(form.Amt.value == ""){
		alert("금액을 입력하십시오.");
		return false;
	}
	else if(form.MallUrl.value == ""){
		alert("상점URL을 입력하십시오.");
		return false;
	}
	return true;
}

function Display(form){
	if(form.Job.value == "onlycard" || form.TempJob.value == "onlycard"){
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "none";
	}else if(form.Job.value == "onlyhp" || form.TempJob.value == "onlyhp"){
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "none";
		document.all.hp.style.display= "";
		document.all.virtual.style.display= "none";
	}else if(form.Job.value == "onlyvirtual" || form.TempJob.value == "onlyvirtual" ){
		document.all.card_hp.style.display= "none";
		document.all.card.style.display= "";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "";
	}else if(form.Job.value == "onlyiche" || form.TempJob.value == "onlyiche"  ){
		document.all.card_hp.style.display= "none";
		document.all.card.style.display= "none";
		document.all.hp.style.display= "none";
		document.all.virtual.style.display= "none";
	}else{
		document.all.card_hp.style.display= "";
		document.all.card.style.display= "";
		document.all.hp.style.display= "";
		document.all.virtual.style.display= "";
	}
}
-->
</script>
</head>
<!-- 주의) onload 이벤트에서 아래와 같이 javascript 함수를 호출하지 마십시오. -->
<!-- onload="javascript:Enable_Flag(frmAGS_pay);Pay(frmAGS_pay);" -->
<body topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0 onload="javascript:Enable_Flag(frmAGS_pay);">

<form name=frmAGS_pay method=post action=../AGS_pay_ing.php  id="PayGateFrm">
<table border=0 width=100% height=100% cellpadding=0 cellspacing=0>
	<tr>
		<td align=center>
		<table width=650 border=0 cellpadding=0 cellspacing=0>
			<tr><td>&nbsp;</td></tr>
			<tr><td><hr></td></tr>
			<tr><td class=clsleft><b>지불요청 테스트페이지</b></td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td class=clsleft>
				1) 본 지불요청 페이지를 상점에 맞게 적절하게 수정하여 사용하십시오.<br>
				2) 본 페이지에서는 올더게이트 플러그인을 다운로드하여 설치하도록 되어 있습니다. 다운로드후에  <font color=#006C6C>보안경고창이 뜨면 확인 버튼("예")을 선택하여</font> 플러그인을 설치해 주십시오. 만약 설치에 실패하였을 경우 수동으로 <a href="http://www.allthegate.com/plugin/AGSPayPluginV10.exe"><font color=#006C6C>다운로드</font></a>하여 설치해 주십시오.<br>
				3) 지불요청을 위해 필요한 정보를 모두 입력후 '지불요청'버튼을 클릭하시면 올더게이트 플러그인을 실행합니다.<br>
				4) 신용카드만 사용시 꼭 <font color=#006C6C>결제지불방법</font>을 <font color=#006C6C><b>신용카드(전용)</b></font>으로 설정해 주십시오.<br>
				5) DB 작업을 하실 경우 <font color=#006C6C>결제성공여부(rSuccYn)</font>을 확인후에 작업하여 주십시오.<br>
				6) 핸드폰 결제 사용시 올더게이트에서 발급받은[핸드폰결제아이디,비밀번호,상품코드,상품타입]을 입력하여 주십시오.<br>
				7) 데이터 입력시 <font color=#006C6C>"|"</font>는 올더게이트에서 구분자로 사용하는 문자이므로 입력하지 말아 주십시오.
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td class=clsleft>☞ 표시는 필수 입력사항입니다. </td></tr>
			<tr><td><hr></td></tr>
			<tr>
				<td>
				<table width=650 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td class=clsleft colspan=3><font color=#006C6C>+ 공통 사용 변수</font></td>
					</tr>
					<tr>
						<td width=170 class=clsleft>☞ 지불방법</td>
						<td width=300>
						<!-- 계좌이체,핸드폰결제를 사용하지 않는 상점은 지불방법을 꼭 신용카드(전용)으로 설정하시기 바랍니다. -->
						<!-- 신용카드만 사용하도록 연동 <input type=hidden name=Job value="onlycard"> -->
						<!-- 계좌이체만 사용하도록 연동 <input type=hidden name=Job value="onlyiche"> -->
						<!-- 핸드폰결제만 사용하도록 연동 <input type=hidden name=Job value="onlyhp"> -->
						<select name=Job style=width:150px><!-- onchange="javascript:Display(frmAGS_pay);" -->
							<option value="" selected>선택하십시오.
							<option value="card">신용카드
							<option value="iche">계좌이체
							<option value="virtual">가상계좌
							<option value="hp">핸드폰결제
							<option value="ars">ARS
							<option value="onlycard">신용카드 (전용)
							<option value="onlyiche">계좌이체 (전용)
							<option value="onlyvirtual">가상계좌 (전용)
							<option value="onlyhp">핸드폰결제 (전용)
							<option value="onlyars">ARS (전용)
							<option value="onlycardselfnormal">신용카드 (일반전용)
							<option value="onlycardselfescrow">신용카드 (에스크로전용)
							<option value="onlyicheselfnormal">계좌이체 (일반전용)
							<option value="onlyicheselfescrow">계좌이체 (에스크로전용)
							<option value="onlyvirtualselfnormal">가상계좌 (일반전용)
							<option value="onlyvirtualselfescrow">가상계좌 (에스크로전용)
							<option value="onlyichebanknormal">계좌이체/인터넷뱅킹 (일반전용)
							<option value="onlyichebankescrow">계좌이체/인터넷뱅킹 (에스크로전용)
							<option value="onlyichetelnormal">계좌이체/텔레뱅킹 (일반전용)
							<option value="onlyichetelescrow">계좌이체/텔레뱅킹 (에스크로전용)
						</select>
						</td>
						<td width=180></td>
					</tr>
					<tr>
						<td class=clsleft>지불방법 직접입력 </td>
						<td><input type=text style=width:100px name=TempJob maxlength=20 value=""></td>
						<td class=clsleft width=180>예) card:iche</td>
					</tr>
					<tr>
						<td class=clsleft >☞ 상점아이디 (20)</td>
						<!--상점아이디를 실거래 전환후에는 발급받은 아이디로 바꾸시기 바랍니다.-->
						<td colspan=2><input type=text style=width:100px name=StoreId maxlength=20 value="aegis"></td>
					</tr>
					<tr>
						<td class=clsleft>☞ 주문번호 (40)</td>
						<td colspan=2><input type=text style=width:100px name=OrdNo maxlength=40 value="1000000001"></td>
					</tr>
					<tr>
						<td class=clsleft>☞ 금액 (12)</td>
						<td><input type=text style=width:100px name=Amt maxlength=12 value="1000">원</td>
						<td class=clsleft>예) 금액 콤마(,)입력불가</td>
					</tr>
					<tr>
						<td class=clsleft>☞ 상점명 (50)</td>
						<td colspan=2><input type=text style=width:300px name=StoreNm value="컴퓨터가게"></td>
					</tr>
					<tr>
						<td class=clsleft>☞ 상품명 (300)</td>
						<td colspan=2><input type=text style=width:300px name=ProdNm maxlength=300 value="마우스"></td>
					</tr>
					<tr>
						<td class=clsleft>☞ 상점URL (50)</td>
						<!-- 주의) 상점홈페이지주소를 반드시 입력해 주십시오. -->
						<!-- (미입력시 특정 카드사 신용카드 결제 및 가상계좌 결제가 이뤄지지 않을 수 있습니다.) -->
						<td><input type=text style=width:300px name=MallUrl value="http://www.allthegate.com"></td>
						<td class=clsleft>예) http://www.abc.com</td>
					</tr>
					<tr>
						<td class=clsleft>주문자이메일 (50)</td>
						<td colspan=2><input type=text style=width:300px name=UserEmail maxlength=50 value="test@test.com"></td>
					</tr>
					<tr>
						<!-- 결제창 좌측상단에 상점의 로고이미지(85 * 38)를 표시할 수 있습니다. -->
						<!-- 잘못된 값을 입력하거나 미입력시 이지스올더게이트의 로고가 표시됩니다. -->
						<td class=clsleft>상점로고이미지 URL</td>
						<td colspan=2><input type=text style=width:400px name=ags_logoimg_url maxlength=200 value="http://www.allthegate.com/hyosung/images/aegis_logo.gif"></td>
					</tr>
					<tr>
						<td class=clsleft>결제창제목입력</td>
						<!-- 제목은 1컨텐츠당 5자 이내이며, 상점명;상품명;결제금액;제공기간; 순으로 입력해 주셔야 합니다. -->
						<!-- 입력 예)업체명;판매상품;계산금액;제공기간; -->
						<td><!-- <input type=text style=width:300px name=SubjectData value="업체명;판매상품;계산금액;2012.09.01 ~ 2012.09.30;"> --></td>
						<td width=170 class=clsleft>예)업체명;판매상품;계산금액;제공기간;</td>
					</tr>
				</table>
				<div id="card_hp" style="display:'';"> 
				<table width=650 border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td width=156 class=clsleft>회원아이디 (20)</td>
						<!-- [신용카드, 핸드폰] 결제와 [현금영수증자동발행]을 사용하시는 경우에 반드시 입력해 주시기 바랍니다. -->
						<td colspan=2><input type=text style=width:100px name=UserId maxlength=20 value="test"></td>
					</tr>
				</table>
				</div>
				<div id="card" style="display:'';"> 
				<table width=650 border=0 cellpadding=0 cellspacing=0>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td class=clsleft colspan=3><font color=#006C6C>+ 카드 & 가상계좌 결제 사용 변수</font></td>
					</tr>
					<tr>
						<td width=160 class=clsleft>주문자명 (40)</td>
						<td width=300><input type=text style=width:100px name=OrdNm maxlength=40 value="홍길동"></td>
						<td width=190></td>
					</tr>
					<tr>
						<td class=clsleft>주문자연락처 (21)</td>
						<td colspan=2><input type=text style=width:100px name=OrdPhone maxlength=21 value="02-111-1111"></td>
					</tr>
               		<tr>
						<td class=clsleft>주문자주소 (100)</td><!-- 가상계좌추가 -->
						<td colspan=2><input type=text style=width:300px name=OrdAddr maxlength=100 value="서울시 강남구 청담동"></td>
					</tr>
					<tr>
						<td class=clsleft>수신자명 (40)</td>
						<td colspan=2><input type=text style=width:100px name=RcpNm maxlength=40 value="김길동"></td>
					</tr>
					<tr>
						<td class=clsleft>수신자연락처 (21)</td>
						<td colspan=2><input type=text style=width:100px name=RcpPhone maxlength=21 value="02-111-1111"></td>
					</tr>
					<tr>
						<td class=clsleft>배송지주소 (100)</td>
						<td colspan=2><input type=text style=width:300px name=DlvAddr maxlength=100 value="서울시 강남구 청담동"></td>
					</tr>
					<tr>
						<td class=clsleft>기타요구사항 (350)</td>
						<td colspan=2><input type=text style=width:300px name=Remark maxlength=350 value="오후에 배송요망"></td>
					</tr>
					 <tr>
						<td class=clsleft>카드사선택</td>
						<td colspan=2><input type=text style=width:300px name=CardSelect value=""></td>
						<!-- 결제창에 특정카드만 표기기능입니다. 
						          사용방법 예)  BC, 국민을 사용하고자 하는 경우 ☞ 100:200
											    국민 만 사용하고자 하는 경우 ☞ 200
							 모두 사용하고자 할 때에는 아무 값도 입력하지 않습니다.
							 카드사별 코드는 매뉴얼에서 확인해 주시기 바랍니다. -->
			  </tr>
				</table>
				</div>
				<div id="hp" style="display:'';"> 
				<table width=650 border=0 cellpadding=0 cellspacing=0>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td class=clsleft colspan=3><font color=#006C6C>+ 핸드폰 결제 사용 변수</font></td>
					</tr>
					<tr>
						<td width=158 class=clsleft>CP아이디 (10)</td>
						<!-- CP아이디를 핸드폰 결제 실거래 전환후에는 발급받으신 CPID로 변경하여 주시기 바랍니다. -->
						<td width=300><input type=text style=width:100px name=HP_ID maxlength=10 value=""></td>
						<td width=192></td>
					</tr>
					<tr>
						<td class=clsleft>CP비밀번호 (10)</td>
						<!-- CP비밀번호를 핸드폰 결제 실거래 전환후에는 발급받으신 비밀번호로 변경하여 주시기 바랍니다. -->
						<td colspan=2><input type=text style=width:100px name=HP_PWD maxlength=10 value=""></td>
					</tr>
					<tr>
						<td class=clsleft>SUB-CP아이디 (10)</td>
						<!-- SUB-CPID는 핸드폰 결제 실거래 전환후에 발급받으신 상점만 입력하여 주시기 바랍니다. -->
						<td colspan=2><input type=text style=width:100px name=HP_SUBID maxlength=10 value=""></td>
					</tr>
					<tr>
						<td class=clsleft>상품코드 (10)</td>
						<!-- 상품코드를 핸드폰 결제 실거래 전환후에는 발급받으신 상품코드로 변경하여 주시기 바랍니다. -->
						<td colspan=2><input type=text style=width:100px name=ProdCode maxlength=10 value=""></td>
					</tr>
					<tr>
						<td class=clsleft>상품종류</td>
						<td colspan=2>
						<!-- 상품종류를 핸드폰 결제 실거래 전환후에는 발급받으신 상품종류로 변경하여 주시기 바랍니다. -->
						<!-- 판매하는 상품이 디지털(컨텐츠)일 경우 = 1, 실물(상품)일 경우 = 2 -->
						<select name=HP_UNITType style=width:100px>
							<option value="1">디지털:1
							<option value="2">실물:2
						</select>
						</td>
					</tr>
				</table>
				</div>
				<div id="virtual" style="display:'';"> 
				<table width=650 border=0 cellpadding=0 cellspacing=0>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td class=clsleft colspan=3><font color=#006C6C>+ 가상계좌 결제 사용 변수</font></td>
					</tr>
               		<tr>
						<td width=180 class=clsleft>통보페이지 (100)</td>
						<!-- 가상계좌 결제에서 입/출금 통보를 위한 필수 입력 사항 입니다. -->
						<!-- 페이지주소는 도메인주소를 제외한 '/'이후 주소를 적어주시면 됩니다. -->
						<td width=300><input type=text style=width:300px name=MallPage value="/mall/AGS_VirAcctResult.php"></td>
						<td width=170 class=clsleft>예) /ab/AGS_VirAcctResult.jsp</td>
					</tr>
					<tr>
						<td width=180 class=clsleft>가상계좌 입금예정일 (8)</td>
						<!-- 가상계좌 결제에서 입금가능한 기한을 지정하는 기능입니다. -->
						<!-- 발급일자로부터 최대 15일 이내로만 설정하셔야 합니다. -->
						<!-- 값을 입력하지 않을 경우, 자동으로 발급일자로부터 5일 이후로 설정됩니다. -->
						<td width=300><input type=text style=width:300px name=VIRTUAL_DEPODT value=""></td>
						<td width=170 class=clsleft>예) 20100120</td>
					</tr>
				</table>
				</div>
				</td>
			</tr>
			<tr><td><hr></td></tr>
			<tr>
				<td align=center>
				<input type="button" value="지불요청" onclick="javascript:submits();">
				<!--
				<a href="javascript:Pay(frmAGS_pay);"><img src="button.gif" border="0"></a>
				-->
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
		</table>
		</td>
	</tr>
</table>




<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->

<!-- 각 결제 공통 사용 변수 -->
<input type=hidden name=Flag value="">				<!-- 스크립트결제사용구분플래그 -->
<input type=hidden name=AuthTy value="">			<!-- 결제형태 -->
<input type=hidden name=SubTy value="">				<!-- 서브결제형태 -->
<input type=hidden name=AGS_HASHDATA value="<?=$AGS_HASHDATA?>">	<!-- 암호화 HASHDATA -->

<!-- 신용카드 결제 사용 변수 -->
<input type=hidden name=DeviId value="">			<!-- (신용카드공통)		단말기아이디 -->
<input type=hidden name=QuotaInf value="0">			<!-- (신용카드공통)		일반할부개월설정변수 -->
<input type=hidden name=NointInf value="NONE">		<!-- (신용카드공통)		무이자할부개월설정변수 -->
<input type=hidden name=AuthYn value="">			<!-- (신용카드공통)		인증여부 -->
<input type=hidden name=Instmt value="">			<!-- (신용카드공통)		할부개월수 -->
<input type=hidden name=partial_mm value="">		<!-- (ISP사용)			일반할부기간 -->
<input type=hidden name=noIntMonth value="">		<!-- (ISP사용)			무이자할부기간 -->
<input type=hidden name=KVP_RESERVED1 value="">		<!-- (ISP사용)			RESERVED1 -->
<input type=hidden name=KVP_RESERVED2 value="">		<!-- (ISP사용)			RESERVED2 -->
<input type=hidden name=KVP_RESERVED3 value="">		<!-- (ISP사용)			RESERVED3 -->
<input type=hidden name=KVP_CURRENCY value="">		<!-- (ISP사용)			통화코드 -->
<input type=hidden name=KVP_CARDCODE value="">		<!-- (ISP사용)			카드사코드 -->
<input type=hidden name=KVP_SESSIONKEY value="">	<!-- (ISP사용)			암호화코드 -->
<input type=hidden name=KVP_ENCDATA value="">		<!-- (ISP사용)			암호화코드 -->
<input type=hidden name=KVP_CONAME value="">		<!-- (ISP사용)			카드명 -->
<input type=hidden name=KVP_NOINT value="">			<!-- (ISP사용)			무이자/일반여부(무이자=1, 일반=0) -->
<input type=hidden name=KVP_QUOTA value="">			<!-- (ISP사용)			할부개월 -->
<input type=hidden name=CardNo value="">			<!-- (안심클릭,일반사용)	카드번호 -->
<input type=hidden name=MPI_CAVV value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=MPI_ECI value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=MPI_MD64 value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=ExpMon value="">			<!-- (일반사용)			유효기간(월) -->
<input type=hidden name=ExpYear value="">			<!-- (일반사용)			유효기간(년) -->
<input type=hidden name=Passwd value="">			<!-- (일반사용)			비밀번호 -->
<input type=hidden name=SocId value="">				<!-- (일반사용)			주민등록번호/사업자등록번호 -->

<!-- 계좌이체 결제 사용 변수 -->
<input type=hidden name=ICHE_OUTBANKNAME value="">	<!-- 이체계좌은행명 -->
<input type=hidden name=ICHE_OUTACCTNO value="">	<!-- 이체계좌예금주주민번호 -->
<input type=hidden name=ICHE_OUTBANKMASTER value=""><!-- 이체계좌예금주 -->
<input type=hidden name=ICHE_AMOUNT value="">		<!-- 이체금액 -->

<!-- 핸드폰 결제 사용 변수 -->
<input type=hidden name=HP_SERVERINFO value="">		<!-- 서버정보 -->
<input type=hidden name=HP_HANDPHONE value="">		<!-- 핸드폰번호 -->
<input type=hidden name=HP_COMPANY value="">		<!-- 통신사명(SKT,KTF,LGT) -->
<input type=hidden name=HP_IDEN value="">			<!-- 인증시사용 -->
<input type=hidden name=HP_IPADDR value="">			<!-- 아이피정보 -->

<!-- ARS 결제 사용 변수 -->
<input type=hidden name=ARS_PHONE value="">			<!-- ARS번호 -->
<input type=hidden name=ARS_NAME value="">			<!-- 전화가입자명 -->

<!-- 가상계좌 결제 사용 변수 -->
<input type=hidden name=ZuminCode value="">			<!-- 가상계좌입금자주민번호 -->
<input type=hidden name=VIRTUAL_CENTERCD value="">	<!-- 가상계좌은행코드 -->
<input type=hidden name=VIRTUAL_NO value="">		<!-- 가상계좌번호 -->

<input type=hidden name=mTId value="">	

<!-- 에스크로 결제 사용 변수 -->
<input type=hidden name=ES_SENDNO value="">			<!-- 에스크로전문번호 -->

<!-- 계좌이체(소켓) 결제 사용 변수 -->
<input type=hidden name=ICHE_SOCKETYN value="">		<!-- 계좌이체(소켓) 사용 여부 -->
<input type=hidden name=ICHE_POSMTID value="">		<!-- 계좌이체(소켓) 이용기관주문번호 -->
<input type=hidden name=ICHE_FNBCMTID value="">		<!-- 계좌이체(소켓) FNBC거래번호 -->
<input type=hidden name=ICHE_APTRTS value="">		<!-- 계좌이체(소켓) 이체 시각 -->
<input type=hidden name=ICHE_REMARK1 value="">		<!-- 계좌이체(소켓) 기타사항1 -->
<input type=hidden name=ICHE_REMARK2 value="">		<!-- 계좌이체(소켓) 기타사항2 -->
<input type=hidden name=ICHE_ECWYN value="">		<!-- 계좌이체(소켓) 에스크로여부 -->
<input type=hidden name=ICHE_ECWID value="">		<!-- 계좌이체(소켓) 에스크로ID -->
<input type=hidden name=ICHE_ECWAMT1 value="">		<!-- 계좌이체(소켓) 에스크로결제금액1 -->
<input type=hidden name=ICHE_ECWAMT2 value="">		<!-- 계좌이체(소켓) 에스크로결제금액2 -->
<input type=hidden name=ICHE_CASHYN value="">		<!-- 계좌이체(소켓) 현금영수증발행여부 -->
<input type=hidden name=ICHE_CASHGUBUN_CD value="">	<!-- 계좌이체(소켓) 현금영수증구분 -->
<input type=hidden name=ICHE_CASHID_NO value="">	<!-- 계좌이체(소켓) 현금영수증신분확인번호 -->

<!-- 텔래뱅킹-계좌이체(소켓) 결제 사용 변수 -->
<input type=hidden name=ICHEARS_SOCKETYN value="">	<!-- 텔레뱅킹계좌이체(소켓) 사용 여부 -->
<input type=hidden name=ICHEARS_ADMNO value="">		<!-- 텔레뱅킹계좌이체 승인번호 -->
<input type=hidden name=ICHEARS_POSMTID value="">	<!-- 텔레뱅킹계좌이체 이용기관주문번호 -->
<input type=hidden name=ICHEARS_CENTERCD value="">	<!-- 텔레뱅킹계좌이체 은행코드 -->
<input type=hidden name=ICHEARS_HPNO value="">		<!-- 텔레뱅킹계좌이체 휴대폰번호 -->

<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->

</form>
</body>
</html> 