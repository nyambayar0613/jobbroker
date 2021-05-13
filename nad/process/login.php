<?php
		/*
		* /application/nad/process/index.php
		* @author Harimao
		* @since 2013/05/23
		* @last update 2015/02/12
		* @Module v3.5 ( Alice )
		* @Brief :: Admin Login Process
		* @Comment :: 관리자 로그인 프로세스에 따른 보안 체킹
		*/


		$alice_path = "../../";

		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		include_once $alice_path . "_core.php";


		/* 보안 체크 */
			// 보안상 POST 로만 받는다.
			$uid = addslashes($_POST['uid']);
			$passwd = $_POST['passwd'];

			if($_GET['uid']){	 // GET 으로 넘어온 uid 에러
				$utility->popup_msg_js($admin_control->_errors('0000'));
				exit;
			}
			if($_GET['passwd']){	// GET 으로 넘어온 paswd 에러
				$utility->popup_msg_js($admin_control->_errors('0000'));
				exit;
			}
			if(!$uid || empty($uid) || !isset($uid)){	 // 관리자 아이디 입력 유무
				$utility->popup_msg_js($admin_control->_errors('0001'));
				exit;
			}
			if(!$passwd || empty($passwd) || !isset($passwd)){	// 관리자 패스워드 입력 유무
				$utility->popup_msg_js($admin_control->_errors('0002'));
				exit;
			}
			if (!trim($uid) || !trim($passwd)){	// 공백체크
				$utility->popup_msg_js($admin_control->_errors('0005'));
				exit;
			}

		/* //보안 체크 */


		##
		# 관리자 계정 체크 후 로그인
		# 정보가 맞다면 세션 발급
		$result = $admin_control->admin_login( $uid, $passwd );

		if($result)
			$utility->location_href("../main");


		// Debugging check
		if( $debug == true ) {
			$_end = $utility->get_time();		// 속도측정 끝
			$_time = $_end - $_begin;
			echo "<p>작업수행시간 :: " . $_time."</p>";
		}

		$db->close();		// DB Close
?>