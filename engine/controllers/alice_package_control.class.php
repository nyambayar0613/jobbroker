<?php
		/**
		* /application/nad/payment/controller/alice_package_control.class.php
		* @author Harimao
		* @since 2015/03/20
		* @last update 2015/04/10
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Package Control class
		* @Comment :: 결제 패키지 컨트롤 클래스
		*/
		class alice_package_control extends alice_package_model {


				/**
				* 결제 패키지 설정 정보 입력
				*/
				function insert_package( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->package_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}

				
				/**
				* 결제 패키지 설정 정보 수정 :: no 기준
				*/
				function update_package( $vals, $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->package_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 결제 패키지 정보삭제
				*/
				function delete_package( $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " delete from`".$this->package_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 삭제 후 rank 정렬 :: no 기준
				*/
				function delete_noRank( $no, $type ){

						if(!$no || !$type) return false;

						// rank 값 구함
						$get_rank = $this->get_package($no);

						// 삭제
						$result = $this->delete_package($no);
						
						$query = " update `".$this->package_table."` set `wr_rank` = wr_rank-1 where `wr_type` = '".$type."' and `wr_rank` > '".$get_rank['wr_rank']."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 순위조절
				*/
				function setRank($type, $no, $next_no){

						$get_package = $this->get_package($no, " and `wr_type` = '".$type."' ");				// 선택 no
						$next_package = $this->get_package($next_no, " and `wr_type` = '".$type."' ");	// 선택 다음 no

						$vals['wr_rank'] = $next_package['wr_rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_package($vals, $no);

						$vals['wr_rank'] = $get_package['wr_rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_package($vals, $next_no);
						

					return $result;

				}


		}	// class end.
?>