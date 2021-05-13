<?php
		/*
		* /application/nad/config/content.php
		* @author Harimao
		* @since 2012/05/25
		* @last update 2012/05/26
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Config contents
		* @Comment :: 사이트소개, 이용약관 등등
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
		$sub_menu_name0  = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['name'] . " > ";
		$type_arr = array(
			'site_introduce' => array('name' => $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['name'], 'code' => $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['code']),
			'site_agreement' => array('name' => $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['code']),
			'site_privacy' => array('name' => $menu[$tmp_menu]['menus'][0]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][0]['sub_menu'][3]['code']),
			'board_criterion' => array('name' => $menu[$tmp_menu]['menus'][0]['sub_menu'][4]['name'], 'code' => $menu[$tmp_menu]['menus'][0]['sub_menu'][4]['code']),
			'email_denied' => array('name' => $menu[$tmp_menu]['menus'][0]['sub_menu'][5]['name'], 'code' => $menu[$tmp_menu]['menus'][0]['sub_menu'][5]['code']),
			'site_bottom' => array('name' => $menu[$tmp_menu]['menus'][0]['sub_menu'][6]['name'], 'code' => $menu[$tmp_menu]['menus'][0]['sub_menu'][6]['code']),
			'email_bottom' => array('name' => $menu[$tmp_menu]['menus'][0]['sub_menu'][7]['name'], 'code' => $menu[$tmp_menu]['menus'][0]['sub_menu'][7]['code']),
		);
		$sub_menu_name1 = $type_arr[$type]['name'];
		$sub_menu_name  = $sub_menu_name0.$sub_menu_name1;
		$sub_menu = $sub_menu_name0."<dd class='col'>".$sub_menu_name1."</dd>";
		$sub_menu_code = $type_arr[$type]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/cont.php?type=" . $type;
	
		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		$type_arr = array( 'site_introduce'=>'사이트소개', 'site_agreement'=>'회원약관', 'site_privacy'=>'개인정보취급방침', 'privacy_info'=>'개인정보수집이용안내', 'board_criterion'=>'게시판관리기준', 'email_denied'=>'이메일무단수집거부', 'site_bottom'=>'사이트하단', 'email_bottom'=>'메일하단' );

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor($type, '100%', '400px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/content.html'))
			include_once $alice['self'] . 'views/content.html';
		else
			$config->error_info( $alice['self'] . 'views/content.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>