<?php
		/*
		* /application/nad/member/mailing_list.php
		* @author Harimao
		* @since 2015/03/26
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Mailing list
		* @Comment :: 메일링 리스트
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "회원관리";
		$top_menu_code = "300000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][4]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][4]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][4]['sub_menu'][1]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][4]['sub_menu'][1]['code'];

		$sub_menu_url = "/" . $alice['admin_member'] . "/mailing_list.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Call Editor
		/*
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('wr_company_mailing', '100%', '500px');
		echo $utility->call_cheditor('wr_individual_mailing', '100%', '500px');
		*/

		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows : 25;
		$con = ($type) ? " where `wr_type` = '".$type."' " : "";
		$list = $mailing_control->__MailingList($page,$page_rows,$con);
		$pages = $utility->get_paging($page_rows, $page, $list['total_page'],"./mailing_list.php?page_rows=".$page_rows."&page=");

		##
		# Plugin, UI, CSS include

		##
		# Include view
		if(is_file($alice['self'] . 'views/mailing_list.html'))
			include_once $alice['self'] . 'views/mailing_list.html';
		else
			$config->error_info( $alice['self'] . 'views/mailing_list.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>