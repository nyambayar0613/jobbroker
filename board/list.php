<?php
include_once "../include/top.php";
$_SESSION['move_page']['board_page'] = $_SERVER['REQUEST_URI'];
?>



<?php
$_banner = 'board_sub_top';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/board/inc/board_list.inc.php';




$_banner = 'board_sub_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';
?>




<?php
include_once(NFE_PATH.'/include/tail.php');
?>