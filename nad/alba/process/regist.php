<?php
		/*
		* /application/nad/alba/process/regist.php
		* @author Harimao
		* @since 2013/10/18
		* @last update 2015/12/17
		* @Module v3.5 ( Alice )
		* @Brief :: Alba process
		* @Comment :: 알바 처리 프로세스
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];

		$mb_id = ($wr_input_type=='self') ? $_POST['wr_id'] : $_POST['mb_id'];

		$mb_no = $_POST['mb_no'];

		$no = $_POST['no'];

		$get_alba = $alba_control->get_alba($no);

		if($mode == 'insert' || $mode == 'load'){
			$wr_input_type = $_POST['wr_input_type'];	// 관리자 등록방법
			$wr_is_admin = 1;
		} else if( $mode == 'update'){
			$wr_is_admin = $get_alba['wr_is_admin'];
			$wr_input_type = ($wr_is_admin) ? $_POST['wr_input_type'] : $get_alba['input_type'];
		}

		switch($mode){

			case 'insert':			// 등록
			case 'update':		// 수정
			case 'load':			// 불러오기

				/* 담당자 정보 */
				$vals['wr_id'] = ($get_alba['wr_id']) ? $get_alba['wr_id'] : $mb_id;
				$vals['wr_open'] = 1;	// 자동으로 공개
				$vals['wr_person'] = $_POST['wr_person'];
				$vals['wr_phone'] = @implode($_POST['wr_phone'],'-');
				$vals['wr_hphone'] = @implode($_POST['wr_hphone'],'-');
				$vals['wr_fax'] = @implode($_POST['wr_fax'],'-');
				$vals['wr_email'] = @implode($_POST['wr_email'],'@');
				$vals['wr_page'] = ($_POST['wr_page']) ? $utility->add_http($_POST['wr_page']) : "";
				/* //담당자 정보 */

				$vals['wr_company'] = $_POST['company_info'];

				/* 업무내용 및 근무지정보 */
				$vals['wr_company_name'] = $_POST['wr_company_name'];
				$vals['wr_subject'] = $_POST['wr_subject'];
				
				$wr_job_type0 = $_POST['wr_job_type0'];
				$vals['wr_job_type0'] = $wr_job_type0;	 // 직종
				$vals['wr_job_type1'] = $_POST['wr_job_type1'];
				$vals['wr_job_type2'] = $_POST['wr_job_type2'];

				$wr_job_type3 = $_POST['wr_job_type3'];
				$vals['wr_job_type3'] = $wr_job_type3;	 // 직종
				$vals['wr_job_type4'] = $_POST['wr_job_type4'];
				$vals['wr_job_type5'] = $_POST['wr_job_type5'];

				$wr_job_type6 = $_POST['wr_job_type6'];
				$vals['wr_job_type6'] = $wr_job_type6;	 // 직종
				$vals['wr_job_type7'] = $_POST['wr_job_type7'];
				$vals['wr_job_type8'] = $_POST['wr_job_type8'];


				$is_adult_type = false;
				$is_type_0 = $category_control->code_is_adult_type($wr_job_type0);
				$is_adult_type = $is_type_0;
				$is_type_1 = $category_control->code_is_adult_type($wr_job_type3);
				$is_adult_type = ($is_type_1) ? $is_type_1 : $is_adult_type;
				$is_type_2 = $category_control->code_is_adult_type($wr_job_type6);
				$is_adult_type = ($is_type_2) ? $is_type_2 : $is_adult_type;
				$vals['wr_is_adult'] = $is_adult_type;	// 성인 카테고리 유무


				$vals['wr_beginner'] = ($_POST['wr_beginner']) ? $_POST['wr_beginner'] : 0;	 // 초보가능

				$vals['wr_area_company'] = $_POST['wr_area_company'];	// 근무지 주소 0 : 직접입력 / 1 : 기업정보 위치
				$vals['wr_area_point'] = $_POST['wr_area_point'];	// 근무지 주소 좌표
				$vals['wr_area'] = $_POST['wr_area'];	 // 근무지 주소

				$wr_area_0 = $_POST['wr_area_0'];
				$wr_area_0[3] = ($wr_area_0[3]=='Гудамжны дугаараа оруулна уу') ? "" : $wr_area_0[3];
				$vals['wr_area_0'] = ($wr_area_0[0]) ? @implode($wr_area_0,'/') : "";	// 근무지 주소 0

				$wr_area_1 = $_POST['wr_area_1'];
				$wr_area_1[3] = ($wr_area_1[3]=='Гудамжны дугаараа оруулна уу') ? "" : $wr_area_1[3];
				$vals['wr_area_1'] = ($wr_area_1[0]) ? @implode($wr_area_1,'/') : "";	// 근무지 주소 1

				$wr_area_2 = $_POST['wr_area_2'];
				$wr_area_2[3] = ($wr_area_2[3]=='Гудамжны дугаараа оруулна уу') ? "" : $wr_area_2[3];
				$vals['wr_area_2'] = ($wr_area_2[0]) ? @implode($wr_area_2,'/') : "";	// 근무지 주소 2

				$vals['wr_subway_area_0'] = $_POST['wr_subway_area_0'];				// 인근 지하철 지역 0
				$vals['wr_subway_line_0'] = $_POST['wr_subway_line_0'];				// 인근 지하철 호선 0
				$vals['wr_subway_station_0'] = $_POST['wr_subway_station_0'];		// 인근 지하철 역 0

				$wr_subway_content_0 = ($_POST['wr_subway_content_0']=='Гарах хугацаа, шаардлагатай цагийг оруулна уу.') ? "" : $_POST['wr_subway_content_0'];
				$vals['wr_subway_content_0'] = $wr_subway_content_0;					// 인근 지하철 출구,소요시간 0
				$vals['wr_subway_area_1'] = $_POST['wr_subway_area_1'];				// 인근 지하철 지역 1
				$vals['wr_subway_line_1'] = $_POST['wr_subway_line_1'];				// 인근 지하철 호선 1
				$vals['wr_subway_station_1'] = $_POST['wr_subway_station_1'];		// 인근 지하철 역 1

				$wr_subway_content_1 = ($_POST['wr_subway_content_1']=='Гарах хугацаа, шаардлагатай цагийг оруулна уу.') ? "" : $_POST['wr_subway_content_1'];
				$vals['wr_subway_content_1'] = $wr_subway_content_1;					// 인근 지하철 출구,소요시간 1
				$vals['wr_subway_area_2'] = $_POST['wr_subway_area_2'];				// 인근 지하철 지역 2
				$vals['wr_subway_line_2'] = $_POST['wr_subway_line_2'];				// 인근 지하철 호선 2
				$vals['wr_subway_station_2'] = $_POST['wr_subway_station_2'];		// 인근 지하철 역 2

				$wr_subway_content_2 = ($_POST['wr_subway_content_2']=='Гарах хугацаа, шаардлагатай цагийг оруулна уу.') ? "" : $_POST['wr_subway_content_2'];
				$vals['wr_subway_content_2'] = $wr_subway_content_2;					// 인근 지하철 출구,소요시간 2

				$vals['wr_college_area'] = $_POST['wr_college_area'];			// 대학 지역
				$vals['wr_college_vicinity'] = $_POST['wr_college_vicinity'];	// 인근대학

				$use_photo = $_POST['wr_use_photo'];	// 회사 이미지 사용 유무
				$vals['wr_use_photo'] = ($use_photo) ? $use_photo : 0;

				$vals['wr_date'] = $_POST['wr_date'];
				$vals['wr_week'] = $_POST['wr_week'];

				$time_conference = $_POST['wr_time_conference'];	 // 시간협의
				if(!$time_conference){	// 시간협의가 아닐때만
					$vals['wr_stime'] = @implode($_POST['wr_stime'],':');	// 근무 시작시간
					$vals['wr_etime'] = @implode($_POST['wr_etime'],':');	// 근무 종료시간
				}
				$vals['wr_time_conference'] = $time_conference;

				$vals['wr_pay_type'] = $_POST['wr_pay_type'];	// 급여조건
				$vals['wr_pay'] = str_replace(",","",$_POST['wr_pay']);		// 급여
				$vals['wr_pay_conference'] = $_POST['wr_pay_conference'];	// 협의가능 유무
				$vals['wr_pay_support'] = @implode($_POST['wr_pay_support'],',');	// 급여 지원 조건

				$vals['wr_work_type'] = @implode($_POST['wr_work_type'],',');	// 근무 형태

				$vals['wr_welfare_read'] = $_POST['welfare_read'];		// 복리후생 텍스트
				$vals['wr_welfare'] = serialize($_POST['wr_welfare']);	// 복리후생 체크 데이터
				/* //업무내용 및 근무지정보 */


				/* 지원 조건 */
				$vals['wr_gender'] = $_POST['wr_gender'];
				$age_limit = $_POST['wr_age_limit'];
				$vals['wr_age_limit'] = $age_limit;
				if($age_limit) {	// 연령제한이 있다면
					$vals['wr_age'] = $_POST['wr_sage'] . "-" . $_POST['wr_eage'];
				}
				$vals['wr_age_etc'] = @implode($_POST['wr_age_etc'],',');	// 연령 기타 정보

				$vals['wr_ability'] = $_POST['wr_ability'];	 // 학력

				$career_type = $_POST['wr_career_type'];
				$vals['wr_career_type'] = $career_type;	// 경력사항
				if($career_type == 2){	// 경력
					$vals['wr_career'] = $_POST['wr_career'];
				}

				$vals['wr_preferential'] = @implode($_POST['wr_preferential'],',');	 // 우대조건
				/* //지원 조건 */

				
				/* 모집내용 */
				$vals['wr_volume'] = ($_POST['wr_volume']) ? $_POST['wr_volume'] : "";	// 모집인원
				$vals['wr_volumes'] = @implode($_POST['wr_volumes'],',');	// 0, 00명
				$vals['wr_target'] = @implode($_POST['wr_target'],',');	// 모집 대상

				$volume_check = $_POST['volume_check'];	 // 모집종료일 종류 선택

				if($volume_check=='wr_volume_dates'){	 // 모집일 선택
					$vals['wr_volume_date'] = $_POST['wr_volume_date'];	 // 모집 종료일
					$vals['wr_volume_always'] = 0;
					$vals['wr_volume_end'] = 0;
				} else if($volume_check=='wr_volume_always'){	// 상시모집
					$vals['wr_volume_always'] = 1;
					$vals['wr_volume_end'] = 0;
				} else if($volume_check=='wr_volume_end'){	// 채용시까지
					$vals['wr_volume_always'] = 0;
					$vals['wr_volume_end'] = 1;
				}

				/*
				$volume_always = $_POST['wr_volume_always'];	 // 상시모집
				$volume_end = $_POST['wr_volume_end'];	 // 채용시까지
				$vals['wr_volume_always'] = $volume_always;
				$vals['wr_volume_end'] = $volume_end;

				if($volume_always || $volume_end)	 // 상시모집, 채용시까지 체크
					$vals['wr_volume_date'] = "";
				else
					$vals['wr_volume_date'] = $_POST['wr_volume_date'];	 // 모집 종료일
				*/

				$vals['wr_requisition'] = @implode($_POST['wr_requisition'],',');	// 접수방법
				$vals['wr_homepage'] = ($_POST['wr_homepage']) ? $utility->add_http($_POST['wr_homepage']) : "";	// 홈페이지 주소

				$wr_form = $_POST['wr_form'];	// 자사양식지원
				$vals['wr_form'] = $wr_form;
				if($wr_form){
					$vals['wr_form_required'] = $_POST['wr_form_required'];
				}

					/* 양식 파일 업로드 */
					$attach_path = $alice['data_alba_abs_path'] . '/' . $ym;
					@mkdir($attach_path, 0707);
					@chmod($attach_path, 0707);
					$file = $attach_path . "/index.html";
					if(!file_exists($file)){	// 디렉토리 보안을 위해서
						$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
					}
					$tmp_file	= $_FILES['wr_form_attach']['tmp_name'];
					$filename	= $_FILES['wr_form_attach']['name'];
					$filesize		= $_FILES['wr_form_attach']['size'];
					if(is_uploaded_file($tmp_file)){
						$file_extension = $alba_company_control->_file();	// 확장자 체크
						if(preg_match("/\.($file_extension)$/i", $filename)){ // 파일 확장자 체크
							if($mode=='update'){	 // 수정일때 업로드 파일이 있다면 기존 파일 삭제
								$form_attach = explode('/',$get_alba['wr_form_attach']);
								@unlink($attach_path . "/". $form_attach[1]);
							}
							$file_upload = $utility->file_upload($tmp_file, $filename, $attach_path, $_FILES);	// 파일 업로드
							$upload_file = $file_upload['upload_file'];
							$vals['wr_form_attach'] = $ym . "/" . $upload_file;
						}
					}
					/* //양식 파일 업로드 */

				$vals['wr_papers'] = @implode($_POST['wr_papers'],',');	// 제출서류
				$vals['wr_pre_question'] = $_POST['wr_pre_question'];		// 사전질문
				/* //모집내용 */

				$vals['wr_content'] = $_POST['wr_content'];		// 상세모집요강

				if($mode=='insert' || $mode=='load'){
					$vals['wr_wdate'] = $now_date; 
					$vals['wr_jdate'] = $now_date; 
				}

				$vals['wr_udate'] = $now_date;

				$vals['wr_is_admin'] = $wr_is_admin;	// 관리자 등록 공고
				$vals['input_type'] = $wr_input_type;	// 관리자입력방식

				$vals['etc_0'] = $_POST['mb_logo'];

		/*
		echo "<pre>";
		print_R($vals);
		exit;
		*/
				

				## 01. 알바공고 등록
				if($mode=='insert' || $mode=='load'){

					$result = $alba_control->alba_insert($vals);

					$last_no = $db->last_id();

					if($result){						 

						echo 'success';

					} else {

						echo 'error';

					}

				## 01. 알바 공고 수정
				} else if($mode=='update'){

					$result = $alba_company_control->alba_update($vals,$no);

					if($result){

						echo 'success';

					} else {

						echo 'error';

					}

				}

			break;

			## 알바 근무회사 이미지 등록
			case 'alba_photo_upload':                

			    $company_no = ($_POST['company_no']) ? $_POST['company_no'] : 0;
				$get_member = $member_control->get_member($mb_id);
				$alba_photos = $_POST['alba_photos'];


				$photo_table = "company";	// 작업 테이블

				// 디렉토리가 없는 경우 생성
				// 로고 및 회사 사진 저장 디렉토리
				//$photos_path = $alice['data_alba_abs_path'] . '/' . $ym;				
				$photos_path2 = $alice['data_member_abs_path'] . '/' . $mb_id ;				
				@mkdir($photos_path2, 0707);
				@chmod($photos_path2, 0707);

				$photos_path = $alice['data_member_abs_path'] . '/' . $mb_id . '/photos';
				@mkdir($photos_path, 0707);
				@chmod($photos_path, 0707);

				$file = $photos_path . "/index.html";
				if(!file_exists($file)){	// 디렉토리 보안을 위해서
					$f = fopen($file, "w"); fwrite($f, ""); fclose($f); chmod($file, 0606);
				}

				$tmp_file	= $_FILES['alba_photo_files']['tmp_name'];
				$filename	= $_FILES['alba_photo_files']['name'];
				$filesize		= $_FILES['alba_photo_files']['size'];

				$timg = @getimagesize($tmp_file);

				if($type=='load'){
					$no = 0;
				} else {
					$no = ($no) ? $no : 0; 
				}

				$photo_con = " and `data_no` = '".$no."' and `photo_no`='".$alba_photos."' and `photo_table` = 'company' ";					
				$photo_list = $user_control->member_photo_list($mb_id, $photo_con);

				if($photo_list){	// 사진 데이터가 있다면 alba_photos 를 기준으로 수정

					if(is_uploaded_file($tmp_file)){ 

						// 확장자 체크
						$img_extension = $user_control->_img();

						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
							$photo = $user_control->get_member_photo($mb_id,$alba_photos);
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
							$result = $user_control->user_photo_update($vals, $mb_id, $photo_table, $alba_photos); 

						} else {
							echo "extension_error";
							exit;
						}
					}

				} else {	 // 사진 데이터가 없다면 alba_photos 를 기준으로 입력						
	
					if(is_uploaded_file($tmp_file)){

						// 확장자 체크
						$img_extension = $user_control->_img();

						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크

							$vals['mb_type'] = $get_member['mb_type'];
							$vals['mb_id'] = $mb_id;
							$vals['company_no'] = $company_no; 
							$vals['data_no'] = $no; 
							$vals['photo_table'] = 'company';
							$vals['photo_no'] = $alba_photos;

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
				
				if($result){
					echo $ym."/".$upload_file."/".$mb_id;
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0029'));
					exit;
				}

			break;

			## 알바 공고 삭제 (단수)
			case 'delete':

				$result = $alba_control->alba_delete($no,$mb_id);

				echo $result;

			break;

			## 알바 공고 선택 삭제 (복수)
			case 'sel_delete':

				$nos = explode(',',$no);

				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result = $alba_control->alba_delete($nos[$i],$mb_id);
				}
			
				echo $result;

			break;

			## 신고 알바 복구 (단수)
			case 'recover':
				
				$vals['wr_report'] = 0;
				$vals['wr_report_date'] = "0000-00-00 00:00:00";
				$vals['wr_report_content'] = "";

				$result = $alba_company_control->alba_update($vals,$no);

				echo $result;

			break;

			## 신고 알바 복구 (복수)
			case 'sel_recover':

				$nos = explode(',',$no);

				$vals['wr_report'] = 0;
				$vals['wr_report_date'] = "0000-00-00 00:00:00";
				$vals['wr_report_content'] = "";

				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result = $alba_company_control->alba_update($vals,$nos[$i]);
				}
			
				echo $result;

			break;

			## 서비스승인
			case 'service':

				$no = $_POST['no'];	// 알바 공고 no

				$is_array = $_POST['is_array'];	// 배열로 넘어온 경우 '선택 서비스승인'

				if($is_array){

					$nos = explode(",",$no);
					$nos_cnt = count($nos);
					for($i=0;$i<$nos_cnt;$i++){

						$get_alba = $alba_control->get_alba($nos[$i]);
						$get_member = $member_control->get_member($get_alba['wr_id']);

						$pay_vals['pay_no'] = $nos[$i];
						$pay_vals['pay_oid'] = $utility->getOrderNumber(10);	 // 주문번호

						$pay_vals['pay_type'] = "alba";
						$pay_vals['pay_pg'] = "admin";	// 관리자가
						$pay_vals['pay_method'] = "service";	// 서비스로 준거
						$pay_vals['pay_uid'] = $get_member['mb_id'];
						$pay_vals['pay_name'] = $get_member['mb_name'];
						$pay_vals['pay_phone'] = ($get_member['mb_hphone']) ? $get_member['mb_hphone'] : $get_member['mb_phone'];
						$pay_vals['pay_email'] = $get_member['mb_email'];

						$pay_vals['pay_main_platinum_logo_effect'] = $_POST['platinum_logo_effect'];
						$pay_vals['pay_main_grand_logo_effect'] = $_POST['grand_logo_effect'];
						$pay_vals['pay_main_special_logo_effect'] = $_POST['special_logo_effect'];
						$pay_vals['pay_alba_platinum_logo_effect'] = $_POST['sub_platinum_logo_effect'];
						$pay_vals['pay_alba_option_neon_color'] = $_POST['alba_option_neon_sel'];
						$pay_vals['pay_alba_option_icon_sel'] = $_POST['alba_option_icon_sel'];
						$pay_vals['pay_alba_option_color_sel'] = $_POST['alba_option_color_sel'];

						$pay_vals['pay_wdate'] = $now_date;	// 서비스 등록일

						$result = $payment_control->insert_payment($pay_vals);

						$vals['wr_service_platinum'] = $_POST['wr_service_platinum'];
						$vals['wr_service_platinum_main_gold'] = $_POST['wr_service_platinum_main_gold'];
						$vals['wr_service_platinum_main_logo'] = $_POST['wr_service_platinum_main_logo'];

						$vals['wr_service_platinum_sub'] = $_POST['wr_service_platinum_sub'];
						$vals['wr_service_platinum_sub_gold'] = $_POST['wr_service_platinum_sub_gold'];
						$vals['wr_service_platinum_sub_logo'] = $_POST['wr_service_platinum_sub_logo'];

						$vals['wr_service_grand'] = $_POST['wr_service_grand'];
						$vals['wr_service_grand_main_gold'] = $_POST['wr_service_grand_main_gold'];
						$vals['wr_service_grand_main_logo'] = $_POST['wr_service_grand_main_logo'];

						$vals['wr_service_special'] = $_POST['wr_service_special'];
						$vals['wr_service_special_main_gold'] = $_POST['wr_service_special_main_gold'];
						$vals['wr_service_special_main_logo'] = $_POST['wr_service_special_main_logo'];					
					
						$vals['wr_service_basic'] = $_POST['wr_service_basic'];					

						$vals['wr_service_busy'] = $_POST['wr_service_busy'];
						$vals['wr_service_neon'] = $_POST['wr_service_neon'];
						$vals['wr_service_bold'] = $_POST['wr_service_bold'];
						$vals['wr_service_color'] = $_POST['wr_service_color'];
						$vals['wr_service_icon'] = $_POST['wr_service_icon'];
						$vals['wr_service_blink'] = $_POST['wr_service_blink'];

						// : 로고, 옵션값
						if(isset($_POST['platinum_logo_effect'])) $vals['wr_service_platinum_main_logo_val'] = $_POST['platinum_logo_effect'];
						if(isset($_POST['grand_logo_effect'])) $vals['wr_service_grand_main_logo_val'] = $_POST['grand_logo_effect'];
						if(isset($_POST['special_logo_effect'])) $vals['wr_service_special_main_logo_val'] = $_POST['special_logo_effect'];
						if($_POST['alba_option_neon_sel']) $vals['wr_service_neon_val'] = $_POST['alba_option_neon_sel'];
						if($_POST['alba_option_icon_sel']) $vals['wr_service_icon_val'] = $_POST['alba_option_icon_sel'];
						if($_POST['alba_option_color_sel']) $vals['wr_service_color_val'] = $_POST['alba_option_color_sel'];
						

						$vals['wr_oid'] = $pay_vals['pay_oid'];

						$result = $alba_control->alba_update($vals,$nos[$i]);

					}

				} else {

					$get_alba = $alba_control->get_alba($no);
					$get_member = $member_control->get_member($get_alba['wr_id']);

					$pay_vals['pay_no'] = $no;
					$pay_vals['pay_oid'] = $utility->getOrderNumber(10);	 // 주문번호

					$pay_vals['pay_type'] = "alba";
					$pay_vals['pay_pg'] = "admin";	// 관리자가
					$pay_vals['pay_method'] = "service";	// 서비스로 준거
					$pay_vals['pay_uid'] = $get_member['mb_id'];
					$pay_vals['pay_name'] = $get_member['mb_name'];
					$pay_vals['pay_phone'] = ($get_member['mb_hphone']) ? $get_member['mb_hphone'] : $get_member['mb_phone'];
					$pay_vals['pay_email'] = $get_member['mb_email'];

					$pay_vals['pay_main_platinum_logo_effect'] = $_POST['platinum_logo_effect'];
					$pay_vals['pay_main_special_logo_effect'] = $_POST['special_logo_effect'];
					$pay_vals['pay_main_grand_logo_effect'] = $_POST['grand_logo_effect'];
					$pay_vals['pay_alba_platinum_logo_effect'] = $_POST['sub_platinum_logo_effect'];
					$pay_vals['pay_alba_option_neon_color'] = $_POST['alba_option_neon_sel'];
					$pay_vals['pay_alba_option_icon_sel'] = $_POST['alba_option_icon_sel'];
					$pay_vals['pay_alba_option_color_sel'] = $_POST['alba_option_color_sel'];

					$pay_vals['pay_wdate'] = $now_date;	// 서비스 등록일

					$result = $payment_control->insert_payment($pay_vals);

					$vals['wr_service_platinum'] = $_POST['wr_service_platinum'];
					$vals['wr_service_platinum_main_gold'] = $_POST['wr_service_platinum_main_gold'];
					$vals['wr_service_platinum_main_logo'] = $_POST['wr_service_platinum_main_logo'];

					$vals['wr_service_grand'] = $_POST['wr_service_grand'];
					$vals['wr_service_grand_main_gold'] = $_POST['wr_service_grand_main_gold'];
					$vals['wr_service_grand_main_logo'] = $_POST['wr_service_grand_main_logo'];

					$vals['wr_service_special'] = $_POST['wr_service_special'];
					$vals['wr_service_special_main_gold'] = $_POST['wr_service_special_main_gold'];
					$vals['wr_service_special_main_logo'] = $_POST['wr_service_special_main_logo'];

					$vals['wr_service_basic'] = $_POST['wr_service_basic'];

					$vals['wr_service_busy'] = $_POST['wr_service_busy'];
					$vals['wr_service_neon'] = $_POST['wr_service_neon'];
					$vals['wr_service_bold'] = $_POST['wr_service_bold'];
					$vals['wr_service_color'] = $_POST['wr_service_color'];
					$vals['wr_service_icon'] = $_POST['wr_service_icon'];
					$vals['wr_service_blink'] = $_POST['wr_service_blink'];
					$vals['wr_service_jump'] = $_POST['wr_service_jump'];

					// : 로고, 옵션값
					if(isset($_POST['platinum_logo_effect'])) $vals['wr_service_platinum_main_logo_val'] = $_POST['platinum_logo_effect'];
					if(isset($_POST['grand_logo_effect'])) $vals['wr_service_grand_main_logo_val'] = $_POST['grand_logo_effect'];
					if(isset($_POST['special_logo_effect'])) $vals['wr_service_special_main_logo_val'] = $_POST['special_logo_effect'];
					if($_POST['alba_option_neon_sel']) $vals['wr_service_neon_val'] = $_POST['alba_option_neon_sel'];
					if($_POST['alba_option_icon_sel']) $vals['wr_service_icon_val'] = $_POST['alba_option_icon_sel'];
					if($_POST['alba_option_color_sel']) $vals['wr_service_color_val'] = $_POST['alba_option_color_sel'];

					$vals['wr_oid'] = $pay_vals['pay_oid'];

					$result = $alba_control->alba_update($vals,$no);

				}

                $is_referer = $_POST['is_referer'] ? $_POST['is_referer'] : '';				
				echo $result."@".$is_referer;

			break;

			## 업체 로고 등록
			case 'mb_logo_upload':

				if($no){
					$get_alba = $alba_control->get_alba($no);
					$wr_id = $get_alba['wr_id'];
				} else {
					$wr_id = $_POST['wr_id'];
				}
				
				/*
				if($no){
					$get_alba = $alba_control->get_alba($no);
					$wr_id = $get_alba['wr_id'];
				} else {
					$wr_id = $utility->get_unique_code('admin');
				}
				*/

				// 디렉토리가 없는 경우 생성
				// 로고 및 회사 사진 저장 디렉토리
				$logo_path = $alice['data_alba_abs_path'] . '/' . $ym;
				@mkdir($logo_path, 0707);
				@chmod($logo_path, 0707);
				$file = $logo_path . "/index.html";
				if(!file_exists($file)){	// 디렉토리 보안을 위해서
					$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
				}

				$tmp_file	= $_FILES['mb_logo_files']['tmp_name'];
				$filename	= $_FILES['mb_logo_files']['name'];
				$filesize		= $_FILES['mb_logo_files']['size'];

				$ext = $utility->get_extension($filename);

				if(is_uploaded_file($tmp_file)){

					// 사이즈 체크

					// 용량 체크 (관리자에서 설정한 용량)

					// 확장자 체크
					$img_extension = $user_control->_img();

					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크

						$file_upload = $utility->file_upload($tmp_file, $filename, $logo_path, $_FILES);	// 파일 업로드
						$upload_file = $file_upload['upload_file'];

						/*
						//$mb_logo = $wr_id . "." . $ext;
						$mb_logo = $wr_id;

						$dest_file = $logo_path . "/" . $mb_logo;
						
						$file_upload = move_uploaded_file($tmp_file, $dest_file);
						*/

					} else {
						echo "extension_error";
						exit;
					}

				}

				if($file_upload){
					echo $ym . "/" . $upload_file."@".$wr_id;
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0037'));
					exit;
				}

			break;

			## 입사지원 삭제 (단수)
			case 'become_delete':

				$vals['is_delete'] = 1;	 // 삭제 처리

				$result = $receive_control->update_receive($vals,$no);

				echo $result;

			break;

			## 입사지원 삭제 (복수)
			case 'become_sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$vals['is_delete'] = 1;	 // 삭제 처리
					$result = $receive_control->update_receive($vals,$nos[$i]);
				}

				echo $result;

			break;

			## 스크랩 삭제 (단수)
			case 'alba_scrap_delete':

				$result = $alba_user_control->scrap_delete($no);

				echo $result;

			break;

			## 스크랩 삭제 (복수)
			case 'alba_scrap_sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result = $alba_user_control->scrap_delete($nos[$i]);
				}

				echo $result;

			break;

			## 첨부파일 삭제 (단수)
			case 'alba_file_delete':

				$result = $alba_file_control->delete_file($no);

				echo $result;

			break;

			## 첨부파일 삭제 (복수)
			case 'alba_file_sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result = $alba_file_control->delete_file($nos[$i]);
				}

				echo $result;

			break;

		}	// switch end.
?>