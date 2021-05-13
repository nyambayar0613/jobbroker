<?php
		/**
		* /application/nad/design/controller/alice_design_control.class.php
		* @author Harimao
		* @since 2013/06/13
		* @last update 2014/10/06
		* @Module v3.5 ( Alice )
		* @Brief :: Design Control class
		* @Comment :: 디자인 컨트롤 클래스
		*/
		class alice_design_control extends alice_design_model {

			
				/**
				* 디자인 정보 입력
				*/
				function insert_design( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->design_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 디자인 정보 수정
				*/
				function update_design( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->design_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 메일 스킨 정보 입력
				*/
				function insert_Mailskin( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->mail_skin_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 메일 스킨 정보 수정
				*/
				function update_Mailskin( $vals, $skin_name ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->mail_skin_table."` set " . $val . " where `skin_name` = '".$skin_name."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 로고 이미지/플래시 파일 정보에 따른 출력
				*/
				function view_logo( $logo, $is_mail=false ){
					
					global $alice, $utility;

						$extension = $utility->get_extension($logo);	// 확장자 체크
						$logo_file = $alice['data_logo_path'] . "/" . $logo;
						$size = @getimagesize($logo_file);

						$result = "";

						if($is_mail) $logo_file = "http://" . $_SERVER['HTTP_HOST'] . "/data/logo/" . $logo;

						if($extension=='swf'){	// 플래시 파일이라면

							$result .= "<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' width='" . $size[0] . "' height='" . $size[1] . "' codebase='http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0'>\n";
							$result .= "<param name='movie' value='" . $logo_file . "'>\n";
							$result .= "<param name='wmode' value='opaque'>\n";
							$result .= "<param name='play' value='true'>\n";
							$result .= "<param name='loop' value='true'>\n";
							$result .= "<param name='quality' value='high'>\n";
							$result .= "<embed src='" . $logo_file . "' width='" . $size[0] . "' height='" . $size[1] . "' play='true' loop='true' quality='high' pluginspage='http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed>\n
							";
							$result .= "</object>";

						} else {
							
							$result .= "<img src='".$logo_file."' border='0'/>";

						}


					return $result;


				}
				

		}	// class end.
?>