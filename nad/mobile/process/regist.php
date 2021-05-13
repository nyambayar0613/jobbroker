<?php
		/*
		* /application/nad/mobile/process/regist.php
		* @author Harimao
		* @since 2013/12/16
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Mobile process
		* @Comment :: 모바일 처리 프로세스
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];
		$no = $_POST['no'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$vals['wr_use'] = $_POST['wr_use'];
		$vals['wr_mobile_url'] = $_POST['wr_mobile_url'];

		$tmp_file	= $_FILES['wr_logo']['tmp_name'];
		$filename	= $_FILES['wr_logo']['name'];

		$timg = @getimagesize($tmp_file);

		if(is_uploaded_file($tmp_file)){

			$img_extension = $logo_control->_img();

			if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크

				// 기존 로고 삭제
				//@unlink($alice['data_logo_path'] . "/" . $logo[$type]);
				
				// 파일 업로드
				$file_upload = $utility->file_upload($tmp_file, $filename, $alice['data_logo_path'], $_FILES);

				// 변수 할당
				$vals['wr_logo'] = $file_upload['upload_file'];
								
			} else {
				
				$utility->popup_msg_ajax($logo_control->_errors('0001'));

			}

		}

		$vals['wr_color'] = $_POST['wr_color'];
		$vals['wr_copyright'] = $_POST['wr_copyright'];

		// 메인 박스형 채용정보
		$vals['wr_main_box_use'] = $_POST['wr_main_box_use'];
		$vals['wr_main_box_total'] = $_POST['wr_main_box_total'];
		$vals['wr_main_box_page'] = $_POST['wr_main_box_page'];

		// 메인 리스트형 채용정보
		$vals['wr_main_list_use'] = $_POST['wr_main_list_use'];
		$vals['wr_main_list_total'] = $_POST['wr_main_list_total'];
		$vals['wr_main_list_page'] = $_POST['wr_main_list_page'];

		// 메인 포커스 인재정보
		$vals['wr_main_focus_use'] = $_POST['wr_main_focus_use'];
		$vals['wr_main_focus_total'] = $_POST['wr_main_focus_total'];
		$vals['wr_main_focus_page'] = $_POST['wr_main_focus_page'];

		$vals['wr_main_board_use'] = $_POST['wr_main_board_use'];	// 메인 게시판 사용 유무
		$vals['wr_main_board'] = serialize($_POST['wr_main_board']);

		$vals['wr_main_notice_use'] = $_POST['wr_main_notice_use'];	// 메인 공지사항 사용 유무

		// 서브 박스형 채용정보
		$vals['wr_sub_box_use'] = $_POST['wr_sub_box_use'];
		$vals['wr_sub_box_total'] = $_POST['wr_sub_box_total'];
		$vals['wr_sub_box_page'] = $_POST['wr_sub_box_page'];

		// 서브 리스트형 채용정보
		$vals['wr_sub_list_use'] = $_POST['wr_sub_list_use'];
		$vals['wr_sub_list_total'] = $_POST['wr_sub_list_total'];
		$vals['wr_sub_list_page'] = $_POST['wr_sub_list_page'];

		// 서브 일반 채용정보
		$vals['wr_sub_use'] = $_POST['wr_sub_use'];
		$vals['wr_sub_total'] = $_POST['wr_sub_total'];
		$vals['wr_sub_page'] = $_POST['wr_sub_page'];

		// 서브 포커스 채용정보
		$vals['wr_sub_focus'] = $_POST['wr_sub_focus'];
		$vals['wr_sub_focus_total'] = $_POST['wr_sub_focus_total'];
		$vals['wr_sub_focus_page'] = $_POST['wr_sub_focus_page'];

		// 서브 일반 인재정보
		$vals['wr_sub_individual'] = $_POST['wr_sub_individual'];
		$vals['wr_sub_individual_total'] = $_POST['wr_sub_individual_total'];
		$vals['wr_sub_individual_page'] = $_POST['wr_sub_individual_page'];

		$vals['wr_board_use'] = $_POST['wr_board_use'];	// 커뮤니티 사용 유무
		$vals['wr_board'] = serialize($_POST['wr_board']);


		$result = $mobile_control->update_mobile( $vals, $no );	

		echo $result;

?>