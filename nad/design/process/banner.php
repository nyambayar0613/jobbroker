<?php
		/*
		* /application/nad/design/process/banner.php
		* @author Harimao
		* @since 2013/06/18
		* @last update 2015/02/25
		* @Module v3.5 ( Alice ) - b1.0
		* @Brief :: Banner Setting
		* @Comment :: 배너 관리 프로세스
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$uid = $_POST['uid'];
		$position = $_POST['position'];
		$type = $_POST['type'];	// 배너 종류
		$no = $_POST['no'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		switch($mode){

			## 배너 등록
			case 'insert':
		
				/* 배너 저장 경로 */
				$save_dir = $alice['data_banner_path'] . '/' . $ym;
				if(!is_dir($save_dir)){
					@mkdir($save_dir, 0707); @chmod($save_dir, 0707);
				}
				$index_file = $save_dir . '/index.html';
				if(!file_exists($index_file)){	// 디렉토리 보안을 위해서
					$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);
				}
				/* //배너 저장 경로 */
			
				$position = $_POST['position'];
				$type = $_POST['type'];
				$p_no = $_POST['p_no'];
				$max_rank = $banner_control->get_MaxRank($position);
				$get_banner = $banner_control->get_banner($p_no);

				$vals['uid'] = $_POST['uid'];
				$vals['rank'] = ($p_no=='self') ? $max_rank['rank'] + 1 : $get_banner['rank'];
				$vals['position'] = $position;
				$vals['type'] = $_POST['type'];
				$vals['size_set'] = $_POST['size_set'];
				$vals['width'] = $_POST['width'];
				$vals['height'] = $_POST['height'];
				
				/* 배너 업로드 */
				if($type=='image'){
					$tmp_file	= $_FILES['upload']['tmp_name'];
					$filename	= $_FILES['upload']['name'];
					if(is_uploaded_file($tmp_file)){
						$img_extension = $banner_control->_file();
						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
							$timg = @getimagesize($tmp_file);
							$file_upload = $utility->file_upload($tmp_file, $filename, $save_dir, $_FILES);	// 파일 업로드
							$vals['content'] = $ym . '/' . $file_upload['upload_file'];	// 변수 할당
							$vals['size_set'] = $_POST['size_set'];	 // 이미지 사이즈 자동/수동
							if($_POST['size_set']){	// 사용자 지정크기
								$width = $_POST['width'];
								$height = $_POST['height'];
							} else {	 // 수동
								$width = $timg[0];
								$height = $timg[1];
							}
						} else {
							echo '0001';
							exit;
						}
					}

					$vals['file_type'] = $timg[2];	// 파일타입
					$vals['width'] = $width;
					$vals['height'] = $height;

				/* 배너 업로드 */	
				} else if($type=='self' || $type=='adsense') {

					$vals['content'] = $_POST[$type.'_content'];

				}

				$vals['url'] = $_POST['url'];
				$vals['target'] = $_POST['target'];
				$vals['cookie'] = $_POST['cookie'];
				$vals['wdate'] = $now_date;
				
				for($i=0;$i<9;$i++){
					$vals['etc_'.$i] = $_POST['etc_'.$i];
				}

				$result = $banner_control->insert_banner($vals);

				$last_id = $db->last_id();
				if($p_no=='self'){
					$upd_vals['p_no'] = $last_id;
					$upd_vals['g_name'] = $_POST['g_name'];
					$banner_control->update_banner($upd_vals, $last_id);
					$max_g_rank = $banner_control->get_GroupMaxRank($position, $last_id);
					$rank_vals['g_rank'] = $max_g_rank['g_rank']+1;
					$banner_control->update_banner($rank_vals, $last_id);
				} else {
					$upd_vals['p_no'] = $p_no;
					$get_banner = $banner_control->get_banner($p_no);
					$upd_vals['g_name'] = $get_banner['g_name'];
					$banner_control->update_banner($upd_vals, $last_id);
					$max_g_rank = $banner_control->get_GroupMaxRank($position, $p_no);
					$rank_vals['g_rank'] = $max_g_rank['g_rank']+1;
					$banner_control->update_banner($rank_vals, $last_id);
				}

				echo "insert/".$result;

			break;

			## 배너 수정
			case 'update':

				$get_banner = $banner_control->get_banner($no);
				$get_p_no = $get_banner['p_no'];

				$type = $_POST['type'];
				$p_no = $_POST['p_no'];

				$vals['uid'] = $uid;
				$vals['type'] = $type;
				$vals['p_no'] = $p_no;
				$vals['size_set'] = $_POST['size_set'];
				$vals['width'] = $_POST['width'];
				$vals['height'] = $_POST['height'];

				/* 배너 업로드 */
				if($type=='image'){
					$tmp_file	= $_FILES['upload']['tmp_name'];
					$filename	= $_FILES['upload']['name'];
					if(is_uploaded_file($tmp_file)){
						$get_banner = $banner_control->get_banner($no);
						@unlink($alice['data_banner_path'] . "/" . $get_banner['content']);		// 기존 배너 삭제
						$img_extension = $banner_control->_file();
						if(preg_match("/\.($img_extension)$/i", $filename)){ // 파일 확장자 체크
							$timg = @getimagesize($tmp_file);
							$file_upload = $utility->file_upload($tmp_file, $filename, $alice['data_banner_path'], $_FILES);	// 파일 업로드
							$vals['content'] = $file_upload['upload_file'];	// 변수 할당
							if($_POST['size_set']=='auto'){	// 자동
								$width = $timg[0];
								$height = $timg[1];
							} else {	 // 수동
								$width = $_POST['width'];
								$height = $_POST['height'];
							}
						} else {
							$utility->popup_msg_ajax($config->_errors('0020'));
						}

						$vals['file_type'] = $timg[2];	// 파일타입

					} else {

						$width = $_POST['width'];
						$height = $_POST['height'];

					}

					$vals['size_set'] = $_POST['size_set'];	 // 이미지 사이즈 자동/수동
					$vals['width'] = $width;
					$vals['height'] = $height;

				/* 배너 업로드 */	
				} else if($type=='self' || $type=='adsense') {

					$vals['content'] = $_POST[$type.'_content'];

				}

				$vals['url'] = $_POST['url'];
				$vals['target'] = $_POST['target'];
				$vals['cookie'] = $_POST['cookie'];
				$vals['wdate'] = $now_date;

				$result = $banner_control->update_banner($vals, $no);

				if($get_p_no!=$p_no){	// 그룹을 변경한 경우					
					$banner_control->banner_rankChange($no, $p_no, $get_p_no);
				}

				echo "update/".$result;

			break;

			## 배너 그룹째 삭제 (복수)
			case 'sel_delete':
				
				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){
					$result = $banner_control->delete_Group_noRank($nos[$i]);
				}

				echo $result;

			break;

			## 배너 그룹 순위 변경
			case 'group_rank':

				$result = $banner_control->group_setRank($position,$p_no, $next_no);

				echo $result;

			break;

			## 배너 그룹내 순위 변경
			case 'banner_rank':

				$result = $banner_control->banner_setRank($position,$no, $next_no);

				echo $result;

			break;

			## 리스트상 배너 출력 설정
			case 'views':

				$get_banner = $banner_control->get_banner($no);
				$vals['view'] = ($get_banner['view']) ? 0 : 1;
				
				$result = $banner_control->update_banner($vals, $no);
				if($result){
					echo $vals['view'];
				} else {
					echo '0003';
					exit;
				}

			break;

			## 리스트상 배너 타겟 설정
			case 'targets':

				$get_banner = $banner_control->get_banner($no);
				$vals['target'] = ($get_banner['target']=='_blank') ? '' : '_blank';
				
				$result = $banner_control->update_banner($vals, $no);
				if($result){
					echo $vals['target'];
				} else {
					echo '0004';
					exit;
				}

			break;

			## 배너 삭제 (단수)
			case 'delete':
			
				$result = $banner_control->delete_noRank($no);

				echo $result;

			break;

			## 선택 사용/미사용
			case 'sel_view':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				$vals['view'] = $_POST['views'];

				for($i=0;$i<$no_cnt;$i++){
					$result = $banner_control->update_bannerP_no($vals,$nos[$i]);
				}

				echo $result;

			break;

			## 선택 본창/새창
			case 'sel_target':
				$nos = explode(',',$no);
				$no_cnt = count($nos);
				$vals['target'] = $_POST['targets'];

				for($i=0;$i<$no_cnt;$i++){
					$result = $banner_control->update_bannerP_no($vals,$nos[$i]);
				}

				echo $result;

			break;

			## 배너 롤링 설정
			case 'banner_roll':

				$p_no = $_POST['p_no'];

				$vals['roll_type'] = $_POST['roll_type'];
				$vals['roll_direction'] = $_POST['roll_direction'];
				$vals['roll_time'] = $_POST['roll_time'];
				$vals['roll_turn'] = $_POST['roll_turn'];

				$result = $banner_control->update_bannerP_no($vals,$p_no);

				echo $result;

			break;

		}	// switch end.
?>