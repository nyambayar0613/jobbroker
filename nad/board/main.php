<?php
		/*
		* /application/nad/board/main.php
		* @author Harimao
		* @since 2014/06/11
		* @last update 2015/03/06
		* @Module v3.5 ( Alice )
		* @Brief :: Community Board main Control
		* @Comment :: 관리자 커뮤니티 게시판 메인 출력 관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "커뮤니티";
		$top_menu_code = "600000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['code'];

		$sub_menu_url = "/" . $alice['admin_board'] . "/";


		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);
		
		##
		# variables
		$category_type = "board_menu";	// 게시판 상위 메뉴 추출
		$board_category = $category_control->category_codeList($category_type);

		$get_main = $board_config_control->get_main(1);	 // 1번 정보 추출
		$print_board = unserialize($get_main['print_board']);

		$code = $board_category[0]['code'];
		$p_codes = $category_control->category_pcodeList($category_type, $code, " `rank` asc ");

		$codes = array();
		foreach($p_codes as $vals){
			array_push($codes, "'".$vals['code']."'");
		}

		if($codes) 
			$board_list = $board_config_control->__BoardList("",""," where `code` in (".@implode($codes,", ").") ", " `b_rank` asc " );

		##
		# Include view
		if(is_file($alice['self'] . 'views/main.html'))
			include_once $alice['self'] . 'views/main.html';
		else
			$config->error_info( $alice['self'] . 'views/main.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>