<?php
		/*
		* /application/nad/design/views/_load/mail.php
		* @author Harimao
		* @since 2013/06/13
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Mail Form design
		* @Comment :: 편집메일 선택에 따른 메일 발송 폼 설정
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mail_skin = $_POST['mail_skin'];

		$get_mail_skin = $design_control->get_mail_skin($mail_skin);	// 선택 메일 스킨
		
		echo $utility->make_cheditor('content', stripslashes($get_mail_skin['content']));

?>