<?php
		/*
		* /application/nad/statistics/index.php
		* @author Harimao
		* @since 2013/06/14
		* @last update 2013/12/09
		* @Module v3.5 ( Alice )
		* @Brief :: Site Statistics
		* @Comment :: 기본 통계
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "통계현황";
		$top_menu_code = "700000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['name'];
		
		$type_arr = array( 'time' => '시간별 통계', 'week' => '요일별 통계', 'date' => '일별 통계', 'month' => '월별 통계', 'domain' => '접속전 도메인 통계', 'ip' => '접속 IP 통계', 'browser' => '접속 브라우저 통계', 'os' => '접속 OS 통계' );

		$sub_menu_name = ($type) ? $type_arr[$type] : $sub_menu_name;

		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_statistics'] . "/";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$page_rows = 17;
		$page = ($page) ? $page : 1;
		$get_visits = $statistics_control->get_visits();

		if($is_demo){
			$first_day = '2013-06-01';
			$to_day = date('Y-m-d');
			$sdate = $first_day;	// 매월 첫째날
			$edate = $to_day;	// 오늘
		} else {
			$first_day = date('Y-m').'-01';
			$to_day = date('Y-m-d');
			if($type=='month')
				$sdate = ($_GET['start_day']) ? $_GET['start_day'] : date("Y-m-d",strtotime("-5 month", $alice['server_time']));
			else 
				$sdate = ($_GET['start_day']) ? $_GET['start_day'] : $first_day;	// 매월 첫째날
			$edate = ($_GET['end_day']) ? $_GET['end_day'] : $to_day;	// 오늘
		}

		if($is_debug){	// 디버깅시
			$first_day = date('Y-m').'-01';
			$to_day = date('Y-m-d');
			if($type=='month')
				$sdate = ($_GET['start_day']) ? $_GET['start_day'] : date("Y-m-d",strtotime("-5 month", $alice['server_time']));
			else
				$sdate = ($_GET['start_day']) ? $_GET['start_day'] : $first_day;	// 매월 첫째날
			$edate = ($_GET['end_day']) ? $_GET['end_day'] : $to_day;	// 오늘
		}

		##
		# Open flash chart include
		//include_once $alice['modules_path'] . "/chart/open-flash-chart/php-ofc-library/open_flash_chart_object.php";
		//include_once $alice['modules_path'] . "/chart/open-flash-chart/php-ofc-library/open-flash-chart.php";
		//include_once "./views/_include/week_data.php";

		##
		# Include view
		if(is_file($alice['self'] . 'views/index.html'))
			include_once $alice['self'] . 'views/index.html';
		else
			$config->error_info( $alice['self'] . 'views/index.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>