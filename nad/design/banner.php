<?php
		/*
		* /application/nad/design/banner.php
		* @author Harimao
		* @since 2013/06/12
		* @last update 2015/03/30
		* @Module v3.5 ( Alice )
		* @Brief :: Banner Control
		* @Comment :: 관리자 배너 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "디자인관리";
		$top_menu_code = "400000";

		##
		# Include Top
		include_once "../include/top.php";

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
			$sub_menu_url = "/" . $alice['admin_design'] . "/banner.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_design'] . "/banner.php";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# List Paging
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 30;
		$banner_list = $banner_control->__BannerList($page, $page_rows);
		$pages = $utility->get_paging($page_rows, $page, $banner_list['total_page'],"./banner.php?position=".$position."&page_rows=".$page_rows."&page=");

		$banner_group = $banner_control->_group($position);
		$banner_group_list = $banner_group['list'];
		$banner_group_count = $banner_group['group_count'];

		##
		# Variables
		# 각 위치별 배너 정보 추출
		$banner_lists = $banner_control->banner_lists;

		/*
		$main_banner = $banner_control->_banners('main');	 // 메인 배너
		$main_banner_cnt = count($main_banner);

		$alba_banner = $banner_control->_banners('alba');	 // 정규직 배너
		$alba_banner_cnt = count($alba_banner);
		*/
		
		$positions = explode('_',$position);

		$banner_title = $banner_control->banner_title;

		$menu_name = $banner_control->_position($positions[0], $position);

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('self_content', '100%', '250px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/banner.html'))
			include_once $alice['self'] . 'views/banner.html';
		else
			$config->error_info( $alice['self'] . 'views/banner.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
	
?>