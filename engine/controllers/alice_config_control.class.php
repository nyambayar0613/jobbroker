<?php
		/**
		* /application/nad/config/controller/alice_config_control.class.php
		* @author Harimao
		* @since 2013/05/24
		* @last update 2013/05/31
		* @Module v3.5 ( Alice )
		* @Brief :: Site Environment
		* @Comment :: 사이트 기본환경설정 컨트롤 클래스
		*/
		class alice_config_control extends config {


				/**
				* 기본 환경설정 정보 입력
				*/
				function config_insert( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->config_table."` set " . $val;

						if($no)
							$query .= " where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;

				}

				/**
				* 기본 환경설정 정보 수정
				*/
				function config_update( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->config_table."` set " . $val;

						if($no)
							$query .= " where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;

				}


				/**
				* 방문자수
				*/
				function alice_visit( ){

					global $alice, $utility;
					global $remote_addr, $referer, $user_agent;


						// 방문자 로그
						if ($utility->get_cookie('alice_visit_ip') != $remote_addr) {
							
							$utility->set_cookie('alice_visit_ip', $remote_addr, 86400); // 하루동안 저장

							$tmp_row = $this->query_fetch(" select max(`vi_id`) as `max_vi_id` from `".$this->visit_table."` ");
							$vi_id = $tmp_row['max_vi_id'] + 1;

							$query = " insert `".$this->visit_table."` (`vi_ip`, `vi_date`, `vi_time`, `vi_referer`, `vi_agent` ) values ('".$remote_addr."', '".$alice['time_ymd']."', '".$alice['time_his']."', '".$referer."', '".$user_agent."')";
							$result = $this->_query($query, FALSE);

							$results = array();

							// 정상으로 INSERT 되었다면 방문자 합계에 반영
							if ($result) {

								$query = " insert `".$this->visit_sum_table."` set `vs_count` = '1', `vs_date` = '".$alice['time_ymd']."' ";
								$result = $this->_query($query, FALSE);	// 합계 테이블 저장

								$query = " update `".$this->config_table."` set `visit_count` = `visit_count` + 1 ";
								$result = $this->_query($query, FALSE);	// 환경설정 테이블 방문자 카운트 업데이트
								
								// DUPLICATE 오류가 발생한다면 이미 날짜별 행이 생성되었으므로 UPDATE 실행
								if (!$result) {
									$query = " update `".$this->visit_sum_table."` set `vs_count` = `vs_count` + 1 where `vs_date` = '".$alice['time_ymd']."' ";
									$result = $this->_query($query);
								}

								// 오늘
								$query = " select `vs_count` as cnt from `".$this->visit_sum_table."` where `vs_date` = '".$alice['time_ymd']."' ";
								$row = $this->qurey_fetch($query);
								$results['vi_today'] = $row['cnt'];

								// 어제
								$query = " select `vs_count` as cnt from `".$this->visit_sum_table."` where `vs_date` = DATE_SUB('".$alice['time_ymd']."', INTERVAL 1 DAY) ";
								$row = $this->qurey_fetch($query);
								$results['vi_yesterday'] = $row['cnt'];

								// 최대
								$query = " select max(`vs_count`) as cnt from `".$this->visit_sum_table."` ";
								$row = $this->qurey_fetch($query);
								$results['vi_max'] = $row['cnt'];

								// 전체
								$query = " select sum(`vs_count`) as total from `".$this->visit_sum_table."` "; 
								$row = $this->qurey_fetch($query);
								$results['vi_sum'] = $row['total'];

								//$visit = "오늘:".$vi_today.",어제:".$vi_yesterday.",최대:".$vi_max.",전체:".$vi_sum;

								/* 기본설정 테이블에 방문자수를 기록한 후 
								 * 방문자수 테이블을 읽지 않고 출력한다.
								 * 쿼리의 수를 상당부분 줄임
								 */
								$this->visit_update_count($results['vi_sum']);

							}

						}


					return $results;

				}


				/**
				* 페이지별 방문자수
				*/
				function alice_visit_page( $vi_page="" ){

					global $alice, $utility;
					global $remote_addr, $referer, $user_agent;

						$check_val = $vi_page . "/" . $remote_addr . "/" . $alice['time_ymd'] . "/" . $user_agent;

						if ($utility->get_cookie('alice_visit_page') != $check_val) {

							$utility->set_cookie('alice_visit_page', $check_val, 86400); // 하루동안 저장

							$query = " insert `".$this->visit_page_table."` ( `vi_page`, `vi_ip` , `vi_date`, `vi_time`, `vi_referer`, `vi_agent` ) values ( '".$vi_page."', '".$remote_addr."', '".$alice['time_ymd']."', '".$alice['time_his']."', '".$referer."', '".$user_agent."' ) ";

							$result = $this->_query($query, FALSE);

						}

					
					return $result;

				}


				/**
				* 방문자수 입력
				*/
				function visit_update_count( $visit ){

						$query = " update `".$this->config_table."` set `visit_count` = '".$visit."' ";

						$result = $this->_query($query);

					
					return $result;

				}

		}	// class end.

?>