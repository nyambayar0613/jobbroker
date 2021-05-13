<?php
		/**
		* /application/nad/board/controller/alice_poll_control.class.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/10/31
		* @Module v3.5 ( Alice ) - p1.0
		* @Brief :: Poll Control class
		* @Comment :: Poll (설문조사) 컨트롤 클래스
		*/
		class alice_poll_control extends alice_poll_model {


				/**
				* 정보 입력
				*/
				function insert_poll( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->poll_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 정보 수정 :: no 기준
				*/
				function update_poll( $vals, $no ){

					global $utility;

						if($no=='' || !$no)
							return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->poll_table."` set " . $val . " where `no` = '" . $no . "' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 사용/미사용 설정 :: no 기준
				*/
				function use_poll( $no ){

					global $utility;

						if($no=='' || !$no) return false;

						$get_poll = $this->get_poll($no);
						$_use = $get_poll['use'];

						$use = ($_use) ? 0 : 1;

						// 우선 view_main 을 모두 0 으로 변경
						$query = " update `".$this->poll_table."` set `use` = " . $use;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 메인 출력 설정 :: no 기준
				*/
				function viewMain_poll( $no ){

					global $utility;

						if($no=='' || !$no) return false;

						// 우선 view_main 을 모두 0 으로 변경
						$query = " update `".$this->poll_table."` set `view_main` = 0 ";

						$result = $this->_query($query);

						// 다음 현 no 값의 데이터를 1 로 변경
						$query = " update `".$this->poll_table."` set `view_main` = 1 where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 정보 삭제 :: no 기준
				*/
				function delete_poll( $no ){

					global $utility;

						if($no=='' || !$no)
							return false;

						// DB 삭제
						$query = " delete from `".$this->poll_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 설문조사 코멘트 정보 입력
				*/
				function insert_pollComment( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->poll_comment_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 설문조사 코멘트 정보 삭제 :: no 기준
				*/
				function delete_pollComment( $no ){

					global $utility;

						if($no=='' || !$no)
							return false;

						// DB 삭제
						$query = " delete from `".$this->poll_comment_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

		}	// class end.
?>