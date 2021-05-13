<?php
		/**
		* /application/nad/payment/controller/alice_tax_control.class.php
		* @author Harimao
		* @since 2013/09/30
		* @last update 2013/09/30
		* @Module v3.5 ( Alice )
		* @Brief :: Tax Control class
		* @Comment :: 세금계산서 컨트롤 클래스
		*/
		class alice_tax_control extends alice_tax_model {


				/**
				* 세금계산서 정보 입력
				*/
				function insert_tax( $vals){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert `".$this->tax_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 세금계산서 정보 수정
				*/
				function update_tax( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->tax_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 세금계산서 정보 삭제
				*/
				function delete_tax( $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$query = " delete from `".$this->tax_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

		}	// class end.
?>