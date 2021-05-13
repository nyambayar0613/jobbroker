<?php
		/*
		* /application/nad/statistics/realtime_keyword.php
		* @author Harimao
		* @since 2013/10/30
		* @last update 2015/04/03
		* @Module v3.5 ( Alice )
		* @Brief :: Site Keyword Statistics
		* @Comment :: 검색어 통계
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "검색어현황";
		$top_menu_code = "700000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['name'];

		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['code'];

		$sub_menu_url = "/" . $alice['admin_statistics'] . "/keyword.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$category_list = $search_control->__SearchList('realtime');

		##
		# Include view
		if(is_file($alice['self'] . 'views/realtime_keyword.html'))
			include_once $alice['self'] . 'views/realtime_keyword.html';
		else
			$config->error_info( $alice['self'] . 'views/realtime_keyword.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>