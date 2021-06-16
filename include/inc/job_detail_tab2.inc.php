<?php
$_open_view_allow = $info['is_open__'];
?>
<div class="tab-box tab4-box content_editor-">

<?php
if(!$info['is_open__']){
?>
<div class="container bnr_bx cf">
	<div class="recruit_service cf">
		<p>Та дэлгэрэнгүй уншихыг хүсвэл ажлын байрны мэдээллийг үзэх үйлчилгээнд хамрагдана уу.</p>
		<div class="member_btn">
			<div class="recruit_service_bt"><a href="<?=NFE_URL;?>/payment/read_payment.php">Ажлын байрны мэдээллийг үзэх үйлчилгээний өргөдөл</a></div>
		</div>
	</div>
</div>
<?php
} else {
	echo $utility->conv_content(stripslashes($get_alba['wr_content']),1);
}
?>

</div>