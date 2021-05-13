<?php
		/**
		* /application/nad/config/model/alice_service_model.class.php
		* @author Harimao
		* @since 2013/06/26
		* @last update 2015/04/10
		* @Module v3.5 ( Alice )
		* @Brief :: Service Model Class
		* @Comment :: 서비스 설정 모델 클래스
		*/
		class alice_service_model extends DBConnection {

			var $service_table				= "alice_service";
			var $service_check_table	= "alice_service_check";

			var $success_code = array(
					'0000' => '채용(정규직)정보 설정이 완료 되었습니다.',
					'0001' => '인재정보 설정이 완료 되었습니다.',
					'0002' => '정규직 정보 설정이 완료 되었습니다.',
					'0003' => '강조효과 설정이 완료 되었습니다.',
					'0004' => '로고 슬라이드 방향이 변경 되었습니다.',
					'0005' => '서비스 설정이 변경 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '채용(정규직)정보 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '인재정보 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '정규직 정보 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '아이콘 확장자를 확인해 주세요.\\n\\n아이콘 등록시 파일 확장자는 ( .jpg, .gif, .png ) 입니다.',
					'0004' => '아이콘이 적용될 서비스가 없습니다.\\n\\n서비스를 먼저 설정해 주세요.',
					'0005' => '업로드된 아이콘이 업습니다.',
					'0006' => '강조효과 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0007' => '로고 슬라이드 방향이 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0008' => '서비스 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0009' => '채용(정규직)공고 값이 존재하지 않습니다.',
					'0010' => '이력서 값이 존재하지 않습니다.',
			);

			var $unit_arr = array( 'count' => '건', 'day' =>'일', 'week' =>'주', 'month' =>'개월', 'year' =>'년' );	// 단위
			var $service_title = array( 'main' => '구인정보', 'alba_resume' => '인재정보', 'alba_option' => '채용정보 옵션서비스', 'resume_option' => '인재정보 옵션서비스', 'etc' => '기타 서비스' ); // , 'adult_alba' => '19정규직'
			//, 'alba' => '채용정보 메인'
			var $icon_extension = array( 'jpg', 'gif', 'png' );	// 아이콘 업로드 확장자

			var $service_lists = array( 
				'main' => array(	// 메인 페이지
					'platinum' => array( 'name' => '플래티넘', 'type' => 'box', 'is_gold' => true, 'is_logo' => true ),
					'grand' => array( 'name' => '그랜드', 'type' => 'box', 'is_gold' => true, 'is_logo' => true ),
					'special' => array( 'name' => '스페셜', 'type' => 'box', 'is_gold' => true, 'is_logo' => true ),
					'basic' => array( 'name' => '일반형 구인정보', 'type' => 'list', 'is_gold' => false ),
				),
				'alba_resume' => array(	 	// 정규직 인재정보 메인
					'focus' => array( "name" => "포커스인재정보", 'type' => 'box', 'is_gold' => true ),
					'basic' => array( 'name' => '일반리스트', 'type' => 'list', 'is_gold' => false ),
				),
				'adult_alba' => array(	 	// 19정규직 메인
					'platinum' => array( 'name' => '플래티넘', 'type' => 'box', 'is_gold' => true, 'is_logo' => true ),
					'banner' => array( 'name' => '배너형', 'type' => 'box', 'is_gold' => true ),
					'list' => array( 'name' => '리스트형', 'type' => 'list' ),
				),
				'alba_option' => array(
					'busy' => array( 'name' => '급구', 'type' => 'icon' ),
					//'logo' => array( 'name' => '로고강조', 'type' => 'slide' ),
					'neon' => array( 'name' => '형광펜', 'type' => 'color' ),
					'bold' => array( 'name' => '굵은글자', 'type' => 'option' ),
					'icon' => array( 'name' => '아이콘', 'type' => 'icon' ),
					'color' => array( 'name' => '글자색', 'type' => 'color' ),
					'blink' => array( 'name' => '반짝칼라', 'type' => 'option' ),
					'jump' => array( 'name' => '점프', 'type' => 'option' ),
				),
				'resume_option' => array(
					'busy' => array( 'name' => '급구', 'type' => 'icon' ),
					'neon' => array( 'name' => '형광펜', 'type' => 'color' ),
					'bold' => array( 'name' => '굵은글자', 'type' => 'option' ),
					'icon' => array( 'name' => '아이콘', 'type' => 'icon' ),
					'color' => array( 'name' => '글자색', 'type' => 'color' ),
					'blink' => array( 'name' => '반짝칼라', 'type' => 'option' ),
					'jump' => array( 'name' => '점프', 'type' => 'option' ),
				),
				'etc' => array(
					'open' => array( 'name' => '이력서열람권', 'type' => 'member' ),
					'alba' => array( 'name' => '채용공고열람권', 'type' => 'member' ),
					//'sms' => array( 'name' => 'SMS충전', 'type' => 'member' ),
				),
			);

			var $service_name = array(
				'main' => array(
					'name' => '메인',
					'service' => array(
						'platinum' => '플래티넘', 'grand' => '그랜드', 'special' => '스페셜', 'focus' => '포커스인재정보', 'basic' => '리스트형'
					),
				),
				'main_platinum' => array(
					'name' => '메인 플래티넘',
					'service' => array(
						'gold' => 'Gold', 'logo' => '로고강조',
					),
				),
				'main_grand' => array(
					'name' => '메인 그랜드',
					'service' => array(
						'gold' => 'Gold', 'logo' => '로고강조',
					),
				),
				'main_special' => array(
					'name' => '메인 스페셜',
					'service' => array(
						'gold' => 'Gold', 'logo' => '로고강조',
					),
				),
				'main_focus' => array(
					'name' => '메인 포커스',
					'service' => array(
					),
				),
				'main_basic' => array(
					'name' => '메인 포커스',
					'service' => array(
						'gold' => 'Gold',
					),
				),
				'alba' => array(
					'name' => '채용정보',
					'service' => array(
						'platinum' => '플래티넘', 'banner' => '배너형', 'list' => '리스트형', 'basic' => '일반리스트', 'resume_basic' => '일반리스트',
					),
				),
				'alba_platinum' => array(
					'name' => '채용정보 플래티넘',
					'service' => array(
						'gold' => 'Gold', 'logo' => '로고강조',
					),
				),
				'alba_banner' => array(
					'name' => '채용정보 배너형',
					'service' => array(
						'gold' => 'Gold',
					),
				),
				'alba_list' => array(
					'name' => '채용정보 리스트형',
					'service' => array(
						'gold' => 'Gold',
					),
				),
				'main_resume' => array(
					'name' => '메인 인재정보',
					'service' => array(
						'basic' => '일반리스트',
					),
				),
				'alba_resume' => array(
					'name' => '인재',
					'service' => array(
						'focus' => '포커스인재정보', 'focus_gold' => '포커스인재정보 Gold', 'basic' => '일반리스트', 'resume_basic' => '일반리스트', 'rbasic' => '일반리스트'
					),
				),
				'alba_option' => array(
					'name' => '채용정보 옵션',
					'service' => array(
						'busy' => '급구', 'neon' => '형광펜', 'bold' => '굵은글자', 'icon' => '아이콘', 'color' => '글자색', 'blink' => '반짝칼라', 'jump' => '점프',
					),
				),
				'resume_option' => array(
					'name' => '인재옵션',
					'service' => array(
						'busy' => '급구', 'neon' => '형광펜', 'bold' => '굵은글자', 'icon' => '아이콘', 'color' => '글자색', 'blink' => '반짝칼라', 'jump' => '점프',
					),
				),
				'etc' => array(
					'name' => '',
					'service' => array(
						'open' => '이력서열람권', 'alba' => '채용공고열람권', 'sms' => 'SMS문자',
					),
				),
			);

			var $package_service = array( 
				"employ" => array( 
					"main_platinum" => "플래티넘", 
					"main_platinum_gold" => "플래티넘 골드", 
					"main_platinum_logo" => "플래티넘 로고강조", 
					"main_grand" => "그랜드", 
					"main_grand_gold" => "그랜드 골드", 
					"main_grand_logo" => "그랜드 로고강조", 
					"main_special" => "스페셜", 
					"main_special_gold" => "스페셜 골드", 
					"main_special_logo" => "스페셜 로고강조", 
					"main_basic" => "일반리스트", 

					"alba_option_busy" => "급구 옵션", 
					"alba_option_bold" => "굵은글자 옵션", 
					"alba_option_blink" => "반짝칼라 옵션", 
					"etc_open" => "이력서 열람권", 
					"alba_option_jump" => "점프 옵션", 


					//"etc_sms" => "SMS지급", 
				),

				"individual" => array(
					"main_focus" => "포커스 인재정보",
					"main_focus_gold" => "포커스 인재정보 골드",
					"main_resume_basic" => "일반리스트",

					"resume_option_busy" => "급구 옵션", 
					"resume_option_bold" => "굵은글자 옵션", 
					"resume_option_blink" => "반짝칼라 옵션", 
					"etc_alba" => "채용공고 열람권", 
					"resume_option_jump" => "점프 옵션", 


					//"etc_sms" => "SMS지급", 
				),
			);

				function __ServiceList( $type='' ){

						//$_add = ($type) ? " where `type` = '".$type."' " : "";
						$_add = " where `type` = '".$type."'";

						$query = " select * from `".$this->service_table."` " . $_add . " order by `rank` asc ";
						
						$total_count = $this->_queryR($query);

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}

				// 단순 리스트
				function service_list( $con='' ){

						$query = " select * from `".$this->service_table."` " . $con . " order by `rank` asc ";
						
						$total_count = $this->_queryR($query);

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// Service 정보 추출(단일) :: no 기준
				function get_service( $no ){

						$query = " select * from `".$this->service_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// rank 최대값 구함
				function get_MaxRank( $type="" ){

						$_add = ($type) ? " where `type` = '".$type."' " : "";

						$query = " select max(`rank`) as `rank` from `".$this->service_table."` " . $_add;

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

				}

				// 서비스별 사용유무 체크
				function service_check( $service ){

						$query = " select * from `".$this->service_check_table."` where `service` = '".$service."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 서비스 체크 간단 리스트
				function service_check_list(){

						$query = " select * from `".$this->service_check_table."` ";	// order by no desc

						$result = $this->query_fetch_rows($query);


					return $result;

				}

				// 서비스 데이터 유무
				function service_checking( $type ){
				
					$query = " select * from `".$this->service_table."` where `type` = '".$type."' ";

					$result = $this->_queryR($query);

					return $result;
				
				}

				// 서비스 금액 할인율 계산
				function service_discount( $service_price, $service_percent ){

					global $utility;

						$result = array();

						if($service_price){

							$result['service_price'] = $service_price;	// 원금
							$result['service_percent'] = $service_percent;	// 할인율
					
							$dc_price = ($service_price * $service_percent) / 100;

							$result['dc_price'] = $dc_price;	// 할인 금액

							$total_price = $service_price - $dc_price;

							$result['total_price'] = $utility->chg_1won($total_price,100);	// 최종 금액

						} else {	 // 무료

							$result['total_price'] = 0;

						}

					
					return $result;

				}

				// Service 정보 추출(단일) :: 필드 기준
				// 아이콘 이나 옵션 정보 추출시
				function get_service_field( $field, $val ){

						$query = " select * from `".$this->service_table."` where `".$field."` = '".$val."' order by `no` desc limit 1";

						$result = $this->query_fetch($query);


					return $result;

				}



				// 서비스 설정 단위
				function _unit( $unit ){

						$result = $this->unit_arr[$unit];


					return $result;

				}

				// 아이콘 업로드시 확장자 구분
				function _icon(){

						$result = implode('|',$this->icon_extension);


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