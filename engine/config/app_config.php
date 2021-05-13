<?php
		/**
		* /engine/config/app_config.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Application Configuration
		* @Comment :: 기본 환경설정 및 변수 정의
		*/

		// 상수설정
		define("_ALICE_", TRUE);
		define("DOMAIN", 'http://'.$_SERVER['HTTP_HOST']);
		if (function_exists("date_default_timezone_set")) date_default_timezone_set("Asia/Seoul");

		define('_ALICE_ALPHAUPPER_', 1); // 영대문자
		define('_ALICE_ALPHALOWER_', 2); // 영소문자
		define('_ALICE_ALPHABETIC_', 4); // 영대,소문자
		define('_ALICE_NUMERIC_', 8); // 숫자
		define('_ALICE_HANGUL_', 16); // 한글
		define('_ALICE_SPACE_', 32); // 공백
		define('_ALICE_SPECIAL_', 64); // 특수문자

		$is_debug	= false;	// 디버깅 모드 설정
		$is_demo	= false;	// 데모 설정
		$is_html5	= true;	// HTML5 사용
		$is_https	= false;	// https 사용 유무

		$is_employ = false;		// 채용공고 사용/미사용
		$is_alba = true;				//  사용/미사용

		$HOST = $_SERVER['HTTP_HOST'];	 // 사이트 도메인

		/* 기본 설정 및 경로 설정 */
		$alice['charset']	= "utf-8";				// 언어셋 설정 (기본 :: UTF-8)
		$alice['author']	= "Netfu™";			// 제작자
		$alice['author_url']	= "<a href='http://netfu.co.kr' target='_blank'>http://netfu.co.kr</a>";
		$alice['author_tel']	= "Tel. <a tel='1544-9638'>1544-9638</a>";

		$alice['url']		= "";						// Application URL
		$alice['https_url'] = "";					// Application HTTPS URL

		$alice['self']		= "./";					// 현재 경로

		$alice['app']				= "./";
		$alice['app_path']		= $alice['path'];
		/* //기본 설정 및 경로 설정 */

		/* engine 디렉토리 절대 수정/삭제 금지 !! */
		$alice['engine']			= "engine";		// Engine Directory
		$alice['engine_path']	= $alice['path'] . $alice['engine'];
		/* // engine 디렉토리 절대 수정/삭제 금지 !! */

		/* Helper 경로 설정 */
		$alice['helpers']			= "_helpers";
		$alice['helpers_path']	= $cat_path . $alice['helpers'];

		$alice['helper_css']				= "_css";		// Helper CSS
		$alice['helper_css_path']		= $alice['helpers_path'] . "/" . $alice['helper_css'];

		$alice['fonts']				= "fonts";
		$alice['fonts_path']		= $alice['helper_css_path'] . "/" . $alice['fonts'];

		$alice['plugins']			= "plugins";
		$alice['plugins_path']	= $alice['helper_css_path'] . "/" . $alice['plugins'];

		$alice['themes']			= "themes";
		$alice['themes_path']	= $alice['helper_css_path'] . "/" . $alice['themes'];

		$alice['editor']			= "_editor";	// Editor 디렉토리
		$alice['editor_path']	= $alice['helpers_path'] . "/" . $alice['editor'];	// 사용하고자 하는 Editor 를 선택

		$alice['helper_img']			= "_images";	// 기본 Images
		$alice['helper_img_path']	= $alice['helpers_path'] . "/" . $alice['helper_img'];

		$alice['js']					= "_js";			// 기본 Javascript Library
		$alice['js_path']			= $alice['helpers_path'] . "/" . $alice['js'];
		$alice['js_i18n']			= $alice['helpers_path'] . "/" . $alice['js'] . "/i18n";		// Javascript 언어 셋
		$alice['js_plugin']		= $alice['helpers_path'] . "/" . $alice['js'] . "/plugin";		// jQuery Plugin
		$alice['js_ui']				= $alice['helpers_path'] . "/" . $alice['js'] . "/ui";			// jQuery UI
		/* //Helper 경로 설정 */


		/* 일반 경로 설정 */
		$alice['css']						= "css";		//  CSS
		$alice['css_path']				= $cat_path . $alice['css'];
		$alice['css_abs_path']			= $alice['app_path'] . "/" . $alice['css'];

		$alice['images']					= 'images';			// Images Directory
		$alice['images_path']			= $cat_path . $alice['images'];
		$alice['images_abs_path']	= $alice['app_path'] . "/" . $alice['images'];

		$alice['style_path']				= $cat_path . "css";						// CSS Save Directory for User
		$alice['admin_style_path']	= $alice['app_path'] . "/css";			// CSS Save Directory for Admin

		/* //일반 경로 설정 */


		/* Application 영역 경로 설정 */
		$alice['board']					= "board";			// Board Directory
		$alice['board_path']			= $cat_path . $alice['board'];
		$alice['board_abs_path']		= $alice['app_path'] . "/" . $alice['board'];

		$alice['include']					= 'include';			// Include Directory
		$alice['include_path']			= $cat_path . $alice['include'];
		$alice['include_abs_path']	= $alice['app_path'] . "/" . $alice['include'];

		$alice['main']						= 'main';			// Main Directory
		$alice['main_path']				= $cat_path . $alice['main'];
		$alice['main_abs_path']		= $alice['app_path'] . "/" . $alice['main'];

		$alice['member']				= "member";		// Member Directory
		$alice['member_path']		= $cat_path . $alice['member'];
		$alice['member_abs_path']	= $alice['app_path'] . "/" . $alice['member'];

		$alice['mypage']					= 'mypage';		// Mypage Directory
		$alice['mypage_path']			= $cat_path . $alice['mypage'];
		$alice['mypage_abs_path']	= $alice['app_path'] . "/" . $alice['mypage'];

		$alice['map']						= 'map';			// Map Directory
		$alice['map_path']				= $cat_path . $alice['map'];
		$alice['map_abs_path']		= $alice['app_path'] . "/" . $alice['map'];

		$alice['individual']					= 'individual';		// Individual Directory
		$alice['individual_path']			= $cat_path . $alice['individual'];
		$alice['individual_abs_path']	= $alice['app_path'] . "/" . $alice['individual'];

		$alice['company']					= 'company';		// Company Directory
		$alice['company_path']			= $cat_path . $alice['company'];
		$alice['company_abs_path']	= $alice['app_path'] . "/" . $alice['company'];

		$alice['inipay']					= 'inipay';		// INIpay Directory
		$alice['inipay_path']			= $cat_path . $alice['inipay'];
		$alice['inipay_abs_path']		= $alice['app_path'] . "/" . $alice['inipay'];

		$alice['ags']						= 'ags';		// Allthegate Directory
		$alice['ags_path']				= $cat_path . $alice['ags'];
		$alice['ags_abs_path']		= $alice['app_path'] . "/" . $alice['ags'];

		$alice['alba']						= "job";		// Alba Directory
		$alice['alba_path']				= $cat_path . $alice['alba'];
		$alice['alba_abs_path']		= $alice['app_path'] . "/" . $alice['alba'];

		$alice['resume']						= "resume";		// Alba Resume Directory
		$alice['resume_path']				= $cat_path . $alice['resume'];
		$alice['resume_abs_path']		= $alice['app_path'] . "/" . $alice['resume'];

		$alice['service']					= "service";	// Service Directory
		$alice['service_path']			= $cat_path . $alice['service'];
		$alice['service_abs_path']	= $alice['app_path'] . "/" . $alice['service'];

		$alice['send']						= "send";	// Send Directory
		$alice['send_path']				= $cat_path . $alice['send'];
		$alice['send_abs_path']		= $alice['app_path'] . "/" . $alice['send'];

		$alice['popup']					= "popup";	// Popup Directory
		$alice['popup_path']			= $cat_path . $alice['popup'];
		$alice['popup_abs_path']		= $alice['app_path'] . "/" . $alice['popup'];

		$alice['rss']						= "rss";	// RSS Directory
		$alice['rss_path']				= $cat_path . $alice['rss'];
		$alice['rss_abs_path']			= $alice['app_path'] . "/" . $alice['rss'];


		$alice['admin']								= "nad";			// Admin Directory
		$alice['admin_path']						= $cat_path . $alice['admin'];
		$alice['admin_abs_path']	 				= $alice['app_path'] . "/" . $alice['admin'];

		$alice['admin_board']						= "board";			// Admin Board Directory
		$alice['admin_board_path']				= $cat_path . $alice['admin'] . "/" . $alice['admin_board'];
		$alice['admin_board_abs_path']		= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_board'];

		/* 필요한 경우 디렉토리 생성하여 사용하세요.
		$alice['admin_css']							= "css";			// Admin Board Directory
		$alice['admin_css_path']					= $cat_path . $alice['admin'] . "/" . $alice['admin_css'];
		$alice['admin_css_abs_path']			= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_css'];
		*/

		$alice['admin_config']						= "config";			// Admin Config Directory
		$alice['admin_config_path']				= $cat_path . $alice['admin'] . "/" . $alice['admin_config'];
		$alice['admin_config_abs_path']	 	= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_config'];

		$alice['admin_design']					= "design";			// Admin Design Directory
		$alice['admin_design_path']			= $cat_path . $alice['admin'] . "/" . $alice['admin_design'];
		$alice['admin_design_abs_path']	 	= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_design'];

		$alice['admin_main']						= "main";			// Admin Main Directory
		$alice['admin_main_path']				= $cat_path . $alice['admin'] . "/" . $alice['admin_main'];
		$alice['admin_main_abs_path']		= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_main'];

		$alice['admin_member']					= "member";			// Admin Member Directory
		$alice['admin_member_path']			= $cat_path . $alice['admin'] . "/" . $alice['admin_member'];
		$alice['admin_member_abs_path']	= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_member'];

		$alice['admin_payment']					= "payment";			// Admin Payment Directory
		$alice['admin_payment_path']			= $cat_path . $alice['admin'] . "/" . $alice['admin_payment'];
		$alice['admin_payment_abs_path']	= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_payment'];

		$alice['admin_alba']						= "alba";			// Admin Alba Directory
		$alice['admin_alba_path']				= $cat_path . $alice['admin'] . "/" . $alice['admin_alba'];
		$alice['admin_alba_abs_path']			= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_alba'];

		$alice['admin_statistics']					= "statistics";			// Admin Statistics Directory
		$alice['admin_statistics_path']			= $cat_path . $alice['admin'] . "/" . $alice['admin_statistics'];
		$alice['admin_statistics_abs_path']	= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_statistics'];

		$alice['admin_mobile']					= "mobile";			// Admin Mobile Directory
		$alice['admin_mobile_path']			= $cat_path . $alice['admin'] . "/" . $alice['admin_mobile'];
		$alice['admin_mobile_abs_path']		= $alice['app_path'] . "/" . $alice['admin'] . "/" . $alice['admin_mobile'];

		$alice['admin_pop']					= "pop";		// Admin Popup Directory
		$alice['admin_pop_path']			= $alice['admin_path'] . "/" . $alice['admin_pop'];
		$alice['admin_pop_url']				= "/" . $alice['admin'] . "/" . $alice['admin_pop'];
		/* //Application 영역 경로 설정 */


		/* 추가 모듈 경로 설정 */
		$alice['modules']				= 'modules';		// Modules Add Directory
		$alice['modules_path']		= $cat_path . $alice['modules'];
		$alice['modules_abs_path']	= $alice['app_path'] . "/" . $alice['modules'];

		$alice['paygate']					= 'paygate';	// PayGate Module
		$alice['paygate_path']			= $alice['modules_path'] . "/" . $alice['paygate'];
		$alice['paygate_abs_path']	= $alice['modules_abs_path'] . "/" . $alice['paygate'];

		$alice['okname']					= 'okname';	// 실명인증 Module (okname)
		$alice['okname_path']			= $alice['modules_path'] . "/" . $alice['okname'];
		$alice['okname_abs_path']	= $realpath . $alice['app'] . "/" . $alice['modules'] . "/" . $alice['okname'];

		$ok_name_glibc = "linux32_nonstatic_glibc2.3.4";	 // 버전에 따라 다르기 때문에 경로를 확인하여 맞게 설정해 주면 된다.
		$alice['okname_gblib_path']	= $alice['modules_path'] . "/" . $alice['okname'] . "/" . $ok_name_glibc;
		$alice['okname_gblib_abs_path']	= $realpath . $alice['app'] . "/" . $alice['modules'] . "/" . $alice['okname'] . "/" . $ok_name_glibc;
		/* //추가 모듈 경로 설정 */


		/* 모바일 경로 설정 */
		$alice['mobile']					= "/";
		$alice['mobile_path']			= $cat_path . $alice['mobile'];
		$alice['mobile_abs_path']	= $realpath . $alice['mobile'];
		/* //모바일 경로 설정 */


		/* DATA 저장 경로 설정 */
		$alice['data']					= "data";		// Attach file Directory
		$alice['data_path']				= $cat_path . $alice['data'];
		$alice['data_abs_path']		= $realpath . $alice['data'];

		// 세션 경로
		$alice['session_path']					= $alice['data_path'] . "/session";			// Save session Directory
		$alice['session_abs_path']			= $alice['data_abs_path'] . "/session";		// Save session absolute Directory

		// 임시 경로 (에디터등 에서 파일 첨부시 사용)
		$alice['tmp_path']						= $alice['data_path'] . "/tmp";					// Attach temp Directory
		$alice['tmp_abs_path']				= $alice['data_abs_path'] . "/tmp";			// Attach temp absolute Directory

		// 기본 경로
		$alice['peg_path']						= $alice['data_path'] . "/peg";					// Attach peg Directory
		$alice['peg_abs_path']				= $alice['data_abs_path'] . "/peg";			// Attach peg absolute Directory

		$alice['data_banner_path']			= $alice['data_path'] . "/banner";	 			// Attach banner Directory
		$alice['data_banner_abs_path']	= $alice['data_abs_path'] . "/banner";		// Attach banner absolute Directory

		$alice['data_board_path']			= $alice['data_path'] . "/board";				// Attach board Directory
		$alice['data_board_abs_path']		= $alice['data_abs_path'] . "/board";		// Attach board absolute Directory

		$alice['data_notice_path']			= $alice['data_board_path'] . "/notice";		// Attach notice Directory
		$alice['data_notice_abs_path']		= $alice['data_board_abs_path'] . "/notice";	// Attach notice absolute Directory

		$alice['data_db_path']					= $alice['data_path'] . "/db";					// Attach db Directory
		$alice['data_db_abs_path']			= $alice['data_abs_path'] . "/db";			// Attach db absolute Directory

		$alice['data_design_path']			= $alice['data_path'] . "/design";				// Attach design Directory
		$alice['data_design_abs_path']	= $alice['data_abs_path'] . "/design";		// Attach design absolute Directory

		$alice['data_logo_path']				= $alice['data_path'] . "/logo";					// Attach logo Directory
		$alice['data_logo_abs_path']		= $alice['data_abs_path'] . "/logo";			// Attach logo absolute Directory

		$alice['data_member_path']		= $alice['data_path'] . "/member";			// Attach member Directory
		$alice['data_member_abs_path']	= $alice['data_abs_path'] . "/member";	// Attach member absolute Directory

		$alice['data_nad_path']				= $alice['data_path'] . "/nad";					// Attach nad Directory
		$alice['data_nad_abs_path']		= $alice['data_abs_path'] . "/nad";			// Attach nad absolute Directory

		$alice['data_popup_path']			= $alice['data_path'] . "/popup";				// Attach popup Directory
		$alice['data_popup_abs_path']		= $alice['data_abs_path'] . "/popup";		// Attach popup absolute Directory

		$alice['data_popup_path']			= $alice['data_path'] . "/popup";				// Attach popup Directory
		$alice['data_popup_abs_path']		= $alice['data_abs_path'] . "/popup";		// Attach popup absolute Directory

		$alice['data_icon_path']				= $alice['data_path'] . "/icon";					// Attach icon Directory
		$alice['data_icon_abs_path']		= $alice['data_abs_path'] . "/icon";			// Attach icon absolute Directory

		$alice['data_alba_path']				= $alice['data_path'] . "/alba";					// Attach alba Directory
		$alice['data_alba_abs_path']		= $alice['data_abs_path'] . "/alba";			// Attach alba absolute Directory

		$alice['data_email_path']			= $alice['data_path'] . "/email";				// Attach email Directory
		$alice['data_email_abs_path']		= $alice['data_abs_path'] . "/email";		// Attach email absolute Directory

		$alice['data_tmp_path']			= $alice['data_path'] . "/tmp";				// Attach temp Directory
		$alice['data_tmp_url']				= $alice['data_url'] . "/tmp";
		/* //DATA 저장 경로 설정 */


	   /*
		*
		* 각종 환경 변수
		* 사이트 관리자 컨트롤 할 필요(또는 할수) 없는 소스상의 변수들
		*
		*/		
		$alice['cookie_domain']	= "";
		$alice['server_time']		= time();
		$alice['time_ymd']			= date("Y-m-d", $alice['server_time']);
		$alice['time_his']			= date("H:i:s", $alice['server_time']);
		$alice['time_ymdhis']		= date("Y-m-d H:i:s", $alice['server_time']);

		$alice['table_prefix']		= "alice_"; // 테이블명 접두사
		$alice['write_prefix']		= $alice['table_prefix'] . "write_"; // 게시판 테이블명 접두사

		$ym				= date("ym", $alice['server_time']);
		$today2			= $alice['time_ymd'];	// 년도 2자리
		$now_date		= date('Y-m-d H:i:s');	// 현재 시각
		$cur_date		= date('Y-m-d');			// 현재 날짜
		$token			= uniqid(time());		// 토큰값


	   /*
		* 추가 Library Call
		*
		*/		
		// session 디렉토리의 경우 재생성 해줘야 할때가 있다.
		if(!is_dir($alice['session_path'])){	// 세션 디렉토리가 없다면 생성
			$index_file = $alice['session_path'] . '/index.html';
			if(!file_exists($index_file)){	 // 디렉토리 보안을 위해
				@mkdir($alice['session_path'], 0707); @chmod($alice['session_path'], 0707);	// 우선 디렉토리 먼저 만들고
				$f = @fopen($index_file, "w"); @fwrite($f, ""); @fclose($f); @chmod($index_file, 0606);	// index.html 파일 생성
			}
		}

?>