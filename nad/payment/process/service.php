<?php
		/*
		* /application/nad/payment/process/service.php
		* @author Harimao
		* @since 2013/08/27
		* @last update 2015/04/07
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Gateway service config
		* @Comment :: 채용공고/이력서 결제 금액 설정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크


		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$uid = $_POST['uid'];
		$no = $_POST['no'];
		$type = $_POST['type'];

		$is_gold = $_POST['is_gold'];	// 골드 서비스 유무
		$is_logo = $_POST['is_logo'];	// 로고강조 서비스 유무

		switch($mode){

			## 서비스 기간 입력
			case 'insert':
				
				$vals['uid'] = $uid;
				if($is_gold) $types = $type . "_gold";
				else if($is_logo) $types = $type . "_logo";
				else $types = $type;
				$vals['type'] = $types;
				$vals['rank'] = $service_control->get_MaxRank($types) + 1;
				$vals['service_cnt'] = ($_POST['service_cnt']) ? $_POST['service_cnt'] : 0;
				$vals['service_unit'] = ($_POST['service_unit']) ? $_POST['service_unit'] : 0;
				$service_price = str_replace(",","",$_POST['service_price']);
				$vals['service_price'] = ($service_price) ? $service_price : 0;
				$vals['service_percent'] = ($_POST['service_percent']) ? $_POST['service_percent'] : 0;
				$vals['wdate'] = $vals['udate'] = $now_date;

				$vals['etc_0'] = $_POST['etc_0'];
				$vals['etc_1'] = $_POST['etc_1'];
				$vals['etc_2'] = $_POST['etc_2'];
				$vals['etc_3'] = $_POST['etc_3'];
				$vals['etc_4'] = $_POST['etc_4'];
				$vals['etc_5'] = $_POST['etc_5'];
				$vals['etc_6'] = $_POST['etc_6'];
				$vals['etc_7'] = $_POST['etc_7'];
				$vals['etc_8'] = $_POST['etc_8'];
				$vals['etc_9'] = $_POST['etc_9'];

				$result = $service_control->insert_service($vals);

				echo $result;

			break;

			## 서비스 기간 수정
			case 'update':

				$vals['uid'] = $uid;
				$vals['service_cnt'] = ($_POST['service_cnt']) ? $_POST['service_cnt'] : 0;
				$vals['service_unit'] = ($_POST['service_unit']) ? $_POST['service_unit'] : 0;
				$service_price = str_replace(",","",$_POST['service_price']);
				$vals['service_price'] = ($service_price) ? $service_price : 0;
				$vals['service_percent'] = ($_POST['service_percent']) ? $_POST['service_percent'] : 0;
				$vals['udate'] = $now_date;

				$vals['etc_0'] = $_POST['etc_0'];
				$vals['etc_1'] = $_POST['etc_1'];
				$vals['etc_2'] = $_POST['etc_2'];
				$vals['etc_3'] = $_POST['etc_3'];
				$vals['etc_4'] = $_POST['etc_4'];
				$vals['etc_5'] = $_POST['etc_5'];
				$vals['etc_6'] = $_POST['etc_6'];
				$vals['etc_7'] = $_POST['etc_7'];
				$vals['etc_8'] = $_POST['etc_8'];
				$vals['etc_9'] = $_POST['etc_9'];

				$result = $service_control->update_service($vals,$no);

				echo $result;

			break;

			## 리스트형 서비스 무료기간 설정
			/*
			case 'list_service':

				$vals['is_pay'] = $_POST['is_pay'];
				$vals['etc_0'] = $_POST['etc_0'] . " " . $_POST['etc_1'];

				$result = $service_control->update_service_check($vals, $no);

				echo $result;

			break;
			*/

			## 서비스 기간 삭제
			case 'delete':

				$result = $service_control->delete_noRank($no);

				echo $result;

			break;

			## 서비스별 유/무료 설정
			case 'pay_type':
			
				if($is_gold) $types = $type . "_gold";
				else if($is_logo) $types = $type . "_logo";
				else $types = $type;
				$is_pay = $_POST['is_pay'];

				$result = $service_control->service_check_updates($types,$is_pay);

				/* 디자인 출력 설정 */

					// 서비스별 출력 설정
					$design_arr = array( "main_platinum" => "main_platinum_use", "main_prime" => "main_prime_use", "main_grand" => "main_grand_use", "main_banner" => "main_banner_use", "main_list" => "main_list_use", "main_focus" => "main_focus_use", "alba_platinum" => "sub_platinum_use", "alba_banner" => "sub_banner_use", "alba_list" => "sub_list_use", "alba_resume_focus" => "sub_focus_use" );

					$_vals = $design_arr[$types];
					$design_vals[$_vals] = $is_pay;

					// 19금 출력 설정
					if($types=='main_platinum' || $types=='alba_platinum') {	// 19금 플래티넘
						$design_vals['adult_platinum_use'] = $is_pay;
					} else if($types=='main_prime') {	// 19금 프라임
						$design_vals['adult_prime_use'] = $is_pay;
					} else if($types=='main_grand') {	// 19금 그랜드
						$design_vals['adult_grand_use'] = $is_pay;
					} else if($types=='main_banner' || $types=='alba_banner') {	// 19금 배너형
						$design_vals['adult_banner_use'] = $is_pay;
					} else if($types=='main_list' || $types=='alba_list') {	// 19금 리스트형
						$design_vals['adult_list_use'] = $is_pay;
					}

					$result = $design_control->update_design($design_vals, 1);	 // 디자인 설정 update

				/* // 디자인 출력 설정 */

				echo $result;

			break;

			## 순위 조절
			case 'rank':

				// 순위조절 함수 호출
				$result = $service_control->setRank($type, $no, $next_no);

				echo $result;

			break;

			## 아이콘 순위 조절
			case 'icon_rank':

				// 순위조절 함수 호출
				$result = $category_control->setRank($type, $no, $next_no);

				echo $result;

			break;

			## 아이콘 업데이트
			case 'icon_update':

				$save_dir = $alice['data_icon_path'] . '/' . $ym;
				if(!is_dir($save_dir)){
					@mkdir($save_dir, 0707); @chmod($save_dir, 0707);
				}
				$index_file = $save_dir . '/index.html';
				if(!file_exists($index_file)){	// 디렉토리 보안을 위해서
					$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);
				}

				$service_name = $_POST['service_name'];

				switch($service_name){

					## 급구 아이콘
					case 'busy':

						$tmp_file	= $_FILES['busy_icon']['tmp_name'];
						$filename	= $_FILES['busy_icon']['name'];

						if(is_uploaded_file($tmp_file)){
							$icon_extension = $service_control->_icon();
							if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
								$timg = @getimagesize($tmp_file);
								$service_check = $service_control->service_check($type);
								$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
								@unlink($alice['data_icon_path']."/".$service_check['busy_icon']);	// 기존 아이콘 삭제
								$vals['busy_icon'] = $ym . "/" . $file_upload['upload_file'];	// 변수 할당
								$vals['udate'] = $now_date;
								$result = $service_control->service_check_update($vals,$type);
							} else {
								echo '0003';
								exit;
							}

							echo $type . "@" . $service_name . "@" . $vals['busy_icon'];

						}

					break;

					## 옵션 아이콘
					## 옵션 아이콘은 카테고리  테이블에 별도 저장한다.
					case 'icon':

						$icon_mode = $_POST['icon_mode'];

						$get_category = $category_control->get_category($no);	// 수정시 아이콘 정보 추출

						$tmp_file	= $_FILES['icon']['tmp_name'];
						$filename	= $_FILES['icon']['name'];

						if(is_uploaded_file($tmp_file)){
							$icon_extension = $service_control->_icon();
							if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
								$timg = @getimagesize($tmp_file);
								$service_check = $service_control->service_check($type);
								$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드								
								if($icon_mode=='update')	// 기존 아이콘 삭제
									@unlink($alice['data_icon_path'] . "/" . $get_category['name']);
								$vals['name'] = $ym . "/" . $file_upload['upload_file'];	 // 변수할당
							} else {
								echo '0003';
								exit;
							}

						}

						if($icon_mode=='insert'){ // 입력
							$vals['type'] = $type;
							$vals['code'] = $utility->get_unique_code();
							$get_LastRank = $category_control->get_MaxRank($type);	// rank 최대값 구함
							$vals['rank'] = $get_LastRank + 1;
							$vals['wdate'] = $now_date;
							$result = $category_control->insert_category($vals);
						} else {	// 수정
							$result = $category_control->update_category($vals,$no);
						}

						echo $result;

					break;
				}

			break;

			## 아이콘 삭제
			case 'icon_delete':

				$get_category = $category_control->get_category($no);

				@unlink($alice['data_icon_path'] . "/" . $get_category['name']);	// 파일 삭제

				$result = $category_control->delete_noRank($no,'service_icon');

				echo $result;

			break;

			## 강조효과 슬라이드 업데이트
			case 'slide_update':

				$service_name = $_POST['service_name'];

				$effect_use = $_POST['effect_use'];
				$effect_direction = $_POST['effect_direction'];

				$service_check = $service_control->service_check($service_name);

				$effect_info = explode('/',$service_check['effect']);
				if($type=='effect_use'){
					$vals['effect'] = $effect_use . '/' . $effect_info[1];
				}

				if($type=='effect_direction'){
					$vals['effect'] = $effect_info[0] . '/' . $effect_direction;
				}

				$vals['udate'] = $now_date;

				$result = $service_control->service_check_update($vals,$service_name);

				echo $result;

			break;

			## 형광펜 색상 설정
			case 'color_update':

				$service_name = $_POST['service_name'];
				$sel_field = ($_POST['service_name']=='color') ? "font_color" : $service_name."_color";

				$sel_color = $_POST[$sel_field];
				$sel_color_cnt = count($sel_color);
				$sel_colors = array();
				for($i=0;$i<$sel_color_cnt;$i++){
					if($sel_color[$i] == '') { break; }
					if($sel_color[$i]!='000000'){
						$sel_colors[$i] = $sel_color[$i];
					}
				}

				$vals[$sel_field] = @implode('/',$sel_colors);
				$vals['udate'] = $now_date;

				$result = $service_control->service_check_update($vals,$type);

				echo $result;

			break;
		}

?>