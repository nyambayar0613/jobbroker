<?php
		/*
		* /application/nad/alba/employ_end.php
		* @author Harimao
		* @since 2014/03/10
		* @last update 2015/04/15
		* @Module v3.5 ( Alice )
		* @Brief :: Arbeit end list
		* @Comment :: 마감된 리스트
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "Ажил хайх удирдлага";
		$top_menu_code = "100000";

		$page_name = "alba_list";

		##
		# Include Top
		include_once "../include/top.php";

		$result = $_GET['result'];	// 입력했나?

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['code'];

		$sub_menu_url = "/" . $alice['admin_alba'] . "/employ_ing.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$wr_service = $_GET['wr_service'];
		$wr_career_type = $_GET['wr_career_type'];
		$wr_career_type_0 = $_GET['wr_career_type_0'];
		$wr_ability = $_GET['wr_ability'];

		$job_type_list = $category_control->category_codeList('job_type');		// 직종
		$area_list = $category_control->category_codeList('area');					// 지역
		$job_career_list = $category_control->category_codeList('job_career', '', 'yes');		// 경력조건
		$job_ability_list = $category_control->category_codeList('job_ability', '', 'yes');		// 학력조건

		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 30;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";

		$where = ($mode=='search') ? " and " : " where ";
		$con = $where . " ( ";
		$con .= " `wr_volume_date` >= curdate() or `wr_volume_always` = 1 or `wr_volume_end` = 1 ";
		$con .= " ) ";

		$con .= " and (`wr_service_platinum` >= curdate() or `wr_service_special` >= curdate() or `wr_service_grand` >= curdate() or `wr_service_basic` >= curdate() or `wr_service_busy` >= curdate() ) ";

		$con .= " and `is_delete` = 0 ";

		if($_GET['is_admin']=='0'){
			$con .= " and `wr_is_admin` = 0 ";
		} else if($_GET['is_admin']=='1'){
			$con .= " and `wr_is_admin` = 1 ";
		}

		$alba_list = $alba_control->__AlbaList( $page, $page_rows, $con );
		$pages = $utility->get_paging($page_rows, $page, $alba_list['total_page'],"./employ_ing.php?".$sorting."page_rows=".$page_rows."&".$alba_list['send_url']."&page=");

		$use_map = $env['use_map'];	// 사용 지도 api
		$daum_local_key = $env['daum_local_key'];	// 다음 지도 local 검색
		$naver_map_key = $env['naver_map_key'];	// 네이버 지도 key

		$map_control->get_map();	 // 지도

		if($use_map=='daum'){
			$map_script = "<script src=\"//apis.daum.net/maps/maps3.js?apikey=".$env['daum_map_key']."&libraries=services\"></script>";
		} else {
			$map_script = "";
		}

		##
		# Plugin, UI, CSS include
		echo $config->_plugin(array('cycle','autoNumeric'));

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('wr_content', '100%', '400px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/employ_ing.html'))
			include_once $alice['self'] . 'views/employ_ing.html';
		else
			$config->error_info( $alice['self'] . 'views/employ_ing.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>Үргэлжлэх хугацаа :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>