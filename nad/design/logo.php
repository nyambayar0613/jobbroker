<?php
		/*
		* /application/nad/design/logo.php
		* @author Harimao
		* @since 2013/06/14
		* @last update 2013/06/17
		* @Module v3.5 ( Alice )
		* @Brief :: Site logo control
		* @Comment :: 사이트로고설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "디자인관리";
		$top_menu_code = "400000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['code'];

		$sub_menu_url = "/" . $alice['admin_design'] . "/logo.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		// jQuery plugin load
		echo $config->_plugin(array('filestyle'));

		##
		# Include view
		if(is_file($alice['self'] . 'views/logo.html'))
			include_once $alice['self'] . 'views/logo.html';
		else
			$config->error_info( $alice['self'] . 'views/logo.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>