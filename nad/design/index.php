<?php
		/*
		* /application/nad/design/index.php
		* @author Harimao
		* @since 2013/08/05
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Design Control
		* @Comment :: 기본 디자인관리 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "디자인관리";
		$top_menu_code = "400000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		if($mode=='insert'){
			$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['code'];
		} else {
			$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['code'];
		}

		if($mode=='insert'){
			$sub_menu_url = "/" . $alice['admin_design'] . "/index.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_design'] . "/index.php";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Plugin, UI, CSS include
		echo $config->_plugin(array('form','colourPicker'));

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('main_platinum_content', '790px', '100px');
		echo $utility->call_cheditor('main_grand_content', '790px', '100px');
		echo $utility->call_cheditor('main_special_content', '790px', '100px');
		echo $utility->call_cheditor('main_busy_content', '790px', '100px');
		echo $utility->call_cheditor('main_focus_content', '790px', '100px');
		echo $utility->call_cheditor('main_basic_content', '790px', '100px');	// 메인 채용공고
		echo $utility->call_cheditor('main_rbasic_content', '790px', '100px');	// 메인 이력서

		echo $utility->call_cheditor('alba_jump_content', '790px', '100px');	 // 채용공고 점프 서비스
		echo $utility->call_cheditor('resume_jump_content', '790px', '100px');	// 이력서 점프 서비스

		echo $utility->call_cheditor('alba_open_content', '790px', '100px');	// 채용공고 열람 서비스
		echo $utility->call_cheditor('resume_open_content', '790px', '100px');	// 이력서 열람 서비스


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