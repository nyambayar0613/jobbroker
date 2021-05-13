<?php
//if($_SERVER['PHP_SELF']!=NFE_URL.'/index.php') $menu_on = 'job';
if(strpos($_SERVER['PHP_SELF'], '/job/')!==false) $menu_on = 'job';
if(strpos($_SERVER['PHP_SELF'], '/resume/')!==false) $menu_on = 'resume';
if(strpos($_SERVER['PHP_SELF'], '/board/')!==false) $menu_on = 'board';
?>
<div class="navi_menu">
	<a href="<?=NFE_URL;?>/job/index.php" class="<?=$menu_on=='job' ? 'active' : '';?>">구인정보</a>
	<a href="<?=NFE_URL;?>/resume/index.php" class="<?=$menu_on=='resume' ? 'active' : '';?>">인재정보</a>
	<a href="<?=NFE_URL;?>/board/index.php" class="<?=$menu_on=='board' ? 'active' : '';?>">커뮤니티</a>
</div>