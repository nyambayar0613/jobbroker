<?php
		/**
		* /application/nad/config/controller/alice_category_control.class.php
		* @author Harimao
		* @since 2013/05/26
		* @last update 2013/08/28
		* @Module v3.5 ( Alice )
		* @Brief :: Category Control class
		* @Comment :: 카테고리 컨트롤 클래스
		*/
		class alice_category_control extends alice_category_model {


				/**
				* 카테고리 정보 입력
				*/
				function insert_category( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->cate_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 카테고리 정보 수정
				*/
				function update_category( $vals, $no ){

					global $utility;
						
						if(!$no || $no=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->cate_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 카테고리 정보 삭제
				*/
				function delete_category( $no ){

					global $utility;

						$query = " delete from `".$this->cate_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

				/**
				* 카테고리 정보 삭제 ( code 기준 )
				*/
				function delete_categories_code( $type, $code ){

					global $utility;

						if(!$type || !$code) return false;

						$query = " delete from `".$this->cate_table."` where `type` = '".$type."' and `code` = '".$code."' ";

						$result = $this->_query($query);


					return $result;

				}

				/**
				* 카테고리 정보 삭제 ( p_code 기준 )
				*/
				function delete_categories_pcode( $type, $p_code ){

					global $utility;

						if(!$type || !$code) return false;

						$query = " delete from `".$this->cate_table."` where `type` = '".$type."' and `p_code` = '".$p_code."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 삭제 후 rank 정렬 :: no 기준
				*/
				function delete_noRank( $no, $type ){

						if(!$no || !$type) return false;

						// rank 값 구함
						$get_rank = $this->get_category($no);

						// 삭제
						$result = $this->delete_category($no);

						$_add = ($type=='mb_level') ? " and `rank` != 1 " : "";	 // 레벨 설정의 경우 1 레벨은 패스~
						
						$query = " update `".$this->cate_table."` set `rank` = rank-1 where `type` = '".$type."' and `p_code` = '".$get_rank['p_code']."' and `rank` > '".$get_rank['rank']."' " . $_add;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 순위조절
				*/
				function setRank($type, $no, $next_no){

						$get_cate = $this->get_category($no);				// 선택 no
						$next_cate = $this->get_category($next_no);	// 선택 다음 no

						$vals['rank'] = $next_cate['rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_category($vals, $no);

						$vals['rank'] = $get_cate['rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_category($vals, $next_no);
						

					return $result;

				}

				
				/**
				* hit 수 조절 (category code 기준)
				*/
				function hit_up_code( $code, $pattern="+", $count=1 ){

					global $utility;

						if($code) return false;

						$query = " update `".$this->cate_table."` set `hit` = `hit` ".$pattern." ".$count." where `code` = '".$code."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* hit 수 조절 (category no 기준)
				*/
				function hit_up_no( $no, $pattern="+", $count=1 ){

					global $utility;

						if($no) return false;

						$query = " update `".$this->cate_table."` set `hit` = `hit` ".$pattern." ".$count." where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* type 을 기준으로 카테고리 정보 일괄 수정
				*/
				function update_types( $vals, $type ){

					global $utility;
						
						if(!$type || $type=='') return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->cate_table."` set " . $val . " where `type` = '".$type."' ";

						$result = $this->_query($query);


					return $result;

				}


		}	// class end.
?>