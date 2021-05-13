<?php
		/*
		* /application/nad/alba/process/resume_regist.php
		* @author Harimao
		* @since 2013/10/22
		* @last update 2015/04/15
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Resume process
		* @Comment :: 알바 이력서 처리 프로세스
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$wr_input_type = $_POST['wr_input_type'];	// 관리자 등록방법

		$mb_id = ($wr_input_type=='self') ? $_POST['wr_id'] : $_POST['mb_id'];
		$no = $_POST['no'];

		$get_member = $member_control->get_member($mb_id);


		switch($mode){

			## 이력서 등록/수정/ 불러오기
			case 'insert':
			case 'update':
			case 'load':

				if($mode=='insert') $vals['wr_id'] = $mb_id;

				$vals['wr_open'] = $_POST['wr_open'];	// 공개 유무

				$wr_subject = $_POST['wr_subject'];
				$vals['wr_subject'] = $wr_subject;

				/* 근무지 */
				$vals['wr_area0'] = $_POST['wr_area0'];
				$vals['wr_area1'] = $_POST['wr_area1'];

				$vals['wr_area2'] = $_POST['wr_area2'];
				$vals['wr_area3'] = $_POST['wr_area3'];

				$vals['wr_area4'] = $_POST['wr_area4'];
				$vals['wr_area5'] = $_POST['wr_area5'];
				/* //근무지 */

				$vals['wr_home_work'] = $_POST['wr_home_work'];	// 재택가능

				/* 업직종 */
				$vals['wr_job_type0'] = $_POST['wr_job_type0'];
				$vals['wr_job_type1'] = $_POST['wr_job_type1'];
				$vals['wr_job_type2'] = $_POST['wr_job_type2'];

				$vals['wr_job_type3'] = $_POST['wr_job_type3'];
				$vals['wr_job_type4'] = $_POST['wr_job_type4'];
				$vals['wr_job_type5'] = $_POST['wr_job_type5'];

				$vals['wr_job_type6'] = $_POST['wr_job_type6'];
				$vals['wr_job_type7'] = $_POST['wr_job_type7'];
				$vals['wr_job_type8'] = $_POST['wr_job_type8'];
				/* //업직종 */

				$vals['wr_age'] = $member_control->get_age($get_member['mb_birth'], $get_member['mb_foreigner']);	// 나이
				$vals['wr_gender'] = $get_member['mb_gender'];	// 성별

				/* 근무일시 */
				$vals['wr_date'] = $_POST['wr_date'];			// 근무기간
				$vals['wr_week'] = $_POST['wr_week'];		// 근무요일
				$vals['wr_time'] = $_POST['wr_time'];			// 근무시간
				$vals['wr_work_direct'] = $_POST['wr_work_direct'];	// 즉시출근가능
				/* //근무일시 */

				/* 급여 */
				$vals['wr_pay_type'] = $_POST['wr_pay_type'];	// 급여조건
				$vals['wr_pay'] = str_replace(",","",$_POST['wr_pay']);	 // 급여금액
				$vals['wr_pay_conference'] = $_POST['wr_pay_conference'];	// 추후협의
				/* //급여 */

				$vals['wr_work_type'] = ($_POST['wr_work_type']) ? @implode($_POST['wr_work_type'],',') : "";	// 근무형태

				/* 학력사항 */
				$vals['wr_school_ability'] = $_POST['wr_school_ability'];			// 최종학력
				$vals['wr_school_absence'] = $_POST['wr_school_absence'];		// 휴학중
				$wr_school_type = $_POST['wr_school_type'];
				$wr_school_type_cnt = count($wr_school_type);
				$vals['wr_school_type'] = ($wr_school_type) ? @implode($wr_school_type,',') : "";	// 입력한 학력

				$vals['wr_high_school_name'] = ($_POST['wr_high_school_name']=='출신학교 선택') ? "" : $_POST['wr_high_school_name'];		// 출신 고등학교
				$vals['wr_high_school_syear'] = $_POST['wr_high_school_syear'];		// 고등학교 입학년도
				$vals['wr_high_school_eyear'] = $_POST['wr_high_school_eyear'];	// 고등학교 졸업년도
				$vals['wr_high_school_graduation'] = $_POST['wr_high_school_graduation'];	// 고등학교 졸업여부

					/* 대학(2,3년) 정보 */
					$wr_half = array();
					$wr_half['college'] = $_POST['wr_half_college'];
					$wr_half['college_specialize'] = $_POST['wr_half_college_specialize'];
					$wr_half['college_syear'] = $_POST['wr_half_college_syear'];
					$wr_half['college_eyear'] = $_POST['wr_half_college_eyear'];
					$wr_half['college_graduation'] = $_POST['wr_half_college_graduation'];

					$vals['wr_half_college'] = ($wr_half['college'][0] != '') ? serialize($wr_half) : "";	// 변수 할당
					/* //대학(2,3년) 정보 */
					
					/* 대학(4년) 정보 */
					$wr_college = array();
					$wr_college['college'] = $_POST['wr_college'];
					$wr_college['college_specialize'] = $_POST['wr_college_specialize'];
					$wr_college['college_syear'] = $_POST['wr_college_syear'];
					$wr_college['college_eyear'] = $_POST['wr_college_eyear'];
					$wr_college['college_graduation'] = $_POST['wr_college_graduation'];

					$vals['wr_college'] = ($wr_college['college'][0] != '') ? serialize($wr_college) : "";	// 변수 할당
					/* //대학(4년) 정보 */

					/* 대학원 정보 */
					$wr_graduate = array();
					$wr_graduate['graduate'] = $_POST['wr_graduate'];
					$wr_graduate['graduate_specialize'] = $_POST['wr_graduate_specialize'];
					$wr_graduate['graduate_grade'] = $_POST['wr_graduate_grade'];
					$wr_graduate['graduate_syear'] = $_POST['wr_graduate_syear'];
					$wr_graduate['graduate_eyear'] = $_POST['wr_graduate_eyear'];
					$wr_graduate['graduate_graduation'] = $_POST['wr_graduate_graduation'];

					$vals['wr_graduate'] = ($wr_graduate['graduate'][0] != '') ? serialize($wr_graduate) : "";	// 변수 할당
					/* //대학원 정보 */

					/* 대학원 이상 정보 */
					$wr_success = array();
					$wr_success['success'] = $_POST['wr_success'];
					$wr_success['success_specialize'] = $_POST['wr_success_specialize'];
					$wr_success['success_grade'] = $_POST['wr_success_grade'];
					$wr_success['success_syear'] = $_POST['wr_success_syear'];
					$wr_success['success_eyear'] = $_POST['wr_success_eyear'];
					$wr_success['success_graduation'] = $_POST['wr_success_graduation'];

					$vals['wr_success'] = ($wr_success['success'][0] !='' ) ? serialize($wr_success) : "";	// 변수 할당
					/* //대학원 이상 정보 */

				/* //학력사항 */

				/* 경력사항 */
				$wr_career_use = $_POST['wr_career_use'];
				$vals['wr_career_use'] = $wr_career_use;
				if($wr_career_use){	// 경력이 있다면
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

					$vals['wr_career'] = serialize($wr_career);	// 변수 할당
				}
				/* //경력사항 */

				/* 자격증 */
				$wr_license_use = $_POST['wr_license_use'];
				$vals['wr_license_use'] = $wr_license_use;
				if($wr_license_use){
					$wr_license = array();
					$wr_license_name = $_POST['wr_license_name'];
					$wr_license_name_cnt = count($wr_license_name);
					for($i=0;$i<$wr_license_name_cnt;$i++){
						$wr_license[$i]['name'] = $wr_license_name[$i];					// 자격증명
						$wr_license[$i]['public'] = $_POST['wr_license_public'][$i];	// 자격증 발행처
						$wr_license[$i]['year'] = $_POST['wr_license_year'][$i];		// 취득연도
					}

					$vals['wr_license'] = serialize($wr_license);	//  변수 할당
				}
				/* //자격증 */

				/* 외국어 */
				$wr_language_use = $_POST['wr_language_use'];
				$vals['wr_language_use'] = $wr_language_use;
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

					$vals['wr_language'] = serialize($wr_language);	// 변수 할당
				}
				/* //외국어 */

				$vals['wr_oa'] = ($_POST['wr_oa']) ? serialize($_POST['wr_oa']) : "";		// OA 능력
				$vals['wr_computer'] = ($_POST['wr_computer']) ? @implode($_POST['wr_computer'],',') : "";	// 컴퓨터능력

				$vals['wr_specialty'] = ($_POST['wr_specialty']) ? @implode($_POST['wr_specialty'],',') : "";		// 특기사항
				$wr_specialty_etc = ($_POST['wr_specialty_etc']) ? 1 : 0;
				$vals['wr_specialty_etc'] = $wr_specialty_etc ."//" . $_POST['wr_specialty_etc_val'];		// 기타 특기사항 내용 (직접 입력)

				$vals['wr_prime'] = $_POST['wr_prime'];				// 수상/수료 활동내역
				$vals['wr_introduce'] = $_POST['wr_introduce'];	// 자기소개서

				$wr_impediment_use = $_POST['wr_impediment_use'];			// 장애여부
				$vals['wr_impediment_use'] = $wr_impediment_use;
				if($wr_impediment_use){
					$vals['wr_impediment_level'] = $_POST['wr_impediment_level'];		// 장애 등급
					$vals['wr_impediment_name'] = $_POST['wr_impediment_name'];		// 장애 내용
				}

				$vals['wr_marriage'] = $_POST['wr_marriage'];	// 결혼여부

				$wr_military = $_POST['wr_military'];	// 병역여부
				$vals['wr_military'] = $wr_military;
				if($wr_military == 1){	// 군필
					$vals['wr_military_type'] = $_POST['wr_military_type'];
				}
				
				$vals['wr_preferential_use'] = $_POST['wr_preferential_use'];	// 국가보훈 대상자
				$vals['wr_treatment_use'] = $_POST['wr_treatment_use'];		// 고용지원금 대상자
				$vals['wr_treatment_service'] = ($_POST['wr_treatment_service']) ? @implode($_POST['wr_treatment_service'],',') : "";	// 고용지원금 대상자 분류

				$vals['wr_calltime'] = ($_POST['wr_calltime']) ? @implode($_POST['wr_calltime'],'-') : "";		// 통화가능시간
				$vals['wr_calltime_always'] = $_POST['wr_calltime_always'];		// 통화가능시간 (언제나 가능)

				//$vals['wr_hit'] = 1;
				$vals['wr_udate'] = $now_date;

				$vals['wr_is_admin'] = 1;	// 관리자 등록 공고
				$vals['input_type'] = $wr_input_type;	// 관리자입력방식

				$vals['etc_0'] = $_POST['mb_photo'];

				if($wr_input_type=='self'){	// 관리자 등록시 기본 회원 정보 등록
					$mb_vals['mb_type'] = 'individual';	// 개인회원
					$mb_vals['mb_id'] = $mb_id;
					$mb_vals['mb_name'] = $_POST['mb_name'];
					$mb_vals['mb_birth'] = $_POST['mb_birth_year'] . "-" . $_POST['mb_birth_month'] . "-" . $_POST['mb_birth_day'];
					$mb_vals['mb_gender'] = $_POST['mb_gender'];
					$mb_vals['mb_phone'] = @implode('-',$_POST['mb_phone']);
					$mb_vals['mb_hphone'] = @implode('-',$_POST['mb_hphone']);

					$new_address = $_POST['new_address'];
					$mb_vals['mb_address_road'] = $new_address;
					if($new_address){	// 도로명 주소 체크
						$mb_vals['mb_zipcode'] = @implode('-',$_POST['new_mb_zipcode']);
						$mb_vals['mb_address0'] = $_POST['new_mb_address0'];
						$mb_vals['mb_address1'] = $_POST['new_mb_address1'];
					} else {
						$mb_vals['mb_zipcode'] = @implode('-',$_POST['mb_zipcode']);
						$mb_vals['mb_address0'] = $_POST['mb_address0'];
						$mb_vals['mb_address1'] = $_POST['mb_address1'];
					}

					$mb_vals['mb_email'] = $_POST['mb_email'];
					$mb_vals['mb_wdate'] = ($mode=='insert') ? $now_date : $get_member['mb_wdate'];	 // 가입일
					$mb_vals['mb_udate'] = $now_date;	// 정보 수정일

					// 기본 디렉토리가 없는 경우 생성
					@mkdir($alice['data_member_abs_path'] . '/' . $mb_id, 0707);
					@chmod($alice['data_member_abs_path'] . '/' . $mb_id, 0707);
					$file = $alice['data_member_abs_path'] . '/' . $mb_id . '/index.html';
					if(!file_exists($file)){	// 디렉토리 보안을 위해서
						$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
					}
					
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
							$mb_vals['mb_photo'] = $upload_file;
						}

					}
						
					$mb_vals['is_admin'] = 1;
					$mb_vals['is_delete'] = 1;		// 삭제된 회원으로 저장
					$mb_vals['input_type'] = 1;	// 관리자 직접입력 회원
				}

				if($mode=='insert' || $mode=='load'){

					$vals['wr_wdate'] = $now_date;	 // 등록 시 등록날짜 업데이트

					if($wr_input_type=='self')	// 관리자 등록시 기본 회원 정보 등록
						$member_result = $member_control->insert_member($mb_vals);	// 회원 정보 등록

					## 01. 이력서 등록
					$result = $alba_resume_control->insert_resume($vals);

					$user_control->user_count_update('mb_alba_resume_count',$mb_id,1);


					if($result){

						$last_no = $db->last_id();

						echo 'success';

					} else {

						echo 'error';

					}


				} else if($mode=='update') {

					## 01. 이력서 수정
					$result = $alba_resume_control->update_resume($vals, $no);

					if($wr_input_type=='self')	// 관리자 등록시 기본 회원 정보 등록
						$member_result = $member_control->update_member($mb_vals,$mb_id);

					if($result){

						echo 'success';

					} else {

						echo 'error';

					}

				}

			break;

			## 이력서 삭제 (단수)
			case 'delete':

				$get_resume = $alba_resume_control->get_resume($no);

				$mb_id = $get_resume['wr_id'];

				$result = $alba_resume_control->delete_resume($no, $mb_id);

				echo $result;

			break;

			## 이력서 삭제 (복수)
			case 'sel_delete':

				$nos = explode(',',$no);

				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$get_resume = $alba_resume_control->get_resume($nos[$i]);
					$mb_id = $get_resume['wr_id'];
					$result = $alba_resume_control->delete_resume($nos[$i], $mb_id);
				}
			
				echo $result;

			break;

			## 서비스 등록
			case 'service':

				$no = $_POST['no'];	// 알바 공고 no

				$is_array = $_POST['is_array'];	// 배열로 넘어온 경우 '선택 서비스승인'

				if($is_array){

					$nos = explode(",",$no);
					$nos_cnt = count($nos);
					for($i=0;$i<$nos_cnt;$i++){

						$get_resume = $alba_resume_control->get_resume($nos[$i]);
						$get_member = $member_control->get_member($get_resume['wr_id']);

						$pay_vals['pay_no'] = $nos[$i];
						$pay_vals['pay_oid'] = $utility->getOrderNumber(10);	 // 주문번호
						$pay_vals['pay_type'] = "alba_resume";
						$pay_vals['pay_pg'] = "admin";	// 관리자가
						$pay_vals['pay_method'] = "service";	// 서비스로 준거
						$pay_vals['pay_uid'] = $get_member['mb_id'];
						$pay_vals['pay_name'] = $get_member['mb_name'];
						$pay_vals['pay_phone'] = ($get_member['mb_hphone']) ? $get_member['mb_hphone'] : $get_member['mb_phone'];
						$pay_vals['pay_email'] = $get_member['mb_email'];

						$pay_vals['pay_resume_option_neon_color'] = $_POST['resume_option_neon_sel'];
						$pay_vals['pay_resume_option_icon_sel'] = $_POST['resume_option_icon_sel'];
						$pay_vals['pay_resume_option_color_sel'] = $_POST['resume_option_color_sel'];

						$pay_vals['pay_wdate'] = $now_date;	// 서비스 등록일

						$result = $payment_control->insert_payment($pay_vals);

						$vals['wr_service_main_focus'] = $_POST['wr_service_main_focus'];
						$vals['wr_service_main_focus_gold'] = $_POST['wr_service_main_focus_gold'];
						$vals['wr_service_basic'] = $_POST['wr_service_basic'];

						$vals['wr_service_busy'] = $_POST['wr_service_busy'];
						$vals['wr_service_neon'] = $_POST['wr_service_neon'];
						$vals['wr_service_bold'] = $_POST['wr_service_bold'];
						$vals['wr_service_icon'] = $_POST['wr_service_icon'];
						$vals['wr_service_color'] = $_POST['wr_service_color'];
						$vals['wr_service_blink'] = $_POST['wr_service_blink'];

						if($_POST['resume_option_neon_sel']) $vals['wr_service_neon_val'] = $_POST['resume_option_neon_sel'];
						if($_POST['resume_option_icon_sel']) $vals['wr_service_icon_val'] = $_POST['resume_option_icon_sel'];
						if($_POST['resume_option_color_sel']) $vals['wr_service_color_val'] = $_POST['resume_option_color_sel'];

						$vals['wr_oid'] = $pay_vals['pay_oid'];

						$result = $alba_resume_control->update_resume($vals,$nos[$i]);

					}
					
				} else {

					$get_resume = $alba_resume_control->get_resume($no);
					$get_member = $member_control->get_member($get_resume['wr_id']);

					$pay_vals['pay_no'] = $no;
					$pay_vals['pay_oid'] = $utility->getOrderNumber(10);	 // 주문번호
					$pay_vals['pay_type'] = "alba_resume";
					$pay_vals['pay_pg'] = "admin";	// 관리자가
					$pay_vals['pay_method'] = "service";	// 서비스로 준거
					$pay_vals['pay_uid'] = $get_member['mb_id'];
					$pay_vals['pay_name'] = $get_member['mb_name'];
					$pay_vals['pay_phone'] = ($get_member['mb_hphone']) ? $get_member['mb_hphone'] : $get_member['mb_phone'];
					$pay_vals['pay_email'] = $get_member['mb_email'];

					$pay_vals['pay_resume_option_neon_color'] = $_POST['resume_option_neon_sel'];
					$pay_vals['pay_resume_option_icon_sel'] = $_POST['resume_option_icon_sel'];
					$pay_vals['pay_resume_option_color_sel'] = $_POST['resume_option_color_sel'];

					$pay_vals['pay_wdate'] = $now_date;	// 서비스 등록일

					$result = $payment_control->insert_payment($pay_vals);

					$vals['wr_service_main_focus'] = $_POST['wr_service_main_focus'];
					$vals['wr_service_main_focus_gold'] = $_POST['wr_service_main_focus_gold'];
					$vals['wr_service_basic'] = $_POST['wr_service_basic'];

					$vals['wr_service_busy'] = $_POST['wr_service_busy'];
					$vals['wr_service_neon'] = $_POST['wr_service_neon'];
					$vals['wr_service_bold'] = $_POST['wr_service_bold'];
					$vals['wr_service_icon'] = $_POST['wr_service_icon'];
					$vals['wr_service_color'] = $_POST['wr_service_color'];
					$vals['wr_service_blink'] = $_POST['wr_service_blink'];

					if($_POST['resume_option_neon_sel']) $vals['wr_service_neon_val'] = $_POST['resume_option_neon_sel'];
					if($_POST['resume_option_icon_sel']) $vals['wr_service_icon_val'] = $_POST['resume_option_icon_sel'];
					if($_POST['resume_option_color_sel']) $vals['wr_service_color_val'] = $_POST['resume_option_color_sel'];


					$vals['wr_oid'] = $pay_vals['pay_oid'];

					$result = $alba_resume_control->update_resume($vals,$no);

				}


                $is_referer = $_POST['is_referer'];				
				echo $result."@".$is_referer;


			break;

			## 신고 이력서 복구 (단수)
			case 'recover':

				$vals['wr_report'] = 0;
				$vals['wr_report_date'] = "0000-00-00 00:00:00";
				$vals['wr_report_content'] = "";

				$result = $alba_resume_control->update_resume($vals,$no);

				echo $result;

			break;

			## 신고 이력서 복구 (복수)
			case 'sel_recover':

				$nos = explode(',',$no);

				$vals['wr_report'] = 0;
				$vals['wr_report_date'] = "0000-00-00 00:00:00";
				$vals['wr_report_content'] = "";

				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result = $alba_resume_control->update_resume($vals,$nos[$i]);
				}
			
				echo $result;

			break;

			## 회원 사진 등록
			case 'mb_photo_upload':

				if($no){
					$get_resume = $alba_resume_control->get_resume($no);
					$wr_id = $get_resume['wr_id'];
				} else {
					$wr_id = $utility->get_unique_code('admin');
				}

				// 디렉토리가 없는 경우 생성
				// 로고 및 회사 사진 저장 디렉토리
				$photo_path = $alice['data_alba_abs_path'] . '/' . $ym;
				@mkdir($photo_path, 0707);
				@chmod($photo_path, 0707);
				$file = $photo_path . "/index.html";
				if(!file_exists($file)){	// 디렉토리 보안을 위해서
					$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
				}

				$tmp_file	= $_FILES['mb_photo_files']['tmp_name'];
				$filename	= $_FILES['mb_photo_files']['name'];
				$filesize		= $_FILES['mb_photo_files']['size'];

				$ext = $utility->get_extension($filename);

				if(is_uploaded_file($tmp_file)){

					// 사이즈 체크

					// 용량 체크 (관리자에서 설정한 용량)

					// 확장자 체크
					$img_extension = $user_control->_img();

					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크

						//$mb_photo = $wr_id . "." . $ext;
						$mb_photo = $wr_id;

						$dest_file = $photo_path . "/" . $mb_photo;
						
						$file_upload = move_uploaded_file($tmp_file, $dest_file);

					} else {
						echo "extension_error";
						exit;
					}

				}

				if($file_upload){
					echo $ym . "/" . $mb_photo."@".$wr_id;
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0037'));
					exit;
				}

			break;

		}	// switch end.

?>