<?php
		/*
		* /application/nad/config/alba.php
		* @author Harimao
		* @since 2013/06/25
		* @last update 2013/08/08
		* @Module v3.5 ( Alice )
		* @Brief :: Arbeit service setting
		* @Comment ::  정보 설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "환경설정";
		$top_menu_code = "200000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][0]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables

		##
		# Include view
		if(is_file($alice['self'] . 'views/alba.html'))
			include_once $alice['self'] . 'views/alba.html';
		else
			$config->error_info( $alice['self'] . 'views/alba.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>