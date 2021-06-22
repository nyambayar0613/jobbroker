<?php
$get_member = $user_control->get_member($row['wr_id']);	 // 등록 회원 정보
$info = $netfu_mjob->get_resume($row, $get_member);
$list = $alba_resume_user_control->get_resume_service($row['no'],"",80);


$_option = $netfu_mjob->get_service_option('alba_resume', $row);
?>

<button class="more_option resume_more_option" no="<?=$row['no'];?>"><span>Дэлгэрэнгүй үзэх</span></button>
<div class="text_box text_bx2 <?=$_option['bold'];?>">
	<div class="person">
		<a href="<?=NFE_URL;?>/resume/detail.php?no=<?=$row['no'];?>"><?=$utility->make_pass_○○($get_member['mb_name']);?></a>
	</div>
	<div class="title"><a href="<?=NFE_URL;?>/resume/detail.php?no=<?=$row['no'];?>"><?=$_option['icon'];?><span class="<?=$_option['blink'];?>" style="<?=$_option['neon'];?>;<?=$_option['color'];?>;"><?=stripslashes($row['wr_subject']);?></span></a></div>
	<div class="info">
		<span class="gender2"><?=$user_control->mb_gender[$get_member['mb_gender']];?><i>·<?=$netfu_util->get_age($get_member['mb_birth']);?></i></span>
		<span class="career"><?=$list['career'];?></span>
		<span class="job"><?=$info['work_type'];?></span>
	</div>
	<div class="info">
		<span class="edu"><?php echo stripslashes($info['wr_school_ability']['name']);?></span>
		<span class="area"><?=@implode(", ", $info['area_val']);?></span>
		<span class="pay"><?=$info['pay_type'];?></span>
	</div>
</div>