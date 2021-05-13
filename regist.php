<?php
$alice_path = "./";
$cat_path = "./";
include_once $alice_path . "_core.php";

### : PG로 넘어온경우에 실행
// :allthegate
if($_POST['param_opt_1']) $_POST['mode'] = $_POST['param_opt_1'];

// : 이니시스
if($netfu_payment->use_pg['pg_company']=='inicis') {
	$_post_val = $_POST['merchantData'] ? $_POST['merchantData'] : $_POST['P_NOTI'];
	if($_post_val) {
		$_post_arr = explode(":", $_post_val);
		$_POST['mode'] = $_post_arr[0];
		$_POST['no'] = $_post_arr[1];
	}
}




##########################################
/*
게시판인 경우
*/
##########################################
if(in_array($_POST['mode'], array('board_reply_write'))) {
	$mode = $_POST['mode'];
	$board_code = $_POST['board_code'];
	$code = $_POST['code'];
	$no = $_POST['no'];
	$wr_no = ($_POST['wr_no']) ? $_POST['wr_no'] : $no;
	$sca = $_POST['sca'];	// 카테고리

	$comment_id = $_POST['comment_id'];	// 코멘트 no

	$wr_subject = $_POST['wr_subject'];
	$wr_content = $_POST['wr_content'];
	$wr_name = $_POST['wr_name'];
	$wr_password = $_POST['wr_password'];

	$wr_secret = $_POST['wr_secret'];	// 비밀글 체크
	$wr_option = $_POST['wr_option'];	// 옵션(공지사항 등등)

	$html = $_POST['html'];	// 다이나믹 태그(HTML) 사용유무
	$wr = $board_control->get_write($write_table, $wr_no);

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
}

switch($_POST['mode']) {

	// : 회원탈퇴
	case "member_left":
		if(!$is_member){	// 회원이 아니라면
			$arr['msg'] = $user_control->_errors('0015');
			$arr['move'] = NFE_URL.'/include/login.php';
		}

		if(!$arr['msg']) {
			$mb_id = $member['mb_id'];
			$left_agreement = $_POST['left_agreement'];
			$mb_password = trim(strip_tags($_POST['mb_password']));
			$mb_email = trim(strip_tags($_POST['mb_email']));
			$get_member = $member_control->get_member($member['mb_id']);

			// 약관 동의 확인
			if(!$left_agreement){
				$arr['msg'] = $user_control->_errors('0043');

			// 이메일 입력 검사
			} else if(!$mb_email){
				$arr['msg'] = $config->_errors('0028');

			// 패스워드 입력 검사
			} else if(!$mb_password){
				$arr['msg'] = $user_control->_errors('0008');

			// 패스워드 검사
			} else if($get_member['mb_password'] != md5($mb_password)){
				$arr['msg'] = $user_control->_errors('0018');

			// 이메일 검사
			} else if($get_member['mb_email'] != $mb_email){
				$arr['msg'] = "이메일 주소를 확인해 주세요.\n\n가입하신 ID 와 이메일 주소가 정확하지 않습니다.";

			} else {

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
					$arr['msg'] = "회원탈퇴 신청이 완료되었습니다.";
					$arr['move'] = NFE_URL.'/';
				}
			}
		}
		die(json_encode($arr));
		break;

	// : 아이디찾기
	case "id_find":
	case "pw_find":
		$find_name = addslashes($_POST['mb_name']);
		$find_email = addslashes(@implode("@", $_POST['mb_email']));
		$find_id = addslashes($_POST['mb_id']);

		if($_POST['mode']=='pw_find') $_wh = " and mb_id='".trim($find_id)."'";
		$q = "select * from alice_member where `mb_name`='".trim($find_name)."' and `mb_email`='".trim($find_email)."' ".$_wh." order by `no` desc limit 1";
		$row = sql_fetch($q);

		// 이메일 금지어 체크 (보안상)
		foreach($user_control->denied_val as $key => $denied) { 
			if(stristr($find_email,$denied)) $row2 = false;
		}
		
		if($row){
			$mail_control->make_mail_Send('member_find', $find_email, $find_id); 
			if($_POST['mode']=='pw_find') $sms_control->send_sms_user('member_password', $row, $mb_password); // : $mb_password변수는 make_mail_Send 함수에서 global합니다.
			$arr['msg'] = '이메일 주소 ['.$find_email.'] 로 메일이 발송 되었습니다.';
			$arr['move'] = NFE_URL.'/include/login.php';
		} else {
			$arr['msg'] = "가입된 정보가 확인되지 않습니다.\n\n가입하신 회원명, 이메일주소를 확인하세요.";
		}

		die(json_encode($arr));
		break;

	case "allow_ext":
		if($_POST['bo_table']) {
			$allow_ext_arr = array();
			$allow_ext_arr[] = preg_replace("/ /", "", $board['bo_upload_ext_img']);
			$allow_ext_arr[] = preg_replace("/ /", "", $board['bo_upload_ext_fla']);
			$allow_ext_arr[] = preg_replace("/ /", "", $board['bo_upload_ext_mov']);
			$allow_ext_arr[] = preg_replace("/ /", "", $board['bo_upload_ext']);
			$allow_ext = strtolower(trim(@implode("|", $allow_ext_arr)));

			$get_ext = strtolower(trim($netfu_util->get_ext($_POST['value'])));
			$chk_ext = explode("|", $allow_ext);

			$arr['msg'] = "";
			if(!$get_ext) {
				$arr['msg'] = "파일을 업로드해주시기 바랍니다.";
			} else if(!@in_array($get_ext, $chk_ext)) {
				$arr['msg'] = str_replace(array("|"), array(", "), $allow_ext)." 파일만 업로드 가능합니다.";
			}
			die(json_encode($arr));
		}
		break;

	case "rand_num_check":
		$arr['msg'] = "";
		$key = $_SESSION['rand_nums'];
		if (!$member['mb_id'] && !($key && strtolower($key) == strtolower($_POST['word']))) {
			$arr['msg'] = "자동등록방지키가 잘못되었습니다. 다시 등록해주세요";
		}
		die(json_encode($arr));
		break;

### : 기본정보
// : 로그인
	case "login_process":
	case "member_write_login":
		$q = "select * from alice_member where `mb_id`='".addslashes($_POST['login_id'])."' and `mb_password`=md5('".addslashes($_POST['login_passwd'])."') and `is_delete`=0 and `mb_badness`=0 and mb_type='".addslashes($_POST['mb_type'])."'";
		$row = sql_fetch($q);
		if(!$row) $arr['msg'] = "아이디와 비밀번호를 정확히 입력해주시기 바랍니다.";
		else {
			$url = urldecode($_POST['url']);
			$url = strpos($url, 'regist.php')!==false ? NFE_URL.'/' : $url;
			$key = $user_control->user_session( $row['mb_id'], $row['mb_type'] );
			$arr['move'] = strpos($url, $_SERVER['HTTP_HOST'])!==false ? $url : NFE_URL.'/';
			$arr['msg'] = '';
		}
		if($_POST['mode']=='member_write_login') return;
		die(json_encode($arr));
		break;

// : 비밀번호 변경
	case "password_update":
		$arr['msg'] = '로그인하셔야 이용가능합니다.';
		$arr['move'] = NFE_URL.'/include/login.php';

		if($member['mb_id']) {
			if($member['mb_password']!=md5($_POST['mb_password'])) {
				$arr['msg'] = "비밀번호를 올바르게 입력해주시기 바랍니다.";
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			} else {
				$q = "update alice_member set `mb_password`=md5('".$_POST['new_password']."') where `mb_id`='".$member['mb_id']."' and `mb_type`='".$member['mb_type']."'";
				$update = sql_query($q);
				$arr['msg'] = "비밀번호 변경이 완료되었습니다.";
				$arr['move'] = NFE_URL.'/';
			}
		}
		$netfu_util->page_move($arr['msg'], $arr['move']);
		exit;
		break;


