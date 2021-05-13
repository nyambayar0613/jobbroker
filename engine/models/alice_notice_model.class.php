<?php
		/**
		* /application/nad/board/model/alice_notice_model.class.php
		* @author Harimao
		* @since 2013/05/28
		* @last update 2013/08/19
		* @Module v3.5 ( Alice )
		* @Brief :: Notice Model Class
		* @Comment :: Notice (공지사항) 모델 클래스
		*/
		class alice_notice_model extends DBConnection {

			var $notice_table		= "alice_notice";
			var $success_code = array(
					'0000' => '공지사항이 입력되었습니다.',
			);
			var $fail_code = array(
					'0000' => '공지사항 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '삭제할 공지사항이 없거나 이미 삭제된 공지사항 입니다.',
					'0002' => '공지사항 내용을 입력해 주세요.',
			);


				function __NoticeList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search();

						$query = " select * from `".$this->notice_table."` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/* 질의문 확인
						echo "<div style='color:#fff;'>";
						echo $query;
						echo "</div><br/>";
						*/

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				// Notice 정보 추출(단수) :: no 기준
				function get_notice( $no ){

						if(!$no || $no=='') return false;

						$query = " select * from `".$this->notice_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 건수당 리스팅
				function get_notice_list_count( $count, $order=" `no` desc " ){

						$query = " select * from `".$this->notice_table."` order by " . $order . " limit " . $count;

						$result = $this->query_fetch_rows($query);

					
					return $result;

				}


				// Notice 검색
				function _Search(){

					global $utility, $config;

						$page = $_GET['page'];
						
						$order = " `no` ";

						$sort = $_GET['sort'];	 // 정렬 기준
						
						if($sort) $order = " `".$sort."` ";
						
						$flag = $_GET['flag'];	 // 정렬 순서
						
						$order .= ($flag) ? $flag : " desc ";

						$mode = $_GET['mode'];
						if($_POST['mode']){	// 검색 방식 유효성 검사
							$utility->popup_msg_js($config->_errors('0031'));
							exit;
						}

						// notice 등록일
						$start_dayAll = $_GET['start_dayAll'];
						$start_day = $_GET['start_day'];
						$end_day = $_GET['end_day'];

						$wr_type = $_GET['wr_type'];	// 카테고리

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드

						$que = array();
						$url = array();


						## 분류(카테고리) 검색 ########################################################################################
						if($wr_type){	 // 값이 존재하는 경우에만
							array_push( $que, " `wr_type` = '".$wr_type."' " );
							array_push( $url, "wr_type=" . urlencode($wr_type) );
						} else {
							array_push( $url, "wr_type=" . urlencode($wr_type) );
						}
						## //분류(카테고리) 검색 ########################################################################################

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							## notice 등록일 검색 #########################################################################################
							if(!$start_dayAll){	// 전체가 아닐 경우에만

								// 두 값이 모두 다 있는 경우
								if( $start_day!='' && $end_day!='' ) {		// start_day && end_day

									array_push( $que, " ( `wr_date` between '".$start_day." 00:00:00' and '".$end_day." 23:59:59' ) " );
									array_push( $url, "start_day=" . urlencode($start_day) . "&end_day=" . urlencode($end_day) );

								// 두 값이 모두 다 없고 둘중 하나만 있는 경우
								} else {

									if( $start_day!='' ) {		// start_day
										array_push( $que, " `wr_date` >= '".$start_day."' " );
										array_push( $url, "start_day=" . urlencode($start_day) );
									}

									if( $end_day!='' ) {		// end_day
										array_push( $que, " `wr_date` <= '".$end_day."' " );
										array_push( $url, "end_day=" . urlencode($end_day) );	
									}

								}

							}
							## //notice 등록일 검색 #######################################################################################

							## 필드선택에 따른 검색 #######################################################################################
							if(!$search_field){	// 통합검색 일때

								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que  = " ( ";
									$search_que .= " INSTR(LOWER(`wr_subject`), LOWER('".$search_keyword."'))";	// 제목
									$search_que .= " or INSTR(LOWER(`wr_content`), LOWER('".$search_keyword."'))";	// 내용
									$search_que .= " or INSTR(LOWER(`wr_name`), LOWER('".$search_keyword."'))";	// 작성자
									$search_que .= " ) ";
								} else {
									$search_que  = " ( ";
									$search_que .= " INSTR(`wr_subject`, '".$search_keyword."')";
									$search_que .= " or INSTR(`wr_content`, '".$search_keyword."')";
									$search_que .= " or INSTR(`wr_name`, '".$search_keyword."')";
									$search_que .= " ) ";
								}

								array_push($url, "search_field=&search_keyword=" . $search_keyword);

							} else {	 // 필드 선택

								$tmp = array();
								$tmp = explode(",", trim($search_field));
								$field = explode("||", $tmp[0]);	// 제목+내용 검색 때문에 || 를 기준으로 자른다
								$not_comment = $tmp[1];
								$field_cnt = count($field);

								$search_que = "";

								for ($i=0; $i<$field_cnt; $i++) { // 필드의 수만큼 다중 필드 검색 가능 (필드1+필드2...)

									// SQL Injection 방지
									// 필드값에 a-z A-Z 0-9 _ , | 이외의 값이 있다면 검색필드를 wr_subject 로 설정한다.
									$field[$i] = preg_match("/^[\w\,\|]+$/", $field[$i]) ? $field[$i] : "wr_subject";
									
									if (preg_match("/[a-zA-Z]/", $search_keyword)){
										$search_que .= "INSTR(LOWER(`".$field[$i]."`), LOWER('".$search_keyword."'))";
									} else {
										$_and = ($i>0)?" or ":"";
										$search_que .= $_and . " INSTR(`".$field[$i]."`, '".$search_keyword."') ";
									}

								}

								array_push($url, "search_field=" . urlencode($search_field) . "&search_keyword=" . urlencode($search_keyword));
							}

							array_push($que, $search_que);
							## //필드선택에 따른 검색 #####################################################################################

						}


						array_push($url, 'page='.$page);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que ? " where ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';

					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

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