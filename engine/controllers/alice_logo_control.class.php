<?php
		/**
		* /application/nad/design/controller/alice_logo_control.class.php
		* @author Harimao
		* @since 2013/06/14
		* @last update 2015/03/24
		* @Module v3.5 ( Alice )
		* @Brief :: Logo Control class
		* @Comment :: 로고 컨트롤 클래스
		*/
		class alice_logo_control extends alice_logo_model {

			
				/**
				* 로고 정보 입력
				*/
				function insert_logo( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->logo_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 로고 정보 수정
				*/
				function update_logo( $vals, $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->logo_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 공고 로고 등록
				*/
				function insert_employ_logo( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->employ_logo_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 공고 로고 수정
				* no 기준
				*/
				function update_employ_logo( $vals, $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->employ_logo_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 공고 로고 수정
				*/
				function updates_employ_logo( $vals){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->employ_logo_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 공고 로고 삭제
				* no 기준
				*/
				function delete_employ_logo( $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$query = " delete from  `".$this->employ_logo_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

		}	// class end.
?>