<?php
$get_member = $user_control->get_member($row['wr_id']);	 // 등록 회원 정보
$info = $netfu_mjob->get_resume($row, $get_member);
$list = $alba_resume_user_control->get_resume_service($row['no'],"",80);

/*
<img src="/images/id_pic2.png" alt="증명사진">
<img src="/images/id_pic.png" alt="증명사진">
<img src="/images/icon/icon2-7.gif" class="icon" alt="" >
<img src="/images/icon/icon2-8.gif" class="icon" alt="" >
<img src="/images/icon/icon2-9.gif" class="icon" alt="" >
*/


switch($row) {


// : 정보가 있는경우
	case true:
		$_option = $netfu_mjob->get_service_option('alba_resume', $row);
		$_gold = $row['wr_service_main_focus_gold']>=date("Y-m-d") ? 'gold2' : 'gold1'; // : 골드 클래스값
?>
<div class="picture_box"> <!--//gold1, gold2-->
	<a href="<?=NFE_URL;?>/resume/detail.php?no=<?=$row['no'];?>"><img src="<?=$info['mb_photo'];?>" alt="증명사진"><!-- <img src="/images/id_pic.png" alt="증명사진"> --></a>
</div>
<div class="text_box bg_ <?=$_option['bold'];?>">
	<div class="profile_name"><a href="<?=NFE_URL;?>/resume/detail.php?no=<?=$row['no'];?>"><?=$utility->make_pass_○○($get_member['mb_name']);?> <span class="profile">(<?=$user_control->mb_gender[$get_member['mb_gender']];?>·<?=$netfu_util->get_age($get_member['mb_birth']);?>)</span><!-- <span class="career"><?=$list['career'];?></span> --> </a></div>
	<div class="title"><a href="<?=NFE_URL;?>/resume/detail.php?no=<?=$row['no'];?>"><?=$_option['icon'];?><span class="<?=$_option['blink'];?>" style="<?=$_option['neon'];?>;<?=$_option['color'];?>;"><?=stripslashes($row['wr_subject']);?></span></a></div> <!--div class->bold , a태그속 <span class="blink neon2">    --> 
</div>
<?php
		break;



// : 정보가 없는경우
	default:
?>
<div class="picture_box"> <!--//gold1, gold2-->
	
</div>
<div class="text_box gold1">
	<div class="profile_name">&nbsp;</div>
	<div class="title">&nbsp;</a></div> <!--div class->bold , a태그속 <span class="blink neon2">    --> 
</div>
<?php
		break;
}
?>