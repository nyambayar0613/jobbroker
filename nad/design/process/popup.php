<?php
		/*
		* /application/nad/config/process/config.php
		* @author Harimao
		* @since 2013/06/12
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Site Environment Infomation
		* @Comment :: 사이트 기본환경설정 정보 입력
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$uid = $_POST['uid'];
		$no = $_POST['no'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		/* 팝업 이미지 저장 경로 */
		$save_dir = $alice['data_popup_path'] . '/' . $ym;
		if(!is_dir($save_dir)){
			@mkdir($save_dir, 0707); @chmod($save_dir, 0707);
		}
		$index_file = $save_dir . '/index.html';
		if(!file_exists($index_file)){	// 디렉토리 보안을 위해서
			$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);
		}
		/* //팝업 설정 이미지 저장 경로 */

		switch($mode){

			## 팝업 스킨 등록 / 수정
			case 'skin_insert':
			case 'skin_update':
			
				$vals['uid'] = $uid;
				$vals['skin_name'] = $_POST['skin_name'];
				$vals['subject_color'] = $_POST['subject_color'];
				$vals['border_size'] = $_POST['border_size'];
				$vals['border_color'] = $_POST['border_color'];

				/* 배경이미지 업로드 */
				$tmp_file	= $_FILES['bgimage_file']['tmp_name'];
				$filename	= $_FILES['bgimage_file']['name'];
				if(is_uploaded_file($tmp_file)){
					$img_extension = $popup_control->_file();
					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
						$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	 // 파일 업로드
						$vals['bgimage_file'] = $ym . '/' . $file_upload['upload_file'];	// 변수 할당
					} else {	
						if($ajax)
							$utility->popup_msg_ajax($popup_control->_errors('0000'));	// 팝업은 이미지만 업로드 가능합니다.
						else
							$utility->popup_msg_js($popup_control->_errors('0000'));	// 팝업은 이미지만 업로드 가능합니다.
					}
				}
				/* 배경이미지 업로드 */

				$vals['bgimage_pattern'] = $_POST['bgimage_pattern'];
				$vals['bgimage_position'] = $_POST['bgimage_position'];
				$vals['cookie_time'] = $_POST['cookie_time'];
				$vals['wdate'] = $now_date;

				// 팝업 스킨 등록
				if($mode=='skin_insert')
					$result = $popup_control->insert_popupSkin($vals);
				else if($mode=='skin_update')	// 수정
					$result = $popup_control->update_popupSkin($vals,  $no);

				echo $mode . '/' . $result;

			break;

			## 팝업 스킨 미리보기
			case 'skin_replace':

				$tmp_file	= $_FILES['bgimage_file']['tmp_name'];
				$filename	= $_FILES['bgimage_file']['name'];
				if(is_uploaded_file($tmp_file)){
					$img_extension = $popup_control->_file();
					@unlink($alice['tmp_path'] . '/' . $_POST['bgimage_file_tmp']);
					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
						$file_upload = $utility->file_upload($tmp_file, $filename, $alice['tmp_path'], $_FILES);	// 파일 업로드
						$bgimage_file = $file_upload['upload_file'];	// 변수 할당
					} else {
						if($ajax)
							$utility->popup_msg_ajax($popup_control->_errors('0000'));	// 팝업은 이미지만 업로드 가능합니다.
						else
							$utility->popup_msg_js($popup_control->_errors('0000'));	// 팝업은 이미지만 업로드 가능합니다.
					}
				}

				$border = ($_POST['border_size']) ? $_POST['border_size'] : 0;
				$background = "";
				if($bgimage_file){	// 배경 이미지를 업로드 했다면
					$background .= "background:";
					$background .= "url('../../".$alice['data']."/tmp/".$bgimage_file."') ".$_POST['bgimage_pattern']." ".$_POST['bgimage_position'];
					$background .= " #".$_POST['border_color'];
				} else {
					$background .= "background:#fff";
				}

				// 결과값
				echo $bgimage_file."||".$_POST['border_size']."||".$_POST['border_color']."||".$background."||".$_POST['cookie_time'];

			break;

			## 팝업 스킨 삭제
			case 'skin_delete':

				$result = $popup_control->delete_popupSkin($no);

				echo $result;

			break;

			## 팝업 등록
			case 'insert':

				if (substr_count($_POST['popup_content'], "&#") > 50) {
					echo '0052';	// 내용에 올바르지 않은 코드가 다수 포함되어 있습니다.
					exit;
				}
			
				$vals['uid'] = $uid;
				$vals['rank'] = $popup_control->get_MaxRank() + 1;
				$vals['popup_skin'] = $_POST['popup_skin'];
				$vals['popup_title'] = $_POST['popup_title'];
				$vals['popup_title_view'] = ($_POST['popup_title_view']) ? $_POST['popup_title_view'] : 0;
				$vals['popup_type'] = $_POST['popup_type'];
				$vals['popup_view'] = ($_POST['popup_view']) ? $_POST['popup_view'] : 0;
				$vals['popup_sub_view'] = ($_POST['popup_sub_view']) ? $_POST['popup_sub_view'] : 0;
				$vals['popup_width'] = $_POST['popup_width'];
				$vals['popup_height'] = $_POST['popup_height'];
				$vals['popup_top'] = $_POST['popup_top'];
				$vals['popup_left'] = $_POST['popup_left'];
				$vals['popup_begin'] = $_POST['popup_begin'];
				$vals['popup_end'] = $_POST['popup_end'];
				$vals['popup_unlimit'] = ($_POST['popup_unlimit']) ? $_POST['popup_unlimit'] : 0;
				$vals['popup_content'] = $_POST['popup_content'];
				$vals['wdate'] = $now_date;

				$result = $popup_control->insert_popup($vals);

				echo $mode . '/' . $result;

			break;

			## 팝업 수정
			case 'update':
			
				$vals['uid'] = $uid;
				$vals['popup_skin'] = $_POST['popup_skin'];
				$vals['popup_title'] = $_POST['popup_title'];
				$vals['popup_title_view'] = ($_POST['popup_title_view']) ? $_POST['popup_title_view'] : 0;
				$vals['popup_type'] = $_POST['popup_type'];
				$vals['popup_view'] = ($_POST['popup_view']) ? $_POST['popup_view'] : 0;
				$vals['popup_width'] = $_POST['popup_width'];
				$vals['popup_height'] = $_POST['popup_height'];
				$vals['popup_top'] = $_POST['popup_top'];
				$vals['popup_left'] = $_POST['popup_left'];
				$vals['popup_begin'] = $_POST['popup_begin'];
				$vals['popup_end'] = $_POST['popup_end'];
				$vals['popup_unlimit'] = ($_POST['popup_unlimit']) ? $_POST['popup_unlimit'] : 0;
				$vals['popup_content'] = $_POST['popup_content'];
				$vals['wdate'] = $now_date;

				$result = $popup_control->update_popup($vals,$no);

				echo $mode . '/' . $result;

			break;

			## 팝업 삭제(단수)
			case 'delete':

				$result = $popup_control->delete_noRank($no);

				echo $result;

			break;

			## 선택 삭제
			case 'sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){

					$result = $popup_control->delete_noRank($nos[$i]);

				}

				echo $result;

			break;

			## 순위조절
			case 'rank':

				// 순위조절 함수 호출
				$result = $popup_control->setRank($no, $next_no);

				echo $result;

			break;

			## 출력/미출력
			case 'views':

				$views = ($_POST['views']=='true') ? 1 : 0;

				$vals['popup_view'] = $views;

				$result = $popup_control->update_popup($vals, $no);

				echo $result;
				
			break;

			## 서브 페이지 출력/미출력
			case 'sub_views':

				$views = ($_POST['views']=='true') ? 1 : 0;

				$vals['popup_sub_view'] = $views;

				$result = $popup_control->update_popup($vals, $no);

				echo $result;
				
			break;

			## 선택 출력/미출력
			case 'sel_view':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				$vals['popup_view'] = ($_POST['views']=='yes') ? 1 : 0;

				for($i=0;$i<$no_cnt;$i++){

					$result = $popup_control->update_popup($vals,$nos[$i]);

				}

				echo $result;

			break;

		}
?>