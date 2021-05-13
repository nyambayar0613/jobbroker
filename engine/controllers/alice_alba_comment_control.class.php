<?php
		/**
		* /application/nad/alba/controller/alice_alba_comment_control.class.php
		* @author Harimao
		* @since 2013/10/18
		* @last update 2015/04/15
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Comment Control class
		* @Comment :: 정규직 댓글 컨트롤 클래스
		*/
		class alice_alba_comment_control extends alice_alba_comment_model {

				/**
				* 댓글 등록
				*/
				function comment_insert( $vals ){

					global $alice, $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `" . $this->comment_table . "` set " . $val;

						$result = $this->_query($query);


					return $result;
				}


				/**
				* 댓글 수정
				*/
				function comment_update( $vals, $wr_no ){

					global $alice, $utility;

						$val = $utility->QueryString($vals);

						$query = " update `" . $this->comment_table . "` set " . $val . " where `wr_no` = '".$wr_no."' ";

						$result = $this->_query($query);


					return $result;
				}


				/**
				* 댓글 삭제
				*/
				function comment_delete( $wr_no, $is_admin=false, $is_reply=false ){

						if(!$wr_no || $wr_no=='') return false;


						$parent_query = " select * from `".$this->comment_table."` where `wr_parent` = '".$wr_no."' ";
						
						$parent_cnt = $this->_queryR($parent_query);


						if($is_admin){	// 하위 댓글까지 모두 삭제 한다.

							if($is_reply){

								$this->_query(" delete from `".$this->comment_table."` where `wr_parent` = '".$wr_no."' ");

								$result = $this->_query(" delete from `".$this->comment_table."` where `wr_no` = '".$wr_no."' ");

							} else {

								$this->_query(" delete from `".$this->comment_table."` where `wr_parent` = '".$wr_no."' ");

								$result = $this->_query(" delete from `".$this->comment_table."` where `wr_num` = '".$wr_no."' ");

							}
							
						} else {

							if($parent_cnt){	// 댓글이 있다면 바로 삭제하지 않고, 삭제된 댓글로 표기한다

								$vals['wr_del'] = 1;

								$query = " update `".$this->comment_table."` set `wr_del` = 1 where `wr_no` = '".$wr_no."' ";

							} else {
								
								$query = " delete from `".$this->comment_table."` where `wr_no` = '".$wr_no."' ";

							}

							$result = $this->_query($query);

						}


					return $result;
		
				}

		}	// class end.
?>