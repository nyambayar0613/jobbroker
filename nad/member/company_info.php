<?php
		/*
		* /application/nad/member/company_info.php
		* @author Harimao
		* @since 2014/08/11
		* @last update 2015/04/20
		* @Module v3.5 ( Alice )
		* @Brief :: Company info
		* @Comment :: 기업회원 - 정보 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "기업정보관리";
		$top_menu_code = "300000";

		$page_name = "company_member";

		##
		# Include Top
		include_once "../include/top.php";

		$result = $_GET['result'];	// 입력했나?

		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['code'];

		$mode = ($mode) ? $mode : "insert";

		if($mode=='insert'){
			$sub_menu_url = "/" . $alice['admin_member'] . "/company_info.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_member'] . "/company_info.php";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 25;
		$con = "";
		$list = $member_control->__CompanyList($page,$page_rows,$con);
		$pages = $utility->get_paging($page_rows, $page, $list['total_page'],"./company_info.php?page_rows=".$page_rows."&".$list['send_url']."&page=");

		$biz_types = $category_control->category_codeList('biz_type','','yes');	 // 회사분류
		$biz_forms = $category_control->category_codeList('biz_form','','yes');	 // 기업형태
		$biz_success = $category_control->category_codeList('biz_success','','yes');	 // 상장여부

		// map
		$use_map = $env['use_map'];
		$daum_local_key = $env['daum_local_key'];
		$naver_map_key = $env['naver_map_key'];
		$map_control->get_map();	 // 지도

		switch($use_map){
			case 'daum':
				$map_color = "#617BFF";
				$map_script = "<script src=\"//apis.daum.net/maps/maps3.js?apikey=".$env['daum_map_key']."&libraries=services\"></script>";
			break;
			case 'naver':
				$map_color = "#33CC00";
				$map_script = "";
			break;
			case 'google':
				$map_color = "#C0C0C0";
				$map_script = "";
			break;
		}

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('mb_biz_vision', '100%', '400px');	// 기업개요 및 비전
		echo $utility->call_cheditor('mb_biz_result', '100%', '400px');	// 기업연혁 및 실적

		##
		# Include view
		if(is_file($alice['self'] . 'views/company_info.html'))
			include_once $alice['self'] . 'views/company_info.html';
		else
			$config->error_info( $alice['self'] . 'views/company_info.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>