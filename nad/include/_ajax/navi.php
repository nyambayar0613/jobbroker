<?php
		/*
		* /application/nad/include/_ajax/navi.php
		* @author Harimao
		* @since 2013/06/11
		* @last update 2013/06/11
		* @Module v3.5 ( Alice )
		* @Brief :: Quick menu add
		* @Comment :: 퀵 메뉴 추가 ajax 
		*/

		$alice_path = "../../../";
		
		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$uid = $_POST['uid'];
		$top_menu_code = $_POST['top_menu_code'];
		$middle_menu_code = $_POST['middle_menu_code'];
		$sub_menu_code = $_POST['sub_menu_code'];

		switch($mode){
			## 퀵메뉴 입력
			case 'quick_insert':

				$duplication_quick = $quick_control->duplication_quick( $uid, $top_menu_code, $middle_menu_code, $sub_menu_code);

				if($duplication_quick){

					echo $quick_control->_errors('0000');
					exit;

				} else {

					$vals['uid'] = $_POST['uid'];
					$vals['top_menu'] = $_POST['top_menu'];
					$vals['top_menu_code'] = $top_menu_code;
					$vals['middle_menu'] = $_POST['middle_menu'];
					$vals['middle_menu_code'] = $middle_menu_code;
					$vals['sub_menu'] = $_POST['sub_menu'];
					$vals['sub_menu_code'] = $sub_menu_code;
					$vals['url'] = $_POST['url'];
					$vals['wdate'] = $now_date;

					$result = $quick_control->quick_insert($vals);

					if(!$result)
						echo $quick_control->_errors('0000');

				}

			break;
		}

?>