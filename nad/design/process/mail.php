<?php
		/*
		* /application/nad/design/process/mail.php
		* @author Harimao
		* @since 2013/06/13
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Mail skin Setting
		* @Comment :: 메일 스킨 관리 프로세스
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$uid = $_POST['uid'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		if (substr_count($_POST['content'], "&#") > 50) {
			echo '0034';	// 내용에 올바르지 않은 코드가 다수 포함되어 있습니다.
			exit;
		}

		switch($mode){

			## 메일 스킨 등록
			case 'insert':
			
				$vals['uid'] = $uid;
				$vals['skin_name'] = $_POST['skin_name'];
				$vals['content'] = $_POST['content'];
				$vals['wdate'] = $now_date;

				for($i=0;$i<=9;$i++){
					$vals['etc_'.$i] = $_POST['etc_'.$i];
				}

				$result = $design_control->insert_Mailskin($vals);

				echo $result;

			break;

			## 메일 스킨 수정
			case 'update':
			
				$skin_name = $_POST['skin_name'];

				$vals['uid'] = $uid;
				$vals['content'] = $_POST['content'];
				$vals['wdate'] = $now_date;

				for($i=0;$i<=9;$i++){
					$vals['etc_'.$i] = $_POST['etc_'.$i];
				}

				$result = $design_control->update_Mailskin($vals, $skin_name);

				echo $result;

			break;

		}
?>