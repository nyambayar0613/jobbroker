<?php
		/*
		* /application/nad/alba/employ_comment.php
		* @author Harimao
		* @since 2013/10/18
		* @last update 2015/04/15
		* @Module v3.5 ( Alice )
		* @Brief :: Alba comment list
		* @Comment ::  공고 댓글 리스트
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "구인구직관리";
		$top_menu_code = "100000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][0]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][0]['code'];
		$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][6]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][6]['code'];

		$sub_menu_url = "/" . $alice['admin_alba'] . "/employ_comment.php";

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$wr_num = $_GET['wr_num'];
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows : 15;
		$list = $comment_control->get_alba_comment_list( $page, $page_rows );

		if($wr_num){
			$get_alba = $alba_control->get_alba($wr_num);
			$con = " where `wr_num` = '".$wr_num."' and `wr_category` = 'alba' and `wr_is_comment` = 1 ";
			$comment_list = $comment_control->__CommentList( $page, $page_rows, $con );
			$total_count = $comment_list['total_count'];
			$total_page = $comment_list['total_page'];
			$list = $comment_list['result'];
			$pages = $utility->user_get_paging($page_rows, $page, $total_page,"./employ_comment.php?wr_num=".$wr_num."&page_rows=".$page_rows."&".$comment_list['send_url']."&page=");

		}

		##
		# Include view
		if(is_file($alice['self'] . 'views/employ_comment.html'))
			include_once $alice['self'] . 'views/employ_comment.html';
		else
			$config->error_info( $alice['self'] . 'views/employ_comment.html' );


		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>