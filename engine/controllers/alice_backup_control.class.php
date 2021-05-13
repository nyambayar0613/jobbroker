<?php
		/**
		* /application/nad/config/controller/alice_backup_control.class.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/05/28
		* @Module v3.5 ( Alice )
		* @Brief :: DB Backup Control class
		* @Comment :: mySQL DB 백업 컨트롤 클래스
		*/
		class alice_backup_control extends alice_backup_model {


				/**
				* 백업 데이터 정보 입력
				*/
				function insert_backup( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->backup_table."` set " . $val;

						$result = $this->_query($query);

					
					return $result;
						
				
				}

				
				/**
				* 백업 데이터 삭제
				*/
				function delete_backup( $no ){

					global $alice, $utility;

						$get_backup = $this->get_backup($no);

						// 백업 파일 삭제
						$result = @unlink($alice['data_db_path'] . "/" . $get_backup['file_name']);

						if($result){

							// 백업 데이터 삭제
							$query = " delete from `".$this->backup_table."` where `no` = '".$no."' ";

							$result = $this->_query($query);

						}


					return $result;

				}

		}	// class end.

?>