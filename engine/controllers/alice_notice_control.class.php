<?php
		/**
		* /application/nad/service/controller/alice_notice_control.class.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/05/28
		* @Module v3.5 ( Alice )
		* @Brief :: Notice Control class
		* @Comment :: Notice 컨트롤 클래스
		*/
		class alice_notice_control extends alice_notice_model {

			
				/**
				* 공지사항 정보 입력
				*/
				function insert_notice( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->notice_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}

				
				/**
				* 공지사항 정보 수정 :: no 기준
				*/
				function update_notice( $vals, $no ){

					global $utility;

						if($no=='' || !$no)
							return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->notice_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 공지사항 삭제 :: no 기준
				*/
				function delete_notice( $no ){

					global $alice, $utility;

						if($no=='' || !$no) return false;

						$notice = $this->get_notice($no);
						$ym = str_replace('-','',substr($notice['wr_date'],2,5));

						// 파일 삭제
						$wr_file = unserialize($notice['wr_file']);
						$wr_file_cnt = count($wr_file);

						for($i=0;$i<$wr_file_cnt;$i++){
							@unlink($alice['data_notice_abs_path'] . '/' . $ym . '/' . $wr_file[$i]);
						}

						// DB 삭제
						$query = " delete from `".$this->notice_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;
					
				}


				/**
				* 공지 hit up
				*/
				function hitup_notice( $no ){

						if($no=='' || !$no)
							return false;

						$notice = $this->get_notice($no);

						$query = " update `".$this->notice_table."` set `wr_hit` = `wr_hit` + 1 where `no` = '".$no."' ";

						$result = $this->_query($query);

					
					return $result;

				}


		}	// class end.

?>