<?php
		/*
		* /application/nad/member/mail.php
		* @author Harimao
		* @since 2013/07/10
		* @last update 2013/08/06
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Member mail
		* @Comment :: 회원 메일 발송
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
		$sub_menu_name = $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_member'] . "/mail.php";

		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		if($mode=='search'){
			$con = " and a.is_delete = 0 ";
		} else {
			$con = " where a.is_delete = 0 ";
		}
		
		$member_list = $member_control->__MemberList($page, $page_rows, $con);
		$pages = $utility->get_paging($page_rows, $page, $member_list['total_page'],"./mail.php?".$sorting."page_rows=".$page_rows."&".$member_list['send_url']."&page=");

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Plugin, UI, CSS include
		echo $config->_plugin(array('filestyle'));

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('content', '100%', '400px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/mail.html'))
			include_once $alice['self'] . 'views/mail.html';
		else
			$config->error_info( $alice['self'] . 'views/mail.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>