<?php
		/**
		* /application/nad/service/controller/alice_sms_control.class.php
		* @author Harimao
		* @since 2013/06/26
		* @last update 2015/04/13
		* @Module v3.5 ( Alice ) - s1.0
		* @Brief :: SMS Control Class
		* @Comment :: SMS 설정 컨트롤 클래스
		*/
		class alice_sms_control extends alice_sms_model {


				/**
				* SMS 설정 정보 수정
				*/
				function update_sms_config( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->sms_config_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 서비스 정보 입력
				*/
				function insert_sms( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->sms_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 서비스 정보 수정
				*/
				function update_sms( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->sms_service."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* SMS 메시지 정보 수정
				*/
				function update_sms_msg_config( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->sms_msg_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

				
				/**
				* SMS 발송 (관리자 - 회원관리 - 다량 발송)
				*/
				function send_sms_Members( $msg, $rphone_list, $sphone ){

					global $member_control;

						$sms_config = $this->sms_config(1);

						$destination = $rphone_list;

						$rphone_list = explode(',',$rphone_list);
						$rphone_list_cnt = count($rphone_list);
						
						$rphone = array();
						for($i=0;$i<$rphone_list_cnt;$i++){
							$rphone_list_exp = explode('|',$rphone_list[$i]);
							$member = $member_control->get_member($rphone_list_exp[2]);
							$msg_replace = $this->msg_replace($msg, 'admin msg', $member);	// 발송 내용 생성
							$result = $this->netfu_sms_Send( $msg_replace['msg'], $rphone_list_exp[0], $sphone, $destination );
							//array_push($rphone,$rphone_list_exp[0]);
						}

						//$rphones = implode($rphone,',');

						//$result = $this->netfu_sms_Send( $msg, $rphones, $sphone, $destination );


					return $result;
				}


				/**
				* SMS 발송 (회원 - 상황별 문자발송)
				*/
				function send_sms_user( $msg_type, $member="", $mb_password="", $datas="", $mb_receive="" ){

					global $env;
					global $admin_control;

						$admin_info = $admin_control->get_level_admin(10);

						$sms_config = $this->sms_config(1);

						$sphone = $sms_config['sms_admin_num'];  //sms 환경설정에서 발신번호 가져옴

						$msg_config = $this->get_config_for_type($msg_type);

						$msg_use = $msg_config['msg_use'];	// 사용 유무


						if($msg_use && ($sms_config['sms_use'] || $sms_config['lms_use'])){	// 상황별문자 사용시, 문자발송 시스템 사용시

							$msg_content = $msg_config['msg_content'];	// 사용자 발송 메시지
							$msg_admin_content = $msg_config['msg_admin_content'];	// 관리자 발송 메시지

							$datas['msg_type'] = $msg_type;
							$datas['data'] = $datas;

							$msg_replace = $this->msg_replace($msg_content, $msg_admin_content, $member, $mb_password, $datas );	// 발송 내용 생성

							$destination = $member['mb_hphone']. "|" . $member['mb_name'];

							//if(@in_array('sms',$mb_receive)){	 // 문자 수신 확인
							if($msg_config['msg_is_user']) {  // 수신자 발송 체크되었다면 발솔
								$result = $this->netfu_sms_Send( $msg_replace['msg'], $member['mb_hphone'], $sphone, $destination, $member );	// 우선 회원한테 발송
							}
							//}

							if($msg_config['msg_is_admin']){	// 관리자에게도 발송한다면

								$destination = $sms_config['sms_admin_num']. "|관리자";

								$datas['mb_name'] = "관리자";

								$result = $this->netfu_sms_Send( $msg_replace['admin_msg'], $sms_config['sms_admin_num'], $sphone, $destination, $datas );

							}

						} else {	 // 사용하지 않으면 false

							$result = false;

						}
					

					return $result;

				}


				/**
				* SMS 전송내역 입력
				*/
				function insert_log( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->sms_log_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* SMS 전송내역 수정
				*/
				function update_log( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->sms_log_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* SMS 전송내역 삭제 :: no 기준
				*/
				function delete_log( $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " delete from `".$this->sms_log_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* SMS 발송 (값을 배열로 받음)
				* 
				*/
				function sms_seding( $vals ){
				
					global $alice, $env;
					global $member_control;


						$result = array();

						$mb_sms = 1;
						$mb_lms = $mb_sms * 3;	// lms 는 sms 의 3배

						$wr_id = $vals['wr_id'];
						$wr_receive = $vals['wr_receive'];

						$get_member = $member_control->get_member($wr_id);	// 회원 정보 추출
						$get_service_member = $member_control->get_service_member($wr_id);	// 회원 서비스 정보 추출

						$receive_member = $member_control->get_member($wr_receive);

						$msg = $vals['msg'];
						$rphone = $vals['rphone'];
						$sms_config = $this->sms_config(1);
						$sphone = $sms_config['sms_admin_num'];  //sms 환경설정에서 발신번호 가져옴
						$destination = $vals['destination'];


						$sms_ord = $this->netfu_sms_Ord();	// 잔여건수 조회
						if(strlen($msg) > 120){
							$wr_type = "lms";
							$use_sms = $mb_lms;
						} else {
							$wr_type = "sms";
							$use_sms = $mb_sms;
						}


						// 사이트 전체 건수 확인
						if( $sms_ord < $use_sms ){
							$result['result'] = "error";
							$result['msg'] = "0006";	// 사이트 전체 SMS 충전 건수가 부족합니다.\n\n사이트 운영자에게 문의하세요.
						} else {	 // 회원 소유 포인트 확인
							if( $sms_ord < $member['mb_sms'] ){
								$result['result'] = "error";
								$result['msg'] = "0007";	// SMS 충전 건수가 부족합니다.\n\nSMS 발송 건수를 충전해 주세요.
							} else {

								// 최종 발송
								$sms_send = $this->netfu_sms_Send( $msg, $rphone, $sphone, $destination );
								$send_result = explode("/",$sms_send);

								// 전송 성공
								if($send_result[0]=='success'){	// 결과 DB 입력
									$send_data = json_decode($send_result[2]);
									$log_vals['wr_type'] = $wr_type;
									$log_vals['wr_status'] = 1;	// 0 : 전송대기, 1 : 전송완료, 2 : 전송실패
									$log_vals['wr_id'] = $wr_id;
									$log_vals['wr_name'] = $get_member['mb_name'];
									$log_vals['wr_sphone'] = $sphone;
									$log_vals['wr_receive'] = $wr_receive;
									$log_vals['wr_receive_name'] = $vals['wr_person'];
									$log_vals['wr_rphone'] = $rphone;
									$log_vals['wr_content'] = $msg;
									$log_vals['wr_wdate'] = $alice['time_ymdhis'];
									
									$this->insert_log($log_vals);	 // SMS 전송 로그 저장

									$mb_vals['mb_sms'] = $get_member['mb_sms'] - $use_sms;
									$mb_vals['mb_udate'] = $alice['time_ymdhis'];
									$member_control->update_member($mb_vals,$wr_id);	// 회원 테이블 mb_sms 카운트 조절

									$mb_service_vals['mb_service_sms_count'] = $mb_vals['mb_sms'];
									$member_control->service_upate($mb_service_vals,$wr_id);	// 회원 서비스 테이블 sms 카운트 조절

									$result['result'] = "success";
									$result['msg'] = "0002";	//$this->_success('0002');	// 성공적으로 SMS 문자를 발송하였습니다.
								} else {	 // 실패
									$result['result'] = "error";
									$result['msg'] = "0005";	//$this->_errors('0005');	// SMS 발송중 오류가 발생하였습니다.
								}

							}
						}

					
					return $result;

				}


		}	// class end.
?>