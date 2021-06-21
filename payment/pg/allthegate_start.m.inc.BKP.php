<?
    ///////////////////////////////////////////////////////
    //
    // 금액 위변조를 막기 위해, 
    // 가격 정보 (Amt) 의 경우 JavaScript로 변경할 수 없습니다.
    // 반드시 ServerScript(asp,php,jsp)에서 가격정보를 세팅한 후 Form에 입력하여 주세요.
    //
    ///////////////////////////////////////////////////////
    
        
    //올더게이트
    $strAegis = "https://www.allthegate.com";
    $strCsrf = "csrf.real.js";
    
?>
<script type="text/javascript" charset="utf-8" src="<?=$strAegis?>/payment/mobilev2/csrf/<?=$strCsrf?>"></script>
<script type="text/javascript" charset="utf-8">

    function doPay(form) {
        
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////        
        //
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
        //  (1) 일반결제로 사용할 경우
        //  form.DeviId.value = "9000400001";
        //
        //  (2) 무이자결제로 사용할 경우
        //  form.DeviId.value = "9000400002";
        //
        //  (3) 만약 결제 금액이 100,000원 미만일 경우 일반할부로 100,000원 이상일 경우 무이자할부로 사용할 경우
        //  if(parseInt(form.Amt.value) < 100000)
        //      form.DeviId.value = "9000400001";
        //  else
        //      form.DeviId.value = "9000400002";
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // [2] 일반 할부기간을 설정합니다.
        // 
        // 일반 할부기간은 2 ~ 12개월까지 가능합니다.
        // 0:일시불, 2:2개월, 3:3개월, ... , 12:12개월
        // 
        // 예제)
        //  (1) 할부기간을 일시불만 가능하도록 사용할 경우
        //  form.QuotaInf.value = "0";
        //
        //  (2) 할부기간을 일시불 ~ 12개월까지 사용할 경우
        //      form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
        //
        //  (3) 결제금액이 일정범위안에 있을 경우에만 할부가 가능하게 할 경우
        //  if((parseInt(form.Amt.value) >= 100000) || (parseInt(form.Amt.value) <= 200000))
        //      form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
        //  else
        //      form.QuotaInf.value = "0";
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        //결제금액이 5만원 미만건을 할부결제로 요청할경우 일시불로 결제
        if(parseInt(form.Amt.value) < 50000)
            form.QuotaInf.value = "0";
        else {
            form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
        }
        
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // [3] 무이자 할부기간을 설정합니다.
        // (일반결제인 경우에는 본 설정은 적용되지 않습니다.)
        // 
        // 무이자 할부기간은 2 ~ 12개월까지 가능하며, 
        // 올더게이트에서 제한한 할부 개월수까지만 설정해야 합니다.
        // 
        // 100:BC
        // 200:국민
        // 300:외환
        // 400:삼성
        // 500:신한
        // 800:현대
        // 900:롯데
        // 
        // 예제)
        //  (1) 모든 할부거래를 무이자로 하고 싶을때에는 ALL로 설정
        //  form.NointInf.value = "ALL";
        //
        //  (2) 국민카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
        //  form.NointInf.value = "200-2:3:4:5:6";
        //
        //  (3) 외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
        //  form.NointInf.value = "300-2:3:4:5:6";
        //
        //  (4) 국민,외환카드 특정개월수만 무이자를 하고 싶을경우 샘플(2:3:4:5:6개월)
        //  form.NointInf.value = "200-2:3:4:5:6,300-2:3:4:5:6";
        //  
        //  (5) 무이자 할부기간 설정을 하지 않을 경우에는 NONE로 설정
        //  form.NointInf.value = "NONE";
        //
        //  (6) 전카드사 특정개월수만 무이자를 하고 싶은경우(2:3:6개월)
        //  form.NointInf.value = "100-2:3:6,200-2:3:6,300-2:3:6,400-2:3:6,500-2:3:6,600-2:3:6,800-2:3:6,900-2:3:6";
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//	모든 할부거래를 무이자
		if(form.DeviId.value == "9000400002") {
			form.NointInf.value = "ALL";
		}
        
        AllTheGate.pay(form);
        return false;
    }



	function ajax_process(data) {
		var form = document.forms['frmAGS_pay'];
		form.Amt.value = data.price;
		form.Job.value = data.method;
		form.Column2.value = data.pno;
		form.SubjectData.value = data.SubjectData;
		doPay(document.forms['frmAGS_pay']);
	}
</script>





<form name="frmAGS_pay" action="<?=$strAegis;?>/payment/mobilev2/intro.jsp" method="post">
<?php
//*******************************************************************************
// MD5 결제 데이터 암호화 처리
// 형태 : 상점아이디(StoreId) + 주문번호(OrdNo) + 결제금액(Amt)
//*******************************************************************************
$StoreId = $netfu_payment->use_pg['pg_id'];

$OrdNo = $_SESSION['__pay_order__'];

