<?php
		/**
		* /application/nad/statistics/model/alice_statistics_model.class.php
		* @author Harimao
		* @since 2013/06/19
		* @last update 2015/04/03
		* @Module v3.5 ( Alice ) - s1.0
		* @Brief :: Statistics Model Class
		* @Comment :: 통계 모델 클래스
		*/
		class alice_statistics_model extends DBConnection {

			var $statistics_table	= "alice_statistics";
			var $visit_table			= "alice_visit";
			var $visit_sum_table	= "alice_visit_sum";
			var $visit_page_table	= "alice_visit_page";
			var $config_table		= "alice_config";
			var $analytics_table	= "alice_analytics";

			var $update_hours		= 2; // 오늘 데이터는 2시간 단위로 갱신
			var $delete_month		= 1; // 최근 업데이트날짜가 1개월이 지난 데이터는 삭제
			var $configs = array();
			var $infos = null;

			var $week_string		= array( 0 => "월", 1 => "화", 2 => "수", 3 => "목", 4 => "금", 5 => "토", 6 =>"일" );

			var $page_view_arr = array( "main" => "메인", "member" => "회원", "company" => "기업서비스", "individual" => "개인서비스", "alba" => "채용정보", "resume" => "인재정보", "service" => "서비스안내", "notice" => "공지사항", "board" => "커뮤니티", "search" => "통합검색" );

			var $success_code = array(
					'0000' => '',
			);
			var $fail_code = array(
					'0000' => '로그 분석 데이터 로딩중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);

				// visit_sum 테이블 데이터 추출(단수) :: 날짜 기준
				function get_visit_sum( $visit_date ){

						if(!$visit_date || $visit_date=='') return false;

						$query = " select * from `".$this->visit_sum_table."` where `visit_date` = '".$visit_date."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 사이트 접속현황 추출
				function get_visits( ){

					global $env;

						$visit_info = explode(',',$env['visit_count']);
						$visit_count = count($visit_info);

						$result = array();

						for($i=0;$i<$visit_count;$i++){
							$visit_field = explode(':',$visit_info[$i]);
							switch($visit_field[0]){
								case 'max_date':	// 가장 많이 접속한 날짜
									$max_date = explode('-',$visit_field[1]);
									$result[$visit_field[0]] = $max_date[0] . "년 " . $max_date[1] . "월 " . $max_date[2] . "일";
								break;
								case 'max_week':
									$result[$visit_field[0]] = $visit_field[1] . "요일";
								break;
								default:
									$result[$visit_field[0]] = $visit_field[1];
								break;
							}
						}


					return $result;

				}


				/**
				* 최근 일주일 방문자 통계
				* Bar, Pie chart 등 지정된 형태로 출력한다.
				*/
				function week_statistics( $type ){

					global $alice;

						if(!$type || $type=='') return false;

						include_once $alice['modules_path'] . "/chart/open-flash-chart/php-ofc-library/open_flash_chart_object.php";
						include_once $alice['modules_path'] . "/chart/open-flash-chart/php-ofc-library/open-flash-chart.php";


						$week_data = new bar_3d( 75, '#0080ff' );
						$week_data->key( '방문자수', 11 );
						
						$g = new graph();

					
						$time = time();

						$visit_range = 0;
						$max_count = 0;
						$visit_total = 0;
						$pie_datas = array();
						for($i=6;$i>=0;$i--){
							$week_date = date("Y-m-d",strtotime("-".$i." day", $time));
							$week_arr[] = $week_date;
							$visit_sum = $this->get_visit_sum($week_date);
							$visit_count = ($visit_sum) ? $visit_sum['visit_count'] : 0;
							$week_data->data[] = $visit_count;
							$max_count = ($visit_count >= $max_count ) ? $visit_count : $max_count;
							$visit_total += $visit_count;
							$pie_datas[] = $visit_count;

						}

						//$max_count = ($visit_range == 0) ? 5 : $visit_range;

						if($max_count > 50) 
							$range = 10;//round($max_count /10, -1);
						else if($max_count > 15) 
							$range = 5;
						else if($max_count < 10) 
							$range = 2;
						else 
							$range = 3;

					
						switch($type){

							## 3d bar chart
							case 'bar_3d':

								$g->data_sets[] = $week_data;
								$g->set_x_axis_3d( 7 );
								$g->x_axis_colour( '#909090', '#ADB5C7' );
								$g->y_axis_colour( '#909090', '#ADB5C7' );
								$g->set_x_labels( $week_arr );	 // array( '일','월','화','수','목','금','토' )
								$g->set_x_label_style( 13 );
								$g->set_y_max( round($max_count+10,-1) );
								$g->y_label_steps( $range );
								$g->set_tool_tip( '#val# 명' );
								//$g->set_y_label_style( 'none' );
								//$g->set_num_decimals( 3 );
								$g->set_width( '100%' );
								$g->set_height( 450 );
								$g->bg_colour = '#ffffff';
								$g->set_output_type('js');

								$result = $g->render();

							break;

							## pie chart
							case 'pie':

								$pie_datas_cnt = count($pie_datas);
								for($i=0;$i<$pie_datas_cnt;$i++){
									$pie_data[] = @round(($pie_datas[$i] * 100) / $visit_total);
								}

								$g = new graph();

								$g->pie(60,'#505050','{font-size: 12px; color: #404040;');
								$g->pie_values( $pie_data, $week_arr );
								$g->pie_slice_colours( array('#ff0000','#ff8040','#ffff00','#008000','#0000ff','#0000a0','#8000ff') );
								$g->set_tool_tip( '#val#%' );

								$g->set_width( '100%' );
								$g->set_height( 450 );
								$g->bg_colour = '#ffffff';

								$g->set_output_type('js');

								$result = $g->render();

							break;

							## bar line mix chart
							case 'bar_line':

								/* 예시 입니다 필요한 경우 참고하여 사용하세요.
								$data_1 = array();
								$data_2 = array();
								for( $i=0; $i<7; $i++ ){
									$data_1[] = rand(2,5);
									$data_2[] = rand(5,9);
								}
								$g = new graph();

								$g->set_data( $data_1 );
								$g->bar( 50, '#ff0000', '', 10 );

								$g->set_data( $data_2 );
								$g->line_dot( 3, 5, '#79bcff', '요일별 등락', 10 );    // <-- 3px thick + dots

								$g->set_x_labels( array( '일','월','화','수','목','금','토' ) );
								$g->set_x_label_style( 15 );

								$g->set_y_max( 10 );
								$g->y_label_steps( 2 );

								$g->set_width( '100%' );
								$g->set_height( 450 );
								$g->bg_colour = '#ffffff';

								$g->set_output_type('js');
								echo $g->render();
								*/

							break;

						}	// switch end.

					
					return $result;

				}


				/**
				* 접속 도메인 TOP10 리스트 추출
				* 오늘 / 어제 / 이번주
				*/
				function domain_top10( $date, $order="" ){

					global $alice, $utility;

						if(!$date || $date=='') return false;

						$_order = ($order) ? $order : " order by `no`";

						$result = array();

						switch($date){
							
							## 오늘 접속 도메인
							case 'today':
								// select * from g4_visit where vi_date between '2013-06-21' and '2013-06-21' order by vi_id desc limit 0, 15 
								// $this->_query(" select * from `".$this->visit_table."` where `visit_date` = now() ");
								$get_data = $this->query_fetch_rows(" select * from `".$this->visit_table."` where `visit_date` = '".$alice['time_ymd']."' order by `visit_referer_cnt` desc limit 10 ");
							break;

							## 어제 접속 도메인
							case 'yesterday':
								$get_data = $this->query_fetch_rows(" select * from `".$this->visit_table."` where `visit_date` = date_add('".$alice['time_ymd']."', interval -1 day) order by `visit_referer_cnt` desc limit 10 ");
							break;
							
							## 이번주 접속 도메인
							case 'week':

								$time = time();
								$week_start = "";	// 이번주 시작
								$week_end = "";	// 이번주 종료 (오늘 까지의 데이터를 뽑아야 하니 오늘이겠지?!)
								for($i=6;$i>=0;$i--){
									$week_date = date("Y-m-d",strtotime("-".$i." day", $time));
									if($i==6) $week_start = $week_date;
									if($i==0) $week_end = $week_date;
								}

								$get_data = $this->query_fetch_rows(" select distinct visit_referer, visit_referer_cnt from `".$this->visit_table."` where `visit_date` between '".$week_start."' and '".$week_end."' order by `visit_referer_cnt` desc limit 10 ");

							break;

							## 이번달 접속 도메인
							case 'month':
								$get_data = $this->query_fetch_rows(" select distinct visit_referer, visit_referer_cnt from `alice_visit` where ( `visit_date` > LAST_DAY(now() - interval 1 month) and `visit_date` <= LAST_DAY(now()) ) order by `visit_referer_cnt` desc limit 10 ");
							break;

						}	// switch end.


						$i = 0;
						foreach($get_data as $key => $val){
							if($val['visit_referer']){
								$result[$i]['visit_referer'] = "<a href=\"".$val['visit_referer']."\" target=\"_blank\" title=\"".$val['visit_referer']."\">".$utility->str_cut($val['visit_referer'],50)."</a>";
							} else {
								$result[$i]['visit_referer'] = "직접입력 또는 즐겨찾기";
							}
							$result[$i]['visit_referer_cnt'] = $val['visit_referer_cnt'];
						$i++;
						}

					
					return $result;

				}


				/**
				* 접속 IP TOP10 리스트 추출
				* 오늘 / 어제 / 이번주
				*/
				function ip_top10( $date, $order="" ){

					global $alice, $utility;

						if(!$date || $date=='') return false;

						$_order = ($order) ? $order : " order by `no`";

						$result = array();

						switch($date){
							
							## 오늘 접속 IP
							case 'today':
								$get_data = $this->query_fetch_rows(" select * from `".$this->visit_table."` where `visit_date` = '".$alice['time_ymd']."' order by `visit_ip_cnt` desc limit 10 ");
							break;

							## 어제 접속 IP
							case 'yesterday':
								$get_data = $this->query_fetch_rows(" select * from `".$this->visit_table."` where `visit_date` = date_add('".$alice['time_ymd']."', interval -1 day) order by `visit_ip_cnt` desc limit 10 ");
							break;
							
							## 이번주 접속 IP
							case 'week':

								$time = time();
								$week_start = "";	// 이번주 시작
								$week_end = "";	// 이번주 종료 (오늘 까지의 데이터를 뽑아야 하니 오늘이겠지?!)
								for($i=6;$i>=0;$i--){
									$week_date = date("Y-m-d",strtotime("-".$i." day", $time));
									if($i==6) $week_start = $week_date;
									if($i==0) $week_end = $week_date;
								}

								$get_data = $this->query_fetch_rows(" select distinct visit_ip, visit_ip_cnt from `".$this->visit_table."` where `visit_date` between '".$week_start."' and '".$week_end."' order by `visit_ip_cnt` desc limit 10 ");

							break;

							## 이번달 접속 IP
							case 'month':
								$get_data = $this->query_fetch_rows(" select distinct visit_ip, visit_ip_cnt from `alice_visit` where ( `visit_date` > LAST_DAY(now() - interval 1 month) and `visit_date` <= LAST_DAY(now()) ) order by `visit_ip_cnt` desc limit 10 ");
							break;

						}	// switch end.


						$i = 0;
						foreach($get_data as $key => $val){
							$result[$i]['visit_ip'] = $val['visit_ip'];
							$result[$i]['visit_ip_cnt'] = $val['visit_ip_cnt'];
						$i++;
						}

					
					return $result;

				}


				/**
				* 날짜별 리스트 추출 (검색)
				* 
				*/
				function statistics_search( $type, $print_type, $start_date="", $end_date="" ){

					global $alice;

						if(!$type || $type=='') return false;
						if(!$print_type || $print_type=='') return false;

						include_once $alice['modules_path'] . "/chart/open-flash-chart/php-ofc-library/open_flash_chart_object.php";
						include_once $alice['modules_path'] . "/chart/open-flash-chart/php-ofc-library/open-flash-chart.php";

						
						$time_data = new bar_3d( 75, '#0080ff' );
						$time_data->key( '방문자수', 11 );

						$g = new graph();

						$max = 0;
						$sum_count = 0;

						switch($type){

							## 시간별 통계
							case 'time':

								$query = $this->query_fetch_rows(" select SUBSTRING(`visit_time`,1,2) as `visit_hour`, count(`no`) as cnt from `".$this->visit_table."` where `visit_date` between '".$start_date."' and '".$end_date."' group by `visit_hour` order by `visit_hour` ");
								$query_cnt = count($query);

								$get_data = array();

								$j = 0;
								foreach($query as $val){
									$arr[$val['visit_hour']] = $val['cnt'];
									if($val['cnt'] > $max) $max = $val['cnt'];
									$sum_count += $val['cnt'];
								$j++;
								}

								$k = 0;
								if($j){
									for($i=0; $i<24; $i++){
										$hour = sprintf('%02d', $i);
										$count = (int)$arr[$hour];

										$rate = ($count / $sum_count * 100);
										$s_rate = number_format($rate, 1);

										$bar = (int)($count / $max * 100);

										$list = ($k++%2);

										$get_data['hour'][$i] = $hour;
										$get_data['data'][$i] = number_format($count);
										$get_data['rate'][$i] = number_format($s_rate);
										$time_data->data[] = number_format($count);
									}
								}

							break;

							## 요일별 통계
							case 'week':

								$query = $this->query_fetch_rows(" select WEEKDAY(`visit_date`) as weekday_date, SUM(`visit_count`) as cnt from `".$this->visit_sum_table."` where `visit_date` between '".$start_date."' and '".$end_date."' group by `weekday_date` order by `weekday_date` "); 
								$query_cnt = count($query);

								$get_data = array();

								$j = 0;
								foreach($query as $val){
									$arr[$val['weekday_date']] = $val['cnt'];
									$sum_count += $val['cnt'];
								$j++;
								}

								$k = 0;
								if($j){
									for($i=0; $i<7; $i++){
										$count = (int)$arr[$i];

										$rate = ($count / $sum_count * 100);
										$s_rate = number_format($rate, 1);

										$list = ($k++%2);

										$get_data['hour'][$i] = $this->week_string[$i];
										$get_data['data'][$i] = number_format($count);
										$get_data['rate'][$i] = number_format($s_rate);
										$time_data->data[] = $count;
									}
								}

							break;

							## 일별 통계
							case 'date':
							
								$query = $this->query_fetch_rows(" select `visit_date`, `visit_count` as cnt from `".$this->visit_sum_table."` where `visit_date` between '".$start_date."' and '".$end_date."' order by `visit_date` asc "); 
								$query_cnt = count($query);

								$get_data = array();

								$j = 0;
								foreach($query as $val){
									$arr[$val['visit_date']] = $val['cnt'];
									if($val['cnt'] > $max) $max = $val['cnt'];
									$sum_count += $val['cnt'];
								$j++;
								}


								$i = 0;
								$k = 0;
								if(count($arr)){
									foreach($arr as $key => $val){
										$count = $val;

										$rate = ($count / $sum_count * 100);
										$s_rate = number_format($rate, 1);
										
										$list = ($k++%2);

										$get_data['hour'][$i] = $key;
										$get_data['data'][$i] = number_format($count);
										$get_data['rate'][$i] = number_format($s_rate);
										$time_data->data[] = $count;

									$i++;
									}
								}

							break;

							## 월별 통계
							case 'month':

								$query = $this->query_fetch_rows(" select SUBSTRING(`visit_date`,1,7) as visit_month, SUM(`visit_count`) as cnt from `".$this->visit_sum_table."` where `visit_date` between '".$start_date."' and '".$end_date."' group by `visit_month` order by `visit_month` asc  "); 
								$query_cnt = count($query);

								$get_data = array();

								$j = 0;
								foreach($query as $val){
									$arr[$val['visit_month']] = $val['cnt'];
									if($val['cnt'] > $max) $max = $val['cnt'];
									$sum_count += $val['cnt'];
								$j++;
								}


								$i = 0;
								$k = 0;
								if(count($arr)){
									foreach($arr as $key => $val){
										$count = $val;

										$rate = ($count / $sum_count * 100);
										$s_rate = number_format($rate, 1);
										
										$list = ($k++%2);

										$get_data['hour'][$i] = $key;
										$get_data['data'][$i] = number_format($count);
										$get_data['rate'][$i] = number_format($s_rate);
										$time_data->data[] = $count;

									$i++;
									}
								}

							break;


						}	// type switch end.

						/*
						if($sum_count >= 50) 
							$range = 8;//round($max_count /10, -1);
						else if($sum_count >= 15) 
							$range = 5;
						else if($sum_count < 10) 
							$range = 2;
						else 
							$range = 3;
						*/

						if($sum_count >= 50){
							$range = $sum_count + 20; //round($sum_count /10, -1);
							$y_steps = floor( ($sum_count / $range)+5 );
						} else if($sum_count >= 15){
							$range = $sum_count + 5;
							$y_steps = 5;
						} else if($sum_count >= 10){
							$range = $sum_count + 5;
							$y_steps = 5;
						} else {
							$range = $sum_count + 3;
							$y_steps = 3;
						}

						//echo $sum_count."@".$range."@".$y_steps." <==<Br/>";
						//exit;


						switch($print_type){

							## 3d bar chart
							case 'bar_3d':

								$g->data_sets[] = $time_data;
								$g->set_x_axis_3d( 7 );
								
								$g->x_axis_colour( '#909090', '#ADB5C7' );
								$g->y_axis_colour( '#909090', '#ADB5C7' );

								$g->set_x_labels( $get_data['hour'] );	
								$g->set_x_label_style( 13 );
 								//$g->set_y_max( round($max_count+10,-1) );
								//$g->set_y_max( round($sum_count+5,-3) );
								$g->set_y_max( $range );

								$g->y_label_steps( $y_steps );
								$g->set_tool_tip( '#val# 명' );

								//$g->set_y_label_style( 'none' );
								//$g->set_num_decimals( 3 );

								$g->set_width( '100%' );
								$g->set_height( 450 );
								$g->bg_colour = '#ffffff';
								$g->set_output_type('js');

								$result = $g->render();

							break;

							## pie chart
							case 'pie':

								$g = new graph();

								$g->pie(60,'#505050','{font-size: 12px; color: #404040;');
								$g->pie_values( $get_data['rate'], $get_data['hour'] );
								$g->pie_slice_colours( array('#ff0000','#ff8040','#ffff00','#008000','#0000ff','#0000a0','#8000ff','#ff0000','#ff8040','#ffff00','#008000','#0000ff','#0000a0','#8000ff','#ff0000','#ff8040','#ffff00','#008000','#0000ff','#0000a0','#8000ff') );
								$g->set_tool_tip( '#val#%' );

								$g->set_width( '100%' );
								$g->set_height( 450 );
								$g->bg_colour = '#ffffff';

								$g->set_output_type('js');

								$result = $g->render();

							break;


							## bar line mix chart
							case 'bar_line':

								$g->set_data( $get_data['data'] );
								$g->bar( 50, '#ff0000', '', 10 );

								$g->set_data( $get_data['data'] );
								$g->line_dot( 3, 5, '#79bcff', '일별 등락', 10 );    // <-- 3px thick + dots

								$g->set_x_labels( $get_data['hour'] );
								$g->set_x_label_style( 15 );

								$g->set_y_max( count(10,-1) );
								$g->y_label_steps( 2 );

								$g->set_tool_tip( '#val# 명' );

								$g->set_width( '100%' );
								$g->set_height( 450 );
								$g->bg_colour = '#ffffff';

								$g->set_output_type('js');
								
								$result = $g->render();

							break;

							## area chart
							case 'area':
					

								$g->set_data( $time_data->data );
								$g->area_hollow( 2, 3, 25, '#007bf7', '방문자수', 12, '#79bcff' );

								$g->set_x_labels( $get_data['hour'] );
								$g->set_x_label_style( 15, '#000000', 0, 1 );
								$g->set_x_axis_steps( 2 );
								$g->x_axis_colour( '#909090', '#ADB5C7' );
								$g->y_axis_colour( '#909090', '#ADB5C7' );

								$g->set_y_min( 0 );
								//$g->set_y_max( round($sum_count+5,-3) );
								$g->set_y_max( $range );
								
								$g->set_tool_tip( '#val# 명' );

								$g->y_label_steps( $range );

								$g->set_width( '100%' );
								$g->set_height( 450 );
								$g->bg_colour = '#ffffff';

								$g->set_output_type('js');

								$result = $g->render();


							break;
						}


					return $result;

				}


				/**
				* 도메인/브라우저별 추출
				* 
				*/
				function statistics_IO( $type, $start_date="", $end_date="", $page_rows="", $page="" ){

					global $alice, $utility;

						if(!$type || $type=='') return false;

						$result = array();

						switch($type){

							## 접속전 도메인
							case 'domain':

								$domain = $_GET['domain'];

								if($domain){
									
									$_query = " select * from `".$this->visit_table."` where `visit_date` between '".$start_date."' and '".$end_date."' and `visit_referer` like '%".$domain."%' ";

									$total_count = $this->_queryR($_query);
									
									$page = ($page) ? $page : 1;
									$page_rows = ($page_rows) ? $page_rows : 17;
									$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
									if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
									$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

									$_query .= " order by `no` desc limit $from_record, $page_rows ";

									$query = $this->query_fetch_rows($_query);

									$i = 0;
									foreach($query as $val){
										$browser = $utility->get_brow($val['visit_agent']);
										$os = $utility->get_os($val['visit_agent']);

										$referer = "";
										$url = "";
										if ($val['visit_referer']) {
											$referer = $utility->get_text($utility->cut_str($val['visit_referer'], 255, ""));
											$referer = urldecode($referer);
											if (strtolower($alice['charset']) == 'utf-8') {
												if (!$utility->is_utf8($referer)) {
													$referer = iconv('euc-kr', 'utf-8', $referer);
												}
											}
											else {
												if ($utility->is_utf8($referer)) {
													$referer = iconv('utf-8', 'euc-kr', $referer);
												}
											}

											$url = str_replace(array("<", ">"), array("&lt;", "&gt;"), $referer);
										}

										$ip = $val['visit_ip'];
										if($browser == '기타') $browser = "<span title='".$val['visit_agent']."'>".$browser."</span>";
										if($os == '기타') $os = "<span title='".$val['visit_agent']."'>".$os."</span>";
										
										$list = ($i%2);

										$result[$i]['ip'] = $ip;
										$result[$i]['url'] = ($url) ? "<a href=\"".$url."\" target=\"_blank\">".$url."</a>" : "직접입력 또는 즐겨찾기";
										$result[$i]['browser'] = $browser;
										$result[$i]['os'] = $os;
										$result[$i]['wdate'] = $val['visit_date']." ".$val['visit_time'];

									$i++;
									}


								} else {

									$query = $this->query_fetch_rows(" select * from `".$this->visit_table."` where `visit_date` between '".$start_date."' and '".$end_date."' ");
									$query_cnt = count($query);

									$max = 0;
									$sum_count = 0;
									
									foreach($query as $val){
										preg_match("/^http[s]*:\/\/([\.\-\_0-9a-zA-Z]*)\//", $val['visit_referer'], $match);
										$s = $match[1];
										$s = preg_replace("/^(www\.|search\.|dirsearch\.|dir\.search\.|dir\.|kr\.search\.|myhome\.)(.*)/", "\\2", $s);
										$arr[$s]++;
										if ($arr[$s] > $max) $max = $arr[$s];
										$sum_count++;
									}

									$j = 0;
									$i = 0;
									$k = 0;
									$save_count = -1;
									if(count($arr)){
										arsort($arr);
										foreach($arr as $key => $val){
											$count = $arr[$key];
											if($save_count != $count){
												$i++;
												$no = $i;
												$save_count = $count;
											} else {
												$no = "";
											}

											$rate = ($count / $sum_count * 100);
											$s_rate = number_format($rate, 1);
											
											$list = ($k++%2);

											$result['result'][$j]['key'] = ($key) ? "<a href=\"./?mode=search&type=".$type."&domain=".$key."\">".$key."</a>" : "직접입력 또는 즐겨찾기";
											$result['result'][$j]['count'] = $count;
											$result['result'][$j]['rate'] = $s_rate;

										$j++;
										}
									}

									$result['total_count'] = $sum_count;

								}

							break;

							## 접속 ip
							case 'ip':
									
								$_query = " select * from `".$this->visit_table."` where `visit_date` between '".$start_date."' and '".$end_date."' ";

								$total_count = $this->_queryR($_query);

								$page = ($page) ? $page : 1;
								$page_rows = ($page_rows) ? $page_rows : 17;
								$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
								if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
								$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

								$_query .= " order by `no` desc limit $from_record, $page_rows ";

								$query = $this->query_fetch_rows($_query);

								$i = 0;
								$sum_count = 0;
								foreach($query as $val){
									$browser = $utility->get_brow($val['visit_agent']);
									$os = $utility->get_os($val['visit_agent']);

									$referer = "";
									$url = "";
									if ($val['visit_referer']) {
										$referer = $utility->get_text($utility->cut_str($val['visit_referer'], 255, ""));
										$referer = urldecode($referer);
										if (strtolower($alice['charset']) == 'utf-8') {
											if (!$utility->is_utf8($referer)) {
												$referer = iconv('euc-kr', 'utf-8', $referer);
											}
										}
										else {
											if ($utility->is_utf8($referer)) {
												$referer = iconv('utf-8', 'euc-kr', $referer);
											}
										}

										$url = str_replace(array("<", ">"), array("&lt;", "&gt;"), $referer);
									}

									$ip = $val['visit_ip'];
									if($browser == '기타') $browser = "<span title='".$val['visit_agent']."'>".$browser."</span>";
									if($os == '기타') $os = "<span title='".$val['visit_agent']."'>".$os."</span>";
									
									$list = ($i%2);

									$result['result'][$i]['ip'] = $ip;
									$result['result'][$i]['url'] = ($url) ? "<a href=\"".$url."\" target=\"_blank\">".$url."</a>" : "직접입력 또는 즐겨찾기";
									$result['result'][$i]['browser'] = $browser;
									$result['result'][$i]['os'] = $os;
									$result['result'][$i]['wdate'] = $val['visit_date']." ".$val['visit_time'];

								$i++;
								}

								$result['total_count'] = $total_count;

							break;

							## 접속 브라우저
							case 'browser':
								
								$query = $this->query_fetch_rows(" select * from `".$this->visit_table."` where `visit_date` between '".$start_date."' and '".$end_date."' ");
								$query_cnt = count($query);

								$max = 0;
								$sum_count = 0;
								foreach($query as $val){
									$browser = $utility->get_brow($val['visit_agent']);
									$arr[$browser]++;
									if ($arr[$browser] > $max) $max = $arr[$browser];
									$sum_count++;
								}

								$j = 0;
								$i = 0;
								$k = 0;
								$save_count = -1;
								if (count($arr)) {
									arsort($arr);
									foreach ($arr as $key=>$value) {
										$count = $arr[$key];
										if ($save_count != $count) {
											$i++;
											$no = $i;
											$save_count = $count;
										} else {
											$no = "";
										}

										$rate = ($count / $sum_count * 100);
										$s_rate = number_format($rate, 1);
									
										$list = ($k++%2);

										$result['result'][$j]['key'] = $key;
										$result['result'][$j]['count'] = $count;
										$result['result'][$j]['rate'] = $s_rate;

									$j++;
									}
								}

								$result['total_count'] = $sum_count;

							break;

							## 접속 OS
							case 'os':

								$query = $this->query_fetch_rows(" select * from `".$this->visit_table."` where `visit_date` between '".$start_date."' and '".$end_date."' ");
								$query_cnt = count($query);

								$max = 0;
								$sum_count = 0;
								foreach($query as $val){
									$browser = $utility->get_os($val['visit_agent']);
									$arr[$browser]++;
									if ($arr[$browser] > $max) $max = $arr[$browser];
									$sum_count++;
								}

								$j = 0;
								$i = 0;
								$k = 0;
								$save_count = -1;
								if (count($arr)) {
									arsort($arr);
									foreach ($arr as $key=>$value) {
										$count = $arr[$key];
										if ($save_count != $count) {
											$i++;
											$no = $i;
											$save_count = $count;
										} else {
											$no = "";
										}

										$rate = ($count / $sum_count * 100);
										$s_rate = number_format($rate, 1);
									
										$list = ($k++%2);

										$result['result'][$j]['key'] = $key;
										$result['result'][$j]['count'] = $count;
										$result['result'][$j]['rate'] = $s_rate;

									$j++;
									}
								}

								$result['total_count'] = $sum_count;

							break;

						}	// swich end.

						if($page_rows){
							$total_page  = ceil($result['total_count'] / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$result['total_page'] = $total_page;
						}

					
					return $result;

				}


				/**
				* Google analytics API 연동 설정
				* 별도의 Table 에서 데이터 추출
				*/
				function google_infos( $kind, $sdate, $edate ) {

						$result = array();

						$query = $this->query_fetch(" select * from `".$this->analytics_table."` where `kind` = '".$kind."' and `sdate` = '".$sdate."' and `edate` = '".$edate."' ");

						if($query) {
							$stamp = strtotime($query['update_time']);
							if(date('Y-m-d')==date('Y-m-d', $stamp)) { // 오늘날짜 로그 검색시
								$hours = floor((time()-strtotime($query['update_time'])) / 3600);
								if($hours>2) $query = null; // 특정 시간단위로만 로딩 ( 2시간 간격으로 갱신 )
							} else if(strtotime($query['edate'].' 23:59:59')>$stamp) {
								$query = null;
							}
							if($query) {
								$result['titles'] = unserialize($query['titles']);
								$result['datas'] = unserialize($query['datas']);
								$result['max'] = $query['max'];
							}
						} else {
							$result = false;
						}


					return $result;

				}


				function google_analytics_chart( $infos, $kind, $mode, $width, $height ) {

					global $alice;


						include_once $alice['modules_path'] . "/chart/open-flash-chart/php-ofc-library/open_flash_chart_object.php";
						include_once $alice['modules_path'] . "/chart/open-flash-chart/php-ofc-library/open-flash-chart.php";

						
						$max = ($infos['max']) ? $infos['max'] : 5;

						if($max > 50) 
							$range = 10;
						else if($max > 15) 
							$range = 5;
						else if($max < 10) 
							$range = 2;
						else 
							$range = 3;

						switch($mode){
							case 'area_chart':

								$g = new graph();

								$g->set_data( $infos['datas'] );
								$g->area_hollow( 2, 3, 25, '#007bf7', '방문자수', 12, '#79bcff' );

								$g->set_x_labels( $infos['titles'] );
								$g->set_x_label_style( 13, '#000000', 1, 1 );
								$g->set_x_axis_steps( 2 );
								$g->x_axis_colour( '#909090', '#ADB5C7' );
								$g->y_axis_colour( '#909090', '#ADB5C7' );

								$g->set_y_min( 0 );
								$g->set_y_max( round($max+5,-1) );
								
								$g->set_tool_tip( '#val# 명' );

								$g->y_label_steps( $range );

								$g->set_width( $width );
								$g->set_height( $height );
								$g->bg_colour = '#ffffff';

								$g->set_output_type('js');

								$result = $g->render();

							break;

							case 'pie_chart':
							
								$g = new graph();

								$g->pie(60,'#505050','{font-size: 12px; color: #404040;');
								$g->pie_values( $infos['datas'] ,$infos['titles'] );
								$g->pie_slice_colours( array('#0000ff','#ff0000','#ff8040','#ffff00','#008000','#0000a0','#8000ff') );
								$g->set_tool_tip( '#val#건' );

								$g->set_width( $width );
								$g->set_height( $height );
								$g->bg_colour = '#ffffff';

								$g->set_output_type('js');

								$result = $g->render();

							break;

							case 'bar_chart':

								$analytics_data = new bar_3d( 75, '#0080ff' );
								$analytics_data->key( '방문자 언어셋', 11 );

								$datas_cnt = count($infos['datas']);
								for($i=0;$i<$datas_cnt;$i++){
									$analytics_data->data[] = $infos['datas'][$i];
								}
								
								$g = new graph();
								$g->data_sets[] = $analytics_data;
								$g->set_x_axis_3d( 7 );
								$g->x_axis_colour( '#909090', '#ADB5C7' );
								$g->y_axis_colour( '#909090', '#ADB5C7' );
								$g->set_x_labels( $infos['titles'] );
								$g->set_x_label_style( 13 );
								$g->set_y_max( round($max+5,-1) );
								$g->y_label_steps( $range );
								$g->set_tool_tip( '#val#건' );
								//$g->set_y_label_style( 'none' );
								//$g->set_num_decimals( 3 );
								$g->set_width( $width );
								$g->set_height( $height );
								$g->bg_colour = '#ffffff';
								$g->set_output_type('js');

								$result = $g->render();

							break;

							case 'landing_chart':

								$analytics_data = new bar_3d( 75, '#0080ff' );
								$analytics_data->key( '페이지 현황', 11 );

								$datas_cnt = count($infos['datas']);
								for($i=0;$i<$datas_cnt;$i++){
									$analytics_data->data[] = $infos['datas'][$i];
								}
								
								$g = new graph();
								$g->data_sets[] = $analytics_data;
								$g->set_x_axis_3d( 7 );
								$g->x_axis_colour( '#909090', '#ADB5C7' );
								$g->y_axis_colour( '#909090', '#ADB5C7' );
								$g->set_x_labels( $infos['titles'] );
								$g->set_x_label_style( 13, '#000000', 1, 1 );
								$g->set_y_max( round($max+5,-1) );
								$g->y_label_steps( $range );
								$g->set_tool_tip( '#val#건' );
								//$g->set_y_label_style( 'none' );
								//$g->set_num_decimals( 3 );
								$g->set_width( $width );
								$g->set_height( $height );
								$g->bg_colour = '#ffffff';
								$g->set_output_type('js');

								$result = $g->render();

							break;

						}


					return $result;

				}

				// 페이지별 통계 수치
				function page_view_count( $vi_page ){

						if(!$vi_page || $vi_page == '') return false;

						$visit_page_query = " select DISTINCT `vi_page` from `".$this->visit_page_table."` ";

						$result = array();


				}


				// 관리자 메인 사이트 접속 통계 (최근1개월, 지난금요일, 오늘현재)
				function get_visits_main(){

					global $payment_control, $member_control, $alba_control, $alba_resume_control;

						$result = array();

						// 방문자
						$visit_month = $this->query_fetch(" select sum(`visit_count`) as month from `".$this->visit_sum_table."` where `visit_date` between '".date('Y-m-d',strtotime("-1 month"))."' and '".date('Y-m-d')."' ");
						$result['visit_month'] = ($visit_month['month']!=null) ? $visit_month['month'] : 0;	// 최근 1개월 방문자
						$visit_week = $this->query_fetch(" select sum(`visit_count`) as week from `".$this->visit_sum_table."` where `visit_date` between '".date('Y-m-d',strtotime("-1 week"))."' and '".date('Y-m-d')."' ");
						$result['visit_week'] = ($visit_week['week']!=null) ? $visit_week['week'] : 0;	// 최근 1주일 방문자
						$visit_today = $this->query_fetch(" select sum(`visit_count`) as today from `".$this->visit_sum_table."` where `visit_date` = '".date('Y-m-d')."' ");
						$result['visit_today'] = ($visit_today['today']!=null) ? $visit_today['today'] : 0;	// 오늘 현재 방문자

						// 회원수
						$member_month = $this->_queryR(" select * from `".$member_control->member_table."` where `mb_left` = '0' and `is_delete` = 0 and `mb_wdate` between '".date('Y-m-d',strtotime("-1 month"))."' and '".date('Y-m-d')."' ");
						$result['member_month'] = ($member_month) ? $member_month : 0;	// 최근 1개월 가입자
						$member_week = $this->_queryR(" select * from `".$member_control->member_table."` where `mb_left` = '0' and `is_delete` = 0 and `mb_wdate` between '".date('Y-m-d',strtotime("-1 week"))."' and '".date('Y-m-d')."' ");
						$result['member_week'] = ($member_week) ? $member_week : 0;	// 최근 1주일 가입자
						$member_today = $this->_queryR(" select * from `".$member_control->member_table."` where `mb_left` = '0' and `is_delete` = 0 and `mb_wdate` >= curdate() ");
						$result['member_today'] = ($member_today) ? $member_today : 0;	// 오늘 가입자

						// 정규직 등록수
						$alba_month = $this->_queryR(" select * from `".$alba_control->alba_table."` where `wr_wdate` between '".date('Y-m-d',strtotime("-1 month"))."' and '".date('Y-m-d')."' ");
						$result['alba_month'] = ($alba_month) ? $alba_month : 0;	// 최근 1개월 정규직 등록수
						$alba_week = $this->_queryR(" select * from `".$alba_control->alba_table."` where `wr_wdate` between '".date('Y-m-d',strtotime("-1 week"))."' and '".date('Y-m-d')."' ");
						$result['alba_week'] = ($alba_week) ? $alba_week : 0;	// 최근 1주일 정규직 등록수
						$alba_today = $this->_queryR(" select * from `".$alba_control->alba_table."` where `wr_wdate` >= curdate() ");
						$result['alba_today'] = ($alba_today) ? $alba_today : 0;	// 오늘 정규직 등록수

						// 이력서 등록수
						$resume_month = $this->_queryR(" select * from `".$alba_resume_control->resume_table."` where `wr_wdate` between '".date('Y-m-d',strtotime("-1 month"))."' and '".date('Y-m-d')."' ");
						$result['resume_month'] = ($resume_month) ? $resume_month : 0;	// 최근 1개월 정규직 등록수
						$resume_week = $this->_queryR(" select * from `".$alba_resume_control->resume_table."` where `wr_wdate` between '".date('Y-m-d',strtotime("-1 week"))."' and '".date('Y-m-d')."' ");
						$result['resume_week'] = ($resume_week) ? $resume_week : 0;	// 최근 1주일 정규직 등록수
						$resume_today = $this->_queryR(" select * from `".$alba_resume_control->resume_table."` where `wr_wdate` >= curdate() ");
						$result['resume_today'] = ($resume_today) ? $resume_today : 0;	// 오늘 정규직 등록수

						// 매출
						// SELECT *FROM `alice_payment` where `pay_pg` != 'admin' and `pay_service` is not null and `pay_status` = 1 and `is_delete` = 0
						$price_con = " where `pay_pg` != 'admin' and `pay_service` is not null and `pay_status` = 1 and `is_delete` = 0 ";
						$price_month = $this->query_fetch(" select sum(`pay_price`) as month from `".$payment_control->payment_table."` ".$price_con." and `pay_sdate` between '".date('Y-m-d',strtotime("-1 month"))."' and '".date('Y-m-d')."' ");
						$result['price_month'] = ($price_month['month']!=null) ? $price_month['month'] : 0;	// 최근 1개월 매출금액
						$price_week = $this->query_fetch(" select sum(`pay_price`) as week from `".$payment_control->payment_table."` ".$price_con." and `pay_sdate` between '".date('Y-m-d',strtotime("-1 week"))."' and '".date('Y-m-d')."' ");
						$result['price_week'] = ($price_week['week']!=null) ? $price_week['week'] : 0;	// 최근 1주일 매출금액
						$price_today = $this->query_fetch(" select sum(`pay_price`) as today from `".$payment_control->payment_table."` ".$price_con." and `pay_sdate` >= curdate() ");
						$result['price_today'] = ($price_today['today']!=null) ? $price_today['today'] : 0;	// 오늘 매출금액

						
					return $result;

				}


				/**
				* 구글 통계 출력 (ajax 로딩을 대체하여 속도를 높힌다)
				*/
				function google_draw( $mode, $sdate="", $edate="", $kind="", $width="100%", $height="250" ){

					global $alice, $env;

						$google_infos = $this->google_infos( $kind, $sdate, $edate);

						$ga = new gapi($env['google_id'], $env['google_pass']);
						
						$max = 0;
						$titles = $datas = array();

						switch($mode){

							## 접속자 수 출력 형태
							case 'area_chart':

								$ga->requestReportData($env['google_profile_id'], array($kind), array('visits'), 'date', null, $sdate, $edate);
								foreach($ga->getResults() as $result) {
									$dimensions = $result->getDimesions();
									array_push($titles, date('Y.m.d', strtotime($dimensions[$kind])));
									array_push($datas, $result->getVisits());
									if($max < $result->getVisits()) $max = $result->getVisits();
								}

							break;

							## 접속 경로, 방문 형태, 접속 국가, 지역 출력 형태
							case 'pie_chart':

								$ga->requestReportData($env['google_profile_id'], array($kind), array('visits'), '-visits', null, $sdate, $edate);
								foreach($ga->getResults() as $result) {
									$dimensions = $result->getDimesions();
									array_push($titles, $dimensions[$kind]);
									array_push($datas, $result->getVisits());
									if($max < $result->getVisits()) $max = $result->getVisits();
								}

							break;

							## 사용언어 출력/랜딩 형태
							case 'bar_chart':
							case 'landing_chart':

								$ga->requestReportData($env['google_profile_id'], array($kind), array('visits'), '-visits', null, $sdate, $edate);
								
								$ga_results = $ga->getResults();

								echo "<pre>";
								print_R($ga_results);
								echo "</pre>";
								exit;

								foreach($ga->getResults() as $result) {
									$dimensions = $result->getDimesions();
									array_push($titles, $dimensions[$kind]);
									array_push($datas, $result->getVisits());
									if($max < $result->getVisits()) $max = $result->getVisits();
								}

							break;

						}	// switch end.
						
				}

				function set_infos($kind, $sdate, $edate) {
					
						$rows = $this->query_fetch(" select * from `".$this->analytics_table."` where `kind` = '".$kind."' and `sdate` = '".$sdate."' and `edate` = '".$edate."' ");

						if(!$rows['no']) 

							$rows = null;

						else {

							$stamp = strtotime($rows['update_time']);

							if(date('Y-m-d')==date('Y-m-d', $stamp)) { // 오늘날짜 로그 검색시

								$hours = floor((time()-strtotime($rows['update_time'])) / 3600);

								if($hours > $this->update_hours) 
									$rows = null; // 특정 시간단위로만 로딩

							} else if( strtotime($rows['edate'].' 23:59:59') > $stamp) 

								$rows = null;

							if($rows!=null) {
								$rows['titles'] = unserialize($rows['titles']);
								$rows['datas'] = unserialize($rows['datas']);
							}

						}

					
					$this->infos = $rows;

				}

				function draw_chart($kind, $shape, $width, $height, $loader) {

						$this->set_infos($kind, $_GET['sdate'], $_GET['edate']);

						$recent = ($this->infos===null) ? 'no' : 'yes';

						$result = sprintf('<div id="%s_chart" class="chart" kind="%s" shape="%s_chart" style="width:%dpx;height:%dpx" recent="%s">%s</div>', $kind, $kind, $shape, $width, $height, $recent, $loader);


					return $result;

				}

				function keep($vals) {

					global $utility;

						$rows = $this->query_fetch(" select * from `".$this->analytics_table."` where `kind` = '".$vals['kind']."' and `sdate` = '".$vals['sdate']."' and `edate` = '".$vals['edate']."' ");

						if($rows['no']) {

							$vals['update_time'] = date('Y-m-d H:i:s');
							$values = $utility->query_string($vals);
							$result = $this->_query( " update `".$this->analytics_table."` set ".$values." where `no` = ".$rows['no']." ");

						} else {

							$vals['regist_time'] = date('Y-m-d H:i:s');
							$vals['update_time'] = date('Y-m-d H:i:s');
							$values = $utility->query_string($vals);
							$result = $this->_query(" insert `".$this->analytics_table."` set " . $values);

						}


					return $result;

				}

				function dot($col) {

					global $statistics_control;

						switch($_GET['kind']) {

							case 'language':

								$tooltip = '사용언어: #x_label#<br>방문자수: #val#명';

							break;

							default:

								$tooltip = '접속일자: #x_label#<br>방문자수: #val#명';

							break;
						}

						$result = new solid_dot();
						$result->size(3);
						$result->halo_size(1);
						$result->colour($col);
						$result->tooltip($tooltip);


					return $result;

				}


				// 로그인 후 메인 '페이지뷰'
				function page_views( $vi_page, $vi_month ){

						if(!$vi_page) return false;

						$query = " select * from `alice_visit_page` where `vi_page` = '".$vi_page."' and `vi_date` = '".$vi_month."'  ";

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