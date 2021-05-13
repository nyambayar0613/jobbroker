<?php
		/**
		* /application/nad/payment/model/alice_package_model.class.php
		* @author Harimao
		* @since 2015/03/20
		* @last update 2015/04/10
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Package Model class
		* @Comment :: 결제 패키지 모델 클래스
		*/
		class alice_package_model extends DBConnection {

			var $package_table	= "alice_payment_package";

			var $success_code = array(
					'0000' => '채용공고 패키지 설정이 완료 되었습니다.',
					'0001' => '이력서 패키지 설정이 완료 되었습니다.',
					'0002' => '패키지 설정이 완료 되었습니다.',
			);

			var $fail_code = array(
					'0000' => '이력서 패키지 설정중 오류가 발생하였습니다.',
					'0001' => '채용공고 패키지 설정중 오류가 발생하였습니다.',
					'0002' => '패키에 오류가 발생하였습니다.',
					'0003' => '패키지 설정중 오류가 발생하였습니다.',
			);



				/**
				* 패키지 설정 리스트
				*/
				function __PackageList( $page="", $page_rows="", $con="", $order="" ){

						$order = ($order) ? $order : " order by `wr_rank` asc ";

						$query = " select * from `".$this->package_table."` " . $con . $order;

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
				* 패키지 설정 정보 추출 (단일)
				*/
				function get_package( $no, $con="" ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->package_table."` where `no` = '".$no."' " . $con;

						$result = $this->query_fetch($query);


					return $result;
					
				}


				/**
				* rank 최대값
				*/
				function get_MaxRank( $con="" ){

						$query = " select max(`wr_rank`) as `rank` from `".$this->package_table."` " . $con;

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

				}


				/**
				* 패키지 서비스별 결제 금액, 건수 계산
				*/
				function package_service( $service_date, $package_service ){

						$result = "";
					
						if($service_date){

							$service = explode("/",$service_date);
							$package = explode("/",$package_service);

							if( $service[1] == 'count' ){	// 건수

							} else {	 // 날짜

								$service_dates = date("Y-m-d",strtotime("+".$service[0]." ".$service[1]));
								sscanf($service_dates,'%4d-%2d-%2d',$y,$m,$d); 
								if($package[1]=='day'){
									$package_dates = date('Y-m-d',mktime(0,0,0,$m,$d+$package[0],$y)); 
								} else if($package[1]=='month'){
									$package_dates = date('Y-m-d',mktime(0,0,0,$m+$package[0],$d,$y)); 
								} else if($package[1]=='year'){
									$package_dates = date('Y-m-d',mktime(0,0,0,$m,$d,$y+$package[0])); 
								}

							}

						}

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