<?php
		/*
		* /application/nad/design/popup_skin.php
		* @author Harimao
		* @since 2013/06/12
		* @last update 2013/06/17
		* @Module v3.5 ( Alice )
		* @Brief :: Site Popup SKIN control
		* @Comment :: 개별디자인 팝업 스킨 설정
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
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][3]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][3]['code'];

		$sub_menu_url = "/" . $alice['admin_design'] . "/pop_skin.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		// jQuery plugin load
		echo $config->_plugin(array( 'colourPicker', 'fileupload' ));

		##
		# List Paging
		$page = ($page) ? $page : 1;
		$page_rows = 12;
		$popup_list = $popup_control->__PopupSkinList($page, $page_rows);
		$pages = $utility->get_paging($page_rows, $page, $popup_list['total_page'],"./popup_skin.php?page=");

		##
		# Variables
		$mod = 4;	 // 한줄에 4건

		##
		# Include view
		if(is_file($alice['self'] . 'views/popup_skin.html'))
			include_once $alice['self'] . 'views/popup_skin.html';
		else
			$config->error_info( $alice['self'] . 'views/popup_skin.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>