<?php
		/**
		* /application/company/model/alice_company_manager_model.class.php
		* @author Harimao
		* @since 2013/09/27
		* @last update 2013/11/07
		* @Module v3.5 ( Alice )
		* @Brief :: Company Manager Model Class
		* @Comment :: 사용자측 기업회원 담당자/지역정보 관리 모델 클래스
		*/
		class alice_company_manger_model extends DBConnection {

			var $manager_table	= "alice_company_manager";

			var $success_code = array(
					'0000' => '',
			);
			var $fail_code = array(
					'0000' => '',
			);


				// 담당자 리스트
				function __ManagerList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						//$_add = $this->_Search( );

						$query = " select * from `".$this->manager_table."` " . $con . " order by `no` desc ";

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/*
						echo "<xmp>";
						echo $query;
						echo "</xmp>";
						*/

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}


				// 담당자 추출(단수) :: no 기준
				function get_manager( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->manager_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

		}	// class end.
?>