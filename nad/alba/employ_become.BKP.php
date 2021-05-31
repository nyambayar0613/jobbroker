<?php
		/*
		* /application/nad/alba/employ_become.php
		* @author Harimao
		* @since 2014/03/03
		* @last update 2014/03/03
		* @Module v3.5 ( Alice )
		* @Brief :: Alba become list
		* @Comment ::  입사지원 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "구인구직관리";
		$top_menu_code = "100000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][6]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][6]['code'];

		$sub_menu_url = "/" . $alice['admin_alba'] . "/employ_become.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;

		$con = " where `is_delete` = 0 ";
		$list = $receive_control->__ReceiveList( $page, $page_rows, $con );
		$total_page = $list['total_page'];
		$pages = $utility->get_paging($page_rows, $page, $total_page,"./employ_become.php?page_rows=".$page_rows."&".$list['send_url']."&page=");

		##
		# Include view
		if(is_file($alice['self'] . 'views/employ_become.html'))
			include_once $alice['self'] . 'views/employ_become.html';
		else
			$config->error_info( $alice['self'] . 'views/employ_become.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>