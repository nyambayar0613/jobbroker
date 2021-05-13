<?php
		/*
		* /application/nad/board/process/cs.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: CS regist
		* @Comment :: CS 등록/수정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$no = $_POST['no'];
		$next_no = $_POST['next_no'];
		$wr_type = $_POST['wr_type'];	// cs 분야
		$wr_cate = $_POST['wr_cate'];	// 카테고리

		$get_cs = $cs_control->get_cs($no);


		$result = array();	// 최종 결과값

		$result['mode'] = $mode;

		switch($mode){

			## faq 입력/수정
			case 'faq_insert':
			case 'faq_update':

				$get_MaxRank = $cs_control->get_MaxRank($wr_type,$wr_cate) + 1;
				//$rank = ($mode=='faq_insert') ? $get_MaxRank : $get_cs['rank'];	 // 입력시, 수정시 구분

				if($mode=='faq_insert'){	// 입력일땐 rank에 최대값을 대입
					$rank = $get_MaxRank;
				} else {	 // 수정일땐 카테고리 변경을 체크하여 제일 낮은 순위로 입력
					if($get_cs['wr_cate'] != $wr_cate){	 // 카테고리가 변경된 경우
						$get_MaxRank = $cs_control->get_MaxRank($wr_type,$wr_cate) +1;	 // 이동할 category 의 rank 최대값 +1
						$rank = $get_MaxRank;
						$noRank = $cs_control->_noRank($no);	// 순위조절
					} else {	 // 변경되지 않은 경우
						$rank = $get_cs['rank'];
					}
				}

				$vals['rank'] = $rank;
				$vals['wr_type'] = $wr_type;
				$vals['wr_cate'] = $_POST['wr_cate'];
				$vals['wr_id'] = $_POST['wr_id'];
				$vals['wr_name'] = $_POST['wr_name'];
				$vals['wr_subject'] = $_POST['wr_subject'];
				$vals['wr_content'] = $_POST['wr_content'];
				$vals['wr_date'] = $now_date;
				
				$result['result'] = ($mode=='faq_insert') ? $cs_control->insert_cs($vals) : $cs_control->update_cs($vals, $no);

			break;

			## faq 순위조절
			case 'faq_rank':

				// 순위조절 함수 호출
				$result['result'] = $cs_control->setRank($wr_type, $wr_cate, $no, $next_no);

			break;

			## FAQ 보기 / 조회수 증가
			case 'faq_view':
				
				echo stripslashes($get_cs['wr_content']);

				$cs_control->hit_up($no);	 // 조회수 증가

				exit;

			break;

			## FAQ 삭제 (단수)
			case 'faq_delete':

				$result['result'] = $cs_control->delete_noRank($no);

			break;

			## FAQ 삭제 (복수)
			case 'faq_sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result['result'] = $cs_control->delete_noRank($nos[$i]);	// DB 삭제
				}

			break;

			## 1:1 문의 / 광고/제휴문의 조회수 증가
			case 'hit_up':
				
				$result = $cs_control->hit_up($no);	 // 조회수 증가

			break;

			## 1:1 문의 / 광고/제휴문의 답변 등록
			case 'cs_reply':
			case 'concert_reply':


				$vals['wr_aid'] = $_POST['wr_aid'];
				$vals['wr_aname'] = $_POST['wr_aname'];
				$vals['wr_acontent'] = $_POST['wr_acontent'];
				$vals['wr_result'] = 1;	// 답변완료
				$vals['wr_adate'] = $now_date;

				$result['result'] = $cs_control->update_cs($vals, $no);

				$receive_mail = stripslashes(trim($get_cs['wr_email']));
                
				if($mode == 'concert_reply') {
					$msg = $design_control->get_mail_skin('concert');
                }else{
					$msg = $design_control->get_mail_skin('qna');
                }

				$subject = "[".$env['site_name']."] `" . $get_cs['wr_subject'] . "` 에 대한 답변입니다.";

				$content = $cs_control->_replaces($no, stripslashes($msg['content']));

				$mail_check = preg_match("/[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*/", $receive_mail);	// 메일주소 정규식 체크
				if($mail_check) {
					$vals['wr_asubject'] = $subject;
					$vals['wr_acontent'] = $content;
					$vals['wr_result'] = 1;
					$cs_control->update_cs($vals,$no);	 // 답변 정보 업데이트
					$mailer->sendMail($env['site_name'], $env['email'], $receive_mail, $subject, $content, 1);	// 메일 발송
				}

			break;

			## 1:1 문의 / 광고/제휴문의 삭제 (단수)
			case 'delete':

				$result['result'] = $cs_control->delete_cs($no);

			break;

			## 1:1 문의 / 광고/제휴문의 삭제 (복수)
			case 'sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result['result'] = $cs_control->delete_cs($nos[$i]);
				}

			break;

			## 메일 발송
			case 'email_send':

				// 메일 제목 확인
				if (!isset($_POST['subject']) || !trim($_POST['subject'])) {
					echo '0001';	 // 메일 제목을 입력해 주세요.
					exit;
				} else {
					$subject = $_POST['subject'];
					$subject = $utility->get_text(stripslashes($subject));
				}

				// 메일 내용 확인
				if (!isset($_POST['content']) || !trim($_POST['content'])) {
					echo '0002';	 // 메일 내용을 입력해 주세요.
					exit;
				} else {
					$content = stripslashes($_POST['content']);
				}

				// 받는 사람 :: 이 경우엔 추가 작성한 email 주소도 메일을 발송 할 수 있다.
				$receive_mail = stripslashes(trim($_POST['receive_mail']));

				$mail_check = preg_match("/[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*/", $receive_mail);	// 메일주소 정규식 체크
				if($mail_check) {
					$vals['wr_asubject'] = $subject;
					$vals['wr_acontent'] = $content;
					$vals['wr_result'] = 1;
					$cs_control->update_cs($vals,$no);	 // 답변 정보 업데이트
					$mailer->sendMail($env['site_name'], $env['email'], $receive_mail, $subject, $content, 1);	// 메일 발송
					$result['result'] = true;
				}


			break;

		}

		echo @implode('/',$result);

?>