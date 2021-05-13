<?php
		/**
		* /application/company/controller/alice_company_manager_control.class.php
		* @author Harimao
		* @since 2013/09/27
		* @last update 2013/09/27
		* @Module v3.5 ( Alice )
		* @Brief :: Company Manager Control class
		* @Comment :: 사용자측 기업회원 담당자/지역정보 컨트롤 클래스
		*/
		class alice_company_manger_control extends alice_company_manger_model {


				/**
				* Manager Data 입력
				*/
				function insert_manager( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->manager_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* Manager Data 수정
				*/
				function update_manager( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->manager_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

				/**
				* Manager Data 삭제 :: no 기준
				*/
				function delete_manager( $no ){

					global $utility;
					global $alba_user_control;
						
						if(!$no || $no=='') return false;


						$query = " delete from`".$this->manager_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


		}	// class end.
?>