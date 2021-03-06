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
			'100000' => 'Ажлын байрны зар удирдах',
			'200000' => 'Орчны тохиргоо',
			'300000' => 'Гишүүд удирдах',
			'400000' => 'Дизайн',
			'500000' => 'Төлбөр тооцоо удирдах',
			'600000' => 'Комиунити',
             '700000' => 'Статистик',
			//'800000' => '모바일웹',
		);


		if (isset($top_menu_code))
            $tmp_menu = substr($top_menu_code, 0, 3);

		## 서비스관리
		$menu['100'] = array(
			"eng_name" => "Service",
			"menus" => array(
				0 => array("code" => "100100", "name" => "Ажлын байрны зар удирдах",
				"sub_menu" => array(
					array("code" => "100101", "name" => "Нийт ажлын байрны зар", "url" => "../alba/"), // 전체 구인공고 관리
					//array("code" => "100102", "name" => "사용자 등록 구인공고", "url" => "../alba/?is_admin=0"),
					//array("code" => "100103", "name" => "관리자 등록 구인공고", "url" => "../alba/?is_admin=1"),
					array("code" => "100102", "name" => "Үргэлжилж буй ажлын зар", "url" => "../alba/employ_ing.php"),
					array("code" => "100103", "name" => "Хугацаа дууссан ажлын зар", "url" => "../alba/employ_end.php"),
					array("code" => "100104", "name" => "Ажлын зар бүртгүүлэх", "url" => "../alba/?mode=insert"),
					array("code" => "100105", "name" => "Мэдээ мэдээлэл", "url" => "../alba/employ_report.php"),
					array("code" => "100109", "name" => "Хугацаа дууссан үйлчилгээ", "url" => "../alba/employ_serviced.php"),
					//array("code" => "100106", "name" => "구인공고 댓글 관리", "url" => "../alba/employ_comment.php"),
					array("code" => "100107", "name" => "Ажлын байрны өрөгдөл", "url" => "../alba/employ_become.php"),
					array("code" => "100108", "name" => "Ажлын байрны scrab", "url" => "../alba/employ_scrap.php"),
					),
				),

				1 => array("code" => "100200", "name" => "Хүний нөөц удирдлага",
				"sub_menu" => array(
					array("code" => "100201", "name" => "Анкет удирдлага", "url" => "../alba/resume.php"),
					array("code" => "100202", "name" => "Анкет бүртгэл", "url" => "../alba/resume.php?mode=insert"),
					array("code" => "100203", "name" => "Анкет менежментийг удирдах", "url" => "../alba/resume_report.php"),
					array("code" => "100205", "name" => "Үйлчилгээний хугацаа дууссан анкет", "url" => "../alba/resume_serviced.php"),
					array("code" => "100204", "name" => "Анкет scrab удирдах", "url" => "../alba/resume_scrap.php"),
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
				0 => array("code" => "200100", "name" => "Сайт удирдах",
				"sub_menu" => array(
					array("code" => "200101", "name" => "Ерөнхий мэдээллийн тохиргоо", "url" => "../config/"),
					//array("code" => "200102", "name" => "사이트소개", "url" => "../config/content.php?type=site_introduce"),
					array("code" => "200103", "name" => "Гишүүнчлэлийн нөхцөл", "url" => "../config/content.php?type=site_agreement"),
					array("code" => "200104", "name" => "Нууцлалын мэдэгдэл", "url" => "../config/content.php?type=site_privacy"),
					array("code" => "200105", "name" => "Хувийн мэдээллийг цуглуулах, ашиглах заавар", "url" => "../config/content.php?type=privacy_info"),
					array("code" => "200105", "name" => "Мэдээллийн самбар", "url" => "../config/content.php?type=board_criterion"),
					array("code" => "200106", "name" => "Зөвшөөрөлгүй и-мэйл цуглуулахаас татгалзах", "url" => "../config/content.php?type=email_denied"),
					array("code" => "200107", "name" => "Сайтын доод хэсэг", "url" => "../config/content.php?type=site_bottom"),
					array("code" => "200108", "name" => "Шуудангийн доод хэсэг", "url" => "../config/content.php?type=email_bottom"),
					),
				),

				1 => array("code" => "200200", "name" => "Үйлчилгээ / гаралтын тоог тохируулах",
				"sub_menu" => array(
					//array("code" => "200201", "name" => "구인정보 설정", "url" => "../config/alba.php"),
					//array("code" => "200202", "name" => "인재정보 설정", "url" => "../config/alba_individual.php"),
					array("code" => "200201", "name" => "SMS орчны тохиргоо", "url" => "../config/sms.php"),
					array("code" => "200202", "name" => "Map тохиргоо", "url" => "../config/map.php"),
					),
				),

				2 => array("code" => "200300", "name" => "Бүртгэл",
				"sub_menu" => array(
					array("code" => "200301", "name" => "Байгууллагын бүртгэл тохируулах", "url" => "../config/register_form.php?type=company_form"),
					array("code" => "200302", "name" => "Ажлын байрны мэдээллийн тохиргоо", "url" => "../config/register_form.php?type=alba_form"),
					array("code" => "200303", "name" => "Анкет тохиргоо", "url" => "../config/register_form.php?type=alba_resume"),
					array("code" => "200304", "name" => "Гишүүнээс гарах хүсэлт", "url" => "../config/category.php?type=member_left_reason"),
					array("code" => "200305", "name" => "Ажлын зарын талаар мэдээлэх", "url" => "../config/category.php?type=alba_report_reason"),
					array("code" => "200306", "name" => "Анкет тайлагнах", "url" => "../config/category.php?type=alba_resume_report_reason"),
					/*
					array("code" => "200306", "name" => "구인공고 신고 사유", "url" => "../config/board.php?type=reason_alba"),
					array("code" => "200306", "name" => "이력서 신고 사유", "url" => "../config/board.php?type=reason_alba_individual"),
					*/
					),
				),

				3 => array("code" => "200400", "name" => "Ангилал",
				"sub_menu" => array(
					array("code" => "200401", "name" => "Нийтлэг хэрэглээний ангилал", "url" => "../config/category.php?type=job_type", "subs" =>
						array(
							"job_type" => array("code" => "200401", "name" => "Ажил мэргэжил", "url" => "../config/category.php?type=job_type"),
							"area" => array("name" => "Бүс нутаг", "url" => "../config/category.php?type=area"),
							"subway" => array("name" => "Метроны буудалтай ойр", "url" => "../config/category.php?type=subway"),
							"impediment" => array("name" => "Хөгжлийн бэрхшээлийн түвшин", "url" => "../config/category.php?type=impediment"),
							"work_type" => array("name" => "Албан тушаалын төрөл", "url" => "../config/category.php?type=work_type"),
							"alba_date" => array("name" => "Ажиллах хугацаа", "url" => "../config/category.php?type=alba_date"),
							"alba_week" => array("name" => "Ажлын өдөр", "url" => "../config/category.php?type=alba_week"),
							"alba_pay" => array("name" => "Цалингийн нөхцөл", "url" => "../config/category.php?type=alba_pay"),
							//"pay" => array("name" => "연봉", "url" => "../config/category.php?type=pay"),
							//"high_school" => array("name" => "고등학교", "url" => "../config/category.php?type=high_school"),
							//"half_college" => array("name" => "대학(2,3년)", "url" => "../config/category.php?type=half_college"),
							//"college" => array("name" => "대학(4년)", "url" => "../config/category.php?type=college"),
							//"graduate" => array("name" => "대학원", "url" => "../config/category.php?type=graduate"),
						),
					),
					array("code" => "200402", "name" => "Гишүүнчлэлийн ангилал", "url" => "../config/category.php?type=email", "subs"=>
						array(
							//"passwd_question" => array("name" => "비밀번호재발급 질문", "url" => "../config/category.php?type=passwd_question"),оүзирх
							"email" => array("name" => "И-мэйл", "url" => "../config/category.php?type=email"),
							"biz_type" => array("name" => "Байгууллагын төрөл", "url" => "../config/category.php?type=biz_type"),
							"biz_success" => array("name" => "Жагсаалтанд орсон эсэх", "url" => "../config/category.php?type=biz_success"),
							"biz_form" => array("name" => "Байгуулагын хэлбэр", "url" => "../config/category.php?type=biz_form"),
						),
					),
					array("code" => "200403", "name" => "Ажлын байрны ангилал", "url" => "../config/category.php?type=job_welfare", "subs" =>
						array(
							"job_welfare" => array("name" => "Даатгал/халамж", "url" => "../config/category.php?type=job_welfare"),
							"job_ability" => array("name" => "Боловсрол", "url" => "../config/category.php?type=job_ability"),
							"job_career" => array("name" => "Ажил мэргэжил", "url" => "../config/category.php?type=job_career"),
							"preferential" => array("name" => "Нэмэлт чадвар", "url" => "../config/category.php?type=preferential"),
							"pt_paper" => array("name" => "Баримт бичиг", "url" => "../config/category.php?type=pt_paper"),
							"job_college" => array("name" => "Ойролцоох сургууль", "url" => "../config/category.php?type=job_college"),
							"job_age" => array("name" => "Насны ангилал", "url" => "../config/category.php?type=job_age"),
							"job_target" => array("name" => "Ажилд авах", "url" => "../config/category.php?type=job_target"),
							"alba_pay_type" => array("name" => "Цалингийн нөхцөл", "url" => "../config/category.php?type=alba_pay_type"),
							"alba_content" => array("name" => " Дэлгэрэнгүй заавар", "url" => "../config/category.php?type=alba_content"),
							//"alba_profesional" => array("name" => "전문구인정보설정", "url" => "../config/category.php?type=alba_profesional"),
							//"job_report" => array("name" => "구인정보 신고사유", "url" => "../config/category.php?type=job_report"),
							//"biz_field" => array("name" => "구인정보 전문분야", "url" => "../config/category.php?type=biz_field"),
						),
					),
					array("code" => "200404", "name" => "Хүний нөөцийн мэдээллийн ангилал", "url" => "../config/category.php?type=indi_language", "subs" =>
						array(
							"indi_language" => array("name" => "Гадаад хэл", "url" => "../config/category.php?type=indi_language"),
							"indi_language_license" => array("name" => "Гадаад хэлний албан ёсны шалгалт", "url" => "../config/category.php?type=indi_language_license"),
							"indi_oa" => array("name" => "Компьютер дээр ажиллах чадвар", "url" => "../config/category.php?type=indi_oa"),
							"indi_special" => array("name" => "Тайлбар", "url" => "../config/category.php?type=indi_special"),
							"indi_introduce" => array("name" => "CV", "url" => "../config/category.php?type=indi_introduce"),
							"indi_treatment" => array("name" => "Хөгжлийн бэрхшээлтэй эсэх", "url" => "../config/category.php?type=indi_treatment"),
							"alba_time" => array("name" => "Ажлын цаг", "url" => "../config/category.php?type=alba_time"),
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

				4 => array("code" => "200500", "name" => "Админ",
				"sub_menu" => array(
					array("code" => "200501", "name" => "Админы мэдээллийн тохиргоо", "url" => "../config/admin.php"),
					array("code" => "200502", "name" => "Дэд админ", "url" => "../config/sadmin.php"),
					array("code" => "200503", "name" => "Админ бүртгэх", "url" => "../config/sadmin.php?mode=insert"),
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
				0 => array("code" => "300100", "name" => "Гишүүдийн нэгдсэн удирдлага",
				"sub_menu" => array(
					array("code" => "300101", "name" => "Нийт гишүүд", "url" => "../member/"),
					array("code" => "300102", "name" => "Алдаа гарсан гишүүд", "url" => "../member/bad_list.php"),
					array("code" => "300103", "name" => "Цуцлах хүсэлт", "url" => "../member/left_list.php"),
					array("code" => "300104", "name" => "Гишүүнээс гарах", "url" => "../member/left_list.php?type=left"),
					array("code" => "300105", "name" => "Гишүүнчлэлийн түвшин/point тохиргоо", "url" => "../member/level.php"),
					array("code" => "300106", "name" => "Гишүүний point оноо", "url" => "../member/point.php"),
					//array("code" => "300107", "name" => "회원간쪽지발송내역", "url" => "../member/memo.php"),
					//array("code" => "300108", "name" => "회원간SMS발송내역", "url" => "../member/sms_log.php"),
					),
				),

				1 => array("code" => "300200", "name" => "Байгууллагын нэгдсэн удирдлага",
				"sub_menu" => array(
					array("code" => "300201", "name" => "Байгууллагын нэгдсэн удирдлага", "url" => "../member/company.php"),
					array("code" => "300202", "name" => "Байгууллагын гишүүн бүртгэл", "url" => "../member/company.php?mode=insert"),
					array("code" => "300303", "name" => "Байгууллагын мэдээлэл", "url" => "../member/company_info.php"),
					),
				),

				2 => array("code" => "300300", "name" => "Хувь хүн",
				"sub_menu" => array(
					array("code" => "300301", "name" => "Хувь хүн", "url" => "../member/individual.php"),
					array("code" => "300302", "name" => "Хувь хүн бүртгэл", "url" => "../member/individual.php?mode=insert"),
					),
				),

				3 => array("code" => "300400", "name" => "Гишүүн CRM удирдлага",
				"sub_menu" => array(
					array("code" => "300401", "name" => "Гишүүний MAIL илгээх", "url" => "../member/mail.php"),
					array("code" => "300402", "name" => "Гишүүний SMS илгээх", "url" => "../member/sms.php"),
					),
				),

				4 => array("code" => "300500", "name" => "Гишүүн бүрт MAIL илгээх",
				"sub_menu" => array(
					array("code" => "300501", "name" => "Байнгын шуудангийн тохиргоо", "url" => "../member/mailing.php"),
					array("code" => "300502", "name" => "Илгээсэн түүх", "url" => "../member/mailing_list.php"),
					array("code" => "300503", "name" => "Санал болгох хүний нөөцийн мэдээлэл", "url" => "../member/custom_individual.php"),
					array("code" => "300504", "name" => "Санал болгох ажлын байрны мэдээлэл", "url" => "../member/custom_employ.php"),
					),
				),

			)
		);

		## 디자인관리
		$menu['400'] = array(
			"eng_name" => "Design",
			"menus" => array(
				0 => array("code" => "400100", "name" => "Ерөнхий дизайн",
				"sub_menu" => array(
					array("code" => "400101", "name" => "Сайтын дизайн тохиргоо", "url" => "../design/"),
					array("code" => "400102", "name" => "Сайтын лого", "url" => "../design/logo.php"),
					array("code" => "400103", "name" => "Зарын ерөнхий лого", "url" => "../design/employ_logo.php"),
					),
				),

				1 => array("code" => "400200", "name" => "Дизайн",
				"sub_menu" => array(
					array("code" => "400201", "name" => "Banner", "url" => "../design/banner.php?position=all_top"),
					array("code" => "400202", "name" => "POPUP", "url" => "../design/popup.php"),
					array("code" => "400203", "name" => "POPUP бүртгэл", "url" => "../design/popup.php?mode=insert"),
					array("code" => "400204", "name" => "POPUP skin", "url" => "../design/popup_skin.php"),
					array("code" => "400205", "name" => "MAIL skin", "url" => "../design/mail_skin.php"),
					),
				),

			)
		);

		## 결제관리
		$menu['500'] = array(
			"eng_name" => "Payment",
			"menus" => array(
				0 => array("code" => "500100", "name" => "Төлбөрийн орчин",
				"sub_menu" => array(
					array("code" => "500101", "name" => "Төлбөрийн орчны тохиргоо", "url" => "../payment/pg.php"),
					array("code" => "500102", "name" => "Данс холбох", "url" => "../payment/online.php"),
					array("code" => "500103", "name" => "Төлбөрийн хуудас тохиргоо", "url" => "../payment/pg_page.php"),
					array("code" => "500104", "name" => "Үйлчилгээни төлбөр тохиргоо", "url" => "../payment/service.php"),
					),
				),

				1 => array("code" => "500200", "name" => "Төлбөр",
				"sub_menu" => array(
					array("code" => "500201", "name" => "Төлбөрийн нэгдсэн удирдлага", "url" => "../payment/"),
					array("code" => "500202", "name" => "Төлбөрийн түүх", "url" => "../payment/index.php?mode=search&status=0"),
					array("code" => "500203", "name" => "Төлбөр амжилттай хийгдсэн түүх", "url" => "../payment/index.php?mode=search&status=1"),
					array("code" => "500204", "name" => "Цуцлах хүсэлтийн түүх", "url" => "../payment/index.php?mode=search&status=2"),
					array("code" => "500205", "name" => "Цуцлалт амжилттай түүх", "url" => "../payment/index.php?mode=search&status=3"),
					array("code" => "500206", "name" => "Татварын нэхэмжлэлийн түүх", "url" => "../payment/tax.php"),
					array("code" => "500207", "name" => "Бэлэн мөнгөний баримт", "url" => "../payment/tax.php?type=individual"),
					),
				),

				2 => array("code" => "500300", "name" => "Package төлбөр тооцоо",
				"sub_menu" => array(
					array("code" => "500301", "name" => "Ажлын зарын package тохиргоо", "url" => "../payment/employ_package.php"),
					//array("code" => "500302", "name" => "구인공고패키지적용설정", "url" => "../payment/employ_package_set.php"),
					array("code" => "500303", "name" => "Хүний нөөцийн package тохиргоо", "url" => "../payment/individual_package.php"),
					//array("code" => "500304", "name" => "이력서패키지적용설정", "url" => "../payment/individual_package_set.php"),
					),
				),
			)
		);

		## 커뮤니티
		$menu['600'] = array(
			"eng_name" => "Community",
			"menus" => array(
				0 => array("code" => "600100", "name" => "Мэдээллийн самбар",
				"sub_menu" => array(
					array("code" => "600101", "name" => "Мэдээллийн самбар", "url" => "../board/"),
					array("code" => "600102", "name" => "Post", "url" => "../board/list.php?bo_table=".$bo_table),
					array("code" => "600103", "name" => "Мэдээллийн самбар үндсэн тохиргоо", "url" => "../board/main.php"),
					array("code" => "600104", "name" => "Үндсэн гаралт", "url" => "../board/main_board.php"),
					),
				),

				1 => array("code" => "600200", "name" => "Оператор",
				"sub_menu" => array(
					array("code" => "600201", "name" => "Анхаарах зүйлс", "url" => "../board/notice.php"),
					array("code" => "600202", "name" => "Анхаарах зүйлс бүртгэл", "url" => "../board/notice.php?mode=insert"),
					array("code" => "600203", "name" => "Хэрэглэгчийн лавлагаа", "url" => "../board/qna.php"),
					//array("code" => "600204", "name" => "광고문의 관리", "url" => "../board/advert.php"),
					array("code" => "600205", "name" => "Нэгдсэн лавлагаа", "url" => "../board/concert.php"),
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
				3 => array("code" => "600400", "name" => "Ангилал",
				"sub_menu" => array(
					array("code" => "600401", "name" => "Анхаарах зүйлс", "url" => "../board/category.php?type=notice"),
					array("code" => "600402", "name" => "Хэрэглэгчийн лавлагаа", "url" => "../board/category.php?type=on2on"),
					//array("code" => "600403", "name" => "광고문의 분류", "url" => "../board/category.php?type=advert"),
					array("code" => "600404", "name" => "Нэгдсэн лавлагаа", "url" => "../board/category.php?type=concert"),
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
				0 => array("code" => "700100", "name" => "Статистик",
				"sub_menu" => array(
					array("code" => "700101", "name" => "Нэвтрэлт", "url" => "../statistics/"),
					//array("code" => "700102", "name" => "구글로그분석", "url" => "../statistics/google.php"),
					//array("code" => "700103", "name" => "사이트이용현황", "url" => "../statistics/service.php"),
					),
				),

				1 => array("code" => "700200", "name" => "Хайлтын нэр",
				"sub_menu" => array(
					array("code" => "700201", "name" => "Хайлт", "url" => "../statistics/keyword.php"),
					//array("code" => "700202", "name" => "인기검색어관리", "url" => "../statistics/popular_keyword.php"),
					array("code" => "700203", "name" => "Цаг тутмын хайлт", "url" => "../statistics/realtime_keyword.php"),
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