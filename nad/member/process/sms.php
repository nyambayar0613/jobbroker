<?php
		/*
		* /application/member/process/sms.php
		* @author Harimao
		* @since 2013/07/09
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: SMS regist
		* @Comment :: 문자발송 처리 (SMS 는 member 에서 넘어오지만 별도 파일에서 독립적으로 처리한다)
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$sphone = $_POST['sphone'];

		switch($mode){

			## 여러회원 문자 발송
			case 'members_send':

				$send_msg = $_POST['send_msg'];
				$rphone_list = trim(strip_tags(mysql_escape_string($_POST['rphone_list'])));

				$trans = array( "\n" => "", "\\n" => "" );
				$rphones = strtr($rphone_list,$trans);

				$result = $sms_control->send_sms_Members($send_msg, $rphones, $sphone);

			break;
		}

		echo $result;
?>