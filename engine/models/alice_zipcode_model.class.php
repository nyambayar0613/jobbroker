<?php
		/**
		* /application/nad/config/model/alice_zipcode_model.class.php
		* @author Harimao
		* @since 2013/07/03
		* @last update 2013/12/04
		* @Module v3.5 ( Alice )
		* @Brief :: Zipcode Model Class
		* @Comment :: 우편번호 모델 클래스
		*/
		class alice_zipcode_model extends DBConnection {

			var $zipcode_table	= "alice_zipcode";
			var $new_zipcode_table = "alice_zipcode_new";

			var $success_code = array(
					'0000' => '',
			);
			var $fail_code = array(
					'0000' => '회원약관에 동의하셔야 합니다.',
			);


				// 우편번호 리스트
				function __ZipcodeList( $page="", $page_rows="", $con="", $order="" ){

						$order = ($order) ? $order : " `no` desc ";

						$query = " select * from `".$this->zipcode_table."` " . $con . " order by " . $order;

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/* 질의문 확인
						echo "<div style='color:#fff;'>";
						echo $query."<br/>";
						echo "</div><br/>";
						*/

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
					
					return $result;

				}

				// 우편번호 검색 (일반 주소)
				function __PostSearch( $keyword, $order="asc" ){

						if(!$keyword || $keyword=='') return false;

						$query = " select * from `".$this->zipcode_table."` where instr(`GUGUN`, '".$keyword."') >= 1 or instr(`DONG`, '".$keyword."') >= 1 or instr(`RI`, '".$keyword."') >= 1 order by `SEQ` " . $order;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}

				// 우편번호 검색 (도로명 주소)
				function __NewPostSearch( $keyword, $order="asc" ){

						if(!$keyword || $keyword=='') return false;

						$query = " select * from `".$this->new_zipcode_table."` where INSTR(`road_name`, '".$keyword."') >=1 order by `no` " . $order;	 // or INSTR(`law_dong_name`, '".$keyword."')

						$result = $this->query_fetch_rows($query);

					
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