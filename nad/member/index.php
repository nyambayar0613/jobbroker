<?php
		/*
		* /application/nad/member/index.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2015/04/20
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Member list
		* @Comment :: 회원 리스트
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "회원관리";
		$top_menu_code = "300000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][0]['code'];

		$sub_menu_url = "/" . $alice['admin_member'] . "/";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		/*
		$qstr = "";		
		$is_get = ($sort&&$flag) ? "?" : "&";
		if(isset($mode)) $qstr .= $is_get . "mode=" . urlencode($mode);
		if(isset($date_type)) $qstr .= "&date_type=" . urlencode($date_type);
		if(isset($start_dayAll)) $qstr .= "&start_dayAll=" . urlencode($start_dayAll);
		if(isset($start_day)) $qstr .= "&start_day=" . urlencode($start_day);
		if(isset($end_day)) $qstr .= "&end_day=" . urlencode($end_day);
		if(isset($mb_type)) $qstr .= "&mb_type=" . urlencode($mb_type);
		if(isset($loginAll)) $qstr .= "&loginAll=" . urlencode($loginAll);
		if(isset($loginCnt_low)) $qstr .= "&loginAll=" . urlencode($loginCnt_low);
		if(isset($loginCnt_high)) $qstr .= "&loginCnt_high=" . urlencode($loginCnt_high);
		if(isset($mb_badness)) $qstr .= "&mb_badness=" . urlencode($mb_badness);
		if(isset($mb_left_request)) $qstr .= "&mb_left_request=" . urlencode($mb_left_request);
		if(isset($mb_left)) $qstr .= "&mb_left=" . urlencode($mb_left);
		if(isset($search_field)) $qstr .= "&search_field=" . urlencode($search_field);
		if(isset($search_keyword)) $qstr .= "&search_keyword=" . urlencode($search_keyword);
		*/

		
		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		if($mode=='search'){
			$con = " and a.is_delete = 0 ";
		} else {
			$con = " where a.is_delete = 0 ";
		}
		
		$member_list = $member_control->__MemberList($page, $page_rows, $con);
		$pages = $utility->get_paging($page_rows, $page, $member_list['total_page'],"./?".$sorting."page_rows=".$page_rows."&".$member_list['send_url']."&page=");

		// mb_level
		$category_list = $category_control->__CategoryList('mb_level');

		// map
		$use_map = $env['use_map'];
		$daum_local_key = $env['daum_local_key'];
		$naver_map_key = $env['naver_map_key'];
		$map_control->get_map();	 // 지도

		switch($use_map){
			case 'daum':
				$map_color = "#617BFF";
				//$map_script = "<script src=\"//apis.daum.net/maps/maps3.js?apikey=".$env['daum_map_key']."&libraries=services\"></script>";
				$map_script = "<script type=\"text/javascript\" src=\"//dapi.kakao.com/v2/maps/sdk.js?appkey=".$env['daum_map_key']."&libraries=services\"></script>"; 
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
		# Plugin, UI, CSS include
		echo $config->_plugin( 'autoNumeric' );

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('content', '100%', '400px');
		echo $utility->call_cheditor('mb_biz_vision', '100%', '400px');	// 기업개요 및 비전
		echo $utility->call_cheditor('mb_biz_result', '100%', '400px');	// 기업연혁 및 실적

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