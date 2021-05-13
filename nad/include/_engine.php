<?php
		/*
		* /application/nad/include/_engine.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/02/12
		* @Module v3.5 ( Alice )
		* @Brief :: Application Engine => Core Injection
		* @Comment :: 관리자 공통사용 Core Injection
		*/

		$alice_path = "../../";

		include_once $alice_path . "_core.php";
		include_once $alice['path'] . "engine/config/menu_config.php";	// 관리자 메뉴설정 및 변수 정의 파일

		// 관리자 페이지 강제 header 지정
		@header("Content-Type: text/html; charset=UTF-8");


		if(!$is_admin){	// 관리자 체크
			$utility->popup_msg_js($admin_control->_errors('0000'), $alice['admin_path']);
			exit;
		}

		$quick_list = $quick_control->__QuickList($admin_info['uid']);

		// 상단 메뉴별 권한 체크
		if(!$is_super_admin){
			$get_sadmin = $admin_control->get_admin($admin_info['uid']);	 // 부관리자 기본 정보
			$get_sadmin_auth = $admin_control->get_admin_auth($admin_info['uid']);	 // 부관리자 접근 메뉴
			// 상단 메뉴별 권한 체크를 위한 메뉴 추출
			$auth_top_menu = explode(',',$get_sadmin_auth['top_menu']);
			$auth_middle_menu = explode(',',$get_sadmin_auth['middle_menu']);
			$auth_sub_menu = explode(',',$get_sadmin_auth['sub_menu']);
		}

		## 기본 헤더
		$style_arr = array( 'nad' );
		$plugin_arr = array( 'cookie', 'form', 'placeholder', 'autoNumeric' );
		echo $config->_admin_header( '', $style_arr, '', $plugin_arr);		// body, css style, css media, plugin

?>