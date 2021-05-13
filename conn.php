<?php
$alice_path = $_SERVER['DOCUMENT_ROOT'].'/';
$cat_path = $_SERVER['DOCUMENT_ROOT'].'/';
$page_name = "main";
$banner_atop_position = $page_name . "_top";
$banner_logo_position = $page_name . "_logo_banner";
$banner_left_position = $page_name . "_left";
$banner_tail_position = $page_name . "_bottom";
$banner_left_wing_position = $page_name . "_left_scroll";
$banner_right_wing_position = $page_name . "_right_scroll";

include_once $cat_path."_engine.php";

if($editor_use===true) {
	echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js?time=".time()."'></script>";
}

?>