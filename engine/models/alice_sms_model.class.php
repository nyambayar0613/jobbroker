<?php
		/**
		* /application/nad/config/model/alice_sms_model.class.php
		* @author Harimao
		* @since 2013/06/26
		* @last update 2015/04/13
		* @Module v3.5 ( Alice ) - s1.0
		* @Brief :: SMS Model Class
		* @Comment :: 문자 설정/발송 모델 클래스
		*/
		class alice_sms_model extends DBConnection {

			var $sms_config_table	=	"alice_sms_config";
			var $sms_msg_table		=	"alice_sms_msg";
			var $sms_table				=	"alice_sms";
			var $sms_log_table		=	"alice_sms_log";

			var $success_code = array(
					'0000' => 'SMS 정보 설정이 완료 되었습니다.',
					'0001' => 'SMS 메세지 설정이 완료 되었습니다.',
					'0002' => '성공적으로 SMS 문자를 발송하였습니다.',
					'0003' => '성공적으로 예약되었습니다.',
					'0004' => '테스트가 성공적입니다!',
					'0005' => 'SMS 발송이 완료 되었습니다.',
					'0006' => '성공적으로 SMS 문자를 발송하였습니다.\\n\\n데모 버전이기 때문에 실제 발송되진 않습니다.',
			);
			var $fail_code = array(
					'0000' => 'SMS 정보 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0001' => 'SMS 메시지 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
					'0002' => '잘못된 번호형식 입니다.',
					'0003' => '스팸문자는 발송되지 않습니다.',
					'0004' => 'SMS 서버 접속중 오류가 발생하였습니다.',
					'0005' => 'SMS 발송중 오류가 발생하였습니다.',
					'0006' => '사이트 전체 SMS 충전 건수가 부족합니다.\n\n사이트 운영자에게 문의하세요.',
					'0007' => 'SMS 충전 건수가 부족합니다.\n\nSMS 발송 건수를 충전해 주세요.',
			);

			var $log_status = array( 0 => "전송대기", 1 => "전송성공", 2 => "전송실패" );

				
				// 문자 발송 메시지 리스트 추출
				function __SMS_msgList( $con="", $order=" `no` asc " ){

						$query = " select * from `".$this->sms_msg_table."` ".$con." order by " . $order;

						$result = $this->query_fetch_rows($query);


					return $result;

				}

				// 문자 발송 환경설정 정보 추출
				function sms_config( $no ){
						
						if(!$no || $no=='') return false;

						$query = " select * from `".$this->sms_config_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 메시지 정보 추출 :: type 기준
				function get_config_for_type( $msg_type ){

						if(!$msg_type || $msg_type=='') return false;

						$query = "select * from `".$this->sms_msg_table."` where `msg_type` = '".$msg_type."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}

				// 메시지 정보 추출 :: no 기준
				function get_sms_msg( $no ){

						if(!$no || $no=='') return false;

						$query = "select * from `".$this->sms_msg_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// cafe24 문자 발송 모델
				// 메시지, 받는사람 번호, 보내는 사람 번호, 받는사람 병합 정보, 데이터 정보
				function netfu_sms_Send( $msg, $rphone, $sphone, $destination="", $datas="" ){
					
					global $is_demo;

						$sms_config = $this->sms_config(1);

						$sms_url = "http://sslsms.netfu.co.kr/sms_sender.php";

						$sms['user_id'] = base64_encode($sms_config['sms_api_id']);		//SMS 아이디.
						$sms['secure'] = base64_encode($sms_config['sms_api_key']) ;	//인증키
						$sms['msg'] = base64_encode(stripslashes($msg));

						$sms['rphone'] = base64_encode($rphone);

						$sms['name'] = base64_encode($datas['mb_name']);
						
						$sphones = explode('-',$sphone);
						$sms['sphone1'] = base64_encode($sphones[0]);
						$sms['sphone2'] = base64_encode($sphones[1]);
						$sms['sphone3'] = base64_encode($sphones[2]);

						$sms['rdate'] = "";	// base64_encode($_POST['rdate']);	 예약 날짜
						$sms['rtime'] = "";	// base64_encode($_POST['rtime']);	 예약 시간

						$sms['mode'] = $sms_config['lms_use'];	// lms 사용유무

						$returnurl = $_POST['returnurl'];
						$sms['returnurl'] = "";	// base64_encode($returnurl);	 전송 리턴 페이지

						$sms['testflag'] = ($is_demo) ? base64_encode('Y') : base64_encode('N');	// 데모일땐 테스트 / 실제 사용시엔 전송

						if($destination!='') $sms['detsination'] = urlencode(base64_encode($destination));

						$sms['repeatFlag'] = "";	// base64_encode($_POST['repeatFlag']);		반복설정
						$sms['repeatNum'] = "";	// base64_encode($_POST['repeatNum']);	반복횟수
						$sms['repeatTime'] = "";	// base64_encode($_POST['repeatTime']);	전송간격

						$nointeractive = 0;	 //$_POST['nointeractive']; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략

						$host_info = explode("/", $sms_url);
						$host = $host_info[2];
						$path = $host_info[3]."/".$host_info[4];

						srand((double)microtime()*1000000);
						$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);

						// 헤더 생성
						$header = "POST /".$path ." HTTP/1.0\r\n";
						$header .= "Host: ".$host."\r\n";
						$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

						// 본문 생성
						foreach($sms AS $index => $value){
							$data .="--$boundary\r\n";
							$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
							$data .= "\r\n".$value."\r\n";
							$data .="--$boundary\r\n";
						}
						$header .= "Content-length: " . strlen($data) . "\r\n\r\n";

						$fp = fsockopen($host, 80);

						if ($fp) { 
							fputs($fp, $header.$data);
							$rsp = array();
							while(!feof($fp)) { 
								$rsp[] = fgets($fp,8192); 
							}

							$result_msg = json_decode($rsp[13]);

							fclose($fp);

							if($result_msg){
								$result['result'] = "success";
								$result['msg'] = $this->_success("0002");
								$result['data'] = $rsp[13];
							} else {
								$result['result'] = "errors";
								$result['msg'] = $this->_errors('0004');
							}							

						} else {

							$result['result'] = "errors";
							$result['msg'] = $this->_errors('0004');

						}


					return implode($result,'/');

				}

				function netfu_sms_Ord(){

						$sms_config = $this->sms_config(1);
					
						$sms_url = "http://sslsms.netfu.co.kr/sms_remain.php"; // SMS 잔여건수 요청 URL

						$sms['url'] = base64_encode($_SERVER['HTTP_HOST']);
						$sms['user_id'] = base64_encode($sms_config['sms_api_id']);		//SMS 아이디.
						$sms['secure'] = base64_encode($sms_config['sms_api_key']) ;	//인증키
						$sms['mode'] = base64_encode('count');	// SMS 발송 가능 건수

						$host_info = explode("/", $sms_url);
						$host = $host_info[2];
						$path = $host_info[3]."/".$host_info[4];
						srand((double)microtime()*1000000);
						$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);

						// 헤더 생성
						$header = "POST /".$path ." HTTP/1.0\r\n";
						$header .= "Host: ".$host."\r\n";
						$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

						// 본문 생성
						foreach($sms AS $index => $value){
							$data .="--$boundary\r\n";
							$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
							$data .= "\r\n".$value."\r\n";
							$data .="--$boundary\r\n";
						}
						$header .= "Content-length: " . strlen($data) . "\r\n\r\n";

						$fp = fsockopen($host, 80);

						if ($fp) {
							fputs($fp, $header.$data);
							$rsp = '';
							while(!feof($fp)) {
								$rsp .= fgets($fp,8192);
							}

							fclose($fp);

							$msg = explode("\r\n\r\n",trim($rsp));

							$result = $msg[1]; //잔여건수

						} else {

							//$result = "Connection Failed";
							$result = 0;

						}


					return $result;

				}

				// cafe24 문자 발송 모델
				// 메시지, 받는사람 번호, 보내는 사람 번호, 받는사람 병합 정보, https 유무
				function cafe24_sms_Send( $msg, $rphone, $sphone, $destination="", $is_https=false ){
					
					global $is_demo;

						$sms_config = $this->sms_config(1);

						if($is_https)
							$sms_url = "https://sslsms.cafe24.com/sms_sender.php";			// HTTPS 전송요청 URL
						else
							$sms_url = "http://sslsms.cafe24.com/sms_sender.php";			// 전송요청 URL

						$sms['user_id'] = base64_encode($sms_config['sms_api_id']);		//SMS 아이디.
						$sms['secure'] = base64_encode($sms_config['sms_api_key']) ;	//인증키
						$sms['msg'] = base64_encode(stripslashes($msg));

						$sms['rphone'] = base64_encode($rphone);
						
						$sphones = explode('-',$sphone);
						$sms['sphone1'] = base64_encode($sphones[0]);
						$sms['sphone2'] = base64_encode($sphones[1]);
						$sms['sphone3'] = base64_encode($sphones[2]);

						$sms['rdate'] = "";	// base64_encode($_POST['rdate']);	 예약 날짜
						$sms['rtime'] = "";	// base64_encode($_POST['rtime']);	 예약 시간
						$sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.

						$returnurl = $_POST['returnurl'];
						$sms['returnurl'] = "";	// base64_encode($returnurl);	 전송 리턴 페이지

						$sms['testflag'] = ($is_demo) ? base64_encode('Y') : base64_encode('N');	// 데모일땐 테스트 / 실제 사용시엔 전송

						if($destination!='') $sms['destination'] = urlencode(base64_encode($destination));

						$sms['repeatFlag'] = "";	// base64_encode($_POST['repeatFlag']);		반복설정
						$sms['repeatNum'] = "";	// base64_encode($_POST['repeatNum']);	반복횟수
						$sms['repeatTime'] = "";	// base64_encode($_POST['repeatTime']);	전송간격

						$nointeractive = 0;	 //$_POST['nointeractive']; //사용할 경우 : 1, 성공시 대화상자(alert)를 생략

						$host_info = explode("/", $sms_url);
						$host = $host_info[2];
						$path = $host_info[3]."/".$host_info[4];

						srand((double)microtime()*1000000);
						$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);

						// 헤더 생성
						$header = "POST /".$path ." HTTP/1.0\r\n";
						$header .= "Host: ".$host."\r\n";
						$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

						// 본문 생성
						foreach($sms AS $index => $value){
							$data .="--$boundary\r\n";
							$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
							$data .= "\r\n".$value."\r\n";
							$data .="--$boundary\r\n";
						}
						$header .= "Content-length: " . strlen($data) . "\r\n\r\n";

						$fp = fsockopen($host, 80);

						if ($fp) { 
							fputs($fp, $header.$data);
							$rsp = '';
							while(!feof($fp)) { 
								$rsp .= fgets($fp,8192); 
							}
							fclose($fp);
							$msg = explode("\r\n\r\n",trim($rsp));
							$rMsg = explode(",", $msg[1]);
							$Result= $rMsg[0]; //발송결과
							$Count= $rMsg[1]; //잔여건수

							$result = array();

							//발송결과 알림
							if($Result=="success") {
								/*
								$alert = "성공";
								$alert .= " 잔여건수는 ".$Count."건 입니다.";
								*/
								$result['result'] = "success";
								$result['msg'] = $this->_success("0002");
							} else if($Result=="reserved") {
								/*
								$alert = "성공적으로 예약되었습니다.";
								$alert .= " 잔여건수는 ".$Count."건 입니다.";
								*/
								$result['result'] = "success";
								$result['msg'] = $this->_success("0003");
							} else if($Result=="3205") {
								//$alert = "잘못된 번호형식입니다.";
								$result['result'] = "errors";
								$result['msg'] = $this->_errors('0002');
							} else if($Result=="0044") {
								//$alert = "스팸문자는발송되지 않습니다.";
								$result['result'] = "errors";
								$result['msg'] = $this->_errors('0003');
							} else {
								//$alert = "[Error]".$Result;	// 테스트가 성공적입니다!
								$result['result'] = "success";
								//$result['msg'] = $this->_success("0004");
								$result['msg'] = $this->_success("0006");	// 성공적으로 SMS 문자를 발송하였습니다.\\n\\n데모 버전이기 때문에 실제 발송되진 않습니다.
							}
						} else {
							//$alert = "Connection Failed";
								$result['result'] = "errors";
								$result['msg'] = $this->_errors('0004');
						}


					return implode($result,'/');

				}

				// cafe24 잔여건수
				function cafe24_sms_Ord(){
				
						$sms_config = $this->sms_config(1);

						$sms_url = "http://sslsms.cafe24.com/sms_remain.php"; // SMS 잔여건수 요청 URL

						$sms['user_id'] = base64_encode($sms_config['sms_api_id']); // SMS 아이디
						$sms['secure'] = base64_encode($sms_config['sms_api_key']) ;//인증키

						$sms['mode'] = base64_encode("1"); // base64 사용시 반드시 모드값을 1로 주셔야 합니다.

						$host_info = explode("/", $sms_url);
						$host = $host_info[2];
						$path = $host_info[3]."/".$host_info[4];
						srand((double)microtime()*1000000);
						$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);

						// 헤더 생성
						$header = "POST /".$path ." HTTP/1.0\r\n";
						$header .= "Host: ".$host."\r\n";
						$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

						// 본문 생성
						foreach($sms AS $index => $value){
							$data .="--$boundary\r\n";
							$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
							$data .= "\r\n".$value."\r\n";
							$data .="--$boundary\r\n";
						}
						$header .= "Content-length: " . strlen($data) . "\r\n\r\n";

						$fp = fsockopen($host, 80);

						if ($fp) {
							fputs($fp, $header.$data);
							$rsp = '';
							while(!feof($fp)) {
								$rsp .= fgets($fp,8192);
							}
							fclose($fp);
							$msg = explode("\r\n\r\n",trim($rsp));

							$result = $msg[1]; //잔여건수

						} else {

							//$result = "Connection Failed";
							$result = 0;

						}


					return $result;

				}


				/**
				* SMS 문구 치환
				*/
				function msg_replace( $msg, $admin_msg, $member="", $mb_password="", $datas="" ){

					global $config, $env, $utility;

						if($datas['msg_type']=='pay_online_request'){	 // 온라인 결제시
							$data = $datas['data'];
							$pay_bank = explode("/",$data['pay_bank']);
							$pay_bank_name = $data['pay_bank_name'];
							$pay_total = $data['pay_price'];
						} else if($datas['msg_type']=='alba_regist' || $datas['msg_type']=='alba_interview' || $datas['msg_type']=='alba_invitation' || $datas['msg_type']=='alba_online' || $datas['msg_type']=='alba_email'){
							$company_name = $datas['wr_company_name'];	 // 회사명
						}

						$result = array();

						// 치환 문구
						$trans = array(
							"{도메인}" => $utility->add_http($_SERVER['HTTP_HOST']),
							"{날짜}" => date('m')."월 ".date('d')."일",
							"{사이트명}" => stripslashes($env['site_name']), 

							"{이름}" => $member['mb_name'],
							"{아이디}" => $member['mb_id'],
							"{비밀번호}" => $mb_password,
							"{닉네임}" => stripslashes($member['mb_nick']),

							"{은행}" => $pay_bank[0],
							"{계좌번호}" => $pay_bank[1],
							"{예금주}" => $pay_bank[2],
							"{입금자}" => $pay_bank_name,
							"{금액}" => $pay_total,

							"{회사}" => $company_name,
						);
					
						$result['msg'] = strtr($msg, $trans);
						$result['admin_msg'] = strtr($admin_msg, $trans);


					return $result;
						
				}


				/**
				* SMS 전송 로그 리스트
				*/
				function __LogList( $page="", $page_rows="", $con="" ){

						// 검색시 사용
						$_add = $this->_Search( );

						$query = " select * from `".$this->sms_log_table."` " . $_add['que'] . $con . $_add['order'];

						$total_count = $this->_queryR($query);

						if($page_rows){

							$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
							if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
							$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

							$query .= " limit $from_record, $page_rows ";

						}

						/*
						echo "<div style='color:#fff;'>";
						echo $query;
						echo "</div>";
						*/

						$result['result'] = $this->query_fetch_rows($query);
						$result['total_count'] = $total_count;
						$result['total_page'] = $total_page;
						$result['send_url'] = $_add['send_url'];

					
					return $result;

				}


				/**
				* SMS 전송 로그 검색
				*/
				function _Search( ){

						$mode = $_GET['mode'];

						$page = $_GET['page'];

						$order = " order by `no` desc ";

						$type = $_GET['type'];	// 발송/수신 리스트 구분

						$start_day = urldecode($_GET['start_day']);
						$end_day = urldecode($_GET['end_day']);

						$sdate = $_GET['sdate'];
						$edate = $_GET['edate'];

						$wr_type = $_GET['wr_type'];	

						$search_field = $_GET['search_field'];	// 검색 필드
						$search_keyword = urldecode($_GET['search_keyword']);	 // 검색 키워드

						$que = array();
						$url = array();

						if($mode=='search'){

							array_push( $url, "mode=" . $mode );	 // 검색 모드

							## 전송일 검색 ######################################################################################
							// 두 값이 모두 다 있는 경우
							if( $start_day!='' && $end_day!='' ) {		// start_day && end_day

								array_push( $que, " ( `wr_wdate` between '" . $start_day . " 00:00:00' and '" . $end_day . " 23:59:59' ) " );

							// 두 값이 모두 다 없고 둘중 하나만 있는 경우
							} else {

								if( $start_day!='' ) {		// start_day
									array_push( $que, " `wr_wdate` >= '" . $start_day . "' " );
								}

								if( $end_day!='' ) {		// end_day
									array_push( $que, " `wr_wdate` <= '" . $end_day . "' " );
								}

								$sdates = $sdate[0] . "-" . $sdate[1] . "-" . $sdate[2];
								$edates = $edate[0] . "-" . $edate[1] . "-" . $edate[2];
								if($sdate && $edate){
									array_push( $que, " `wr_wdate` between '".$sdates." 00:00:00' and '".$edates." 23:59:59' " );
									//array_push( $url, "start_day=".urlencode($sdates)."&end_day=".urlencode($edates) );
								}

							}
							## //전송일 검색 #####################################################################################

							## 전송 방식 검색 #####################################################################################
							if($wr_type){
								array_push( $que, " `wr_type` = '".$wr_type."' " );
								array_push( $url, "wr_type=".$wr_type );
							}
							## //전송 방식 검색 ####################################################################################


							## 필드선택에 따른 검색 #################################################################################
							if($search_field==''){	// 통합검색 일때

								if(preg_match("/[a-zA-Z]/", $search_keyword)) {
									$search_que  = "( INSTR(LOWER(`wr_content`), LOWER('".$search_keyword."')) or ";
									$search_que .= " INSTR(LOWER(`wr_id`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_name`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_sphone`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_receive`), LOWER('".$search_keyword."')) ) or ";
									$search_que .= " INSTR(LOWER(`wr_receive_name`), LOWER('".$search_keyword."')) or";
									$search_que .= " INSTR(LOWER(`wr_rphone`), LOWER('".$search_keyword."')) ";
								} else {
									$search_que  = "( ";
									$search_que .= " INSTR(`wr_content`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_id`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_name`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_sphone`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_receive`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_receive_name`, '".$search_keyword."') or ";
									$search_que .= " INSTR(`wr_rphone`, '".$search_keyword."') ";
									$search_que .= ") ";
								}

								array_push($url, "search_field=&search_keyword=" . urlencode($search_keyword));

							} else {	 // 필드 선택

								if(preg_match("/[a-zA-Z]/", $search_keyword))
									$search_que = " INSTR(LOWER(`".$search_field."`), LOWER('".$search_keyword."')) ";
								else
									$search_que = " INSTR(`".$search_field."`, '".$search_keyword."') ";

								array_push($url, "search_field=" . urlencode($search_field) . "&search_keyword=" . urlencode($search_keyword));

							}
							## //필드선택에 따른 검색 ###############################################################################

							if($search_keyword){
								array_push($que, $search_que);
							}

						}

						array_push($url, 'page='.$page);
						array_push($url, 'page_rows='.$page_rows);

						$que = is_array($que) ? implode(' and ',$que) : '';
						$url = is_array($url) ? implode('&',$url) : '';
						$que = preg_replace("/^\s+where/i", '', $que);
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