<?php
		/*
		* /application/nad/board/process/regist.php
		* @author Harimao
		* @since 2013/06/10
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Board article regist
		* @Comment :: 게시판별 게시물 프로세스
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$code = $_POST['code'];
		$bo_table = $_POST['bo_table'];

		$no = $_POST['no'];
		$wr_id = $_POST['wr_id'];
		$wr_no = ($_POST['wr_no']) ? $_POST['wr_no'] : $no;

		$result = array();	// 최종 결과값

		$result['mode'] = $mode;

		$upload_max_filesize = ini_get('upload_max_filesize');
		if (empty($_POST)) {
			echo '0003';	// 파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
			exit;
		}
		$wr_link1 = mysql_real_escape_string($_POST['wr_link1']);
		$wr_link2 = mysql_real_escape_string($_POST['wr_link2']);

		$notice_array = explode("\n", trim($board['bo_notice']));

		$wr_subject = $_POST['wr_subject'];
		$wr_content = $_POST['wr_content'];
		$wr_name = $_POST['wr_name'];
		$wr_password = $_POST['wr_password'];
		$wr_secret = $_POST['wr_secret'];
		$wr_option = $_POST['wr_option'];
		$wr_category = $_POST['wr_category'];

		if (substr_count($wr_content, "&#") > 50) {
			echo '0004';	// 내용에 올바르지 않은 코드가 다수 포함되어 있습니다.
			exit;
		}

		// 입력/수정/답변 일때
		if($mode=='insert' || $mode=='update' || $mode=='reply'){ 
			if (!isset($_POST['wr_subject']) || !trim($_POST['wr_subject'])) {
				echo '0005';	// 제목을 입력해 주세요
				exit;
			}

			/* 게시판 데이터 저장 디렉토리 */
			$board_data_dir = $alice['data_board_path'] . '/' . $bo_table;
			$index_file = $board_data_dir . '/index.html';
			if(!file_exists($index_file)){	 // 디렉토리 보안을 위해
				@mkdir($board_data_dir, 0707); @chmod($board_data_dir, 0707);	// 우선 디렉토리 먼저 만들고
				$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);	// index.html 파일 생성
			}
			/* //게시판 데이터 저장 디렉토리 */

			$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

			/* 가변 파일 업로드 */
			$file_upload_msg = "";	// 파일 오류 메시지
			$upload = array();










            $f_del_no = $_POST['file_no_del'];
			if (count($f_del_no) > 0 ) {
			foreach($f_del_no as $key => $val) {

					$row = $db->query_fetch(" select `file_name` from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$key."' ");

					@unlink($board_data_dir."/".$row['file_name']);

					$db->_query(" delete from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$key."' ");

            }

			$rows = $db->query_fetch_rows(" select * from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' ");
	
			 for($j=0; $j < count($rows); $j++) {            

					$db->_query(" update `".$alice['table_prefix']."board_file` set `file_no`='".$j."' where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_name`='".$rows[$j]['file_name']."' ");
			 }
			       
			}









			for ($i=0; $i<count($_FILES['file_name']['name']); $i++) {
				/* 삭제에 체크가 되어있다면 파일을 삭제합니다. */
				if ($_POST['file_no_del'][$i]) {
					$upload[$i]['del_check'] = true;

					$row = $db->query_fetch(" select `file_name` from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
					@unlink($board_data_dir."/".$row['file_name']);

				} else
					$upload[$i]['del_check'] = false;
				/* //삭제에 체크가 되어있다면 파일을 삭제합니다. */

				$tmp_file  = $_FILES['file_name']['tmp_name'][$i];
				$filename  = $_FILES['file_name']['name'][$i];
				$filesize  = $_FILES['file_name']['size'][$i];

				// 서버에 설정된 값보다 큰파일을 업로드 한다면
				if ($filename){
					if ($_FILES['file_name']['error'][$i] == 1){
						$file_upload_msg .= "[".$filename."] 파일의 용량이 서버에 설정(".$upload_max_filesize.")된 값보다 크므로 업로드 할 수 없습니다.\\n";
						continue;
					} else if ($_FILES['file_name']['error'][$i] != 0) {
						$file_upload_msg .= "[".$filename."] 파일이 정상적으로 업로드 되지 않았습니다.\\n";
						continue;
					}
				}

				if (is_uploaded_file($tmp_file)) {

					// 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
					if ($filesize > $board['bo_upload_size']) {
						$file_upload_msg .= "[".$filename."] 파일의 용량(".number_format($filesize)." 바이트)이 게시판에 설정(".number_format($board['bo_upload_size'])." 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n";
						continue;
					}

					$timg = @getimagesize($tmp_file);

					if ( preg_match("/\.($board[bo_upload_ext_img])$/i", $filename) || preg_match("/\.($board[bo_upload_ext_fla])$/i", $filename) ) {
						if ($timg[2] < 1 || $timg[2] > 16) {
							continue;
						}
					}
					
					$upload[$i]['image'] = $timg;

					if ($mode == 'update') {
						// 존재하는 파일이 있다면 삭제합니다.
						$row = $db->query_fetch(" select `file_name` from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and file_no = '".$i."' ");
						@unlink($board_data_dir."/".$row['file_name']);
					}

					// 프로그램 원래 파일명
					$upload[$i]['source'] = $filename;
					$upload[$i]['filesize'] = $filesize;

					// 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
					$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

					shuffle($chars_array);
					$shuffle = implode("", $chars_array);

					$upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename))); 

					$dest_file = $board_data_dir . "/" . $upload[$i]['file'];

					// 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
					$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['file_name']['error'][$i]);

					// 올라간 파일의 퍼미션을 변경합니다.
					chmod($dest_file, 0606);
				}

			}
			/* //가변 파일 업로드 */

		}

		$wr = $board_control->get_write($write_table, $wr_no);

		switch($mode){

			## 입력
			case 'insert':

				if($is_admin){	// 관리자 일때
					$wr_email = $env['email'];
					$wr_homepage = $utility->set_http($HOST);
				} else {
					echo '0006';	// 관리자 페이지는 관리자만 글 작성이 가능합니다.
					exit;
				}

				$wr_num = $board_control->get_next_num($write_table);

				$vals['wr_num'] = $wr_num;
				$vals['wr_reply'] = $wr_reply;
				$vals['wr_category'] = $wr_category;
				$vals['wr_secret'] = $wr_secret;
				$vals['wr_option'] = $wr_option;
				$vals['wr_subject'] = $wr_subject;
				$vals['wr_content'] = $wr_content;
				$vals['wr_link1'] = $wr_link1;
				$vals['wr_link2'] = $wr_link2;
				$vals['wr_trackback'] = $_POST['wr_trackback'];
				//$vals['wr_id'] = $wr_id;
				$vals['wr_id'] = 'admin';
				$vals['wr_password'] = $wr_password;
				$vals['wr_name'] = $wr_name;
				$vals['wr_email'] = $wr_email;
				$vals['wr_homepage'] = $wr_homepage;
				$vals['wr_datetime'] = $alice['time_ymdhis'];
				$vals['wr_last'] = $alice['time_ymdhis'];
				$vals['wr_ip'] = $_SERVER['REMOTE_ADDR'];
				$vals['wr_is_admin'] = 1;
				$vals['wr_0'] = $_POST['wr_0'];
				$vals['wr_1'] = $_POST['wr_1'];
				$vals['wr_2'] = $_POST['wr_2'];
				$vals['wr_3'] = $_POST['wr_3'];
				$vals['wr_4'] = $_POST['wr_4'];
				$vals['wr_5'] = $_POST['wr_5'];
				$vals['wr_6'] = $_POST['wr_6'];
				$vals['wr_7'] = $_POST['wr_7'];
				$vals['wr_8'] = $_POST['wr_8'];
				$vals['wr_9'] = $_POST['wr_9'];
				
				$result['result'] = $board_control->_insert($vals, $bo_table);	// DB 입력

				$wr_no = $db->last_id();

				// 부모 아이디에 UPDATE
				$db->_query(" update `".$write_table."` set `wr_parent` = '".$wr_no."' where `wr_no` = '".$wr_no."' ");

				// 최근게시물 INSERT
				$db->_query(" insert into `".$alice['table_prefix']."board_new` set `bo_table` = '".$bo_table."', `wr_no` = '".$wr_no."', `wr_parent` = '".$wr_no."' , `bn_datetime` = '".$alice['time_ymdhis']."', `mb_id` = '".$wr_id."' ");

				// 게시글 1 증가
				$db->_query("update `".$alice['table_prefix']."board` set `bo_write_count` = `bo_write_count` + 1 where `bo_table` = '".$bo_table."'");

				if($wr_option=='notice'){	// 공지사항이라면
					$bo_notice = $wr_no . "\n" . $board['bo_notice'];
					$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");
				}

				// 글작성 포인트

			break;

			## 수정
			case 'update':

				if (!$wr['wr_no']) {
					echo '0008';	// 글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동하였을 수 있습니다.
					exit;
				}

				if(!$is_admin && $wr_option=='notice'){	// 공지사항은 관리자만 작성 가능
					echo '0009';	// 공지사항은 관리자만 작성 가능합니다.
					exit;
				}

				$wr_num = $board_control->get_next_num($write_table);
				$wr_reply = "";
			
				$vals['wr_category'] = $_POST['wr_category'];
				$vals['wr_option'] = $wr_option;
				$vals['wr_secret'] = $wr_secret;
				$vals['wr_subject'] = $wr_subject;
				$vals['wr_content'] = $wr_content;
				$vals['wr_link1'] = $wr_link1;
				$vals['wr_link2'] = $wr_link2;
				$vals['wr_trackback'] = $_POST['wr_trackback'];
				//$vals['wr_id'] = $wr_id;
				$vals['wr_name'] = $wr_name;
				$vals['wr_email'] = $wr_email;
				$vals['wr_homepage'] = $wr_homepage;
				$vals['wr_last'] = $alice['time_ymdhis'];
				$vals['wr_password'] = $wr_password;
				$vals['wr_0'] = $_POST['wr_0'];
				$vals['wr_1'] = $_POST['wr_1'];
				$vals['wr_2'] = $_POST['wr_2'];
				$vals['wr_3'] = $_POST['wr_3'];
				$vals['wr_4'] = $_POST['wr_4'];
				$vals['wr_5'] = $_POST['wr_5'];
				$vals['wr_6'] = $_POST['wr_6'];
				$vals['wr_7'] = $_POST['wr_7'];
				$vals['wr_8'] = $_POST['wr_8'];
				$vals['wr_9'] = $_POST['wr_9'];

				$result['result'] = $board_control->_update($vals, $bo_table, $wr_no);	// DB 수정

				$db->_query(" update `".$write_table."` set `wr_category` = '".$wr_category."' where `wr_parent` = '".$wr['wr_no']."' ");

				if($wr_option=='notice'){	// 공지사항이라면
					if (!in_array((int)$wr_no, $notice_array)){
						$bo_notice = $wr_no . '\n' . $board['bo_notice'];
						$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");
					}
				} else {
					$bo_notice = '';
					for ($i=0; $i<count($notice_array); $i++)
						if ((int)$wr_no != (int)$notice_array[$i])
							$bo_notice .= $notice_array[$i] . '\n';
					$bo_notice = trim($bo_notice);
					$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");
				}

			break;

			## 답변
			case 'reply':

				if (!$wr['wr_no']) {
					echo '0008';	// 글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동하였을 수 있습니다.
					exit;
				}

				if (in_array((int)$wr_no, $notice_array)) {
					echo '0011';	// 공지에는 답변 할 수 없습니다.
					exit;
				}

				// 게시글 배열 참조
				$reply_array = &$wr;
				// 최대 답변은 테이블에 잡아놓은 wr_reply 사이즈만큼만 가능합니다.
				if (strlen($reply_array['wr_reply']) == 10) {
					echo '0012';	// 더 이상 답변하실 수 없습니다.\\n\\n답변은 10단계 까지만 가능합니다.
					exit;
				}

				$reply_len = strlen($reply_array['wr_reply']) + 1;
				if ($board['bo_reply_order']) {
					$begin_reply_char = "A";
					$end_reply_char = "Z";
					$reply_number = +1;
					$query = " select MAX(SUBSTRING(wr_reply, ".$reply_len.", 1)) as reply from `".$write_table."` where `wr_num` = '".$reply_array['wr_num']."' and SUBSTRING(wr_reply, ".$reply_len.", 1) <> '' ";
				} else {
					$begin_reply_char = "Z";
					$end_reply_char = "A";
					$reply_number = -1;
					$query = " select MIN(SUBSTRING(wr_reply, ".$reply_len.", 1)) as reply from `".$write_table."` where wr_num = '".$reply_array['wr_num']."' and SUBSTRING(wr_reply, ".$reply_len.", 1) <> '' ";
				}

				if ($reply_array['wr_reply']) $query .= " and `wr_reply` like '".$reply_array['wr_reply']."%' ";

				$row = $db->query_fetch($query);

				if (!$row['reply']){
					$reply_char = $begin_reply_char;
				} else if ($row['reply'] == $end_reply_char) { // A~Z은 26 입니다.
					echo '0013';	// 더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.
					exit;
				} else {
					$reply_char = chr(ord($row[reply]) + $reply_number);
				}

				$reply = $reply_array['wr_reply'] . $reply_char;

				if ($wr_secret)	// 답변의 원글이 비밀글이라면 패스워드는 원글과 동일하게 넣는다.
					$wr_password = $wr['wr_password'];

				$wr_no = $wr_no . $reply;
				$wr_num = $write['wr_num'];
				$wr_reply = $reply;

				$vals['wr_num'] = $wr_num;
				$vals['wr_reply'] = $wr_reply;
				$vals['wr_category'] = $_POST['wr_category'];
				$vals['wr_option'] = $wr_option;
				$vals['wr_secret'] = $wr_secret;
				$vals['wr_subject'] = $wr_subject;
				$vals['wr_content'] = $wr_content;
				$vals['wr_link1'] = $wr_link1;
				$vals['wr_link2'] = $wr_link2;
				$vals['wr_trackback'] = $_POST['wr_trackback'];
				$vals['wr_id'] = $wr_id;
				$vals['wr_password'] = $wr_password;
				$vals['wr_name'] = $wr_name;
				$vals['wr_email'] = $wr_email;
				$vals['wr_homepage'] = $wr_homepage;
				$vals['wr_datetime'] = $alice['time_ymdhis'];
				$vals['wr_last'] = $alice['time_ymdhis'];
				$vals['wr_ip'] = $_SERVER['REMOTE_ADDR'];
				$vals['wr_is_admin'] = 1;
				$vals['wr_0'] = $_POST['wr_0'];
				$vals['wr_1'] = $_POST['wr_1'];
				$vals['wr_2'] = $_POST['wr_2'];
				$vals['wr_3'] = $_POST['wr_3'];
				$vals['wr_4'] = $_POST['wr_4'];
				$vals['wr_5'] = $_POST['wr_5'];
				$vals['wr_6'] = $_POST['wr_6'];
				$vals['wr_7'] = $_POST['wr_7'];
				$vals['wr_8'] = $_POST['wr_8'];
				$vals['wr_9'] = $_POST['wr_9'];
				
				$result['result'] = $board_control->_insert($vals, $bo_table);	// DB 입력

				$wr_no = $db->last_id();

				// 부모 아이디에 UPDATE
				$db->_query(" update `".$write_table."` set `wr_parent` = '".$wr_no."' where `wr_no` = '".$wr_no."' ");

				// 최근게시물 INSERT
				$db->_query(" insert into `".$alice['table_prefix']."board_new` set `bo_table` = '".$bo_table."', `wr_no` = '".$wr_no."', `wr_parent` = '".$wr_no."' , `bn_datetime` = '".$alice['time_ymdhis']."', `mb_id` = '".$wr_id."' ");

				// 게시글 1 증가
				$db->_query("update `".$alice['table_prefix']."board` set `bo_write_count` = `bo_write_count` + 1 where `bo_table` = '".$bo_table."'");

				if($wr_option=='notice'){	// 공지사항이라면
					$bo_notice = $wr_no . "\n" . $board['bo_notice'];
					$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");
				}

				// 글작성 포인트 (답변글은 글작성 포인트로 대체)

			break;

			## 삭제
			case 'delete':

				if($wr_no){	 // wr_no 가 존재하는 유효한 경우 삭제 실행
					
					if($is_admin){

					}/* else if($mb_id) {
						if ($member[mb_id] != $write[mb_id]){
							echo '0128';	// 자신의 글이 아니므로 삭제할 수 없습니다.
							exit;
						}
					} else {
						if ($write['mb_id']){
							echo '0129';	// 로그인 후 삭제하세요
							exit;
						} else if ($wr_password != $write['wr_password']){
							echo '0130';	// 패스워드가 틀리므로 삭제할 수 없습니다.
							exit;
						}
					}*/

					if($board['bo_use_delete']){	// 게시글 삭제시 삭제된 게시물로 표시

						// 최근게시물 삭제
						$db->_query(" delete from `".$alice['table_prefix']."board_new` where `bo_table` = '".$bo_table."' and `wr_parent` = '".$write['wr_no']."' ");

						// 공지사항 삭제
						$notice_array = explode("\n", trim($board['bo_notice']));
						$bo_notice = "";
						for ($k=0; $k<count($notice_array); $k++)
							if ((int)$write['wr_no'] != (int)$notice_array[$k])
								$bo_notice .= $notice_array[$k] . "\n";
						$bo_notice = trim($bo_notice);
						$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");

						/*
						// 업로드된 파일이 있다면 파일삭제
						$query1 = " select * from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$write['wr_no']."' ";
						$result1 = $db->query_fetch_rows($query1);
						foreach($result1 as $row1) {
							@unlink($board_data_dir."/".$row1['file_name']);							
							// 파일테이블 행 삭제
							$db->_query(" delete from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$row1['wr_no']."' ");
						}
						*/
						
						$vals['wr_option'] = '';
						$vals['wr_del'] = 1;
						$vals['wr_last'] = $alice['time_ymdhis'];

						$result['result'] = $board_control->_update($vals,$bo_table,$wr_no);

					} else {	 // 진짜 삭제

						$len = strlen($write['wr_reply']);
						if ($len < 0) $len = 0; 
						$reply = substr($write['wr_reply'], 0, $len);

						// 원글만 구한다.
						$query = " select count(*) as cnt from `".$write_table."` where `wr_reply` like '".$reply."%' and `wr_no` <> '".$write['wr_no']."' and `wr_num` = '".$write['wr_num']."' and `wr_is_comment` = 0 ";
						$row = $db->query_fetch($query);
						if ($row['cnt'] && !$is_admin) {
							echo '0015';	// 이 글과 관련된 답변글이 존재하므로 삭제 할 수 없습니다.\\n\\n우선 답변글부터 삭제하여 주십시오.
							exit;
						}
						// 코멘트 달린 원글의 삭제 여부
						$query = " select count(*) as cnt from `".$write_table."` where `wr_parent` = '".$wr_no."' and `wr_id` <> '".$mb_id."' and `wr_is_comment` = 1 ";
						$row = $db->query_fetch($query);
						if ($row['cnt'] >= $board['bo_count_delete'] && !$is_admin) {
							echo '0016';	// 이 글과 관련된 코멘트가 존재하므로 삭제 할 수 없습니다.\\n\\n코멘트를 먼저 삭제해 주세요.
							exit;
						}

						$query = " select `wr_no`, `wr_id`, `wr_is_comment` from `".$write_table."` where `wr_parent` = '".$write['wr_no']."' order by `wr_no` ";
						$result1 = $db->query_fetch_rows($query);
						$count_write = $count_comment = 0;
						foreach($result1 as $row){
							if (!$row['wr_is_comment']) {	// 원글이라면
								/*
								// 원글 포인트 삭제
								if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '쓰기'))
									insert_point($row[mb_id], $board[bo_write_point] * (-1), "$board[bo_subject] $row[wr_id] 글삭제");
								*/
								// 업로드된 파일이 있다면 파일삭제
								$query2 = " select * from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$row['wr_no']."' ";
								$result2 = $db->query_fetch_rows($query2);
								foreach($result2 as $row2)
									@unlink($board_data_dir."/".$row2['file_name']);
									
								// 파일테이블 행 삭제
								$db->_query(" delete from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$row['wr_no']."' ");
								$count_write++;
							} else {
								/*
								// 코멘트 포인트 삭제
								if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '코멘트'))
									insert_point($row[mb_id], $board[bo_comment_point] * (-1), "$board[bo_subject] {$write[wr_id]}-{$row[wr_id]} 코멘트삭제");
								*/
								$count_comment++;
							}
						}

						// 게시글 삭제
						$result['result'] = $db->_query(" delete from `".$write_table."` where `wr_parent` = '".$write['wr_no']."' ");

						// 최근게시물 삭제
						$db->_query(" delete from `".$alice['table_prefix']."board_new` where `bo_table` = '".$bo_table."' and `wr_parent` = '".$write['wr_no']."' ");

						// 공지사항 삭제
						$notice_array = explode("\n", trim($board['bo_notice']));
						$bo_notice = "";
						for ($k=0; $k<count($notice_array); $k++)
							if ((int)$write['wr_no'] != (int)$notice_array[$k])
								$bo_notice .= $notice_array[$k] . "\n";
						$bo_notice = trim($bo_notice);
						$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");

						// 글숫자 감소
						if ($count_write > 0 || $count_comment > 0)
							$db->_query(" update `".$alice['table_prefix']."board` set `bo_write_count` = `bo_write_count` - ".$count_write.", `bo_comment_count` = `bo_comment_count` - ".$count_comment." where `bo_table` = '".$bo_table."' ");

					}

				} else {

					echo '0014';	// 삭제할 데이터가 없거나 이미 삭제된 데이터 입니다.
					exit;

				}

			break;

			## 선택 삭제
			case 'sel_delete':

				$count_write = 0;
				$count_comment = 0;

				$tmp_array = $_POST['wr_no'];
				$wr_no_cnt = count($tmp_array);

				for ($i=$wr_no_cnt-1; $i>=0; $i--) {	// 거꾸로 읽는다

					$write = $db->query_fetch(" select * from `".$write_table."` where `wr_no` = '".$tmp_array[$i]."' ");
					
					if($board['bo_use_delete']){	// 게시글 삭제시 삭제된 게시물로 표시
						
						/*
						// 업로드된 파일이 있다면 파일삭제
						$query1 = " select * from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$write['wr_no']."' ";
						$result1 = $db->query_fetch_rows($query1);
						foreach($result1 as $row1) {
							@unlink($board_data_dir."/".$row1['file_name']);
							// 파일테이블 행 삭제
							$db->_query(" delete from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$row1['wr_no']."' ");
						}
						*/
						
						$vals['wr_option'] = '';
						$vals['wr_del'] = 1;
						$vals['wr_last'] = $alice['time_ymdhis'];

						$result['result'] = $board_control->_update($vals,$bo_table,$write['wr_no']);

						// 최근게시물 삭제
						$db->_query(" delete from `".$alice['table_prefix']."board_new` where `bo_table` = '".$bo_table."' and `wr_parent` = '".$write['wr_no']."' ");

						// 공지사항 삭제
						$notice_array = explode("\n", trim($board['bo_notice']));
						$bo_notice = "";
						for ($k=0; $k<count($notice_array); $k++)
							if ((int)$write['wr_no'] != (int)$notice_array[$k])
								$bo_notice .= $notice_array[$k] . "\n";
						$bo_notice = trim($bo_notice);
						$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");
						$board[bo_notice] = $bo_notice;


					} else {

						/*
						if(!$is_admin){	// 관리자가 아니라면
							if ($mb_id && $mb_id == $write['mb_id']) {	// 자신의 글이라면
								;
							} else if ($wr_password && !$write[mb_id] && sql_password($wr_password) == $write[wr_password]) {	// 패스워드가 같다면
								;
							} else
								continue;   // 나머지는 삭제 불가
						}
						*/

						$len = strlen($write['wr_reply']);
						if ($len < 0) $len = 0; 
						$reply = substr($write['wr_reply'], 0, $len);

						// 원글만 구한다.
						$query = " select count(*) as cnt from `".$write_table."` where `wr_reply` like '".$reply."%' and `wr_id` <> '".$write['wr_no']."' and `wr_num` = '".$write['wr_num']."' and `wr_is_comment` = 0 ";
						$row = $db->_query($query);
						if ($row['cnt']) continue;

						$query = " select `wr_no`, `wr_id`, `wr_is_comment` from `".$write_table."` where `wr_parent` = '".$write['wr_no']."' order by `wr_no` ";
						$result1 = $db->query_fetch_rows($query);
						foreach($result1 as $row){
							// 원글이라면
							if (!$row['wr_is_comment']) {
								/*
								// 원글 포인트 삭제
								if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '쓰기'))
									insert_point($row[mb_id], $board[bo_write_point] * (-1), "$board[bo_subject] $row[wr_id] 글삭제");
								*/
								// 업로드된 파일이 있다면 파일삭제
								$query2 = " select * from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$row['wr_no']."' ";
								$result2 = $db->query_fetch_rows($query2);
								foreach($result2 as $row2)
									@unlink($board_data_dir."/".$row2['file_name']);
								// 파일테이블 행 삭제
								$db->_query(" delete from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$row['wr_no']."' ");
								$count_write++;
							} else  {
								/*
								// 코멘트 포인트 삭제
								if (!delete_point($row[mb_id], $bo_table, $row[wr_id], '코멘트'))
									insert_point($row[mb_id], $board[bo_comment_point] * (-1), "$board[bo_subject] {$write[wr_id]}-{$row[wr_id]} 코멘트삭제");
								*/
								$count_comment++;
							}
						}

						// 게시글 삭제
						$result['result'] = $db->_query(" delete from `".$write_table."` where `wr_parent` = '".$write['wr_no']."' ");

						// 최근게시물 삭제
						$db->_query(" delete from `".$alice['table_prefix']."board_new` where `bo_table` = '".$bo_table."' and `wr_parent` = '".$write['wr_no']."' ");

						// 공지사항 삭제
						$notice_array = explode("\n", trim($board['bo_notice']));
						$bo_notice = "";
						for ($k=0; $k<count($notice_array); $k++)
							if ((int)$write['wr_no'] != (int)$notice_array[$k])
								$bo_notice .= $notice_array[$k] . "\n";
						$bo_notice = trim($bo_notice);
						$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");
						$board[bo_notice] = $bo_notice;

					}	// bo_use_delete if end.

				}	// for end.

				// 글숫자 감소
				if ($count_write > 0 || $count_comment > 0)
					$db->_query(" update `".$alice['table_prefix']."board` set `bo_write_count` = `bo_write_count` - ".$count_write.", `bo_comment_count` = `bo_comment_count` - ".$count_comment." where `bo_table` = '".$bo_table."' ");

			break;

			## 게시물 보기
			case 'view':
			
				$result = $board_control->_view($bo_table, $wr_no);

				echo $result;
				exit;

			break;

		}

		/* 가변 파일 업로드 */
		$upload_cnt = count($upload);

		if($upload_cnt >= 1){

			for ($i=0; $i<$upload_cnt; $i++) {

				if (!get_magic_quotes_gpc()) {
					$upload[$i]['source'] = addslashes($upload[$i]['source']);
				}

				$row = $db->query_fetch(" select count(*) as cnt from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");

				if ($row['cnt']) {
					if ($upload[$i]['del_check'] || $upload[$i]['file']) {
						$file_vals['file_source'] = $upload[$i]['source'];
						$file_vals['file_name'] = $upload[$i]['file'];
						$file_vals['file_filesize'] = $upload[$i]['filesize'];
						$file_vals['file_width'] = $upload[$i]['image'][0];
						$file_vals['file_height'] = $upload[$i]['image'][1];
						$file_vals['file_type'] = $upload[$i]['image'][2];
						$file_vals['file_datetime'] = date('Y-m-d H:i:s');
						$file_val = $utility->QueryString( $file_vals );
						$db->_query(" update `".$alice['table_prefix']."board_file` set " . $file_val . " where `bo_table` = '" . $bo_table . "' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
					} else {
						$file_valss['file_content'] = $file_content[$i];
						$file_val1 = $utility->QueryString( $file_valss );
						$db->_query(" update `".$alice['table_prefix']."board_file` set " . $file_val1 . " where `bo_table` = '" . $bo_table . "' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
					}
				} else {
					$file_vals['bo_table'] = $bo_table;
					$file_vals['wr_no'] = $wr_no;
					$file_vals['file_no'] = $i;
					$file_vals['file_source'] = $upload[$i]['source'];
					$file_vals['file_name'] = $upload[$i]['file'];
					$file_vals['file_content'] = $file_content[$i];
					$file_vals['file_download'] = 0;
					$file_vals['file_filesize'] = $upload[$i]['filesize'];
					$file_vals['file_width'] = $upload[$i]['image'][0];
					$file_vals['file_height'] = $upload[$i]['image'][1];
					$file_vals['file_type'] = $upload[$i]['image'][2];
					$file_vals['file_datetime'] = date('Y-m-d H:i:s');
					$file_val = $utility->QueryString( $file_vals );
					$db->_query(" insert into `".$alice['table_prefix']."board_file` set " . $file_val);
				}

			}

			$row = $db->query_fetch(" select max(file_no) as max_file_no from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' ");
			for ($i=(int)$row['max_file_no']; $i>=0; $i--) {
				$row2 = $db->query_fetch(" select `file_name` from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
				if ($row2['file_name']) break;
				$db->_query(" delete from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
			}

		}
		/* // 가변 파일 업로드 */

		$result['wr_category'] = $wr_category;

		echo @implode($result,'/');

?>