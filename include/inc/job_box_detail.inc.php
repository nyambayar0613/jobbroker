<?php
include NFE_PATH.'/include/job_detail.info.php';
if(is_array($area_cate)) foreach($area_cate as $k=>$v) {
	$area_array[] = @implode(" ", $v).' '.$area_arr[$k][3];
}

if($job_type[0] || $job_type[1] || $job_type[2]) $__job_type_arr[] = array($job_type[0], $job_type[1], $job_type[2]);
if($job_type[3] || $job_type[4] || $job_type[5]) $__job_type_arr[] = array($job_type[3], $job_type[4], $job_type[5]);
if($job_type[6] || $job_type[7] || $job_type[8]) $__job_type_arr[] = array($job_type[6], $job_type[7], $job_type[8]);
?>
<div class="detail_inner">
	<div class="company_name"><h2><?=stripslashes($get_alba['wr_company_name']);?></h2>
		<div class="btn-r">
			<a href="<?=NFE_URL;?>/job/detail.php?no=<?=$get_alba['no'];?>">Дэлгэрэнгүй</a><a href="#none;" onClick="netfu_mjob.scrap('alba', '<?=$get_alba['no'];?>')">Зарын scrab</a><button id="close_ly" type="button" onClick='$(".detail_ly").hide()'>X</button>
		</div>
	</div>
	<div class="title_area">
	<p class="title_txt"><?=stripslashes($get_alba['wr_subject']);?></p>
	<p class="field">
		<div><?=@implode(" > ", $__job_type_arr[0]);?></div>
		<div><?=@implode(" > ", $__job_type_arr[1]);?></div>
		<div><?=@implode(" > ", $__job_type_arr[2]);?></div>
	</p>
	</div>
	<div class="info_area">
		<ul>
			<?php if($area_array[0]) {?><li><span class="info_tit">Ажлын барйшил</span><span><?=$area_array[0];?></span></li><?php }?>
			<?php if($area_array[1]) {?><li><span class="info_tit">&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$area_array[1];?></span></li><?php }?>
			<?php if($area_array[2]) {?><li><span class="info_tit">&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$area_array[2];?></span></li><?php }?>
			<li><span class="info_tit">Ажиллах хугацаа</span><span><?=$category_control->get_categoryCodeName($get_alba['wr_date']);?></span></li>
			<li><span class="info_tit">Ажлын өдөр</span><span><?=$category_control->get_categoryCodeName($get_alba['wr_week']);?></span></li>
			<li><span class="info_tit">Ажлын нөхцөл</span><span><?=@implode(", ", $work_type_cate);?></span></li>
			<li><span class="info_tit">Эцсийн хугацаа</span><span><?=$job_info['volume_text'];?></span></li>
		</ul>
	</div>
	<div class="etc_area">
		<ul>
			<li>
				<div class="etc_tit"><strong>Цалингийн нөхцөл</strong></div>
				<div class="etc_txt pay">
					<?php echo ($get_alba['wr_pay_conference']) ? '<b>'.$alba_user_control->pay_conference[$get_alba['wr_pay_conference']].'</b>' : '<b>'.$pay_type.'</b><span>'.$wr_pay.'</span>'; ?>
				</div>
			</li>
			<li>
			  <div class="etc_tit"><strong>Хүйс</strong></div>
				<div class="etc_txt"><?=$alba_user_control->gender_val[$get_alba['wr_gender']];?></div>
			</li>
			<li>
			  <div class="etc_tit"><strong>Нас</strong></div>
				<div class="etc_txt"><?=$get_alba['wr_age_limit']==1 ? preg_replace("/-/", " ~ ", $get_alba['wr_age']).'нас' : '';?></div>
			</li>
			<li>
			  <div class="etc_tit"><strong>Ажилд авах хүний тоо</strong></div>
				<div class="etc_txt"><?=$volmue;?></div><!--<span>0</span>명, <span>00<span>명-->
			</li>
		</ul>
	</div>
	<div class="btn_area">
	  <ul>
			<li class="sbtn"><a href="#none;" onClick="netfu_mjob.scrap('alba', '<?=$get_alba['no'];?>')"><img src="/images/scrap_icon3.png" alt="Scrab">Scrab</a></li>
			<li class="abtn"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$get_alba['no'];?>&code=receive_online">지원하기</a></li>
		</ul>
	</div>
</div>