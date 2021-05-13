<?php
		/**
		* /application/main/model/alice_search_model.class.php
		* @author Harimao
		* @since 2013/10/24
		* @last update 2014/04/06
		* @Module v3.5 ( Alice ) - b1.0
		* @Brief :: Search Model Class
		* @Comment :: 통합/상세 검색 모델 클래스
		*/
		class alice_search_model extends DBConnection {

			var $alba_table				= "alice_alba";				// 정규직 공고 테이블
			var $alba_resume_table	= "alice_alba_resume";	// 정규직 이력서 테이블
			var $board_table			= "alice_board";				// 게시판 정보
			var $board_new_table	= "alice_board_new";		// 게시판 최신글
			var $search_table			= "alice_search";			// 통합 검색 테이블

			var $success_code = array(
					'0000' => '',
			);

			var $fail_code = array(
					'0000' => '',
			);

				// 정규직 상세 검색
				function __AlbaSearch( $page="", $page_rows="", $con="" ){

						$_add = $this->_AlbaSearch( );

						$query = " select * from `".$this->alba_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						//echo "<p><br/><strong>Query :: " . $query."</strong><br/><br/></p>";	// 쿼리 확인

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;


				}

				function _AlbaSearch(){

					global $utility, $config;


						$mode = $_GET['mode'];

						$order = " `wr_wdate` ";

						$view_type = $_GET['view_type'];

						$sort = $_GET['sort'];

						if($sort) $order = " `" . $sort . "` ";

						$flag = $_GET['flag'];

						$order .= ($flag) ? " ".$flag." " : " desc ";


						$search_field = $_GET['search_field'];	// 검색 필드

						//$search_keyword = preg_replace( "/\//", "\/", trim( urldecode($_GET['search_keyword']) ) );	 // 다른 방식
						$search_keyword = urldecode( trim($_GET['search_keyword']) );	 // 검색 키워드


						$que = array();
						$url = array();

						// 검색 조건 시작~
						if($mode=='search'){

							array_push($url, "mode=" . $mode);

							array_push($url, "view_type=" . $view_type);
							array_push($url, "sort=" . $sort);

							## 지역 검색 ######################################################################################################
							$wr_area_0 = $_GET['wr_area_0'];	// 1차 지역 배열
							$wr_area_0_cnt = count($wr_area_0);
							$wr_area_1 = $_GET['wr_area_1'];	// 2차 지역 배열
							$wr_area_1_cnt = count($wr_area_1);
							$wr_area_2 = $_GET['wr_area_2'];	// 3차 지역 배열
							$wr_area_2_cnt = count($wr_area_2);

							$area_que_1 = array();
							$area_que_2 = array();

							$area_que = " ( ";

							for($i=0;$i<$wr_area_0_cnt;$i++){	// 1차 지역 검색
								$_and = ($wr_area_0_cnt != $i+1) ? " or " : "";
								$area_que .= " ( INSTR( `wr_area_0`, '".$wr_area_0[$i]."' ) or INSTR( `wr_area_1`, '".$wr_area_0[$i]."' ) or INSTR( `wr_area_2`, '".$wr_area_0[$i]."' ) ) " . $_and;
								array_push($url, "wr_area_0[]=" . $wr_area_0[$i]);
							}

							if($wr_area_1){	// 2차 지역 데이터 배열 가공
								foreach($wr_area_1 as $area_1_key => $area_1_val){
									$area_1_val_cnt = count($area_1_val);
									for($j=0;$j<$area_1_val_cnt;$j++){
										if( stristr($area_1_val[$j],'all') ){
											$is_all = true;
										} else {
											$is_all = false;
											array_push($area_que_1,$area_1_val[$j]);
										}
										array_push($url, "wr_area_1[".$area_1_key."][]=" . $area_1_val[$j]);
									}
								}
								if(!$is_all)
									$area_que .= " and ";
							}
							
							$area_que_1_cnt = count($area_que_1);
							
							for($i=0;$i<$area_que_1_cnt;$i++){	// 2차 지역 검색
								$_and = ($area_que_1_cnt != $i+1) ? " or " : "";
								$area_que .= " ( INSTR( `wr_area_0`, '".$area_que_1[$i]."' ) or INSTR( `wr_area_1`, '".$area_que_1[$i]."' ) or INSTR( `wr_area_2`, '".$area_que_1[$i]."' ) ) " . $_and;
								//array_push($url, "wr_area_1[]=" . $area_que_1[$i]);
							}

							if($wr_area_2){	// 3차 지역 데이터 배열 가공
								foreach($wr_area_2 as $area_2_key => $area_2_val){
									foreach($area_2_val as $key => $val){
										$val_cnt = count($val);
										for($j=0;$j<$val_cnt;$j++){
											if( stristr($val[$j],'all') ){
												$is_all = true;
											} else {
												$is_all = false;
												array_push($area_que_2,$val[$j]);
											}
											array_push($url, "wr_area_2[".$area_2_key."][".$key."][]=" . $val[$j]);
										}
									}
								}
								if(!$is_all)
									$area_que .= " and ";
							}

							$area_que_2_cnt = count($area_que_2);
							
							for($i=0;$i<$area_que_2_cnt;$i++){	// 3차 지역 검색
								$_and = ($area_que_2_cnt != $i+1) ? " or " : "";
								$area_que .= " ( INSTR( `wr_area_0`, '".$area_que_2[$i]."' ) or INSTR( `wr_area_1`, '".$area_que_2[$i]."' ) or INSTR( `wr_area_2`, '".$area_que_2[$i]."' ) ) " . $_and;
							}
							
							$area_que .= " ) ";

							if($wr_area_0 || $wr_area_1 || $wr_area_2){
								array_push($que, $area_que);
							}
							## //지역 검색 ######################################################################################################


							## 역세권 검색 ###############################################################################################################
							$wr_subway_0 = $_GET['wr_subway_0'];	 // 1차 역세권 배열
							$wr_subway_0_cnt = count($wr_subway_0);
							$wr_subway_1 = $_GET['wr_subway_1'];	 // 2차 역세권 배열
							$wr_subway_1_cnt = count($wr_subway_1);
							$wr_subway_2 = $_GET['wr_subway_2'];	 // 3차 역세권 배열
							$wr_subway_2_cnt = count($wr_subway_2);

							$subway_que_1 = array();
							$subway_que_2 = array();

							$subway_que = " ( ";

							for($i=0;$i<$wr_subway_0_cnt;$i++){	// 1차 역세권 검색
								
								$_and = ($wr_subway_0_cnt != $i+1) ? " and " : "";
								$subway_que .= " `wr_subway_area_0` = '".$wr_subway_0[$i]."'  or `wr_subway_area_1` = '".$wr_subway_0[$i]."' or `wr_subway_area_2` = '".$wr_subway_0[$i]."' " . $_and;
								array_push($url, "wr_subway_0[]=" . $wr_subway_0[$i]);

							}

							if($wr_subway_1){	// 2차 역세권 데이터 배열 가공
								foreach($wr_subway_1 as $subway_1_key => $subway_1_val){
									$subway_1_val_cnt = count($subway_1_val);
									for($j=0;$j<$subway_1_val_cnt;$j++){
										array_push($subway_que_1,$subway_1_val[$j]);
										array_push($url, "wr_subway_1[".$subway_1_key."][]=" . $subway_1_val[$j]);
									}
								}
								$subway_que .= " and ";
							}

							$subway_que_1_cnt = count($subway_que_1);
							
							for($i=0;$i<$subway_que_1_cnt;$i++){	// 2차 역세권 검색
								$_and = ($subway_que_1_cnt != $i+1) ? " and " : "";
								$subway_que .= " `wr_subway_line_0` = '".$subway_que_1[$i]."' or `wr_subway_line_1` = '".$subway_que_1[$i]."' or `wr_subway_line_2` = '".$subway_que_1[$i]."' " . $_and;
							}


							if($wr_subway_2){	// 3차 역세권 데이터 배열 가공
								foreach($wr_subway_2 as $subway_2_key => $subway_2_val){
									foreach($subway_2_val as $key => $val){
										$val_cnt = count($val);
										for($j=0;$j<$val_cnt;$j++){
											array_push($subway_que_2,$val[$j]);
											array_push($url, "wr_subway_2[".$subway_2_key."][".$key."][]=" . $val[$j]);
										}
									}
								}
								$subway_que .= " and ";
							}

							$subway_que_2_cnt = count($subway_que_2);

							for($i=0;$i<$subway_que_2_cnt;$i++){	// 3차 역세권 검색
								$_and = ($subway_que_2_cnt != $i+1) ? " and " : "";
								$subway_que .= " `wr_subway_station_0` = '".$subway_que_2[$i]."' or `wr_subway_station_1` = '".$subway_que_2[$i]."' or `wr_subway_station_2` = '".$subway_que_2[$i]."' " . $_and;
							}

							$subway_que .= " ) ";

							if($wr_subway_0 || $wr_subway_1 || $wr_subway_2){
								array_push($que, $subway_que);
							}
							## //역세권 검색 ###############################################################################################################


							## 직종 검색 ###############################################################################################################
							$wr_jobtype_0 = $_GET['wr_jobtype_0'];	 // 1차 직종 배열
							$wr_jobtype_0_cnt = count($wr_jobtype_0);
							$wr_jobtype_1 = $_GET['wr_jobtype_1'];	 // 2차 직종 배열
							$wr_jobtype_1_cnt = count($wr_jobtype_1);
							$wr_jobtype_2 = $_GET['wr_jobtype_2'];	 // 3차 직종 배열
							$wr_jobtype_2_cnt = count($wr_jobtype_2);

							$jobtype_que_1 = array();
							$jobtype_que_2 = array();

							$jobtype_first = " ( ";
							for($i=0;$i<$wr_jobtype_0_cnt;$i++){	// 1차 직종 검색
								$_or = ($i != ($wr_jobtype_0_cnt-1)) ? " or " : "";
								$jobtype_first .= " `wr_job_type0` = '".$wr_jobtype_0[$i]."' " . $_or;
								array_push($url, "wr_jobtype_0[]=" . $wr_jobtype_0[$i]);
							}
							$jobtype_first .= " ) ";

							$jobtype_first .= " or ( ";
							for($i=0;$i<$wr_jobtype_0_cnt;$i++){	// 1차 직종 검색
								$_or = ($i != ($wr_jobtype_0_cnt-1)) ? " or " : "";
								$jobtype_first .= " `wr_job_type3` = '".$wr_jobtype_0[$i]."' " . $_or;
							}
							$jobtype_first .= " ) ";

							$jobtype_first .= " or ( ";
							for($i=0;$i<$wr_jobtype_0_cnt;$i++){	// 1차 직종 검색
								$_or = ($i != ($wr_jobtype_0_cnt-1)) ? " or " : "";
								$jobtype_first .= " `wr_job_type6` = '".$wr_jobtype_0[$i]."' " . $_or;
							}
							$jobtype_first .= " ) ";

							if($wr_jobtype_1){	 // 2차 직종 데이터 배열 가공
								foreach($wr_jobtype_1 as $jobtype_1_key => $jobtype_1_val){
									$jobtype_1_val_cnt = count($jobtype_1_val);
									for($j=0;$j<$jobtype_1_val_cnt;$j++){
										array_push($jobtype_que_1,$jobtype_1_val[$j]);
										array_push($url, "wr_jobtype_1[".$jobtype_1_key."][]=" . $jobtype_1_val[$j]);
									}
								}
							}

							$jobtype_que_1_cnt = count($jobtype_que_1);

							$jobtype_second = " ( ";
							for($i=0;$i<$jobtype_que_1_cnt;$i++){	// 2차 직종 검색
								$_or = ($i != ($jobtype_que_1_cnt-1)) ? " or " : "";
								$jobtype_second .= " `wr_job_type1` = '".$jobtype_que_1[$i]."' " . $_or;
							}
							$jobtype_second .= " ) ";

							$jobtype_second .= " or ( ";
							for($i=0;$i<$jobtype_que_1_cnt;$i++){	// 2차 직종 검색
								$_or = ($i != ($jobtype_que_1_cnt-1)) ? " or " : "";
								$jobtype_second .= " `wr_job_type4` = '".$jobtype_que_1[$i]."' " . $_or;
							}
							$jobtype_second .= " ) ";

							$jobtype_second .= " or ( ";
							for($i=0;$i<$jobtype_que_1_cnt;$i++){	// 2차 직종 검색
								$_or = ($i != ($jobtype_que_1_cnt-1)) ? " or " : "";
								$jobtype_second .= " `wr_job_type7` = '".$jobtype_que_1[$i]."' " . $_or;
							}
							$jobtype_second .= " ) ";

							if($wr_jobtype_2){	 // 3차 직종 데이터 배열 가공
								foreach($wr_jobtype_2 as $jobtype_2_key => $jobtype_2_val){
									foreach($jobtype_2_val as $key => $val){
										$val_cnt = count($val);
										for($j=0;$j<$val_cnt;$j++){
											array_push($jobtype_que_2,$val[$j]);
											array_push($url, "wr_jobtype_2[".$jobtype_2_key."][".$key."][]=" . $val[$j]);
										}
									}
								}
							}

							$jobtype_que_2_cnt = count($jobtype_que_2);

							$jobtype_third = " ( ";
							for($i=0;$i<$jobtype_que_2_cnt;$i++){	// 2차 직종 검색
								$_or = ($i != ($jobtype_que_2_cnt-1)) ? " or " : "";
								$jobtype_third .= " `wr_job_type2` = '".$jobtype_que_2[$i]."' " . $_or;
							}
							$jobtype_third .= " ) ";

							$jobtype_third .= " or ( ";
							for($i=0;$i<$jobtype_que_2_cnt;$i++){	// 2차 직종 검색
								$_or = ($i != ($jobtype_que_2_cnt-1)) ? " or " : "";
								$jobtype_third .= " `wr_job_type5` = '".$jobtype_que_2[$i]."' " . $_or;
							}
							$jobtype_third .= " ) ";

							$jobtype_third .= " or ( ";
							for($i=0;$i<$jobtype_que_2_cnt;$i++){	// 2차 직종 검색
								$_or = ($i != ($jobtype_que_2_cnt-1)) ? " or " : "";
								$jobtype_third .= " `wr_job_type8` = '".$jobtype_que_2[$i]."' " . $_or;
							}
							$jobtype_third .= " ) ";

							if($wr_jobtype_0) array_push($que, " (" . $jobtype_first . ") ");			// 1차 직종
							if($wr_jobtype_1) array_push($que, " (" . $jobtype_second . ") ");		// 2차 직종
							if($wr_jobtype_2) array_push($que, " (" . $jobtype_third . ") ");			// 3차 직종
							## //직종 검색 ##############################################################################################################


							## 대학가 검색 ##############################################################################################################
							$wr_college_area = $_GET['wr_college_area'];	 // 대학가
							if($wr_college_area){
								array_push($que, " `wr_college_area` = '".$wr_college_area."' ");
								array_push($url, "wr_college_area=".$wr_college_area);
							}
							$wr_college_vicinity = $_GET['wr_college_vicinity'];	// 인근대학
							if($wr_college_vicinity){
								array_push($que, " `wr_college_vicinity` = '".$wr_college_vicinity."' ");
								array_push($url, "wr_college_vicinity=".$wr_college_vicinity);
							}
							## //대학가 검색 #############################################################################################################


							## 근무조건 검색 #############################################################################################################
							$wr_date = $_GET['wr_date'];	 // 근무기간
							if($wr_date){
								$wr_date_cnt = count($wr_date);
								$wr_date_arr = array();
								for($i=0;$i<$wr_date_cnt;$i++){
									$wr_date_arr[$i] = "'".$wr_date[$i]."'";
									array_push($url, "wr_date[]=".$wr_date[$i]);
								}
								$wr_date_search = @implode($wr_date_arr,", ");
								array_push($que, " `wr_date` in (" . $wr_date_search.") ");
							}
							$wr_week = $_GET['wr_week'];	 // 근무요일
							if($wr_week){
								$wr_week_cnt = count($wr_week);
								$wr_week_arr = array();
								for($i=0;$i<$wr_week_cnt;$i++){
									$wr_week_arr[$i] = "'".$wr_week[$i]."'";
									array_push($url, "wr_week[]=".$wr_week[$i]);
								}
								$wr_week_search = @implode($wr_week_arr,", ");
								array_push($que, " `wr_week` in (" . $wr_week_search.") ");
							}
							$wr_stime = $_GET['wr_stime'];	// 근무 시작 시간
							$wr_etime = $_GET['wr_etime'];	// 근무 종료 시간
							$wr_time_conference = $_GET['wr_time_conference'];	// 시간협의
							/*
							if($wr_stime[0]){
								$wr_time_que = " ( ";
								$wr_stimes = @implode($wr_stime,':');
								$wr_time_que .= " `wr_stime` >= '".$wr_stimes."' ";
								array_push($url, "wr_stime[]=".$wr_stime[0]);
								array_push($url, "wr_stime[]=".$wr_stime[1]);
								if($wr_etime[0]){
									$wr_etimes = @implode($wr_etime,':');
									$wr_time_que .= " and `wr_etime` >= '".$wr_etimes."' ";
									$wr_time_que .= " ) ";
									array_push($url, "wr_etime[]=".$wr_etime[0]);
									array_push($url, "wr_etime[]=".$wr_etime[1]);
								} else {
									$wr_time_que .= " ) ";
								}
							array_push($que, $wr_time_que);
							}
							*/
							if( !$wr_time_conference && ($wr_stime[0] != "" || $wr_etime[0] != "") ){	// 협의가 없을때
								$time_que = "(";
								if($wr_stime[0]){
									$time_que .=  " `wr_stime` >= '".implode($wr_stime,':')."' ";
									array_push($url, "wr_stime[]=".$wr_stime[0]);
									array_push($url, "wr_stime[]=".$wr_stime[1]);
								}
								if($wr_etime[0]){
									$time_que .=  " and `wr_etime` <= '".implode($wr_etime,':')."' ";
									array_push($url, "wr_etime[]=".$wr_etime[0]);
									array_push($url, "wr_etime[]=".$wr_etime[1]);
								}
								$time_que .= ")";
								array_push( $que, $time_que );
							} else if($wr_time_conference) {	 // 시간협의
								array_push( $que, " `wr_time_conference` = '1' " );
								array_push($url, "wr_time_conference=".$wr_time_conference);
							}
							## //근무조건 검색 ############################################################################################################


							## 급여조건 검색 ############################################################################################################
							$wr_pay_type = $_GET['wr_pay_type'];	// 급여 조건
							if($wr_pay_type){
								$wr_pay_type_cnt = count($wr_pay_type);
								$wr_pay_type_arr = array();
								for($i=0;$i<$wr_pay_type_cnt;$i++){
									$wr_pay_type_arr[$i] = "'".$wr_pay_type[$i]."'";
									array_push($url, "wr_pay_type[]=".$wr_pay_type[$i]);
								}
								$wr_pay_type_search = @implode($wr_pay_type_arr,", ");
								array_push($que, " `wr_pay_type` in (".$wr_pay_type_search.") ");
							}
							$wr_pay = $_GET['wr_pay'];	// 급여 금액 범위
							if($wr_pay[0]){
								array_push($que, " `wr_pay` between '".$wr_pay[0]."' and '".$wr_pay[1]."' ");
								array_push($url, "wr_pay[]=".$wr_pay[0]);
								array_push($url, "wr_pay[]=".$wr_pay[1]);
							}
							## //급여조건 검색 ###########################################################################################################

							
							## 성별 검색 ###########################################################################################################
							$wr_gender = $_GET['wr_gender'];	// 0 : 무관, 1 : 남자, 2 : 여자
							$wr_gender_not = $_GET['wr_gender_not'];	 // 무관 포함
							if($wr_gender){
								array_push($url, "wr_gender=".$wr_gender);
								$wr_gender_que = " ( ";
								if($wr_gender_not){	// 무관 포함시
									$wr_gender_que .= " `wr_gender` in ('".$wr_gender."', '0') ";
									array_push($url, "wr_gender_not=".$wr_gender_not);
								} else {	 // 무관 미포함시
									$wr_gender_que .= " `wr_gender` = '".$wr_gender."' ";
								}
								$wr_gender_que .= " ) ";
							array_push($que, $wr_gender_que);
							}
							## //성별 검색 ##########################################################################################################


							## 연령 검색 ###########################################################################################################
							$wr_age = $_GET['wr_age'];
							$wr_age_limit = $_GET['wr_age_limit'];
							if($wr_age){
								array_push($url, "wr_age=".$wr_age);
								$age_que = "(";
								$age_que .= " substring( `wr_age`,1 ,2 ) >= ".$wr_age." ";
								if($wr_age_limit){
									$age_que .= " or `wr_age_limit` = '0' ";
									array_push($url, "wr_age_limit=".$wr_age_limit);
								}
								$age_que .= ")";
								array_push( $que, $age_que );	// and substring( `wr_age`,4 ,2 ) <= '".$wr_age."'
							}
							## //연령 검색 ##########################################################################################################


							## 학력 검색 ###########################################################################################################
							$wr_ability = $_GET['wr_ability'];
							if($wr_ability){
								array_push($que, " `wr_ability` = '".$wr_ability."' ");
								array_push($url, "wr_ability=".$wr_ability);
							}
							## //학력 검색 ##########################################################################################################


							## 우대조건 검색 ###########################################################################################################
							$wr_preferential = $_GET['wr_preferential'];
							if($wr_preferential){
								$wr_preferential_cnt = count($wr_preferential);
								$wr_preferential_que = " ( ";
								for($i=0;$i<$wr_preferential_cnt;$i++){
									$_or = ($i != ($wr_preferential_cnt-1)) ? " or " : "";
									$wr_preferential_que .= " INSTR( `wr_preferential`, '".$wr_preferential[$i]."' ) " . $_or;
									array_push($url, "wr_preferential[]=".$wr_preferential[$i]);
								}
								$wr_preferential_que .= " ) ";
							array_push($que, $wr_preferential_que);
							}
							## //우대조건 검색 ##########################################################################################################


							## 복리후생 검색 ###########################################################################################################
							$wr_welfare = $_GET['wr_welfare'];
							if($wr_welfare){
								$wr_welfare_cnt = count($wr_welfare);
								$wr_welfare_que = " ( ";
								for($i=0;$i<$wr_welfare_cnt;$i++){
									$_or = ($i != ($wr_welfare_cnt-1)) ? " or " : "";
									$wr_welfare_que .= " INSTR( `wr_welfare`, '".$wr_welfare[$i]."' ) " . $_or;
									array_push($url, "wr_welfare[]=".$wr_welfare[$i]);
								}
								$wr_welfare_que .= " ) ";
							array_push($que, $wr_welfare_que);
							}
							## //복리후생 검색 ##########################################################################################################


							## 모집대상 검색 ###########################################################################################################
							$wr_target = $_GET['wr_target'];
							if($wr_target){
								$wr_target_cnt = count($wr_target);
								$wr_target_que = " ( ";
								for($i=0;$i<$wr_target_cnt;$i++){
									$_or = ($i != ($wr_target_cnt-1)) ? " or " : "";
									$wr_target_que .= " INSTR( `wr_target`, '".$wr_target[$i]."' ) " . $_or;
									array_push($url, "wr_target[]=".$wr_target[$i]);
								}
								$wr_target_que .= " ) ";
							array_push($que, $wr_target_que);
							}
							## //모집대상 검색 ##########################################################################################################


							## 근무형태 검색 ###########################################################################################################
							$wr_work_type = $_GET['wr_work_type'];
							if($wr_work_type){
								$wr_work_type_cnt = count($wr_work_type);
								$wr_work_type_que = " ( ";
								for($i=0;$i<$wr_work_type_cnt;$i++){
									$_or = ($i != ($wr_work_type_cnt-1)) ? " or " : "";
									$wr_work_type_que .= " INSTR( `wr_work_type`, '".$wr_work_type[$i]."' ) " . $_or;
									array_push($url, "wr_work_type[]=".$wr_work_type[$i]);
								}
								$wr_work_type_que .= " ) ";
							array_push($que, $wr_work_type_que);
							}
							## //근무형태 검색 ##########################################################################################################


							## 지원방법 검색 ###########################################################################################################
							$wr_requisition = $_GET['wr_requisition'];
							if($wr_requisition){
								$wr_requisition_cnt = count($wr_requisition);
								$wr_requisition_que = " ( ";
								for($i=0;$i<$wr_requisition_cnt;$i++){
									$_or = ($i != ($wr_requisition_cnt-1)) ? " or " : "";
									$wr_requisition_que .= " INSTR( `wr_requisition`, '".$wr_requisition[$i]."' ) " . $_or;
									array_push($url, "wr_requisition[]=".$wr_requisition[$i]);
								}
								$wr_requisition_que .= " ) ";
							array_push($que, $wr_requisition_que);
							}
							## //지원방법 검색 ##########################################################################################################


							## 등록일 기간 검색 #########################################################################################################
							$wr_wdate = $_GET['wr_wdate'];
							if($wr_wdate){
								if($wr_wdate=='today'){	 // 오늘 등록 데이터만
									array_push($que, " `wr_wdate` = curdate() ");
								} else {
									if($wr_wdate!='all'){	// 전체가 아닐때
										array_push($que, " DATE_ADD( `wr_wdate`, interval ".$wr_wdate.") > now() and `wr_wdate` < now() ");
									}
								}
							array_push($url, "wr_wdate=".$wr_wdate);
							}
							// select * from `alice_alba` where DATE_ADD( `wr_wdate`, interval 7 day) > now() and `wr_wdate` < now()
							## //등록일 기간 검색 ########################################################################################################


							## 기타 검색 변수 ###########################################################################################################
							$area_sels = $_GET['area_sels'];
							if($area_sels){
								$area_sels_cnt = count($area_sels);
								for($i=0;$i<$area_sels_cnt;$i++){
									array_push($url, "area_sels[]=".$area_sels[$i]);
								}
							}
							$subway_sels = $_GET['subway_sels'];
							if($subway_sels){
								$subway_sels_cnt = count($subway_sels);
								for($i=0;$i<$subway_sels_cnt;$i++){
									array_push($url, "subway_sels[]=".$subway_sels[$i]);
								}
							}
							$jobtype_sels = $_GET['jobtype_sels'];
							if($jobtype_sels){
								$jobtype_sels_cnt = count($jobtype_sels);
								for($i=0;$i<$jobtype_sels_cnt;$i++){
									array_push($url, "jobtype_sels[]=".$jobtype_sels[$i]);
								}
							}
							## //기타 검색 변수 ##########################################################################################################


							## 검색어 ###############################################################################################################
							if($search_keyword){
								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que  = "( INSTR(LOWER(`wr_company_name`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`wr_subject`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_content`), LOWER('".$search_keyword."')) ) ";
								} else {
									$search_que = "( INSTR(`wr_company_name`, '".$search_keyword."') or INSTR(`wr_subject`, '".$search_keyword."') or INSTR(`wr_content`, '".$search_keyword."') ) ";
								}

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							array_push($que, $search_que);
							}
							## //검색어 ##############################################################################################################

						}
						// 검색 조건 끝.


						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 정규직 이력서 상세 검색
				function __AlbaResumeSearch( $page="", $page_rows="", $con="" ){

						$_add = $this->_AlbaResumeSearch( );

						$query = " select * from `".$this->alba_resume_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						//echo "<p><br/><strong>Query :: " . $query."</strong><br/><br/></p>";	// 쿼리 확인

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}

				function _AlbaResumeSearch(){

					global $utility, $config;


						$mode = $_GET['mode'];

						$order = " `wr_wdate` ";

						$view_type = $_GET['view_type'];

						$sort = $_GET['sort'];

						if($sort) $order = " `" . $sort . "` ";

						$flag = $_GET['flag'];

						$order .= ($flag) ? " ".$flag." " : " desc ";


						$search_field = $_GET['search_field'];	// 검색 필드

						//$search_keyword = preg_replace( "/\//", "\/", trim( urldecode($_GET['search_keyword']) ) );	 // 다른 방식
						$search_keyword = urldecode( trim($_GET['search_keyword']) );	 // 검색 키워드


						$que = array();
						$url = array();


						// 검색 조건 시작~
						if($mode=='search'){

							array_push($url, "mode=" . $mode);

							array_push($url, "view_type=" . $view_type);
							array_push($url, "sort=" . $sort);


							## 지역 검색 ######################################################################################################
							$wr_area_0 = $_GET['wr_area_0'];	// 1차 지역 배열
							$wr_area_0_cnt = count($wr_area_0);
							$wr_area_1 = $_GET['wr_area_1'];	// 2차 지역 배열
							$wr_area_1_cnt = count($wr_area_1);
							$wr_area_2 = $_GET['wr_area_2'];	// 3차 지역 배열
							$wr_area_2_cnt = count($wr_area_2);

							$area_que_1 = array();
							$area_que_2 = array();

							$area_que = " ( ";

							for($i=0;$i<$wr_area_0_cnt;$i++){	// 1차 지역 검색
								$_and = ($wr_area_0_cnt != $i+1) ? " or " : "";
								$area_que .= " ( `wr_area0` = '".$wr_area_0[$i]."' or `wr_area2` = '".$wr_area_0[$i]."' or `wr_area4` = '".$wr_area_0[$i]."' ) " . $_and;
								array_push($url, "wr_area_0[]=" . $wr_area_0[$i]);
							}

							$area_que .= " ) ";
							

							if($wr_area_1){	// 2차 지역 데이터 배열 가공
								foreach($wr_area_1 as $area_1_key => $area_1_val){
									$area_1_val_cnt = count($area_1_val);
									for($j=0;$j<$area_1_val_cnt;$j++){
										array_push($area_que_1,$area_1_val[$j]);
										array_push($url, "wr_area_1[".$area_1_key."][]=" . $area_1_val[$j]);
									}
								}
								$area_que .= " and ";

								$area_que .= " ( ";

								$area_que_1_cnt = count($area_que_1);
								
								for($i=0;$i<$area_que_1_cnt;$i++){	// 2차 지역 검색
									$_and = ($area_que_1_cnt != $i+1) ? " or " : "";
									$area_que .= " ( `wr_area1` = '".$area_que_1[$i]."' or `wr_area3` = '".$area_que_1[$i]."' or `wr_area5` = '".$area_que_1[$i]."' ) " . $_and;
								}
								
								$area_que .= " ) ";
							}

							if($wr_area_0 || $wr_area_1){
								array_push($que, $area_que);
							}
							## //지역 검색 ######################################################################################################


							## 직종 검색 ###############################################################################################################
							$wr_jobtype_0 = $_GET['wr_jobtype_0'];	 // 1차 직종 배열
							$wr_jobtype_0_cnt = count($wr_jobtype_0);
							$wr_jobtype_1 = $_GET['wr_jobtype_1'];	 // 2차 직종 배열
							$wr_jobtype_1_cnt = count($wr_jobtype_1);
							$wr_jobtype_2 = $_GET['wr_jobtype_2'];	 // 3차 직종 배열
							$wr_jobtype_2_cnt = count($wr_jobtype_2);

							$jobtype_que_1 = array();
							$jobtype_que_2 = array();

							$jobtype_first = " ( ";
							for($i=0;$i<$wr_jobtype_0_cnt;$i++){	// 1차 직종 검색
								$_or = ($i != ($wr_jobtype_0_cnt-1)) ? " or " : "";
								$jobtype_first .= " `wr_job_type0` = '".$wr_jobtype_0[$i]."' " . $_or;
								array_push($url, "wr_job_type0[]=" . $wr_area_0[$i]);
							}
							$jobtype_first .= " ) ";
							
							if($wr_jobtype_1){	 // 2차 직종 데이터 배열 가공
								foreach($wr_jobtype_1 as $jobtype_1_key => $jobtype_1_val){
									$jobtype_1_val_cnt = count($jobtype_1_val);
									for($j=0;$j<$jobtype_1_val_cnt;$j++){
										array_push($jobtype_que_1,$jobtype_1_val[$j]);
										array_push($url, "wr_job_type1[".$jobtype_1_key."][]=" . $jobtype_1_val[$j]);
									}
								}
							}

							$jobtype_que_1_cnt = count($jobtype_que_1);

							$jobtype_second = " ( ";
							for($i=0;$i<$jobtype_que_1_cnt;$i++){	// 2차 직종 검색
								$_or = ($i != ($jobtype_que_1_cnt-1)) ? " or " : "";
								$jobtype_second .= " `wr_job_type1` = '".$jobtype_que_1[$i]."' " . $_or;
							}
							$jobtype_second .= " ) ";

							if($wr_jobtype_2){	 // 3차 직종 데이터 배열 가공
								foreach($wr_jobtype_2 as $jobtype_2_key => $jobtype_2_val){
									foreach($jobtype_2_val as $key => $val){
										$val_cnt = count($val);
										for($j=0;$j<$val_cnt;$j++){
											array_push($jobtype_que_2,$val[$j]);
											array_push($url, "wr_jobtype_2[".$jobtype_2_key."][".$key."][]=" . $val[$j]);
										}
									}
								}
							}

							$jobtype_que_2_cnt = count($jobtype_que_2);

							$jobtype_third = " ( ";
							for($i=0;$i<$jobtype_que_2_cnt;$i++){	// 2차 직종 검색
								$_or = ($i != ($jobtype_que_2_cnt-1)) ? " or " : "";
								$jobtype_third .= " `wr_job_type2` = '".$jobtype_que_2[$i]."' " . $_or;
							}
							$jobtype_third .= " ) ";

							if($wr_jobtype_0) array_push($que, $jobtype_first);			// 1차 직종
							if($wr_jobtype_1) array_push($que, $jobtype_second);		// 2차 직종
							if($wr_jobtype_2) array_push($que, $jobtype_third);		// 3차 직종
							## //직종 검색 ##############################################################################################################


							## 성별 검색 ###########################################################################################################
							$wr_gender = $_GET['wr_gender'];	// 0 : 남자, 1 : 여자
							if($wr_gender && $wr_gender!='3'){	// 무관
								array_push($que, " `wr_gender` = '".$wr_gender."' ");
								array_push($url, "wr_gender=" . $wr_gender);
							}
							## //성별 검색 ##########################################################################################################


							## 연령 검색 ###########################################################################################################
							$wr_age = $_GET['wr_age'];
							if($wr_age[0] && $wr_age[1]){	// 둘다 있는 경우
								$age_que = " `wr_age` between '".$wr_age[0]."' and '".$wr_age[1]."'";
								array_push($url, "wr_age[]=" . $wr_age[0]);
								array_push($url, "wr_age[]=" . $wr_age[1]);
							array_push($que, $age_que);
							} else {
								if($wr_age[0]){
									array_push($que, " `wr_age` >= '".$wr_age[0]."' ");
									array_push($url, "wr_age[]=" . $wr_age[0]);
								}
								if($wr_age[1]){
									array_push($que, " `wr_age` <= '".$wr_age[1]."' ");
									array_push($url, "wr_age[]=" . $wr_age[1]);
								}
							}
							## //연령 검색 ##########################################################################################################


							## 근무기간 검색 ###########################################################################################################
							$wr_date = $_GET['wr_date'];
							if($wr_date[0]){
								$wr_date_arr = array();
								$wr_date_cnt = count($wr_date);
								for($i=0;$i<$wr_date_cnt;$i++){
									array_push($wr_date_arr, "'".$wr_date[$i]."'");
									array_push($url, "wr_date[]=" . $wr_date[$i]);
								}
								$wr_date_que = @implode($wr_date_arr,", ");

							array_push($que, " `wr_date` in (".$wr_date_que.") ");
							}
							## //근무기간 검색 ##########################################################################################################


							## 근무요일 검색 ###########################################################################################################
							$wr_week = $_GET['wr_week'];
							if($wr_week){
								array_push($que, " `wr_week` = '".$wr_week."' ");
								array_push($url, "wr_week=" . $wr_week);
							}
							## //근무요일 검색 ##########################################################################################################


							## 근무시간 검색 ###########################################################################################################
							$wr_time = $_GET['wr_time'];
							if($wr_time[0]){
								$wr_time_arr = array();
								$wr_time_cnt = count($wr_time);
								for($i=0;$i<$wr_time_cnt;$i++){
									array_push($wr_time_arr, "'".$wr_time[$i]."'");
									array_push($url, "wr_time[]=" . $wr_time[$i]);
								}
								$wr_time_que = @implode($wr_time_arr,", ");

							array_push($que, " `wr_time` in (".$wr_time_que.") ");
							}
							## //근무시간 검색 ##########################################################################################################


							## 근무형태 검색 ###########################################################################################################
							$wr_work_type = $_GET['wr_work_type'];
							if($wr_work_type[0]){
								$wr_work_type_arr = array();
								$wr_work_type_cnt = count($wr_time);
								for($i=0;$i<$wr_work_type_cnt;$i++){
									array_push($wr_work_type_arr, "'".$wr_work_type[$i]."'");
									array_push($url, "wr_work_type[]=" . $wr_work_type[$i]);
								}
								$wr_work_type_que = @implode($wr_work_type_arr,", ");

							array_push($que, " `wr_work_type` in (".$wr_work_type_que.") ");
							}
							## //근무형태 검색 ##########################################################################################################

							
							## 경력 검색 ##############################################################################################################
							$wr_career_use = $_GET['wr_career_use'];
							if($wr_career_use){
								array_push($que, " `wr_career_use` = '".$wr_career_use."' ");
								array_push($url, "wr_career_use=".$wr_career_use);
							}
							## //경력 검색 #############################################################################################################


							## 학력 검색 ##############################################################################################################
							$wr_school_ability = $_GET['wr_school_ability'];
							if($wr_school_ability){
								array_push($que, " left(`wr_school_ability`,19) = '".$wr_school_ability."' ");
								array_push($url, "wr_school_ability=".$wr_school_ability);
							}
							## //학력 검색 #############################################################################################################


							## 자격증 검색 #############################################################################################################
							$wr_license = urldecode( trim($_GET['wr_license']) );
							if($wr_license){
								array_push($que, " INSTR( `wr_license`, '".$wr_license."' ) ");
								array_push($url, "wr_license=".$wr_license);
							}
							## //자격증 검색 ############################################################################################################


							## 외국어능력 검색 ###########################################################################################################
							$wr_language_name = $_GET['wr_language_name'];
							if($wr_language_name){
								array_push($que, " INSTR(`wr_language_use`, '1') ");
								array_push($que, " INSTR(`wr_language`, '".$wr_language_name."') ");
								array_push($url, "wr_language_name=".$wr_language_name);
								$wr_language_level = $_GET['wr_language_level'];
								if($wr_language_level!=''){
									array_push($que, " ( INSTR(`wr_language`, '\"level\";s:1:\"".$wr_language_level."\"') or INSTR(`wr_language`, '\"level\";a:1:\"".$wr_language_level."\"') or INSTR(`wr_language`, '\"level\";a:2:\"".$wr_language_level."\"') ) ");
									array_push($url, "wr_language_level=".$wr_language_level);
								}
							}
							$wr_language_study = $_GET['wr_language_study'];	// 어학연수 경험
							if($wr_language_study){
								array_push($que, " INSTR(`wr_language`, '\"study\";s:1:\"".$wr_language_study."\"') ");
								array_push($url, "wr_language_study=".$wr_language_study);
							}
							## //외국어능력 검색 ##########################################################################################################


							## OA능력 검색 #############################################################################################################
							$wr_oa = $_GET['wr_oa'];
							$wr_oa_level = $_GET['wr_oa_level'];
							if($wr_oa) {
								if($wr_oa_level!=''){	// OA 능력 수준 있다면
									array_push($que, " INSTR(`wr_oa`, '\"".$wr_oa."\";s:1:\"".$wr_oa_level."\"') ");
									array_push($url, "wr_oa=".$wr_oa);
									array_push($url, "wr_oa_level=".$wr_oa_level);
								} else {	 // OA능력만 체크 했다면
									array_push($que, " INSTR(`wr_oa`, '".$wr_oa."') ");
									array_push($url, "wr_oa=".$wr_oa);
								}
							}
							## //OA능력 검색 ############################################################################################################


							## 컴퓨터 검색 ##############################################################################################################
							$wr_computer = $_GET['wr_computer'];
							if($wr_computer[0]){
								$wr_computer_cnt = count($wr_computer);
								$wr_computer_que = " ( ";
								for($i=0;$i<$wr_computer_cnt;$i++){
									$_or = ( $i != ($wr_computer_cnt-1) ) ? " or " : "";
									$wr_computer_que .= " INSTR(`wr_computer`, '".$wr_computer[$i]."')" . $_or;
									array_push($url, "wr_computer[]=".$wr_computer[$i]);
								}
								$wr_computer_que .= " ) ";

							array_push($que, $wr_computer_que);
							}
							## //컴퓨터 검색 #############################################################################################################

							
							## 특기사항 검색 #############################################################################################################
							$wr_specialty = $_GET['wr_specialty'];
							if($wr_specialty[0]){
								$wr_specialty_cnt = count($wr_specialty);
								$wr_specialty_que = " ( ";
								for($i=0;$i<$wr_specialty_cnt;$i++){
									$_or = ( $i != ($wr_specialty_cnt-1) ) ? " or " : "";
									$wr_specialty_que .= " INSTR(`wr_specialty`, '".$wr_specialty[$i]."')" . $_or;
									array_push($url, "wr_specialty[]=".$wr_specialty[$i]);
								}
								$wr_specialty_que .= " ) ";

							array_push($que, $wr_specialty_que);
							}
							## //특기사항 검색 ############################################################################################################


							## 기타사항 검색 #############################################################################################################
							$wr_treatment = $_GET['wr_treatment'];
							if($wr_treatment[0]){
								/*
								if(@in_array('photo',$wr_treatment)){	// 사진있는 이력서 검색
								}
								*/
								if(@in_array('military',$wr_treatment)){	// 군필자 검색
									array_push($que, " `wr_military` = 1 ");
									array_push($url, "wr_treatment[]=military");
								}
								if(@in_array('impediment',$wr_treatment)){	// 장애인 검색
									array_push($que, " `wr_impediment_use` = 1 ");
									array_push($url, "wr_treatment[]=impediment");
								}
								if(@in_array('treatment',$wr_treatment)){	// 고용지원금대상자 검색
									array_push($que, " `wr_treatment_use` = 1 ");
									array_push($url, "wr_treatment[]=treatment");
								}
							}
							$wr_treatment_service = $_GET['wr_treatment_service'];
							if($wr_treatment_service[0]){	// 고용지원금 대상자
								$wr_treatment_service_cnt = count($wr_treatment_service);
								$wr_treatment_service_que = " ( ";
								for($i=0;$i<$wr_treatment_service_cnt;$i++){
									$_or = ( $i != ($wr_treatment_service_cnt-1) ) ? " or " : "";
									$wr_treatment_service_que .= " INSTR(`wr_treatment_service`, '".$wr_treatment_service[$i]."')" . $_or;
									array_push($url, "wr_treatment_service[]=".$wr_treatment_service[$i]);
								}
								$wr_treatment_service_que .= " ) ";

							array_push($que, $wr_treatment_service_que);
							}
							## //기타사항 검색 ############################################################################################################


							## 기타 검색 변수 ###########################################################################################################
							$area_sels = $_GET['area_sels'];
							if($area_sels){
								$area_sels_cnt = count($area_sels);
								for($i=0;$i<$area_sels_cnt;$i++){
									array_push($url, "area_sels[]=".$area_sels[$i]);
								}
							}
							$jobtype_sels = $_GET['jobtype_sels'];
							if($jobtype_sels){
								$jobtype_sels_cnt = count($jobtype_sels);
								for($i=0;$i<$jobtype_sels_cnt;$i++){
									array_push($url, "jobtype_sels[]=".$jobtype_sels[$i]);
								}
							}
							## //기타 검색 변수 ##########################################################################################################


							## 검색어 ###############################################################################################################
							if($search_keyword){
								$search_que = " ( ";
								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que .= " INSTR(LOWER(`wr_subject`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_introduce`), LOWER('".$search_keyword."')) ";
								} else {
									$search_que .= " INSTR(`wr_subject`, '".$search_keyword."') or INSTR(`wr_introduce`, '".$search_keyword."') ";
								}
								$search_que .= " ) ";

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							array_push($que, $search_que);
							}
							## //검색어 ##############################################################################################################

						}
						// 검색 조건 끝.


						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);
				}


				// 통합 검색
				function __Searching( $page="", $page_rows="" ){

					global $alice;
					global $service_control;

						$result = array();

						$service_check = $service_control->service_check('alba_basic');

						/* 정규직 검색 */
						$alba_con = " where `wr_open` = 1 and `wr_is_adult` = 0 and `wr_report` = 0 and `is_delete` = 0 ";
						if( $service_check['is_pay'] ){
							$alba_con .= " and ( `wr_service_platinum` >= curdate() or `wr_service_platinum_sub` >= curdate() or `wr_service_prime` >= curdate() or `wr_service_grand` >= curdate() or `wr_service_banner` >= curdate() or `wr_service_banner_sub` >= curdate() or `wr_service_list` >= curdate() or `wr_service_list_sub` >= curdate() or `wr_service_basic_sub` >= curdate() ) ";
						}
						//$alba_search = $this->__AlbaSearch( $page, $page_rows, $alba_con );
						$result['alba_search'] = $this->__AlbaSearch( $page, $page_rows, $alba_con );
						/* // 정규직 검색 */

						
						$service_check = $service_control->service_check('alba_resume_basic');
						
						/* 정규직 이력서 검색 */
						$alba_resume_con = " where `wr_open` = 1 and `wr_report` = 0 and `is_delete` = 0 ";
						if( $service_check['is_pay'] ){
							$alba_resume_con .= " and ( `wr_service_main_focus` >= curdate() or `wr_service_sub_focus` >= curdate() or `wr_service_basic` >= curdate() or `wr_service_basic_sub` >= curdate() ) ";
						}
						$result['alba_resume_search'] = $this->__AlbaResumeSearch( $page, $page_rows, $alba_resume_con );
						/* // 정규직 이력서 검색 */

						
						/* 게시판 검색 */
						$table_query = " select `code`, `bo_table`, `bo_subject` from `".$this->board_table."` order by `no` desc  ";

						$search_table = $this->query_fetch_rows($table_query);

						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드


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
						
						$result['board_search']['total_count'] = 0;
						foreach($search_table as $val){

							$search_query = " select * from `".$alice['write_prefix'].$val['bo_table']."` where " . $search_que;
							$search_list = $this->query_fetch_rows($search_query);

							if($search_list){
								$i = 0;
								foreach($search_list as $list){
									$result['board_search']['result'][$val['bo_table']][$i] = $list;
								$i++;
								}

								$result['board_search']['total_count'] += count($search_list);
							}
							
						}
						/* // 게시판 검색 */


					return $result;

				}

				// 전체 건수
				function total_counting( $table ){

						switch($table){

							## 정규직 공고
							case 'alba':

								$query = " select * from `".$this->alba_table."` where `wr_open` = 1 and `wr_is_adult` = 0 and `wr_report` = 0 ";

								$result = $this->_queryR($query);

							break;

							## 정규직 이력서
							case 'alba_resume':

								$query = " select * from `".$this->alba_resume_table."` where `wr_open` = 1 and `wr_report` = 0 ";

								$result = $this->_queryR($query);

							break;

							## 게시판
							case 'board':

								$query = " select * from `".$this->board_new_table."` ";

								$result = $this->_queryR($query);

							break;

						}	// switch end.

					
					return $result;

				}
				


				// 검색어 통계
				function get_search( $limit=50 ){

						$result = array();
						
						$query = " select * from `".$this->search_table."` where `wr_wdate` like '".date('Y-m-d')."%' order by `wr_hit` desc limit " . $limit;
						//echo "<font color='ffffff'>". $query. " 오늘<== </font><br>";
						$result['today'] = $this->query_fetch_rows($query);

						$query = " select * from `".$this->search_table."` where `wr_wdate` between date_add(curdate(), interval -1 day) and curdate() order by `wr_hit` desc limit " . $limit;
						//echo "<font color='ffffff'>". $query. " 어제<== </font><br>";
						$result['yesterday'] = $this->query_fetch_rows($query);
                        
						$start_ymd = date("Y-m")."-01 00:00:00";
						$end_ymd   = date("Y-m-d")." 23:59:59";
						$query = " select * from `".$this->search_table."` where `wr_wdate` between '". $start_ymd ."' and '". $end_ymd ."' group by wr_content order by `wr_hit` desc limit " . $limit;
						//echo "<font color='ffffff'>". $query. " 달<== </font><br>";
						$result['month'] = $this->query_fetch_rows($query);

					return $result;

				}

				// 검색어 단일 추출 (no 기준)
				function get_search_once( $no ){

						if(!$no) return false;

						$query = " select * from `".$this->search_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// type에 따른 카테고리 리스트 출력
				// 기본적으로 rank 순
				function __SearchList( $type, $order=" `rank` asc ", $limit="" ){

						if(!$type) return false;

						if($limit!='')
							$con = " limit " . $limit;

						$query = " select * from `".$this->search_table."` where `wr_type` = '".$type."' order by " . $order . $con;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}

				// type 에 따른 rank 최대값 구함
				function get_MaxRank( $type, $con="" ){

						if(!$type) return false;

						$query = " select max(`rank`) as `rank` from `".$this->search_table."` where `wr_type` = '".$type."' " . $con;

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

				}


		}	// class end.
?>