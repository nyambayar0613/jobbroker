<?php
		/*
		* /application/member/process/logout.php
		* @author Harimao
		* @since 2013/07/10
		* @last update 2015/02/27
		* @Module v3.5 ( Alice )
		* @Brief :: Member logout
		* @Comment :: 회원 로그아웃
		*/

		$alice_path = "../../";

		$cat_path = "../../";

		include_once $alice_path . "_core.php";

		if($_SESSION[$user_control->sess_user_val]){

			$result = $user_control->user_logout($_SESSION[$user_control->sess_user_val]);

		} else {

			$result = "0015";

		}

		if($_GET['is_delete']){
			$utility->popup_msg_js("","/");
		} else {
			echo $result;
		}

?>