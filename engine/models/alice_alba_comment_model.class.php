<?php
		/**
		* /application/nad/alba/model/alice_alba_user_model.class.php
		* @author Harimao
		* @since 2013/10/18
		* @last update 2013/10/21
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Comment Model class
		* @Comment :: 정규직 댓글 모델 클래스
		*/
		class alice_alba_comment_model extends DBConnection {

			var $comment_table		= "alice_comment";

			var $success_code = array(
					'0000' => '',
			);
			var $fail_code = array(
					'0000' => '코멘트를 입력해 주세요.',
					'0001' => '댓글은 회원만 작성 가능합니다.',
					'0002' => '너무 빠른 시간내에 게시물을 연속해서 올릴수 없습니다.',
					'0003' => '동일한 내용을 연속해서 등록할 수 없습니다.',
					'0004' => '공고가 존재하지 않습니다.\\n\\n공고가 삭제되었을수 있습니다.',
					'0005' => '답변할 댓글이 없습니다.\\n\\n답변하는 동안 코멘트가 삭제되었을 수 있습니다.',
					'0006' => '더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.',
					'0007' => '더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.',
					'0008' => '자신의 글이 아니므로 수정할 수 없습니다.',
					'0009' => '이 코멘트와 관련된 답변코멘트가 존재하므로 수정 할 수 없습니다.',
					'0010' => '댓글 삭제중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요',
			);


				// 기본 댓글 리스팅
				function __CommentList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->comment_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						//echo "<p><br/><strong>Query :: " . $query."</strong><br/><br/></p>";	// 쿼리 확인

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// 댓글 검색
				function _Search( ){

					global $utility, $config;
					global $category_control;

						$mode = $_GET['mode'];

						$type = $_GET['type'];

						$page = $_GET['page'];

						$page_rows = $_GET['page_rows'];

						$order = " wr_comment, wr_comment_reply ";

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드


						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

						}


						array_push($url, 'page='.$page);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}


				// 동일 내용 여부
				function is_dupplicate( $mode, $comment_id, $wr_subject, $wr_content ){

					global $is_admin;

						$result = false;

						$query = " select MD5(CONCAT(wr_ip, wr_subject, wr_content)) as prev_md5 from `".$this->comment_table."` ";

						if($mode=='update') {

							$query .= " where `wr_no` <> '".$comment_id."' ";

						}

						$query .= " order by `wr_no` desc limit 1 ";

						$row = $this->query_fetch($query);

						$curr_md5 = md5($_SERVER['REMOTE_ADDR'].$wr_subject.$wr_content);

						if($row['prev_md5'] == $curr_md5 && $mode != 'update' && !$is_admin){

							$result = true;

						}


					return $result;

				}

				// 코멘트 정보 추출 (단수) :: wr_no 기준
				function get_comment( $wr_no ){

						if(!$wr_no || $wr_no=='') return false;

						$query = " select * from `".$this->comment_table."` where `wr_no` = '".$wr_no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 공고별 코멘트 리스팅
				function get_alba_comment_list( $page="", $page_rows="" ){

					global $alba_control;


						$query = " select DISTINCT `wr_num` from `".$this->comment_table."` order by `wr_no` desc ";

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						$wr_num_query = $this->query_fetch_rows($query);


						$result = array();

						$i = 0;
						foreach($wr_num_query as $val){

							$alba_query = $this->query_fetch(" select * from `".$alba_control->alba_table."` where `no` = '".$val['wr_num']."' ");
							$count_query = $this->_queryR(" select * from `".$this->comment_table."` where `wr_num` = '".$val['wr_num']."' ");

							$result['alba_list'][$i] = $alba_query;
							$result['alba_list'][$i]['comment_count'] = $count_query;

						$i++;
						}

					
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