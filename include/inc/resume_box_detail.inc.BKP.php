<?php
$get_member = $user_control->get_member($get_resume['wr_id']);	 // 등록 회원 정보
$info = $netfu_mjob->get_resume($get_resume, $get_member);
$list = $alba_resume_user_control->get_resume_service($get_resume['no'],"",80);

$_wr_date = $netfu_util->get_cate(array($get_resume['wr_date']));
?>
<div class="detail_inner">
	<div class="title_name"><h2><?=$utility->make_pass_○○($get_member['mb_name']);?>(<?=$user_control->mb_gender[$get_member['mb_gender']];?>, <?=$netfu_util->get_age($get_member['mb_birth']);?>세)</h2>
		<div class="btn-r">
			<a href="<?=NFE_URL;?>/resume/detail.php?no=<?=$get_resume['no'];?>">이력서  상세보기</a><a href="#none;" onClick="netfu_mjob.scrap('alba_resume', '<?=$get_resume['no'];?>')">공고 스크랩</a><button id="close_ly" type="button" onClick='$(".detail_ly").hide()'>X</button>
		</div>
	</div>
	<div class="photo_area">
	  <img src="<?=$info['mb_photo'];?>" alt="사진">
	</div>
	<div class="info_area" style="float:left;width:auto">
		<ul>
			<?php
			if($info['max_area']<=1) {
			?>
			<li><span class="info_tit">근무지역</span><span><?=@implode(", ", $info['area_val']);?></span></li>
			<?php
			} else {
			?>
				<?php if($info['area_val'][0]) {?><li><span class="info_tit">근무지역</span><span><?=$info['area_val'][0];?></span></li><?php }?>
				<?php if($info['area_val'][1]) {?><li><span class="info_tit">&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$info['area_val'][1];?></span></li><?php }?>
				<?php if($info['area_val'][2]) {?><li><span class="info_tit">&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$info['area_val'][2];?></span></li><?php }
			}


			if($info['max_job_type']<=1) {
			?>
			<li><span class="info_tit">근무직종</span><span><?=@implode(", ", $info['job_type_val']);?></span></li>
			<?php
			} else {
			?>
				<?php if($info['job_type_val'][0]) {?><li><span class="info_tit">근무직종</span><span><?=$info['job_type_val'][0];?></span></li><?php }?>
				<?php if($info['job_type_val'][1]) {?><li><span class="info_tit">&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$info['job_type_val'][1];?></span></li><?php }?>
				<?php if($info['job_type_val'][2]) {?><li><span class="info_tit">&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$info['job_type_val'][2];?></span></li><?php }
			}
			?>
			<li><span class="info_tit">근무기간</span><span><?=$_wr_date[0];?></span></li>
			<li><span class="info_tit">학력사항</span><span><?php echo stripslashes($info['wr_school_ability']['name']);?></span></li>
			<li><span class="info_tit">경력사항</span><span><?=$list['career'];?></span></li>
		</ul>
	</div>
</div>