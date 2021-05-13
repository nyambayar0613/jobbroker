<?php
		/**
		* /application/resume/controller/alice_alba_resume_user_control.class.php
		* @author Harimao
		* @since 2013/10/01
		* @last update 2015/03/25
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Resume Control class
		* @Comment :: 사용자측 알바 이력서 컨트롤 클래스
		*/
		class alice_alba_resume_user_control extends alice_alba_resume_user_model {


				/**
				* 서비스 시간이 존재하는지 확인하고, 서비스 기간이 있다면 true / 없다면 false 를 리턴한다
				* 필드 데이터를 통째로 받아 체킹
				* 결과는 배열로 리턴
				*/
				function service_valid( $vals ){

					global $utility;

						$result = array();

						$wr_service_main_focus = $utility->valid_day($vals['wr_service_main_focus']);	// 포커스 메인 서비스
						if($wr_service_main_focus) 
							$result['service_focus'] = $wr_service_main_focus;

						$wr_service_main_focus_gold = $utility->valid_day($vals['wr_service_main_focus_gold']);	// 포커스 메인 골드 서비스
						if($wr_service_main_focus_gold) 
							$result['service_focus_gold'] = $wr_service_main_focus_gold;

						$wr_service_sub_focus = $utility->valid_day($vals['wr_service_sub_focus']);	// 포커스 서브 서비스
						if($wr_service_sub_focus) 
							$result['service_sub_focus'] = $wr_service_sub_focus;

						$wr_service_sub_focus_gold = $utility->valid_day($vals['wr_service_sub_focus_gold']);	// 포커스 서브 골드 서비스
						if($wr_service_sub_focus_gold) 
							$result['service_sub_focus_gold'] = $wr_service_sub_focus_gold;

						$wr_service_busy = $utility->valid_day($vals['wr_service_busy']);	// 급구 서비스
						if($wr_service_busy) 
							$result['service_busy'] = $wr_service_busy;

						$wr_service_neon = $utility->valid_day($vals['wr_service_neon']);	// 형광펜 서비스
						if($wr_service_neon) 
							$result['service_neon'] = $wr_service_neon;

						$wr_service_bold = $utility->valid_day($vals['wr_service_bold']);		// 굵은글자 서비스
						if($wr_service_bold) 
							$result['service_bold'] = $wr_service_bold;

						$wr_service_color = $utility->valid_day($vals['wr_service_color']);	// 글자색 서비스
						if($wr_service_color) 
							$result['service_color'] = $wr_service_color;

						$wr_service_icon = $utility->valid_day($vals['wr_service_icon']);		// 아이콘 서비스
						if($wr_service_icon) 
							$result['service_icon'] = $wr_service_icon;

						$wr_service_blink = $utility->valid_day($vals['wr_service_blink']);		// 깜빡임 서비스
						if($wr_service_blink) 
							$result['service_blink'] = $wr_service_blink;

						$wr_service_jump = $utility->valid_day($vals['wr_service_jump']);		// 점프 서비스
						if($wr_service_jump) 
							$result['service_jump'] = $wr_service_jump;

					return $result;
					
				}


				// 리스트상 직종 출력
				function list_type( $vals, $type_sel="third", $implode=", " ){

					global $category_control;
						
						$result = array();

						$result['first'] = stripslashes( $category_control->get_categoryCodeName($vals['job_type0']) );

						if($type_sel=='second' && $vals['job_type1']){

							$result['second'] = stripslashes( $category_control->get_categoryCodeName($vals['job_type1']) );

						} else if($type_sel=='third'){

							if($vals['job_type1'])	$result['second'] = stripslashes( $category_control->get_categoryCodeName($vals['job_type1']) );

							if($vals['job_type2'])	$result['third'] = stripslashes( $category_control->get_categoryCodeName($vals['job_type2']) );

						}


					return @implode($result,$implode);

				}


				// hit up
				function hit_up( $no ){

						$query = " update `".$this->resume_table."` set `wr_hit` = `wr_hit` + 1 where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				// jump update
				function jump_update(){

					global $alice;
					global $alba_control;

						$query = " select * from `".$this->resume_table."` where `wr_open` = 1 and `wr_report` = 0 and `is_delete` = 0 and `wr_service_jump` >= curdate() ";

						if($alice['time_his'] < '06:00:00'){
							$result = $this->query_fetch_rows($query);
							foreach($result as $val){
								if($val['wr_jdate'] <= $alice['time_ymdhis']){
									$vals['wr_jdate'] = $alice['time_ymdhis'];
									$alba_control->alba_update($vals, $val['no']);
								}
							}
						} else if($alice['time_his'] < '12:00:00'){
							$result = $this->query_fetch_rows($query);
							foreach($result as $val){
								if($val['wr_jdate'] <= $alice['time_ymdhis']){
									$vals['wr_jdate'] = $alice['time_ymdhis'];
									$alba_control->alba_update($vals, $val['no']);
								}
							}
						} else if($alice['time_his'] < '18:00:00'){
							$result = $this->query_fetch_rows($query);
							foreach($result as $val){
								if($val['wr_jdate'] <= $alice['time_ymdhis']){
									$vals['wr_jdate'] = $alice['time_ymdhis'];
									$alba_control->alba_update($vals, $val['no']);
								}
							}
						} else if($alice['time_his'] < '23:59:59'){
							$result = $this->query_fetch_rows($query);
							foreach($result as $val){
								if($val['wr_jdate'] <= $alice['time_ymdhis']){
									$vals['wr_jdate'] = $alice['time_ymdhis'];
									$alba_control->alba_update($vals, $val['no']);
								}
							}
						}

				}


		}	// class end.
?>