<?php
		/*
		* /application/nad/design/employ_logo.php
		* @author Harimao
		* @since 2015/03/18
		* @last update 2015/04/08
		* @Module v3.5 ( Alice )
		* @Brief :: Employ logo
		* @Comment :: 채용공고 기본로고
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
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['code'];

		$sub_menu_url = "/" . $alice['admin_design'] . "/employ_logo.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		// jQuery plugin load
		//echo $config->_plugin(array('filestyle'));

		##
		# List Paging
		$page = ($page) ? $page : 1;
		$page_rows = 25;
		$con = "";
		$list = $logo_control->__EmploylogoList($page,$page_rows,$con);
		//$pages = $utility->get_paging($page_rows, $page, $list['total_page'],"./employ_logo.php?page_rows=".$page_rows."&page=");

		##
		# Variables

		##
		# Include view
		if(is_file($alice['self'] . 'views/employ_logo.html'))
			include_once $alice['self'] . 'views/employ_logo.html';
		else
			$config->error_info( $alice['self'] . 'views/employ_logo.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>