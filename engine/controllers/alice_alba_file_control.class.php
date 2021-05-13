<?php
		/**
		* /application/nad/alba/model/alice_alba_file_control.class.php
		* @author Harimao
		* @since 2015/01/13
		* @last update 2015/01/13
		* @Module v3.5 ( Alice )
		* @Brief :: Alba File Control Class
		* @Comment :: 관리자측 이력서 파일 관리 컨트롤 클래스
		*/
		class alice_alba_file_control extends alice_alba_file_model {


				/**
				* 파일 정보 입력
				*/
				function insert_file( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->file_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 파일 정보 수정
				*/
				function update_file( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->file_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 파일 정보 삭제 :: no 기준
				*/
				function delete_file( $no ){

					global $alice;

						if(!$no || $no=='') return false;

						$get_file = $this->get_file($no);

						$result = $this->_query(" delete from `".$this->file_table."` where `no` = '".$no."' ");

						if($result){
							@unlink($alice['data_alba_abs_path']."/".$get_file['wr_content']);	// 파일 삭제
						}


					return $result;

				}

		}	// class end.
?>