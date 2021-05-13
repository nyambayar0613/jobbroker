<?php
		/**
		* /application/nad/mobile/model/alice_mobile_control.class.php
		* @author Harimao
		* @since 2013/12/16
		* @last update 2014/03/28
		* @Module v3.5 ( Alice )
		* @Brief :: Mobile Model class
		* @Comment :: 모바일 모델 클래스
		*/
		class alice_mobile_model extends DBConnection {

			var $mobile_table	 = "alice_mobile";

			var $alba_table = "alice_alba";
			var $alba_resume_table = "alice_alba_resume";

			
			var $success_code = array(
					'0000' => '모바일웹 설정이 완료 되었습니다.',
			);

			var $fail_code = array(
					'0000' => '모바일웹 설정중 오류가 발생하였습니다.',
			);

			var $requisition_code = array( 'phone' => '전화후방문', 'meet' => '방문접수', 'post' => '우편', 'fax' => '팩스', 'homepage' => '홈페이지', 'online' => '온라인', 'email' => '이메일' );


				// 모바일 설정 정보 추출
				function get_mobile_info( $no="" ){

					global $alice;

						$query = " select * from `".$this->mobile_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

						$wr_logo = $result['wr_logo'];

						$result['wr_logo'] = $alice['data_logo_path'] . "/" . $wr_logo;

					
					return $result;

				}

				// 정규직 리스팅
				function alba_listing( $page="", $page_rows="", $con="", $total_count=4 ){

						$query = " select * from `".$this->alba_table."` " . $con . " order by `wr_wdate` desc ";

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

				// 이력서 리스팅
				function alba_resume_listing( $page="", $page_rows="", $con="", $total_count=4 ){

						$query = " select * from `".$this->alba_resume_table."` " . $con . " order by `wr_wdate` desc ";

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


				// 리스팅
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

						//echo $query."<br/><br/>";

						//echo "<p><br/><strong>Query :: " . $query."</strong><br/><br/></p>";	// 쿼리 확인

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}

				// 이력서 리스팅
				function resume_listing( $page="", $page_rows="", $con="", $total_count=4 ){

						$query = " select * from `".$this->alba_resume_table."` " . $con . " order by `wr_wdate` desc ";

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


				// 리스팅
				function __AlbaResumeList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_ResumeSearch( );

						$query = " select * from `".$this->alba_resume_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						//echo $query."<br/><Br/>";

						//echo "<p><br/><strong>Query :: " . $query."</strong><br/><br/></p>";	// 쿼리 확인

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL :: 사용자측
				function get_paging($write_pages, $cur_page, $total_page, $url, $add="") {

						$str = "";
						if ($cur_page > 1) {
							$str .= "<a href='" . $url . "1" . $add . "' class='prev'><img src=\"../images/btn/btn_leftArrow2.png\" class=\"bg_color1\"><img src=\"../images/btn/btn_leftArrow2.png\" class=\"bg_color1\"></a>\n";
							//$str .= "[<a href='" . $url . ($cur_page-1) . "'>이전</a>]";
						}

						$start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
						$end_page = $start_page + $write_pages - 1;

						if ($end_page >= $total_page) $end_page = $total_page;

						if ($start_page > 1) $str .= "<a href='" . $url . ($start_page-1) . $add . "' class='prev'>이전</a>\n";

						if ($total_page > 1) {
							for ($k=$start_page;$k<=$end_page;$k++) {
								if ($cur_page != $k)
									$str .= "<a href='" . $url . $k . $add . "' class='page text_color1'>" . $k . "</a>\n";
								else 
									$str .= "<a href='" . $url . $k . $add . "' class='page bg_color1 on'>" . $k . "</a>\n";
							}
						}

						if ($total_page > $end_page) $str .= "<a href='" . $url . ($end_page+1) . $add . "' class='next'>다음</a>\n";

						if ($cur_page < $total_page) {
							$str .= "<a href='" . $url . $total_page . $add . "' class='next text_color1'><img src=\"../images/btn/btn_rightArrow2.png\" class=\"bg_color1\"><img src=\"../images/btn/btn_rightArrow2.png\" class=\"bg_color1\"></a>";
						}

						$str .= "";


					return $str;

				}

				// 현재페이지, 총페이지수, 한페이지에 보여줄 행 ajax
				function get_ajax_paging($write_pages, $cur_page, $total_page, $list="") {

						$str = "";
						if ($cur_page > 1) {
							$str .= "<a href='javascript:ajax_paging(1,\"".$list."\");' class='prev' onfocus='blur();'>처음</a>\n";
						}

						$start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
						$end_page = $start_page + $write_pages - 1;

						if ($end_page >= $total_page) $end_page = $total_page;

						if ($start_page > 1) $str .= "<a href='javascript:ajax_paging(".($start_page-1).",\"".$list."\");' class='prev' onfocus='blur();'>이전</a>\n";

						if ($total_page > 1) {
							for ($k=$start_page;$k<=$end_page;$k++) {
								if ($cur_page != $k)
									$str .= "<a href='javascript:ajax_paging(".$k.",\"".$list."\");' class='page ".$list."_page text_color1' onfocus='blur();' id='page_".$list."_".$k."'>" . $k . "</a>\n";
								else 
									$str .= "<a href='javascript:ajax_paging(".$k.",\"".$list."\");' class='page ".$list."_page bg_color1 on' onfocus='blur();' id='page_".$list."_".$k."'>" . $k . "</a>\n";
							}
						}

						if ($total_page > $end_page) $str .= "<a href='javascript:ajax_paging(".($start_page+1).",\"".$list."\");' class='next' onfocus='blur();'>다음</a>\n";

						if ($cur_page < $total_page) {
							$str .= "<a href='javascript:ajax_paging(".$total_page.",\"".$list."\");' class='next text_color1' onfocus='blur();' id='last_".$list."'>맨끝</a>";
						}

						$str .= "";


					return $str;

				}


				// 정규직 검색
				function _Search( ){

					global $utility, $config;
					global $category_control;

						$mode = $_GET['mode'];

						$type = $_GET['type'];
						
						$search_mode = $_GET['search_mode'];	// 검색 페이지별 모드

						$page = $_GET['page'];

						$page_rows = $_GET['page_rows'];

						$order = " `wr_wdate` desc ";

						$category_top_val = explode(",",$_GET['category_top_val']);
						$category_top_val_cnt = count($category_top_val);


						$que = array();
						$url = array();

						if($type) array_push($url,"type=".$type);
						if($search_mode) array_push($url,"search_mode=".$search_mode);

						$search_keyword = urldecode( trim($_GET['search_keyword']) );	 // 검색 키워드


						$code = $_GET['code'];
						$code1 = $_GET['code1'];
						$search_code = ($code) ? "&code=".$code : "";
						$search_code = ($code1) ? "&code=".$code1 : $search_code;

						if($mode=='search'  || $mode=='mobile_search' || $code || $code1){

							array_push( $url, "mode=" . $mode );	 // 검색 모드
							
							if($search_mode=='alba_local'){
								$third_area = $category_control->get_categoryCode($code);
								$second_area = $category_control->get_categoryCode($third_area['p_code']);
								$first_area = $category_control->get_categoryCode($second_area['p_code']);
							}

							$first_code = ($first_area['code']) ? $first_area['code'] : $wr_area_0[0];
							$second_code = ($second_area['code']) ? $second_area['code'] : $wr_area_0[1];
							$third_code = ($code) ? $code : $wr_area_0[2];

							$wr_area_code = array();
							array_push($wr_area_code,$first_code);
							array_push($wr_area_code,$second_code);
							array_push($wr_area_code,$third_code);

							$wr_area_0 = ($_GET['wr_area_0']) ? $_GET['wr_area_0'] : $wr_area_code;	// 지역

							if($wr_area_0[0]){
								$wr_area_0_cnt = count($wr_area_0);
								$area_field = "";
								for($i=0;$i<$wr_area_0_cnt;$i++){
									$_slash = ($wr_area_0_cnt != ($i+1) && $wr_area_0[$i] != "") ? "/" : "";
									$area_field .= (strstr($wr_area_0[$i], "_all")) ? "" : $wr_area_0[$i] . $_slash;
									array_push($url, "wr_area_0[]=" . $wr_area_0[$i]);
								}
								$area_que  = " INSTR( `wr_area_0`, '".$area_field."' ) ";
								
							array_push( $que, $area_que );
							}

							if($search_mode=='alba_part'){
								if($code1){
									$second_type = $category_control->get_categoryCode($code1);
								}else{
									$third_type = $category_control->get_categoryCode($code);
									$second_type = $category_control->get_categoryCode($third_type['p_code']);
								}
								$first_type = $category_control->get_categoryCode($second_type['p_code']);
							}

							$wr_job_type0 = ($first_type['code']) ? $first_type['code'] : $_GET['wr_job_type0'];	 // 1차 직종
							$wr_job_type1 = ($second_type['code']) ? $second_type['code'] : $_GET['wr_job_type1'];	 // 2차 직종
							$wr_job_type2 = ($third_type['code']) ? $third_type['code'] : $_GET['wr_job_type2'];	 // 3차 직종

							if($wr_job_type0){                              
								

								$job_type_que  = " ( ";
								
								$job_type_que .= " ( `wr_job_type0` = '".$wr_job_type0."' or `wr_job_type3` = '".$wr_job_type0."' or `wr_job_type6` = '".$wr_job_type0."' ) ";
								array_push( $url, "wr_job_type0=" . $wr_job_type0 . $search_code );

								if($wr_job_type1){
									$job_type_que .= " and ( `wr_job_type1` = '".$wr_job_type1."' or `wr_job_type4` = '".$wr_job_type1."' or `wr_job_type7` = '".$wr_job_type1."' ) ";
									array_push( $url, "wr_job_type1=" . $wr_job_type1 );
								}
								if($wr_job_type2){
									$job_type_que .= " and ( `wr_job_type2` = '".$wr_job_type2."' or`wr_job_type5` = '".$wr_job_type2."' or`wr_job_type8` = '".$wr_job_type2."' ) ";
									array_push( $url, "wr_job_type2=" . $wr_job_type2 );
								}
								$job_type_que .= " ) ";
								array_push( $que, $job_type_que );
							}

							if($search_mode=='alba_subway'){
								$third_subway = $category_control->get_categoryCode($code);
								$second_subway = $category_control->get_categoryCode($third_subway['p_code']);
								$first_subway = $category_control->get_categoryCode($second_subway['p_code']);
							}

							$wr_subway_0 = ($first_subway['code']) ? $first_subway['code'] : $_GET['wr_subway_0'];	 // 지하철 지역
							$wr_subway_1 = ($second_subway['code']) ? $second_subway['code'] : $_GET['wr_subway_1'];	 // 지하철 호선
							$wr_subway_2 = ($third_subway['code']) ? $third_subway['code'] : $_GET['wr_subway_2'];	 // 지하철 역명

							if($wr_subway_0){
								$subway_que  = " ( ";
								$subway_que .= " ( `wr_subway_area_0` = '".$wr_subway_0."'  or `wr_subway_area_1` = '".$wr_subway_0."' or `wr_subway_area_2` = '".$wr_subway_0."' ) ";
								array_push($url, "wr_subway_0=" . $wr_subway_0.$search_code);

								if($wr_subway_1){
									$subway_que .= " and ( `wr_subway_line_0` = '".$wr_subway_1."'  or `wr_subway_line_1` = '".$wr_subway_1."' or `wr_subway_line_2` = '".$wr_subway_1."' ) ";
									array_push($url, "wr_subway_1=" . $wr_subway_1);
								}

								if($wr_subway_2){
									$subway_que .= " and ( `wr_subway_station_0` = '".$wr_subway_2."'  or `wr_subway_station_1` = '".$wr_subway_2."' or `wr_subway_station_2` = '".$wr_subway_2."' ) ";
									array_push($url, "wr_subway_1=" . $wr_subway_1);
								}

								$subway_que .= " ) ";

							array_push( $que, $subway_que );
							}

							if($search_mode=='alba_college'){
								$second_college = $category_control->get_categoryCode($code);
								$first_college = $category_control->get_categoryCode($second_college['p_code']);
							}

							$wr_college_area = ($first_college['code']) ? $first_college['code'] : $_GET['wr_college_area'];			// 대학가 지역
							$wr_college_vicinity = ($second_college['code']) ? $second_college['code'] : $_GET['wr_college_vicinity'];	// 대학명
							if($wr_college_area){
								$college_que = " ( ";
								$college_que .= " `wr_college_area` = '".$wr_college_area."'";
								array_push( $url, "wr_college_area=" . $wr_college_area );
								if($wr_college_vicinity){
									$college_que .= " and `wr_college_vicinity` in ('".$wr_college_vicinity."') ";
									array_push( $url, "wr_college_vicinity=" . $wr_college_vicinity );
								}
								$college_que .= " ) ";

							array_push( $que, $college_que);
							}

							if($search_mode=='alba_term'){
								$wr_date = ($code) ? $code : $_GET['wr_date'];
							}

							if($wr_date){
								array_push( $que, " `wr_date` = '".$wr_date."' " );
								array_push( $url, "wr_date=" . $wr_date );
							}


							if($search_mode=='alba_pay'){
								$second_pay = $category_control->get_categoryCode($code);
								$first_pay = $category_control->get_categoryCode($second_pay['p_code']);
							}

							$wr_pay_type = ($second_pay['code']) ? $second_pay['code'] : $_GET['wr_pay_type'];
							$wr_pay = ($first_pay['code']) ? $first_pay['code'] : $_GET['wr_pay'];

							if($wr_pay_type){
								$pay_que  = " ( `wr_pay_type` = '".$wr_pay_type."' ";

								if($wr_pay){

									array_push( $url, "wr_pay=" . $wr_pay );

									$wr_pay = $category_control->get_categoryCode($wr_pay_type);
									$wr_pay_name = $wr_pay['name'];
									$wr_pay_level = $wr_pay['etc_0'];

									if(stristr($wr_pay_name,'~')){	 // 10000 ~ 20000

										$pay = explode('~',$wr_pay_name);
										$pay_que .= " and `wr_pay` between ".$pay[0]." and " . $pay[1];
										
									} else {	 // 10000
										
										switch($wr_pay_level){
											case 'under':	// 미만
												$pay_que .= " and `wr_pay` < " . $wr_pay_name;
											break;
											case 'exceed':	// 초과
												$pay_que .= " and `wr_pay` > " . $wr_pay_name;
											break;
											case 'high':	// 이상
												$pay_que .= " and `wr_pay` >= " . $wr_pay_name;
											break;
											case 'low':	// 이하
												$pay_que .= " and `wr_pay` <= " . $wr_pay_name;
											break;
										}

									}

								}

								$pay_que .= " ) ";

							array_push( $que, $pay_que );
							array_push( $url, "wr_pay_type=" . $wr_pay_type );
							}


							if($search_mode=='alba_target'){
								$alba_target = ($code) ? $code : $_GET['alba_target'];
							}

							if($alba_target){
								array_push( $que, " INSTR(`wr_target`, '".$alba_target."') " );
								array_push( $url, "alba_target=" . $alba_target );
							}


							$wr_career = $_GET['wr_career'];	// 경력
							$wr_career_type = $_GET['wr_career_type'];	// 경력 조건
							if($wr_career_type || $wr_career_type == '0'){	// 경력 조건이 있다면
								array_push( $que, " `wr_career_type` = '".$wr_career_type."' " );
								array_push( $url, "wr_career_type=" . $wr_career_type );
							} else {	 // 경력 조건이 없으면 선택 경력으로
								if($wr_career){
									array_push( $que, " `wr_career` = '".$wr_career."' " );
									array_push( $url, "wr_career=" . $wr_career );
								}
							}

							$wr_ability = $_GET['wr_ability'];	// 학력
							if($wr_ability){
								array_push( $que, " `wr_ability` = '".$wr_ability."' " );
								array_push($url, "wr_ability=".$wr_ability);
							}

							$wr_age = $_GET['wr_age'];	// 나이
							$wr_age_low = $_GET['wr_age_low'];	// 나이 이하
							$wr_age_high = $_GET['wr_age_high'];	// 나이 이상
							$wr_age_limit = $_GET['wr_age_limit'];	// 나이 무관 포함
							if($wr_age){
								$division = ($wr_age_low) ? "<=" : ">=";
								$age_que = "(";
								$age_que .= " substring( `wr_age`,1 ,2 ) ".$division." ".$wr_age." ";
								array_push($url, "wr_age=".$wr_age);
								if($wr_age_limit){
									$age_que .= " or `wr_age_limit` = '0' ";
									array_push($url, "wr_age_limit=".$wr_age_limit);
								}
								$age_que .= ")";
								array_push( $que, $age_que );
							}

							$wr_gender = $_GET['wr_gender'];	// 성별
							if($wr_gender){	//  || $wr_gender=='0'
								array_push( $que, " ( `wr_gender` = '".$wr_gender."' ) " );
								array_push($url, "wr_gender=".$wr_gender);
							}

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

						/*
						echo "<pre>";
						print_R($que);
						echo "</pre>";
						*/

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


				// 이력서 검색
				function _ResumeSearch(){

					global $utility, $config;
					global $category_control;


						$mode = $_GET['mode'];

						$type = $_GET['type'];
						
						$search_mode = $_GET['search_mode'];	// 검색 페이지별 모드

						$page = $_GET['page'];

						$page_rows = $_GET['page_rows'];


						$order = " `wr_wdate` desc ";

						$category_top_val = explode(",",$_GET['category_top_val']);
						$category_top_val_cnt = count($category_top_val);


						$que = array();
						$url = array();

						if($type) array_push($url,"type=".$type);
						if($search_mode) array_push($url,"search_mode=".$search_mode);

						$search_keyword = urldecode( trim($_GET['search_keyword']) );	 // 검색 키워드


						$code = $_GET['code'];
						$code1 = $_GET['code1'];

						if($mode=='search' || $mode=='mobile_search' || $code){
						
							$wr_area0 = $_GET['wr_area0'];
							$wr_area1 = $_GET['wr_area1'];

							if($search_mode=='alba_resume_local'){
								$second_area = $category_control->get_categoryCode($code);
								$first_area = $category_control->get_categoryCode($second_area['p_code']);
							}

							$wr_area0 = ($first_area['code']) ? $first_area['code'] : $wr_area0;
							$wr_area1 = ($second_area['code']) ? $second_area['code'] : $wr_area1;

							if($wr_area0){
								array_push( $url, "wr_area0=" . $wr_area0 );
								$area_que = " ( ";
									$area_que .= " `wr_area0` = '".$wr_area0."' ";
									if($wr_area1){
										array_push( $url, "wr_area1=" . $wr_area1 );
										$area_que .= " and `wr_area1` = '".$wr_area1."' ";
									}
								$area_que .= " ) ";

							array_push( $que, $area_que );
							}

							if($search_mode=='alba_resume_part'){
								if($code1){
									$second_type = $category_control->get_categoryCode($code1);
								}else{
									$third_type = $category_control->get_categoryCode($code);
									$second_type = $category_control->get_categoryCode($third_type['p_code']);
								}
								$first_type = $category_control->get_categoryCode($second_type['p_code']);
							}

							$wr_job_type0 = ($first_type['code']) ? $first_type['code'] : $_GET['wr_job_type0'];	 // 1차 직종
							$wr_job_type1 = ($second_type['code']) ? $second_type['code'] : $_GET['wr_job_type1'];	 // 2차 직종
							$wr_job_type2 = ($third_type['code']) ? $third_type['code'] : $_GET['wr_job_type2'];	 // 3차 직종
							
							if($wr_job_type0){
								$job_type_que  = " ( ";
								if($wr_job_type2){
									$job_type_que .= " `wr_job_type2` = '".$wr_job_type2."' ";
									array_push( $url, "wr_job_type2=" . $wr_job_type2 );
								} elseif($wr_job_type1){
									$job_type_que .= " `wr_job_type1` = '".$wr_job_type1."' ";
									array_push( $url, "wr_job_type1=" . $wr_job_type1 );
								}else{
									$job_type_que .= " `wr_job_type0` = '".$wr_job_type0."' ";
									array_push( $url, "wr_job_type0=" . $wr_job_type0 );
								}
								$job_type_que .= " ) ";

							array_push( $que, $job_type_que );
							}

							if($search_mode=='alba_resume_term'){
								$wr_date = ($code) ? $code : $_GET['wr_date'];
							}

							if($wr_date){
								array_push( $que, " `wr_date` = '".$wr_date."' " );
								array_push( $url, "wr_date=" . $wr_date );
							}


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
								$result['career'] = "약 <span>".sprintf('%02d',$year)."</span>년 <span>".$month."</span>개월";
							} else {
								$result['wr_career'] = $result['career'] = "신입";
							}

							$wr_career = $_GET['wr_career'];
							$wr_career_use = $_GET['wr_career_use'];
							if($wr_career_use){
								if($wr_career_use=='1'){	// 신입
									array_push( $que, " `wr_career` = '' " );
								} else if($wr_career_use=='2') {	 // 경력
									array_push( $que, " `wr_career` != '' " );
								}
							array_push($url, "wr_career_use=".$wr_career_use);
							}

							$wr_school_ability = $_GET['wr_school_ability'];
							if($wr_school_ability){
								array_push( $que, " left(`wr_school_ability`,19) = '".$wr_school_ability."' " );
								array_push($url, "wr_school_ability=" . $wr_school_ability);
							}

							$wr_age = $_GET['wr_age'];
							$wr_age_lows = $_GET['wr_age_lows'];
							if($wr_age){
								$age_rows = ($wr_age_lows=='low') ? " <= " : " >= ";
								if(!$wr_age_limit)	// 나이 무관 아닐때
									array_push( $que, " `wr_age`  " . $age_rows . $wr_age );
							array_push($url, "wr_age=".$wr_age);
							}

							$wr_gender = $_GET['wr_gender'];
							if($wr_gender){	
								$_gender = ($wr_gender=='1') ? "0" : "1";
								array_push( $que, " `wr_gender` = '".$_gender."' " );
								array_push($url, "wr_gender=".$wr_gender);
							}

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							/* 검색어 */
							if($search_keyword){

								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que .= " INSTR(LOWER(`wr_subject`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_introduce`), LOWER('".$search_keyword."')) ";
								} else {
									$search_que = "( INSTR(`wr_subject`, '".$search_keyword."') or INSTR(`wr_introduce`, '".$search_keyword."') ) ";
								}

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							array_push($que, $search_que);

							}
							/* // 검색어 */

						}

						/*
						echo "<pre>";
						//print_R($_GET);
						print_R($url);
						print_R($que);
						echo "</pre>";
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


				// 게시판 검색
				function board_list( $page, $page_rows ){

					global $alice, $utility, $config;
					global $board, $board_config_control;

						$mode = $_GET['mode'];
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드

						$board_list = $board_config_control->__BoardList();


						$result = array();

						if($mode=='mobile_search'){

							$i = 0;
							foreach( $board_list['result'] as $boards ){

								$bo_table = $boards['bo_table'];
								$write_table = "alice_write_".$bo_table;

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

								$search_query = " select * from `".$write_table."` where `wr_is_comment` = 0 and `wr_reply` = '' and `wr_secret` = 0 and " . $search_que . " order by wr_num, wr_reply desc ";

								$board_search_result = $this->query_fetch_rows($search_query);
								
								if($board_search_result){
									$result[$i]['bo_table'] = $bo_table;
									$result[$i]['bo_subject'] = $boards['bo_subject'];
									$j = 0;
									foreach($board_search_result as $val){
										$result[$i]['result'][$j]['wr_no'] = $val['wr_no'];
										$result[$i]['result'][$j]['wr_subject'] = $val['wr_subject'];
										$result[$i]['result'][$j]['wr_id'] = $val['wr_id'];
										$result[$i]['result'][$j]['wr_datetime'] = $val['wr_datetime'];
										$result[$i]['result'][$j]['wr_name'] = $val['wr_name'];
									$j++;
									}
								} else {
									continue;
								}

								//print_R($board_search_result);
							$i++;
							}

						} else {

							foreach( $board_list['result'] as $boards ){

								$bo_table = $boards['bo_table'];
								$write_table = "alice_write_".$bo_table;

								$search_query = " select * from `".$write_table."` order by wr_num, wr_reply desc ";

								$search_query = " select * from `".$write_table."` where `wr_is_comment` = 0 and `wr_reply` = '' and `wr_secret` = 0 order by wr_num, wr_reply desc ";

								$board_search_result = $this->query_fetch_rows($search_query);

								if($board_search_result){
									$result[$i]['bo_table'] = $bo_table;
									$result[$i]['bo_subject'] = $boards['bo_subject'];
									$j = 0;
									foreach($board_search_result as $val){
										$result[$i]['result'][$j]['wr_no'] = $val['wr_no'];
										$result[$i]['result'][$j]['wr_subject'] = $val['wr_subject'];
										$result[$i]['result'][$j]['wr_id'] = $val['wr_id'];
										$result[$i]['result'][$j]['wr_datetime'] = $val['wr_datetime'];
									$j++;
									}
								} else {
									continue;
								}

							}

						}


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