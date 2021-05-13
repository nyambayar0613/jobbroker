<?php
		/**
		* /application/resume/model/alice_alba_resume_user_model.class.php
		* @author Harimao
		* @since 2013/10/01
		* @last update 2015/11/24
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Resume Model class
		* @Comment :: 사용자측 정규직 이력서 모델 클래스
		*/
		class alice_alba_resume_user_model extends DBConnection {

			var $resume_table					= "alice_alba_resume";
			var $resume_open_table			= "alice_resume_open";
			var $member_service_table	= "alice_member_service";

			var $success_code = array(
					'0000' => '',
			);
			var $fail_code = array(
					'0000' => '회원만 스크랩 가능합니다.',
					'0001' => '신고된 이력서 입니다.\\n\\n사이트 운영자 확인중입니다.',
					'0002' => '비공개 이력서 입니다.',
					'0003' => '사용가능한 이력서 열람권이 없습니다.',
			);

			var $gender_val = array( 0 => "남자", 1 => "여자" );
			var $gender_text = array( 0 => "男", 1 => "女" );


				// 리스팅
				function __ResumeList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->resume_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

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


				// 이력서 추출 (단수) :: wr_id 기준
				function get_resume( $wr_id, $con="" ){

						if(!$wr_id || $wr_id=='') return false;

						$query = " select * from `".$this->resume_table."` where `wr_id` = '".$wr_id."' " . $con;

						$result = $this->query_fetch($query);


					return $result;
				}


				// 이력서 추출 (단수) :: wr_no 기준
				function get_resume_no( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->resume_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;
				}


				// 전체/오늘의 정규직 이력서 카운팅 => 이미지 변환 출력
				// 채용정보 상단에서 사용
				function resume_count_image( $type='all' ){

					global $alice;

						$trans_number = array( 
							"0" => "<img class=\"bg_color8\" src=\"../images/basic/img_no0.png\" width=\"26\" height=\"34\" alt=\"0\">", 
							"1" => "<img class=\"bg_color8\" src=\"../images/basic/img_no1.png\" width=\"26\" height=\"34\" alt=\"1\">", 
							"2" => "<img class=\"bg_color8\" src=\"../images/basic/img_no2.png\" width=\"26\" height=\"34\" alt=\"2\">", 
							"3" => "<img class=\"bg_color8\" src=\"../images/basic/img_no3.png\" width=\"26\" height=\"34\" alt=\"3\">", 
							"4" => "<img class=\"bg_color8\" src=\"../images/basic/img_no4.png\" width=\"26\" height=\"34\" alt=\"4\">", 
							"5" => "<img class=\"bg_color8\" src=\"../images/basic/img_no5.png\" width=\"26\" height=\"34\" alt=\"5\">", 
							"6" => "<img class=\"bg_color8\" src=\"../images/basic/img_no6.png\" width=\"26\" height=\"34\" alt=\"6\">", 
							"7" => "<img class=\"bg_color8\" src=\"../images/basic/img_no7.png\" width=\"26\" height=\"34\" alt=\"7\">", 
							"8" => "<img class=\"bg_color8\" src=\"../images/basic/img_no8.png\" width=\"26\" height=\"34\" alt=\"8\">", 
							"9" => "<img class=\"bg_color8\" src=\"../images/basic/img_no9.png\" width=\"26\" height=\"34\" alt=\"9\">", 
							"," => "<img class=\"bg_color8\" src=\"../images/basic/img_noc.png\" width=\"9\" height=\"12\" alt=\",\">", 
						);
						
						$query = " select * from `".$this->resume_table."` where `wr_open` = 1 and `wr_report` = 0 ";

						switch($type){

							## 전체 이력서 카운팅
							case 'all':

								$total_count = $this->_queryR($query);
								$result = strtr($total_count, $trans_number);

							break;

							## 오늘의 이력서 카운팅
							case 'today':

								$query .= " and `wr_wdate` > curdate() ";

								$total_count = $this->_queryR($query);
								$result = strtr($total_count, $trans_number);

							break;

						}	// switch end.


					return $result;

				}



				// 이력서 검색
				function _Search( ){

					global $utility, $config;
					global $category_control, $service_control;


						$mode = $_GET['mode'];

						$type = $_GET['type'];
						
						$search_mode = $_GET['search_mode'];	// 검색 페이지별 모드

						$page = $_GET['page'];

						$page_rows = $_GET['page_rows'];

						$resume_jump_check = $service_control->service_check('resume_option_jump');	// alba jump 체크
						if( $resume_jump_check['etc_2'] ){
							//$order .= ", wr_jdate desc ";
							$order = " `wr_jdate` desc, `wr_wdate` ";
						} else {
							$order = " `wr_wdate` ";
						}

						$view_type = $_GET['view_type'];

						$sort = $_GET['sort'];

						if($sort) $order = " `" . $sort . "` ";

						$flag = $_GET['flag'];

						$order .= ($flag) ? " ".$flag." " : " desc ";


						$category_top_val = explode(",",$_GET['category_top_val']);
						$category_top_val_cnt = count($category_top_val);


						$que = array();
						$url = array();


						array_push($url, "category_top_val=".$_GET['category_top_val']);
						array_push($url, "category_middle_val=".$_GET['category_middle_val']);
						array_push($url, "category_sub_val=".$_GET['category_sub_val']);


						switch($search_mode){

							## 지역별
							case 'resume_area':

								$resume_area_1 = $_GET['resume_area_1'];
								$resume_area_1_cnt = count($resume_area_1);
								$resume_area_2 = $_GET['resume_area_2'];
								$resume_area_2_cnt = count($resume_area_2);

								$resume_area_que_1 = array();
								$resume_area_que_2 = array();

								$resume_area_first = " ( ";
								for($i=0;$i<$category_top_val_cnt;$i++){	// 1차 지역 검색
									$_or = ($category_top_val_cnt != $i+1) ? " or " : "";
									$resume_area_first .= " ( `wr_area0` = '".$category_top_val[$i]."' or `wr_area2` = '".$category_top_val[$i]."' or `wr_area4` = '".$category_top_val[$i]."' ) " . $_or;
									array_push($url, "resume_area_0[]=" . $category_top_val[$i]);
								}
								$resume_area_first .= " ) ";

								if($resume_area_1){	 // 2차 지역 데이터 배열 가공
									$is_all = false;
									foreach($resume_area_1 as $resume_area_1_key => $resume_area_1_val){
										$resume_area_1_val_cnt = count($resume_area_1_val);
										for($j=0;$j<$resume_area_1_val_cnt;$j++){
											if( stristr($area_1_val[$j],'all') ){
												$is_all = true;
											} else {
												$is_all = false;
												array_push($resume_area_que_1,$resume_area_1_val[$j]);
											}
											array_push($url, "resume_area_1[".$resume_area_1_key."][]=" . $resume_area_1_val[$j]);
										}
									}

									if(!$is_all){	// 전체가 아닐때

										$resume_area_que_1_cnt = count($resume_area_que_1);

										$resume_area_second = " ( ";
										for($i=0;$i<$resume_area_que_1_cnt;$i++){	// 2차 지역 검색
											$_or = ($i != ($resume_area_que_1_cnt-1)) ? " or " : "";
											$resume_area_second .= " ( `wr_area1` = '".$resume_area_que_1[$i]."' or `wr_area3` = '".$resume_area_que_1[$i]."' or `wr_area5` = '".$resume_area_que_1[$i]."' ) " . $_or;
										}
										$resume_area_second .= " ) ";

									}

								}

							break;

							## 직종별
							case 'resume_type':

								$resume_type_1 = $_GET['resume_type_1'];
								$resume_type_1_cnt = count($resume_type_1);
								$resume_type_2 = $_GET['resume_type_2'];
								$resume_type_2_cnt = count($resume_type_2);

								$resume_type_que_1 = array();
								$resume_type_que_2 = array();

								$resume_type_first = " ( ";
								for($i=0;$i<$category_top_val_cnt;$i++){	// 1차 직종 검색
									$_or = ($i != ($category_top_val_cnt-1)) ? " or " : "";
									$resume_type_first .= " `wr_job_type0` = '".$category_top_val[$i]."' " . $_or;
									array_push($url, "resume_type_0[]=" . $category_top_val[$i]);
								}
								$resume_type_first .= " ) ";
								
								if($resume_type_1){	 // 2차 직종 데이터 배열 가공
									foreach($resume_type_1 as $resume_type_1_key => $resume_type_1_val){
										$resume_type_1_val_cnt = count($resume_type_1_val);
										for($j=0;$j<$resume_type_1_val_cnt;$j++){
											array_push($resume_type_que_1,$resume_type_1_val[$j]);
											array_push($url, "resume_type_1[".$resume_type_1_key."][]=".$resume_type_1_val[$j]);
										}
									}

									$resume_type_que_1_cnt = count($resume_type_que_1);

									$resume_type_second = " ( ";
									for($i=0;$i<$resume_type_que_1_cnt;$i++){	// 2차 직종 검색
										$_or = ($i != ($resume_type_que_1_cnt-1)) ? " or " : "";
										$resume_type_second .= " `wr_job_type1` = '".$resume_type_que_1[$i]."' " . $_or;
									}
									$resume_type_second .= " ) ";
								}

								if($resume_type_2){	 // 3차 직종 데이터 배열 가공
									foreach($resume_type_2 as $resume_type_2_key => $resume_type_2_val){
										foreach($resume_type_2_val as $key => $val){
											$val_cnt = count($val);
											for($j=0;$j<$val_cnt;$j++){
												array_push($resume_type_que_2,$val[$j]);
												array_push($url, "alba_type_2[".$resume_type_2_key."][".$key."][]=".$val[$j]);
											}
										}
									}

									$resume_type_que_2_cnt = count($resume_type_que_2);

									$resume_type_third = " ( ";
									for($i=0;$i<$resume_type_que_2_cnt;$i++){	// 3차 직종 검색
										$_or = ($i != ($resume_type_que_2_cnt-1)) ? " or " : "";
										$resume_type_third .= " `wr_job_type2` = '".$resume_type_que_2[$i]."' " . $_or;
									}
									$resume_type_third .= " ) ";
								}

							break;


						}	// switch end.

						// 지역
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
							$is_all = false;
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

							if(!$is_all) { // 전체가 아닐때만

								$area_que .= " and ";

								$area_que .= " ( ";

								$area_que_1_cnt = count($area_que_1);
								
								for($i=0;$i<$area_que_1_cnt;$i++){	// 2차 지역 검색
									$_and = ($area_que_1_cnt != $i+1) ? " or " : "";
									$area_que .= " ( `wr_area1` = '".$area_que_1[$i]."' or `wr_area3` = '".$area_que_1[$i]."' or `wr_area5` = '".$area_que_1[$i]."' ) " . $_and;
								}
								
								$area_que .= " ) ";

							}
						}

						// 직종
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



						// 근무조건
						$wr_date = $_GET['wr_date'];		// 근무기간
						$wr_week = $_GET['wr_week'];	// 근무요일
						$wr_time = $_GET['wr_time'];		// 근무시간

						$wr_work_direct = $_GET['wr_work_direct'];	// 즉시출근가능

						$wr_school_ability = $_GET['wr_school_ability'];	// 학력

						$wr_career_use = $_GET['wr_career_use'];	// 경력
						$wr_career = $_GET['wr_career'];	// 경력 조건 ( ~ 이하 )

						$wr_age = $_GET['wr_age'];	// 입력 나이
						$wr_age_limit = $_GET['wr_age_limit'];	// 나이 무관포함

						$wr_gender = $_GET['wr_gender'];	// 성별

						$wr_specialty = $_GET['wr_specialty'];	// 특기별 검색

						$wr_language_name = $_GET['wr_language_name'];	// 외국어 종류
						$wr_language_level = $_GET['wr_language_level'];		// 외국어 수준
						$wr_language_study = $_GET['wr_language_study'];	// 어학연수 경험

						$search_field = $_GET['search_field'];	// 검색 필드

						//$search_keyword = preg_replace( "/\//", "\/", trim( urldecode($_GET['search_keyword']) ) );	 // 다른 방식
						$search_keyword = urldecode( trim($_GET['search_keyword']) );	 // 검색 키워드

						$search_license = urldecode( trim($_GET['search_license']) );	 // 자격증명 검색


						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							array_push($url, "view_type=" . $view_type);
							array_push($url, "sort=" . $sort);

							/* 지역 검색 */
								if($wr_area_0 || $wr_area_1){
									array_push($que, $area_que);
								}

								// 지역별 검색
								if($_GET['category_top_val'] && $resume_area_first){
									if($resume_area_first) array_push($que, $resume_area_first);
									if($resume_area_second) array_push($que, $resume_area_second);
									if($resume_area_third) array_push($que, $resume_area_third);
								}
							/* // 지역 검색 */


							/* 직종 검색 */
								// 1차 직종
								if($wr_jobtype_0) array_push($que, $jobtype_first);
								// 2차 직종
								if($wr_jobtype_1) array_push($que, $jobtype_second);
								// 3차 직종
								if($wr_jobtype_2) array_push($que, $jobtype_third);

								// 직종별 검색
								if($_GET['category_top_val'] && $resume_type_first){
									if($resume_type_first) array_push($que, $resume_type_first);
									if($resume_type_second) array_push($que, $resume_type_second);
									if($resume_type_third) array_push($que, $resume_type_third);
								}
							/* // 직종 검색 */


							/* 특기 검색 */
							if($wr_specialty){
								$wr_specialty_cnt = count($wr_specialty);
								$specialty = " ( ";
								for($i=0;$i<$wr_specialty_cnt;$i++){
									$_or = ($i != ($wr_specialty_cnt-1)) ? " or " : "";
									$specialty .= " INSTR(`wr_specialty`, '".$wr_specialty[$i]."') " . $_or;
								}
								$specialty .= " ) ";

								array_push( $que, $specialty );
							}
							/* // 특기 검색 */


							/* 근무기간 검색 */
							if($wr_date){
								array_push( $que, " `wr_date` = '".$wr_date."' " );
								array_push($url, "wr_date=" . $wr_date);
							}
							/* // 근무기간 검색 */


							/* 근무요일 검색 */
							if($wr_week){
								array_push( $que, " `wr_week` = '".$wr_week."' " );
								array_push($url, "wr_week=" . $wr_week);
							}
							/* // 근무요일 검색 */

							
							/* 근무시간 검색 */
							if($wr_time){
								array_push( $que, " `wr_time` = '".$wr_time."' " );
								array_push($url, "wr_time=" . $wr_time);
							}
							/* // 근무시간 검색 */

							/* 즉시출근가능 검색 */
							if($wr_work_direct){
								array_push( $que, " `wr_work_direct` = '".$wr_work_direct."' " );
								array_push($url, "wr_work_direct=" . $wr_work_direct);
							}
							/* // 즉시출근가능 검색 */


							/* 최종 학력 검색 */
							if($wr_school_ability){
								array_push( $que, " left(`wr_school_ability`,19) = '".$wr_school_ability."' " );
								array_push($url, "wr_school_ability=" . $wr_school_ability);
							}
							/* // 최종 학력 검색 */


							/* 경력 검색 */
							if($wr_career_use){
								if($wr_career_use=='1'){	// 신입
									array_push( $que, " `wr_career` = '' " );
								} else if($wr_career_use=='2') {	 // 경력
									array_push( $que, " `wr_career` != '' " );
								}
							array_push($url, "wr_career_use=".$wr_career_use);
							}
							/* // 경력 검색 */


							/* 나이 검색 */
							if($wr_age[0] && $wr_age[1]){
								if( is_array($wr_age) ){
									$wr_age_1 = ($wr_age[1]) ? $wr_age[1] : 0;
									if(!$wr_age_limit)	// 나이 무관 아닐때
										array_push( $que, " `wr_age` between " . $wr_age[0] . " and " . $wr_age_1 );
								} else {
									if(!$wr_age_limit)	// 나이 무관 아닐때
										array_push( $que, " `wr_age` >= " . $wr_age );
								}
							array_push($url, "wr_age=".$wr_age);
							}
							/* //나이 검색 */

							
							/* 성별 검색 */
							if($wr_gender){	//  || $wr_gender=='0'
								$_gender = ($wr_gender=='1') ? "0" : "1";
								array_push( $que, " `wr_gender` = '".$_gender."' " );
								array_push($url, "wr_gender=".$wr_gender);
							}
							/* //성별 검색 */

							
							/* 외국어 선택 검색 */
							if($wr_language_name){	 // 외국어 종류 검색
								array_push( $que, " INSTR(`wr_language_use`, '1') ");
								array_push( $que, " INSTR(`wr_language`, '".$wr_language_name."') ");
								array_push($url, "wr_language_name=".$wr_language_name);
							}
							if($wr_language_level){	 // 외국어 종류 검색
								array_push( $que, " INSTR(`wr_language`, '".stripslashes($wr_language_level)."') ");
								array_push($url, "wr_language_level=".$wr_language_level);
							}
							if($wr_language_study){	 // 어학 연수 경험
								array_push( $que, " INSTR(`wr_language`, 'study') ");
								array_push($url, "wr_language_study=".$wr_language_study);
							}
							/* // 외국어 선택 검색 */


							/* 자격증명 검색 */
							if($search_license){
								array_push( $que, " INSTR(`wr_license`, '".$search_license."') ");
								array_push($url, "search_license=".$search_license);
							}
							/* // 자격증명 검색 */


							## 기타 검색 변수 ###############################################################################################################################################################
							if($search_mode && ($search_mode != 'resume_busy' && $search_mode != 'resume_term' && $search_mode != 'resume_specialty' && $search_mode != 'resume_license' && $search_mode != 'resume_language')){
								$area_sels = $_GET[$search_mode.'_sels'];
								if($area_sels){
									$area_sels_cnt = count($area_sels);
									for($i=0;$i<$area_sels_cnt;$i++){
										array_push($url, $search_mode."_sels[]=".$area_sels[$i]);
									}
								}
							} else {
								$area_sels = $_GET['area_sels'];
								if($area_sels){
									$area_sels_cnt = count($area_sels);
									for($i=0;$i<$area_sels_cnt;$i++){
										array_push($url, "area_sels[]=".$area_sels[$i]);
									}
								}
							}
							$jobtype_sels = $_GET['jobtype_sels'];
							if($jobtype_sels){
								$jobtype_sels_cnt = count($jobtype_sels);
								for($i=0;$i<$jobtype_sels_cnt;$i++){
									array_push($url, "jobtype_sels[]=".$jobtype_sels[$i]);
								}
							}
							## //기타 검색 변수 ###############################################################################################################################################################


							/* 검색어 */
							if($search_keyword){

								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que .= " INSTR(LOWER(`wr_subject`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_introduce`), LOWER('".$search_keyword."')) ) ";
								} else {
									$search_que = "( INSTR(`wr_subject`, '".$search_keyword."') or INSTR(`wr_introduce`, '".$search_keyword."') ) ";
								}

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							array_push($que, $search_que);

							}
							/* // 검색어 */


						}


						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}

				/**
				* 이력서 리스트 출력시 각종 효과를 적용한다
				* no :: 공고 번호
				* service :: 서비스 위치 ( main_focus, sub_focus 등등 )
				*/
				function get_resume_service( $no, $service="", $subject_len=32, $photo_width="", $photo_height="" ){

					global $application;
					global $alice, $utility, $member, $is_member, $is_admin;
					global $user_control, $category_control, $payment_control, $service_control, $alba_user_control, $member_control;


						$result = array();

						$list = $this->get_resume_no($no);	// 이력서 정보

						$wr_id = $list['wr_id'];	// 이력서 등록 id

						$result['wr_id'] = $wr_id;
						
						$get_member = $user_control->get_member($wr_id);	// 작성 회원 정보

						$get_payment = $payment_control->get_payment_for_oid($list['wr_oid']);	 // 결제정보

						$is_service = $this->service_valid( $list );	// 서비스 정보
						
						switch($service){

							## 메인 포커스
							case 'main_focus':
								$result['gold_service'] = ($is_service['service_focus_gold']) ? 'gold' : '';	// 골드 서비스
							break;

							## 서브 포커스
							case 'sub_focus':
								$result['gold_service'] = ($is_service['service_sub_focus_gold']) ? 'gold' : '';	// 골드 서비스
							break;

							default :
							break;

						}

						/* 회원 사진 */
						$wr_photo = $get_member['mb_photo'];
						if($wr_photo){
							$photo_path = "/data/member/" . $wr_id;	//$alice['data_member_path'] . '/' . $wr_id;
							$photo = $this->photo_print( $photo_path."/".$get_member['mb_photo'], $result['wr_name'], $photo_width, $photo_height );
							$result['wr_photo'] = $photo;
							$result['is_photo'] = true;
							$result['photo_path'] = $alice['data_member_path'] . "/" . $wr_id . "/" . $get_member['mb_photo'];
						} else {
							$_photo_gender = $get_member['mb_gender'] ? '2' : '';
							//$result['wr_photo'] = "<img src=\"/".$application."/images/basic/bg_noPhoto.gif\"/>";
							$result['wr_photo'] = "<img src=\"/".$application."/images/id_pic".$_photo_gender.".png\"/>";
							$result['is_photo'] = false;
							$result['photo_path'] = "";
						}
						/* // 회원 사진 */

						// 급구 아이콘
						$result['service_busy'] = "";
						if($is_service['service_busy']){
							$service_check = $service_control->service_check('resume_option_busy');
							$result['service_busy'] = "<img src=\"".$alice['data_icon_path'] . "/" . $service_check['busy_icon']."\" class=\"vm pr5\"/>";
						}

						// 강조 아이콘
						$result['service_icon'] = "";
						if($is_service['service_icon']){	
							$icon_sel = $category_control->get_category($get_payment['pay_resume_option_icon_sel']);
							$result['service_icon'] = "<img src=\"".$alice['data_icon_path'] . "/" . $icon_sel['name']."\" class=\"vm pr5\">";
						}

						$style_add = " style=\"";

						// 형광펜
						if($is_service['service_neon']){
							$style_add .= "background-color:#".$get_payment['pay_resume_option_neon_color'].";";
						}

						// 굵은글자
						if($is_service['service_bold']){
							$style_add .= "font-weight:bold;";
						}

						// 글자색
						if($is_service['service_color']){
							$style_add .= "color:#".$get_payment['pay_resume_option_color_sel'].";";
						}

						$style_add .= "\" ";

						// 반짝임
						$class = "";
						if($is_service['service_blink']){
							$class = "class=\"jumble\"";
						}


						/* 이력서 이름 */
						if($is_member){		// 회원일때
							if($member['mb_type']=='company'){	 // 업소회원의 경우 열람권 체크
								$get_service = $member_control->get_service_member($member['mb_id']);
								$open_service_valid = $utility->valid_day($get_service['mb_service_open']);
								$is_open_resume = $this->is_open_resume('alba',$member['mb_id'],$wr_id);
								//if($open_service_valid || $is_open_resume){	 // 열람권이 있다면 보여주고
								if($is_open_resume){	 // 열람 기록이 있다면 보여준다
									$wr_name = $name = stripslashes($get_member['mb_name']);
									$is_open = true;
								} else {	 // 없음 감추기
									$wr_name = trim( $utility->make_pass_00( stripslashes($get_member['mb_name']) ) );
									$name = trim( $utility->make_pass_○○( stripslashes($get_member['mb_name']) ) );
									$is_open = false;
								}
							} else if($member['mb_type']=='individual'){	 // 개인회원의 경우 자신의 이력서 인지 체크
								if($wr_id==$member['mb_id']){	// 내 이력서 라면
									$wr_name = $name = stripslashes($get_member['mb_name']);
									$is_open = true;
								} else {	 // 내 이력서가 아니라면
									$wr_name = trim( $utility->make_pass_00( stripslashes($get_member['mb_name']) ) );
									$name = trim( $utility->make_pass_○○( stripslashes($get_member['mb_name']) ) );
									$is_open = false;
								}
							}
						} else {	 // 회원이 아닐때 (무조건 감춤)
							$wr_name = trim( $utility->make_pass_00( stripslashes($get_member['mb_name']) ) );
							$name = trim( $utility->make_pass_○○( stripslashes($get_member['mb_name']) ) );
							$is_open = false;
						}
						$result['wr_name'] = $wr_name;
						$result['name'] = $name;
						$result['is_open'] = ($is_admin) ? true : $is_open;
						/* // 이력서 이름 */


						/* 직종 */
						$job_type_arr = array( "job_type0" => $list['wr_job_type0'], "job_type1" => $list['wr_job_type3'], "job_type2" => $list['wr_job_type6'] );
						$result['job_type'] = $this->list_type($job_type_arr);
						/* // 직종 */

						
						// 성별
						$result['wr_gender'] = $this->gender_text[$get_member['mb_gender']];

						
						/* 나이 (내/외국인 구분) */
						$get_age = $member_control->get_age($get_member['mb_birth']);
						$result['wr_age'] = $get_age;
						/* //나이 (내/외국인 구분) */


						/* 경력 정보 추출 */
						$wr_career = unserialize($list['wr_career']);
						if($wr_career){
							$wr_career_cnt = count($wr_career);
							$career = 0;
							for($i=0;$i<$wr_career_cnt;$i++){
								$career += $utility->date_diff($wr_career[$i]['sdate'],$wr_career[$i]['edate']);
							}							
							$strtime = time() - strtotime("-".$career.' day');
							$year = date("Y", $strtime) - 1970;
							$month = date("m", $strtime);
							$result['wr_career'] = "약 " . sprintf('%02d',$year) . "년 " . $month . "개월";
							$result['career'] = "<span class='cr1'>약</span> <span class='cr_year'>".sprintf('%02d',$year)."</span><span class='cr2'>년</span> <span class='cr_month'>".$month."</span><span class='cr2'>개월</span>";
						} else {
							$result['wr_career'] = $result['career'] = "신입";
						}
						/* //경력 정보 추출 */


						// 이력서 제목
						$wr_subject = stripslashes($list['wr_subject']);
						$result['subject'] = "<span ".$style_add." ".$class.">" . $utility->str_cut($wr_subject,$subject_len) . "</span>";	// 공고 제목
						$result['wr_subject'] = $wr_subject;


						/* 학력 정보 추출 */
						$wr_school_ability = explode("/",$list['wr_school_ability']);
						$result['school_ability'] = $category_control->get_categoryCodeName($wr_school_ability[0]);
						$wr_school_type = explode(",",$list['wr_school_type']);	 // 입력학력
						$wr_school_type_cnt = count($wr_school_type);

						if($wr_school_type[0]!=''){	// 값이 있을때
							for($i=0;$i<$wr_school_type_cnt;$i++){
								if($wr_school_type[$i]=='half_college'){	// 대학(2,3년) 전공
									$wr_half_college = unserialize($list['wr_half_college']);
									$result['specialize'] = @implode($wr_half_college['college_specialize'],", ");
								}
								if($wr_school_type[$i]=='college'){	// 대학교(4년)
									$wr_college = unserialize($list['wr_college']);
									$result['specialize'] = @implode($wr_college['college_specialize'],", ");
								}
								if($wr_school_type[$i]=='graduate'){	// 대학원
									$wr_graduate = unserialize($list['wr_graduate']);
									$result['specialize'] = @implode($wr_graduate['graduate_specialize'],", ");
								}
							}
						}
						/* //학력 정보 추출 */


						/* 자격증 정보 추출 */
						if($list['wr_license_use']){
							$wr_license = unserialize($list['wr_license']);
							$wr_license_cnt = count($wr_license);
							$license = "";
							for($i=0;$i<$wr_license_cnt;$i++){
								$license_comma = ($i != ($wr_license_cnt-1)) ? ", " : "";
								$license .= $wr_license[$i]['name'] . $license_comma;
							}
							$result['license'] = $license;
						}
						/* // 자격증 정보 추출 */


						/* 급여 조건 */
						if($list['wr_pay_conference']){	 // 추후협의
							$result['wr_pay_type'] = "협의";
							$result['wr_pay'] = "";
						} else {
							$result['wr_pay_type'] = $category_control->get_categoryCodeName($list['wr_pay_type']);	// 급여조건
							$result['wr_pay'] = number_format($list['wr_pay'])."원";
						}
						/* // 급여 조건 */


						/* 희망지역 */
						$wr_area_0 = "";
						if($list['wr_area0']){
							$result['wr_area0'] = $list['wr_area0'];
							$wr_area_0 .= $category_control->get_categoryCodeName($list['wr_area0']);
						}
						if($list['wr_area1']){
							$result['wr_area1'] = $list['wr_area1'];
							$wr_area_0 .= " > " . $category_control->get_categoryCodeName($list['wr_area1']);
						}
						$wr_area_1 = "";
						if($list['wr_area2']){
							$result['wr_area2'] = $list['wr_area2'];
							$wr_area_1 .= $category_control->get_categoryCodeName($list['wr_area2']);
						}
						if($list['wr_area3']){
							$result['wr_area3'] = $list['wr_area3'];
							$wr_area_1 .= " > " . $category_control->get_categoryCodeName($list['wr_area3']);
						}
						$wr_area = $wr_area_0;
						$wr_areas = $wr_area_0;
						if($wr_area_1 != '' ){
							$wr_area .= "<br/>".$wr_area_1;
						}
						$result['wr_area'] = $wr_area;

						if($wr_area_1 != '' ){
							$wr_areas .= ", ".$wr_area_1;
						}
						$result['wr_area_0'] = $wr_areas;
						/* // 희망지역 */


						/* 회원 주소 */
						$result['mb_address0'] = $get_member['mb_address0'];
						$result['mb_address1'] = $get_member['mb_address1'];
						$result['mb_address'] = $result['mb_address0'] . " " . $result['mb_address1'];
						/* // 회원 주소 */

						$result['mb_hphone'] = ($get_member['mb_hphone']) ? $get_member['mb_hphone'] : $get_member['mb_phone'];	// 회원 연락처
						$result['mb_email'] = $get_member['mb_email'];	 // 회원 이메일 주소


						/* 등록일/수정일 */
						$result['wdate'] = $list['wr_wdate'];	 // 등록일
						$wdate1 = explode(" ",$list['wr_wdate']);	 // 등록일
						$result['wdate1'] = $wdate1[0];

						$result['datetime'] = substr($list['wr_wdate'],0,10);
						$result['datetime2'] = $list['wr_wdate'];
						if($result['datetime'] == date("Y-m-d", $alice['server_time']))
							$result['datetime2'] = substr($result['datetime2'],11,5);
						else
							$result['datetime2'] = substr($result['datetime2'],0,10);

						$result['datetime3'] = substr($result['datetime2'],5,5);

						$result['last'] = substr($list['wr_udate'],0,10);
						$list['last2'] = $list['wr_udate'];

						if($result['last'] == date("Y-m-d", $alice['server_time'])) {
							$result['last2'] = "today";
							$result['last3'] = substr($list['last2'],11,5);
						} else {
							$result['last2'] = strtr(substr($list['last2'],5,5),'-','/');
							$result['last3'] = substr($list['last2'],5,5);
						}
						/* // 등록일/수정일 */

						$result['wr_date'] = $list['wr_date'];
						$result['is_delete'] = $list['is_delete'];


					return $result;

				}


				// 이력서별 사진 출력
				function photo_print( $photo_file, $member_name="", $width="", $height="" ){

						$width = ($width) ? "width='".$width."' " : "";
						$height = ($height) ? "height='".$height."' " : "";

						$result = "<img src=\"".$photo_file."\" alt=\"".$member_name."\" ".$width." ".$height."/>";


					return $result;

				}


				// 카테고리 단/장기 정규직 코드값
				function get_short_longCode( $type ){

					global $category_control;

						if($type=='short'){	 // 단기 정규직 정보

							$query = $this->query_fetch(" select * from `".$category_control->cate_table."` where `type` = 'alba_date' and `etc_0` = '1' ");


						} else {	 // 장기 정규직 정보

							$query = $this->query_fetch(" select * from `".$category_control->cate_table."` where `type` = 'alba_date' and `etc_1` = '1' ");

						}

						$result = $query['code'];

					
					return $result;

				}

				// 카테고리 특기사항 카운팅
				function get_category_count_specialty( $code ){

						$query = " select `wr_specialty` from `".$this->resume_table."` where INSTR(`wr_specialty`, '".$code."') ";

						$result = $this->_queryR($query);


					return $result;

				}


				// 카테고리 기준 카운팅
				function get_category_count( $code, $search_field ){

						$query = " select * from `".$this->resume_table."` where `".$search_field."` = '".$code."' and `wr_open` = 1 and `is_delete` = 0  ";

						$result = $this->_queryR($query);


					return $result;

				}

				// 열람한 이력서 정보인지 체크
				function is_open_resume( $wr_type, $mb_id, $wr_id, $p_no="" ){

						$query = " select * from `".$this->resume_open_table."` where `wr_type` = '".$wr_type."' and `mb_id` = '".$mb_id."' and	`wr_id` = '".$wr_id."' ";

						if($p_no){
							$query .= " and `p_no` = '".$p_no."' ";
						}

						$result = $this->_queryR($query);

					
					return $result;

				}

				// 인재 정보 이름 출력 (서비스 기간에 따라 출력형태 변경)
				function resume_names( $no ){

					global $utility;
					global $member_service;
					global $service_control, $alba_individual_control, $user_control;


						if(!$no || $no=='') return false;

						$get_resume = $alba_individual_control->get_resume_no($no);	// 이력서 정보

						$get_member = $user_control->get_member($get_resume['wr_id']);	 // 등록 회원 정보

						$service_check = $service_control->service_check('etc_open');
						$open_is_pay = $service_check['is_pay'];
						$service_open = $utility->valid_day($member_service['mb_service_open']);	// 이력서 열람 서비스 기간 체크


						// 열람권 기간/건수 확인		
						$is_open_service = false;
						if( $utility->valid_day($member_service['mb_service_open']) ){
							$is_open_service = $member_service['mb_service_open'];
						}
						$is_open_count = false;
						if( $utility->valid_day($member_service['mb_service_open']) && $member_service['mb_service_open_count'] ){	// 건수 사용이 가능하다면
							$is_open_count = $member_service['mb_service_open_count'];
						}

						if($is_open_count){
							$result = $utility->make_pass_○○($get_member['mb_name']);
						} else if( $service_open||$alba_resume_user_control->is_open_resume('alba',$member['mb_id'],$get_resume['wr_id']) ) {
							$result = $get_member['mb_name'];
						} else {
							$result = $utility->make_pass_○○($get_member['mb_name']);
						}


					return $result;

				}


				// 카테고리 지역 카운팅
				function get_category_count_area( $code ){

					global $service_control;

						$basic_check = $service_control->service_check('alba_resume_basic');	// 이력서 일반 리스트 사용시

						$query = " select `wr_area0`, `wr_area1`, `wr_area2` from `".$this->resume_table."` where ( INSTR(`wr_area0`, '".$code."') or INSTR(`wr_area1`, '".$code."') or INSTR(`wr_area2`, '".$code."') ) and `is_delete` = 0 ";

						if($basic_check['is_pay']){
							
							$query .= " and ( `wr_service_basic` >= curdate() ) ";

						}

						//echo $query."<br/><br/>";

						$result = $this->_queryR($query);


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