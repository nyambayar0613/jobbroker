<?php
		/*
		* /application/nad/design/process/logo.php
		* @author Harimao
		* @since 2013/06/14
		* @last update 2015/03/24
		* @Module v3.5 ( Alice )
		* @Brief :: Site Logo Setting
		* @Comment :: 사이트 로고설정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";
		
		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$type = $_POST['type'];
		$uid = $_POST['uid'];
		$no = $_POST['no'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		/* 로고 저장 경로 */
		$save_dir = $alice['data_logo_path'] . '/' . $ym;
		if(!is_dir($save_dir)){
			@mkdir($save_dir, 0707); @chmod($save_dir, 0707);
		}
		$index_file = $save_dir . '/index.html';
		if(!file_exists($index_file)){	// 디렉토리 보안을 위해서
			$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);
		}
		/* //로고 저장 경로 */

		switch($mode){

			## 로고 수정(설정)
			case 'update':

				/* 로고 업로드 */
				$tmp_file	= $_FILES[$type]['tmp_name'];
				$filename	= $_FILES[$type]['name'];

				$timg = @getimagesize($tmp_file);

				if(is_uploaded_file($tmp_file)){

					$img_extension = $logo_control->_img();

					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크

						// 기존 로고 삭제
						@unlink($alice['data_logo_path'] . "/" . $logo[$type]);
						
						// 파일 업로드
						$file_upload = $utility->file_upload($tmp_file, $filename, $alice['data_logo_path'], $_FILES);

						// 변수 할당
						$vals[$type] = $file_upload['upload_file'];
						//$vals['file_width'] = $timg[0];
						//$vals['file_height'] = $timg[1];
						//$vals['file_type'] = $timg[2];
						$vals['wdate'] = $now_date;
						
						$result = $logo_control->update_logo($vals, $no);

						$_extension = $utility->get_extension($filename);

						if($result)
							echo $type.",".$vals[$type].",".$_extension.",".$timg[0].",".$timg[1];
						
					} else {
						
						$utility->popup_msg_ajax($logo_control->_errors('0001'));

					}

				}
				/* //로고 업로드 */


			break;

			## 채용공고 기본 로고 등록
			case 'employ_logo_insert':

				$tmp_file	= $_FILES['wr_content']['tmp_name'];
				$filename	= $_FILES['wr_content']['name'];
				$filesize  = $_FILES['wr_content']['size'];

				if(is_uploaded_file($tmp_file)){
					$img_extension = $logo_control->_img();
					if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
						$timg = @getimagesize($tmp_file);

						$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
						
						$list = $logo_control->__EmploylogoList($page,$page_rows," where `wr_logo` = '1' ");
						if(!$list['total_count']){	// 대표 로고가 설정 안된경우 자동으로 선택
							$vals['wr_logo'] = 1;
						}

						$vals['wr_content'] = $ym . '/' . $file_upload['upload_file'];	// 변수 할당
						$vals['wr_size'] = $filesize ;
						$vals['wr_width'] = $timg[0];
						$vals['wr_height'] = $timg[1];
						$vals['wr_type'] = $timg[2];
						$vals['wr_wdate'] = $alice['time_ymdhis'];

					}

					$result = $logo_control->insert_employ_logo($vals);

				}

				if($result){
					echo "0001";	// 채용공고 기본 로고 등록이 완료 되었습니다.
				} else {
					echo "0002";	// 채용공고 기본 로고 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.
				}

			break;

			## 채용공고 기본 로고 수정
			case 'employ_logo_update':

			break;

			## 채용공고 기본 로고 삭제
			case 'employ_logo_delete':

				$get_logo = $logo_control->getEmployLogo($no);

				@unlink($alice['data_logo_path']."/".$get_logo['wr_content']);
				
				$result = $logo_control->delete_employ_logo($no);

				if($result){
					echo "0002";
				} else {
					echo "0003";
				}

			break;

			## 채용공고 기본 로고 선택
			case 'employ_logo_sel':

				$vals['wr_logo'] = 0;	// 전체 미사용으로 체크
				$logo_control->updates_employ_logo($vals,$no);


				$upd_vals['wr_logo'] = 1;

				$result = $logo_control->update_employ_logo($upd_vals,$no);

				if($result){
					echo "0003";
				} else {
					echo "0004";
				}


			break;

		}

?>