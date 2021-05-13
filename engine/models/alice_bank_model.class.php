<?php
		/**
		* /application/nad/payment/model/alice_bank_model.class.php
		* @author Harimao
		* @since 2012/10/04
		* @last update 2013/10/04
		* @Module v3.0 ( Alice )
		* @Brief :: Bank Info Model class
		* @Comment :: 무통장 입금 계좌 설정 모델 클래스
		*/
		class alice_bank_model extends DBConnection {

			var $bank_table	 = "alice_bank";


				// 무통장 입금계좌 리스트 출력
				// 기본적으로 rank 순
				function __BankList( $con="" ){

						$query = " select * from `".$this->bank_table."` " . $con . " order by `rank` asc ";

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 무통장 입금계좌 정보 추출(단수)
				function get_bank($no){

						$query = " select * from `".$this->bank_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 무통장 입금계좌 rank 최대값 구함
				function get_MaxRank(){

						$query = " select max(`rank`) as `rank` from `".$this->bank_table."` ";

						$result = $this->query_fetch($query);

					
					return ($result['rank']) ? $result['rank'] : 0;

				}


				// 무통장 입금계좌 rank 순으로 1개만 뽑음
				function get_Rank_once(){

						$query = " select * from `".$this->bank_table."` order by `rank` asc ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

		
		}	// class end.

?>