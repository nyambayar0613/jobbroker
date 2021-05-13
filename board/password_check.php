<?php
		/*
		* /application/board/password_check.php
		* @author Harimao
		* @since 2013/10/28
		* @last update 2013/10/29
		* @Module v3.5 ( Alice )
		* @Brief :: Board article view password check
		* @Comment :: 게시글 비밀번호 확인
		*/
		
		$alice_path = "../";

		$cat_path = "../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		$page_name = "board";

		include_once $cat_path . "_engine.php";

		##
		# Variables
		$wr = $board_control->get_write($write_table, $wr_no);

		if(md5($wr_password) != $wr['wr_password']){
			$utility->popup_msg_js($board_control->_errors('0061'));	// 패스워드가 틀립니다.
		}

		//$ss_name = "view_secret_".$bo_table."_".$wr['wr_num'];
		$ss_name = "view_secret_".$bo_table."_".$wr['wr_no'];

		$utility->set_session($ss_name, TRUE);

		$go_url = $alice['board_path']."/view.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no;

		$utility->popup_msg_js("", $go_url);

?>