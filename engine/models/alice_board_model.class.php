<?php
		/**
		* /application/nad/board/model/alice_board_model.class.php
		* @author Harimao
		* @since 2013/05/29
		* @last update 2015/03/30
		* @Module v3.5 ( Alice )
		* @Brief :: Baord Model Class
		* @Comment :: 게시판 모델 클래스
		*/
		class alice_board_model extends DBConnection {

			var $board_table	= "alice_board";				// 게시판 정보
			var $file_table		= "alice_board_file";		// 게시판 첨부 파일 목록
			var $new_table		= "alice_board_new";		// 게시판 최신글
			var $good_table		= "alice_board_good";	// 게시판글 추천/비추천
			var $report_table	= "alice_board_report";	// 게시판글 신고 목록

			var $success_code = array(
					'0000' => '게시글 입력이 완료 되었습니다.',
					'0001' => '댓글이 삭제 되었습니다.',
			);
			var $fail_code = array(
					'0000' => '게시글 입력중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => '게시글 수정중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '게시글 삭제중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0003' => '파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0004' => '내용에 올바르지 않은 코드가 다수 포함되어 있습니다.',
					'0005' => '제목을 입력해 주세요.',
					'0006' => '관리자 페이지는 관리자만 글 작성이 가능합니다.',
					'0007' => '첨부파일이 존재하지 않습니다.',
					'0008' => '글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동하였을 수 있습니다.',
					'0009' => '공지사항은 관리자만 작성 가능합니다.',
					'0010' => '게시글 답변중 오류가 발생했습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0011' => '공지에는 답변 할 수 없습니다.',
					'0012' => '더 이상 답변하실 수 없습니다.\\n\\n답변은 10단계 까지만 가능합니다.',
					'0013' => '더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.',
					'0014' => '삭제할 데이터가 없거나 이미 삭제된 데이터 입니다.',
					'0015' => '이 글과 관련된 답변글이 존재하므로 삭제 할 수 없습니다.\\n\\n우선 답변글부터 삭제하여 주십시오.',
					'0016' => '이 글과 관련된 코멘트가 존재하므로 삭제 할 수 없습니다.\\n\\n코멘트를 먼저 삭제해 주세요.',
					'0017' => '회원만 접근 가능합니다.',
					'0018' => '목록을 볼 권한이 없습니다.',
					'0019' => '존재하지 않는 게시판 입니다.',
					'0020' => 'bo_table 값이 넘어오지 않았습니다.\\n\\nboard.php?bo_table=code 와 같은 방식으로 넘겨 주세요.',
					'0021' => '글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동된 경우입니다.',
					'0022' => '글을 읽을 권한이 없습니다.',
					'0023' => '글을 읽을 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보세요.',
					'0024' => '목록을 볼 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보세요.',
					'0025' => '글쓰기에는 wr_no 값을 사용하지 않습니다.',
					'0026' => '글을 쓸 권한이 없습니다.',
					'0027' => '글을 쓸 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보세요.',
					'0028' => '글을 답변할 권한이 없습니다.',
					'0029' => '정상적인 접근이 아닌것 같습니다.',
					'0030' => '비밀글에는 자신 또는 관리자만 답변이 가능합니다.',
					'0031' => '비회원의 비밀글에는 답변이 불가합니다.',
					'0032' => '파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0033' => '동일한 내용을 연속해서 등록할 수 없습니다.',
					'0034' => '비밀글 미사용 게시판 이므로 비밀글로 등록할 수 없습니다.',
					'0035' => '너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.',
					'0036' => '자신의 글이 아니므로 수정할수 없습니다.',
					'0037' => '비밀번호(패스워드)가 일치하지 않습니다.',
					'0038' => '이름은 필히 입력하셔야 합니다.',
					'0039' => '토큰 에러로 삭제 불가합니다.',
					'0040' => '자신의 글이 아니므로 삭제할수 없습니다.',
					'0041' => '로그인 후 삭제하세요.',
					'0042' => '패스워드가 틀리므로 삭제할 수 없습니다.',
					'0043' => '이 글과 관련된 답변글이 존재하므로 수정 할 수 없습니다.',
					'0044' => '글을 수정할 권한이 없습니다.',
					'0045' => '글을 수정할 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보세요.',
					'0046' => '회원만 추천 가능합니다.',
					'0047' => '값이 제대로 넘어오지 않았습니다.',
					'0048' => '해당 게시물에서만 추천 또는 비추천 하실 수 있습니다.',
					'0049' => '게시판이 존재하지 않습니다.',
					'0050' => '자신의 글에는 추천 또는 비추천 하실 수 없습니다.',
					'0051' => '이 게시판은 추천 기능을 사용하지 않습니다.',
					'0052' => '이 게시판은 비추천 기능을 사용하지 않습니다.',
					'0053' => '비밀번호(패스워드)를 입력해 주세요.',
					'0054' => '코멘트를 쓸 권한이 없습니다.',
					'0055' => '답변할 코멘트가 없습니다.\\n\\n답변하는 동안 코멘트가 삭제되었을 수 있습니다.',
					'0056' => '더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.',
					'0057' => '코멘트 작성중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0058' => '이 코멘트와 관련된 답변코멘트가 존재하므로 수정 할 수 없습니다.',
					'0059' => '코멘트 수정중 오류가 발생하였습니다.\\n\\n사이트 관리자에게 문의하세요.',
					'0060' => '등록된 코멘트가 없거나 코멘트 글이 아닙니다.',
					'0061' => '패스워드가 틀립니다.',
					'0062' => '다운로드 권한이 없습니다.',

			);


				// DB 에서 각 테이블별 데이터 추출
				function __BoardList( $bo_table, $page="", $page_rows="", $con="" ){

					global $alice, $utility;
					global $board;

						// 검색시 사용
						$_add = $this->_Search();

						$query = " select * from `" . $alice['write_prefix'] . $bo_table . "` " . $con . $_add['que'] . " order by " . $_add['order'];

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
						$result['q'] = $query;

					
					return $result;


				}

				// 게시판 내용 추출 (단수)
				function get_boardArticle( $bo_table, $con="" ){

					global $alice;

						$query = " select * from `" . $alice['write_prefix'] . $bo_table . "` " . $con;

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 게시판 필드별 건수 검색
				function get_boardArticle_cnt( $bo_table, $con="" ){

					global $alice;

						$query = " select * from `" . $alice['write_prefix'] . $bo_table . "` " . $con;

						$result = $this->_queryR($query);

					
					return $result;
				}

				// 게시판 내용 추출 :: wr_no 기준 (단수)
				function get_wrNo( $write_board, $wr_no ){

					global $alice;

						$query = " select * from `" . $write_board . "` where `wr_no` = '".$wr_no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 게시판별 게시물 리스트
				function get_list( $write_row, $board, $skin_path='', $subject_len=40 ){

					global $alice, $utility;
					global $is_member, $is_admin;
					global $member_control;

						$list = $write_row;
						unset($write_row);
						
						$get_member = $member_control->get_member($list['wr_id']);

						$list['code'] = $board['code'];
					    $list['is_notice'] = preg_match("/[^0-9]{0,1}{$list['wr_no']}[\r]{0,1}/",$board['bo_notice']);
						
						//$list['declare'] = $this->query_fetch(" select * from `".$this->report_table."` where `bo_table` = '".$board['bo_table']."' and `wr_no` = '".$list['wr_no']."' ");
						
						if($list['wr_del']){
							$list['subject'] = "<span style='color:#d3d3d3; font-size:11px;'> * 삭제된 게시물 입니다.</span>";
							$list['content'] = "* 이 게시물은 [".$list['wr_last']."] 에 삭제 되었습니다.";
						} else {
							if($subject_len){
								$list['subject'] = stripslashes($utility->conv_subject($list['wr_subject'], $subject_len, "…"));
							} else {
								$list['subject'] = stripslashes($list['wr_subject']);
							}
							$list['content'] = stripslashes($list['wr_content']);
						}

						// 댓글 건수
						$list['comment_cnt'] = number_format($list['wr_comment']);

						// 당일인 경우 시간으로 표시함
						$list['datetime'] = substr($list['wr_datetime'],0,10);
						$list['datetime2'] = $list['wr_datetime'];
						
						$list['datetime3'] = $list['wr_datetime'];

						if($list['datetime'] == date("Y-m-d", $alice['server_time']))
							$list['datetime2'] = substr($list['datetime2'],11,5);
						else
							$list['datetime2'] = substr($list['datetime2'],0,10);
					

						$list['last'] = substr($list['wr_last'],0,10);
						$list['last2'] = $list['wr_last'];

						if($list['last'] == date("Y-m-d", $alice['server_time']))
							$list['last2'] = substr($list['last2'],11,5);
						else
							$list['last2'] = substr($list['last2'],5,5);


						$list['wr_homepage'] = $utility->get_text(addslashes($list['wr_homepage']));

						$tmp_name = $utility->get_text($utility->str_cut($list['wr_name'], $board['bo_cut_name'] * 2)); // 설정된 자리수 만큼만 이름 출력 (UTF-8로 계산하기 때문에 X 2)

						// 0 : 닉네임, 1 : 아이디, 2 : 이름, 3 : 익명
						if($board['bo_use_name']=='0'){
							$list['name'] = $tmp_name;
						} else if($board['bo_use_name']=='1'){
							$list['name'] = $list['wr_id'];
						} else if($board['bo_use_name']=='2'){
							$list['name'] = ($get_member['mb_name']) ? $get_member['mb_name'] : $tmp_name;
						} else if($board['bo_use_name']=='3'){
							$list['name'] = "익명";
						}

						/*
						$list['name'] = $tmp_name;
						$use_name = explode(',',$board['bo_use_name']);
						$list['id'] = (@in_array('id',$use_name)) ? "(".$list['wr_id'].")" : "";
						*/


						$reply = $list['wr_reply'];

						$list['reply'] = "";
						if (strlen($reply) > 0) {
							for ($k=0; $k<strlen($reply); $k++)
								$list['reply'] .= ' &nbsp;&nbsp; ';
						}

						$list['icon_reply'] = "";
						if ($list['reply'])
							$list['icon_reply'] = "<img src='".$alice['images_path']."/ic/reply.gif'/>";

						$list['icon_link'] = "";
						if($list['wr_link1'] || $list['wr_link2'])
							$list['icon_link'] = "<img src='".$skin_path."/board/img/icon_link.png' align='absmiddle'>";

						if (strstr($search_field, "content")) {
							$search_keyword = trim($_GET['search_keyword']);
							$list['content'] = $utility->search_font($search_keyword, $list['content']);
						}

						// QUERY_STRING
						$qstr = "";
						if($_GET['mode']) $qstr .= 'mode=' . $mode;	// mode
						if($_GET['code']) $qstr .= '&code=' . $code;	// code
						if($_GET['bo_table']) $qstr .= '&bo_table=' . $bo_table;	// bo_table
						if($_GET['search_field']) $qstr .= '&search_field=' . $search_field;	// search_field
						if($_GET['search_keyword']) $qstr .= '&search_keyword=' . $search_keyword;	// search_keyword
						if($_GET['page']) $qstr .= '&page=' . $page;	// page
						if($_GET['page_rows']) $qstr .= '&page_rows=' . $page_rows;	// page_rows
						//if($_GET['sca']) $qstr .= '&sca=' . $sca;	// sca

						// 분류명 링크
						//$list['ca_name_href'] = "?" . $qstr . "&sca=".urlencode($list['wr_category']);
						//$list['ca_name'] = $get_category['name'];

						$list['href'] = $alice['board_path']."/board.php?board_code=".$board_code."&code=".$code."&bo_table=".$board['bo_table']."&wr_no=".$list['wr_no'].$qstr;
						$list['href_link'] = "board.php?board_code=".$board_code."&code=".$code."&bo_table=".$board['bo_table']."&wr_no=".$list['wr_no'].$qstr;

						if($board['bo_use_comment']){
							$board_code = $_GET['board_code'];
							$list['comment_href'] = $_board . "board.php?board_code=".$board_code."&bo_table=" . $board['bo_table'] . "&wr_no=".$list['wr_no'].'&cwin=1';
						} else {
							$list['comment_href'] = $list['href'];
						}

						$list['icon_new'] = false;
						if($list['wr_datetime'] >= date("Y-m-d H:i:s", $alice['server_time'] - ($board['bo_new'] * 3600))){
							$list['icon_new'] = ($list['wr_del']) ? false : true;
						}

						$list['icon_img'] = false;
						//$wr_content = stripslashes($list['wr_content']);
						$wr_content = $utility->conv_content( $list['wr_content'], 1 );		// editor 값 고정
						preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $wr_content, $icon_img);

						if($icon_img[1]){
							$image_info = pathinfo($icon_img[1]);	// 이미지 정보
							$cimg = $alice['data_board_path'] . '/' . $board['bo_table'] . '/150/' . $image_info['basename'];
						} else {
							$cimg = "../images/comn/b.gif";
						}

						if( $icon_img[0] ){
							$list['icon_img'] = true;
							$list['content_img'] = $icon_img[1];
						}

						$list['icon_secret'] = false;
						if ($list['wr_secret'])
							$list['icon_secret'] = true;

						$list['hit'] = number_format($list['wr_hit']);	// hit count

						$list['code'] = $board['code'];			// 게시판 상위 code
						$list['board'] = $board['bo_table'];	// 게시판 table 명

						// 가변 파일
						$list['file'] = $this->get_file($board['bo_table'], $list['wr_no']);

						$list['icon_file'] = false;
						if($list['file']['count'])
							$list['icon_file'] = ($list['wr_del']) ? false : true;


					return $list;

				}


				// 게시글 내용 보기
				function get_view( $bo_table, $wr_no ){

					global $alice, $utility, $board;	// 환경설정 관련
					global $member, $users, $is_member, $is_admin;	// 회원 관련
					global $category_control, $admin_control;	// 컨트롤 객체
					global $member_control;

						$search_field = $_GET['search_field'];
						$search_keyword = $_GET['search_keyword'];
					
						$write = $this->_get( $bo_table, $wr_no );	// 게시글 정보

						$get_category = $category_control->get_categoryCode($write['wr_category']);	// 카테고리 정보

						// 배열전체를 복사
						$view = $write;
						unset($write);

						$view['category'] = ($board['bo_use_category']!='' && $view['wr_category']!='') ? "[".stripslashes($get_category['name'])."]" : '';		// 카테고리
						
						$tmp_name = $utility->get_text($utility->str_cut($view['wr_name'], $board['bo_cut_name'] * 2)); // 설정된 자리수 만큼만 이름 출력 (UTF-8로 계산하기 때문에 X 2)

						$get_member = $member_control->get_member($view['wr_id']);

						// 0 : 닉네임, 1 : 아이디, 2 : 이름, 3 : 익명
						if($board['bo_use_name']=='0'){
							$view['name'] = $tmp_name;
						} else if($board['bo_use_name']=='1'){
							$view['name'] = $view['wr_id'];
						} else if($board['bo_use_name']=='2'){
							$view['name'] = ($get_member['mb_name']) ? $get_member['mb_name'] : $tmp_name;
						} else if($board['bo_use_name']=='3'){
							$view['name'] = "익명";
						}

						//$view['name'] = $tmp_name;

						$use_name = explode(',',$board['bo_use_name']);
						$view['id'] = (in_array('id',$use_name)) ? "(".$view['wr_id'].")" : $view['name'];

						$view['mb_level'] = ($member) ? $member['mb_level'] : $admin_infos['level'];// 작성자 레벨
						$view['hit'] = $view['wr_hit'];		// 조회수

						$view['option'] = $view['wr_option'];

						// 등록일
						$view['datetime'] = substr($view['wr_datetime'],0,10);
						$view['datetime2'] = $view['wr_datetime'];
						$view['last'] = substr($view['wr_last'],0,10);
						$view['last2'] = $view['wr_last'];
						$wdate = explode(' ',$view['datetime2']);
						$view['wdate'] = $wdate[0];
						
						// 가변 파일
						$view['file'] = $this->get_file($bo_table, $wr_no);

						if($view['wr_del']){	 // 삭제된 게시물 취급
							$view['subject'] = "* 삭제된 게시물 입니다.";
							$view['content'] = "* 이 게시물은 [".$view['wr_last']."] 에 삭제 되었습니다.";
						} else {
							$view['subject'] = stripslashes($view['wr_subject']);		// 제목
							$view['content'] = stripslashes($utility->conv_content( $view['wr_content'], 1 ));		// editor 값 고정
							if (strstr($search_field, "content"))
								$view['content'] = $utility->search_font($search_keyword, $view['content']);
							$view['rich_content'] = preg_replace("/{이미지\:([0-9]+)[:]?([^}]*)}/ie", "view_image(\$view, '\\1', '\\2')", $view['content']);

							// 수정시
							$view['wr_content'] = stripslashes($view['wr_content']);
						}
						
						// 작성자가 관리자인지 아닌지 확인
						$admin_write = $admin_control->get_admin($view['wr_id']);
						$view['admin_write'] = false;
						if($admin_write)
							$view['admin_write'] = true;


					return $view;

				}

				// 게시글에 첨부된 파일을 얻는다. (배열로 반환)
				function get_file( $bo_table, $wr_no ) {

					global $alice, $utility;

						$file["count"] = 0;
						$get_files = $this->query_fetch_rows(" select * from `".$this->file_table."` where `bo_table` = '".$bo_table."' and `wr_no` = '".$wr_no."' order by `file_no` ");

						foreach($get_files as $val){
						
							$no = $val['file_no'];
							$file[$no]['href'] = "./download.php?bo_table=" . $bo_table . "&wr_no=".$wr_no."&no=" . $no;
							$file[$no]['download'] = $val['file_download'];
							$file[$no]['path'] = $alice['data_board_path'] . '/' . $bo_table;
							$file[$no]['size'] = $utility->get_filesize($val['file_filesize']);
							$file[$no]['datetime'] = $val['file_datetime'];
							$file[$no]['source'] = addslashes($val['file_source']);
							$file[$no]['file_content'] = $val['file_content'];
							$file[$no]['content'] = $utility->get_text($val['file_content']);
							$file[$no]['view'] = $utility->view_file_link($val['file_name'], $val['file_width'], $val['file_height'], $file[$no]['content']);
							$file[$no]['file'] = $val['file_name'];
							$file[$no]['image_width'] = $val['file_width'] ? $val['file_width'] : 640;
							$file[$no]['image_height'] = $val['file_height'] ? $val['file_height'] : 480;
							$file[$no]['image_type'] = $val['file_type'];
							$file[$no]['width'] = $val['file_width'];		// 실제 파일 가로
							$file[$no]['height'] = $val['file_height'];	// 실제 파일 높이
							$file["count"]++;

						}


					return $file;

				}


				// 게시판 테이블에서 하나의 행을 읽음
				function get_write( $write_table, $wr_no ) {

						$query = " select * from `".$write_table."` where `wr_no` = '".$wr_no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 게시글 추출
				function _get( $bo_table, $wr_no ){

					global $alice;

						$query = " select * from `" . $alice['write_prefix'] . $bo_table . "` where `wr_no` = '".$wr_no."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 게시판의 다음글 번호를 얻는다.
				function get_next_num( $table ){

						// 가장 작은 번호를 얻어
						$query = " select min(wr_num) as min_wr_num from `".$table."` ";

						$result = $this->query_fetch($query);


					// 가장 작은 번호에 1을 빼서 넘겨줌
					return (int)($result['min_wr_num'] - 1);

				}


				// 최근 게시물 필드 뽑기 (단수)
				function get_latest( $con ){

						$query = " select * from `".$this->new_table."` " . $con;

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 최근 게시물 필드 뽑기 (복수)
				function get_latestList( $con="" ){

						$query = " select * from `".$this->new_table."` " . $con;

						$result = $this->query_fetch_rows($query);

					return $result;

				}

				// 최신글 추출 (최소 5개)
				function latest($bo_table, $rows=5, $subject_len=40, $file_name="", $options=""){

					global $alice, $host_name, $utility;
					global $get_board_main, $board_config_control;
					global $board_code;


					//echo $skin_dir.' @ '.$bo_table.'@'.$rows.'@'.$subject_len.'@'.$file_name." <==<Br/>";

					//echo $bo_table." @ " . $rows . " @ " . $subject_le . " @ " . $file_name . " @ " . $options." <===<Br/>";

						$latest_skin_path = ($options['is_main']) ? $alice['main'] . "/skins/latest" : "./skins/latest";

						$list = array();

						$query = " select * from `".$this->board_table."` where `bo_table` = '".$bo_table."'";
						$board = $this->query_fetch($query);

						$tmp_write_table = $alice['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
						$query = " select * from `".$tmp_write_table."` where `wr_is_comment` = 0 order by `wr_num` limit 0, " . $rows;
						$result = $this->query_fetch_rows($query);
						//for ($i=0; $row = sql_fetch_array($result); $i++) 
						$i=0;
						if($result){
							foreach($result as $row){
								$list[$i] = $this->get_list($row, $board, $latest_skin_path, $subject_len);
							$i++;
							}
						}
						
						ob_start();
					
							$index = ($file_name) ? $file_name : "index";

							include "$latest_skin_path/".$index.".skin.php";

							$content = ob_get_contents();

						ob_end_clean();


					return $content;						

				}


				// 게시글 검색
				function _Search(){

					global $config, $utility;
					global $board;

						$page = $_GET['page'];

						$order = "";

						if($_GET['sort'] || $_GET['flag']){
							$sort = ($_GET['sort']) ? $_GET['sort'] : $_GET['board_sort'];	 // 정렬 기준
							if($sort)  $order = " `".$sort."` ";
							$flag = ($_GET['flag']) ? $_GET['flag'] : $_GET['board_flag'];	 // 정렬 순서
							$order .= ($flag) ? $flag : "";	// asc, desc
						} else {
							if($board['bo_sort_field'])
								$order .= $board['bo_sort_field'];
							else 
								$order .= "wr_num, wr_reply";
						}

						$mode = $_GET['mode'];
						if($_POST['mode'] && strpos($_SERVER['PHP_SELF'], 'board')) {	// 검색 방식 유효성 검사, strpos로 체크안하면 모든곳에 다 체크해버림;;
							$utility->popup_msg_js($config->_errors('0031'));
							exit;
						}

						$board_code = $_GET['board_code'];	// board_code
						$code = $_GET['code'];	// code
						$bo_table = $_GET['bo_table'];	// bo_table
						$sca = $_GET['sca'];	// 카테고리

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = trim(stripslashes($_GET['search_keyword']));	 // 검색 키워드


						$que = array();
						$url = array();

						## 분류(카테고리) 검색 ########################################################################################
						if($sca){	 // 값이 존재하는 경우에만
							array_push( $que, " `wr_category` = '".$sca."' " );
							array_push( $url, "sca=" . urlencode($sca) );
						} else {
							array_push( $url, "sca=" . urlencode($sca) );
						}
						## //분류(카테고리) 검색 ########################################################################################


						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드
							if($board_code) array_push( $url, "board_code=" . $board_code );
							array_push( $url, "code=" . $code );
							array_push( $url, "bo_table=" . $bo_table );

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
						$que = $que ? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url, 'order'=>$order);

				}

				// 게시판 그룹 메뉴 최상위 첫번째 코드
				function get_top_menu( $bo_table="" ){

					global $category_control;
					global $board_config_control;

						if($bo_table){

							$board = $board_config_control->get_boardTable($bo_table);	// 게시판 정보 (단수)
							
							$get_category = $category_control->get_categoryCode($board['code']);

							if($get_category['p_code']){

								$result = $get_category['p_code'];

							} else {

								$result = $get_category['code'];

							}

						} else {
							
							$query = $this->query_fetch(" select * from `".$category_control->cate_table."` where `type` = 'board_menu' and `p_code` = '' ");

							$result = $query['code'];

						}



					return $result;

				}

				// 게시판 정보 추출(단수) :: bo_table 기준
				function get_boardTable( $bo_table ){

						if(!$bo_table) return false;

						$query = " select * from `".$this->board_table."` where `bo_table` = '".$bo_table."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 상위 code 기준 게시판 리스트 추출
				function boCode_list( $code, $order=" order by `rank` asc " ){

						$_add = ($code) ? " where `code` = '".$code."' " : "";

						$query = " select * from `".$this->board_table."` " . $_add . $order;

						$result = $this->query_fetch_rows($query);


					return $result;

				}

				// 상황별 권한 체크
				function denied_check( $board, $status, $mb_level ){

						$result = false;

						switch($status){

							## 게시글 목록 보기 권한 체크
							case 'bo_list_level':

								if($mb_level >= $board['bo_list_level']){
									$result = true;
								}

							break;

						}


					return $result;

				}


				// DB 에서 각 테이블별 데이터 추출
				function __TableList( $bo_table, $page="", $page_rows="", $con="" ){

					global $alice, $utility;

						// 검색시 사용
						$_add = $this->_Search();

						$query = " select * from `" . $alice['write_prefix'] . $bo_table . "` " . $con . $_add['que'] . " order by " . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						//echo "<p>".$query."</p>";

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
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