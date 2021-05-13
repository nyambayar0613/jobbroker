<?php
		/*
		* /application/nad/member/sms.php
		* @author Harimao
		* @since 2013/07/09
		* @last update 2013/11/07
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Member sms
		* @Comment :: 회원 문자 발송
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "회원관리";
		$top_menu_code = "300000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][3]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][3]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['code'];

		$sub_menu_url = "/" . $alice['admin_member'] . "/sms.php";

		##
		# Variables
		$mb_types = $member_control->mb_type;
		$search_field = $_GET['search_field'];
		$search_receive = $_GET['search_receive'];
		$search_mb_type = $_GET['search_mb_type'];
		$page = $_GET['page'];
		$page_rows = 10000;
		if($mode=='member_search'){
			$con = " and is_delete = 0 ";
		} else {
			$con = " where is_delete = 0 ";
		}

		$member_list = $member_control->member_list2($page, $page_rows, $con);

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Plugin, UI, CSS include

		##
		# Include view
		if(is_file($alice['self'] . 'views/sms.html'))
			include_once $alice['self'] . 'views/sms.html';
		else
			$config->error_info( $alice['self'] . 'views/sms.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>