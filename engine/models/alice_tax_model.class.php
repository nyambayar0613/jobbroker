<?php
		/**
		* /application/nad/payment/model/alice_tax_model.class.php
		* @author Harimao
		* @since 2013/09/30
		* @last update 2013/09/30
		* @Module v3.5 ( Alice )
		* @Brief :: Tax Model class
		* @Comment :: 세금계산서 모델 클래스
		*/
		class alice_tax_model extends DBConnection {

			var $tax_table	= "alice_tax";

			var $status = array( 
				0 => array( 'name' => '신청중', 'color' => '#000000' ),
				1 => array( 'name' => '처리완료', 'color' => '#0080ff' ),
				2 => array( 'name' => '취소', 'color' => '#ff0000' ),
				3 => array( 'name' => '불가', 'color' => '#ff8040' ),
			);

			var $success_code = array(
					'0000' => '세금계산서 신청이 완료 되었습니다.',
					'0001' => '상태 변경이 완료 되었습니다.',
			);

			var $fail_code = array(
					'0000' => '세금계산서 신청중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0001' => '상태 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);

				// 계산서 리스트
				function __TaxList( $page="", $page_rows="", $con="", $order="" ){

						// 검색시 사용
						$_add = $this->_Search();

						$query = " select * from `".$this->tax_table."` " . $con . $_add['que'];

						if(!$order) 
							$query .= " order by " . $_add['order'];
						else 
							$query .= $order;
						
						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/* 질의문 확인
						echo "<div style='color:#fff;'>";
						echo $query."<br/>";
						echo "</div><br/>";
						*/

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// 세금계산서 정보 추출 (단수)
				function get_tax( $no ){

						if(!$no || $no=='' ) return false;

						$query = " select * from `".$this->tax_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 리스트 검색
				function _Search(){

					global $utility, $config;

						$page = $_GET['page'];
						
						$order = " `no` ";

						$sort = $_GET['sort'];	 // 정렬 기준
						
						if($sort) $order = " `".$sort."` ";
						
						$flag = $_GET['flag'];	 // 정렬 순서
						
						$order .= ($flag) ? $flag : " desc ";

						$mode = $_GET['mode'];
						if($_POST['mode']){	// 검색 방식 유효성 검사
							$utility->popup_msg_js($config->_errors('0046'));
							exit;
						}

						$start_dayAll = $_GET['start_dayAll'];
						$start_day = $_GET['start_day'];
						$end_day = $_GET['end_day'];

						$search_date = $_GET['search_date'];
						$status = $_GET['status'];

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = $_GET['search_keyword'];	 // 검색 키워드


						$que = array();
						$url = array();


						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드
							array_push( $url, "search_date=" . urlencode($search_date) );

							## pay 지정 필드별 검색 ######################################################################################
							if(!$start_dayAll){	// 전체가 아닐 경우에만

								// 두 값이 모두 다 있는 경우
								if( $start_day!='' && $end_day!='' ) {		// start_day && end_day

									array_push( $que, " ( `".$search_date."` between '".$start_day." 00:00:00' and '".$end_day." 23:59:59' ) " );
									array_push( $url, "start_day=" . urlencode($start_day) . "&end_day=" . urlencode($end_day) );

								// 두 값이 모두 다 없고 둘중 하나만 있는 경우
								} else {

									if( $start_day!='' ) {		// start_day
										array_push( $que, " `".$search_date."` >= '".$start_day."' " );
										array_push( $url, "start_day=" . urlencode($start_day) );
									}

									if( $end_day!='' ) {		// end_day
										array_push( $que, " `".$search_date."` <= '".$end_day."' " );
										array_push( $url, "end_day=" . urlencode($end_day) );	
									}

								}

							}
							## //pay 지정 필드별 검색 #####################################################################################


							## 상태별 검색 ############################################################################################
							if($pay_status || $pay_status=='0'){	 // 체크값이 존재하는 경우
								if(is_array($pay_status)){	// 배열인 경우 form 에서 넘어온 값
									if(!@in_array('all',$pay_status)){	 // 전체가 아닐때만
										$status = @implode(',',$pay_status);
										array_push( $que, " `pay_status` in (".$status.") " );
										array_push( $url, "status=" . $pay_status );	
									}
								} else {	 // 배열이 아닌 경우
									array_push( $que, " `pay_status` = '".$pay_status."' " );
									array_push( $url, "status=" . $pay_status );	
								}
							}

							if($status || $status=='0'){	// 체크값이 존재하는 경우
								if(is_array($status)){	// 배열인 경우 form 에서 넘어온 값
									if(!@in_array('all',$status)){	 // 전체가 아닐때만
										$wr_status = @implode(',',$status);
										array_push( $que, " `wr_status` in (".$wr_status.") " );
										array_push( $url, "status=" . $status );	
									}
								} else {	 // 배열이 아닌 경우
									array_push( $que, " `wr_status` = '".$wr_status."' " );
									array_push( $url, "status=" . $status );	
								}
							}
							## //상태별 검색 ###########################################################################################


							## 필드선택에 따른 검색 ######################################################################################
							if($search_keyword){

								if(!$search_field){	// 통합검색 일때

									if(preg_match("/[a-zA-Z]/", $search_keyword)) {
										$search_que  = " ( ";
										$search_que .= " INSTR(LOWER(`wr_name`), LOWER('".$search_keyword."'))";	// 회원아이디
										$search_que .= " or INSTR(LOWER(`wr_id`), LOWER('".$search_keyword."'))";	// 이름
										$search_que .= " or INSTR(LOWER(`wr_company_name`), LOWER('".$search_keyword."'))";	// 입금자명
										$search_que .= " or INSTR(LOWER(`wr_ceo_name`), LOWER('".$search_keyword."'))";	// 이메일
										$search_que .= " ) ";
									} else {
										$search_que  = " ( ";
										$search_que .= " INSTR(`wr_name`, '".$search_keyword."')";
										$search_que .= " or INSTR(`wr_id`, '".$search_keyword."')";
										$search_que .= " or INSTR(`wr_company_name`, '".$search_keyword."')";
										$search_que .= " or INSTR(`wr_ceo_name`, '".$search_keyword."')";
										$search_que .= " ) ";
									}

									array_push($url, "search_field=&search_keyword=" . $search_keyword);

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

								array_push($que, $search_que);

							}
							## //필드선택에 따른 검색 #####################################################################################

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