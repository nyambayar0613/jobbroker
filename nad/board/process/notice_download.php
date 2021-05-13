<?php
		/*
		* /application/nad/board/process/download.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Notice attach file download
		* @Comment :: 공지사항 첨부 파일 다운로드
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$no = $_GET['no'];
		$notice = $notice_control->get_notice($no);	 // 공지사항 추출
		$file_name = $_GET['file_name'];

		$filepath = addslashes($alice['data_notice_abs_path'] . "/" . $ym . "/" . $file_name);

		if(!is_file($filepath) || !file_exists($filepath)){	// 파일이 없으면 아웃
			$utility->popup_msg_js($config->_errors('0054'));	// 파일이 존재하지 않습니다.
			exit;
		}

		$utility->make_downloads($filepath, $file_name);

?>