<?php
		/**
		* /engine/config/menu_config.php
		* @author Harimao
		* @since 2013/05/24
		* @last update 2015/04/03
		* @Module v3.5 ( Alice )
		* @Brief :: Application Menu Configuration
		* @Comment :: 관리자/사용자 메뉴 설정
		*/

		// 상수설정
		define("_ALICE_", TRUE);

		//echo "<p style='color:#fff;'>".$top_menu_code."</p>";

		/*
		 * 대 메뉴 리스트
		 * 대 메뉴는 각 페이지별 상단에 정의됨
		 */
		 $top_menus = array(
			'100000' => '구인구직관리',
			'200000' => '환경설정',
			'300000' => '회원관리',
			'400000' => '디자인관리',
			'500000' => '결제관리',
			'600000' => '커뮤니티',
			'700000' => '통계관리',
			//'800000' => '모바일웹',
		);


		if (isset($top_menu_code))
            $tmp_menu = substr($top_menu_code, 0, 3);

		## 서비스관리
		$menu['100'] = array(
			"eng_name" => "Service",
			"menus" => array(
				0 => array("code" => "100100", "name" => "구인공고 관리", 
				"sub_menu" => array(
					array("code" => "100101", "name" => "전체 구인공고 관리", "url" => "../alba/"), // 전체 구인공고 관리
					//array("code" => "100102", "name" => "사용자 등록 구인공고", "url" => "../alba/?is_admin=0"),
					//array("code" => "100103", "name" => "관리자 등록 구인공고", "url" => "../alba/?is_admin=1"),
					array("code" => "100102", "name" => "진행중인 구인공고", "url" => "../alba/employ_ing.php"),
					array("code" => "100103", "name" => "마감된 구인공고", "url" => "../alba/employ_end.php"),
					array("code" => "100104", "name" => "구인공고 등록", "url" => "../alba/?mode=insert"),
					array("code" => "100105", "name" => "신고 공고 관리", "url" => "../alba/employ_report.php"),
					array("code" => "100109", "name" => "서비스기간 만료 구인공고", "url" => "../alba/employ_serviced.php"),
					//array("code" => "100106", "name" => "구인공고 댓글 관리", "url" => "../alba/employ_comment.php"),
					array("code" => "100107", "name" => "입사지원 관리", "url" => "../alba/employ_become.php"),
					array("code" => "100108", "name" => "구인공고 스크랩 관리", "url" => "../alba/employ_scrap.php"),
					),
				),

				1 => array("code" => "100200", "name" => "인재정보 관리",
				"sub_menu" => array(
					array("code" => "100201", "name" => "이력서 관리", "url" => "../alba/resume.php"),
					array("code" => "100202", "name" => "이력서 등록", "url" => "../alba/resume.php?mode=insert"),
					array("code" => "100203", "name" => "신고 이력서 관리", "url" => "../alba/resume_report.php"),
					array("code" => "100205", "name" => "서비스기간 만료 이력서", "url" => "../alba/resume_serviced.php"),
					array("code" => "100204", "name" => "이력서 스크랩 관리", "url" => "../alba/resume_scrap.php"),
					),
				),
				/* 누락 시켜 두었습니다. 추후 업데이트 활성화 하겠습니다.
				2 => array("code" => "100300", "name" => "입사지원관리",
				"sub_menu" => array(
					array("code" => "100301", "name" => "입사지원관리", "url" => "../alba/company_join.php"),
					array("code" => "100302", "name" => "스크랩관리", "url" => "../alba/scrap.php"),
					),
				),
				*/
			)
		);

		## 환경설정
		$menu['200'] = array(
			"eng_name" => "Environment",
			"menus" => array(
				0 => array("code" => "200100", "name" => "사이트 관리", 
				"sub_menu" => array(
					array("code" => "200101", "name" => "기본정보설정", "url" => "../config/"),
					//array("code" => "200102", "name" => "사이트소개", "url" => "../config/content.php?type=site_introduce"),
					array("code" => "200103", "name" => "회원약관", "url" => "../config/content.php?type=site_agreement"),
					array("code" => "200104", "name" => "개인정보취급방침", "url" => "../config/content.php?type=site_privacy"),
					array("code" => "200105", "name" => "개인정보수집이용안내", "url" => "../config/content.php?type=privacy_info"),
					array("code" => "200105", "name" => "게시판관리기준", "url" => "../config/content.php?type=board_criterion"),
					array("code" => "200106", "name" => "이메일무단수집거부", "url" => "../config/content.php?type=email_denied"),
					array("code" => "200107", "name" => "사이트하단", "url" => "../config/content.php?type=site_bottom"),
					array("code" => "200108", "name" => "메일하단", "url" => "../config/content.php?type=email_bottom"),
					),
				),

				1 => array("code" => "200200", "name" => "서비스/출력수 설정",
				"sub_menu" => array(
					//array("code" => "200201", "name" => "구인정보 설정", "url" => "../config/alba.php"),
					//array("code" => "200202", "name" => "인재정보 설정", "url" => "../config/alba_individual.php"),
					array("code" => "200201", "name" => "SMS 환경설정", "url" => "../config/sms.php"),
					array("code" => "200202", "name" => "지도설정", "url" => "../config/map.php"),
					),
				),

				2 => array("code" => "200300", "name" => "등록폼 관리",
				"sub_menu" => array(
					array("code" => "200301", "name" => "기업회원 가입폼 설정", "url" => "../config/register_form.php?type=company_form"),
					array("code" => "200302", "name" => "구인정보 항목 설정", "url" => "../config/register_form.php?type=alba_form"),
					array("code" => "200303", "name" => "이력서 항목 설정", "url" => "../config/register_form.php?type=alba_resume"),
					array("code" => "200304", "name" => "회원 탈퇴요청 사유", "url" => "../config/category.php?type=member_left_reason"),
					array("code" => "200305", "name" => "구인공고 신고 사유", "url" => "../config/category.php?type=alba_report_reason"),
					array("code" => "200306", "name" => "이력서 신고 사유", "url" => "../config/category.php?type=alba_resume_report_reason"),
					/*
					array("code" => "200306", "name" => "구인공고 신고 사유", "url" => "../config/board.php?type=reason_alba"),
					array("code" => "200306", "name" => "이력서 신고 사유", "url" => "../config/board.php?type=reason_alba_individual"),
					*/
					),
				),

				3 => array("code" => "200400", "name" => "분류관리",
				"sub_menu" => array(
					array("code" => "200401", "name" => "공통적용 분류", "url" => "../config/category.php?type=job_type", "subs" => 
						array(
							"job_type" => array("code" => "200401", "name" => "직종", "url" => "../config/category.php?type=job_type"),
							"area" => array("name" => "지역", "url" => "../config/category.php?type=area"),
							"subway" => array("name" => "역세권", "url" => "../config/category.php?type=subway"),
							"impediment" => array("name" => "장애등급", "url" => "../config/category.php?type=impediment"),
							"work_type" => array("name" => "근무형태", "url" => "../config/category.php?type=work_type"),
							"alba_date" => array("name" => "근무기간", "url" => "../config/category.php?type=alba_date"),
							"alba_week" => array("name" => "근무요일", "url" => "../config/category.php?type=alba_week"),
							"alba_pay" => array("name" => "급여조건", "url" => "../config/category.php?type=alba_pay"),
							//"pay" => array("name" => "연봉", "url" => "../config/category.php?type=pay"),
							//"high_school" => array("name" => "고등학교", "url" => "../config/category.php?type=high_school"),
							//"half_college" => array("name" => "대학(2,3년)", "url" => "../config/category.php?type=half_college"),
							//"college" => array("name" => "대학(4년)", "url" => "../config/category.php?type=college"),
							//"graduate" => array("name" => "대학원", "url" => "../config/category.php?type=graduate"),
						),
					),
					array("code" => "200402", "name" => "회원가입 분류", "url" => "../config/category.php?type=email", "subs"=> 
						array(
							//"passwd_question" => array("name" => "비밀번호재발급 질문", "url" => "../config/category.php?type=passwd_question"),
							"email" => array("name" => "이메일", "url" => "../config/category.php?type=email"),
							"biz_type" => array("name" => "회사분류", "url" => "../config/category.php?type=biz_type"),
							"biz_success" => array("name" => "상장여부", "url" => "../config/category.php?type=biz_success"),
							"biz_form" => array("name" => "기업형태", "url" => "../config/category.php?type=biz_form"),
						),
					),
					array("code" => "200403", "name" => "구인정보 분류", "url" => "../config/category.php?type=job_welfare", "subs" => 
						array(
							"job_welfare" => array("name" => "복리후생", "url" => "../config/category.php?type=job_welfare"),
							"job_ability" => array("name" => "학력조건", "url" => "../config/category.php?type=job_ability"),
							"job_career" => array("name" => "경력조건", "url" => "../config/category.php?type=job_career"),
							"preferential" => array("name" => "우대조건", "url" => "../config/category.php?type=preferential"),
							"pt_paper" => array("name" => "제출서류", "url" => "../config/category.php?type=pt_paper"),
							"job_college" => array("name" => "인근대학", "url" => "../config/category.php?type=job_college"),
							"job_age" => array("name" => "연령특이사항", "url" => "../config/category.php?type=job_age"),
							"job_target" => array("name" => "채용대상", "url" => "../config/category.php?type=job_target"),
							"alba_pay_type" => array("name" => "급여지원조건", "url" => "../config/category.php?type=alba_pay_type"),
							"alba_content" => array("name" => "상세모집요강항목", "url" => "../config/category.php?type=alba_content"),
							//"alba_profesional" => array("name" => "전문구인정보설정", "url" => "../config/category.php?type=alba_profesional"),
							//"job_report" => array("name" => "구인정보 신고사유", "url" => "../config/category.php?type=job_report"),
							//"biz_field" => array("name" => "구인정보 전문분야", "url" => "../config/category.php?type=biz_field"),
						),
					),
					array("code" => "200404", "name" => "인재정보 분류", "url" => "../config/category.php?type=indi_language", "subs" => 
						array(
							"indi_language" => array("name" => "외국어종류", "url" => "../config/category.php?type=indi_language"),
							"indi_language_license" => array("name" => "외국어공인시험", "url" => "../config/category.php?type=indi_language_license"),
							"indi_oa" => array("name" => "컴퓨터능력", "url" => "../config/category.php?type=indi_oa"),
							"indi_special" => array("name" => "특기사항", "url" => "../config/category.php?type=indi_special"),
							"indi_introduce" => array("name" => "자기소개서항목", "url" => "../config/category.php?type=indi_introduce"),
							"indi_treatment" => array("name" => "고용지원금대상자", "url" => "../config/category.php?type=indi_treatment"),
							"alba_time" => array("name" => "근무시간", "url" => "../config/category.php?type=alba_time"),
							//"indi_profesional" => array("name" => "전문인재정보설정", "url" => "../config/category.php?type=indi_profesional"),
							//"indi_ability" => array("name" => "학력", "url" => "../config/category.php?type=indi_ability"),
							//"indi_report" => array("name" => "인재정보 신고사유", "url" => "../config/category.php?type=indi_report"),
							//"indi_field" => array("name" => "인재정보 전문분야", "url" => "../config/category.php?type=indi_field"),
						),
					),
					/*
					array("code" => "200405", "name" => "아르바이트 분류", "url" => "../config/category.php?type=alba_date", "subs" => 
						array(
							//"alba_paper" => array("name" => "제출서류", "url" => "../config/category.php?type=alba_paper"),
							//"alba_field" => array("name" => "전문분야", "url" => "../config/category.php?type=alba_field"),
						),
					),
					*/
					),
					//array("code" => "200406", "name" => "회원그룹 분류", "url" => "../config/category.php?type=member"),
				),

				4 => array("code" => "200500", "name" => "운영자관리",
				"sub_menu" => array(
					array("code" => "200501", "name" => "관리자정보설정", "url" => "../config/admin.php"),
					array("code" => "200502", "name" => "부관리자관리", "url" => "../config/sadmin.php"),
					array("code" => "200503", "name" => "부관리자등록", "url" => "../config/sadmin.php?mode=insert"),
					//array("code" => "200504", "name" => "DB백업", "url" => "../config/db.php"),
					//array("code" => "200505", "name" => "데이터베이스 스키마", "url" => "../config/scheme.php"),
					//array("code" => "200506", "name" => "파일디렉토리 구조도", "url" => "../config/file.php"),
					),
				),


			)
		);

		## 회원관리
		$menu['300'] = array(
			"eng_name" => "Member",
			"menus" => array(
				0 => array("code" => "300100", "name" => "회원종합관리", 
				"sub_menu" => array(
					array("code" => "300101", "name" => "전체회원관리", "url" => "../member/"),
					array("code" => "300102", "name" => "불량회원관리", "url" => "../member/bad_list.php"),
					array("code" => "300103", "name" => "탈퇴요청관리", "url" => "../member/left_list.php"),
					array("code" => "300104", "name" => "탈퇴회원관리", "url" => "../member/left_list.php?type=left"),
					array("code" => "300105", "name" => "회원등급/포인트설정", "url" => "../member/level.php"),
					array("code" => "300106", "name" => "회원포인트관리", "url" => "../member/point.php"),
					//array("code" => "300107", "name" => "회원간쪽지발송내역", "url" => "../member/memo.php"),
					//array("code" => "300108", "name" => "회원간SMS발송내역", "url" => "../member/sms_log.php"),
					),
				),

				1 => array("code" => "300200", "name" => "기업회원관리", 
				"sub_menu" => array(
					array("code" => "300201", "name" => "기업회원관리", "url" => "../member/company.php"),
					array("code" => "300202", "name" => "기업회원등록", "url" => "../member/company.php?mode=insert"),
					array("code" => "300303", "name" => "기업정보관리", "url" => "../member/company_info.php"),
					),
				),

				2 => array("code" => "300300", "name" => "개인회원관리", 
				"sub_menu" => array(
					array("code" => "300301", "name" => "개인회원관리", "url" => "../member/individual.php"),
					array("code" => "300302", "name" => "개인회원등록", "url" => "../member/individual.php?mode=insert"),
					),
				),

				3 => array("code" => "300400", "name" => "회원CRM관리",
				"sub_menu" => array(
					array("code" => "300401", "name" => "회원MAIL발송", "url" => "../member/mail.php"),
					array("code" => "300402", "name" => "회원SMS발송", "url" => "../member/sms.php"),
					),
				),

				4 => array("code" => "300500", "name" => "회원별맞춤메일링",
				"sub_menu" => array(
					array("code" => "300501", "name" => "정기메일링설정", "url" => "../member/mailing.php"),
					array("code" => "300502", "name" => "정기메일링발송내역", "url" => "../member/mailing_list.php"),
					array("code" => "300503", "name" => "맞춤인재정보관리", "url" => "../member/custom_individual.php"),
					array("code" => "300504", "name" => "맞춤구인정보관리", "url" => "../member/custom_employ.php"),
					),
				),

			)
		);

		## 디자인관리
		$menu['400'] = array(
			"eng_name" => "Design",
			"menus" => array(
				0 => array("code" => "400100", "name" => "기본디자인관리", 
				"sub_menu" => array(
					array("code" => "400101", "name" => "사이트디자인설정", "url" => "../design/"),
					array("code" => "400102", "name" => "사이트로고설정", "url" => "../design/logo.php"),
					array("code" => "400103", "name" => "구인공고기본로고", "url" => "../design/employ_logo.php"),
					),
				),

				1 => array("code" => "400200", "name" => "개별디자인관리",
				"sub_menu" => array(
					array("code" => "400201", "name" => "배너관리", "url" => "../design/banner.php?position=all_top"),
					array("code" => "400202", "name" => "팝업관리", "url" => "../design/popup.php"),
					array("code" => "400203", "name" => "팝업등록", "url" => "../design/popup.php?mode=insert"),
					array("code" => "400204", "name" => "팝업스킨관리", "url" => "../design/popup_skin.php"),
					array("code" => "400205", "name" => "MAIL스킨관리", "url" => "../design/mail_skin.php"),
					),
				),

			)
		);

		## 결제관리
		$menu['500'] = array(
			"eng_name" => "Payment",
			"menus" => array(
				0 => array("code" => "500100", "name" => "결제환경관리",
				"sub_menu" => array(
					array("code" => "500101", "name" => "결제환경설정", "url" => "../payment/pg.php"),
					array("code" => "500102", "name" => "무통장입금계좌설정", "url" => "../payment/online.php"),
					array("code" => "500103", "name" => "결제페이지설정", "url" => "../payment/pg_page.php"),
					array("code" => "500104", "name" => "서비스별금액설정", "url" => "../payment/service.php"),
					),
				),

				1 => array("code" => "500200", "name" => "결제관리", 
				"sub_menu" => array(
					array("code" => "500201", "name" => "결제통합관리", "url" => "../payment/"),
					array("code" => "500202", "name" => "결제대기내역", "url" => "../payment/index.php?mode=search&status=0"),
					array("code" => "500203", "name" => "결제완료내역", "url" => "../payment/index.php?mode=search&status=1"),
					array("code" => "500204", "name" => "취소요청내역", "url" => "../payment/index.php?mode=search&status=2"),
					array("code" => "500205", "name" => "취소완료내역", "url" => "../payment/index.php?mode=search&status=3"),
					array("code" => "500206", "name" => "세금계산서신청내역", "url" => "../payment/tax.php"),
					array("code" => "500207", "name" => "현금영수증신청내역", "url" => "../payment/tax.php?type=individual"),
					),
				),

				2 => array("code" => "500300", "name" => "패키지결제관리", 
				"sub_menu" => array(
					array("code" => "500301", "name" => "구인공고패키지설정", "url" => "../payment/employ_package.php"),
					//array("code" => "500302", "name" => "구인공고패키지적용설정", "url" => "../payment/employ_package_set.php"),
					array("code" => "500303", "name" => "인재정보패키지설정", "url" => "../payment/individual_package.php"),
					//array("code" => "500304", "name" => "이력서패키지적용설정", "url" => "../payment/individual_package_set.php"),
					),
				),
			)
		);

		## 커뮤니티
		$menu['600'] = array(
			"eng_name" => "Community",
			"menus" => array(
				0 => array("code" => "600100", "name" => "게시판관리", 
				"sub_menu" => array(
					array("code" => "600101", "name" => "게시판관리", "url" => "../board/"),
					array("code" => "600102", "name" => "게시물관리", "url" => "../board/list.php?bo_table=".$bo_table),
					array("code" => "600103", "name" => "게시판메인설정", "url" => "../board/main.php"),
					array("code" => "600104", "name" => "메인게시판출력설정", "url" => "../board/main_board.php"),
					),
				),

				1 => array("code" => "600200", "name" => "운영자관리",
				"sub_menu" => array(
					array("code" => "600201", "name" => "공지사항관리", "url" => "../board/notice.php"),
					array("code" => "600202", "name" => "공지사항등록", "url" => "../board/notice.php?mode=insert"),
					array("code" => "600203", "name" => "고객문의 관리", "url" => "../board/qna.php"),
					//array("code" => "600204", "name" => "광고문의 관리", "url" => "../board/advert.php"),
					array("code" => "600205", "name" => "제휴문의 관리", "url" => "../board/concert.php"),
					//array("code" => "600205", "name" => "FAQ관리", "url" => "../board/faq.php"),
					),
				),
/*
				2 => array("code" => "600300", "name" => "설문조사관리",
				"sub_menu" => array(
					array("code" => "600301", "name" => "설문조사관리", "url" => "../board/poll.php"),
					array("code" => "600302", "name" => "설문조사등록", "url" => "../board/poll.php?mode=insert"),
					),
				),
*/
				3 => array("code" => "600400", "name" => "분류 관리",
				"sub_menu" => array(
					array("code" => "600401", "name" => "공지사항 분류", "url" => "../board/category.php?type=notice"),
					array("code" => "600402", "name" => "고객문의 분류", "url" => "../board/category.php?type=on2on"),
					//array("code" => "600403", "name" => "광고문의 분류", "url" => "../board/category.php?type=advert"),
					array("code" => "600404", "name" => "제휴문의 분류", "url" => "../board/category.php?type=concert"),
					//array("code" => "600405", "name" => "게시글 신고사유", "url" => "../board/category.php?type=board_reason"),
					//array("code" => "600405", "name" => "FAQ 분류", "url" => "../config/board.php?type=faq"),
					),
				),
			)
		);

		## 통계관리
		$menu['700'] = array(
			"eng_name" => "Statistics",
			"menus" => array(
				0 => array("code" => "700100", "name" => "통계현황", 
				"sub_menu" => array(
					array("code" => "700101", "name" => "접속통계", "url" => "../statistics/"),
					//array("code" => "700102", "name" => "구글로그분석", "url" => "../statistics/google.php"),
					//array("code" => "700103", "name" => "사이트이용현황", "url" => "../statistics/service.php"),
					),
				),

				1 => array("code" => "700200", "name" => "검색어현황", 
				"sub_menu" => array(
					array("code" => "700201", "name" => "검색어통계", "url" => "../statistics/keyword.php"),
					//array("code" => "700202", "name" => "인기검색어관리", "url" => "../statistics/popular_keyword.php"),
					array("code" => "700203", "name" => "실시간검색어관리", "url" => "../statistics/realtime_keyword.php"),
					//array("code" => "700204", "name" => "HOT검색어관리", "url" => "../statistics/hot_keyword.php"),
					),
				),
			)
		);
/*
		## 모바일
		$menu['800'] = array(
			"eng_name" => "Mobile",
			"menus" => array(
				0 => array("code" => "800100", "name" => "모바일웹", 
				"sub_menu" => array(
					array("code" => "800101", "name" => "모바일웹 설정", "url" => "../mobile/"),
					),
				),
			)
		);
*/

?>