$dutyfree = 0; //면세 금액 (amt 중 면세 금액 설정)

//올더게이트
$strAegis = "https://www.allthegate.com";
$strCsrf = "csrf.real.js";

?>
<input type="hidden"  name="Column1" maxlength="200" value="payment_process">
<input type="hidden"  name="Column2" maxlength="200" value="">
<input type="hidden"  name="Column3" maxlength="200" value="" title="추가사용필드3">


<input type="hidden" name="OrdNo" value="<?php echo $OrdNo;?>" title="주문번호"/>
<input type="hidden" name="ProdNm"  value="<?=$__service_name;?>" title="상품명"/>
<input type="hidden" name="Amt" value="" title="가격"/>
<input type="hidden" name="DutyFree" value="<?=$dutyfree?>" title="면세금액"/>
<input type="hidden" name="OrdNm"  value="<?php echo $member['mb_name'];?>" title="구매자이름"/>
<input type="hidden" name="StoreNm"  value="<?php echo $env['site_title'];?>" title="상점이름"/>
<input type="hidden" name="OrdPhone"  value="<?php echo $member['mb_hphone'];?>" title="휴대폰번호"/>
<input type="hidden" name="UserEmail"  value="<?php echo $member['mb_email'];?>" title="이메일"/>
<?php
/*
<option value="card">신용카드</option>
<option value="cardnormal">신용카드만</option>
<option value="cardescrow">신용카드(에스크로)</option>
<option value="virtual">가상계좌</option>
<option value="virtualnormal">가상계좌만</option>
<option value="virtualescrow">가상계좌(에스크로)</option>
<option value="hp">휴대폰</option>
*/
?>
<input type="hidden" name="Job"  value="" title="결제방법"/>
<input type="hidden" name="StoreId" maxlength="20" value="<?php echo $StoreId;?>" title="상점아이디"/>
<input type="hidden"  name="MallUrl" value="http://<?php echo $_SERVER['HTTP_HOST'];?>" title="상점URL"/>
<input type="hidden"  name="UserId" maxlength="20" value="<?php echo $member['mb_id'];?>" title="회원아이디">
<input type="hidden"  name="OrdAddr" value="<?=$member['mb_address0'];?>" title="주문자주소">
<input type="hidden"  name="RcpNm" value="<?php echo $member['mb_name'];?>" title="수신자명">
<input type="hidden"  name="RcpPhone" value="<?php echo $member['mb_hphone'];?>" title="수신자연락처">
<input type="hidden"  name="DlvAddr" value="" title="배송지주소">
<input type="hidden"  name="Remark" value="" title="기타요구사항">
<input type="hidden"  name="CardSelect"  value="" title="특정카드사선택">
<input type="hidden"  name="RtnUrl" value="http://<?=$_SERVER['HTTP_HOST'];?>/regist.php?mode=payment_process" title="성공URL">
<input type="hidden"  name="CancelUrl" value="http://<?=$_SERVER['HTTP_HOST'];?>/plugin/PG/allthegate/mobile/AGSMobile_user_cancel.php" title="취소URL">
<input type="hidden" name="MallPage" maxlength="100" value="" title="통보페이지">
<input type="hidden" name="VIRTUAL_DEPODT" maxlength=8 value="<?=date("Y-m-d", strtotime("3 day"));?>" title="입금예정일">
<input type="hidden" name="HP_ID" maxlength="10" value="<?php echo $netfu_payment->use_pg['pg_cpid'];?>" title="CP아이디">
<input type="hidden" name="HP_PWD" maxlength="10" value="<?php echo $netfu_payment->use_pg['pg_code'];?>" title="CP비밀번호">
<input type="hidden" name="HP_SUBID" maxlength="10" value="<?php echo $netfu_payment->use_pg['pg_subcp'];?>" title="SUB-CP아이디">
<input type="hidden" name="ProdCode" maxlength="10" value="<?php echo $netfu_payment->use_pg['pg_code'];?>" title="상품코드">

<?
/*
<option value="1">디지털:1
<option value="2">실물:2
*/
?>
<input type="hidden" name="HP_UNITType" maxlength="10" value="1" title="상품종류">
<input type="hidden" name="SubjectData" value="" title="상품제공기간">

<input type="hidden" name="DeviId" value="9000400001">            
<input type="hidden" name="QuotaInf" value="0">         
<input type="hidden" name="NointInf" value="NONE">



<?php
/*
네이버 예시 :  naversearchapp://inappbrowser?url=
AppRtnScheme + RtnUrl을 합친 값으로 다시 앱을 호출합니다.<br/>
독자앱이 아닌경우 빈값으로 세팅
*/

$app_val = '';
if(strpos($_SERVER['HTTP_USER_AGENT'], "NAVER(inapp")!==false) $app_val = 'naversearchapp://inappbrowser?url=';
?>
<input type="hidden"  name="AppRtnScheme" value="<?=$app_val;?>" title="독자앱일경우">



<?
//
?>
</form>