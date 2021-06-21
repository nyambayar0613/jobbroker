<?php
$page_code = 'mypage';
$head_title = $menu_text = "점프 충전 서비스";
include_once "../include/top.php";

$_type = $member['mb_type']=='individual' ? 'resume' : 'alba';

$query = sql_query("select * from `alice_service` where `type` in ('".$_type."_option_jump') order by `rank` asc");
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/payment.class.js?time=<?=time();?>"></script>
<form name="fpayment" action="./job_order.php" method="post">
<input type="hidden" name="mode" value="jump_payment" />
<input type="hidden" name="pay_type" value="<?=$_type;?>" />

<section class="item_con">
	<article>
		<h2><span>점프 충전 서비스</span></h2>
		<div class="item_box cf">
			<h3>점프 충전 서비스</h3>
			<ul>
				<li class="box-tit cf">
					<select name="service[]" onChange="netfu_payment.money_click(this)">
						<option value="">선택</option>
						<?php
						while($row=sql_fetch_array($query)) {
							$_txt = $row['etc_3'];
						?>
						<option value="<?=$_type;?>_option/<?=$row['no'];?>"><?=number_format($_txt);?>건</option>
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
	<a href="#" class="bottom_btn04" onClick="netfu_payment.order_move('fpayment', 'all')">신청하기<img src="<?=NFE_URL;?>/images/btn_arrow.png" alt="메인페이지"></a>
</div>
</form>

<?php
include "../include/tail.php";
?>