<?php
		/**
		* /engine/library/config.class.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/11/18
		* @Module v3.5 ( Alice )
		* @Brief :: Config Class
		* @Comment :: 사이트 및 기타 환경설정
		*/
		class config extends DBConnection {

				var $config_table		= "alice_config";		// Config Table Name
				var $visit_table			= "alice_visit";
				var $visit_page_table	= "alice_visit_page";
				var $visit_sum_table	= "alice_visit_sum";


				var $time_zone = array(		// time zone
							'-1200' => '[GMT -12:00] Baker Island Time',
							'-1100' => '[GMT -11:00] Niue Time, Samoa Standard Time',
							'-1000' => '[GMT -10:00] Hawaii-Aleutian Standard Time, Cook Island Time',
							'-0930' => '[GMT -09:30] Marquesas Islands Time',
							'-0900' => '[GMT -09:00] Alaska Standard Time, Gambier Island Time',
							'-0800' => '[GMT -08:00] Pacific Standard Time',
							'-0700' => '[GMT -07:00] Mountain Standard Time',
							'-0600' => '[GMT -06:00] Central Standard Time',
							'-0500' => '[GMT -05:00] Eastern Standard Time',
							'-0400' => '[GMT -04:00] Atlantic Standard Time',
							'-0330' => '[GMT -03:30] Newfoundland Standard Time',
							'-0300' => '[GMT -03:00] Amazon Standard Time, Central Greenland Time',
							'-0200' => '[GMT -02:00] Fernando de Noronha Time, South Georgia &amp; the South Sandwich Islands Time',
							'-0100' => '[GMT -01:00] Azores Standard Time, Cape Verde Time, Eastern Greenland Time',
							'0000'  => '[GMT  00:00] Western European Time, Greenwich Mean Time',
							'+0100' => '[GMT +01:00] Central European Time, West African Time',
							'+0200' => '[GMT +02:00] Eastern European Time, Central African Time',
							'+0300' => '[GMT +03:00] Moscow Standard Time, Eastern African Time',
							'+0330' => '[GMT +03:30] Iran Standard Time',
							'+0400' => '[GMT +04:00] Gulf Standard Time, Samara Standard Time',
							'+0430' => '[GMT +04:30] Afghanistan Time',
							'+0500' => '[GMT +05:00] Pakistan Standard Time, Yekaterinburg Standard Time',
							'+0530' => '[GMT +05:30] Indian Standard Time, Sri Lanka Time',
							'+0545' => '[GMT +05:45] Nepal Time',
							'+0600' => '[GMT +06:00] Bangladesh Time, Bhutan Time, Novosibirsk Standard Time',
							'+0630' => '[GMT +06:30] Cocos Islands Time, Myanmar Time',
							'+0700' => '[GMT +07:00] Indochina Time, Krasnoyarsk Standard Time',
							'+0800' => '[GMT +08:00] Chinese Standard Time, Australian Western Standard Time, Irkutsk Standard Time',
							'+0845' => '[GMT +08:45] Southeastern Western Australia Standard Time',
							'+0900' => '[GMT +09:00] Korea Standard Time, Japan Standard Time, China Standard Time',
							'+0930' => '[GMT +09:30] Australian Central Standard Time',
							'+1000' => '[GMT +10:00] Australian Eastern Standard Time, Vladivostok Standard Time',
							'+1030' => '[GMT +10:30] Lord Howe Standard Time',
							'+1100' => '[GMT +11:00] Solomon Island Time, Magadan Standard Time',
							'+1130' => '[GMT +11:30] Norfolk Island Time',
							'+1200' => '[GMT +12:00] New Zealand Time, Fiji Time, Kamchatka Standard Time',
							'+1245' => '[GMT +12:45] Chatham Islands Time',
							'+1300' => '[GMT +13:00] Tonga Time, Phoenix Islands Time',
							'+1400' => '[GMT +14:00] Line Island Time'
				);

				var $success_code = array(
						'0000' => '입력 되었습니다.',
						'0001' => '입력이 완료 되었습니다.',
						'0002' => '저장 되었습니다.',
						'0003' => '저장이 완료 되었습니다.',
						'0004' => '등록 되었습니다.',
						'0005' => '등록이 완료 되었습니다.',
						'0006' => '수정 되었습니다.',
						'0007' => '수정이 완료 되었습니다.',
						'0008' => '변경 되었습니다.',
						'0009' => '변경이 완료 되었습니다.',
						'0010' => '삭제 되었습니다.',
						'0011' => '삭제가 완료 되었습니다.',
						'0012' => '업로드 되었습니다.',
						'0013' => '업로드가 완료 되었습니다.',
						'0014' => '업데이트 되었습니다.',
						'0015' => '업데이트가 완료 되었습니다.',
						'0016' => '설정 되었습니다.',
						'0017' => '설정이 완료 되었습니다.',
						'0018' => '설정이 변경 되었습니다.',
						'0019' => '순위가 변경 되었습니다.',
						'0020' => '출력설정이 변경 되었습니다.',
						'0021' => '지도 설정이 완료 되었습니다.',
						'0022' => '내/외국인 등록폼 설정이 완료 되었습니다.',
						'0023' => 'Quick 메뉴가 설정되었습니다.',
				);

				var $fail_code = array(
						'0000' => '잘못된 방법으로 변수가 정의 되었습니다.',
						'0001' => '토큰에러',
						'0002' => '잘못된 접근입니다.',
						'0003' => '정상적인 접근이 아닌것 같습니다.',
						'0004' => '입력중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0005' => '저장중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0006' => '등록중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0007' => '수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0008' => '변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0009' => '설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0010' => '삭제중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0011' => '업로드중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0012' => '이미지 업로드중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0013' => '파일 업로드중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0014' => '업데이트중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0015' => '이미지 업데이트중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0016' => '파일 업데이트중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0017' => '순위 조절중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0018' => '순위 변경중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0019' => '일괄 적용중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0020' => '출력 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0021' => '출력 설정 수정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0022' => '복사중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0023' => '데모 버전에선 사용할 수 없는 기능입니다.\\n\\n솔루션 개발사 :: `넷퓨(http://netfu.co.kr)` 에 문의하세요.',
						'0024' => '이미지만 업로드 가능합니다.',
						'0025' => 'ZIP 파일만 업로드 가능합니다.',
						'0026' => '내용에 삽입할 이미지를 선택해 주세요',
						'0027' => '이메일 주소가 올바르지 않습니다.',
						'0028' => '이메일 주소를 입력해 주세요.',
						'0029' => '이메일 주소가 너무 짧습니다 최소 8자 이상 입력해 주세요',
						'0030' => 'SESSION 발급시 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0031' => '검색 방식이 잘못 되었습니다.',
						'0032' => '검색어를 입력해 주세요.',
						'0033' => '검색할수 없는 URL 입니다\\n\\n\'http://\' 를 포함한 URL 형식을 입력해 주세요.',
						'0034' => '내용에 올바르지 않은 코드가 다수 포함되어 있습니다.',
						'0035' => '찾을 이미지(동영상)의 URL 을 입력해 주세요.',
						'0036' => '등록하실 이미지(동영상)를 선택해 주세요.',
						'0037' => '도메인 및 파일 확장자를 확인해 주세요.',
						'0038' => '업로드 값이 존재 하지 않습니다\\n\\n이미지나 동영상을 업로드해 주세요.',
						'0039' => '업로드가 불가능한 파일 입니다.',
						'0040' => '삭제할 항목이 없거나 이미 삭제된 항목 입니다.',
						'0041' => '제목을 입력해 주세요.',
						'0042' => '내용을 입력해 주세요.',
						'0043' => '설명글을 작성해 주세요.',
						'0044' => '업로드할 이미지나 동영상을 선택해주세요.',
						'0045' => '파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0046' => '자동등록방지 글을 정확히 입력해 주세요.',
						'0047' => 'IFRAME 태그는 검색이 불가능합니다.\\n\\nIFRAME 내 src 경로를 검색해 주세요.',
						'0048' => '리스트를 출력할 수 없습니다.',
						'0049' => '페이지를 출력(표시)할 수 없습니다.',
						'0050' => '관리자 페이지는 관리자만 글 작성이 가능합니다.',
						'0051' => '파비콘 확장자를 확인해 주세요.\\n\\n파비콘 등록시 파일 확장자는 ( .ico ) 입니다.',
						'0052' => '이동할 항목을 선택해 주세요.\\n\\n항목 필드를 클릭하시면 선택됩니다.',
						'0053' => '비밀번호(패스워드)가 일치하지 않습니다.',
						'0054' => '파일이 존재하지 않습니다.',
						'0055' => '지도 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0056' => '내/외국인 설정중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0057' => '설정 저장중 오류가 발생하였습니다.\\n\\n솔루션 개발사 :: `넷퓨(Netfu)` 1:1 게시판에 문의하세요.',
						'0058' => '고유값 (no) 가 필요합니다.',
						'0059' => 'Quick menu 수정중 오류가 발생하였습니다.',

				);

				var $ui_themes_arr = array(		// jquery UI themes
						'black-tie' => 'Black Tie', 'blitzer' => 'Blitzer', 'cupertino' => 'Cupertino', 'dark-hive' => 'Dark Hive', 'dot-luv' => 'Dot Luv', 
						'eggplant' => 'Eggplant', 'excite-bike' => 'Excite Bike', 'flick' => 'Flick', 'hot-sneaks' => 'Hot Sneaks', 'humanity' => 'Humanity', 'le-frog' => 'Le Frog', 
						'mint-choc' => 'Mint Choc', 'overcast' => 'Overcast', 'pepper-grinder' => 'Pepper Grinder', 'redmond' => 'Redmond', 'smoothness' => 'Smoothness', 
						'south-street' => 'South Street', 'start' => 'Start', 'sunny' => 'Sunny', 'swanky-purse' => 'Swanky Purse', 'trontastic' => 'Trontastic', 
						'ui-darkness' => 'UI darkness', 'ui-lightness' => 'UI lightness', 'vader' => 'Vader',
					/* 필요한 경우 _helpers/_css/themes/ 에 업로드 하고, 배열 추가하면 됩니다. */
				);


				/*
				var $color_arr = array(	// Site skin Color
						'gr' => 'bbbbbb', 'yel' => 'fbae00', 'org' => 'ea5d05', 'dho' => 'e82626', 'red' => 'f20000', 'pk' => 'c4228e', 'pp' => '6721ac', 'lgr' => '619d0e', 'grn' => '2c7b04', 'bgr' => '0f879c', 'wbl' => '158fe7', 'dbl' => '214eaa', 'bk' => '000000'
				);
				*/

				var $img_extension = array( 'jpg', 'gif', 'png', 'bmp' );	// 이미지 업로드 확장자
				var $upload_extension = array( 'jpg', 'gif', 'png', 'bmp', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'hwp', 'pdf', 'zip', 'rar' );	// 업로드 가능 확장자

				var $local_num = array( "02" => "서울 (02)", "031" => "경기 (031)", "032" => "인천 (032)", "033" =>"강원 (033)", "041" =>"충남 (041)", "042" => "대전 (042)", "043" =>"충북 (043)", "044" => "세종 (044)", "051" =>"부산 (051)", "052" => "울산 (052)", "053" => "대구 (053)", "054" => "경북 (054)", "055" => "경남 (055)", "061" => "전남 (061)", "062" => "광주 (062)", "063" => "전북 (063)", "064" => "제주 (064)", "060" => "인터넷 (060)", "070" => "인터넷 (070)", "080" => "인터넷 (080)", "0502" => "평생번호(0502)", "0503" => "평생번호(0503)" );

				var $tel_num = array( "02" , "031", "032", "033", "041", "042", "043", "044", "051", "052", "053", "054", "055", "061", "062", "063", "064", "060", "070", "080", "0502", "0503" );

				var $hp_num = array( "010", "011", "016", "017", "018", "019" );


				// 기본 환경설정 Initialize
				function _init( $no ) {

						if(!$no) return false;

						$query = " select * from `".$this->config_table."` where `no` = '".$no."' ";

						$result = $this->query_fetch($query);

					
					return $result;

				}


				// 기본 환경설정 특정 항목만 추출
				function _env( $no, $field ){
					
						if(!$no || !$field) return false;

						$query = $this->query_fetch(" select `".$field."` from `".$this->config_table."` where `no` = '".$no."' ");

						$result = $query[$field];

					
					return $result;

				}


				// 기본 헤더 설정 (사용자측)
				function _user_header( $body_attr='', $css='', $css_media='', $plugin='', $view="" ){
					global $head_title;

					global $alice, $env, $utility;		// 기본설정 변수
					global $design, $logo;				// 디자인 변수
					global $is_debug, $is_demo, $is_html5, $is_member, $is_https;	// 확인 변수
					global $ym, $host_name;	// 데이터에 따른 header 정보
					global $member, $netfu_util;	// 회원 정보

						if($is_html5){
							$result  = "<!DOCTYPE html>\n";
							$result .= "<html class=\"".$utility->get_user_agent()."\">\n";
						} else {
							$result  = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
							$result .= "<html lang=\"ko\" xml:lang=\"ko\" xmlns=\"http://www.w3.org/1999/xhtml\">\n";
						}

						$result .= "<head>\n";

						$https_url_chk = $is_https ? "https://" : "http://";
						
						if($view){	// view 가 있을땐 SEO 에 맞춘 헤더 정보 출력
							$_title_txt = $view['wr_subject']." - ".stripslashes($env['site_title'])."\n";
						} else {
							$_title_txt = stripslashes($env['site_title'])."\n";
						}

						// : 선언된 타이틀값이 있으면 타이틀값으로 출력합니다.
						if($head_title) $_title_txt = $head_title." - ".$env['site_title'];
						$result .= '<title>'.$_title_txt.'</title>';

						$result .= '<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"><meta http-equiv="X-UA-Compatible" content="IE=Edge">';

						$result .= "<meta charset=\"".$alice['charset']."\" />\n";
						$result .= "<meta name=\"Author\" content=\"".$env['meta_author']."\" />\n";
						$result .= "<meta name=\"Reply-to\" content=\"".stripslashes($env['email'])."\" />\n";
						//$result .= "<meta name=\"Generator\" content=\"html php mysql\" />\n";	// 작성 언어(툴)

						$meta_description = stripslashes($env['meta_description']);
						$result .= "<meta name=\"Description\" content=\"".$meta_description."\" />\n";			// 문서에 대한 간단한 설명글을 지정

						$result .= "<meta name=\"Copyright\" content=\"".stripslashes($env['meta_copyright'])."\" />\n";				// 저작권 정보
						$result .= "<meta name=\"Keywords\" content=\"".stripslashes($env['meta_keywords'])."\" />\n";				// 문서의 주요 키워드를 콤마(,)로 구분하여 나열
						$result .= "<meta name=\"Classification\" content=\"".stripslashes($env['meta_classifiction'])."\" />\n";		// 기본 카테고리의 위치나 분류
						$result .= "<meta name=\"Location\" content=\"".$utility->add_http($_SERVER['HTTP_HOST'])."\" />\n";		// 도메인
						$result .= "<meta name=\"Publisher\" content=\"".stripslashes($env['meta_publisher'])."\" />\n";				// 퍼블리셔명
						$result .= "<meta name=\"subject\" content=\"".$_title_txt."\" />\n";
						$result .= "<meta name=\"title\" content=\"".$_title_txt."\" />\n";
						$result .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$alice['charset']."\" />\n";

						$og_title = ($view) ? stripslashes($view['wr_subject']) : $_title_txt;
						$og_url = ($view) ? $https_url_chk.$host_name."alba/alba_detail.php?no=".$view['no'] : $https_url_chk . $host_name;							
						$view_image = $https_url_chk . $host_name . "data/logo/" . $logo['top'];
						$alba_image = ($view) ? $https_url_chk . $host_name . "data/alba/".$view['etc_0'] : "";
						$og_img = ($view) ? $alba_image : $view_image;

						$result .= "<meta property=\"og:url\" content=\"".$og_url."\" />\n";
						$result .= "<meta property=\"og:title\" content=\"".$og_title."\"/>\n";
						$result .= "<meta property=\"og:type\" content=\"website\"/>\n";
						$result .= "<meta property=\"og:image\" content=\"".$og_img."\"/>\n";
						$result .= "<meta property=\"og:site_name\" content=\"".stripslashes($env['site_name'])."\"/>\n";
						$result .= "<meta property=\"og:description\" content=\"".$meta_description."\"/>\n";
						
						$result .= "<meta property=\"twitter:card\" content=\"summary\" />\n";
						$result .= "<meta property=\"twitter:title\" content=\"".$og_title."\"/>\n";
						$result .= "<meta property=\"twitter:image\" content=\"".$og_img."\"/>\n";
						$result .= "<meta property=\"twitter:site\" content=\"".stripslashes($env['site_name'])."\"/>\n";
						$result .= "<meta property=\"twitter:description\" content=\"".$meta_description."\"/>\n";

						$result .= "<link rel=\"canonical\" href=\"http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].  "\" />\n";
						$result .= "<link type=\"image/x-icon\" rel=\"shortcut icon\" href=\"".$alice['peg_path']."/".$env['favicon']."\" />\n";	 // 파비콘
						$result .= $this->_style( $css, $css_media );	// default CSS

						if(!$design['site_color'])	// 사이트 색상 스킨사용시
							$result .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $alice['css_path'] . "/" . $design['skin_color'] . ".css?t=".date('YmdH')."&ver=161020\"/>\n";

						//$result .= $this->_ui_theme($design['ui_theme']);	// jquery UI Theme
						$result .= $this->_ui_theme('_base', 'jquery-ui.min.css');	// jquery UI Theme
						

						$result .= "<!--[if IE 6]>\n";
						$result .= "<script type=\"text/javascript\" src=\"" . $alice['js_path'] . "/unitpngfix.js\"></script>\n";
						$result .= "<![endif]-->\n";

						/*$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/jquery.min.js?t=".date('YmdH')."'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_ui'] . "/jquery-ui.min.js?t=".date('YmdH')."'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/plugin/jquery.form.js?t=2018010121'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_i18n'] . "/jquery.ui.datepicker-ko.js?t=".date('YmdH')."'></script>\n";
						$result .= "<script src='".NFE_URL."/_helpers/_js/util1.class.js?time=".time()."'></script>";*/
						//<script src='".NFE_URL."/sample/_helpers/_js/jquery-3.2.1.min.js'></script> 이걸 사용하면 이상해짐

						$result .= '
						<!--[if lt IE 7]> <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script> <![endif]-->
						<!--[if lt IE 8]> <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script> <![endif]-->
						<!--[if lt IE 9]> <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script> <![endif]-->
						<!--[if lt IE 9]> <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/ie7-squish.js"></script> <![endif]-->
						';

// : 소스가 없어서 뺐음.
/*
<script src="'.NFE_URL.'/_helpers/_js/respond.min.js"></script>
<script src="'.NFE_URL.'/_helpers/_js/html5shiv.min.js"></script>
<script src="'.NFE_URL.'/_helpers/_js/prefixfree.jquery"></script>
<script src="'.NFE_URL.'/_helpers/_js/selectivizr-min.js"></script>
*/

						$result .= '<!--[if lte IE 8]>
<script src="http://mjob.netfu.co.kr/sample/js/html5.js"></script>
<![endif]-->
						<script src="'.NFE_URL.'/_helpers/ie7/IE7.js"></script>
						<script src="'.NFE_URL.'/_helpers/ie7/IE8.js"></script>
						<script src="'.NFE_URL.'/_helpers/ie7/IE9.js"></script>
						<script src="'.NFE_URL.'/_helpers/ie7/ie7-squish.js"></script>';

						if($plugin){	// jQuery Plug-In
							$result .= $this->_plugin($plugin);
						}

						$result .= "<script type='text/javascript'>\n";
						$result .= "var application = '".$alice['app']."';\n";
						$result .= "var base_path = '".$alice['app_path']."';\n";
						$result .= "var mobile_is = '".$netfu_util->mobile_is."';\n";
						$result .= "var base_url = '".NFE_URL."';\n";
						$result .= "var board_path = '".$alice['board_path']."';\n";
						$result .= "var is_gecko = navigator.userAgent.toLowerCase().indexOf('gecko') != -1;\n";
						$result .= "var is_ie = navigator.userAgent.toLowerCase().indexOf('msie') != -1;\n";
						$result .= "var is_member = '".$is_member."';\n";
						$result .= "var mb_id = '".$member['mb_id']."';\n";
						$result .= "var mb_type = '".$member['mb_type']."';\n";
						if($is_member) {
							$result .= "var mb_email = '".$member['mb_email']."';\n";
							$result .= "var mb_point = '".$member['mb_point']."';\n";
						}
						if($is_demo){
							$result .= "var is_demo = 1;\n";
						}
						$result .= "</script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/common.js?t=".date('YmdH')."'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/form.js?t=".date('YmdH')."'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/plugins.js?t=".date('YmdH')."'></script>\n";

						//$result .= $this->_design();	// 별도 디자인 설정시 사용

						if($is_debug==false){	// 디버깅 모드가 아닐때만
							$result .= "<script>function killErrors() { return true; } window.onerror = killErrors;</script>\n";
						}

						$sns_feed = explode(',',$env['sns_feed']);
						if(@in_array('kakao_talk',$sns_feed) || @in_array('kakao_story',$sns_feed)){
							$result .= "<script src=\"https://developers.kakao.com/sdk/js/kakao.min.js\"></script>\n";
						}

						//구글 통계분석 스크립트
						$result .= stripslashes($env['google_scripts'])."\n";

						$result .= "</head>\n";


					echo $result;

				}


				// 기본 헤더 설정 (관리자측)
				function _admin_header( $body_attr='', $css='', $css_media='', $plugin='' ){
					
					global $alice, $env, $utility;
					global $is_debug;	// 확인 변수
					global $design;

						$result  = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\">\n";
						$result .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"ko\" xml:lang=\"ko\">\n";
						$result .= "<head>\n";
						$result .= "<title>".$env['site_title']." :: 관리자 모드</title>\n";
						$result .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
						$result .= "<meta http-equiv=\"Content-Script-Type\" content=\"text/javascript\">\n";
						$result .= "<meta http-equiv=\"Content-Style-Type\" content=\"text/css\">\n";
						$result .= "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
						$result .= "<meta name=\"viewport\" content=\"width=990px\">\n";
						$result .= "<link type=\"image/x-icon\" rel=\"shortcut icon\" href=\"".$alice['peg_path']."/".$env['favicon']."\" />\n";	 // 파비콘
						$result .= $this->_style( $css, $css_media );	// Admin CSS
						$result .= $this->_ui_theme($design['ui_theme']);	// jquery UI Theme
						$result .= $utility->_fontStyle($_SERVER['HTTP_USER_AGENT']) . "\n";	// Case User Agent WebFont
						$result .= "<!--[if IE 6]>\n";
						$result .= "<script type=\"text/javascript\" src=\"" . $alice['js_path'] . "/unitpngfix.js\"></script>\n";
						$result .= "<![endif]-->\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/jquery.min.js'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_ui'] . "/jquery-ui.min.js'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_i18n'] . "/jquery.ui.datepicker-ko.js'></script>\n";
						$result .= "<script type='text/javascript'>\n";
						$result .= "var application = '".$alice['app']."';\n";
						$result .= "var base_path = '".$alice['app_path']."';\n";
						$result .= "var mobile_is = '".$netfu_util->mobile_is."';\n";
						$result .= "var base_url = '".NFE_URL."';\n";
						$result .= "var is_gecko = navigator.userAgent.toLowerCase().indexOf('gecko') != -1;\n";
						$result .= "var is_ie = navigator.userAgent.toLowerCase().indexOf('msie') != -1;\n";
						$result .= "</script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/common.js'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/form.js'></script>\n";
						$result .= "<script type='text/javascript' src='" . $alice['js_path'] . "/util1.class.js?t=".date('YmdH')."'></script>\n";

						if($is_debug==false){	// 디버깅 모드가 아닐때만
							$result .= "<script>function killErrors() { return true; } window.onerror = killErrors;</script>\n";
						}

						if($plugin){	// jQuery Plug-In
							$result .= $this->_plugin($plugin);
						}
						$result .= "</head>\n\n";


					echo $result;
					
				}


				// 모바일 헤더
				function _mobile_header( ){

				}


				// 꼬리
				function _tail( $user="" ){

					global $alice, $env;

						$_tail  = "\n";
						if($user)	// 사용자 일때만
							$_tail .= stripslashes($env['google_scripts'])."\n";
						$_tail .= "</body>\n";
						$_tail .= "</html>\n";
					
					echo $_tail;

				}


				/**
				* style call
				*/
				function _style( $css='', $css_media='' ){

						global $alice;

						$result = '';
						$attr_media = ($css_media) ? " media=\"all\"" : "";
						if( is_array($css) ){
							foreach($css as $val){
								$result .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $alice['style_path'] . "/" . $val . ".css?t=".date('YmdH')."\"" . $attr_media . "/>\n";
							}
						} else {
							$result .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $alice['style_path'] . "/" . $css . ".css?t=".date('YmdH')."\" " . $attr_media . "/>\n";
						}

					return $result;

				}


				/**
				* Site design
				*/
				function _design( ){

				}


				/**
				* jQuery UI call
				* jQuery UI 를 불러올때 theme 1개만 지정해준다.
				*/
				function _ui_theme( $theme='base', $theme_name='jquery-ui.css' ){
					$theme = '_base';
					global $alice;

						$result = "<link rel='stylesheet' type='text/css' href='" . $alice['themes_path'] . "/" . $theme."/" . $theme_name . "?t=".date('YmdH')."' />\n";

						$result .= '<style type="text/css">.ui-datepicker select { padding:0px; margin:0px; }</style>';

					return $result;

				}


				/**
				* jQuery plug-in call
				*/
				function _plugin( $plugin='' ){

					global $alice;

						$result = '';
						if(is_array($plugin)){
							foreach($plugin as $val){
								$result .= "<script type='text/javascript' src='" . $alice['js_plugin'] . "/jquery.".$val.".js?t=".date('YmdH')."'></script>\n";
								if( $val == 'validate.min' || $val == 'validate' )
									$result .= "<script type='text/javascript' src='" . $alice['js_i18n'] . "/jquery.validate-ko.js?t=".date('YmdH')."'></script>\n";		// 한글
							}
						} else {
							$result .= "<script type='text/javascript' src='" . $alice['js_plugin'] . "/jquery.".$plugin.".js?t=".date('YmdH')."'></script>\n";
						}

					return $result;

				}

				/**
				* jquery UI theme 를 불러와 $ui_themes_arr 변수 대입
				* theme 를 대입한 이름으로 출력
				*/
				function ui_themes( $theme='' ){

					global $alice, $utility;

						$ui_themes = $this->ui_themes_arr;

						$get_themes = $utility->get_skin_dir($alice['themes_path'] . '/');	// _helpers/_css/themes 디렉토리에서 추출

						$result = "";

						foreach($get_themes as $val){

							$selected = ($val == $theme) ? 'selected' : '';

							$result .= "<option value='".$val."' ".$selected.">".$ui_themes[$val]."</option>";

						}


					return $result;

				}


				/**
				* Skin load
				*/
				function get_skins( $dir='', $skins ){

					global $alice, $utility;

						///$get_skins = $utility->get_skin_dir($alice[$skins.'_path'] . '/skins/');

						$result = $alice[$dir.'_path'] . '/skins/' . $skins;


					return $result;

				}


				function is_mobile(){
				
					$mobile_agent = "phone|samsung|lgtel|mobile|[^A]skt|nokia|blackberry|android|sony";

					return preg_match('/'.$mobile_agent.'/i', $_SERVER['HTTP_USER_AGENT']);
				}

				function mobile_checking( $request="" ){

					global $mobile_control;

						$get_mobile = $mobile_control->get_mobile_info(1);

						if($get_mobile['wr_use']){

							if ($request['device']=='pc') {
								$_SESSION['device_is_pc'] = 1;
								$result = false;
							} else if ($request['device']=='mobile') {
								$result = true;
								$_SESSION['device_is_pc'] = 0;
							} else if (isset($request['ss_is_mobile'])) {
								$result = $request['ss_is_mobile'];
							} else if ($this->is_mobile()) {
								if( $_SESSION['device_is_pc'] ){
									$result = false;
								} else {
									$result = true;
								}
                            }
						}


					return $result;

				}

				/**
				* 전화번호 선택
				*/
				function get_tel_num( $num="" ){

						$tel_num_option = "";

						foreach($this->tel_num as $tel){

							$selected = ($tel == $num) ? "selected" : "";

							$tel_num_option .= "<option value='".$tel."' ".$selected.">".$tel."</option>"; // $this->local_num[$tel]

						}

					
					return $tel_num_option;

				}


				/**
				* 휴대폰번호 선택
				*/
				function get_hp_num( $num="" ){

						$hp_num_option = "";

						foreach($this->hp_num as $hp){

							$selected = ($hp == $num) ? "selected" : "";

							$hp_num_option .= "<option value='".$hp."' ".$selected.">".$hp."</option>";

						}


					return $hp_num_option;

				}


				/**
				* 이메일 선택
				*/
				function get_email( $email="" ){

					global $category_control;

						$email_list = $category_control->category_codeList('email', " `rank` asc ");

						$email_option = "";

						foreach($email_list as $option){

							$selected = ($option['name'] == $email) ? "selected" : "";

							$email_option .= "<option value='".$option['name']."' ".$selected.">".$option['name']."</option>";

						}


					return $email_option;

				}


				/**
				* 업종 선택
				*/
				function get_biz_type( $biz_type="" ){

					global $category_control;

						$biz_type_list = $category_control->category_codeList('biz_type', " `rank` asc ");

						$biz_type_option = "";

						foreach($biz_type_list as $option){

							$selected = ($option['code'] == $biz_type) ? "selected" : "";

							$biz_type_option .= "<option value='".$option['code']."' ".$selected.">".$option['name']."</option>";

						}


					return $biz_type_option;

				}


				/**
				* 상장여부
				*/
				function get_biz_success( $biz_success_sel="" ){

					global $category_control;

						$biz_success = $category_control->category_codeList('biz_success', " `rank` asc ");

						$biz_success_option = "";

						foreach($biz_success as $option){

							$selected = ($option['code'] == $biz_success_sel) ? "selected" : "";

							$biz_success_option .= "<option value='".$option['code']."' ".$selected.">".$option['name']."</option>";

						}


					return $biz_success_option;

				}


				/**
				* 기업형태
				*/
				function get_biz_form( $biz_form_sel="" ){

					global $category_control;

						$biz_form = $category_control->category_codeList('biz_form', " `rank` asc ");

						$biz_form_option = "";

						foreach($biz_form as $option){

							$selected = ($option['code'] == $biz_form_sel) ? "selected" : "";

							$biz_form_option .= "<option value='".$option['code']."' ".$selected.">".$option['name']."</option>";

						}


					return $biz_form_option;

				}


				/**
				* 이미지 업로드시 확장자 구분
				*/
				function _img(){

						$result = implode('|',$this->img_extension);

					return $result;

				}

				/**
				* 업로드 가능 파일
				*/
				function _upload(){

						$result = implode('|',$this->upload_extension);

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

				
				/**
				* 에러문의
				*/
				function error_info( $file_path ){
					
					global $alice;

						$result = $file_path;
						$result .= " 파일이 존재하지 않습니다.<br/>";
						$result .= "디렉토리 경로에 맞게 파일을 생성해 주세요.<br/><br/>";
						$result .= $alice['author']." (".$alice['author_url'].")<br/>";
						$result .= $alice['author_tel'];


					echo $result;

				}

		}	// class end.
?>