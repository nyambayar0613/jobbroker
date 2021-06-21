<?php
$page_code = 'mypage';
include "../engine/db_start.php";
$netfu_payment = new netfu_payment();
$_type = $member['mb_type']=='individual' ? 'etc_alba' : 'etc_open';
$head_title = $menu_text = $netfu_payment->read_service_type[$_type].'열람 서비스';

$service_check = $service_control->service_check($_type);
$open_is_pay = $service_check['is_pay'];

if(!$open_is_pay) { 
	if($member['mb_type']=='individual') {
		echo "<script>javascript:alert('Энэ үйлчилгээг зөвхөн байгууллагын гишүүд ашиглах боломжтой. '); location.href='/';</script>";
	}else{
		echo "<script>javascript:alert('Энэ үйлчилгээг хувь хүн ашиглах боломжтой. '); location.href='/';</script>";
	}
}

include_once "../include/top.php";
$query = sql_query("select * from `alice_service` where `type` in ('".$_type."') order by `rank` asc");
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/payment.class.js?time=<?=time();?>"></script>
<form name="fpayment" action="./job_order.php" method="post">
<input type="hidden" name="mode" value="open_payment" />
<input type="hidden" name="pay_type" value="alba" />
<section class="item_con">
	<article>
		<h2><span><?=$netfu_payment->read_service_type[$_type];?>Унших</span></h2>
		<div class="item_box cf">
			<h3><?=$netfu_payment->read_service_type[$_type];?>Унших үйлчилгээ</h3>
			<ul>
				<li class="box-tit cf">
					<select name="service[]" onChange="netfu_payment.money_click(this)">
						<option value="">Сонгох</option>
						<?php
						while($row=sql_fetch_array($query)) {
							$_txt = $netfu_util->day_arr[$row['service_unit']];
						?>
						<option value="etc/<?=$row['no'];?>"><?=$row['service_cnt'].$_txt;?></option>
						<?php
						}
						?>
					</select>
				</li>
				<li class="box-info2 cf">
					<ul>
						<li class="item_info1 service_info1"></li>
						<li class="item_info2 service_info2"><li>
						<li class="item_info3 service_info3"></li>
						<li class="item_info4 service_info4"></li>
					</ul>
				</li>
			</ul>
		</div>
	</article>
</section>

<div class="button_con button_con4">
	<a href="#" class="bottom_btn04" onClick="netfu_payment.order_move('fpayment', 'all')">Хүсэлт гаргах<img src="<?=NFE_URL;?>/images/btn_arrow.png" alt="Үндсэн хуудас"></a>
</div>
</form>

<?php
include "../include/tail.php";
?>