<?php
		/**
		* /application/main/model/alice_receive_model.class.php
		* @author Harimao
		* @since 2013/09/25
		* @last update 2014/03/03
		* @Module v3.5 ( Alice )
		* @Brief :: Receive Data Model class
		* @Comment :: Receive 데이터 모델 클래스
		*/
		class alice_receive_model extends DBConnection {

			var $receive_table		= "alice_receive";
			var $scrap_table		= "alice_scrap";		// 스크랩 저장 테이블
			var $alba_table			= "alice_alba";

			var $become_arr = array( "become_email" => "이메일", "become_online" =>"온라인" );

			var $success_code = array(
					'0000' => '',
			);
			var $fail_code = array(
					'0000' => '이미 지원하셨습니다.',
			);


				// 데이터 리스트
				function __ReceiveList( $page="", $page_rows="", $con="" ){

						$mode = $_GET['mode'];

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->receive_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

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


					return $result;

				}


				// 스크랩 데이터 리스팅
				function __ScrapList( $page="", $page_rows="", $con="" ){

					global $alice;
					global $member_control;


						$result = array();
						
						$query = " select * from `".$this->scrap_table."` " . $con . " order by `no` desc ";

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



				// 데이터 정보 추출 (단수) :: no 기준
				function get_receive( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->receive_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 데이터 정보 추출 (단수)
				function get_receive_info( $con="" ){

						$query = " select * from `".$this->receive_table."` " . $con;

						$result = $this->query_fetch($query);


					return $result;

				}


				// 데이터 정보 중복 확인 :: type, wr_id, wr_to 로 확인
				function is_receive( $type, $wr_id, $wr_to ){

						if( !$type || $type =='' ) return false;

						$query = " select * from `".$this->receive_table."` where `type` = '".$type."' and `wr_id` = '".$wr_id."' and `wr_to` = '".$wr_to."'  and `is_cancel` = 0 and `is_delete` = 0 ";

						$result = $this->_queryR($query);


					return $result;

				}


				// 데이터 검색
				function _Search( ){

					global $utility, $config;

						$mode = $_GET['mode'];

						//$type = $_GET['type'];

						$page = $_GET['page'];

						$order = ($_GET['order']) ? $_GET['order'] : " `no` desc ";

						$pay_sdate = $_GET['pay_sdate'];
						$pay_edate = $_GET['pay_edate'];

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드

						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							if($pay_sdate && $pay_edate){	// 사용자측 검색

								$pay_sdates = $pay_sdate[0] . "-" . $pay_sdate[1] . "-" . $pay_sdate[2];
								$pay_edates = $pay_edate[0] . "-" . $pay_edate[1] . "-" . $pay_edate[2];
								array_push( $que, " `wdate` between '".$pay_sdates."' and '".$pay_edates."' " );

							}

							if($search_keyword){

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