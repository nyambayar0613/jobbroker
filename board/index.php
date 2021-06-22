<?php
$head_title = "Community Main";
include_once "../include/top.php";
?>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.js"></script>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.swipe.js"></script>


<!-- 커뮤니티 텍스트형 -->
<?php
$_banner = 'board_main_top';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/board_main.php';




$_banner = 'board_main_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';
?>


<?php
include_once(NFE_PATH.'/include/tail.php');
?>