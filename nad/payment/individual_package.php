<?php
		/*
		* /application/nad/payment/individual_package.php
		* @author Harimao
		* @since 2015/03/20
		* @last update 2015/04/13
		* @Module v3.5 ( Alice )
		* @Brief :: Individual package
		* @Comment :: 이력서 패키지 결제 설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "결제환경설정";
		$top_menu_code = "500000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][2]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][2]['code'];
		
		$sub_menu_name  = $menu[$tmp_menu]['menus'][2]['sub_menu'][1]['name'];
		$sub_menu = $sub_menu_name0."<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][2]['sub_menu'][1]['code'];

		$sub_menu_url = "/" . $alice['admin_payment'] . "/individual_package.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$page = ($page) ? $page : 1;
		//$page_rows = 25;
		$con = " where `wr_type` = 'individual' ";
		$list = $package_control->__PackageList("","",$con);
		//$pages = $utility->get_paging($page_rows, $page, $alba_list['total_page'],"./employ_package.php?page_rows=".$page_rows."&page=");
	
		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('wr_brief', '100%', '200px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/individual_package.html'))
			include_once $alice['self'] . 'views/individual_package.html';
		else
			$config->error_info( $alice['self'] . 'views/individual_package.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>