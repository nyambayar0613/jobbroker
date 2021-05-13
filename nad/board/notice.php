<?php
		/*
		* /application/nad/board/notice.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/05/30
		* @Module v3.5 ( Alice )
		* @Brief :: Notice config
		* @Comment :: 공지사항 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "커뮤니티";
		$top_menu_code = "600000";
		$top_menu_sel = "600201";

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
			$sub_menu_url = "/" . $alice['admin_board'] . "/notice.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_board'] . "/notice.php";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# GET variables
		$wr_type = $_GET['wr_type'];
		$dsrch_cookie = 'notice';

		##
		# List Paging
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		$notice_list = $notice_control->__NoticeList($page, $page_rows);
		$pages = $utility->get_paging($page_rows, $page, $notice_list['total_page'],"./notice.php?".$sorting."page_rows=".$page_rows."&".$notice_list['send_url']."&page=");

		$category = $category_control->__CategoryList('notice');	// 카테고리 추출
		$search_category = $category_control->getOption('notice', $_GET['wr_type']);	// option 형태 (검색시 사용)

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('wr_content', '100%', '400px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/notice.html'))
			include_once $alice['self'] . 'views/notice.html';
		else
			$config->error_info( $alice['self'] . 'views/notice.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>