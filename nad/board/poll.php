<?php
		/*
		* /application/nad/board/poll.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/05/28
		* @Module v3.5 ( Alice )
		* @Brief :: Poll Control
		* @Comment :: 설문조사 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "커뮤니티";
		$top_menu_code = "600000";

		##
		# Include Top
		include_once "../include/top.php";

		$result = $_GET['result'];	// 입력했나?

		$middle_menu = $menu[$tmp_menu]['menus'][2]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][2]['code'];
		if($mode=='insert'){
			$sub_menu_name = $menu[$tmp_menu]['menus'][2]['sub_menu'][1]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][2]['sub_menu'][1]['code'];
		} else {
			$sub_menu_name = $menu[$tmp_menu]['menus'][2]['sub_menu'][0]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][2]['sub_menu'][0]['code'];
		}

		if($mode=='insert'){
			$sub_menu_url = "/" . $alice['admin_board'] . "/poll.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_board'] . "/poll.php";
		}

		##
		# List Paging
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$_add = "";
		$poll_list = $poll_control->__PollList($page, $page_rows, $_add);
		$pages = $utility->get_paging($page_rows, $page, $poll_list['total_page'],"./?page_rows=".$page_rows."&".$poll_list['send_url']."&page=");


		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Include view
		if(is_file($alice['self'] . 'views/poll.html'))
			include_once $alice['self'] . 'views/poll.html';
		else
			$config->error_info( $alice['self'] . 'views/poll.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>