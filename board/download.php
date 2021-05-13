<?php
		/*
		* /application/board/download.php
		* @author Harimao
		* @since 2013/10/29
		* @last update 2014/01/06
		* @Module v3.5 ( Alice )
		* @Brief :: Board data download
		* @Comment :: 첨부파일 다운로드
		*/
		
		$alice_path = "../";

		$cat_path = "../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		$page_name = "board";

		include_once $alice_path . "_core.php";

		$bo_table = $_GET['bo_table'];
		$wr_no = $_GET['wr_no'];

		if(!$_SESSION['ss_view_'.$bo_table.'_'.$wr_no]){
			$utility->popup_msg_js($config->_errors('0002'));	// 잘못된 접근입니다.
			exit;
		}

		$query = " select `file_source`, `file_name` from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$no."' ";
		$file = $db->query_fetch($query);
		if (!$file['file_name']){
			$utility->popup_msg_js($config->_errors('0054'));	// 파일이 존재하지 않습니다.
			exit;
		}

		if($board['bo_read_level'] > $member['mb_level']){	// 읽기 권한으로 체크
			echo $utility->popup_msg_js($board_control->_errors('0062'));	 // 다운로드 권한이 없습니다.
			exit;
		}

		$ss_name = "ss_down_".$bo_table."_".$wr_no;
		if (!$_SESSION['ss_name']) {
			// 다운로드 카운트 증가
			$query = " update `".$alice['table_prefix']."board_file` set `file_download` = `file_download` + 1 where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$no."' ";
			$db->_query($query);
			$utility->set_session($ss_name, TRUE);
		}

		$filepath = $alice['data_board_path'] . '/' . $bo_table . '/' . $file['file_name'];
		
		$filepath = addslashes($filepath);
		if (!is_file($filepath) || !file_exists($filepath)){
			$utility->popup_msg_js($board_control->_errors('0007'));	// 첨부파일이 존재하지 않습니다.
			exit;
		}

		// : 포인트
		/*
		// : 다운로드 1,2,번별로 각각 차감하게 하는방법이 없음. 만들어서 해야함. 정규직에는 없어서 안했음.
		if($board['bo_download_point']) {
			$bo_row = sql_fetch("select * from ".$write_table." where `wr_no`='".addslashes($_POST['wr_no'])."'");
			$point_control->point_insert($member['mb_id'], $board['bo_download_point'], $board['bo_subject']." ".$bo_row['wr_no']." 다운로드", $bo_table, $bo_row['wr_no'], '다운로드');
		}
		*/

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
			//echo fread($fp, 100*1024);
			/*
			echo fread($fp, 100*1024);
			flush();
			*/

			print fread($fp, round($download_rate * 1024));
			flush();
			usleep(1000);
		}
		fclose ($fp);
		flush();
?>