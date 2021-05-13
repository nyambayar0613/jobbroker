<?php
		/*
		* /application/nad/board/index.php
		* @author Harimao
		* @since 2015/05/29
		* @last update 2014/10/01
		* @Module v3.5 ( Alice )
		* @Brief :: Community Board Control
		* @Comment :: 관리자 커뮤니티 게시판 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "커뮤니티";
		$top_menu_code = "600000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_board'] . "/";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);
		
		##
		# variables
		$category_type = "board_menu";
		$board_category = $category_control->category_codeList($category_type);
		$page_rows = 15;
		$page = ($page) ? $page : 1;
		$board_list = $board_config_control->__BoardList($page,$page_rows,""," `no` desc ");
		$pages = $utility->get_paging($page_rows, $page, $board_list['total_page'],"./index.php?page_rows=".$page_rows."&".$board_list['send_url']."&page=");

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js?time=".time()."'></script>";

		##
		# Include view
		if(is_file($alice['self'] . 'views/index.html'))
			include_once $alice['self'] . 'views/index.html';
		else
			$config->error_info( $alice['self'] . 'views/index.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>