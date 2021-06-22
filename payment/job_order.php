<?php
include "../engine/db_start.php";
include_once '../engine/netfu_payment.class.php';
$netfu_payment = new netfu_payment();

$head_title = $netfu_payment->service_kind[$_POST['mode']]." Үйлчилгээний хүсэлт";

// : 이전에 선택한 주키값들 가져오기
if(is_array($_POST['service'])) { foreach($_POST['service'] as $k=>$v) {
	if(!$v) continue;
	$_service_arr[$k] = explode("/", $v);
	$_service_no_arr[$_service_arr[$k][0]][] = $_service_arr[$k][1];
} }

$page_code = 'mypage';
$_use_service = $netfu_payment->get_use_service();

$menu_text = $netfu_payment->service_kind[$_POST['mode']]." Үйлчилгээний хүсэлт";
include_once "../include/top.php";
$_SESSION['__pay_order__'] = $utility->getOrderNumber(10);
?>
<style type="text/css">
._none { display:none; }
</style>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/payment.class.js?time=<?=time();?>"></script>
<form name="forder" action="../regist.php" method="post">
<input type="hidden" name="mode" value="payment_start" />
<input type="hidden" name="p_mode" value="<?=addslashes($_POST['mode']);?>" />
<input type="hidden" name="info_no" value="<?=addslashes($_POST['info_no']);?>" />
<input type="hidden" name="pay_type" value="<?=addslashes($_POST['pay_type']);?>" />
<section class="cont_box service_con">
	<h2>Төлбөр хийх</h2>
	<ul>
	<?php
	// : 패키지 서비스 모음
	include NFE_PATH.'/payment/inc/package_payment.inc.php';

	// : 정보 서비스 [ 구인, 구직 ]
	include NFE_PATH.'/payment/inc/job_payment.inc.php';

	// : 옵션 - 아이콘~점프
	include NFE_PATH.'/payment/inc/option_payment.inc.php';

	// : 기타 서비스 - 열람, SMS
	include NFE_PATH.'/payment/inc/etc_payment.inc.php';
	?>
	</ul>
</section>



<?php
// : 신청상품 목록
include NFE_PATH.'/payment/inc/payment_list.inc.php';

// : 결제방법 폼
include NFE_PATH.'/payment/inc/payment_foot.inc.php';
?>


<script type="text/javascript">
var sel_se = '';
$("input[name='service[]']").each(function(){
	if($(this).val() && !sel_se) {
		sel_se = $(this);
	}
});
if(!sel_se) {
	$("select[name='service[]']").each(function(){
		if($(this).val() && !sel_se) {
			sel_se = $(this);
		}
	});
}
//var len = sel_se.length;
netfu_payment.money_click(sel_se[0]);
</script>

</form>

<?php
$__service_name = $netfu_payment->payment_service_name[$_POST['mode']];
if($_POST['mode']=='open_payment') $head_txt = ($_POST['pay_type']=='alba') ? 'Зар үзэх ' : 'Анкет ';
$__service_name = $head_txt.$__service_name;
include_once NFE_PATH.'/payment/use_pg.inc.php';
?>
<?php
include "../include/tail.php";
?>