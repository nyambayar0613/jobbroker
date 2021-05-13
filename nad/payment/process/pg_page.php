<?php
		/*
		* /application/nad/payment/process/pg_page.php
		* @author Harimao
		* @since 2013/07/23
		* @last update 2015/03/31
		* @Module v3.5 ( Alice )
		* @Brief :: Payment Gateway page config
		* @Comment :: 채용공고/이력서 등록 후 이동할 결제 페이지를 설정한다.
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

			## 알바 공고 결제 페이지 설정
			case 'alba_page':

				$vals['uid'] = $uid;
				$vals['alba_pay'] = $_POST['alba_pay'];

				$vals['main_platinum'] = @implode($_POST['main_platinum']," ");
				//$vals['main_prime'] = @implode($_POST['main_prime']," ");
				$vals['main_grand'] = @implode($_POST['main_grand']," ");
				$vals['main_special'] = @implode($_POST['main_special']," ");
				//$vals['main_list'] = @implode($_POST['main_list']," ");
				$vals['main_basic'] = @implode($_POST['main_basic']," ");

				//$vals['alba_platinum'] = @implode($_POST['alba_platinum']," ");
				//$vals['alba_banner'] = @implode($_POST['alba_banner']," ");
				//$vals['alba_list'] = @implode($_POST['alba_list']," ");
				//$vals['alba_basic'] = @implode($_POST['alba_basic']," ");

				$vals['wdate'] = $now_date;

				$result = $payment_control->update_payment_page($vals,$no);

				echo $result;

			break;

			## 알바 이력서 결제 페이지 설정
			case 'alba_resume_page':
				
				$vals['uid'] = $uid;
				$vals['alba_resume_pay'] = $_POST['alba_resume_pay'];

				$vals['main_resume_focus'] = @implode($_POST['main_resume_focus']," ");
				$vals['main_resume_busy'] = @implode($_POST['main_resume_busy']," ");
				$vals['main_resume_list'] = @implode($_POST['main_resume_list']," ");
				$vals['main_resume_basic'] = @implode($_POST['main_resume_basic']," ");


				//$vals['alba_resume_focus'] = @implode($_POST['alba_resume_focus']," ");
				//$vals['alba_resume_busy'] = @implode($_POST['alba_resume_busy']," ");
				//$vals['alba_resume_list'] = @implode($_POST['alba_resume_list']," ");
				//$vals['alba_resume_basic'] = @implode($_POST['alba_resume_basic']," ");

				$vals['wdate'] = $now_date;

				$result = $payment_control->update_payment_page($vals,$no);

				echo $result;

			break;
		}
?>