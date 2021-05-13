<?php
		/*
		* /application/nad/board/process/board.php
		* @author Harimao
		* @since 2013/06/01
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Board regist
		* @Comment :: 게시판 등록/수정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$no = $_POST['no'];
		$code = $_POST['code'];

		switch($mode){

			## 게시판 입력/수정
			case 'board_insert':
			case 'board_update':
				
				// rank 최대값 구함
				$get_LastRank = $board_config_control->get_MaxRank($code);
				$bo_table = $utility->get_unique_code();
				
				if($mode=='board_insert'){
					$vals['rank'] = $get_LastRank + 1;
					$vals['code'] = $code;
					$vals['bo_table'] = $bo_table;
				}

				$vals['bo_skin'] = $_POST['bo_skin'];
				$vals['bo_subject'] = $_POST['bo_subject'];
				//$vals['bo_type'] = $_POST['bo_type'];	// 게시판 타입(필요한 경우 사용 하세요)
				$vals['bo_table_width'] = $_POST['bo_table_width'];
				$vals['bo_subject_len'] = $_POST['bo_subject_len'];
				$vals['bo_page_rows'] = $_POST['bo_page_rows'];
				$vals['bo_board_view'] = $_POST['bo_board_view'];
				//$vals['bo_adult_view'] = $_POST['bo_adult_view'];	 //	 성인 게시판 사용 유무
				//$vals['bo_main_view'] = $_POST['bo_main_view'];		// 게시판 메인 출력 유무
				//$vals['bo_main_count'] = $_POST['bo_main_count'];	// 게시판 메인 출력 건수
				$vals['bo_use_point'] = $_POST['bo_use_point'];
				$vals['bo_list_level'] = $_POST['bo_list_level'];
				$vals['bo_read_level'] = $_POST['bo_read_level'];
				$vals['bo_secret_level'] = $_POST['bo_secret_level'];
				$vals['bo_write_level'] = $_POST['bo_write_level'];
				$vals['bo_reply_level'] = $_POST['bo_reply_level'];
				$vals['bo_comment_level'] = $_POST['bo_comment_level'];
				//$vals['bo_notice_level'] = $_POST['bo_notice_level'];	 // 공지사항 작성 레벨
				$vals['bo_use_overlap'] = $_POST['bo_use_overlap'];
				$vals['bo_use_comment'] = $_POST['bo_use_comment'];
				$vals['bo_use_reply'] = $_POST['bo_use_reply'];
				$vals['bo_use_good'] = $_POST['bo_use_good'];
				$vals['bo_use_nogood'] = $_POST['bo_use_nogood'];
				//$vals['bo_use_trackback'] = $_POST['bo_use_trackback'];	// 트랙백 기능
				$vals['bo_use_delete'] = $_POST['bo_use_delete'];
				$vals['bo_use_report'] = $_POST['bo_use_report'];
				$vals['bo_use_secret'] = $_POST['bo_use_secret'];
				$vals['bo_use_name'] = $_POST['bo_use_name'];
				$vals['bo_cut_name'] = $_POST['bo_cut_name'];
				$vals['bo_use_sns'] = $_POST['bo_use_sns'];
				$vals['bo_sns'] = @implode($_POST['bo_sns'],',');
				$vals['bo_use_best'] = $_POST['bo_use_best'];
				$vals['bo_best_count'] = $_POST['bo_best_count'];
				$vals['bo_use_comment_best'] = $_POST['bo_use_comment_best'];
				$vals['bo_new'] = $_POST['bo_new'];
				//$vals['bo_imoticon'] = $_POST['bo_imoticon'];	// 댓글 이모티콘 입력
				$vals['bo_image_width'] = $_POST['bo_image_width'];
				$vals['bo_use_list_view'] = $_POST['bo_use_list_view'];
				$vals['bo_write_point'] = $_POST['bo_write_point'];
				$vals['bo_read_point'] = $_POST['bo_read_point'];
				$vals['bo_comment_point'] = $_POST['bo_comment_point'];
				//$vals['bo_reply_point'] = $_POST['bo_reply_point'];	// 답변 글쓰기 포인트 (답변은 글작성 포인트로로 대체)
				//$vals['bo_recommand_point'] = $_POST['bo_recommand_point'];	// 추천 포인트 (게시글/댓글 추천 받은 사람에게 지급)
				$vals['bo_download_point'] = $_POST['bo_download_point'];
				$vals['bo_use_category'] = $_POST['bo_use_category'];
				//$vals['bo_category_list'] = $_POST['bo_category_list'];	// 게시판 생성시 직접 입력하는 경우 사용
				//$vals['bo_use_sideview'] = $_POST['bo_use_sideview'];	 // 사이트뷰 (게시글 작성자 닉네임,아이디 클릭시 뜨는 토글)
				$vals['bo_use_upload'] = $_POST['bo_use_upload'];
				//$vals['bo_use_upload_detail'] = $_POST['bo_use_upload_detail'];	// 첨부파일 출력여부 (필요할까?)
				$vals['bo_upload_count'] = $_POST['bo_upload_count'];
				$vals['bo_upload_size'] = $_POST['bo_upload_size'];
				$vals['bo_upload_ext_img'] = $_POST['bo_upload_ext_img'];
				$vals['bo_upload_ext_fla'] = $_POST['bo_upload_ext_fla'];
				$vals['bo_upload_ext_mov'] = $_POST['bo_upload_ext_mov'];
				$vals['bo_upload_ext'] = $_POST['bo_upload_ext'];
				//$vals['bo_include_head'] = $_POST['bo_include_head'];
				//$vals['bo_include_tail'] = $_POST['bo_include_tail'];
				$vals['bo_content_head'] = $_POST['bo_content_head'];
				$vals['bo_content_tail'] = $_POST['bo_content_tail'];
				$vals['bo_insert_content'] = $_POST['bo_insert_content'];
				$vals['bo_filter'] = $_POST['bo_filter'];
				//$vals['bo_intercept_ip'] = $_POST['bo_intercept_ip'];	// 접근 차단 ip

				$vals['bo_reply_order'] = $_POST['bo_reply_order'];
				$vals['bo_sort_field'] = $_POST['bo_sort_field'];
				//$vals['bo_use_search'] = $_POST['bo_use_search'];	// 전체 검색 사용 유무
				//$vals['bo_order_search'] = $_POST['bo_order_search'];	 //	전체 검색 순서

				$vals['wdate'] = $now_date;

				/* 여분 필드(들) */
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
				/* //여분 필드(들) */


				if($mode=='board_insert') {
					$result = $board_config_control->insert_board($vals);
					if($result){
						$create_board = $board_config_control->create_Board($bo_table);
						if(!$create_board){
							echo '0015';
							exit;
						} else {
							if($mode=='board_insert'){	 // 입력일때만
								/* 게시판 데이터 저장 디렉토리 */
								$board_data_dir = $alice['data_board_path'] . '/' . $bo_table;
								$index_file = $board_data_dir . '/index.html';
								if(!file_exists($index_file)){	 // 디렉토리 보안을 위해
									@mkdir($board_data_dir, 0707); @chmod($board_data_dir, 0707);	// 우선 디렉토리 먼저 만들고
									$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);	// index.html 파일 생성
								}
								/* //게시판 데이터 저장 디렉토리 */
							}
							echo $code;
						}
					} else {
						echo '0016';
						exit;
					}
				} else if($mode=='board_update') {
					$result = $board_config_control->update_board($vals,$no);
					if($result){
						$get_board = $board_config_control->get_board($no);
						echo $get_board['code'];
					} else {
						echo '0002';
						exit;
					}
				}

			break;

			## 게시판 목록상 삭제 (단수)
			case 'board_delete':

				$result = $board_config_control->delete_board($no);

				echo $result;

			break;

			## 게시판 목록상 선택 삭제 (복수)
			case 'board_deletes':

				$nos = explode(',',$no);
				$nos_cnt = count($nos);
				for($i=0;$i<$nos_cnt;$i++){
					$get_board = $board_config_control->get_board($no);
					$result = $board_config_control->delete_noRank($nos[$i],$get_board['code']);
				}

				echo $result;

			break;

			## 게시판 순위조절
			case 'board_rank':

				$next_no = $_POST['next_no'];

				// 순위조절 함수 호출
				$result = $board_config_control->setRank($no, $next_no);

				echo $result;

			break;

			## 게시판 순위조절
			case 'board_b_rank':

				$next_no = $_POST['next_no'];

				// 순위조절 함수 호출
				$result = $board_config_control->set_b_Rank($no, $next_no);

				echo $result;

			break;

			## 게시판 순위조절
			case 'board_m_rank':

				$next_no = $_POST['next_no'];

				// 순위조절 함수 호출
				$result = $board_config_control->set_m_Rank($no, $next_no);

				echo $result;

			break;

			## 게시판 목록상 스킨 변경
			case 'board_skin':

				$vals['bo_skin'] = $_POST['bo_skin'];
				$result = $board_config_control->update_board($vals,$no);

				echo $result;

			break;

			## 게시판 목록상 출력 상태 변경
			case 'board_view':

				$vals['bo_board_view'] = ($_POST['board_view']=='true') ? 1 : 0;
				$result = $board_config_control->update_board($vals,$no);

				echo $result;
				
			break;

			## 게시판 목록상 메인출력 상태 변경
			case 'board_main':

				$vals['bo_main_view'] = ($_POST['main_view']=='true') ? 1 : 0;
				$vals['bo_main_count'] = $_POST['main_count'];
				$result = $board_config_control->update_board($vals,$no);

				echo $result;
				
			break;

			## 게시판 목록상 권한설정
			case 'level_update':
			
				$vals['bo_list_level'] = $_POST['bo_list_level'];
				$vals['bo_read_level'] = $_POST['bo_read_level'];
				$vals['bo_write_level'] = $_POST['bo_write_level'];
				$vals['bo_reply_level'] = $_POST['bo_reply_level'];
				$vals['bo_comment_level'] = $_POST['bo_comment_level'];
				$vals['bo_secret_level'] = $_POST['bo_secret_level'];

				$result = $board_config_control->update_board($vals,$no);

				if(!$result){
					echo '0020';
					exit;
				}

			break;

			## 게시판 분류설정
			case 'board_category':
				
				$modes = $_POST['modes'];
				$type = $_POST['type'];	// 카테고리 type
				$p_code = $_POST['p_code'];

				$vals['type'] = $type;
				if($modes=='insert'){
					$get_LastRank = $category_control->get_MaxRank($type);	// rank 최대값 구함
					$vals['rank'] = $get_LastRank + 1;
					$vals['code'] = $utility->get_unique_code();
					$vals['p_code'] = $p_code;
				}
				$vals['view'] = $_POST['view'];
				$vals['name'] = $_POST['name'];

				if($modes=='insert') {
					$result = $category_control->insert_category($vals);
					$bo_vals['bo_use_category'] = 1;	// 카테고리를 입력했다면 자동으로 카테고리 사용
					$board_config_control->update_board($bo_vals,$no);
				} else {
					$result = $category_control->update_category($vals, $no);
				}

				if($result){	
					echo $p_code;
				} else {
					echo '0021';
					exit;
				}

			break;

			## 게시판 분류 출력 설정
			case 'board_cate_view':
				
				$vals['view'] = ($_POST['view']=='true') ? 'yes' : 'no';
				$result = $category_control->update_category($vals, $no);

				echo $result;

			break;

			## 게시판 분류 순위 조절
			case 'board_category_rank':

				$next_no = $_POST['next_no'];

				// 순위조절 함수 호출
				$result = $category_control->setRank('board', $no, $next_no);

				echo $result;

			break;

			## 게시판 분류명 수정
			case 'board_cate_update':

				$vals['view'] = ($_POST['view']=='true') ? 'yes' : 'no';
				$vals['name'] = $_POST['name'];
				$result = $category_control->update_category($vals, $no);

				echo $result;

			break;

			## 게시판 분류명 삭제
			case 'board_cate_delete':

				$result = $category_control->delete_noRank($no,'board');

				echo $result;

			break;

			## 게시판 메뉴 select
			case 'borad_menus':

				$type = $_POST['type'];

				$result = array();

				if($type=='first'){	// 1차 메뉴 추출
					
					$board_category = $category_control->category_codeList('board_menu');
					
					$result['option'] .= "<option value=''>1차 메뉴명</option>";

					foreach($board_category as $option){

						$result['option'] .= "<option value='".$option['code']."'>".$option['name']."</option>";

					}

					$result['result'] = ($board_category) ? true : false;

				} else if($type=='second'){	 // 2차 메뉴 추출

					$board_category = $category_control->category_pcodeList('board_menu',$code);

					if($board_category){

						$result['option'] .= "<option value=''>2차 메뉴명</option>";

						foreach($board_category as $option){

							$result['option'] .= "<option value='".$option['code']."'>".$option['name']."</option>";

						}
					}

					$result['result'] = ($board_category) ? true : false;

				}
				
				echo @implode($result,'@');

			break;

			## code 로 게시판 select 추출
			case 'board_for_code':

				$result = array();

				$board_list = $board_config_control->boCode_list($code);

				$result['option'] .= "<option value=''>게시판명</option>";

				foreach($board_list as $board){

					$result['option'] .= "<option value='".$board['code']."'>".$board['bo_subject']."</option>";

				}

				$result['result'] = ($board_list) ? true : false;

				print_R($result);
				exit;

			break;

			## 게시판 상위 메뉴 code 변경
			case 'board_code_update':

				$nos_cnt = count($no);
				for($i=0;$i<$nos_cnt;$i++){
					$vals['code'] = $code;
					$get_LastRank = $board_config_control->get_MaxRank($code);				
					$vals['rank'] = $get_LastRank + 1;
					$result = $board_config_control->update_board($vals,$no[$i]);
				}

				echo $result;

			break;

			## 게시판 메인 출력 설정
			case 'board_main_print':
			
				$vals['use_main'] = $_POST['use_main'];
				$vals['use_best'] = $_POST['use_best'];
				$vals['use_best_count'] = $_POST['use_best_count'];
				$vals['use_inquiry'] = $_POST['use_inquiry'];
				$vals['use_inquiry_count'] = $_POST['use_inquiry_count'];
				$vals['use_reply'] = $_POST['use_reply'];
				$vals['use_reply_count'] = $_POST['use_reply_count'];
				$vals['use_recommend'] = $_POST['use_recommend'];
				$vals['use_recommend_count'] = $_POST['use_recommend_count'];
				$vals['use_sub_best'] = $_POST['use_sub_best'];
				$vals['sub_best_count'] = $_POST['sub_best_count'];
				//$vals['use_new'] = $_POST['use_new'];
				//$vals['use_new_count'] = $_POST['use_new_count'];
				$vals['use_print'] = $_POST['use_print'];
				$vals['print_board'] = serialize($_POST['board']);
				$vals['wdate'] = $now_date;

				/* 여분 필드(들) */
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
				/* //여분 필드(들) */

				$result = $board_config_control->update_main($vals,$no);

				echo $result;

			break;

			## 게시판 인덱스 출력 설정
			case 'board_index_print':
			
				$vals['print_main'] = serialize($_POST['board']);

				$result = $board_config_control->update_main($vals,$no);

				echo $result;

			break;
			

		}	// switch end.
?>