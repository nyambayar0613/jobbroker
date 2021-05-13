<?php
		/**
		* /application/nad/board/controller/alice_board_control.class.php
		* @author Harimao
		* @since 2013/05/29
		* @last update 2013/10/30
		* @Module v3.5 ( Alice )
		* @Brief :: Board Control class
		* @Comment :: 게시판 컨트롤 클래스
		*/
		class alice_board_control extends alice_board_model {


				/**
				* 게시물 등록
				*/
				function _insert( $vals, $bo_table ){

					global $alice, $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `" . $alice['write_prefix'] . $bo_table . "` set " . $val;

						$result = $this->_query($query);


					return $result;
				}


				/**
				* 게시물 수정
				*/
				function _update( $vals, $bo_table, $wr_no ){

					global $alice, $utility;

						$val = $utility->QueryString($vals);

						$query = " update `" . $alice['write_prefix'] . $bo_table . "` set " . $val . " where `wr_no` = '".$wr_no."' ";

						$result = $this->_query($query);


					return $result;
				}


				/**
				* 게시물 삭제
				*/
				function _delete( $bo_table, $wr_no ){

						
				}

				/**
				* 게시물 보기
				* 게시물, new 테이블 카운트 증가
				*/
				function _view( $bo_table, $wr_no, $ss_name="" ){

					global $alice, $utility;
					global $board;
						
						// 게시물 hit up
						$query = " update `" . $alice['write_prefix'] . $bo_table . "` set `wr_hit` = `wr_hit` + 1 where `wr_no` = '".$wr_no."' ";

						$result = $this->_query($query);

						// new 테이블 hit up
						$query = " update `".$this->new_table."` set `wr_hit` = `wr_hit` + 1 where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' ";

						$result = $this->_query($query);

						$utility->set_session($ss_name, TRUE);


					return $result;
						
				}


				// 회원 레이어
				function get_sideview($mb_id, $name="", $email="", $homepage=""){

					global $alice;

					$email = base64_encode($email);
					$homepage = set_http($homepage);

					$name = preg_replace("/\&#039;/", "", $name);
					$name = preg_replace("/\'/", "", $name);
					$name = preg_replace("/\"/", "&#034;", $name);
					$title_name = $name;

					if ($mb_id) {
						$tmp_name = "<span class='member'>$name</span>";

						if ($config['cf_use_member_icon']) {
							$mb_dir = substr($mb_id,0,2);
							$icon_file = "$g4[path]/data/member/$mb_dir/$mb_id.gif";

							//if (file_exists($icon_file) && is_file($icon_file)) {
							if (file_exists($icon_file)) {
								//$size = getimagesize($icon_file);
								//$width = $size[0];
								//$height = $size[1];
								$width = $config['cf_member_icon_width'];
								$height = $config['cf_member_icon_height'];
								$tmp_name = "<img src='$icon_file' width='$width' height='$height' align='absmiddle' border='0'>";

								if ($config['cf_use_member_icon'] == 2) // 회원아이콘+이름
									$tmp_name = $tmp_name . " <span class='member'>$name</span>";
							}
						}
						$title_mb_id = "[$mb_id]";
					} else {
						$tmp_name = "<span class='guest'>$name</span>";
						$title_mb_id = "[비회원]";
					}

					$name     = get_text($name);
					$email    = get_text($email);
					$homepage = get_text($homepage);

					return "<a href=\"javascript:;\" onClick=\"showSideView(this, '$mb_id', '$name', '$email', '$homepage');\" title=\"{$title_mb_id}{$title_name}\">$tmp_name</a>";
				}


				// 작성글 비회원으로 업데이트 (회원 탈퇴시 사용)
				// 회원 ID 기준
				function articles_outs( $mb_id ){

					global $board_config_control;
						

				}

				// 카운트 증가
				function hit_up( $bo_table, $wr_no ){

					global $utility;
					global $write_table;

						$ss_name = "ss_view_".$bo_table."_".$wr_no;

						if(!$_SESSION[$ss_name]){

							$result = $this->_query(" update `".$write_table."` set `wr_hit` = `wr_hit` + 1 where `wr_no` = '".$wr_no."' ");

							$this->_query(" update `".$this->new_table."` set `wr_hit` = `wr_hit` + 1 where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' ");	// alice_board_new

							$utility->set_session($ss_name, TRUE);

						} else {
							
							$result = false;

						}

					
					return $result;

				}

		}	// class end.
?>