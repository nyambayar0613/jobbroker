<?php
		/**
		* /application/nad/main/model/alice_quick_model.class.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2013/06/11
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Quick Menu Model class
		* @Comment :: 관리자 퀵 메뉴 모델 클래스
		*/
		class alice_quick_model extends DBConnection {

			var $quick_table = "alice_admin_quick";

			var $success_code = array(
					'0000' => '퀵 메뉴에 추가 되었습니다..',
			);
			var $fail_code = array(
					'0000' => '이미 추가하신 메뉴 입니다.',
			);
				function __QuickList( $uid=''){

						$query = " select * from `".$this->quick_table."` ";

						if($uid){
							$query .= " where `uid` = '".$uid."' ";
						}

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// 단일 데이터 검색
				function get_quick( $uid ){

						if(!$uid)	 // uid 가 없다면 false
							return false;

						$query = " select * from `".$this->quick_table."` where `uid` = '".$uid."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 중복 데이터 체크시
				function duplication_quick( $uid, $top_menu_code, $middle_menu_code, $sub_menu_code ){

						$query = " select * from `".$this->quick_table."` where `uid` = '".$uid."' and `top_menu_code` = '".$top_menu_code."' and `middle_menu_code` = '".$middle_menu_code."' and `sub_menu_code` = '".$sub_menu_code."' ";

						$result = $this->_queryR($query);


					return $result;

				}


				// sub menu code 기준 데이터 추출
				function get_subMenu( $uid, $sub_code ){

						$query = " select * from `".$this->quick_table."` where `uid` = '".$uid."' and `sub_menu_code` = '".$sub_code."' ";

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