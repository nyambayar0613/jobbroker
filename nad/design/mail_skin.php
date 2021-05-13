<?php
		/*
		* /application/nad/design/mail_skin.php
		* @author Harimao
		* @since 2013/06/13
		* @last update 2014/03/10
		* @Module v3.5 ( Alice )
		* @Brief :: Site Mail SKIN control
		* @Comment :: 개별디자인 메일 스킨 설정
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
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][4]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][4]['code'];

		$sub_menu_url = "/" . $alice['admin_design'] . "/mail_skin.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		$mail_type = ($_GET['mail_type']) ? $_GET['mail_type'] : 'member_regist';
		$get_mail_skin = $design_control->get_mail_skin($mail_type);	// 메일 스킨 기본값 :: 회원가입

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('content', '100%', '600px');

		##
		# Variables
		$mail_skins = $design_control->mail_skin_name;

		# Include view
		if(is_file($alice['self'] . 'views/mail_skin.html'))
			include_once $alice['self'] . 'views/mail_skin.html';
		else
			$config->error_info( $alice['self'] . 'views/mail_skin.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>