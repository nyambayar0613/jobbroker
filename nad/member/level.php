<?php
		/*
		* /application/nad/member/level.php
		* @author Harimao
		* @since 2013/05/24
		* @last update 2015/03/05
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Member level config
		* @Comment :: 회원 등급(level) 설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "회원관리";
		$top_menu_code = "300000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][4]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][4]['code'];

		$sub_menu_url = "/" . $alice['admin_member'] . "/level.php";


		##
		# Variables
		$level_category = $category_control->__CategoryList("mb_level"," `rank` asc ");
		//$point_control->point_insert("test",$env['login_point'],"테스트","@login",'admin',$alice['time_ymd']);

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Plugin, UI, CSS include
		echo $config->_plugin(array('filestyle'));

		##
		# Include view
		if(is_file($alice['self'] . 'views/level.html'))
			include_once $alice['self'] . 'views/level.html';
		else
			$config->error_info( $alice['self'] . 'views/level.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>