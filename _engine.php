<?php
		/*
		* /application/_engine.php
		* @author Harimao
		* @since 2013/06/14
		* @last update 2015/04/10
		* @Module v3.5 ( Alice )
		* @Brief :: Application Engine Injection
		* @Comment :: 상위에 있는 _core 에 접근, applicaiton 공통 작업 변수 설정
		*/

		$alice_path = $_SERVER['DOCUMENT_ROOT'].'/';

		$cat_path = '/';

		include_once $alice_path . "_core.php"; 
		$_ver = substr(PHP_VERSION,0,3);

		/*if($env['under_construction'] && !$is_demo){
			include NFE_PATH.'/include/const.php';
			//header("Location: /404/");
			exit;
		}*/

		if($design['skin_color']=='gr') $icon_img = 2;

		// go mobile.
		if($is_mobile){
			//$utility->popup_msg_js("",$alice['mobile_path']);
		}

		/*if($env['use_adult'] && !$is_admin){	// 성인인증 기능을 사용할때 (관리자 아닐때)

			if($is_member){	// 회원일때
				if(!$member['is_adult']){	// 성인이 아니라면
					header("Location: ".$alice['main_path']."/adult_certify.php");
				}
			} else {	 // 비회원
				if(!$_SESSION['adult_view']){	// 성인인증 세션이 없다면
					header("Location: ".$alice['main_path']."/adult_certify.php");
				}
			}

		}*/

		// 탈퇴/삭제된 회원 체크
		if($member['mb_left'] || $member['is_delete']){	// 삭제된 회원이다.
			$utility->popup_msg_js($user_control->_errors('0046'),$alice['member_path']."/process/logout.php?is_delete=1");
			exit;
		}

		##
		# Page access
		switch($page_name){
			## 개인회원 전용 접근 페이지
			case 'individual':
				if(!$is_member){	// 회원이 아닌 경우
					$utility->popup_msg_js($user_control->_errors('0015'),$alice['member_path']."/login.php?type=individual&url=".$urlencode);
					exit;
				}
				if($mb_type=='company'){	 // 기업회원 접근시
					$utility->popup_msg_js($user_control->_errors('0030'));
					exit;
				}
			break;
			## 기업회원 전용 접근 페이지
			case 'company':
				if(!$is_member){	// 회원이 아닌 경우
					$utility->popup_msg_js($user_control->_errors('0015'),$alice['member_path']."/login.php?type=company&url=".$urlencode);
					exit;
				}
				if($mb_type=='individual'){	 // 개인회원 접근시
					$utility->popup_msg_js($user_control->_errors('0031'));
					exit;
				}
			break;
		}

		## 페이지별 SKIN 및 모듈 설정
		$main_skin				= $design['main_skin'];
		$menu_skin				= $design['menu_skin'];
		$member_skin			= $design['member_skin'];
		$employ_skin				= $design['employ_skin'];
		$alba_skin					= $design['alba_skin'];
		$resume_skin			= $design['resume_skin'];
		$alba_resume_skin		= $design['alba_resume_skin'];
		$map_skin					= $design['map_skin'];

		## jqueryUI theme
		$ui_themes = $design['ui_theme'];

		## 게시판 스킨 :: DB 에서 선택 하는 걸로~
		$board_main_skin	= $design['board_skin'];	 // 커뮤니티 메인 페이지 스킨
		$board_skin			= "default";	// 게시판 기본 스킨 (DB 에서 로드?!)
		$board_best_skin	= "default";	// 게시판 BEST 스킨
		$board_latest_skin	= "default";	// 게시판 최근게시물 스킨
		$board_tab_skin		= "default";	// 게시판 메인 TAB 스킨
		
		$main_left = $design['main_left'];	// 좌측메뉴 사용유무


		##
		# Search
		$mode = $_POST['mode'] ? $_POST['mode'] : $_GET['mode']; 
		if($mode=='search'){	 // 통합 검색

			$search_keyword = $_GET['search_keyword'];	 // 검색 키워드 필터링

			if($search_keyword){
				$search_keyword = mysql_real_escape_string($search_keyword);
				$search_keyword = stripslashes($search_keyword);
				$search_keyword = urlencode($search_keyword);
			}

		}

		##
		# Variables
		$sms_config = $sms_control->sms_config(1);	// SMS 환경설정 정보
		$sms_use = $sms_config['sms_use'];	// sms 사용 유무

		if($is_demo){	 // 데모일때
			$save_id = $save_password = "test_individual";	// 테스트 기본 개인회원
		} else {
			$save_id = $utility->get_cookie("ack_mb_id");	 // 로그인 아이디 저장 쿠키
		}
		
		$mb_phone = explode('-',$member['mb_phone']);
		$mb_hpone = explode('-',$member['mb_hphone']);
		$mb_email = explode('@',$member['mb_email']);
		$mb_biz_fax = explode("-", $member_com['mb_biz_fax']);

		$tel_num_option = $config->get_tel_num($mb_phone[0]);		// 전화번호
		$fax_num_option = $config->get_tel_num($mb_biz_fax[0]);		// 팩스번호
		$hp_num_option = $config->get_hp_num($mb_hpone[0]);		// 휴대폰 번호
		$email_option = $config->get_email();										// 이메일
		$biz_type_option = $config->get_biz_type($company_member['mb_biz_type']);	// 업종

		$is_adult_type = $category_control->is_adult_type('job_type');	// 성인 직종 사용 유무
		$is_adult = $is_adult_type['is_adult'];
		$adult_cate = $is_adult_type['adult'];

		$category_area = $category_control->category_codeList('area','','yes');	 // 지역 카테고리
		$category_subway = $category_control->category_codeList('subway','','yes');	 // 역세권 카테고리
		$job_types = $category_control->category_codeLists('job_type'," and `p_code` = '' and `view` = 'yes' and `etc_0` != '1'  ");	 // 직종별 카테고리
		//$job_college = $category_control->category_codeList('job_college','','yes');	 // 인근대학 카테고리
		//$college_category_list = $category_control->category_codeList('area');	// 인근대학 지역 카테고리
		
		$adult_job_types = $category_control->category_codeLists('job_type'," and `p_code` = '' and `view` = 'yes' and `etc_0` = '1'  ");	 // 성인직종 카테고리
		$adult_job_types_cnt = count($adult_job_types);
		$job_targets = $category_control->category_codeList('job_target','','yes');	 // 채용대상
		$job_targets_cnt = count($job_targets);

		$alba_date_list = $category_control->category_codeList('alba_date', '', 'yes');	// 근무기간
		$alba_week_list = $category_control->category_codeList('alba_week', '', 'yes');	// 근무요일
		$alba_time_list = $category_control->category_codeList('alba_time', '', 'yes');	// 근무시간
		$alba_pay_list = $category_control->category_codeList('alba_pay', '', 'yes');	// 급여조건
		$alba_pay_type_list = $category_control->category_codeList('alba_pay_type', '', 'yes');	// 급여지원조건
		$job_ability_list = $category_control->category_codeList('job_ability', '', 'yes');		// 학력조건
		$job_career_list = $category_control->category_codeList('job_career', '', 'yes');		// 경력조건
		$preferential_list = $category_control->category_codeList('preferential', '', 'yes');		// 우대조건
		$job_age = $category_control->category_codeList('job_age', '', 'yes');		// 연령특이사항
		$form_age = $category_control->get_categoryCode('20130806090039_4821');	// 연령

		$indi_ability_list = $category_control->category_codeList('indi_ability', '', 'yes');	// 인재정보 학력
		$indi_special_list = $category_control->category_codeList('indi_special', '', 'yes');	// 특기사항
		$indi_language_list = $category_control->category_codeList('indi_language', '', 'yes');	// 외국어

		$professional_indi = explode(',',$design['professional_indi']);	 // 전문인재정보
		$professional_indi_cnt = count($professional_indi);

		$professional_alba = explode(',',$design['professional_alba']);	 // 전문채용정보
		$professional_alba_cnt = count($professional_alba);

		$job_welfare = $category_control->category_codeList('job_welfare', '', 'yes');		// 복리후생
		$work_type_list = $category_control->category_codeList('work_type', '', 'yes');	// 근무형태

		$main_platinum_use = $design['main_platinum_use'];	// 메인 플래티넘 사용유무
		$main_prime_use = $design['main_prime_use'];			// 메인 프라임 사용유무
		$main_grand_use = $design['main_grand_use'];			// 메인 그랜드 사용유무
		$main_banner_use = $design['main_banner_use'];		// 메인 배너형 사용유무
		$main_list_use = $design['main_list_use'];					// 메인 일반 리스트형 사용유무
		$main_focus_use = $design['main_focus_use'];			// 메인 포커스 인재정보 사용유무
		$main_focus_total = $design['main_focus_total'];			// 메인 포커스 인재정보 출력건수

		$sub_platinum_use = $design['sub_platinum_use'];		// 서브 플래티넘 사용유무
		$sub_mobile_prime_use = $design['sub_mobile_prime_use'];		// 서브 프라임 사용유무
		$sub_banner_use = $design['sub_banner_use'];			// 서브 배너형 사용유무
		$sub_list_use = $design['sub_list_use'];						// 서브 일반 리스트형 사용유무
		$sub_focus_use = $design['sub_focus_use'];				// 서브 포커스 인재정보 사용유무
		$sub_focus_total = $design['sub_focus_total'];				// 서브 포커스 인재정보 출력건수

		$adult_platinum_use = $design['adult_platinum_use'];	// 19금 플래티넘 사용유무
		$adult_prime_use = $design['adult_prime_use'];			// 19금 프라임 사용유무
		$adult_grand_use = $design['adult_grand_use'];			// 19금 그랜드 사용유무
		$adult_banner_use = $design['adult_banner_use'];		// 19금 배너형 사용유무
		$adult_list_use = $design['adult_list_use'];					// 19금 일반 리스트형 사용유무

		if($main_left=='2'){
			// 메인 출력 설정
			$main_platinum_row = ($design['main_platinum_row'] < 6) ? $design['main_platinum_row'] + 1 : $design['main_platinum_row'];
			$main_prime_row = ($design['main_prime_row'] < 6) ? $design['main_prime_row'] + 1 : $design['main_prime_row'];
			$main_grand_row = ($design['main_grand_row'] < 6) ? $design['main_grand_row'] + 1 : $design['main_grand_row'];
			$main_banner_row = ($design['main_banner_row'] < 6) ? $design['main_banner_row'] + 1 : $design['main_banner_row'];
			// 서브 출력 설정
			$sub_platinum_row = ($design['sub_platinum_row'] < 6) ? $design['sub_platinum_row'] + 1 : $design['sub_platinum_row'];
			$sub_mobile_prime_row = ($design['sub_mobile_prime_row'] < 6) ? $design['sub_mobile_prime_row'] + 1 : $design['sub__mobile_prime_row'];
			$sub_prime_row = ($design['sub_prime_row'] < 6) ? $design['sub_prime_row'] + 1 : $design['sub_prime_row'];
			$sub_grand_row = ($design['sub_grand_row'] < 6) ? $design['sub_grand_row'] + 1 : $design['sub_grand_row'];
			$sub_banner_row = ($design['sub_banner_row'] < 6) ? $design['sub_banner_row'] + 1 : $design['sub_banner_row'];
		} else {
			// 메인 출력 설정
			$main_platinum_row = $design['main_platinum_row'];
			$main_prime_row = $design['main_prime_row'];
			$main_grand_row = $design['main_grand_row'];
			$main_banner_row = $design['main_banner_row'];
			// 서브 출력 설정
			$sub_platinum_row = $design['sub_platinum_row'];
			$sub_mobile_prime_row = $design['sub_mobile_prime_row'];
			$sub_prime_row = $design['sub_prime_row'];
			$sub_grand_row = $design['sub_grand_row'];
			$sub_banner_row = $design['sub_banner_row'];
		}

		$adult_platinum_row = $design['adult_platinum_row'] + 1;
		$adult_prime_row = $design['adult_prime_row'] + 1;
		$adult_grand_row = $design['adult_grand_row'] + 1;
		$adult_banner_row = $design['adult_banner_row'] + 1;

		$realtime_search = $search_control->__SearchList('realtime'," `rank` asc ",10);
		$popular_search = $search_control->__SearchList('popular'," `rank` asc ",10);

		$call_center_use = false;	// 좌측 고객센터 출력 유무
		$pay_view = false;	 // 좌측 최저임금 출력 유무
		if($page_name=='main'){	// 메인 일때만
			if($main_left=='1'){	// 좌측메뉴를 사용하지 않으면 출력
				$call_center_use = ($env['call_center_use']) ? true : false;
				$pay_view = ($env['pay_view']) ? true : false;
			} else if($main_left=='2'){
				$call_center_use = false;
				$pay_view = false;
			}
		} else {
			$call_center_use = ($env['call_center_use']) ? true : false;
			$pay_view = ($env['pay_view']) ? true : false;
		}	// page_name if end.

		##
		# Member
		$mb_photo_file = $alice['data_member_path']."/".$member['mb_id']."/".$member['mb_photo'];
		$photo_gender = $member['mb_gender'] ? '2' : '';
		$mb_photo = (is_file(NFE_PATH.$mb_photo_file)) ? $mb_photo_file : "../images/id_pic".$photo_gender.".png";	 // 개인회원 프로필 사진

		$mb_logo_file = $alice['data_member_path']."/".$company_member['mb_id']."/logo/".$company_member['mb_logo'];
		$mb_logo = (is_file(NFE_PATH.$mb_logo_file)) ? $mb_logo_file : "../images/basic/bg_noLogo.gif";	 // 기업회원 로고 사진
		//$mb_logo = (is_file($mb_logo_file)) ? $mb_logo_file : $alice['data_logo_path']."/".$employ_logo['wr_content'];	 // 기업회원 로고 사진

		// : 사업자등록증
		$mb_com_num_photo_file = $alice['data_member_path'].'/'.$member['mb_id']."/photos/".$company_member['mb_com_num_photo'];
		$mb_com_num_photo = (is_file(NFE_PATH.$mb_com_num_photo_file)) ? $mb_com_num_photo_file : "../images/basic/bg_noLogo.gif";

		$mb_receive = explode(',',$member['mb_receive']);		// 수신여부

		
		##
		# Banner lists
		$logo_banner = $banner_control->get_banner_for_position($banner_logo_position);	// 페이지별 상단 로고 배너
		$atop_banner = $banner_control->get_banner_for_position($banner_atop_position);	// 페이지별 최상단 배너
		$top_banner = $banner_control->get_banner_for_position($banner_top_position);	// 페이지별 상단 배너
		$left_banner = $banner_control->get_banner_for_position($banner_left_position);	// 페이지별 좌측 배너
		$bottom_banner = $banner_control->get_banner_for_position($banner_tail_position);	// 페이지별 하단 배너
		$left_wing_banner = $banner_control->get_banner_for_position($banner_left_wing_position);	// 페이지별 좌측 스크롤 배너
		$right_wing_banner = $banner_control->get_banner_for_position($banner_right_wing_position);	// 페이지별 우측 스크롤 배너

		$etc_bottom_banner = $banner_control->get_banner_for_position('etc_bottom');	// 하단 공통 제휴 배너

		##
		# Listing
		
		
		##
		# Board main list
		$board_top_menu = $board_control->get_top_menu( $bo_table );	 // 첫번째 기본 게시판 메뉴

		$get_board_main = $board_config_control->get_main(1);	 // 1번 정보 추출
		$print_board = unserialize($get_board_main['print_board']);	// 게시판 메인 출력 정보
		$print_main = unserialize($get_board_main['print_main']);	// 인덱스 게시판 출력 정보
		$use_print = $get_board_main['use_print'];

		$board_code = ($_GET['board_code']) ? $_GET['board_code'] : $board_top_menu;	// 게시판 그룹 코드
		$code = $_GET['code'];	// 게시판 상위 코드

		if($get_board_main['use_main']){	// 메인페이지를 사용 유무에 따른 링크
			//$board_href = $alice['board_path'] . "/index.php?board_code=".$board_code;
			$board_href = $alice['board_path'] . "/index.php";
		} else {
			$board_top = $category_control->get_categoryPCode($board_code, " order by `rank` asc ");
			$code = ($_GET['code']) ? $_GET['code'] : $board_top['code'];
			$get_board_code = $board_config_control->get_boardCode($code, " order by `rank` asc ");
            $bo_table_val = ($_GET['bo_table']) ? $_GET['bo_table'] : $_POST['bo_table'];
			$bo_table = ($bo_table_val) ? $bo_table_val : $get_board_code['bo_table']; 
			$board_href = $alice['board_path'] . "/board.php?board_code=".$board_code . "&code=" . $code . "&bo_table=" . $bo_table;
		}

		##
		# Main poll list
		//$poll_list = $poll_control->__PollList("","","");
		$print_polls = $poll_control->print_polls(1);	// 설문조사 (공통) 1개

		##
		# Header
		# 필요에 의한 style, jQuery plugin 추가가 가능합니다.
		# 아래는 예시 입니다.

		// : 구인정보 상세
		if(strpos($_SERVER['PHP_SELF'], '/job/detail.php')!==false)
			$view = $alba_user_control->get_alba_no($no);	// 정규직 정보
		// : 인재정보 상세
		if(strpos($_SERVER['PHP_SELF'], '/resume/detail.php')!==false)
			$view = sql_fetch("select * from alice_alba_resume where `no`='".addslashes($_GET['no'])."'");
		// : 게시판
		if(strpos($_SERVER['PHP_SELF'], '/board/list.php')!==false && $_GET['bo_table'] && !$_GET['no'])
			$view['wr_subject'] = $board['bo_subject'].' 커뮤니티 리스트';
		// : 
		if(strpos($_SERVER['PHP_SELF'], '/board/detail.php')!==false) {
			$_table = 'alice_write_'.addslashes($_GET['bo_table']);
			$write = $bo_row = sql_fetch("select * from ".$_table." where `wr_no`='".addslashes($_GET['no'])."'");
			$view['wr_subject'] = $write['wr_subject'].' 커뮤니티 상세';
		}
		if(strpos($_SERVER['PHP_SELF'], '/board/write.php')!==false) {
			$view['wr_subject'] =$board['bo_subject'].' 커뮤니티 글쓰기';
		}
		// : 공지사항
		if(strpos($_SERVER['PHP_SELF'], '/notice/notice_view.php')!==false) {
			$n_row = sql_fetch("select * from alice_notice where `no`='".addslashes($_GET['no'])."'");
			$view['wr_subject'] = $n_row['wr_subject'].' 공지사항 상세';
		}
		// : 텍스트 기타
		if(strpos($_SERVER['PHP_SELF'], '/etc/text.php')!==false) {
			$head_title = $netfu_util->site_content[$_GET['code']];
		}
		
		//$style_arr = array( 'default', 'style', 'color_'.$design['skin_color']);
		$style_arr = array(
            'job/bootstrap.min',
            'job/fontawesome',
            'job/materialdesignicons.min',
            'job/nice-select',
            'job/owl.carousel',
            'job/owl.theme',
            'job/owl.transitions',
            'job/selectize',
            'job/style',
            /*'default',*/
            'style',
            /*'color_'.$design['skin_color'],*/
        );
		$plugin_arr = array( 'scrollfollow' );
		echo $config->_user_header( '', $style_arr, '', $plugin_arr, $view);		// body, css style, css media, jQuery plugin


		// ie 버전 체크
		$ie_version = $utility->_IE_Vercheck();

		// 미확인쪽지
		$viewed_memo = $memo_control->__MemoList($page,$page_rows,"viewed"," where `wr_recv_mb_id` = '".$member['mb_id']."' and `wr_read_datetime` = '0000-00-00 00:00:00' and `wr_is_delete` = 0 ");


		// Under construction
		/*
		if($page_name=='category' || $page_name=='main'){
			if($under_construction){
				include_once $alice['main_path']."/under.php";
			}
		}
		*/

		$etc_alba_check = $service_control->service_check('etc_alba');	// 채용공고 열람권 체크
		$etc_open_check = $service_control->service_check('etc_open');	// 이력서 열람권 체크
		$etc_sms_check = $service_control->service_check('etc_sms');	// SMS 충전 체크

		// 채용공고 점프
		$alba_user_control->alba_jumping( 12 );


		##
		# Include Top
		// : 다시 없앴음. 혹시나 해서 주석함.
		//include_once NFE_PATH.'/include/top.php';

?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/mjob.class.js?time=<?=time();?>"></script>