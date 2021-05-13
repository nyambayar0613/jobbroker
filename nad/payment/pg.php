<?php
		/*
		* /application/nad/payment/pg.php
		* @author Harimao
		* @since 2013/09/05
		* @last update 2015/03/12
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Gateway config
		* @Comment :: 결제 모듈 설정
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
		
		$sub_menu_name  = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['name'];
		$sub_menu = $sub_menu_name0."<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_payment'] . "/pg.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$pg_lists = $payment_control->pg_company;	// pg사 리스트

		$inicisSet_info = $payment_control->get_pgInfoCompany('inicis');	// 이니시스 설정 정보
		$inicis_logo = $alice['data_logo_path'] . '/' . $inicisSet_info['pg_logo'];

		$allSet_info = $payment_control->get_pgInfoCompany('allthegate');	// 올더게잇 설정 정보
		$all_logo = $alice['data_logo_path'] . '/' . $allSet_info['pg_logo'];

		$kcpSet_info = $payment_control->get_pgInfoCompany('kcp');	// KCP 설정 정보
		$kcp_logo = $alice['data_logo_path'] . '/' . $kcpSet_info['pg_logo'];

		$niceSet_info = $payment_control->get_pgInfoCompany('nicepay');	// 올더게잇 설정 정보
		$nice_logo = $alice['data_logo_path'] . '/' . $niceSet_info['pg_logo'];

		$use_pg = $payment_control->get_use_pg();	// 사용중인 pg 사 정보

	
		##
		# Include view
		if(is_file($alice['self'] . 'views/pg.html'))
			include_once $alice['self'] . 'views/pg.html';
		else
			$config->error_info( $alice['self'] . 'views/pg.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>