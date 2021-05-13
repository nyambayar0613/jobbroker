<?php
		/**
		* /application/nad/alba/model/alice_alba_resume_model.class.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Resume Model Class
		* @Comment :: 관리자측 정규직 이력서 관리 모델 클래스
		*/
		class alice_alba_resume_model extends DBConnection {

			var $resume_table	= "alice_alba_resume";

			var $language_date = array( 0 => "6개월 이하", 1 => "1년", 2 => "1년 미만", 3 => "2년", 4 => "2년 미만", 5 => "3년", 6 => "3년 미만", 7 => "4년", 8 => "4년 미만", 9 => "5년", 10 => "5년 미만", 11 => "6년", 12 => "6년 미만", 13 => "7년", 14 => "7년 미만", 15 => "8년", 16 => "8년 미만", 17 => "9년", 18 => "9년 미만", 19 => "10년", 20 => "10년 미만", 21 => "10년 이상" );

			var $gender_val = array( 0 => "남자", 1 => "여자" );
			var $gender_text = array( 0 => "男", 1 => "女" );

			var $success_code = array(
					'0000' => '이력서 등록이 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '이력서 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '이력서 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '이력서 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '서비스 기간 부여중 오류가 발생하였습니다..\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0004' => '신고 이력서 복원중 오류가 발생하였습니다..\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);

				// 리스팅
				function __ResumeList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->resume_table."` " . $_add['que'] . $con . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/* 질의문 확인 
						echo "<div style='color:#fff;'>";
						echo $query;
						echo "</div>";
						*/

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];
						$result['q'] = $query;


					
					return $result;

				}


				// 이력서 검색
				function _Search( ){

					global $utility, $config;
					global $category_control;

						$mode = $_GET['mode'];

						$order = " `no` ";

						$sort = $_GET['sort'];

						if($sort) $order = " `" . $sort . "` ";

						$flag = $_GET['flag'];

						$order .= ($flag) ? " ".$flag." " : " desc ";

						// 등록일
						$start_dayAll = $_GET['start_dayAll'];
						$start_day = urldecode($_GET['start_day']);
						$end_day = urldecode($_GET['end_day']);

						$wr_service = $_GET['wr_service'];

						$wr_job_type0 = $_GET['wr_job_type_0'];
						$wr_job_type1 = $_GET['wr_job_type_1'];
						$wr_job_type2 = $_GET['wr_job_type_2'];

						$wr_career_type = $_GET['wr_career_type'];
						$wr_career = $_GET['wr_career'];
						$wr_career_type_0 = $_GET['wr_career_type_0'];

						$wr_gender = $_GET['wr_gender'];

						$search_field = $_GET['search_field'];	// 검색 필드

						$search_keyword = urldecode( trim($_GET['search_keyword']) );	 // 검색 키워드

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

							}
							## //등록일 검색 ###############################################################################


							## 서비스 검색 ################################################################################
							if($wr_service){

								$wr_service_cnt = count($wr_service);

								$service_arr = array( 
									"main_focus" => " `wr_service_main_focus` >= now() ",
									"main_focus_gold" => " `wr_service_main_focus_gold` >= now() ",
									"basic" => " `wr_service_basic` >= now() ",
									"neon" => " `wr_service_neon` >= now() ",
									"bold" => " `wr_service_bold` >= now() ",
									"color" => " `wr_service_color` >= now() ",
									"blink" => " `wr_service_blink` >= now() ",
									"icon" => " `wr_service_icon` >= now() ",
									"busy" => " `wr_service_busy` >= now() ",
								);

								$service_que = " ( ";

								for($i=0;$i<$wr_service_cnt;$i++){
									$_or = ($i != ($wr_service_cnt-1)) ? " or " : "";
									$wr_services = $wr_service[$i];

									$service_que .= $service_arr[$wr_services] . $_or;
									
								}

								$service_que .= " ) ";

								array_push($que, $service_que);

							}
							## //서비스 검색 ###############################################################################


							## 경력 검색 ################################################################################
							if($wr_career_type){
								array_push($que, " `wr_career_use` = ".$wr_career_type." " );
							}
							## //경력 검색 ################################################################################


							## 직종 검색 #################################################################################
							if($wr_job_type0){	
								array_push($que, " `wr_job_type0` = '".$wr_job_type0."' ");
							}
							if($wr_job_type1){
								array_push($que, " `wr_job_type1` = '".$wr_job_type1."' ");
							}
							if($wr_job_type2){
								array_push($que, " `wr_job_type2` = '".$wr_job_type2."' ");
							}
							## //직종 검색 ################################################################################


							## 성별 검색 #################################################################################
							if($wr_gender){
								$wr_genders = ($wr_gender=='1') ? "0" : "1";
								array_push($que, " `wr_gender` = '".$wr_genders."' ");
							}
							## //성별 검색 ################################################################################

							
							## 필드선택에 따른 검색 ##########################################################################
							if($search_field==''){	// 통합검색 일때

								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que .= " INSTR(LOWER(`wr_subject`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_introduce`), LOWER('".$search_keyword."')) ) ";
								} else {
									$search_que = "( INSTR(`wr_subject`, '".$search_keyword."') or INSTR(`wr_introduce`, '".$search_keyword."') ) ";
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

						array_push($url, 'sort='.$sort);
						array_push($url, 'page_rows='.$page_rows);

						$que = is_array($que) ? implode(' and ',$que) : '';

						if($page_rows) array_push( $url, "page_rows=" . $page_rows );
						if($view_type) array_push( $url, "view_type=" . $view_type );
						if($sort) array_push( $url, "sort=" . $sort );
						if($flag) array_push( $url, "flag=" . $flag );

						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " where ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}

				// 정규직 이력서 정보 추출 (단수)
				function get_resume( $no ){

						if( !$no || $no == '' ) return false;

						$query = " select * from `".$this->resume_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				
				// 정규직 이력서 정보 추출 :: wr_id 기준
				function get_resume_for_id( $wr_id ){

						if( !$wr_id || $wr_id == '' ) return false;

						$query = " select * from `".$this->resume_table."` where `wr_id` = '".$wr_id."' and `wr_open` = 1 and `is_delete` = 0 ";

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