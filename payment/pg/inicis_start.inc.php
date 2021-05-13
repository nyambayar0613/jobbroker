<?php
$src_head = $use_pg_service ? 'stg' : '';
?>
<script language="javascript" type="text/javascript" src="https://<?=$src_head;?>stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>
<script type="text/javascript">
function pay() {
	INIStdPay.pay('order_info');
}
</script>



<script type="text/javascript">
function ajax_process(data) {
	//create_goodInfo();
	var form = document.forms['order_info'];
	form.price.value = data.price;
	form.signature.value = data.sign;
	form.gopaymethod.value = data.method;
	form.merchantData.value = 'payment_process:'+data.pno;
	form.timestamp.value = data.timestamp;
	pay();
}
</script>
<?php
//############################################
// 1.전문 필드 값 설정(***가맹점 개발수정***)
//############################################
// 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
//인증  // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
$mid = $netfu_payment->use_pg['pg_id'];  // 가맹점 ID(가맹점 수정후 고정)					
$signKey = $netfu_payment->use_pg['pg_key'];

//$cardNoInterestQuota = "11-2:3:,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
//$cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
//
//###################################
// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
//###################################
$mKey = hash("sha256", $signKey);

/*
  //*** 위변조 방지체크를 signature 생성 [ ajax로 값 가져옴 ] ***
  oid, price, timestamp 3개의 키와 값을
  key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값
  ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004
 * key기준 알파벳 정렬
 * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그데로 사용하여야함
 */
//$params = "oid=" . $orderNumber . "&price=" . $price . "&timestamp=" . $timestamp;

/* 기타 */
$siteDomain = "http://".$_SERVER['HTTP_HOST']."/plugin/PG/inicis/INIStdPaySample"; //가맹점 도메인 입력
// 페이지 URL에서 고정된 부분을 적는다. 
// Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
//                 http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.
?>
<form name="order_info" action="<?=NFE_URL;?>/regist.php" method="post">
<!--version : --><input type="hidden" name="version" value="1.0" >
<!--mid :  --><input type="hidden"   name="mid" value="<?php echo $mid ?>" >
<!--상품명 :  --><input type="hidden"  name="goodname" value="<?=$__service_name;?>" >
<!--oid :  --><input type="hidden"   name="oid" value="<?=$_SESSION['__pay_order__'];?>" >
<!--price :  --><input  type="hidden"  name="price" value="" >
<!--currency :  --><input   type="hidden" name="currency" value="WON" >
<!--buyername :  --><input  type="hidden"  name="buyername" value="<?php echo $member['mb_name'];?>" >
<!--buyertel :  --><input  type="hidden"  name="buyertel" value="<?php echo $member['mb_hphone'];?>" >
<!--buyeremail :  --><input  type="hidden"  name="buyeremail" value="<?php echo $member['mb_email'];?>" >
<!--timestamp :  --><input  type="hidden" name="timestamp" value="" >
<!--signature :  --><input  type="hidden"  name="signature" value="" >
<!--returnUrl :  --><input  type="hidden"  name="returnUrl" value="http://<?=$_SERVER['HTTP_HOST'];?>/regist.php" >
<!--mKey :  --><input  type="hidden" name="mKey" value="<?php echo $mKey ?>" >

<!--***** 기본 옵션 *****-->
<!--결제 수단 선택-->
<!--gopaymethod : --><input  type="hidden"  name="gopaymethod" value="" >
<!--제공기간-->
<!--offerPeriod : --><input  type="hidden"  name="offerPeriod" value="<?=$good_expr;?>" >
<!--??-->
<!--acceptmethod : --><input  type="hidden" name="acceptmethod" value="HPP(1):no_receipt:va_receipt:vbanknoreg(0):below1000" >
<!--언어-->
<!--languageView : --><input  type="hidden" name="languageView" value="" >
<!--언어셋 [UTF-8|EUC-KR] (default:UTF-8)-->
<!--charset : --><input  type="hidden" name="charset" value="" >
<!--결제창 표시방법-->
<!--payViewType : --><input  type="hidden" name="payViewType" value="" >
<!--취소버튼 클릭시 창닥기 처리 URL-->
<!--closeUrl : --><input  type="hidden" name="closeUrl" value="<?php echo $siteDomain ?>/close.php" >
<!--팝업을 띄울수 있도록 처리해주는 URL(가맹점에 맞게 설정)-->
<!--popupUrl : --><input  type="hidden" name="popupUrl" value="<?php echo $siteDomain ?>/popup.php" >

<!--***** 결제 수단별 옵션 *****-->
<!--카드(간편결제도 사용) 무이자 할부 개월 ex) 11-2:3:4,04-2:3:4-->
<!--nointerest : --><input  type="hidden"  name="nointerest" value="<?php echo $cardNoInterestQuota ?>" >
<!--할부 개월 ex) 2:3:4-->
<!--quotabase : --><input  type="hidden"  name="quotabase" value="<?php echo $cardQuotaBase ?>" >
<!--가상계좌 / 주민번호 설정 기능 / 13자리(주민번호),10자리(사업자번호),미입력시(화면에서입력가능)-->
<!--vbankRegNo : --><input  type="hidden"  name="vbankRegNo" value="" >

<!--***** 추가 옵션 *****-->
<!--가맹점 관리데이터(2000byte) 인증결과 리턴시 함께 전달됨-->
<!--merchantData : --><input  type="hidden"  name="merchantData" value="payment_process:<?=$pay_no;?>" >
</form>