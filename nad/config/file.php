<?php
		/*
		* /application/nad/config/file.php
		* @author Harimao
		* @since 2014/03/10
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Admin File info
		* @Comment :: File 구조
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "환경설정";
		$top_menu_code = "200000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][4]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][4]['code'];
		$sub_menu_name  = $menu[$tmp_menu]['menus'][4]['sub_menu'][4]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][4]['sub_menu'][4]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/file.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables

		##
		# Include view
		if($is_demo){
			include_once $alice['self'] . 'views/is_demo.html';
		} else {
			if(is_file($alice['self'] . 'views/file.html'))
				include_once $alice['self'] . 'views/file.html';
			else
				$config->error_info( $alice['self'] . 'views/file.html' );
		}

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>