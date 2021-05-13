<?php
		/**
		* /application/nad/member/model/alice_member_model.class.php
		* @author Harimao
		* @since 2013/07/02
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Member Model Class
		* @Comment :: 관리자측 회원 관리 모델 클래스
		*/
		class alice_member_model extends DBConnection {

			var $member_table				= "alice_member";
			var $member_company_table	= "alice_member_company";
			var $member_service_table	= "alice_member_service";
			var $member_photo_table		= "alice_member_photo";
			var $reason_table					= "alice_reason";

			var $success_code = array(
					'0000' => '회원 등록이 완료 되었습니다.',
					'0001' => '회원 수정이 완료 되었습니다.',
					'0002' => '메모 작성이 완료 되었습니다.',
					'0003' => '회원 정보 수정이 완료 되었습니다.',
					'0004' => '회원 정보 등록이 완료 되었습니다.',
					'0005' => 'SMS 수동 충전(차감) 이 완료 되었습니다.',
					'0006' => '점프 건수 수동 충전(차감) 이 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '회원약관에 동의하셔야 합니다.',
					'0001' => '개인정보보호정책에 동의하셔야 합니다.',
					'0002' => '메모 작성중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '회원 정보 입력중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0004' => '회원 정보 수정중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0005' => '기업회원 정보 입력중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0006' => '기업회원 정보 수정중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0007' => '회원 정보 삭제중 오류가 발생하였습니다..\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0008' => '회원 정보 입력중이셨다면 회원구분 변경시 입력된 내용이 초기화됩니다.\\n\\n회원구분을 변경하시겠습니까?',
					'0009' => '불량 회원으로 등록중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0010' => '회원정보 탈퇴 처리중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0011' => '회원정보 복귀중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0012' => '회원정보 탈퇴 승인중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0013' => '존재하는 회원아이디가 아닙니다.',
					'0014' => '열람서비스 기간 설정중 오류가 발생하였습니다.',
					'0015' => '기업정보 삭제중 오류가 발생하였습니다.',
					'0016' => 'SMS 수동 충전(차감)중 오류가 발생하였습니다.',
					'0017' => '점프 건수 수동 충전(차감)중 오류가 발생하였습니다.',

			);

			var $mb_type = array( "individual" => "개인회원", "company" => "기업회원" );
			var $mb_gender = array( 0 => "남", 1 => "여");


				// 회원 리스트 출력
				// 3중 조인 필요
				function __MemberList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						//$query = " SELECT * FROM `".$this->member_table."` LEFT JOIN `".$this->member_company_table."` ON ".$this->member_table.".mb_id = ".$this->member_company_table.".mb_id  LEFT JOIN `".$this->member_service_table."` ON ".$this->member_table.".mb_id = ".$this->member_service_table.".mb_id " . $con . $_add['que'] . " order by " . $_add['order'];
						$query  = " select a.*, ";
						$query .= " b.mb_ceo_name, b.mb_company_name, b.mb_biz_type, b.mb_biz_no, b.mb_biz_fax, b.mb_biz_success, b.mb_biz_form, b.mb_biz_content, b.mb_biz_foundation, b.mb_biz_member_count, b.mb_biz_stock, b.mb_biz_sale, b.mb_biz_vision, b.mb_biz_result, b.mb_logo, b.mb_latlng, ";
						$query .= " c.mb_service_platinum, c.mb_service_platinum_count, c.mb_service_prime, c.mb_service_prime_count, c.mb_service_grand, c.mb_service_grand_count, c.mb_service_banner, c.mb_service_banner_count, c.mb_service_list, c.mb_service_list_count, c.mb_service_logo, c.mb_service_logo_count, c.mb_service_neon, c.mb_service_neon_count, c.mb_service_bold, c.mb_service_bold_count, c.mb_service_color, c.mb_service_color_count, c.mb_service_icon, c.mb_service_icon_count, c.mb_service_blink, c.mb_service_blink_count, c.mb_service_open, c.mb_service_open_count, c.mb_service_focus, c.mb_service_focus_count, c.mb_service_busy, c.mb_service_busy_count, c.mb_employ_jump, c.mb_employ_jump_count, c.mb_resume_jump, c.mb_resume_jump_count, c.mb_alba_jump, c.mb_alba_jump_count ";
						$query .= " from `".$this->member_table."` a left join `".$this->member_company_table."` b on a.mb_id = b.mb_id left join `".$this->member_service_table."` c on a.mb_id = c.mb_id " . $_add['que'] . $con . $_add['order'];

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

					
					return $result;

				}

				// 회원 테이블 리스트만 추출
				function member_list( $page="", $page_rows="", $con="" ){

						$_add = $this->search();

						$query = " select * from `".$this->member_table."` " . $con . $_add['que'] . "  order by `no` desc ";

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
						echo "</div><br/>";
						 */

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}

				
				// 회원 테이블 리스트만 추출
				function member_list2( $page="", $page_rows="", $con="" ){

						$_add = $this->search();

						$query = " select * from `".$this->member_table."` " . $_add['que'] . $con . "  order by `no` desc ";

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
						echo "</div><br/>";
						 */

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}


				// 회원 정보 추출(단일) :: mb_id 기준
				function get_member( $mb_id ){

						if(!$mb_id)	 // mb_id 가 없다면 false
							return false;

						$query = " select * from `".$this->member_table."` where `mb_id` = '".$mb_id."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 회원 정보 추출(단일) :: no 기준
				function get_memberNo( $no ){

						if(!$no)	 // no 가 없다면 false
							return false;

						$query = " select * from `".$this->member_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 회원 정보 추출(단일) :: mb_email 기준
				function get_memberEmail( $mb_email ){

						if(!$mb_email)	 // email 이 없다면 false
							return false;

						$query = " select * from `".$this->member_table."` where `mb_email` = '".$mb_email."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 회원 정보 추출(복수) :: mb_email 기준
				function get_memberEmail_s( $mb_email, $mb_id='' ){

						if(!$mb_email)	 // email 이 없다면 false
							return false;

						$query = " select * from `".$this->member_table."` where `mb_email` = '".$mb_email."' ";
 
						if($mb_id) $query .= " and `mb_id` = '".$mb_id."' "; 

						$result = $this->query_fetch_rows($query);


					return $result;

				}

				// 기업회원 정보 추출(단일) :: mb_id 기준
				function get_company_member( $mb_id, $con="" ){

						if(!$mb_id)	 // mb_id 가 없다면 false
							return false;

						$query = " select * from `".$this->member_company_table."` where `mb_id` = '".$mb_id."' " . $con;

						$result = $this->query_fetch($query);


					return $result;

				}

				// 기업회원 정보 추출(단일) :: no 기준
				function get_company_memberNo( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->member_company_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 회원별 서비스 정보 추출(단일) :: mb_id 기준
				function get_service_member( $mb_id ){

						if(!$mb_id)	 // mb_id 가 없다면 false
							return false;

						$query = " select * from `".$this->member_service_table."` where `mb_id` = '".$mb_id."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 회원별 서비스 정보 추출(단일) :: mb_id 기준
				function get_photo_member( $mb_id ){

						if(!$mb_id)	 // mb_id 가 없다면 false 
							return false;

						$query = " select * from `".$this->member_photo_table."` where `mb_id` = '".$mb_id."' order by no desc ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 회원별 SMS, Email 수신 여부 확인
				function is_receive( $mb_id ){

						if(!$mb_id) return false;

						$get_member = $this->get_member($mb_id);

						$mb_receive = explode(",",$get_member);
				}


				/**
				* 닉네임 중복 체크
				*/
				function nick_checking( $mb_id, $mb_nick="" ){

					global $alice, $config;
					global $utility;

						$result = true;	// 유효하다면 true
					
						$mb_nick = trim(strip_tags(mysql_escape_string($mb_nick)));

						if(!$mb_nick || $m_nick=='') {	 // 닉 입력을 안한 경우

							$result = false;

						} else {

							$query = " select * from `".$this->user_table."` where `mb_nick` = '".$mb_nick."' and `mb_id` != '".$mb_id."' ";
							
							$count = $this->_queryR($query);

							if($count) {

								$result = false;

							}

						}


					return $result;

				}


				// 회원 검색
				function _Search( ){

					global $utility, $config;

						$mode = $_GET['mode'];

						$page = $_GET['page'];

						$order = " group by a.no ";

						$sort = $_GET['sort'];

						if($sort){
							if($sort == 'mb_service_open') // 열람기간은 서비스 테이블에서
								$order = " order by c.".$sort." ";
							else if($sort=='mb_company_name')	// 업소회원명은 업소회원 테이블에서
								$order = " group by b.".$sort." ";
							else
								$order = " order by a.".$sort." ";
						}


						$flag = $_GET['flag'];

						$order .= ($flag) ? " ".$flag." " : " desc ";

						$date_type = $_GET['date_type'];	// 가입일/최종로그인

						// 가입일
						$start_dayAll = $_GET['start_dayAll'];
						$start_day = urldecode($_GET['start_day']);
						$end_day = urldecode($_GET['end_day']);

						$mb_type = $_GET['mb_type'];	// 회원구분

						// 방문수
						$loginAll = $_GET['loginAll'];
						$loginCnt_low = $_GET['loginCnt_low'];
						$loginCnt_high = $_GET['loginCnt_high'];

						// 메일 수신거부
						$mb_email_receive = $_GET['mb_email_receive'];

						$mb_badness = $_GET['mb_badness'];	// 불량회원
						$mb_left_request = $_GET['mb_left_request'];	// 탈퇴요청
						$mb_left = $_GET['mb_left'];	// 탈퇴완료

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = urldecode($_GET['search_keyword']);	 // 검색 키워드

						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드
							array_push( $url, "date_type=" . $date_type );	 // 검색 날짜

							$wdate = $date_type;

							
							## 가입입 검색 #################################################################################
							if(!$start_dayAll){	// 전체가 아닐 경우에만

								$member_wdate = "a." . $wdate;

								// 두 값이 모두 다 있는 경우
								if( $start_day!='' && $end_day!='' ) {		// start_day && end_day

									array_push( $que, " ( " . $member_wdate . " between '" . $start_day . " 00:00:00' and '" . $end_day . " 23:59:59' ) " );
									array_push( $url, "start_day=" . urlencode($start_day) . "&end_day=" . urlencode($end_day) );

								// 두 값이 모두 다 없고 둘중 하나만 있는 경우
								} else {

									if( $start_day!='' ) {		// start_day
										array_push( $que, " " . $member_wdate . " >= '" . $start_day . "' " );
										array_push( $url, "start_day=" . urlencode($start_day) );
									}

									if( $end_day!='' ) {		// end_day
										array_push( $que, " " . $member_wdate . " <= '" . $end_day . "' " );
										array_push( $url, "end_day=" . urlencode($end_day) );
									}

								}

							}
							## //가입입 검색 ###############################################################################


							## 회원분류 검색 ###############################################################################
							$member_type = "a.mb_type";

							if($mb_type){
								if($mb_type!='all'){	 // 전체 검색이 아닐때만
									array_push( $que, " " . $member_type . " = '" . $mb_type . "' " );
									array_push( $url, "mb_type=" . urlencode($mb_type) );
								}/* else {
									array_push( $url, "mb_type=" . urlencode($mb_type) );
								}*/
							}
							## //회원분류 검색 ##############################################################################


							## 방문수 검색 ################################################################################
							if(!$loginAll){	// 전체가 아닐때
								
								$member_login_cnt = "a.mb_login_count";

								// 두 값이 모두 다 있는 경우
								if( $loginCnt_low!='' && $loginCnt_high!='' ) {		// start_day && end_day

									array_push( $que, " ( " . $member_login_cnt . " between " . $loginCnt_low . " and " . $loginCnt_high . " ) " );
									array_push( $url, "loginCnt_low=" . $loginCnt_low . "&loginCnt_high=" . $loginCnt_high );

								// 두 값이 모두 다 없고 둘중 하나만 있는 경우
								} else {

									if( $loginCnt_low!='' ) {		// loginCnt_low
										array_push( $que, " " . $member_login_cnt . " >= '" . $loginCnt_low . "' " );
										array_push( $url, "loginCnt_low=" . $loginCnt_low );
									}

									if( $loginCnt_high!='' ) {		// loginCnt_high
										array_push( $que, " " . $member_login_cnt . " <= '" . $loginCnt_high . "' " );
										array_push( $url, "loginCnt_high=" . $loginCnt_high );
									}

								}

							}
							## //방문수 검색 ###############################################################################

							
							## 메일수신거부 검색 ############################################################################
							if($mb_email_receive=='0'){	// 수신거부
								array_push( $que, " a.mb_receive not like '%email%' " );
							} else {
								if($mb_email_receive=='1'){	// 수신허용
									array_push( $que, " INSTR(a.mb_receive,'email') " );
								}
							}
							array_push( $url, "mb_badness=" . $mb_badness );

							## //메일수신거부 검색 ###########################################################################


							## 불량회원 검색 ###############################################################################
							$member_badness = "a.mb_badness";

							if($mb_badness!=''){
								array_push( $que, " " . $member_badness . " = '" . $mb_badness . "' " );
								array_push( $url, "mb_badness=" . $mb_badness );
							}
							## //불량회원 검색 ##############################################################################


							## 탈퇴요청 검색 ###############################################################################
							$member_left_request = "a.mb_left_request";

							if($mb_left_request!=''){
								array_push( $que, " " . $member_left_request . " = '" . $mb_left_request . "' " );
								array_push( $url, "mb_left_request=" . $mb_left_request );
							}
							## //탈퇴요청 검색 ##############################################################################


							## 탈퇴완료 검색 ###############################################################################
							$member_left = "a.mb_left";

							if($mb_left!=''){
								array_push( $que, " " . $member_left . " = '" . $mb_left . "' " );
								array_push( $url, "mb_left=" . $mb_left );
							}
							## //탈퇴요청 검색 ##############################################################################

							
							## 필드선택에 따른 검색 ##########################################################################
							$member_id = "a.mb_id";
							$member_name = "a.mb_name";
							$member_email = "a.mb_email";
							$company_name = "b.mb_company_name";

							if($search_field==''){	// 통합검색 일때

								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que = "(";
									$search_que .= " INSTR(LOWER(".$member_id."), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(".$member_name."), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(".$member_email."), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(".$company_name."), LOWER('".$search_keyword."')) ";
									$search_que .= " )";
								} else {
									$search_que = "(";
									$search_que .= " INSTR(".$member_id.", '".$search_keyword."') or ";
									$search_que .= " INSTR(".$member_name.", '".$search_keyword."') or ";
									$search_que .= " INSTR(".$member_email.", '".$search_keyword."') or ";
									$search_que .= " INSTR(".$company_name.", '".$search_keyword."') ";
									$search_que .= ") ";
								}

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							} else {	 // 필드 선택

								if(preg_match("/[a-zA-Z]/", $search_keyword))
									$search_que = " INSTR(LOWER(a." . $search_field . "), LOWER('".$search_keyword."')) ";
								else
									$search_que = " INSTR(a." . $search_field . ", '".$search_keyword."') ";

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

						
						/*
						print_R($que);
						echo "<br/><p>".$send_url."</p>";
						echo "</div></pre>";
						*/


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 회원 간단 검색
				function search(){

					global $config, $utility;
					global $board;

						$mode = $_GET['mode'];
						$page = $_GET['page'];

						$search_field = $_GET['search_field'];
						$search_receive = $_GET['search_receive'];
						$search_mb_type = $_GET['search_mb_type'];
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드

						$que = array();
						$url = array();

						if($mode=='member_search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							// SQL Injection 방지
							// 필드값에 a-z A-Z 0-9 _ , | 이외의 값이 있다면 검색필드를 wr_subject 로 설정한다.
							$field = preg_match("/^[\w\,\|]+$/", $search_field) ? $search_field : "mb_name";
							if (preg_match("/[a-zA-Z]/", $search_keyword)){
								$search_que .= "INSTR(LOWER(`".$field."`), LOWER('".$search_keyword."'))";
							} else {
								$search_que .= " INSTR(`".$field."`, '".$search_keyword."') ";
							}

							if($search_mb_type) {
                                $search_que .= " and `mb_type` = '".$search_mb_type."'";
                            }

							if($search_receive == 'yes') { //문자 수신허용
								$search_text = 'sms';
                                $search_que .= " and INSTR(`mb_receive`, '".$search_text."') ";
                            }else if($search_receive == 'no') { //문자 수신거부
								$search_text = 'sms';
                                $search_que .= " and `mb_receive` NOT like '%".$search_text."%' ";
                            }
						
							array_push( $url, "search_field=" . urlencode($search_field) . "&search_keyword=" . urlencode($search_keyword) . "$search_mb_type=" . urlencode($search_mb_type) );
							array_push( $url, "sarch_receive=" . $sarch_receive );
							array_push( $que, $search_que );

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


				// 회원 리스트 출력
				// 3중 조인 필요
				function __CompanyList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_companySearch( );

						$query = " select * from `".$this->member_company_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

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

						//echo $query;

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// 회원 검색
				function _companySearch( ){

					global $utility, $config;

						$mode = $_GET['mode'];

						$page = $_GET['page'];

						$sort = $_GET['sort'];

						$order = " `no` desc ";

						$mb_biz_type = $_GET['mb_biz_type'];
						$mb_biz_success = $_GET['mb_biz_success'];
						$mb_biz_form = $_GET['mb_biz_form'];

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = urldecode($_GET['search_keyword']);	 // 검색 키워드

						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							## 회사분류 #################################################################################
							if( $mb_biz_type ){
								$mb_biz_types = array();
								$mb_biz_type_cnt = count($mb_biz_type);
								for($i=0;$i<$mb_biz_type_cnt;$i++){
									array_push($mb_biz_types,"'".$mb_biz_type[$i]."'");
								}
								$biz_type = @implode($mb_biz_types,",");
								array_push( $que, " `mb_biz_type` in (".$biz_type.") " );
								//array_push( $url, "mb_biz_type=" . $mb_biz_type );
							}
							## //회사분류 ################################################################################

							## 상장여부 #################################################################################
							if( $mb_biz_success ){
								$mb_biz_successs = array();
								$mb_biz_success_cnt = count($mb_biz_success);
								for($i=0;$i<$mb_biz_success_cnt;$i++){
									array_push($mb_biz_successs,"'".$mb_biz_success[$i]."'");
								}
								$biz_success = @implode($mb_biz_successs,",");
								array_push( $que, " `mb_biz_success` in (".$biz_success.") " );
								//array_push( $url, "mb_biz_success=" . $mb_biz_success );
							}
							## //상장여부 ################################################################################

							## 기업형태 #################################################################################
							if( $mb_biz_form ){
								$mb_biz_forms = array();
								$mb_biz_form_cnt = count($mb_biz_form);
								for($i=0;$i<$mb_biz_form_cnt;$i++){
									array_push($mb_biz_forms,"'".$mb_biz_form[$i]."'");
								}
								$biz_form = @implode($mb_biz_forms,",");
								array_push( $que, " `mb_biz_form` in (".$biz_form.") " );
								//array_push( $url, "mb_biz_form=" . $mb_biz_form );
							}
							## //기업형태 ################################################################################


							## 필드선택에 따른 검색 ##########################################################################
							if($search_field==''){	// 통합검색 일때

								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que = "(";
									$search_que .= " INSTR(LOWER(`mb_id`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`mb_ceo_name`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`mb_company_name`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`mb_biz_no`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`mb_biz_phone`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`mb_biz_hphone`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`mb_biz_fax`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`mb_biz_email`), LOWER('".$search_keyword."')) ";
									$search_que .= " )";
								} else {
									$search_que = "(";
									$search_que .= " INSTR(`mb_id`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`mb_ceo_name`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`mb_company_name`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`mb_biz_no`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`mb_biz_phone`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`mb_biz_hphone`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`mb_biz_fax`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`mb_biz_email`, '".$search_keyword."') ";
									$search_que .= ") ";
								}

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							} else {	 // 필드 선택

								if(preg_match("/[a-zA-Z]/", $search_keyword))
									$search_que = " INSTR(LOWER(" . $search_field . "), LOWER('".$search_keyword."')) ";
								else
									$search_que = " INSTR(" . $search_field . ", '".$search_keyword."') ";

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



				// 개인회원 나이
				function get_age( $birth, $is_foreigner=false ){

						if(!$birth) return false;

						$birth = substr($birth,0,4);

						if($is_foreigner){

							$result = ( date('Y') - $birth);

						} else {

							$result = ( date('Y') - $birth) + 1;

						}


					return $result;

				}

				// 레벨정보
				function get_level( $level ){

					global $utility;
					global $category_control;

						if(!$level) return false;

						$con = " and `type` = 'mb_level' ";

						$get_level = $category_control->get_categoryRank($level, $con);

						$result = $utility->remove_quoted($get_level['name']);


					return $result;

				}


				// 회원 정보 추출
				function get_member_cnt( $_add="" ){

						$query = " select * from `".$this->member_table."` " . $_add;

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