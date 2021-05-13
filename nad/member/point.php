<?php
		/*
		* /application/nad/member/point.php
		* @author Harimao
		* @since 2013/07/15
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Member point list/config
		* @Comment :: 회원 포인트 관리
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
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][5]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][5]['code'];

		$sub_menu_url = "/" . $alice['admin_member'] . "/point.php";

		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 25;
		$sorting = ($sort) ? "&sort=" . $sort : "";
		$con = "";

		$point_list = $point_control->__PointList($page, $page_rows, $con);
		$pages = $utility->get_paging($page_rows, $page, $point_list['total_page'],"./point.php?".$sorting."page_rows=".$page_rows."&".$point_list['send_url']."&page=");

		$total_point = $point_control->total_point($con);

		$member_id = $member_control->member_list();

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Plugin, UI, CSS include
		echo $config->_plugin(array('filestyle'));

		##
		# Include view
		if(is_file($alice['self'] . 'views/point.html'))
			include_once $alice['self'] . 'views/point.html';
		else
			$config->error_info( $alice['self'] . 'views/point.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>