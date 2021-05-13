<?php
		/**
		* /application/alba/controller/alice_alba_user_control.class.php
		* @author Harimao
		* @since 2013/08/01
		* @last update 2015/04/10
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Control class
		* @Comment :: 사용자측 정규직 컨트롤 클래스
		*/
		class alice_alba_user_control extends alice_alba_user_model {


	
				/**
				* 서비스 시간이 존재하는지 확인하고, 서비스 기간이 있다면 true / 없다면 false 를 리턴한다
				* 필드 데이터를 통째로 받아 체킹
				* 결과는 배열로 리턴
				*/
				function service_valid( $vals ){

					global $utility;

						$result = array();
											
						$wr_service_platinum = $utility->valid_day($vals['wr_service_platinum']);	// 플래티넘 메인 서비스
						if($wr_service_platinum) 
							$result['service_platinum'] = $wr_service_platinum;

						$wr_service_platinum_main_gold = $utility->valid_day($vals['wr_service_platinum_main_gold']);	// 플래티넘 메인 페이지 골드 서비스
						if($wr_service_platinum_main_gold) 
							$result['service_platinum_main_gold'] = $wr_service_platinum_main_gold;

						$wr_service_platinum_main_logo = $utility->valid_day($vals['wr_service_platinum_main_logo']);	// 플래티넘 메인 로고강조 서비스
						if($wr_service_platinum_main_logo) 
							$result['service_platinum_main_logo'] = $wr_service_platinum_main_logo;


						$wr_service_platinum_sub_gold = $utility->valid_day($vals['wr_service_platinum_sub_gold']);		// 플래티넘 서브 페이지 골드 서비스
						if($wr_service_platinum_sub_gold) 
							$result['service_platinum_sub_gold'] = $wr_service_platinum_sub_gold;

						$wr_service_platinum_sub_logo = $utility->valid_day($vals['wr_service_platinum_sub_logo']);	// 플래티넘 서브 로고강조 서비스
						if($wr_service_platinum_sub_logo) 
							$result['service_platinum_sub_logo'] = $wr_service_platinum_sub_logo;

						
						$wr_service_prime = $utility->valid_day($vals['wr_service_prime']);	// 프라임 서비스
						if($wr_service_prime) 
							$result['service_prime'] = $wr_service_prime;

						$wr_service_prime_main_gold = $utility->valid_day($vals['wr_service_prime_main_gold']);	// 프라임 메인 페이지 골드 서비스
						if($wr_service_prime_main_gold) 
							$result['service_prime_main_gold'] = $wr_service_prime_main_gold;

						$wr_service_prime_main_logo = $utility->valid_day($vals['wr_service_prime_main_logo']);	// 프라임 메인 페이지 로고강조 서비스
						if($wr_service_prime_main_logo) 
							$result['service_prime_main_logo'] = $wr_service_prime_main_logo;

						$wr_service_prime_sub_gold = $utility->valid_day($vals['wr_service_prime_sub_gold']);		// 프라임 서브 페이지 골드 서비스
						if($wr_service_prime_sub_gold) 
							$result['service_prime_sub_gold'] = $wr_service_prime_sub_gold;

						$wr_service_grand = $utility->valid_day($vals['wr_service_grand']);	// 그랜드 서비스
						if($wr_service_grand) 
							$result['service_grand'] = $wr_service_grand;

						$wr_service_grand_main_gold = $utility->valid_day($vals['wr_service_grand_main_gold']);	// 그랜드 메인 페이지 골드 서비스
						if($wr_service_grand_main_gold) 
							$result['service_grand_main_gold'] = $wr_service_grand_main_gold;

						$wr_service_grand_main_logo = $utility->valid_day($vals['wr_service_grand_main_logo']);	// 그랜드 메인 페이지 로고강조 서비스
						if($wr_service_grand_main_logo) 
							$result['service_grand_main_logo'] = $wr_service_grand_main_logo;

						$wr_service_grand_sub_gold = $utility->valid_day($vals['wr_service_grand_sub_gold']);		// 그랜드 서브 페이지 골드 서비스
						if($wr_service_grand_sub_gold) 
							$result['service_grand_sub_gold'] = $wr_service_grand_sub_gold;


						$wr_service_banner = $utility->valid_day($vals['wr_service_banner']);	// 배너형 서비스
						if($wr_service_banner) 
							$result['service_banner'] = $wr_service_banner;

						$wr_service_banner_main_gold = $utility->valid_day($vals['wr_service_banner_main_gold']);	// 배너형 메인 페이지 골드 서비스
						if($wr_service_banner_main_gold) 
							$result['service_banner_main_gold'] = $wr_service_banner_main_gold;

						$wr_service_banner_sub_gold = $utility->valid_day($vals['wr_service_banner_sub_gold']);		// 배너형 서브 페이지 골드 서비스
						if($wr_service_banner_sub_gold) 
							$result['service_banner_sub_gold'] = $wr_service_banner_sub_gold;


						$wr_service_list = $utility->valid_day($vals['wr_service_list']);	// 리스트형 서비스
						if($wr_service_list) 
							$result['service_list'] = $wr_service_list;

						$wr_service_list_gold = $utility->valid_day($vals['wr_service_list_main_gold']);	// 리스트형 골드 서비스
						if($wr_service_list_gold) 
							$result['service_list_main_gold'] = $wr_service_list_gold;

						$wr_service_sub_list = $utility->valid_day($vals['wr_service_list_sub']);	// 서브 리스트형 서비스
						if($wr_service_sub_list) 
							$result['service_list_sub'] = $wr_service_sub_list;

						$wr_service_sub_list_gold = $utility->valid_day($vals['wr_service_list_sub_gold']);	// 서브 리스트형 골드 서비스
						if($wr_service_sub_list_gold) 
							$result['service_list_sub_gold'] = $wr_service_sub_list_gold;


						$wr_service_busy = $utility->valid_day($vals['wr_service_busy']);	// 급구 서비스
						if($wr_service_busy) 
							$result['service_busy'] = $wr_service_busy;

						
						$wr_service_neon = $utility->valid_day($vals['wr_service_neon']);	// 형광펜 기간
						if($wr_service_neon) 
							$result['service_neon'] = $wr_service_neon;

						$wr_service_bold = $utility->valid_day($vals['wr_service_bold']);		// 굵은글자 기간
						if($wr_service_bold) 
							$result['service_bold'] = $wr_service_bold;

						$wr_service_color = $utility->valid_day($vals['wr_service_color']);	// 글자색상 기간
						if($wr_service_color) 
							$result['service_color'] = $wr_service_color;

						$wr_service_icon = $utility->valid_day($vals['wr_service_icon']);		// 아이콘 기간
						if($wr_service_icon) 
							$result['service_icon'] = $wr_service_icon;

						$wr_service_blink = $utility->valid_day($vals['wr_service_blink']);	// 반짝칼라 기간
						if($wr_service_blink) 
							$result['service_blink'] = $wr_service_blink;


						$wr_service_jump = $utility->valid_day($vals['wr_service_jump']);	// 점프 서비스
						if($wr_service_jump) 
							$result['service_jump'] = $wr_service_jump;


					return $result;

				}


				// 리스트상 지역 출력
				function list_area( $vals, $area_sel="second" ){

					global $category_control;

						$result = array();

						$wr_area_0 = explode('/',$vals);	// 지역 정보

						$result['first'] = stripslashes( $category_control->get_categoryCodeName($wr_area_0[0]) );

						if($area_sel=='second'){	// 2차 까지 출력

							$result['second'] = stripslashes( $category_control->get_categoryCodeName($wr_area_0[1]) );

						} else if($area_sel=='third'){	// 3차 까지 출력

							$result['second'] = stripslashes( $category_control->get_categoryCodeName($wr_area_0[1]) );

							$result['third'] = stripslashes( $category_control->get_categoryCodeName($wr_area_0[2]) );

						}


					return @implode($result," ");

				}

				// 리스트상 직종 출력
				function list_type( $vals, $type_sel="third", $implode=", " ){

					global $category_control;
						
						$result = array();

						$result['first'] = stripslashes( $category_control->get_categoryCodeName($vals['job_type0']) );

						if($type_sel=='second'){

							$result['second'] = stripslashes( $category_control->get_categoryCodeName($vals['job_type1']) );

						} else if($type_sel=='third'){

							$result['second'] = stripslashes( $category_control->get_categoryCodeName($vals['job_type1']) );

							$result['third'] = stripslashes( $category_control->get_categoryCodeName($vals['job_type2']) );

						}


					return @implode($result,$implode);

				}

				// 리스트상 지하철 정보 아이콘 변환 및 정보 출력
				function list_subway( $vals ){
					
					global $alice, $utility;
					global $category_control;

						$result = array();

						for($i=0;$i<=2;$i++){
							$subway_line = $vals['subway_area_'.$i]['subway_line'];
							$subway_station = $vals['subway_area_'.$i]['subway_station'];
							$subway_content = $vals['subway_area_'.$i]['subway_content'];
							if($subway_line){
								$get_line = $category_control->get_categoryCode($subway_line);
								$get_station = $category_control->get_categoryCode($subway_station);
								$line = $utility->remove_quoted($get_line['name']);
								$station = $utility->remove_quoted($get_station['name']);
								$content = ($subway_content) ? " (" . stripslashes($subway_content) . ")" : "";
								$result[$i] = "<span title=\"".$line."\"><img width=\"35\" height=\"15\" src=\"../images/icon/".$get_line['etc_0']."\"></span> <span class=\"district\">".$station."</span> <span class=\"txtBar\"> | </span> ";	// .$content
							}
						}

					
					return @implode($result,", ");

				}

				// 지하철 정보 아이콘 변환 및 정보 출력
				function view_subway( $vals, $subway_area=0 ){
					
					global $alice, $utility;
					global $category_control;

						$result = array();

						$subway_line = $vals['subway_area_'.$subway_area]['subway_line'];
						$subway_station = $vals['subway_area_'.$subway_area]['subway_station'];
						$subway_content = $vals['subway_area_'.$subway_area]['subway_content'];

						$get_line = $category_control->get_categoryCode($subway_line);
						$get_station = $category_control->get_categoryCode($subway_station);
						$line = $utility->remove_quoted($get_line['name']);
						$station = $utility->remove_quoted($get_station['name']);
						$content = ($subway_content) ? stripslashes($subway_content) : "";

						if($subway_line){
							$result['line_icon'] = "../images/icon/" . $get_line['etc_0'];
						}
						if($subway_station){
							$result['station'] = $station;
						}
						if($subway_content){
							$result['content'] = $content;
						}
					

					return $result;

				}
				
				// 리스트상 지역 정보
				function list_area_info( $vals ){

					global $category_control;

						$area_0 = explode('/',$vals['area_0']);
						$area_1 = explode('/',$vals['area_1']);
						$area_2 = explode('/',$vals['area_2']);

						$areas = array();
						for($i=0;$i<=2;$i++){
							if($vals['area_'.$i]!=''){
								$area = explode('/',$vals['area_'.$i]);
								if( !@in_array($area[0],$areas) ){
									@array_push($areas,$area[0]);
								}
							} else {
								continue;
							}
						}


						$results = array();

						$areas_cnt = count($areas);
						for($i=0;$i<$areas_cnt;$i++){
						$k = 0;
							$vals_cnt = count($vals);
							for($j=0;$j<$vals_cnt;$j++){
								$_val = explode('/',$vals['area_'.$j]);
								if($_val[0] == $areas[$i]){
									$results[$areas[$i]][$k] = $_val[1];
								$k++;
								}
							}
						}

						$result = array();
						$r = 0;
						foreach($results as $key => $val){
							$result[$r] = $category_control->get_categoryCodeName($key);
							$val_cnt = count($val);
							if($val_cnt){
								$result[$r] .= " > ";
								for($v=0;$v<$val_cnt;$v++){
									$_comma = ($v != ($val_cnt-1)) ? ", " : "";
									$result[$r] .= $category_control->get_categoryCodeName($val[$v]) . $_comma;
								}
							}
						$r++;
						}


					return @implode(" / ",$result);

				}

				// 마감일 계산
				function volume_date( $vals, $is_box=false ){

					global $alice;

						$wr_volume_date = $vals['volume_date'];			// 마감일
						$wr_volume_always = $vals['volume_always'];	// 상시모집
						$wr_volume_end = $vals['volume_end'];				// 채용시까지

						$result = array();

						$result['result'] = false;

						if($wr_volume_always || $wr_volume_end){

							if($wr_volume_always) $result['text'] .= " 상시모집";

							if($wr_volume_end) {

								$_slash = ($wr_volume_always) ? "/":" ";
								$result['text'] .= $_slash . "채용시까지";
							}
							
							$result['result'] = true;

						} else {

							if($wr_volume_date < $alice['time_ymd']){

								$result['text'] = " 마감됨";

								$result['result'] = false;

							} else {

								if($is_box==true) {	// 박스형 리스트

									$volume_date = substr($wr_volume_date,5,5);
									$result['text'] .= "~" . strtr($volume_date,'-','/');
									$result['date'] = $wr_volume_date;

								} else {

									$result['text'] .= " ".$wr_volume_date;
									$result['text'] .= " <strong>(마감 ".((strtotime($wr_volume_date)-strtotime(date("Y/m/d")))/86400) . "일전)</strong>";
									$result['date'] = $wr_volume_date;

								}

								$result['result'] = true;

							}

						}

					
					return $result;

				}

				// 리스트상 연령 정보
				function list_age( $vals ){

					global $category_control;

						$age_limit = $vals['age_limit'];		// 연령 제한 유무
						$age = $vals['age'];						// 제한 연령
						$age_etc = $vals['age_etc'];			// 장년/주부 가능 유무

						$result = array();

						if($age_limit)
							$result['result'] = str_replace('-',' ~ ',$age) . "세";
						else
							$result['result'] = "연령무관";

						if($age_etc) {
							$age_etcs = explode(',',$age_etc);
							$age_etc_cnt = count($age_etcs);
							$age_etc_arr = array();
							for($i=0;$i<$age_etc_cnt;$i++){
								$age_etc_arr[$i] = $category_control->get_categoryCodeName($age_etcs[$i]);
							}

							$result['etc'] = @implode($age_etc_arr,',');
						}


					return $result;

				}

				// 리스트상 모집 인원
				function list_volume( $vals ){

						$wr_volume = $vals['volume'];
						$wr_volumes = $vals['volumes'];

						$result = "";

						if($wr_volume){

							$result .= number_format($wr_volume) . "명";

						} else {

							$volumes = explode(',',$wr_volumes);
							$volumes_cnt = count($volumes);
							
							$volumes_arr = array();

							for($i=0;$i<$volumes_cnt;$i++){

								$volumes_arr[$i] = preg_replace("/0/", "○", $volumes[$i]) . "명";

							}

							$result .= @implode($volumes_arr,', ');

						}


					return $result;

				}


				// 스크랩 데이터 입력
				function scrap_insert( $mb_id, $content="", $rel_table, $rel_id, $rel_action ){

					global $alice;
					global $member_control;
					
						if(!$mb_id || $mb_id=="") return $this->_errors('0000');


						$mb = $member_control->get_member($mb_id);

						// 아이디가 없다면 패스
						if(!$mb['mb_id'] || $mb['mb_id']=='') $this->_errors('0000');

						if($rel_table || $rel_id || $rel_action){

							// 이미 스크랩한 내역이 있다면 패스
							$get_scrap_cnt = $this->get_scrap_cnt($mb_id, $rel_table, $rel_id, $rel_action);
							if($get_scrap_cnt['cnt']) return $this->_errors('0001');

							// 자신의 글(데이터)을 스크랩 한 경우
							//$get_alba = $this->get_alba_no($rel_id);

							$result = $this->_query(" insert into `".$this->scrap_table."` set `mb_id` = '".$mb_id."', `scrap_content` = '".addslashes($content)."', `scrap_rel_table` = '".$rel_table."', `scrap_rel_id` = '".$rel_id."', `scrap_rel_action` = '".$rel_action."', `wdate` = '".$alice['time_ymdhis']."' ");

						}


					return $this->_success('0000');

				}


				// 스크랩 데이터 삭제 :: no 기준
				function scrap_delete( $no ){

						if(!$no || $no=='') return false;

						$query = " delete from `".$this->scrap_table."` where `no` = '".$no."' ";

						echo $query." \n\n";

						$result = $this->_query($query);


					return $result;

				}


				// 지원자수 증가
				function desire_update( $no, $mb_id="" ){

					global $member_control;

						if(!$no || $no=='') return false;

						$this->_query(" update `".$member_control->member_table."` set `mb_alba_count` = `mb_alba_count` + 1 where `mb_id` = '".$mb_id."' ");	// 개인 회원 정규직 지원수 증가

						$query = " update `".$this->alba_table."` set `wr_desire` = `wr_desire` + 1  where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;

				}

				// 지원자수 감소
				function desire_down( $no ){

						if(!$no || $no=='') return false;

						$query = " update `".$this->alba_table."` set `wr_desire` = `wr_desire` - 1  where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;

				}

				// hit up
				function hit_up( $no ){

						$query = " update `".$this->alba_table."` set `wr_hit` = `wr_hit`+ 1 where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				// jump update
				function jump_update(){

					global $alice, $utility;
					global $alba_control, $member_control;

						$query = " select A.* from `".$this->alba_table."` as A LEFT JOIN `alice_member_service` as B ON A.wr_id=B.mb_id where `wr_open` = 1 and `wr_report` = 0 and `is_delete` = 0 and B.mb_alba_jump_count > 0 ";
						$result = $this->query_fetch_rows($query);

						$wr_id = "";
						$wr_jump = 0;

						if( $alice['time_his'] >= '00:00:00' && $alice['time_his'] <= '06:00:00'){
							//echo "A<br/>";
							foreach($result as $val){
								$wr_id = $val['wr_id'];
								$wr_jump = $val['wr_jump'];
								if( (!$val['wr_jump'] || $val['wr_jump'] > 1) && $val['wr_jdate'] <= $alice['time_ymdhis'] ){
									$vals['wr_jdate'] = date("Y-m-d H:i").":".sprintf("%02d",rand(0,59));
									$vals['wr_jump'] = 1;
									$alba_control->alba_update($vals, $val['no']);
								}
							
							if( !$wr_jump || $wr_jump > 1 ){
								$service_member = $member_control->get_service_member($wr_id);
								if( $service_member['mb_alba_jump_count'] > 0 ){
									$service_vals['mb_alba_jump_count'] = $service_member['mb_alba_jump_count'] - 1;
									$member_control->service_upate($service_vals,$wr_id);
								}
							}
							}
						} else if( $alice['time_his'] > '06:00:00' && $alice['time_his'] <= '12:00:00'){
							//echo "B<br/>";
							foreach($result as $val){
								$wr_id = $val['wr_id'];
								$wr_jump = $val['wr_jump'];
								if( (!$val['wr_jump'] || $val['wr_jump'] < 2) && $val['wr_jdate'] <= $alice['time_ymdhis']){
									$vals['wr_jdate'] = date("Y-m-d H:i").":".sprintf("%02d",rand(0,59));
									$vals['wr_jump'] = 2;
									$alba_control->alba_update($vals, $val['no']);
								}
							
							if( !$wr_jump || $wr_jump < 2 ){
								$service_member = $member_control->get_service_member($wr_id);
								if( $service_member['mb_alba_jump_count'] > 0 ){
									$service_vals['mb_alba_jump_count'] = $service_member['mb_alba_jump_count'] - 1;
									$member_control->service_upate($service_vals,$wr_id);
								}
							}
							}
						} else if( $alice['time_his'] > '12:00:00' && $alice['time_his'] <= '15:00:00'){
							//echo "C<br/>";
							foreach($result as $val){
								$wr_id = $val['wr_id'];
								$wr_jump = $val['wr_jump'];
								if( (!$val['wr_jump'] || $val['wr_jump'] < 3) && $val['wr_jdate'] <= $alice['time_ymdhis']){
									$vals['wr_jdate'] = date("Y-m-d H:i").":".sprintf("%02d",rand(0,59));
									$vals['wr_jump'] = 3;
									$alba_control->alba_update($vals, $val['no']);
								}
							
							if( !$wr_jump || $wr_jump < 3 ){										
								$service_member = $member_control->get_service_member($wr_id);
								if( $service_member['mb_alba_jump_count'] > 0 ){
									$service_vals['mb_alba_jump_count'] = $service_member['mb_alba_jump_count'] - 1;
									$member_control->service_upate($service_vals,$wr_id);
								}
							}
							}
						} else if( $alice['time_his'] > '15:00:00' && $alice['time_his'] <= '23:59:59'){

							foreach($result as $val){
								$wr_id = $val['wr_id'];
								$wr_jump = $val['wr_jump'];
								if( (!$val['wr_jump'] || $val['wr_jump'] < 4) && $val['wr_jdate'] <= $alice['time_ymdhis']){
									$vals['wr_jdate'] = date("Y-m-d H:i").":".sprintf("%02d",rand(0,59));
									$vals['wr_jump'] = 4;
									$alba_control->alba_update($vals, $val['no']);
								}
							
							if( !$wr_jump || $wr_jump < 4 ){
								$service_member = $member_control->get_service_member($wr_id);
								if( $service_member['mb_alba_jump_count'] > 0 ){
									$service_vals['mb_alba_jump_count'] = $service_member['mb_alba_jump_count'] - 1;
									$member_control->service_upate($service_vals,$wr_id);
								}
							}
							}
						}


				}

		}	// class end.
?>