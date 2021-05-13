<?php
		/*
		* /application/nad/board/process/poll.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Poll regist
		* @Comment :: 설문조사 등록/수정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$no = $_POST['no'];

		$result = array();

		$result['mode'] = $mode;

		switch($mode){
			## 설문조사 입력/수정
			case 'poll_insert':
			case 'poll_update':

				$vals['poll_wdate'] = $_POST['poll_wdate'];
				$vals['poll_edate'] = $_POST['poll_edate'];
				$vals['poll_member'] = $_POST['poll_member'];
				$vals['poll_overlap'] = $_POST['poll_overlap'];

				// 설문조사 제목 확인
				if (!isset($_POST['poll_subject']) || !trim($_POST['poll_subject'])) {
					echo '0003';	 // 설문조사 제목을 입력해 주세요.
					exit;
				} else {
					$vals['poll_subject'] = $_POST['poll_subject'];
				}

				$content_arr = '';
				$answer_arr = '';
				if($mode=='poll_insert') {	 // 입력일때

					$content_cnt = count($_POST['content']);

					if($content_cnt <= 1){	// 1개 이하이면 안된다
						echo '0004';	// 설문조사 항목은 최소 2개 이상이어야 합니다.
						exit;
					}

					$get_polls = $poll_control->get_polls(" where `view_main` = 1 ");	 // 메인 출력이면서 사용중인거
					if(!$get_polls['no'])	// 메인 출력중 이면서 사용중인게 없다면
						$vals['view_main'] = 1;	// 메인에 출력한다.

				} else {	 // 수정일때

					$get_poll = $poll_control->get_poll($no);
					
					//$get_content = explode('|&|',$get_poll['poll_content']);	// 내용
					$get_content = $_POST['content'];
					$content_cnt = count($get_content);

					$get_answer = explode('|&|',$get_poll['poll_answer']);	// 답변수
					$answer_cnt = count($get_answer);

				}

				for($i=0;$i<$content_cnt;++$i){
					if($_POST['content'][$i]==''){
						continue;
					} else {
						$content_arr[$i] = $_POST['content'][$i];
						if($content_cnt > $answer_cnt){
							$answer_arr[$i] = ($mode=='poll_insert') ? 0 : $get_answer[$i];
							$answer_arr[$i] = 0;
						} else {
							$answer_arr[$i] = ($mode=='poll_insert') ? 0 : $get_answer[$i];
						}
					}
				}
				
				$vals['poll_content'] = @implode('|&|',$content_arr);	// 내용
				$vals['poll_answer'] = @implode('|&|',$answer_arr);	// 답변 카운트
				$vals['poll_date'] = $now_date;

				$result['result'] = ($mode=='poll_insert') ? $poll_control->insert_poll($vals) : $poll_control->update_poll($vals, $no);

			break;

			## Poll 삭제 (단수)
			case 'poll_delete':

				$result = $poll_control->delete_poll($no);

				$result['result'] = (!$result) ? '0005' : 1;	// 삭제할 설문조사가 없거나 이미 삭제된 설문조사 입니다.

			break;

			## Poll 삭제 (복수)
			case 'poll_sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result['result'] = $poll_control->delete_poll($nos[$i]);	// DB 삭제
				}

			break;

			## 일괄적용
			case 'sel_poll':
				
				/* 필드명을 기준으로 배열 변수를 정렬 */
				$sels = explode('/',$_POST['sels']);
				$sels_cnt = count($sels);
				for($i=0;$i<$sels_cnt;$i++){
					$sel['no'] = $sels[0];
					$sel['use'] = $sels[1];
					$sel['poll_wdate'] = $sels[2];
					$sel['poll_edate'] = $sels[3];
				}
				$sel_use = explode(',',$sel['use']);
				$sel_poll_wdate = explode(',',$sel['poll_wdate']);
				$sel_poll_edate = explode(',',$sel['poll_edate']);
				/* //필드명을 기준으로 배열 변수를 정렬 */

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($j=0;$j<$no_cnt;$j++){	// 실제 값 업데이트

					$vals['use'] = ($sel_use[$j]) ? 1 : 0;
					$vals['poll_wdate'] = $sel_poll_wdate[$j];
					$vals['poll_edate'] = $sel_poll_edate[$j];

					$result['result'] = $poll_control->update_poll($vals, $nos[$j]);

				}

			break;

			## 설문조사 코멘트 삭제
			case 'poll_deleteComment':

				$get_pollComment = $poll_control->get_pollComment($no);

				$result['result'] = $poll_control->delete_pollComment($no);

				$result['p_no'] = $get_pollComment['p_no'];

				$result['page'] = $_POST['page'];

			break;

			## 사용/미사용 설정
			case 'poll_use':

				$result['result'] = $poll_control->use_poll($no);

			break;

			## 메인 출력 설정
			case 'view_main':
				
				$result['result'] = $poll_control->viewMain_poll($no);

			break;

		}

		echo @implode('/',$result);
?>