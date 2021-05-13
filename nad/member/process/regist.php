<?php
		/*
		* /application/nad/member/process/regist.php
		* @author Harimao
		* @since 2013/07/11
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Member data process
		* @Comment :: 회원 데이터 관리/처리
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];

		$return_regist = $_POST['return_regist'];	 // 등록 후 공고 등록

		switch($mode){

			## 회원정보 입력 / 수정
			case 'insert':
			case 'update':

				$mb_id = trim(strip_tags(mysql_escape_string($_POST['mb_id'])));
				$mb_password = trim(strip_tags(mysql_escape_string($_POST['mb_password'])));
				$mb_name = trim(strip_tags(mysql_escape_string($_POST['mb_name'])));
				$mb_nick = trim(strip_tags(mysql_escape_string($_POST['mb_nick'])));
				$mb_email = trim(strip_tags(mysql_escape_string($_POST['mb_email'])));

				if($mode=='update') {
					$member = $member_control->get_member($mb_id);
					$vals['mb_udate'] = $now_date;	// 정보 수정일
				}

				/* 아이디 검사 */
				if(!$mb_id){
					echo $user_control->_errors('0005');	// 아이디를 입력해 주세요
					exit;
				} else {
					// 아이디 공백 검사
					if(!ereg("([^[:space:]]+)", $mb_id) || ereg("([[:space:]]+)",$mb_id)) {
						echo $user_control->_errors('0006');	// 아이디에 공백이 존재합니다.\n\n공백없이 입력해 주세요.
						exit;
					}
					if($mode=='insert'){	// 입력일때만
						// 아이디 중복검사
						$check_id = $user_control->checkUid_member($mb_id);
						if($check_id){
							if($ajax)
								echo $user_control->_errors('0007');	// 이미 존재하는 아이디 입니다.
							else 
								$utility->popup_msg_js($user_control->_errors('0007'));
							exit;
						} else {
							$vals['mb_id'] = $mb_id;
						}
					}
				}
				/* //아이디 검사 */

				/* 이름 입력 검사 */
				if(!$mb_name){
					if($ajax)
						echo $user_control->_errors('0009');	// 이름을 입력해 주세요.
					else 
						$utility->popup_msg_js($user_control->_errors('0009'));
					exit;
				} else {
					$mb_name = str_replace(array("!","@","#","$",","), "", $mb_name);
					$vals['mb_name'] = $mb_name;
				}
				/* //이름 입력 검사 */

				/* 닉네임 검사 */
				if(!$mb_nick){
					if($ajax)
						echo $user_control->_errors('0010');	// 닉네임을 입력해 주세요
					else 
						$utility->popup_msg_js($user_control->_errors('0010'));
					exit;
				} else {
					// 닉네임 공백 검사
					if(!ereg("([^[:space:]]+)", $mb_nick) || ereg("([[:space:]]+)",$mb_nick)) {
						if($ajax)
							echo $user_control->_errors('0011');	// 닉네임에 공백이 존재합니다.\n\n공백없이 입력해 주세요.
						else 
							$utility->popup_msg_js($user_control->_errors('0011'));
						exit;
					}
					// 닉네임 중복검사
					$check_nick = $member_control->nick_checking($mb_id,$mb_nick);
					if($check_nick){
						if($ajax)
							echo $user_control->_errors('0012');	// 이미 존재하는 닉네임 입니다.
						else 
							$utility->popup_msg_js($user_control->_errors('0012'));
						exit;
					}
					$vals['mb_nick'] = $mb_nick;
				}
				/* //닉네임 검사 */

				/* 이메일 검사 */
				if($mode=='insert'){	// 입력일때만
					if(!$mb_email){	// 이메일 입력 검사
						if($ajax) {
							echo $config->_errors('0028');	// 이메일 주소를 입력해 주세요.
						} else 
							$utility->popup_msg_js($config->_errors('0028'));
						exit;
					} else {
						// 이메일 중복검사
						$check_email = $user_control->checkEmail_member($mb_email);
						if($check_email){
							if($ajax) {
								echo $user_control->_errors('0013');	// 이미 등록된 이메일 주소 입니다.
							} else 
								$utility->popup_msg_js($user_control->_errors('0013'));
							exit;
						}
					}
				}
				$vals['mb_email'] = $mb_email;
				/* //이메일 검사 */

				/* 패스워드 입력 검사 */
				if($mode=='insert'){	// 입력시
					if(!$mb_password){
						echo $user_control->_errors('0008');	// 비밀번호를 입력해 주세요.
						exit;
					} else {
						$vals['mb_password'] = md5($mb_password);
					}
				} else {	 // 수정시
					if($mb_password)	// 패스워드를 입력했다면 수정한다.
						$vals['mb_password'] = md5($mb_password);
				}
				/* //패스워드 입력 검사 */

				if($mode=='insert') $vals['mb_type'] = $_POST['mb_type'];	// 회원구분은 입력일때만
				$vals['mb_level'] = $_POST['mb_level'];

				if($_POST['mb_type']=='individual') {	// 개인회원 전용 데이터
					$vals['mb_birth'] = $_POST['mb_birth_year'] . "-" . $_POST['mb_birth_month'] . "-" . $_POST['mb_birth_day'];
					$vals['mb_gender'] = $_POST['mb_gender'];
				}

				$vals['mb_phone'] = @implode('-',$_POST['mb_phone']);
				$vals['mb_hphone'] = @implode('-',$_POST['mb_hphone']);
				$vals['mb_receive'] = @implode(',',$_POST['mb_receive']);	// 문자/메일 수신 여부 (관리자가 임의로 변경하면 안될텐데...)

				$vals['mb_zipcode'] = @implode('-',$_POST['mb_zipcode']);
				$vals['mb_address0'] = $_POST['mb_address0'];
				$vals['mb_address1'] = $_POST['mb_address1'];

				$vals['mb_homepage'] = ($_POST['mb_homepage']) ? $utility->add_http($_POST['mb_homepage']) : "";

				$vals['mb_login_count'] = ($mode=='insert') ? 1 : $member['mb_login_count'];
				$vals['mb_wdate'] = ($mode=='insert') ? $now_date : $member['mb_wdate'];	 // 가입일
				$vals['mb_memo'] = $_POST['mb_memo'];

				## 01. 기본 회원정보 입력
				if($mode=='insert') {
					$vals['is_admin'] = 1;
					$member_result = $member_control->insert_member($vals);
				} else if($mode=='update')
					$member_result = $member_control->update_member($vals,$mb_id);


				// 기본 디렉토리가 없는 경우 생성
				@mkdir($alice['data_member_abs_path'] . '/' . $mb_id, 0707);
				@chmod($alice['data_member_abs_path'] . '/' . $mb_id, 0707);
				$file = $alice['data_member_abs_path'] . '/' . $mb_id . '/index.html';
				if(!file_exists($file)){	// 디렉토리 보안을 위해서
					$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
				}


				if($_POST['mb_type']=='company'){	 // 기업회원 전용 데이터

					if($mode=='insert'){
						$company_vals['is_public'] = 1;	// 처음 가입시 기업회원 입력 데이터는 기본 정보로 선택
					}
					$company_vals['mb_id'] = $mb_id;
					$company_vals['mb_ceo_name'] = $_POST['mb_ceo_name'];
					$company_vals['mb_company_name'] = $_POST['mb_company_name'];
					$company_vals['mb_biz_type'] = $_POST['mb_biz_type'];
					$company_vals['mb_biz_no'] = @implode('-',$_POST['mb_biz_no']);
					$company_vals['mb_biz_fax'] = @implode('-',$_POST['mb_biz_fax']);
					$company_vals['mb_biz_success'] = $_POST['mb_biz_success'];
					$company_vals['mb_biz_form'] = $_POST['mb_biz_form'];
					$company_vals['mb_biz_content'] = $_POST['mb_biz_content'];
					$company_vals['mb_biz_foundation'] = $_POST['mb_biz_foundation'];
					$company_vals['mb_biz_member_count'] = $_POST['mb_biz_member_count'];
					$company_vals['mb_biz_stock'] = $_POST['mb_biz_stock'];
					$company_vals['mb_biz_sale'] = $_POST['mb_biz_sale'];
					$company_vals['mb_biz_vision'] = $_POST['mb_biz_vision'];
					$company_vals['mb_biz_result'] = $_POST['mb_biz_result'];
					$company_vals['mb_latlng'] = $_POST['mb_latlng'];

					$mb_logo = $_POST['mb_logo'];

					// 디렉토리가 없는 경우 생성
					// 로고 및 회사 사진 저장 디렉토리
					$logo_path = $alice['data_member_abs_path'] . '/' . $mb_id . '/logo';
					@mkdir($logo_path, 0707);
					@chmod($logo_path, 0707);
					$file = $logo_path . "/index.html";
					if(!file_exists($file)){	// 디렉토리 보안을 위해서
						$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
					}

					$tmp_file	= $_FILES['mb_logo']['tmp_name'];
					$filename	= $_FILES['mb_logo']['name'];
					$filesize  = $_FILES['mb_logo']['size'];

					$timg = @getimagesize($tmp_file);

					if(is_uploaded_file($tmp_file)){

						// 사이즈 체크

						// 용량 체크 (관리자에서 설정한 용량)

						// 확장자 체크
						$img_extension = $user_control->_img();

						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
							$file_upload = $utility->file_upload($tmp_file, $filename, $logo_path, $_FILES);	// 파일 업로드
							$upload_file = $file_upload['upload_file'];
							$company_vals['mb_logo'] = $upload_file;	// 변수 할당
						}

					}

					## 02. 기업회원 정보 입력
					if($mode=='insert'){
						$company_result = $member_control->insert_company_member($company_vals);
					} else if($mode=='update') {
						//$company_result = $member_control->update_company_member($company_vals,$mb_id);
						$company_result = $member_control->update_company_memberNo($company_vals,$_POST['company_no']);
					}

				} else if($_POST['mb_type']=='individual'){	// 개인회원 전용 데이터

					$get_member = $member_control->get_member($mb_id);
					$mb_photos = $_POST['mb_photos'];

					// 프로필 사진 저장 디렉토리
					$photo_path = $alice['data_member_abs_path'] . '/' . $mb_id;

					$tmp_file	= $_FILES['photo_file']['tmp_name'];
					$filename	= $_FILES['photo_file']['name'];

					$timg = @getimagesize($tmp_file);

					if(is_uploaded_file($tmp_file)){
						
						// 사이즈 체크

						// 용량 체크 (관리자에서 설정한 용량)

						// 확장자 체크
						$img_extension = $user_control->_img();

						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
							@unlink($photo_path . "/". $get_member['mb_photo']);	 // 기존 파일 삭제
							$file_upload = $utility->file_upload($tmp_file, $filename, $photo_path, $_FILES);	// 파일 업로드
							$upload_file = $file_upload['upload_file'];
							$member_vals['mb_photo'] = $upload_file;
						}

						if($mode=='insert')
							$member_result = $member_control->insert_member($member_vals);
						else if($mode=='update')
							$member_result = $member_control->update_member($member_vals,$mb_id);

					}

				}

				## 03. 서비스 테이블 임시 데이터 입력
				if($mode=='insert')	// 입력일때만
					$service_result = $user_control->user_service_regist( array('mb_id' => $mb_id) );

				$result = array();	// 결과 값

				$result['mode'] = 'member';
				$result['status'] = $mode;

				if($_POST['mb_type']=='individual'){	 // 개인회원

					if($member_result){

						if($ajax){
							$result['msg'] = "0000";
							$result['result'] = true;
						} else {
							$utility->popup_msg_js("","./");
							exit;
						}

					} else {	 // 실패시
						if($ajax){
							if($mode=='insert')
								$result['msg'] = $member_control->_errors('0003');
							else if($mode=='update')
								$result['msg'] = $member_control->_errors('0004');
							$result['result'] = false;
						} else {
							if($mode=='insert')
								$utility->popup_msg_js($member_control->_errors('0003'));
							else if($mode=='update')
								$utility->popup_msg_js($member_control->_errors('0004'));
							exit;
						}
					}

				} else if($_POST['mb_type']=='company') {	// 기업회원

					if($member_result && $company_result){

						if($ajax){
							$result['msg'] = "0000";
							$result['result'] = true;
						} else {
							$utility->popup_msg_js("","./");
							exit;
						}

					} else {	 // 실패시
						if($ajax){
							if($mode=='insert')
								$result['msg'] = $member_control->_errors('0005');
							else if($mode=='update')
								$result['msg'] = $member_control->_errors('0006');
							$result['result'] = false;
						} else {
							if($mode=='insert')
								$utility->popup_msg_js($member_control->_errors('0005'));
							else if($mode=='update')
								$utility->popup_msg_js($member_control->_errors('0006'));
							exit;
						}
					}

				}

				$result['mb_type'] = $_POST['mb_type'];
				$result['mb_id'] = $mb_id;
				$result['return_regist'] = $return_regist;

				echo @implode('/',$result);

			break;

			## 이메일 발송
			case 'email':

				$result = '';
				
				// 메일 제목 확인
				if (!isset($_POST['subject']) || !trim($_POST['subject'])) {
					echo $sms_control->_errors('0000');	 // 메일 제목을 입력해 주세요.
					exit;
				} else {
					$subject = $_POST['subject'];
					$subject = $utility->get_text(stripslashes($subject));
				}

				// 메일 내용 확인
				if (!isset($_POST['content']) || !trim($_POST['content'])) {
					echo $sms_control->_errors('0001');	 // 메일 내용을 입력해 주세요.
					exit;
				} else {
					$content = stripslashes($_POST['content']);
				}

				
				// 받는 사람 :: 이 경우엔 추가 작성한 email 주소도 메일을 발송 할 수 있다.
				$receive_mail = addslashes(trim($_POST['receive_mail']));
				$receive_mail_list = explode(',',$receive_mail);
				$receive_mail_list_cnt = count($receive_mail_list);

				$mail_denied_cnt = 0;	// 수신 거부 메일 수
				$mail_send_cnt = 0;		// 전송 메일 수
				for($i=0;$i<$receive_mail_list_cnt;$i++){
					$member = $member_control->get_memberEmail($receive_mail_list[$i]);	 // 메일 주소를 기준으로 회원 정보 검색

					$mb_email = $receive_mail_list[$i];
					$mail_check = preg_match("/[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*/", $mb_email);	// 메일주소 정규식 체크

					if($mail_check){
						$mail_send_cnt++;
						$content = $mail_control->mail_replaces( $mb_email, $content );
						echo $mailer->sendMail($env['site_name'], $env['email'], $mb_email, $subject, $content, 1);
					}
					
					/*
					if($member){	 // 회원정보가 검색 되는 경우
					} else {	 // 회원정보가 검색 안되고 추가된 메일 주소인 경우
					}
					*/

				}

				$result = '0000';

				echo $mode . '/' . $result . '/' . number_format($mail_send_cnt);

			break;

			## 메모 정보 업데이트
			case 'memo':
				
				$mb_id = $_POST['mb_id'];
				$vals['mb_memo'] = $_POST['mb_memo'];

				$result = $member_control->update_member($vals, $mb_id);
				$member = $member_control->get_member($mb_id);

				if($ajax)
					echo $mode . '/' . $result . '/' . $no . '/' . $member['mb_memo'];
				else
					$utility->popup_msg_js($config->_success('0011'));	// 메모 작성이 완료 되었습니다.

			break;

			## 회원 삭제
			case 'delete':

				$result = $member_control->delete_member($no);

				echo $result;

			break;

			## 선택 회원 삭제
			case 'sel_delete':
			
				$nos = explode(',',$no);
				$nos_cnt = count($nos);

				for($i=0;$i<$nos_cnt;$i++){

					$result = $member_control->delete_member($nos[$i]);

				}

				echo $result;

			break;

			## 선택 회원 등급(레벨) 수정
			case 'sel_level':

				$nos = explode(',',$no);
				$nos_cnt = count($nos);

				for($i=0;$i<$nos_cnt;$i++){

					$vals['mb_level'] = $_POST['mb_level'];

					$result = $member_control->update_memberNo($vals,$nos[$i]);

				}

				echo $result;

			break;

			## 불량회원으로 등록
			case 'badness':

				$is_nos = $_POST['is_nos'];	// 다수일 경우

				if($is_nos){
					
					$nos = explode(',',$no);
					$nos_cnt = count($nos);

					for($i=0;$i<$nos_cnt;$i++){

						$member = $member_control->get_memberNo($nos[$i]);

						$vals['mb_denied'] = $_POST['mb_denied'];
						$vals['mb_badness'] = $_POST['mb_badness'];
						$vals['mb_udate'] = $now_date;	// 정보 수정일
						$vals['mb_memo']	= $_POST['mb_memo'];

						$result = $member_control->update_member($vals,$member['mb_id']);

					}

				} else {

					$member = $member_control->get_member($mb_id);
					
					$vals['mb_denied'] = $_POST['mb_denied'];
					$vals['mb_badness'] = $_POST['mb_badness'];
					$vals['mb_udate'] = $now_date;	// 정보 수정일
					$vals['mb_memo']	= $_POST['mb_memo'];
					
					$result = $member_control->update_member($vals,$mb_id);

				}


				if($ajax)
					echo $mode . '/' . $result . '/' . $no;
				else
					$utility->popup_msg_js($config->_success('0011'));	// 메모 작성이 완료 되었습니다.

			break;

			## 회원정보 탈퇴처리 (단수)
			case 'left':

				$member = $member_control->get_memberNo($no);

				$vals['mb_left'] = 1;
				$vals['mb_left_date'] = $now_date;	 // 탈퇴일
				$vals['mb_udate'] = $now_date;	// 정보 수정일

				$result = $member_control->update_member($vals,$member['mb_id']);

				echo $result;

			break;

			## 선택 회원정보 탈퇴처리 (복수)
			case 'sel_left':
			
				$nos = explode(',',$no);
				$nos_cnt = count($nos);

				for($i=0;$i<$nos_cnt;$i++){

					$member = $member_control->get_memberNo($nos[$i]);

					$vals['mb_left'] = 1;
					$vals['mb_left_date'] = $now_date;	 // 탈퇴일
					$vals['mb_udate'] = $now_date;	// 정보 수정일

					$result = $member_control->update_member($vals,$member['mb_id']);

				}

				echo $result;

			break;

			## 회원정보 복귀 (단수)
			case 'return':

				$member = $member_control->get_memberNo($no);

				$vals['mb_left_request'] = 0;
				$vals['mb_left'] = 0;
				$vals['mb_left_date'] = "0000-00-00";	 // 초기화
				$vals['mb_udate'] = $now_date;	// 정보 수정일

				$member_control->reason_delete($no);	// 탈퇴 데이터 삭제

				$result = $member_control->update_member($vals,$member['mb_id']);

				echo $result;

			break;

			## 회원정보 복귀 (복수)
			case 'sel_return':

				$nos = explode(',',$no);
				$nos_cnt = count($nos);

				for($i=0;$i<$nos_cnt;$i++){

					$member = $member_control->get_memberNo($nos[$i]);

					$vals['mb_left_request'] = 0;
					$vals['mb_left'] = 0;
					$vals['mb_left_date'] = "0000-00-00";	 // 초기화
					$vals['mb_udate'] = $now_date;	// 정보 수정일

					$member_control->reason_delete($nos[$i]);	// 탈퇴 데이터 삭제

					$result = $member_control->update_member($vals,$member['mb_id']);

				}

				echo $result;

			break;


			## 개인회원 포토앨범 사진 업로드
			case 'photo_uploads':

				$mb_id = ($_POST['wr_id']) ? $_POST['wr_id'] : $_POST['mb_id'];

				$get_member = $member_control->get_member($mb_id);
				$mb_photos = $_POST['mb_photos'];

				// 기본 디렉토리가 없는 경우 생성
				@mkdir($alice['data_member_abs_path'] . '/' . $mb_id, 0707);
				@chmod($alice['data_member_abs_path'] . '/' . $mb_id, 0707);
				$file = $alice['data_member_abs_path'] . '/' . $mb_id . '/index.html';
				if(!file_exists($file)){	// 디렉토리 보안을 위해서
					$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
				}

				// 디렉토리가 없는 경우 생성
				$photos_path = $alice['data_member_abs_path'] . '/' . $mb_id . '/photos';
				@mkdir($photos_path, 0707);
				@chmod($photos_path, 0707);
				$file = $photos_path . "/index.html";
				if(!file_exists($file)){	// 디렉토리 보안을 위해서
					$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
				}

				$tmp_file	= $_FILES['photo_files']['tmp_name'];
				$filename	= $_FILES['photo_files']['name'];
				$filesize  = $_FILES['photo_files']['size'];

				$timg = @getimagesize($tmp_file);

				$photo_list = $user_control->member_photo_list($mb_id);

				if($photo_list){	// 사진 데이터가 있다면 mb_photos 를 기준으로 수정

					if(is_uploaded_file($tmp_file)){

						// 사이즈 체크

						// 용량 체크 (관리자에서 설정한 용량)

						// 확장자 체크
						$img_extension = $user_control->_img();

						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
							$photo = $user_control->get_member_photo($mb_id,$mb_photos);
							@unlink($photos_path . "/". $photo);	 // 기존 파일 삭제
							$file_upload = $utility->file_upload($tmp_file, $filename, $photos_path, $_FILES);	// 파일 업로드
							$upload_file = $file_upload['upload_file'];
							$vals['photo_source'] = $filename;
							$vals['photo_name'] = $upload_file;
							$vals['photo_filesize'] = $filesize;
							$vals['photo_width'] = $timg[0];
							$vals['photo_height'] = $timg[1];
							$vals['photo_type'] = $timg[2];
							$vals['photo_datetime'] = $now_date;

							// update
							$result = $user_control->user_photo_update($vals, $mb_id, 'member', $mb_photos);

						}
					}

				} else {	 // 사진 데이터가 없다면 mb_photos 를 기준으로 입력

					$vals['mb_type'] = $get_member['mb_type'];
					$vals['mb_id'] = $mb_id;
					$vals['photo_table'] = 'member';

					for($i=0;$i<=3;$i++){
						$vals['photo_no'] = $i;
						if($i==$mb_photos){
							if(is_uploaded_file($tmp_file)){
								$img_extension = $user_control->_img();	// 사진 업로드시 확장자 구분
								if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
									$file_upload = $utility->file_upload($tmp_file, $filename, $photos_path, $_FILES);	// 파일 업로드
									$upload_file = $file_upload['upload_file'];
									$vals['photo_source'] = $filename;
									$vals['photo_name'] = $upload_file;
									$vals['photo_filesize'] = $filesize;
									$vals['photo_width'] = $timg[0];
									$vals['photo_height'] = $timg[1];
									$vals['photo_type'] = $timg[2];
									$vals['photo_datetime'] = $now_date;
								}
							}
						} else {
							$vals['photo_source'] = "";
							$vals['photo_name'] = "";
							$vals['photo_filesize'] = "";
							$vals['photo_width'] = "";
							$vals['photo_height'] = "";
							$vals['photo_type'] = "";
							$vals['photo_datetime'] = $now_date;
						}
						// insert
						$result = $user_control->user_photo_insert($vals);
					}
				}
				
				if($result){
					echo "../../data/member/".$mb_id."/photos/".$upload_file;
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0036'));
					exit;
				}

			break;



			## 개인회원 포토앨범 사진 삭제
			case 'photo_deletes':

				$get_member = $member_control->get_member($mb_id);

				$photo_no = $_POST['photo_no'];

				$photos_path = $alice['data_member_abs_path'] . '/' . $mb_id . '/photos';

				$photo = $user_control->get_member_photo($mb_id,$photo_no);
				@unlink($photos_path . "/". $photo);	 // 기존 파일 삭제

				$vals['photo_source'] = "";
				$vals['photo_name'] = "";
				$vals['photo_filesize'] = "";
				$vals['photo_width'] = "";
				$vals['photo_height'] = "";
				$vals['photo_type'] = "";
				$vals['photo_datetime'] = $now_date;

				// update
				$result = $user_control->user_photo_update($vals, $mb_id, 'member', $photo_no);

				if($result){
					echo "../../images/comn/no_profileimg.gif";
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0035'));
					exit;
				}

			break;

			## 기업회원 열람서비스 기간 부여
			case 'oepn_service':

				$vals['mb_service_open'] = $_POST['mb_service_open'];
				$vals['mb_service_open_count'] = $_POST['mb_service_open_count'];

				$result = $member_control->service_upate($vals,$mb_id);

				echo $result;
			
			break;

			## 개인회원 열람서비스 기간 / 건수 부여
			case 'indi_oepn_service':

				$vals['mb_service_alba_open'] = $_POST['mb_service_alba_open'];
				$vals['mb_service_alba_count'] = $_POST['mb_service_alba_count'];
			
				$result = $member_control->service_upate($vals,$mb_id);

				echo $result;

			break;

			## 메일링 정보 설정
			case 'mailing_update':

				$vals['uid'] = $_POST['uid'];

				$vals['wr_mail_use'] = $_POST['wr_mail_use'];
				$vals['wr_mail_auto'] = $_POST['wr_mail_auto'];
				$vals['wr_mail_time'] = $_POST['wr_mail_time'];

				$vals['wr_sms_use'] = $_POST['wr_sms_use'];
				$vals['wr_sms_auto'] = $_POST['wr_sms_auto'];
				$vals['wr_sms_time'] = $_POST['wr_sms_time'];

				$vals['wr_company_mailing'] = $_POST['wr_company_mailing'];
				$vals['wr_individual_mailing'] = $_POST['wr_individual_mailing'];

				$vals['wr_sms_company'] = serialize($_POST['wr_sms_company']);
				$vals['wr_sms_individual'] = serialize($_POST['wr_sms_individual']);

				$vals['wr_wdate'] = $alice['time_ymd'];

				$result = $mailing_control->update_config($vals,$no);

				if($result){	 // 성공
					echo "0000";
				} else {	 // 실패
					echo "0001";
				}

			break;

			## 쪽지 사용 유무
			case 'memo_config':
				
				$vals['memo_use'] = $_POST['memo_use'];
				$vals['wdate'] = $alice['time_ymdhis'];

				$result = $config_control->config_update($vals, $no);

				if($result){	 // 성공
					echo "0000";
				} else {	 // 실패
					echo "0001";
				}

			break;

			## 쪽지 삭제 (단일)
			case 'memo_delete':

				$result = $memo_control->delete_memo($no);

				if($result){
					echo "0003";	// 쪽지 삭제가 완료 되었습니다.
				} else {
					echo "0005";	// 쪽지 삭제중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
				}

			break;

			## 쪽지 삭제 (복수)
			case 'memo_sel_delete':

				$nos = explode(",",$_POST['no']);
				$no_cnt = count($nos);

				for($i=0;$i<$no_cnt;$i++){
					
					$result = $memo_control->delete_memo($nos[$i]);

				}

				if($result){
					echo "0003";	// 쪽지 삭제가 완료 되었습니다.
				} else {
					echo "0005";	// 쪽지 삭제중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.
				}

			break;

			## 메일링 수동 발송
			case 'mailing_send':

				$type = $_POST['type'];	// mail / sms 구분
				$no = explode(",",$_POST['no']);
				$no_cnt = count($no);

				$mail_count = 0;
				$sms_count = 0;

				switch($type){
					
					## 이메일
					case 'mail':

						for($i=0;$i<$no_cnt;$i++){

							$mb = $member_control->get_memberNo($no[$i]);
							
							switch($mb['mb_type']){
								
								// 기업회원 메일링 발송
								case 'company':

									$company_custom_list = $alba_company_control->__CustomList("",""," where `wr_id` = '".$mb['mb_id']."' ");
									if($company_custom_list['total_count']){
										foreach($company_custom_list['result'] as $val){
											$company_mail_msg = $mailing_control->auto_make_Mail('company', $val);
											$mail_subject = $mb['mb_name']."님께서 신청하신 ".date('Y')."년 ".date('m')."월 ".date('d')."일 맞춤인재 정보입니다.";
											$mailer->sendMail($env['site_name'], $env['email'], $mb['mb_email'], $mail_subject, stripslashes($company_mail_msg['company_mailing']), 1);

											$mailing_mail['wr_type'] = "email";
											$mailing_mail['wr_id'] = $mb['mb_id'];
											$mailing_mail['wr_mb_type'] = "company";
											$mailing_mail['wr_subject'] = $mail_subject;
											$mailing_mail['wr_content'] = $company_mail_msg['company_mailing'];
											$mailing_mail['wr_wdate'] = $alice['time_ymdhis'];
											$mailing_control->insert_mailing_list($mailing_mail);

										$mail_count++;
										}	// custom_list foreach end.
									}	// total_count if end.

								break;

								// 개인회원 메일링 발송
								case 'individual':

									$individual_custom_list = $alba_individual_control->__CustomList("",""," where `wr_id` = '".$mb['mb_id']."' ");
									if($individual_custom_list['total_count']){
										foreach($individual_custom_list['result'] as $val){
											$individual_mail_msg = $mailing_control->auto_make_Mail('individual', $val);
											$mail_subject = $mb['mb_name']."님께서 신청하신 ".date('Y')."년 ".date('m')."월 ".date('d')."일 맞춤채용 정보입니다.";
											$mailer->sendMail($env['site_name'], $env['email'], $mb['mb_email'], $mail_subject, stripslashes($individual_mail_msg['individual_mailing']), 1);

											$mailing_mail['wr_type'] = "email";
											$mailing_mail['wr_id'] = $mb['mb_id'];
											$mailing_mail['wr_mb_type'] = "individual";
											$mailing_mail['wr_subject'] = $mail_subject;
											$mailing_mail['wr_content'] = $individual_mail_msg['individual_mailing'];
											$mailing_mail['wr_wdate'] = $alice['time_ymdhis'];
											$mailing_control->insert_mailing_list($mailing_mail);

										$mail_count++;
										}	// custom_list foreach end.
									}	// total_count if end.

								break;

							}	// mb_type switch end.
							
						}	// no_cnt for end.

					break;

					## SMS
					case 'sms':

						for($i=0;$i<$no_cnt;$i++){

							$mb = $member_control->get_memberNo($no[$i]);
							
							switch($mb['mb_type']){
								
								// 기업회원 SMS 발송
								case 'company':

									$company_custom_list = $alba_company_control->__CustomList("",""," where `wr_id` = '".$mb['mb_id']."' ");
									if($company_custom_list['total_count']){
										foreach($company_custom_list['result'] as $val){
											$sms_msg = $mailing_control->auto_make_Sms('company', $val);
											$destination = $mb['mb_hphone']. "|" . $mb['mb_name'];
											$sms_control->netfu_sms_Send( $sms_msg['company_msg'], $mb['mb_hphone'], $env['call_center'], $destination, $mb );
											
											$mailing_sms['wr_type'] = "sms";
											$mailing_sms['wr_id'] = $mb['mb_id'];
											$mailing_mail['wr_mb_type'] = "company";
											$mailing_sms['wr_content'] = $sms_msg['company_msg'];
											$mailing_sms['wr_wdate'] = $alice['time_ymdhis'];
											$mailing_control->insert_mailing_list($mailing_sms);

										$sms_count++;
										}
									}

								break;

								// 개인회원 SMS 발송
								case 'individual':

									$individual_custom_list = $alba_individual_control->__CustomList("",""," where `wr_id` = '".$mb['mb_id']."' ");
									if($individual_custom_list['total_count']){
										foreach($individual_custom_list['result'] as $val){
											$sms_msg = $mailing_control->auto_make_Sms('individual', $val);
											$destination = $mb['mb_hphone']. "|" . $mb['mb_name'];
											$sms_control->netfu_sms_Send( $sms_msg['individual_msg'], $mb['mb_hphone'], $env['call_center'], $destination, $mb );

											$mailing_sms['wr_type'] = "sms";
											$mailing_sms['wr_id'] = $mb['mb_id'];
											$mailing_mail['wr_mb_type'] = "individual";
											$mailing_sms['wr_content'] = $sms_msg['individual_msg'];
											$mailing_sms['wr_wdate'] = $alice['time_ymdhis'];
											$mailing_control->insert_mailing_list($mailing_sms);

										$sms_count++;
										}
									}

								break;

							}	// mb_type switch end.

						}	// no_cnt for end.
					break;

				}	// switch end.

				echo $mail_count."/".$sms_count;

			break;

			## SMS 수동 충전
			case 'sms_charge':

				$member = $member_control->get_member($mb_id);

				$mb_sms = str_replace(",","",$_POST['mb_sms']);
				$member_service = $member_control->get_service_member($member['mb_id']);	 // 서비스 정보

				$mb_sms = ($_POST['charge_type']=='+') ? $member['mb_sms'] + $mb_sms : $member['mb_sms'] - $mb_sms;

				$mb_vals['mb_sms'] = $mb_sms;
				$result = $member_control->update_member($mb_vals,$mb_id);
				$service_vals['mb_service_sms_count'] = $mb_sms;
				$result = $member_control->service_upate($service_vals,$mb_id);

				echo "sms_charge/".$result;

			break;

			## 점프 수동 충전
			case 'jump_charge':

				$member = $member_control->get_member($mb_id);

				$mb_jump = str_replace(",","",$_POST['mb_jump']);
				$member_service = $member_control->get_service_member($member['mb_id']);	 // 서비스 정보

				if( $member['mb_type'] == 'individual' ){

					$mb_jump = ($_POST['charge_type']=='+') ? $member_service['mb_resume_jump_count'] + $mb_jump : $member_service['mb_resume_jump_count'] - $mb_jump;
					$service_vals['mb_resume_jump_count'] = $mb_jump;

				} else {

					$mb_jump = ($_POST['charge_type']=='+') ? $member_service['mb_alba_jump_count'] + $mb_jump : $member_service['mb_alba_jump_count'] - $mb_jump;
					$service_vals['mb_alba_jump_count'] = $mb_jump;

				}

				$result = $member_control->service_upate($service_vals,$mb_id);

				echo "jump_charge/".$result;

			break;

			## 회원 로그인
			case 'member_login':

				unset($_SESSION[$user_control->sess_user_val]);
				unset($_SESSION[$user_control->sess_user_type]);
				unset($_SESSION[$user_control->sess_uid_val]);
				unset($_SESSION[$user_control->sess_level_val]);
				unset($_SESSION[$user_control->sess_name_val]);
				unset($_SESSION[$user_control->sess_nick_val]);
				unset($_SESSION[$user_control->sess_email_val]);
				unset($_SESSION[$user_control->sess_key_val]);

				$result = $user_control->user_session( $_POST['mb_id'], $_POST['mb_type'] );

				if($result){
					$utility->location_href("/"); 
				}

			break; 

		}
?>