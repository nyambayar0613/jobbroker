<?php
		/**
		* /application/nad/config/model/alice_backup_model.class.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/05/28
		* @Module v3.5 ( Alice )
		* @Brief :: DB Backup Model class
		* @Comment :: mySQL DB 백업 모델 클래스
		*/
		class alice_backup_model extends DBConnection {

			var $backup_table	 = "alice_backup";		// db backup table

			var $success_code = array(
					'0000' => '백업 되었습니다.',
					'0001' => '백업파일 삭제가 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '백업중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '백업파일 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);

				function __BackupList( $page="", $page_rows="" ){

						$query = " select * from `".$this->backup_table."`order by `no` desc ";

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}


				// 백업 정보 추출(단일)
				function get_backup( $no ){

						$query = " select * from `".$this->backup_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				/**
				* 에러코드에 맞는 에러를 토해낸다.
				*/
				function _errors( $err_code ){

						$result = $this->fail_code[$err_code];

					return $result;

				}

				/**
				* 완료코드에 맞는 에러를 토해낸다.
				*/
				function _success( $success_code ){

						$result = $this->success_code[$success_code];

					return $result;

				}


		}	// class end.

?>