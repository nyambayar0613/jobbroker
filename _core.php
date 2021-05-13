<?php	// php.ini 세팅중 short_open_tag 가 Off 인 경우를 대비하여 모든 php 소스는 <?php 와 같은 형태로 작성한다.
		/**
		* /_core.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/03/26
		* @Module v3.5 ( Alice )
		* @Brief :: Application Core Injection
		* @Comment :: Core 파일을 아무곳에서나 사용하기 위한 접근 파일입니다. 절대 삭제하지 마세요.
		*/

		ob_start('ob_gzhandler');		// 속도 향상을 위한 웹페이지 압축

		// 에러 정보
		error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);

		// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
		// iframe 때문에 간혹 세션이 깨지는 경우를 방지함
		header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

		// 강제 header 지정
		@header("Content-Type: text/html; charset=UTF-8");


		// 절대경로
		$realpath = $_SERVER['DOCUMENT_ROOT'].'/';
		$dirname = dirname(__FILE__).'/';

		if (!isset($set_time_limit)) 
			$set_time_limit = 0;
		@set_time_limit($set_time_limit);


	   /*
		* 짧은 환경변수를 지원하지 않는다면
		* 기존 module 2.0 의 getParam 을 대체한다
		* 그누보드 발췌
		*/
		if (isset($HTTP_POST_VARS) && !isset($_POST)) {
			$_POST		= &$HTTP_POST_VARS;
			$_GET		= &$HTTP_GET_VARS;
			$_SERVER	= &$HTTP_SERVER_VARS;
			$_COOKIE	= &$HTTP_COOKIE_VARS;
			$_ENV		= &$HTTP_ENV_VARS;
			$_FILES		= &$HTTP_POST_FILES;
			if (!isset($_SESSION))
				$_SESSION = &$HTTP_SESSION_VARS;
		}

	   /*
		* php.ini 의 magic_quotes_gpc 값이 FALSE 인 경우 addslashes() 적용
		* SQL Injection 등으로 부터 보호
		* phpBB2 참고
		*/
		if( !get_magic_quotes_gpc() ) {
			if( is_array($_GET) ) {
				while( list($k, $v) = each($_GET) ) {
					if( is_array($_GET[$k]) ) {
						while( list($k2, $v2) = each($_GET[$k]) ) {
							$_GET[$k][$k2] = addslashes($v2);
						}
						@reset($_GET[$k]);
					} else {
						$_GET[$k] = addslashes($v);
					}
				}
				@reset($_GET);
			}
			if( is_array($_POST) ) {
				while( list($k, $v) = each($_POST) ) {
					if( is_array($_POST[$k]) ) {
						while( list($k2, $v2) = each($_POST[$k]) ) {
							$_POST[$k][$k2] = addslashes($v2);
						}
						@reset($_POST[$k]);
					} else {
						$_POST[$k] = addslashes($v);
					}
				}
				@reset($_POST);
			}
			if( is_array($_COOKIE) ) {
				while( list($k, $v) = each($_COOKIE) ) {
					if( is_array($_COOKIE[$k]) ) {
						while( list($k2, $v2) = each($_COOKIE[$k]) ) {
							$_COOKIE[$k][$k2] = addslashes($v2);
						}
						@reset($_COOKIE[$k]);
					} else {
						$_COOKIE[$k] = addslashes($v);
					}
				}
				@reset($_COOKIE);
			}
		}

		if (($_GET['alice_path'] || $_POST['alice_path'] || $_COOKIE['alice_path']) || ($_GET['cat_path'] || $_POST['cat_path'] || $_COOKIE['cat_path'])) {
			unset($_GET['alice_path']);
			unset($_POST['alice_path']);
			unset($_COOKIE['alice_path']);
			unset($alice_path);
			unset($_GET['cat_path']);
			unset($_POST['cat_path']);
			unset($_COOKIE['cat_path']);
			unset($cat_path);
		}

	   /*
		* XSS(Cross Site Scripting) 공격에 의한 데이터 검증 및 차단
		* 그누보드 발췌
		*/
		function xss_clean($data) { 
			// If its empty there is no point cleaning it :\ 
			if(empty($data))  return $data; 
			// Recursive loop for arrays 
			if(is_array($data)) { 
				foreach($data as $key => $value) {
					$data[$key] = xss_clean($value);
				}
				return $data;
			}
			 
			// http://svn.bitflux.ch/repos/public/popoon/trunk/classes/externalinput.php 
			// +----------------------------------------------------------------------+ 
			// | Copyright (c) 2001-2006 Bitflux GmbH                                 | 
			// +----------------------------------------------------------------------+ 
			// | Licensed under the Apache License, Version 2.0 (the "License");      | 
			// | you may not use this file except in compliance with the License.     | 
			// | You may obtain a copy of the License at                              | 
			// | http://www.apache.org/licenses/LICENSE-2.0                           | 
			// | Unless required by applicable law or agreed to in writing, software  | 
			// | distributed under the License is distributed on an "AS IS" BASIS,    | 
			// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      | 
			// | implied. See the License for the specific language governing         | 
			// | permissions and limitations under the License.                       | 
			// +----------------------------------------------------------------------+ 
			// | Author: Christian Stocker <chregu@bitflux.ch>                        | 
			// +----------------------------------------------------------------------+ 
			 
			// Fix &entity\n; 
			$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data); 
			$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/', '$1;', $data); 
			$data = preg_replace('/(&#x*[0-9A-F]+);*/i', '$1;', $data); 

			if (function_exists("html_entity_decode")) {
				$data = html_entity_decode($data); 
			} else {
				$trans_tbl = get_html_translation_table(HTML_ENTITIES);
				$trans_tbl = array_flip($trans_tbl);
				$data = strtr($data, $trans_tbl);
			}

			// Remove any attribute starting with "on" or xmlns 
			$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#i', '$1>', $data); 

			// Remove javascript: and vbscript: protocols 
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#i', '$1=$2nojavascript...', $data); 
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#i', '$1=$2novbscript...', $data); 
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#', '$1=$2nomozbinding...', $data); 

			// Only works in IE: <span style="width: expression(alert('Ping!'));"></span> 
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data); 
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data); 
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#i', '$1>', $data); 

			// Remove namespaced elements (we do not need them) 
			$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data); 

			do { 
				// Remove really unwanted tags 
				$old_data = $data; 
				$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data); 
			} while ($old_data !== $data);

			return $data;
		}

		$_GET = xss_clean($_GET);		//  XSS(Cross Site Scripting) 공격에 의한 데이터 검증 및 차단


		/*
		 * extract($_GET); 명령으로 인해 page.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
		 * 그누보드 발췌
		 */
		$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST','HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS','HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');

		$ext_cnt = count($ext_arr);
		for ($i=0; $i<$ext_cnt; $i++) {
			// GET 으로 선언된 전역변수가 있다면 unset() 시킴
			if (isset($_GET[$ext_arr[$i]])) unset($_GET[$ext_arr[$i]]);
		}


		// php.ini 의 register_globals=off 일 경우
		@extract($_GET);
		@extract($_POST);
		@extract($_SERVER);

		// 보안관련 변수 설정
		$config		= array();
		$member	= array();
		$users		= array();
		$board		= array();
		$group		= array();
		$alice		= array();


		/*
		 * index.php 가 있는곳의 상대경로
		 * php 인젝션 ( 임의로 변수조작으로 인한 리모트공격) 취약점에 대비한 코드
		 */
		if (!$alice_path || preg_match("/:\/\//", $alice_path))
			//die($utility->popup_msg_js("잘못된 방법으로 변수가 정의되었습니다."));
			die("잘못된 방법으로 변수가 정의되었습니다. [alice_path]");

		$alice['path'] = $alice_path;		// 상대경로를 사용하기 위한 변수

		unset($alice_path);

		include_once $alice['path'] . "engine/config/app_config.php";		// 기본 환경설정 및 변수 정의 파일
		require_once $alice['path'] . "engine/core/core.php";					// Core require :: 없으면 모든 작동을 막기 위해 require 를 사용한다.	
		include_once $alice['path'] . "engine/core/custom.php";				// 커스터마이징

		if (!$cat_path || preg_match("/:\/\//", $cat_path))
			die("잘못된 방법으로 변수가 정의되었습니다. [cat_path]");

		$cat['path'] = $cat_path;				// 절대경로를 사용하기 위한 변수 (alice 변수 helper)

		unset($cat_path);

		
		// config.php 가 있는곳의 웹경로
		if (!$alice['url']){
            $https_url_chk = $is_https ? "https://" : "http://";
			$alice['url'] = $https_url_chk . $HOST;
			$dir = dirname($_SERVER["PHP_SELF"]);
				if (!file_exists($alice['path'] . "engine/config/app_config.php"))
					$dir = dirname($dir);

			$cnt = substr_count($alice['path'], "..");
			for ($i=2; $i<=$cnt; $i++)
				$dir = dirname($dir);

			$alice['url'] .= $dir;
		}


		$alice['url'] = strtr($alice['url'], "\\", "/");	// \ 를 / 로 변경
		$alice['url'] = preg_replace("/\/$/", "", $alice['url']);	// url 의 끝에 있는 / 를 삭제한다.

		$bo_table = ($_POST['bo_table']) ? $_POST['bo_table'] : $_GET['bo_table'];
		$wr_no = ($_POST['wr_no']) ? $_POST['wr_no'] : $_GET['wr_no'];


	   /*
		* SESSION 설정 (GNUBOARD4 참고)
		*/
		@ini_set('memory_limit','512M');	// 메모리 사이즈
		ini_set("session.use_trans_sid", 0);	// PHPSESSID를 자동으로 넘기지 않음
		ini_set("url_rewriter.tags","");			// 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)
		ini_set("max_input_vars", 5000);	// post 값 설정
		ini_set("session.save_handler","files"); 


		if (isset($SESSION_CACHE_LIMITER))
			@session_cache_limiter($SESSION_CACHE_LIMITER);
		else
			@session_cache_limiter("no-cache, must-revalidate");


		##
		# 사이트 환경설정을 불러온다 :: 사용자/관리자 모두 사용하기 때문에 여기서 선언
		# init 함수 할당 no(주키) => 서브 사용자 존재시 대비용
		$env = $config->_init(1);

		$design = $design_control->get_design(1);
		//$category = $category_control->__CategoryList('category');	// 기본 카테고리 리스트
		$board = $board_config_control->get_boardTable($bo_table);	// 게시판 정보 (단수)
		//$pg = $pg_control->get_pgInfo('yes');	 // 현재 사용하고 있는 결제모듈 정보
		$mobile_info = $mobile_control->get_mobile_info(1);	// 모바일 정보

		$write_table = "";	// 작성 게시판
		if (isset($bo_table)) {
			if ($board['bo_table']) {
				$write_table = $alice['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
				if ($wr_no) $write = $db->query_fetch(" select * from `".$write_table."` where `wr_no` = '".$wr_no."' ");
			}
		}

		##
		# 사이트 디자인 정보를 불러온다 :: 사용자/관리자 모두 사용하기 때문에 여기서 선언
		# get_design 함수 할당 no(주키) => 서브 사용자가 존재할 경우 사용 대비용
		# get_logo 함수 할당 no(주키) => 서브 사용자가 존재할 경우 사용 대비용
		//$design_rolling_time = unserialize($design['rolling_time']);
		$logo = $logo_control->get_logo(1);
		//$popup = $popup_control->__PopupList();	// 팝업 리스트
		$is_popup = $popup_control->is_printPopup();	 // 팝업 여부

		$employ_logo = $logo_control->employ_logo();

		//$top_logo = $alice['data_logo_path']."/".$logo['top'];		// 상단 로고 파일



	   /*
		* 기본환경설정
		*/

		$time_zone = $config->time_zone;	// Time Zone

		ini_set("session.cache_expire", $env['session_time']); // 세션 캐쉬 보관시간 (분)
		ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
		ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
		ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

		@session_set_cookie_params(0, "/");
		ini_set("session.cookie_domain", $alice['cookie_domain']);


		// 세션 스타트~
		@session_start();

		###############################################################################################################
		# Mobile Checking
		$is_mobile = false;

		$mobile_checking = $config->mobile_checking( $_REQUEST );
		$is_mobile = $mobile_checking;

		$_SESSION['ss_is_mobile'] = $is_mobile;

		if($is_mobile) {	// 모바일의 경우 경로 재설정
			$session_data = $realpath . $application . "/data/session";
			@session_save_path($session_data);
		} else {
			@session_save_path($alice['session_path']);
        }

		/*
		if($_SESSION['ss_is_mobile'] == true){
			unset($_SESSION['ss_is_mobile']);
			$utility->popup_msg_js("",$alice['mobile_path']);
		}
		*/


		// 보안관련 :: PHPSESSID 가 틀리면 로그아웃한다. (그누보드 참고)
		if ($_REQUEST['PHPSESSID'] && $_REQUEST['PHPSESSID'] != session_id())
			die("PHPSESSID 가 일치하지 않습니다.");

		$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));


		##
		# admin session checking
		$is_admin = false;
		$is_super_admin = false;	// 최고관리자 체크
		$admin_info = $admin_control->__adminSessCheck();
		if($admin_info){
			$is_admin = true;
			if($admin_info['level']==10){
				$is_super_admin = true;
			}
			$admin_name = $admin_info['name'];
			$admin_nick = $admin_info['nick'];
		}

		$host_name = $HOST . '/' . $application;	// host name
		$remote_addr = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);			// 접속자 ip
		$referer     = mysql_real_escape_string($_SERVER['HTTP_REFERER']);				// 접근 경로
		$user_agent  = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);		// 접속자 브라우저
		$self_page = urlencode($_SERVER['PHP_SELF']);	// 현재 페이지를 알아내서 로그인 후 이동하도록 한다.

		if($_SESSION[$user_control->sess_user_val]){	// 로그인 중이라면

			$member = $user_control->get_member($_SESSION['sess_user_uid']);
			$member_com = $user_control->get_member_company($_SESSION['sess_user_uid']);

			// 오늘 처음 로그인 이라면
			if(substr($member['mb_last_login'], 0, 10) != $alice['time_ymd']){
				
				// 첫 로그인 포인트 지급
				$point_control->point_insert($member['mb_id'], $env['login_point'], $alice['time_ymd']." 첫로그인", "@login", $member['mb_id'], $alice['time_ymd']);

				// 해당 회원의 접근일시와 IP 를 저장
				$member_vals['mb_login_count'] = $member['mb_login_count'] + 1;
				$member_vals['mb_last_login'] = $now_date;
				$member_vals['mb_login_ip'] = $_SERVER['REMOTE_ADDR'];
				$user_control->user_update($member_vals, $member['mb_id']);

			}

		} else {

			/* 자동 로그인 */

		}

		##
		# User session checking
		$is_member = $is_guest = false;	 // 회원, 비회원 구분

		if ($member['mb_id']) {	// 현재 로그인한 회원 정보
			$is_member = true;
			$mb_type = $member['mb_type'];	// 회원 구분 ( individual : 개인회원 / company : 기업회원 )
			//$company_member = $user_control->get_member_company($member['mb_id']);	// 기업회원 정보
			$company_member = $user_control->get_company($member['mb_id']);	// 기업회원 정보
			$member_service = $member_control->get_service_member($member['mb_id']);	 // 서비스 정보
		} else {
			$is_guest = true;
			$member['mb_level'] = 1;	// 비회원은 level 1
		}

		##
		# Base variables
		$img_extension = $config->_img();	 // 이미지 확장자
		$upload_extension = $config->_upload();	 // 업로드 확장자
		$hp_num_cnt = count($config->hp_num);

		if (isset($url)) {
			$urlencode = urlencode($url);
		} else {
			$urlencode = urlencode($_SERVER['REQUEST_URI']);
		}

		
		// 통계
		$statistics_control->insert_visit();

		// 점프
		$alba_user_control->jump_update();
		$alba_resume_user_control->jump_update();


		// 정기메일링 설정 정보 추출
		$mailing_config = $mailing_control->get_config();
		$sms_company = unserialize($mailing_config['wr_sms_company']);	// (기업회원) 맞춤 인재정보 SMS 설정정보
		$sms_company_content = $sms_company['content'];
		$sms_company_use = $sms_company['use'];
		$sms_individual = unserialize($mailing_config['wr_sms_individual']);	// (개인회원) 맞춤 채용정보 SMS 설정정보
		$sms_individual_content = $sms_individual['content'];
		$sms_individual_use = $sms_individual['use'];

		// 정기메일링 자동 발송
		$mailing_control->auto_mailing( 1 );

		// 작업 및 debug 상태일때
		if( $is_debug == true ) {
			$_begin = $utility->get_time();		// 여기부터 속도측정을 시작한다.
		}



