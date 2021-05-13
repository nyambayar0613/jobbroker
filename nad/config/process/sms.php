<?php
		/*
		* /application/nad/config/process/sms.php
		* @author Harimao
		* @since 2013/07/09
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: SMS config
		* @Comment :: SMS 문자 환경설정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];

		switch($mode){

			## SMS 설정
			case 'config_update':

				$vals['sms_use'] = $_POST['sms_use'];
				$vals['lms_use'] = $_POST['lms_use'];
				$vals['sms_module'] = $_POST['sms_module'];
				$vals['sms_odd_count'] = $_POST['sms_odd_count'];
				$vals['sms_api_id'] = $_POST['sms_api_id'];
				$vals['sms_api_key'] = $_POST['sms_api_key'];
				$vals['sms_sleep_start'] = @implode($_POST['sms_sleep_start'],":");
				$vals['sms_sleep_end'] = @implode($_POST['sms_sleep_end'],":");
				$vals['sms_admin_num'] = $utility->phone_pdash($_POST['sms_admin_num']);
				$vals['sms_odd_send'] = $_POST['sms_odd_send'];

				$result = $sms_control->update_sms_config($vals,$no);

			break;

			## 발송 메시지 수정
			case 'msg_update':
			
				$sms_msg = $_POST['sms_msg'];
				$sms_msg_cnt = count($sms_msg);
				
				if($sms_msg){
					foreach($sms_msg as $val){
						$no = $val['no'];
						$vals['msg_use'] = $val['msg_use'];
						$vals['msg_content'] = $val['msg_content'];
						$vals['msg_admin_content'] = $val['msg_admin_content'];
						$vals['msg_is_user'] = $val['msg_is_user'];
						$vals['msg_is_admin'] = $val['msg_is_admin'];
						$vals['wdate'] = $now_date;
						$result = $sms_control->update_sms_msg_config($vals,$no);
					}
				}

			break;
		}

		echo $result;
?>