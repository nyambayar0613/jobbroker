<?php
		/**
		* /application/nad/member/controller/alice_mail_control.class.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2015/01/13
		* @Module v3.5 ( Alice )
		* @Brief :: Mail Control class
		* @Comment :: 메일 컨트롤 클래스
		*/
		class alice_mail_control extends alice_mail_model {


				// 내용 변환
				function mail_replaces( $mb_email, $mail_content, $mail_skin="", $cs_no="", $employ_no="", $resume_no="", $alba_no="", $alba_resume_no="", $wr_id="", $proposal_no="" ){
					
					global $alice, $env, $logo, $utility;
					global $design_control, $member_control, $user_control, $cs_control, $receive_control, $sms_control;
					//global $employ_control, $resume_control;
					global $alba_control, $alba_resume_control;
					global $alba_company_control;
					global $alba_file_control, $mb_password;

						if($mb_email=='' || !$mb_email) return false;

						$mail_top_logo = $design_control->view_logo($logo['mail'],true);
						$mail_bottom_logo = $design_control->view_logo($logo['mail_bottom'],true);

						$mb = $member_control->get_memberEmail_s($mb_email, $wr_id);  

						$mb_password = $utility->make_passwd();
						$mb_val['mb_password'] = md5($mb_password);						

						$i = 0;
						foreach($mb as $val) {

							$mb_name = $val['mb_name'];
							$mb_email = $val['mb_email'];
							$mb_id = $val['mb_id'];
							$arr_id .= $val['mb_id'].", ";
							$mb_wdate = $val['mb_wdate'];
							if($mail_skin=='member_find'){

								$member_control->update_member($mb_val,$mb_id);
							} else if($mail_skin=='member_password'){
								
								$member_control->update_member($mb_val,$mb_id);
								$member_info = $member_control->get_member($mb_id);	// 회원 정보
								$sms_control->send_sms_user('member_password', $member_info, $mb_password);
							}

							$i++;

						}

						if($cs_no!='') $get_cs = $cs_control->get_cs($cs_no);

						/*
						if($employ_no){	 // 채용공고
							$get_employ = $employ_control->get_employ($employ_no);
							$wr_subject = stripslashes($get_employ['wr_subject']);
						}
						if($resume_no){	 // 이력서
							$get_resume = $resume_control->get_resume($resume_no);
							$wr_subject = stripslashes($get_resume['wr_subject']);
						}
						*/

						if($alba_no){	// 알바 공고
							$get_alba = $alba_control->get_alba($alba_no);
							$wr_subject = stripslashes($get_alba['wr_subject']);
							$become_employ = "<a href='http://".$_SERVER['HTTP_HOST']."/alba/alba_detail.php?no=".$alba_no."' target='_blank'>".stripslashes($get_alba['wr_subject'])."</a>";
							$wr_content = stripslashes($get_alba['wr_content']);
							$wr_company_name = stripslashes($get_alba['wr_company_name']);
						}
						
						if($alba_resume_no){	 // 알바 이력서
							$get_alba_resume = $alba_resume_control->get_resume($alba_resume_no);
							$wr_id = $get_alba_resume['wr_id'];
							$get_member = $member_control->get_member($wr_id);	// 회원 정보
							$become_resume = "<a href='http://".$_SERVER["HTTP_HOST"]."/resume/alba_resume_detail.php?no=".$alba_resume_no."' target='_blank'>".stripslashes($get_alba_resume['wr_subject'])."</a>";
						} else {	 // 회사 자사양식
							$get_member = $member_control->get_member($wr_id);	// 회원 정보
							$become_resume = "자사양식으로 지원";
						}
						$mb_gender_txt = $user_control->mb_gender_txt[$get_member['mb_gender']];	// 성별
						$mb_birth = explode('-',$get_member['mb_birth']);
						$become_name = $get_member['mb_name'] . "(" . $mb_gender_txt . ", " . $mb_birth[0] . "년생)";

						$receive_query = " where `wr_id` = '".$wr_id."' and `wr_to` = '".$alba_no."' ";
						if($mail_skin=='email_become'){
							$receive_query .= " and `type` = 'become_email' ";
						} else if($mail_skin=='online_become'){
							$receive_query .= " and `type` = 'become_online' ";
						}
						$receive_info = $receive_control->get_receive_info($receive_query);	// 지원 정보
						$receive_info_etc_1 = explode(",",$receive_info['etc_1']);	 // 수신항목 확인
						$become_phone = ( @in_array('mb_phone',$receive_info_etc_1) ) ? $get_member['mb_phone'] : "[비공개]";
						$become_hphone = ( @in_array('mb_hphone',$receive_info_etc_1) ) ? $get_member['mb_hphone'] : "[비공개]";
						$become_email = ( @in_array('mb_email',$receive_info_etc_1) ) ? $get_member['mb_email'] : "[비공개]";
						$become_homepage = ( @in_array('mb_homepage',$receive_info_etc_1) ) ? $get_member['mb_homepage'] : "[비공개]";

						$receive_info_etc_2 = explode("/",$receive_info['etc_2']);	 // 자사지원양식
						if($receive_info['etc_2']){
							$file_ext = $utility->get_extension($receive_info_etc_2[1]);
							$become_form = "<a href='http://".$_SERVER["HTTP_HOST"] . "/data/email/" . $receive_info['etc_2']."' target='_blank'>".$get_member['mb_name']."_이력서.".$file_ext."</a>";
						} else {
							$become_form = "첨부된 지원양식이 없습니다.";
						}
						$receive_info_etc_3 = explode("/",$receive_info['etc_3']);	 // 첨부파일
						if($receive_info['etc_3']){
							$become_file = "<a href='http://".$_SERVER["HTTP_HOST"] . "/data/email/" . $receive_info['etc_3']."' target='_blank'>이력서첨부파일</a>";
						} else {
							$become_file = "첨부된 파일이 없습니다.";
						}
						
						$receive_info_etc_5 = explode(",",$receive_info['etc_5']);	 // 첨부파일
						$receive_info_etc_5_cnt = count($receive_info_etc_5);
						if($receive_info['etc_5']){
							$receive_info_etc_5_arr = array();
							for($i=0;$i<$receive_info_etc_5_cnt;$i++){
								$get_file = $alba_file_control->get_file($receive_info_etc_5[$i]);
								$receive_info_etc_5_arr[$i] = "<a href='http://".$_SERVER["HTTP_HOST"] . "/data/alba/" . $get_file['wr_content']."' target='_blank'>".$get_file['wr_source']."</a>";
							}
							$etc_5_file = @implode($receive_info_etc_5_arr,"<br/>");
						} else {
							$etc_5_file = "첨부된 파일이 없습니다.";
						}

						$receive_wdate = substr($receive_info['wdate'],0,16);
						$become_date = strtr($receive_wdate,'-','.');
						$become_answer = nl2br(stripslashes($receive_info['wr_content']));
						
						$get_proposal = $alba_company_control->get_proposal($proposal_no);

						$trans = array(
							// 공통 치환문자
							"{메일상단로고}" => $mail_top_logo, 
							"{메일하단로고}" => $mail_bottom_logo,
							"{메일하단}" => stripslashes($env['email_bottom']), 
							"{사이트명}" => stripslashes($env['site_name']), 
							"{회원이름}" => $mb_name, 
							"{회원아이디}" => $arr_id ? $arr_id : $mb_id, 
							"{아이디}" => $mb_id,
							"{비밀번호}" => $mb_password,
                            "{이메일}" => $mb_email,
							"{가입일시}" => $mb_wdate,
							"{문의등록일}" => $get_cs['wr_date'],
							"{문의답변일}" => $get_cs['wr_adate'],
							"{문의제목}" => stripslashes($get_cs['wr_subject']),
							"{문의내용}" => stripslashes($get_cs['wr_content']),
							"{답변내용}" => stripslashes($get_cs['wr_acontent']),
							"{기업명}" => $wr_company_name,
							"{보낸사람}" => $mb_name,
							"{전달메시지}" => $mail_content,
							"{도메인}" => 'http://'.$_SERVER['HTTP_HOST'],
							"{오늘날짜}" => date("Y/m/d"),

							// 입사지원 치환문자
							"{알바공고}" => $become_employ,
							"{알바이력서}" => $become_resume,
							// "<a href='".$alice['url']."/alba/alba_detail.php?no=".$alba_resume_no."' target='_blank'>".stripslashes($get_alba_resume['wr_subject'])."</a>";
							// http://alba.netfu.co.kr/n_alba/resume/alba_resume_detail.php?no=28
							"{지원자아이디}" => $wr_id,
							"{지원자명}" => $become_name,
							"{지원자전화번호}" => $become_phone,
							"{지원자휴대폰}" => $become_hphone,
							"{지원자이메일}" => $become_email,
							"{지원자홈페이지}" => $become_homepage,
							"{자사양식}" => $become_form,
							"{지원첨부파일}" => $become_file,
							"{파일첨부}" => $etc_5_file,
							"{지원일}" => $become_date ? $become_date : date('Y.m.d'),
							"{사전질문답변}" => $become_answer,

							"{담당자명}" => $get_alba['wr_person'],
							"{담당자전화번호}" => $get_alba['wr_phone'],
							"{담당자휴대폰}" => $get_alba['wr_hphone'],
							"{담당자이메일}" => $get_alba['wr_email'],
							"{면접제의내용}" => $get_proposal['wr_content'],
							"{입사지원내용}" => $get_proposal['wr_content'],

						);

						$result = strtr($mail_content, $trans);


					return $result;

				}


				// DB 에 있는 내용이 아닌, 사용자가 직접 입력한 content 가 있는 내용 치환
				function content_mail_replace( $mb_id="", $send_mail, $receive_mail, $mail_content="", $content="", $cs_no="", $employ_no="", $resume_no="", $alba_no="", $alba_resume_no="" ){

					global $alice, $env, $logo, $utility;
					global $design_control, $member_control, $user_control, $cs_control;
					//global $employ_control, $resume_control;
					global $alba_control, $alba_resume_control;

						$mail_top_logo = $design_control->view_logo($logo['mail'],true);						// 메일 상단 로고
						$mail_bottom_logo = $design_control->view_logo($logo['mail_bottom'],true);		// 메일 하단 로고

						$get_member = $member_control->get_member($mb_id);	// 회원 정보
						if($get_member){	// 회원
							$mb_name = $get_member['mb_name'];
							$mb_email = $get_member['mb_email'];
							$mb_id = $get_member['mb_id'];
							$mb_wdate = $get_member['mb_wdate'];
							if($mail_skin=='member_find'){
								$mb_password = $utility->make_passwd();
								$mb_val['mb_password'] = md5($mb_password);
								$member_control->update_member($mb_val,$mb_id);
							}
						} else {	 // 비회원
							$mb_name = $mb_wdate = "비회원";
							$mb_email = $send_mail;
						}

						if($cs_no!='') $get_cs = $cs_control->get_cs($cs_no);

						/*
						if($employ_no){	 // 채용공고
							$get_employ = $employ_control->get_employ($employ_no);
							$wr_subject = stripslashes($get_employ['wr_subject']);
						}
						if($resume_no){	 // 이력서
							$get_resume = $resume_control->get_resume($resume_no);
							$wr_subject = stripslashes($get_resume['wr_subject']);
						}
						*/
						if($alba_no){	// 알바 공고
							$get_alba = $alba_control->get_alba($alba_no);
							$wr_subject = stripslashes($get_alba['wr_subject']);
							$wr_content = stripslashes($get_alba['wr_content']);
							$wr_company_name = stripslashes($get_alba['wr_company_name']);
						}
						if($alba_resume_no){	 // 알바 이력서
							$get_alba_resume = $alba_control->get_alba($alba_resume_no);
							$wr_subject = stripslashes($get_alba_resume['wr_subject']);
							$wr_content = stripslashes($get_alba_resume['wr_content']);
							$wr_company_name = stripslashes($get_alba_resume['wr_company_name']);
							$resume_content = stripslashes($this->mail_resume_content($alba_resume_no));	 // 이력서 내용
						}

						$trans = array(
							// 공통 치환문자
							"{메일상단로고}" => $mail_top_logo, 
							"{메일하단로고}" => $mail_bottom_logo, 
							"{메일하단}" => stripslashes($env['email_bottom']), 
							"{사이트명}" => stripslashes($env['site_name']), 
							"{회원이름}" => $mb_name, 
							"{회원아이디}" => $mb_id, 
							"{아이디}" => $mb_id,
							"{비밀번호}" => $mb_password,
                            "{이메일}" => $mb_email,
							"{가입일시}" => $mb_wdate,
							"{문의등록일}" => $get_cs['wr_date'],
							"{문의답변일}" => $get_cs['wr_adate'],
							"{문의제목}" => stripslashes($get_cs['wr_subject']),
							"{문의내용}" => stripslashes($get_cs['wr_content']),
							"{답변내용}" => stripslashes($get_cs['wr_acontent']),
							"{기업명}" => $wr_company_name,
							"{보낸사람}" => $mb_name,
							"{전달메시지}" => nl2br(stripslashes($content)),

							// 알바공고 치환문자
							"{알바공고}" => "알바공고 내용 스킨",

							// 알바이력서 치환문자
							"{알바이력서}" => $resume_content,
						);

						$result = strtr($mail_content, $trans);


					return $result;

				}


		}	// class end.
?>