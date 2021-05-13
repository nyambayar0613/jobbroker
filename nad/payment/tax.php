<?php
		/*
		* /application/nad/payment/tax.php
		* @author Harimao
		* @since 2013/09/27
		* @last update 2013/09/30
		* @Module v3.0 ( Alice )
		* @Brief :: Tax list
		* @Comment :: 세금계산서 리스트
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "결제관리";
		$top_menu_code = "500000";	

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];

		if($type=='individual'){
			$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][6]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][6]['code'];
			$sub_menu_url = "/" . $alice['admin_payment'] . "/tax.php?type=individual";
		} else {
			$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][5]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][5]['code'];
			$sub_menu_url = "/" . $alice['admin_payment'] . "/tax.php";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);


		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		$con = "";
		$tax_list = $tax_control->__TaxList($page, $page_rows, $con);
		$pages = $utility->get_paging($page_rows, $page, $tax_list['total_page'],"./tax.php?".$sorting."page_rows=".$page_rows."&".$tax_list['send_url']."&page=");	

		$tax_status = $tax_control->status;
		$status = (!is_array($_GET['status'])) ? explode(',',$_GET['status']) : $_GET['status'];
		$status_cnt = count($status);

		##
		# Plugin, UI, CSS include

		
		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('content', '100%', '400px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/tax.html'))
			include_once $alice['self'] . 'views/tax.html';
		else
			$config->error_info( $alice['self'] . 'views/tax.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>