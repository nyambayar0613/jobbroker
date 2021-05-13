<?php
		/**
		* /application/nad/design/model/alice_alba_config_control.class.php
		* @author Harimao
		* @since 2013/08/08
		* @last update 2013/08/08
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Config Control Class
		* @Comment :: 알바 설정 컨트롤 클래스
		*/
		class alice_alba_config_control extends DBConnection {


				/**
				* 알바 설정 정보 입력
				*/
				function insert_alba_config( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->alba_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 알바 설정 정보 수정
				*/
				function update_alba_config( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->alba_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


		}	// class end.
?>