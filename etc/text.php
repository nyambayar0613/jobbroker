<?php
include_once "../include/top.php";
?>
<section class="cont_box service_con register_con">
	<h2><?=$menu_text;?></h2>
	<div class="text_box">
	<?=stripslashes($env[$_GET['code']]);?>
	</div>
</section>

<?php
include_once(NFE_PATH.'/include/tail.php');
?>