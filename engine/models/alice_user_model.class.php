<?php
		/**
		* /application/member/model/alice_user_model.class.php
		* @author Harimao
		* @since 2013/07/02
		* @last update 2015/04/13
		* @Module v3.5 ( Alice )
		* @Brief :: User Model Class
		* @Comment :: 사용자측 회원 관리 모델 클래스
		*/
		class alice_user_model extends DBConnection {

			var $user_table			= "alice_member";
			var $company_table	= "alice_member_company";
			var $service_table		= "alice_member_service";
			var $photo_table		= "alice_member_photo";
			var $reason_table		= "alice_reason";

			var $sess_user_val		= "sess_user";					// 로그인한 회원인지 확인
			var $sess_user_type	= "sess_user_type";			// 회원구분

			var $sess_uid_val		= "sess_user_uid";				// 회원 아이디
			var $sess_level_val	= "sess_user_level";			// 회원 레벨
			var $sess_name_val	= "sess_user_name";			// 회원 이름
			var $sess_nick_val		= "sess_user_nick";			// 회원 닉네임
			var $sess_email_val	= "sess_user_email";			// 회원 이메일
			var $sess_key_val		= "sess_user_key";			// 회원 보안 고유키

			var $success_code = array(
					'0000' => '회원가입이 완료 되었습니다.',
					'0001' => '공개 설정이 변경 되었습니다.',
					'0002' => '대표 기업정보가 설정되었습니다.',
			);
			var $fail_code = array(
					'0000' => '회원약관에 동의하셔야 합니다.',
					'0001' => '개인정보보호정책에 동의하셔야 합니다.',
					'0002' => '개인회원 또는 기업회원 가입을 선택해 주시고\\n\\n회원약관 및 개인정보보호정책에 동의하셔야 합니다.',
					'0003' => '이미 로그인 하셨습니다.',
					'0004' => '아이디는 5~20자의 영문 소문자와 숫자의 조합만 사용할 수 있습니다.',
					'0005' => '아이디를 입력해 주세요',
					'0006' => '아이디에 공백이 존재합니다.\\n\\n공백없이 입력해 주세요.',
					'0007' => '이미 존재하는 아이디 입니다.',
					'0008' => '비밀번호를 입력해 주세요.',
					'0009' => '이름을 입력해 주세요.',
					'0010' => '닉네임을 입력해 주세요.',
					'0011' => '닉네임에 공백이 존재합니다.\\n\\n공백없이 입력해 주세요.',
					'0012' => '이미 존재하는 닉네임 입니다.',
					'0013' => '이미 등록된 이메일 주소 입니다.',
					'0014' => '회원가입중 오류가 발생 하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0015' => '회원만 접근 가능합니다.',
					'0016' => '이미 회원으로 로그인 하셨습니다.',
					'0017' => '등록된 아이디를 찾을 수 없습니다.\\n\\n아이디를 확인해 주세요.',
					'0018' => '비밀번호(패스워드)가 일치하지 않습니다.',
					'0019' => '회원 로그인 정보 업데이트 중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0020' => '불량회원으로 등록된 회원입니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0021' => '탈퇴 요청중인 회원입니다.\\n\\n서비스를 이용하시려면 사이트 관리자에게 문의하세요.',
					'0022' => '탈퇴된 회원입니다.\\n\\n서비스를 이용하시려면 사이트 관리자에게 문의하세요.',
					'0023' => 'SESSION 발급시 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0024' => '회원 로그인 중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0025' => '차단된 회원입니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0026' => '비밀번호(패스워드)가 일치하지 않습니다.\\n\\n비밀번호(패스워드)를 확인해 주세요.',
					'0027' => '회원정보 수정중 오류가 발생 하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0028' => '회사이미지는 이미지만 등록 가능합니다 (jpg, gif, png)',
					'0029' => '회사이미지 등록중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0030' => '개인회원 전용 서비스 입니다.',
					'0031' => '기업회원 전용 서비스 입니다.',
					'0032' => '프로필 사진은 이미지만 등록 가능합니다 (jpg, gif, png)',
					'0033' => '프로필 사진 등록중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0034' => '공개 설정중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0035' => '회사이미지 삭제중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0036' => '포토앨범 사진 등록중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0037' => '회사 로고 등록중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0038' => '로고를 등록해 주세요.',
					'0039' => '비밀번호 변경중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0040' => '현재 비밀번호를 입력해 주세요.',
					'0041' => '변경할 비밀번호를 입력해 주세요.',
					'0042' => '새로운 비밀번호가 재입력 비밀번호와 동일하지 않습니다.',
					'0043' => '회원탈퇴 유의사항에 동의해 주세요.',
					'0044' => '이메일 주소를 확인해 주세요.\\n\\n가입하신 ID 와 이메일 주소가 정확하지 않습니다.',
					'0045' => '가입된 회원정보를 찾을 수 없습니다.',
					'0046' => '탈퇴/삭제된 회원으로 로그인 하셨습니다.\\n\\n보안상 자동 로그아웃 됩니다.',
					'0047' => '탈퇴/삭제된 회원입니다.',
					'0047' => '가입된 정보가 확인되지 않습니다.\\n\\n가입하신 회원명, 이메일주소를 확인하세요.',
					'0048' => '기업정보 입력중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0049' => '기업정보 수정중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',

			);

			var $denied_val = array( "admin", "administrator", "super", "superuser", "super_user", "manager", "managers", "super_nanager" );	// 회원 가입시 사용 불가한 id, email (보안상)
			var $denied_txt = array( "관리자", "사이트관리자", "최고관리자", "매니저", "최고매니저", "운영자", "사이트운영자" );	// 회원 가입시 사용 불가한 이름, 닉네임
			var $mb_gender = array( 0 => "남", 1 => "여");
			var $mb_gender_txt = array( 0 => "男", 1 => "女");
			var $photo_extension = array( 'jpg', 'gif', 'png' );	// 회사 이미지 업로드 확장자	(bmp 제외)


				// 회원 정보 추출(단일) :: mb_id 기준
				function get_member( $mb_id ){

						if(!$mb_id)	 // mb_id 가 없다면 false
							return false;

						$query = " select * from `".$this->user_table."` where `mb_id` = '".$mb_id."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 기업 회원 정보 추출(단일) :: mb_id 기준
				function get_member_company( $mb_id, $con="" ){

						if(!$mb_id)	 // mb_id 가 없다면 false
							return false;

						$query = " select * from `".$this->company_table."` where `mb_id` = '".$mb_id."' " . $con;

						$result = $this->query_fetch($query);


					return $result;

				}

				// 기업 회원 정보 추출(단일) :: no 기준
				function get_member_company_no( $no ){

						if(!$no)	 // mb_id 가 없다면 false
							return false;

						$query = " select * from `".$this->company_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 가입 회원 체크 :: mb_id 기준
				function checkUid_member( $user_id ){

					global $env;

						$result = 0;

						$query = " select * from `".$this->user_table."` where `mb_id` = '".$user_id."' ";

						$result = $this->_queryR($query);

						// 관리자 아이디 체크 (보안상)
						$query = " select * from `alice_admin` where `uid` = '".$user_id."' ";

						$result += $this->_queryR($query);

						// 금지어 체크 (보안상)
						foreach($this->denied_val as $key => $denied) { 
							if(stristr($user_id,$denied)) $result++;
						}

					
					return $result;

				}

				// 가입 회원 체크 :: 닉네임 기준
				function checkNick_member( $mb_nick, $mb_id="" ){

					global $env;

						$result = 0;

						$con = ($mb_id) ? " and `mb_id` != '".$mb_id."' " : "";

						$query = " select * from `".$this->user_table."` where `mb_nick` = '".$mb_nick."' " . $con;

						$result = $this->_queryR($query);

						// 관리자 아이디 체크 (보안상)
						$query = " select * from `alice_admin` where `nick` = '".$mb_nick."' ";

						$result += $this->_queryR($query);

						// 금지어 체크 (보안상)
						foreach($this->denied_val as $key => $denied) { 
							if(stristr($mb_nick,$denied)) $result++;
						}
						foreach($this->denied_txt as $key => $denied) { 
							if(stristr($mb_nick,$denied)) $result++;
						}

				
					return $result;

				}

				// 가입 회원 체크 :: email 기준
				function checkEmail_member( $user_mail ){

					global $env;

						$result = 0;

						// 사용자 이메일 체크
						$query = " select * from `".$this->user_table."` where `mb_email` = '".$user_mail."' ";

						$result += $this->_queryR($query);

						// 금지어 체크 (보안상)
						foreach($this->denied_val as $key => $denied) { 
							if(stristr($user_mail,$denied)) $result++;
						}


					return $result;

				}

				// 가입 회원 체크 :: mb_name, email 기준
				function checkNameEmail_member( $user_name, $user_mail ){

					global $env;

						$result = 0;

						// 사용자 이름/이메일 체크
						$query = " select * from `".$this->user_table."` where `mb_name` = '".trim($user_name)."' and `mb_email` = '".trim($user_mail)."' ";

						$result += $this->_queryR($query);

						// 이메일 금지어 체크 (보안상)
						foreach($this->denied_val as $key => $denied) { 
							if(stristr($user_mail,$denied)) $result = false;
						}


					return $result;

				}

				// 사진 테이블 리스트만 추출 :: 간단 추출 (mb_id 기준)
				function member_photo_list( $mb_id, $con="", $order="" ){

						if(!$mb_id || $mb_id=='') return false;

						$_order = ($order) ? $order : " order by `no` desc ";

						$query = " select * from `".$this->photo_table."` where `mb_id` = '".$mb_id."' " . $con . $_order;


						$result = $this->query_fetch_rows($query);


					return $result;
						
				}

				// 사진 테이블 정보 추출
				function get_member_photo( $mb_id, $photo_no, $con="" ){ 

						if(!$mb_id || $mb_id=='') return false;

						$query = " select * from `".$this->photo_table."` where `mb_id` = '".$mb_id."' and `photo_no` = '".$photo_no."' " . $con;
                        
                        //echo $query. "<== <br>"; 

						$result = $this->query_fetch($query);

					
					return $result['photo_name'];

				}

				// ssn 중복 체크
				function ssn_checking( $ssn ){

						$query = " select `mb_ssn` from `".$this->user_table."` where `mb_ssn` = '".$ssn."' ";

						$result = $this->_queryR($query);

					
					return $result;

				}

				// 대표 기업정보
				function get_company( $mb_id ){
					
						if(!$mb_id || $mb_id=='') return false;

						$query = " select * from `".$this->company_table."` where `mb_id` = '".$mb_id."' and `is_public` = 1 ";

						$result = $this->query_fetch($query);


					return $result;

				}

				/**
				* 이미지 업로드시 확장자 구분
				*/
				function _img(){

						$result = implode('|',$this->photo_extension);

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