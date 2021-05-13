<?php
		/*
		* /application/nad/payment/index.php
		* @author Harimao
		* @since 2013/09/27
		* @last update 2015/04/15
		* @Module v3.0 ( Alice )
		* @Brief :: Payment list
		* @Comment :: 결제관리
		*/
		
		$cat_path = "../../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

		##
		# Menu Navigation
		$top_menu = "결제관리";
		$top_menu_code = "500000";	

		##
		# Include Top
		include_once "../include/top.php";

		if(is_array($_GET['status'])){
			$status = "";
		} else {
			$status = ($_GET['pay_status']) ? $_GET['pay_status'] : $_GET['status'];
		}


		$middle_menu = $menu[$tmp_menu]['menus'][1]['name'];
		$middle_menu_code = $menu[$tmp_menu]['menus'][1]['code'];
		
		$type_arr = array(
			'0' => array('name' => $menu[$tmp_menu]['menus'][1]['sub_menu'][1]['name'], 'code' => $menu[$tmp_menu]['menus'][1]['sub_menu'][1]['code']),
			'1' => array('name' => $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['name'], 'code' => $menu[$tmp_menu]['menus'][1]['sub_menu'][2]['code']),
			'2' => array('name' => $menu[$tmp_menu]['menus'][1]['sub_menu'][3]['name'], 'code' => $menu[$tmp_menu]['menus'][1]['sub_menu'][3]['code']),
			'3' => array('name' => $menu[$tmp_menu]['menus'][1]['sub_menu'][4]['name'], 'code' => $menu[$tmp_menu]['menus'][1]['sub_menu'][4]['code']),
		);

		if($status || $status=='0'){
			$sub_menu_name = $type_arr[$status]['name'];
			$sub_menu_code = $type_arr[$status]['code'];
		} else {
			$sub_menu_name = "결제통합관리";
			$sub_menu_code = "500201";
		}
		
		$sub_menu = "<dd class='col'>".$sub_menu_name."</dd>";

		if($status || $status=='0'){
			$sub_menu_url = "/" . $alice['admin_payment'] . "/index.php?mode=search&status=" . $status;
		} else {
			$sub_menu_url = "/" . $alice['admin_payment'] . "/";
		}

		##
		# 부관리자 메뉴 접근 권한 체크
		if(!$is_super_admin)	// 최고관리자가 아닐때만
			$admin_control->admin_auth_checking($admin_info['uid'],$top_menu_code,$middle_menu_code,$sub_menu_code);


		##
		# Variables
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		$con = " where `pay_pg` != 'admin' and `pay_method` != 'service' and `is_delete` = 0 ";
		//$con .= " and `pay_package` = 0 ";
		$pay_list = $payment_control->__PayList($page, $page_rows, $con);
		$pages = $utility->get_paging($page_rows, $page, $pay_list['total_page'],"./index.php?".$sorting."page_rows=".$page_rows."&".$pay_list['send_url']."&page=");
		$status_0 = number_format($payment_control->status_count('0'));
		$status_1 = number_format($payment_control->status_count('1'));
		$status_2 = number_format($payment_control->status_count('2'));
		$status_3 = number_format($payment_control->status_count('3'));

		$pay_status = $payment_control->pay_status;
		$status_color = $payment_control->status_color;

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