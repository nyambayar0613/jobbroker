<?php
		/**
		* /application/nad/main/controller/alice_quick_control.class.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2013/06/11
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Quick Menu Control class
		* @Comment :: 관리자 퀵 메뉴 컨트롤 클래스
		*/
		class alice_quick_control extends alice_quick_model {


				/**
				* 관리자 퀵 메뉴 데이터 AJAX 입력
				* /nad/include/_ajax/navi.php , mode :: quick_insert 에서 넘어온다
				*/
				function quick_insert( $vals ){

					global $utility;

						if($val)	// 입력할 데이터 변수가 없다면
							return false;

						$val = $utility->QueryString($vals);


						$query = " insert into `".$this->quick_table."` set " . $val;

						$result = $this->_query($query);

					
					return $result;
						
				}


		}	// class end.

?>