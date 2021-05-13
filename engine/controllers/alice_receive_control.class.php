<?php
		/**
		* /application/main/controller/alice_receive_control.class.php
		* @author Harimao
		* @since 2013/09/25
		* @last update 2013/10/16
		* @Module v3.5 ( Alice )
		* @Brief :: Receive Data Control class
		* @Comment :: Receive 데이터 컨트롤 클래스
		*/
		class alice_receive_control extends alice_receive_model {


				/**
				* Receive Data 입력
				*/
				function insert_receive( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->receive_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* Receive Data 수정
				*/
				function update_receive( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->receive_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

				/**
				* Receive Data 삭제 :: no 기준
				*/
				function delete_receive( $no ){

					global $utility;
					global $alba_user_control;
						
						if(!$no || $no=='') return false;

						$get_receive = $this->get_receive($no);

						$alba_user_control->desire_down($get_receive['wr_to']);	// 지원자수 감소

						$query = " delete from`".$this->receive_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				// 열람일 기록
				function update_receive_etc_4( $no, $wr_to_id ){

					global $alice;

						if(!$no || $no=='') return false;
						if(!$wr_to_id || $wr_to_id=='') return false;

						//$con = " `wr_id` = '".$wr_id."' and `wr_from` = '".$wr_from."' and `wr_to_id` = '".$wr_to_id."' ";

						$is_receive = $this->query_fetch(" select * from `".$this->receive_table."` where `no` = '".$no."' and `wr_to_id` = '".$wr_to_id."' ");

						if($is_receive['etc_4']){	// 이미 열람일이 있다면

							$result = false;

						} else {

							$query = " update `".$this->receive_table."` set `etc_4` = '".$alice['time_ymdhis']."' where `no` = '".$no."' and `wr_to_id` = '".$wr_to_id."' ";

							$result = $this->_query($query);
						}


					return $result;

				}



		}	// class end.
?>