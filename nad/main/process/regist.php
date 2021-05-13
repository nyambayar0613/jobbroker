<?php
		/*
		* /application/nad/main/process/regist.php
		* @author Harimao
		* @since 2012/11/07
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Quick menu regist
		* @Comment :: 퀵 메뉴 등록/수정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		if(!$is_admin)	{ // 관리자 체크
			echo '0006';
			exit;
		}

		$ajax = $_POST['ajax'];
		$mode = $_POST['mode'];
		$uid = $_POST['uid'];
		

		$result = array();	// 최종 결과값

		switch($mode){

			## 퀵 메뉴 수정
			case 'quick_update':

				$menu_code = $_POST['menu_code'];
				$menu_code_cnt = count($menu_code);

				// 퀵메뉴 초기화
				$db->_query("TRUNCATE TABLE `".$quick_control->quick_table."`");

				for($i=0;$i<$menu_code_cnt;$i++){
					$menus = explode('@',$menu_code[$i]);
					$menu_codes = explode('/',$menus[0]);
					$top_menus = explode(':',$menu_codes[0]);
					$top_menu_code = $top_menus[0];
					$top_menu_name = $top_menus[1];
					$middle_menus = explode(':',$menu_codes[1]);
					$middle_menu_code = $middle_menus[0];
					$middle_menu_name = $middle_menus[1];
					$sub_menus = explode(':',$menu_codes[2]);
					$sub_menu_code = $sub_menus[0];
					$sub_menu_name = $sub_menus[1];
										
					//$duplication_check = $quick_control->duplication_quick($uid, $top_menu_code,$middle_menu_code, $sub_menu_code);
					
					//if(!$duplication_check){	// 중복되지 않을때만
						
						$vals['uid'] = $uid;
						$vals['top_menu'] = $top_menu_name;
						$vals['top_menu_code'] = $top_menu_code;
						$vals['middle_menu'] = $middle_menu_name;
						$vals['middle_menu_code'] = $middle_menu_code;
						$vals['sub_menu'] = $sub_menu_name;
						$vals['sub_menu_code'] = $sub_menu_code;
						$vals['url'] = $menus[1];
						$vals['wdate'] = $now_date;

						$result['result'] = $quick_control->quick_insert($vals);

					//}

				}

			break;

			## 모바일웹 설정
			case 'mobile_update':

				$vals['uid'] = $_POST['uid'];
				$vals['mobile_use'] = $_POST['mobile_use'];
				$vals['mobile_url'] = $_POST['mobile_url'];
				$vals['mobile_name'] = $_POST['mobile_name'];
				$vals['mobile_color'] = $_POST['mobile_color'];
				$vals['mobile_copy'] = $_POST['mobile_copy'];
				$vals['wdate'] = $now_date;
	
				for($i=0;$i<=9;$i++){
					$vals['etc_'.$i] = $_POST['etc_'.$i];
				}

				// 기본은 무조건 no 값이 1이다
				$result['result'] = $mobile_control->mobile_update($vals, 1);

			break;

			## 모바일웹 로고 등록
			case 'mobile_logo':

				$tmp_file	= $_FILES['mobile_logo']['tmp_name'];
				$filename	= $_FILES['mobile_logo']['name'];

				if(is_uploaded_file($tmp_file)){

					$img_extension = $config->_img();

					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크

						// 기존 로고 삭제
						//@unlink($alice['data_logo_path'] . "/" . $logo[$type]);
						
						// 파일 업로드
						$file_upload = $utility->file_upload($tmp_file, $filename, $alice['data_logo_path'], $_FILES);

						// 변수 할당
						$vals['mobile_logo'] = $file_upload['upload_file'];
						$vals['wdate'] = $now_date;
						
						$update_result = $mobile_control->mobile_update($vals, 1);

						$result['result'] = ($update_result) ? $file_upload['upload_file'] : "";
						
					} else {
						
						$utility->popup_msg_ajax($config->_errors('0021'));

					}

				}

			break;

		}

		$result['mode'] = $mode;	// 모드값

		echo @implode('/',$result);

?>