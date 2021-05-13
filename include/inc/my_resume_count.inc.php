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
				<div class="info_txt">이력서<br>등록수</div>
			</a>
		</li>
		<li>
			<a href="<?=NFE_URL;?>/mypage/report_individual.php">
				<div class="count"><?=number_format($_my_count['receive']['c']);?></div>
				<div class="info_txt">입사지원<br>현황</div>
			</a>
		</li>
		<li>
			<a href="<?=NFE_URL;?>/mypage/setting_individual.php">
				<div class="count"><?=number_format($_my_count['12121']['c']);?></div>
				<div class="info_txt">맞춤구인<br>정보</div>
			</a>
		</li>
		<li>
			<a href="<?=NFE_URL;?>/mypage/scrap_individual.php">
				<div class="count"><?=number_format($_my_count['scrap']['c']);?></div>
				<div class="info_txt">스크랩<br>구인정보</div>
			</a>
		</li>
	</ul>
</div>