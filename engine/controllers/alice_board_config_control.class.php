<?php
		/**
		* /application/nad/board/model/alice_board_config_control.class.php
		* @author Harimao
		* @since 2013/05/29
		* @last update 2015/03/06
		* @Module v3.5 ( Alice )
		* @Brief :: Baord Config Control Class
		* @Comment :: 게시판 환경설정 컨트롤 클래스 (게시판 메인설정, 환경설정 등)
		*/
		class alice_board_config_control extends alice_board_config_model {


				/**
				* 게시판 정보 입력
				*/
				function insert_board( $vals ){

					global $utility;

						$val = $utility->QueryString($vals);

						$query = " insert into `".$this->board_table."` set " . $val;

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 게시판 정보 수정 :: no 기준
				*/
				function update_board( $vals, $no ){

					global $utility;

						if($no=='' || !$no)
							return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->board_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 게시판 정보 삭제
				*/
				function delete_board( $no ){

					global $alice, $utility;

						$get_board = $this->get_board($no);

						$bo_table = $get_board['bo_table'];

						// 게시판 정보 삭제
						$query = " delete from `".$this->board_table."` where `no` = '".$no."' ";

						$result = $this->_query($query);

						// 게시판 최근 게시물 삭제
						//$query = " delete from `".$this->new_table."` where `bo_table` = '".$bo_table."' ";

						//$result = $this->_query($query);

						// 게시판 테이블 삭제
						$query = " drop table `alice_write_".$bo_table."` ";

						$result = $this->_query($query);

						// 게시판 디렉토리/파일 삭제
						$board_data_dir = $alice['data_board_path'] . '/' . $bo_table;

						$utility->rmdirAll($board_data_dir);


					return $result;

				}


				/**
				* 삭제 후 rank 정렬 :: code 기준
				*/
				function delete_noRank( $no, $code ){

						// rank 값 구함
						$get_rank = $this->get_board($no);

						// 삭제
						$result = $this->delete_board($no);
						
						$query = " update `".$this->board_table."` set `rank` = rank-1 where `code` = '".$code."' and `rank` > '".$get_rank['rank']."' ";

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 순위조절
				*/
				function setRank($no, $next_no){

						$get_cate = $this->get_board($no);				// 선택 no
						$next_cate = $this->get_board($next_no);	// 선택 다음 no

						$vals['rank'] = $next_cate['rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_board($vals, $no);

						$vals['rank'] = $get_cate['rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_board($vals, $next_no);
						

					return $result;

				}


				/**
				* 순위조절
				*/
				function set_b_Rank($no, $next_no){

						$get_cate = $this->get_board($no);				// 선택 no
						$next_cate = $this->get_board($next_no);	// 선택 다음 no

						$vals['b_rank'] = $next_cate['b_rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_board($vals, $no);

						$vals['b_rank'] = $get_cate['b_rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_board($vals, $next_no);
						

					return $result;

				}


				/**
				* 순위조절
				*/
				function set_m_Rank($no, $next_no){

						$get_cate = $this->get_board($no);				// 선택 no
						$next_cate = $this->get_board($next_no);	// 선택 다음 no

						$vals['m_rank'] = $next_cate['m_rank'];	// 선택 다음 no 순위 <=> 선택 no 순위
						$result = $this->update_board($vals, $no);

						$vals['m_rank'] = $get_cate['m_rank'];	// 선택 no 순위 <=> 선택 다음 no 순위
						$result = $this->update_board($vals, $next_no);
						

					return $result;

				}


				/**
				* 카테고리 에 속한 게시판 유무 :: no 기준 (count 로 넘긴다)
				*/
				function is_Codeboard( $no ){

					global $category_control;


						$get_category = $category_control->get_category($no);

						$query = " select * from `".$this->board_table."` where `code` = '".$get_category['code']."' ";

						$result = $this->_queryR($query);
						

					return $result;

				}


				/**
				* 게시판 생성 :: code 기준
				*/
				function create_Board( $bo_table ){

						$query = $this->board_scheme($bo_table);

						$result = $this->_query($query);


					return $result;

				}


				/**
				* 게시판 메인설정 정보 수정 :: no 기준
				*/
				function update_main( $vals, $no ){

					global $utility;

						if($no=='' || !$no) return false;

						$val = $utility->QueryString($vals);

						$query = " update `".$this->main_table."` set " . $val . " where `no` = '".$no."' ";

						$result = $this->_query($query);


					return $result;

				}
				


		}	// class end.

?>