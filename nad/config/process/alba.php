<?php
		/*
		* /application/nad/config/process/alba.php
		* @author Harimao
		* @since 2013/08/08
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Alba Environment Infomation
		* @Comment :: 알바 환경설정 정보 입력
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크
	
		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$uid = $_POST['uid'];
		$no = $_POST['no'];

		switch($mode){

			## 알바 정보 설정
			case 'alba_update':

				$vals['pay_year'] = $_POST['pay_year'];		// 최저입금 기준연도
				$vals['time_pay'] = $_POST['time_pay'];		// 시급

				echo "<pre>";
				print_R($_POST);
				print_R($vals);
				exit;

			break;
		}
?>