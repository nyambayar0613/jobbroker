<?php
		/*
		* /application/nad/member/process/level.php
		* @author Harimao
		* @since 2013/05/30
		* @last update 2015/03/05
		* @Module v3.5 ( Alice )
		* @Brief :: Level icon/point config
		* @Comment :: 회원 레벨별 아이콘/포인트 설정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$uid = $_POST['uid'];
		$no = $_POST['no'];
		$level_no = $_POST['level_no'];
		
		$name = $_POST['name'];
		$rank = $_POST['rank'];
		$view = $_POST['view'];
		$etc_0 = $_POST['etc_0'];
		$etc_0_cnt = count($etc_0);

		switch($mode){

			## 회원등급 출력/미출력 설정
			case 'level_view':

				$vals['view'] = ($view=='true') ? 'yes' : 'no';

				$result = $category_control->update_category($vals,$no);

				if(!$result){
					echo '0020';
					exit;
				}

			break;

			## 레벨 입력
			case 'level_insert':

				$vals['type'] = 'mb_level';
				$vals['name'] = $name;
				$vals['view'] = $view;
				$vals['rank'] = $rank;
				$vals['etc_0'] = $_POST['point'];

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

				$etc_1 = $_FILES['img_file'];

				$tmp_file	= $etc_1['tmp_name'];
				$filename	= $etc_1['name'];
				
				if(is_uploaded_file($tmp_file)){
					if(preg_match("/\.($img_extension)$/i", $filename)){ // 이미지 확장자 체크
						$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
						$vals['etc_1'] = $ym . "/" . $file_upload['upload_file'];
					} else {
						if($ajax)
							$utility->popup_msg_ajax($config->_errors('0051'));
						else
							$utility->popup_msg_js($config->_errors('0051'));
					}
				}

				$result = $category_control->insert_category($vals);

				if(!$result){
					echo '0017';
					break;
				}

			break;

			## 레벨 수정
			case 'level_update':

				$vals['name'] = $name;
				$vals['view'] = ($view=='true') ? 'yes' : 'no';
				$vals['rank'] = $rank;
				$vals['etc_0'] = ($etc_0) ? $etc_0 : 0;

				$result = $category_control->update_category($vals, $level_no);

				if(!$result){
					echo '0013';
					exit;
				}
			
			break;

			## 레벨 삭제
			case 'level_delete':

				$result = $category_control->delete_noRank($no,'mb_level');

				if(!$result){
					echo '0006';
					exit;
				}
				
			break;

			## 레벨 일괄수정
			case 'sel_level_update':
				
				$no_cnt = count($no);
				for($i=0;$i<$no_cnt;$i++){
					$vals['name'] = $name[$i];
					$vals['view'] = ($view[$i]=='true') ? 'yes' : 'no';
					$vals['rank'] = $rank[$i];
					$vals['etc_0'] = ($etc_0[$i]) ? $etc_0[$i] : 0;

					$result = $category_control->update_category($vals, $no[$i]);

				}

				if(!$result){
					echo '0014';
					exit;
				}
			
			break;

			## 레벨별 등급아이콘 수정
			case 'level_icon':

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

				$etc_1 = $_FILES['etc_1'];

				$tmp_file	= $etc_1['tmp_name'][$level_no];
				$filename	= $etc_1['name'][$level_no];
				if(is_uploaded_file($tmp_file)){
					if(preg_match("/\.($img_extension)$/i", $filename)){ // 이미지 확장자 체크
						$get_level = $category_control->get_category($level_no);
						@unlink($alice['peg_path'] . "/" . $get_level['etc_1']); // 기존 파일 삭제
						$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
						$vals['etc_1'] = $ym . "/" . $file_upload['upload_file'];
						$result = $category_control->update_category($vals,$level_no);
						if($result) echo $level_no."@".$vals['etc_1'];	// 결과
					} else {
						if($ajax)
							$utility->popup_msg_ajax($config->_errors('0051'));
						else
							$utility->popup_msg_js($config->_errors('0051'));
					}
				}

			break;

			## 기본 포인트 설정
			## 환경설정 테이블에서 수정
			case 'environment_update':

				$vals['use_point'] = $_POST['use_point'];
				$vals['auto_level'] = $_POST['auto_level'];
				$vals['register_level'] = $_POST['register_level'];	 // 가입시 지급 포인트
				$vals['register_point'] = $_POST['register_point'];
				$vals['login_point'] = $_POST['login_point'];

				$vals['employ_point_percent'] = $_POST['employ_point_percent'];		// 채용공고 유료 결제시 지급 포인트 %
				$vals['resume_point_percent'] = $_POST['resume_point_percent'];	// 이력서 유료 결제시 지급 포인트 %
				$vals['alba_point_percent'] = $_POST['alba_point_percent'];				// 알바공고 유료 결제시 지급 포인트 %
				$vals['alba_resume_point_percent'] = $_POST['alba_resume_point_percent'];	 // 알바 이력서 유료 결제시 지급 포인트 %

				$vals['employ_read_point'] = $_POST['employ_read_point'];
				$vals['individual_read_point'] = $_POST['individual_read_point'];

				$result = $config_control->config_update($vals,1);	 // 기본은 1

				if(!$result){
					echo '0018';
					exit;
				}

			break;
		}


?>