<?php
		/*
		* /application/nad/statistics/google.php
		* @author Harimao
		* @since 2013/06/14
		* @last update 2014/03/19
		* @Module v3.5 ( Alice )
		* @Brief :: Google analytics
		* @Comment :: 구글 웹로그 분석
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
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['code'];

		$sub_menu_url = "/" . $alice['admin_statistics'] . "/";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		/*
		if(!$_GET['sdate']) 
			//$_GET['sdate'] = date('Y-m-01');
			$_GET['sdate'] = '2013-06-01';
		if(!$_GET['edate']) 
			//$_GET['edate'] = date('Y-m-d');
			$_GET['edate'] = '2013-08-31';
		$sdate = $_GET['sdate'];
		$edate = $_GET['edate'];

		$first_day = $_GET['sdate'];
		$to_day = $_GET['edate'];
		*/

		if($is_demo){
			$first_day = '2013-06-01';
			$to_day = '2013-08-31';
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

		$loading = "<table width=\"100%\" height=\"100%\" cellpadding=\"0\" cellspacing=\"0\"><tr><td align=\"center\" height=\"100%\"><b>구글 Analytics</b>로부터 데이터를 수신하는 중입니다.<br /><br/> 잠시만 기다려 주십시오.<div style=\"margin-top:20px\"><img src=\"".$alice['helper_img_path']."/loader.gif\" align=\"absmiddle\" /></div></td></tr></table>";

		##
		# Include view
		if(is_file($alice['self'] . 'views/google.html'))
			include_once $alice['self'] . 'views/google.html';
		else
			$config->error_info( $alice['self'] . 'views/google.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>