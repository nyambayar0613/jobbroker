<?php
		/*
		* /application/nad/member/left_list.php
		* @author Harimao
		* @since 2013/07/10
		* @last update 2013/08/05
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Member left list
		* @Comment :: 탈퇴요청/탈퇴 회원 리스트
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
		if($type=='left'){
			$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][3]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][3]['code'];
			$sub_menu_url = "/" . $alice['admin_member'] . "/left_list.php?type=left";
		} else {
			$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['code'];
			$sub_menu_url = "/" . $alice['admin_member'] . "/left_list.php";
		}


		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		$_add = ($mode=='search') ? " and " : " where ";
		$_field = ($type=='left') ? "a.mb_left" : "a.mb_left_request";
		$con  = $_add . " ".$_field." = 1 ";
		$con .= (!$type) ? " and a.mb_left = 0 " : "";
		$con .= " and a.is_delete = 0 ";

		$_type = ($type=='left') ? "&type=left&" : "";

		
		$member_list = $member_control->__MemberList($page, $page_rows, $con);
		$pages = $utility->get_paging($page_rows, $page, $member_list['total_page'],"./left_list.php?".$sorting."page_rows=".$page_rows.$_type."&".$member_list['send_url']."&page=");

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Plugin, UI, CSS include

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('content', '100%', '400px');
		echo $utility->call_cheditor('mb_biz_vision', '100%', '400px');	// 기업개요 및 비전
		echo $utility->call_cheditor('mb_biz_result', '100%', '400px');	// 기업연혁 및 실적

		##
		# Include view
		if(is_file($alice['self'] . 'views/left_list.html'))
			include_once $alice['self'] . 'views/left_list.html';
		else
			$config->error_info( $alice['self'] . 'views/left_list.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>