// : 회원가입
	case "member_write":
		/*
		mb_ssn='".addslashes($_POST['asdf'])."',
		mb_foreigner='".addslashes($_POST['asdf'])."',
		mb_denied='".addslashes($_POST['asdf'])."',
		mb_group='".addslashes($_POST['asdf'])."',
		mb_point='".addslashes($_POST['asdf'])."',
		mb_sms='".addslashes($_POST['asdf'])."',
		mb_email_view='".addslashes($_POST['asdf'])."',
		mb_phone_view='".addslashes($_POST['asdf'])."',
		mb_hphone_view='".addslashes($_POST['asdf'])."',
		mb_address_view='".addslashes($_POST['asdf'])."',
		mb_homepage_view='".addslashes($_POST['asdf'])."',
		mb_employ_count='".addslashes($_POST['asdf'])."',
		mb_alba_count='".addslashes($_POST['asdf'])."',
		mb_resume_count='".addslashes($_POST['asdf'])."',
		mb_alba_resume_count='".addslashes($_POST['asdf'])."',
		mb_employ_scrap_count='".addslashes($_POST['asdf'])."',
		mb_alba_scrap_count='".addslashes($_POST['asdf'])."',
		mb_board_count='".addslashes($_POST['asdf'])."',
		mb_comment_count='".addslashes($_POST['asdf'])."',
		mb_badness='".addslashes($_POST['asdf'])."',
		mb_left_request='".addslashes($_POST['asdf'])."',
		mb_left='".addslashes($_POST['asdf'])."',
		mb_left_date='".addslashes($_POST['asdf'])."',
		is_admin='".addslashes($_POST['asdf'])."',
		is_adult='".addslashes($_POST['asdf'])."',
		input_type='".addslashes($_POST['asdf'])."'";
		*/

		// : 탈퇴관련
		/*
		mb_left_request_date='".addslashes($_POST['asdf'])."',
		is_delete='1',
		*/

		// : 로그인
		/*
		mb_last_login='".addslashes($_POST['asdf'])."',
		mb_login_ip='".addslashes($_POST['asdf'])."',
		*/

		// : 불량회원
		/*
		mb_memo='".addslashes($_POST['asdf'])."',
		*/

		$arr['move'] = $_SERVER['HTTP_REFERER'];

		$mb_id = $_POST['mb_id'] ? $_POST['mb_id'] : $member['mb_id'];
		$mb_type = $_POST['kind'] ? $_POST['kind'] : $member['mb_type'];
		$m_row = sql_fetch("select * from alice_member where mb_id='".addslashes($mb_id)."'");

		// : 회원수정
		if($m_row['mb_id']) {
			$mb_id_chk = sql_fetch("select * from alice_member where mb_password=md5('".addslashes($_POST['password_confirm'])."') and mb_id='".$m_row['mb_id']."'");
			$nick_row = sql_fetch("select * from alice_member where mb_nick='".addslashes($_POST['mb_nick'])."' and `mb_id`!='".$mb_id."'");

			if(!$mb_id_chk) $arr['msg'] = "비밀번호를 정확히 입력해주시기 바랍니다.";
			if(!$arr['msg'] && $nick_row) $arr['msg'] = "닉네임이 중복된 회원이 있습니다.";

		// : 회원가입
		} else {
			$m_row = sql_fetch("select * from alice_member where mb_id='".addslashes($_POST['mb_id'])."'");
			$nick_row = sql_fetch("select * from alice_member where mb_nick='".addslashes($_POST['mb_nick'])."'");
			if($m_row) $arr['msg'] = "아이디가 중복된 회원이 있습니다.";
			if($nick_row) $arr['msg'] = "닉네임이 중복된 회원이 있습니다.";
		}

		if(!$arr['msg']) {

			// : 사진등록
			$photo_key = $mb_type=='individual' ? 'photo' : 'logo';
			$dir = NFE_PATH.'/data/member/'.$mb_id.'/';
			$logo_dir = $dir.'logo/';
			$com_num_dir .= $dir.'photos/';
			if(!is_dir($dir)) {
				@mkdir($dir, 0707);
				@chmod($dir, 0707);
			}

			// : 기업회원가입시
			if($mb_type=='company' && !is_dir($logo_dir)) {
				@mkdir($logo_dir, 0707);
				@chmod($logo_dir, 0707);

			// : 개인회원가입시
			} else {
				$logo_dir = $dir;
			}

			if(!is_dir($com_num_dir)) {
				@mkdir($com_num_dir, 0707);
				@chmod($com_num_dir, 0707);
			}

			if($_FILES[$photo_key]['tmp_name']) {
				$ext = $netfu_util->get_ext($_FILES[$photo_key]['name']);
				$fname = 'member_'.time().'.'.$ext;
				$file_upload = $netfu_util->attach_save('member', $fname, $photo_key, $logo_dir, $mb_id, $mb_type); // 파일 업로드
			}

			if($_FILES['com_num_photo']['tmp_name']) {
				$photo_key = 'com_num_photo';
				$ext = $netfu_util->get_ext($_FILES[$photo_key]['name']);
				$fname = 'member_'.time().'.'.$ext;
				$com_num_upload = $netfu_util->attach_save('com_num', $fname, $photo_key, $com_num_dir, $mb_id, $mb_type); // 파일 업로드
			}

			$birth = $_POST['mb_birth_year'].'-'.$_POST['mb_birth_month'].'-'.$_POST['mb_birth_day'];
			$mb_homepage = ($_POST['mb_homepage']) ? $utility->add_http($_POST['mb_homepage']) : "";
			$mb_login_count = 1;


			// : $q - 회원테이블 [ 개인,기업 ]
			// : $c_q - 기업만 모여있는 테이블

			$q = "
			mb_nick='".addslashes($_POST['mb_nick'])."',
			mb_email='".@implode("@", $_POST['mb_email'])."',
			mb_phone='".@implode("-", $_POST['mb_phone'])."',
			mb_hphone='".@implode("-", $_POST['mb_hphone'])."',
			mb_receive='".@implode(",", $_POST['mb_receive'])."',
			mb_zipcode='".@implode("-", $_POST['mb_zipcode'])."',
			mb_doro_post='".addslashes($_POST['mb_doro_post'])."',
			mb_address0='".addslashes($_POST['mb_address0'])."',
			mb_address1='".addslashes($_POST['mb_address1'])."',
			mb_homepage='".addslashes($mb_homepage)."'
			";

			if($_SESSION['certify_info']['ci']) $q .= ", mb_ssn = '".$_SESSION['certify_info']['ci']."'";
			if($_SESSION['adult_view']) $q .= ", is_adult='1'";

			if($file_upload['upload_file'] && $mb_type=='individual') $q .= ", mb_photo='".addslashes($file_upload['upload_file'])."'";

			if($_POST['kind']) $q .= ", mb_type='".addslashes($_POST['kind'])."'";

			switch($mb_type) {
				case "individual":
					if(!$m_row['mb_id']) {
					$q .= "
						,mb_birth='".addslashes($birth)."'
						,mb_gender='".addslashes($_POST['mb_gender'])."'
						";
					}
					break;

				default:
					$q .= "
					,mb_birth='".addslashes($birth)."'
					,mb_gender='".addslashes($_POST['mb_gender'])."'
					";

					$c_q = "
					mb_ceo_name='".addslashes($_POST['mb_ceo_name'])."',
					mb_company_name='".addslashes($_POST['mb_company_name'])."',
					mb_biz_type='".addslashes($_POST['mb_biz_type'])."',
					mb_biz_no='".@implode("-", $_POST['mb_biz_no'])."',
					mb_biz_phone='".@implode("-", $_POST['mb_phone'])."',
					mb_biz_hphone='".implode("-", $_POST['mb_hphone'])."',
					mb_biz_doro_post='".addslashes($_POST['mb_doro_post'])."',
					mb_biz_zipcode='".@implode("-", $_POST['mb_zipcode'])."',
					mb_biz_address0='".addslashes($_POST['mb_address0'])."',
					mb_biz_address1='".addslashes($_POST['mb_address1'])."',
					mb_biz_email='".@implode("@", $_POST['mb_email'])."',
					mb_biz_fax='".@implode("-", $_POST['mb_biz_fax'])."',
					mb_biz_success='".addslashes($_POST['mb_biz_success'])."',
					mb_biz_form='".addslashes($_POST['mb_biz_form'])."',
					mb_biz_content='".addslashes($_POST['mb_biz_content'])."',
					mb_biz_foundation='".addslashes($_POST['mb_biz_foundation'])."',
					mb_biz_member_count='".addslashes($_POST['mb_biz_member_count'])."',
					mb_biz_stock='".addslashes($_POST['mb_biz_stock'])."',
					mb_biz_sale='".addslashes($_POST['mb_biz_sale'])."',
					mb_biz_vision='".addslashes($_POST['mb_biz_vision'])."',
					mb_biz_result='".addslashes($_POST['mb_biz_result'])."',
					mb_logo_sel=0,
					mb_homepage='".addslashes($_POST['mb_homepage'])."',
					mb_latlng='".addslashes(@implode(",", $_POST['map_latlng']))."'
					";

					if($file_upload['upload_file']) $c_q .= ", mb_logo='".addslashes($file_upload['upload_file'])."'";
					if($com_num_upload['upload_file']) $c_q .= ", mb_com_num_photo='".addslashes($com_num_upload['upload_file'])."'";
					break;
			}

			// : 가입할때만 사용합니다.
			if(!$m_row) {
				$q .= "
					, mb_level='".addslashes($env['register_level'])."'
					, mb_password='".md5($_POST['mb_password'])."'
					, mb_id='".addslashes($_POST['mb_id'])."'
					, mb_name='".addslashes($_POST['mb_name'])."'
					, mb_login_count='".addslashes($mb_login_count)."'
					, mb_address_road='".addslashes($_POST['mb_doro_post'])."'
					, mb_wdate=now()
				";

				$c_q .= "
					, is_public='1'
					, mb_id='".addslashes($_POST['mb_id'])."'
					,mb_address_road='".addslashes($_POST['mb_doro_post'])."'
				";
			} else {
				$q .= "
					,mb_udate=now()
				";
			}

			// : 회원 가입,수정
			if($m_row) $q_all = "update alice_member set $q where `mb_id`='".$m_row['mb_id']."'";
			else $q_all = "insert into alice_member set $q";
			
			$query = sql_query($q_all);

			// : 기업정보
			if($mb_type=='company') {
				if($m_row['mb_id']) $q_all = "update alice_member_company set $c_q where `mb_id`='".$m_row['mb_id']."' and is_public='1'";
				else $q_all = "insert into alice_member_company set $c_q";
				$query = sql_query($q_all);
			}

			$get_member = $member_control->get_member($mb_id);
			$mb_receive = explode(",",$get_member['mb_receive']);	// 수신여부
			if(!$m_row['mb_id']) {
				$service_result = $user_control->user_service_regist( array('mb_id' => $mb_id) );

				$mb_email = $get_member['mb_email'];

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

				// : 로그인
				$user_control->user_session( $mb_id, $mb_type );
			} else {
				$sms_control->send_sms_user('member_update', $get_member, "", "", $mb_receive);
			}

			
			if($m_row['mb_id']) $arr['msg'] = "회원수정이 완료되었습니다.";
			else $arr['msg'] = "회원가입이 완료되었습니다.";

			if($mb_type=='individual') $arr['move'] = NFE_URL.'/mypage/resume_list.php';
			else $arr['move'] = NFE_URL.'/mypage/employ_list.php';

		}

		$netfu_util->page_move($arr['msg'], $arr['move']);
		exit;
		break;


	case "dupl_mid":
		$q = "select * from alice_member where `mb_id`='".addslashes($_POST['val'])."'";
		$row = sql_fetch($q);
		$_allow = false;
		if(!$_POST['val']) {
			$arr['txt'] = "아이디를 입력해주시기 바랍니다.";
		} else if($row) {
			$arr['txt'] = "중복된 회원이 존재합니다.";
		} else {
			$arr['txt'] = "사용할 수 있는 아이디입니다.";
			$_allow = true;
		}
		if(!$_allow) {
			$arr['js'] = '$("#member_id").val("");$("#member_check").val("");';
		} else {
			$arr['js'] = '$("#member_check").val(1);';
		}
		$arr['q'] = $q;
		die(json_encode($arr));
		exit;
		break;


	case "dupl_nick":
		$q = "select * from alice_member where `mb_nick`='".addslashes($_POST['val'])."'";
		$row = sql_fetch($q);
		$_allow = false;
		if(!$_POST['val']) {
			$arr['txt'] = "닉네임을 입력해주시기 바랍니다.";
		} else if($row) {
			$arr['txt'] = "중복된 닉네임이 존재합니다.";
		} else {
			$arr['txt'] = "사용할 수 있는 닉네임입니다.";
			$_allow = true;
		}
		if(!$_allow) {
			$arr['js'] = '$("#nickname").val("");$("#nick_check").val("");';
		} else {
			$arr['js'] = '$("#nick_check").val(1);';
		}
		$arr['q'] = $q;
		die(json_encode($arr));
		exit;
		break;


// : 카테고리값 가져오기
	case "get_cate_array":
		$arr['where'] = " and `p_code`='".$_POST['no']."'";
		$arr['len'] = 0;
		$arr['cate'] = $netfu_util->get_cate_array($_POST['type'], $arr);
		if($arr['cate']) $arr['len'] = count($arr['cate']);
		$q = "select * from alice_category where `type` = '".$_POST['type']."' and `view`='yes' ".$arr['where']." order by `rank` asc";
		$arr['q'] = $q;
		die(json_encode($arr));
		break;


// : 고객센터 등록
	case "cs_center_write":
		$q = "
		wr_id='".addslashes($member['mb_id'])."',
		wr_cate='".addslashes($_POST['wr_cate'])."',
		wr_name='".addslashes($_POST['wr_name'])."',
		wr_email='".@implode("@", $_POST['wr_email'])."',
		wr_phone='".@implode("-", $_POST['wr_phone'])."',
		wr_hphone='".@implode("-", $_POST['wr_hphone'])."',
		wr_site='".addslashes($_POST['wr_site'])."',
		wr_subject='".addslashes($_POST['wr_subject'])."',
		wr_content='".addslashes($_POST['wr_content'])."',
		wr_date='".$netfu_util->today_time."',
		wr_ip='".$_SERVER['REMOTE_ADDR']."'
		";
		$query = sql_query("insert into alice_cs set $q");
		$arr['msg'] = "등록이 완료되었습니다.";
		$arr['move'] = NFE_URL."/";
		die(json_encode($arr));
		break;




	case 'qna_insert':		## 고객센터 문의
	case 'advert_insert':	## 광고 문의
	case 'concert_insert':	## 제휴 문의

		/* captcha 확인 */
		if (!$is_member || $is_guest) {	// 비회원 일때
			$key = $_SESSION['rand_nums'];
			if (!($key && $key == $_POST['wr_key'])) {
				//session_unregister("captcha_keystring");
				$arr['msg'] = '자동등록방지 글을 정확히 입력해 주세요.';
				die(json_encode($arr));
			}
		}
		/* //captcha 확인 */

		if (substr_count($_POST['wr_content'], "&#") > 50) {
			$arr['msg'] = '내용에 올바르지 않은 코드가 다수 포함되어 있습니다.';
			die(json_encode($arr));
		}

		$vals['wr_type'] = $_POST['wr_type'];
		$vals['wr_cate'] = $_POST['wr_cate'];
		$vals['wr_id'] = $member['mb_id'];

		if(!$wr_name || $wr_name==''){
			$arr['msg'] = '이름을 입력해 주세요.';
			die(json_encode($arr));
		} else {
			$vals['wr_name'] = $wr_name;
		}

		$vals['wr_biz'] = $_POST['wr_biz'];	// 주요사업
		$vals['wr_biz_name'] = $_POST['wr_biz_name'];	// 업체명
		$vals['wr_biz_type'] = $_POST['wr_biz_type'];	// 제휴부분

		if(!$wr_email || $wr_email==''){
			$arr['msg'] = '이메일 주소를 입력해 주세요.';
			die(json_encode($arr));
			exit;
		} else {
			$vals['wr_email'] = @implode($wr_email,'@');
		}

		for($i=0;$i<$wr_hphone_cnt;$i++){
			if($wr_hphone[$i]==''){
				$arr['msg'] = '휴대폰 번호를 입력해 주세요.';
			}
		}

		if(!$arr['msg']) {

			$vals['wr_phone'] = @implode($_POST['wr_phone'],'-');
			$vals['wr_hphone'] = @implode($_POST['wr_hphone'],'-');

			$vals['wr_site'] = ($_POST['wr_site']) ? $utility->add_http($_POST['wr_site']) : "";

			if($mode=='concert_insert'){	// 제휴/광고문의
				if(!$wr_biz_name){
					$arr['msg'] = '업체명을 입력해 주세요.';
					die(json_encode($arr));
				} else {
					$vals['wr_biz_name'] = $_POST['wr_biz_name'];
				}
			}

			if (!isset($_POST['wr_subject']) || !trim($_POST['wr_subject'])) {
				$arr['msg'] = '제목을 입력해 주세요.';
				die(json_encode($arr));
			} else {
				$vals['wr_subject'] = $_POST['wr_subject'];
			}

			if (!isset($_POST['wr_content']) || !trim($_POST['wr_content'])) {
				$arr['msg'] = '내용을 입력해 주세요.';
				die(json_encode($arr));
			} else {
				$vals['wr_content'] = $_POST['wr_content'];
			}

			$vals['wr_date'] = $now_date;

			$result['result'] = $cs_control->insert_cs($vals);
			$arr['msg'] = "등록이 완료되었습니다.";
			$arr['move'] = NFE_URL.'/';
		}
		die(json_encode($arr));

	break;

// : 지도검색
	case "map_job_list":
		$_data = $_POST;
		$_data['lat_field'] = 'SUBSTRING_INDEX(wr_area_point, ",", 1)';
		$_data['lng_field'] = 'SUBSTRING_INDEX(wr_area_point, ",", -1)';
		$_field = $netfu_util->distance_q($_data);
		$_total = 10;
		$_box_num = $_total;

		$service_check = $service_control->service_check('main_basic');
		if($service_check['is_pay'] == 1) {
			$con = " and ( `wr_service_platinum` >= curdate() or `wr_service_grand` >= curdate() or `wr_service_special` >= curdate() or `wr_service_basic` >= curdate() ) ";
		}
		$_keyword = addslashes($_POST['keyword']);
		$_search[] = "`wr_company_name` like '%".$_keyword."%'";
		$_search[] = "`wr_subject` like '%".$_keyword."%'";
		$_search[] = "`wr_area` like '%".$_keyword."%'";
		if($_keyword) $con .= " and (".@implode(" or ", $_search).")";
		$q = "alice_alba where ".$netfu_mjob->job_where.$con." and replace(wr_area_point,',','')!=''";
		$start = $netfu_util->_paging_start($_POST['page'], $_total);
		$q_all = "select *, $_field from ".$q." order by map_distance asc limit ".$start.", ".$_total;
		$query = sql_query($q_all);
		$total = sql_fetch("select count(*) as c from ".$q);
		$list_num = mysql_num_rows($query);
		$_total = $netfu_util->get_remain($list_num, $_box_num);

		$_path = parse_url($_SERVER['HTTP_REFERER']);

		$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$total['c'], 'path'=>$_path['path'], 'page'=>$_POST['page']));
		$paging_group = ceil($total['c']/($_box_num));

		$arr['latlng'] = array();
		ob_start();
		switch($total['c']<=0) {
			case true:
				?>
				<li>
					<div class="text_box2">
						<div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">등록된 내용이 없습니다.</div>
					</div>
				</li>
				<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
					$lo_arr = explode(",", $row['wr_area_point']);
					$arr['latlng'][] = array('lat'=>$lo_arr[0], 'lng'=>$lo_arr[1]);

					$map_distance = ' ('.sprintf("%0.2f", $row['map_distance']).'km)';
				?>
				<li style="width:100%;">
				<?php
					include "./include/inc/job_box4.inc.php";
				?>
				</li>
				<?php
				}
				break;
		}
		$get_tag = ob_get_clean();
		
		$arr['q'] = $q_all;
		$arr['tag'] = $get_tag;
		$arr['paging'] = $paging;
		$arr['total'] = $list_num;
		die(json_encode($arr));
		break;


