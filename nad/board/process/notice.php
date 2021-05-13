<?php
		/*
		* /application/nad/board/process/notice.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2015/09/30
		* @Module v3.5 ( Alice )
		* @Brief :: Notice regist
		* @Comment :: 공지사항 등록/수정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];

		$notice = $notice_control->get_notice($no);

		$result = array();	// 최종 결과값

		$result['mode'] = $mode;

		switch($mode){
			## 공지사항 등록/수정
			case 'insert':
			case 'update':		

				$vals['wr_subject'] = $_POST['wr_subject'];
				$vals['wr_type'] = $_POST['wr_type'];
				if($mode=='insert') {
					$vals['wr_id'] = $_POST['wr_id'];
				}
				$vals['wr_name'] = $_POST['wr_name'];
				$wr_content = $_POST['wr_content'];
				if(!$wr_content || $wr_content == ''){
					echo $notice_control->_errors('0002'); exit;	 // 공지사항 내용을 입력해 주세요.
				}
				$vals['wr_content'] = $wr_content;
				if($mode=='insert'){
					$vals['wr_date'] = $now_date;
				}

				$wr_file = array();	// 업로드 파일명
				$wr_file_cnt = count($_FILES['wr_file']);
				$j = 0;
				for($i=0;$i<$wr_file_cnt;$i++){

					$tmp_file  = $_FILES['wr_file']['tmp_name'][$i];
					$filename  = $_FILES['wr_file']['name'][$i];

					if(is_uploaded_file($tmp_file)){

						if(preg_match("/\.($upload_extension)$/i", $filename)){ // 파일 확장자 체크

							@mkdir($alice['data_notice_abs_path'] . '/' . $ym, 0707);
							@chmod($alice['data_notice_abs_path'] . '/' . $ym, 0707);
							$index_file = $alice['data_notice_abs_path'] . '/' . $ym . '/index.html';
							if(!file_exists($index_file)){	// 디렉토리 보안을 위해서
								$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);
							}

							// 파일 업로드
							$file_upload = $utility->file_upload($tmp_file, $filename, $alice['data_notice_abs_path'] . '/' . $ym , $_FILES);
							$wr_file[$j] = $file_upload['upload_file'];

						$j++;
						} else {

							echo $config->_errors('0039'); exit;	 // 업로가드 불가능한 파일 입니다.

						}

					}

				}

				$vals['wr_file'] = serialize($wr_file);
				$vals['wr_ip'] = $_SERVER['REMOTE_ADDR'];

				$result['result'] = ($mode=='insert') ? $notice_control->insert_notice($vals) : $notice_control->update_notice($vals, $no);

			break;

			## 공지사항 카운트 업
			case 'hit_up':
			
				$result['result'] = $notice_control->hitup_notice($no);

			break;
			## 공지 삭제
			case 'delete':
			
				if($no){	 // no 가 존재하는 유효한 pin 의 경우 삭제 실행
					$result['result'] = $notice_control->delete_notice($no);	// 삭제
				} else {
					echo $notice_control->_errors('0001'); exit;	 // 삭제할 공지사항이 없거나 이미 삭제된 공지사항 입니다.
				}

			break;

			## 선택 공지 삭제
			case 'sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result['result'] = $notice_control->delete_notice($nos[$i]);	// DB 삭제
				}

			break;

		}

		echo @implode('/',$result);

?>