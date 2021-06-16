<div class="picture_box">
	<a href="#"><img src="<?=$mb_photo;?>" alt="Цээж зураг"></a>
</div>
<div class="text_box">
	<div class="profile_name"><?=$member['mb_name'];?>(<span><?=$netfu_util->gender_arr[$member['mb_gender']];?></span>, <span><?=substr($member['mb_birth'], 0, 4);?>Төрсөн он</span>)</div>
	<div class="profile_name2"><?=$member['mb_id'];?></div>
	<div class="profile_info"><span><?=$member['mb_hphone'];?></span><span>(<?=$member['mb_email'];?>)</span></div>
	<div class="info">Сүүлийн засвар <span><?=date("Y.m.d", strtotime($member['mb_udate']));?></span></div>
</div>