<?php
		/**
		* /application/nad/payment/model/alice_payment_model.class.php
		* @author Harimao
		* @since 2013/07/23
		* @last update 2015/07/02
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Model class
		* @Comment :: 결제모듈 모델 클래스
		*/
		class alice_payment_model extends DBConnection {

			var $pg_page_table	= "alice_payment_page";
			var $payment_table	= "alice_payment";	 // 결제 내역 테이블
			var $pg_config_table	= "alice_pg";

			// 커스터마이징시 pg 사 추가는 이곳에서 하시면 됩니다.
			var $pg_company = array( 
				'inicis' => array( 'dir' => '/INIpay50/', 'is_logo' => true, 'id' => 'pg_inicis', 'name' => '이니시스' ),
				//'allthegate' => array( 'dir' => '/ags/source/', 'is_logo' => true, 'id' => 'pg_allthegate', 'name' => '올더게이트' ),
				'kcp' => array( 'dir' => '/kcp/', 'is_logo' => true, 'id' => 'pg_kcp', 'name' => 'KCP' ),
				'nicepay' => array( 'dir' => '/nicepay/', 'is_logo' => true, 'id' => 'pg_nicepay', 'name' => '나이스페이' ),
				//'lguplus' => array( 'dir' => '/XPay/', 'is_logo' => false, 'id' => 'lguplus', 'name' => 'LG U+' ),
			);

			// 결제 상태
			var $pay_status = array( 0 => "결제대기", 1 => "결제완료", 2 => "취소요청", 3 => "취소완료" );
			var $tax_num_type = array( 0 => '주민등록번호', 1 => '휴대폰번호', 2 => '카드번호');
			var $status_color = array( 0 => "dgr", 1 => "pk", 2 => "lgr", 3 => "bgr", 4 => "bk" );

			var $logo_extension = array( 'jpg', 'gif', 'png' );	// 로고 업로드 확장자

			var $pg_method = array(
				'inicis' => array(	// 이니시스
					'card' => array( 'gopaymethod' => 'onlycard', 'name' => '신용카드' ),
					'direct' => array( 'gopaymethod' => 'onlydbank', 'name' => '실시간 계좌이체' ),
					// 'virtual' => array( 'gopaymethod' => 'onlyvbank', 'name' => '가상계좌' ),
					'hphone' => array( 'gopaymethod' => 'onlyhpp', 'name' => '핸드폰' ),
					//'phone' => array( 'gopaymethod' => 'onlyphone', 'name' => '일반전화' ),
					'bank' => array( 'gopaymethod' => 'bank', 'name' => '무통장입금' ),
				),
				'allthegate' => array( 	// 올더게이트
					'card' => array( 'gopaymethod' => 'onlycard', 'name' => '신용카드' ),
					'direct' => array( 'gopaymethod' => 'onlyiche', 'name' => '실시간 계좌이체' ),
					// 'virtual' => array( 'gopaymethod' => 'onlyvirtual', 'name' => '가상계좌' ),
					'hphone' => array( 'gopaymethod' => 'onlyhp', 'name' => '핸드폰' ),
					//'phone' => array( 'gopaymethod' => 'onlyars', 'name' => 'ARS' ),
					'bank' => array( 'gopaymethod' => 'bank', 'name' => '무통장입금' ),
				),
				'kcp' => array( 	// KCP
					'card' => array( 'gopaymethod' => '100000000000', 'name' => '신용카드' ),
					'direct' => array( 'gopaymethod' => '010000000000', 'name' => '실시간 계좌이체' ),
					// 'virtual' => array( 'gopaymethod' => '001000000000', 'name' => '가상계좌' ),
					'hphone' => array( 'gopaymethod' => '000010000000', 'name' => '핸드폰' ),
					//'phone' => array( 'gopaymethod' => '000000000010', 'name' => 'ARS' ),
					'bank' => array( 'gopaymethod' => 'bank', 'name' => '무통장입금' ),
				),
				'nicepay' => array( 	// nicepay
					'card' => array( 'gopaymethod' => 'CARD', 'name' => '신용카드' ),
					'direct' => array( 'gopaymethod' => 'BANK', 'name' => '실시간 계좌이체' ),
					// 'virtual' => array( 'gopaymethod' => '001000000000', 'name' => '가상계좌' ),
					'hphone' => array( 'gopaymethod' => 'CELLPHONE', 'name' => '핸드폰' ),
					//'phone' => array( 'gopaymethod' => '000000000010', 'name' => 'ARS' ),
					'bank' => array( 'gopaymethod' => 'bank', 'name' => '무통장입금' ),
				),
				/*
				'lguplus' => array( 	// LG U+
					'card' => array( 'gopaymethod' => '100000000000', 'name' => '신용카드' ),
					'direct' => array( 'gopaymethod' => '010000000000', 'name' => '계좌이체' ),
					'virtual' => array( 'gopaymethod' => '001000000000', 'name' => '가상계좌' ),
					'hphone' => array( 'gopaymethod' => '000010000000', 'name' => '핸드폰' ),
					'phone' => array( 'gopaymethod' => '000000000010', 'name' => 'ARS' ),
					'bank' => array( 'gopaymethod' => 'bank', 'name' => '무통장입금' ),
				),
				*/
			);

			var $pay_method = array( 'onlycard' => '신용카드', '100000000000' => '신용카드', 'onlydbank' => '실시간 계좌이체', 'onlyiche' => '실시간 계좌이체', '010000000000' => '실시간 계좌이체', 'onlyvbank' => '가상계좌', 'onlyvirtual' => '가상계좌', '001000000000' => '가상계좌', 'onlyhpp' => '핸드폰', 'onlyhp' => '핸드폰', '000010000000' => '핸드폰', 'onlyphone' => '일반전화', 'onlyars' => 'ARS', '000000000010' => 'ARS', 'bank' => '무통장입금', );

			var $success_code = array(
					'0000' => '결제페이지 사용 설정이 완료 되었습니다.',
			);

			var $fail_code = array(
					'0000' => '결제페이지 사용 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '이니시스 상점 로고 사이즈가 너무 큽니다.\\n\\n권장 [가로 : 90px 이하, 세로 : 34px 이하]',
					'0002' => '올더게이트 상점 로고 사이즈가 너무 큽니다.\\n\\n권장 [가로 : 85px 이하, 세로 : 38px 이하]',
					'0003' => 'KCP 상점 로고 사이즈가 너무 큽니다.\\n\\n권장 [가로 : 150px 이하, 세로 : 50px 이하]',
					'0004' => '업로드 확장자가 잘못 되었습니다. [ *.jpg, *.gif, *.png 가능]',
					'0005' => '키 파일은 압축된 ZIP 파일만 업로드 가능합니다.',
					'0006' => '결제 데이터 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0007' => '결제 데이터 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);


				// 결제 리스트
				function __PayList( $page="", $page_rows="", $con="", $order="" ){

					global $member_control;

						// 검색시 사용
						$_add = $this->_Search();

						//select * from A as a join B as b where a.uid=b.uid ~~
						//$query = " select a.*, b.mb_group, b.mb_email from `".$this->pin_table."` as a join `".$member_control->member_table."` as b where a.mb_id = b.mb_id " . $con . $_add['que'];
						$query = " select * from `".$this->payment_table."` " . $con . $_add['que'];

						if(!$order) 
							$query .= " order by " . $_add['order'];
						else 
							$query .= $order;
						
						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/* 질의문 확인 
						echo "<div style='color:#fff;'>";
						echo $query;
						echo "</div><br/>";
						*/

						//echo $query;

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// 결제 페이지 사용 정보 추출
				function get_pg_page( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->pg_page_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// PG 리스트 추출
				function __PgList( $con="" ){

						$query = " select * from `".$this->pg_config_table."` " . $con;

						$result = $this->query_fetch_rows($query);


					return $result;

				}

				// PG사 설정 정보 추출 (no 기준)
				function get_pgInfo( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->pg_config_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// PG사 설정 정보 추출 (pg_company 기준)
				function get_pgInfoCompany( $pg_company ){

						if(!$pg_company || $pg_company=='') return false;

						$query = " select * from `".$this->pg_config_table."` where `pg_company` = '".$pg_company."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 사용중인 PG사 설정 정보 추출 (pg_result 기준)
				function get_use_pg( $pg_result="1" ){

						$query = " select * from `".$this->pg_config_table."` where `pg_result` = '".$pg_result."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 결제 정보 :: no 기준 (단수)
				function get_payment( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->payment_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;
				}


				// 결제 정보 :: pay_oid 기준 (단수)
				function get_payment_for_oid( $oid, $con="" ){

						if(!$oid || $oid=='') return false;

						$query = " select * from `".$this->payment_table."` where `pay_oid` = '".$oid."' " . $con;

						$result = $this->query_fetch($query);


					return $result;
				}


				// 결제 서비스 기간 추출 :: 정규직
				function get_service_alba_date( $vals ){

					global $utility;
					global $member_control, $alba_control;

						$result = array();

						$is_package = $vals['pay_package'];
						if($is_package){
							$get_payment = $this->get_payment_for_oid($vals['pay_oid']," and `pay_package` = '0' ");	// 패키지 가 아닌 결제 보
						} else {
							$get_payment = $this->get_payment_for_oid($vals['pay_oid']);	// 패키지 가 아닌 결제 보
						}

						$main_platinum = ($vals['pay_main_platinum']) ? $vals['pay_main_platinum'] : $vals['main_platinum'];

						## 메인 플래티넘 채용정보 (박스형) ######################################################################################################################
						if($is_package && $get_payment['pay_main_platinum']){

							$pay_main_platinum = explode("/",$get_payment['pay_main_platinum']);
							$pay_main_platinum_day = $pay_main_platinum[0] . " " . $pay_main_platinum[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum']) ) ? "wr_service_platinum" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_platinum` = date_add( ".$field.", interval ".$pay_main_platinum_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_platinum_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_platinum_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

						}
						if($main_platinum){	// 메인 플래티넘

							$pay_main_platinum = explode("/",$main_platinum);
							$pay_main_platinum_day = $pay_main_platinum[0] . " " . $pay_main_platinum[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_platinum_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_platinum_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum']) ) ? "wr_service_platinum" : "curdate()";
							array_push( $result, " `wr_service_platinum` = date_add( ".$field.", interval ".$pay_main_platinum_day." ) " );	

						}
						## //메인 플래티넘 채용정보 (박스형) #####################################################################################################################


						## 메인 플래티넘 채용정보 골드 (옵션) ####################################################################################################################
						$main_platinum_gold = ($vals['pay_main_platinum_gold']) ? $vals['pay_main_platinum_gold'] : $vals['main_platinum_gold'];

						if($is_package && $get_payment['pay_main_platinum_gold']){
							$pay_main_platinum_gold = explode("/",$get_payment['pay_main_platinum_gold']);
							$pay_main_platinum_gold_day = $pay_main_platinum_gold[0] . " " . $pay_main_platinum_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_main_gold']) ) ? "wr_service_platinum_main_gold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_platinum_main_gold` = date_add( ".$field.", interval ".$pay_main_platinum_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_platinum_gold){	// 메인 플래티넘 골드
							$pay_main_platinum_gold = explode("/",$main_platinum_gold);
							$pay_main_platinum_gold_day = $pay_main_platinum_gold[0] . " " . $pay_main_platinum_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_main_gold']) ) ? "wr_service_platinum_main_gold" : "curdate()";
							array_push( $result, " `wr_service_platinum_main_gold` = date_add( ".$field.", interval ".$pay_main_platinum_gold_day." ) " );
						}
						## //메인 플래티넘 채용정보 골드 (옵션) ###################################################################################################################


						## 메인 플래티넘 채용정보 로고 (옵션) ####################################################################################################################
						$main_platinum_logo = ($vals['pay_main_platinum_logo']) ? $vals['pay_main_platinum_logo'] : $vals['main_platinum_logo'];

						if($is_package && $get_payment['pay_main_platinum_logo']){
							$pay_main_platinum_logo = explode("/",$get_payment['pay_main_platinum_logo']);
							$pay_main_platinum_logo_day = $pay_main_platinum_logo[0] . " " . $pay_main_platinum_logo[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_main_logo']) ) ? "wr_service_platinum_main_logo" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_platinum_main_logo` = date_add( ".$field.", interval ".$pay_main_platinum_logo_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_platinum_logo){	// 메인 플래티넘 로고 강조
							$pay_main_platinum_logo = explode("/",$main_platinum_logo);
							$pay_main_platinum_logo_day = $pay_main_platinum_logo[0] . " " . $pay_main_platinum_logo[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_main_logo']) ) ? "wr_service_platinum_main_logo" : "curdate()";
							array_push( $result, " `wr_service_platinum_main_logo` = date_add( ".$field.", interval ".$pay_main_platinum_logo_day." ) " );
						}
						## //메인 플래티넘 채용정보 로고 (옵션) ###################################################################################################################


						## 메인 프라임 채용정보 (박스형) #######################################################################################################################
						$main_prime = ($vals['pay_main_prime']) ? $vals['pay_main_prime'] : $vals['main_prime'];

						if($is_package && $get_payment['pay_main_prime']){

							$pay_main_prime = explode("/",$get_payment['pay_main_prime']);
							$pay_main_prime_day = $pay_main_prime[0] . " " . $pay_main_prime[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_prime']) ) ? "wr_service_prime" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_prime` = date_add( ".$field.", interval ".$pay_main_prime_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_prime_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_prime_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_prime){	// 메인 프라임

							$pay_main_prime = explode("/",$main_prime);
							$pay_main_prime_day = $pay_main_prime[0] . " " . $pay_main_prime[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_prime_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_prime_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_prime']) ) ? "wr_service_prime" : "curdate()";
							array_push( $result, " `wr_service_prime` = date_add( ".$field.", interval ".$pay_main_prime_day." ) " );	

						}
						## //메인 프라임 채용정보 (박스형) ######################################################################################################################

						
						## 메인 프라임 채용정보 골드 (옵션) #####################################################################################################################
						$main_prime_gold = ($vals['pay_main_prime_gold']) ? $vals['pay_main_prime_gold'] : $vals['main_prime_gold'];

						if($is_package && $get_payment['pay_main_prime_gold']){
							$pay_main_prime_gold = explode("/",$get_payment['pay_main_prime_gold']);
							$pay_main_prime_gold_day = $pay_main_prime_gold[0] . " " . $pay_main_prime_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_prime_main_gold']) ) ? "wr_service_prime_main_gold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_prime_main_gold` = date_add( ".$field.", interval ".$pay_main_prime_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_prime_gold){	// 메인 프라임 골드
							$pay_main_prime_gold = explode("/",$main_prime_gold);
							$pay_main_prime_gold_day = $pay_main_prime_gold[0] . " " . $pay_main_prime_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_prime_main_gold']) ) ? "wr_service_prime_main_gold" : "curdate()";
							array_push( $result, " `wr_service_prime_main_gold` = date_add( ".$field.", interval ".$pay_main_prime_gold_day." ) " );
						}

						## //메인 프라임 채용정보 골드 (옵션) ####################################################################################################################


						## 메인 프라임 채용정보 로고 (옵션) #####################################################################################################################
						$main_prime_logo = ($vals['pay_main_prime_logo']) ? $vals['pay_main_prime_logo'] : $vals['main_prime_logo'];

						if($is_package && $get_payment['pay_main_prime_logo']){
							$pay_main_prime_logo = explode("/",$get_payment['pay_main_prime_logo']);
							$pay_main_prime_logo_day = $pay_main_prime_logo[0] . " " . $pay_main_prime_logo[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_prime_main_logo']) ) ? "wr_service_prime_main_logo" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_prime_main_logo` = date_add( ".$field.", interval ".$pay_main_prime_logo_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_prime_logo){	// 메인 프라임 로고 강조
							$pay_main_prime_logo = explode("/",$main_prime_logo);
							$pay_main_prime_logo_day = $pay_main_prime_logo[0] . " " . $pay_main_prime_logo[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_prime_main_logo']) ) ? "wr_service_prime_main_logo" : "curdate()";
							array_push( $result, " `wr_service_prime_main_logo` = date_add( ".$field.", interval ".$pay_main_prime_logo_day." ) " );
						}
						## //메인 프라임 채용정보 로고 (옵션) ####################################################################################################################


						## 메인 그랜드 채용정보 (박스형) #######################################################################################################################
						$main_grand = ($vals['pay_main_grand']) ? $vals['pay_main_grand'] : $vals['main_grand'];

						if($is_package && $get_payment['pay_main_grand']){
							$pay_main_grand = explode("/",$get_payment['pay_main_grand']);
							$pay_main_grand_day = $pay_main_grand[0] . " " . $pay_main_grand[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_grand']) ) ? "wr_service_grand" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_grand` = date_add( ".$field.", interval ".$pay_main_grand_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_grand_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_grand_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

						}
						if($main_grand){	// 메인 그랜드
							$pay_main_grand = explode("/",$main_grand);
							$pay_main_grand_day = $pay_main_grand[0] . " " . $pay_main_grand[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_grand_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_grand_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_grand']) ) ? "wr_service_grand" : "curdate()";
							array_push( $result, " `wr_service_grand` = date_add( ".$field.", interval ".$pay_main_grand_day." ) " );	
						}
						## //메인 그랜드 채용정보 (박스형) ######################################################################################################################


						## 메인 그랜드 채용정보 골드 (옵션) #####################################################################################################################
						$main_grand_gold = ($vals['pay_main_grand_gold']) ? $vals['pay_main_grand_gold'] : $vals['main_grand_gold'];

						if($is_package && $get_payment['pay_main_grand_gold']){
							$pay_main_grand_gold = explode("/",$get_payment['pay_main_grand_gold']);
							$pay_main_grand_gold_day = $pay_main_grand_gold[0] . " " . $pay_main_grand_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_grand_main_gold']) ) ? "wr_service_grand_main_gold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_grand_main_gold` = date_add( ".$field.", interval ".$pay_main_grand_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_grand_gold){	// 메인 그랜드 골드
							$pay_main_grand_gold = explode("/",$main_grand_gold);
							$pay_main_grand_gold_day = $pay_main_grand_gold[0] . " " . $pay_main_grand_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_grand_main_gold']) ) ? "wr_service_grand_main_gold" : "curdate()";
							array_push( $result, " `wr_service_grand_main_gold` = date_add( ".$field.", interval ".$pay_main_grand_gold_day." ) " );
						}
						## //메인 그랜드 채용정보 골드 (옵션) ####################################################################################################################


						## 메인 그랜드 채용정보 로고 (옵션) #####################################################################################################################
						$main_grand_logo = ($vals['pay_main_grand_logo']) ? $vals['pay_main_grand_logo'] : $vals['main_grand_logo'];

						if($is_package && $get_payment['pay_main_grand_logo']){
							$pay_main_grand_logo = explode("/",$get_payment['pay_main_grand_logo']);
							$pay_main_grand_logo_day = $pay_main_grand_logo[0] . " " . $pay_main_grand_logo[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_grand_main_logo']) ) ? "wr_service_grand_main_logo" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_grand_main_logo` = date_add( ".$field.", interval ".$pay_main_grand_logo_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_grand_logo){	// 메인 그랜드 로고 강조
							$pay_main_grand_logo = explode("/",$main_grand_logo);
							$pay_main_grand_logo_day = $pay_main_grand_logo[0] . " " . $pay_main_grand_logo[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_grand_main_logo']) ) ? "wr_service_grand_main_logo" : "curdate()";
							array_push( $result, " `wr_service_grand_main_logo` = date_add( ".$field.", interval ".$pay_main_grand_logo_day." ) " );
						}
						## //메인 그랜드 채용정보 로고 (옵션) #####################################################################################################################


						## 메인 배너형 채용정보 (박스형) ########################################################################################################################
						$main_banner = ($vals['pay_main_banner']) ? $vals['pay_main_banner'] : $vals['main_banner'];

						if($is_package && $get_payment['pay_main_banner']){

							$pay_main_banner = explode("/",$get_payment['pay_main_banner']);
							$pay_main_banner_day = $pay_main_banner[0] . " " . $pay_main_banner[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_banner']) ) ? "wr_service_banner" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_banner` = date_add( ".$field.", interval ".$pay_main_banner_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_banner_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_banner_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

						}
						if($main_banner){	// 메인 배너형

							$pay_main_banner = explode("/",$main_banner);
							$pay_main_banner_day = $pay_main_banner[0] . " " . $pay_main_banner[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_banner_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_banner_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_banner']) ) ? "wr_service_banner" : "curdate()";
							array_push( $result, " `wr_service_banner` = date_add( ".$field.", interval ".$pay_main_banner_day." ) " );	

						}
						## //메인 배너형 채용정보 (박스형) #######################################################################################################################


						## 메인 배너형 채용정보 골드 (옵션) ######################################################################################################################
						$main_banner_gold = ($vals['pay_main_banner_gold']) ? $vals['pay_main_banner_gold'] : $vals['main_banner_gold'];

						if($is_package && $get_payment['pay_main_banner_gold']){
							$pay_main_banner_gold = explode("/",$get_payment['pay_main_banner_gold']);
							$pay_main_banner_gold_day = $pay_main_banner_gold[0] . " " . $pay_main_banner_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_main_gold']) ) ? "wr_service_platinum_main_gold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_banner_main_gold` = date_add( ".$field.", interval ".$pay_main_banner_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_banner_gold){	// 메인 배너형 골드
							$pay_main_banner_gold = explode("/",$main_banner_gold);
							$pay_main_banner_gold_day = $pay_main_banner_gold[0] . " " . $pay_main_banner_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_banner_main_gold']) ) ? "wr_service_banner_main_gold" : "curdate()";
							array_push( $result, " `wr_service_banner_main_gold` = date_add( ".$field.", interval ".$pay_main_banner_gold_day." ) " );
						}
						## //메인 배너형 채용정보 골드 (옵션) #####################################################################################################################


						## 서브 플래티넘 채용정보 (박스형) #######################################################################################################################
						$alba_platinum = ($vals['pay_alba_platinum']) ? $vals['pay_alba_platinum'] : $vals['alba_platinum'];

						if($is_package && $get_payment['pay_alba_platinum']){

							$pay_alba_platinum = explode("/",$get_payment['pay_alba_platinum']);
							$pay_alba_platinum_day = $pay_alba_platinum[0] . " " . $pay_alba_platinum[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_sub']) ) ? "wr_service_platinum_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_platinum_sub` = date_add( ".$field.", interval ".$pay_alba_platinum_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_alba_platinum_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_alba_platinum_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

						}
						if($alba_platinum){	// 서브 플래티넘

							$pay_alba_platinum = explode("/",$alba_platinum);
							$pay_alba_platinum_day = $pay_alba_platinum[0] . " " . $pay_alba_platinum[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_alba_platinum_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_alba_platinum_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_sub']) ) ? "wr_service_platinum_sub" : "curdate()";
							array_push( $result, " `wr_service_platinum_sub` = date_add( ".$field.", interval ".$pay_alba_platinum_day." ) " );	

						}
						## //서브 플래티넘 채용정보 (박스형) ######################################################################################################################


						## 서브 플래티넘 채용정보 골드 (옵션) ######################################################################################################################
						$alba_platinum_gold = ($vals['pay_alba_platinum_gold']) ? $vals['pay_alba_platinum_gold'] : $vals['alba_platinum_gold'];

						if($is_package && $get_payment['pay_alba_platinum_gold']){
							$pay_alba_platinum_gold = explode("/",$get_payment['pay_alba_platinum_gold']);
							$pay_alba_platinum_gold_day = $pay_alba_platinum_gold[0] . " " . $pay_alba_platinum_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_sub_gold']) ) ? "wr_service_platinum_sub_gold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_platinum_sub_gold` = date_add( ".$field.", interval ".$pay_alba_platinum_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_platinum_gold){	// 서브 플래티넘 골드
							$pay_alba_platinum_gold = explode("/",$alba_platinum_gold);
							$pay_alba_platinum_gold_day = $pay_alba_platinum_gold[0] . " " . $pay_alba_platinum_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_sub_gold']) ) ? "wr_service_platinum_sub_gold" : "curdate()";
							array_push( $result, " `wr_service_platinum_sub_gold` = date_add( ".$field.", interval ".$pay_alba_platinum_gold_day." ) " );
						}
						## //서브 플래티넘 채용정보 골드 (옵션) #####################################################################################################################


						## 서브 플래티넘 채용정보 로고 (옵션) ######################################################################################################################
						$alba_platinum_logo = ($vals['pay_alba_platinum_logo']) ? $vals['pay_alba_platinum_logo'] : $vals['alba_platinum_logo'];

						if($is_package && $get_payment['pay_alba_platinum_logo']){
							$pay_alba_platinum_logo = explode("/",$get_payment['pay_alba_platinum_logo']);
							$pay_alba_platinum_logo_day = $pay_alba_platinum_logo[0] . " " . $pay_alba_platinum_logo[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_sub_logo']) ) ? "wr_service_platinum_sub_logo" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_platinum_sub_logo` = date_add( ".$field.", interval ".$pay_alba_platinum_logo_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_platinum_logo){	// 서브 플래티넘 로고 강조
							$pay_alba_platinum_logo = explode("/",$alba_platinum_logo);
							$pay_alba_platinum_logo_day = $pay_alba_platinum_logo[0] . " " . $pay_alba_platinum_logo[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_platinum_sub_logo']) ) ? "wr_service_platinum_sub_logo" : "curdate()";
							array_push( $result, " `wr_service_platinum_sub_logo` = date_add( ".$field.", interval ".$pay_alba_platinum_logo_day." ) " );
						}
						## //서브 플래티넘 채용정보 로고 (옵션) ######################################################################################################################


						## 서브 배너형 채용정보 (박스형) ##########################################################################################################################
						$alba_banner = ($vals['pay_alba_banner']) ? $vals['pay_alba_banner'] : $vals['alba_banner'];

						if($is_package && $get_payment['pay_alba_banner']){

							$pay_alba_banner = explode("/",$get_payment['pay_alba_banner']);
							$pay_alba_banner_day = $pay_alba_banner[0] . " " . $pay_alba_banner[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_banner_sub']) ) ? "wr_service_banner_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_banner_sub` = date_add( ".$field.", interval ".$pay_alba_banner_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_alba_banner_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_alba_banner_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

						}
						if($alba_banner){	// 서브 배너형

							$pay_alba_banner = explode("/",$alba_banner);
							$pay_alba_banner_day = $pay_alba_banner[0] . " " . $pay_alba_banner[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_alba_banner_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_alba_banner_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_banner_sub']) ) ? "wr_service_banner_sub" : "curdate()";
							array_push( $result, " `wr_service_banner_sub` = date_add( ".$field.", interval ".$pay_alba_banner_day." ) " );	

						}
						## //서브 배너형 채용정보 (박스형) #########################################################################################################################


						## 서브 배너형 채용정보 골드 (옵션) ########################################################################################################################
						$alba_banner_gold = ($vals['pay_alba_banner_gold']) ? $vals['pay_alba_banner_gold'] : $vals['alba_banner_gold'];

						if($is_package && $get_payment['pay_alba_banner_gold']){
							$pay_alba_banner_gold = explode("/",$get_payment['pay_alba_banner_gold']);
							$pay_alba_banner_gold_day = $pay_alba_banner_gold[0] . " " . $pay_alba_banner_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_banner_sub_gold']) ) ? "wr_service_banner_sub_gold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_banner_sub_gold` = date_add( ".$field.", interval ".$pay_alba_banner_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_banner_gold){	// 서브 배너형 골드
							$pay_alba_banner_gold = explode("/",$alba_banner_gold);
							$pay_alba_banner_gold_day = $pay_alba_banner_gold[0] . " " . $pay_alba_banner_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_banner_sub_gold']) ) ? "wr_service_banner_sub_gold" : "curdate()";
							array_push( $result, " `wr_service_banner_sub_gold` = date_add( ".$field.", interval ".$pay_alba_banner_gold_day." ) " );
						}
						## //서브 배너형 채용정보 골드 (옵션) #######################################################################################################################


						## 메인 리스트형 ####################################################################################################################################
						$main_list = ($vals['pay_main_list']) ? $vals['pay_main_list'] : $vals['main_list'];

						if($is_package && $get_payment['pay_main_list']){
							$pay_main_list = explode("/",$get_payment['pay_main_list']);
							$pay_main_list_day = $pay_main_list[0] . " " . $pay_main_list[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_list']) ) ? "wr_service_list" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_list` = date_add( ".$field.", interval ".$pay_main_list_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_list){	// 메인 리스트형
							$pay_main_list = explode("/",$main_list);
							$pay_main_list_day = $pay_main_list[0] . " " . $pay_main_list[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_list']) ) ? "wr_service_list" : "curdate()";
							array_push( $result, " `wr_service_list` = date_add( ".$field.", interval ".$pay_main_list_day." ) " );
						}
						## //메인 리스트형 ###################################################################################################################################


						## 메인 리스트형 골드 (옵션) #############################################################################################################################
						$main_list_gold = ($vals['pay_main_list_gold']) ? $vals['pay_main_list_gold'] : $vals['main_list_gold'];

						if($is_package && $get_payment['pay_main_list_gold']){
							$pay_main_list_gold = explode("/",$get_payment['pay_main_list_gold']);
							$pay_main_list_gold_day = $pay_main_list_gold[0] . " " . $pay_main_list_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_list_main_gold']) ) ? "wr_service_list_main_gold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_list_main_gold` = date_add( ".$field.", interval ".$pay_main_list_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($main_list_gold){	// 메인 리스트형 골드
							$pay_main_list_gold = explode("/",$main_list_gold);
							$pay_main_list_gold_day = $pay_main_list_gold[0] . " " . $pay_main_list_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_list_main_gold']) ) ? "wr_service_list_main_gold" : "curdate()";
							array_push( $result, " `wr_service_list_main_gold` = date_add( ".$field.", interval ".$pay_main_list_gold_day." ) " );
						}
						## //메인 리스트형 골드 (옵션) ############################################################################################################################


						## 서브 리스트형 ####################################################################################################################################
						$alba_list = ($vals['pay_alba_list']) ? $vals['pay_alba_list'] : $vals['alba_list'];

						if($is_package && $get_payment['pay_alba_list']){
							$pay_alba_list = explode("/",$get_payment['pay_alba_list']);
							$pay_alba_list_day = $pay_alba_list[0] . " " . $pay_alba_list[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_list_sub']) ) ? "wr_service_list_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_list_sub` = date_add( ".$field.", interval ".$pay_alba_list_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_list){	// 서브 리스트형
							$pay_alba_list = explode("/",$alba_list);
							$pay_alba_list_day = $pay_alba_list[0] . " " . $pay_alba_list[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_list_sub']) ) ? "wr_service_list_sub" : "curdate()";
							array_push( $result, " `wr_service_list_sub` = date_add( ".$field.", interval ".$pay_alba_list_day." ) " );
						}
						## //서브 리스트형 ###################################################################################################################################

						
						## 서브 리스트형 골드 (옵션) #############################################################################################################################
						$alba_list_gold = ($vals['pay_alba_list_gold']) ? $vals['pay_alba_list_gold'] : $vals['alba_list_gold'];

						if($is_package && $get_payment['pay_alba_list_gold']){
							$pay_alba_list_gold = explode("/",$get_payment['pay_alba_list_gold']);
							$pay_alba_list_gold_day = $pay_alba_list_gold[0] . " " . $pay_alba_list_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_list_sub_gold']) ) ? "wr_service_list_sub_gold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_list_sub_gold` = date_add( ".$field.", interval ".$pay_alba_list_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_list_gold){	// 서브 리스트형 골드
							$pay_alba_list_gold = explode("/",$alba_list_gold);
							$pay_alba_list_gold_day = $pay_alba_list_gold[0] . " " . $pay_alba_list_gold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_list_sub_gold']) ) ? "wr_service_list_sub_gold" : "curdate()";
							array_push( $result, " `wr_service_list_sub_gold` = date_add( ".$field.", interval ".$pay_alba_list_gold_day." ) " );
						}
						## //서브 리스트형 골드 (옵션) ############################################################################################################################


						## 메인 일반 리스트 채용정보 #############################################################################################################################
						$main_basic = ($vals['pay_main_basic']) ? $vals['pay_main_basic'] : $vals['main_basic'];

						if($is_package && $get_payment['pay_main_basic']){

							$pay_main_basic = explode("/",$get_payment['pay_main_basic']);
							$pay_main_basic_day = $pay_main_basic[0] . " " . $pay_main_basic[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic` = date_add( ".$field.", interval ".$pay_main_basic_day." ) , `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

						}
						if($main_basic){	// 메인 일반 리스트

							$pay_main_basic = explode("/",$main_basic);
							$pay_main_basic_day = $pay_main_basic[0] . " " . $pay_main_basic[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							array_push( $result, " `wr_service_basic` = date_add( ".$field.", interval ".$pay_main_basic_day." ) " );

						}
						## //메인 일반 리스트 채용정보 ############################################################################################################################


						## 서브 일반 리스트 채용정보 #############################################################################################################################
						$alba_basic = ($vals['pay_alba_basic']) ? $vals['pay_alba_basic'] : $vals['alba_basic'];

						if($is_package && $get_payment['pay_alba_basic']){
							$pay_alba_basic = explode("/",$get_payment['pay_alba_basic']);
							$pay_alba_basic_day = $pay_alba_basic[0] . " " . $pay_alba_basic[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_basic_sub` = date_add( ".$field.", interval ".$pay_alba_basic_day." ) , `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

						}
						if($alba_basic){	// 서브 일반 리스트

							$pay_alba_basic = explode("/",$alba_basic);
							$pay_alba_basic_day = $pay_alba_basic[0] . " " . $pay_alba_basic[1];

							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							array_push( $result, " `wr_service_basic_sub` = date_add( ".$field.", interval ".$pay_alba_basic_day." ) " );

						}
						## //서브 일반 리스트 채용정보 ############################################################################################################################


						## 급구 채용정보 (옵션) ################################################################################################################################
						$alba_option_busy = ($vals['pay_alba_option_busy']) ? $vals['pay_alba_option_busy'] : $vals['alba_option_busy'];

						if($is_package && $get_payment['pay_alba_option_busy']){
							$pay_alba_option_busy = explode("/",$get_payment['pay_alba_option_busy']);
							$pay_alba_option_busy_day = $pay_alba_option_busy[0] . " " . $pay_alba_option_busy[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_busy']) ) ? "wr_service_busy" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_busy` = date_add( ".$field.", interval ".$pay_alba_option_busy_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_option_busy){	// 정규직 급구 옵션
							$pay_alba_option_busy = explode("/",$alba_option_busy);
							$pay_alba_option_busy_day = $pay_alba_option_busy[0] . " " . $pay_alba_option_busy[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_busy']) ) ? "wr_service_busy" : "curdate()";
							array_push( $result, " `wr_service_busy` = date_add( ".$field.", interval ".$pay_alba_option_busy_day." ) " );
						}
						## //급구 채용정보 (옵션) ###############################################################################################################################

						
						## 형광펜 (옵션) #####################################################################################################################################
						$alba_option_neon = ($vals['pay_alba_option_neon']) ? $vals['pay_alba_option_neon'] : $vals['alba_option_neon'];

						if($is_package && $get_payment['pay_alba_option_neon']){
							$pay_alba_option_neon = explode("/",$get_payment['pay_alba_option_neon']);
							$pay_alba_option_neon_day = $pay_alba_option_neon[0] . " " . $pay_alba_option_neon[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_neon']) ) ? "wr_service_neon" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_neon` = date_add( ".$field.", interval ".$pay_alba_option_neon_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_option_neon){	// 정규직 형광색 옵션
							$pay_alba_option_neon = explode("/",$alba_option_neon);
							$pay_alba_option_neon_day = $pay_alba_option_neon[0] . " " . $pay_alba_option_neon[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_neon']) ) ? "wr_service_neon" : "curdate()";
							array_push( $result, " `wr_service_neon` = date_add( ".$field.", interval ".$pay_alba_option_neon_day." ) " );
						}
						## //형광펜 (옵션) ####################################################################################################################################


						## 굵은글자 (옵션) ####################################################################################################################################
						$alba_option_bold = ($vals['pay_alba_option_bold']) ? $vals['pay_alba_option_bold'] : $vals['alba_option_bold'];

						if($is_package && $get_payment['pay_alba_option_bold']){
							$pay_alba_option_bold = explode("/",$get_payment['pay_alba_option_bold']);
							$pay_alba_option_bold_day = $pay_alba_option_bold[0] . " " . $pay_alba_option_bold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_bold']) ) ? "wr_service_bold" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_bold` = date_add( ".$field.", interval ".$pay_alba_option_bold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_option_bold){	// 정규직 굵은글자 옵션
							$pay_alba_option_bold = explode("/",$alba_option_bold);
							$pay_alba_option_bold_day = $pay_alba_option_bold[0] . " " . $pay_alba_option_bold[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_bold']) ) ? "wr_service_bold" : "curdate()";
							array_push( $result, " `wr_service_bold` = date_add( ".$field.", interval ".$pay_alba_option_bold_day." ) " );
						}
						## //굵은글자 (옵션) ###################################################################################################################################


						## 아이콘 (옵션) #####################################################################################################################################
						$alba_option_icon = ($vals['pay_alba_option_icon']) ? $vals['pay_alba_option_icon'] : $vals['alba_option_icon'];

						if($is_package && $get_payment['pay_alba_option_icon']){
							$pay_alba_option_icon = explode("/",$get_payment['pay_alba_option_icon']);
							$pay_alba_option_icon_day = $pay_alba_option_icon[0] . " " . $pay_alba_option_icon[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_icon']) ) ? "wr_service_icon" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_icon` = date_add( ".$field.", interval ".$pay_alba_option_icon_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_option_icon){	// 정규직 아이콘 옵션
							$pay_alba_option_icon = explode("/",$alba_option_icon);
							$pay_alba_option_icon_day = $pay_alba_option_icon[0] . " " . $pay_alba_option_icon[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_icon']) ) ? "wr_service_icon" : "curdate()";
							array_push( $result, " `wr_service_icon` = date_add( ".$field.", interval ".$pay_alba_option_icon_day." ) " );
						}
						## //아이콘 (옵션) #####################################################################################################################################

						
						## 글자색 (옵션) ######################################################################################################################################
						$alba_option_color = ($vals['pay_alba_option_color']) ? $vals['pay_alba_option_color'] : $vals['alba_option_color'];

						if($is_package && $get_payment['pay_alba_option_color']){
							$pay_alba_option_color = explode("/",$get_payment['pay_alba_option_color']);
							$pay_alba_option_color_day = $pay_alba_option_color[0] . " " . $pay_alba_option_color[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_color']) ) ? "wr_service_color" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_color` = date_add( ".$field.", interval ".$pay_alba_option_color_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_option_color){	// 정규직 글자색 옵션
							$pay_alba_option_color = explode("/",$alba_option_color);
							$pay_alba_option_color_day = $pay_alba_option_color[0] . " " . $pay_alba_option_color[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_color']) ) ? "wr_service_color" : "curdate()";
							array_push( $result, " `wr_service_color` = date_add( ".$field.", interval ".$pay_alba_option_color_day." ) " );
						}
						## //글자색 (옵션) #####################################################################################################################################

						
						## 깜빡임 (옵션) ######################################################################################################################################
						$alba_option_blink = ($vals['pay_alba_option_blink']) ? $vals['pay_alba_option_blink'] : $vals['alba_option_blink'];

						if($is_package && $get_payment['pay_alba_option_blink']){
							$pay_alba_option_blink = explode("/",$get_payment['pay_alba_option_blink']);
							$pay_alba_option_blink_day = $pay_alba_option_blink[0] . " " . $pay_alba_option_blink[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_blink']) ) ? "wr_service_blink" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_blink` = date_add( ".$field.", interval ".$pay_alba_option_blink_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_option_blink){	// 정규직 깜빡임 옵션
							$pay_alba_option_blink = explode("/",$alba_option_blink);
							$pay_alba_option_blink_day = $pay_alba_option_blink[0] . " " . $pay_alba_option_blink[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_blink']) ) ? "wr_service_blink" : "curdate()";
							array_push( $result, " `wr_service_blink` = date_add( ".$field.", interval ".$pay_alba_option_blink_day." ) " );
						}
						## 깜빡임 (옵션) ######################################################################################################################################


						## 점프 (옵션) #######################################################################################################################################
						$alba_option_jump = ($vals['pay_alba_option_jump']) ? $vals['pay_alba_option_jump'] : $vals['alba_option_jump'];

						if($is_package && $get_payment['pay_alba_option_jump']){
							$pay_alba_option_jump = explode("/",$get_payment['pay_alba_option_jump']);
							$pay_alba_option_jump_day = $pay_alba_option_jump[0] . " " . $pay_alba_option_jump[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_jump']) ) ? "wr_service_jump" : "curdate()";
							$this->_query(" update `alice_alba` set `wr_service_jump` = date_add( ".$field.", interval ".$pay_alba_option_jump_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($alba_option_jump){	// 정규직 점프 옵션
							$pay_alba_option_jump = explode("/",$alba_option_jump);
							$pay_alba_option_jump_day = $pay_alba_option_jump[0] . " " . $pay_alba_option_jump[1];
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_alba['wr_service_jump']) ) ? "wr_service_jump" : "curdate()";
							array_push( $result, " `wr_service_jump` = date_add( ".$field.", interval ".$pay_alba_option_jump_day." ) " );
							array_push( $result, " `wr_jdate` = now() " );
						}
						## //점프 (옵션) ######################################################################################################################################
						

						if($vals['pay_etc_open']){	// 이력서 열람 서비스
							$pay_etc_open = explode("/",$vals['pay_etc_open']);

							if($pay_etc_open[1]=='count'){	// 건별 결제

								if($is_package && $get_payment['pay_etc_open']){
									$pay_etc_open = explode("/",$get_payment['pay_etc_open']);
									if($pay_etc_open[5] && $pay_etc_open[6]){
										$pay_etc_open_day = $pay_etc_open[5] . " " . $pay_etc_open[6];
									} else {
										$pay_etc_open_day = "12 month";	// 무제한일때 유예 기간 1년
									}
									$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
									$pay_etc_open_count = $member_service['mb_service_open_count'] + $pay_etc_open[0];
									$add_field = ( $utility->valid_day($member_service['mb_service_open']) ) ? "mb_service_open" : "curdate()";
									$this->_query(" update `alice_member_service` set `mb_service_open_count` = date_add( ".$add_field.", interval ".$pay_etc_open_day."), `mb_service_open_count` = '".$pay_etc_open_count."' where `mb_id` = '".$get_payment['pay_uid']."' ");

									echo "1 :: update `alice_member_service` set `mb_service_open_count` = date_add( ".$add_field.", interval ".$pay_etc_open_day."), `mb_service_open_count` = '".$pay_etc_open_count."' where `mb_id` = '".$get_payment['pay_uid']."' \n\n";
								}
								if($vals['pay_etc_open']){
									$pay_etc_open = explode("/",$vals['pay_etc_open']);
									if($pay_etc_open[5] && $pay_etc_open[6]){
										$pay_etc_open_day = $pay_etc_open[5] . " " . $pay_etc_open[6];
									} else {
										$pay_etc_open_day = "12 month";	// 무제한일때 유예 기간 1년
									}
									$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
									$pay_etc_open_count = $member_service['mb_service_open_count'] + $pay_etc_open[0];
									$add_field = ( $utility->valid_day($member_service['mb_service_open']) ) ? "mb_service_open" : "curdate()";
									$this->_query(" update `alice_member_service` set `mb_service_open` = date_add( ".$add_field.", interval ".$pay_etc_open_day."), `mb_service_open_count` = '".$pay_etc_open_count."' where `mb_id` = '".$vals['pay_uid']."' ");

									echo "2 :: update `alice_member_service` set `mb_service_open` = date_add( ".$add_field.", interval ".$pay_etc_open_day."), `mb_service_open_count` = '".$pay_etc_open_count."' where `mb_id` = '".$vals['pay_uid']."' \n\n";
								}

							} else {	 // 기간 결제
								
								if($is_package && $get_payment['pay_etc_open']){
									$pay_etc_open = explode("/",$get_payment['pay_etc_open']);
									$pay_etc_open_day = $pay_etc_open[5] . " " . $pay_etc_open[6];
									$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
									$add_field = ( $utility->valid_day($member_service['mb_service_open']) ) ? "mb_service_open" : "curdate()";
									$this->_query(" update `alice_member_service` set `mb_service_open` = date_add( ".$add_field.", interval ".$pay_etc_open_day.") where `mb_id` = '".$get_payment['pay_uid']."' ");
									echo "3 :: update `alice_member_service` set `mb_service_open` = date_add( ".$add_field.", interval ".$pay_etc_open_day.") where `mb_id` = '".$get_payment['pay_uid']."' \n\n";
								}
								if($vals['pay_etc_open']){
									$pay_etc_open = explode("/",$vals['pay_etc_open']);
									$pay_etc_open_day = $pay_etc_open[0] . " " . $pay_etc_open[1];
									$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
									$add_field = ( $utility->valid_day($member_service['mb_service_open']) ) ? "mb_service_open" : "curdate()";
									$this->_query(" update `alice_member_service` set `mb_service_open` = date_add( ".$add_field.", interval ".$pay_etc_open_day.") where `mb_id` = '".$vals['pay_uid']."' ");
									echo "4 :: update `alice_member_service` set `mb_service_open` = date_add( ".$add_field.", interval ".$pay_etc_open_day.") where `mb_id` = '".$vals['pay_uid']."' \n\n";
								}

							}
						}

						if($is_package && $get_payment['pay_etc_sms']){
							$pay_etc_sms = explode("/",$get_payment['pay_etc_sms']);
							if($pay_etc_sms[1]=='count'){	// 건별 결제
								if($pay_etc_sms[5] && $pay_etc_sms[6]){
									$pay_etc_sms_day = $pay_etc_sms[5] . " " . $pay_etc_sms[6];
								} else {
									$pay_etc_sms_day = "12 month";	// 무제한일때 유예 기간 1년
								}
								$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
								$pay_etc_sms_count = $member_service['mb_service_sms_count'] + $pay_etc_sms[0];
								$this->_query(" update `alice_member_service` set `mb_service_sms_count` = '".$pay_etc_sms_count."' where `mb_id` = '".$vals['pay_uid']."' ");	 // SMS 서비스 건수 부여
								$this->_query(" update `alice_member` set `mb_sms` = '".$pay_etc_sms_count."' where `mb_id` = '".$vals['pay_uid']."' ");	 // 회원 SMS 건수 부여
							}
						}
						if($vals['pay_etc_sms']){	// SMS 충전 서비스
							$pay_etc_sms = explode("/",$vals['pay_etc_sms']);
							if($pay_etc_sms[1]=='count'){	// 건별 결제
								if($pay_etc_sms[5] && $pay_etc_sms[6]){
									$pay_etc_sms_day = $pay_etc_sms[5] . " " . $pay_etc_sms[6];
								} else {
									$pay_etc_sms_day = "12 month";	// 무제한일때 유예 기간 1년
								}
								$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
								$pay_etc_sms_count = $member_service['mb_service_sms_count'] + $pay_etc_sms[0];
								$this->_query(" update `alice_member_service` set `mb_service_sms_count` = '".$pay_etc_sms_count."' where `mb_id` = '".$vals['pay_uid']."' ");	 // SMS 서비스 건수 부여
								$this->_query(" update `alice_member` set `mb_sms` = '".$pay_etc_sms_count."' where `mb_id` = '".$vals['pay_uid']."' ");	 // 회원 SMS 건수 부여
							}
						}
						

					return @implode($result,',');

				}


				// 결제 서비스 기간 추출 :: 정규직 이력서
				function get_service_alba_resume_date( $vals ){

					global $utility;
					global $member_control, $package_control, $alba_resume_control;


						$result = array();

						$is_package = $vals['pay_package'];
						if($is_package){
							$get_payment = $this->get_payment_for_oid($vals['pay_oid']," and `pay_package` = '0' ");	// 패키지 가 아닌 결제 정보
						} else {
							$get_payment = $this->get_payment_for_oid($vals['pay_oid']);	// 패키지 가 아닌 결제 보
						}
						$get_package = $package_control->get_package($is_package);


						## 메인 포커스 인재정보 (박스형) ######################################################################################################################
						if($is_package && $get_payment['pay_main_focus']){	// 패키지 서비스 결제
							$pay_main_focus = explode("/",$get_payment['pay_main_focus']);
							$pay_main_focus_day = $pay_main_focus[0] . " " . $pay_main_focus[1];

							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_main_focus']) ) ? "wr_service_main_focus" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_main_focus` = date_add( ".$field.", interval ".$pay_main_focus_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
							
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_resume['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_resume['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_focus_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_focus_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_main_focus']){	// 이력서 메인 포커스
							$pay_main_focus = explode("/",$vals['pay_main_focus']);
							$pay_main_focus_day = $pay_main_focus[0] . " " . $pay_main_focus[1];

							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_resume['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_resume['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_main_focus_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_main_focus_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_main_focus']) ) ? "wr_service_main_focus" : "curdate()";
							array_push( $result, " `wr_service_main_focus` = date_add( ".$field.", interval ".$pay_main_focus_day." ) " );	
						}
						## //메인 포커스 인재정보 (박스형) #####################################################################################################################


						## 메인 포커스 인재정보 골드 (옵션) ####################################################################################################################
						if($is_package && $get_payment['pay_main_focus_gold']){	// 패키지 서비스 결제
							$pay_main_focus_gold = explode("/",$get_payment['pay_main_focus']);
							$pay_main_focus_gold_day = $pay_main_focus_gold[0] . " " . $pay_main_focus_gold[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_main_focus_gold']) ) ? "wr_service_main_focus_gold" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_main_focus_gold` = date_add( ".$field.", interval ".$pay_main_focus_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_main_focus_gold']){	// 이력서 메인 포커스 골드
							$pay_main_focus_gold = explode("/",$vals['pay_main_focus']);
							$pay_main_focus_gold_day = $pay_main_focus_gold[0] . " " . $pay_main_focus_gold[1];
							// 메인 포커스 인재정보 골드 서비스 기간 부여
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_main_focus_gold']) ) ? "wr_service_main_focus_gold" : "curdate()";
							array_push( $result, " `wr_service_main_focus_gold` = date_add( ".$field.", interval ".$pay_main_focus_gold_day." ) " );
						}
						## //메인 포커스 인재정보 골드 (옵션) ###################################################################################################################


						## 서브 포커스 인재정보 (박스형) ######################################################################################################################
						if($is_package && $get_payment['pay_alba_resume_focus']){
							$pay_alba_resume_focus = explode("/",$get_payment['pay_alba_resume_focus']);
							$pay_alba_resume_focus_day = $pay_alba_resume_focus[0] . " " . $pay_alba_resume_focus[1];
							
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_sub_focus']) ) ? "wr_service_sub_focus" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_sub_focus` = date_add( ".$field.", interval ".$pay_alba_resume_focus_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
							
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_resume['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_resume['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_alba_resume_focus_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_alba_resume_focus_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_alba_resume_focus']){	// 이력서 서브 포커스
							$pay_alba_resume_focus = explode("/",$vals['pay_alba_resume_focus']);
							$pay_alba_resume_focus_day = $pay_alba_resume_focus[0] . " " . $pay_alba_resume_focus[1];

							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$service_basic_field = ( $utility->valid_day($get_resume['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$service_basic_sub_field = ( $utility->valid_day($get_resume['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_basic` = date_add( ".$service_basic_field.", interval ".$pay_alba_resume_focus_day." ), `wr_service_basic_sub` = date_add( ".$service_basic_sub_field.", interval ".$pay_alba_resume_focus_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");

							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_sub_focus']) ) ? "wr_service_sub_focus" : "curdate()";
							array_push( $result, " `wr_service_sub_focus` = date_add( ".$field.", interval ".$pay_alba_resume_focus_day." ) " );
						}
						## //서브 포커스 인재정보 (박스형) #####################################################################################################################


						## 서브 포커스 인재정보 골드 (옵션) ####################################################################################################################
						if($is_package && $get_payment['pay_alba_resume_focus_gold']){
							$pay_alba_resume_focus_gold = explode("/",$get_payment['pay_alba_resume_focus_gold']);
							$pay_alba_resume_focus_gold_day = $pay_alba_resume_focus_gold[0] . " " . $pay_alba_resume_focus_gold[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_sub_focus_gold']) ) ? "wr_service_sub_focus_gold" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_sub_focus_gold` = date_add( ".$field.", interval ".$pay_alba_resume_focus_gold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_alba_resume_focus_gold']){	// 이력서 서브 포커스 골드
							$pay_alba_resume_focus_gold = explode("/",$vals['pay_alba_resume_focus_gold']);
							$pay_alba_resume_focus_gold_day = $pay_alba_resume_focus_gold[0] . " " . $pay_alba_resume_focus_gold[1];
							// 서브 포커스 골드 서비스 기간 부여
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_sub_focus_gold']) ) ? "wr_service_sub_focus_gold" : "curdate()";
							array_push( $result, " `wr_service_sub_focus_gold` = date_add( ".$field.", interval ".$pay_alba_resume_focus_gold_day." ) " );
						}
						## //서브 포커스 인재정보 골드 (옵션) ###################################################################################################################


						## 메인 일반 리스트 인재정보 ########################################################################################################################
						if($is_package && $get_payment['pay_main_resume_basic']){	// 패키지 서비스 결제
							$pay_main_list = explode("/",$get_payment['pay_main_resume_basic']);
							$pay_main_list_day = $pay_main_list[0] . " " . $pay_main_list[1];

							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_basic` = date_add( ".$field.", interval ".$pay_main_list_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_main_resume_basic']){	// 이력서 메인 일반리스트
							$pay_main_list = explode("/",$vals['pay_main_resume_basic']);
							$pay_main_list_day = $pay_main_list[0] . " " . $pay_main_list[1];

							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_basic']) ) ? "wr_service_basic" : "curdate()";
							array_push( $result, " `wr_service_basic` = date_add( ".$field.", interval ".$pay_main_list_day." ) " );
						}
						## //메인 일반 리스트 인재정보 #######################################################################################################################


						## 서브 일반 리스트 인재정보 ########################################################################################################################
						if($is_package && $get_payment['pay_resume_basic']){
							$pay_sub_list = explode("/",$get_payment['pay_resume_basic']);
							$pay_sub_list_day = $pay_sub_list[0] . " " . $pay_sub_list[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_basic_sub` = date_add( ".$field.", interval ".$pay_sub_list_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_resume_basic']){	// 이력서 서브 일반리스트
							$pay_sub_list = explode("/",$vals['pay_resume_basic']);
							$pay_sub_list_day = $pay_sub_list[0] . " " . $pay_sub_list[1];
							// 메인 일반 리스트 서비스 기간 부여
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_basic_sub']) ) ? "wr_service_basic_sub" : "curdate()";
							array_push( $result, " `wr_service_basic_sub` = date_add( ".$field.", interval ".$pay_sub_list_day." ) " );
						}
						## //서브 일반 리스트 인재정보 #######################################################################################################################


						## 급구 인재정보 (옵션) ###########################################################################################################################
						if($is_package && $get_payment['pay_resume_option_busy']){
							$pay_resume_option_busy = explode("/",$get_payment['pay_resume_option_busy']);
							$pay_resume_option_busy_day = $pay_resume_option_busy[0] . " " . $pay_resume_option_busy[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_busy']) ) ? "wr_service_busy" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_busy` = date_add( ".$field.", interval ".$pay_resume_option_busy_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_resume_option_busy']){	// 이력서 급구 옵션
							$pay_resume_option_busy = explode("/",$vals['pay_resume_option_busy']);
							$pay_resume_option_busy_day = $pay_resume_option_busy[0] . " " . $pay_resume_option_busy[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_busy']) ) ? "wr_service_busy" : "curdate()";
							array_push( $result, " `wr_service_busy` = date_add( ".$field.", interval ".$pay_resume_option_busy_day." ) " );
						}
						## //급구 인재정보 (옵션) ##########################################################################################################################


						## 형광펜 (옵션) ################################################################################################################################
						if($is_package && $get_payment['pay_resume_option_neon']){
							$pay_resume_option_neon = explode("/",$get_payment['pay_resume_option_neon']);
							$pay_resume_option_neon_day = $pay_resume_option_neon[0] . " " . $pay_resume_option_neon[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_neon']) ) ? "wr_service_neon" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_neon` = date_add( ".$field.", interval ".$pay_resume_option_neon_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_resume_option_neon']){	// 이력서 형광색 옵션
							$pay_resume_option_neon = explode("/",$vals['pay_resume_option_neon']);
							$pay_resume_option_neon_day = $pay_resume_option_neon[0] . " " . $pay_resume_option_neon[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_neon']) ) ? "wr_service_neon" : "curdate()";
							array_push( $result, " `wr_service_neon` = date_add( ".$field.", interval ".$pay_resume_option_neon_day." ) " );
						}
						## //형광펜 (옵션) ###############################################################################################################################


						## 굵은글자 (옵션) ###############################################################################################################################
						if($is_package && $get_payment['pay_resume_option_bold']){
							$pay_resume_option_bold = explode("/",$get_payment['pay_resume_option_bold']);
							$pay_resume_option_bold_day = $pay_resume_option_bold[0] . " " . $pay_resume_option_bold[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_bold']) ) ? "wr_service_bold" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_bold` = date_add( ".$field.", interval ".$pay_resume_option_bold_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_resume_option_bold']){	// 이력서 굵은글자 옵션
							$pay_resume_option_bold = explode("/",$vals['pay_resume_option_bold']);
							$pay_resume_option_bold_day = $pay_resume_option_bold[0] . " " . $pay_resume_option_bold[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_bold']) ) ? "wr_service_bold" : "curdate()";
							array_push( $result, " `wr_service_bold` = date_add( ".$field.", interval ".$pay_resume_option_bold_day." ) " );
						}
						## //굵은글자 (옵션) ##############################################################################################################################


						## 글자색 (옵션) ################################################################################################################################
						if($is_package && $get_payment['pay_resume_option_color']){
							$pay_resume_option_color = explode("/",$get_payment['pay_resume_option_color']);
							$pay_resume_option_color_day = $pay_resume_option_color[0] . " " . $pay_resume_option_color[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_color']) ) ? "wr_service_color" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_color` = date_add( ".$field.", interval ".$pay_resume_option_color_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_resume_option_color']){	// 이력서 글자색 옵션
							$pay_resume_option_color = explode("/",$vals['pay_resume_option_color']);
							$pay_resume_option_color_day = $pay_resume_option_color[0] . " " . $pay_resume_option_color[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_color']) ) ? "wr_service_color" : "curdate()";
							array_push( $result, " `wr_service_color` = date_add( ".$field.", interval ".$pay_resume_option_color_day." ) " );
						}
						## //글자색 (옵션) ###############################################################################################################################


						## 아이콘 (옵션) ################################################################################################################################
						if($is_package && $get_payment['pay_resume_option_icon']){
							$pay_resume_option_icon = explode("/",$get_payment['pay_resume_option_icon']);
							$pay_resume_option_icon_day = $pay_resume_option_icon[0] . " " . $pay_resume_option_icon[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_icon']) ) ? "wr_service_icon" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_icon` = date_add( ".$field.", interval ".$pay_resume_option_icon_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_resume_option_icon']){	// 이력서 아이콘 옵션
							$pay_resume_option_icon = explode("/",$vals['pay_resume_option_icon']);
							$pay_resume_option_icon_day = $pay_resume_option_icon[0] . " " . $pay_resume_option_icon[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_icon']) ) ? "wr_service_icon" : "curdate()";
							array_push( $result, " `wr_service_icon` = date_add( ".$field.", interval ".$pay_resume_option_icon_day." ) " );
						}
						## //아이콘 (옵션) ###############################################################################################################################


						## 반짝임 (옵션) ################################################################################################################################
						if($is_package && $get_payment['pay_resume_option_blink']){
							$pay_resume_option_blink = explode("/",$get_payment['pay_resume_option_blink']);
							$pay_resume_option_blink_day = $pay_resume_option_blink[0] . " " . $pay_resume_option_blink[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_blink']) ) ? "wr_service_blink" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_blink` = date_add( ".$field.", interval ".$pay_resume_option_blink_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_resume_option_blink']){	// 이력서 깜빡임 옵션
							$pay_resume_option_blink = explode("/",$vals['pay_resume_option_blink']);
							$pay_resume_option_blink_day = $pay_resume_option_blink[0] . " " . $pay_resume_option_blink[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_blink']) ) ? "wr_service_blink" : "curdate()";
							array_push( $result, " `wr_service_blink` = date_add( ".$field.", interval ".$pay_resume_option_blink_day." ) " );
						}
						## //반짝임 (옵션) ################################################################################################################################


						## 점프 (옵션) ##################################################################################################################################
						if($is_package && $get_payment['pay_resume_option_jump']){
							$pay_resume_option_jump = explode("/",$get_payment['pay_resume_option_jump']);
							$pay_resume_option_jump_day = $pay_resume_option_jump[0] . " " . $pay_resume_option_jump[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_jump']) ) ? "wr_service_jump" : "curdate()";
							$this->_query(" update `alice_alba_resume` set `wr_service_jump` = date_add( ".$field.", interval ".$pay_resume_option_jump_day." ), `wr_udate` = now() where `no` = '".$get_payment['pay_no']."' ");
						}
						if($vals['pay_resume_option_jump']){	// 이력서 점프 옵션
							$pay_resume_option_jump = explode("/",$vals['pay_resume_option_jump']);
							$pay_resume_option_jump_day = $pay_resume_option_jump[0] . " " . $pay_resume_option_jump[1];
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);
							$field = ( $utility->valid_day($get_resume['wr_service_jump']) ) ? "wr_service_jump" : "curdate()";
							array_push( $result, " `wr_service_jump` = date_add( ".$field.", interval ".$pay_resume_option_jump_day." ) " );
						}
						## //점프 (옵션) #################################################################################################################################


						if($vals['pay_etc_alba']){	// 채용공고 열람 서비스
							$pay_etc_alba = explode("/",$vals['pay_etc_alba']);

							if($pay_etc_alba[1]=='count'){	// 건별 결제

								if($is_package && $get_payment['pay_etc_alba']){
									$pay_etc_alba = explode("/",$get_payment['pay_etc_alba']);
									if($pay_etc_alba[5] && $pay_etc_alba[6]){
										$pay_etc_alba_day = $pay_etc_alba[5] . " " . $pay_etc_alba[6];
									} else {
										$pay_etc_alba_day = "12 month";	// 무제한일때 유예 기간 1년
									}
									$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
									$add_field = ( $utility->valid_day($member_service['mb_service_alba_open']) ) ? "mb_service_alba_open" : "curdate()";
									$pay_etc_alba_count = $member_service['mb_service_alba_count'] + $pay_etc_alba[0];
									$this->_query(" update `alice_member_service` set `mb_service_alba_open` = date_add( ".$add_field.", interval ".$pay_etc_alba_day."), `mb_service_alba_count` = '".$pay_etc_alba_count."' where `mb_id` = '".$get_payment['pay_uid']."' ");
								}
								if($vals['pay_etc_alba']){
									$pay_etc_alba = explode("/",$vals['pay_etc_alba']);
									if($pay_etc_alba[5] && $pay_etc_alba[6]){
										$pay_etc_alba_day = $pay_etc_alba[5] . " " . $pay_etc_alba[6];
									} else {
										$pay_etc_alba_day = "12 month";	// 무제한일때 유예 기간 1년
									}
									$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
									$add_field = ( $utility->valid_day($member_service['mb_service_alba_open']) ) ? "mb_service_alba_open" : "curdate()";
									$pay_etc_alba_count = $member_service['mb_service_alba_count'] + $pay_etc_alba[0];
									$this->_query(" update `alice_member_service` set `mb_service_alba_open` = date_add( ".$add_field.", interval ".$pay_etc_alba_day."), `mb_service_alba_count` = '".$pay_etc_alba_count."' where `mb_id` = '".$vals['pay_uid']."' ");
								}

							} else {	 // 기간 결제
								
								if($is_package && $get_payment['pay_etc_alba']){
									$pay_etc_alba = explode("/",$get_payment['pay_etc_alba']);
									$pay_etc_alba_day = $pay_etc_alba[5] . " " . $pay_etc_alba[6];
									$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
									$add_field = ( $utility->valid_day($member_service['mb_service_alba_open']) ) ? "mb_service_alba_open" : "curdate()";
									$this->_query(" update `alice_member_service` set `mb_service_alba_open` = date_add( ".$add_field.", interval ".$pay_etc_alba_day.") where `mb_id` = '".$get_payment['pay_uid']."' ");
								}
								if($vals['pay_etc_alba']){
									$pay_etc_alba = explode("/",$vals['pay_etc_alba']);
									$pay_etc_alba_day = $pay_etc_alba[0] . " " . $pay_etc_alba[1];
									$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
									$add_field = ( $utility->valid_day($member_service['mb_service_alba_open']) ) ? "mb_service_alba_open" : "curdate()";
									$this->_query(" update `alice_member_service` set `mb_service_alba_open` = date_add( ".$add_field.", interval ".$pay_etc_alba_day.") where `mb_id` = '".$vals['pay_uid']."' ");	 // 열람 서비스 기간 부여
								}

							}
						}


						if($is_package && $get_payment['pay_etc_sms']){
							$pay_etc_sms = explode("/",$get_payment['pay_etc_sms']);
							if($pay_etc_sms[1]=='count'){	// 건별 결제
								if($pay_etc_sms[5] && $pay_etc_sms[6]){
									$pay_etc_sms_day = $pay_etc_sms[5] . " " . $pay_etc_sms[6];
								} else {
									$pay_etc_sms_day = "12 month";	// 무제한일때 유예 기간 1년
								}
								$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
								$pay_etc_sms_count = $member_service['mb_service_sms_count'] + $pay_etc_sms[0];
								$this->_query(" update `alice_member_service` set `mb_service_sms_count` = '".$pay_etc_sms_count."' where `mb_id` = '".$vals['pay_uid']."' ");	 // SMS 서비스 건수 부여
								$this->_query(" update `alice_member` set `mb_sms` = '".$pay_etc_sms_count."' where `mb_id` = '".$vals['pay_uid']."' ");	 // 회원 SMS 건수 부여
							}
						}
						if($vals['pay_etc_sms']){	// SMS 충전 서비스
							$pay_etc_sms = explode("/",$vals['pay_etc_sms']);
							if($pay_etc_sms[1]=='count'){	// 건별 결제
								if($pay_etc_sms[5] && $pay_etc_sms[6]){
									$pay_etc_sms_day = $pay_etc_sms[5] . " " . $pay_etc_sms[6];
								} else {
									$pay_etc_sms_day = "12 month";	// 무제한일때 유예 기간 1년
								}
								$member_service = $member_control->get_service_member($vals['pay_uid']);	 // 서비스 정보
								$pay_etc_sms_count = $member_service['mb_service_sms_count'] + $pay_etc_sms[0];
								$this->_query(" update `alice_member_service` set `mb_service_sms_count` = '".$pay_etc_sms_count."' where `mb_id` = '".$vals['pay_uid']."' ");	 // SMS 서비스 건수 부여
								$this->_query(" update `alice_member` set `mb_sms` = '".$pay_etc_sms_count."' where `mb_id` = '".$vals['pay_uid']."' ");	 // 회원 SMS 건수 부여
							}
						}


					return @implode($result,',');

				}


				// 결제 리스트 검색
				function _Search(){

					global $utility, $config;

						$page = $_GET['page'];
						
						$order = " `no` ";

						$sort = $_GET['sort'];	 // 정렬 기준
						
						if($sort) $order = " `".$sort."` ";
						
						$flag = $_GET['flag'];	 // 정렬 순서
						
						$order .= ($flag) ? $flag : " desc ";

						$mode = $_GET['mode'];
						if($_POST['mode']){	// 검색 방식 유효성 검사
							$utility->popup_msg_js($config->_errors('0046'));
							exit;
						}

						$search_date = $_GET['search_date'];	 // 입금완료일/결제신청일/취소신청일/취소완료

						$start_dayAll = $_GET['start_dayAll'];
						$start_day = $_GET['start_day'];
						$end_day = $_GET['end_day'];

						$pay_sdate = $_GET['pay_sdate'];
						$pay_edate = $_GET['pay_edate'];

						$pay_status = $_GET['status'];	 // 진행상태	
						$pay_method = $_GET['pay_method'];	// 결제수단

						$pay_service = $_GET['pay_service'];		// 서비스명

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = $_GET['search_keyword'];	 // 검색 키워드


						$que = array();
						$url = array();


						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드


							## pay 지정 필드별 검색 ######################################################################################
							if(!$start_dayAll){	// 전체가 아닐 경우에만

								// 두 값이 모두 다 있는 경우
								if( $start_day!='' && $end_day!='' ) {		// start_day && end_day

									array_push( $que, " ( `".$search_date."` between '".$start_day." 00:00:00' and '".$end_day." 23:59:59' ) " );
									array_push( $url, "start_day=" . urlencode($start_day) . "&end_day=" . urlencode($end_day) );

								// 두 값이 모두 다 없고 둘중 하나만 있는 경우
								} else {

									if( $start_day!='' ) {		// start_day
										array_push( $que, " `".$search_date."` >= '".$start_day."' " );
										array_push( $url, "start_day=" . urlencode($start_day) );
									}

									if( $end_day!='' ) {		// end_day
										array_push( $que, " `".$search_date."` <= '".$end_day."' " );
										array_push( $url, "end_day=" . urlencode($end_day) );	
									}

								}

							}

							if($pay_sdate && $pay_edate){	// 사용자측 검색

								$pay_sdates = $pay_sdate[0] . "-" . $pay_sdate[1] . "-" . $pay_sdate[2];
								$pay_edates = $pay_edate[0] . "-" . $pay_edate[1] . "-" . $pay_edate[2];

								if( $pay_sdates == date('Y-m-d') ){
									array_push( $que, " `pay_wdate` like '".$pay_sdates."%' " );
								} else {
									array_push( $que, " `pay_wdate` between '".$pay_sdates."' and '".$pay_edates."' " );
									//array_push( $url, "start_day=".urlencode($pay_sdates)."&end_day=".urlencode($pay_edates) );
								}

							}
							## //pay 지정 필드별 검색 #####################################################################################


							## 진행상태별 검색 #########################################################################################
							if($pay_status || $pay_status=='0'){	 // 체크값이 존재하는 경우
								if(is_array($pay_status)){	// 배열인 경우 form 에서 넘어온 값
									if(!@in_array('all',$pay_status)){	 // 전체가 아닐때만
										$status = @implode(',',$pay_status);
										array_push( $que, " `pay_status` in (".$status.") " );
										array_push( $url, "status=" . $pay_status );	
									}
								} else {	 // 배열이 아닌 경우
									array_push( $que, " `pay_status` = '".$pay_status."' " );
									array_push( $url, "status=" . $pay_status );	
								}
							}
							## //진행상태별 검색 ########################################################################################


							## 결제수단별 검색 #########################################################################################
							if($pay_method){
								switch($pay_method){
									case 'card':	// 신용카드
										$ques = " `pay_method` in ('onlycard', '100000000000') ";
									break;
									case 'online':	// 실시간 계좌이체
										// 이니시스 : onlydbank, 올더게잇 : onlyiche
										$ques = " `pay_method` in ('onlydbank', 'onlyiche', '010000000000') ";
									break;
									case 'virtual':	 // 가상계좌
										$ques .= " `pay_method` in ('onlyvbank', 'onlyvirtual', '001000000000') ";
									break;
									case 'hp':	// 핸드폰
										// 이니시스 : onlyhpp, 올더게잇 : onlyhp
										$ques = " `pay_method` in ('onlyhpp', 'onlyhp', '000010000000') ";
									break;
									case 'phone':	// 일반전화
										// 이니시스 : onlyphone, 올더게잇 : onlyars
										$ques = " `pay_method` in ('onlyphone', 'onlyars', '000000000010') ";
									break;
									case 'bank':	// 무통장 입금
										$ques = " `pay_method` = 'bank' ";
									break;
								}
								array_push( $que, $ques );
								array_push( $url, "pay_method=" . $pay_method );	
							}
							## //결제수단별 검색 ########################################################################################


							## 서비스별 검색 ##########################################################################################
							if($pay_service){
								$pay_service_cnt = count($pay_service);
								$pay_service_str = " ( ";
								for($i=0;$i<$pay_service_cnt;$i++){
									$_or = ($i != ($pay_service_cnt-1)) ? " or " : "";
									$pay_service_str .= " INSTR(`pay_service`, '".$pay_service[$i]."' ) " . $_or;
								}
								$pay_service_str .= " ) ";
								array_push( $que, $pay_service_str );
							}
							//array_push( $url, "pay_service=" . $pay_service );	
							## //서비스별 검색 #########################################################################################

							## 필드선택에 따른 검색 ######################################################################################
							if($search_keyword){

								if(!$search_field){	// 통합검색 일때

									if(preg_match("/[a-zA-Z]/", $search_keyword)) {
										$search_que  = " ( ";
										$search_que .= " INSTR(LOWER(`pay_uid`), LOWER('".$search_keyword."'))";	// 회원아이디
										$search_que .= " or INSTR(LOWER(`pay_name`), LOWER('".$search_keyword."'))";	// 이름
										$search_que .= " or INSTR(LOWER(`pay_bank_name`), LOWER('".$search_keyword."'))";	// 입금자명
										$search_que .= " or INSTR(LOWER(`pay_email`), LOWER('".$search_keyword."'))";	// 이메일
										$search_que .= " ) ";
									} else {
										$search_que  = " ( ";
										$search_que .= " INSTR(`pay_uid`, '".$search_keyword."')";
										$search_que .= " or INSTR(`pay_name`, '".$search_keyword."')";
										$search_que .= " or INSTR(`pay_bank_name`, '".$search_keyword."')";
										$search_que .= " or INSTR(`pay_email`, '".$search_keyword."')";
										$search_que .= " ) ";
									}

									array_push($url, "search_field=&search_keyword=" . $search_keyword);

								} else {	 // 필드 선택

									$tmp = array();
									$tmp = explode(",", trim($search_field));
									$field = explode("||", $tmp[0]);	// 제목+내용 검색 때문에 || 를 기준으로 자른다
									$not_comment = $tmp[1];
									$field_cnt = count($field);

									$search_que = "";

									for ($i=0; $i<$field_cnt; $i++) { // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)

										// SQL Injection 방지
										// 필드값에 a-z A-Z 0-9 _ , | 이외의 값이 있다면 검색필드를 wr_subject 로 설정한다.
										$field[$i] = preg_match("/^[\w\,\|]+$/", $field[$i]) ? $field[$i] : "wr_subject";
										
										if (preg_match("/[a-zA-Z]/", $search_keyword)){
											$search_que .= "INSTR(LOWER(`".$field[$i]."`), LOWER('".$search_keyword."'))";
										} else {
											$_and = ($i>0)?" or ":"";
											$search_que .= $_and . " INSTR(`".$field[$i]."`, '".$search_keyword."') ";
										}

									}

									array_push($url, "search_field=" . urlencode($search_field) . "&search_keyword=" . urlencode($search_keyword));
								}

								array_push($que, $search_que);

							}
							## //필드선택에 따른 검색 #####################################################################################

						}


						array_push($url, 'page='.$page);
						array_push($url, 'page_rows='.$page_rows);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}

				// 상태별 카운팅
				function status_count( $status ){

						$query = " select * from `".$this->payment_table."` where `pay_status` = '".$status."' and `pay_pg` != 'admin' and `pay_method` != 'service' and `pay_package` = 0 and `is_delete` = 0 ";
						
						$result = $this->_queryR($query);


					return $result;

				}

				// 필드별 정보 추출
				function get_service_field( $no, $field ){

						$query = $this->query_fetch(" select ".$field." from `".$this->payment_table."` where `no` = '".$no."' ");

						$result = $query[$field];

					
					return $result;

				}


				// pg사별 결제수단 추출
				function pg_payMethod( $method ){

						if(!$method) return false;

						$result = array();

						switch($method){
							case 'card':
							case 'onlycard': 
							case '100000000000':
								$result['name'] = "신용카드"; 
								$result['method'] = "card"; 
								$result['color'] = "grf_dbl lnb_dbl"; 
							break;
							case 'direct':
							case 'onlydbank': 
							case 'onlyiche': 
							case '010000000000':
								$result['name'] = "계좌이체"; 
								$result['method'] = "online"; 
								$result['color'] = "grf_pp lnb_pp"; 
							break;
							case 'onlyvbank':
							case 'onlyvirtual':
							case '001000000000':
								$result['name'] = "가상계좌"; 
								$result['method'] = "virtual"; 
								$result['color'] = "grf_pp lnb_pp"; 
							break;
							case 'hphone':
							case 'onlyhpp':
							case 'onlyhp': 
							case '000010000000':
								$result['name'] = "핸드폰"; 
								$result['method'] = "hp"; 
								$result['color'] = "grf_wbl lnb_wbl"; 
							break;
							case 'phone':
							case 'onlyphone':
							case 'onlyars': 
							case '000000000010':
								$result['name'] = "일반전화"; 
								$result['method'] = "phone"; 
								$result['color'] = "grf_red lnb_red"; 
							break;
							case 'admin':
								$result['name'] = "관리자"; 
								$result['method'] = "admin"; 
								$result['color'] = "grf_org lnb_org"; 
							break;
							case 'free':
								$result['name'] = "무료"; 
								$result['method'] = "freee"; 
								$result['color'] = "grf_grn lnb_grn"; 
							break;
							default :
								$result['name'] = "무통장입금"; 
								$result['method'] = "bank"; 
								$result['color'] = "grf_pk lnb_pk"; 
							break;
						}


					return $result;

				}


				/**
				* 로고 업로드시 확장자 구분
				*/
				function _logo(){

						$result = implode('|',$this->logo_extension);

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