<?php
		/*
		* /application/board/process/regist.php
		* @author Harimao
		* @since 2013/10/29
		* @last update 2015/03/09
		* @Module v3.5 ( Alice )
		* @Brief :: Board regist
		* @Comment :: 게시판 프로세스 (사용자측은 공지사항을 작성 할수 없으므로 공지사항 로직은 빠짐)
		*/

		$alice_path = "../";

		$cat_path = "../";

		include_once $alice_path . "_core.php";

		if($_GET['mode']=='board_delete') $_POST['mode'] = 'delete';
		$mode = $_POST['mode'] ? $_POST['mode'] : $_GET['mode'];
		
		$board_code = $_POST['board_code'] ? $_POST['board_code'] : $_GET['board_code'];
		$code = $_POST['code'] ? $_POST['code'] : $_GET['code'];
		$no = $_POST['no'] ? $_POST['no'] : $_GET['no'];
		$wr_no = ($_POST['wr_no']) ? $_POST['wr_no'] : $_GET['wr_no'];
		$wr_no = $wr_no ? $wr_no : $no;
		$sca = $_POST['sca'];	// 카테고리
		$bo_table = $_POST['bo_table'] ? $_POST['bo_table'] : $_GET['bo_table'];

		$token = ($_GET['token']) ? $_GET['token'] : $_POST['token'];
		$wr_password = $_POST['wr_password'];

		$comment_id = $_POST['comment_id'];	// 코멘트 no


		$upload_max_filesize = ini_get('upload_max_filesize');
		/*
		if (empty($_POST)) {
			$utility->popup_msg_js($board_control->_errors('0032'));	// 파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.
			exit;
		}
		*/

		/* 현재 버전에선 사용하지 않음
		$wr_link1 = mysql_real_escape_string($_POST['wr_link1']);
		$wr_link2 = mysql_real_escape_string($_POST['wr_link2']);
		*/

		$wr_subject = $_POST['wr_subject'];
		$wr_content = $_POST['wr_content'];
		$wr_name = $_POST['wr_name'];
		$wr_password = $_POST['wr_password'];

		$wr_secret = $_POST['wr_secret'];	// 비밀글 체크
		$wr_option = $_POST['wr_option'];	// 옵션(공지사항 등등)

		$html = $_POST['html'];	// 다이나믹 태그(HTML) 사용유무

		if (substr_count($wr_content, "&#") > 50) {
			$utility->popup_msg_js($board_control->_errors('0004'));	// 내용에 올바르지 않은 코드가 다수 포함되어 있습니다.
			exit;
		}


		// : 비밀번호 체크 - 비밀번호 입력안해도 되는지 아닌지 체크
		if($_POST['mode']=='reply_delete_chk') {
			$row = sql_fetch("select * from $write_table where `wr_no`='".addslashes($_POST['comment_id'])."'");
			$arr['js'] = "";
			if($row['wr_id']==$member['mb_id']) {
				$arr['js'] = "netfu_board.reply_process(el, '".$_POST['comment_id']."')";
			}
			die(json_encode($arr));
			exit;
		}


		// 비회원의 경우 이름이 누락되는 경우가 있음
		if (!$member['mb_id'] && !in_array($_POST['mode'], array('password_confirm', 'delete', 'rand_number_check')) && !$is_member && !$is_admin) {
			if (!trim($wr_name)) {
				$utility->popup_msg_js($config->_errors('0124'));	// 이름은 필히 입력하셔야 합니다.
				exit;
			}
		}

		// : 댓글 랜덤숫자 체크
		if($_POST['mode']=='rand_number_check') {
			$arr['msg'] = "";
			if(!$member['mb_id'] && $_SESSION['_reply_rand_'][$_POST['no']]!=$_POST['wr_key']) {
				$arr['msg'] = "자동등록방지 문자를 올바르게 입력해주시기 바랍니다.";
			} else {
			}
			die(json_encode($arr));
		}


		### : 비밀번호 묻는경우.
		$_password = md5($_POST['passwd']);
		if($_POST['wr_password']) $_password = md5($_POST['wr_password']);
		if($_POST['mode']=='password_confirm') {

			// : 수정
			if($_POST['bo_mode']=='update'){
				$action = "./write.php?board_code=".$_POST['board_code']."&code=".$_POST['code']."&bo_table=".$_POST['bo_table']."&wr_no=".$_POST['wr_no'];

			// : 삭제
			} else if($_POST['bo_mode']=='delete'){
				$_POST['mode'] = 'delete';
				include "./regist.php";
				exit;

			// : 글읽기
			} else if($_POST['bo_mode']=='read') {
				$bo_row = sql_fetch("select * from ".$write_table." where `wr_no`='".addslashes($_POST['wr_no'])."'");
				if($bo_row['wr_password'] && $bo_row['wr_password']!=$_password && $bo_row['wr_id']!=$member['mb_id']) {
					$arr['msg'] = "비밀번호를 정확히 입력해주시기 바랍니다.";
					$netfu_util->page_move($arr['msg'], $_SERVER['HTTP_REFERER']);
				} else {
					$wr = $board_control->get_write($write_table, $wr_no);
					$ss_name = "view_secret_".$bo_table."_".$wr['wr_no'];
					$utility->set_session($ss_name, TRUE);
					$arr['move'] = NFE_URL.'/board/detail.php?board_code='.$_POST['board_code'].'&code='.$_POST['code'].'&bo_table='.$_POST['bo_table'].'&no='.$_POST['wr_no'];
					$netfu_util->page_move('', $arr['move']);
				}
			// : 기타 [ 댓글 ]
			} else if($_POST['bo_mode']=='comment_update') {
				$_table = 'alice_write_'.addslashes($_POST['bo_table']);
				$bo_row = sql_fetch("select * from ".$_table." where `wr_no`='".addslashes($_POST['comment_id'])."'");
				$arr['js'] = "";
				$arr['msg'] = "";
				if(!$bo_row['wr_id'] && $bo_row['wr_password'] && $bo_row['wr_password']!=$_password) {
					$arr['msg'] = "비밀번호를 정확히 입력해주시기 바랍니다.";
				} else {
					if($bo_row['wr_id']!=$member['mb_id']) {
						$arr['msg'] = "작성자만 허용가능합니다.";
					} else {
						switch($_POST['reply_mode']) {
							case "delete":
								$delete = sql_query("delete from ".$_table." where `wr_no`='".addslashes($_POST['comment_id'])."'");
								if($delete) {
									$arr['msg'] = "삭제가 완료되었습니다.";
									$arr['js'] = '$("#c_'.$_POST['comment_id'].'").remove();';

									// 코멘트 삭제
									if (!$point_control->point_delete($bo_row['wr_id'], $bo_table, $comment_id, '코멘트'))
										$point_control->point_insert($bo_row['wr_id'], $board['bo_comment_point'] * (-1), $board['bo_subject']." ". $bo_row['wr_parent']."-".$comment_id." 코멘트삭제");

									// 코멘트가 삭제되므로 해당 게시물에 대한 최근 시간을 다시 얻는다.
									$sql = " select max(wr_datetime) as wr_last from `".$write_table."` where `wr_parent` = '".$bo_row['wr_parent']."' ";
									$row = $db->query_fetch($sql);
																		  
									// 원글의 코멘트 숫자를 감소
									$db->_query(" update `".$write_table."` set `wr_comment` = `wr_comment` - 1, `wr_last` = '".$row['wr_last']."' where `wr_no` = '".$bo_row['wr_parent']."' ");

									// 코멘트 숫자 감소
									$db->_query(" update `".$alice['table_prefix']."board` set `bo_comment_count` = `bo_comment_count` - 1 where `bo_table` = '".$bo_table."' ");

									// 새글 삭제
									$db->_query(" delete from `".$alice['table_prefix']."board_new` where `bo_table` = '".$bo_table."' and `wr_no` = '".$comment_id."' ");
								} else {
									$arr['msg'] = "삭제가 실패되었습니다.";
								}

								break;
							default:
								$arr['js'] = '$(".comment_con.reply_reply_write").addClass("_none");$(".reply_write_"+no).removeClass("_none");';
								break;
						}
					}
				}
				die(json_encode($arr));
			} else if($_POST['bo_mode']=='comment_delete'){
				$action = "./delete_comment.php";
			} else if($_POST['bo_mode']=='view'){
				$action = "./password_check.php";
			} else {
				$action = "./password_check.php";
			}

			$_table = 'alice_write_'.addslashes($_POST['bo_table']);
			$bo_row = sql_fetch("select * from ".$_table." where `wr_no`='".addslashes($_POST['wr_no'])."'");
			if(!($member['mb_id'] && $member['mb_id'] == $bo_row['wr_id'])){
				if(md5($wr_password) != $bo_row['wr_password']){
					$utility->popup_msg_js($board_control->_errors('0037'), $_SERVER['HTTP_REFERER']);
				} else {
					$utility->popup_msg_js("", $action);
				}
			}
			exit;
		}

		/* captcha 확인 */
		if (!$member['mb_id'] && !in_array($_POST['mode'], array('password_confirm', 'delete'))) {

			$key = $_SESSION['rand_nums'];
			if (!($key && strtolower($key) == strtolower($_POST['wr_key']))) {
				$_SESSION['rand_nums'] = "";
				$utility->popup_msg_js($board_control->_errors('0029'));	// 정상적인 접근이 아닌것 같습니다.
				exit;
			}
			/* //captcha 확인 */
		}

		if($mode=='insert' || $mode=='update' || $mode=='reply'){	 // 입력/수정/답변 일때

			if (!isset($_POST['wr_subject']) || !trim($_POST['wr_subject'])) {
				$utility->popup_msg_js($config->_errors('0079'));	// 제목을 입력해 주세요
				exit;
			}

			$board_data_dir = $alice['data_board_path'] . '/' . $bo_table;
			@mkdir($board_data_dir, 0707);
			@chmod($board_data_dir, 0707);

			$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

			// 가변 파일 업로드
			$file_upload_msg = "";
			$upload = array();

			for ($i=0; $i<count($_FILES['file_name']['name']); $i++) {
				// 삭제에 체크가 되어있다면 파일을 삭제합니다.
				if ($_POST['file_no_del'][$i]) {
					$upload[$i]['del_check'] = true;

					$row = $db->query_fetch(" select `file_name` from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
					@unlink($board_data_dir."/".$row['file_name']);
				} else
					$upload[$i]['del_check'] = false;

				$tmp_file  = $_FILES['file_name']['tmp_name'][$i];
				$filename  = $_FILES['file_name']['name'][$i];
				$filesize  = $_FILES['file_name']['size'][$i];

				// 서버에 설정된 값보다 큰파일을 업로드 한다면
				if ($filename){
					if ($_FILES['file_name']['error'][$i] == 1){
						$file_upload_msg .= "[".$filename."] 파일의 용량이 서버에 설정(".$upload_max_filesize.")된 값보다 크므로 업로드 할 수 없습니다.\\n";
						$utility->popup_msg_alert($file_upload_msg);
					} else if ($_FILES['file_name']['error'][$i] != 0) {
						$file_upload_msg .= "[".$filename."] 파일이 정상적으로 업로드 되지 않았습니다.\\n";
						$utility->popup_msg_alert($file_upload_msg);
					}
				}

				if (is_uploaded_file($tmp_file)) {
					// 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
					if (!$is_admin && $filesize > $board['bo_upload_size']) {
						$file_upload_msg .= "[".$filename."] 파일의 용량(".number_format($filesize)." 바이트)이 게시판에 설정(".number_format($board['bo_upload_size'])." 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n";
						$utility->popup_msg_alert($file_upload_msg);
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
						$row = $db->query_fetch(" select `file_name` from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
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

			if($mode=='insert' || $mode=='reply'){
				
				if($is_member) {	 // 회원일때
					if($member['mb_id']){
						$wr_id = $member['mb_id'];
						$wr_name = (!$board['bo_use_name']) ? $member['mb_nick'] : $member['mb_name'];
						$wr_password = $member['mb_password'];
						$wr_email = $member['mb_email'];
						$wr_homepage = $member['mb_homepage'];
					}
				} else {	 // 비회원
					$wr_id = "guest";
					if (!trim($wr_name)) {	// 비회원의 경우 이름이 누락되는 경우가 있음
						echo $utility->popup_msg_js($config->_errors('0124'));	// 이름은 필히 입력하셔야 합니다.
						exit;
					}
					$wr_password = md5($wr_password);	 // 패스워드 꼬기
					$wr_email = ($_POST['wr_email']) ? $_POST['wr_email'] : "";	// 비회원이 이메일을 입력했다면 (스킨에서 wr_email 변수 설정)
					$wr_homepage = ($_POST['wr_homepage']) ? $_POST['wr_homepage'] : "";	// 비회원이 홈페이지를 입력했다면 (스킨에서 wr_homepage 변수 설정)
				}

				/* 동일내용 연속 등록 불가 */
				$row = $db->query_fetch(" select MD5(CONCAT(wr_ip, wr_subject, wr_content)) as prev_md5 from `".$write_table."` order by `wr_no` desc limit 1 ");
				$curr_md5 = md5($_SERVER['REMOTE_ADDR'].$wr_subject.$wr_content);
				if ($row['prev_md5'] == $curr_md5 && !$is_admin){
					$utility->popup_msg_js($board_control->_errors('0033'));	// 동일한 내용을 연속해서 등록할 수 없습니다.
					exit;
				}
				/* //동일내용 연속 등록 불가 */

			}

		}


		$wr = $board_control->get_write($write_table, $wr_no);

		switch($mode){

			## 게시글 작성
			case 'insert':

				/* 비밀글 작성 확인 */
				if(!$board['bo_use_secret'] && $wr_secret){	 // 비밀글을 사용하지 않는데 비밀글을 체크했다면
					$utility->popup_msg_js($board_control->_errors('0034'));	// 비밀글 미사용 게시판 이므로 비밀글로 등록할 수 없습니다.
					exit;
				}
				/* //비밀글 작성 확인 */

				/* 글 작성 권한 확인 */
				if($member['mb_level'] < $board['bo_write_level']){
					$utility->popup_msg_js($board_control->_errors('0026'));	// 글을 쓸 권한이 없습니다.
				}
				/* //글 작성 권한 확인 */

				/* 20초 제한 */
				if ($_SESSION["ss_datetime"] >= ($alice['server_time'] - 20) && !$is_admin) {
					$utility->popup_msg_js($board_control->_errors('0035'));	// 너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.
					exit;
				}
				$utility->set_session("ss_datetime", $alice['server_time']);
				/* //20초 제한 */

				$wr_num = $board_control->get_next_num($write_table);

				$vals['wr_num'] = $wr_num;
				$vals['wr_reply'] = $wr_reply;
				$vals['wr_category'] = $_POST['wr_category'];
				$vals['wr_secret'] = $wr_secret;
				$vals['wr_option'] = $wr_option;
				$vals['wr_subject'] = $wr_subject;
				$vals['wr_content'] = $wr_content;
				//$vals['wr_link1'] = $wr_link1;
				//$vals['wr_link2'] = $wr_link2;
				//$vals['wr_trackback'] = $_POST['wr_trackback'];
				$vals['wr_id'] = $wr_id;
				$vals['wr_password'] = $wr_password;
				$vals['wr_name'] = $wr_name;
				$vals['wr_email'] = $wr_email;
				$vals['wr_homepage'] = $wr_homepage;
				$vals['wr_datetime'] = $alice['time_ymdhis'];
				$vals['wr_last'] = $alice['time_ymdhis'];
				$vals['wr_ip'] = $_SERVER['REMOTE_ADDR'];
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
			
				$result = $board_control->_insert($vals, $bo_table);	// DB 입력

				$wr_no = $db->last_id();

				// 부모 아이디에 UPDATE
				$db->_query(" update `".$write_table."` set `wr_parent` = '".$wr_no."' where `wr_no` = '".$wr_no."' ");

				// 최근게시물 INSERT
				$db->_query(" insert into `".$alice['table_prefix']."board_new` set `bo_table` = '".$bo_table."', `wr_no` = '".$wr_no."', `wr_parent` = '".$wr_no."' , `bn_datetime` = '".$alice['time_ymdhis']."', `mb_id` = '".$wr_id."' ");

				// 게시글 1 증가
				$db->_query("update `".$alice['table_prefix']."board` set `bo_write_count` = `bo_write_count` + 1 where `bo_table` = '".$bo_table."'");

				if($wr_secret){	// 비밀글에 체크가 되어 있다면
					$ss_name = "view_secret_" . $bo_table . "_" . $wr_no;
					$utility->set_session($ss_name,true);
				}

				// 글작성 포인트
				$point_control->point_insert($member['mb_id'], $board['bo_write_point'], $board['bo_subject']." ".$wr_id." 글쓰기", $bo_table, $wr_no, "쓰기");

			break;

			## 게시글 답변
			case 'reply':

				/* 글 답변 권한 확인 */
				if($member['mb_level'] < $board['bo_reply_level']){
					$utility->popup_msg_js($board_control->_errors('0028'));	// 글을 답변할 권한이 없습니다.
				}
				/* //글 답변 권한 확인 */

				// 게시글 배열 참조
				$reply_array = &$wr;

				// 최대 답변은 테이블에 잡아놓은 wr_reply 사이즈만큼만 가능합니다.
				if (strlen($reply_array['wr_reply']) == 10) {
					$utility->popup_msg_js($board_control->_errors('0012'));	// 더 이상 답변하실 수 없습니다.\\n\\n답변은 10단계 까지만 가능합니다.
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

				if (!$row['reply']) {
					$reply_char = $begin_reply_char;
				} else if ($row['reply'] == $end_reply_char) { // A~Z은 26 입니다.
					$utility->popup_msg_js($board_control->_errors('0013'));	// 더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.
					exit;
				} else {
					$reply_char = chr(ord($row['reply']) + $reply_number);
				}

				$reply = $reply_array['wr_reply'] . $reply_char;

				/* 20초 제한 */
				if ($_SESSION["ss_datetime"] >= ($alice['server_time'] - 20)) {
					$utility->popup_msg_js($board_control->_errors('0035'));	// 너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.
					exit;
				}
				$utility->set_session("ss_datetime", $alice['server_time']);
				/* //20초 제한 */

				// 답변의 원글이 비밀글이라면 패스워드는 원글과 동일하게 넣는다.
				if ($wr_secret)
					$wr_password = $wr['wr_password'];

				$wr_no = $wr_no . $reply;
				$wr_num = $write['wr_num'];
				$wr_reply = $reply;

				$vals['wr_num'] = $wr_num;
				$vals['wr_reply'] = $wr_reply;
				$vals['wr_category'] = $_POST['wr_category'];
				$vals['wr_secret'] = $wr_secret;
				$vals['wr_option'] = $wr_option;
				$vals['wr_subject'] = $wr_subject;
				$vals['wr_content'] = $wr_content;
				//$vals['wr_link1'] = $wr_link1;
				//$vals['wr_link2'] = $wr_link2;
				//$vals['wr_trackback'] = $_POST['wr_trackback'];
				$vals['wr_id'] = $wr_id;
				$vals['wr_password'] = $wr_password;
				$vals['wr_name'] = $wr_name;
				$vals['wr_email'] = $wr_email;
				$vals['wr_homepage'] = $wr_homepage;
				$vals['wr_datetime'] = $alice['time_ymdhis'];
				$vals['wr_last'] = $alice['time_ymdhis'];
				$vals['wr_ip'] = $_SERVER['REMOTE_ADDR'];
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

				$result = $board_control->_insert($vals, $bo_table);	// DB 입력

				$wr_no = $db->last_id();

				// 부모 아이디에 UPDATE
				$db->_query(" update `".$write_table."` set `wr_parent` = '".$wr_no."' where `wr_no` = '".$wr_no."' ");

				// 게시글 1 증가
				$db->_query("update `".$alice['table_prefix']."board` set `bo_write_count` = `bo_write_count` + 1 where `bo_table` = '".$bo_table."'");

				if ($wr_secret) {
					$ss_name = "view_secret_" . $bo_table . "_" . $wr_no;
					$utility->set_session($ss_name,true);
				}

				// 답변은 코멘트 포인트를 부여함
				// 답변 포인트가 많은 경우 코멘트 대신 답변을 하는 경우가 많음
				$point_control->point_insert($member['mb_id'], $board['bo_comment_point'], $board['bo_subject']." ".$wr_no." 글답변", $bo_table, $wr_no, '쓰기');

			break;

			## 게시글 수정
			case 'update':

				if (!$wr['wr_no']) {
					$utility->popup_msg_js($board_control->_errors('0008'));	// 글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동하였을 수 있습니다.
					exit;
				}

				/* 외부에서 글 등록 방지 */
				if(!$is_admin && !$board['bo_use_secret'] && $wr_secret){
					$utility->popup_msg_js($board_control->_errors('0034'));	// 비밀글 미사용 게시판 이므로 비밀글로 등록할 수 없습니다.
					exit;
				}
				if (!$is_admin && $board['bo_use_secret']) {
					$vals['wr_secret'] = "secret";
				}
				/* //외부에서 글 등록 방지 */

				/* 글 작성 권한 확인 */
				if(!$is_admin){	// 관리자가 아닐때만
					if($member['mb_level'] < $board['bo_write_level']){
						$utility->popup_msg_js($board_control->_errors('0026'));	// 글을 쓸 권한이 없습니다.
						exit;
					}
				}
				if($is_member) {	// 회원일때
					if($member['mb_id']!=$wr['wr_id']){	// 자신이 쓴 글인가
						$utility->popup_msg_js($board_control->_errors('0036'));	// 자신의 글이 아니므로 수정할수 없습니다.
					}
				} else {	 // 비회원의 경우 비번 확인
					if($wr['wr_password'] != md5($wr_password)){
						$utility->popup_msg_js($board_control->_errors('0037'));	// 비밀번호(패스워드)가 일치하지 않습니다.
						exit;
					}
				}
				if(!$is_admin && $wr_option=='notice'){	// 공지사항은 관리자만 작성 가능
					$utility->popup_msg_js($board_control->_errors('0009'));	// 공지사항은 관리자만 작성 가능합니다.
					exit;
				}
				/* //글 작성 권한 확인 */
				
				if($is_member) {	 // 일반 회원일때
					if($mb_id==$wr['wr_id']){	// 자신의 글이라면
						$wr_id = $member['mb_id'];
						$wr_name = (!$board['bo_use_name']) ? $member['mb_nick'] : $member['mb_name'];
						$wr_password = $member['mb_passwd'];
						$wr_email = $member['mb_email'];
						$wr_homepage = $member['mb_homepage'];
					} else {
						$wr_id = $wr['wr_id'];
						$wr_name = $wr['wr_name'];
						$wr_password = $wr['wr_password'];
						$wr_email = $wr['wr_email'];
						$wr_homepage = $wr['wr_homepage'];
					}
				} else {	 // 비회원
					$wr_id = "guest";
					// 비회원의 경우 이름이 누락되는 경우가 있음
					if (!trim($wr_name)) {
						$utility->popup_msg_js($board_control->_errors('0038'));	// 이름은 필히 입력하셔야 합니다.
						exit;
					}
					$wr_password = md5($wr_password);
				}

				$vals['wr_category'] = $_POST['wr_category'];
				$vals['wr_secret'] = $wr_secret;
				$vals['wr_option'] = $wr_option;
				$vals['wr_subject'] = $wr_subject;
				$vals['wr_content'] = $wr_content;
				$vals['wr_id'] = $wr_id;
				$vals['wr_password'] = $wr_password;
				$vals['wr_name'] = $wr_name;
				$vals['wr_email'] = $wr_email;
				$vals['wr_homepage'] = $wr_homepage;
				$vals['wr_datetime'] = $alice['time_ymdhis'];
				$vals['wr_last'] = $alice['time_ymdhis'];
				$vals['wr_ip'] = $_SERVER['REMOTE_ADDR'];
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
			
				$result = $board_control->_update($vals, $bo_table, $wr_no);	// DB 입력

				$db->_query(" update `".$write_table."` set `wr_category` = '".$_POST['wr_category']."' where `wr_parent` = '".$wr['wr_no']."' ");

				if ($wr_secret) {
					$ss_name = "view_secret_" . $bo_table . "_" . $wr_no;
					$utility->set_session($ss_name,true);
				}

				/* 사용자측에선 공지사항 로직이 없다.
				if($wr_option=='notice'){	// 공지사항이라면
					$bo_notice = $wr_no . "\n" . $board['bo_notice'];
					$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");
				} else {
					$bo_notice = '';
					for ($i=0; $i<count($notice_array); $i++)
						if ((int)$wr_no != (int)$notice_array[$i])
							$bo_notice .= $notice_array[$i] . '\n';
					$bo_notice = trim($bo_notice);
					$db->_query(" update `".$alice['table_prefix']."board` set `bo_notice` = '".$bo_notice."' where `bo_table` = '".$bo_table."' ");
				}
				*/

			break;


			case 'delete':
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
				$utility->popup_msg_js("삭제가 완료되었습니다.","../board/list.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table);
				exit;

				break;

			## 코멘트 작성
			case 'comment':

				if ($member['mb_level'] < $board['bo_comment_level']) 
					$utility->popup_msg_js($board_control->_errors('0054'));	// 코멘트를 쓸 권한이 없습니다.

				if ($_SESSION["ss_datetime"] >= ($alice['server_time'] - 10)){		// 10 초 제한
					$utility->popup_msg_js($board_control->_errors('0035'));	// 너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.
					exit;
				}

				$utility->set_session("ss_datetime", $alice['server_time']);

				// 동일내용 연속 등록 불가
				$query = " select MD5(CONCAT(wr_ip, wr_subject, wr_content)) as prev_md5 from `".$write_table."` ";
				$query .= " order by wr_id desc limit 1 ";

				$row = $db->query_fetch($query);

				$curr_md5 = md5($_SERVER['REMOTE_ADDR'].$wr_subject.$wr_content);

				if ($row['prev_md5'] == $curr_md5){
					$utility->popup_msg_js($board_control->_errors('0033'));	// 동일한 내용을 연속해서 등록할 수 없습니다.
					exit;
				}
				
				if (!$wr['wr_no']) {
					$utility->popup_msg_js($board_control->_errors('0008'));	// 글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동하였을 수 있습니다.
					exit;
				}

				if($is_member) {	 // 회원일때
					$wr_id = $member['mb_id'];
					$wr_name = (!$board['bo_use_name']) ? $member['mb_nick'] : $member['mb_name'];
					$wr_password = $member['mb_passwd'];
					$wr_email = $member['mb_email'];
					$wr_homepage = "";
				} else {	 // 비회원
					$wr_id = "guest";
					$wr_password = md5($wr_password);
				}

				// 코멘트쓰기 포인트
				/*
				$tmp_point = ($member['mb_point'] > 0) ? $member['mb_point'] : 0;
				if ($tmp_point + $board['bo_comment_point'] < 0 && !$is_admin)
					$utility->popup_msg_js("보유하신 포인트(".number_format($member['mb_point']).")가 없거나 모자라서 글쓰기(".number_format($board['bo_comment_point']).")가 불가합니다.\\n\\n포인트를 적립하신 후 다시 글쓰기 해 주십시오.");
				*/

				// 코멘트 답변
				if ($comment_id) {

					$query = " select wr_no, wr_comment, wr_comment_reply from `".$write_table."` where `wr_no` = '".$comment_id."' ";
					$reply_array = $db->query_fetch($query);
					if (!$reply_array['wr_no']){
						$utility->popup_msg_js($board_control->_errors('0055'));	// 답변할 코멘트가 없습니다.\\n\\n답변하는 동안 코멘트가 삭제되었을 수 있습니다.
						exit;
					}

					$tmp_comment = $reply_array['wr_comment'];

					if (strlen($reply_array['wr_comment_reply']) == 5) {
						$utility->popup_msg_js($board_control->_errors('0056'));	// 더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.
						exit;
					}

					$reply_len = strlen($reply_array['wr_comment_reply']) + 1;
					if ($board['bo_reply_order']) {
						$begin_reply_char = "A";
						$end_reply_char = "Z";
						$reply_number = +1;
						$query = " select MAX(SUBSTRING(wr_comment_reply, ".$reply_len.", 1)) as reply from `".$write_table."` where `wr_parent` = '".$wr_no."' and `wr_comment` = '".$tmp_comment."' and SUBSTRING(wr_comment_reply, ".$reply_len.", 1) <> '' ";
					} else {
						$begin_reply_char = "Z";
						$end_reply_char = "A";
						$reply_number = -1;
						$query = " select MIN(SUBSTRING(wr_comment_reply, ".$reply_len.", 1)) as reply from `".$write_table."` where `wr_parent` = '".$wr_no."' and `wr_comment` = '".$tmp_comment."' and SUBSTRING(wr_comment_reply, ".$reply_len.", 1) <> '' ";
					}
					if ($reply_array['wr_comment_reply']) 
						$query .= " and wr_comment_reply like '".$reply_array['wr_comment_reply']."%' ";
					$row = $db->query_fetch($query);

					if (!$row['reply']){
						$reply_char = $begin_reply_char;
					} else if ($row[reply] == $end_reply_char) { // A~Z은 26 입니다.
						$utility->popup_msg_js($board_control->_errors('0013'));	// 더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.
						exit;
					} else {
						$reply_char = chr(ord($row['reply']) + $reply_number);
					}

					$tmp_comment_reply = $reply_array['wr_comment_reply'] . $reply_char;

				} else  {

					$query = " select max(wr_comment) as max_comment from `".$write_table."` where `wr_parent` = '".$wr_no."' and `wr_is_comment` = 1 ";
					$row = $db->query_fetch($query);
					$row['max_comment'] += 1;
					$tmp_comment = $row['max_comment'];
					$tmp_comment_reply = "";

				}
				
				$vals['wr_category'] = $wr['wr_category'];
				$vals['wr_secret'] = $wr_secret;
				$vals['wr_num'] = $wr['wr_num'];
				$vals['wr_reply'] = '';
				$vals['wr_parent'] = $wr_no;
				$vals['wr_is_comment'] = '1';
				$vals['wr_comment'] = $tmp_comment;
				$vals['wr_comment_reply'] = $tmp_comment_reply;
				$vals['wr_subject'] = $wr_subject;
				$vals['wr_content'] = $wr_content;
				$vals['wr_id'] = $wr_id;
				$vals['wr_password'] = $wr_password;
				$vals['wr_name'] = $wr_name;
				$vals['wr_email'] = $wr_email;
				$vals['wr_homepage'] = $wr_homepage;
				$vals['wr_datetime'] = $alice['time_ymdhis'];
				$vals['wr_last'] = '';
				$vals['wr_ip'] = $_SERVER['REMOTE_ADDR'];
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

				$result = $board_control->_insert($vals, $bo_table);	// DB 입력

				$comment_id = $db->last_id();

				// 원글에 코멘트수 증가 & 마지막 시간 반영
				$result = $db->_query(" update `".$write_table."` set `wr_comment` = `wr_comment` + 1, `wr_last` = '".$alice['time_ymdhis']."' where `wr_no` = '".$wr_no."' ");

				// 코멘트 1 증가
				$result = $db->_query(" update `".$alice['table_prefix']."board` set `bo_comment_count` = `bo_comment_count` + 1 where `bo_table` = '".$bo_table."' ");

				// 최근게시물 wr_comment update
				$result = $db->_query(" update`".$alice['table_prefix']."board_new` set `wr_comment` = `wr_comment` + 1 where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' ");

				// 포인트 부여
				$point_control->point_insert($member['mb_id'], $board['bo_comment_point'], $board['bo_subject']." ".$wr_id."-".$comment_id." 코멘트쓰기", $bo_table, $comment_id, '코멘트');

				if($result){	 // 작성 성공
					$utility->set_session("ss_comment_".$comment_id, true);	 // 비회원의 경우 세션 할당
					$utility->popup_msg_js("","./list.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no."&cwin=".$cwin."#c_".$comment_id);
				} else {
					$utility->popup_msg_js($board_control->_errors('0057'));	// 코멘트 작성중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.
					exit;
				}

			break;

			## 코멘트 수정
			case 'comment_update':

				if ($member['mb_level'] < $board['bo_comment_level'] && !$is_admin) 
					$utility->popup_msg_js($board_control->_errors('0054'));	// 코멘트를 쓸 권한이 없습니다.

				if (!$wr['wr_no']) {
					$utility->popup_msg_js($board_control->_errors('0008'));	// 글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동하였을 수 있습니다.
					exit;
				}

				if($is_member) {	 // 회원일때
					$wr_id = $member['mb_id'];
					$wr_name = (!$board['bo_use_name']) ? $member['mb_nick'] : $member['mb_name'];
					$wr_password = $member['mb_passwd'];
					$wr_email = $member['mb_email'];
					$wr_homepage = "";
				} else {	 // 비회원
					$wr_id = "guest";
					$wr_password = md5($wr_password);
				}


				$query = " select `wr_id`, `wr_comment`, `wr_comment_reply` from `".$write_table."` where `wr_no` = '".$comment_id."' ";

				$comment = $reply_array = $db->query_fetch($query);
				$tmp_comment = $reply_array['wr_comment'];

				$len = strlen($reply_array['wr_comment_reply']);
				if ($len < 0) $len = 0; 
				$comment_reply = substr($reply_array['wr_comment_reply'], 0, $len);

				if($is_member) {	// 회원일때
					if($member['mb_id']!=$comment['wr_id'] && !$is_admin ){	// 자신이 쓴 글인가
						$utility->popup_msg_js($board_control->_errors('0036'));	// 자신의 글이 아니므로 수정할수 없습니다.
					}
				}

				$query = " select count(*) as cnt from `".$write_table."` where `wr_comment_reply` like '".$comment_reply."%' and wr_id <> '".$comment_id."'and `wr_parent` = '".$wr_no."' and `wr_comment` = '".$tmp_comment."' and `wr_is_comment` = 1 ";
				$row = $db->query_fetch($query);
				if ($row['cnt'] && !$is_admin)
					//$utility->popup_msg_js($board_control->_errors('0058'));	// 이 코멘트와 관련된 답변코멘트가 존재하므로 수정 할 수 없습니다.

				if ($wr_secret) {
					$ss_name = "view_secret_" . $bo_table . "_" . $wr_no;
					$utility->set_session($ss_name,true);
				}

				$vals['wr_secret'] = $wr_secret;
				$vals['wr_subject'] = $wr_subject;
				$vals['wr_content'] = $wr_content;
				$vals['wr_last'] = $alice['time_ymdhis'];
				$vals['wr_ip'] = $_SERVER['REMOTE_ADDR'];
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

				$result = $board_control->_update($vals, $bo_table, $comment_id);	// DB 수정

				if($result){	 // 수정 성공
					$utility->set_session("ss_comment_".$comment_id, true);	 // 비회원의 경우 세션 할당
					$utility->popup_msg_js("","./list.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no."&cwin=".$cwin."#c_".$comment_id);
				} else {
					$utility->popup_msg_js($board_control->_errors('0059'));	// 코멘트 수정중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.
					exit;
				}

			break;

		}	// switch end.


		/* 가변 파일 ============================================================================= */
		for ($i=0; $i<count($upload); $i++) {
			if (!get_magic_quotes_gpc()) {
				$upload[$i]['source'] = addslashes($upload[$i]['source']);
			}

			$row = $db->query_fetch(" select count(*) as cnt from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
			if ($row['cnt']) {
				// 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
				// 그렇지 않다면 내용만 업데이트 합니다.
				if ($upload[$i]['del_check'] || $upload[$i]['file']) {
					
					$query = " update `".$alice['table_prefix']."board_file` set `file_source` = '".$upload[$i]['source']."', `file_name` = '".$upload[$i]['file']."', `file_content` = '".$bf_content[$i]."', `file_filesize` = '".$upload[$i]['filesize']."', `file_width` = '".$upload[$i]['image'][0]."', `file_height` = '".$upload[$i]['image'][1]."', `file_type` = '".$upload[$i]['image'][2]."', `file_datetime` = '".$alice['time_ymdhis']."' where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ";
					$db->_query($query);

				} else  {

					$query = " update `".$alice['table_prefix']."board_file` set `file_content` = '".$file_content[$i]."'  where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ";
					$db->_query($query);
				}

			} else {

				$query = " insert into `".$alice['table_prefix']."board_file` set `bo_table` = '".$bo_table."', `wr_no` = '".$wr_no."', `file_no` = '".$i."', `file_source` = '".$upload[$i][source]."', `file_name` = '".$upload[$i][file]."', `file_content` = '".$bf_content[$i]."', `file_download` = 0, `file_filesize` = '".$upload[$i]['filesize']."', `file_width` = '".$upload[$i]['image'][0]."', `file_height` = '".$upload[$i]['image'][1]."', `file_type` = '".$upload[$i]['image'][2]."', `file_datetime` = '".$alice['time_ymdhis']."' ";
				$db->_query($query);

			}
		}

		// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
		// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
		$row = $db->query_fetch(" select max(file_no) as max_file_no from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' ");
		for ($i=(int)$row['max_file_no']; $i>=0; $i--) {
			$row2 = $db->query_fetch(" select `file_name` from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");

			// 정보가 있다면 빠집니다.
			if ($row2['file_name']) break;

			// 그렇지 않다면 정보를 삭제합니다.
			$db->_query(" delete from `".$alice['table_prefix']."board_file` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' and `file_no` = '".$i."' ");
		}
		/* //가변 파일 ============================================================================ */
		
		if($mode=='insert' || $mode=='reply' || $mode=='update'){	// 글 작성/답변/수정 완료
			if($alice['https_url'])
				$https_url = $alice['https_url']."/".$alice['app']."/".$alice['board'];
			else 
				$https_url = "..";
			if($result){
				$utility->popup_msg_js("", NFE_URL."/board/list.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no."&page=".$page);
			}
			/*
			if($result)	// 작성 완료시~
				$utility->popup_msg_js("","../view.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no);
				//$utility->popup_msg_js("","./board.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table);
			*/
		}
?>