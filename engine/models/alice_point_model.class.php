<?php
		/**
		* /application/nad/member/model/alice_point_model.class.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: PointModel Class
		* @Comment :: 포인트 관리 모델 클래스
		*/
		class alice_point_model extends DBConnection {

			var $point_table			= "alice_point";
			var $category_table	= "alice_category";

			var $success_code = array(
					'0000' => '',
			);
			var $fail_code = array(
					'0000' => '포인트를 차감하는 경우 현재 포인트보다 작으면 안됩니다.',
					'0001' => '포인트 내역 삭제중 오류가 발생하여습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '포인트 데이터 등록중 오류가 발생하여습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);

				// 포인트 리스트
				function __PointList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->point_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

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


				// 포인트 정보 추출(단수) :: no 기준
				function get_point( $no ){

						if(!$no || $no=="") return false;

						$query = " select * from `".$this->point_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 포인트 중복 지급 체크시 카운팅
				function get_point_cnt( $mb_id, $rel_table="", $rel_id="", $rel_action="" ){

						if(!$mb_id || $mb_id=="") return false;

						$query = " select count(*) as cnt from `".$this->point_table."` where `mb_id` = '".$mb_id."' and `point_rel_table` = '".$rel_table."' and `point_rel_id` = '".$rel_id."' and `point_rel_action` = '".$rel_action."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 전체 포인트
				function total_point( $con="" ){

						$_add = $this->_Search( );

						$query = " select sum(`point_point`) as point from `".$this->point_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 포인트 검색
				function _Search( ){

					global $utility, $config;

						$mode = $_GET['mode'];

						$page = $_GET['page'];

						$order = ($_GET['order']) ? $_GET['order'] : " `no` desc ";

						$sort = ($_GET['sort']) ? $_GET['sort'] : "";

						// 일시
						$start_dayAll = $_GET['start_dayAll'];
						$start_day = urldecode($_GET['start_day']);
						$end_day = urldecode($_GET['end_day']);

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드

						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							## 가입입 검색 #################################################################################
							if(!$start_dayAll){	// 전체가 아닐 경우에만

								// 두 값이 모두 다 있는 경우
								if( $start_day!='' && $end_day!='' ) {		// start_day && end_day

									array_push( $que, " ( `point_datetime` between '" . $start_day . " 00:00:00' and '" . $end_day . " 23:59:59' ) " );
									array_push( $url, "start_day=" . urlencode($start_day) . "&end_day=" . urlencode($end_day) );

								// 두 값이 모두 다 없고 둘중 하나만 있는 경우
								} else {

									if( $start_day!='' ) {		// start_day
										array_push( $que, " `point_datetime` >= '" . $start_day . "' " );
										array_push( $url, "start_day=" . urlencode($start_day) );
									}

									if( $end_day!='' ) {		// end_day
										array_push( $que, " `point_datetime` <= '" . $end_day . "' " );
										array_push( $url, "end_day=" . urlencode($end_day) );
									}

								}

							}
							## //가입입 검색 ###############################################################################

							## 필드선택에 따른 검색 ##########################################################################
							if($search_field==''){	// 통합검색 일때

								if(preg_match("/[a-zA-Z]/", $search_keyword))
									$search_que = "( INSTR(LOWER(`mb_id`), LOWER('".$search_keyword."')) or INSTR(LOWER(`point_content`), LOWER('".$search_keyword."')) )";
								else
									$search_que = "( INSTR(`mb_id`, '".$search_keyword."') or INSTR(`point_content`, '".$search_keyword."') ) ";

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							} else {	 // 필드 선택

								if(preg_match("/[a-zA-Z]/", $search_keyword))
									$search_que = " INSTR(LOWER(`" . $search_field . "`), LOWER('".$search_keyword."')) ";
								else
									$search_que = " INSTR(`" . $search_field . "`, '".$search_keyword."') ";

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

						/* 검색 쿼리문 확인
						print_R($que);
						echo "<br/><p>".$send_url."</p>";
						echo "</div></pre>";
						*/


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