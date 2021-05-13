<?php
		/**
		* /application/company/model/alice_alba_company_model.class.php
		* @author Harimao
		* @since 2013/07/29
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Company Employ Model class
		* @Comment :: 사용자측 정규직 채용정보 모델 클래스
		*/
		class alice_alba_company_model extends DBConnection {

			var $alba_table	= "alice_alba";
			var $open_table = "alice_resume_open";	// 이력서 열람 정보 테이블
			var $scrap_table = "alice_scrap";	// 스크랩 테이블
			var $custom_table = "alice_resume_search";	// 맞춤 인재정보 테이블
			var $proposal_table = "alice_resume_proposal";	// 면접/입사 제안 테이블

			var $success_code = array(
					'0000' => '채용공고 등록이 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '채용공고 등록중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0001' => '자신이 등록한 공고만 수정 가능합니다.',
					'0002' => '채용공고 수정중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0003' => '공고가 존재하지 않거나, 삭제된 데이터 입니다.',
					'0004' => '채용공고 고유 데이터 번호가 잘못 되었습니다.\\n\\n해당 공고가 삭제되었거나 공고에 문제가 있을수 있습니다.',
					'0005' => '채용공고 삭제중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0006' => '맞춤 인재정보 저장중 오류가 발생했습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0007' => '강제 마감중 오류가 발생했습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0008' => '맞춤 인재정보 수정중 오류가 발생했습니다.',
					'0009' => '맞춤 인재정보 삭제중 오류가 발생했습니다.',
			);


				// 채용공고 리스트
				function __AlbaList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->alba_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/*
						echo "<xmp>";
						echo $query;
						echo "</xmp>";
						*/

						//echo $query;

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}

				// 채용공고 간단 리스트
				function alba_list( $con ){

						$query = " select * from `".$this->alba_table."` " . $con;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 채용공고 카운팅 (마이페이지에서 활용)
				function alba_list_count( $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->alba_table."` " . $con . $_add['que'];

						$result = $this->_queryR($query);

					
					return $result;

				}

				// 지원자 카운팅
				function alba_desire_count( $con="" ){

					echo " select * from `".$this->alba_table."` " . $con."<Br/>";

						$query = $this->query_fetch_rows(" select * from `".$this->alba_table."` " . $con);

						$result = 0;

						foreach($query as $val){
							if($val['wr_desire']){
								$result += $val['wr_desire'];
							}
						}

					
					return $result;

				}


				// 채용공고 추출 (단수) :: wr_id 기준
				function get_alba( $wr_id, $con="" ){

						if(!$wr_id || $wr_id=='') return false;

						$query = " select * from `".$this->alba_table."` where `wr_id` = '".$wr_id."' " . $con;

						$result = $this->query_fetch($query);


					return $result;
				}


				// 채용공고 추출 (단수) :: no 기준
				function get_alba_no( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->alba_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;
				}


				// 공고 검색
				function _Search( ){

					global $utility, $config;

						$mode = $_GET['mode'];

						$type = $_GET['type'];

						$page = $_GET['page'];
						$page_rows = $_GET['page_rows'];

						$order = ($_GET['order']) ? $_GET['order'] : " `no` desc ";

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드


						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드
							array_push( $url, 'type='.$type );	// 진행/마감 구분


							## 필드선택에 따른 검색 #######################################################################################
							if(!$search_field){	// 통합검색 일때
								/*
								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que  = " ( ";
									$search_que .= " INSTR(LOWER(`wr_subject`), LOWER('".$search_keyword."'))";	// 제목
									$search_que .= " or INSTR(LOWER(`wr_content`), LOWER('".$search_keyword."'))";	// 내용
									$search_que .= " or INSTR(LOWER(`wr_name`), LOWER('".$search_keyword."'))";	// 작성자
									$search_que .= " ) ";
								} else {
									$search_que  = " ( ";
									$search_que .= " INSTR(`wr_subject`, '".$search_keyword."')";
									$search_que .= " or INSTR(`wr_content`, '".$search_keyword."')";
									$search_que .= " or INSTR(`wr_name`, '".$search_keyword."')";
									$search_que .= " ) ";
								}

								array_push($url, "search_field=&search_keyword=" . $search_keyword);
								*/

							} else {	 // 필드 선택

								$tmp = array();
								$tmp = explode(",", trim($search_field));
								$field = explode("||", $tmp[0]);	// 제목+내용 검색 때문에 || 를 기준으로 자른다
								$not_comment = $tmp[1];
								$field_cnt = count($field);

								$search_que = "";

								for ($i=0; $i<$field_cnt; $i++) { // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)

									// SQL Injection 방지
									// 필드값에 a-z A-Z 0-9 _ , | 이외의 값이 있다면 검색필드를 wr_subject 로 설정한다.
									$field[$i] = preg_match("/^[\w\,\|]+$/", $field[$i]) ? $field[$i] : "wr_subject";
									
									if (preg_match("/[a-zA-Z]/", $search_keyword)){
										$search_que .= "INSTR(LOWER(`".$field[$i]."`), LOWER('".$search_keyword."'))";
									} else {
										$_and = ($i>0)?" or ":"";
										$search_que .= $_and . " INSTR(`".$field[$i]."`, '".$search_keyword."') ";
									}

								}

								array_push($url, "search_field=" . urlencode($search_field) . "&search_keyword=" . urlencode($search_keyword));
							}
							## //필드선택에 따른 검색 #####################################################################################
							
							array_push($que, $search_que);

						}

						array_push($url, 'page='.$page);
						array_push($url, 'page_rows='.$page_rows);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 직종 출력
				function print_job_type( $val ){

					global $category_control;

						$result = array();
					
						if($val['wr_job_type0']){	 // 1차 직종
							$result[] = $category_control->get_categoryCodeName($val['wr_job_type0']);
						}

						if($val['wr_job_type1']){	 // 2차 직종
							$result[] = $category_control->get_categoryCodeName($val['wr_job_type1']);
						}

						if($val['wr_job_type2']){	 // 3차 직종
							$result[] = $category_control->get_categoryCodeName($val['wr_job_type2']);
						}

					
					return $result;

				}

				// 마감일 출력
				function print_end_day( $val ){

						if($val['wr_volume_always'] && $val['wr_volume_end']){	// 상시모집, 채용시까지

							$result = "상시/채용시까지";

						} else {

							if($val['wr_volume_always']){

								$result = "상시모집";

							} else if($val['wr_volume_end']){

								$result = "채용시까지";

							} else {

								$result = $val['wr_volume_date'];

							}

						}


					return $result;

				}

				// 과거 채용공고 리스트
				function past_alba_list( $no="",$wr_id ){

						if($no){

							$query = " select * from `".$this->alba_table."` where `no` != '".$no."' and `wr_id` = '".$wr_id."' and `is_delete` = 0 order by `no` desc ";

						} else {

							$query = " select * from `".$this->alba_table."` where `wr_id` = '".$wr_id."' and `is_delete` = 0 order by `no` desc ";

						}

						$result = $this->query_fetch_rows($query);


					return $result;

				}


				// 열람정보 리스트
				function __OpenList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_OpenSearch( );

						$query = " select * from `".$this->open_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}
						
						//echo $query." <==<Br/>";

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];


					return $result;

				}

				// 열람 정보 검색
				function _OpenSearch(){

					global $utility, $config;

						$mode = $_GET['mode'];

						$type = $_GET['type'];

						$page = $_GET['page'];
						$page_rows = $_GET['page_rows'];

						$order = ($_GET['order']) ? $_GET['order'] : " `no` desc ";

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드


						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							## 필드선택에 따른 검색 #######################################################################################
							$tmp = array();
							$tmp = explode(",", trim($search_field));
							$field = explode("||", $tmp[0]);	// 제목+내용 검색 때문에 || 를 기준으로 자른다
							$not_comment = $tmp[1];
							$field_cnt = count($field);

							$search_que = "";

							for ($i=0; $i<$field_cnt; $i++) { // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)

								// SQL Injection 방지
								// 필드값에 a-z A-Z 0-9 _ , | 이외의 값이 있다면 검색필드를 wr_subject 로 설정한다.
								$field[$i] = preg_match("/^[\w\,\|]+$/", $field[$i]) ? $field[$i] : "wr_subject";
								
								if (preg_match("/[a-zA-Z]/", $search_keyword)){
									$search_que .= "INSTR(LOWER(`".$field[$i]."`), LOWER('".$search_keyword."'))";
								} else {
									$_and = ($i>0)?" or ":"";
									$search_que .= $_and . " INSTR(`".$field[$i]."`, '".$search_keyword."') ";
								}

							}

							array_push($url, "search_field=" . urlencode($search_field) . "&search_keyword=" . urlencode($search_keyword));
							## //필드선택에 따른 검색 #####################################################################################

							array_push($que, $search_que);

						}
						
						/*
						array_push($url, 'page='.$page);
						array_push($url, 'page_rows='.$page_rows);
						*/

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 맞춤인재정보 리스트
				function __CustomList( $page="", $page_rows="", $con="" ){

						$query = " select * from `".$this->custom_table."` " . $con . " order by `no` desc ";

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}

				// 맞춤인재정보 검색 리스트
				function custom_list( $page="", $page_rows="", $con="", $no="" ){

					global $alba_resume_user_control;

						$_add = $this->_CustomSearch( $no );

						$query = " select * from `".$alba_resume_user_control->resume_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						//echo $query;

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}

				// 공고 검색
				function _CustomSearch( $no="" ){

					global $utility, $config;

						$mode = $_GET['mode'];

						$page = $_GET['page'];
						$page_rows = $_GET['page_rows'];

						$order = ($_GET['order']) ? $_GET['order'] : " `no` desc ";

						if($no){
							$search_no = $no;
						} else {
							$get_last_no = $this->get_last_no();
							$search_no = ($_GET['no']) ? $_GET['no'] : $get_last_no['no'];
						}

						$get_custom = $this->get_custom($search_no);

						$wr_job_type0 = $get_custom['wr_job_type0'];
						$wr_job_type1 = $get_custom['wr_job_type1'];
						$wr_job_type2 = $get_custom['wr_job_type2'];
						$wr_job_type3 = $get_custom['wr_job_type3'];
						$wr_job_type4 = $get_custom['wr_job_type4'];
						$wr_job_type5 = $get_custom['wr_job_type5'];
						$wr_job_type6 = $get_custom['wr_job_type6'];
						$wr_job_type7 = $get_custom['wr_job_type7'];
						$wr_job_type8 = $get_custom['wr_job_type8'];

						$wr_area0 = $get_custom['wr_area0'];
						$wr_area1 = $get_custom['wr_area1'];
						$wr_area2 = $get_custom['wr_area2'];
						$wr_area3 = $get_custom['wr_area3'];
						$wr_area4 = $get_custom['wr_area4'];
						$wr_area5 = $get_custom['wr_area5'];

						$wr_home_work = $get_custom['wr_home_work'];

						$wr_date = $get_custom['wr_date'];
						$wr_week = $get_custom['wr_week'];
						$wr_time = $get_custom['wr_time'];

						$wr_work_direct = $get_custom['wr_work_direct'];

						$wr_gender = $get_custom['wr_gender'];
						
						$wr_age_limit = $get_custom['wr_age_limit'];
						$wr_age = $get_custom['wr_age'];
						$wr_age_etc = $get_custom['wr_age_etc'];

						$wr_work_type = $get_custom['wr_work_type'];


						$que = array();
						$url = array();

						//if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							if($wr_job_type0 || $wr_job_type1 || $wr_job_type2 || $wr_job_type3 || $wr_job_type4 || $wr_job_type5 || $wr_job_type6 || $wr_job_type7 || $wr_job_type8){

								$job_type_que = " ( ";
								if($wr_job_type0){
									$job_type_que .= " `wr_job_type0` = '".$wr_job_type0."' ";
								}
								if($wr_job_type1){
									$job_type_que .= " or `wr_job_type1` = '".$wr_job_type1."' ";
								}
								if($wr_job_type2){
									$job_type_que .= " or `wr_job_type2` = '".$wr_job_type2."' ";
								}
								if($wr_job_type3){
									$job_type_que .= " or `wr_job_type3` = '".$wr_job_type3."' ";
								}
								if($wr_job_type4){
									$job_type_que .= " or `wr_job_type4` = '".$wr_job_type4."' ";
								}
								if($wr_job_type5){
									$job_type_que .= " or `wr_job_type5` = '".$wr_job_type5."' ";
								}
								if($wr_job_type6){
									$job_type_que .= " or `wr_job_type6` = '".$wr_job_type6."' ";
								}
								if($wr_job_type7){
									$job_type_que .= " or `wr_job_type7` = '".$wr_job_type7."' ";
								}
								if($wr_job_type8){
									$job_type_que .= " or `wr_job_type8` = '".$wr_job_type8."' ";
								}
								$job_type_que .= " ) ";
								
								array_push( $que, $job_type_que );

							}


							if( $wr_area0 || $wr_area1 || $wr_area2 || $wr_area3 || $wr_area4 || $wr_area5 ){

								$job_area_que = " ( ";
								if($wr_area0){
									$job_area_que .= " `wr_area0` = '".$wr_area0."' ";
								}
								if($wr_area1){
									$job_area_que .= " or `wr_area1` = '".$wr_area1."' ";
								}
								if($wr_area2){
									$job_area_que .= " or `wr_area2` = '".$wr_area2."' ";
								}
								if($wr_area3){
									$job_area_que .= " or `wr_area3` = '".$wr_area3."' ";
								}
								if($wr_area4){
									$job_area_que .= " or `wr_area4` = '".$wr_area4."' ";
								}
								if($wr_area5){
									$job_area_que .= " or `wr_area5` = '".$wr_area5."' ";
								}
								$job_area_que .= " ) ";

								array_push( $que, $job_area_que );

							}


							if($wr_home_work){
								array_push( $que, " `wr_home_work` = '".$wr_home_work."' " );
							}

							if($wr_date){
								array_push( $que, " `wr_date` = '".$wr_date."' " );
							}

							if($wr_week){
								array_push( $que, " `wr_week` = '".$wr_week."' " );
							}

							if($wr_time){
								array_push( $que, " `wr_time` = '".$wr_time."' " );
							}

							if($wr_work_direct){
								array_push( $que, " `wr_work_direct` = '".$wr_work_direct."' " );
							}

							if($wr_gender){	// 성별
								if($wr_gender=='1')
									$gender = 0;
								else if($wr_gender=='2')
									$gender = 1;

								$gender = $wr_gender;
								if($wr_gender>0) {
									array_push( $que, " `wr_gender` = '".$gender."' " );
								}
							}

							if($wr_age){	// 나이
								/*$wr_ages = explode('-',$wr_age);
								if(!$wr_age_limit)	// 나이 무관 아닐때
									array_push( $que, " ( `wr_age` between " . $wr_ages[0] . " and " . $wr_ages[1] ." ) " );*/

								if($get_custom['wr_age_limit']>0 && $get_custom['wr_age']>0) {
									$_chk = $get_custom['wr_age_limit']==1 ? '<=' : '>=';

									array_push($que, " `wr_age`".$_chk."'".$get_custom['wr_age']."'");
								}
								
							}

							if($wr_work_type){
								$work_types = explode(",",$wr_work_type);
								$work_types_cnt = count($work_types);
								$work_type_que = " ( ";
								for($i=0;$i<$work_types_cnt;$i++){
									if($work_types[$i]!=''){
										$_or = ($i != ($work_types_cnt-1)) ? 'or' : '';
										$work_type_que .= " INSTR(`wr_work_type`,'".$work_types[$i]."') " . $_or;
									}

								}
								$work_type_que .= " ) ";

								array_push( $que, $work_type_que);
							}


						//}


						array_push($url, 'page='.$page);
						array_push($url, 'page_rows='.$page_rows);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 맞춤 인재정보 타이틀 리스트 :: wr_id 기준
				function custom_titles( $wr_id ){

						if(!$wr_id || $wr_id=='') return false;

						$query = " select * from `".$this->custom_table."` where `wr_id` = '".$wr_id."' order by `no` desc ";

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}

				// 맞춤 인재정보 추출 :: no 기준 (단수)
				function get_custom( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->custom_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 맞춤 인재정보 마지막 no
				function get_last_no(){

						$query = " select * from `".$this->custom_table."` order by `no` desc ";

						$result = $this->query_fetch($query);

					
					return $result;
				}

				// 면접/입사 제안 리스트
				// wr_type 은 무조건 있어야 되고, mb_id, wr_id 를 기준으로 리스팅
				function proposal_list( $page="", $page_rows="", $con="" ){

						$query = " select * from `".$this->proposal_table."` " . $con . " order by `no` desc ";

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						//echo $query;

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}

				// 면접/입사 카운팅
				function proposal_counts( $wr_type, $mb_id="", $wr_id="" ){

						$query = " select * from `".$this->proposal_table."` where `wr_type` = '".$wr_type."' ";

						if($mb_id) $query .= " and `mb_id` = '".$mb_id."' ";
						if($wr_id) $query .= " and `wr_id` = '".$wr_id."' ";

						$result = $this->_queryR($query);


					return $result;

				}

				// 면접/입사 제의 정보 추출 :: 단수 (no 기준)
				function get_proposal( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->proposal_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				
				// 공고별 서비스 기간 확인
				function service_valid( $no ){

					global $utility;
					global $alba_control;

						if(!$no || $no=='') return false;

						$result = array();

						$get_alba = $alba_control->get_alba($no);

						$result['service_platinum'] = $utility->valid_day($get_alba['wr_service_platinum']);
						$result['service_platinum_text'] = "메인 플래티넘";
						$result['service_platinum_main_gold'] = $utility->valid_day($get_alba['wr_service_platinum_main_gold']);
						$result['service_platinum_main_gold_text'] = "메인 플래티넘 골드";
						$result['service_platinum_main_logo'] = $utility->valid_day($get_alba['wr_service_platinum_main_logo']);
						$result['service_platinum_main_logo_text'] = "메인 플래티넘 로고";

						$result['service_platinum_sub'] = $utility->valid_day($get_alba['wr_service_platinum_sub']);
						$result['service_platinum_sub_text'] = "채용정보 플래티넘";
						$result['service_platinum_sub_gold'] = $utility->valid_day($get_alba['wr_service_platinum_sub_gold']);
						$result['service_platinum_sub_gold_text'] = "채용정보 플래티넘 골드";
						$result['service_platinum_sub_logo'] = $utility->valid_day($get_alba['wr_service_platinum_sub_logo']);
						$result['service_platinum_sub_logo_text'] = "채용정보 플래티넘 로고";

						$result['service_prime'] = $utility->valid_day($get_alba['wr_service_prime']);
						$result['service_prime_text'] = "메인 프라임";
						$result['service_prime_main_gold'] = $utility->valid_day($get_alba['wr_service_prime_main_gold']);
						$result['service_prime_main_gold_text'] = "메인 프라임 골드";
						$result['service_prime_main_logo'] = $utility->valid_day($get_alba['wr_service_prime_main_logo']);
						$result['service_prime_main_logo_text'] = "메인 프라임 로고";

						$result['service_grand'] = $utility->valid_day($get_alba['wr_service_grand']);
						$result['service_grand_text'] = "메인 그랜드";
						$result['service_grand_main_gold'] = $utility->valid_day($get_alba['wr_service_grand_main_gold']);
						$result['service_grand_main_gold_text'] = "메인 그랜드 골드";
						$result['service_grand_main_logo'] = $utility->valid_day($get_alba['wr_service_grand_main_logo']);
						$result['service_grand_main_logo_text'] = "메인 그랜드 로고";

						$result['service_banner'] = $utility->valid_day($get_alba['wr_service_banner']);
						$result['service_banner_text'] = "메인 배너형";
						$result['service_banner_main_gold'] = $utility->valid_day($get_alba['wr_service_banner_main_gold']);
						$result['service_banner_main_gold_text'] = "메인 배너형 골드";

						$result['service_banner_sub'] = $utility->valid_day($get_alba['wr_service_banner_sub']);
						$result['service_banner_sub_text'] = "채용정보 배너형";
						$result['service_banner_sub_gold'] = $utility->valid_day($get_alba['wr_service_banner_sub_gold']);
						$result['service_banner_sub_gold_text'] = "채용정보 배너형 골드";

						$result['service_list'] = $utility->valid_day($get_alba['wr_service_list']);
						$result['service_list_text'] = "메인 리스트형";
						$result['service_list_main_gold'] = $utility->valid_day($get_alba['wr_service_list_main_gold']);
						$result['service_list_main_gold_text'] = "메인 리스트형 골드";

						$result['service_list_sub'] = $utility->valid_day($get_alba['wr_service_list_sub']);
						$result['service_list_sub_text'] = "채용정보 리스트형";
						$result['service_list_sub_gold'] = $utility->valid_day($get_alba['wr_service_list_sub_gold']);
						$result['service_list_sub_gold_text'] = "채용정보 리스트형 골드";

						$result['service_basic'] = $utility->valid_day($get_alba['wr_service_basic']);
						$result['service_basic_text'] = "메인 일반";
						$result['service_basic_sub'] = $utility->valid_day($get_alba['wr_service_basic_sub']);
						$result['service_basic_sub_text'] = "채용정보 일반";


						/*
						$result['wr_service_busy'] = $get_alba['wr_service_busy'];
						$result['wr_service_neon'] = $get_alba['wr_service_neon'];
						$result['wr_service_bold'] = $get_alba['wr_service_bold'];
						$result['wr_service_color'] = $get_alba['wr_service_color'];
						$result['wr_service_icon'] = $get_alba['wr_service_icon'];
						$result['wr_service_blink'] = $get_alba['wr_service_blink'];
						$result['wr_service_jump'] = $get_alba['wr_service_jump'];
						*/

					
					return $result;


				}


				/**
				* 파일 업로드시 확장자 구분
				*/
				function _file(){

					global $config;

						$result = implode('|',$config->upload_extension);

					return $result;

				}

				/**
				* 에러코드에 맞는 에러를 토해낸다.
				*/
				function _errors( $err_code ){

						$result = $this->fail_code[$err_code];

					return $result;

				}

				/**
				* 완료코드에 맞는 에러를 토해낸다.
				*/
				function _success( $success_code ){

						$result = $this->success_code[$success_code];

					return $result;

				}

		}	// class end.
?>