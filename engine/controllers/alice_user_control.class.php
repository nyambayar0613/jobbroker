<?php
		/**
		* /application/member/controller/alice_user_control.class.php
		* @author Harimao
		* @since 2013/07/02
		* @last update 2015/01/09
		* @Module v3.5 ( Alice )
		* @Brief :: User Control class
		* @Comment :: 사용자측 회원 컨트롤 클래스
		*/
		class alice_user_control extends alice_user_model {


				// 폼 카테고리 정렬에 따른 필드 생성
				function form_make( $form, $mode="", $no="" ){

					global $config, $utility;
					global $member, $company_member;
					global $category_control, $member_control;
						
						if($_GET['no']){
							$company_member = $member_control->get_company_memberNo($no);	 // 기업 정보
							$biz_no = explode('-',$company_member['mb_biz_no']);
							$biz_fax = explode('-',$company_member['mb_biz_fax']);
							$biz_success_option = $config->get_biz_success($company_member['mb_biz_success']);	// 상장여부
							$biz_form_option = $config->get_biz_form($company_member['mb_biz_form']);	// 기업형태
							$mb_homepage = $company_member['mb_homepage'];
							//$mb_email = explode('@',$company_member['mb_biz_email']);	 // 이메일
							$mb_email = explode('@',$member['mb_email']);	 // 이메일
							$mb_biz_content = $company_member['mb_biz_content'];	// 주요사업내용
							/* 설립연도 */
							$foundation_option = "";
							for($i=date('Y');$i>=1900;--$i){
								$selected = ($company_member['mb_biz_foundation']==$i) ? 'selected' : '';
								$foundation_option .= "<option value='".$i."' ".$selected.">".$i." 년</option>";
							}
							/* //설립연도 */
							$mb_biz_member_count = $company_member['mb_biz_member_count'];
							$mb_biz_stock = $company_member['mb_biz_stock'];
							$mb_biz_sale = $company_member['mb_biz_sale'];
							$mb_biz_vision = $company_member['mb_biz_vision'];
							$mb_biz_result = $company_member['mb_biz_result'];
						} else {
							if($mode=='insert'){
								$biz_no = "";
								$biz_fax = "";
								$biz_success_option = $config->get_biz_success("");	// 상장여부
								$biz_form_option = $config->get_biz_form("");	// 기업형태
								$mb_homepage = "";
								$mb_email = "";
								$mb_biz_content = "";
								/* 설립연도 */
								$foundation_option = "";
								for($i=date('Y');$i>=1900;--$i){
									$foundation_option .= "<option value='".$i."' ".$selected.">".$i." 년</option>";
								}
								/* //설립연도 */
								$mb_biz_member_count = "";
								$mb_biz_stock = "";
								$mb_biz_sale = "";
								$mb_biz_vision = "";
								$mb_biz_result = "";
							} else if($mode=='update') {
								$company_member = $member_control->get_company_memberNo($no);	 // 기업 정보
								$biz_no = explode('-',$company_member['mb_biz_no']);
								$biz_fax = explode('-',$company_member['mb_biz_fax']);
								$biz_success_option = $config->get_biz_success($company_member['mb_biz_success']);	// 상장여부
								$biz_form_option = $config->get_biz_form($company_member['mb_biz_form']);	// 기업형태
								$mb_homepage = $member['mb_homepage'];
								$mb_email = explode('@',$company_member['mb_biz_email']);	 // 이메일
								$mb_biz_content = $company_member['mb_biz_content'];	// 주요사업내용
								/* 설립연도 */
								$foundation_option = "";
								for($i=date('Y');$i>=1900;--$i){
									$selected = ($company_member['mb_biz_foundation']==$i) ? 'selected' : '';
									$foundation_option .= "<option value='".$i."' ".$selected.">".$i." 년</option>";
								}
								/* //설립연도 */
								$mb_biz_member_count = $company_member['mb_biz_member_count'];
								$mb_biz_stock = $company_member['mb_biz_stock'];
								$mb_biz_sale = $company_member['mb_biz_sale'];
								$mb_biz_vision = $company_member['mb_biz_vision'];
								$mb_biz_result = $company_member['mb_biz_result'];
							} else {
								$biz_no = explode('-',$company_member['mb_biz_no']);
								$biz_fax = explode('-',$company_member['mb_biz_fax']);
								$biz_success_option = $config->get_biz_success($company_member['mb_biz_success']);	// 상장여부
								$biz_form_option = $config->get_biz_form($company_member['mb_biz_form']);	// 기업형태
								$mb_homepage = $member['mb_homepage'];
								$mb_email = explode('@',$member['mb_email']);	 // 이메일
								$mb_biz_content = $company_member['mb_biz_content'];	// 주요사업내용
								/* 설립연도 */
								$foundation_option = "";
								for($i=date('Y');$i>=1900;--$i){
									$selected = ($company_member['mb_biz_foundation']==$i) ? 'selected' : '';
									$foundation_option .= "<option value='".$i."' ".$selected.">".$i." 년</option>";
								}
								/* //설립연도 */
								$mb_biz_member_count = $company_member['mb_biz_member_count'];
								$mb_biz_stock = $company_member['mb_biz_stock'];
								$mb_biz_sale = $company_member['mb_biz_sale'];
								$mb_biz_vision = $company_member['mb_biz_vision'];
								$mb_biz_result = $company_member['mb_biz_result'];
							}
						}
						/*
						$biz_no = explode('-',$company_member['mb_biz_no']);
						$biz_fax = explode('-',$company_member['mb_biz_fax']);
						$biz_success_option = $config->get_biz_success($company_member['mb_biz_success']);	// 상장여부
						$biz_form_option = $config->get_biz_form($company_member['mb_biz_form']);	// 기업형태
						*/
						$email_option = $config->get_email();		// 이메일


						$form_code = $form['code'];

						if($form['etc_0']){
							$required_img = "<img alt=\"필수입력사항\" src=\"../images/icon/icon_b.gif\" >";	// 필수 이미지
							$required_attr = "required";	// 필수 속성
							$biz_vision_required = "<script>if (document.getElementById('tx_mb_biz_vision')) {if (!ed_wr_content.outputBodyText()) { alert('기업개요 및 비전을 입력하십시오.'); ed_mb_biz_vision.returnFalse();return false;}}</script>";
							$biz_result_required = "<script>if (document.getElementById('tx_mb_biz_result')) {if (!ed_wr_content.outputBodyText()) { alert('기업연혁 및 실적을 입력하십시오.'); ed_mb_biz_result.returnFalse();return false;}}</script>";
						} else {
							$required_img = "";
							$required_attr = "";
							$biz_vision_required = "";
							$biz_result_required = "";
						}
						
						$tel_num = explode('-',$member['mb_phone']);
						$tel_num_option = $config->get_tel_num($tel_num[0]);		// 전화번호
						$fax_num_option = $config->get_tel_num($biz_fax[0]);		// 팩스번호

						//$mb_receive = (!$no&&!$mode)?"<p><input type=\"checkbox\" class=\"typeCheckbox\" id=\"mb_receive_email\" name=\"mb_receive[]\" value=\"email\" checked><label class=\"help\">인재정보 등의 이메일 수신</label></p>":"";
						$mb_receive = explode(',',$member['mb_receive']);		// 수신여부
						$mb_receive_email = (@in_array('email',$mb_receive)) ? 'checked' : '';
						$mb_receive = "<p><label><input type=\"checkbox\" class=\"typeCheckbox\" id=\"mb_receive_email\" name=\"mb_receive[]\" value=\"email\" ".$mb_receive_email."> 인재정보 등의 이메일 수신</label></p>";
						$biz_ex_msg = (!$no&&!$mode)?"<em class=\"help\">(예 : 네트워크 트래픽 관리제품 개발 및 판매)</em>":"<br/><em class=\"help\">(예 : 네트워크 트래픽 관리제품 개발 및 판매)</em>";

						$form_arr = array( 

							"20130626171450_7281" => "<tr><th scope=\"row\"> <label>".$required_img."사업자번호</label></th><td colspan=\"3\"><input type=\"text\"  style=\"width:50px;\" class=\"ipText\" title=\"사업자번호1\" maxlength=\"3\" id=\"mb_biz_no0\" name=\"mb_biz_no[]\" hname=\"사업자번호\" ".$required_attr." value=\"".$biz_no[0]."\"> <span class=\"delimiter\">-</span> <input type=\"text\" style=\"width:40px;\" class=\"ipText\" title=\"사업자번호2\" maxlength=\"2\" id=\"mb_biz_no1\" name=\"mb_biz_no[]\" hname=\"사업자번호\" ".$required_attr." value=\"".$biz_no[1]."\"> <span class=\"delimiter\">-</span> <input type=\"text\" style=\"width:70px;\" class=\"ipText\" title=\"사업자번호3\" maxlength=\"5\" id=\"mb_biz_no2\" name=\"mb_biz_no[]\" hname=\"사업자번호\" ".$required_attr." value=\"".$biz_no[2]."\"></td></tr>", 

							"20130626171534_3599" => "<tr><th scope=\"row\"> <label>".$required_img."상장여부</label></th><td colspan=\"3\"><select class=\"ipSelect\" style=\"width:200px;\" id=\"mb_biz_success\" name=\"mb_biz_success\" title=\"상장여부 선택\" hname=\"상장여부\" ".$required_attr."><option value=\"\">상장여부 선택</option>".$biz_success_option."</select></td></tr>",

							"20130626171524_3156" => "<tr><th scope=\"row\"> <label>".$required_img."기업형태</label></th><td colspan=\"3\"><select class=\"ipSelect\" style=\"width:200px;\" id=\"mb_biz_form\" name=\"mb_biz_form\" title=\"기업형태 선택\" hname=\"기업형태\" ".$required_attr."><option value=\"\">기업형태 선택</option>".$biz_form_option."</select></td></tr>",

							"20130626172051_4894" => "<tr><th scope=\"row\"> <label>".$required_img."팩스번호</label></th><td colspan=\"3\"><div class=\"telWrap\"><div class=\"tel\"><select class=\"ipSelect\" style=\"width:111px;\" id=\"mb_biz_fax0\" name=\"mb_biz_fax[]\" title=\"지역번호 선택\" hname=\"팩스 지역번호\" ".$required_attr."><option value=\"\">지역번호 선택</option>".$tel_num_option."</select> <span class=\"delimiter\">-</span> <input type=\"text\" class=\"ipText\" title=\"팩스번호 앞자리\" maxlength=\"4\" id=\"mb_biz_fax1\" name=\"mb_biz_fax[]\" hname=\"팩스번호 앞자리\" ".$required_attr." value=\"".$biz_fax[1]."\"> <span class=\"delimiter\">-</span> <input type=\"text\" class=\"ipText\" title=\"팩스번호 뒷자리\" maxlength=\"4\" id=\"mb_biz_fax2\" name=\"mb_biz_fax[]\" hname=\"팩스번호 뒷자리\" ".$required_attr." value=\"".$biz_fax[2]."\"></div></td></tr>",

							"20130626171544_9534" => "<tr><th scope=\"row\"> <label>".$required_img."홈페이지주소</label></th><td colspan=\"3\"> http:// <input type=\"text\"  style=\"width:490px;\" class=\"ipText\" title=\"홈페이지주소\" maxlength=\"80\" id=\"mb_homepage\" name=\"mb_homepage\" hname\"홈페이지주소\" ".$required_attr." value=\"".$utility->remove_http($mb_homepage)."\"></td></tr>",

							"20130626172514_1792" => "<tr><th scope=\"row\"> <label>".$required_img."주요사업내용</label></th><td colspan=\"3\"><input type=\"text\" maxlength=\"16\" class=\"ipText\" style=\"width:450px;\" id=\"mb_biz_content\" name=\"mb_biz_content\" hname=\"주요사업내용\" ".$required_attr." value=\"".	$mb_biz_content."\"> ".$biz_ex_msg."</td></tr>",

							"20130626171611_2769" => "<tr><th scope=\"row\"> <label>".$required_img."설립년도</label></th><td colspan=\"3\"><select class=\"ipSelect\" style=\"width:200px;\" id=\"mb_biz_foundation\" name=\"mb_biz_foundation\" title=\"설립연도 선택\" hname=\"설립연도\" ".$required_attr."><option value=\"\">선택</option>".$foundation_option."</select> 설립</td></tr>",

							"20130626172544_6551" => "<tr><th scope=\"row\"> <label>".$required_img."사원수</label></th><td colspan=\"3\"><input type=\"text\" maxlength=\"16\" class=\"ipText\" style=\"width:200px;\" id=\"mb_biz_member_count\" name=\"mb_biz_member_count\" hname=\"사원수\" ".$required_attr." value=\"".$mb_biz_member_count."\"> 명 <em class=\"help\">(예 : 200)</em></td></tr>",

							"20130626172551_1164" => "<tr><th scope=\"row\"> <label>".$required_img."자본금</label></th><td colspan=\"3\"><input type=\"text\" maxlength=\"16\" class=\"ipText\" style=\"width:200px;\" id=\"mb_biz_stock\" name=\"mb_biz_stock\" hname=\"자본금\" ".$required_attr." value=\"".$mb_biz_stock."\"> 원 <em class=\"help\">(예 : 3억 5천만)</em></td></tr>",

							"20130626172556_1808" => "<tr><th scope=\"row\"> <label>".$required_img."매출액</label></th><td colspan=\"3\"><input type=\"text\" maxlength=\"16\" class=\"ipText\" style=\"width:200px;\" id=\"mb_biz_sale\" name=\"mb_biz_sale\" hname=\"매출액\" ".$required_attr." value=\"".$mb_biz_sale."\"> 원 <em class=\"help\">(예 : 3억 5천만)</em></td></tr>",

							"20130626172616_7679" => "<tr><th scope=\"row\" class=\"vt\"><label>".$required_img."기업개요 및 비전</label></th><td colspan=\"3\">".$utility->make_cheditor('mb_biz_vision',stripslashes($mb_biz_vision))."</td></tr>".$biz_vision_required,
							// <textarea class=\"ipTextarea\" style=\"width:680px; height:100px; padding:10px;\" id=\"mb_biz_vision\" name=\"mb_biz_vision\" hname=\"기업개요 및 비전\" ".$required_attr."></textarea>

							"20130626172621_6326" => "<tr><th scope=\"row\" class=\"vt\"> <label>".$required_img."기업연혁 및 실적</label></th><td colspan=\"3\">".$utility->make_cheditor('mb_biz_result',stripslashes($mb_biz_result))."</td></tr>".$biz_result_required,
							// <textarea class=\"ipTextarea\" style=\"width:680px; height:100px; padding:10px;\" id=\"mb_biz_result\" name=\"mb_biz_result\" hname=\"기업연혁 및 실적\" ".$required_attr."></textarea>
							
							"20130703114256_2703" => "<tr><th scope=\"row\" class=\"vt\"><label>".$required_img."e-mail</label></th><td colspan=\"3\"><div class=\"mbrHelpWrap\"><input type=\"text\" class=\"ipText\" style=\"width:150px;\" maxlength=\"30\" id=\"mb_email\" name=\"mb_email[]\" hname=\"이메일\" ".$required_attr." value=\"".$mb_email[0]."\"> <span class=\"delimiter\">@</span> <input type=\"text\" style=\"width:185px;\" class=\"ipText\" maxlength=\"25\" title=\"이메일 서비스 제공자\" id=\"mb_email_tail\" name=\"mb_email[]\" hname=\"이메일 서비스 제공자\" ".$required_attr." value=\"".$mb_email[1]."\"> <select class=\"ipSelect\" style=\"width:105px;\" id=\"email_service\" onchange=\"email_sel(this);\"><option value=\"\">직접입력</option>".$email_option."</select>".$mb_receive."</div></td></tr>",

							//"20130703115415_0806" => "<tr><th scope=\"row\"> <label>휴대폰번호".$required_img."</label></th><td colspan=\"3\"><div class=\"telWrap\"><div class=\"tel\"><select class=\"ipSelect\" style=\"width:111px;\" id=\"\" name=\"\" title=\"번호선택\"><option value=\"\">번호선택</option>".$hp_num_option."</select> <span class=\"delimiter\">-</span> <input type=\"text\" class=\"ipText\" title=\"휴대폰번호 앞자리\" maxlength=\"4\" id=\"\" name=\"\"> <span class=\"delimiter\">-</span> <input type=\"text\" class=\"ipText\" title=\"휴대폰번호 뒷자리\" maxlength=\"4\" value=\"\" id=\"\" name=\"\"></div></td></tr>",

						);

						$result = $form_arr[$form_code];


					return $result;

				}


				/**
				* 회원 가입
				*/
				function user_regist( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->user_table."` set " . $val;

						$result = $this->_query($query);


					return $result;


				}


				/**
				* 기업 회원 가입
				*/
				function company_user_regist( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->company_table."` set " . $val;

						$result = $this->_query($query);


					return $result;


				}


				/**
				* 회원별 서비스 테이블 데이터 입력
				*/
				function user_service_regist( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->service_table."` set " . $val;

						$result = $this->_query($query);


					return $result;


				}


				/**
				* 회원 수정
				*/
				function user_update( $vals, $mb_id ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->user_table."` set " . $val . " where `mb_id` = '".$mb_id."' ";

						$result = $this->_query($query);

					
					return $result;

				}


				/**
				* 기업회원 수정
				*/
				function company_user_update( $vals, $mb_id ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->company_table."` set " . $val . " where `mb_id` = '".$mb_id."' ";

						$result = $this->_query($query);

					
					return $result;

				}


				/**
				* 기업회원 수정 (no 기준)
				*/
				function company_user_updateNo( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->company_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;

				}


				/**
				* 기업회원 수정 (no 기준)
				*/
				function company_user_delete( $no ){

						// 기업회원 포토 삭제
						$this->_query(" delete from `".$this->photo_table."` where `company_no` = '".$no."' ");

						// 기업회원 정보 삭제
						$query = " delete from `".$this->company_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;

				}


				/**
				* 회원 로그인 :: mb_id 기준
				*/
				function user_login( $mb_type, $mb_id, $mb_passwd ){

					global $alice, $config, $utility;

						// 1차 아이디 검사
						$query = " select * from `".$this->user_table."` where `mb_type` = '".$mb_type."' and `mb_id` = '".$mb_id."' ";

						$id_result = $this->_queryR($query);

						if(!$id_result) {

							$utility->popup_msg_js($this->_errors('0017'));	 // 등록된 아이디를 찾을 수 없습니다.\\n\\n아이디를 확인해 주세요.
							//echo "0017";
							exit;

						}

						// 2차 아이디 + 패스워드 검사
						$query = " select * from `".$this->user_table."` where `mb_type` = '".$mb_type."' and `mb_id` = '".$mb_id."' and `mb_password` = '".md5($mb_passwd)."' ";
						
						$result = $this->_queryR($query);	// 최종 결과값 리턴


						if(!$id_result || !$result) {	// 매칭이 안될때는 튕겨내자

							$utility->popup_msg_js($this->_errors('0018'));	// 비밀번호(패스워드)가 일치하지 않습니다.
							//echo "0018";
							exit;

						} else {

							// 전부 맞다면
							// 탈퇴처리를 확인한다.
							// 차단을 확인한다.
							;
							
						}

					return $result;

				}


				/**
				* 회원 세션 발급
				*/
				function user_session( $mb_id, $mb_type ){

					global $config, $utility;

						$mb = $this->get_member($mb_id);

						$utility->set_session( $this->sess_user_val, true );
						$utility->set_session( $this->sess_user_type, $mb['mb_type'] );

						$utility->set_session( $this->sess_uid_val, $mb['mb_id'] );
						$utility->set_session( $this->sess_level_val, $mb['mb_level'] );
						$utility->set_session( $this->sess_name_val, $mb['mb_name'] );
						$utility->set_session( $this->sess_nick_val, $mb['sess_nick_val'] );
						$utility->set_session( $this->sess_email_val, $mb['mb_email'] );
						
						$key = md5($_SERVER['SERVER_ADDR'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $mb['mb_passwd']);
						$utility->set_session( $this->sess_key_val, $key );

					
					return $key;

				}



				/**
				* 회원 로그아웃
				*/
				function user_logout( $mb_id ){

					global $config, $utility;
						
						session_unset();		// 모든 세션변수를 언레지스터 시켜줌 
						session_destroy();	// 세션해제함 

						// 자동로그인 해제
						//$utility->set_cookie("ack_mb_id", "", 0);
						//$utility->set_cookie("ack_auto", "", 0);


					return true;

				}

				
				// 회원별 사진 등록
				function user_photo_insert( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->photo_table."` set ".$val." ";

						$result = $this->_query($query);


					return $result;

				}


				// 회원별 사진 수정 :: photo_no 기준
				function user_photo_update( $vals, $mb_id, $photo_table, $photo_no, $con="" ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->photo_table."` set ".$val." where `mb_id` = '".$mb_id."' and `photo_table` = '".$photo_table."' and `photo_no` = '".$photo_no."' " . $con;
						
						$result = $this->_query($query);


					return $result;

				}

				// 회원별 사진 삭제 :: data_no 기준 (삭제 흉내가 아닌 진짜 Data 삭제)
				function user_photo_delete( $mb_id, $data_no ){

					global $alice;

						if(!$data_no || $data_no=='') return false;

						$photo_list = $this->member_photo_list($mb_id, " and `data_no` = '".$data_no."' ", " order by `photo_no` asc ");

						// 파일 삭제
						if($photo_list){
							foreach($photo_list as $val){
								@unlink($alice['data_alba_abs_path'] . '/' . $val['photo_name']);
								$query = " delete from `".$this->photo_table."` where `no` = '".$val['no']."'  ";
								$result = $this->_query($query);
							}
						}


					return $result;

				}

				// 회원별 특정 필드 카운트 업데이트
				function user_count_update( $field, $mb_id, $cnt, $operator="+" ){

						if(!$mb_id || $mb_id =='') return false;

						$query = " update `".$this->user_table."` set `".$field."` = `".$field."` ".$operator." ".$cnt." where `mb_id` = '".$mb_id."' ";

						$result = $this->_query($query);

					
					return $result;

				}


		}	// class end.
?>