<?php
		/**
		* /application/nad/model/alice_admin_model.class.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/04/03
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Model class
		* @Comment :: 관리자 모델 클래스
		*/
		class alice_admin_model extends DBConnection {

			var $admin_table	= "alice_admin";			// admin table
			var $auth_table		= "alice_admin_auth";	// admin auth table
			var $sess_uid_val		= "sess_admin_uid";			// 관리자 아이디
			var $sess_level_val	= "sess_admin_level";		// 관리자 레벨
			var $sess_name_val	= "sess_admin_name";		// 관리자 이름
			var $sess_nick_val		= "sess_admin_nick";			// 관리자 닉네임
			var $sess_key_val		= "sess_admin_key";			// 관리자 보안 고유키

			var $success_code = array(
					'0000' => '로그인 되었습니다.',
					'0001' => '최고관리자로 로그인 되었습니다.',
					'0002' => '사이트운영자로 로그인 되었습니다.',
					'0003' => '관리자 정보가 수정 되었습니다.',
					'0004' => '부관리자 정보가 입력 되었습니다.',
					'0005' => '부관리자 삭제가 완료 되었습니다.',
					'0006' => '관리자 정보 갱신을 위하여 재 로그인 부탁드립니다.',
			);
			var $fail_code = array(
					'0000' => '관리자만 접근 가능합니다.',
					'0001' => '관리자 아이디를 입력해 주세요.',
					'0002' => '관리자 비밀번호를 입력해 주세요.',
					'0003' => '관리자 아이디가 정확하지 않습니다.\\n\\n관리자 아이디를 확인해 주세요.',
					'0004' => '관리자 비밀번호가 정확하지 않습니다.\\n\\n관리자 비밀번호를 확인해 주세요.',
					'0005' => '관리자 아이디나 비밀번호, 닉네임은 공백이면 안됩니다.',
					'0006' => '부관리자 정보 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0007' => '메뉴 접근 권한이 없습니다.\\n\\n최고관리자에게 문의하세요.',
					'0008' => '관리자 닉네임을 입력해 주세요.',
					'0009' => '관리자 정보 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0010' => '이미 존재하는 관리자 아이디(ID) 입니다.',
					'0011' => '부관리자 정보 입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0012' => '부관리자 정보 삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0013' => '부관리자 메뉴별 권한 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
			);

				function __AdminList( $level, $page="", $page_rows="" ){

						// 검색시 사용
						$_con = $this->_Search();

						$query = " select * from `".$this->admin_table."` where `level` = '".$level."' " . $_con['que'] . " order by `no` desc ";
						
						//$total_count = ($this->_queryR($query)==0) ? $this->_queryR($query) : $this->_queryR($query) - 1;
						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;


					return $result;

				}

				// 관리자 정보 추출(단일)
				function get_admin( $uid ){

						if(!$uid) return false;

						$query = " select * from `".$this->admin_table."` where `uid` = '".$uid."' ";

						$result = $this->query_fetch($query);


					return $result;

				}

				// 레벨에 맞는 관리자 정보 추출
				function get_level_admin( $level ){

						if(!$level) return false;

						$query = " select * from `".$this->admin_table."` where `level` = '".$level."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 관리자 세션정보 체크
				function __adminSessCheck(){

					global $_SESSION;

						if($_SESSION[$this->sess_uid_val] && $_SESSION[$this->sess_key_val]){
							$get_admin = $this->get_admin($_SESSION[$this->sess_uid_val]);
							if($get_admin)
								$result = $get_admin;
							else
								$result = false;
						}

					return $result;

				}

				
				// 부관리자 중복체크
				function sadmin_duplication( $uid ){

						if(!$uid) return false;

						$query = " select * from `".$this->admin_table."` where `uid` = '".$uid."' ";

						$result = $this->_queryR($query);

					
					return $result;

				}

				
				// 부관리자 메뉴별 권한 정보
				function get_admin_auth( $uid ){

						if(!$uid) return false;

						$query = " select * from `".$this->auth_table."` where `uid` = '".$uid."' ";

						$result = $this->query_fetch($query);


					return $result;

				}


				// 관리자 검색
				function _Search(){

						$page = $_GET['page'];
						
						$search = $_GET['search'];
						$search_field = $_GET['search_field'];
						$search_keyword = $_GET['search_keyword'];

						$que = array();
						$url = array();

						array_push($url, 'search='.$search);

						if($search_field && $search_keyword){

							array_push($que, " INSTR(LOWER(`".$search_field."`), LOWER('".$search_keyword."')) ");
							array_push($url, "search_field=".urlencode($search_field).'&search_keyword='.urlencode($search_keyword));

						} else {	 // 통합검색

							$search_field_arr = array('name', 'uid', 'nick');

							array_push($que, " ( INSTR(LOWER(`name`), LOWER('".$search_keyword."')) or INSTR(LOWER(`uid`), LOWER('".$search_keyword."')) or INSTR(LOWER(`nick`), LOWER('".$search_keyword."')) )");
							array_push($url, "search_field=".urlencode($search_field).'&search_keyword='.urlencode($search_keyword));

						}

						array_push($url, 'page='.$page);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+and/i", '', $que);
						$que = $que? " and ".$que : '';
						$url = preg_replace('/^&/', '', $url);
						$send_url = $url;
						$url = $url ? $_SERVER['PHP_SELF'].'?'.$url : '';


					return array('que'=>$que, 'url'=>$url, 'send_url'=>$send_url);

				}


				// 로그인 후 메인 '페이지뷰'
				function page_views( $vi_page, $vi_month ){

						if(!$vi_page) return false;

						$query = " select * from `alice_visit_page` where `vi_page` = '".$vi_page."' and `vi_date` like '".$vi_month."-%'  ";

						$result = $this->_queryR($query);

					
					return $result;

				}


				// 간편 관리자 체크
				function is_admin( $ajax="" ){

					global $is_admin;
					global $utility;

						if(!$is_admin){	// 관리자가 아닐때

							if($ajax) {
								$utility->popup_msg_ajax($this->_errors('0000'));		// 관리자만 접근 가능합니다.
								exit;
							} else {
								$utility->popup_msg_js($this->_errors('0000'));
								exit;
							}

						} else {

							return true;

						}

				}


				/**
				* NETFU 제공 공지사항/솔루션업데이트 XML 추출
				*/
				function get_netfuXML( $type ){
					
					global $alice;
					global $snoopy;


						## 01. 소켓으로 파일을 가져온다.
						$url = "http://netfu.co.kr/xml/notice.php?type=" . $type;

						$info = parse_url($url);

						$send  = "POST " . $info['path'] . " HTTP/1.1\r\n";
						$send .= "Host: " . $info['host'] . "\r\n";
						$send .= "Content-type: application/x-www-form-urlencoded\r\n";
						$send .= "Content-length: " . strlen($info['query']) . "\r\n";
						$send .= "Connection: close\r\n\r\n" . $info['query'];

						$fp = fsockopen($info['host'], 80);
						fputs($fp, $send);

						$start = false;
						$retVal = '';
						while(!feof($fp)){
			
							$tmp = fgets ($fp,1024);
							if($start == true)
								$retVal .= $tmp;
							if($tmp == "\r\n")
								$start = true;
							
						}

						$retVal = str_replace(array('\r','\n','\r\n'), array('','',''), $retVal);

						fclose($fp);
						//echo $retVal;

						## 02. 가져온 파일을 임의로 생성
						$filename = ($type=='notice') ? $alice['tmp_path'] . '/netfu_notice.xml' : $alice['tmp_path'] . '/netfu_update.xml';


						// Let's make sure the file exists and is writable first.
						if (is_writable($filename)) {

							// that's where $somecontent will go when we fwrite() it.
							if (!$handle = fopen($filename, 'w')) {
								 echo "Cannot open file ($filename)";
								 exit;
							}

							// Write $somecontent to our opened file.
							if (fwrite($handle, $retVal) === FALSE) {
								echo "Cannot write to file ($filename)";
								exit;
							}

							## 03. 생성된 파일을 xml 형태로 로드
							include_once $alice['path'] . "engine/library/simplexml.class.php";

							/*
							if(!function_exists("simplexml_load_file")){
								function simplexml_load_file($file){
									$sx = new simplexml;
									return $sx->xml_load_file($file);
								}
							}
							*/

							$sxml = new simplexml;

							$xml = $sxml->xml_load_file($filename);

							fclose($handle);

						} else {

							## 생성된 파일을 xml 형태로 로드

							echo "The file $filename is not writable";

						}					

					return $xml;

				}


				/**
				* NETFU 제공 공지사항/솔루션업데이트 XML 출력
				*/
				function print_netfuXML($type){

						$get_netfuXML = $this->get_netfuXML($type);					

						$result = "";

						foreach($get_netfuXML->attributes() as $a => $b){
							if($a=='url')
								$result['url'] = $b;
						}

						$data_cnt = count($get_netfuXML->DATA);

						if($type=='notice'){
							$ul_id = "tab01";
							$ul_style = "display:;";
						} else if($type=='update'){
							$ul_id = "tab02";
							$ul_style = "display:;";
						}

						$result['data'] .= "<ul id='".$ul_id."' class='s11lst dgr hcol' style='".$ul_style."'>\n";
						for($i=0;$i<$data_cnt;$i++){
							$wdate = strtr(substr($get_netfuXML->DATA[$i]->WDATE,5,5),'-','/');
							$url = $get_netfuXML->DATA[$i]->URL;
							$subject = $get_netfuXML->DATA[$i]->SUBJECT;
							$result['data'] .= "<li>[".$wdate."] <a href='".$url."' target='_blank'>".$subject."</a></li>\n";
						}
						$result['data'] .= "</ul>\n";

					
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