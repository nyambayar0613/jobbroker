<?php
		/**
		* /application/nad/alba/model/alice_alba_model.class.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Model Class
		* @Comment :: 관리자측 정규직 관리 모델 클래스
		*/
		class alice_alba_model extends DBConnection {

			var $alba_table	= "alice_alba";

			var $success_code = array(
					'0000' => '정규직 공고 등록이 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '정규직 공고 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '정규직 공고 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '정규직 공고 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '서비스승인 중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);


				// 정규직 정보 추출 (단수)
				function get_alba( $no ){

						if( !$no || $no == '' ) return false;

						$query = " select * from `".$this->alba_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 리스팅
				function __AlbaList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->alba_table."` " . $_add['que'] . $con . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/*
						echo "<div style='color:#fff;'>";
						echo $query;
						echo "</div>";
						*/
						
						

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// 정규직 검색
				function _Search( ){

					global $utility, $config;

						$mode = $_GET['mode'];

						$page = $_GET['page'];

						$page_rows = $_GET['page_rows'];

						//$order = " `no` desc ";

						$order = " `no` ";

						$sort = $_GET['sort'];	 // 정렬 기준
						
						if($sort) $order = " `".$sort."` ";
						
						$flag = $_GET['flag'];	 // 정렬 순서
						
						$order .= ($flag) ? $flag : " desc ";


						// 등록일
						$start_dayAll = $_GET['start_dayAll'];
						$start_day = urldecode($_GET['start_day']);
						$end_day = urldecode($_GET['end_day']);

						$wr_service = $_GET['wr_service'];

						$wr_job_type0 = $_GET['wr_job_type_0'];
						$wr_job_type1 = $_GET['wr_job_type_1'];
						$wr_job_type2 = $_GET['wr_job_type_2'];

						$wr_area0 = $_GET['wr_area0'];
						$wr_area1 = $_GET['wr_area1'];

						$wr_career_type = $_GET['wr_career_type'];
						$wr_career = $_GET['wr_career'];
						$wr_career_type_0 = $_GET['wr_career_type_0'];

						$wr_gender = $_GET['wr_gender'];

						$wr_ability = $_GET['wr_ability'];
						$wr_ability_0 = $_GET['wr_ability_0'];

						$wr_volume_date = $_GET['wr_volume_date'];
						$wr_volume_always = $_GET['wr_volume_always'];
						$wr_volume_end = $_GET['wr_volume_end'];

						$wr_requisition = $_GET['wr_requisition'];

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = urldecode($_GET['search_keyword']);	 // 검색 키워드

						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드


							## 등록일 검색 #################################################################################
							if(!$start_dayAll){	// 전체가 아닐 경우에만

								// 두 값이 모두 다 있는 경우
								if( $start_day!='' && $end_day!='' ) {		// start_day && end_day

									array_push( $que, " ( `wr_wdate` between '" . $start_day . " 00:00:00' and '" . $end_day . " 23:59:59' ) " );

								// 두 값이 모두 다 없고 둘중 하나만 있는 경우
								} else {

									if( $start_day!='' ) {		// start_day
										array_push( $que, " `wr_wdate` >= '" . $start_day . "' " );
									}

									if( $end_day!='' ) {		// end_day
										array_push( $que, " `wr_wdate` <= '" . $end_day . "' " );
									}

								}

								array_push($url, "start_day=".$start_day."&end_day=".$end_day);

							}
							## //등록일 검색 ###############################################################################


							## 서비스 검색 ################################################################################
							if($wr_service){

								$wr_service_cnt = count($wr_service);

								$service_arr = array( 
									"platinum" => " `wr_service_platinum` >= now() ",									
									"grand" => " `wr_service_grand` >= now() ",
									"special" => " `wr_service_special` >= now() ",
									"basic" => " `wr_service_basic` >= now() ",											
									"busy" => " `wr_service_busy` >= now() ",							
									"logo" => " `wr_service_platinum_main_logo` >= now() or `wr_service_grand_main_logo` >= now() or `wr_service_special_main_logo` >= now() ",
									"neon" => " `wr_service_neon` >= now() ",
									"icon" => " `wr_service_icon` >= now() ",
									"blink" => " `wr_service_blink` >= now() ",
								);

								$service_que = " ( ";

								for($i=0;$i<$wr_service_cnt;$i++){
									$_or = ($i != ($wr_service_cnt-1)) ? " or " : "";
									$wr_services = $wr_service[$i];

									$service_que .= $service_arr[$wr_services] . $_or;
									array_push($url, "wr_service[]=".$wr_services);
									
								}

								$service_que .= " ) ";

								array_push($que, $service_que);
								

							}
							## //서비스 검색 ###############################################################################

							## 지역 검색 #################################################################################
							if($wr_area0){	
								array_push($que, " ( INSTR(`wr_area_0`, '".$wr_area0."') or INSTR(`wr_area_1`, '".$wr_area0."') or INSTR(`wr_area_2`, '".$wr_area0."') )  ");
								array_push($url, "wr_area0=".$wr_area0);								
							}
							if($wr_area1){	
								array_push($que, " ( INSTR(`wr_area_0`,  '".$wr_area1."') or INSTR(`wr_area_1`,  '".$wr_area1."') or INSTR(`wr_area_2`,  '".$wr_area1."') )  ");
								array_push($url, "wr_area1=".$wr_area1);
							}						
							## //지역 검색 ################################################################################

							## 직종 검색 #################################################################################
							if($wr_job_type0){	
								array_push($que, " ( `wr_job_type0` = '".$wr_job_type0."' or `wr_job_type3` = '".$wr_job_type0."' or `wr_job_type6` = '".$wr_job_type0."' ) ");
								array_push($url, "wr_job_type_0=".$wr_job_type0);
							}
							if($wr_job_type1){
								array_push($que, " ( `wr_job_type1` = '".$wr_job_type1."' or `wr_job_type4` = '".$wr_job_type1."' or `wr_job_type7` = '".$wr_job_type1."' ) ");
								array_push($url, "wr_job_type_1=".$wr_job_type1);
							}
							if($wr_job_type2){
								array_push($que, " ( `wr_job_type2` = '".$wr_job_type2."' or `wr_job_type5` = '".$wr_job_type2."' or `wr_job_type8` = '".$wr_job_type2."' ) ");
								array_push($url, "wr_job_type_2=".$wr_job_type2);
							}
							## //직종 검색 ################################################################################


							## 경력 검색 ################################################################################
							if($wr_career_type){
								if($wr_career_type=='1'){	// 신입
									if($wr_career_type_0){	// 경력 무관
										array_push($que, " `wr_career_type` in ('".$wr_career_type."', '0') ");
									} else {
										array_push($que, " `wr_career_type` = '".$wr_career_type."' ");
									}
								} else if($wr_career_type=='2'){	 // 경력
									if($wr_career_type_0){	// 경력 무관
										array_push($que, " `wr_career_type` in ('".$wr_career_type."', '0') and `wr_career` = '".$wr_career."' ");
									} else {
										array_push($que, " `wr_career_type` = '".$wr_career_type."' and `wr_career` = '".$wr_career."' ");
									}
								}
							}
							## //경력 검색 ################################################################################


							## 성별 검색 #################################################################################
							if($wr_gender){	//  || $wr_gender=='0'
								array_push($que, " `wr_gender` = '".$wr_gender."' ");
								array_push($url, "wr_gender=".$wr_gender);

							}
							## //성별 검색 ################################################################################


							## 학력 검색 #################################################################################
							if($wr_ability){
								$wr_ability_cnt = count($wr_ability);
								$wr_ability_arr = array();
								for($i=0;$i<$wr_ability_cnt;$i++){
									$wr_ability_arr[$i] = "'".$wr_ability[$i]."'";
								}
								$wr_abilities = implode($wr_ability_arr,',');
								array_push($que, " `wr_ability` in (".$wr_abilities.") ");
							}
							## //학력 검색 ################################################################################


							## 채용기간 검색 ##############################################################################
							if($wr_volume_date){
								$volume_que = " ( ";
									$volume_que .= " `wr_volume_date` = '".$wr_volume_date."' ";
									if($wr_volume_always){	// 상시모집
										$volume_que .= " or `wr_volume_always` = '".$wr_volume_always."' ";
									}
									if($wr_volume_end){	// 채용시까지
										$volume_que .= " or `wr_volume_end` = '".$wr_volume_end."' ";
									}
								$volume_que .= " ) ";
							}
							## //채용기간 검색 #############################################################################


							## 접수방법 검색 ##############################################################################
							if($wr_requisition){
								array_push($que, " INSTR(`wr_requisition`, '".$wr_requisition."') ");
							}
							## //접수방법 검색 ##############################################################################


							## 필드선택에 따른 검색 ##########################################################################
							if($search_field==''){	// 통합검색 일때

								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que  = "( INSTR(LOWER(`wr_company_name`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`wr_person`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_id`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_subject`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_content`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`wr_phone`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_hphone`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_email`), LOWER('".$search_keyword."')) )";
								} else {
									$search_que  = "( ";
									$search_que .= " INSTR(`wr_company_name`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_company_name`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_person`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_id`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_subject`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_content`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_phone`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_hphone`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_email`, '".$search_keyword."') ";
									$search_que .= ") ";
								}

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							} else {	 // 필드 선택

								if(preg_match("/[a-zA-Z]/", $search_keyword))
									$search_que = " INSTR(LOWER(`".$search_field."`), LOWER('".$search_keyword."')) ";
								else
									$search_que = " INSTR(`".$search_field."`, '".$search_keyword."') ";

								array_push($url, "search_field=" . urlencode($search_field) . "&search_keyword=" . urlencode($search_keyword));

							}
							## //필드선택에 따른 검색 #########################################################################

							array_push($que, $search_que);


						}

						array_push($url, 'page='.$page);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " where ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 아이디를 기준으로 추출
				function get_alba_for_id( $wr_id ){

						$query = " select * from `".$this->alba_table."` where `wr_id` = '".$wr_id."' and `wr_open` = 1 and `wr_report` = 0 and `is_delete` = 0 order by `no` desc ";

						$result = $this->query_fetch_rows($query);


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