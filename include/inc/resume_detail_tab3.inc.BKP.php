<?php
$_open_view_allow = $read_info['_open_view_allow'];
?>
<div class="tab-box tab5-box">
	<div class="container cf">
	<?php
	// : 공개
	if($read_info['_open_view_allow']===true) {

		echo $utility->conv_content(stripslashes($re_row['wr_introduce']),2);

	// : 차감
	} else if($_allow=='count') {
	?>
	사용가능한 이력서 열람권이 <?php echo $is_open_count;?>건 있습니다 열람권을 사용하시면 열람이 가능합니다.
	<?php


	// : 열람서비스 버튼
	} else {
	?>
	<div class="resume_service">
		<p>자기소개서 내용을 열람하시려면 이력서 열람서비스를 신청하세요.</p>
		<div class="member_btn">
			<div class="resume_service_bt"><a href="<?=NFE_URL;?>/payment/read_payment.php">이력서 열람서비스 신청</a></div>
		</div>
	</div>
	<?php
	}
	?>
	</div>
</div>