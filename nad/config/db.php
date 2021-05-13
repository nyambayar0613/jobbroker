<?php
		/*
		* /application/nad/config/db.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/06/26
		* @Module v3.5 ( Alice )
		* @Brief :: Admin DB Backup
		* @Comment :: DB 백업
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
		$sub_menu_name  = $menu[$tmp_menu]['menus'][4]['sub_menu'][3]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][4]['sub_menu'][3]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/db.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# List Paging
		$page = ($page) ? $page : 1;
		$page_rows = 15;
		$backup_list = $backup_control->__BackupList($page, $page_rows);
		$pages = $utility->get_paging($page_rows, $page, $backup_list['total_page'],"./db.php?page=");

		##
		# Include view
		if(is_file($alice['self'] . 'views/db.html'))
			include_once $alice['self'] . 'views/db.html';
		else
			$config->error_info( $alice['self'] . 'views/db.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>