<?php
		/*
		* /application/nad/board/download.php
		* @author Harimao
		* @since 2013/06/10
		* @last update 2013/08/02
		* @Module v3.5 ( Alice )
		* @Brief :: Board file download
		* @Comment :: 게시판 첨부파일 다운로드
		*/

		$alice_path = "../../../";

		$cat_path = "../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$bo_table = $_GET['bo_table'];
		$wr_no = $_GET['wr_no'];

		$query = " select file_source, file_name from `alice_board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$no."' ";
		$file = $db->query_fetch($query);
		if (!$file['file_name']){
			$utility->popup_msg_js($board_control->_errors('0054'));	// 파일이 존재하지 않습니다.
			exit;
		}

		$filepath = $alice['data_board_path'] . '/' . $bo_table . '/' . $file['file_name'];
		$filepath = addslashes($filepath);
		if (!is_file($filepath) || !file_exists($filepath)){
			$utility->popup_msg_js($config->_errors('0018'));
			exit;
		}

		if (preg_match("/^utf/i", $alice['charset']))
			$original = urlencode($file['file_source']);
		else
			$original = $file['file_source'];

		if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
			header("content-type: doesn/matter");
			header("content-length: ".filesize("$filepath"));
			header("content-disposition: attachment; filename=\"$original\"");
			header("content-transfer-encoding: binary");
		} else {
			header("content-type: file/unknown");
			header("content-length: ".filesize("$filepath"));
			header("content-disposition: attachment; filename=\"$original\"");
			header("content-description: php generated data");
		}
		header("pragma: no-cache");
		header("expires: 0");
		flush();

		$fp = fopen("$filepath", "rb");

		$download_rate = 10;

		while(!feof($fp)) {
			print fread($fp, round($download_rate * 1024));
			flush();
			usleep(1000);
		}
		fclose ($fp);
		flush();
?>