// : 그누보드용 함수파일 - netfu단어 들어가는 class도 이안에서 include합니다.
		include_once $alice['path'] . "engine/common.lib.php";

		$_cert_birth = preg_replace("/-/", "", $_SESSION['certify_info']['birth']);
		$_cert_hphone = preg_replace("/-/", "", $_SESSION['certify_info']['hphone']);
		if($_cert_hphone) {
			$_cert_hphone_arr[0] = substr($_cert_hphone,0,3);
			$_cert_hphone_arr[1] = strlen($_cert_hphone)==11 ? substr($_cert_hphone,3,4) : substr($_cert_hphone,3,3);
			$_cert_hphone_arr[2] = strlen($_cert_hphone)==11 ? substr($_cert_hphone,7,4) : substr($_cert_hphone,6,4);
		}

		$_member_write_input_view = !$is_member && $_SESSION['certify_info'] ? true : false;
		$_mb_birth = $member['mb_birth'] ? $member['mb_birth'] : ($_cert_birth ? substr($_cert_birth,0,4).'-'.substr($_cert_birth,4,2).'-'.substr($_cert_birth,6,2) : '');
		$_mb_name = $member['mb_name'] ? $member['mb_name'] : $_SESSION['certify_info']['name'];
		$_mb_hphone = $member['mb_hphone'] ? $member['mb_hphone'] : @implode("-", $_cert_hphone_arr);
		$_mb_gender = $member['mb_id'] ? $member['mb_gender'] : $_SESSION['certify_info']['gender'];

// : SNS사용여부정보
		$sns_feed = explode(',', $env['sns_feed']);


// : 결제금액 모음
		$service_price_moim_query = sql_query("select * from alice_payment_package");
		while($row=sql_fetch_array($service_price_moim_query)){
			$service_price_moim['package'][$row['no']] = $row;
		}

		$service_price_moim_query = sql_query("select * from alice_service");
		while($row=sql_fetch_array($service_price_moim_query)){
			$service_price_moim['service'][$row['no']] = $row;
		}




		// : 아이콘 정보
		$__alba_icon = $category_control->category_codeList('alba_option_icon');
		$__resume_icon = $category_control->category_codeList('resume_option_icon');
		if(is_array($__alba_icon)) foreach($__alba_icon as $k=>$v) $__alba_icon_arr[$v['no']] = $v;
		if(is_array($__resume_icon)) foreach($__resume_icon as $k=>$v) $__resume_icon_arr[$v['no']] = $v;
?>