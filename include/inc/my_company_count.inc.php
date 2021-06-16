<?php
// : 개수정보
$_my_count['alba'] = sql_fetch("select count(*) as c from alice_alba where `wr_id`='".$member['mb_id']."' and `is_delete` = 0");
$_my_count['receive'] = sql_fetch("select count(*) as c from alice_receive where `wr_to_id`='".$member['mb_id']."' and `is_delete` = 0");
$_my_count['scrap'] = sql_fetch("select count(*) as c from alice_scrap where `mb_id`='".$member['mb_id']."'");
?>
<div class="status2">
	<ul>
		<li>
			<div class="count"><?=number_format($_my_count['alba']['c']);?></div>
			<div class="info_txt">Ажлын зар<br>Одоогын байдлаар</div>
		</li>
		<li>
			<div class="count"><?=number_format($_my_count['receive']['c']);?></div>
			<div class="info_txt">Зар<br>Хүсэлт гаргагч</div>
		</li>
		<li>
			<div class="count"><?=number_format($_my_count['scrap']['c']);?></div>
			<div class="info_txt">Scrab<br>Хүний нөөцийн мэдээлэл</div>
		</li>
	</ul>
</div>