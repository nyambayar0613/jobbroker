<?php
		/*
		* /application/nad/design/download.php
		* @author Harimao
		* @since 2013/06/18
		* @last update 2013/06/18
		* @Module v3.5 ( Alice )
		* @Brief :: Banner file download
		* @Comment :: 배너 파일 다운로드
		*/

		$alice_path = "../../";

		$cat_path = "../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$banner_file = $_GET['banner_file'];

		$filepath = $alice['data_banner_path'] . '/' . $banner_file;
		$filepath = addslashes($filepath);
		if (!is_file($filepath) || !file_exists($filepath)){
			$utility->popup_msg_js($config->_errors('0054'));
			exit;
		}

		if (preg_match("/^utf/i", $alice['charset']))
			$original = urlencode($banner_file);
		else
			$original = $banner_file;

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