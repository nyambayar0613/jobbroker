<?php
include "../engine/db_start.php";
include_once '../engine/netfu_payment.class.php';
$netfu_payment = new netfu_payment();

$pay_row = sql_fetch("select * from alice_payment where `no`='".addslashes($_GET['no'])."'");

$_txt = $pay_row['pay_status'] ? "Амжилттай" : "Хүсэлт гаргах";
$head_title = $menu_text = "Төлбөр".$_txt;

include '../conn.php';
$_pg_un = (array)unserialize(base64_decode($pay_row['pg_un']));
$_post_un = unserialize(stripslashes($pay_row['post_un']));
$_bank_arr = explode("/", $pay_row['pay_bank']);

$card_info = $netfu_payment->get_card_info($pay_row);

$page_code = 'mypage';

include_once "../include/top.php";
?>

<section class="cont_box complate_con">
<h2>
	<?php
	if($pay_row['pay_method']=='bank' && !$pay_row['pay_status']) {
	?>
	Хүсэлт амжиллттай.
	<?php
	} else {
	?>
	<?=$netfu_payment->pay_method_arr[$pay_row['pay_method']];?> Төлбөр <?=$_txt;?>боллоо.
	<?php
	}
	?>
	
</h2>
	<table class="search_tb">
	<tr>
		<th class="sch_hd">
			<div>Төлбөрийн арга</div>
		</th>
		<td class="sch_td1">
			<?=$pay_row['pay_price']<=0 ? 'Үнэгүй' : $netfu_payment->pay_method_arr[$pay_row['pay_method']];?>
		</td>
	</tr>
	<tr>
		<th class="sch_hd">
			<div>Захиалгын хэмжээ</div>
		</th>
		<td class="sch_td1">
			<?=number_format($pay_row['pay_total']);?>төгрөг
		</td>
	</tr>
	<?php
	if($pay_row['pay_dc']>0) {
	?>
	<tr>
		<th class="sch_hd">
			<div>Бүтээгдэхүүн point</div>
		</th>
		<td class="sch_td1">
			<?=number_format($pay_row['pay_dc']);?>p
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<th class="sch_hd">
			<div>Төлбөрийн эцсийн дүн</div>
		</th>
		<td class="sch_td1">
			<span class="result"><?=number_format($pay_row['pay_price']);?>төгрөг<span>
		</td>
	</tr>
	<?php
	if($pay_row['pay_method']=='bank') {
	?>
	<tr>
		<th class="sch_hd">
			<div>Хадгаламжийн данс</div>
		</th>
		<td class="sch_td1">
			<?=$_bank_arr[0];?> <?=$_bank_arr[1];?>(Данс эзэмшигч:<?=$_bank_arr[2];?>)
		</td>
	</tr>
	<tr>
		<th class="sch_hd">
			<div>Данс эзэмшигчийн нэр</div>
		</th>
		<td class="sch_td1" colspan="3">
			<?=$pay_row['pay_bank_name'];?>
		</td>
	</tr>
	<?php
	}/* else if($pay_row['pay_method']=='card') {
	?>
	<tr>
		<th class="sch_hd">
			<div>결제카드</div>
		</th>
		<td class="sch_td1">
			<?=$card_info['cardname'];?>
			<?php
			echo $card_info['cardno_ch'];
			?>
		</td>
		</tr>
	<?php }*/?>
	<tr>
		<th class="sch_hd">
			<div><?=$pay_row['pay_status']==0 ? 'Хүсэлт гаргасан огноо' : 'Төлбөр хийсэн огноо';?></div>
			</th>
			<td class="sch_td1" colspan="3">
				<?=$pay_row['pay_status']==0 ? $pay_row['pay_wdate'] : $pay_row['pay_sdate'];?>
			</td>
	</tr>
</table>
</section>

<div class="button_con button_con4">
	<a href="<?=NFE_URL;?>/" class="bottom_btn04">Үндсэн хуудас<img src="<?=NFE_URL;?>/images/btn_arrow.png" alt="Үндсэн хуудас"></a>
</div>

<?php
include "../include/tail.php";
?>