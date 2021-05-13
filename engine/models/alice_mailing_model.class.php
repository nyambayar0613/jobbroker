<?php
		/**
		* /application/nad/member/model/alice_mailing_model.class.php
		* @author Harimao
		* @since 2015/03/10
		* @last update 2015/03/27
		* @Module v3.5 ( Alice )
		* @Brief :: Mailing Model Class
		* @Comment :: 메일링 관리 모델 클래스
		*/
		class alice_mailing_model extends DBConnection {

			var $mailing_config_table	= "alice_mailing_config";
			var $mailing_table				= "alice_mailing";
			var $mailing_list_table		= "alice_mailing_list";


			var $success_code = array(
					'0000' => '메일링 설정이 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '메일링 설정을 실패 하였습니다.',
					'0001' => '메일링 설정중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);

				/**
				* 메일링 환경설정 정보 추출 (단일)
				*/
				function get_config( $no=1 ){

						$query = " select * from `".$this->mailing_config_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;
					
				}

				/**
				* 자동 메일링 메일 생성
				*/
				function auto_make_Mail( $type, $data ){

					global $alice, $env, $logo, $utility;
					global $design_control, $category_control, $member_control;
					global $alba_company_control, $alba_individual_control, $alba_user_control;

						$get_config = $this->get_config();

						$mail_top_logo = $design_control->view_logo($logo['mail'],true);
						$mail_bottom_logo = $design_control->view_logo($logo['mail_bottom'],true);

						$mb = $member_control->get_member($data['wr_id']);

						// 기업회원 :: 맞춤인재정보
						if($type=='company'){

							$company_job_type = array();
							$company_job_area = array();

							$wr_job_type0 = $category_control->get_categoryCode($data['wr_job_type0']);
							$wr_job_type1 = $category_control->get_categoryCode($data['wr_job_type3']);
							$wr_job_type2 = $category_control->get_categoryCode($data['wr_job_type6']);	
							if($wr_job_type0) array_push($company_job_type,$wr_job_type0['name']);
							if($wr_job_type1) array_push($company_job_type,$wr_job_type1['name']);
							if($wr_job_type2) array_push($company_job_type,$wr_job_type2['name']);
							$wr_area0 = $category_control->get_categoryCode($data['wr_area0']);
							$wr_area1 = $category_control->get_categoryCode($data['wr_area3']);
							$wr_area2 = $category_control->get_categoryCode($data['wr_area6']);
							if($wr_area0) array_push($company_job_area,$wr_area0['name']);
							if($wr_area1) array_push($company_job_area,$wr_area1['name']);
							if($wr_area2) array_push($company_job_area,$wr_area2['name']);

						// 개인회원 :: 맞춤채용정보 리스팅
						} else if($type=='individual'){

							$individual_job_type = array();
							$individual_job_area = array();

							$wr_job_type0 = $category_control->get_categoryCode($data['wr_job_type0']);
							$wr_job_type1 = $category_control->get_categoryCode($data['wr_job_type3']);
							$wr_job_type2 = $category_control->get_categoryCode($data['wr_job_type6']);
							if($wr_job_type0) array_push($individual_job_type,$wr_job_type0['name']);
							if($wr_job_type1) array_push($individual_job_type,$wr_job_type1['name']);
							if($wr_job_type2) array_push($individual_job_type,$wr_job_type2['name']);
							$wr_area0 = $category_control->get_categoryCode($data['wr_area0']);
							$wr_area1 = $category_control->get_categoryCode($data['wr_area3']);
							$wr_area2 = $category_control->get_categoryCode($data['wr_area6']);
							if($wr_area0) array_push($individual_job_area,$wr_area0['name']);
							if($wr_area1) array_push($individual_job_area,$wr_area1['name']);
							if($wr_area2) array_push($individual_job_area,$wr_area2['name']);

						}

						// 기업회원 :: 맞춤인재정보 리스팅
						$company_list = $alba_company_control->custom_list(1, 20, " where `is_delete` = 0 ", $data['no']);
						if($company_list['total_count']){
							$resume_list = "<table width=\"100%\" style=\"font: 12px/170% dotum;border:1px solid #dddddd;border-bottom:none;border-collapse:collapse;text-align:center;\" cellpadding=\"0\" cellspacing=\"0\">";
							$resume_list .= "<tr style=\"border-bottom:1px solid #dddddd;\">";
							$resume_list .= "<td style=\"width:105px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">성명</td>";
							$resume_list .= "<td style=\"width:161px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">희망직종</td>";
							$resume_list .= "<td style=\"width:120px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">희망근무지역</td>";
							$resume_list .= "<td style=\"width:67px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">경력</td>";
							$resume_list .= "<td style=\"width:119px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">학력</td>";
							$resume_list .= "<td style=\"width:94px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;\">등록일</td>";
							$resume_list .= "</tr>";


							foreach($company_list['result'] as $val){
								$job_types = array();
								$job_areas = array();
								$get_member = $member_control->get_member($val['wr_id']);
								$job_type0 = $category_control->get_categoryCode($val['wr_job_type0']);
								$job_type1 = $category_control->get_categoryCode($val['wr_job_type3']);
								$job_type2 = $category_control->get_categoryCode($val['wr_job_type6']);
								if($job_type0) array_push($job_types,$job_type0['name']);
								if($job_type1) array_push($job_types,$job_type1['name']);
								if($job_type2) array_push($job_types,$job_type2['name']);
								$job_area0 = $category_control->get_categoryCode($val['wr_area0']);
								$job_area1 = $category_control->get_categoryCode($val['wr_area3']);
								if($job_area0) array_push($job_areas,$job_area0['name']);
								if($job_area1) array_push($job_areas,$job_area1['name']);
								$wr_career = unserialize($val['wr_career']);
								if($wr_career){
									$wr_career_cnt = count($wr_career);
									$career = 0;
									for($i=0;$i<$wr_career_cnt;$i++){
										$career += $utility->date_diff($wr_career[$i]['sdate'],$wr_career[$i]['edate']);
									}							
									$strtime = time() - strtotime("-".$career.' day');
									$year = date("Y", $strtime) - 1970;
									$month = date("m", $strtime);
									$career_periods = "약 " . sprintf('%02d',$year) . "년 " . $month . "개월";
								} else {
									$career_periods = "없음";
								}
								$wr_school_ability = explode('/',$val['wr_school_ability']);
								$wr_school_ability = $category_control->get_categoryCode($wr_school_ability[0]);
								$resume_list .= "<tr>";
								$resume_list .= "<td style=\"width:105px;height:25px;border-bottom:1px solid #dddddd;text-align:center;border-right:1px solid #dddddd;\"><a href=\"http://".$_SERVER['HTTP_HOST']."/resume/alba_resume_detail.php?no=".$val['no']."\" target=\"_blank\">".$utility->make_pass_○○($get_member['mb_name'])."</a></td>";
								$resume_list .= "<td style=\"width:161px;height:25px;text-align:center;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">".implode($job_types,", ")."</td>";
								$resume_list .= "<td style=\"width:120px;height:25px;text-align:center;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">".implode($job_areas,", ")."</td>";
								$resume_list .= "<td style=\"width:67px;height:25px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">".$career_periods."</td>";
								$resume_list .= "<td style=\"width:119px;height:25px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">".stripslashes($wr_school_ability['name'])."</td>";
								$resume_list .= "<td style=\"width:94px;height:25px;border-bottom:1px solid #dddddd;\">".substr($val['wr_wdate'],0,10)."</td>";
								$resume_list .= "<tr>";
							}

							$resume_list .= "</table>";

						}


						$individual_list = $alba_individual_control->custom_list(1, 20, " where `is_delete` = 0 ", $data['no']);
						if($individual_list['total_count']){
							$company_list = "<table width=\"100%\" style=\"font: 12px/170% dotum;border:1px solid #dddddd;border-bottom:none;border-collapse:collapse;text-align:center;\" cellpadding=\"0\" cellspacing=\"0\">";
							$company_list .= "<tr style=\"border-bottom:1px solid #dddddd;\">";
							$company_list .= "<td style=\"width:105px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">기업명</td>";
							$company_list .= "<td style=\"width:161px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">모집직종</td>";
							$company_list .= "<td style=\"width:120px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">근무지역</td>";
							$company_list .= "<td style=\"width:67px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">성별</td>";
							$company_list .= "<td style=\"width:119px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">급여</td>";
							$company_list .= "<td style=\"width:94px;height:25px;text-align:center;font-weight:bold;border-bottom:1px solid #dddddd;\">등록일</td>";
							$company_list .= "</tr>";

							foreach($individual_list['result'] as $val){
								$job_types = array();
								$wr_areas = array();
								$job_type0 = $category_control->get_categoryCode($val['wr_job_type0']);
								$job_type1 = $category_control->get_categoryCode($val['wr_job_type3']);
								$job_type2 = $category_control->get_categoryCode($val['wr_job_type6']);
								if($job_type0) array_push($job_types,$job_type0['name']);
								if($job_type1) array_push($job_types,$job_type1['name']);
								if($job_type2) array_push($job_types,$job_type2['name']);
								$wr_area_0 = explode("/",$val['wr_area_0']);
								$wr_area0 = $category_control->get_categoryCode($wr_area_0[0]);
								$wr_area_1 = explode("/",$val['wr_area_1']);
								$wr_area1 = $category_control->get_categoryCode($wr_area_1[0]);
								$wr_area_2 = explode("/",$val['wr_area_2']);
								$wr_area2 = $category_control->get_categoryCode($wr_area_2[0]);
								if($wr_area0) array_push($wr_areas,$wr_area0['name']);
								if($wr_area1) array_push($wr_areas,$wr_area1['name']);
								if($wr_area2) array_push($wr_areas,$wr_area2['name']);
								$wr_gender = $alba_user_control->gender_val[$val['wr_gender']];
								$pay_type = $category_control->get_categoryCodeName($val['wr_pay_type']);
								$wr_pay = number_format($val['wr_pay'])."원";
								$pay_conference = $val['wr_pay_conference'];	// 협의가능
								$pay_info = ($pay_conference) ? $alba_user_control->pay_conference[$pay_conference] : $pay_type." ".$wr_pay;

								$company_list .= "<tr>";
								$company_list .= "<td style=\"width:105px;height:25px;border-bottom:1px solid #dddddd;text-align:center;border-right:1px solid #dddddd;\"><a href=\"http://".$_SERVER['HTTP_HOST']."/alba/alba_detail.php?no=".$val['no']."\" target=\"_blank\">".$val['wr_company_name']."</td>";
								$company_list .= "<td style=\"width:161px;height:25px;text-align:center;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">".implode($job_types,", ")."</td>";
								$company_list .= "<td style=\"width:120px;height:25px;text-align:center;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">".implode($wr_areas,", ")."</td>";
								$company_list .= "<td style=\"width:67px;height:25px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">".$wr_gender."</td>";
								$company_list .= "<td style=\"width:119px;height:25px;border-bottom:1px solid #dddddd;border-right:1px solid #dddddd;\">".$pay_info."</td>";
								$company_list .= "<td style=\"width:94px;height:25px;border-bottom:1px solid #dddddd;\">".substr($val['wr_wdate'],0,10)."</td>";
								$company_list .= "</tr>";
							}
							
							$company_list .= "</table>";

						}

						$trans = array (
							"{메일상단로고}" => $mail_top_logo, 
							"{메일하단로고}" => $mail_bottom_logo,
							"{메일하단}" => stripslashes($env['email_bottom']), 
							"{사이트명}" => stripslashes($env['site_name']), 
							"{도메인}" => "http://".$_SERVER['HTTP_HOST'], 

							"{회원이름}" => $mb['mb_name'],
							"{회원아이디}" => $mb['mb_id'],

							"{희망직종}" => @implode($company_job_type,","),
							"{희망근무지역}" => @implode($company_job_area,","),

							"{채용직종}" => @implode($individual_job_type,","),
							"{근무지역}" => @implode($individual_job_area,","),

							
							"{맞춤인재정보}" => $resume_list,
							"{맞춤채용정보}" => $company_list,
							
						);

						$result['company_mailing'] = strtr($get_config['wr_company_mailing'], $trans);

						$result['individual_mailing'] = strtr($get_config['wr_individual_mailing'], $trans);


					return $result;

				}


				/**
				* 자동 메일링 SMS 생성
				*/
				function auto_make_Sms( $type, $data ){

					global $alice, $env, $utility;
					global $category_control, $member_control;
					global $alba_company_control;


						$get_config = $this->get_config();


						// (기업회원) 맞춤 인재정보 SMS 설정정보
						$sms_company = unserialize($get_config['wr_sms_company']);	
						$sms_company_content = $sms_company['content'];
						$sms_company_use = $sms_company['use'];

						// (개인회원) 맞춤 채용정보 SMS 설정정보
						$sms_individual = unserialize($get_config['wr_sms_individual']);
						$sms_individual_content = $sms_individual['content'];
						$sms_individual_use = $sms_individual['use'];

						$mb = $member_control->get_member($data['wr_id']);

						switch($type){
							case 'company':

								$job_type = array();
								$job_area = array();

								$wr_job_type0 = $category_control->get_categoryCode($data['wr_job_type0']);
								$wr_job_type1 = $category_control->get_categoryCode($data['wr_job_type3']);
								$wr_job_type2 = $category_control->get_categoryCode($data['wr_job_type6']);	
								if($wr_job_type0) array_push($job_type,str_replace(" • ","/",$wr_job_type0['name']));
								if($wr_job_type1) array_push($job_type,str_replace(" • ","/",$wr_job_type1['name']));
								if($wr_job_type2) array_push($job_type,str_replace(" • ","/",$wr_job_type2['name']));
								$wr_area0 = $category_control->get_categoryCode($data['wr_area0']);
								$wr_area1 = $category_control->get_categoryCode($data['wr_area3']);
								$wr_area2 = $category_control->get_categoryCode($data['wr_area6']);
								if($wr_area0) array_push($job_area,$wr_area0['name']);
								if($wr_area1) array_push($job_area,$wr_area1['name']);
								if($wr_area2) array_push($job_area,$wr_area2['name']);

							break;
							case 'individual':

								$job_type = array();
								$job_area = array();

								$wr_job_type0 = $category_control->get_categoryCode($data['wr_job_type0']);
								$wr_job_type1 = $category_control->get_categoryCode($data['wr_job_type3']);
								$wr_job_type2 = $category_control->get_categoryCode($data['wr_job_type6']);
								if($wr_job_type0) array_push($job_type,str_replace(" • ","/",$wr_job_type0['name']));
								if($wr_job_type1) array_push($job_type,str_replace(" • ","/",$wr_job_type1['name']));
								if($wr_job_type2) array_push($job_type,str_replace(" • ","/",$wr_job_type2['name']));
								$wr_area0 = $category_control->get_categoryCode($data['wr_area0']);
								$wr_area1 = $category_control->get_categoryCode($data['wr_area3']);
								$wr_area2 = $category_control->get_categoryCode($data['wr_area6']);
								if($wr_area0) array_push($job_area,$wr_area0['name']);
								if($wr_area1) array_push($job_area,$wr_area1['name']);
								if($wr_area2) array_push($job_area,$wr_area2['name']);

							break;
						}

						$custom_list = $alba_company_control->custom_list(1, 20, " where `is_delete` = 0 ", $data['no']);

						$work_type = array();
						foreach($custom_list as $val){
							if($val['wr_work_type']){
								$wr_work_type = explode(",",$val['wr_work_type']);
								$wr_work_type_cnt = count($wr_work_type);
								for($i=0;$i<$wr_work_type_cnt;$i++){
									$work_type_name = $category_control->get_categoryCode($wr_work_type[$i]);
									array_push($work_type,$work_type_name);
								}
							} else {
								array_push($work_type,"");
							}
						}

						$trans = array (
							"{사이트명}" => stripslashes($env['site_name']), 
							"{도메인}" => "http://".$_SERVER['HTTP_HOST'], 
							
							"{회원명}" => $mb['mb_name'],
							"{아이디}" => $mb['mb_id'],

							"{희망직종}" => @implode($job_type,","),
							"{희망근무지역}" => @implode($job_area,","),

							"{근무형태}" => "",
							"{등록건수}" => number_format($custom_list['total_count']),
						);


						$result['company_msg'] = strtr($sms_company_content[$sms_company_use], $trans);

						$result['individual_msg'] = strtr($sms_individual_content[$sms_individual_use], $trans);


					return $result;

				}


				/**
				* 메일링 발송 내역
				*/
				function __MailingList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->mailing_list_table."` " . $_add['que'] . $con . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				/**
				* 메일링 발송 내역 검색
				*/
				function _Search( ){

						$mode = $_GET['mode'];

						$page = $_GET['page'];

						$order = " order by `no` desc ";

						$wr_type = $_GET['wr_type'];
						$wr_mb_type = $_GET['wr_mb_type'];

						$que = array();
						$url = array();

						if($mode=='search'){

							## 구분 검색 ##################################################################################
							if($wr_type){
								array_push( $que, " `wr_type` = '".$wr_type."' " );
								array_push( $url, "wr_type=" . $wr_type );
							}
							## //구분 검색 #################################################################################

							## 수신회원 유형 검색 ############################################################################
							if($wr_mb_type){
								array_push( $que, " `wr_mb_type` = '".$wr_mb_type."' " );
								array_push( $url, "wr_mb_type=" . $wr_mb_type );
							}
							## //수신회원 유형 검색 ###########################################################################

						}

						array_push($url, 'page='.$page);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " where ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				/**
				* 메일링 발송 내역 보기
				*/
				function get_mailing_list( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->mailing_list_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


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