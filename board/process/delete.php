<?php
		/*
		* /application/board/process/delete.php
		* @author Harimao
		* @since 2013/10/29
		* @last update 2015/03/09
		* @Module v3.5 ( Alice )
		* @Brief :: Board article delete
		* @Comment :: 게시글 삭제
		*/

		$alice_path = "../../";

		$cat_path = "../../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$board_code = $_POST['board_code'];
		$code = $_POST['code'];
		$no = $_POST['no'];
		$wr_no = ($_POST['wr_no']) ? $_POST['wr_no'] : $no;
		$sca = $_POST['sca'];	// 카테고리

		$page = $_GET['page'];
		$token = ($_GET['token']) ? $_GET['token'] : $_POST['token'];
		$wr_password = $_POST['wr_password'] ? $_POST['wr_password'] : $_GET['wr_password'];

		if (!($token && $_SESSION['ss_delete_token'] == $token)) {
			$utility->popup_msg_js($board_control->_errors('0039'));	// 토큰 에러로 삭제 불가합니다.
			exit;
		}

		if($write['wr_id']=='guest' ){	 // 비회원 작성글 및 관리자 통과
			if($write['wr_id']=='guest'){
				if(!$is_admin) {
					if(md5($wr_password) != $write['wr_password'])
						$utility->popup_msg_js($board_control->_errors('0042'));	// 패스워드가 틀리므로 삭제할 수 없습니다.
				}
			} else {
			;
			}
		} else if($member['mb_id']) {	// 회원의 경우

			if($member['mb_id'] != $write['wr_id']){
				$utility->popup_msg_js($board_control->_errors('0040'));	// 자신의 글이 아니므로 삭제할수 없습니다.
			}

		} else {
            if(!$is_admin) {
				if($write['wr_id'])
					$utility->popup_msg_js($board_control->_errors('0041'));	// 로그인 후 삭제하세요.
				else if(md5($wr_password) != $write['wr_password'])
					$utility->popup_msg_js($board_control->_errors('0042'));	// 패스워드가 틀리므로 삭제할 수 없습니다.
            }

		}


		$len = strlen($write['wr_reply']);
		if ($len < 0) $len = 0; 
		$reply = substr($write['wr_reply'], 0, $len);

		// 원글만 구한다.
		$query = " select count(*) as cnt from `".$write_table."` where `wr_reply` like '".$reply."%' and `wr_no` <> '".$write['wr_no']."' and `wr_num` = '".$write['wr_num']."' and `wr_is_comment` = 0 ";
		$row = $db->query_fetch($query);
		if ($row['cnt']){
			$utility->popup_msg_js($board_control->_errors('0015'));	// 이 글과 관련된 답변글이 존재하므로 삭제 할 수 없습니다.\\n\\n우선 답변글부터 삭제해 주세요.
			exit;
		}

		// 코멘트 달린 원글의 삭제 여부
		$query = " select count(*) as cnt from `".$write_table."` where `wr_parent` = '".$wr_no."' and `wr_id` <> '".$mb_id."' and `wr_is_comment` = 1 ";
		$row = $db->query_fetch($query);
		if ($row['cnt']) {
			$utility->popup_msg_js($board_control->_errors('0016'));	// 이 글과 관련된 코멘트가 존재하므로 삭제 할 수 없습니다.\\n\\n코멘트를 먼저 삭제해 주세요.
			exit;
		}

		$query = " select wr_no, wr_id, wr_is_comment from `".$write_table."` where `wr_parent` = '".$write['wr_no']."' order by `wr_no` ";
		$result = $db->query_fetch_rows($query);
		foreach($result as $row) {

			// 원글이라면
			if (!$row['wr_is_comment']) {

				// 원글 포인트 삭제
				if (!$point_control->point_delete($row['wr_id'], $bo_table, $row['wr_no'], '쓰기'))
					$point_control->point_insert($row['wr_id'], $board['bo_write_point'] * (-1), $board['bo_subject']." ".$row['wr_no']." 글삭제");

				// 업로드된 파일이 있다면 파일삭제
				$query2 = " select * from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$row['wr_no']."' ";
				$result2 = $db->query_fetch_rows($query2);
				foreach($result2 as $row2)
					@unlink($alice['data_board_path']."/".$bo_table."/".$row2['file_name']);
					
				// 파일테이블 행 삭제
				$db->_query(" delete from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$row['wr_no']."' ");

				$count_write++;

			} else {

				// 코멘트 포인트 삭제
				if (!$point_control->point_delete($row['wr_id'], $bo_table, $row['wr_no'], '코멘트'))
					$point_control->point_insert($row['wr_id'], $board['bo_comment_point'] * (-1), $board['bo_subject']." ".$write['wr_no']."-".$row['wr_no']." 코멘트삭제");

				$count_comment++;

			}

		}

		// 게시글 삭제
		$db->_query(" delete from `".$write_table."` where `wr_parent` = '".$write['wr_no']."' ");

		// 최근게시물 삭제
		$db->_query(" delete from `".$alice['table_prefix']."board_new` where `bo_table` = '".$bo_table."' and `wr_parent` = '".$write['wr_no']."' ");

		// 스크랩 삭제

		// 글숫자 감소
		if ($count_write > 0 || $count_comment > 0)
			$db->_query(" update `".$alice['table_prefix']."board` set `bo_write_count` = bo_write_count - '".$count_write."', `bo_comment_count` = bo_comment_count - '".$count_comment."' where `bo_table` = '".$bo_table."' ");
        
        $is_mobile = $_POST['is_mobile'];
        if( $is_mobile ){
			$utility->popup_msg_js("", $alice['mobile_url']."/m/community/list.php?bo_table=".$bo_table);
        } else {
			$utility->popup_msg_js("","../board.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table);
        }
	
?>