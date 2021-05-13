<?php
		/**
		* /application/nad/statistics/contoller/alice_statistics_control.class.php
		* @author Harimao
		* @since 2013/06/19
		* @last update 2015/04/03
		* @Module v3.5 ( Alice ) - s1.0
		* @Brief :: Statistics Control Class
		* @Comment :: 통계 컨트롤 클래스
		*/
		class alice_statistics_control extends alice_statistics_model {


				/**
				* 방문 데이터 입력
				*/
				function insert_visit( ){

					global $alice, $utility;

						if($utility->get_cookie('alice_visit_ip') != $_SERVER['REMOTE_ADDR']){

							$utility->set_cookie('alice_visit_ip', $_SERVER['REMOTE_ADDR'], 86400); // 하루동안 저장

							$tmp_row = $this->query_fetch(" select max(`no`) as `max_no` from `".$this->visit_table."` ");

							$visit_no = $tmp_row['max_no'] + 1;

							// $_SERVER 배열변수 값의 변조를 이용한 SQL Injection 공격을 막는 코드입니다. 110810
							$remote_addr = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
							$referer     = mysql_real_escape_string($_SERVER['HTTP_REFERER']);
							$user_agent  = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);

							$result = $this->_query(" insert `".$this->visit_table."` ( `no`, `visit_ip`, `visit_date`, `visit_time`, `visit_referer`, `visit_referer_cnt`, `visit_agent` ) values ( '".$visit_no."', '".$remote_addr."', '".$alice['time_ymd']."', '".$alice['time_his']."', '".$referer."', 1, '".$user_agent."' ) ", false);

							if($result) {

								// 1개월 이내 데이터 검색해서 중복되는 ip, referer 쿼리 => 카운트 업데이트
								//$get_duplicate = $this->query_fetch(" select * from `alice_visit` where ( `visit_date` > LAST_DAY(now() - interval 1 month) and `visit_date` <= LAST_DAY(now()) ) and `visit_ip` = '".$remote_addr."' ");
								$this->_query(" update `".$this->visit_table."` set `visit_ip_cnt` = `visit_ip_cnt`+1 where ( `visit_date` > LAST_DAY(now() - interval 1 month) and `visit_date` <= LAST_DAY(now()) ) and `visit_ip` = '".$remote_addr."' ");
								//$get_duplicate = $this->query_fetch(" select * from `alice_visit` where ( `visit_date` > LAST_DAY(now() - interval 1 month) and `visit_date` <= LAST_DAY(now()) ) and `visit_referer` = '".$referer."' ");
								$this->_query(" update `".$this->visit_table."` set `visit_referer_cnt` = `visit_referer_cnt`+1 where ( `visit_date` > LAST_DAY(now() - interval 1 month) and `visit_date` <= LAST_DAY(now()) ) and `visit_referer` = '".$referer."' ");

								$sum_result = $this->_query(" insert `".$this->visit_sum_table."` ( `visit_count`, `visit_date`) values ( 1, '".$alice['time_ymd']."' ) ", false);

								// DUPLICATE 오류가 발생한다면 이미 날짜별 행이 생성되었으므로 UPDATE 실행
								if (!$sum_result) {
									$this->_query(" update `".$this->visit_sum_table."` set `visit_count` = visit_count + 1 where `visit_date` = '".$alice['time_ymd']."' ");
								}

								// 오늘
								$row = $this->query_fetch(" select `visit_count` as cnt from `".$this->visit_sum_table."` where `visit_date` = '".$alice['time_ymd']."' ");
								$visit_today = $row['cnt'];

								// 어제
								$row = $this->query_fetch(" select `visit_count` as cnt from `".$this->visit_sum_table."` where `visit_date` = DATE_SUB('".$alice['time_ymd']."', INTERVAL 1 DAY) ");
								$visit_yesterday = $row['cnt'];

								// 최근 1주일
								$row = $this->query_fetch(" select `visit_count` as cnt from `".$this->visit_sum_table."` where `visit_date` > DATE_ADD(now(), INTERVAL -7 DAY) ");
								$visit_week = $row['cnt'];

								// 최대
								$row = $this->query_fetch(" select max(`visit_count`) as cnt from `".$this->visit_sum_table."` ");
								$visit_max = $row['cnt'];

								// 전체
								$row = $this->query_fetch(" select sum(`visit_count`) as total from `".$this->visit_sum_table."` "); 
								$visit_sum = $row['total'];

								// 가장 많이 접속한 날짜
								$row = $this->query_fetch(" select * from `".$this->visit_sum_table."` order by `visit_count` desc limit 1 ");
								$visit_date = $row['visit_date'];

								// 가장 많이 접속한 요일
								$row_visit_date = explode('-',$visit_date);
								$row_visit_ddate = date("w", mktime("0","0","0",$row_visit_date[1],$row_visit_date[2],$row_visit_date[0]));	// 1:월,2:화,3:수,4:목,5:금,6:토.7:일  
								$visit_weeks = $this->week_string[$row_visit_ddate];


								$visit = "today:$visit_today,yesterday:$visit_yesterday,1week:$visit_week,max:$visit_max,total:$visit_sum,max_date:$visit_date,max_week:$visit_weeks";

								// 기본설정 테이블에 방문자수를 기록한 후 
								// 방문자수 테이블을 읽지 않고 출력한다.
								// 쿼리의 수를 상당부분 줄임
								$this->_query(" update `".$this->config_table."` set `visit_count` = '".$visit."' ");

							}	// insert result if end.


						}	// cookie check if end.

				}


				/**
				* 구글 데이터 업데이트
				*/
				function google_updates( $vals ) {

					global $utility;
				
						$val = $utility->QueryString($vals);

						$query = $this->query_fetch(" select * from `".$this->analytics_table."` where `kind` = '".$vals['kind']."' and `sdate` = '".$vals['sdate']."' and `edate` = '".$vals['edate']."' ");

						if($query['no']) {	// 기존 정보가 있다면 업데이트
							$vals['update_time'] = date('Y-m-d H:i:s');
							$val = $utility->QueryString($vals);
							$result = $this->_query( " update `".$this->analytics_table."` set ".$val." where `no` = '".$query['no']."' " );
						} else {	 // 없다면 입력
							$vals['regist_time'] = date('Y-m-d H:i:s');
							$vals['update_time'] = date('Y-m-d H:i:s');
							$val = $utility->QueryString($vals);
							$result = $this->_query(" insert `".$this->analytics_table."` set " . $val );
						}


					return $result;

				}



		}	// class end.
?>