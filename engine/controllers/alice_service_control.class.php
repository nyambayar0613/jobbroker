<?php
		/**
		* /application/nad/service/controller/alice_service_control.class.php
		* @author Harimao
		* @since 2013/06/26
		* @last update 2015/03/23
		* @Module v3.5 ( Alice )
		* @Brief :: Service Control Class
		* @Comment :: 서비스 설정 컨트롤 클래스
		*/
		class alice_service_control extends alice_service_model {


				/**
				* Service 정보 입력
				*/
				function insert_service( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->service_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* Service 정보 수정
				*/
				function update_service( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->service_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* Service 정보 삭제
				*/
				function delete_service( $no ){

					global $alice, $utility;

						$service = $this->get_service($no);

						// DB 삭제
						$query = " delete from `".$this->service_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 삭제 후 rank 정렬 :: no 기준
				*/
				function delete_noRank( $no ){

						// rank 값 구함
						$get_service = $this->get_service($no);

						$type = $get_service['type'];

						// 삭제
						$result = $this->delete_service($no);
						
						$query = " update `".$this->service_table."` set `rank` = rank-1 where `type` = '".$type."' and `rank` > '".$get_service['rank']."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 순위조절
				*/
				function setRank( $type, $no, $next_no ){

						$get_service = $this->get_service($no);				// 선택 no
						$next_service = $this->get_service($next_no);	// 선택 다음 no

						$vals['rank'] = $next_service['rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_service($vals, $no);

						$vals['rank'] = $get_service['rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_service($vals, $next_no);


					return $result;

				}

				
				/**
				* 서비스별 유/무료 설정
				*/
				function service_check_updates( $service, $is_pay ){

					global $alice;
					global $admin_info;

						$sel_query_cnt = $this->_queryR(" select * from `".$this->service_check_table."` where `service` = '".$service."' ");

						if($sel_query_cnt){	 // 있다면 수정

							$query = " update `".$this->service_check_table."` set `is_pay` = '".$is_pay."', `udate` = now() where `service` = '".$service."' ";

						} else {	 // 없으면 입력

							$query = " insert into `".$this->service_check_table."` set `uid` = '".$admin_info['uid']."', `service` = '".$service."', `is_pay` = '".$is_pay."', `wdate` = now(), `udate` = now() ";

						}

						$result = $this->_query($query);


					return $result;

				}

				/**
				* Service check 정보 수정 :: no 기준
				*/
				function update_service_check( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->service_check_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* Service check 정보 수정 :: service 기준
				*/
				function service_check_update( $vals, $service ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->service_check_table."` set " . $val . " where `service` = '".$service."' ";

						$result = $this->_query($query);


					return $result;

				}


				// 서비스 타입별 업데이트
				// type 필드 기준
				function service_update_types( $vals, $type ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->service_table."` set " . $val . " where `type` = '".$type."' ";

						$result = $this->_query($query);


					return $result;

				}

		}	// class end.
?>