// : 현금영수증 발행신청
	case "tax_write":
		$arr['msg'] = '로그인하셔야 이용가능합니다.';
		$arr['move'] = NFE_URL.'/include/login.php';

		if($member['mb_id']) {
			$vals['wr_type'] = $_POST['wr_type'];		// 세금계산서/현금영수증 구분
			$vals['wr_id'] = $member['mb_id'];
			$vals['wr_name'] = $_POST['wr_name'];
			$vals['wr_biz_no'] = @implode('-', $_POST['wr_biz_no']);
			$vals['wr_company_name'] = $_POST['wr_company_name'];
			$vals['wr_ceo_name'] = $_POST['wr_ceo_name'];
			$vals['wr_doro'] = $_POST['wr_doro'];
			$vals['wr_address0'] = $_POST['wr_address0'];
			$vals['wr_address1'] = $_POST['wr_address1'];
			$vals['wr_condition'] = $_POST['wr_condition'];
			$vals['wr_item'] = $_POST['wr_item'];
			$vals['wr_email'] = @implode('@', $_POST['wr_email']);
			$vals['wr_manager'] = $_POST['wr_manager'];
			$vals['wr_phone'] = @implode('-', $_POST['wr_phone']);
			if($_POST['wr_hphone'][0]) $vals['wr_hphone'] = @implode('-', $_POST['wr_hphone']);
			$vals['wr_pay_date'] = $_POST['wr_pay_date'];
			$vals['wr_price'] = $_POST['wr_price'];
			$vals['wr_content'] = $_POST['wr_content'];

			$vals['wdate'] = $now_date;
			$val = $utility->QueryString($vals);
			$q = " insert alice_tax set " . $val;
			sql_query($q);

			$arr['msg'] = "신청이 완료되었습니다.";
			$arr['move'] = $_SERVER['HTTP_REFERER'];
		}
		die(json_encode($arr));
		break;


################ // : 게시판

	// : 게시판 댓글 수정하기
	case "board_reply_password":
		$q = " select * from `".$write_table."` where `wr_no` = '".$_POST['comment_id']."' ";
		$row = sql_fetch($q);
		if($member['mb_id']!=$row['wr_id']) {
			$arr['modify'] = 'netfu_board.reply_password(el);';
		} else {
			$arr['modify'] = 'netfu_board.reply_reply(el, \'\', \''.$_POST['comment_id'].'\');';
		}
		die(json_encode($arr));
		break;


	// : 게시판 댓글작성
	case "board_reply_write":
		$arr['msg'] = "";
		$arr['move'] = "";

		/* captcha 확인 */
		if (!$is_member || $is_guest) {	// 비회원 일때
			$key = $_SESSION['rand_nums'];
			if (!($key && $key == $_POST['wr_key'])) {
				//session_unregister("captcha_keystring");
				$arr['msg'] = '자동등록방지 글을 정확히 입력해 주세요.';
				die(json_encode($arr));
			}
		}
		/* //captcha 확인 */

		// 코멘트 답변
		if ($_POST['comment_id']>0) {
			$_POST['wr_name'] = $_POST['reply_name'][$_POST['text_key']];
			$_POST['wr_password'] = md5($_POST['reply_password'][$_POST['text_key']]);
			$_POST['wr_content'] = $_POST['reply_content'][$_POST['text_key']];

			if($_POST['reply_mode']!='modify') {

				$query = " select wr_no, wr_comment, wr_comment_reply from `".$write_table."` where `wr_no` = '".$_POST['comment_id']."' ";
				$reply_array = $db->query_fetch($query);
				if (!$reply_array['wr_no']){
					$arr['msg'] = $board_control->_errors('0055');// 답변할 코멘트가 없습니다.\\n\\n답변하는 동안 코멘트가 삭제되었을 수 있습니다.
				}

				$tmp_comment = $reply_array['wr_comment'];

				if (strlen($reply_array['wr_comment_reply']) == 5) {
					$arr['msg'] = $board_control->_errors('0056'); // 더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.
				}

				if(!$arr['msg']) {
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
						$arr['msg'] = $board_control->_errors('0013'); // 더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.
					} else {
						$reply_char = chr(ord($row['reply']) + $reply_number);
					}

					$tmp_comment_reply = $reply_array['wr_comment_reply'] . $reply_char;
				}
			}

		} else  {

			$query = " select max(wr_comment) as max_comment from `".$write_table."` where `wr_parent` = '".$wr_no."' and `wr_is_comment` = 1 ";
			$row = $db->query_fetch($query);
			$row['max_comment'] += 1;
			$tmp_comment = $row['max_comment'];
			$tmp_comment_reply = "";

		}

		if(!$arr['msg']) {
			$_table = 'alice_write_'.addslashes($_POST['bo_table']);
			$bo_row = sql_fetch("select * from ".$_table." where `wr_no`='".addslashes($_POST['wr_no'])."'");

			// : 댓글수정
			if($_POST['reply_mode']=='modify') {
				$q = "
				`wr_content` = '".addslashes($_POST['wr_content'])."',
				`wr_ip` = '".$_SERVER['REMOTE_ADDR']."'
				";
			// : 댓글등록
			} else {
				$q = "
					`wr_category` = '".$wr['wr_category']."',
					`wr_secret` = '".$wr_secret."' ,
					`wr_num` = '".$wr['wr_num']."',
					`wr_reply` = '',
					`wr_parent` = '".addslashes($wr_no)."',
					`wr_is_comment` = '1',
					`wr_comment` = '".$tmp_comment."',
					`wr_comment_reply` = '".$tmp_comment_reply."',
					`wr_subject` = '".addslashes($wr_subject)."' ,
					`wr_content` = '".addslashes($_POST['wr_content'])."',
					`wr_email` = '".$wr_email."',
					`wr_homepage` = '".$wr_homepage."',
					`wr_datetime` = '".$alice['time_ymdhis']."',
					`wr_last` = '',
					`wr_ip` = '".$_SERVER['REMOTE_ADDR']."',
					`wr_0` = '".addslashes($_POST['wr_0'])."' ,
					`wr_1` = '".addslashes($_POST['wr_1'])."' ,
					`wr_2` = '".addslashes($_POST['wr_2'])."' ,
					`wr_3` = '".addslashes($_POST['wr_3'])."' ,
					`wr_4` = '".addslashes($_POST['wr_4'])."' ,
					`wr_5` = '".addslashes($_POST['wr_5'])."' ,
					`wr_6` = '".addslashes($_POST['wr_6'])."' ,
					`wr_7` = '".addslashes($_POST['wr_7'])."' ,
					`wr_8` = '".addslashes($_POST['wr_8'])."' ,
					`wr_9` = '".addslashes($_POST['wr_9'])."'
				";
			}

			if(!$member['mb_id']) {
				$q .= "
				,`wr_name` = '".$_POST['wr_name']."'
				,`wr_password` = '".md5($_POST['wr_password'])."'
				";
			} else {
				$q .= "
				, `wr_id` = '".$member['mb_id']."'
				,`wr_name` = '".$member['mb_name']."'
				";
			}


			// : 댓글수정
			if($_POST['comment_id']>0 && $_POST['reply_mode']=='modify') {
				sql_query("update ".$_table." set ".$q." where `wr_no`='".addslashes($_POST['comment_id'])."'");
				$arr['msg'] = "댓글 수정이 완료되었습니다.";
			// : 댓글등록
			} else {
				sql_query("insert into ".$_table." set ".$q);
				$insert_id = $db->last_id();
				$comment_id = $insert_id;

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
					$arr['msg'] = "댓글 등록이 완료되었습니다.";
					//$arr['move'] = "./detail.php?board_code=".$board_code."&code=".$code."&bo_table=".$bo_table."&wr_no=".$wr_no;//."#c_".$comment_id;
				} else {
					// 코멘트 작성중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.
					$arr['msg'] = $board_control->_errors('0057');
				}
			}
		}

		ob_start();
		include NFE_PATH.'/board/reply_list.inc.php';
		$arr['list_tag'] = ob_get_clean();
		$arr['reply_total'] = $total_num;
		$arr['reply_rand_text'] = '<img src="'.NFE_URL.'/include/rand_text.php" />';
		$arr['hash'] = 'c_'.$insert_id;

		$arr['js'] = '$("input[type=text]").val("");$("input[type=password]").val("");$("textarea").val("");$(".reply_total").html(data.reply_total);$(".reply_rand_text").html(data.reply_rand_text);$(".reply_con").html(data.list_tag);self.location.hash=data.hash;';

		die(json_encode($arr));
		break;


	// : 가격 가져오기
	case "get_money":
		include_once './engine/netfu_payment.class.php';
		$netfu_payment = new netfu_payment();

		$row = sql_fetch("select * from `alice_service` where `no`='".addslashes($_POST['no'])."'");
		if(!$row && strpos($_SERVER['HTTP_REFERER'], "job_order.php")===false) {
			$arr['msg'] = "가격을 선택해주시기 바랍니다.";
		} else {

			$_sale = $row['service_price']-($row['service_price']*($row['service_percent']/100));

			if($row['etc_3']) {
				$_txt = $row['etc_3'].'건';
			} else {
				$_txt = '오늘+'.str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, number_format($row['service_cnt']).$row['service_unit']);
			}

			$arr = $row;
			$arr['service_txt'] = $_txt;
			$arr['sale_price'] = $_sale;
			$arr['sale_price_txt'] = number_format($_sale).'원';
			$arr['ori_price_txt'] = number_format($row['service_price']).'원';

			// : 장바구니 페이지에서만 실행합니다.
			if(strpos($_SERVER['HTTP_REFERER'], 'payment/job_order.php')!==false) {

				$_val_arr = explode("/", $_POST['val']);
				// : 가격값
				$price_row = $netfu_payment->get_price($_val_arr[0], $_val_arr[1]);
				if(!$row['etc_3']) $_date_txt = '오늘 + ';
				
				if($price_row['type']) $arr['put_tag'] = '._'.$price_row['type'];
				else $arr['put_tag'] = '._'.($_POST['chk_se']=='on' ? $_POST['put_tag'] : $_POST['chk_se']);

				if($price_row['etc_3']) $_date_txt = $price_row['etc_3'].'건';
				else $_date_txt .= $price_row['_date'];

				ob_start();
				include NFE_PATH.'/payment/inc/payment_tag.inc.php';
				$tag = ob_get_clean();

				$arr['tag'] = $_POST['val'] ? $tag : '';

				// : 가격 장바구니에서 골드나 로고 선택시 가격 태그 아래에 붙이기.
				if($_POST['part_code']) {

					if($_POST['val'])
						$arr['js'] = '$(data.put_tag).removeClass("_none")';
					else
						$arr['js'] = '$(data.put_tag).addClass("_none")';

					$arr['txt'] = $price_row['_subject'];

				// : 
				} else {
					$arr['js'] = '$(data.put_tag).html(data.tag)';
				}

				$_price = $netfu_payment->all_service_price();
				$arr['price_hap'] = $_price;
				$arr['price_hap_txt'] = number_format($_price).'원';
				$arr['price_result_txt'] = number_format($_price-$_POST['use_point']).'원';
			}
		}
		if($_POST['mode']!='include_get_money') die(json_encode($arr));
		break;



	// : 결제시작
	case "payment_start":
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}

		if(!$arr['msg']) {
			include_once './engine/netfu_payment.class.php';
			$netfu_payment = new netfu_payment();
			$pno = $netfu_payment->payment_save();
			$get_price = $netfu_payment->get_service_type($_POST);
			$get_pg = $payment_control->get_use_pg(1);
			$arr['price'] = $get_price['use_price_hap'];

			if($arr['price']>0 && !$_POST['pay_method']) {
				$arr['msg'] = "결제방법을 선택해주시기 바랍니다.";
			} else {
				// : 무료인경우
				if($arr['price']<=0) {
					$pay_row = sql_fetch("select * from alice_payment where `no`='".$pno."' and `pay_price`<=0");
					if($pay_row) {
						$_POST['no'] = $pno;
						$_POST['status'] = 1;
						$mu_process = true;
						$msg = $payment_control->payment_status(1, $pay_row['pay_oid']);
						if(!$msg) $arr['msg'] = "이미 무료로 적용중이므로 업데이트할 수가 없습니다.";
						else {
							$arr['move'] = NFE_URL."/payment/result.php?no=".$pno;
						}
					} else {
						$arr['msg'] = "정상적인 방식으로 결제해주시기 바랍니다.";
					}
					die(json_encode($arr));
				} else {
					switch($netfu_payment->use_pg['pg_company']) {
						case "inicis":
							if((double)$_ver<=5.2) {
								require_once(NFE_PATH.'/plugin/PG/inicis/5.0.0/libs/INIStdPayUtil.php');
								require_once(NFE_PATH.'/plugin/PG/inicis/5.0.0/libs/sha256.inc.php');
								$SignatureUtil = new INIStdPayUtil();
							} else {
								require_once(NFE_PATH.'/plugin/PG/inicis/libs/INIStdPayUtil.php');
								$SignatureUtil = new INIStdPayUtil();
							}
							
							$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성
							$params = array(
								"oid" => $_SESSION['__pay_order__'],
								"price" => $arr['price'],
								"timestamp" => $timestamp
							);
							$sign = $SignatureUtil->makeSignature($params);
							$arr['sign'] = $sign;
							$arr['timestamp'] = $timestamp;
							break;

						case "allthegate":
							$arr['hash'] = md5($netfu_payment->use_pg['pg_id'] . $_SESSION['__pay_order__'] . $arr['price']);
							break;

						case "nicepay":
							$arr['EdiDate'] = date("YmdHis");
							$arr['hash'] = bin2hex(hash('sha256', $arr['EdiDate'].$netfu_payment->use_pg['pg_id'].$arr['price'].$netfu_payment->use_pg['pg_key'], true));
							break;
					}

					$__service_name = $netfu_payment->payment_service_name[$_POST['mode']];
					if($_POST['mode']=='open_payment') $head_txt = ($_POST['pay_type']=='alba') ? '채용정보 ' : '이력서 ';
					$__service_name = $head_txt.$__service_name;

					$_var = $netfu_payment->use_pg['pg_company'].'_method_arr';
					if($netfu_util->mobile_is && in_array($netfu_payment->use_pg['pg_company'], array('kcp', 'inicis', 'allthegate'))) $_var .= '_m';
					$_method = $netfu_payment->$_var;
					$arr['method'] = $_method[$_POST['pay_method']];
					$arr['html_put'] = '';
					$arr['move'] = "";
					$arr['pno'] = $pno;
					$arr['service_name'] = $__service_name;
					$arr['SubjectData'] = $arr['price'].';'.$arr['service_name'].';';
					$arr['oid'] = $_SESSION['__pay_order__'];

					if($_POST['pay_method']=='bank') {
						$bank_row = sql_fetch("select * from `alice_bank` where `no`='".addslashes($_POST['bank'])."'");
						$_POST['pay_bank'] = $bank_row['bank_name'].'/'.$bank_row['bank_num'].'/'.$bank_row['name'];;
						$_POST['pay_bank_name'] = $_POST['bank_name'];
						$sms_control->send_sms_user('pay_online_request', $member, "", $_POST);
						$arr['move'] = NFE_URL."/payment/result.php?no=".$pno;
					}
				}
			}
		}
		die(json_encode($arr));
		exit;
		break;



	case "payment_process":
		include_once './engine/netfu_payment.class.php';
		$netfu_payment = new netfu_payment();

		$_pay_result = false;
		switch($netfu_payment->use_pg['pg_company']) {
			case "kcp":
				$pno = $_POST['param_opt_2'];
				include NFE_PATH.'/plugin/PG/kcp/sample/pp_cli_hub.php';
				break;

			case "inicis":
				$pno = $_POST['no'];
				if($netfu_util->mobile_is) {
					$pno = $_POST['no'];
					if($_POST['P_STATUS']!='00') {
						$arr['msg'] = iconv("CP949", "UTF-8", $_POST['P_RMESG1']);
					} else {
						include NFE_PATH.'/plugin/PG/inicis/mobile/mx_rnoti.php';
					}
				} else {
					if((double)$_ver<=5.2) {
						require_once(NFE_PATH.'/plugin/PG/inicis/5.0.0/libs/INIStdPayUtil.php');
						require_once(NFE_PATH.'/plugin/PG/inicis/5.0.0/libs/HttpClient.php');
					} else {
						require_once(NFE_PATH.'/plugin/PG/inicis/libs/INIStdPayUtil.php');
						require_once(NFE_PATH.'/plugin/PG/inicis/5.0.0/libs/HttpClient.php');
					}
					$util = new INIStdPayUtil();

					if($_POST['resultCode']!='0000') {
						$arr['msg'] = $_POST['resultMsg'];
					} else {
						include_once NFE_PATH.'/plugin/PG/inicis/INIStdPaySample/INIStdPayReturn.php';
					}
				}
				break;

			case "allthegate":
				$pno = $_POST['no'];
				include NFE_PATH.'/plugin/PG/allthegate/source/AGS_pay_ing.php';
				break;

			case "nicepay":
				$pno = $_POST['no'];
				if($netfu_util->mobile_is) include NFE_PATH.'/plugin/PG/nicepay/mobile/payResult.php';
				else include NFE_PATH.'/plugin/PG/nicepay/pc/payResult.php';
				break;
		}

		// : 결제완료
		if($_pay_result) {
		?>
		<script type="text/javascript">
		location.href = "<?=NFE_URL;?>/payment/result.php?no=<?=$pno;?>";
		</script>
		<?php

		// : 결제실패
		} else {
			if(!$arr['msg']) $arr['msg'] = "결제가 실패되었습니다.";
		?>
		<script type="text/javascript">
		alert("<?=$arr['msg'];?>");
		location.replace("<?=NFE_URL;?>/");
		</script>
		<?php
		}
		exit;
		break;






























	// : 로고등록
	case "logo_write":
		// : 관리자, 회원이 아닌경우에는 사용을 못하게
		if(!$member['mb_id'] && !$_SESSION['sess_admin_uid']) {
			$utility->popup_msg_ajax("로그인을 하셔야 이용이 가능합니다.");
			exit;
		}
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

				// : 채용정보의 etc_0값을 없애기
				if($_POST['job_no'] && $result) {
					$alba_data = sql_fetch("select * from alice_alba where `no`='".addslashes($_POST['job_no'])."'");
					if($alba_data['etc_0']) {
						@unlink(NFE_PATH."/data/alba/".$alba_data['etc_0']);
						$update = sql_query("update alice_alba set `etc_0`='' where `no`='".addslashes($_POST['job_no'])."'");
					}
				}
			}

			if($result){
				echo NFE_URL."/data/member/".$mb_id."/logo/".$upload_file;
			} else {
				$utility->popup_msg_ajax($user_control->_errors('0037'));
				exit;
			}

		} else {
			$utility->popup_msg_ajax($user_control->_errors('0038'));
			exit;
		}
		exit;
		break;


	## 회사 로고 삭제
	case 'logo_delete':

		// : 관리자, 회원이 아닌경우에는 사용을 못하게
		if(!$member['mb_id'] && !$_SESSION['sess_admin_uid']) {
			$arr['msg'] = "로그인을 하셔야 이용이 가능합니다.";
		}

		if(!$arr['msg']) {
			$mb_id = $member['mb_id'];

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
				$arr['photo'] = NFE_URL."/images/basic/bg_noLogo.gif";
				$arr['msg'] = "삭제가 완료되었습니다.";
			} else {
				$arr['msg'] = $user_control->_errors('0037');
			}
		}
		die(json_encode($arr));
	break;

	// : 사진삭제
	case 'photo_delete':
		$mb_id = $member['mb_id'];
		$arr = $netfu_member->login_check2($member['mb_id']);
		if(!$arr['msg']) {
			$get_member = $member_control->get_member($mb_id);

			$vals['mb_udate'] = $now_date;	// 수정일

			// 프로필 사진 저장 디렉토리
			$photo_path = $alice['data_member_abs_path'] . '/' . $mb_id;

			@unlink($photo_path . "/". $get_member['mb_photo']);	 // 기존 파일 삭제

			$vals['mb_photo'] = "";

			// update
			$result = $user_control->user_update($vals,$mb_id);

			if($result){
				$arr['msg'] = "사진 삭제가 완료되었습니다.";
				$arr['photo'] = NFE_URL."/images/id_pic.png";
				$arr['js'] = '$(".picture_box").find("img").attr({"src":data.photo});';
			} else {
				$arr['msg'] = $user_control->_errors('0033');
				exit;
			}
		}
		die(json_encode($arr));
		break;



