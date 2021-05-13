<?php
		/*
		* /application/nad/config/index.php
		* @author Harimao
		* @since 2013/05/24
		* @last update 2015/03/12
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Index
		* @Comment :: 기본 header 만 설정하고 나머지는 스킨을 불러드려 사용한다.
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "환경설정";
		$top_menu_code = "200000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		// 회원 가입시 기본 그룹 지정 카테고리
		//$category_list = $category_control->__CategoryList('member');

		##
		# Variables
		$sns_feed = explode(',',$env['sns_feed']);
		$sns_count = count($sns_feed);
		$level_category = $category_control->__CategoryList("mb_level"," `rank` asc ");	// 회원 등급(레벨) 정보
		$use_ipin = $env['use_ipin'];
		$use_hphone = $env['use_hphone'];

		##
		# Include view
		if(is_file($alice['self'] . 'views/index.html'))
			include_once $alice['self'] . 'views/index.html';
		else
			$config->error_info( $alice['self'] . 'views/index.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>