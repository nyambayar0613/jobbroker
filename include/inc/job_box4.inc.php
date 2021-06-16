<?php
/*
<img src="/images/icon/icon_wanted.gif" alt="급구" class="wanted">
<img src="/images/icon/icon2-1.gif" class="icon" alt="HOT">
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

$_option = $netfu_mjob->get_service_option('alba', $row);
?>
<button class="more_option job_more_option" no="<?=$row['no'];?>"><span>Цааш үзэх</span></button>
<div class="<?=$_option['bold'];?>">
	<div class="company" style="overflow:hidden;"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['no'];?>"><?=stripslashes($row['wr_company_name']);?><?=$map_distance;?></a></div>
	<div class="text_box">
		<!--bold--><div class="title"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['no'];?>"><?=$_option['icon'];?><span class="<?=$_option['blink'];?>" style="<?=$_option['neon'];?>;<?=$_option['color'];?>;"><?=stripslashes($row['wr_subject']);?></span></a></div>
		<div class="info">
			<span class="area"><?=$area_txt;?></span>
			<span class="pay"><?=$wr_pay;?></span>
			<span class="gender"><?=$netfu_util->gender_val[$row['wr_gender']];?></span>
			<span class="time"><?=$info['wr_time'];?></span>
			<span class="etc"><p><?=$info['volume_text'];?></p></span>
		</div>
	</div>
</div>