## 프로필 사진 업로드
	case 'profile_photo_upload':
		$mb_id = $member['mb_id'];

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

			if($result) {
				$arr['msg'] = "사진등록이 완료되었습니다.";
				$arr['photo'] = "../data/member/".$mb_id."/".$upload_file;
				$arr['js'] = '$(".picture_box").find("img").attr({"src":data.photo});setTimeout(function(){netfu_util1.photo_write_view(".pic_change_div");},300);';
			} else {
				$arr['msg'] = $user_control->_errors('0033');
			}
			die(json_encode($arr));
		}

		break;


	case "get_sms_phone":
		switch($_POST['code']) {
			case "job":
				$row = sql_fetch("select * from alice_alba where `no`='".addslashes($_POST['no'])."'");
				$read_kind = 'individual'; // : 읽을수 있는 회원
				break;

			case "resume":
				$row = sql_fetch("select * from alice_alba_resume where `no`='".addslashes($_POST['no'])."'");
				$read_kind = 'company'; // : 읽을수 있는 회원
				break;
		}
		$service_check = $service_control->service_check('etc_open');
		$get_member = $user_control->get_member($row['wr_id']);	 // 등록 회원 정보
		$read_info = $netfu_member->get_read_info($row, $get_member);

		if($_POST['code']=='job') {
			//$_hphone = $get_member['mb_hphone'];
			//$_phone = $get_member['mb_phone'];
			$_hphone = $row['wr_hphone'];
			$_phone = $row['wr_phone'];
		} else {
			//if($read_info['hphone_read']) $_hphone = $get_member['mb_hphone'];
			//if($read_info['phone_read']) $_phone = $get_member['mb_phone'];
			if($read_info['hphone_read']) $_hphone = $row['wr_hphone'];
			if($read_info['phone_read']) $_phone = $row['wr_phone'];
		}
		$phone_txt = $_hphone ? $_hphone : $_phone;

		$member_kind_txt = $netfu_member->member_kind[$read_kind];

		$service_check = $service_control->service_check('etc_alba');
		$open_is_pay = $service_check['is_pay'];

		if($_POST['code'] == 'job' && !$open_is_pay) {

			$arr['tel'] = 'location.href="tel:'.$phone_txt.'"';
			$arr['sms'] = 'location.href="sms:'.$phone_txt.'"';

		}else{

			if($member['mb_type']!=$read_kind) $arr['msg'] = $member_kind_txt.'만 이용가능합니다.';
			else if(!$member['mb_id']) {
				$arr['msg'] = '로그인하셔야 이용가능합니다.';
				$arr['move'] = NFE_URL.'/include/login.php';
			} else if($member_service['mb_service_alba_open']<$now_date) {
				$_txt = $_POST['code']=='resume' ? '이력서' : '구인공고';
				$arr['msg'] = $_txt." 열람권을 결제하셔야 이용가능힙니다.";
				$arr['move'] = NFE_URL.'/payment/read_payment.php';
			} else if(!$phone_txt) {
				$arr['msg'] = "연락처를 공개하지 않았습니다.";
			} else {
				if(!$arr['msg']) {
					$arr['tel'] = 'location.href="tel:'.$phone_txt.'"';
					$arr['sms'] = 'location.href="sms:'.$phone_txt.'"';
				}
			}

		}
		die(json_encode($arr));
		break;




// : 점프하기
case "service_jump":
	$arr = $netfu_member->login_check2($member['mb_id']);
	if(!$arr['msg']) {
		$_field = 'mb_'.addslashes($_POST['code']).'_jump_count';
		$_table = $member['mb_type']=='individual' ? 'alice_alba_resume' : ' alice_alba';
		if($member_service[$_field]<=0) {
			$arr['msg'] = "점프할 수 있는 건수가 없습니다. 충전해주시기 바랍니다.";
			$arr['move'] = NFE_URL.'/payment/jump_payment.php';
		} else {
			$max = sql_fetch("select * from ".$_table." order by `wr_jdate` desc limit 1");
			$row = sql_fetch("select * from ".$_table." where `no`='".addslashes($_POST['no'])."'");
			if($max['no']==$row['no']) {
				$arr['msg'] = "현재 최상단으로 올려진 상태입니다.";
			} else if($row) {
				sql_query("update ".$_table." set `wr_jdate`='".date("Y-m-d H:i:s")."' where `no`='".$row['no']."'");
				sql_query("update alice_member_service set `".$_field."`=`".$_field."`-1 where `mb_id`='".$member['mb_id']."'");
				$arr['msg'] = "점프가 완료되었습니다.";
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			}
		}
	}
	die(json_encode($arr));
	break;



// : 기업정보 대표선택
case "is_public_company":
	$arr = $netfu_member->login_check2($member['mb_id']);
	if(!$arr['msg']) {
		sql_query("update alice_member_company set is_public=0 where `mb_id`='".$member['mb_id']."'");
		sql_query("update alice_member_company set is_public=1 where `no`='".addslashes($_POST['no'])."' and `mb_id`='".$member['mb_id']."'");
		$arr['msg'] = "설정이 완료되었습니다.";
		$arr['move'] = $_SERVER['HTTP_REFERER'];
	}
	die(json_encode($arr));
	break;


// : 기업정보 등록
case "company_write":
	$arr = $netfu_member->login_check2($member['mb_id']);

	if(!$arr['msg']) {

		$row = sql_fetch("select * from alice_member_company where `no`='".addslashes($_POST['no'])."' and `mb_id`='".$member['mb_id']."'");

		if($_FILES['mb_logo']['tmp_name']) {
			$tmp_file = $_FILES['mb_logo']['tmp_name'];
			$filename = $_FILES['mb_logo']['name'];
			$filesize = $_FILES['mb_logo']['size'];

			$timg = @getimagesize($tmp_file);

			if(is_uploaded_file($tmp_file)){
				// 사이즈 체크

				// 용량 체크 (관리자에서 설정한 용량)

				// 확장자 체크
				$img_extension = $user_control->_img();
				$logo_path = NFE_PATH.'/data/member/'.$member['mb_id'].'/logo/';

				if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
					$file_upload = $utility->file_upload($tmp_file, $filename, $logo_path, $_FILES);	// 파일 업로드
					$upload_file = $file_upload['upload_file'];
					$vals['mb_logo'] = $upload_file;	// 변수 할당
					@unlink($logo_path.$row['mb_logo']);
				}

			}
		}

		$vals['mb_id'] = $member['mb_id'];
		$vals['mb_ceo_name'] = $_POST['mb_ceo_name'];
		$vals['mb_company_name'] = $_POST['mb_company_name'];
		$vals['mb_biz_type'] = $_POST['mb_biz_type'];
		$vals['mb_biz_no'] = @implode("-", $_POST['mb_biz_no']);
		$vals['mb_biz_phone'] = @implode("-", $_POST['mb_biz_phone']);
		$vals['mb_biz_hphone'] = @implode("-", $_POST['mb_biz_hphone']);
		//$vals['mb_address_road'] = $_POST['xfsd'];
		//$vals['mb_biz_zipcode'] = $_POST['xfsd'];
		$vals['mb_biz_doro_post'] = $_POST['mb_doro_post'];
		$vals['mb_biz_address0'] = $_POST['mb_address0'];
		$vals['mb_biz_address1'] = $_POST['mb_address1'];
		$vals['mb_biz_email'] = @implode("@", $_POST['mb_email']);
		$vals['mb_biz_fax'] = @implode("-", $_POST['mb_biz_fax']);
		$vals['mb_biz_success'] = $_POST['mb_biz_success'];
		$vals['mb_biz_form'] = $_POST['mb_biz_form'];
		$vals['mb_biz_content'] = $_POST['mb_biz_content'];
		$vals['mb_biz_foundation'] = $_POST['mb_biz_foundation'];
		$vals['mb_biz_member_count'] = $_POST['mb_biz_member_count'];
		$vals['mb_biz_stock'] = $_POST['mb_biz_stock'];
		$vals['mb_biz_sale'] = $_POST['mb_biz_sale'];
		$vals['mb_biz_vision'] = $_POST['mb_biz_vision'];
		$vals['mb_biz_result'] = $_POST['mb_biz_result'];
		$vals['mb_logo_sel'] = $_POST['wr_logo'];
		$vals['mb_latlng'] = @implode(",", $_POST['map_latlng']);
		//$vals['mb_left'] = $_POST['xfsd'];
		$vals['mb_homepage'] = $_POST['mb_homepage'];
		//$vals['is_delete'] = $_POST['xfsd'];
		//$vals['is_admin'] = $_POST['xfsd'];

		$val = $utility->QueryString($vals);

		if($row) sql_query("update alice_member_company set ".$val." where `no`='".addslashes($row['no'])."'");
		else sql_query("insert into alice_member_company set ".$val);

		$msg = $row ? '수정' : '등록';
		$arr['msg'] = $msg.'이 완료되었습니다.';
		$arr['move'] = NFE_URL.'/mypage/company_list.php';
	}
	die(json_encode($arr));
	break;


