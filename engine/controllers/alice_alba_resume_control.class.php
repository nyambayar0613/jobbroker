<?php
		/**
		* /application/nad/alba/model/alice_alba_resume_control.class.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2013/08/05
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Resume Control Class
		* @Comment :: 관리자측 정규직 이력서 관리 컨트롤 클래스
		*/
		class alice_alba_resume_control extends alice_alba_resume_model {

				/**
				* 정규직 이력서 정보 입력
				*/
				function insert_resume( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->resume_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 정규직 이력서 정보 수정
				*/
				function update_resume( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->resume_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 정규직 이력서 정보 삭제 :: no 기준
				*/
				function delete_resume( $no, $mb_id ){

					global $alice, $env;
					global $user_control, $point_control;


						if(!$no || $no=='') return false;

						// 01. 회원 정규직 이력서 카운트 감소
						$user_control->user_count_update('mb_alba_resume_count',$mb_id,1,'-');

						// 02. 회원 포인트 차감

						// 03. 이력서 데이터 삭제
						$result = $this->_query(" delete from `".$this->resume_table."` where `no` = '".$no."' ");


					return $result;

				}
		}	// class end.
?>