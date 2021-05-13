<?php
		/**
		* /application/nad/member/controller/alice_mailing_control.class.php
		* @author Harimao
		* @since 2015/03/10
		* @last update 2015/04/09
		* @Module v3.5 ( Alice )
		* @Brief :: Mailing Control class
		* @Comment :: 메일링 회원 관리 컨트롤 클래스
		*/
		class alice_mailing_control extends alice_mailing_model {


				/**
				* 메일링 환경설정 정보 입력
				*/
				function insert_config( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->mailing_config_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}

				
				/**
				* 메일링 환경설정 정보 수정 :: no 기준
				*/
				function update_config( $vals, $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->mailing_config_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 메일링 데이터 입력
				*/
				function insert_mailing_list( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->mailing_list_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 메일링 데이터 입력
				*/
				function insert_mailing( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->mailing_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 메일링 자동발송
				* 기업회원 : 맞춤 인재정보
				* 개인회원 : 맞춤 채용정보
				*/
				function auto_mailing( $no ){

					global $alice, $env;
					global $member_control, $alba_company_control, $alba_individual_control;
					global $mailer, $sms_control;


						$get_config = $this->get_config( $no );

						$sms_config = $sms_control->sms_config(1);

						$mail_time = $get_config['wr_mail_time'];	// 메일 발송시간
						$mail_time_arr = array( 
							1 => array( "stime" => '06:00:00', "etime" => '11:59:59' ),
							2 => array( "stime" => '13:00:00', "etime" => '17:59:59' ),
							3 => array( "stime" => '18:00:00', "etime" => '23:59:59' ),
						);
						$mail_stime = explode(":",$mail_time_arr[$mail_time]['stime']);
						$mail_etime = explode(":",$mail_time_arr[$mail_time]['etime']);

						// (기업회원) 맞춤 인재정보 SMS 설정정보
						$sms_company = unserialize($get_config['wr_sms_company']);	
						$sms_company_content = $sms_company['content'];
						$sms_company_use = $sms_company['use'];

						// (개인회원) 맞춤 채용정보 SMS 설정정보
						$sms_individual = unserialize($get_config['wr_sms_individual']);
						$sms_individual_content = $sms_individual['content'];
						$sms_individual_use = $sms_individual['use'];


						if($get_config['wr_mail_use']){	// 메일링 사용

							// 오늘 발송한 메일링이 있는지 확인
							$mailing_query = $this->_queryR(" select * from `".$this->mailing_table."` where `wr_mail_date` = '".$alice['time_ymd']."' ");

							// 없으면 발송
							if(!$mailing_query){

								// 시간 체크
								$now_mtime = mktime(date('H'), date('i'), 0, date("m"), date('d'), date('Y'));
								$stime_mtime = mktime($mail_stime[0], $mail_stime[1], 0, date("m"), date('d'), date('Y'));
								$etime_mtime = mktime($mail_etime[0], $mail_etime[1], 0, date("m"), date('d'), date('Y'));

								if( $now_mtime >= $stime_mtime && $now_mtime <= $etime_mtime ){

									$mail_count = 0;
									$sms_count = 0;

									/* 맞춤인재 정보 수신 기업회원 리스트 */
									$company_custom_list = $alba_company_control->__CustomList();
									if($company_custom_list['total_count']){
										foreach($company_custom_list['result'] as $val){
											$mb = $member_control->get_member($val['wr_id']);
											$mb_receive = explode(",",$mb['mb_receive']);	// 수신여부
											if( $get_config['wr_mail_auto'] && @in_array('email', $mb_receive) ){	// 이메일 수신시
												$company_mail_msg = $this->auto_make_Mail('company', $val);
												//echo $env['site_name']." ".$env['email']." ".$mb['mb_email']." ".$mb['mb_name']."님께서 신청하신 ".date('Y')."년 ".date('m')."월 ".date('d')."일 맞춤인재 정보입니다. ".stripslashes($company_mail_msg['company_mailing']);
												$mail_subject = $mb['mb_name']."님께서 신청하신 ".date('Y')."년 ".date('m')."월 ".date('d')."일 맞춤인재 정보입니다.";
												$mailer->sendMail($env['site_name'], $env['email'], $mb['mb_email'], $mail_subject, stripslashes($company_mail_msg['company_mailing']), 1);
												
												$mailing_mail['wr_type'] = "email";
												$mailing_mail['wr_id'] = $mb['mb_id'];
												$mailing_mail['wr_mb_type'] = "company";
												$mailing_mail['wr_subject'] = $mail_subject;
												$mailing_mail['wr_content'] = $company_mail_msg['company_mailing'];
												$mailing_mail['wr_wdate'] = $alice['time_ymdhis'];
												$this->insert_mailing_list($mailing_mail);

											$mail_count++;
											}
											if( $get_config['wr_sms_auto'] && @in_array('sms', $mb_receive) && $sms_config['lms_use'] ){	// SMS 수신 / LMS 사용시에만
												$sms_msg = $this->auto_make_Sms('company', $val);
												$destination = $mb['mb_hphone']. "|" . $mb['mb_name'];
												$sms_control->netfu_sms_Send( $sms_msg['company_msg'], $mb['mb_hphone'], $env['call_center'], $destination, $mb );
												
												$mailing_sms['wr_type'] = "sms";
												$mailing_sms['wr_id'] = $mb['mb_id'];
												$mailing_mail['wr_mb_type'] = "company";
												$mailing_sms['wr_content'] = $sms_msg['company_msg'];
												$mailing_sms['wr_wdate'] = $alice['time_ymdhis'];
												$this->insert_mailing_list($mailing_sms);

											$sms_count++;
											}
										}
									}
									/* // 맞춤인재 정보 수신 기업회원 리스트 */


									/* 맞춤채용 정보 메일 수신 개인회원 리스트 */
									$individual_custom_list = $alba_individual_control->__CustomList();
									if($individual_custom_list['total_count']){
										foreach($individual_custom_list['result'] as $val){
											$mb = $member_control->get_member($val['wr_id']);
											$mb_receive = explode(",",$mb['mb_receive']);	// 수신여부
											if( $get_config['wr_mail_auto'] && @in_array('email', $mb_receive) ){	// 이메일 수신시
												$individual_mail_msg = $this->auto_make_Mail('individual', $val);
												//echo $env['site_name']." @@@ ".$env['email']." @@@ ".$mb['mb_email']." @@@ ".$mb['mb_name']."님께서 신청하신 ".date('Y')."년 ".date('m')."월 ".date('d')."일 맞춤채용 정보입니다. @@@ ".stripslashes($individual_mail_msg['individual_mailing']);
												//exit;
												$mail_subject = $mb['mb_name']."님께서 신청하신 ".date('Y')."년 ".date('m')."월 ".date('d')."일 맞춤채용 정보입니다.";
												$mailer->sendMail($env['site_name'], $env['email'], $mb['mb_email'], $mail_subject, stripslashes($individual_mail_msg['individual_mailing']), 1);

												$mailing_mail['wr_type'] = "email";
												$mailing_mail['wr_id'] = $mb['mb_id'];
												$mailing_mail['wr_mb_type'] = "individual";
												$mailing_mail['wr_subject'] = $mail_subject;
												$mailing_mail['wr_content'] = $individual_mail_msg['individual_mailing'];
												$mailing_mail['wr_wdate'] = $alice['time_ymdhis'];
												$this->insert_mailing_list($mailing_mail);
											$mail_count++;
											}
											if( $get_config['wr_sms_auto'] && @in_array('sms', $mb_receive) && $sms_config['lms_use'] ){	// SMS 수신 / LMS 사용시에만
												$sms_msg = $this->auto_make_Sms('individual', $val);
												$destination = $mb['mb_hphone']. "|" . $mb['mb_name'];
												$sms_control->netfu_sms_Send( $sms_msg['individual_msg'], $mb['mb_hphone'], $env['call_center'], $destination, $mb );

												$mailing_sms['wr_type'] = "sms";
												$mailing_sms['wr_id'] = $mb['mb_id'];
												$mailing_mail['wr_mb_type'] = "individual";
												$mailing_sms['wr_content'] = $sms_msg['individual_msg'];
												$mailing_sms['wr_wdate'] = $alice['time_ymdhis'];
												$this->insert_mailing_list($mailing_sms);

											$sms_count++;
											}
										}
									}
									/* // 맞춤인재 정보 수신 기업회원 리스트 */


									
									// 메일 전송 유무
									$vals['wr_mail'] = 1;
									$vals['wr_mail_date'] = $alice['time_ymd'];
									$vals['wr_mail_time'] = $alice['time_ymdhis'];
	

									// SMS 전송 유무
									$vals['wr_sms'] = 1;
									$vals['wr_sms_date'] = $alice['time_ymd'];
									$vals['wr_sms_time'] = $alice['time_ymdhis'];

									
									$vals['wr_total'] = $mail_count."/".$sms_count;	 // 총 전송건수 (mail/sms)
									$vals['wr_wdate'] = $alice['time_ymdhis'];	// 전송일

									$this->insert_mailing($vals);

								}

							}

							//echo $mailing_query."<Br/>";

						}

				}


		}	// class end.
?>