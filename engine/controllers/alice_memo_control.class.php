<?php
		/**
		* /application/nad/member/controller/alice_memo_control.class.php
		* @author Harimao
		* @since 2015/03/16
		* @last update 2015/03/16
		* @Module v3.5 ( Alice )
		* @Brief :: Memo Control class
		* @Comment :: 메모 컨트롤 클래스
		*/
		class alice_memo_control extends alice_memo_model {


				/**
				* 쪽지 데이터 입력
				*/
				function insert_memo( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->memo_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}

				
				/**
				* 쪽지 데이터 수정 :: no 기준
				*/
				function update_memo( $vals, $no ){

					global $utility;

						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->memo_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 쪽지 데이터 삭제 :: no 기준
				*/
				function delete_memo( $no ){

						if(!$no || $no=='') return false;

						$query = " delete from `".$this->memo_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 쪽지 읽음 전환
				*/
				function read_memo( $no, $mb_id ){

					global $alice;

						if(!$no || $no=='' && !$mb_id || $mb_id=='') return false;

						$query = " update `".$this->memo_table."` set `wr_read_datetime` = '".$alice['time_ymdhis']."' where `no` = '".$no."' and `wr_recv_mb_id` = '".$mb_id."' and `wr_read_datetime` = '0000-00-00 00:00:00' ";

						$result = $this->_query($query);


					return $result;

				}


		}	// class end.
?>