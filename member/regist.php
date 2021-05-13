<?php
		/*
		* /application/member/process/regist.php
		* @author Harimao
		* @since 2013/07/03
		* @last update 2015/04/13
		* @Module v3.5 ( Alice )
		* @Brief :: Member regist
		* @Comment :: 회원 데이터 처리 프로세스
		*/

		$alice_path = "../";

		$cat_path = "../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$ajax = ($_POST['ajax']) ? true : false;
		$mb_type = $_POST['mb_type'];	 // 개인/기업회원 구분
		$mb_ssn = trim($_POST['mb_ssn']);
		$no = $_POST['no'];

		$mb_id = trim(strip_tags(mysql_escape_string($_POST['mb_id'])));
		$mb_password = trim(strip_tags(mysql_escape_string($_POST['mb_password'])));
		$mb_name = trim(strip_tags(mysql_escape_string($_POST['mb_name'])));

		// 이메일 주소
		if($_POST['mb_email'][0] && $_POST['mb_email'][1]){
			$mb_email = trim(strip_tags(mysql_escape_string($_POST['mb_email'][0]))) . "@" . trim(strip_tags(mysql_escape_string($_POST['mb_email'][1])));
			$mail_check = preg_match("/[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\.[0-9a-zA-Z_]+)*/", $mb_email); // 메일주소 정규식 체크
		} else {
			$mb_email = "";
		}


		// validate checking
		$form_email = $category_control->get_categoryCode('20130703114256_2703');	// 이메일

		//$id_check = preg_match("/^[0-9A-Z][0-9A-Z_-]{4,20}$/i", $mb_id);	 // 아이디 정규식 체크

		// 디렉토리가 없는 경우 생성
		// 로고 및 회사 사진 저장 디렉토리
		@mkdir($alice['data_member_abs_path'] . '/' . $mb_id, 0707);
		@chmod($alice['data_member_abs_path'] . '/' . $mb_id, 0707);
		$file = $alice['data_member_abs_path'] . '/' . $mb_id . '/index.html';
		if(!file_exists($file)){	// 디렉토리 보안을 위해서
			$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
		}
	
		switch($mode){

			## 회원 가입
			case 'member_regist':

				/*
				if(strlen($mb_email) < 12) {
					$utility->popup_msg_js($config->_errors('0029'));	// 이메일 주소가 너무 짧습니다 최소 12자 이상 입력해 주세요.
					exit;
				}

				if(!$mail_check) {
					$utility->popup_msg_js($config->_errors('0027'));	// 이메일 주소가 올바르지 않습니다.
					exit;
				}
				if(!$id_check){
					$utility->popup_msg_js("아이디는 ".$user_control->_errors('0004'));	// 아이디는 5~20자의 영문 소문자와 숫자의 조합만 사용할 수 있습니다.
					exit;
				}
				*/

				$vals['mb_ssn'] = $mb_ssn;
				$vals['mb_type'] = $mb_type;	 // facebook / twitter / email 구분
				$vals['mb_group'] = $env['member_group'];	// 관리자에서 설정한 회원그룹
				$vals['mb_level'] = $env['register_level'];		// 기본 레벨


				/* 아이디 검사 */
					if(!$mb_id){	// 아이디 입력 검사
						if($ajax)
							echo $user_control->_errors('0005');	// 아이디를 입력해 주세요
						else 
							$utility->popup_msg_js($user_control->_errors('0005'));
						exit;
					} else {
						// 아이디 공백 검사
						if(!ereg("([^[:space:]]+)", $mb_id) || ereg("([[:space:]]+)",$mb_id)) {
							if($ajax)
								echo $user_control->_errors('0006');	// 아이디에 공백이 존재합니다.\n\n공백없이 입력해 주세요.
							else 
								$utility->popup_msg_js($user_control->_errors('0006'));
							exit;
						}
						// 아이디 중복검사
						$check_id = $user_control->checkUid_member($mb_id);
						if($check_id){
							if($ajax)
								echo $user_control->_errors('0007');	// 이미 존재하는 아이디 입니다.
							else 
								$utility->popup_msg_js($user_control->_errors('0007'));
							exit;
						}
						$vals['mb_id'] = $mb_id;
					}
				/* //아이디 검사 */


				// 패스워드 입력 검사
				if(!$mb_password){
					if($ajax)
						echo $user_control->_errors('0008');	// 비밀번호를 입력해 주세요.
					else 
						$utility->popup_msg_js($user_control->_errors('0008'));
					exit;
				} else {
					$vals['mb_password'] = md5($mb_password);
				}


				// 이름 입력 검사
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

				
				/* 닉네임 검사 */
					if(!$mb_nick){	// 닉네임 입력 검사
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
						$check_nick = $user_control->checkNick_member($mb_nick);
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


				/* 이메일 검사
				if($form_email['etc_0']){
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
						$vals['mb_email'] = $mb_email;
					}
				} else {
					if($mb_email){
						// 이메일 중복검사
						$check_email = $user_control->checkEmail_member($mb_email);
						if($check_email){
							if($ajax) {
								echo $user_control->_errors('0013');	// 이미 등록된 이메일 주소 입니다.
							} else 
								$utility->popup_msg_js($user_control->_errors('0013'));
							exit;
						}
						$vals['mb_email'] = $mb_email;
					}
				}
				 //이메일 검사 */

				if($form_email['etc_0']){
					if(!$mb_email){	// 이메일 입력 검사
						if($ajax) {
							echo $config->_errors('0028');	// 이메일 주소를 입력해 주세요.
						} else 
							$utility->popup_msg_js($config->_errors('0028'));
						exit;
					}
				}

				$vals['mb_email'] = $mb_email;

				$vals['mb_birth'] = $_POST['mb_birth_year'] . "-" . $_POST['mb_birth_month'] . "-" . $_POST['mb_birth_day'];
				$vals['mb_gender'] = $_POST['mb_gender'];

				$vals['mb_phone'] = @implode('-',$_POST['mb_phone']);
				$vals['mb_hphone'] = @implode('-',$_POST['mb_hphone']);
				$vals['mb_receive'] = @implode(',',$_POST['mb_receive']);

				$vals['mb_zipcode'] = @implode('',$_POST['mb_zipcode']);
				$vals['mb_address0'] = $_POST['mb_address0'];
				$vals['mb_address1'] = $_POST['mb_address1'];

				$vals['mb_homepage'] = ($_POST['mb_homepage']) ? $utility->add_http($_POST['mb_homepage']) : "";

				$vals['mb_login_count'] = 1;
				$vals['mb_wdate'] = $now_date;	 // 가입일
				$vals['mb_last_login'] = $_SERVER['REMOTE_ADDR'];	// 로그인 ip

				if($_POST['mb_birth_year'] && $_POST['mb_birth_month'] && $_POST['mb_birth_day'])	// 성인유무
					$vals['is_adult'] = $utility->is_adult($_POST['mb_birth_year'].$_POST['mb_birth_month'].$_POST['mb_birth_day']);

				## 01. 기본 회원정보 입력
				$user_result = $user_control->user_regist($vals);

				if($mb_type=='company'){	 // 기업회원 전용 데이터

					$company_vals['is_public'] = 1;	// 처음 가입시 기업회원 입력 데이터는 기본 정보로 선택
					$company_vals['mb_id'] = $mb_id;

					$company_vals['mb_ceo_name'] = $_POST['mb_ceo_name'];
					$company_vals['mb_company_name'] = $_POST['mb_company_name'];
					$company_vals['mb_biz_type'] = $_POST['mb_biz_type'];
					$company_vals['mb_biz_no'] = @implode('-',$_POST['mb_biz_no']);

					$company_vals['mb_biz_phone'] = $vals['mb_phone'];						// 회사번호
					$company_vals['mb_biz_hphone'] = $vals['mb_hphone'];					// 회사 휴대폰번호
					$company_vals['mb_address_road'] = $vals['mb_address_road'];		// 회사 도로명 주소 유무
					$company_vals['mb_biz_zipcode'] = $vals['mb_zipcode'];					// 회사 우편번호
					$company_vals['mb_biz_address0'] = $vals['mb_address0'];				// 회사 주소1
					$company_vals['mb_biz_address1'] = $vals['mb_address1'];				// 회사 주소2
					$company_vals['mb_biz_email'] = $vals['mb_email'];						// 회사 이메일주소

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

					## 02. 기업회원 정보 입력
					$company_result = $user_control->company_user_regist($company_vals);

				}

				## 03. 서비스 테이블 임시 데이터 입력
				$service_result = $user_control->user_service_regist( array('mb_id' => $mb_id) );

				$result = array();	// 결과 값

				if($mb_type=='individual'){	 // 개인회원

					if($user_result && $service_result){

						$result['msg'] = "0000";
						$result['result'] = true;
						
					} else {	 // 실패시

						$result['msg'] = "0014";
						$result['result'] = false;

					}

				} else if($mb_type=='company') {	// 기업회원

					if($user_result && $company_result && $service_result){

						$result['msg'] = "0000";
						$result['result'] = true;

					} else {	 // 실패시

						$result['msg'] = "0014";
						$result['result'] = false;

					}

				}

				// 성공 했다면 성공 메시지 발송~
				if($result['msg']=='0000'){

					$get_member = $member_control->get_member($mb_id);
					$mb_email = $get_member['mb_email'];
					$mb_receive = explode(",",$get_member['mb_receive']);	// 수신여부

					## 01. 가입축하 메일 전송
					if(@in_array('email',$mb_receive)){	 // 이메일 수신 확인
						$mail_control->make_mail_Send('member_regist', $mb_email);	
					}
					## 02. 가입축하 문자 전송
					if(@in_array('sms',$mb_receive)){	 // 문자 수신 확인
						$sms_control->send_sms_user('member_regist', $get_member);
					}
					## 03. 회원가입 포인트 지급
					$point_control->point_insert($mb_id, $env['register_point'], $alice['time_ymd']." 회원가입", "@register", $mb_id, $alice['time_ymd']);

					## 04. 세션 발급
					$key = $user_control->user_session( $mb_id, $mb_type );

					if($ajax){

						echo @implode('/',$result);

					} else {

						$utility->popup_msg_js("",$alice['member_path']."/result.php");

					}

				// 실패시
				} else {

					if($ajax){

						echo $result['msg'];

					} else {

						$utility->popup_msg_js($config->_errors($result['msg']));

					}

				}

			break;
			


			## 회원 수정
			case 'member_update':

				if(!$is_member){	// 회원이 아니라면
					$utility->popup_msg_js($user_control->_errors('0015'), $alice['member_path'] . "/login.php?url=".$urlencode);
					exit;
				}

				$get_member = $member_control->get_member($mb_id);	// 회원정보

				// 패스워드 입력 검사
				if(!$mb_password){
					if($ajax)
						echo $user_control->_errors('0008');	// 비밀번호를 입력해 주세요.
					else 
						$utility->popup_msg_js($user_control->_errors('0008'));
					exit;
				} else {
					// 패스워드 비교					
					if($get_member['mb_password'] != md5($mb_password)){

							$result11  = " <script> ";
							$result11 .= " alert('비밀번호가 일치하지 않습니다. 비밀번호를 확인해 주세요.'); ";	
							$result11 .= " history.go(-1); ";
							$result11 .= " </script> ";
							
							echo $result11;
							
							exit;
						
                    }

					$vals['mb_password'] = md5($mb_password);
				}

				/* 닉네임 검사 */
					if(!$mb_nick){	// 닉네임 입력 검사
						$vals['mb_nick'] = $mb_nick;
/*
						if($ajax)
							echo $user_control->_errors('0010');	// 닉네임을 입력해 주세요
						else 
							$utility->popup_msg_js($user_control->_errors('0010'));
						exit;
*/
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
						$check_nick = $user_control->checkNick_member($mb_nick,$mb_id);
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
					if(!$mb_email){	// 이메일 입력 검사
/*
						if($ajax) {
							echo $config->_errors('0028');	// 이메일 주소를 입력해 주세요.
						} else 
							$utility->popup_msg_js($config->_errors('0028'));
						exit;
*/
					}
					$vals['mb_email'] = $mb_email;
				/* //이메일 검사 */


				$vals['mb_phone'] = @implode('-',$_POST['mb_phone']);
				$vals['mb_hphone'] = @implode('-',$_POST['mb_hphone']);
				$vals['mb_receive'] = @implode(',',$_POST['mb_receive']);

				$new_address = $_POST['new_address'];
				if($new_address){	// 도로명 주소 체크
					$vals['mb_address_road'] = $new_address;
					$vals['mb_zipcode'] = @implode('-',$_POST['new_mb_zipcode']);
					$vals['mb_address0'] = $_POST['new_mb_address0'];
					$vals['mb_address1'] = $_POST['new_mb_address1'];
				} else {	 // 일반 주소 체크
					$vals['mb_zipcode'] = @implode('-',$_POST['mb_zipcode']);
					$vals['mb_address0'] = $_POST['mb_address0'];
					$vals['mb_address1'] = $_POST['mb_address1'];
				}

				$vals['mb_homepage'] = ($_POST['mb_homepage']) ? $utility->add_http($_POST['mb_homepage']) : "";

				$vals['mb_udate'] = $now_date;	 // 수정일
				if( $_POST['mb_type'] != "individual" ){
					$vals['mb_name'] = $_POST['mb_name'];
				}
				//$vals['mb_birth'] = $_POST['mb_birth_year'] . "-" . $_POST['mb_birth_month'] . "-" . $_POST['mb_birth_day'];
				//$vals['mb_gender'] = $_POST['mb_gender'];

				## 01. 기본 회원정보 수정
				$user_result = $user_control->user_update($vals,$mb_id);

				if($mb_type=='company'){	 // 기업회원 전용 데이터

					$company_vals['mb_ceo_name'] = $_POST['mb_ceo_name'];
					$company_vals['mb_company_name'] = $_POST['mb_company_name'];
					$company_vals['mb_biz_type'] = $_POST['mb_biz_type'];
					$company_vals['mb_biz_no'] = @implode('-',$_POST['mb_biz_no']);

					$company_vals['mb_biz_phone'] = $vals['mb_phone'];						// 회사번호
					$company_vals['mb_biz_hphone'] = $vals['mb_hphone'];					// 회사 휴대폰번호
					$company_vals['mb_address_road'] = $vals['mb_address_road'];		// 회사 도로명 주소 유무
					$company_vals['mb_biz_zipcode'] = $vals['mb_zipcode'];
					$company_vals['mb_biz_address0'] = $vals['mb_address0'];
					$company_vals['mb_biz_address1'] = $vals['mb_address1'];
					$company_vals['mb_biz_email'] = $vals['mb_email'];

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

					## 02. 기업회원 정보 수정
					//$company_result = $member_control->update_company_member($company_vals,$mb_id);
					$company_result = $member_control->update_company_memberNo($company_vals,$_POST['company_no']);

				}

				## 회원정보 수정 문자 전송
				$mb_receive = explode(",",$get_member['mb_receive']);	// 수신여부
				//if(@in_array('sms',$mb_receive)){	 // 문자 수신 확인
					$sms_control->send_sms_user('member_update', $get_member, "", "", $mb_receive);
				//}

				$result = array();	// 결과 값

				if($mb_type=='individual'){	 // 개인회원

					if($user_result){	 // 성공시
						if($ajax){
							$result['msg'] = "0000";
							$result['result'] = true;
						} else {
							$utility->popup_msg_js("",$alice['individual_path']."/");
							exit;
						}
					} else {	 // 실패시
						if($ajax){
							$result['msg'] = "0027";
							$result['result'] = false;
						} else {
							$utility->popup_msg_js($user_control->_errors('0027'));
							exit;
						}
					}

				} else if($mb_type=='company') {	// 기업회원

					if($user_result && $company_result){

						if($ajax){
							$result['msg'] = "0000";
							$result['result'] = true;
						} else {
							$utility->popup_msg_js("",$alice['company_path']."/");
							exit;
						}

					} else {	 // 실패시
						if($ajax){
							$result['msg'] = "0027";
							$result['result'] = false;
						} else {
							$utility->popup_msg_js($user_control->_errors('0027'));
							exit;
						}
					}

				}

				//echo @implode('/',$result);

				if($mb_type=='individual'){
					$utility->popup_msg_js("",$alice['individual_path']);
				} else if($mb_type=='company'){
					$utility->popup_msg_js("",$alice['company_path']);
				}

			break;


			## 회사 로고 업로드
			case 'logo_upload':
			
				$get_company = $user_control->get_member_company_no($_POST['company_no']);

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
						@unlink($logo_path . "/" . $get_company['mb_logo']);	// 기존 파일 삭제
						$file_upload = $utility->file_upload($tmp_file, $filename, $logo_path, $_FILES);	// 파일 업로드
						$upload_file = $file_upload['upload_file'];
						$vals['mb_logo'] = $upload_file;	// 변수 할당
						$vals['mb_logo_sel'] = 0;	// 기본 로고 초기화
						$result = $user_control->company_user_updateNo($vals,$get_company['no']);	// 수정
					}

					if($result){
						echo "../data/member/".$mb_id."/logo/".$upload_file;
					} else {
						$utility->popup_msg_ajax($user_control->_errors('0037'));
						exit;
					}

				} else {
					$utility->popup_msg_ajax($user_control->_errors('0038'));
					exit;
				}

			break;


			## 회사 로고 삭제
			case 'logo_delete':

				$company_no = $_POST['company_no'];
				$get_company = $user_control->get_member_company_no($company_no);

				$get_member = $user_control->get_member_company($mb_id);

				// 프로필 사진 저장 디렉토리
				$photo_path = $alice['data_member_abs_path'] . '/' . $mb_id . '/logo';

				@unlink($photo_path . "/". $get_company['mb_logo']);	 // 기존 파일 삭제

				$vals['mb_logo'] = "";

				// update
				$result = $user_control->company_user_updateNo($vals,$company_no);	// 수정

				if($result){
					echo $alice['data_logo_path']."/".$employ_logo['wr_content'];
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0037'));
					exit;
				}
			break;


			## 회사이미지 업로드
			case 'photo_upload':

				$company_no = ($_POST['company_no']) ? $_POST['company_no'] : 0;
				$get_member = $member_control->get_member($mb_id);
				$mb_photos = $_POST['mb_photos'];

				// 디렉토리가 없는 경우 생성
				// 로고 및 회사 사진 저장 디렉토리
				$photos_path = $alice['data_member_abs_path'] . '/' . $mb_id . '/photos';
				@mkdir($photos_path, 0707);
				@chmod($photos_path, 0707);
				$file = $photos_path . "/index.html";
				if(!file_exists($file)){	// 디렉토리 보안을 위해서
					$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
				}

				$tmp_file	= $_FILES['photo_files']['tmp_name'];
				$filename	= $_FILES['photo_files']['name'];
				$filesize		= $_FILES['photo_files']['size'];

				$timg = @getimagesize($tmp_file);

				$photo_con = " and `company_no` = '".$company_no."' and `photo_no`='".$mb_photos."' and `photo_table` = 'company' ";
				$photo_list = $user_control->member_photo_list($mb_id, $photo_con);

				if($photo_list){	// 사진 데이터가 있다면 mb_photos 를 기준으로 수정

					if(is_uploaded_file($tmp_file)){

						// 사이즈 체크

						// 용량 체크 (관리자에서 설정한 용량)

						// 확장자 체크
						$img_extension = $user_control->_img();

						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
							$photo = $user_control->get_member_photo($mb_id,$mb_photos," and `company_no` = '".$company_no."' ");
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
							$result = $user_control->user_photo_update($vals, $mb_id, 'company', $mb_photos, " and `company_no` = '".$company_no."' ");

						}
					}

				} else {	 // 사진 데이터가 없다면 mb_photos 를 기준으로 입력


					for($i=0;$i<=4;$i++){
						
						if($i==$mb_photos){ 
							if(is_uploaded_file($tmp_file)){

								// 사이즈 체크

								// 용량 체크 (관리자에서 설정한 용량)

								// 확장자 체크
								$img_extension = $user_control->_img();

								if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크

									$vals['mb_type'] = $get_member['mb_type'];
									$vals['mb_id'] = $mb_id;
									$vals['company_no'] = $company_no; 
									$vals['photo_table'] = 'company';
									$vals['photo_no'] = $mb_photos;

									$file_upload = $utility->file_upload($tmp_file, $filename, $photos_path, $_FILES);	// 파일 업로드
									$upload_file = $file_upload['upload_file'];
									$vals['photo_source'] = $filename;
									$vals['photo_name'] = $upload_file;
									$vals['photo_filesize'] = $filesize;
									$vals['photo_width'] = $timg[0];
									$vals['photo_height'] = $timg[1];
									$vals['photo_type'] = $timg[2];
									$vals['photo_datetime'] = $now_date;

									// insert
									$result = $user_control->user_photo_insert($vals);
								}
							}
						}  

					}					

				}
				
				if($result){
					echo "../data/member/".$mb_id."/photos/".$upload_file;
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0029'));
					exit;
				}

			break;


			## 회사이미지 삭제
			case 'photo_delete':

				$company_no = $_POST['company_no'];

				$get_member = $member_control->get_member($mb_id);

				$photo_no = $_POST['photo_no'];

				$photos_path = $alice['data_member_abs_path'] . '/' . $mb_id . '/photos';

				$photo = $user_control->get_member_photo($mb_id,$photo_no," and `company_no` = '".$company_no."' ");
				@unlink($photos_path . "/". $photo);	 // 기존 파일 삭제

				$vals['photo_source'] = "";
				$vals['photo_name'] = "";
				$vals['photo_filesize'] = "";
				$vals['photo_width'] = "";
				$vals['photo_height'] = "";
				$vals['photo_type'] = "";
				$vals['photo_datetime'] = $now_date;

				// update
				$result = $user_control->user_photo_update($vals, $mb_id, 'company', $photo_no, " and `company_no` = '".$company_no."' ");

				if($result){
					echo "../images/comn/no_profileimg.gif";
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0035'));
					exit;
				}

			
			break;



			## 프로필 사진 업로드
			case 'profile_photo_upload':
			
				$get_member = $member_control->get_member($mb_id);
				$mb_photos = $_POST['mb_photos'];

				$vals['mb_udate'] = $now_date;	// 수정일

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
						$vals['mb_photo'] = $upload_file;
						// update
						$result = $user_control->user_update($vals,$mb_id);
					}

					if($result){
						echo "../data/member/".$mb_id."/".$upload_file;
					} else {
						$utility->popup_msg_ajax($user_control->_errors('0033'));
						exit;
					}
				}

			break;



			## 프로필 사진 삭제
			case 'profile_photo_remove':

				$get_member = $member_control->get_member($mb_id);

				$vals['mb_udate'] = $now_date;	// 수정일

				// 프로필 사진 저장 디렉토리
				$photo_path = $alice['data_member_abs_path'] . '/' . $mb_id;

				@unlink($photo_path . "/". $get_member['mb_photo']);	 // 기존 파일 삭제

				$vals['mb_photo'] = "";

				// update
				$result = $user_control->user_update($vals,$mb_id);

				if($result){
					echo "../images/basic/bg_noPhoto.gif";
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0033'));
					exit;
				}

			break;



			## 프로필 비/공개 체크
			case 'member_views':

				$field = $_POST['field'];
				$value = $_POST['value'];
				$value_arr = array( "phone" => "전화번호", "hphone" => "휴대폰", "email" => "이메일", "homepage" => "홈페이지" );

				$vals[$field] = $_POST['sel'];

				$vals['mb_udate'] = $now_date;	// 수정일

				// update
				$result = $user_control->user_update($vals,$mb_id);

				if($result){
					echo $value_arr[$value] . " " . $user_control->_success('0001');
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0034'));
					exit;
				}

			break;



			## 개인회원 포토앨범 사진 업로드
			case 'photo_uploads':

				$get_member = $member_control->get_member($mb_id);
				$mb_photos = $_POST['mb_photos'];

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

					for($i=0;$i<=4;$i++){
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
					echo "../data/member/".$mb_id."/photos/".$upload_file;
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
					echo "../images/comn/no_profileimg.gif";
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0035'));
					exit;
				}

			break;

			## 비밀번호 변경
			case 'password_update':
			
				if(!$is_member){	// 회원이 아니라면
					$utility->popup_msg_js($user_control->_errors('0015'), $alice['member_path'] . "/login.php?url=".$urlencode);
					exit;
				}

				$mb_password = trim(strip_tags(mysql_escape_string($_POST['mb_password'])));
				$new_password = trim(strip_tags(mysql_escape_string($_POST['new_password'])));
				$new_password_re = trim(strip_tags(mysql_escape_string($_POST['new_password_re'])));

				// 패스워드 입력 검사
				if(!$mb_password){
					$utility->popup_msg_js($user_control->_errors('0040'));
					exit;
				}

				// 패스워드 검사
				$get_member = $member_control->get_member($mb_id);
				if($get_member['mb_password'] != md5($mb_password)){
					$utility->popup_msg_js($user_control->_errors('0018'));
					exit;
				}

				// 변경할 패스워드 입력 검사
				if(!$new_password){
					$utility->popup_msg_js($user_control->_errors('0041'));
					exit;
				}

				if( $new_password != $new_password_re ){
					$utility->popup_msg_js($user_control->_errors('0042'));
					exit;
				}

				$vals['mb_password'] = md5($new_password);
				$vals['mb_udate'] = $now_date;	// 수정일

				$result = $user_control->user_update($vals,$mb_id);

				if($result){
					if($mb_type=='individual'){
						$utility->popup_msg_js("",$alice['individual_path']);
					} else if($mb_type=='company'){
						$utility->popup_msg_js("",$alice['company_path']);
					}
				} else {
					$utility->popup_msg_js($user_control->_errors('0039'));
					exit;
				}

			break;

			## 탈퇴요청
			case 'member_left':

				if(!$is_member){	// 회원이 아니라면
					$utility->popup_msg_js($user_control->_errors('0015'), $alice['member_path'] . "/login.php?url=".$urlencode);
					exit;
				}

				$left_agreement = $_POST['left_agreement'];
				$mb_password = trim(strip_tags(mysql_escape_string($_POST['mb_password'])));
				$mb_email = trim(strip_tags(mysql_escape_string($_POST['mb_email'])));

				// 약관 동의 확인
				if(!$left_agreement){
					$utility->popup_msg_js($user_control->_errors('0043'));
					exit;
				}

				// 이메일 입력 검사
				if(!$mb_email){
					$utility->popup_msg_js($config->_errors('0028'));
					exit;
				}

				// 패스워드 입력 검사
				if(!$mb_password){
					$utility->popup_msg_js($user_control->_errors('0008'));
					exit;
				}

				// 패스워드 검사
				$get_member = $member_control->get_member($mb_id);
				if($get_member['mb_password'] != md5($mb_password)){
					$utility->popup_msg_js($user_control->_errors('0018'));
					exit;
				}

				// 이메일 검사
				if($get_member['mb_email'] != $mb_email){
					$utility->popup_msg_js($user_control->_errors('0044'));
					exit;
				}

				// 탈퇴사유
				$reason_val['uid'] = $mb_id;
				$reason_val['reason_type'] = 'member_left';
				$reason_val['reason_no'] = $no;

				$left_reason = (!$_POST['left_reason'] || $_POST['left_reason']=='self') ? $_POST['left_reason_txt'] : $_POST['left_reason'];
				$reason_val['reason'] = $left_reason;
				$reason_val['wdate'] = $now_date;
				$member_control->reason_insert($reason_val);

				// 탈퇴요청
				$vals['mb_left_request'] = 1;
				$vals['mb_left_request_date'] = $now_date;

				## 회원 탈퇴요청 문자 전송
				$mb_receive = explode(",",$get_member['mb_receive']);	// 수신여부
				//if(@in_array('sms',$mb_receive)){	 // 문자 수신 확인
					$sms_control->send_sms_user('member_left', $get_member, "", "", $mb_receive);
				//}

				$result = $user_control->user_update($vals,$mb_id);

				if($result){
					$user_control->user_logout($_SESSION[$user_control->sess_user_val]);	// 로그아웃
					$utility->popup_msg_js("", '/');
				}

			break;

			## 이메일로 아이디 찾기
			case 'email_find_id':
				
				$find_name = $_POST['find_name'];
				$find_email = $_POST['find_email'];

				$member_check = $user_control->checkNameEmail_member($find_name,$find_email);
				
				if($member_check){
					$mail_control->make_mail_Send('member_find', $find_email);
					//$utility->popup_msg_ajax("이메일 주소 [".$find_email."] 로 메일이 발송 되었습니다.");
					$result = 1;
				} else {
					//$utility->popup_msg_ajax($user_control->_errors('0047'));	// 가입된 정보가 확인되지 않습니다.\\n\\n가입하신 회원명, 이메일주소를 확인하세요.
					$result = 0;
				}

				echo $result;

			break;


		}	// switch end.
?>