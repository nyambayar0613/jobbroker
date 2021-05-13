<?php
		/*
		* /application/nad/config/process/db_download.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: DB dump file download
		* @Comment :: DB 파일 다운로드
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		if($is_demo){	 // 데모일땐 작동 안함

			$utility->popup_msg_js($config->_errors('0023'));

		} else {

			if($is_admin){	// 관리자 확인

				$no = $_GET['no'];
				$uid = $admin_info['uid'];

				$get_backup = $backup_control->get_backup($no);

				$filepath = addslashes($alice['data_db_path'] . "/" . $get_backup['file_name']);

				if(!is_file($filepath) || !file_exists($filepath)){	// 파일이 없으면 아웃
					$utility->popup_msg_js($config->_errors('0054'));	// 파일이 존재하지 않습니다.
					exit;
				}

				$utility->make_downloads($filepath, $get_backup['file_name']);

			} else {

				$utility->popup_msg_js($admin_control->_errors('0000'));	// 관리자만 접근 가능합니다.

			}

		}
?>