<?php
$_open_view_allow = $info['is_open__'];
?>
<div class="tab-box tab4-box content_editor-">

<?php
if(!$info['is_open__']){
?>
<div class="container bnr_bx cf">
	<div class="recruit_service cf">
		<p>상세요강 내용을 열람하시려면 구인정보 열람서비스를 신청하세요.</p>
		<div class="member_btn">
			<div class="recruit_service_bt"><a href="<?=NFE_URL;?>/payment/read_payment.php">구인정보 열람서비스 신청</a></div>
		</div>
	</div>
</div>
<?php
} else {
	echo $utility->conv_content(stripslashes($get_alba['wr_content']),1);
}
?>

</div>