<?php
		/*
		* /application/nad/payment/online.php
		* @author Harimao
		* @since 2013/10/02
		* @last update 2013/10/04
		* @Module v3.5 ( Alice )
		* @Brief :: Bank info
		* @Comment :: 무통장입금계좌 설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "결제환경설정";
		$top_menu_code = "500000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		
		$sub_menu_name  = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['name'];
		$sub_menu = $sub_menu_name0."<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['code'];

		$sub_menu_url = "/" . $alice['admin_payment'] . "/online.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$bank_list = $bank_control->__BankList();
	
		##
		# Include view
		if(is_file($alice['self'] . 'views/online.html'))
			include_once $alice['self'] . 'views/online.html';
		else
			$config->error_info( $alice['self'] . 'views/online.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>