// : 담당자 등록
	case "company_manager_write":
		$arr['msg'] = "로그인하셔야 이용가능합니다.";
		$arr['move'] = NFE_URL."/include/login.php";
		if($member['mb_id']) {

			if($_POST['no']) {
				$q = "select * from alice_company_manager where `wr_id` = '".$member['mb_id']."' and `no`='".addslashes($_POST['no'])."'";
				$manager_row = sql_fetch($q);
			}
			$vals['wr_id'] = $member['mb_id'];
			$vals['wr_name'] = $_POST['wr_name'];
			if($_POST['wr_phone'][1]) $vals['wr_phone'] = @implode("-", $_POST['wr_phone']);
			if($_POST['wr_hphone'][1]) $vals['wr_hphone'] = @implode("-", $_POST['wr_hphone']);
			if($_POST['wr_fax'][1]) $vals['wr_fax'] = @implode("-", $_POST['wr_fax']);
			$vals['wr_email'] = @implode("@", $_POST['wr_email']);
			if(!$manager_row) $vals['wr_wdate'] = $now_date;
			$val = $utility->QueryString($vals);

			if($manager_row) $Q = "update alice_company_manager set ".$val." where `no`='".$manager_row['no']."'";
			else $Q = "insert into alice_company_manager set ".$val;

			sql_query($Q);

			$msg = $manager_row ? '수정' : '등록';
			$arr['msg'] = $msg."이 완료되었습니다.";
			$arr['move'] = NFE_URL.'/mypage/manager_info.php';
		}
		die(json_encode($arr));
		break;


// : 기업선택
	case "company_list_sel":
		$arr['msg'] = "로그인하셔야 이용가능합니다.";
		$arr['move'] = NFE_URL."/include/login.php";
		if($member['mb_id']) {
			$row = sql_fetch("select * from `alice_member_company` where `mb_id` = '".$member['mb_id']."' and `no`='".addslashes($_POST['no'])."'");
			$arr = array();
			$arr['row'] = $row;

			$wr_company = $row['no'];
			ob_start();
			include NFE_PATH.'/include/inc/my_company_info.inc.php';
			$arr['body'] = ob_get_clean();
		}
		die(json_encode($arr));
		break;

// : 담당자 선택
	case "manager_sel":
		$arr['msg'] = "로그인하셔야 이용가능합니다.";
		$arr['move'] = NFE_URL."/include/login.php";
		if($member['mb_id']) {
			$row = sql_fetch("select * from `alice_company_manager` where `wr_id` = '".$member['mb_id']."' and `no`='".addslashes($_POST['no'])."'");
			$arr = array();
			$arr['row'] = $row;
		}
		die(json_encode($arr));
		break;


	case "get_ajax_job_detail":
		$get_alba = sql_fetch("select * from alice_alba where `no`='".addslashes($_POST['no'])."'");
		ob_start();
		include NFE_PATH.'/include/inc/job_box_detail.inc.php';
		$body = ob_get_clean();
		$arr['body'] = $body;
		die(json_encode($arr));
		break;


	case "get_ajax_resume_detail":
		$get_resume = sql_fetch("select * from alice_alba_resume where `no`='".addslashes($_POST['no'])."'");
		ob_start();
		include NFE_PATH.'/include/inc/resume_box_detail.inc.php';
		$body = ob_get_clean();
		$arr['body'] = $body;
		die(json_encode($arr));
		break;


// : 채용정보 등록
	case "job_write":
		$arr['move'] = ($member['mb_id']) ? NFE_URL."/" : NFE_URL."/include/login.php";
		if($_POST['no']) {
			$job_row = sql_fetch("select * from alice_alba where `no`='".addslashes($_POST['no'])."'");
		}

		if(!$member['mb_id']) $arr['msg'] = "기업회원으로 로그인을 하셔야 이용가능합니다.";
		if($member['mb_type']!='company') $arr['msg'] = "기업회원으로 로그인을 하셔야 이용가능합니다.";
		if($job_row['no'] && $job_row['wr_id']!=$member['mb_id']) $arr['msg'] = "본인만 수정가능합니다.";

		if(!$arr['msg']) {

			$mb_id = $member['mb_id'];

			$vals['wr_id'] = $mb_id;
			$vals['wr_open'] = 1;
			$vals['wr_person'] = $_POST['wr_person'];
			$vals['wr_phone'] = @implode("-", $_POST['wr_phone']);
			$vals['wr_hphone'] = @implode("-", $_POST['wr_hphone']);
			$vals['wr_fax'] = @implode("-", $_POST['wr_fax']);
			$vals['wr_email'] = @implode("@", $_POST['wr_email']);
			$vals['wr_page'] = $_POST['wr_page'];
			$vals['wr_company'] = $_POST['company_list'];

			$vals['wr_company_name'] = $_POST['wr_company_name'];
			$vals['wr_subject'] = $_POST['wr_subject'];
			$vals['wr_job_type0'] = $_POST['wr_job_type0'];
			$vals['wr_job_type1'] = $_POST['wr_job_type1'];
			$vals['wr_job_type2'] = $_POST['wr_job_type2'];
			$vals['wr_job_type3'] = $_POST['wr_job_type3'];
			$vals['wr_job_type4'] = $_POST['wr_job_type4'];
			$vals['wr_job_type5'] = $_POST['wr_job_type5'];
			$vals['wr_job_type6'] = $_POST['wr_job_type6'];
			$vals['wr_job_type7'] = $_POST['wr_job_type7'];
			$vals['wr_job_type8'] = $_POST['wr_job_type8'];
			//$vals['wr_is_adult'] = $_POST['sdfsdf'];
			$vals['wr_beginner'] = $_POST['sdfsdf']; // 초보가능
			$vals['wr_area_company'] = $_POST['wr_area_company'];
			$vals['wr_area_point'] = @implode(",", $_POST['map_latlng']);
			$vals['wr_area'] = $_POST['wr_area'];
			if($_POST['wr_area_0'][0]) $vals['wr_area_0'] = @implode("/", $_POST['wr_area_0']);
			if($_POST['wr_area_1'][0]) $vals['wr_area_1'] = @implode("/", $_POST['wr_area_1']);
			if($_POST['wr_area_2'][0]) $vals['wr_area_2'] = @implode("/", $_POST['wr_area_2']);
			$vals['wr_subway_area_0'] = $_POST['wr_subway_area_0'];
			$vals['wr_subway_line_0'] = $_POST['wr_subway_line_0'];
			$vals['wr_subway_station_0'] = $_POST['wr_subway_station_0'];
			$vals['wr_subway_content_0'] = $_POST['wr_subway_content_0'];
			$vals['wr_subway_area_1'] = $_POST['wr_subway_area_1'];
			$vals['wr_subway_line_1'] = $_POST['wr_subway_line_1'];
			$vals['wr_subway_station_1'] = $_POST['wr_subway_station_1'];
			$vals['wr_subway_content_1'] = $_POST['wr_subway_content_1'];
			$vals['wr_subway_area_2'] = $_POST['wr_subway_area_2'];
			$vals['wr_subway_line_2'] = $_POST['wr_subway_line_2'];
			$vals['wr_subway_station_2'] = $_POST['wr_subway_station_2'];
			$vals['wr_subway_content_2'] = $_POST['wr_subway_content_2'];
			$vals['wr_college_area'] = $_POST['wr_college_area'];
			$vals['wr_college_vicinity'] = $_POST['wr_college_vicinity'];
			//$vals['wr_use_photo'] = $_POST['sdfsdf'];
			$vals['wr_date'] = $_POST['wr_date'];
			$vals['wr_week'] = $_POST['wr_week'];
			$vals['wr_stime'] = @implode(":", $_POST['wr_stime']);
			$vals['wr_etime'] = @implode(":", $_POST['wr_etime']);
			$vals['wr_time_conference'] = $_POST['wr_time_conference'];
			$vals['wr_pay_type'] = $_POST['wr_pay_type'];
			$vals['wr_pay'] = preg_replace("/,/", "", $_POST['wr_pay']);
			$vals['wr_pay_conference'] = $_POST['wr_pay_conference'];
			$vals['wr_pay_support'] = @implode(',', $_POST['wr_pay_support']);
			$vals['wr_work_type'] = @implode(',', $_POST['wr_work_type']);
			$vals['wr_welfare_read'] = $_POST['welfare_read'];
			$vals['wr_welfare'] = serialize($_POST['wr_welfare']);
			$vals['wr_gender'] = $_POST['wr_gender'];
			$vals['wr_age_limit'] = $_POST['wr_age_limit'];
			if($_POST['wr_age_limit']) $vals['wr_age'] = $_POST['wr_sage'] . "-" . $_POST['wr_eage'];
			$vals['wr_age_etc'] = @implode(',', $_POST['wr_age_etc']);
			$vals['wr_ability'] = $_POST['wr_ability'];
			$vals['wr_career_type'] = $_POST['wr_career_type'];
			if($_POST['wr_career_type']==2) $vals['wr_career'] = $_POST['wr_career'];
			$vals['wr_preferential'] = @implode(',', $_POST['wr_preferential']);
			$vals['wr_volume'] = intval($_POST['wr_volume'])>0 ? $_POST['wr_volume'] : "";
			$vals['wr_volumes'] = @implode(',', $_POST['wr_volumes']);
			$vals['wr_target'] = @implode(',', $_POST['wr_target']);

			if($_POST['volume_check']=='wr_volume_dates') $vals['wr_volume_date'] = $_POST['wr_volume_date'];	 // 모집 종료일
			if($_POST['volume_check']=='wr_volume_always') $vals['wr_volume_always'] = 1; // 상시모집
			if($_POST['volume_check']=='wr_volume_end') $vals['wr_volume_end'] = 1; // 채용시까지

			$vals['wr_requisition'] = @implode(',', $_POST['wr_requisition']);
			$vals['wr_homepage'] = ($_POST['wr_homepage']) ? $_POST['wr_homepage'] : ""; // 홈페이지 주소;
			$vals['wr_form'] = $_POST['wr_form'];
			if($_POST['wr_form']) $vals['wr_form_required'] = $_POST['wr_form_required'];
			//$vals['wr_form_attach'] = $_POST['sdfsdf'];
			$vals['wr_papers'] = @implode(',', $_POST['wr_papers']);
			$vals['wr_pre_question'] = $_POST['wr_pre_question'];
			$vals['wr_content'] = $_POST['wr_content'];
			$vals['wr_udate'] = $now_date;

			//$vals['wr_report'] = $_POST['sdfsdf'];
			//$vals['wr_report_date'] = $_POST['sdfsdf'];
			//$vals['wr_report_content'] = $_POST['sdfsdf'];
			//$vals['wr_is_admin'] = $_POST['sdfsdf'];
			//$vals['wr_oid'] = $_POST['sdfsdf'];
			//$vals['is_delete'] = $_POST['sdfsdf'];
			//$vals['input_type'] = $_POST['sdfsdf'];
			$vals['kakao_id'] = $_POST['kakao_id'];

			if(@in_array($_POST['mode_2'], array('reinsert', 'load')) || !$job_row) {
				$vals['wr_wdate'] = $now_date;
				$vals['wr_jdate'] = $now_date;
			}

			$val = $utility->QueryString($vals);

			if((!$_POST['mode_2'] && $job_row['no']) || @in_array($_POST['mode_2'], array('reinsert'))) {
				$q = " update alice_alba set " . $val." where `no`='".$job_row['no']."'";
			} else {
				$q = " insert into alice_alba set " . $val;
			}

			$_msg = '등록';
			if($job_row['no']) $_msg = '수정';
			if($_POST['mode_2']=='reinsert') $_msg = '재등록';
			if($_POST['mode_2']=='load') $_msg = '복사';

			$query = sql_query($q);

			$em_no = $job_row['no'];
			if(!$job_row['no']  || $_POST['mode_2']=='load' ) {
				$em_no = mysql_insert_id();
				$sms_control->send_sms_user('alba_regist', $member, "", $_POST);

				// : 결제페이지설정 미사용인경우 실행 - 처음등록시 1번만 실행.
				$arr['move'] = $netfu_mjob->mu_service_process('job', $em_no);
			}


			$get_pg_page = $payment_control->get_pg_page(1);
			if($query) {
				$arr['msg'] = $_msg."이(가) 완료되었습니다.";
				if(!$arr['move']) {
					if($job_row['no'] && $_POST['mode_2']!='load') {
						$arr['move'] = NFE_URL."/mypage/employ_list.php";
					}else{
						$arr['move'] = NFE_URL."/payment/job_payment.php?no=".$em_no;
					}
				}
			} else {
				$arr['msg'] = $_msg."이 실패되었습니다.";
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			}
		}

		echo $netfu_util->page_move($arr['msg'], $arr['move']);
		exit;
		break;


	## 채용정보 강제마감
	case 'volume_end':
		$arr['msg'] = "로그인하셔야 이용가능합니다.";
		$arr['move'] = NFE_URL."/include/login.php";
		if($_POST['no']) {
			$job_row = sql_fetch("select * from alice_alba where `no`='".addslashes($_POST['no'])."' and `wr_id`='".$member['mb_id']."'");
			if(!$job_row) {
				$arr['msg'] = "정상적인 방식으로 이용해주시기 바랍니다.";
			} else {
				$vals['wr_volume_date'] = "";		// 모집종료일 초기화
				$vals['wr_volume_always'] = 0;	// 상시모집 체크 해제
				$vals['wr_volume_end'] = 0;		// 채용시까지 체크 해제

				$result = $alba_company_control->alba_update($vals, $_POST['no']);
				$arr['msg'] = '마감으로 설정했습니다.';
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			}
		}
		die(json_encode($arr));
		break;



	## 프로필 비/공개 체크
	case 'member_views':
		$arr['msg'] = "로그인하셔야 이용가능합니다.";
		$arr['move'] = NFE_URL."/include/login.php";

		if($member['mb_id']) {

			$field = $_POST['field'];
			$value = $_POST['value'];
			$value_arr = array( "phone" => "전화번호", "hphone" => "휴대폰", "email" => "이메일", "homepage" => "홈페이지" );

			$vals[$field] = $_POST['sel'];

			$vals['mb_udate'] = $now_date;	// 수정일

			// update
			$result = $user_control->user_update($vals, $member['mb_id']);

			if($result){
				$arr['msg'] = $value_arr[$value] . " " . $user_control->_success('0001');
			} else {
				$arr['msg'] = $user_control->_errors('0034');
			}
		}
		die(json_encode($arr));
		break;


	case "resume_read":
		$arr = array();
		if(!$is_member){	// 회원 체크
			$arr['msg'] = $user_control->_errors('0015');
			$arr['move'] = $alice['member_path']."/login.php?url=".$urlencode;
		}

		if(!$arr['msg']) {

			$no = $_POST['no'];
			$wr_id = $_POST['wr_id'];
			$type = $_POST['type'];

			$get_resume = $alba_individual_control->get_resume_no($no); // 이력서 정보

			// 열람권 기간/건수 확인
			$is_open_service = false;
			if( $utility->valid_day($member_service['mb_service_open']) ){
				$is_open_service = $member_service['mb_service_open'];
			}
			$is_open_count = false;
			if( $utility->valid_day($member_service['mb_service_open']) && $member_service['mb_service_open_count'] ){	// 건수 사용이 가능하다면
				$is_open_count = $member_service['mb_service_open_count'];
			}

			if($is_open_count) {
				$result = $alba_company_control->open_insert($no,$get_resume['wr_id'],$type);
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			} else {
				$arr['msg'] = '사용가능한 이력서 열람권이 없습니다.';
			}
		}
		die(json_encode($arr));
		break;


