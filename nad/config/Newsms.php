<?php
		/*
		* /application/nad/config/sms.php
		* @author Harimao
		* @since 2013/06/25
		* @last update 2013/11/28
		* @Module v3.5 ( Alice )
		* @Brief :: SMS setting
		* @Comment :: SMS(문자) 환경설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "환경설정";
		$top_menu_code = "200000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][0]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/sms.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$sms_config = $sms_control->sms_config(1);
		if($sms_config['sms_module']=='cafe24'){	// cafe24 정보
			$sms_ord = $sms_control->cafe24_sms_Ord();
		}
		$sms_sleep_start = explode(':',$sms_config['sms_sleep_start']);
		$sms_sleep_end = explode(':',$sms_config['sms_sleep_end']);
		$sms_msg = $sms_control->__SMS_msgList( " where `is_view`  = 1 " );
		$sms_admin_num = ($is_demo) ? '010-0000-0000' : $sms_config['sms_admin_num'];

		##
		# Include view
		if(is_file($alice['self'] . 'views/Newsms.html'))
			include_once $alice['self'] . 'views/Newsms.html';
		else
			$config->error_info( $alice['self'] . 'views/Newsms.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>