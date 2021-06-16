<?php
// : 개수정보
$_my_count['resume'] = sql_fetch("select count(*) as c from alice_alba_resume where `wr_id`='".$member['mb_id']."' and `is_delete` = 0");
$_my_count['receive'] = sql_fetch("select count(*) as c from alice_receive where `wr_id`='".$member['mb_id']."' and `is_delete` = 0");
$_my_count['scrap'] = sql_fetch("select count(*) as c from alice_scrap where `mb_id`='".$member['mb_id']."'");
?>
<div class="status">
	<ul>
		<li>
			<a href="<?=NFE_URL;?>/mypage/resume_list.php">
				<div class="count"><?=number_format($_my_count['resume']['c']);?></div>
				<div class="info_txt">Анкет<br>Бүртгүүлсэн тоо</div>
			</a>
		</li>
		<li>
			<a href="<?=NFE_URL;?>/mypage/report_individual.php">
				<div class="count"><?=number_format($_my_count['receive']['c']);?></div>
				<div class="info_txt">Ажилд орох хүсэлт<br>Одоогын байдлаар</div>
			</a>
		</li>
		<li>
			<a href="<?=NFE_URL;?>/mypage/setting_individual.php">
				<div class="count"><?=number_format($_my_count['12121']['c']);?></div>
				<div class="info_txt">Санал болгох ажлын байр<br>Мэдээлэл</div>
			</a>
		</li>
		<li>
			<a href="<?=NFE_URL;?>/mypage/scrap_individual.php">
				<div class="count"><?=number_format($_my_count['scrap']['c']);?></div>
				<div class="info_txt">Scrab<br>Ажлын байрны мэдээлэл</div>
			</a>
		</li>
	</ul>
</div>