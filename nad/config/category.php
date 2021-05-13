<?php
		/*
		* /application/nad/config/category.php
		* @author Harimao
		* @since 2013/05/26
		* @last update 2014/03/06
		* @Module v3.5 ( Alice )
		* @Brief :: Admin category config
		* @Comment :: 무통장입금설정
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "환경설정";
		$top_menu_code = "200000";

		##
		# Include Top
		include_once "../include/top.php";

		$middle_menu = $menu[$tmp_menu]['menus'][3]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][3]['code'];
		$sub_menus = $menu[$tmp_menu]['menus'][3]['sub_menu'];	 // 서브 메뉴

		$type_arr = array( 
			// 공통적용 분류
			'job_type' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'], 
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			'area' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			'subway' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			'pay' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			'impediment' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			'work_type' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			/*
			'high_school' => array(	// 고등학교
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			), 
			'half_college' => array(	// 대학(2,3년)
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			), 
			'college' => array(	// 대학(4년)
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			), 
			'graduate' => array(	// 대학원
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			*/

			// 회원가입 분류
			'passwd_question' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['subs'][$type]['name'],
			),
			'email' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['subs'][$type]['name'],
			),
			'biz_type' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['subs'][$type]['name'],
			),
			'biz_success' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['subs'][$type]['name'],
			),
			'biz_form' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][1]['subs'][$type]['name'],
			),

			// 채용정보 분류
			'job_welfare' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'job_ability' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'job_career' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'preferential' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'pt_paper' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'job_report' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'job_college' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'job_age' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'job_target' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),

			// 인재정보 분류
			/* 학력
			'indi_ability' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			*/
			'indi_language' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			'indi_language_license' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			'indi_oa' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			'indi_special' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			'indi_introduce' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			'indi_treatment' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			/*
			'indi_report' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			*/
			/* 전문분야
			'indi_field' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			*/

			// 아르바이트 분류
			'alba_date' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			'alba_time' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			'alba_week' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			'alba_pay' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][0]['subs'][$type]['name'],
			),
			'alba_pay_type' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'alba_content' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),
			'alba_paper' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][4]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][4]['subs'][$type]['name'],
			),
			'alba_type' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][4]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][4]['subs'][$type]['name'],
			),

			// 등록폼 :: 사유
			'member_left_reason' => array (
				'name' => $menu[$tmp_menu]['menus'][2]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][2]['sub_menu'][3]['code'],
			),
			'alba_report_reason' => array (
				'name' => $menu[$tmp_menu]['menus'][2]['sub_menu'][4]['name'], 'code' => $menu[$tmp_menu]['menus'][2]['sub_menu'][4]['code'],
			),
			'alba_resume_report_reason' => array (
				'name' => $menu[$tmp_menu]['menus'][2]['sub_menu'][5]['name'], 'code' => $menu[$tmp_menu]['menus'][2]['sub_menu'][5]['code'],
			),

			// 전문인재정보설정
			'indi_profesional' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][3]['subs'][$type]['name'],
			),
			// 전문채용정보설정
			'alba_profesional' => array(
				'name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['code'],
				'sub_name' => $menu[$tmp_menu]['menus'][3]['sub_menu'][2]['subs'][$type]['name'],
			),

		);

		$sub_menu_name  = $type_arr[$type]['name'];
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";
		$sub_menu_code = $type_arr[$type]['code'];

		$sub_menu_url = "/" . $alice['admin_config'] . "/category.php?type=" . $type;

		// reason array
		$reason_types = array( 'member_left_reason', 'alba_report_reason', 'alba_resume_report_reason' );

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);

		##
		# Listing
		if($type=='job_college') {
			$category_list = $category_control->category_codeList('area');
		} else if($type=='indi_profesional' || $type=='alba_profesional'){ 
			$category_list = $category_control->category_codeList('job_type');
		} else {
			//$type = ($type=='indi_profesional') ? 'job_type' : $type;
			$category_list = $category_control->category_codeList($type);
		}

		##
		# Variables
		$multiple_type = array( "job_type", "area", "subway", "job_college", "indi_profesional" );
		$double_type = array( "job_welfare", "alba_pay" );
		//$is_job = ($type=='job_type') ? true : false;
		$is_job = false;
		$is_pay = ($type=='alba_pay') ? true : false;	// 급여 기준
		//$pay_level = $category_control->pay_level;
		$is_professional = false;	 // 전문인재정보설정
		if($type=='indi_profesional'){
			$is_professional = true;
			$professional_indi = explode(',',$design['professional_indi']);	 // 전문인재정보
			$professional_indi_cnt = count($professional_indi);

			if($professional_indi[0]!=''){
				$professional_vals = "";
				for($i=0;$i<$professional_indi_cnt;$i++){ 
					$professional_vals[$i] = $utility->remove_quoted( $category_control->get_categoryCodeName($professional_indi[$i]) );
				}
				$professional_text = implode($professional_vals,', ');
			} else {
				$professional_text = "전문인재정보 직종을 선택해 주세요.";
			}
		} else if($type=='alba_profesional'){
			$is_professional = true;
			$professional_indi = explode(',',$design['professional_alba']);	 // 전문채용정보
			$professional_indi_cnt = count($professional_indi);

			if($professional_indi[0]!=''){
				$professional_vals = "";
				for($i=0;$i<$professional_indi_cnt;$i++){ 
					$professional_vals[$i] = $utility->remove_quoted( $category_control->get_categoryCodeName($professional_indi[$i]) );
				}
				$professional_text = implode($professional_vals,', ');
			} else {
				$professional_text = "전문채용정보 직종을 선택해 주세요.";
			}
		}

		##
		# Include view
		if($is_professional){
			if(is_file($alice['self'] . 'views/professional_category.html'))
				include_once $alice['self'] . 'views/professional_category.html';
			else
				$config->error_info( $alice['self'] . 'views/professional_category.html' );
		} else {
			if(is_file($alice['self'] . 'views/category.html'))
				include_once $alice['self'] . 'views/category.html';
			else
				$config->error_info( $alice['self'] . 'views/category.html' );
		}

		// Debugging check
		if( $is_debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close

?>