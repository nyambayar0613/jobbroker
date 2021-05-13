<?php
		/**
		* /application/main/model/alice_search_control.class.php
		* @author Harimao
		* @since 2013/10/24
		* @last update 2013/10/30
		* @Module v3.5 ( Alice ) - b1.0
		* @Brief :: Search Control Class
		* @Comment :: 통합/상세 검색 컨트롤 클래스
		*/
		class alice_search_control extends alice_search_model {


				/**
				* 검색어 입력
				*/
				function insert_search( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->search_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}

				/**
				* 검색어 수정
				*/
				function update_search( $vals, $no ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->search_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}

				/**
				* 검색어 삭제
				*/
				function delete_search( $no ){

					global $utility;

						$query = " delete from `".$this->search_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 삭제 후 rank 정렬 :: no 기준
				*/
				function delete_noRank( $no, $type ){

						if(!$no || !$type) return false;

						// rank 값 구함
						$get_rank = $this->get_search_once($no);

						// 삭제
						$result = $this->delete_search($no);
						
						$query = " update `".$this->search_table."` set `rank` = rank-1 where `wr_type` = '".$type."' and `rank` > '".$get_rank['rank']."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 순위조절
				*/
				function setRank($type, $no, $next_no){

						$get_search = $this->get_search_once($no);				// 선택 no
						$next_search = $this->get_search_once($next_no);		// 선택 다음 no

						$vals['rank'] = $next_search['rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_search($vals, $no);

						$vals['rank'] = $get_search['rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_search($vals, $next_no);
						

					return $result;

				}

				
				/**
				* 검색 결과 페이지에서 검색어 DB 입력
				*/
				function search_result( $keyword, $type="" ){

						if(!$keyword) return false;

						//$search_query = $this->query_fetch(" select * from `".$this->search_table."` where INSTR(LOWER(`wr_content`), LOWER('".$keyword."')) ");
						  $type_con = $type ? " and `wr_type` = '".$type."'" : "";
						  $search_query = $this->query_fetch(" select * from `".$this->search_table."` where wr_content = '".$keyword."'".$type_con);

						if($search_query){	 // 기존 데이터가 있다면 hit up

							$query = " update `".$this->search_table."` set `wr_hit` = `wr_hit` + 1, `wr_udate` = now() where `no` = '".$search_query['no']."' ";

						} else {	 // 없다면 insert

							$get_LastRank = $this->get_MaxRank($type);

							$rank = $get_LastRank + 1;

							$query = " insert into `".$this->search_table."` set `rank` = '".$rank."', `wr_type` = '".$type."', `wr_content` = '".$keyword."', `wr_wdate` = now() ";

						}

						$result = $this->_query($query);

					
					return $result;

				}


		}	// class end.
?>