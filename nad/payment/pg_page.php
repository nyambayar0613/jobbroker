<?php
		/*
		* /application/nad/payment/pg_page.php
		* @author Harimao
		* @since 2013/07/23
		* @last update 2015/03/24
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Gateway Page config
		* @Comment :: 결제 페이지 사용/미사용에 따른 로직을 정립한다.
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "결제관리";
		$top_menu_code = "500000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];

		if($type=='alba_resume'){
			$sub_menu_name = "이력서 결제 페이지";
		} else {
			//$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['name'];
			$sub_menu_name = "구인공고 결제 페이지";
		}
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['code'];

		$sub_menu_url  = "/" . $alice['admin_config'] . "/pg_page.php";
		$sub_menu_url .= ($type) ? "?type=" . $type : "";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$type_arr = array( "alba_resume" => "alba_resume_page" );
		$get_pg_page = $payment_control->get_pg_page(1);


		/* 구인공고 서비스 */
		$main_platinum = explode(" ",$get_pg_page['main_platinum']);
		//$main_prime = explode(" ",$get_pg_page['main_prime']);
		$main_grand = explode(" ",$get_pg_page['main_grand']);
		$main_special = explode(" ",$get_pg_page['main_special']);
		//$main_list = explode(" ",$get_pg_page['main_list']);
		$main_basic = explode(" ",$get_pg_page['main_basic']);

		//$alba_platinum = explode(" ",$get_pg_page['alba_platinum']);
		//$alba_banner = explode(" ",$get_pg_page['alba_banner']);
		//$alba_list = explode(" ",$get_pg_page['alba_list']);
		//$alba_basic = explode(" ",$get_pg_page['alba_basic']);
		/* // 구인공고 서비스 */


		/* 인재정보 서비스 */
		$main_resume_focus = explode(" ",$get_pg_page['main_resume_focus']);
		$main_resume_busy = explode(" ",$get_pg_page['main_resume_busy']);
		$main_resume_list = explode(" ",$get_pg_page['main_resume_list']);
		$main_resume_basic = explode(" ",$get_pg_page['main_resume_basic']);

		//$alba_resume_focus = explode(" ",$get_pg_page['alba_resume_focus']);
		//$alba_resume_busy = explode(" ",$get_pg_page['alba_resume_busy']);
		//$alba_resume_list = explode(" ",$get_pg_page['alba_resume_list']);
		//$alba_resume_basic = explode(" ",$get_pg_page['alba_resume_basic']);
		/* // 인재정보 서비스 */

		##
		# Include view
		if(is_file($alice['self'] . 'views/pg_page.html'))
			include_once $alice['self'] . 'views/pg_page.html';
		else
			$config->error_info( $alice['self'] . 'views/pg_page.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>