// : 이력서 등록
	case "resume_write":

		if($_POST['no']) {
			$re_row = sql_fetch("select * from alice_alba_resume where `no`='".addslashes($_POST['no'])."'");
		}

		$wr_id = strpos($_SERVER['HTTP_REFERER'], '/nad/')!==false ? addslashes($_POST['wr_id']) : $member['mb_id'];

		/* 대학(2,3년) 정보 */
		$wr_half = array();
		$wr_half['college'] = $_POST['wr_half_college'];
		$wr_half['college_specialize'] = $_POST['wr_half_college_specialize'];
		$wr_half['college_syear'] = $_POST['wr_half_college_syear'];
		$wr_half['college_eyear'] = $_POST['wr_half_college_eyear'];
		$wr_half['college_graduation'] = $_POST['wr_half_college_graduation'];

		/* 대학(4년) 정보 */
		$wr_college = array();
		$wr_college['college'] = $_POST['wr_college'];
		$wr_college['college_specialize'] = $_POST['wr_college_specialize'];
		$wr_college['college_syear'] = $_POST['wr_college_syear'];
		$wr_college['college_eyear'] = $_POST['wr_college_eyear'];
		$wr_college['college_graduation'] = $_POST['wr_college_graduation'];

		/* 대학원 정보 */
		$wr_graduate = array();
		$wr_graduate['graduate'] = $_POST['wr_graduate'];
		$wr_graduate['graduate_specialize'] = $_POST['wr_graduate_specialize'];
		$wr_graduate['graduate_grade'] = $_POST['wr_graduate_grade'];
		$wr_graduate['graduate_syear'] = $_POST['wr_graduate_syear'];
		$wr_graduate['graduate_eyear'] = $_POST['wr_graduate_eyear'];
		$wr_graduate['graduate_graduation'] = $_POST['wr_graduate_graduation'];

		/* 대학원 이상 정보 */
		$wr_success = array();
		$wr_success['success'] = $_POST['wr_success'];
		$wr_success['success_specialize'] = $_POST['wr_success_specialize'];
		$wr_success['success_grade'] = $_POST['wr_success_grade'];
		$wr_success['success_syear'] = $_POST['wr_success_syear'];
		$wr_success['success_eyear'] = $_POST['wr_success_eyear'];
		$wr_success['success_graduation'] = $_POST['wr_success_graduation'];


		// : 경력
		if($_POST['wr_career_use']){	// 경력이 있다면
			$wr_career = array();
			$wr_career_company = $_POST['wr_career_company'];
			$wr_career_company_cnt = count($wr_career_company);
			for($i=0;$i<$wr_career_company_cnt;$i++){
				$wr_career[$i]['company'] = $wr_career_company[$i];		// 회사명
				$wr_career[$i]['type'] = $_POST['wr_career_type_'.$i];	// 직종
				$wr_career[$i]['sdate'] = $_POST['wr_career_syear'][$i] . '-' . sprintf('%02d',$_POST['wr_career_smonth'][$i]);
				$wr_career[$i]['edate'] = $_POST['wr_career_eyear'][$i] . '-' . sprintf('%02d',$_POST['wr_career_emonth'][$i]);
				$wr_career[$i]['job'] = $_POST['wr_career_job'][$i];
				$wr_career[$i]['content'] = $_POST['wr_career_content'][$i];
			}
		}

		// : 자격증
		if($_POST['wr_license_use']){
			$wr_license = array();
			$wr_license_name = $_POST['wr_license_name'];
			$wr_license_name_cnt = count($wr_license_name);
			for($i=0;$i<$wr_license_name_cnt;$i++){
				$wr_license[$i]['name'] = $wr_license_name[$i];					// 자격증명
				$wr_license[$i]['public'] = $_POST['wr_license_public'][$i];	// 자격증 발행처
				$wr_license[$i]['year'] = $_POST['wr_license_year'][$i];		// 취득연도
			}
		}

		// : 외국어
		if($wr_language_use){
			$wr_language = array();
			$wr_language_name = $_POST['wr_language_name'];
			$wr_language_name_cnt = count($wr_language_name);	// 가능한 외국어 건수
			for($i=0;$i<$wr_language_name_cnt;$i++){
				$wr_language[$i]['language'] = $wr_language_name[$i];			// 가능한 외국어
				$wr_language[$i]['level'] = $_POST['wr_language_level_'.$i];	// 외국어 수준

				$wr_language[$i]['license']['license'] = $_POST['language_license_'.$i];			// 공인시험
				$wr_language[$i]['license']['level'] = $_POST['language_license_level_'.$i];	// 공인시험 점수
				$wr_language[$i]['license']['year'] = $_POST['language_license_year_'.$i];	// 공인시험 취득연도

				if( $_POST['wr_language_study_'.$i] ){
					$wr_language[$i]['study'] = $_POST['wr_language_study_'.$i];					// 어학연수 경험
					$wr_language[$i]['study_date'] = $_POST['wr_language_study_date_'.$i];	// 어학연수 기간
				}
			}
		}

		// : 
		$wr_specialty_etc = ($_POST['wr_specialty_etc']) ? 1 : 0;
		$wr_specialty_etc = $wr_specialty_etc ."//" . $_POST['wr_specialty_etc_val'];

		// : 
		if($_POST['wr_military'] == 1){	// 군필
			$wr_military_type = $_POST['wr_military_type'];
		}

		/*
		wr_age = '".addslashes($_POST['adfd'])."',
		wr_gender = '".addslashes($_POST['adfd'])."',
		wr_keyword = '".addslashes($_POST['adfd'])."',
		wr_view = '".addslashes($_POST['adfd'])."',
		wr_report = '".addslashes($_POST['adfd'])."',
		wr_report_date = '".addslashes($_POST['adfd'])."',
		wr_is_admin = '".addslashes($_POST['adfd'])."',
		wr_report_content = '".addslashes($_POST['adfd'])."',
		wr_oid = '".addslashes($_POST['adfd'])."',
		is_delete = '".addslashes($_POST['adfd'])."',
		input_type = '".addslashes($_POST['adfd'])."',
		etc_0 = '".addslashes($_POST['adfd'])."',
		etc_1 = '".addslashes($_POST['adfd'])."',
		etc_2 = '".addslashes($_POST['adfd'])."',
		etc_3 = '".addslashes($_POST['adfd'])."',
		etc_4 = '".addslashes($_POST['adfd'])."',
		etc_5 = '".addslashes($_POST['adfd'])."',
		etc_6 = '".addslashes($_POST['adfd'])."',
		etc_7 = '".addslashes($_POST['adfd'])."',
		etc_8 = '".addslashes($_POST['adfd'])."',
		etc_9 = '".addslashes($_POST['adfd'])."',

		wr_service_main_focus = '".addslashes($_POST['adfd'])."',
		wr_service_main_focus_gold = '".addslashes($_POST['adfd'])."',
		wr_service_sub_focus = '".addslashes($_POST['adfd'])."',
		wr_service_sub_focus_gold = '".addslashes($_POST['adfd'])."',
		wr_service_basic = '".addslashes($_POST['adfd'])."',
		wr_service_basic_sub = '".addslashes($_POST['adfd'])."',
		wr_service_busy = '".addslashes($_POST['adfd'])."',
		wr_service_focus = '".addslashes($_POST['adfd'])."',
		wr_service_neon = '".addslashes($_POST['adfd'])."',
		wr_service_bold = '".addslashes($_POST['adfd'])."',
		wr_service_color = '".addslashes($_POST['adfd'])."',
		wr_service_icon = '".addslashes($_POST['adfd'])."',
		wr_service_blink = '".addslashes($_POST['adfd'])."',
		wr_service_jump = '".addslashes($_POST['adfd'])."',
		*/

		// : 아이디
		if($wr_id) $add_q = ", wr_id = '".$wr_id."'";
		if($wr_career) $add_q .= ", wr_career = '".addslashes(serialize($wr_career))."'";
		if($wr_military_type) $add_q .= ", wr_military_type = '".addslashes($_POST['wr_military_type'])."'";

		$q = "
		wr_use = '1',
		wr_open = '".addslashes($_POST['wr_open'])."',
		wr_subject = '".addslashes($_POST['wr_subject'])."',
		wr_area0 = '".addslashes($_POST['wr_area0'])."',
		wr_area1 = '".addslashes($_POST['wr_area1'])."',
		wr_area2 = '".addslashes($_POST['wr_area2'])."',
		wr_area3 = '".addslashes($_POST['wr_area3'])."',
		wr_area4 = '".addslashes($_POST['wr_area4'])."',
		wr_area5 = '".addslashes($_POST['wr_area5'])."',
		wr_home_work = '".intval($_POST['wr_home_work'])."',
		wr_job_type0 = '".addslashes($_POST['wr_job_type0'])."',
		wr_job_type1 = '".addslashes($_POST['wr_job_type1'])."',
		wr_job_type2 = '".addslashes($_POST['wr_job_type2'])."',
		wr_job_type3 = '".addslashes($_POST['wr_job_type3'])."',
		wr_job_type4 = '".addslashes($_POST['wr_job_type4'])."',
		wr_job_type5 = '".addslashes($_POST['wr_job_type5'])."',
		wr_job_type6 = '".addslashes($_POST['wr_job_type6'])."',
		wr_job_type7 = '".addslashes($_POST['wr_job_type7'])."',
		wr_job_type8 = '".addslashes($_POST['wr_job_type8'])."',

		wr_date = '".addslashes($_POST['wr_date'])."',
		wr_week = '".addslashes($_POST['wr_week'])."',
		wr_time = '".addslashes($_POST['wr_time'])."',
		wr_work_direct = '".intval($_POST['wr_work_direct'])."',

		wr_pay_type = '".addslashes($_POST['wr_pay_type'])."',
		wr_pay = '".addslashes($_POST['wr_pay'])."',
		wr_pay_conference = '".intval($_POST['wr_pay_conference'])."',
		wr_work_type = '".@implode(",", $_POST['wr_work_type'])."',
		wr_school_ability = '".addslashes($_POST['wr_school_ability'])."',
		wr_school_absence = '".intval($_POST['wr_school_absence'])."',
		wr_school_type = '".@implode(",", $_POST['wr_school_type'])."',
		wr_high_school_name = '".addslashes($_POST['wr_high_school_name'])."',
		wr_high_school_syear = '".addslashes($_POST['wr_high_school_syear'])."',
		wr_high_school_eyear = '".addslashes($_POST['wr_high_school_eyear'])."',
		wr_high_school_graduation = '".intval($_POST['wr_high_school_graduation'])."',
		wr_half_college = '".addslashes(serialize($wr_half))."',
		wr_college = '".addslashes(serialize($wr_college))."',
		wr_graduate = '".addslashes(serialize($wr_graduate))."',
		wr_success = '".addslashes(serialize($wr_success))."',
		wr_career_use = '".intval($_POST['wr_career_use'])."',
		wr_license_use = '".intval($_POST['wr_license_use'])."',
		wr_license = '".addslashes(serialize($wr_license))."',
		wr_language_use = '".intval($_POST['wr_language_use'])."',
		wr_language = '".addslashes(serialize($wr_language))."',
		wr_oa = '".addslashes(serialize($_POST['wr_oa']))."',
		wr_computer = '".addslashes(@implode(',', $_POST['wr_computer']))."',
		wr_specialty = '".addslashes(@implode(',', $_POST['wr_specialty']))."',
		wr_specialty_etc = '".addslashes($wr_specialty_etc)."',
		wr_prime = '".addslashes($_POST['wr_prime'])."',
		wr_introduce = '".addslashes($_POST['wr_introduce'])."',
		wr_impediment_use = '".intval($_POST['wr_impediment_use'])."',
		wr_impediment_level = '".addslashes($_POST['wr_impediment_level'])."',
		wr_impediment_name = '".addslashes($_POST['wr_impediment_name'])."',
		wr_marriage = '".intval($_POST['wr_marriage'])."',
		wr_military = '".intval($_POST['wr_military'])."',
		wr_wdate = '".addslashes($now_date)."',
		wr_udate = '".addslashes($now_date)."',
		wr_preferential_use = '".intval($_POST['wr_preferential_use'])."',
		wr_treatment_use = '".intval($_POST['wr_treatment_use'])."',
		wr_treatment_service = '".addslashes(@implode(',', $_POST['wr_treatment_service']))."',
		wr_calltime = '".addslashes(@implode('-', $_POST['wr_calltime']))."',
		wr_calltime_always = '".intval($_POST['wr_calltime_always'])."',
		kakao_id = '".addslashes($_POST['kakao_id'])."'
		";
		$q .= $add_q;

		if($re_row['no']) sql_query("update alice_alba_resume set $q where `no`='".$re_row['no']."'");
		else sql_query("insert into alice_alba_resume set $q");
		$nos = $re_row['no'] ? $re_row['no'] : mysql_insert_id();

		// : 결제페이지설정 미사용인경우 실행 - 처음등록시 1번만 실행.
		if(!$re_row['no']) {
			$sms_control->send_sms_user('alba_resume_regist', $member, "", $_POST);
			$netfu_mjob->mu_service_process('resume', $nos);
		}

		$get_pg_page = $payment_control->get_pg_page(1);
		$arr['msg'] = "등록이 완료되었습니다.";
		$arr['move'] = $get_pg_page['alba_resume_pay'] ? NFE_URL.'/payment/resume_payment.php?no='.$nos : NFE_URL.'/mypage/resume_list.php';

		if($re_row['no']) {
			$arr['msg'] = "수정이 완료되었습니다.";
			$arr['move'] = NFE_URL.'/mypage/resume_list.php';
		}
		//echo str_replace("\r\n", "<br/>", $q);
		echo $netfu_util->page_move($arr['msg'], $arr['move']);
		//die(json_encode($arr));
		break;



	case "resume_open":
		$arr['msg'] = "설정이 실패되었습니다.";
		$arr['move'] = "";
		$nos = addslashes(@implode(",", $_POST['chk']));
		if($nos) {
			if(!$_SESSION['sess_admin_uid'] || strpos($_SERVER['HTTP_REFERER'], "/nad/")===false)
				$_where = " and `wr_id`='".$member['mb_id']."'";
			$q = "select * from alice_alba_resume where `no` in (".$nos.") ".$_where;
			$query = sql_query($q);

			while($row=sql_fetch_array($query)) {
				if($row && $row['wr_id']==$member['mb_id']) {
					$delete = sql_query("update alice_alba_resume set wr_open='".addslashes($_POST['open'])."' where `no`='".$row['no']."'");
				}
			}
			$arr['msg'] = "설정이 완료되었습니다.";
			$arr['move'] = $_SERVER['HTTP_REFERER'];
		}
		die(json_encode($arr));
		break;


	case "receive_click":
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		} else {
			$get_alba = $alba_user_control->get_alba_no($_POST['no']);	// 정규직 정보
			$job_info = $netfu_mjob->get_alba($get_alba);
			if($member['mb_id'] && $member['mb_type']=='individual') {
				if($job_info['is_open__']===true) {
					$arr['js'] = '$(".detail_ly.mail_ly").css("display","none");$(".detail_ly.mail_ly.'.addslashes($_POST['k']).'_bx").css("display","block");';
				} else {
					$arr['move'] = NFE_URL.'/payment/read_payment.php';
				}
			} else if($member['mb_id']) {
				$arr['msg'] = "개인회원만 이용가능합니다.";
			} else {
				$arr['msg'] = "로그인하셔야 이용가능합니다.";
				$arr['move'] = NFE_URL.'/include/login.php';
			}
		}
		die(json_encode($arr));
		break;

