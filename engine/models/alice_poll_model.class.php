<?php
		/**
		* /application/nad/board/model/alice_poll_model.class.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/10/31
		* @Module v3.5 ( Alice ) - p1.0
		* @Brief :: Poll Model Class
		* @Comment :: Poll (설문조사) 모델 클래스
		*/
		class alice_poll_model extends DBConnection {

			var $poll_table					= "alice_poll";
			var $poll_comment_table	= "alice_poll_comment";

			var $success_code = array(
					'0000' => '설문조사 등록 완료',
					'0001' => '설문조사 수정 완료',
					'0006' => '설문조사 사용 설정이 변경되었습니다.',
					'0007' => '설문조사 메인 출력 설정이 변경되었습니다.',
					'0008' => '투표가 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '설문조사 등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '설문조사 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '설문조사 투표중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '설문조사 제목을 입력해 주세요.',
					'0004' => '설문조사 항목은 최소 2개 이상이어야 합니다.',
					'0005' => '삭제할 설문조사가 없거나 이미 삭제된 설문조사 입니다.',
					'0006' => '설문조사 사용 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0007' => '설문조사 메인 출력 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0008' => '회원만 투표 가능합니다.',
					'0009' => '이미 투표하셨습니다.',
			);
				function __PollList( $page="", $page_rows="", $con="" ){

						$query = " select * from `".$this->poll_table."` " . $con . " order by `no` desc ";

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
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// POLL 정보 추출(단수) :: no 기준
				function get_poll( $no ){

						$query = " select * from `".$this->poll_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// POLL 정보 추출 where 기준 (단수)
				function get_polls( $_add="" ){

						$query = " select * from `".$this->poll_table."` " . $_add;

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// POLL 정보 출력 (메인 출력)
				function print_polls( $limit ){

						if($limit=='' || !$limit)	 // query 오류를 막자
							return false;

						// 출력 중이며, 메인에 출력 체크한거
						$query = " select * from `".$this->poll_table."` where `use` = 1 and `view_main` = 1 limit " . $limit;

						$result = $this->query_fetch($query);

					
					return $result;

				}

				
				// POLL 댓글 리스트 추출
				function __PollcommentList( $page="", $page_rows="", $con="" ){

						$query = " select * from `".$this->poll_comment_table."` " . $con . " order by `no` desc ";

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
						
						//echo $query."<br/>";

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// POLL 코멘트 정보 추출(단수) :: no 기준
				function get_pollComment( $no ){

						$query = " select * from `".$this->poll_comment_table."` where `no` = '".$no."' ";

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