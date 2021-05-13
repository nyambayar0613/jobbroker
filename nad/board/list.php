<?php
		/*
		* /application/nad/board/index.php
		* @author Harimao
		* @since 2015/05/29
		* @last update 2015/06/10
		* @Module v3.5 ( Alice )
		* @Brief :: Community Board data list
		* @Comment :: 관리자 커뮤니티 게시글 관리
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
		if($mode=='insert'){
			$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][2]['code'];
		} else {
			$sub_menu_name = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['name'];
			$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
			$sub_menu_code = $menu[$tmp_menu]['menus'][0]['sub_menu'][1]['code'];
		}

		if($mode=='insert'){
			$sub_menu_url = "/" . $alice['admin_board'] . "/list.php?mode=insert";
		} else {
			$sub_menu_url = "/" . $alice['admin_board'] . "/list.php";
		}

		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Variables
		$board_menu = $category_control->category_codeList('board_menu');	// 게시판 메뉴 리스트
		$use_upload = $board['bo_use_upload'];

		##
		# Listing
		if($bo_table){
			/* 카테고리 정보 */
			$bo_category = false;
			if($board['bo_use_category'])
				$bo_category = $category_control->category_pcodeList('board',$bo_table, " rank asc ");	// 게시판별 분류(카테고리)
			/* //카테고리 정보 */
			$page = ($page) ? $page : 1;
			$page_rows = ($page_rows) ? $page_rows: $board['bo_page_rows'];
			//$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
			$con = " where `wr_is_comment` = 0 ";
			$list_row = $board_control->__BoardList($bo_table,$page,$page_rows,$con);

			$pages = $utility->get_paging($page_rows, $page, $list_row['total_page'],"./list.php?code=".$code."&bo_table=".$bo_table."&page_rows=".$page_rows."&".$list_row['send_url']."&page=");

			$list = array();
			$i = 0;
			
			/* 공지사항 리스트 */
			$arr_notice = explode("\n", trim($board['bo_notice']));
			$notice_cnt = count($arr_notice);
			for($n=0;$n<$notice_cnt;$n++){
				if (trim($arr_notice[$n])=='') continue;
				// 공지사항 리스트
				$notices = $board_control->get_boardArticle( $bo_table, " where `wr_no` = '".$arr_notice[$n]."' order by `wr_no` desc ");
				$list[$i] = $board_control->get_list( $notices, $board, $board_skin, $board['bo_subject_len'] );
				$list[$i]['is_notice'] = true;
			$i++;
			}
			/* //공지사항 리스트 */

			/* 게시물 리스트 */
			$n = 0;
			foreach($list_row['result'] as $val){	// 리스팅
				$list[$i] = $board_control->get_list($val, $board, "./skins/default", $board['bo_subject_len'] );
				$list[$i]['subject'] = $utility->search_font($search_keyword, $list[$i]['subject']);
				$list[$i]['is_notice'] = false;
				$list[$i]['num'] = $list_row['total_count'] - ($page - 1) * $board['bo_page_rows'] - $n;
				$len = strlen($val['wr_reply']);
				if($len < 0):
					$len = 0;
				endif;
				$reply = substr($val['wr_reply'], 0, $len);
				$list[$i]['reply_cnt'] = $db->_queryR(" select count(*) from `".$alice['write_prefix'].$board['bo_table']."` where `wr_reply` like '".$reply."%' and `wr_no` <> '".$val['wr_no']."' and `wr_num` = '".$val['wr_num']."' and `wr_is_comment` = 0 ");

			$i++;
			$n++;
			}
			/* //게시물 리스트 */

		}

		##
		# Call Editor
		echo "<script src='".$alice['editor_path']."/cheditor/cheditor.js'></script>";
		echo $utility->call_cheditor('wr_content', '100%', '500px');

		##
		# Include view
		if(is_file($alice['self'] . 'views/list.html'))
			include_once $alice['self'] . 'views/list.html';
		else
			$config->error_info( $alice['self'] . 'views/list.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>