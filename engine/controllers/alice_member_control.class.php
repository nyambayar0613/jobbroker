<?php
		/**
		* /application/nad/member/controller/alice_member_control.class.php
		* @author Harimao
		* @since 2013/07/02
		* @last update 2015/04/02
		* @Module v3.5 ( Alice )
		* @Brief :: Member Control class
		* @Comment :: 관리자측 회원 관리 컨트롤 클래스
		*/
		class alice_member_control extends alice_member_model {


				/**
				* 회원 정보 입력
				*/
				function insert_member( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->member_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}

				
				/**
				* 회원 정보 수정 :: mb_id 기준
				*/
				function update_member( $vals, $mb_id ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->member_table."` set " . $val . " where `mb_id` = '".$mb_id."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 회원 정보 수정 :: no 기준
				*/
				function update_memberNo( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->member_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 기업회원 정보 입력
				*/
				function insert_company_member( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->member_company_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}

				
				/**
				* 기업회원 정보 수정 :: mb_id 기준
				*/
				function update_company_member( $vals, $mb_id ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->member_company_table."` set " . $val . " where `mb_id` = '".$mb_id."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 기업회원 정보 수정 :: no 기준
				*/
				function update_company_memberNo( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->member_company_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 기업회원 정보 삭제
				*/
				function delete_company_member( $no ){

						$query = " delete from `".$this->member_company_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;
				}

				/**
				* 회원 정보 삭제 :: mb_id 기준
				*/
				function delete_member( $mb_no ){

					global $alice, $utility;
					global $board_control;

						$get_member = $this->get_memberNo($mb_no);

						$mb_id = $get_member['mb_id'];

						$mb_type = $get_member['mb_type'];

						if($mb_type=='individual'){	 // 개인 회원


							// 01. 이력서 삭제
							$resume_delete = " delete from `alice_resume` where `wr_id` = '".$mb_id."' ";

							// 01. 알바 이력서 삭제
							$alba_resume_delete = $this->_query(" update `alice_alba_resume` set `is_delete` = 1 where `wr_id` = '".$mb_id."' ");

							// 02. 입사지원 정보 삭제
							//$receive_delete = " delete from `alice_receive` where `wr_id` = '".$mb_id."' and `type` in ('become_email','become_online') ";

							// 03. 이력서 열람제한 기업 정보 삭제
							$alba_resume_denied_delete = $this->_query(" delete from `alice_resume_denied` where `wr_id` = '".$mb_id."' ");

							// 04. 맞춤 검색정보 삭제
							$alice_alba_search_delete = $this->_query(" delete from `alice_alba_search` where `wr_id` = '".$mb_id."' ");

							// 05. 관심기업 정보 삭제
							$alice_favorite_delete = $this->_query(" delete from `alice_resume_favorite` where `wr_id` = '".$mb_id."' ");

							// 06. 입사제안 내용 삭제
							$alice_proposal_delete = $this->_query(" delete from `alice_resume_proposal` where `wr_id` = '".$mb_id."' ");


						} else if($mb_type=='company'){	// 기업 회원

							// 01. 채용공고 삭제
							$employ_delete = " delete from `alice_employ` where `wr_id` = '".$mb_id."' ";

							// 01. 알바공고 삭제
							$alba_delete = $this->_query(" update `alice_alba` set `is_delete` = 1 where `wr_id` = '".$mb_id."' ");

							// 02. 입사지원 정보 삭제
							//$receive_delete = " delete from `alice_receive` where `wr_id` = '".$mb_id."' and `type` in ('become_email','become_online') ";

							// 03. 이력서 열람제한 기업 정보 삭제
							$alba_resume_denied_delete = $this->_query(" delete from `alice_resume_denied` where `mb_id` = '".$mb_id."' ");

							// 04. 맞춤 검색정보 삭제
							$alice_alba_search_delete = $this->_query(" delete from `alice_alba_search` where `wr_id` = '".$mb_id."' ");

							// 05. 입사제안 내용 삭제
							$alice_proposal_delete = $this->_query(" delete from `alice_resume_proposal` where `mb_id` = '".$mb_id."' ");

							// 기업회원 정보 탈퇴처리
							$company_vals['mb_left'] = 1;
							$company_vals['is_delete'] = 1;

							$this->update_company_member($company_vals,$mb_id);


						}


						// 포인트 내역 삭제
						$point_delete = $this->_query(" delete from `alice_point` where `mb_id` = '".$mb_id."' ");

						// 스크랩 삭제
						$scrap_delete = $this->_query(" delete from `alice_scrap` where `mb_id` = '".$mb_id."' ");

						// 게시판 작성글 탈퇴(비회원)회원 으로 업데이트
						//$board_control->articles_outs($mb_id);

						// 쪽지 삭제
						$memo_delete = " delete from `alice_memo` where `mb_id` = '".$mb_id."' ";

						// 회원 필드 초기화
						$mb_vals['mb_ssn'] = "";	// 민번 초기화
						$mb_vals['mb_level'] = 0;
						$mb_vals['mb_point'] = 0;
						//$mb_vals['mb_email'] = "";
						//$mb_vals['mb_phone'] = "";
						//$mb_vals['mb_hphone'] = "";
						$mb_vals['mb_login_count'] = 0;
						$mb_vals['mb_employ_count'] = 0;
						$mb_vals['mb_alba_count'] = 0;
						$mb_vals['mb_resume_count'] = 0;
						$mb_vals['mb_alba_resume_count'] = 0;
						$mb_vals['mb_employ_scrap_count'] = 0;
						$mb_vals['mb_alba_scrap_count'] = 0;
						$mb_vals['mb_board_count'] = 0;
						$mb_vals['mb_comment_count'] = 0;
						$mb_vals['mb_udate'] = $alice['time_ymdhis'];
						$mb_vals['mb_left'] = 1;
						$mb_vals['mb_left_date'] = $alice['time_ymdhis'];
						$mb_vals['mb_photo'] = "";
						$mb_vals['is_delete'] = 1;	// 삭제 여부 체크

						// 회원 테이블 업데이트 (삭제)
						$this->update_member($mb_vals, $mb_id);

						// 회원 서비스 테이블 업데이트
						$service_vals['mb_service_platinum'] = $service_vals['mb_service_prime'] = $service_vals['mb_service_grand'] = $service_vals['mb_service_banner'] = $service_vals['mb_service_list'] = $service_vals['mb_service_logo'] = $service_vals['mb_service_neon'] = $service_vals['mb_service_bold'] = $service_vals['mb_service_color'] = $service_vals['mb_service_icon'] = $service_vals['mb_service_blink'] = $service_vals['mb_service_open'] = $service_vals['mb_service_focus'] = $service_vals['mb_service_busy'] = $service_vals['mb_employ_jump'] = $service_vals['mb_resume_jump'] = $service_vals['mb_alba_jump'] = "0000-00-00";

						$service_vals['mb_service_platinum_count'] = $service_vals['mb_service_prime_count'] = $service_vals['mb_service_grand_count'] = $service_vals['mb_service_banner_count'] = $service_vals['mb_service_list_count'] = $service_vals['mb_service_logo_count'] = $service_vals['mb_service_neon_count'] = $service_vals['mb_service_bold_count'] = $service_vals['mb_service_color_count'] = $service_vals['mb_service_icon_count'] = $service_vals['mb_service_blink_count'] = $service_vals['mb_service_open_count'] = $service_vals['mb_service_focus_count'] = $service_vals['mb_service_busy_count'] = $service_vals['mb_employ_jump_count'] = $service_vals['mb_resume_jump_count'] = $service_vals['mb_alba_jump_count'] = 0;

						$service_delete = $this->service_upate($service_vals,$mb_id);

						// 사진 정보 삭제
						$photo_delete = $this->_query(" delete from `".$this->member_photo_table."` where `mb_id` = '".$mb_id."' ");

						// 디렉토리 파일 삭제
						$utility->rmdirAll( $alice['data_member_abs_path'] . "/" . $mb_id);


					return true;

				}

				// 서비스 정보 업데이트
				function service_upate( $vals, $mb_id ){

					global $utility;

						$val = $utility->QueryString($vals);

						$result = $this->_query(" update `".$this->member_service_table."` set ".$val." where `mb_id` = '".$mb_id."' ");						

					
					return $result;

				}


				// 탈퇴사유 입력
				function reason_insert( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->reason_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}

				// 탈퇴사유 삭제
				function reason_delete( $mb_no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " delete from `".$this->reason_table."` where `reason_no` = '".$mb_no."' ";

						$result = $this->_query($query);


					return $result;

				}


		}	// class end.
?>