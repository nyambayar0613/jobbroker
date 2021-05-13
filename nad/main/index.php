<?php
		/*
		* /application/nad/main/index.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/04/20
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Index
		* @Comment :: 기본 header 만 설정하고 나머지는 스킨을 불러드려 사용한다.
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Include Top
		include_once "../include/top.php";

		##
		# NETFU 공지사항/솔루션업데이트 추출
		$netfu_notice = $admin_control->print_netfuXML('notice');
		$netfu_update = $admin_control->print_netfuXML('update');

		##
		# 1:1 고객상담
		$page = 1;
		$page_rows = 5;
		$cs_list = $cs_control->__CsList($page, $page_rows, " where `wr_type` = 0 ");

		##
		# Variables
		$page_view_arr = $statistics_control->page_view_arr;

		// 전체 view count
		$total_page_views = 0;
		foreach($page_view_arr as $key => $val){
			$total_page_views += $admin_control->page_views($key, date('Y-m'));
		}

		##
		# 서비스이용현황
		$pg_list = $payment_control->__PgList();	// 전체 리스트
		$get_pg = $payment_control->get_use_pg(1);
		$pg_company = $get_pg['pg_company'];
		$_method = $payment_control->pg_method;	// 결제수단
		$methods = explode('/',$get_pg['pg_method']);

		##
		# 회원현황
		$allMember = $member_control->get_member_cnt();	// 전체회원 count
		$leftMember = $member_control->get_member_cnt(" where `mb_left` = 1 ");	// 탈퇴회원 count
		$visit_counts = explode(",",$env['visit_count']);
		$visit_count_total = explode(':',$visit_counts[4]);
		$visit_count = number_format($visit_count_total[1]);	// 전체회원
		$y_day7 = date('Y-m-d', time()-(60*60*24*7));	// 7일전
		$y_day5 = date('Y-m-d', time()-(60*60*24*5));	// 5일전
		$y_day3 = date('Y-m-d', time()-(60*60*24*3));	// 3일전
		$y_day1 = date('Y-m-d', time()-(60*60*24*1));	// 1일전
		//select * from `alice_member` where `mb_wdate` between '2012-09-18 00:00:00' and '2012-09-23 23:59:59' 
		$latestMember = $member_control->get_member_cnt(" where `mb_wdate` between '".$y_day5." 00:00:00' and '".date('Y-m-d')." 23:59:59' ");	// 신규가입 count

		$get_visits_main = $statistics_control->get_visits_main();

		$get_visits = $statistics_control->get_visits();


		$yoil = array("일","월","화","수","목","금","토");


		// 방문자
		$visit_month = $get_visits_main['visit_month'];
		$visit_week = $get_visits_main['visit_week'];
		$visit_friday = $get_visits_main['visit_friday'];
		$visit_today = $get_visits_main['visit_today'];
		
		$visit_sum = $visit_month + $visit_week + $visit_today;
		$visit_month_pert = ($visit_month) ? sprintf("%.2f%%", ($visit_month/$visit_sum) * 100) : "0%";
		$visit_week_pert = ($visit_week) ? sprintf("%.2f%%", ($visit_week/$visit_sum) * 100) : "0%";
		$visit_today_pert = ($visit_today) ? sprintf("%.2f%%", ($visit_today/$visit_sum) * 100) : "0%";

		// 회원수
		$member_month = $get_visits_main['member_month'];
		$member_week = $get_visits_main['member_week'];
		$member_today = $get_visits_main['member_today'];
		$member_sum = $member_month + $member_week + $member_today;
		$member_month_pert = ($member_month) ? sprintf("%.2f%%", ($member_month/$member_sum) * 100) : "0%";
		$member_week_pert = ($member_week) ? sprintf("%.2f%%", ($member_week/$member_sum) * 100) : "0%";
		$member_today_pert = ($member_today) ? sprintf("%.2f%%", ($member_today/$member_sum) * 100) : "0%";

		// 정규직 등록수
		$alba_month = $get_visits_main['alba_month'];
		$alba_week = $get_visits_main['alba_week'];
		$alba_today = $get_visits_main['alba_today'];
		$alba_sum = $alba_month + $alba_week + $alba_today;
		$alba_month_pert = ($alba_month) ? sprintf("%.2f%%", ($alba_month/$alba_sum) * 100) : "0%";
		$alba_week_pert = ($alba_week) ? sprintf("%.2f%%", ($alba_week/$alba_sum) * 100) : "0%";
		$alba_today_pert = ($alba_today) ? sprintf("%.2f%%", ($alba_today/$alba_sum) * 100) : "0%";

		// 이력서 등록수
		$resume_month = $get_visits_main['resume_month'];
		$resume_week = $get_visits_main['resume_week'];
		$resume_today = $get_visits_main['resume_today'];
		$resume_sum = $resume_month + $resume_week + $resume_today;
		$resume_month_pert = ($resume_month) ? sprintf("%.2f%%", ($resume_month/$resume_sum) * 100) : "0%";
		$resume_week_pert = ($resume_week) ? sprintf("%.2f%%", ($resume_week/$resume_sum) * 100) : "0%";
		$resume_today_pert = ($resume_today) ? sprintf("%.2f%%", ($resume_today/$resume_sum) * 100) : "0%";

		// 매출액
		$price_month = $get_visits_main['price_month'];
		$price_week = $get_visits_main['price_week'];
		$price_today = $get_visits_main['price_today'];
		$price_sum = $price_month + $price_week + $price_today;
		$price_month_pert = ($price_month) ? sprintf("%.2f%%", ($price_month/$price_sum) * 100) : "0%";
		$price_week_pert = ($price_week) ? sprintf("%.2f%%", ($price_week/$price_sum) * 100) : "0%";
		$price_today_pert = ($price_today) ? sprintf("%.2f%%", ($price_today/$price_sum) * 100) : "0%";
			
		##
		# 결제현황
		$pay_list = $payment_control->__PayList($page, $page_rows, " where `pay_pg` != 'admin' and `is_delete` = 0 and `pay_service` is not null and `pay_wdate` >= curdate() ");	// 최근 5건

		##
		# 게시판현황
		$board_list = $board_config_control->__BoardList("","",""," `no` asc ");


		// 저번주 날짜 구하기
		$today = time();
		$week = date("w");
		$week_first = $today-($week*86400);
		$week_last = $week_first+(6*86400);
		$last_week = date("Y-m-d",$week_first-(86400*7))." ~ ".date("Y-m-d",$week_last-(86400*7));

		##
		# 채용공고 등록 현황
		$today_employ = $alba_control->__AlbaList("",""," where INSTR(`wr_wdate`, '".date('Y-m-d')."') and `is_delete` = 0 ");	// 오늘
		$yester_employ = $alba_control->__AlbaList("",""," where INSTR(`wr_wdate`, '".date('Y-m-d', strtotime('-1 day'))."') and `is_delete` = 0 ");	// 어제
		$last_employ = $alba_control->__AlbaList("",""," where `wr_wdate` between '".date("Y-m-d",$week_first-(86400*7))."' and '".date("Y-m-d",$week_last-(86400*7))."' and `is_delete` = 0 ");	// 지난주

		##
		# 이력서 등록 현황
		$today_resume = $alba_resume_control->__ResumeList("",""," where INSTR(`wr_wdate`, '".date('Y-m-d')."') and `is_delete` = 0 ");	// 오늘
		$yester_resume = $alba_resume_control->__ResumeList("",""," where INSTR(`wr_wdate`, '".date('Y-m-d', strtotime('-1 day'))."') and `is_delete` = 0 ");	// 어제
		$last_resume = $alba_resume_control->__ResumeList("",""," where `wr_wdate` between '".date("Y-m-d",$week_first-(86400*7))."' and '".date("Y-m-d",$week_last-(86400*7))."' and `is_delete` = 0 ");	// 지난주

		##
		# 실시간 검색어
		$category_list = $search_control->__SearchList("realtime"," `wr_hit` desc ", 10);

		/*
		echo "<pre style='color:#fff;'>";
		print_R($category_list);
		echo "</pre>";
		*/

		##
		# Include view
		if(is_file($alice['self'] . 'views/index.html'))
			include_once $alice['self'] . 'views/index.html';
		else
			$config->error_info( $alice['self'] . 'views/index.html' );

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>