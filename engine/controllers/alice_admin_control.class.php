<?php
		/**
		* /application/nad/controller/alice_admin_control.class.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2013/11/13
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Control class
		* @Comment :: 관리자 컨트롤 클래스
		*/
		class alice_admin_control extends alice_admin_model {


				/**
				* 관리자 로그인
				*/
				function admin_login( $uid, $passwd ){

					global $utility;

					$uid = stripslashes($uid);

					if (!trim($uid) || !trim($passwd))
						return die($this->_errors('0005'));	// 관리자 아이디나 비밀번호가 공백이면 안됩니다.

					$uid_query = " select * from `".$this->admin_table."` where `uid` = '".$uid."' ";	// uid 먼저 검사
					$uid_result = $this->_queryR( $uid_query );

					if(!$uid_result){	// uid가 맞지 않다면

						$utility->popup_msg_js( $this->_errors('0003') );	 // 관리자 아이디가 정확하지 않습니다.\\n\\n관리자 아이디를 확인해 주세요.

						return false;

					} else {	 // uid 가 맞다면

						// 패스워드 검사
						$admin_query = " select * from `".$this->admin_table."` where `uid` = '".$uid."' and `passwd` = md5('".$passwd."') ";	// passwd 검사
						$admin_result = $this->query_fetch( $admin_query );

						if(!$admin_result){	// passwd 가 맞지 않다면

							$utility->popup_msg_js( $this->_errors('0004') );	// 관리자 비밀번호가 정확하지 않습니다.\\n\\n관리자 비밀번호를 확인해 주세요.

							return false;

						} else {	 // 맞다면
							
							$this->_lastlogin($uid);	// 마지막 로그인 업데이트
							$get_admin = $this->get_admin( $uid );	// 관리자 정보 추출(단일)

							// 세션 할당
							$utility->set_session( $this->sess_uid_val, $get_admin['uid'] );
							$utility->set_session( $this->sess_level_val, $get_admin['level'] );
							$utility->set_session( $this->sess_name_val, $get_admin['name'] );
							$utility->set_session( $this->sess_nick_val, $get_admin['nick'] );
							$utility->set_session( $this->sess_key_val, md5($get_admin['last_login'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']) );

							return true;
						}

					}

				}	// admin_login function end.


				/**
				* 관리자 로그아웃
				*/
				function admin_logout( $uid ){
						
				}


				/**
				* 관리자 마지막 로그인 일자 업데이트
				* 로그인 카운트+1
				*/
				function _lastlogin( $uid ){

						$result = $this->_query(" update `".$this->admin_table."` set `login` = `login`+1, `last_login` = now() where `uid` = '".$uid."' ");	// 마지막 로그인 업데이트


					return $result;

				}


				/**
				* 최고관리자 정보 수정
				*/
				function update_admin( $no, $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->admin_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;
						
				}


				/**
				* 부관리자 정보 입력
				*/
				function insert_sadmin( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->admin_table."` set " . $val;

						$result = $this->_query($query);

					
					return $result;
						
				}


				/**
				* 부관리자 정보 수정
				*/
				function update_sadmin( $vals, $uid ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->admin_table."` set " . $val . " where `uid` = '".$uid."' ";

						$result = $this->_query($query);

					
					return $result;

				}


				/**
				* 부관리자 정보 삭제 (uid 기준)
				*/
				function delete_sadmin( $uid ){

						// 부관리자 데이터 삭제
						$query = " delete from `".$this->admin_table."` where `uid` = '".$uid."' ";

						$result = $this->_query($query);

						if($result){

							// 관리자 접근 메뉴 데이터 삭제
							$auth_query = " delete from `".$this->auth_table."` where `uid` = '".$uid."' ";

							$result = $this->_query($auth_query);

						}


					return $result;

				}


				/**
				* 부관리자 권한 정보 입력
				*/
				function sadmin_auth( $vals, $uid='' ){

					global $utility;

						$get_admin_auth = $this->get_admin_auth($uid);	 // 부관리자 접근 메뉴

						$val = $utility->QueryString($vals);

						if($get_admin_auth)	// 기존 데이터가 있다면 수정

							$query = " update `".$this->auth_table."` set " . $val . " where `uid` = '".$vals['uid']."'";

						else	// 없다면 입력

							$query = " insert into `".$this->auth_table."` set " . $val;


						$result = $this->_query($query);

					
					return $result;

				}


				// 관리자 메뉴/페이지별 권한 체크
				function admin_auth_checking( $uid, $top_menu_code, $middle_menu_code, $sub_menu_code ){

					global $is_super_admin, $utility;

						$get_sadmin_auth = $this->get_admin_auth($uid);	 // 부관리자 접근 메뉴

						$auth_top_menu = explode(',',$get_sadmin_auth['top_menu']);
						$auth_middle_menu = explode(',',$get_sadmin_auth['middle_menu']);
						$auth_sub_menu = explode(',',$get_sadmin_auth['sub_menu']);

						// 대 메뉴 접근 체크
						if(in_array($top_menu_code,$auth_top_menu)==false) {
							$utility->popup_msg_js($this->_errors('0007'));
							return false;
						}

						// 중 메뉴 접근 체크
						if(in_array($middle_menu_code,$auth_middle_menu)==false) {
							$utility->popup_msg_js($this->_errors('0007'));
							return false;
						}

						// 소 메뉴 접근 체크
						if(in_array($sub_menu_code,$auth_sub_menu)==false) {
							$utility->popup_msg_js($this->_errors('0007'));
							return false;
						}


					return true;

				}


				/**
				* 관리자 uid 수정시 각종 환경설정 필드 uid 값 수정
				*/
				function update_uid( $admin_id, $uid ){

					// alice_admin_auth uid 값 수정
					$update_quick = $this->_query(" update `alice_admin_auth` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_admin_quick uid 값 수정
					$update_quick = $this->_query(" update `alice_admin_quick` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_config uid 값 수정
					$update_config = $this->_query(" update `alice_config` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_backup uid 값 수정
					//$update_backup = $this->_query(" update `alice_backup` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");
					
					// alice_banner uid 값 수정
					//$update_banner = $this->_query(" update `alice_banner` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_design uid 값 수정
					//$update_design = $this->_query(" update `alice_design` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_logo uid 값 수정
					//$update_logo = $this->_query(" update `alice_logo` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_mail_skin uid 값 수정
					//$update_mskin = $this->_query(" update `alice_mail_skin` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_notice uid 값 수정
					//$update_notice = $this->_query(" update `alice_notice` set `wr_id` = '".$uid."' where `wr_id` = '".$admin_id."' ");

					// alice_popup uid 값 수정
					//$update_popup = $this->_query(" update `alice_popup` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_popup_skin uid 값 수정
					//$update_pskin = $this->_query(" update `alice_popup_skin` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_service uid 값 수정
					//$update_pskin = $this->_query(" update `alice_service` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_service_check uid 값 수정
					//$update_pskin = $this->_query(" update `alice_service_check` set `uid` = '".$uid."' where `uid` = '".$admin_id."' ");

					// alice_comment wr_id 값 수정
					$update_comment = $this->_query(" update `alice_comment` set `wr_id` = '".$uid."' where `wr_id` = '".$admin_id."' ");

				}



		}	// class end.

?>