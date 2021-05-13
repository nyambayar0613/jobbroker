<?php
		/*
		* /application/nad/mobile/index.php
		* @author Harimao
		* @since 2013/12/13
		* @last update 2013/12/17
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Mobile config
		* @Comment :: 모바일웹 설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "모바일웹";
		$top_menu_code = "800000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_member'] . "/";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$no = 1;
		$mobile_info = $mobile_control->get_mobile_info($no);	// 모바일 환경설정 정보
		$board_menu = $category_control->category_codeList('board_menu');	// 게시판 메뉴 리스트

		$main_board = unserialize($mobile_info['wr_main_board']); 
		$wr_board = unserialize($mobile_info['wr_board']);

		/*
		echo "<pre>";
		print_R($board_menu);
		echo "</pre>";
		*/

		##
		# Plugin, UI, CSS include

		##
		# Call Editor

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