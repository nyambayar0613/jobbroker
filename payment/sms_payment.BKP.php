<?php
$page_code = 'mypage';
$menu_text = "기업회원 서비스 신청";
include_once "../include/top.php";

$query = sql_query("select * from `alice_service` where `type` in ('etc_sms') order by `rank` asc");
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/payment.class.js?time=<?=time();?>"></script>
<!-- 서비스 신청 -->
<form name="fpayment" action="./job_order.php" method="post">
<input type="hidden" name="mode" value="sms_payment" />
<input type="hidden" name="pay_type" value="alba" />
<section class="item_con">
	<article>
		<h2><span>SMS 충전 서비스</span></h2>
		<div class="item_box cf">
			<h3>SMS 충전 서비스</h3>
			<ul>
				<li class="box-tit cf">
					<select name="service[]" onChange="netfu_payment.money_click(this)">
						<option value="">SMS 충전</option>
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
						<li class="item_info1 service_info1">10,000건</li>
						<li class="item_info2 service_info2">120,000<li>
						<li class="item_info3 service_info3">(<em>20%↓</em>)</li>
						<li class="item_info4 service_info4">96,000원</li>
					</ul>
				</li>
			</ul>
		</div>
	</article>
</section>
<div class="button_con button_con4">
	<a href="#" class="bottom_btn04" onClick="netfu_payment.order_move('fpayment', 'all')">신청하기<img src="<?=NFE_URL;?>/images/btn_arrow.png" alt="메인페이지"></a>
</div>
</form>

<?php
include "../include/tail.php";
?>