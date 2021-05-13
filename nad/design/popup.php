<?php
		/*
		* /application/nad/design/popup.php
		* @author Harimao
		* @since 2013/06/13
		* @last update 2013/06/17
		* @Module v3.5 ( Alice )
		* @Brief :: Site Popup control
		* @Comment :: 개별디자인 팝업설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "디자인관리";
		$top_menu_code = "400000";

		##
		# Include Top
		include_once "../include/top.php";

		$result = $_GET['result'];	// 입력했나?

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		if($mode=='insert'){
			$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['code'];
		} else {
			$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][1]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][1]['code'];
		}

		if($mode=='insert'){
			$sub_menu_url = "/" . $alice['admin_design'] . "/popup.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_design'] . "/popup.php";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# List Paging
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$popup_list = $popup_control->__PopupList($page, $page_rows);
		$pages = $utility->get_paging($page_rows, $page, $popup_list['total_page'],"./popup.php?page_rows=".$page_rows."&page=");

		$popup_skin = $popup_control->__PopupSkinList();	// 팝업 스킨

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('popup_content', '100%', '200px');

		# Include view
		if(is_file($alice['self'] . 'views/popup.html'))
			include_once $alice['self'] . 'views/popup.html';
		else
			$config->error_info( $alice['self'] . 'views/popup.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>