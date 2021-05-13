<?php
		/*
		* /application/nad/member/views/_ajax/sms_msg.php
		* @author Harimao
		* @since 2013/07/11
		* @last update 2013/07/11
		* @Module v3.5 ( Alice )
		* @Brief :: SMS message
		* @Comment :: SMS 메시지 정보만 추출
		*/

		$alice_path = "../../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$no = $_POST['no'];

		$sms_msg = $sms_control->get_sms_msg($no);

		echo $utility->remove_quoted($sms_msg['msg_content']);
?>