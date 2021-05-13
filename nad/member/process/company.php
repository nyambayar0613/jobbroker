<?php
		/*
		* /application/nad/member/process/company.php
		* @author Harimao
		* @since 2014/08/12
		* @last update 2015/04/20
		* @Module v3.5 ( Alice )
		* @Brief :: Company process
		* @Comment :: 기업정보 데이터 처리
		*/

		$alice_path = "../../../";
		
		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];
		$mb_id = $_POST['mb_id'];


		// 디렉토리가 없는 경우 생성
		// 로고 및 회사 사진 저장 디렉토리
		$logo_path = $alice['data_member_abs_path'] . '/' . $mb_id . '/logo';
		@mkdir($logo_path, 0707);
		@chmod($logo_path, 0707);
		$file = $logo_path . "/index.html";
		if(!file_exists($file)){	// 디렉토리 보안을 위해서
			$f = @fopen($file, "w"); @fwrite($f, ""); @fclose($f); @chmod($file, 0606);
		}

		switch($mode){

			## 기업 정보 입력/수정
			case 'insert':
			case 'update':

				$vals['mb_id'] = $mb_id;
				$vals['mb_ceo_name'] = $_POST['mb_ceo_name'];
				$vals['mb_company_name'] = $_POST['mb_company_name'];
				$vals['mb_biz_type'] = $_POST['mb_biz_type'];
				$vals['mb_biz_no'] = @implode($_POST['mb_biz_no'],'-');
				$vals['mb_biz_phone'] = @implode($_POST['mb_phone'],'-');
				$vals['mb_biz_hphone'] = @implode($_POST['mb_hphone'],'-');

				$vals['mb_biz_zipcode'] = @implode($_POST['mb_zipcode'],'-');
				$vals['mb_biz_address0'] = $_POST['mb_address0'];
				$vals['mb_biz_address1'] = $_POST['mb_address1'];

				$vals['mb_biz_email'] = @implode($_POST['mb_email'],'@');
				$vals['mb_biz_fax'] = @implode($_POST['mb_biz_fax'],'-');
				$vals['mb_biz_success'] = $_POST['mb_biz_success'];
				$vals['mb_biz_form'] = $_POST['mb_biz_form'];
				$vals['mb_biz_content'] = $_POST['mb_biz_content'];
				$vals['mb_biz_foundation'] = $_POST['mb_biz_foundation'];
				$vals['mb_biz_member_count'] = $_POST['mb_biz_member_count'];
				$vals['mb_biz_stock'] = $_POST['mb_biz_stock'];
				$vals['mb_biz_sale'] = $_POST['mb_biz_sale'];
				$vals['mb_biz_vision'] = $_POST['mb_biz_vision'];
				$vals['mb_biz_result'] = $_POST['mb_biz_result'];

				$vals['mb_latlng'] = $_POST['mb_latlng'];
				$vals['mb_homepage'] = $_POST['mb_homepage'];

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
						@unlink($logo_path . "/" . $get_member['mb_logo']);	// 기존 파일 삭제
						$file_upload = $utility->file_upload($tmp_file, $filename, $logo_path, $_FILES);	// 파일 업로드
						$upload_file = $file_upload['upload_file'];
						$vals['mb_logo'] = $upload_file;	// 변수 할당
					}

				}

				$is_public = $_POST['is_public'];	// 대표 기업정보

				if($is_public){
					$upd_vals['is_public'] = 0;
					$user_control->company_user_update($upd_vals, $mb_id);
					$vals['is_public'] = 1;
				}


				if($mode=='insert'){
					$result = $user_control->company_user_regist($vals);
					
					$company_no = $db->last_id();

					$photo_con = " and `company_no` = '".$company_no."' and `photo_table` = 'company' ";
					$photo_list = $user_control->member_photo_list($mb_id, $photo_con);

					if($photo_list){	// 기존에 등록된 기업 이미지가 있다면

						for($i=0;$i<=4;$i++){
							$photos_name = explode("/",$_POST['photos_'.$i]);
							$photos_size = getimagesize("../".$_POST['photos_'.$i]);
							$photo_vals['mb_type'] = "company";
							$photo_vals['mb_id'] = $mb_id;
							$photo_vals['company_no'] = $company_no;
							$photo_vals['photo_name'] = $photos_name[5];
							$photo_vals['photo_filesize'] = filesize("../".$_POST['photos_'.$i]);
							$photo_vals['photo_width'] = $photos_size[0];
							$photo_vals['photo_height'] = $photos_size[1];
							$photo_vals['photo_type'] = $photos_size[2];
							$photo_vals['photo_datetime'] = $now_date;
							$user_control->user_photo_update($photo_vals, $mb_id, 'company', $i, " and `company_no` = '0' ");
						}

					} else {	 // 없다면 입력

						$photo_con = " and `company_no` = '0' and `photo_table` = 'company' ";
						$photo_list = $user_control->member_photo_list($mb_id, $photo_con);

						if($photo_list){	// 기업정보 업데이트

							for($i=0;$i<=4;$i++){
								$photo_vals['company_no'] = $company_no;
								$photo_vals['photo_datetime'] = $now_date;
								$user_control->user_photo_update($photo_vals, $mb_id, 'company', $i, " and `company_no` = '0' ");
							}

						} else {

							for($i=0;$i<=4;$i++){
								$photos_name = explode("/",$_POST['photos_'.$i]);
								$photos_size = getimagesize("../".$_POST['photos_'.$i]);
								$photo_vals['mb_type'] = "company";
								$photo_vals['mb_id'] = $mb_id;
								$photo_vals['company_no'] = $company_no;
								$photo_vals['photo_table'] = "company";
								$photo_vals['photo_no'] = $i;
								$photo_vals['photo_datetime'] = $now_date;
								$user_control->user_photo_insert($photo_vals);
							}

						}

					}

					$error_msg = $user_control->_errors('0048');

				} else if($mode=='update'){

					/*
					$result = $user_control->company_user_updateNo($vals,$no);
					for($i=0;$i<=4;$i++){
						$photos_name = explode("/",$_POST['photos_'.$i]);
						$photos_size = getimagesize($alice['data_member_path'] . "/" . $_POST['photos_'.$i]);
						$photo_vals['mb_type'] = "company";
						$photo_vals['mb_id'] = $mb_id;
						$photo_vals['company_no'] = $no;
						$photo_vals['photo_name'] = $photos_name[6];
						$photo_vals['photo_filesize'] = filesize($alice['data_member_path'] . "/" . $_POST['photos_'.$i]);
						$photo_vals['photo_width'] = $photos_size[0];
						$photo_vals['photo_height'] = $photos_size[1];
						$photo_vals['photo_type'] = $photos_size[2];
						$photo_vals['photo_datetime'] = $now_date;
						$user_control->user_photo_update($photo_vals, $mb_id, 'company', $i);
					}

					$error_msg = $user_control->_errors('0049');
					*/

					$result = $user_control->company_user_updateNo($vals,$no);

					$error_msg = $user_control->_errors('0049');

				}

				echo $result;

				/*
				if($result){
					$utility->popup_msg_js("","../company_info.php");
				} else {
					$utility->popup_msg_js($error_msg);
				}
				*/

			break;

			## 알바 근무회사 이미지 등록
			case 'photo_upload':

				$no = ($no) ? $no : 0;

				$get_member = $member_control->get_member($mb_id);
				$alba_photos = $_POST['alba_photos'];
				$mb_photos = $_POST['alba_photos'];

				$photo_table = "company";	// 작업 테이블

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

				$photo_con = " and `company_no` = '".$no."' and `photo_table` = 'company' ";
				$photo_list = $user_control->member_photo_list($mb_id, $photo_con);

				if($photo_list){	// 사진 데이터가 있다면 alba_photos 를 기준으로 수정

					$vals['company_no'] = $no;

					if(is_uploaded_file($tmp_file)){

						// 사이즈 체크

						// 용량 체크 (관리자에서 설정한 용량)

						// 확장자 체크
						$img_extension = $user_control->_img();

						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
							$photo = $user_control->get_member_photo($mb_id,$mb_photos," and `company_no` = '".$no."' ");
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
							$result = $user_control->user_photo_update($vals, $mb_id, 'company', $mb_photos, " and `company_no` = '".$no."' ");

						} else {
							echo "extension_error";
							exit;
						}
					}

				} else {	 // 사진 데이터가 없다면 alba_photos 를 기준으로 입력

					$vals['mb_type'] = $get_member['mb_type'];
					$vals['mb_id'] = $mb_id;
					$vals['company_no'] = $no;
					$vals['photo_table'] = 'company';

					for($i=0;$i<=4;$i++){
						$vals['photo_no'] = $i;
						if($i==$mb_photos){
							if(is_uploaded_file($tmp_file)){

								// 사이즈 체크

								// 용량 체크 (관리자에서 설정한 용량)

								// 확장자 체크
								$img_extension = $user_control->_img();

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

					}	// for end.

				}

				echo $mb_id . "/photos/" . $upload_file;

				/*
				if($result){
					echo $ym."/".$upload_file;
				} else {
					$utility->popup_msg_ajax($user_control->_errors('0029'));
					exit;
				}
				*/

			break;

			## 기업정보 추출
			case 'get_company_info':

				$company = $member_control->get_company_memberNo($no);	// no 기준

				$mb_id = $company['mb_id'];
				
				$result['company_name'] = $company['mb_company_name'];

				$wr_photo = $user_control->member_photo_list($mb_id," and `company_no` = '".$no."' ", " order by `photo_no` asc ");

				$photo_0_file = "../../../data/member/" . $mb_id . "/photos/" . $wr_photo[0]['photo_name'];
				$result['photo_0'] = (is_file($photo_0_file)) ? "../../data/member/" . $mb_id . "/photos/" . $wr_photo[0]['photo_name'] : "../../images/comn/no_profileimg.gif";

				$photo_1_file = "../../../data/member/" . $mb_id . "/photos/" . $wr_photo[1]['photo_name'];
				$result['photo_1'] = (is_file($photo_1_file)) ? "../../data/member/" . $mb_id . "/photos/" . $wr_photo[1]['photo_name'] : "../../images/comn/no_profileimg.gif";

				$photo_2_file = "../../../data/member/" . $mb_id . "/photos/" . $wr_photo[2]['photo_name'];
				$result['photo_2'] = (is_file($photo_2_file)) ? "../../data/member/" . $mb_id . "/photos/" . $wr_photo[2]['photo_name'] : "../../images/comn/no_profileimg.gif";

				$photo_3_file = "../../../data/member/" . $mb_id . "/photos/" . $wr_photo[3]['photo_name'];
				$result['photo_3'] = (is_file($photo_3_file)) ? "../../data/member/" . $mb_id . "/photos/" . $wr_photo[3]['photo_name'] : "../../images/comn/no_profileimg.gif";

				$photo_4_file = "../../../data/member/" . $mb_id . "/photos/" . $wr_photo[4]['photo_name'];
				$result['photo_4'] = (is_file($photo_4_file)) ? "../../data/member/" . $mb_id . "/photos/" . $wr_photo[4]['photo_name'] : "../../images/comn/no_profileimg.gif";
				
				//print_r($result);
				//print_r($company);

				echo json_encode($result);

			break;

			## 기업정보 삭제 (단수)
			case 'delete':
			
				$result = $member_control->delete_company_member($no);

				echo $result;

			break;

			## 기업정보 선택 삭제 (복수)
			case 'sel_delete':

				$nos = explode(',',$no);
				$nos_cnt = count($nos);

				for($i=0;$i<$nos_cnt;$i++){
					$result = $member_control->delete_company_member($nos[$i]);
				}

				echo $result;
			
			break;

		}	// switch end.
?>