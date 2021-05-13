<?php
		/*
		* /application/nad/config/process/config.php
		* @author Harimao
		* @since 2013/05/24
		* @last update 2015/03/12
		* @Module v3.5 ( Alice )
		* @Brief :: Site Environment Infomation
		* @Comment :: 사이트 기본환경설정 정보 입력
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크
	
		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$uid = $_POST['uid'];
		$no = $_POST['no'];

		switch($mode){

			## 사이트 기본환경설정
			case 'config_update':
				
				$vals['uid'] = $uid;
				$vals['site_title'] = $_POST['site_title'];
				$vals['site_name'] = $_POST['site_name'];
				$vals['site_nick'] = $_POST['site_nick'];
				$vals['site_english'] = $_POST['site_english'];
				$vals['favorite_title'] = $_POST['favorite_title'];
				$vals['email'] = $_POST['email'];

				$vals['call_center_use'] = $_POST['call_center_use'];
				$vals['call_center'] = $_POST['call_center'];
				$vals['call_time'] = $_POST['call_time'];

				$vals['pay_view'] = ($_POST['pay_view']) ? $_POST['pay_view'] : 0;
				$vals['pay_year'] = $_POST['pay_year'];
				$vals['time_pay'] = $_POST['time_pay'];

				$vals['use_digital'] = $_POST['use_digital'];
				$vals['digital_content'] = $_POST['digital_content'];

				$vals['hphone'] = $_POST['hphone'];
				$vals['login_return'] = $_POST['login_return'];
				$vals['login_return_page'] = $_POST['login_return_page'];
				$vals['session_time'] = $_POST['session_time'];
				/*
				$vals['use_point'] = $_POST['use_point'];
				$vals['auto_level'] = $_POST['auto_level'];
				$vals['register_level'] = $_POST['register_level'];
				$vals['login_point'] = $_POST['login_point'];
				$vals['employ_point'] = $_POST['employ_point'];
				$vals['individual_point'] = $_POST['individual_point'];
				$vals['employ_read_point'] = $_POST['employ_read_point'];
				$vals['individual_read_point'] = $_POST['individual_read_point'];
				*/
				$vals['member_group'] = $_POST['member_group'];
				$vals['article_denied'] = $_POST['article_denied'];
				$vals['notice_main_count'] = $_POST['notice_main_count'];
				$vals['notice_side_count'] = $_POST['notice_side_count'];
				$vals['under_construction'] = $_POST['under_construction'];
				$vals['rss_feed'] = $_POST['rss_feed'];
				$vals['sns_feed'] = @implode($_POST['sns_feed'],',');
				$vals['kakao_key'] = $_POST['kakao_key'];
				$vals['facebook_appid'] = $_POST['facebook_appid'];
				$vals['facebook_secret'] = $_POST['facebook_secret'];
				$vals['twitter_key'] = $_POST['twitter_key'];
				$vals['twitter_secret'] = $_POST['twitter_secret'];
				$vals['meta_author'] = $_POST['meta_author'];
				$vals['meta_description'] = $_POST['meta_description'];
				$vals['meta_copyright'] = $_POST['meta_copyright'];
				$vals['meta_keywords'] = $_POST['meta_keywords'];
				$vals['meta_classifiction'] = $_POST['meta_classifiction'];
				$vals['meta_publisher'] = $_POST['meta_publisher'];

				// 구글 통계정보
				$vals['google_id'] = $_POST['google_id'];
				$vals['google_pass'] = $_POST['google_pass'];
				$vals['google_profile_id'] = $_POST['google_profile_id'];
				$vals['google_scripts'] = $_POST['google_scripts'];

				/* 관리자 설정 이미지 저장 경로 */
				$save_dir = $alice['peg_path'] . '/' . $ym;
				if(!is_dir($save_dir)){
					@mkdir($save_dir, 0707); @chmod($save_dir, 0707);
				}
				$index_file = $save_dir . '/index.html';
				if(!file_exists($index_file)){	// 디렉토리 보안을 위해서
					$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);
				}
				/* //관리자 설정 이미지 저장 경로 */

				/* 파비콘 업로드 */
				$tmp_file	= $_FILES['favicon']['tmp_name'];
				$filename	= $_FILES['favicon']['name'];
				if(is_uploaded_file($tmp_file)){
					if(preg_match("/\.(ico)$/i", $filename)){ // 파일 .ico 확장자 체크
						@unlink($save_dir . '/' . $env['favicon']); // 기존 파비콘 삭제
						$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
						$vals['favicon'] = $ym . '/' . $file_upload['upload_file'];	// 변수 할당
					} else {
						if($ajax)
							$utility->popup_msg_ajax($config->_errors('0051'));		// 파비콘 확장자를 확인해 주세요.\\n\\n파비콘 등록시 파일 확장자는 ( .ico ) 입니다.
						else
							$utility->popup_msg_js($config->_errors('0051'));
					}
				}
				/* //파비콘 업로드 */

				$vals['cs_type'] = $_POST['cs_type'];	// 고객센터 타입

				/* 고객센터 이미지 업로드 */
				// 메인 페이지 고객센터 1
				$tmp_file	= $_FILES['call_time_main_1']['tmp_name'];
				$filename	= $_FILES['call_time_main_1']['name'];
				if(is_uploaded_file($tmp_file)){
					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
						@unlink($save_dir . '/' . $env['call_time_main_1']);	// 기존 파비콘 삭제
						$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
						$vals['call_time_main_1'] = $ym . '/' . $file_upload['upload_file'];	// 변수 할당
					} else {
						if($ajax)
							$utility->popup_msg_ajax($config->_errors('0024'));	// 이미지만 업로드 가능합니다.
						else
							$utility->popup_msg_js($config->_errors('0024'));
					}
				}
				// 메인 페이지 고객센터 2
				$tmp_file	= $_FILES['call_time_main_2']['tmp_name'];
				$filename	= $_FILES['call_time_main_2']['name'];
				if(is_uploaded_file($tmp_file)){
					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
						@unlink($save_dir . '/' . $env['call_time_main_2']);	// 기존 파비콘 삭제
						$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
						$vals['call_time_main_2'] = $ym . '/' . $file_upload['upload_file'];	// 변수 할당
					} else {
						if($ajax)
							$utility->popup_msg_ajax($config->_errors('0024'));	// 이미지만 업로드 가능합니다.
						else
							$utility->popup_msg_js($config->_errors('0024'));
					}
				}
				$tmp_file	= $_FILES['call_time_image']['tmp_name'];
				$filename	= $_FILES['call_time_image']['name'];
				if(is_uploaded_file($tmp_file)){
					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
						@unlink($save_dir . '/' . $env['call_time_image']);	// 기존 파비콘 삭제
						$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
						$vals['call_time_image'] = $ym . '/' . $file_upload['upload_file'];	// 변수 할당
					} else {
						if($ajax)
							$utility->popup_msg_ajax($config->_errors('0024'));	// 이미지만 업로드 가능합니다.
						else
							$utility->popup_msg_js($config->_errors('0024'));
					}
				}
				/* //고객센터 이미지 업로드 */

				$vals['file_size'] = $_POST['file_size'];					// 파일 업로드 제한용량
				$vals['profile_size'] = $_POST['profile_size'];		// 프로필 사진 업로드 제한용량
				$vals['use_direct'] = $_POST['use_direct'];			// 다이렉트 결제 사용유무
				$vals['use_ipin'] = $_POST['use_ipin'];					// 아이핀 사용유무
				$vals['ipin_id'] = $_POST['ipin_id'];						// 아이핀 id
				$vals['ipin_pw'] = $_POST['ipin_pw'];					// 아이핀 pw
				$vals['use_hphone'] = $_POST['use_hphone'];		// 휴대폰 인증 사용유무
				$vals['hphone_id'] = $_POST['hphone_id'];			// 휴대폰 인증 id
				$vals['hphone_pw'] = $_POST['hphone_pw'];		// 휴대폰 인증 pw
				$vals['use_adult'] = $_POST['use_adult'];				// 성인 인증 사용유무
				$vals['use_adult_all'] = $_POST['use_adult_all'];	// 성인 인증 설정 (모두 사용인가 / 성인인증 카테고리만 사용하는가)
				$vals['register_form'] = $_POST['register_form'];	// 내/외국인 설정
				$vals['wdate'] = $now_date;

				$result = $config_control->config_update($vals, $no);

			break;

			## 지도 설정
			case 'map_update':

				sql_query("update alice_design set `map_use`='".addslashes($_POST['map_use'])."'");
			
				$vals['use_map'] = $_POST['use_map'];
				$vals['daum_map_key'] = $_POST['daum_map_key'];
				$vals['daum_local_key'] = $_POST['daum_local_key'];
				$vals['naver_map_key'] = $_POST['naver_map_key'];
				$vals['google_map_key'] = $_POST['google_map_key'];

				$result = $config_control->config_update($vals, $no);

				echo $result;
				exit;

			break;

			## 내/외국인 설정
			case 'register_form':
				
				$vals['register_form'] = $_POST['register'];

				$result = $config_control->config_update($vals, $no);

				echo $result;
				exit;

			break;

			## 검색어 출력설정
			case 'search':

				$vals['search'] = $_POST['search'];

				$result = $config_control->config_update($vals, $no);

				echo $_POST['search']."/".$result;
				exit;
			
			break;


			## 기타 (사이트소개, 이용약관, 게시판관리기준, 개인정보취급방침, 이메일무단수집거부, 사이트하단, 메일하단)
			default :


				if (substr_count($_POST[$mode], "&#") > 50) {
					if($ajax)
						$utility->popup_msg_ajax($config->_errors('0034'));	// 내용에 올바르지 않은 코드가 다수 포함되어 있습니다.
					else
						$utility->popup_msg_js($config->_errors('0034'));
					exit;
				}

				$vals[$mode] = $_POST[$mode];
				$vals[$mode."_date"] = $now_date;

				$result = $config_control->config_update($vals, $no);

			break;

		}	// switch end.

		if($result)
			echo '0002';
		else
			echo '0005';

?>