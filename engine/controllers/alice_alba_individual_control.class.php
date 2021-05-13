<?php
		/**
		* /application/individual/controller/alice_alba_individual_control.class.php
		* @author Harimao
		* @since 2013/07/23
		* @last update 2015/04/09
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Individual Control class
		* @Comment :: 사용자측 알바 이력서 컨트롤 클래스
		*/
		class alice_alba_individual_control extends alice_alba_individual_model {


				/**
				* 알바 이력서 정보 입력
				*/
				function insert_resume( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->resume_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 알바 이력서 정보 수정
				*/
				function update_resume( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->resume_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 알바 이력서 정보 삭제 :: no 기준
				*/
				function delete_resume( $no, $mb_id ){

					global $alice, $env;
					global $user_control, $point_control;


						if(!$no || $no=='') return false;

						// 01. 회원 알바 이력서 카운트 감소
						$user_control->user_count_update('mb_alba_resume_count',$mb_id,1,'-');

						// 02. 회원 포인트 차감

						// 03. 이력서 데이터 삭제
						//$result = $this->_query(" delete from `".$this->resume_table."` where `no` = '".$no."' ");
						$result = $this->_query(" update `".$this->resume_table."` set `is_delete` = 1 where `no` = '".$no."' ");


					return $result;

				}

				
				// 기본 이력서 전체 초기화
				function initial_use( $wr_id ){

						if(!$wr_id || $wr_id == '') return false;
						
						$query = " update `".$this->resume_table."` set `wr_use` = '0' where `wr_id` = '".$wr_id."' ";

						$result = $this->_query($query);

					
					return $result;

				}

				// 이력서 기간 부여
				function individual_interval( $service_field, $date, $no ){

						if(!$no || $no =='') return false;

						$query = " update `".$this->resume_table."` set `".$service_field."` = date_add(now(), interval ".$date.") where `no` = " . $no;

						$result = $this->_query($query);


					return $result;
				}
				

				/**
				* 알바 이력서 정보 복사 :: no 기준
				*/
				function copy_resume( $no, $mb_id ){

					global $user_control;

						if(!$no || $no=='') return false;

						$get_member = $user_control->get_member($mb_id);		// 회원 정보
						$get_resume = $this->get_resume_no($no);					// 이력서 정보

						$query = " insert into `".$this->resume_table."` 
										set `wr_id` = '".$get_resume['wr_id']."',
										wr_open = '".$get_resume['wr_open']."',
										wr_subject = '사본-".$get_resume['wr_subject']."',
										wr_area0 = '".$get_resume['wr_area0']."',
										wr_area1 = '".$get_resume['wr_area1']."',
										wr_area2 = '".$get_resume['wr_area2']."',
										wr_area3 = '".$get_resume['wr_area3']."',
										wr_area4 = '".$get_resume['wr_area4']."',
										wr_area5 = '".$get_resume['wr_area5']."',
										wr_job_type0 = '".$get_resume['wr_job_type0']."',
										wr_job_type1 = '".$get_resume['wr_job_type1']."',
										wr_job_type2 = '".$get_resume['wr_job_type2']."',
										wr_job_type3 = '".$get_resume['wr_job_type3']."',
										wr_job_type4 = '".$get_resume['wr_job_type4']."',
										wr_job_type5 = '".$get_resume['wr_job_type5']."',
										wr_job_type6 = '".$get_resume['wr_job_type6']."',
										wr_job_type7 = '".$get_resume['wr_job_type7']."',
										wr_job_type8 = '".$get_resume['wr_job_type8']."',
										wr_date = '".$get_resume['wr_date']."',
										wr_week = '".$get_resume['wr_week']."',
										wr_time = '".$get_resume['wr_time']."',
										wr_work_direct = '".$get_resume['wr_work_direct']."',
										wr_pay_type = '".$get_resume['wr_pay_type']."',
										wr_pay = '".$get_resume['wr_pay']."',
										wr_pay_conference = '".$get_resume['wr_pay_conference']."',
										wr_work_type = '".$get_resume['wr_work_type']."',
										wr_school_ability = '".$get_resume['wr_school_ability']."',
										wr_school_absence = '".$get_resume['wr_school_absence']."',
										wr_school_type = '".$get_resume['wr_school_type']."',
										wr_high_school_name = '".$get_resume['wr_high_school_name']."',
										wr_high_school_syear = '".$get_resume['wr_high_school_syear']."',
										wr_high_school_eyear = '".$get_resume['wr_high_school_eyear']."',
										wr_high_school_graduation = '".$get_resume['wr_high_school_graduation']."',
										wr_half_college = '".$get_resume['wr_half_college']."',
										wr_college = '".$get_resume['wr_college']."',
										wr_graduate = '".$get_resume['wr_graduate']."',
										wr_success = '".$get_resume['wr_success']."',
										wr_career_use = '".$get_resume['wr_career_use']."',
										wr_career = '".$get_resume['wr_career']."',
										wr_license = '".$get_resume['wr_license']."',
										wr_language = '".$get_resume['wr_language']."',
										wr_oa = '".$get_resume['wr_oa']."',
										wr_computer = '".$get_resume['wr_computer']."',
										wr_specialty = '".$get_resume['wr_specialty']."',
										wr_specialty_etc = '".$get_resume['wr_specialty_etc']."',
										wr_prime = '".$get_resume['wr_prime']."',
										wr_introduce = '".$get_resume['wr_introduce']."',
										wr_impediment_use = '".$get_resume['wr_impediment_use']."',
										wr_impediment_level = '".$get_resume['wr_impediment_level']."',
										wr_impediment_name = '".$get_resume['wr_impediment_name']."',
										wr_marriage = '".$get_resume['wr_marriage']."',
										wr_military = '".$get_resume['wr_military']."',
										wr_military_type = '".$get_resume['wr_military_type']."',
										wr_preferential_use = '".$get_resume['wr_preferential_use']."',
										wr_treatment_use = '".$get_resume['wr_treatment_use']."',
										wr_treatment_service = '".$get_resume['wr_treatment_service']."',
										wr_calltime = '".$get_resume['wr_calltime']."',
										wr_calltime_always = '".$get_resume['wr_calltime_always']."',
										wr_wdate = '".$get_resume['wr_wdate']."',
										wr_udate = '".$get_resume['wr_udate']."',
										wr_report = '".$get_resume['wr_report']."',
										wr_report_date = '".$get_resume['wr_report_date']."',
										wr_is_admin = '".$get_resume['wr_is_admin']."',
										
										etc_0 = '".$get_resume['etc_0']."',
										etc_1 = '".$get_resume['etc_1']."',
										etc_2 = '".$get_resume['etc_2']."',
										etc_3 = '".$get_resume['etc_3']."',
										etc_4 = '".$get_resume['etc_4']."',
										etc_5 = '".$get_resume['etc_5']."',
										etc_6 = '".$get_resume['etc_6']."',
										etc_7 = '".$get_resume['etc_7']."',
										etc_8 = '".$get_resume['etc_8']."',
										etc_9 = '".$get_resume['etc_9']."' ";

						/* 서비스도 복사하나?
										wr_service = '',
										wr_service_busy = '',
										wr_service_focus = '',
										wr_service_neon = '',
										wr_service_neon_val = '',
										wr_service_bold = '',
										wr_service_color = '',
										wr_service_color_val = '',
										wr_service_icon = '',
										wr_service_icon_val = '',
										wr_service_icon_text = '',
										wr_service_blink = '',
										wr_service_jump = '',

						*/

						$result = $this->_query($query);


					return $result;

				}


				// 이력서 공개/비공개 설정
				function resume_is_open( $no, $wr_id, $is_open ){
						
						if(!$no || $no=='') return false;

						$query = " update `".$this->resume_table."` set `wr_open` = '".$is_open."' where `no` = '".$no."' and `wr_id` = '".$wr_id."' ";
						
						$result = $this->_query($query);

					
					return $result;

				}


				/**
				* 이력서 열람 제한 정보 입력
				*/
				function insert_denied( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);


						$sel_cnt = $this->_queryR(" select * from `".$this->resume_denied."` where `wr_id` = '".$vals['wr_id']."' and `mb_id` = '".$vals['mb_id']."' ");

						if($sel_cnt){

							$result = true;

						} else {

							$query = " insert into `".$this->resume_denied."` set " . $val;

							$result = $this->_query($query);

						}


					return $result;

				}

				/**
				* 이력서 열람 제한 정보 삭제
				*/
				function delete_denied( $no ){

					global $utility;

						$query = " delete from `".$this->resume_denied."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 이력서 열람 제한 정보 카운트
				*/
				function sel_denied_cnt( $wr_id ){

						$query = " select * from `".$this->resume_denied."` where `wr_id` = '".$wr_id."' ";

						$result = $this->_queryR($query);

					
					return $result;

				}


				/**
				* 관심기업 정보 입력
				*/
				function insert_favorite( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);


						$sel_cnt = $this->_queryR(" select * from `".$this->resume_favorite."` where `wr_id` = '".$vals['wr_id']."' and `mb_id` = '".$vals['mb_id']."' ");

						if($sel_cnt){

							$result = true;

						} else {

							$query = " insert into `".$this->resume_favorite."` set " . $val;

							$result = $this->_query($query);

						}


					return $result;

				}

				/**
				* 관심기업 정보 삭제
				*/
				function delete_favorite( $no ){

					global $utility;

						$query = " delete from `".$this->resume_favorite."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

				/**
				* 관심기업 정보 카운트
				*/
				function sel_favorite_cnt( $wr_id ){

						$query = " select * from `".$this->resume_favorite."` where `wr_id` = '".$wr_id."' ";

						$result = $this->_queryR($query);

					
					return $result;

				}


				/**
				* 취업활동 증명서 발급 정보 입력
				*/
				function insert_proof( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->resume_proof."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				// 맞춤 인재정보 입력/수정
				function custom_updates( $vals, $no="" ){

					global $utility;

						$val = $utility->QueryString($vals);

						if($no){
							$query = " update `".$this->custom_table."` set " . $val . " where `no` = '".$no."' ";
						} else {
							$query = " insert into `".$this->custom_table."` set " . $val;
						}

						$result = $this->_query($query);

					
					return $result;

				}


				// 맞춤 인재정보 삭제
				function custom_delete( $no ){

						$query = " delete from `".$this->custom_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;

				}


				// 열람 정보 저장
				function open_insert( $alba_no, $wr_id="", $type ){
					
					global $utility;
					global $member, $member_control, $alba_user_control;
					global $member_service;
						
						if(!$alba_no || $alba_no == '') return false;

						if(!$wr_id || $wr_id == '') return false;	// wr_id 가 있어야 됨

						$get_member = $member_control->get_member($wr_id);

						$get_alba = $alba_user_control->get_alba_no($alba_no);

						// 기업 회원일때만
						if($member['mb_type']!='individual') return false;

						// 열람권이 있는 기업회원이 볼때만
						if($utility->valid_day($member_service['mb_service_alba_open'])){	// 열람권 서비스 기간이 있다면

							// 01. 중복 데이터 체크
							$sel_count = $this->_queryR(" select * from `".$this->open_table."` where `p_no` = '".$alba_no."' and  `mb_id` = '".$member['mb_id']."' and `wr_id` = '".$wr_id."' ");

							// 02. 중복 데이터가 없다면 입력
							if(!$sel_count){
								
								$result = $this->_query(" insert into `".$this->open_table."` set `p_no` = '".$alba_no."', `mb_id` = '".$member['mb_id']."', `wr_id` = '".$wr_id."', `wr_type` = '".$type."', `wr_name` = '".$get_member['mb_name']."', `wr_subject` = '".$get_alba['wr_subject']."', `wdate` = now() ");
								
								// 열람권 기간/건수 확인
								$is_open_service = false;
								if( $utility->valid_day($member_service['mb_service_alba_open']) ){
									$is_open_service = $member_service['mb_service_alba_open'];
								}
								$is_open_count = false;
								if( $utility->valid_day($member_service['mb_service_alba_open']) && $member_service['mb_service_alba_count'] ){	// 건수 사용이 가능하다면
									$is_open_count = $member_service['mb_service_alba_count'];
								}

								if($is_open_count){	// 건수 사용이 가능하면 열람 했으니 차감
									$mb_service_open_count = $is_open_count - 1;
									$this->_query(" update `alice_member_service` set `mb_service_alba_count` = '".$mb_service_open_count."' where `mb_id` = '".$member['mb_id']."' ");
								}

							} else {

								$result = false;
							}

						} else {

							return false;

						}


					return $result;

				}

		}	// class end.
?>