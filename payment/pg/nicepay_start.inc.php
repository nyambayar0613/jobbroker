<?php
/*
*******************************************************
* <결제요청 파라미터>
* 결제시 Form 에 보내는 결제요청 파라미터입니다.
* 샘플페이지에서는 기본(필수) 파라미터만 예시되어 있으며, 
* 추가 가능한 옵션 파라미터는 연동메뉴얼을 참고하세요.
*******************************************************
*/
$merchantKey      = $netfu_payment->use_pg['pg_key'];   // 상점키
$merchantID       = $netfu_payment->use_pg['pg_id'];                           // 상점아이디
$goodsCnt         = "1";                                    // 결제상품개수
$goodsName        = $__service_name;                           // 결제상품명
$price            = "1004";                                 // 결제상품금액	
$buyerName        = "나이스";                               // 구매자명
$buyerTel         = "01000000000";                          // 구매자연락처
$buyerEmail       = "happy@day.co.kr";                      // 구매자메일주소
$moid             = "mnoid1234567890";                      // 상품주문번호

/*
*******************************************************
* <해쉬암호화> (수정하지 마세요)
* SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
*******************************************************
*/ 
$ediDate = date("YmdHis");

/*
******************************************************* 
* <서버 IP값>
*******************************************************
*/
$ip = $_SERVER['REMOTE_ADDR'];    
?>
<link rel="stylesheet" type="text/css" href="<?=NFE_URL;?>/plugin/PG/nicepay/pc/css/import.css"/>
<script src="https://web.nicepay.co.kr/flex/js/nicepay_tr_utf.js" type="text/javascript"></script>
<script type="text/javascript">
//결제창 최초 요청시 실행됩니다.
function nicepayStart(){
    document.getElementById("vExp").value = getTomorrow();
    goPay(document.payForm);
}

//결제 최종 요청시 실행됩니다. <<'nicepaySubmit()' 이름 수정 불가능>>
function nicepaySubmit(){
    document.payForm.submit();
}

//결제창 종료 함수 <<'nicepayClose()' 이름 수정 불가능>>
function nicepayClose(){
    alert("결제가 취소 되었습니다");
}

//가상계좌입금만료일 설정 (today +1)
function getTomorrow(){
    var today = new Date();
    var yyyy = today.getFullYear().toString();
    var mm = (today.getMonth()+1).toString();
    var dd = (today.getDate()+1).toString();
    if(mm.length < 2){mm = '0' + mm;}
    if(dd.length < 2){dd = '0' + dd;}
    return (yyyy + mm + dd);
}

  var ajax_process = function(data) {
		var form = document.forms['payForm'];
		form.Amt.value = data.price;
		form.PayMethod.value = data.method;
		form.no.value = data.pno;
		form.EdiDate.value = data.EdiDate;
		form.EncryptData.value = data.hash;
		nicepayStart();
	}
</script>

<form name="payForm" method="post" action="<?=NFE_URL;?>/regist.php">
<input type="hidden" name="mode" value="payment_process" />
<input type="hidden" name="no" value="" />
<input type="hidden" name="PayMethod" value="" title="Төлбөр хийх төрөл" />
<input type="hidden" name="GoodsName" value="<?=$__service_name;?>" title="Төлбөрийн бүтээгдэхүүний нэр" />
<input type="hidden" name="GoodsCnt" value="<?=$goodsCnt;?>" title="Төлбөрийн бүтээгдэхүүний тоо" />
<input type="hidden" name="Amt" value="" title="Төлбөрийн бүтээгдэхүүний хэмжээ" />
<input type="hidden" name="BuyerName" value="<?=$member['mb_name'];?>" title="Худалдан авагчийн нэр" />
<input type="hidden" name="BuyerTel" value="<?=$member['mb_hphone'];?>" title="Холбоо барих" />
<input type="hidden" name="Moid" value="<?=$_SESSION['__pay_order__'];?>" title="Бүтээгдэхүүний захиалгын дугаар" />
<input type="hidden" name="MID" value="<?=$merchantID;?>" title="Нэгжийн ID" />
<input type="hidden" name="UserIP" value="<?=$ip?>" title="Гишүүний IP" />

<!-- 옵션 -->
<input type="hidden" name="VbankExpDate" id="vExp" value="" title="Виртуал дансны хугацаа дуусах огноо" />
<input type="hidden" name="BuyerEmail" value="<?=$member['mb_email'];?>" title="Худалдан авагчийн и-мэйл" />
<input type="hidden" name="TransType" value="0" title="Энгийн(0)/Эскроу(1)" />
<input type="hidden" name="GoodsCl" value="0" title="Бүтээгдэхүүний ангилал(real(1),contents(0))" />

 <!-- 변경 불가능 -->
<input type="hidden" name="EncodeParameters" value="" title="Encode утга" />
<input type="hidden" name="EdiDate" value="" title="Professional creation date" />
<input type="hidden" name="EncryptData" value="" title="hash утга" />
<input type="hidden" name="TrKey" value="asfsafasd" title="Field л шаардлагатай />
</form>