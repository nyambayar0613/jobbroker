<?php
		/*
		* /application/nad/config/sadmin.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/11/12
		* @Module v3.5 ( Alice )
		* @Brief :: Admin config
		* @Comment :: 부관리자관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "환경설정";
		$top_menu_code = "200000";

		##
		# Include Top
		include_once "../include/top.php";

		$result = $_GET['result'];	// 입력했나?

		$middle_menu = $menu[$tmp_menu]['menus'][4]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][4]['code'];

		if($mode=='insert'){
			$sub_menu_name = $menu[$tmp_menu]['menus'][4]['sub_menu'][2]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][4]['sub_menu'][2]['code'];
		} else {
			$sub_menu_name = $menu[$tmp_menu]['menus'][4]['sub_menu'][1]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][4]['sub_menu'][1]['code'];
		}

		if($mode=='insert'){
			$sub_menu_url = "/" . $alice['admin_config'] . "/sadmin.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_config'] . "/sadmin.php";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# List Paging
		$page = ($page) ? $page : 1;
		$page_rows = 15;
		$admin_list = $admin_control->__AdminList(9, $page, $page_rows);
		$pages = $utility->get_paging($page_rows, $page, $admin_list['total_page'],"./sadmin.php?page=");

		##
		# Include view
		if(is_file($alice['self'] . 'views/sadmin.html'))
			include_once $alice['self'] . 'views/sadmin.html';
		else
			$config->error_info( $alice['self'] . 'views/sadmin.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>