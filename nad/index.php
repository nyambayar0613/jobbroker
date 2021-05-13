<?php
		/*
		* /application/nad/index.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/02/12
		* @Module v3.0 ( Alice )
		* @Brief :: Admin Index
		* @Comment :: 기본 header 만 설정하고 나머지는 스킨을 불러드려 사용한다.
		*/

		$alice_path = "../";

		$cat_path = "../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		include_once $alice_path . "_core.php";
		
		##
		# admin session checking
		# 로그인한 관리자 세션 정보가 남아있다면 /nad/main 으로 이동
		if($is_admin){
			$utility->location_href( "./main" );
		} else {	 // 없다면 세션 날림
			session_unset(); // 모든 세션변수를 언레지스터 시켜줌 
			session_destroy(); // 세션해제함 
		}

		##
		# is_demo checking
		if($is_demo){
			$Admin_uid = "netfu_admin";
			$Admin_passwd = "netfu_admin";
		}

		## 
		# header
		$style_arr = array( 'nad' );
		$config->_admin_header( '', $style_arr, '');		// body, css style, css media

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