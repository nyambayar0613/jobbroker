<?php
		/**
		* /application/nad/payment/controller/alice_bank_control.class.php
		* @author Harimao
		* @since 2012/10/04
		* @last update 2012/10/04
		* @Module v3.0 ( Alice )
		* @Brief :: Bank Info Control class
		* @Comment :: 무통장 입금 계좌 설정 컨트롤 클래스
		*/
		class alice_bank_control extends alice_bank_model {

			
				/**
				* 무통장 입금 계좌 정보 입력
				*/
				function insert_bank( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->bank_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 무통장 입금 계좌 정보 수정
				*/
				function update_bank( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->bank_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 무통장 입금 계좌 정보 삭제
				*/
				function delete_bank( $no ){

					global $utility;

						$query = " delete from `".$this->bank_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 삭제 후 rank 정렬 :: no 기준
				*/
				function delete_noRank( $no ){

						// rank 값 구함
						$get_rank = $this->get_bank($no);

						// 삭제
						$result = $this->delete_bank($no);
						
						$query = " update `".$this->bank_table."` set `rank` = rank-1 where `rank` > '".$get_rank['rank']."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 순위조절
				*/
				function setRank($type, $no, $next_no){

						$get_bank = $this->get_bank($no);				// 선택 no
						$next_bank = $this->get_bank($next_no);	// 선택 다음 no
						
						$vals['rank'] = $next_bank['rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_bank($vals, $no);

						$vals['rank'] = $get_bank['rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_bank($vals, $next_no);


					return $result;

				}


		}	// class end.
?>