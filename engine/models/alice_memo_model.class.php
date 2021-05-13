<?php
		/**
		* /application/nad/member/model/alice_memo_model.class.php
		* @author Harimao
		* @since 2015/03/16
		* @last update 2015/04/06
		* @Module v3.5 ( Alice )
		* @Brief :: Memo Model Class
		* @Comment :: 쪽지 모델 클래스
		*/
		class alice_memo_model extends DBConnection {

			var $memo_table	= "alice_memo";

			var $success_code = array (
					'0000' => '쪽지 설정이 완료 되었습니다.',
					'0001' => '쪽지 발송이 완료 되었습니다.',
					'0002' => '쪽지가 발송되었습니다.',
					'0003' => '쪽지 삭제가 완료 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '쪽지 발송중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '쪽지 설정중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '쪽지 발송중 오류가 발생하였습니다.',
					'0003' => '쪽지 발송중 오류가 발생하였습니다.\\n\\n사이트 운영자에게 문의하세요.',
					'0004' => '쪽지 삭제중 오류가 발생하였습니다.\\n\\n사이트 운영자에게 문의하세요.',
					'0005' => '쪽지 삭제중 오류가 발생하였습니다..\\n\\najax 오류나 encoding 오류 일수 있습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);


				/**
				* 쪽지 리스팅
				*/
				function __MemoList( $page="", $page_rows="", $type="", $con="" ){
					
					global $alice;
					global $member_control;

						switch($type){

							// 받은쪽지
							case 'receve':
								$query = " select a.*, b.mb_id, b.mb_nick, b.mb_email, b.mb_homepage from `".$this->memo_table."` a left join `".$member_control->member_table."` b on (a.wr_send_mb_id = b.mb_id) ".$con." order by a.no desc ";
							break;

							// 미확인쪽지
							case 'viewed':
								$query = " select * from `".$this->memo_table."` " . $con . " order by no desc ";
							break;
							
							// 보낸쪽지
							case 'send':
								$query = " select a.*, b.mb_id, b.mb_nick, b.mb_email, b.mb_homepage from `".$this->memo_table."` a left join `".$member_control->member_table."` b on (a.wr_recv_mb_id = b.mb_id) ".$con." order by a.no desc ";
							break;

							// 기본 :: 관리자 리스팅
							default:
								$query = " select * from `".$this->memo_table."`  " . $con . " order by `no` desc ";
							break;

						}

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						
						//echo $query."<br/>";


						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				/**
				* 쪽지 내용
				*/
				function get_memo( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->memo_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				/**
				* 쪽지 내용 (확장)
				*/
				function get_memo_extend( $con="" ){

						$query = " select * from `".$this->memo_table."` " . $con;

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