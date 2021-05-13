<?php
		/*
		* /application/nad/board/qna.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/10/01
		* @Module v3.5 ( Alice )
		* @Brief :: QNA list
		* @Comment :: 1:1 문의관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "커뮤니티";
		$top_menu_code = "600000";
		$top_menu_sel = "600203";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['code'];

		$sub_menu_url = "/" . $alice['admin_board'] . "/qna.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# GET variables
		$wr_cate = ($_GET['wr_cate']) ? $_GET['wr_cate'] : $_GET['wr_type'];	 // 카테고리 값임
		$dsrch_cookie = 'qna';
		$site_name = stripslashes($env['site_name']);

		##
		# List Paging
		$wr_type = 'on2on';
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		$cs_list = $cs_control->__CsList($page, $page_rows, " where `wr_type` = " . $cs_control->wr_type[$wr_type]);
		$pages = $utility->get_paging($page_rows, $page, $cs_list['total_page'],"./?".$sorting."page_rows=".$page_rows."&".$cs_list['send_url']."&page=");

		$category = $category_control->__CategoryList($wr_type);	// 카테고리 추출
		$search_category = $category_control->getOption($wr_type, $wr_cate);	// option 형태 (검색시 사용)

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('wr_acontent', '100%', '400px');
		echo $utility->call_cheditor('content', '100%', '400px');	// 메일 발송

		##
		# Include view
		if(is_file($alice['self'] . 'views/qna.html'))
			include_once $alice['self'] . 'views/qna.html';
		else
			$config->error_info( $alice['self'] . 'views/qna.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>