<?php
		/*
		* /application/nad/alba/resume_scrap.php
		* @author Harimao
		* @since 2014/03/03
		* @last update 2014/03/03
		* @Module v3.5 ( Alice )
		* @Brief :: Resume scrap list
		* @Comment :: 이력서 스크랩 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "구인구직관리";
		$top_menu_code = "100000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][4]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][4]['code'];

		$sub_menu_url = "/" . $alice['admin_alba'] . "/resume_scrap.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows : 15;
		$con = " where `scrap_rel_table` = 'alba_resume' ";
		$list = $receive_control->__ScrapList($page, $page_rows, $con);

		##
		# Include view
		if(is_file($alice['self'] . 'views/resume_scrap.html'))
			include_once $alice['self'] . 'views/resume_scrap.html';
		else
			$config->error_info( $alice['self'] . 'views/resume_scrap.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>