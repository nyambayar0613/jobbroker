<?php
		/**
		* /application/nad/include/_ajax/admin_logout.php
		* @author Harimao
		* @since 2013/05/26
		* @last update 2013/05/26
		* @Module v3.5 ( Alice )
		* @Brief :: Admin logout process
		* @Comment :: 관리자 로그아웃 ajax 파일
		*/
		$alice_path = "../../../";
		
		$cat_path = "../../../";

		$realpath = $_SERVER['DOCUMENT_ROOT'].'/';	// ajax 는 절대경로

		include_once  $realpath . "_core.php";


		if(!$is_admin){

			echo $admin_control->_errors('0000');	// 관리자만 접근 가능합니다.

			exit;

		} else {

			session_unset();		// 모든 세션변수를 언레지스터 시켜줌
			session_destroy(); // 세션해제함

			echo "admin_logout_complete";	// 별도의 코드 없이 메시지로 넘긴다.

		}

?>