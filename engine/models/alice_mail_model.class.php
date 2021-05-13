<?php
		/**
		* /application/nad/member/model/alice_mail_model.class.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2015/01/13
		* @Module v3.5 ( Alice )
		* @Brief :: Mail Model Class
		* @Comment :: 메일 모델 클래스
		*/
		class alice_mail_model extends DBConnection {

			var $member_table	= "alice_member";
			var $mail_table			= "alice_send_mail";
			var $mail_skin_table	= "alice_mail_skin";

			var $success_code = array(
					'0000' => '메일 전송이 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '메일 제목을 입력해 주세요.',
					'0001' => '메일 내용을 입력해 주세요.',
			);


				// 메일 내용 생성 => 발송
				// 메일 스킨을 불러와 기본 메일 내용을 생성해 발송한다.
				function make_mail_Send( $mail_type, $email, $wr_id='' ){

					global $alice, $env;
					global $design_control;
					global $mailer;

						$mail_skins = ($mail_type=='member_password') ? "member_find" : $mail_type;

						$mail_skin = $design_control->get_mail_skin($mail_skins);

						$subject_arr = array( 
							"member_regist" => "[".$env['site_name'] . "] 회원가입을 축하합니다.", 
							"member_find" => "[".$env['site_name']."] 문의하신 회원 아이디/비밀번호 입니다.", 
							"member_password" => "[".$env['site_name']."] 문의하신 회원 아이디/비밀번호 입니다.", 
						);

						$mail_content = $mail_skin['content'];

						$content = $this->mail_replaces( $email, $mail_content, $mail_type,'','','','','', $wr_id );  

						$result = $mailer->sendMail($env['site_name'], $env['email'], $email, $subject_arr[$mail_type], stripslashes($content), 1);

					
					return $result;

				}

				// 메일 내용 생성 => 발송
				// 메일 스킨을 불러와 기본 메일 내용을 생성해 발송한다.
				function mail_seding( $mail_type, $email, $subject="", $cs_no="", $employ_no="", $resume_no="", $alba_no="", $alba_resume_no="", $wr_id="", $proposal_no="" ){	// 별도의 subject

					global $alice, $env;
					global $design_control;
					global $mailer;

						$mail_skin = $design_control->get_mail_skin($mail_type);

						$mail_content = $mail_skin['content'];

						$content = $this->mail_replaces( $email, $mail_content, $mail_type, $cs_no, $employ_no, $resume_no, $alba_no, $alba_resume_no, $wr_id, $proposal_no );

						$result = $mailer->sendMail($env['site_name'], $env['email'], $email, $subject, stripslashes($content), 1);

					
					return $result;

				}

				// 보내는 메일 주소, 받는 메일 주소 포함
				// 주로 내용을 전달할때 사용
				function mail_sedings( $mail_type, $send_email, $receive_mail, $subject="", $mail_content="", $cs_no="", $employ_no="", $resume_no="", $alba_no="", $alba_resume_no="", $wr_id="" ){

					global $alice, $env;
					global $design_control;
					global $mailer;

						$content = $this->mail_replaces( $send_email, $mail_content, $mail_type, $cs_no, $employ_no, $resume_no, $alba_no, $alba_resume_no, $wr_id );

						$result = $mailer->sendMail($env['site_name'], $send_email, $receive_mail, $subject, nl2br(stripslashes($content)), 1);

					
					return $result;

				}


				// 메일 내용 생성 => 발송
				// 치환 문자를 사용하며, 별도의 내용을 작성하여 발송하는 경우 사용
				function Send_Mail( $mb_id, $mail_type, $send_email, $receive_email, $send_name, $subject="", $content="", $data_no="" ){

					global $alice, $env;
					global $design_control;
					global $mailer;

						$mail_skin = $design_control->get_mail_skin($mail_type);

						$mail_content = $mail_skin['content'];

						$content = $this->content_mail_replace( $mb_id, $send_email, $receive_email, $mail_content, $content, "", "", "", "", $data_no );	// 이력서 data_no
			
						$result = $mailer->sendMail($env['site_name'], $send_email, $receive_email, $subject, stripslashes($content), 1);


					return $result;

				}




				// 정규직 이력서 메일 내용 생성
				function mail_resume_content( $no ){

					global $alice , $env;
					global $alba_resume_control, $category_control, $alba_individual_control, $user_control;
					global $host_name, $utility;

						if(!$no || $no=='') return false;

						$get_resume = $alba_resume_control->get_resume($no);	// 이력서 정보

						$wr_udate = substr($get_resume['wr_udate'],0,11);	// 수정일
						$wr_subject = stripslashes($get_resume['wr_subject']);
						$wr_calltime = explode('-',$get_resume['wr_calltime']);
						$wr_school_ability = explode('/',$get_resume['wr_school_ability']);
						$wr_school_ability = $category_control->get_categoryCode($wr_school_ability[0]);

						/* 경력사항 */
						$wr_career = unserialize($get_resume['wr_career']);
						if($wr_career){
							$period = "";
							foreach($wr_career as $key => $val){
								$sdate = $val['sdate'];
								$sdate_exp = explode('-',$sdate);
								$edate = $val['edate'];
								$edate_exp = explode('-',$edate);
								$period =+ $utility->date_diff($sdate,$edate);
							}
							$periods = round(($period/30),1);
							$periods_exp = explode('.',$periods);
							if($periods_exp[0] >= 12){
								$career_period_year = round(($periods_exp[0] / 12),0);
								$career_period_month = round($periods_exp[1],0);
							}
							$career_periods = "약 " . $career_period_year . "년 " . $career_period_month . "개월";
						} else {
							$career_periods = "없음";
						}
						/* //경력사항 */

						
						/* 희망급여 */
						if($get_resume['wr_pay_conference']){
							$pay_type = "추후협의";
						} else {
							$wr_pay_type = $category_control->get_categoryCode($get_resume['wr_pay_type']);
							$pay_type = $wr_pay_type['name']." ".number_format($get_resume['wr_pay'])."원";
						}
						/* //희망급여 */


						/* 자격증 */
						$license = "";
						if($get_resume['wr_license']){
							$wr_license = unserialize($get_resume['wr_license']);
							$wr_license_cnt = count($wr_license);
							if($wr_license){
								foreach($wr_license as $key => $val){
									if($key==0){
										$license .= $val['name'];
									}
								}
								if($wr_license_cnt >= 2){
									$license .= " 외 " . ($wr_license_cnt-1) . "개";
								}
							} else {
								$license .= "없음";
							}
						} else {
							$license .= "없음";
						}
						/* //자격증 */


						/* 외국어능력 */
						$language = "";
						if($get_resume['wr_language']){
							$wr_language = unserialize($get_resume['wr_language']);
							$wr_language_cnt = count($wr_language);
							if($wr_language){
								foreach($wr_language as $key => $val){
									$language_val = $category_control->get_categoryCode($val['language']);
									if($key==0){
										$language .= $language_val['name'];
										$language_icon = $alba_individual_control->language_level[$val['level']]['icon'];
										$language_name = $alba_individual_control->language_level[$val['level']]['name'];
										$language .= "<em class=\"pl5 vt\"><img src=\"http://" . $host_name . "/images/icon/".$language_icon."\" width=\"17\" height=\"14\" alt=\"".$language_name."\" /></em>";
									}
								}
								if($wr_language_cnt >= 2){
									$language .= " 외 " . ($wr_language_cnt-1) . "개국어";
								}
							} else {
								$language .= "없음";
							}
						} else {
							$language .= "없음";
						}
						/* //외국어능력 */


						/* 희망근무지 */
						// 1차 지역
						$wr_area0 = $category_control->get_categoryCodeName($get_resume['wr_area0']);
						$wr_area1 = $category_control->get_categoryCodeName($get_resume['wr_area1']);
						if($wr_area0){
							$wr_area_0 = "<li><a href=\"#\">";
							if($wr_area0) $wr_area_0 .= $wr_area0;
							if($wr_area1) $wr_area_0 .= " " . $wr_area1;
							$wr_area_0 .= "</a></li>";
						}
						// 2차 지역
						$wr_area2 = $category_control->get_categoryCodeName($get_resume['wr_area2']);
						$wr_area3 = $category_control->get_categoryCodeName($get_resume['wr_area3']);
						if($wr_area2){
							$wr_area_1 = ", <li><a href=\"#\">";
							if($wr_area2) $wr_area_1 .= $wr_area2;
							if($wr_area3) $wr_area_1 .= " " . $wr_area3;
							$wr_area_1 .= "</a></li>";
						}
						// 3차 지역
						$wr_area4 = $category_control->get_categoryCodeName($get_resume['wr_area4']);
						$wr_area5 = $category_control->get_categoryCodeName($get_resume['wr_area5']);
						if($wr_area4){
							$wr_area_2 = ", <li><a href=\"#\">";
							if($wr_area4) $wr_area_2 .= $wr_area4;
							if($wr_area5) $wr_area_2 .= " " . $wr_area5;
							$wr_area_2 .= "</a></li>";
						}
						/* //희망근무지 */


						/* 희망 근무직종 */
						// 1차 근무직종
						$wr_job_type0 = $category_control->get_categoryCodeName($get_resume['wr_job_type0']);
						$wr_job_type1 = $category_control->get_categoryCodeName($get_resume['wr_job_type1']);
						$wr_job_type2 = $category_control->get_categoryCodeName($get_resume['wr_job_type2']);
						if($wr_job_type0){
							$wr_job_type_0 = "<li>";
							if($wr_job_type0) $wr_job_type_0 .= $wr_job_type0;
							if($wr_job_type1) $wr_job_type_0 .= "·" . $wr_job_type1;
							if($wr_job_type2) $wr_job_type_0 .= "·" . $wr_job_type2;
							$wr_job_type_0 .= "</li>";
						}
						// 2차 근무직종
						$wr_job_type3 = $category_control->get_categoryCodeName($get_resume['wr_job_type3']);
						$wr_job_type4 = $category_control->get_categoryCodeName($get_resume['wr_job_type4']);
						$wr_job_type5 = $category_control->get_categoryCodeName($get_resume['wr_job_type5']);
						if($wr_job_type3){
							$wr_job_type_1 = " , <li>";
							if($wr_job_type3) $wr_job_type_1 .= $wr_job_type2;
							if($wr_job_type4) $wr_job_type_1 .= "·" . $wr_job_type3;
							if($wr_job_type5) $wr_job_type_1 .= "·" . $wr_job_type4;
							$wr_job_type_1 .= "</li>";
						}
						// 3차 근무직종
						$wr_job_type6 = $category_control->get_categoryCodeName($get_resume['wr_job_type6']);
						$wr_job_type7 = $category_control->get_categoryCodeName($get_resume['wr_job_type7']);
						$wr_job_type8 = $category_control->get_categoryCodeName($get_resume['wr_job_type8']);
						if($wr_job_type6){
							$wr_job_type_2 = " , <li>";
							if($wr_job_type6) $wr_job_type_2 .= $wr_job_type6;
							if($wr_job_type7) $wr_job_type_2 .= "·" . $wr_job_type7;
							if($wr_job_type8) $wr_job_type_2 .= "·" . $wr_job_type8;
							$wr_job_type_2 .= "</li>";
						}
						/* //희망 근무직종 */

						$wr_date = $category_control->get_categoryCodeName($get_resume['wr_date']);		// 근무기간
						$wr_week = $category_control->get_categoryCodeName($get_resume['wr_week']);	// 근무요일
						$wr_time = $category_control->get_categoryCodeName($get_resume['wr_time']);		// 근무시간
						$wr_work_direct = ($get_resume['wr_work_direct']) ? "(즉시출근가능)" : "";

						/* 근무형태 */
						if($get_resume['wr_work_type']){
							$wr_work_type = explode(',',$get_resume['wr_work_type']);	
							$wr_work_type_cnt = count($wr_work_type);
							$work_type = "";
							for($i=0;$i<$wr_work_type_cnt;$i++){
								$work_type_name = $category_control->get_categoryCodeName($wr_work_type[$i]);
								$work_type .= "<li>".$work_type_name."</li> ";
							}
						}
						/* //근무형태 */


						/* 학력사항 */
						$school_ability = explode(' ',$wr_school_ability['name']);
						$wr_school_type = explode(',',$get_resume['wr_school_type']);
						// 대학 (2,3년) 데이터
						$wr_half_college = unserialize($get_resume['wr_half_college']);
						$wr_half_college_cnt = count($wr_half_college['college']);
						// 대학 (4년) 데이터
						$wr_college = unserialize($get_resume['wr_college']);
						$wr_college_cnt = count($wr_college['college']);
						// 대학원 데이터
						$wr_graduate = unserialize($get_resume['wr_graduate']);
						$wr_graduate_cnt = count($wr_graduate['graduate']);
						// 대학원 이상 데이터
						$wr_success = unserialize($get_resume['wr_success']);
						$wr_success_cnt = count($wr_graduate['success']);
						/* //학력사항 */


						/* 경력사항 */
						if($get_resume['wr_career']){
							$wr_career_use = $get_resume['wr_career_use'];
							if($wr_career_use){	// 경력 사항을 체크했다면
								$wr_career = unserialize($get_resume['wr_career']);
							}
						}
						/* //경력사항 */


						/* OA 능력 및 특기사항 */
						if($get_resume['wr_oa']){
							$wr_oa = unserialize($get_resume['wr_oa']);	// oa 능력 및 특기사항
							$oa_word = $alba_individual_control->oa_level['word'][$wr_oa['word']];				// 워드 능력
							$oa_pt = $alba_individual_control->oa_level['pt'][$wr_oa['pt']];								// 파워포인트 능력
							$oa_sheet = $alba_individual_control->oa_level['sheet'][$wr_oa['sheet']];				// 엑셀 능력
							$oa_internet = $alba_individual_control->oa_level['internet'][$wr_oa['internet']];	// 인터넷 능력
						}
						/* //OA 능력 및 특기사항 */


						/* 컴퓨터 능력 */
						if($get_resume['wr_computer']){
							$wr_computer = explode(',',$get_resume['wr_computer']);
							$wr_computer_cnt = count($wr_computer);
							$computers = array();
							for($i=0;$i<$wr_computer_cnt;$i++){
								$computers[$i] = $category_control->get_categoryCodeName($wr_computer[$i]);
							}
						}
						/* //컴퓨터 능력 */


						/* 특기사항 */
						if($get_resume['wr_specialty']){
							$wr_specialty = explode(',',$get_resume['wr_specialty']);
							$wr_specialty_cnt = count($wr_specialty);
							$specialty = array();
							for($i=0;$i<$wr_specialty_cnt;$i++){
								$specialty[$i] = $category_control->get_categoryCodeName($wr_specialty[$i]);
							}
							$wr_specialty_etc = explode('//',$get_resume['wr_specialty_etc']);
							if($wr_specialty_etc[0]){
								array_push($specialty,$wr_specialty_etc[1]);
							}
						}
						/* //특기사항 */


						$wr_prime = nl2br(stripslashes($get_resume['wr_prime']));	// 수상·수료활동내역
						$wr_introduce = $utility->conv_content($get_resume['wr_introduce'],2);

						/* 장애여부 */
						$wr_impediment_use = $get_resume['wr_impediment_use'];
						if($wr_impediment_use){
							$wr_impediment_level = $category_control->get_categoryCodeName($get_resume['wr_impediment_level']);
							$impediment = $get_resume['wr_impediment_name'] . " " . $wr_impediment_level;
						} else {
							$impediment = "해당사항 없음";
						}
						/* //장애여부 */

						$wr_marriage = ($get_resume['wr_marriage']) ? "기혼" : "미혼";
						$wr_military = $alba_individual_control->military[$get_resume['wr_military']];	// 군필 여부

						$wr_preferential_use = $get_resume['wr_preferential_use'];
						$wr_preferential = array();
						($wr_preferential_use) ? array_push($wr_preferential,"국가보훈 대상자") : "";

						$wr_treatment_use = $get_resume['wr_treatment_use'];
						($wr_treatment_use) ?  array_push($wr_preferential,"고용지원금 대상자") : "";

						if($get_resume['wr_treatment_service']){
							$wr_treatment_service = explode(',',$get_resume['wr_treatment_service']);
							$wr_treatment_service_cnt = count($wr_treatment_service);
							$treatment_service = array();
							for($i=0;$i<$wr_treatment_service_cnt;$i++){
								$treatment_service[$i] = $category_control->get_categoryCodeName($wr_treatment_service[$i]);
							}
							$treatment = "<br/>(";
							$treatment .= @implode($treatment_service,', ');
							$treatment .= ")";
						}

						$get_member = $user_control->get_member($get_resume['wr_id']);	 // 등록 회원 정보
						$mb_gender_txt = $user_control->mb_gender_txt[$get_member['mb_gender']];	// 성별
						$mb_birth = explode('-',$get_member['mb_birth']);
						$mb_homepage = $utility->add_http($get_member['mb_homepage']);

						$mb_photo_file = $alice['data_member_path']."/".$get_member['mb_id']."/".$get_member['mb_photo'];
						$mb_photo = (is_file($mb_photo_file)) ? "http://" . $host_name . "/data/". $get_member['mb_id'] . "/" . $mb_photo_file : "http://" . $host_name . "/images/basic/bg_noPhoto.gif";	 // 개인회원 프로필 사진

						$result  = "";
						$result .= "<!DOCTYPE html>";
						$result .= "<html class=\"ie ie8 win ko\">";
						$result .= "<head>";
						$result .= "<title></title>";
						$result .= "<meta charset=\"utf-8\" />";
						$result .= "</head>";
						$result .= "<body>";

						$result .= "<section id=\"print\" class=\"content_wrap clearfix\">";
						$result .= "<div class=\"print\" id=\"rightContent\"> ";
						$result .= "<div class=\"listWrap positionR mt30\">";
						$result .= "<h2 class=\"skip\">이력서상세보기 </h2>";
						$result .= "<div class=\"readBtn clearfix\">";
						$result .= "<ul>";
						$result .= "<li class=\"pb5\" style=\"color:#ff0000;\"><p>수정일 : " . $wr_udate . "</p></li>";
						$result .= "</ul>  ";
						$result .= "</div>";
						$result .= "<div class=\"resumeDetail positionR\">";
						$result .= "<table>";
						$result .= "<caption><span class=\"skip\">개인정보출력</span></caption>";
						$result .= "<colgroup><col width=\"159px\"><col width=\"126px\"><col width=\"*\"></colgroup>";
						$result .= "<tbody>";
						$result .= "<tr>";
						$result .= "<th class=\"brend\" colspan=\"3\">";
						$result .= "<div class=\"positionR\"> <p class=\"title\">" . $wr_subject . "</p></div>";
						$result .= "</th>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<td class=\"first\" rowspan=\"6\">";
						$result .= "<div class=\"personphoto\">";
						$result .= "<img src=\"" . $mb_photo . "\" width=\"100\" height=\"130\" alt=\"photo\" />";
						$result .= "</div>";
						$result .= "</td>";
						$result .= "<th scope=\"row\"> <p>이름</p></th>";
						$result .= "<td><strong>" . $get_member['mb_name'] . "</strong> (" . $mb_gender_txt . ", " . $mb_birth[0] . "년생) / " . $utility->make_pass_($get_member['mb_id']) . " </td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\"> <p>전화번호</p></th>";
						$result .= "<td><p style=\"display:block;\">" . $get_member['mb_phone'] . "</p></td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\"> <p>휴대폰</p></th>";
						$result .= "<td><p style=\"display:block;\">" . $get_member['mb_hphone'] . "</p></td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\"> <p>이메일</p></th>";
						$result .= "<td><p style=\"display:block;\">" . $get_member['mb_email'] . "</p></td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\"> <p>홈페이지</p></th>";
						$result .= "<td><a href=\"" . $mb_homepage . "\" target=\"_blank\">" . $mb_homepage . "</a></td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th class=\"vt\" scope=\"row\"><p>주소</p></th>";
						$result .= "<td>[" . $get_member['mb_zipcode'] . "] " . $get_member['mb_address0']." ".$get_member['mb_address1'] . "</td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<td colspan=\"3\" class=\"etcWrap bbend vt\" scope=\"row\" style=\"padding:0; \">";
						$result .= "<table style=\"width:100%\">";
						$result .= "<colgroup><col width=\"159px\"><col width=\"159px\"><col width=\"159px\"><col width=\"159px\"><col width=\"159px\"></colgroup>";
						$result .= "<tbody>";
						$result .= "<tr>";
						$result .= "<th>최종학력</th>";
						$result .= "<th>경력사항</th>";
						$result .= "<th>희망급여</th>";
						$result .= "<th>자격증</th>";
						$result .= "<th class=\"brend\">외국어능력</th>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<td>" . stripslashes($wr_school_ability['name']) . "</td>";
						$result .= "<td>" . $career_periods . "</td>";
						$result .= "<td>" . $pay_type . "</td>";
						$result .= "<td>" . $license . "</td>";
						$result .= "<td class=\"brend\">" . $language . "</td>";
						$result .= "</tr>";
						$result .= "</tbody>";
						$result .= "</table>";
						$result .= "</td>";
						$result .= "</tr>";
						$result .= "</tbody>";
						$result .= "</table>";
						$result .= "</div>";
						$result .= "</div>";
						$result .= "<div class=\"listWrap mt30\">";
						$result .= "<h2 class=\"pb5\"><img src=\"http://" . $host_name . "/images/tit/person_nav_tit_02.gif\" width=\"134\" height=\"25\"  alt=\"희망근무조건\"></h2>";
						$result .= "<div class=\"resumeDetail jobtype\">";
						$result .= "<table>";
						$result .= "<caption><span class=\"skip\">희망근무조건출력</span></caption>";
						$result .= "<colgroup><col width=\"159px\"><col width=\"*\"></colgroup>";
						$result .= "<tbody>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\"><label>희망근무지</label></th>";
						$result .= "<td>";
						$result .= "<ul>";
						$result .= $wr_area_0;
						$result .= $wr_area_1;
						$result .= $wr_area_2;
						$result .= "</ul>";
						$result .= "</td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\"><label>희망직종</label></th>";
						$result .= "<td>";
						$result .= "<ul>";
						$result .= $wr_job_type_0;
						$result .= $wr_job_type_1;
						$result .= $wr_job_type_2;
						$result .= "</ul>";
						$result .= "</td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\"><label>근무일시</label></th>";
						$result .= "<td>";
						$result .= "<ul>";
						$result .= "<li>" . $wr_date . "</li>,";
						$result .= "<li>" . $wr_week . "</li>,";
						$result .= "<li>" . $wr_time . "</li>";
						$result .= $wr_work_direct;
						$result .= "</ul>";
						$result .= "</td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\"><label>희망급여</label></th>";
						$result .= "<td>" . $pay_type . "</td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th scope=\"row\" class=\"bbend\"><label>근무형태</label></th>";
						$result .= "<td  class=\"bbend\">";
						$result .= "<ul>" . $work_type . "</ul>";
						$result .= "</td>";
						$result .= "</tr>";
						$result .= "</tbody>";
						$result .= "</table>";
						$result .= "</div>";
						$result .= "</div>";
						$result .= "<div class=\"listWrap mt30\">";
						$result .= "<h2 class=\"pb5\">";
						$result .= "<img src=\"http://" . $host_name . "/images/tit/person_nav_tit_03.gif\" width=\"91\" height=\"25\"  alt=\"학력사항\">";
						$result .= "<em class=\"resumeText pb5\"><strong><span class=\"text_blue\">대학(2,3년)</span> 졸업</strong></em>";
						$result .= "</h2>";
						$result .= "<div class=\"resumeDetail table\">";
						$result .= "<table>";
						$result .= "<caption><span class=\"skip\">학력사항출력</span></caption>";
						$result .= "<colgroup><col width=\"245px\"><col width=\"200px\"><col width=\"*\"></colgroup>";
						$result .= "<tbody>";
						$result .= "<tr>";
						$result .= "<th scope=\"col\"> <label>재학기간</label></th>";
						$result .= "<th scope=\"col\"> <label>학교명</label></th>";
						$result .= "<th scope=\"col\" class=\"brend\"> <label>전공</label></th>";
						$result .= "</tr>";
						if($wr_school_type) {
							foreach($wr_school_type as $key => $val){
								// 고등학교
								if($val=='high_school'){	// 고등학교
									$school_syear = $get_resume['wr_high_school_syear'] . "년 입학 ";	// 입학년도
									$school_eyear = "~ " . $get_resume['wr_high_school_eyear'] ."년 ";		// 졸업년도
									$high_school_graduation = $get_resume['wr_high_school_graduation'];	// 졸업여부
									$school_graduation = ($high_school_graduation) ? "재학" : "졸업";
									$school_name = $get_resume['wr_high_school_name'];
						$result .= "<tr>";
						$result .= "<td>" . $school_syear . $school_eyear . $school_graduation . "</td>";
						$result .= "<td><strong>" . $school_name . "</strong></td>";
						$result .= "<td class=\"brend\"></td>";
						$result .= "</tr>";
								} else if($val=='half_college'){	// 대학 (2,3년)
									if($wr_half_college){
										for($j=0;$j<$wr_half_college_cnt;$j++){
											$school_syear = $wr_half_college['college_syear'][$j] . "년 입학 ";	// 입학년도
											$school_eyear = "~ " . $wr_half_college['college_eyear'][$j] . "년 ";	// 졸업년도
											$half_college_school_graduation = $wr_half_college['college_graduation'][$j];
											$school_graduation_arr = array( 0 => "졸업", 1 => "재학", 2 => "중퇴");
											$school_graduation = $school_graduation_arr[$half_college_school_graduation];
											$school_name = $wr_half_college['college'][$j];
											$school_specialize = $wr_half_college['college_specialize'][$j];
						$result .= "<tr>";
						$result .= "<td>" . $school_syear . $school_eyear . $school_graduation;
											if( ($j+1) ==$wr_half_college_cnt ) echo ($get_resume['wr_school_absence']) ? "휴학중" : "";
						$result .= "</td>";
						$result .= "<td><strong>" . $school_name . "</strong></td>";
						$result .= "<td class=\"brend\">" . $school_specialize . "</td>";
						$result .= "</tr>";
										}	// half_college for end.
									}	// wr_half_college if end.

								} else if($val=='college'){	// 대학 (4년)
									if($wr_college){
										for($j=0;$j<$wr_college_cnt;$j++){
											$school_syear = $wr_college['college_syear'][$j] . "년 입학 ";	// 입학년도
											$school_eyear = "~ " . $wr_college['college_eyear'][$j] . "년 ";	// 졸업년도
											$college_school_graduation = $wr_college['college_graduation'][$j];
											$school_graduation_arr = array( 0 => "졸업", 1 => "재학", 2 => "중퇴");
											$school_graduation = $school_graduation_arr[$college_school_graduation];
											$school_name = $wr_college['college'][$j];
											$school_specialize = $wr_college['college_specialize'][$j];
							$result .= "<tr>";
							$result .= "<td>" . $school_syear . $school_eyear . $school_graduation;
											if( ($j+1) ==$wr_college_cnt ) echo ($get_resume['wr_school_absence']) ? "휴학중" : "";
							$result .= "</td>";
							$result .= "<td><strong>" . $school_name . "</strong></td>";
							$result .= "<td class=\"brend\">" . $school_specialize . "</td>";
							$result .= "</tr>";
										}	// college for end.
									}	// college if end.

								} else if($val=='graduate'){	// 대학원
									if($wr_graduate){
										for($j=0;$j<$wr_graduate_cnt;$j++){
											$school_syear = $wr_graduate['graduate_syear'][$j] . "년 입학 ";	// 입학년도
											$school_eyear = "~ " . $wr_graduate['graduate_eyear'][$j] . "년 ";	// 졸업년도
											$graduate_school_graduation = $wr_graduate['graduate_graduation'][$j];
											$school_graduation_arr = array( 0 => "졸업", 1 => "수료", 2 => "재학", 3 => "중퇴");
											$school_graduation = $school_graduation_arr[$graduate_school_graduation];
											$school_name = $wr_graduate['graduate'][$j];
											$school_specialize = $wr_graduate['graduate_specialize'][$j];
						$result .= "<tr>";
						$result .= "<td>" . $school_syear . $school_eyear . $school_graduation;
											if( ($j+1) ==$wr_graduate_cnt ) echo ($get_resume['wr_school_absence']) ? "휴학중" : "";
						$result .= "</td>";
						$result .= "<td><strong>" . $school_name . "</strong></td>";
						$result .= "<td class=\"brend\">" . $school_specialize . "</td>";
						$result .= "</tr>";
										}	// college for end.
									}	// college if end.

								} else if($val=='success'){	// 대학원 이상
									if($wr_success){
										for($j=0;$j<$wr_success_cnt;$j++){
											$school_syear = $wr_success['success_syear'][$j] . "년 입학 ";	// 입학년도
											$school_eyear = "~ " . $wr_success['success_eyear'][$j] . "년 ";	// 졸업년도
											$success_school_graduation = $wr_success['success_graduation'][$j];
											$school_graduation_arr = array( 0 => "졸업", 1 => "수료", 2 => "재학", 3 => "중퇴");
											$school_graduation = $school_graduation_arr[$success_school_graduation];
											$school_name = $wr_success['success'][$j];
											$school_specialize = $wr_success['success_specialize'][$j];
						$result .= "<tr>";
						$result .= "<td>" . $school_syear . $school_eyear . $school_graduation;
											if( ($j+1) ==$wr_success_cnt ) echo ($get_resume['wr_school_absence']) ? "휴학중" : "";
						$result .= "</td>";
						$result .= "<td><strong>" . $school_name . "</strong></td>";
						$result .= "<td class=\"brend\">" . $school_specialize . "</td>";
						$result .= "</tr>";
										}	// college for end.
									}	// college if end.
								}	// if end.
										
							} // foreach end. 
						} // foreach if end.
						$result .= "</tbody>";
						$result .= "</table>";
						$result .= "</div>";
						$result .= "</div>";
						if($wr_career_use){
						$result .= "<div class=\"listWrap mt30\">";
						$result .= "<h2 class=\"pb5\">";
						$result .= "<img src=\"http://" . $host_name . "/images/tit/person_nav_tit_04.gif\" width=\"91\" height=\"25\"  alt=\"경력사항\">";
						$result .= "<em class=\"resumeText pb5\"><strong>총 경력<span class=\"text_blue\"> " . $career_periods . "</span></strong></em>";
						$result .= "</h2>";
						$result .= "<div class=\"resumeDetail table\">";
						$result .= "<table>";
						$result .= "<caption><span class=\"skip\">경력사항출력</span></caption>";
						$result .= "<colgroup><col width=\"100px\"><col width=\"150px\"><col width=\"150px\"><col width=\"*\"></colgroup>";
						$result .= "<tbody>";
						$result .= "<tr>";
						$result .= "<th scope=\"col\"> <label>근무기간</label></th>";
						$result .= "<th scope=\"col\"> <label>회사명</label></th>";
						$result .= "<th scope=\"col\"> <label>담당업무</label></th>";
						$result .= "<th scope=\"col\" class=\"brend\"> <label>상세업무</label></th>";
						$result .= "</tr>";
							if($wr_career){
								foreach($wr_career as $key => $val){
									$date_val = "";
									$sdate = ($val['sdate']) ? explode('-',$val['sdate']) : "";
									$date_val = $sdate[0]."년 " . $sdate[1] . "월 ~<br/>";
									$edate = ($val['edate']) ? explode('-',$val['edate']) : "";
									$date_val .= $edate[0]."년 " . $edate[1] . "월";
									$career_type = $val['type'];
									$career_type_cnt = count($val['type']);
						$result .= "<tr>";
						$result .= "<td class=\"tl\"><p><?php echo $date_val;?></p></td>";
						$result .= "<td class=\"tl\">";
						$result .= "<strong>" . $val['company'] . "</strong>";
						$result .= "<ul>";
									for($k=0;$k<$career_type_cnt;$k++){
										$result .= "<li><img src=\"http://" . $host_name . "/images/icon/ico_job_category1.gif\" width=\"27\" height=\"14\" alt=\"업종\" /> " . $category_control->get_categoryCodeName($career_type[$k]) . "</li>";
									}
						$result .= "</ul>";
						$result .= "</td>";
						$result .= "<td class=\"tl\">" . $val['job'] . "</td>";
						$result .= "<td class=\"tl brend\">" . nl2br(stripslashes($val['content'])) . "</td>";
						$result .= "</tr>";
								}	// foreach end.
							}	// wr_career if end.
						$result .= "</tbody>";
						$result .= "</table>";
						$result .= "</div>";
						$result .= "</div>";
						}
						if($wr_license){
						$result .= "<div class=\"listWrap mt30\">";
						$result .= "<h2 class=\"pb5\"><img src=\"http://" . $host_name . "/images/tit/person_nav_tit_05.gif\" width=\"113\" height=\"25\"  alt=\"보유자격증\"></h2>";
						$result .= "<div class=\"resumeDetail table\">";
						$result .= "<table>";
						$result .= "<caption><span class=\"skip\">학력사항출력</span></caption>";
						$result .= "<colgroup><col width=\"245px\"><col width=\"*\"><col width=\"200px\"></colgroup>";
						$result .= "<tbody>";
						$result .= "<tr>";
						$result .= "<th scope=\"col\"> <label>취득일</label></th";
						$result .= "<th scope=\"col\"> <label>자격증명</label></th>";
						$result .= "<th scope=\"col\" class=\"brend\"> <label>발행처</label></th>";
						$result .= "</tr>";
							if($wr_license){
								foreach($wr_license as $key => $val){
						$result .= "<tr>";
						$result .= "<td>" . $val['year'] . "년</td>";
						$result .= "<td><strong>" . $val['name'] . "</strong></td>";
						$result .= "<td class=\"brend\">" . $val['public'] . "</td>";
						$result .= "</tr>";
									} // foreach end.
								}	// foreach if end.
						$result .= "</tbody>";
						$result .= "</table>";
						$result .= "</div>";
						$result .= "</div>";
						}
						if($wr_language){
						$result .= "<div class=\"listWrap mt30\">";
						$result .= "<h2 class=\"pb5\"> <img src=\"http://" . $host_name . "/images/tit/person_nav_tit_06.gif\" width=\"119\" height=\"25\" alt=\"외국어능력\"> </h2>";
						$result .= "<div class=\"resumeDetail table\">";
						$result .= "<table>";
						$result .= "<caption><span class=\"skip\">학력사항출력</span></caption>";
						$result .= "<colgroup><col width=\"200px\"><col width=\"*\"></colgroup>";
						$result .= "<tbody>";
						$result .= "<tr>";
						$result .= "<th scope=\"col\"> <label>외국어명</label></th>";
						$result .= "<th scope=\"col\" class=\"brend\"> <label>구사능력 / 공인시험 / 어학연수</label></th>";
						$result .= "</tr>";
							if($wr_language){
								foreach($wr_language as $key => $val){
								$language_name = $category_control->get_categoryCodeName($val['language']);
								$level_name = $alba_individual_control->language_level[$val['level']]['name'];
								$level_icon = $alba_individual_control->language_level[$val['level']]['icon'];
								$level_text = $alba_individual_control->language_level[$val['level']]['text'];
								$study_date = $alba_resume_control->language_date[$val['study_date']];
						$result .= "<tr>";
						$result .= "<td>" . $language_name . "</td>";
						$result .= "<td class=\"tl brend\">";
						$result .= "<ul>";
						$result .= "<li>[구사능력] <strong><em><img class=\"vm pb3\" width=\"17\" height=\"14\" alt=\"" . $level_name . "\" src=\"http://" . $host_name . "/images/icon/" . $level_icon . "\"></em>" . $level_text . "</strong></li>";
								if($val['license']){
									//foreach($val['license']['license'] as $lkey => $lval){
									$license = $val['license']['license'];
									$level = $val['license']['level'];
									$year = $val['license']['year'];
									$license_cnt = count($license);
									for($j=0;$j<$license_cnt;$j++){
									$license_name = $category_control->get_categoryCodeName($license[$j]);
									$license_level = $level[$j];
									$license_year = $year[$j];
						$result .= "<li>[공인시험] <strong><?php echo $license_name;?> <?php echo $license_level;?>점 (취득년도:<?php echo $license_year;?>년)</strong></li>";
									} 
								}
								if($val['study']){
						$result .= "<li>[어학연수] <strong>어학연수 경험있음 (연수기간:<?php echo $study_date;?>)</strong></li>";
								}
						$result .= "</ul>";
						$result .= "</td>";
						$result .= "</tr>";
								}	// foreach end.
							}	// foreach if end.
						$result .= "</tbody>";
						$result .= "</table>";
						$result .= "</div>";
						$result .= "</div>";
						}
						$result .= "<div class=\"listWrap mt30\">";
						$result .= "<h2 class=\"pb5\"><img src=\"http://" . $host_name . "/images/tit/person_nav_tit_07.gif\" width=\"208\" height=\"25\" alt=\"oa능력및특기사항\"></h2>";
						$result .= "<div class=\"resumeDetail list\">";
						$result .= "<table>";
						$result .= "<caption><span class=\"skip\">OA능력및특기사항 출력</span></caption>";
						$result .= "<tbody>";
						$result .= "<tr>";
						$result .= "<th class=\"brend\">";
						$result .= "<ul>";
						$result .= "<li>";
						$result .= "<label><em class=\"pr5\"><img class=\"vm pb2\" width=\"16\" height=\"16\" src=\"http://" . $host_name . "/images/icon/icon_word1.gif\" alt=\"워드\"></em>한글/ms워드</label>";
						$result .= "</li>";
						$result .= "<li>";
						$result .= "<label><em class=\"pr5\"><img class=\"vm pb2\" width=\"16\" height=\"16\" src=\"http://" . $host_name . "/images/icon/icon_power1.gif\" alt=\"파워포인트\"></em>파워포인트</label>";
						$result .= "</li>";
						$result .= "<li>";
						$result .= "<label><em class=\"pr5\"><img class=\"vm pb2\" width=\"16\" height=\"16\" src=\"http://" . $host_name . "/images/icon/icon_excel1.gif\" alt=\"엑셀\"></em>엑셀</label>";
						$result .= "</li>";
						$result .= "<li class=\"brend\">";
						$result .= "<label><em class=\"pr5\"><img class=\"vm pb2\" width=\"16\" height=\"16\" src=\"http://" . $host_name . "/images/icon/icon_ie1.gif\" alt=\"인터넷\"></em>인터넷</label>";
						$result .= "</li>";
						$result .= "</ul>";
						$result .= "</th>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<td>";
						$result .= "<ul>";
						$result .= "<li>";
						$result .= "<em class=\"pl5\"><img class=\"vm pb3\" width=\"17\" height=\"14\" alt=\"" . $oa_word['name'] . "\" src=\"http://" . $host_name . "/images/icon/" . $oa_word['icon'] . "\"></em>" . $oa_word['text'];
						$result .= "</li>";
						$result .= "<li>";
						$result .= "<em class=\"pl5\"><img class=\"vm pb3\" width=\"17\" height=\"14\" alt=\"" . $oa_pt['name'] . "\" src=\"http://" . $host_name . "/images/icon/" . $oa_pt['icon'] . "\"></em>" . $oa_pt['text'];
						$result .= "</li>";
						$result .= "<li>";
						$result .= "<em class=\"pl5\"><img class=\"vm pb3\" width=\"17\" height=\"14\" alt=\"" . $oa_sheet['name'] . "\" src=\"http://" . $host_name . "/images/icon/" . $oa_sheet['icon'] . "\"></em>" . $oa_sheet['text'];
						$result .= "</li>";
						$result .= "<li class=\"brend\">";
						$result .= "<em class=\"pl5\"><img class=\"vm pb3\" width=\"17\" height=\"14\" alt=\"" . $oa_internet['name'] . "\" src=\"http://" . $host_name . "/images/icon/" . $oa_internet['icon'] . "\"></em>" . $oa_internet['text'];
						$result .= "</li>";
						$result .= "</ul>";
						$result .= "</td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th class=\"brend\"><label class=\"pl20\">컴퓨터능력</label></th>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<td class=\"brend\"><p class=\"pl20\">" . @implode($computers,', ') . "</p></td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th class=\"brend\"><label class=\"pl20\">특기사항</label></th>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<td class=\"brend\"><p class=\"pl20\">" . @implode($specialty,', ') . "</p></td>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<th class=\"brend\"><label class=\"pl20\">수상·수료활동내역</label></th>";
						$result .= "</tr>";
						$result .= "<tr>";
						$result .= "<td class=\"brend bbend\"><p class=\"pl20\">" . $wr_prime . "</p></td>";
						$result .= "</tr>";
						$result .= "</tbody>";
						$result .= "</table>";
						$result .= "</div>";
						$result .= "</div>";
						$result .= "<div class=\"listWrap mt30\">";
						$result .= "<h2 class=\"pb5\"><img src=\"http://" . $host_name . "/images/tit/person_nav_tit_08.gif\" width=\"112\" height=\"25\" alt=\"자기소개서\"></h2>";
						$result .= "<div class=\"resumeDetail clearfix\">";
						$result .= "<div class=\"pt20 pl20 pr20 pb20\">" . $wr_introduce . "</div>";
						$result .= "</div>";
						$result .= "</div>";
						$result .= "<div style=\"display:block;\" class=\"Caution mt50 mb20\">";
						$result .= "<h3 class=\"skip\">주의사항</h3>";
						$result .= "<ul>";
						$result .= "<li>본 정보는 취업활동을 위해 등록한 이력서 정보이며 " . $env['site_name'] . "는(은) 기재된 내용에 대한 오류와 사용자가 신뢰하여 취한 조치에 대한 책임을 지지 않습니다.</li> ";
						$result .= "<li>누구든 본 정보를 " . $env['site_name'] . "의 동의없이 재배포할 수 없으며 본 정보를 출력 및 복사하더라도 채용목적 이외의 용도로 사용할 수 없습니다.</li> ";
						$result .= "<li>아울러 본 정보를 출력 및 복사한 경우의 개인정보보호에 대한 책임은 출력 및 복사한 당사자에게 있으며 정보통신부 고시 제2005-18호 (개인정보의 기술적·관리적 보호조치 기준)에 따라 개인정보가 담긴 이력서 등을 불법유출 및 배포하게 되면 법에 따라 책임지게 됨을 양지하시기 바랍니다. <저작권자 ⓒ " . $env['site_name'] . ". 무단전재-재배포 금지></li>";
						$result .= "</ul>";
						$result .= "</div>";
						$result .= "</div>";
						$result .= "</section>";

						$result .= "</body>";
						$result .= "</html>";


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