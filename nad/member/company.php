<?php
		/*
		* /application/nad/member/company.php
		* @author Harimao
		* @since 2013/06/25
		* @last update 2015/04/15
		* @Module v3.5 ( Alice )
		* @Brief :: Company member list
		* @Comment :: 기업회원 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "기업회원관리";
		$top_menu_code = "300000";

		$page_name = "company_member";

		##
		# Include Top
		include_once "../include/top.php";

		$result = $_GET['result'];	// 입력했나?

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		if($mode=='insert'){
			$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][1]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][1]['code'];
		} else {
			$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][0]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][0]['code'];
		}

		if($mode=='insert'){
			$sub_menu_url = "/" . $alice['admin_member'] . "/company.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_member'] . "/company.php";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		$where = ($mode=='search') ? "and" : "where";
		$con = $where . " a.mb_type = 'company' ";
		$con .= " and a.is_delete = 0 ";
		
		$member_list = $member_control->__MemberList($page, $page_rows, $con);
		$pages = $utility->get_paging($page_rows, $page, $member_list['total_page'],"./company.php?".$sorting."page_rows=".$page_rows."&".$member_list['send_url']."&page=");

		// mb_level
		$category_list = $category_control->__CategoryList('mb_level');

		// map
		$use_map = $env['use_map'];
		$daum_local_key = $env['daum_local_key'];
		$naver_map_key = $env['naver_map_key'];
		$map_control->get_map();	 // 지도

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('content', '100%', '400px');
		echo $utility->call_cheditor('mb_biz_vision', '100%', '400px');	// 기업개요 및 비전
		echo $utility->call_cheditor('mb_biz_result', '100%', '400px');	// 기업연혁 및 실적

		##
		# Include view
		if(is_file($alice['self'] . 'views/company.html'))
			include_once $alice['self'] . 'views/company.html';
		else
			$config->error_info( $alice['self'] . 'views/company.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>