// : 입사지원
	case "receive_write":
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}

		if(!$arr['msg']) {
			$get_alba = $alba_user_control->get_alba_no($_POST['no']);	 // 정규직 공고
			$get_member = $user_control->get_member($get_alba['wr_id']);

			$vals['type'] = 'become_'.$_POST['code'];
			$vals['wr_id'] = $member['mb_id']; // 작성 회원 id
			$vals['wr_from'] = $_POST['alba_resume']; // 이력서 no
			$vals['wr_to'] = $_POST['no']; // 공고 no
			$vals['wr_to_id'] = $get_alba['wr_id'];
			$vals['wr_content'] = $_POST['wr_content']; // 사전 질문 답변
			$vals['etc_0'] = $_POST['wr_subject']; // 지원 제목
			$vals['etc_1'] = @implode(",", $_POST['mb_info']);
			$vals['etc_5'] = @implode(",", $_POST['sel_file']);
			$vals['wdate'] = $now_date;
			$val = $utility->QueryString($vals);

			$row = sql_fetch("select * from alice_receive where `type`='".addslashes($vals['type'])."' and `wr_id`='".$vals['wr_id']."' and `wr_from`='".addslashes($vals['wr_from'])."' and `wr_to`='".addslashes($vals['wr_to'])."'");

			$_kind_txt = $netfu_mjob->requisition_arr[$_POST['code']];
			if($row) {
				$arr['msg'] = $_kind_txt." 입사지원을 이미 신청하셨습니다.";
			} else {
				$query = sql_query(" insert into alice_receive set " . $val);

				$arr['msg'] = $_kind_txt." 입사지원 신청이 실패되었습니다.";
				if($query) {
					// 공고 지원 카운트 증가
					$alba_user_control->desire_update($_POST['no'], $get_alba['wr_id']);

					$s_data['email_arr'][] = array('email'=>$get_member['mb_email'], 'name'=>$get_member['mb_name']);
					if($_POST['code']=='email') $s_data['email_attach'][] = array('file'=>$_FILES['up_file']['tmp_name'], 'name'=>$_FILES['up_file']['name']);
					$s_data['subject'] = '입사지원 신청';
					$s_data['content'] = '내용내용';
					$netfu_util->mailer($s_data);

					$_key = $_POST['code']=='email' ? 'alba_email' : 'alba_online';
					$sms_control->send_sms_user($_key, $get_member, "", $get_alba);

					$arr['msg'] = $_kind_txt." 입사지원 신청이 완료되었습니다.";
				}
			}
		}
		die(json_encode($arr));
		break;



	case "resume_pop":
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}

		if(!$arr['msg']) {
			$get_alba = $alba_user_control->get_alba_no($_POST['wr_employ']);
			$get_member = $member_control->get_member($get_alba['mb_id']);
			$get_resume = $alba_resume_user_control->get_resume_no($_POST['resume_no']);
			$get_indi_member = $member_control->get_member($get_resume['wr_id']);

			$vals['mb_id'] = $member['mb_id'];
			$vals['wr_type'] = $_POST['wr_type'];
			$vals['wr_id'] = $get_resume['wr_id'];
			$vals['wr_resume'] = $_POST['resume_no'];
			$vals['wr_employ'] = $_POST['wr_employ'];
			$vals['wr_person'] = $_POST['wr_person'];
			$vals['wr_phone'] = $_POST['wr_phone'];
			$vals['wr_hphone'] = $_POST['wr_hphone'];
			$vals['wr_fax'] = $_POST['wr_fax'];
			$vals['wr_email'] = $_POST['wr_email'];
			$vals['wr_content'] = $_POST['wr_content'];
			$vals['wdate'] = $now_date;
			$val = $utility->QueryString($vals);

			$_where = " and `mb_id`='".$vals['mb_id']."' and `wr_type`='".addslashes($vals['wr_type'])."' and `wr_resume`='".addslashes($vals['wr_resume'])."' and `wr_employ`='".addslashes($vals['wr_employ'])."'";
			$row = sql_fetch("select * from alice_resume_proposal where 1 ".$_where);

			if($row) {
				$arr['msg'] = "이미 신청하신 ".$netfu_mjob->proposal_arr[$vals['wr_type']]." 입니다.";
			} else {
				$query = sql_query("insert into alice_resume_proposal set ".$val);
				$insert_no = $db->last_id();
				if($query) {
					$arr['msg'] = $netfu_mjob->proposal_arr[$vals['wr_type']]." 신청이 완료되었습니다.";

					//$mb_receive = explode(",",$get_member['mb_receive']);	// 수신여부 무관
					//if(@in_array('sms',$mb_receive)){	 // 문자 수신 확인
					if($vals['wr_type']=='become'){	// 면접요청
						$mail_control->mail_seding('proposal_become',$get_member['mb_email'],"[".stripslashes($env['site_name'])."] 입사지원 요청 메일 입니다.","","","",$vals['wr_employ'], $vals['wr_resume'], $vals['mb_id'], $insert_no);
						$sms_control->send_sms_user('alba_online', $get_indi_member, "", $get_alba);
						//$sms_control->send_sms_user('alba_invitation', $get_member, "", $get_alba);
					} else if($vals['wr_type']=='interview'){	 // 입사지원
						$mail_control->mail_seding('proposal_meet',$get_member['mb_email'],"[".stripslashes($env['site_name'])."] 면접요청 메일 입니다.","","","",$vals['wr_employ'], $vals['wr_resume'], $vals['mb_id'], $insert_no);
						//$sms_control->send_sms_user('alba_interview', $get_member, "", $get_alba);
					}
				} else {
					$arr['msg'] = $netfu_mjob->proposal_arr[$vals['wr_type']]." 신청이 실패되었습니다.";
				}
			}
		}
		die(json_encode($arr));
		break;


// : 신고하기
	case "report_write":
		$arr['msg'] = "";
		$arr['move'] = "";

		// : 로그인체크
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}

		// : 정보불러오기
		switch($_POST['code']) {
			case "alba":
				$info = $alba_user_control->get_alba_no($_POST['no']);	// 정규직 정보
				$_table = "alice_alba";
				break;

			case "alba_resume":
				break;

			default:
				break;
		}

		// : 정보가 있는지 체크
		if(!$info['no']) $arr['msg'] = "정보가 존재하지 않습니다.";

		// : 신고 했는지 체크
		if($info['wr_report']) $arr['msg'] = "이미 신고된 정보입니다.";

		if(!$arr['msg']) {
			$report_no = $netfu_util->get_cate($_POST['report_no']);
			$report_content = $_POST['wr_report']=='self' ? $_POST['wr_report_content']: $report_no['name'];

			$q = "
			wr_report=1,
			wr_report_date='".$netfu_util->today_time."',
			wr_report_content='".$report_content."'
			";

			$update = sql_query("update ".$_table." set ".$q." where `no`='".addslashes($_POST['no'])."'");
			$arr['msg'] = "신고가 완료되었습니다.";
		}

		// : 리턴값
		die(json_encode($arr));
		break;



// : 선택 스크랩
	case "scrap_select":
		$arr = $netfu_member->login_check2($member['mb_id']);
		if(!$arr['msg']) {
			$nos = @implode(",", $_POST['chk']);
			if($nos) {
				$scrap_int = 0;
				foreach($_POST['chk'] as $k=>$v) {
					$_POST['no'] = $v;
					$_arr = $netfu_mjob->scrap_write();
					if($_arr['process']) $scrap_int++;
				}
				if($scrap_int) $arr['msg'] = "스크랩이 완료되었습니다.";
				else $arr['msg'] = "이미 스크랩한 정보입니다.";
			} else {
				$arr['msg'] = "스크랩할 정보를 선택해주시기 바랍니다.";
			}
		}
		die(json_encode($arr));
		break;


// : 스크랩하기
	case "scrap_write":
		$arr['msg'] = "";
		$arr['move'] = "";

		// : 로그인체크
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}
		// : 스크랩 했는지 체크
		$row = sql_fetch("select * from alice_scrap where `scrap_rel_table`='".addslashes($_POST['code'])."' and `scrap_rel_id`='".addslashes($_POST['no'])."' and `mb_id`='".$member['mb_id']."' limit 1");
		if($row) $arr['msg'] = "이미 스크랩을 했습니다.";

		// : 정보불러오기
		switch($_POST['code']) {
			case "alba":
				$info = $alba_user_control->get_alba_no($_POST['no']); // 정규직 정보
				if($member['mb_type']!='individual') $arr['mem_msg'] = "개인회원만 스크랩이 가능합니다.";
				break;

			case "alba_resume":
				$info = sql_fetch("select * from alice_alba_resume where `no`='".addslashes($_POST['no'])."'"); // 인재정보
				if($member['mb_type']!='company') $arr['mem_msg'] = "기업회원만 스크랩이 가능합니다.";
				break;

			default:
				break;
		}

		if(!$arr['msg']) $arr = $netfu_mjob->scrap_write();

		// : 리턴값
		die(json_encode($arr));
		break;



