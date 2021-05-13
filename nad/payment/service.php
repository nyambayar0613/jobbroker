<?php
		/*
		* /application/nad/payment/service.php
		* @author Harimao
		* @since 2013/07/24
		* @last update 2015/04/13
		* @Module v3.5 ( Alice )
		* @Brief :: Service config
		* @Comment :: 결제 서비스에 따른 금액 설정
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
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][3]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][3]['code'];

		$sub_menu_url  = "/" . $alice['admin_config'] . "/service.php";
		$type = ($_GET['type']) ? $_GET['type'] : "main_platinum";
		$sub_menu_url .= ($type) ? "?type=" . $type : "";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$no = $_GET['no'];
		$service_title = $service_control->service_title;

		$types = explode('_',$type);
		$types_length = count($types);
		
		$types_code = ($types_length > 2) ? $types[0] . "_" . $types[1] : $types[0];
		$sel_code = ($types_length > 2) ? $types[2] : $types[1];

		$service_lists = $service_control->service_lists[$types_code];
		$service_sel_title = ($types_length >2 ) ? $service_title[$types_code] : $service_title[$types_code];
		$service_sel_title .= " > " . $service_lists[$sel_code]['name'];
		$service_is_gold = $service_lists[$sel_code]['is_gold'];
		$service_is_logo = $service_lists[$sel_code]['is_logo'];	 // 로고강조

		$service_list = $service_control->__ServiceList($type);
		$service_gold_list = $service_control->__ServiceList($type."_gold");
		$service_logo_list = $service_control->__ServiceList($type."_logo");

		$service_check = $service_control->service_check($type);
		$service_gold_check = $service_control->service_check($type."_gold");
		$service_logo_check = $service_control->service_check($type."_logo");

		$service_etc_0 = explode(' ',$service_check['etc_0']);

		$logo_check = $service_control->service_check($type);
		$logo_checks = explode("/",$logo_check['effect']);

		$neon_color_check = $service_control->service_check($type);
		$font_color_check = $service_control->service_check($type);

		if($sel_code=='neon'){
			$color_checks = explode("/",$neon_color_check['neon_color']);
			$color_checks_cnt = count($color_checks);
			$sel_field = "neon_color";
		} else {
			$color_checks = explode("/",$font_color_check['font_color']);
			$color_checks_cnt = count($color_checks);
			$sel_field = "font_color";
		}

		$is_open = false;	// 열람권 서비스
		if($type=='etc_open' || $type=='etc_alba') {
			$is_open = true;
		}


		if($no){	// 수정
			$mode = "update";
			if($is_gold)	// 골드서비스 정보
				$get_gold_service = $service_control->get_service($no);
			else if($is_logo)	// 로고강조 정보
				$get_logo_service = $service_control->get_service($no);
			else
				$get_service = $service_control->get_service($no);
		} else {
			$mode = "insert";
		}

		$icon_mode = ($icon_mode) ? $icon_mode : "insert";

		$service_type = $service_lists[$sel_code]['type'];	 // box / icon / color / option

		$icon_list = $category_control->category_codeList($type);

		$is_jump_service = false;
		if($type=='alba_option_jump' || $type=='resume_option_jump'){
			$is_jump_service = true;
		}

		/*
		echo "<pre style='color:#ffffff;'>";
		//print_R($logo_checks);
		//print_r($service_lists[$sel_code]);
		//print_r($types);
		//print_R($service_lists);
		echo $sel_code." <==<Br/>";
		//echo $service_type." <==<br/><br/>";
		//echo $types_code." <==<Br/>";
		//echo $service_lists[$sel_code]['type']." <==<Br/>";
		//echo $sel_code." <==<Br/>";
		echo "</pre>";
		*/


		// jQuery plugin load
		echo $config->_plugin( array('cycle','easing','colourPicker','filestyle') );

		##
		# Include view
		if(is_file($alice['self'] . 'views/service.html'))
			include_once $alice['self'] . 'views/service.html';
		else
			$config->error_info( $alice['self'] . 'views/service.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>