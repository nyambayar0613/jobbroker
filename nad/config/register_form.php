<?php
		/*
		* /application/nad/config/register_form.php
		* @author Harimao
		* @since 2013/06/25
		* @last update 2015/03/10
		* @Module v3.5 ( Alice )
		* @Brief :: Company member register setting
		* @Comment :: 기업 회원 가입폼 설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "환경설정";
		$top_menu_code = "200000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][2]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][2]['code'];
		$sub_menus = $menu[$tmp_menu]['menus'][2]['sub_menu'];	 // 서브 메뉴

		$type_arr = array(
			'company_form' => array('name' => $menu[$tmp_menu]['menus'][2]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][2]['sub_menu'][0]['code']),
			'alba_form' => array('name' => $menu[$tmp_menu]['menus'][2]['sub_menu'][1]['name'], 'code' => $menu[$tmp_menu]['menus'][2]['sub_menu'][1]['code']),
			'alba_resume' => array('name' => $menu[$tmp_menu]['menus'][2]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][2]['sub_menu'][2]['code']),
		);

		$sub_menu_name  = $type_arr[$type]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $type_arr[$type]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/register_form.php?type=" . $type;

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$category_list = $category_control->category_codeList($type, " `rank` asc ");

		##
		# Include view
		//$include_arr = array("company" => "company_form.html", "alba_form" => "alba_form.html");
		if( is_file($alice['self'] . 'views/register_form.html') )
			include_once $alice['self'] . 'views/register_form.html';
		else
			$config->error_info( $alice['self'] . 'views/register_form.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>