<?php
		/**
		* /application/nad/payment/controller/alice_payment_control.class.php
		* @author Harimao
		* @since 2013/07/23
		* @last update 2015/06/04
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Control class
		* @Comment :: 결제모듈 컨트롤 클래스
		*/
		class alice_payment_control extends alice_payment_model {


				/**
				* 결제 페이지 사용 정보 수정
				*/
				function update_payment_page( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->pg_page_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 결제 모듈 사용 정보 수정
				* pg_company 기준
				*/
				function update_pg_page( $vals, $pg_company ){

					global $utility;

						$get_pgInfoCompany = $this->get_pgInfoCompany($pg_company);
						
						$val = $utility->QueryString($vals);

						$this->_query(" update `".$this->pg_config_table."` set `pg_result` = 0 ");	// 전체 pg_result 끄기

						if($get_pgInfoCompany){	// 기존 데이터가 있다면 update

							$query = " update `".$this->pg_config_table."` set " . $val . " where `pg_company` = '".$pg_company."' ";

						} else {	 // 없다면 insert
							
							$query = " insert into `".$this->pg_config_table."` set " . $val;

						}

						$result = $this->_query($query);


					return $result;

				}
				

				/**
				* 결제 정보 데이터 입력
				*/
				function insert_payment( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->payment_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 결제 정보 데이터 수정 :: no 기준
				*/
				function update_payment( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->payment_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 결제 정보 데이터 수정 :: oid 기준
				*/
				function update_payment_for_oid( $vals, $oid, $con="" ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->payment_table."` set " . $val . " where `pay_oid` = '".$oid."' " . $con;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 결제 정보 데이터 삭제 (실제 데이터는 삭제 안됨 => is_delete)
				*/
				function delete_payment( $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->payment_table."` set `is_delete` = '1' where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 결제 완료시
				* 서비스 기간 업데이트 / 결제 완료 처리
				* 주문번호 기준
				*/
				function success_payment( $oid ){

					global $alice, $utility, $env;
					global $member_control, $alba_control, $alba_resume_control, $point_control;

						$get_package = $this->get_payment_for_oid($oid," and `pay_package` != '0' ");

						if($get_package['pay_package']){
							$get_payment = $this->get_payment($get_package['no']);	 // 결제정보
						} else {
							$get_payment = $this->get_payment_for_oid($oid);	 // 결제정보
						}

						$get_member = $member_control->get_member($get_payment['pay_uid']);	// 회원 정보

						$pay_no = $get_payment['pay_no'];	// 서비스 데이터 번호


						if($get_payment['pay_type']=='alba'){	 // 알바 추출

							$get_service_alba = $this->get_service_alba_date($get_payment);	// 알바 서비스 기간 정보
                            $get_service_alba_val = $get_service_alba ? $get_service_alba."," : "";

							$get_alba = $alba_control->get_alba($pay_no);

							$pay_service = explode("/",$get_payment['pay_service']);


							if( in_array('etc_open',$pay_service) || in_array('etc_sms',$pay_service) ){
								$pay_service_cnt = count($pay_service);
								for($i=0;$i<$pay_service_cnt;$i++){
									if( $pay_service[$i] == 'etc_open' || $pay_service[$i] == 'etc_sms') unset($pay_service[$i]);
								}
							}

							if( $get_payment['pay_service'] != 'etc_open' && $get_payment['pay_service'] != 'etc_sms' ){
								// 서비스 기간 업데이트
								$alba_update_query = " update `alice_alba` set " . $get_service_alba_val . " `wr_oid` = '".$oid."', `wr_udate` = now() where `no` = '".$pay_no."' ";
								$this->_query($alba_update_query);
							}

							// 사용한 포인트가 있다면 차감
							$use_point = $get_payment['pay_dc'];
							if($use_point){

								//$point = $get_member['mb_point'] - $use_point;
								$content = $alice['time_ymd'] . " 채용공고 [".stripslashes($get_alba['wr_subject'])."] 등록시 사용";
								$point_control->point_insert($get_member['mb_id'], "-".$use_point, $content, "alba", $pay_no, $alice['time_ymdhis']." 등록");

							} else {	 // 사용한 포인트가 없는 경우 관리자에서 설정한 유료결제 포인트를 지급한다.

								if($env['alba_point_percent']){	// 지급 % 가 설정되어 있다면
									$pay_price = $get_payment['pay_price'];	 // 결제 금액
									$pay_point = ($pay_price / 100 ) * $env['alba_point_percent'];
									$content = $alice['time_ymd'] . " 채용공고 [".stripslashes($get_alba['wr_subject'])."] 등록시 적립";
									$point_control->point_insert($get_member['mb_id'], $pay_point, $content, "alba", $pay_no, $alice['time_ymdhis']." 등록");
								}

							}

						} else if($get_payment['pay_type']=='alba_resume'){	// 알바 이력서 추출

							$get_service_resume = $this->get_service_alba_resume_date($get_payment);	// 알바 이력서 서비스 기간 정보
							$get_service_resume_val = $get_service_resume ? $get_service_resume."," : "";

							$get_alba_resume = $alba_resume_control->get_resume($pay_no);

							if( @in_array('etc_alba',$pay_service) || @in_array('etc_sms',$pay_service) ){
								$pay_service_cnt = count($pay_service);
								for($i=0;$i<$pay_service_cnt;$i++){
									if( $pay_service[$i] == 'etc_alba' || $pay_service[$i] == 'etc_sms') unset($pay_service[$i]);
								}
							}

							// 서비스 기간 업데이트
							$alba_resume_update_query = " update `alice_alba_resume` set " . $get_service_resume_val . " `wr_oid` = '".$oid."', `wr_udate` = now() where `no` = '".$pay_no."' ";
							$this->_query($alba_resume_update_query);

							$get_alba_resume = $alba_resume_control->get_resume($pay_no);


							// 사용한 포인트가 있다면 차감
							$use_point = $get_payment['pay_dc'];
							if($use_point){

								$content = $alice['time_ymd'] . " 이력서 [".stripslashes($get_alba_resume['wr_subject'])."] 등록시 사용";
								$point_control->point_insert($get_member['mb_id'], "-".$use_point, $content, "alba_resume", $pay_no, $alice['time_ymdhis']." 등록");

							} else {	 // 사용한 포인트가 없는 경우 관리자에서 설정한 유료결제 포인트를 지급한다.

								if($env['alba_resume_point_percent']){	// 지급 % 가 설정되어 있다면
									$pay_price = $get_payment['pay_price'];	 // 결제 금액
									$pay_point = ($pay_price / 100 ) * $env['alba_resume_point_percent'];
									$content = $alice['time_ymd'] . " 이력서 [".stripslashes($get_alba_resume['wr_subject'])."] 등록시 적립";
									$point_control->point_insert($get_member['mb_id'], $pay_point, $content, "alba_resume", $pay_no, $alice['time_ymdhis']." 등록");
								}

							}

						} else if($get_payment['pay_type']=='resume_open' || $get_payment['pay_type']=='etc_open' || $get_payment['pay_service']=='etc_open'){	// 이력서 열람권 결제

							/*
							30/count/30000/15/25500/5/day
							0 => 30
							1 => count
							2 => 30000
							3 => 15
							4 => 25500

							5 => 5
							6 => day
							*/
							$pay_etc_open = explode("/",$get_payment['pay_etc_open']);
							
							if($pay_etc_open[1]=='count'){	// 건별 결제
								if($pay_etc_open[5] && $pay_etc_open[6]){
									$pay_etc_open_day = $pay_etc_open[5] . " " . $pay_etc_open[6];
								} else {
									$pay_etc_open_day = "12 month";	// 무제한일때 유예 기간 1년
								}
								$member_service = $member_control->get_service_member($get_payment['pay_uid']);	 // 서비스 정보
								$pay_etc_open_count = $member_service['mb_service_open_count'] + $pay_etc_open[0];
								$this->_query(" update `alice_member_service` set `mb_service_open` = date_add( `mb_service_open`, interval ".$pay_etc_open_day."), `mb_service_open_count` = '".$pay_etc_open_count."' where `mb_id` = '".$get_payment['pay_uid']."' ");	 // 열람 서비스 기간 부여
							} else {	 // 기간 결제
								$pay_etc_open_day = $pay_etc_open[0] . " " . $pay_etc_open[1];
								$this->_query(" update `alice_member_service` set `mb_service_open` = date_add( `mb_service_open`, interval ".$pay_etc_open_day."), `mb_service_open_count` = '0' where `mb_id` = '".$get_payment['pay_uid']."' ");	 // 열람 서비스 기간 부여
							}

							// 사용한 포인트가 있다면 차감
							$use_point = $get_payment['pay_dc'];
							if($use_point){

								//$point = $get_member['mb_point'] - $use_point;
								$content = $alice['time_ymd'] . " 이력서 열람권 사용";
								$point_control->point_insert($get_member['mb_id'], "-".$use_point, $content, "alba", $pay_no, $alice['time_ymdhis']." 등록");

							} 

						} else if($get_payment['pay_type']=='etc_alba'){	// 채용공고 열람권 결제

							$pay_etc_alba = explode("/",$get_payment['pay_etc_alba']);

							if($pay_etc_alba[1]=='count'){	// 건별 결제
								if($pay_etc_alba[5] && $pay_etc_alba[6]){
									$pay_etc_alba_day = $pay_etc_alba[5] . " " . $pay_etc_alba[6];
								} else {
									$pay_etc_alba_day = "12 month";	// 무제한일때 유예 기간 1년
								}
								$member_service = $member_control->get_service_member($get_payment['pay_uid']);	 // 서비스 정보
								$pay_etc_alba_count = $member_service['mb_service_alba_count'] + $pay_etc_alba[0];
								$this->_query(" update `alice_member_service` set `mb_service_alba_open` = date_add( `mb_service_alba_open`, interval ".$pay_etc_alba_day."), `mb_service_alba_count` = '".$pay_etc_alba_count."' where `mb_id` = '".$get_payment['pay_uid']."' ");	 // 열람 서비스 기간 부여
							} else {	 // 기간 결제
								$pay_etc_alba_day = $pay_etc_alba[0] . " " . $pay_etc_alba[1];
								$this->_query(" update `alice_member_service` set `mb_service_alba_open` = date_add( `mb_service_alba_open`, interval ".$pay_etc_alba_day."), `mb_service_alba_count` = '0' where `mb_id` = '".$get_payment['pay_uid']."' ");	 // 열람 서비스 기간 부여
							}

							// 사용한 포인트가 있다면 차감
							$use_point = $get_payment['pay_dc'];
							if($use_point){

								//$point = $get_member['mb_point'] - $use_point;
								$content = $alice['time_ymd'] . " 채용공고 열람권 사용";
								$point_control->point_insert($get_member['mb_id'], "-".$use_point, $content, "alba", $pay_no, $alice['time_ymdhis']." 등록");

							} 

						} else if($get_payment['pay_type']=='etc_sms'){	// SMS 건수 충전

							$pay_etc_sms = explode("/",$get_payment['pay_etc_sms']);

							$member_service = $member_control->get_service_member($get_payment['pay_uid']);	 // 서비스 정보
							$pay_etc_sms_count = $member_service['mb_service_sms_count'] + $pay_etc_sms[0];

							$mb_vals['mb_sms'] = $pay_etc_sms_count;
							$mb_vals['mb_udate'] = $alice['time_ymdhis'];
							$member_control->update_member($mb_vals,$get_payment['pay_uid']);	// 회원 테이블 mb_sms 카운트 조절

							$mb_service_vals['mb_service_sms_count'] = $pay_etc_sms_count;
							$member_control->service_upate($mb_service_vals,$get_payment['pay_uid']);	// 회원 서비스 테이블 sms 카운트 조절

							// 사용한 포인트가 있다면 차감
							$use_point = $get_payment['pay_dc'];
							if($use_point){

								//$point = $get_member['mb_point'] - $use_point;
								$content = $alice['time_ymd'] . " 문자충전";
								$point_control->point_insert($get_member['mb_id'], "-".$use_point, $content, "alba", $pay_no, $alice['time_ymdhis']." 등록");

							} 

						}

						// 결제 정보 업데이트
						$pay_update_query = " update `".$this->payment_table."` set `pay_status` = 1, `pay_sdate` = now() where `pay_oid` = '".$oid."' ";	// oid 를 기준으로 수정
						$result = $this->_query($pay_update_query);


					return $result;

				}


				// 결제 정보 리스팅시 데이터 정렬
				function payment_listing( $no ){

					global $alice, $utility;
					global $service_control, $netfu_util;

					$get_payment = $this->get_payment($no);	// 결제 정보
					$pg_un = unserialize($get_payment['post_un']);
					$price_un = unserialize($get_payment['price_un']);

					$result_txt = array();
					if(is_array($pg_un['service'])) { foreach($pg_un['service'] as $k=>$v) {
						if(!$v) continue;
						$_v_arr = explode("/", $v);
						switch($_v_arr[0]) {
							case "package":
								$_price_arr = $price_un['package'][$_v_arr[1]];
								$result_txt[] = '<b>'.$_price_arr['wr_subject'].' : '.number_format($_price_arr['wr_price']).'원</b> (패키지상품)';
								$result_txt2[] = '<div class="service_name">'.$_price_arr['wr_subject'].'<span></span></div>';
								break;

							default:
								$_price_arr = $price_un['service'][$_v_arr[1]];
								$service_cnt = $_price_arr['service_cnt']>0 ? $_price_arr['service_cnt'] : $_price_arr['etc_3'].'건';
								if($service_cnt<=0) {
									continue;
								}
								$_type = substr($_price_arr['type'],strlen($_v_arr[0])+1);
								//$_type_key = $_type ? $_type : 
								$_type2 = '';
								// : 골드
								if(strpos($_price_arr['type'], '_gold')!==false) $_type2 = ' Gold';
								if(strpos($_price_arr['type'], '_logo')!==false) $_type2 = ' 로고강조';
								$_service_txt = $service_control->service_lists[$_v_arr[0]][$_type]['name'];
								$_price = $_price_arr['service_price']>0 ? number_format($_price_arr['service_price']).'원' : '무료';
								if($_type2) $_service_txt .= $_type2;
								$_day_eng = $service_cnt.' '.$_price_arr['service_unit'];
								$_day = $service_cnt.$netfu_util->day_arr[$_price_arr['service_unit']];
								$result_txt[] = $_service_txt.' : '.$_day.' ('.$_price.')';
								$result_txt2[] = '<div class="service_name">'.$_service_txt.'<span>'.$_price_arr['wr_subject'].'~'.date("Y-m-d", strtotime($_price_arr['wr_subject'].' '.$_day_eng)).'</span></div>';
								break;
						}
					} }
					return array('admin'=>$result_txt, 'user'=>$result_txt2);
				}


				// 결제 정보 리스팅시 데이터 쪼개기
				function payment_list( $no ){

					global $alice, $utility;
					global $service_control, $alba_control, $alba_resume_control;

						$result = array();

						$payment = $this->get_payment($no);	// 결제 정보

						$get_package = $this->get_payment_for_oid($payment['pay_oid']," and `pay_package` != '0' ");

						if($get_package['pay_package']){
							$get_payment = $this->get_payment($get_package['no']);	 // 결제정보
						} else {
							$get_payment = $this->get_payment_for_oid($payment['pay_oid']);	 // 결제정보
						}

						/*
						echo "<pre>";
						//print_R($payment);
						print_R($get_payment);
						echo "</pre>";
						*/


						if($get_payment['pay_type']=='alba'){
							$get_alba = $alba_control->get_alba($get_payment['pay_no']);		// 채용정보
						} else if($get_payment['pay_type']=='alba_resume'){
							$get_resume = $alba_resume_control->get_resume($get_payment['pay_no']);	// 이력서 정보
						}


						$pay_service = explode('/',$get_payment['pay_service']);
						$pay_service_cnt = count($pay_service);

						for($i=0;$i<$pay_service_cnt;$i++){

							if($pay_service[$i]=='alba_resume_basic'){
								$field_name = "pay_resume_basic";
							} else {
								if($pay_service[$i] && is_field_check("pay_" . $pay_service[$i], 'alice_payment')){
									$field_name = "pay_" . $pay_service[$i];
								} else {
									$field_name = "*";
								}
							}

							$service_field = explode('_',$pay_service[$i]);	 // 결제 서비스 항목별 필드
							/*
							if($get_payment['pay_type']=='alba'){
								$service_info = $this->get_service_field($payment['no'],$field_name);
							} else if($get_payment['pay_type']=='alba_resume'){
								$service_info = $this->get_service_field($payment['no'],$field_name);
							}
							*/
							$service_info = $this->get_service_field($payment['no'],$field_name);

							$service_day = explode('/',$service_info);	// 결제 서비스 기간 / 금액

							if($service_day[0]) {

								if(count($service_field) > 2 ){	// 결제 서비스명
									
									$service_name = $service_control->service_name[ $service_field[0] . "_" . $service_field[1] ]['name'];
									if($service_field[3]){
										$service_name .= " " . $service_control->service_name[ $service_field[0] . "_" . $service_field[1] ]['service'][ $service_field[2] . "_" . $service_field[3] ];
										$service_code = $service_field[0] . "_" . $service_field[1]. "_" . $service_field[2]. "_" . $service_field[3];
									} else {
										$service_name .= " " . $service_control->service_name[ $service_field[0] . "_" . $service_field[1] ]['service'][ $service_field[2] ];
										$service_code = $service_field[0] . "_" . $service_field[1]. "_" . $service_field[2];
									}

								} else {

									$service_name  = $service_control->service_name[ $service_field[0] ]['name'];
									$service_name .= " " . $service_control->service_name[ $service_field[0] ]['service'][ $service_field[1] ];
									$service_code = $service_field[0] . "_" . $service_field[1];
								}

								## 채용공고 서비스 기간 / 건수
								if($get_payment['pay_type']=='alba'){

									if( $get_alba['wr_service_platinum'] != '0000-00-00' ){
										$result[$i]['service_day']['main_platinum'] = $get_alba['wr_service_platinum'];
									}
									if( $get_alba['wr_service_platinum_main_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['main_platinum_gold'] = $get_alba['wr_service_platinum_main_gold'];
									}
									if( $get_alba['wr_service_platinum_main_logo'] != '0000-00-00' ){
										$result[$i]['service_day']['main_platinum_logo'] = $get_alba['wr_service_platinum_main_logo'];
									}

									if( $get_alba['wr_service_platinum_sub'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_platinum'] = $get_alba['wr_service_platinum_sub'];
									}
									if( $get_alba['wr_service_platinum_sub_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_platinum_gold'] = $get_alba['wr_service_platinum_sub_gold'];
									}
									if( $get_alba['wr_service_platinum_sub_logo'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_platinum_logo'] = $get_alba['wr_service_platinum_sub_logo'];
									}

									if( $get_alba['wr_service_prime'] != '0000-00-00' ){
										$result[$i]['service_day']['main_prime'] = $get_alba['wr_service_prime'];
									}
									if( $get_alba['wr_service_prime_main_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['main_prime_gold'] = $get_alba['wr_service_prime_main_gold'];
									}
									if( $get_alba['wr_service_prime_main_logo'] != '0000-00-00' ){
										$result[$i]['service_day']['main_prime_logo'] = $get_alba['wr_service_prime_main_logo'];
									}

									if( $get_alba['wr_service_grand'] != '0000-00-00' ){
										$result[$i]['service_day']['main_grand'] = $get_alba['wr_service_grand'];
									}
									if( $get_alba['wr_service_grand_main_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['main_grand_gold'] = $get_alba['wr_service_grand_main_gold'];
									}
									if( $get_alba['wr_service_grand_main_logo'] != '0000-00-00' ){
										$result[$i]['service_day']['main_grand_logo'] = $get_alba['wr_service_grand_main_logo'];
									}

									if( $get_alba['wr_service_banner'] != '0000-00-00' ){
										$result[$i]['service_day']['main_banner'] = $get_alba['wr_service_banner'];
									}
									if( $get_alba['wr_service_banner_main_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['main_banner_gold'] = $get_alba['wr_service_banner_main_gold'];
									}

									if( $get_alba['wr_service_banner_sub'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_banner'] = $get_alba['wr_service_banner_sub'];
									}
									if( $get_alba['wr_service_banner_sub_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_banner_gold'] = $get_alba['wr_service_banner_sub_gold'];
									}

									if( $get_alba['wr_service_list'] != '0000-00-00' ){
										$result[$i]['service_day']['main_list'] = $get_alba['wr_service_list'];
									}
									if( $get_alba['wr_service_list_main_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['main_list_gold'] = $get_alba['wr_service_list_main_gold'];
									}

									if( $get_alba['wr_service_list_sub'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_list'] = $get_alba['wr_service_list_sub'];
									}
									if( $get_alba['wr_service_list_sub_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_list_gold'] = $get_alba['wr_service_list_sub_gold'];
									}

									if( $get_alba['wr_service_basic'] != '0000-00-00' ){
										$result[$i]['service_day']['main_basic'] = $get_alba['wr_service_basic'];
									}
									if( $get_alba['wr_service_basic_sub'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_basic'] = $get_alba['wr_service_basic_sub'];
									}

									if( $get_alba['wr_service_busy'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_option_busy'] = $get_alba['wr_service_busy'];
									}
									if( $get_alba['wr_service_neon'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_option_neon'] = $get_alba['wr_service_neon'];
									}
									if( $get_alba['wr_service_bold'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_option_bold'] = $get_alba['wr_service_bold'];
									}
									if( $get_alba['wr_service_color'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_option_color'] = $get_alba['wr_service_color'];
									}
									if( $get_alba['wr_service_icon'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_option_icon'] = $get_alba['wr_service_icon'];
									}
									if( $get_alba['wr_service_blink'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_option_blink'] = $get_alba['wr_service_blink'];
									}
									if( $get_alba['wr_service_jump'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_option_jump'] = $get_alba['wr_service_jump'];
									}

									if($get_payment['pay_etc_open']){	// 이력서 열람권
										$pay_etc_open = explode("/",$get_payment['pay_etc_open']);
										$etc_open = explode("/",$payment['pay_etc_open']);

										if($pay_etc_open[1]=='count'){	// 건수
											$result[$i]['service_day']['etc_open'] = "count/".number_format($pay_etc_open[0]);
										} else {	 // 기간
											$pay_etc_open_date = date('Y-m-d', strtotime('+'.$pay_etc_open[0].' '.$pay_etc_open[1]) );
											if($etc_open){
												sscanf($pay_etc_open_date,'%4d-%2d-%2d',$y,$m,$d); 
												switch($etc_open[1]){
													case 'day':
														$pay_etc_open_date = date('Y-m-d',mktime(0,0,0,$m,$d+$etc_open[0],$y));
													break;
													case 'month':
														$pay_etc_open_date = date('Y-m-d',mktime(0,0,0,$m+$etc_open[0],$d,$y));
													break;
													case 'year':
														$pay_etc_open_date = date('Y-m-d',mktime(0,0,0,$m,$d,$y+$etc_open[0]));
													break;
												}
											}

											$result[$i]['service_day']['etc_open'] = "date/".$pay_etc_open_date;
										}
									}

									if($get_payment['pay_etc_sms']){	// SMS 건수
										$pay_etc_sms = explode("/",$get_payment['pay_etc_sms']);
										$etc_sms = explode("/",$payment['pay_etc_sms']);
										if($pay_etc_sms[1]=='count'){	// 건수
											$result[$i]['service_day']['etc_sms'] = "count/".number_format($pay_etc_sms[0]+$etc_sms[0]) . "건";
											$service_type = "count";
										} else {	 // 기간
											$result[$i]['service_day']['etc_sms'] = "date/".date('Y-m-d', strtotime('+'.$pay_etc_sms[0].' '.$pay_etc_sms[1]) );
											$service_type = "date";
										}
									}

								## 이력서 서비스 기간 / 건수
								} else if($get_payment['pay_type']=='alba_resume'){

									if( $get_resume['wr_service_main_focus'] != '0000-00-00' ){
										$result[$i]['service_day']['main_focus'] = $get_resume['wr_service_main_focus'];
									}
									if( $get_resume['wr_service_main_focus_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['main_focus_gold'] = $get_resume['wr_service_main_focus_gold'];
									}

									if( $get_resume['wr_service_sub_focus'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_resume_focus'] = $get_resume['wr_service_sub_focus'];
									}
									if( $get_resume['wr_service_sub_focus_gold'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_resume_focus_gold'] = $get_resume['wr_service_sub_focus_gold'];
									}

									if( $get_resume['wr_service_basic'] != '0000-00-00' ){
										$result[$i]['service_day']['main_resume_basic'] = $get_resume['wr_service_basic'];
									}
									if( $get_resume['wr_service_basic_sub'] != '0000-00-00' ){
										$result[$i]['service_day']['alba_resume_basic'] = $get_resume['wr_service_basic_sub'];
									}


									if( $get_resume['wr_service_busy'] != '0000-00-00' ){
										$result[$i]['service_day']['resume_option_busy'] = $get_resume['wr_service_busy'];
									}
									if( $get_resume['wr_service_neon'] != '0000-00-00' ){
										$result[$i]['service_day']['resume_option_neon'] = $get_resume['wr_service_neon'];
									}
									if( $get_resume['wr_service_bold'] != '0000-00-00' ){
										$result[$i]['service_day']['resume_option_bold'] = $get_resume['wr_service_bold'];
									}
									if( $get_resume['wr_service_color'] != '0000-00-00' ){
										$result[$i]['service_day']['resume_option_color'] = $get_resume['wr_service_color'];
									}
									if( $get_resume['wr_service_icon'] != '0000-00-00' ){
										$result[$i]['service_day']['resume_option_icon'] = $get_resume['wr_service_icon'];
									}
									if( $get_resume['wr_service_blink'] != '0000-00-00' ){
										$result[$i]['service_day']['resume_option_blink'] = $get_resume['wr_service_blink'];
									}
									if( $get_resume['wr_service_jump'] != '0000-00-00' ){
										$result[$i]['service_day']['resume_option_jump'] = $get_resume['wr_service_jump'];
									}

									if($get_payment['pay_etc_alba']){	// 채용정보 열람권
										$pay_etc_alba = explode("/",$get_payment['pay_etc_alba']);
										$etc_alba = explode("/",$payment['pay_etc_alba']);

										if($pay_etc_alba[1]=='count'){	// 건수
											$result[$i]['service_day']['etc_alba'] = "count/".number_format($pay_etc_alba[0]);
										} else {	 // 기간
											$pay_etc_alba_date = date('Y-m-d', strtotime('+'.$pay_etc_alba[0].' '.$pay_etc_alba[1]) );
											if($etc_alba){
												sscanf($pay_etc_alba_date,'%4d-%2d-%2d',$y,$m,$d); 
												switch($etc_alba[1]){
													case 'day':
														$pay_etc_alba_date = date('Y-m-d',mktime(0,0,0,$m,$d+$etc_alba[0],$y));
													break;
													case 'month':
														$pay_etc_alba_date = date('Y-m-d',mktime(0,0,0,$m+$etc_alba[0],$d,$y));
													break;
													case 'year':
														$pay_etc_alba_date = date('Y-m-d',mktime(0,0,0,$m,$d,$y+$etc_alba[0]));
													break;
												}
											}
											$result[$i]['service_day']['etc_alba'] = "date/".$pay_etc_alba_date;
										}
									}

									if($get_payment['pay_etc_sms']){	// SMS 건수
										$pay_etc_sms = explode("/",$get_payment['pay_etc_sms']);
										$etc_sms = explode("/",$payment['pay_etc_sms']);
										if($pay_etc_sms[1]=='count'){	// 건수
											$result[$i]['service_day']['etc_sms'] = "count/".number_format($pay_etc_sms[0]+$etc_sms[0]) . "건";
											$service_type = "count";
										} else {	 // 기간
											$result[$i]['service_day']['etc_sms'] = "date/".date('Y-m-d', strtotime('+'.$pay_etc_sms[0].' '.$pay_etc_sms[1]) );
											$service_type = "date";
										}
									}

								}

							} else {

								continue;

							}

							$result[$i]['service_name'] = $service_name;
							$result[$i]['service_code'] = $service_code;

						}

					
					return $result;

				}


				// : 건, 날짜 디비저장시 붙여질 값.
				function service_val($part, $field, $val, $info_row) {
					if($_POST['status']!=1) $_part = '-'; // : 관리자에서 결제완료->나머지 변경할경우 서비스값 차감하기
					switch($part) {
						case 'count':
							$_count = @array_sum($val);
							if($info_row[$field]>0) $_result = $_part=='-' ? $info_row[$field]-$_count : $info_row[$field]+$_count;
							else $_result = $_count;
							break;

						default:
							$_date = @implode(" ", $val);
							if($info_row[$field]>date("Y-m-d")) $_result = date("Y-m-d", strtotime($info_row[$field].' '.$_part.$_date));
							else $_result = date("Y-m-d", strtotime($_date));

							// : 뺄때 오늘과 같은 날인경우에는 0000-00-00로 변경 - 관리자 진행상태 변경할경우 결제완료->나머지 선택한경우에만 실행함.
							if(strpos($_SERVER['HTTP_REFERER'], 'nad/payment/')!==false && $_result==date("Y-m-d") && $_POST['status']!=1) $_result = '0000-00-00';
							break;
					}
					return $_result;
				}


				function get_service_field_val($price_row, $mem_se_row, $info_row) {
					$_type_arr = explode("_", $price_row['type']);

					$sevrice_key = 'info';
					if(strpos($price_row['type'], 'alba_option')!==false) $sevrice_key = 'alba_option';
					if(strpos($price_row['type'], 'resume_option')!==false) $sevrice_key = 'resume_option';
					if(strpos($price_row['type'], 'etc')!==false) $sevrice_key = 'etc';

					$_count = $price_row['service_cnt']>0 ? $price_row['service_cnt'] : $price_row['etc_3'];
					$_arr_v = $price_row['service_unit']=='count' ? $_count : $price_row['service_cnt'].' '.$price_row['service_unit'];

					switch($sevrice_key) {
						// : 옵션, 점프
						case "alba_option":
						case "resume_option":
							if($price_row['type']=='resume_option_jump') $_field = $price_row['service_unit']=='count' ? 'mb_resume_jump_count' : 'mb_resume_jump';
							else if($price_row['type']=='alba_option_jump') $_field = $price_row['service_unit']=='count' ? 'mb_alba_jump_count' : 'mb_alba_jump';
							else $_field = 'wr_service_'.preg_replace("/".$sevrice_key."_/", "", $price_row['type']);

							if(in_array($price_row['type'], array('resume_option_jump', 'alba_option_jump'))) {
								$_arr_k = 'mem_se';
							} else {
								$_arr_k = 'info';
							}
							break;

						// : 기타
						case "etc":
							if($price_row['type']=='etc_sms') $_field = 'mb_service_sms_count';
							else if($price_row['type']=='etc_alba') $_field = $price_row['service_unit']=='count' ? 'mb_service_alba_count' : 'mb_service_alba_open';
							else if($price_row['type']=='etc_open') $_field = $price_row['service_unit']=='count' ? 'mb_service_open_count' : 'mb_service_open';
							$_arr_k = 'mem_se';
							break;

						// : 채용, 인재
						default:
							$_field_code = 'basic';
							$member_row = sql_fetch("select * from alice_member where `mb_id`='".$mem_se_row['mb_id']."'");
							if(strpos($price_row['type'], 'gold')!==false) $_field_code = 'gold';
							if(strpos($price_row['type'], 'logo')!==false) $_field_code = 'logo';
							$_member_code = $member_row['mb_type']=='individual' ? 'resume' : 'alba';

							switch($_member_code) {
								case "resume":
									$_type_arr2 = explode('alba_resume_', $price_row['type']);
									$_type_pay = $price_row['pay_type']=='package' ? $_type_arr2[0] : $_type_arr2[1];

									// : 포커스의 값이 패키지냐, 포커스선택후결제냐에 따라서 값이 다름.
									if(in_array($_type_pay, array('main_focus', 'focus'))) $_field = 'wr_service_main_focus';
									else $_field = 'wr_service_basic';

									if($_field_code=='gold') $_field = 'wr_service_main_focus_gold';
									$_arr_k = 'info';
									break;

								default:
									$_field = 'wr_service_'.$_type_arr[1];
									if(strpos($price_row['type'], 'main')===false) $_field = 'wr_service_'.$_type_arr[1].'_sub';
									if($_field_code=='gold' && strpos($price_row['type'], 'main')!==false) $_field = 'wr_service_'.$_type_arr[1].'_main_gold';
									if($_field_code=='logo' && strpos($price_row['type'], 'main')!==false) $_field = 'wr_service_'.$_type_arr[1].'_main_logo';
									if($_field_code=='gold' && strpos($price_row['type'], 'main')===false) $_field = 'wr_service_'.$_type_arr[1].'_sub_gold';
									if($_field_code=='logo' && strpos($price_row['type'], 'main')===false) $_field = 'wr_service_'.$_type_arr[1].'_sub_logo';
									$_arr_k = 'info';
									break;
							}
							break;
					}
					$_arr_f = $_field;

					$_result = array('k'=>$_arr_k, 'v'=>$_arr_v, 'f'=>$_arr_f);
					return $_result;
				}


				/**
				* 결제 상태별 처리 로직 (상태, 결제번호를 받아 처리)
				* 단수/복수 데이터 모두 사용하도록 단일 함수 형태로 구성한다.
				*/
				function set_gold_logo($k2, $arr) {
					if(is_array($arr)) { foreach($arr as $k=>$v) {
						if(strpos($k2, $v)!==false) return $k;
					} }
					return false;
				}
				function payment_status( $pg='' ){
					global $utility, $member_control, $point_control, $alice, $env, $mu_process, $sms_control;
					$prev_page = strpos($_SERVER['HTTP_REFERER'], 'nad/payment/')!==false ? 'admin' : '';

					$row = sql_fetch("select * from alice_payment where `no`='".addslashes($_POST['no'])."'");
					$mem_se_row = sql_fetch("select * from alice_member_service where `mb_id`='".$row['pay_uid']."'");
					$get_member = $member_control->get_member($row['pay_uid']);	// 회원 정보

					$_post_un = unserialize(stripslashes($row['post_un']));
					$info_no = $row['pay_no'];
					$pay_no = $row['no'];

					// : 관리자에서 진행상태 수정할경우 결제완료가 아닐때 결제왼료를 제외한 나머지를 선택할경우 차감 안되게.
					if($prev_page==='admin' && $_POST['status'] && $row['pay_status']!=1 && $_POST['status']!=1) {

					// : 결제완료->나머지수정이거나, 나머지->결제완료 수정이거나 pg사를 통한 결제한경우에만 사용
					} else {

						switch($_post_un['p_mode']) {
							case 'job_payment':
								$info_row = sql_fetch("select * from alice_alba where `no`='".$info_no."'");
								$_head_txt = '채용공고';
								break;

							case 'resume_payment':
								$info_row = sql_fetch("select * from alice_alba_resume where `no`='".$info_no."'");
								$_head_txt = '인재정보';
								break;
						}

						if(is_array($_post_un['service'])) { foreach($_post_un['service'] as $k=>$v) {
							if(!$v) continue;
							$_key_arr = explode("/", $v);
							$price_key = $_key_arr[0];
							$price_no = $_key_arr[1];
							switch($price_key) {
								// : 패키지
								case "package":
									$package_row = sql_fetch("select * from alice_payment_package where `no`='".$price_no."'");
									$wr_content = unserialize(stripslashes($package_row['wr_content']));
									if(is_array($wr_content)) { foreach($wr_content as $k2=>$v2) {
										if($v2['use']) {
											$price_row = $v2;
											$price_row['type'] = $k2; // : 종류
											$price_row['service_cnt'] = $v2['service_count']; // : 건수, 날짜 숫자
											$price_row['etc_3'] = $v2['service_count']; // : 점프용
											$price_row['pay_type'] = 'package';
											if($v2['jump_count']>0) $price_row['service_cnt'] = $v2['jump_count']; // : 점프값이 있는경우 service_cnt값 저장
											$_re = $this->get_service_field_val($price_row, $mem_se_row, $info_row);
											$_arr[$_re['k']][$_re['f']][] = $_re['v'];
										}
									} }
									break;

								// : 기타
								default:
									$price_row = sql_fetch("select * from alice_service where `no`='".$price_no."'");
									if($price_row['etc_3']>0) $price_row['service_unit'] = 'count'; // : etc_3값이 있으면 점프건수값임. 무조건 count입니다.
									$_re = $this->get_service_field_val($price_row, $mem_se_row, $info_row);
									$_arr[$_re['k']][$_re['f']][] = $_re['v'];
									break;
							}
						} }

						// $_arr에는 기간이나 건값이 모아져있음. 패키지+일반정보 모두 선택했을경우 중복해서 다 처리해야함
						if(is_array($_arr)) { foreach($_arr as $k=>$v) {
							if(is_array($v)) { foreach($v as $k2=>$v2) {
								$_part = strpos($k2, 'count')===false ? 'date' : 'count';
								if($k=='mem_se') $field_set_value = $this->service_val($_part, $k2, $v2, $mem_se_row);
								else $field_set_value = $this->service_val($_part, $k2, $v2, $info_row);
								if($field_set_value) {
									$_field_arr[$k][$k2] = $field_set_value;
									$_gold_val = $this->set_gold_logo($k2, $_post_un['service_gold']);
									$_logo_val = $this->set_gold_logo($k2, $_post_un['service_logo']);
									if(strpos($k2, '_gold')!==false) {
										if(!isset($_gold_val)) unset($_field_arr[$k][$k2]);
									}

									// : 로고값
									if(strpos($k2, '_logo')!==false) {
										if(!isset($_logo_val)) unset($_field_arr[$k][$k2]);
										else $_field_arr[$k][$k2.'_val'] = $_post_un['logo_m'][$_logo_val];
									}
								}
							} }
						} }

						// : 옵션값 정보
						if(is_array($_post_un['service_opt'])) { foreach($_post_un['service_opt'] as $k=>$v) {
							$_field_arr['info']['wr_service_'.$k.'_val'] = $v;
						} }

						// : 무료인경우에는 기존정보에 값이 있나 없나 체크하기 값이 남아있으면 변수값 초기화
						if($mu_process) {
							// : 정보결제 디비처리전 체크
							$_info_table = array('job_payment'=>'alice_alba', 'resume_payment'=>'alice_alba_resume');
							if(is_array($_field_arr['info'])) {
								$_info_desc = sql_query("desc ".$_info_table[$_post_un['p_mode']]);
								while($desc=sql_fetch_array($_info_desc)) {
									$desc_arr[] = $desc['Field'];
								}
								foreach($_field_arr['info'] as $k=>$v) {
									if(strpos($k, 'count')!==false && $mem_se_row[$k]>0) unset($_field_arr['info'][$k]);
									else if($mem_se_row[$k]>=date("Y-m-d")) unset($_field_arr['info'][$k]);
								}
							}
							// : 회원테이블 디비처리전 체크
							if(is_array($_field_arr['mem_se'])) {
								$_info_desc = sql_query("desc alice_member_service");
								while($desc=sql_fetch_array($_info_desc)) {
									$desc_arr[] = $desc['Field'];
								}
								foreach($_field_arr['mem_se'] as $k=>$v) {
									if(strpos($k, 'count')!==false && $mem_se_row[$k]>0) unset($_field_arr['mem_se'][$k]);
									else if($mem_se_row[$k]>=date("Y-m-d")) unset($_field_arr['mem_se'][$k]);
								}
							}

							$_field_arr = @array_diff($_field_arr, array(""));

							if(count($_field_arr['mem_se'])<=0 && count($_field_arr['info'])<=0) {
								$delete = sql_query("delete from alice_payment where `no`='".$row['no']."'");
								return false;
							}
						}

						if(@count($_arr['info'])>0) $info_values = $utility->QueryString($_field_arr['info']);
						if(@count($_arr['mem_se'])>0) $mem_se_values = $utility->QueryString($_field_arr['mem_se']);

						// : 정보 update
						if($info_values) {
							switch($_post_un['p_mode']) {
								case 'job_payment':
									$update_q = "update alice_alba set $info_values where `no`='".$info_no."'";
									break;

								case 'resume_payment':
									$update_q = "update alice_alba_resume set $info_values where `no`='".$info_no."'";
									break;
							}
							$update = sql_query($update_q);
						}

						// : 회원 update
						if($mem_se_values) {
							$member_q = "update alice_member_service set $mem_se_values where `mb_id`='".$row['pay_uid']."'";
							$update = sql_query($member_q);
						}

						// 사용한 포인트가 있다면 차감
						$use_point = $row['pay_dc'];
						if($use_point){

							//$point = $get_member['mb_point'] - $use_point;
							$content = $alice['time_ymd'] . " ".$_head_txt." [".stripslashes($info_row['wr_subject'])."] 등록시 사용";
							$point_control->point_insert($get_member['mb_id'], "-".$use_point, $content, "alba", $pay_no, $alice['time_ymdhis']." 등록");

						}
						//	else {	 // 사용한 포인트가 없는 경우 관리자에서 설정한 유료결제 포인트를 지급한다.

						if($env['alba_point_percent']){	// 지급 % 가 설정되어 있다면
							$pay_price = $row['pay_price'];	 // 결제 금액
							$pay_point = ($pay_price / 100 ) * $env['alba_point_percent'];
							$content = $alice['time_ymd'] . " ".$_head_txt." [".stripslashes($info_row['wr_subject'])."] 등록시 적립";
							$point_control->point_insert($get_member['mb_id'], $pay_point, $content, "alba", $pay_no, $alice['time_ymdhis']." 등록");
						}
						//}

					}

					// 결제 정보 업데이트
					if($pg) $__add_set = ", `pg_un`='".base64_encode(serialize($pg))."'";
					$pay_status = $prev_page==='admin' && $_SESSION['sess_admin_uid'] ? intval($_POST['status']) : 1;
					if($pay_status==1) $__add_set = ", `pay_sdate`=now()";
					$pay_update_query = " update `".$this->payment_table."` set `pay_status` = ".$pay_status." ".$__add_set." where `no` = '".$pay_no."' ";
					$result = $this->_query($pay_update_query);

					//$result = $this->success_payment($oid);

					if($prev_page==='admin' && $_SESSION['sess_admin_uid'] && $_POST['status']==1)
						$sms_control->send_sms_user('pay_online_success', $get_member, "", $_POST);

					return '설정이 완료되었습니다.';

				}

				


		}	// class end.
?>