<?php
		/**
		* /application/individual/model/alice_alba_individual_model.class.php
		* @author Harimao
		* @since 2013/07/23
		* @last update 2015/04/10
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Individual Model class
		* @Comment :: 사용자측 정규직 이력서 및 개인 서비스 모델 클래스
		*/
		class alice_alba_individual_model extends DBConnection {

			var $resume_table	= "alice_alba_resume";
			var $resume_denied = "alice_resume_denied";	 // 열람제한 기업회원 정보 테이블
			var $resume_proof = "alice_resume_proof";	 // 취업활동 증명서 발급 정보 테이블
			var $resume_favorite = "alice_resume_favorite";	 // 관심 기업회원 정보 테이블
			var $custom_table = "alice_alba_search";	// 맞춤 기업정보 테이블
			var $open_table = "alice_resume_open";		// 채용공고 열람 정보 테이블

			var $success_code = array(
					'0000' => '이력서 등록이 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '이력서 등록중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0001' => '자신이 등록한 이력서만 수정 가능합니다.',
					'0002' => '이력서 삭제중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0003' => '이력서 복사중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0004' => '이력서 고유 데이터 번호가 잘못 되었습니다.\\n\\n해당 이력서가 삭제되었거나 이력서에 문제가 있을수 있습니다.',
					'0005' => '비공개 이력서 입니다.\\n\\n이력서 열람에 제한이 있습니다.',
					'0006' => '자신의 이력서만 확인 가능합니다.',
					'0007' => '이력서 수정중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0008' => '이력서 정보가 확인 되지 않습니다.\\n\\n해당 이력서가 삭제되었거나 이력서에 문제가 있을수 있습니다.',
					'0009' => '이력서 공개/비공개 설정중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0010' => '이력서가 존재하지 않거나, 삭제된 데이터 입니다.',
					'0011' => '해당 회원 이력서에 접근이 금지 되었습니다.',
					'0012' => '맞춤 채용정보 저장중 오류가 발생했습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0013' => '맞춤 채용정보 수정중 오류가 발생했습니다.',
					'0014' => '맞춤 채용정보 삭제중 오류가 발생했습니다.',
					'0015' => '이미 관심기업으로 등록하셨습니다.',
			);

			var $language_level = array( 
				0 => array( "name" => "상", "icon" => "icon_good.gif", "text" => "회화능숙" ),
				1 => array( "name" => "중", "icon" => "icon_average.gif", "text" => "일상대화" ),
				2 => array( "name" => "하", "icon" => "icon_poor.gif", "text" => "간단대화" ),
			);

			var $oa_level = array(
				"word" => array(
					0 => array( "name" => "상", "icon" => "icon_good.gif", "text" => "표/도구 활용가능" ),
					1 => array( "name" => "중", "icon" => "icon_average.gif", "text" => "문서편집 가능" ),
					2 => array( "name" => "하", "icon" => "icon_poor.gif", "text" => "기본사용" ),
				),
				"pt" => array(
					0 => array( "name" => "상", "icon" => "icon_good.gif", "text" => "챠트/효과 활용가능" ),
					1 => array( "name" => "중", "icon" => "icon_average.gif", "text" => "서식/도형 가능" ),
					2 => array( "name" => "하", "icon" => "icon_poor.gif", "text" => "기본사용" ),
				),
				"sheet" => array(
					0 => array( "name" => "상", "icon" => "icon_good.gif", "text" => "수식/함수 활용가능" ),
					1 => array( "name" => "중", "icon" => "icon_average.gif", "text" => "데이터 편집가능" ),
					2 => array( "name" => "하", "icon" => "icon_poor.gif", "text" => "기본사용" ),
				),
				"internet" => array(
					0 => array( "name" => "상", "icon" => "icon_good.gif", "text" => "정보수집 능숙" ),
					1 => array( "name" => "중", "icon" => "icon_average.gif", "text" => "정보수집 가능" ),
					2 => array( "name" => "하", "icon" => "icon_poor.gif", "text" => "기본사용" ),
				),
			);

			var $military = array( 0 => "미필", 1 => "군필", 2 => "면제");

				// 이력서 리스트
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

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}


				// 이력서 추출 (단수)
				function get_resume( $wr_id, $con="" ){

						if(!$wr_id || $wr_id=='') return false;

						$query = " select * from `".$this->resume_table."` where `wr_id` = '".$wr_id."' " . $con;

						$result = $this->query_fetch($query);


					return $result;
				}


				// 이력서 추출 (단수) :: no 기준
				function get_resume_no( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->resume_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;
				}

				
				// 이력서 검색
				function _Search( ){

					global $utility, $config;

						$mode = $_GET['mode'];

						$type = $_GET['type'];

						$page = $_GET['page'];

						$order = ($_GET['order']) ? $_GET['order'] : " `no` desc ";


						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

						}

						array_push($url, 'page='.$page);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 직종 간단 추출
				function get_job_type( $no ){

					global $category_control;

						$val = $this->get_resume_no( $no );

						$wr_job_type0 = $category_control->get_categoryCode($val['wr_job_type0']);
						$wr_job_type1 = $category_control->get_categoryCode($val['wr_job_type1']);
						$wr_job_type2 = $category_control->get_categoryCode($val['wr_job_type2']);

						$wr_job_type3 = $category_control->get_categoryCode($val['wr_job_type3']);
						$wr_job_type4 = $category_control->get_categoryCode($val['wr_job_type4']);
						$wr_job_type5 = $category_control->get_categoryCode($val['wr_job_type5']);

						$wr_job_type6 = $category_control->get_categoryCode($val['wr_job_type6']);
						$wr_job_type7 = $category_control->get_categoryCode($val['wr_job_type7']);
						$wr_job_type8 = $category_control->get_categoryCode($val['wr_job_type8']);

						$result = array();
						
						$result[] = $wr_job_type0['name'];

						if($wr_job_type1) $result[] = $wr_job_type1['name'];
						if($wr_job_type2) $result[] = $wr_job_type2['name'];

						if($wr_job_type3) $result[] = $wr_job_type3['name'];
						if($wr_job_type4) $result[] = $wr_job_type4['name'];
						if($wr_job_type5) $result[] = $wr_job_type5['name'];

						if($wr_job_type6) $result[] = $wr_job_type6['name'];
						if($wr_job_type7) $result[] = $wr_job_type7['name'];
						if($wr_job_type8) $result[] = $wr_job_type8['name'];


					return $result;

				}


				// 회원별 이력서 간단 리스트 :: wr_id 기준
				function get_resume_list( $wr_id ){

						if(!$wr_id || $wr_id == '') return false;

						$query = " select * from `".$this->resume_table."` where `wr_id` = '".$wr_id."' and `wr_open` = 1 and `wr_report` = 0 and `is_delete` = 0  ";	// 공개/미신고 이력서

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}

				
				/**
				* 이력서 리스트 출력 정보를 설정한다.
				* 일반 리스트 등에서 많이 사용한다.
				* wr_id :: 회원 아이디
				* no :: 이력서 no
				* photo_width,height :: 출력 사진 사이즈 조절
				* subject_len :: 글자 길이를 적용할 경우 리스트상 ... 을 적용한다.
				*/
				function get_individual_list( $wr_id, $no="", $photo_width="106", $photo_height="42", $subject_len="" ){

					global $alice, $config, $utility;
					global $user_control;	// $alba_user_control, , $category_control;

						$result = array();

						/*
						if($no){	 // 이력서 단수 추출
							echo "AAAA <==<br/>";
							$get_resume = $this->get_resume_no($no);
						} else {
							echo "BBBB <==<br/>";
							$get_resume = $this->get_resume($wr_id);	
						echo "<pre>";
						print_R($get_resume);
						echo "</pre>";
						}
						*/


				}

				// 과거 이력서 리스트
				function past_resume_list( $no="",$wr_id ){

						if($no){

							$query = " select * from `".$this->resume_table."` where `no` != '".$no."' and `wr_id` = '".$wr_id."' and `is_delete` = 0 order by `no` desc ";

						} else {

							$query = " select * from `".$this->resume_table."` where `wr_id` = '".$wr_id."' and `is_delete` = 0 order by `no` desc ";

						}

						$result = $this->query_fetch_rows($query);


					return $result;

				}

				// 열람 제한 기업 정보 리스트
				function get_denied_list( $page="", $page_rows="" ,$con="" ){

						$query = " select * from `".$this->resume_denied."` " . $con . " order by `no` desc ";

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

				// 기업회원 검색 (이력서 열람제한 기업에서 사용)
				function denied_company_search( $page="", $page_rows="" ,$con="" ){

					global $user_control;

						
						// 검색시 사용
						$_add = $this->_DeniedSearch( );

						$query = " select * from `".$user_control->company_table."` " . $_add['que'] . $con . " order by " . $_add['order'];

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

				function _DeniedSearch(){

						$mode = $_GET['mode'];

						$type = $_GET['type'];

						$page = $_GET['page'];

						$page_rows = $_GET['page_rows'];

						$order = " `no` desc ";

						$mb_company_name = urldecode( trim($_GET['mb_company_name']) );	 // 회사명

						$mb_biz_type = $_GET['mb_biz_type'];	// 업종


						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							// 업종
							if($mb_biz_type){
								array_push( $que, " `mb_biz_type` = '".$mb_biz_type."' ");
								array_push( $url, "mb_biz_type=".$mb_biz_type);
							}

							/* 회사명 */
							if($mb_company_name){

								if(preg_match("/[a-zA-Z]/", $mb_company_name)) {
									$search_que .= " INSTR(LOWER(`mb_company_name`), LOWER('".$mb_company_name."')) or";
								} else {
									$search_que = " INSTR(`mb_company_name`, '".$mb_company_name."') ";
								}

								array_push($url, "mb_company_name=" . urlencode($mb_company_name));

								array_push($que, $search_que);

							}
							/* // 회사명 */

						}

						array_push($url, 'page='.$page);
						array_push($url, 'page_rows='.$page_rows);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " where ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}

				// 이력서 열람제한 기업회원 체크
				function is_denied( $wr_id, $mb_id ){

						$query = " select * from `".$this->resume_denied."` where `wr_id` = '".$wr_id."' and `mb_id` = '".$mb_id."' ";

						$result = $this->_queryR( $query );


					return $result;

				}


				// 취업활동 증명서 발급 마지막 번호
				function proof_last_no(){

						$query = " select * from `".$this->resume_proof."` order by `no` desc limit 1 ";

						$result = $this->query_fetch($query);


					return $result['no'];
				}



				// 관심 기업 정보 리스트
				function get_favorite_list( $page="", $page_rows="" ,$con="" ){

						$query = " select * from `".$this->resume_favorite."` " . $con . " order by `no` desc ";

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

				// 기업회원 검색 (관심기업에서 사용)
				function favorite_company_search( $page="", $page_rows="" ,$con="" ){

					global $user_control;

						
						// 검색시 사용
						$_add = $this->_FavoriteSearch( );

						$query = " select * from `".$user_control->company_table."` " . $_add['que'] . $con . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						//echo $query."<br/>";

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}

				function _FavoriteSearch(){

						$mode = $_GET['mode'];

						$type = $_GET['type'];

						$page = $_GET['page'];

						$page_rows = $_GET['page_rows'];

						$order = " `no` desc ";

						$mb_company_name = urldecode( trim($_GET['mb_company_name']) );	 // 회사명

						$mb_biz_type = $_GET['mb_biz_type'];	// 업종


						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							// 업종
							if($mb_biz_type){
								array_push( $que, " `mb_biz_type` = '".$mb_biz_type."' ");
								array_push( $url, "mb_biz_type=".$mb_biz_type);
							}

							/* 회사명 */
							if($mb_company_name){

								if(preg_match("/[a-zA-Z]/", $mb_company_name)) {
									$search_que .= " INSTR(LOWER(`mb_company_name`), LOWER('".$mb_company_name."')) or";
								} else {
									$search_que = " INSTR(`mb_company_name`, '".$mb_company_name."') ";
								}

								array_push($url, "mb_company_name=" . urlencode($mb_company_name));

								array_push($que, $search_que);

							}
							/* // 회사명 */

						}

						array_push($url, 'page='.$page);
						array_push($url, 'page_rows='.$page_rows);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " where ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 맞춤채용정보 리스트
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

				// 맞춤채용정보 검색 리스트
				function custom_list( $page="", $page_rows="", $con="", $no="" ){

					global $alba_user_control;

						$_add = $this->_CustomSearch( $no );

						$query = " select * from `".$alba_user_control->alba_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

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

							if($wr_area0 || $wr_area1 || $wr_area2 || $wr_area3 || $wr_area4 || $wr_area5){
								$job_area_que = " ( ";
								if($wr_area0){
									//$job_area_que .= " `wr_area_0` = '".$wr_area0."' ";
									$job_area_que .= " INSTR(`wr_area_0`, '".$wr_area0."') ";
								}
								if($wr_area1){
									$job_area_que .= " or INSTR(`wr_area_1`, '".$wr_area1."') ";
								}
								if($wr_area2){
									$job_area_que .= " or INSTR(`wr_area_2`, '".$wr_area2."') ";
								}
								if($wr_area3){
									$job_area_que .= " or INSTR(`wr_area_3`, '".$wr_area3."') ";
								}
								if($wr_area4){
									$job_area_que .= " or INSTR(`wr_area_4`, '".$wr_area4."') ";
								}
								if($wr_area5){
									$job_area_que .= " or INSTR(`wr_area_5`, '".$wr_area5."') ";
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
								else if($wr_gender=='2') {
									$gender = 1;
								}
								$gender = $wr_gender; // : 추가 [ 채용정보인경우에는 여자는 2값임 ] 2018-02-10
								array_push( $que, " `wr_gender` = '".$gender."' " );
							}

							if($wr_age){	// 나이
								$wr_ages = explode('-',$wr_age);
								if(!$wr_age_limit)	// 나이 무관 아닐때
									array_push( $que, " ( `wr_age` between " . $wr_ages[0] . " and " . $wr_ages[1] ." ) " );
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

				// 맞춤 채용정보 타이틀 리스트 :: wr_id 기준
				function custom_titles( $wr_id ){

						if(!$wr_id || $wr_id=='') return false;

						$query = " select * from `".$this->custom_table."` where `wr_id` = '".$wr_id."' order by `no` desc ";

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 맞춤 채용정보 추출 :: no 기준 (단수)
				function get_custom( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->custom_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 맞춤 채용정보 마지막 no
				function get_last_no(){

						$query = " select * from `".$this->custom_table."` order by `no` desc ";

						$result = $this->query_fetch($query);

					
					return $result;
				}


				// 맞춤 채용정보 첫 no
				function get_first_no(){

						$query = " select * from `".$this->custom_table."` order by `no` asc ";

						$result = $this->query_fetch($query);

					
					return $result;
				}


				// 이력서별 서비스 기간 확인
				function service_valid( $no ){

					global $utility;
					global $alba_resume_control;

						if(!$no || $no=='') return false;

						$result = array();

						$get_resume = $alba_resume_control->get_resume($no);

						$result['service_main_focus'] = $utility->valid_day($get_resume['wr_service_main_focus']);
						$result['service_main_focus_text'] = "메인 포커스";
						$result['service_main_focus_gold'] = $utility->valid_day($get_resume['wr_service_main_focus_gold']);
						$result['service_main_focus_gold_text'] = "메인 포커스";

						$result['service_sub_focus'] = $utility->valid_day($get_resume['wr_service_sub_focus']);
						$result['service_sub_focus_text'] = "인재정보 포커스";
						$result['service_sub_focus_gold'] = $utility->valid_day($get_resume['wr_service_sub_focus_gold']);
						$result['service_sub_focus_gold_text'] = "인재정보 포커스";

						$result['service_basic'] = $utility->valid_day($get_resume['wr_service_basic']);
						$result['service_basic_text'] = "메인 일반";
						$result['service_basic_sub'] = $utility->valid_day($get_resume['wr_service_basic_sub']);
						$result['service_basic_sub_text'] = "인재정보 일반";


						/*
						$result['wr_service_busy'] = $get_alba['wr_service_busy'];
						$result['wr_service_focus'] = $get_alba['wr_service_focus'];
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