<?php
		/*
		* /application/nad/config/board.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/06/26
		* @Module v3.5 ( Alice )
		* @Brief :: Admin board category
		* @Comment :: 커뮤니티/게시판 카테고리 설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "환경설정";
		$top_menu_code = "200000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][3]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][3]['code'];
		$type_arr = array(
			'notice' => array('name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][5]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][5]['code']),
			'on2on' => array('name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][6]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][6]['code']),
			'concert' => array('name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][7]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][7]['code']),
			'left_reason' => array('name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][8]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][8]['code']),
			/*
			'report_reason' => array('name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][9]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][9]['code']),
			'faq' => array('name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code']),
			'member' => array('name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][5]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][4]['code']),
			*/
		);
		$sub_menu_name  = $type_arr[$type]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $type_arr[$type]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/board.php?type=" . $type;

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Listing
		$category_list = $category_control->__CategoryList($type);
		

		##
		# Include view
		if(is_file($alice['self'] . 'views/board.html'))
			include_once $alice['self'] . 'views/board.html';
		else
			$config->error_info( $alice['self'] . 'views/board.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>