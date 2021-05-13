<?php
		/**
		* /application/nad/mobile/controller/alice_mobile_control.class.php
		* @author Harimao
		* @since 2013/12/16
		* @last update 2013/12/27
		* @Module v3.5 ( Alice )
		* @Brief :: Mobile Control class
		* @Comment :: 모바일 컨트롤 클래스
		*/
		class alice_mobile_control extends alice_mobile_model {


				/**
				* 모바일 정보 입력
				*/
				function insert_mobile( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->mobile_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 모바일 정보 수정
				*/
				function update_mobile( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->mobile_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

				// 공고별 로고 출력
				function logo_print( $logo_file, $print_type ){

						switch($print_type){
							case '0':
								$result = "<img src=\"".$logo_file."\" class=\"vm fade_image\" width='200' height='100' />";
							break;
							case '1':
								$result = "<img src=\"".$logo_file."\" class=\"vm blink_image\" width='200' height='100' />";
							break;
							case '2':
								//$result = "<div class=\"slide_image\" style=\"position:relative; width:100px; height: 50px; overflow: hidden; display: inline-block;\">";
								$result = "<div class=\"slide_image\" style=\"position:relative; width:200px; height: 200px; overflow: hidden; display: inline-block;\">";
								$result .= "<img src=\"".$logo_file."\" width='200' height='100' />";
								$result .= "<img src=\"".$logo_file."\" width='200' height='100' />";
								$result .= "</div>";
							break;
						}


					return $result;

				}


		}	// class end.
?>