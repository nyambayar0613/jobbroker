<?php
/*
<img src="/images/icon/icon2-3.gif" alt="" class="icon">
*/
$info = $netfu_mjob->get_alba($row);
$com_member = sql_fetch("select * from alice_member_company where `mb_id`='".$row['wr_id']."' and `no`='".$row['wr_company']."'");
$get_logo = $alba_user_control->get_logo($com_member, $info);

// : 지역
$_area_arr = explode("/", $row['wr_area_0']);
$area_txt = $netfu_util->get_short_area(@implode(" ", $netfu_util->get_cate($_area_arr)));
// : 급여
$pay_val = $netfu_util->get_cate($row['wr_pay_type']);

$wr_pay = ($row['wr_pay_conference']) ? "<strong>".$netfu_mjob->pay_conference[$row['wr_pay_conference']]."</strong>" : '<b>'.$pay_val['name'].'</b> <em>'.$netfu_util->get_money_txt($row['wr_pay']).'</em>';

$_gold = 'gold1';
if($row) {
	$_option = $netfu_mjob->get_service_option('alba', $row);
	$logo_path = $alice['data_alba_path'] . "/" . $row['etc_0'];
	$_logo = $netfu_util->photo_service_print($get_logo, $row['wr_service_platinum_main_logo'], $row['company_name']);
	$_gold = $row['wr_service_platinum_main_gold']>=date("Y-m-d") ? 'gold2' : 'gold1'; // : 골드 클래스값
	$_logo_c = $netfu_mjob->get_logo_type('wr_service_platinum_main_logo', $row, $get_logo);
?>
<button id="show_ly" class="more_option show_ly job_more_option" no="<?=$row['no'];?>"><span>Цааш үзэх</span></button>
<div class="text_box bg_ gold_bx">
	<a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['no'];?>"><div class="logo_box <?=$_logo_c[2];?>" >
		<?=$_logo_c['img'];?>
	</div></a>
	<div class="info_bx <?=$_option['bold'];?>">
		<div class="company"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['no'];?>"><?=stripslashes($row['wr_company_name']);?></a></div>
		<div class="title"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['no'];?>"><?=$_option['icon'];?><span class="<?=$_option['blink'];?>" style="<?=$_option['neon'];?>;<?=$_option['color'];?>;"><?=stripslashes($row['wr_subject']);?></span></a></div>
		<div class="info">
			 <span class="area"><?=$area_txt;?></span>
			<span class="pay"><?=$wr_pay;?></span>
			<span class="etc"><p><?=$info['volume_text'];?></p></span>
		</div>
	</div>
</div>
<?php } else {?>
<div class="white_box platinum-wbx">
	<div class="whitebox_inner">
		<div class="text">Зар сурталчилгааны бүртгэл хүлээгдэж байна.</div>
		<a href="<?=NFE_URL;?>/etc/adver.php"><div class="btn">Зар сурталчилгааны мэдээлэл болон хүсэлт<img src="/images/chevron.png" alt="Зар сурталчилгааны мэдээлэл болон хүсэлт"></div></a>
	</div>
</div>
<?php }?>