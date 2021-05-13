<?php
		/**
		* /application/alba/model/alice_alba_user_model.class.php
		* @author Harimao
		* @since 2013/08/01
		* @last update 2015/12/15
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Model class
		* @Comment :: 사용자측 정규직 모델 클래스
		*/
		class alice_alba_user_model extends DBConnection {

			var $alba_table		= "alice_alba";
			var $scrap_table	= "alice_scrap";		// 스크랩 저장 테이블
			var $popular_table	= "alice_popular";	// 검색어 저장 테이블

			var $success_code = array(
					'0000' => '스크랩 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '회원만 스크랩 가능합니다.',
					'0001' => '이미 스크랩 하셨습니다.',
					'0002' => '신고된 공고 입니다.\\n\\n사이트 운영자 확인중입니다.',
					'0003' => '채용공고 고유 데이터 번호가 잘못 되었습니다.\\n\\n해당 공고가 삭제되었거나 공고에 문제가 있을수 있습니다.',
					'0004' => '삭제된 채용공고 입니다.',
					'0005' => '사용가능한 채용공고 열람권이 없습니다.',
			);


			var $subway_top_code = array( "20130730142020_3833", "20130730142022_3078", "20130730142023_6528", "20130730142024_9194", "20130730142026_9165" );	// 지하철 최상위 코드
			var $gender_val = array( 0 => "성별무관", 1 => "남자", 2 => "여자");
			var $paper_val = array( "resume" => "이력서", "transcript" => "주민등록등본", "introduction" => "자기소개서", "graduation" => "졸업증명서", "careers" => "경력증명서", "parent" => "부모님동의서" );
			var $pay_conference_long = array( 0 => "", 1 => "추후협의", 2 => "면접후결정" );
			var $pay_conference = array( 0 => "", 1 => "협의", 2 => "면접" );

				// 리스팅
				function __AlbaList( $page="", $page_rows="", $con="", $order="" ){

						// 검색시 사용
						$_add = $this->_Search( $order );


						$query = " select * from `".$this->alba_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}


						//echo "<p><br/><strong>" . $query."</strong><br/><br/></p>";	// 쿼리 확인

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];
						$result['q'] = $query;

					
					return $result;

				}


				// 정규직 공고 추출 (단수) :: wr_id 기준
				function get_alba( $wr_id, $con="" ){

						if(!$wr_id || $wr_id=='') return false;

						$query = " select * from `".$this->alba_table."` where `wr_id` = '".$wr_id."' " . $con;

						$result = $this->query_fetch($query);


					return $result;
				}


				// 정규직 공고 추출 (단수) :: wr_no 기준
				function get_alba_no( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->alba_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;
				}


				// 전체/오늘의 정규직 카운팅 => 이미지 변환 출력
				// 채용정보 상단에서 사용
				function alba_count_image( $type='all' ){

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
						
						$query = " select * from `".$this->alba_table."` where `wr_open` = 1 and `wr_report` = 0 ";

						switch($type){

							## 전체 정규직 카운팅
							case 'all':

								$total_count = $this->_queryR($query);
								$result = strtr($total_count, $trans_number);

							break;

							## 오늘의 정규직 카운팅
							case 'today':

								$query .= " and `wr_wdate` > curdate() ";

								$total_count = $this->_queryR($query);
								$result = strtr($total_count, $trans_number);

							break;

						}	// switch end.


					return $result;

				}


				// 정규직 검색
				function _Search( $order="" ){

					global $utility, $config;
					global $category_control, $service_control;

						$mode = $_GET['mode'];

						$type = $_GET['type'];
						
						$search_mode = $_GET['search_mode'];	// 검색 페이지별 모드

						$page = $_GET['page'];

						$page_rows = $_GET['page_rows'];

						//$alba_jump_check = $service_control->service_check('alba_option_jump');	// alba jump 체크
						
						if(!$order){
							/*
							if( $alba_jump_check['etc_2'] ){
								//$order .= ", wr_jdate desc ";
								$order = " `wr_jdate` desc, `wr_wdate` ";
							} else {
								$order = " `wr_wdate` ";
							}
							*/

							

							$view_type = $_GET['view_type'];

							$sort = $_GET['sort'];

                            if($sort == 'wr_volume_date') {

								$order = " wr_volume_always asc, wr_volume_end asc, wr_volume_date asc";

                            }else{
								$order = " `wr_jdate` desc, `wr_wdate` ";

							    if($sort) $order = " `" . $sort . "` ";

							    $flag = $_GET['flag'];

								$order .= ($flag) ? " ".$flag." " : " desc ";

							}
						}


						$category_top_val = explode(",",$_GET['category_top_val']);
						$category_top_val_cnt = count($category_top_val);


						$que = array();
						$url = array();


						array_push($url, "category_top_val=".$_GET['category_top_val']);
						array_push($url, "category_middle_val=".$_GET['category_middle_val']);
						array_push($url, "category_sub_val=".$_GET['category_sub_val']);

						if($type) array_push($url,"type=".$type);
						if($search_mode) array_push($url,"search_mode=".$search_mode);

						switch($search_mode){

							## 직종별
							case 'alba_type':

								$alba_type_1 = $_GET['alba_type_1'];	 // 2차 직종
								$alba_type_1_cnt = count($alba_type_1);
								$alba_type_2 = $_GET['alba_type_2'];	 // 3차 직종
								$alba_type_2_cnt = count($alba_type_2);

								$alba_type_que_1 = array();
								$alba_type_que_2 = array();

								$alba_type_first = " ( ";
								for($i=0;$i<$category_top_val_cnt;$i++){	// 1차 직종 검색
									$_or = ($i != ($category_top_val_cnt-1)) ? " or " : "";
									$alba_type_first .= " `wr_job_type0` = '".$category_top_val[$i]."' " . $_or;
									array_push($url, "wr_job_type0[]=" . $category_top_val[$i]);
								}
								$alba_type_first .= " ) ";

								$alba_type_first .= " or ( ";
								for($i=0;$i<$category_top_val_cnt;$i++){	// 1차 직종 검색
									$_or = ($i != ($category_top_val_cnt-1)) ? " or " : "";
									$alba_type_first .= " `wr_job_type3` = '".$category_top_val[$i]."' " . $_or;
								}
								$alba_type_first .= " ) ";

								$alba_type_first .= " or ( ";
								for($i=0;$i<$category_top_val_cnt;$i++){	// 1차 직종 검색
									$_or = ($i != ($category_top_val_cnt-1)) ? " or " : "";
									$alba_type_first .= " `wr_job_type6` = '".$category_top_val[$i]."' " . $_or;
								}
								$alba_type_first .= " ) ";

								if($alba_type_1){	 // 2차 직종 데이터 배열 가공
									foreach($alba_type_1 as $alba_type_1_key => $alba_type_1_val){
										$alba_type_1_val_cnt = count($alba_type_1_val);
										for($j=0;$j<$alba_type_1_val_cnt;$j++){
											array_push($alba_type_que_1,$alba_type_1_val[$j]);
											array_push($url, "alba_type_1[".$alba_type_1_key."][]=".$alba_type_1_val[$j]);
										}
									}

									$alba_type_que_1_cnt = count($alba_type_que_1);

									$alba_type_second = " ( ";
									for($i=0;$i<$alba_type_que_1_cnt;$i++){	// 2차 직종 검색
										$_or = ($i != ($alba_type_que_1_cnt-1)) ? " or " : "";
										$alba_type_second .= " `wr_job_type1` = '".$alba_type_que_1[$i]."' " . $_or;
									}
									$alba_type_second .= " ) ";

									$alba_type_second .= " or ( ";
									for($i=0;$i<$alba_type_que_1_cnt;$i++){	// 2차 직종 검색
										$_or = ($i != ($alba_type_que_1_cnt-1)) ? " or " : "";
										$alba_type_second .= " `wr_job_type4` = '".$alba_type_que_1[$i]."' " . $_or;
									}
									$alba_type_second .= " ) ";

									$alba_type_second .= " or ( ";
									for($i=0;$i<$alba_type_que_1_cnt;$i++){	// 2차 직종 검색
										$_or = ($i != ($alba_type_que_1_cnt-1)) ? " or " : "";
										$alba_type_second .= " `wr_job_type7` = '".$alba_type_que_1[$i]."' " . $_or;
									}
									$alba_type_second .= " ) ";

								}
	
								if($alba_type_2){	 // 3차 직종 데이터 배열 가공
									foreach($alba_type_2 as $alba_type_2_key => $alba_type_2_val){
										foreach($alba_type_2_val as $key => $val){
											$val_cnt = count($val);
											for($j=0;$j<$val_cnt;$j++){
												array_push($alba_type_que_2,$val[$j]);
												array_push($url, "alba_type_2[".$alba_type_2_key."][".$key."][]=".$val[$j]);
											}
										}
									}

									$alba_type_que_2_cnt = count($alba_type_que_2);

									$alba_type_third = " ( ";
									for($i=0;$i<$alba_type_que_2_cnt;$i++){	// 3차 직종 검색
										$_or = ($i != ($alba_type_que_2_cnt-1)) ? " or " : "";
										$alba_type_third .= " `wr_job_type2` = '".$alba_type_que_2[$i]."' " . $_or;
									}
									$alba_type_third .= " ) ";

									$alba_type_third .= " or ( ";
									for($i=0;$i<$alba_type_que_2_cnt;$i++){	// 3차 직종 검색
										$_or = ($i != ($alba_type_que_2_cnt-1)) ? " or " : "";
										$alba_type_third .= " `wr_job_type5` = '".$alba_type_que_2[$i]."' " . $_or;
									}
									$alba_type_third .= " ) ";
									
									$alba_type_third .= " or ( ";
									for($i=0;$i<$alba_type_que_2_cnt;$i++){	// 3차 직종 검색
										$_or = ($i != ($alba_type_que_2_cnt-1)) ? " or " : "";
										$alba_type_third .= " `wr_job_type8` = '".$alba_type_que_2[$i]."' " . $_or;
									}
									$alba_type_third .= " ) ";

								}

							break;

							## 지역별
							case 'alba_area':

								$alba_area_1 = $_GET['alba_area_1'];
								$alba_area_1_cnt = count($alba_area_1);
								$alba_area_2 = $_GET['alba_area_2'];
								$alba_area_2_cnt = count($alba_area_2);

								$alba_area_que_1 = array();
								$alba_area_que_2 = array();

								$alba_area_first = " ( ";
								for($i=0;$i<$category_top_val_cnt;$i++){	// 1차 지역 검색
									$_or = ($category_top_val_cnt != $i+1) ? " or " : "";
									$alba_area_first .= " ( INSTR( `wr_area_0`, '".$category_top_val[$i]."' ) or INSTR( `wr_area_1`, '".$category_top_val[$i]."' ) or INSTR( `wr_area_2`, '".$category_top_val[$i]."' ) ) " . $_or;
									array_push($url, "alba_area_0[]=" . $category_top_val[$i]);
								}
								$alba_area_first .= " ) ";

								if($alba_area_1){	 // 2차 지역 데이터 배열 가공
									$is_all = false;
									foreach($alba_area_1 as $alba_area_1_key => $alba_area_1_val){
										$alba_area_1_val_cnt = count($alba_area_1_val);
										for($j=0;$j<$alba_area_1_val_cnt;$j++){
											if( stristr($alba_area_1_val[$j],'all') ){
												$is_all = true;
											} else {
												$is_all = false;
												array_push($alba_area_que_1,$alba_area_1_val[$j]);
											}
											array_push($url, "alba_area_1[".$alba_area_1_key."][]=" . $alba_area_1_val[$j]);
										}
									}

									if(!$is_all){	// 전체가 아닐때

										$alba_area_que_1_cnt = count($alba_area_que_1);

										$alba_area_second = " ( ";
										for($i=0;$i<$alba_area_que_1_cnt;$i++){	// 2차 지역 검색
											$_or = ($i != ($alba_area_que_1_cnt-1)) ? " or " : "";
											$alba_area_second .= " ( INSTR( `wr_area_0`, '".$alba_area_que_1[$i]."' ) or INSTR( `wr_area_1`, '".$alba_area_que_1[$i]."' ) or INSTR( `wr_area_2`, '".$alba_area_que_1[$i]."' ) ) " . $_or;
										}
										$alba_area_second .= " ) ";

									}

								}
	
								if($alba_area_2){	 // 3차 지역 데이터 배열 가공
									$is_all = false;
									foreach($alba_area_2 as $alba_area_2_key => $alba_area_2_val){
										foreach($alba_area_2_val as $key => $val){
											$val_cnt = count($val);
											for($j=0;$j<$val_cnt;$j++){
												if( stristr($val[$j],'all') ){
													$is_all = true;
												} else {
													$is_all = false;
													array_push($alba_area_que_2,$val[$j]);
												}
												array_push($url, "alba_area_2[".$alba_area_2_key."][".$key."][]=" . $val[$j]);
											}
										}
									}

									if(!$is_all){	// 전체가 아닐때

										$alba_area_que_2_cnt = count($alba_area_que_2);

										$alba_area_third = " ( ";
										for($i=0;$i<$alba_area_que_2_cnt;$i++){	// 3차 지역 검색
											$_or = ($i != ($alba_area_que_2_cnt-1)) ? " or " : "";
											$alba_area_third .= " ( INSTR( `wr_area_0`, '".$alba_area_que_2[$i]."' ) or INSTR( `wr_area_1`, '".$alba_area_que_2[$i]."' ) or INSTR( `wr_area_2`, '".$alba_area_que_2[$i]."' ) ) " . $_or;
										}
										$alba_area_third .= " ) ";

									}

								}
							
							break;

							## 역세권
							case 'alba_subway':

								$alba_subway_1 = $_GET['alba_subway_1'];
								$alba_subway_1_cnt = count($alba_subway_1);
								$alba_subway_2 = $_GET['alba_subway_2'];
								$alba_subway_2_cnt = count($alba_subway_2);

								$alba_subway_que_1 = array();
								$alba_subway_que_2 = array();


								$alba_subway_first = " ( ";
								for($i=0;$i<$category_top_val_cnt;$i++){	// 1차 역세권 검색
									$_or = ($category_top_val_cnt != $i+1) ? " or " : "";
									$alba_subway_first .= " ( `wr_subway_area_0` = '".$category_top_val[$i]."' or `wr_subway_area_1` = '".$category_top_val[$i]."'  or `wr_subway_area_2` = '".$category_top_val[$i]."' ) " . $_or;
									array_push($url, "alba_subway_0[]=" . $category_top_val[$i]);
								}
								$alba_subway_first .= " ) ";

								if($alba_subway_1){	 // 2차 직종 데이터 배열 가공
									foreach($alba_subway_1 as $alba_subway_1_key => $alba_subway_1_val){
										$alba_subway_1_val_cnt = count($alba_subway_1_val);
										for($j=0;$j<$alba_subway_1_val_cnt;$j++){
											array_push($alba_subway_que_1,$alba_subway_1_val[$j]);
											array_push($url, "alba_subway_1[".$alba_subway_1_key."][]=" . $alba_subway_1_val[$j]);
										}
									}

									$alba_subway_que_1_cnt = count($alba_subway_que_1);

									$alba_subway_second = " ( ";
									for($i=0;$i<$alba_subway_que_1_cnt;$i++){	// 2차 역세권 검색
										$_or = ($i != ($alba_subway_que_1_cnt-1)) ? " or " : "";
										$alba_subway_second .= " ( INSTR( `wr_subway_line_0`, '".$alba_subway_que_1[$i]."' ) or INSTR( `wr_subway_line_1`, '".$alba_subway_que_1[$i]."' ) or INSTR( `wr_subway_line_2`, '".$alba_subway_que_1[$i]."' ) ) " . $_or;
									}
									$alba_subway_second .= " ) ";
								}
	
								if($alba_subway_2){	 // 3차 역세권 데이터 배열 가공
									foreach($alba_subway_2 as $alba_subway_2_key => $alba_subway_2_val){
										foreach($alba_subway_2_val as $key => $val){
											$val_cnt = count($val);
											for($j=0;$j<$val_cnt;$j++){
												array_push($alba_subway_que_2,$val[$j]);
												array_push($url, "alba_area_2[".$alba_subway_2_key."][".$key."][]=" . $val[$j]);
											}
										}
									}

									$alba_subway_que_2_cnt = count($alba_subway_que_2);

									$alba_subway_third = " ( ";
									for($i=0;$i<$alba_subway_que_2_cnt;$i++){	// 3차 역세권 검색
										$_or = ($i != ($alba_subway_que_2_cnt-1)) ? " or " : "";
										$alba_subway_third .= " ( INSTR( `wr_subway_station_0`, '".$alba_subway_que_2[$i]."' ) or INSTR( `wr_subway_station_1`, '".$alba_subway_que_2[$i]."' ) or INSTR( `wr_subway_station_2`, '".$alba_subway_que_2[$i]."' ) ) " . $_or;
									}
									$alba_subway_third .= " ) ";
								}

							break;

							## 대학가
							case 'alba_college':

								$alba_college_1 = $_GET['alba_college_1'];
								$alba_college_1_cnt = count($alba_college_1);

								$alba_college_que_1 = array();

								$alba_college_first = " `wr_college_area` in (";
								for($i=0;$i<$category_top_val_cnt;$i++){	// 1차 인근대학 지역 검색
									$_comma = ($category_top_val_cnt != $i+1) ? ", " : "";
									$alba_college_first .= " '".$category_top_val[$i]."' " . $_comma;
									array_push($url, "alba_college_0[]=" . $category_top_val[$i]);
								}
								$alba_college_first .= " ) ";

								if($alba_college_1){	 // 2차 직종 데이터 배열 가공
									foreach($alba_college_1 as $alba_college_1_key => $alba_college_1_val){
										$alba_college_1_val_cnt = count($alba_college_1_val);
										for($j=0;$j<$alba_college_1_val_cnt;$j++){
											array_push($alba_college_que_1,$alba_college_1_val[$j]);
											array_push($url, "alba_college_1[".$alba_college_1_key."][]=" . $alba_college_1_val[$j]);
										}
									}

									$alba_college_que_1_cnt = count($alba_college_que_1);

									$alba_college_second = " `wr_college_vicinity` in ( ";
									for($i=0;$i<$alba_college_que_1_cnt;$i++){	// 2차 역세권 검색
										$_comma = ($i != ($alba_college_que_1_cnt-1)) ? ", " : "";
										$alba_college_second .= " '".$alba_college_que_1[$i]."' " . $_comma;
									}
									$alba_college_second .= " ) ";
								}

							break;

							## 급여별
							case 'alba_pay':

								$alba_pay = $_GET['alba_pay'];

								if($type=='day'){	// 급여별 지원조건

									$wr_pay_support = $_GET['wr_pay_support'];
									$alba_pay_first = " INSTR( `wr_pay_support`, '".$wr_pay_support."' ) ";
									array_push($url, "wr_pay_support=" . $wr_pay_support);

								} else {

									if($alba_pay){

										$i = 0;
										$alba_pay_first = " ( ";
										foreach($alba_pay as $key => $val){
											$_or = ($i != count($alba_pay)-1) ? " or " : "";
											$alba_pay_first .= " ( `wr_pay_type` = '".$key."' ";

											$wr_pay = $category_control->get_categoryCode($val);
											$wr_pay_name = $wr_pay['name'];
											$wr_pay_level = $wr_pay['etc_0'];

											if(stristr($wr_pay_name,'~')){	 // 10000 ~ 20000

												$pay = explode('~',$wr_pay_name);
												//$pays = strtr($wr_pay_name,'~',' > ');

												$alba_pay_first .= " and `wr_pay` between ".$pay[0]." and " . $pay[1];
												
											} else {	 // 10000
												
												switch($wr_pay_level){
													case 'under':	// 미만
														$alba_pay_first .= " and `wr_pay` < " . $wr_pay_name;
													break;
													case 'exceed':	// 초과
														$alba_pay_first .= " and `wr_pay` > " . $wr_pay_name;
													break;
													case 'high':	// 이상
														$alba_pay_first .= " and `wr_pay` >= " . $wr_pay_name;
													break;
													case 'low':	// 이하
														$alba_pay_first .= " and `wr_pay` <= " . $wr_pay_name;
													break;
												}

											}

											$alba_pay_first .= " ) " . $_or;
											
											array_push($url, "alba_pay[".$key."]=" . $val);

										$i++;
										}
										$alba_pay_first .= " ) ";

									}
								}
								
							break;

							## 대상별
							case 'alba_target':

								$wr_target = $_GET['wr_target'];

								$alba_target = " INSTR( `wr_target`, '".$wr_target."') ";

								array_push($url, "wr_target=" . $wr_target);

							break;

							## 19 정규직
							case 'alba_list_adult':

								$alba_adult_1 = $_GET['alba_list_adult_1'];
								$alba_adult_1_cnt = count($alba_adult_1);

								$alba_adult_que_1 = array();
								$alba_adult_que_2 = array();

								$alba_adult_first = " `wr_job_type0` = '".$type."' ";

								if($alba_adult_1){	 // 2차 직종 데이터 배열 가공

									$alba_adult_second = " `wr_job_type1` in ( ";
									$c = 0;
									foreach($alba_adult_1 as $alba_adult_1_key => $alba_adult_1_val){
										$_comma = ($c != ($alba_adult_1_cnt-1) ) ? ", ":"";
										$alba_adult_second .= " '".$alba_adult_1_key."' " . $_comma;
										$alba_adult_1_val_cnt = count($alba_adult_1_val);
										if($alba_adult_1_val_cnt){
											for($i=0;$i<$alba_adult_1_val_cnt;$i++){
												array_push($alba_adult_que_2,$alba_adult_1_val[$i]);
												array_push($url, "alba_list_adult_1[".$alba_adult_1_key."][]=".$alba_adult_1_val[$i]);
											}
										}
									$c++;
									}
									$alba_adult_second .= " ) ";

									$alba_adult_que_2_cnt = count($alba_adult_que_2);

									if($alba_adult_que_2_cnt){

										$alba_adult_third = " `wr_job_type2` in ( ";
										for($i=0;$i<$alba_adult_que_2_cnt;$i++){
											$_comma = ($i != ($alba_adult_que_2_cnt-1) ) ? ", ":"";
											$alba_adult_third .= " '".$alba_adult_que_2[$i]."' " . $_comma;
										}
										$alba_adult_third .= " ) ";
									}

								}

							break;

						}	// search_mode switch end.


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
							$area_que .= " ( INSTR( `wr_area_0`, '".$wr_area_0[$i]."' ) or INSTR( `wr_area_1`, '".$wr_area_0[$i]."' ) or INSTR( `wr_area_2`, '".$wr_area_0[$i]."' ) ) " . $_and;
							array_push($url, "wr_area_0[]=" . $wr_area_0[$i]);
						}

						if($wr_area_1 ){	// 2차 지역 데이터 배열 가공
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
							
							if(!$is_all)
								$area_que .= " and ";
						}
					
						$area_que_1_cnt = count($area_que_1);
						
						for($i=0;$i<$area_que_1_cnt;$i++){	// 2차 지역 검색
							$_and = ($area_que_1_cnt != $i+1) ? " or " : "";
							$area_que .= " ( INSTR( `wr_area_0`, '".$area_que_1[$i]."' ) or INSTR( `wr_area_1`, '".$area_que_1[$i]."' ) or INSTR( `wr_area_2`, '".$area_que_1[$i]."' ) ) " . $_and;
						}

						if($wr_area_2){	// 3차 지역 데이터 배열 가공
							$is_all = false;
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


						// 역세권
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
										array_push($url, "wr_jobtype_7[".$jobtype_2_key."][".$key."][]=" . $val[$j]);
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



						// 근무조건
						$wr_date = $_GET['wr_date'];		// 근무기간
						$wr_week = $_GET['wr_week'];	// 근무요일

						// 근무시간
						$wr_stime = $_GET['wr_stime'];	// 시작시간
						$wr_etime = $_GET['wr_etime'];	// 종료시간
						$wr_time_conference = $_GET['wr_time_conference'];	// 시간협의

						$wr_ability = $_GET['wr_ability'];	// 학력

						$wr_career_type = $_GET['wr_career_type'];	// 경력
						$wr_career = $_GET['wr_career'];	// 경력 조건 ( ~ 이하 )

						$wr_age = $_GET['wr_age'];	// 입력 나이
						$wr_age_limit = $_GET['wr_age_limit'];	// 나이 무관포함

						$wr_gender = $_GET['wr_gender'];	// 성별


						$search_field = $_GET['search_field'];	// 검색 필드

						//$search_keyword = preg_replace( "/\//", "\/", trim( urldecode($_GET['search_keyword']) ) );	 // 다른 방식
						$search_keyword = urldecode( trim($_GET['search_keyword']) );	 // 검색 키워드


						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드


							/* 지역 검색 */
								if($wr_area_0 || $wr_area_1 || $wr_area_2){
									array_push($que, $area_que);
								}

								// 지역별 검색
								if($_GET['category_top_val'] && $alba_area_first){
									if($alba_area_first) array_push($que, $alba_area_first);
									if($alba_area_second) array_push($que, $alba_area_second);
									if($alba_area_third) array_push($que, $alba_area_third);
								}
							/* // 지역 검색 */


							/* 역세권 검색 */
								if($wr_subway_0 || $wr_subway_1 || $wr_subway_2){
									array_push($que, $subway_que);
								}
								if($_GET['category_top_val'] && $alba_subway_first){
									if($alba_subway_first) array_push($que, $alba_subway_first);
									if($alba_subway_second) array_push($que, $alba_subway_second);
									if($alba_subway_third) array_push($que, $alba_subway_third);
								}
							/* // 역세권 검색 */


							/* 직종 검색 */
								// 1차 직종
								if($wr_jobtype_0) array_push($que, " (" . $jobtype_first . ") ");

								// 2차 직종
								if($wr_jobtype_1) array_push($que, " (" . $jobtype_second . ") ");
								
								// 3차 직종
								if($wr_jobtype_2) array_push($que, " (" . $jobtype_third . ") ");

								// 직종별 검색
								if($_GET['category_top_val'] && $alba_type_first){
									if($alba_type_first) array_push($que, " (" . $alba_type_first . ") ");
									if($alba_type_second) array_push($que, " (" . $alba_type_second . ") ");
									if($alba_type_third) array_push($que, " (" . $alba_type_third . ") ");
								}

								// 19 정규직 검색
								if($_GET['category_top_val'] && $alba_adult_first){
									if($alba_adult_first) array_push($que, $alba_adult_first);
									if($alba_adult_second) array_push($que, $alba_adult_second);
									if($alba_adult_third) array_push($que, $alba_adult_third);
								}
							/* // 직종 검색 */


							/* 대학가 검색 */
								// 인근 대학가
								if($_GET['category_top_val'] && $alba_college_first){
									if($alba_college_first) array_push($que, $alba_college_first);
									if($alba_college_second) array_push($que, $alba_college_second);
								}
							/* // 대학가 검색 */


							/* 급여별 검색 */
								if($_GET['alba_pay'] && $alba_pay_first){
									if($alba_pay_first) array_push($que, $alba_pay_first);
								} else if( ($_GET['search_mode'] == 'alba_pay' && $type == 'day' ) && $alba_pay_first) {
									if($alba_pay_first) array_push($que, $alba_pay_first);
								}
							/* //급여별 검색 */


							/* 테마별 검색 */
								if($alba_target){
									array_push($que, $alba_target);
								}
							/* //테마별 검색 */



							/* 보장제도 검색 */
								$wr_preferential = $_GET['wr_preferential'];
								if($wr_preferential){
									array_push($que, " `wr_preferential` = '".$wr_preferential."' ");
									array_push($url, "wr_preferential=" . $wr_preferential);
								}
							/* //보장제도 검색 */

							
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

								//array_push( $que, " (`wr_stime` = '' and `wr_etime` = '' and `wr_time_conference` = '1' ) " );
								array_push( $que, " `wr_time_conference` = '1' " );
								array_push($url, "wr_time_conference=".$wr_time_conference);
								
							}
							/* // 근무시간 검색 */


							/* 학력 검색 */
							if($wr_ability){
								array_push( $que, " `wr_ability` = '".$wr_ability."' " );
								array_push($url, "wr_ability=".$wr_ability);
							}
							/* // 학력 검색 */


							/* 경력 검색 */
							if($wr_career_type != ''){
								$career_que = "(";
								$career_que .= " `wr_career_type` = '".$wr_career_type."' ";
								array_push($url, "wr_career_type=".$wr_career_type);
								if($wr_career){	// 경력 기간
									$career_que .= " and `wr_career` = '".$wr_career."' ";
									array_push($url, "wr_career=".$wr_career);
								}
								$career_que .= ")";
								array_push( $que, $career_que );
							}
							/* // 경력 검색 */


							/* 나이 검색 */
							if($wr_age){
								$age_que = "(";
								$age_que .= " substring( `wr_age`,1 ,2 ) >= ".$wr_age." ";
								array_push($url, "wr_age=".$wr_age);
								if($wr_age_limit){
									$age_que .= " or `wr_age_limit` = '0' ";
									array_push($url, "wr_age_limit=".$wr_age_limit);
								}
								$age_que .= ")";
								array_push( $que, $age_que );	// and substring( `wr_age`,4 ,2 ) <= '".$wr_age."'
							}
							/* //나이 검색 */

							
							/* 성별 검색 */
							if($wr_gender){	//  || $wr_gender=='0'
								array_push( $que, " ( `wr_gender` = '".$wr_gender."' ) " );
								array_push($url, "wr_gender=".$wr_gender);
							}
							/* //성별 검색 */

							## 근무형태 검색 ###########################################################################################################
							$wr_work_type = $_GET['wr_work_type'];
							if($wr_work_type){
								echo $wr_work_type." <==<br/>";
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

							if($search_mode){
								$jobtype_sels = $_GET[$search_mode.'_sels'];
								if($jobtype_sels){
									$jobtype_sels_cnt = count($jobtype_sels);
									for($i=0;$i<$jobtype_sels_cnt;$i++){
										array_push($url, $search_mode."_sels[]=".$jobtype_sels[$i]);
									}
								}
							} else {
								$jobtype_sels = $_GET['jobtype_sels'];
								if($jobtype_sels){
									$jobtype_sels_cnt = count($jobtype_sels);
									for($i=0;$i<$jobtype_sels_cnt;$i++){
										array_push($url, "jobtype_sels[]=".$jobtype_sels[$i]);
									}
								}
							}
							## //기타 검색 변수 ##########################################################################################################


							/* 검색어 */
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
							/* // 검색어 */

						}

						array_push($url, "view_type=" . $view_type);
						array_push($url, "sort=" . $sort);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 스크랩 카운팅
				function get_scrap_cnt( $mb_id, $rel_table="", $rel_id="", $rel_action="" ){

						if(!$mb_id || $mb_id=="") return '0000';

						$query = " select count(*) as cnt from `".$this->scrap_table."` where `mb_id` = '".$mb_id."' and `scrap_rel_table` = '".$rel_table."' and `scrap_rel_id` = '".$rel_id."' "; // and `scrap_rel_action` = '".$rel_action."'

						$result = $this->query_fetch($query);


					return $result;

				}


				/**
				* 채용정보 리스트 출력시 각종 효과를 적용한다
				* no :: 공고 번호
				* service :: 서비스 위치 ( main_platinum, sub_platinum 등등 )
				*/
				function get_alba_service( $no, $service="", $subject_len=32 ){

					global $alice, $utility;
					global $user_control, $category_control, $payment_control, $service_control, $alba_user_control;

						$result = array();

						$list = $this->get_alba_no($no);	// 정규직 정보

						$list['company_name'] = stripslashes($list['wr_company_name']);

						$get_payment = $payment_control->get_payment_for_oid($list['wr_oid']);	 // 결제정보

						$wr_id = $list['wr_id'];	// 정규직 등록 id

						$result['no'] = $list['no'];
						$result['wr_id'] = $wr_id;

						$company_info = $user_control->get_member_company($wr_id);	// 등록 업소회원 정보

						switch($service){

							## 메인 플래티넘
							case 'main_platinum':
								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_platinum_main_gold']) ? 'gold' : '';	// 골드 서비스
								
								// 업소 로고
								$logo_path = $alice['data_alba_path'] . "/" . $list['etc_0'];
								
								if($list['input_type']=='self'){	// 직접 입력
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_platinum_main_logo']){
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\" style=\"max-width:100px; max-height:50px;\"/>";
										}
									} else {
										$result['wr_logo'] = "<img src=\"".$alice['images_path']."/basic/bg_noLogo.gif\"/>";
									}
								} else {
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_platinum_main_logo']){
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\" style=\"max-width:100px; max-height:50px;\"/>";
										}
									} else {
										$wr_logo = $this->get_logo($company_info);
										if($is_service['service_platinum_main_logo']){
											$logo = $this->logo_print( $wr_logo, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$wr_logo."\" title=\"".$list['company_name']." style=\"max-width:100px; max-height:50px;\"\"/>";
										}
									}
								}
							break;

							case 'main_prime':	 ## 메인 프라임
							case 'adult_prime':	 ## 19금 프라임

								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_prime_main_gold']) ? 'gold' : '';	// 골드 서비스

								$logo_path = $alice['data_alba_path'] . "/" . $list['etc_0'];

								// 업소 로고
								if($list['input_type']=='self'){	// 관리자 직접 입력
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_prime_main_logo']){
											//$logo = $this->logo_print( $logo_path."/".$list['etc_0'], $get_payment['pay_main_prime_logo_effect'], $list['company_name'] );
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\"/>";
										}
									} else {
										$result['wr_logo'] = "<img src=\"".$alice['images_path']."/basic/bg_noLogo.gif\"/>";
									}
								} else {
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_prime_main_logo']){
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_prime_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\" style=\"max-width:100px; max-height:50px;\"/>";
										}
									} else {
										$wr_logo = $this->get_logo($company_info);
										if($is_service['service_prime_main_logo']){
											$logo = $this->logo_print( $wr_logo, $get_payment['pay_main_prime_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$wr_logo."\" title=\"".$list['company_name']." style=\"max-width:100px; max-height:50px;\"\"/>";
										}
									}
								}

							break;

							case 'main_grand':	 ## 메인 그랜드
							case 'adult_grand':	 ## 19금 그랜드

								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_grand_main_gold']) ? 'gold' : '';	// 골드 서비스

								// 업소 로고
								$logo_path = $alice['data_alba_path'] . "/" . $list['etc_0'];

								// 업소 로고
								if($list['input_type']=='self'){	// 관리자 직접 입력									
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_grand_main_logo']){
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path ."\" title=\"".$list['company_name']."\"/>";
										}
									} else {
										$result['wr_logo'] = "<img src=\"".$alice['images_path']."/basic/bg_noLogo.gif\"/>";
									}
								} else {
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_grand_main_logo']){
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_grand_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\" style=\"max-width:100px; max-height:50px;\"/>";
										}
									} else {
										$wr_logo = $this->get_logo($company_info);
										if($is_service['service_grand_main_logo']){
											$logo = $this->logo_print( $wr_logo, $get_payment['pay_main_grand_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$wr_logo."\" title=\"".$list['company_name']." style=\"max-width:100px; max-height:50px;\"\"/>";
										}
									}
								}
							break;

							## 메인 배너형
							case 'main_banner':
								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_banner_main_gold']) ? 'gold' : '';	// 골드 서비스
							break;

							## 메인 리스트형
							case 'main_list':
								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_list_main_gold']) ? 'gold' : '';	// 골드 서비스
							break;

							## 서브 플래티넘
							case 'sub_platinum':
								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_platinum_sub_gold']) ? 'gold' : '';	// 골드 서비스
								
								// 업소 로고
								$logo_path = $alice['data_alba_path'] . "/" . $list['etc_0'];
								if($list['input_type']=='self'){	// 관리자 직접 입력
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_platinum_sub_logo']){
											//$logo = $this->logo_print( $logo_path."/".$list['etc_0'], $get_payment['pay_alba_platinum_logo_effect'], $list['company_name'] );
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\" style=\"max-width:100px; max-height:50px;\"/>";
										}
									} else {
										$result['wr_logo'] = "<img src=\"".$alice['images_path']."/basic/bg_noLogo.gif\"/>";
									}
								} else {
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_platinum_sub_logo']){
											$logo = $this->logo_print( $logo_path, $get_payment['pay_alba_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\" style=\"max-width:100px; max-height:50px;\"/>";
										}
									} else {
										$wr_logo = $this->get_logo($company_info);
										if($is_service['service_platinum_main_logo']){
											$logo = $this->logo_print( $wr_logo, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$wr_logo."\" title=\"".$list['company_name']." style=\"max-width:100px; max-height:50px;\"\"/>";
										}
									}
								}
							break;

							## 서브 배너형
							case 'sub_banner':
								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_banner_sub_gold']) ? 'gold' : '';	// 골드 서비스
							break;

							## 서브 리스트형
							case 'sub_list':
								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_list_sub_gold']) ? 'gold' : '';	// 골드 서비스
							break;

							## 일반 리스트 (서비스 없음, 공개 설정만 체크)
							default:

							break;

							## 19금 플래티넘
							case 'adult_platinum':

								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_platinum_main_gold'] || $is_service['service_platinum_sub_gold']) ? 'gold' : '';	// 골드 서비스
								
								// 업소 로고
								$logo_path = $alice['data_alba_path'] . "/" . $list['etc_0'];
								
								if($list['input_type']=='self'){	// 직접 입력
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_platinum_main_logo']){
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\" style=\"max-width:100px; max-height:50px;\"/>";
										}
									} else {
										$result['wr_logo'] = "<img src=\"".$alice['images_path']."/basic/bg_noLogo.gif\"/>";
									}
								} else { 
									if( file_exists($logo_path) && is_file($logo_path) ){
										if($is_service['service_platinum_main_logo']){
											$logo = $this->logo_print( $logo_path, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$logo_path."\" title=\"".$list['company_name']."\" style=\"max-width:100px; max-height:50px;\"/>";
										}
									} else {
										$wr_logo = $this->get_logo($company_info);
										if($is_service['service_platinum_main_logo']){
											$logo = $this->logo_print( $wr_logo, $get_payment['pay_main_platinum_logo_effect'], $list['company_name'] );
											$result['wr_logo'] = $logo;
										} else {
											$result['wr_logo'] = "<img alt=\"".$list['company_name']."\" src=\"".$wr_logo."\" title=\"".$list['company_name']." style=\"max-width:100px; max-height:50px;\"\"/>";
										}
									}
								}

							break;

							## 19금 배너형
							case 'adult_banner':

								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_banner_main_gold'] || $is_service['service_banner_sub_gold']) ? 'gold' : '';	// 골드 서비스

							break;

							## 19금 리스트형
							case 'adult_list':

								$is_service = $this->service_valid( $list );	// 서비스 정보
								$result['gold_service'] = ($is_service['service_list_main_gold'] || $is_service['service_list_sub_gold']) ? 'gold' : '';	// 골드 서비스

							break;

						}

						// 급구 아이콘
						$result['service_busy'] = "";
						if($is_service['service_busy']){
							$service_check = $service_control->service_check('alba_option_busy');
							$result['service_busy'] = "<img src=\"".$alice['data_icon_path'] . "/" . $service_check['busy_icon']."\" class=\"vm pr5\"/>";
						}

						// 강조 아이콘
						$result['service_icon'] = "";
						if($is_service['service_icon']){	
							$icon_sel = $category_control->get_category($get_payment['pay_alba_option_icon_sel']);
							$result['service_icon'] = "<img src=\"".$alice['data_icon_path'] . "/" . $icon_sel['name']."\" class=\"vm pr5\">";
						}

						$style_add = " style=\"";

						// 형광펜
						if($is_service['service_neon']){
							$style_add .= "background-color:#".$get_payment['pay_alba_option_neon_color'].";";
						}

						// 굵은글자
						if($is_service['service_bold']){
							$style_add .= "font-weight:bold;";
						}

						// 글자색
						if($is_service['service_color']){
							$style_add .= "color:#".$get_payment['pay_alba_option_color_sel'].";";
						}

						$style_add .= "\" ";

						// 반짝임
						$class = "";
						if($is_service['service_blink']){
							$class = "class=\"jumble\"";
						}
						
						//$result['company_name'] = stripslashes($company_info['mb_company_name']);	// 업소명
						$result['company_name'] = stripslashes($list['company_name']);

						$wr_subject = stripslashes($list['wr_subject']);
						$result['subject'] = "<span ".$style_add." ".$class.">" . $utility->str_cut($wr_subject,$subject_len) . "</span>";	// 공고 제목

						$get_alba = $alba_user_control->get_alba_no($no);	 // 채용정보 단수 추출

						$invalid_service = array( "main_platinum", "main_prime", "main_grand", "main_banner", "main_list", "sub_list" );

						if( !in_array($service, $invalid_service) ){

							// 지역
							$area_arr = array( "area_0" => $get_alba['wr_area_0'], "area_1" => $get_alba['wr_area_1'], "area_2" => $get_alba['wr_area_2'] );
							$result['job_area'] = $alba_user_control->list_area_info($area_arr);

							$wr_area_0 = explode('/',$get_alba['wr_area_0']);
							$wr_area_name = $category_control->get_categoryCodeName($wr_area_0[0]);
							$wr_area_name .= ($wr_area_0[1]) ? " > " . $category_control->get_categoryCodeName($wr_area_0[1]) : "";
							$result['job_area_1'] = $wr_area_name;

							$wr_area_name = $category_control->get_categoryCodeName($wr_area_0[0]);
							$wr_area_name .= ($wr_area_0[1]) ? " " . $category_control->get_categoryCodeName($wr_area_0[1]) : "";
							$result['job_area_2'] = $wr_area_name;

						}

						$volume_arr = array( "volume_date" => $list['wr_volume_date'], "volume_always" => $list['wr_volume_always'], "volume_end" => $list['wr_volume_end'] );
						$volume_date = $this->volume_date($volume_arr,true);
						$result['volume'] = $volume_date['text'];
						$result['volume_result'] = $volume_date['result'];

						$result['wr_pay_type'] = $category_control->get_categoryCodeName($list['wr_pay_type']);	// 급여조건
						$result['wr_pay'] = number_format($list['wr_pay']);

						$result['wr_pay_conference'] = $list['wr_pay_conference'];	// 협의가능
						$result['wr_area'] = $this->list_area($list['wr_area_0']);	// 2차 지역까지 출력
						$result['wr_area_cut'] =  $utility->str_cut($this->list_area($list['wr_area_0']),"16","");	// 2차 지역까지 출력(긴 경우 짜르기)

						// 직종
						$job_type_arr = array( "job_type0" => $get_alba['wr_job_type0'], "job_type1" => $get_alba['wr_job_type1'], "job_type2" => $get_alba['wr_job_type2'] );
						$result['job_type'] = $alba_user_control->list_type($job_type_arr);

						$result['wr_gender'] = $alba_user_control->gender_val[$list['wr_gender']];	 // 성별

						/*
						$result['wdate'] = $list['wr_wdate'];	 // 등록일
						$wdate1 = explode(" ",$list['wr_wdate']);	 // 등록일
						$result['wdate1'] = $wdate1[0];

						$result['datetime'] = substr($list['wr_wdate'],0,10);
						$result['datetime2'] = $list['wr_wdate'];
						$datetime2 = $result['datetime2'];
						if($result['datetime'] == date("Y-m-d", $alice['server_time']))
							$result['datetime2'] = substr($result['datetime2'],11,5);
						else
							$result['datetime2'] = substr($result['datetime2'],0,10);

						$result['datetime3'] = substr($datetime2,5,5);

						$result['last'] = substr($list['wr_udate'],0,10);
						$list['last2'] = $list['wr_udate'];

						if($result['last'] == date("Y-m-d", $alice['server_time']))
							$result['last2'] = substr($list['last2'],11,5);
						else
							$result['last2'] = substr($list['last2'],5,5);
						*/

						$result['wdate'] = $get_alba['wr_wdate'];	 // 등록일
						$wdate1 = explode(" ",$get_alba['wr_wdate']);	 // 등록일
						$result['wdate1'] = $wdate1[0];

						$result['datetime'] = substr($get_alba['wr_wdate'],0,10);
						$result['datetime2'] = $get_alba['wr_wdate'];
						if($result['datetime'] == date("Y-m-d", $alice['server_time'])) {
							$result['datetime2'] = substr($result['datetime2'],11,5);
							$result['datetime3'] = "<span class='b'>Today</span>";
						} else { 
							$result['datetime2'] = substr($result['datetime2'],0,10);
							$result['datetime3'] = substr($result['datetime2'],5,5);
						}

						$result['last'] = substr($get_alba['wr_udate'],0,10);
						$get_alba['last2'] = $get_alba['wr_udate'];

						if($result['last'] == date("Y-m-d", $alice['server_time']))
							$result['last2'] = substr($get_alba['last2'],11,5);
						else
							$result['last2'] = substr($get_alba['last2'],5,5);


						$result['is_delete'] = $list['is_delete'];


					return $result;

				}



				/**
				* 채용정보 리스트 출력 정보를 설정한다.
				* 일반 리스트 등에서 많이 사용한다.
				* no :: 공고 번호
				* logo_width,height :: 출력 로고 사이즈 조절
				* subject_len :: 글자 길이를 적용할 경우 리스트상 ... 을 적용한다.
				*/
				function get_alba_list( $no, $logo_width="106", $logo_height="42", $subject_len="" ){

					global $alice, $config, $utility, $ym;
					global $alba_user_control, $user_control, $category_control;

						$result = array();

						$get_alba = $alba_user_control->get_alba_no($no);	 // 채용정보 단수 추출
						$wr_id = $get_alba['wr_id'];

						$wr_subject = stripslashes($get_alba['wr_subject']);
						$result['subject'] = ($subject_len) ? $utility->str_cut($wr_subject,$subject_len) : $wr_subject;

						// 직종
						$job_type_arr = array( "job_type0" => $get_alba['wr_job_type0'], "job_type1" => $get_alba['wr_job_type1'], "job_type2" => $get_alba['wr_job_type2'] );
						$result['job_type'] = $alba_user_control->list_type($job_type_arr);

						// 역세권
						$subway_arr = array( 
							"subway_area_0" => array( "subway_area" => $get_alba['wr_subway_area_0'], "subway_line" => $get_alba['wr_subway_line_0'], "subway_station" => $get_alba['wr_subway_station_0'], "subway_content" => $get_alba['wr_subway_content_0'] ),
							"subway_area_1" => array( "subway_area" => $get_alba['wr_subway_area_1'], "subway_line" => $get_alba['wr_subway_line_1'], "subway_station" => $get_alba['wr_subway_station_1'], "subway_content" => $get_alba['wr_subway_content_1'] ),
							"subway_area_2" => array( "subway_area" => $get_alba['wr_subway_area_2'], "subway_line" => $get_alba['wr_subway_line_2'], "subway_station" => $get_alba['wr_subway_station_2'], "subway_content" => $get_alba['wr_subway_content_2'] )
						);
						
						$result['job_subway'] = $alba_user_control->list_subway($subway_arr);

						// 지역
						$area_arr = array( "area_0" => $get_alba['wr_area_0'], "area_1" => $get_alba['wr_area_1'], "area_2" => $get_alba['wr_area_2'] );
						$result['job_area'] = $alba_user_control->list_area_info($area_arr);

						$wr_area_0 = explode('/',$get_alba['wr_area_0']);
						$wr_area_name = $category_control->get_categoryCodeName($wr_area_0[0]);
						$wr_area_name .= ($wr_area_0[1]) ? " > " . $category_control->get_categoryCodeName($wr_area_0[1]) : "";
						$result['job_area_1'] = $wr_area_name;

						$wr_area_name = $category_control->get_categoryCodeName($wr_area_0[0]);
						$wr_area_name .= ($wr_area_0[1]) ? " " . $category_control->get_categoryCodeName($wr_area_0[1]) : "";
						$result['job_area_2'] = $wr_area_name;

						$result['wr_date'] = $category_control->get_categoryCodeName($get_alba['wr_date']);		// 근무날짜
						$result['wr_week'] = $category_control->get_categoryCodeName($get_alba['wr_week']);	// 근무주일

						// 근무시간
						$result['wr_stime'] = $get_alba['wr_stime'];
						$result['wr_etime'] = $get_alba['wr_etime'];
						$result['time_conference'] = $get_alba['wr_time_conference'];
						$result['wr_time'] = ($result['time_conference']) ? "시간협의" : $result['wr_stime'] . " ~ " . $result['wr_etime'];
						$result['welfare_read'] = stripslashes($get_alba['wr_welfare_read']);

						// 모집일
						$volume_arr = array( "volume_date" => $get_alba['wr_volume_date'], "volume_always" => $get_alba['wr_volume_always'], "volume_end" => $get_alba['wr_volume_end'] );
						$result['volume_date'] = $alba_user_control->volume_date($volume_arr);

						$result['wr_pay_type'] = $category_control->get_categoryCodeName($get_alba['wr_pay_type']);	// 급여조건
						$result['wr_pay'] = number_format($get_alba['wr_pay']);

						$result['pay_conference'] = $get_alba['wr_pay_conference'];	// 협의가능
						$result['wr_gender'] = $alba_user_control->gender_val[$get_alba['wr_gender']];	 // 성별

						// 연령
						$age_arr = array( "age_limit" => $get_alba['wr_age_limit'], "age" => $get_alba['wr_age'], "age_etc" => $get_alba['wr_age_etc'] );
						$result['age'] = $alba_user_control->list_age($age_arr);

						// 모집인원
						$volume_arr = array( "volume" => $get_alba['wr_volume'], "volumes" => $get_alba['wr_volumes'] );
						$result['volmue'] = $alba_user_control->list_volume($volume_arr);

						// 등록 업소회원 정보
						$result['company_info'] = $user_control->get_member_company($wr_id);
						$result['company_name'] = stripslashes($get_alba['wr_company_name']);
						$company_info = $result['company_info'];
						$result['company_year'] = date('Y') - $company_info['mb_biz_foundation'];
						$result['biz_form_option'] = $category_control->get_categoryCodeName($company_info['mb_biz_form']);	// 업소형태

						// 모집 형태
						$result['wr_requisition'] = $get_alba['wr_requisition'];
						$wr_requisition = explode(',',$result['wr_requisition']);
						$result['is_online'] = false;
						if(in_array('online',$wr_requisition) || in_array('email',$wr_requisition)){	// 온라인, 이메일 의 경우 온라인 입사지원 가능
							$result['is_online'] = true;
							$result['requisitions'] = $wr_requisition;
						}

						// 업소 로고
						if($get_alba['input_type']=='self'){	// 관리자 직접 입력
							$logo_path = $alice['data_alba_path'];
							if(file_exists($logo_path."/".$get_alba['etc_0'])){
								$result['wr_logo'] = "<img alt=\"".$get_alba['company_name']."\" src=\"".$logo_path . "/". $get_alba['etc_0']."\" title=\"".$get_alba['company_name']."\" width=\"".$logo_width."\" height=\"".$logo_height."\"/>";
							} else {
								$result['wr_logo'] = "<img src=\"".$alice['images_path']."/basic/bg_noLogo.gif\" width=\"".$logo_width."\" height=\"".$logo_height."\"/>";
							}
						} else {
							$wr_logo = $company_info['mb_logo'];
							if($wr_logo){
								$logo_path = $alice['data_member_path'] . '/' . $wr_id . '/logo';
								$result['wr_logo'] = "<img alt=\"".$get_alba['company_name']."\" src=\"".$logo_path . "/". $company_info['mb_logo']."\" title=\"".$get_alba['company_name']."\" width=\"".$logo_width."\" height=\"".$logo_height."\"/>";
							} else {
								$result['wr_logo'] = "<img src=\"".$alice['images_path']."/basic/bg_noLogo.gif\" width=\"".$logo_width."\" height=\"".$logo_height."\"/>";
							}
						}

						$result['wdate'] = $get_alba['wr_wdate'];	 // 등록일
						$wdate1 = explode(" ",$get_alba['wr_wdate']);	 // 등록일
						$result['wdate1'] = $wdate1[0];

						$result['datetime'] = substr($get_alba['wr_wdate'],0,10);
						$result['datetime2'] = $get_alba['wr_wdate'];
						/*
						if($result['datetime'] == date("Y-m-d", $alice['server_time']))
							$result['datetime2'] = substr($result['datetime2'],11,5);
						else
							$result['datetime2'] = substr($result['datetime2'],0,10);

						$result['datetime3'] = substr($result['datetime2'],5,5);
						*/

						if($result['datetime'] == date("Y-m-d", $alice['server_time'])) {
							$result['datetime2'] = substr($result['datetime2'],11,5);
							$result['datetime3'] = "<span class='b'>Today</span>";
						} else { 
							$result['datetime2'] = substr($result['datetime2'],0,10);
							$result['datetime3'] = substr($result['datetime2'],5,5);
						}

						$result['last'] = substr($get_alba['wr_udate'],0,10);
						$get_alba['last2'] = $get_alba['wr_udate'];

						if($result['last'] == date("Y-m-d", $alice['server_time']))
							$result['last2'] = substr($get_alba['last2'],11,5);
						else
							$result['last2'] = substr($get_alba['last2'],5,5);


					return $result;

				}



				// 공고별 로고 출력
				function logo_print( $logo_file, $print_type, $company_name="", $is_mobile=false ){

						switch($print_type){
							case '0':
								if( $is_mobile ){
									$result = "<img src=\"".$logo_file."\" class=\"vm fade_image\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:114px;max-height:57px;\"/>";
								} else {
									$result = "<img src=\"".$logo_file."\" class=\"vm fade_image\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:100px;max-height:50px;\"/>";
								}
							break;
							case '1':
								if( $is_mobile ){
									$result = "<img src=\"".$logo_file."\" class=\"vm blink_image\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:114px;max-height:57px;\"/>";
								} else {
									$result = "<img src=\"".$logo_file."\" class=\"vm blink_image\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:100px;max-height:50px;\"/>";
								}
							break;
							case '2':
								if( $is_mobile ){
									$result = "<div class=\"slide_image\" style=\"position:relative; width:114px; height: 66px; overflow: hidden; display: inline-block;\">";
									$result .= "<img src=\"".$logo_file."\" title=\"".$company_name."\" alt=\"".$company_name."\"/>";
									$result .= "<img src=\"".$logo_file."\" title=\"".$company_name."\" alt=\"".$company_name."\"/>";
									$result .= "</div>";
								} else {
									//$result  = "<div style=\"float:right;margin-left:5px;\" class=\"slide_image\">";
									$result = "<div class=\"slide_image\" style=\"position:relative; width:100px; height: 50px; overflow: hidden; display: inline-block;\">";
									$result .= "<img src=\"".$logo_file."\" title=\"".$company_name."\" alt=\"".$company_name."\"/>";
									$result .= "<img src=\"".$logo_file."\" title=\"".$company_name."\" alt=\"".$company_name."\"/>";
									$result .= "</div>";
								}
							break;
							default:
								if( $is_mobile ){
									$result = "<img src=\"".$logo_file."\" class=\"vm\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:114px;max-height:57px;\"/>";
								} else {
									$result = "<img src=\"".$logo_file."\" class=\"vm\" title=\"".$company_name."\" alt=\"".$company_name."\" style=\"max-width:100px;max-height:50px;\"/>";
								}
							break;
						}


					return $result;

				}


				// 카테고리 기준 카운팅
				function get_category_count( $code, $search_field, $adult_chk = '' ){

					global $service_control;

						$alba_basic_check = $service_control->service_check('alba_basic');	// 채용공고 일반 리스트 사용시

						$query = " select * from `".$this->alba_table."` ";

						if( $search_field == 'wr_job_type0' ){
							$query .= " where ( `wr_job_type0` = '".$code."' or `wr_job_type3` = '".$code."' or `wr_job_type6` = '".$code."' ) ";
						} else {
							$query .= " where `".$search_field."` = '".$code."' ";
						}

						$adult_que = ($adult_chk=='adult') ? " and `wr_is_adult` = 1 " : " and `wr_is_adult` = 0 ";  

						$query .= " and `wr_open` = 1 and `wr_report` = 0 and `is_delete` = 0 ". $adult_que; 

						if($alba_basic_check['is_pay']){
							
							$query .= " and ( `wr_service_platinum` >= curdate() or `wr_service_platinum_sub` >= curdate() or `wr_service_prime` >= curdate() or `wr_service_grand` >= curdate() or `wr_service_banner` >= curdate() or `wr_service_banner_sub` >= curdate() or `wr_service_list` >= curdate() or `wr_service_list_sub` >= curdate() or `wr_service_basic` >= curdate() or `wr_service_basic_sub` >= curdate() or `wr_service_busy` >= curdate() ) ";

						}

						//echo $query."<br/><br/>";

						$result = $this->_queryR($query);


					return $result;

				}

				// 카테고리 지역 카운팅
				function get_category_count_area( $code ){

					global $service_control;

						$alba_basic_check = $service_control->service_check('alba_basic');	// 채용공고 일반 리스트 사용시

						$query = " select `wr_area_0`, `wr_area_1`, `wr_area_2` from `".$this->alba_table."` where ( INSTR(`wr_area_0`, '".$code."') or INSTR(`wr_area_1`, '".$code."') or INSTR(`wr_area_2`, '".$code."') ) and `is_delete` = 0 ";

						if($alba_basic_check['is_pay']){
							
							//$query .= " and ( `wr_service_basic` >= curdate() ) ";
							$query .= " and ( `wr_service_platinum` >= curdate() or `wr_service_platinum_sub` >= curdate() or `wr_service_prime` >= curdate() or `wr_service_grand` >= curdate() or `wr_service_banner` >= curdate() or `wr_service_banner_sub` >= curdate() or `wr_service_list` >= curdate() or `wr_service_list_sub` >= curdate() or `wr_service_basic` >= curdate() or `wr_service_basic_sub` >= curdate() or `wr_service_busy` >= curdate() ) ";

						}

						//echo $query."<br/><br/>";

						$result = $this->_queryR($query);

						
						/*
						$area_0_query = " select `wr_area_0` from `".$this->alba_table."` where  INSTR(`wr_area_0`, '".$code."') ";	// , `wr_area_0_point`
						$area_0_data = $this->query_fetch_rows($area_0_query);

						foreach($area_0_data as $key => $val){
							if(stristr($val['wr_area_0'],$code)){
								$result++;
							}
						}

						$area_1_query = " select `wr_area_1` from `".$this->alba_table."` where  INSTR(`wr_area_1`, '".$code."') ";	// , `wr_area_1_point`
						$area_1_data = $this->query_fetch_rows($area_1_query);

						foreach($area_1_data as $key => $val){
							if(stristr($val['wr_area_1'],$code)){
								$result++;
							}
						}

						$area_2_query = " select `wr_area_2` from `".$this->alba_table."` where  INSTR(`wr_area_2`, '".$code."') ";	// , `wr_area_2_point`
						$area_2_data = $this->query_fetch_rows($area_2_query);

						foreach($area_2_data as $key => $val){
							if(stristr($val['wr_area_2'],$code)){
								$result++;
							}
						}
						*/


					return $result;

				}

				// 카테고리 역세권 카운팅
				function get_category_count_subway( $area="", $line="", $station="" ){

					global $service_control;

						$alba_basic_check = $service_control->service_check('alba_basic');	// 채용공고 일반 리스트 사용시

						$query  = " select `no`, `wr_subway_area_0`, `wr_subway_line_0`, `wr_subway_station_0`, `wr_subway_area_1`, `wr_subway_line_1`, `wr_subway_station_1`, `wr_subway_area_2`, `wr_subway_line_2`, `wr_subway_station_2` from `".$this->alba_table."` ";


						if($area!="") 
							$query .= " where (`wr_subway_area_0` = '".$area."' or `wr_subway_area_1` = '".$area."' or `wr_subway_area_2` = '".$area."' ) ";

						if($line!="") 
							$query .= " and (`wr_subway_line_0` = '".$line."' or `wr_subway_line_1` = '".$line."' or `wr_subway_line_2` = '".$line."' ) ";

						if($station!="") 
							$query .= " and (`wr_subway_station_0` = '".$station."' or `wr_subway_station_1` = '".$station."' or `wr_subway_station_2` = '".$station."' ) ";


						if($alba_basic_check['is_pay']){
							
							$query .= " and ( `wr_service_basic` >= curdate() ) ";

						}

						//echo $query." <==<Br/>";

						$result = $this->_queryR($query);


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

				// 스크랩 데이터 리스팅
				function scrap_list( $mb_id, $page="", $page_rows="" ){

					global $alice;
					global $member_control;

						if(!$mb_id || $mb_id=="") return false;

						$result = array();
						
						$query = " select * from `".$this->scrap_table."` where `mb_id` = '".$mb_id."' ";

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
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// 채용공고 점핑
				function alba_jumping( $set_time=12 ){

					global $alice, $now_date;


						//echo $set_time." @ ".$alice['time_ymdhis']." @ ".$now_date." <==<Br/>";
						
						//$now_date = "2014-03-20 00:00:00";

						$half_hour = date('H:i');

						/*
						echo $half_hour % $set_time;
						if(){
						}
						*/



						/*
						$rtime = date('Y-m-d H:i:s', strtotime("-2 hours -51 minutes -24 seconds"));
						$xtime = date('Y-m-d H:i:s', strtotime("+1 hours 12 minutes 35 seconds"));

						 $yy = substr($end_date, 0, 4);
						 $mm = substr($end_date, 5, 2);
						 $dd = substr($end_date, 8, 2);
						 $hh = substr($end_date, 11, 2);
						 $ii = substr($end_date, 14, 2);
						 $ss = substr($end_date, 17, 2);
						*/

						//echo $half_hour." <==<Br/>";


						$service_result = $this->query_fetch_rows(" select * from `".$this->alba_table."` where `wr_service_jump` >= curdate() ");

						//echo "<xmp>";
						foreach($service_result as $val){

							//echo $val['wr_jdate']." <==<br/>";

							//$rtime = date('H', strtotime("-".$set_time." hours"));

							//echo $rtime." <==\n\n";

							//print_R($val);

						}
						//echo "</xmp>";

						
				}


				/**
				* 업소정보별 사용중인 로고 추출
				* 인자 :: 업소정보
				*/
				function get_logo( $company="", $alba="" ){

					global $alice;
					global $logo_control;

						if($company){

							if($company['mb_logo_sel']){
								
								$logo = $logo_control->getEmployLogo($company['mb_logo_sel']);
								$company_logo_file = $alice['data_logo_path']."/".$logo['wr_content'];
								$result = (is_file($company_logo_file)) ? $company_logo_file : ($result ? $result : "../images/basic/bg_noLogo.gif");	 // 업소회원 로고 사진

							} else {

								$company_logo_file = "/data/member/".$company['mb_id']."/logo/".$company['mb_logo'];
								$result = (is_file(NFE_PATH.$company_logo_file)) ? NFE_URL.$company_logo_file : ($result ? $result : "../images/basic/bg_noLogo.gif");	 // 업소회원 로고 사진

							}

						} else {

							if( is_file($alice['data_alba_path']."/".$alba['etc_0']) ){
								$result = $alice['data_alba_path']."/".$alba['etc_0'];
							} else {
								if(!$result) $result = "../images/basic/bg_noLogo.gif";
							}

						}

						if($alba['etc_0']) $result = NFE_URL."/data/alba/" . $alba['etc_0'];


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

				// 정규직 공고 추출 (단수) :: wr_id 기준
				function get_alba_desire( $wr_id, $con="" ){

						if(!$wr_id || $wr_id=='') return false;

						$query = " select SUM(wr_desire) as desire from `".$this->alba_table."` where `wr_id` = '".$wr_id."' " . $con;

						$result = $this->query_fetch($query);


					return $result;
				}

		}	// class end.
?>