<?php
		/*
		* /application/nad/alba/resume_report.php
		* @author Harimao
		* @since 2013/06/26
		* @last update 2013/11/04
		* @Module v3.5 ( Alice )
		* @Brief :: Arbeit report list
		* @Comment :: 신고된 정보
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "Орчны тохиргоо";
		$top_menu_code = "100000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['code'];

		$sub_menu_url = "/" . $alice['admin_alba'] . "/resume_report.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		$con = " where `wr_report` = 1 and `is_delete` = 0 ";

		$resume_list = $alba_resume_control->__ResumeList( $page, $page_rows, $con );
		$pages = $utility->get_paging($page_rows, $page, $resume_list['total_page'],"./resume_report.php?".$sorting."page_rows=".$page_rows."&".$resume_list['send_url']."&page=");

		##
		# Plugin, UI, CSS include
		echo $config->_plugin(array('form'));

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor("wr_introduce", '100%', '580px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/resume_report.html'))
			include_once $alice['self'] . 'views/resume_report.html';
		else
			$config->error_info( $alice['self'] . 'views/resume_report.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>Үргэлжлэх хугацаа :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>