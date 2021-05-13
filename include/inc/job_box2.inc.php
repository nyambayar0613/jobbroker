<?php
$info = $netfu_mjob->get_alba($row);
$com_member = sql_fetch("select * from alice_member_company where `mb_id`='".$row['wr_id']."' and `no`='".$row['wr_company']."'");
$get_logo = $alba_user_control->get_logo($com_member, $info);
// : 지역
$_area_arr = explode("/", $row['wr_area_0']);
$area_txt = $netfu_util->get_short_area(@implode(" ", $netfu_util->get_cate($_area_arr)));
// : 급여
$pay_val = $netfu_util->get_cate($row['wr_pay_type']);

$wr_pay = ($row['wr_pay_conference']) ? "<strong>".$netfu_mjob->pay_conference[$row['wr_pay_conference']]."</strong>" : '<b>'.$pay_val['name'].'</b> <em>'.$netfu_util->get_money_txt($row['wr_pay']).'</em>';

// : li에 class="gold1" 
if($row) {
	$_option = $netfu_mjob->get_service_option('alba', $row);
	$_logo_c = $netfu_mjob->get_logo_type('wr_service_grand_main_logo', $row, $get_logo);
?>
<button class="more_option job_more_option" no="<?=$row['no'];?>"><span>더보기</span></button>
<div class="bg_ gold_bx">
	<a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['no'];?>"><div class="logo_box <?=$_logo_c[2];?>">
		<?=$_logo_c['img'];?>
	</div></a>
	<div class="text_box info_bx <?=$_option['bold'];?>">
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
<div class="white_box grand-wbx">
	<div class="whitebox_inner">
		<div class="text">신규광고 등록 대기중</div>
		<a href="<?=NFE_URL;?>/etc/adver.php"><div class="btn">광고안내 및 신청<img src="/images/chevron.png" alt="광고안내 및 신청"></div></a>
	</div>
</div>
<?php }?>