// : 신고하기
	case "report_write":
		$arr['msg'] = "";
		$arr['move'] = "";

		// : 로그인체크
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}

		$_table = $_POST['code']=='job' ? 'alice_alba' : 'alice_alba_resume';

		// : 신고 했는지 체크
		$row = sql_fetch("select * from ".$_table." where `no`='".addslashes($_POST['no'])."'");
		if($row['wr_report']==1) $arr['msg'] = "이미 신고했습니다.";

		if(!$arr['msg']) {
			$q = "
			wr_report=1,
			wr_report_date='',
			wr_report_content=''
			";
			$update = sql_query("update ".$_table." set ".$q." where `no`='".addslashes($_POST['no'])."'");
		}

		die(json_encode($arr));
		break;



##### : 면접제의 정보 가져오기
	case "get_receive_request":
		$arr['msg'] = "정보를 가져오는데 실패되었습니다.";
		$arr['move'] = "";

		if(!$_SESSION['sess_admin_uid'])
			$_where = ($member['mb_type']=='company') ? " and `mb_id`='".addslashes($member['mb_id'])."'" : " and `wr_id`='".addslashes($member['mb_id'])."'";
		$row = sql_fetch("select * from alice_resume_proposal where `no`='".addslashes($_POST['no'])."' {$_where}");
		if($row) {
			$c_row = sql_fetch("select * from alice_alba where `no`='".addslashes($row['wr_employ'])."'");
			if($c_row) {
				$row['company_name'] = $c_row['wr_company_name'];
				$arr = $row;
			} else {
				$arr['msg'] = "삭제된 채용정보입니다.";
			}
		}
		die(json_encode($arr));
		break;




#####################맞춤설정##################
	// : 기업, 개인 맞춤.
	case "setting_individual":
	case "setting_company":

		$arr['msg'] = "로그인하셔야 이용가능합니다.";
		$arr['move'] = NFE_URL."/include/login.php";

		if($member['mb_id']) {
			if($_POST['mode']=='setting_individual') {
				$_table = 'alice_alba_search';
			} else {
				$_table = 'alice_resume_search';
			}

			if($_POST['no']) {
				$_where = " and `wr_id`='".$member['mb_id']."'";
				$row = sql_fetch("select * from ".$_table." where `no`='".addslashes($_POST['no'])."' ".$_where);
			}

			$q = "
			wr_job_type0 = '".addslashes($_POST['wr_job_type0'])."',
			wr_job_type1 = '".addslashes($_POST['wr_job_type1'])."',
			wr_job_type2 = '".addslashes($_POST['wr_job_type2'])."',
			wr_job_type3 = '".addslashes($_POST['wr_job_type3'])."',
			wr_job_type4 = '".addslashes($_POST['wr_job_type4'])."',
			wr_job_type5 = '".addslashes($_POST['wr_job_type5'])."',
			wr_job_type6 = '".addslashes($_POST['wr_job_type6'])."',
			wr_job_type7 = '".addslashes($_POST['wr_job_type7'])."',
			wr_job_type8 = '".addslashes($_POST['wr_job_type8'])."',
			wr_area0 = '".addslashes($_POST['wr_area0'])."',
			wr_area1 = '".addslashes($_POST['wr_area1'])."',
			wr_area2 = '".addslashes($_POST['wr_area2'])."',
			wr_area3 = '".addslashes($_POST['wr_area3'])."',
			wr_area4 = '".addslashes($_POST['wr_area4'])."',
			wr_area5 = '".addslashes($_POST['wr_area5'])."',
			wr_date = '".addslashes($_POST['wr_date'])."',
			wr_week = '".addslashes($_POST['wr_week'])."',
			wr_gender = '".addslashes($_POST['wr_gender'])."',
			wr_age_limit = '".addslashes($_POST['wr_age_limit'])."',
			wr_age_etc = '".addslashes(@implode(',', $_POST['wr_age_etc']))."',
			wr_work_type = '".addslashes(@implode(',', $_POST['wr_work_type']))."',
			wr_email = '".intval($_POST['wr_email'])."',
			wr_sms = '".intval($_POST['wr_sms'])."',
			wdate = '".addslashes($now_date)."'
			";

			// : 개인이 맞춤할경우
			if($_POST['mode']=='setting_individual') {
				$q .= "
				, wr_stime = '".addslashes(@implode(":", $_POST['wr_stime']))."'
				, wr_etime = '".addslashes(@implode(":", $_POST['wr_etime']))."'
				, wr_time_conference = '".addslashes($_POST['wr_time_conference'])."'
				";
				if($_POST['wr_age_limit']) $q .= ", wr_age = '".$_POST['wr_sage']."-".$_POST['wr_eage']."'";

			// : 기업이 맞춤할경우
			} else {
				$q .= "
				, wr_home_work='".intval($_POST['wr_home_work'])."'
				, wr_time = '".addslashes($_POST['wr_time'])."'
				, wr_work_direct='".intval($_POST['wr_work_direct'])."'
				";
				if($_POST['wr_age_limit']) $q .= ", wr_age = '".$_POST['wr_sage']."'";
			}

			if($_POST['no'] && $member['mb_id']==$row['wr_id'])
				$query = sql_query("update ".$_table." set {$q} where `no`='".addslashes($_POST['no'])."' ".$_where);
			else {
				$q .= ", wr_id = '".$member['mb_id']."'";
				$query = sql_query("insert into ".$_table." set {$q}");
			}

			if($query) {
				$arr['msg'] = "저장이 완료되었습니다.";
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			}
		}

		$netfu_util->page_move($arr['msg'], $arr['move']);
		exit;

		break;

#####################맞춤설정 끝################





##################### 삭제 모음 ########################
	case "job_report_delete":
		$arr = $netfu_member->login_check2($member['mb_id']);
		if(!$arr['msg']) {
			$nos = @implode(",", $_POST['chk']);
			if($nos) {
				if(!$_SESSION['sess_admin_uid']) $_where = " and `wr_to_id`='".$member['mb_id']."'";
				$query = sql_query("select * from `alice_receive` where `no` in (".$nos.") ".$_where);
				while($row=sql_fetch_array($query)) {
					$r_uid = $row['wr_to_id'];
					$db->_query(" update alice_member set `mb_alba_count` = `mb_alba_count` -1 where `mb_id` = '".$r_uid."' ");
					
					$vals['is_delete'] = 1;	 // 삭제 처리
					$result = $receive_control->update_receive($vals, $row['no']);
				}
				$arr['msg'] = "삭제가 완료되었습니다.";
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			} else {
				$arr['msg'] = "삭제할 정보를 선택해주시기 바랍니다.";
			}
		}
		die(json_encode($arr));
		break;

	case "company_list_delete":
		$arr = $netfu_member->login_check2($member['mb_id']);
		if(!$arr['msg']) {
			$nos = @implode(",", $_POST['chk']);
			if($nos) {
				$_where = " and mb_id='".$member['mb_id']."'";
				$q = "select * from alice_member_company where `no` in (".$nos.") ".$_where;
				$query = sql_query($q);
				while($row=sql_fetch_array($query)) {
					$logo_path = NFE_PATH.'/data/member/'.$member['mb_id'].'/logo/';
					@unlink($logo_path.$row['mb_logo']);
					$delete = sql_query("delete from alice_member_company where `no`='".$row['no']."' and `mb_id`='".$member['mb_id']."'");
				}
				$arr['msg'] = "삭제가 완료되었습니다.";
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			} else {
				$arr['msg'] = "삭제할 담당자를 선택해주시기 바랍니다.";
				$arr['move'] = "";
			}
		}
		die(json_encode($arr));
		break;


	// : 담당자 삭제
	case "company_manager_delete":
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}

		if(!$arr['msg']) {
			$nos = @implode(",", $_POST['chk']);
			if($nos) {
				$_where = " and wr_id='".$member['mb_id']."'";
				$q = "select * from alice_company_manager where `no` in (".$nos.") ".$_where;
				$query = sql_query($q);
				while($row=sql_fetch_array($query)) {
					$delete = sql_query("delete from alice_company_manager where `no`='".$row['no']."' and `wr_id`='".$member['mb_id']."'");
				}
				$arr['msg'] = "삭제가 완료되었습니다.";
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			} else {
				$arr['msg'] = "삭제할 담당자를 선택해주시기 바랍니다.";
				$arr['move'] = "";
			}
		}
		die(json_encode($arr));
		break;


	// : 구인정보 삭제
	case "job_delete":
		if(!$member['mb_id']) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}

		if(!$arr['msg']) {
			$nos = @implode(",", $_POST['chk']);
			if($nos) {
				$_where = " and wr_id='".$member['mb_id']."'";
				$q = "select * from alice_alba where `no` in (".$nos.") ".$_where;
				$query = sql_query($q);
				while($row=sql_fetch_array($query)) {

					$user_control->user_count_update('mb_alba_count',$row['wr_id'], 1, '-'); // : 카운트 감소
					$user_control->user_photo_delete( $row['wr_id'], $row['no'] ); // : 이미지 삭제

					$delete = sql_query("delete from alice_alba where `no`='".$row['no']."' and `wr_id`='".$member['mb_id']."'");
				}
				$arr['msg'] = "삭제가 완료되었습니다.";
				$arr['move'] = $_SERVER['HTTP_REFERER'];
			} else {
				$arr['msg'] = "삭제할 구인정보를 선택해주시기 바랍니다.";
				$arr['move'] = "";
			}
		}
		die(json_encode($arr));
		break;

	case "resume_delete":
		$arr['msg'] = "삭제가 실패되었습니다.";
		$arr['move'] = "";
		$nos = addslashes(@implode(",", $_POST['chk']));
		if($nos) {
			if(!$_SESSION['sess_admin_uid'] || strpos($_SERVER['HTTP_REFERER'], "/nad/")===false)
				$_where = " and `wr_id`='".$member['mb_id']."'";
			$q = "select * from alice_alba_resume where `no` in (".$nos.") ".$_where;
			$query = sql_query($q);

			while($row=sql_fetch_array($query)) {
				if($row && $row['wr_id']==$member['mb_id']) {
					$delete = sql_query("delete from alice_alba_resume where `no`='".$row['no']."'");
				}
			}
			$arr['msg'] = "삭제가 완료되었습니다.";
			$arr['move'] = $_SERVER['HTTP_REFERER'];
		}
		die(json_encode($arr));
		break;




// : 입사지원 삭제
	case "receive_delete":
		$arr['msg'] = "삭제가 실패되었습니다.";
		$arr['move'] = "";
		$nos = addslashes(@implode(",", $_POST['chk']));
		if($nos) {
			if(!$_SESSION['sess_admin_uid'])
				$_where = in_array($member['kind'], array('company')) ? " and wr_to_id='".$member['mb_id']."'" : " and `wr_id`='".$member['mb_id']."'";

			$query = sql_query("select * from alice_receive where `no` in (".$nos.") ".$_where);
			while($row=sql_fetch_array($query)) {
				switch($member['kind']) {
					case 'company':
						$_set[] = "is_delete=1";
						//$qu = " update alice_member set `mb_alba_count` = `mb_alba_count` -1 where `mb_id` = '".$row['wr_to_id']."' ";
						$up_query = " update alice_alba set `wr_desire` = `wr_desire` - 1  where `no` = '".$row['wr_to']."' ";
						break;

					default:
						//$qu = " update alice_member set `mb_resume_count` = `mb_resume_count` -1 where `mb_id` = '".$row['wr_id']."' ";
						$up_query = " update alice_alba_resume set `wr_desire` = `wr_desire` - 1  where `no` = '".$row['wr_from']."' ";
						$_set[] = "is_delete_indi=1";
						break;
				}
				$set_put = @implode(", ", $_set);

				$q = "update alice_receive set {$set_put} where `no`='".$row['no']."'";
			}

			$arr['msg'] = "삭제가 완료되었습니다.";
			$arr['move'] = $_SERVER['HTTP_REFERER'];
		}
		die(json_encode($arr));
		break;



// : 입사지원요청/면접제의 삭제
	case "interview_delete":
		$arr = $netfu_member->login_check2($member['mb_id']);
		if(!$arr['msg']) {
			$nos = @implode("','", $_POST['chk']);
			if(!$_SESSION['sess_admin_uid']) $_where = " and `mb_id`='".addslashes($member['mb_id'])."'";
			$delete = sql_query("delete from alice_resume_proposal where `no` in ('".$nos."') ".$_where);
			$arr['msg'] = "삭제가 완료되었습니다.";
			$arr['move'] = $_SERVER['HTTP_REFERER'];
		}
		die(json_encode($arr));
		break;


// : 스크랩삭제
	case "scrap_delete":
		$arr['msg'] = "삭제가 실패되었습니다.";
		$arr['move'] = "";
		$nos = addslashes(@implode(",", $_POST['chk']));
		if($nos) {
			if(!$_SESSION['sess_admin_uid']) $_where = " and `mb_id`='".$member['mb_id']."'";
			$query = sql_query("delete from alice_scrap where `no` in (".$nos.") ".$_where);
			$arr['msg'] = "삭제가 완료되었습니다.";
			$arr['move'] = $_SERVER['HTTP_REFERER'];
		}
		die(json_encode($arr));
		break;

####################################################




	// : 결제시 포인트 체크
	case "member_point_check":
		$arr = $netfu_member->login_check2($member['mb_id']);
		if(!$arr['msg']) {
			$arr['msg'] = $member['mb_point']."p 이상 입력할 수 없습니다.";
			$arr['js'] = "form.use_point.value = '';";
			if(intval($member['mb_point'])>=intval($_POST['point'])) {
				$arr['msg'] = "";
				$arr['js'] = "";
			}
			$arr['js'] .= 'netfu_payment.money_click($("[name=\'service[]\']").eq(0)[0])';
		}
		die(json_encode($arr));
		break;

	default:

		switch($_GET['mode']) {

			// : 로그아웃
			case "logout":
				$result = $user_control->user_logout($_SESSION[$user_control->sess_user_val]);
				$utility->popup_msg_js("", NFE_URL.'/');
				break;
		}
		break;
}
?>