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
	Ашиглах боломжтой үйлчилгээ. <?php echo $is_open_count;?>
	<?php


	// : 열람서비스 버튼
	} else {
	?>
	<div class="resume_service">
		<p>CV-ийн агуулгыг уншихын тулд Анкет үзэх үйлчилгээнд хамрагдана уу.</p>
		<div class="member_btn">
			<div class="resume_service_bt"><a href="<?=NFE_URL;?>/payment/read_payment.php">Анкет үзэх үйлчилгээний хүсэлт</a></div>
		</div>
	</div>
	<?php
	}
	?>
	</div>
</div>