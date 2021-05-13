<?php
		/**
		* /application/company/controller/alice_alba_company_control.class.php
		* @author Harimao
		* @since 2013/07/29
		* @last update 2015/04/09
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Company Employ Control class
		* @Comment :: 사용자측 알바 이력서 컨트롤 클래스
		*/
		class alice_alba_company_control extends alice_alba_company_model {


				/**
				* 알바 공고 등록
				*/
				function alba_insert( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->alba_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 알바 공고 수정
				*/
				function alba_update( $vals, $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->alba_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

				/**
				* 알바 공고 삭제 :: no 기준
				*/
				function alba_delete( $no, $mb_id ){

					global $alice, $env;
					global $user_control, $point_control;


						if(!$no || $no=='') return false;

						// 01. 회원 알바 카운트 감소
						$user_control->user_count_update('mb_alba_count',$mb_id,1,'-');

						// 02. 회원 포인트 차감

						// 03. 알바 근무회사 이미지 삭제
						$user_control->user_photo_delete( $mb_id, $no );

						// 04. 알바 데이터 삭제
						//$query = " delete from `".$this->alba_table."` where `no` = '".$no."' ";
						$query = " update `".$this->alba_table."` set `is_delete` = 1 where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				// 공고 기간 부여
				function alba_interval( $service_field, $date, $no ){

						if(!$no || $no =='') return false;

						$query = " update `".$this->alba_table."` set `".$service_field."` = date_add(now(), interval ".$date.") where `no` = " . $no;

						$result = $this->_query($query);


					return $result;
				}


				// 열람 정보 저장
				function open_insert( $resume_no, $wr_id="", $type ){
					
					global $utility;
					global $member, $member_control, $alba_resume_user_control;
					global $member_service;
						
						if(!$resume_no || $resume_no == '') return false;

						if(!$wr_id || $wr_id == '') return false;	// wr_id 가 있어야 됨

						$get_member = $member_control->get_member($wr_id);

						$get_resume = $alba_resume_user_control->get_resume_no($resume_no);

						// 기업 회원일때만
						if($member['mb_type']!='company') return false;

						// 열람권이 있는 기업회원이 볼때만
						if($utility->valid_day($member_service['mb_service_open'])){	// 열람권 서비스 기간이 있다면

							// 01. 중복 데이터 체크
							$sel_count = $this->_queryR(" select * from `".$this->open_table."` where `p_no` = '".$resume_no."' and  `mb_id` = '".$member['mb_id']."' and `wr_id` = '".$wr_id."' ");

							// 02. 중복 데이터가 없다면 입력
							if(!$sel_count){
								
								$result = $this->_query(" insert into `".$this->open_table."` set `p_no` = '".$resume_no."', `mb_id` = '".$member['mb_id']."', `wr_id` = '".$wr_id."', `wr_type` = '".$type."', `wr_name` = '".$get_member['mb_name']."', `wr_subject` = '".$get_resume['wr_subject']."', `wdate` = now() ");
								
								// 열람권 기간/건수 확인
								$is_open_service = false;
								if( $utility->valid_day($member_service['mb_service_open']) ){
									$is_open_service = $member_service['mb_service_open'];
								}
								$is_open_count = false;
								if( $utility->valid_day($member_service['mb_service_open']) && $member_service['mb_service_open_count'] ){	// 건수 사용이 가능하다면
									$is_open_count = $member_service['mb_service_open_count'];
								}

								if($is_open_count){	// 건수 사용이 가능하면 열람 했으니 차감
									$mb_service_open_count = $is_open_count - 1;
									$this->_query(" update `alice_member_service` set `mb_service_open_count` = '".$mb_service_open_count."' where `mb_id` = '".$member['mb_id']."' ");
								}

							} else {

								$result = false;
							}

						} else {

							return false;

						}


					return $result;

				}

				// 열람 정보 삭제
				function open_delete( $no ){

						if(!$no || $no=='') return false;

						$query = " delete from `".$this->open_table."` where `no` = '".$no."' ";

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


				// 면접/입사 제안 입력 (중복 체크 함)
				function insert_proposal( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$is_proposal = $this->is_proposal( $vals['wr_type'], $vals['wr_resume'], $vals['wr_employ'] );

						if($is_proposal){

							$result = true;

						} else {

							$query = " insert into `".$this->proposal_table."` set " . $val;

							$result = $this->_query($query);

						}


					return $result;

				}

				// 면접/입사 제안 데이터 유무
				function is_proposal( $wr_type, $wr_resume, $wr_employ ){

						$query = " select * from `".$this->proposal_table."` where `wr_type` = '".$wr_type."' and `wr_resume` = '".$wr_resume."' and `wr_employ` = '".$wr_employ."' ";

						$result = $this->_queryR($query);


					return $result;

				}

				// 기업회원 기준으로 면접/입사제안 데이터 존재유무
				function is_proposal_id( $wr_type, $mb_id, $wr_resume ){

						$query = " select * from `".$this->proposal_table."` where `wr_type` = '".$wr_type."' and `mb_id` = '".$mb_id."' and `wr_resume` = '".$wr_resume."' ";

						$result = $this->_queryR($query);

					
					return $result;

				}

				// 입사지원/면접제의 카운팅
				function proposal_count( $wr_type, $wr_id ){

						$query = " select * from `".$this->proposal_table."` where `wr_type` = '".$wr_type."' and `wr_id` = '".$wr_id."' ";

						$result = $this->_queryR($query);

					
					return $result;

				}



		}	// class end.
?>