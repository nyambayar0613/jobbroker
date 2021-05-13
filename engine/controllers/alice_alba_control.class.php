<?php
		/**
		* /application/nad/alba/model/alice_alba_control.class.php
		* @author Harimao
		* @since 2013/07/08
		* @last update 2014/12/02
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Control Class
		* @Comment :: 관리자측 정규직 관리 컨트롤 클래스
		*/
		class alice_alba_control extends alice_alba_model {


				/**
				* 정규직 공고 등록
				*/
				function alba_insert( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->alba_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 정규직 공고 수정
				*/
				function alba_update( $vals, $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->alba_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 정규직 공고 삭제 :: no 기준
				*/
				function alba_delete( $no, $mb_id ){

					global $alice, $env, $is_admin;
					global $user_control, $point_control;

						if(!$no || $no=='') return false;

						$get_alba = $this->get_alba($no);

						// 01. 회원 정규직 카운트 감소
						$user_control->user_count_update('mb_alba_count',$get_alba['wr_id'],1,'-');

						// 02. 회원 포인트 차감

						// 03. 정규직 근무회사 이미지 삭제
						$user_control->user_photo_delete( $mb_id, $no );

						// 04. 관리자 등록 데이터 삭제
						@unlink($alice['data_alba_path'] . "/" . $get_alba['etc_0']);

						// 05. 정규직 데이터 삭제
						//$query = " delete from `".$this->alba_table."` where `no` = '".$no."' ";
						$query = " update `".$this->alba_table."` set `is_delete` = 1 where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


		}	// class end.
?>