<?php
		/*
		* /application/nad/design/process/logo.php
		* @author Harimao
		* @since 2013/08/07
		* @last update 2015/04/02
		* @Module v3.5 ( Alice )
		* @Brief :: Site design Setting
		* @Comment :: 사이트 디자인 설정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";
		
		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$type = $_POST['type'];
		$uid = $_POST['uid'];
		$no = $_POST['no'];

		$admin_control->is_admin( $ajax );	// 관리자 체크


		switch($mode){

			## 디자인 수정(설정)
			case 'update':

				$vals['uid'] = $uid;
				$vals['site_color'] = $_POST['site_color'];
				$vals['ui_theme'] = $_POST['ui_theme'];
				//$vals['map_use'] = $_POST['map_use'];	// 지도 사용 유무
				//$vals['professional_indi'] = @implode($_POST['professional_val'],',');	// 전문인재정보

				$vals['skin_color'] = $_POST['skin_color'];
				$vals['menu_skin'] = $_POST['menu_skin'];
				$vals['main_skin'] = $_POST['main_skin'];
				$vals['main_left'] = $_POST['main_left'];

				$vals['main_platinum'] = $_POST['main_platinum'];
				$vals['main_grand'] = $_POST['main_grand'];
				$vals['main_special'] = $_POST['main_special'];
				$vals['main_banner'] = $_POST['main_banner'];
				$vals['sub_platinum'] = $_POST['sub_platinum'];
				$vals['sub_banner'] = $_POST['sub_banner'];

				/*
				$vals['member_skin'] = $_POST['member_skin'];
				$vals['employ_skin'] = $_POST['employ_skin'];
				$vals['alba_skin'] = $_POST['alba_skin'];
				$vals['resume_skin'] = $_POST['resume_skin'];
				$vals['alba_resume_skin'] = $_POST['alba_resume_skin'];
				$vals['board_skin'] = $_POST['board_skin'];
				$vals['map_skin'] = $_POST['map_skin'];
				*/

				$vals['main_platinum_use'] = ($_POST['main_platinum_use']) ? $_POST['main_platinum_use'] : 0;
				$vals['main_platinum_limit'] = ($_POST['main_platinum_limit']) ? $_POST['main_platinum_limit'] : 0;
				$vals['main_platinum_total'] = $_POST['main_platinum_total'];
				$vals['main_platinum_row'] = $_POST['main_platinum_row'];
				$vals['main_platinum_row2'] = $_POST['main_platinum_row2'];
				$vals['main_platinum_border'] = $_POST['main_platinum_border'];
				$vals['main_platinum_margin'] = $_POST['main_platinum_margin'];
				$vals['main_platinum_border_color'] = $_POST['main_platinum_border_color'];
				$vals['main_platinum_border_gold_color'] = $_POST['main_platinum_border_gold_color'];
				$vals['main_platinum_background_color'] = $_POST['main_platinum_background_color'];
				$vals['main_platinum_background_gold_color'] = $_POST['main_platinum_background_gold_color'];
				$vals['main_platinum_font_color'] = $_POST['main_platinum_font_color'];
				$vals['main_platinum_font_gold_color'] = $_POST['main_platinum_font_gold_color'];
				//$vals['main_platinum_content'] = $_POST['main_platinum_content'];

				$vals['main_special_use'] = ($_POST['main_special_use']) ? $_POST['main_special_use'] : 0;
				$vals['main_special_limit'] = ($_POST['main_special_limit']) ? $_POST['main_special_limit'] : 0;
				$vals['main_special_total'] = $_POST['main_special_total'];
				$vals['main_special_row'] = $_POST['main_special_row'];
				$vals['main_special_row2'] = $_POST['main_special_row2'];
				$vals['main_special_border'] = $_POST['main_special_border'];
				$vals['main_special_margin'] = $_POST['main_special_margin'];
				$vals['main_special_border_color'] = $_POST['main_special_border_color'];
				$vals['main_special_border_gold_color'] = $_POST['main_special_border_gold_color'];
				$vals['main_special_background_color'] = $_POST['main_special_background_color'];
				$vals['main_special_background_gold_color'] = $_POST['main_special_background_gold_color'];
				$vals['main_special_font_color'] = $_POST['main_special_font_color'];
				$vals['main_special_font_gold_color'] = $_POST['main_special_font_gold_color'];
				//$vals['main_special_content'] = $_POST['main_special_content'];

				$vals['main_grand_use'] = ($_POST['main_grand_use']) ? $_POST['main_grand_use'] : 0;
				$vals['main_grand_limit'] = ($_POST['main_grand_limit']) ? $_POST['main_grand_limit'] : 0;
				$vals['main_grand_total'] = $_POST['main_grand_total'];
				$vals['main_grand_row'] = $_POST['main_grand_row'];
				$vals['main_grand_row2'] = $_POST['main_grand_row2'];
				$vals['main_grand_border'] = $_POST['main_grand_border'];
				$vals['main_grand_margin'] = $_POST['main_grand_margin'];
				$vals['main_grand_border_color'] = $_POST['main_grand_border_color'];
				$vals['main_grand_border_gold_color'] = $_POST['main_grand_border_gold_color'];
				$vals['main_grand_background_color'] = $_POST['main_grand_background_color'];
				$vals['main_grand_background_gold_color'] = $_POST['main_grand_background_gold_color'];
				$vals['main_grand_font_color'] = $_POST['main_grand_font_color'];
				$vals['main_grand_font_gold_color'] = $_POST['main_grand_font_gold_color'];
				//$vals['main_grand_content'] = $_POST['main_grand_content'];

				$vals['main_banner_use'] = ($_POST['main_banner_use']) ? $_POST['main_banner_use'] : 0;
				$vals['main_banner_limit'] = ($_POST['main_banner_limit']) ? $_POST['main_banner_limit'] : 0;
				$vals['main_banner_total'] = $_POST['main_banner_total'];
				$vals['main_banner_row'] = $_POST['main_banner_row'];
				$vals['main_banner_row2'] = $_POST['main_banner_row2'];
				$vals['main_banner_border'] = $_POST['main_banner_border'];
				$vals['main_banner_margin'] = $_POST['main_banner_margin'];
				$vals['main_banner_border_color'] = $_POST['main_banner_border_color'];
				$vals['main_banner_border_gold_color'] = $_POST['main_banner_border_gold_color'];
				$vals['main_banner_background_color'] = $_POST['main_banner_background_color'];
				$vals['main_banner_background_gold_color'] = $_POST['main_banner_background_gold_color'];
				//$vals['main_banner_content'] = $_POST['main_banner_content'];

				$vals['main_list_use'] = ($_POST['main_list_use']) ? $_POST['main_list_use'] : 0;
				$vals['main_list_limit'] = ($_POST['main_list_limit']) ? $_POST['main_list_limit'] : 0 ;
				$vals['main_list_total'] = $_POST['main_list_total'];
				$vals['main_list_background_gold_color'] = $_POST['main_list_background_gold_color'];
				//$vals['main_list_content'] = $_POST['main_list_content'];

				//$vals['main_busy_content'] = $_POST['main_busy_content'];

				$vals['main_focus_use'] = ($_POST['main_focus_use']) ? $_POST['main_focus_use'] : 0;
				$vals['main_focus_limit'] = ($_POST['main_focus_limit']) ? $_POST['main_focus_limit'] : 0;
				$vals['main_focus_total'] = $_POST['main_focus_total'];
				$vals['main_focus_border_color'] = $_POST['main_focus_border_color'];
				$vals['main_focus_border_gold_color'] = $_POST['main_focus_border_gold_color'];
				$vals['main_focus_background_color'] = $_POST['main_focus_background_color'];
				$vals['main_focus_background_gold_color'] = $_POST['main_focus_background_gold_color'];
				$vals['main_focus_font_color'] = $_POST['main_focus_font_color'];
				$vals['main_focus_font_gold_color'] = $_POST['main_focus_font_gold_color'];
				//$vals['main_focus_content'] = $_POST['main_focus_content'];

				$vals['main_bottom_alba_use'] = $_POST['main_bottom_alba_use'];
				$vals['main_bottom_alba_total'] = $_POST['main_bottom_alba_total'];
				$vals['main_bottom_resume_use'] = $_POST['main_bottom_resume_use'];
				$vals['main_bottom_resume_total'] = $_POST['main_bottom_resume_total'];

				$vals['sub_platinum_use'] = ($_POST['sub_platinum_use']) ? $_POST['sub_platinum_use'] : 0;
				$vals['sub_platinum_limit'] = ($_POST['sub_platinum_limit']) ? $_POST['sub_platinum_limit'] : 0;
				$vals['sub_platinum_total'] = $_POST['sub_platinum_total'];
				$vals['sub_platinum_row'] = $_POST['sub_platinum_row'];
				$vals['sub_platinum_border'] = $_POST['sub_platinum_border'];
				$vals['sub_platinum_margin'] = $_POST['sub_platinum_margin'];
				$vals['sub_platinum_border_color'] = $_POST['sub_platinum_border_color'];
				$vals['sub_platinum_border_gold_color'] = $_POST['sub_platinum_border_gold_color'];
				$vals['sub_platinum_background_color'] = $_POST['sub_platinum_background_color'];
				$vals['sub_platinum_background_gold_color'] = $_POST['sub_platinum_background_gold_color'];
				//$vals['sub_platinum_content'] = $_POST['sub_platinum_content'];

				$vals['sub_banner_use'] = ($_POST['sub_banner_use']) ? $_POST['sub_banner_use'] : 0;
				$vals['sub_banner_limit'] = ($_POST['sub_banner_limit']) ? $_POST['sub_banner_limit'] : 0;
				$vals['sub_banner_total'] = $_POST['sub_banner_total'];
				$vals['sub_banner_row'] = $_POST['sub_banner_row'];
				$vals['sub_banner_border'] = $_POST['sub_banner_border'];
				$vals['sub_banner_margin'] = $_POST['sub_banner_margin'];
				$vals['sub_banner_border_color'] = $_POST['sub_banner_border_color'];
				$vals['sub_banner_border_gold_color'] = $_POST['sub_banner_border_gold_color'];
				$vals['sub_banner_background_color'] = $_POST['sub_banner_background_color'];
				$vals['sub_banner_background_gold_color'] = $_POST['sub_banner_background_gold_color'];
				//$vals['sub_banner_content'] = $_POST['sub_banner_content'];

				$vals['sub_list_use'] = ($_POST['sub_list_use']) ? $_POST['sub_list_use'] : 0;
				$vals['sub_list_limit'] = ($_POST['sub_list_limit']) ? $_POST['sub_list_limit'] : 0;
				$vals['sub_list_total'] = $_POST['sub_list_total'];
				$vals['sub_list_background_gold_color'] = $_POST['sub_list_background_gold_color'];
				//$vals['sub_list_content'] = $_POST['sub_list_content'];

				$vals['sub_focus_use'] = ($_POST['sub_focus_use']) ? $_POST['sub_focus_use'] : 0;
				$vals['sub_focus_limit'] = ($_POST['sub_focus_limit']) ? $_POST['sub_focus_limit'] : 0;
				$vals['sub_focus_total'] = $_POST['sub_focus_total'];
				$vals['sub_focus_border_color'] = $_POST['sub_focus_border_color'];
				$vals['sub_focus_border_gold_color'] = $_POST['sub_focus_border_gold_color'];
				$vals['sub_focus_background_color'] = $_POST['sub_focus_background_color'];
				$vals['sub_focus_background_gold_color'] = $_POST['sub_focus_background_gold_color'];
				//$vals['sub_focus_content'] = $_POST['sub_focus_content'];

				//$vals['sub_busy_content'] = $_POST['sub_busy_content'];


				$vals['today_resume_use'] = $_POST['today_resume_use'];
				$vals['today_resume_total'] = $_POST['today_resume_total'];

				$vals['sub_resume_list_use'] = $_POST['sub_resume_list_use'];
				$vals['sub_resume_list_total'] = $_POST['sub_resume_list_total'];


				//$vals['alba_jump_content'] = $_POST['alba_jump_content'];
				//$vals['resume_jump_content'] = $_POST['resume_jump_content'];

				//$vals['alba_open_content'] = $_POST['alba_open_content'];
				//$vals['resume_open_content'] = $_POST['resume_open_content'];


				// 추가된 19금 채용정보 설정 (2014.03.27)
				$vals['adult_platinum_use'] = ($_POST['adult_platinum_use']) ? $_POST['adult_platinum_use'] : 0;
				$vals['adult_platinum_total'] = $_POST['adult_platinum_total'];
				$vals['adult_platinum_row'] = $_POST['adult_platinum_row'];
				$vals['adult_platinum_border'] = $_POST['adult_platinum_border'];
				$vals['adult_platinum_margin'] = $_POST['adult_platinum_margin'];
				$vals['adult_platinum_border_color'] = $_POST['adult_platinum_border_color'];
				$vals['adult_platinum_border_gold_color'] = $_POST['adult_platinum_border_gold_color'];
				$vals['adult_platinum_background_color'] = $_POST['adult_platinum_background_color'];
				$vals['adult_platinum_background_gold_color'] = $_POST['adult_platinum_background_gold_color'];

				$vals['adult_prime_use'] = ($_POST['adult_prime_use']) ? $_POST['adult_prime_use'] : 0;
				$vals['adult_prime_total'] = $_POST['adult_prime_total'];
				$vals['adult_prime_row'] = $_POST['adult_prime_row'];
				$vals['adult_prime_border'] = $_POST['adult_prime_border'];
				$vals['adult_prime_margin'] = $_POST['adult_prime_margin'];
				$vals['adult_prime_border_color'] = $_POST['adult_prime_border_color'];
				$vals['adult_prime_border_gold_color'] = $_POST['adult_prime_border_gold_color'];
				$vals['adult_prime_background_color'] = $_POST['adult_prime_background_color'];
				$vals['adult_prime_background_gold_color'] = $_POST['adult_prime_background_gold_color'];

				$vals['adult_grand_use'] = ($_POST['adult_grand_use']) ? $_POST['adult_grand_use'] : 0;
				$vals['adult_grand_total'] = $_POST['adult_grand_total'];
				$vals['adult_grand_row'] = $_POST['adult_grand_row'];
				$vals['adult_grand_border'] = $_POST['adult_grand_border'];
				$vals['adult_grand_margin'] = $_POST['adult_grand_margin'];
				$vals['adult_grand_border_color'] = $_POST['adult_grand_border_color'];
				$vals['adult_grand_border_gold_color'] = $_POST['adult_grand_border_gold_color'];
				$vals['adult_grand_background_color'] = $_POST['adult_grand_background_color'];
				$vals['adult_grand_background_gold_color'] = $_POST['adult_grand_background_gold_color'];

				$vals['adult_banner_use'] = ($_POST['adult_banner_use']) ? $_POST['adult_banner_use'] : 0;
				$vals['adult_banner_total'] = $_POST['adult_banner_total'];
				$vals['adult_banner_row'] = $_POST['adult_banner_row'];
				$vals['adult_banner_border'] = $_POST['adult_banner_border'];
				$vals['adult_banner_margin'] = $_POST['adult_banner_margin'];
				$vals['adult_banner_border_color'] = $_POST['adult_banner_border_color'];
				$vals['adult_banner_border_gold_color'] = $_POST['adult_banner_border_gold_color'];
				$vals['adult_banner_background_color'] = $_POST['adult_banner_background_color'];
				$vals['adult_banner_background_gold_color'] = $_POST['adult_banner_background_gold_color'];

				$vals['adult_list_use'] = ($_POST['adult_list_use']) ? $_POST['adult_list_use'] : 0;
				$vals['adult_list_total'] = $_POST['adult_list_total'];
				$vals['adult_list_background_gold_color'] = $_POST['adult_list_background_gold_color'];
				// 추가된 19금 채용정보 설정 (2014.03.27)

				$vals['wdate'] = $now_date;

				$result = $design_control->update_design($vals, $no);

				/* 서비스 사용 설정 */
				$service_vals['is_pay'] = $vals['main_platinum_use'];
				$result = $service_control->service_check_update($service_vals,"main_platinum");
				$service_vals['is_pay'] = $vals['main_prime_use'];
				$result = $service_control->service_check_update($service_vals,"main_prime");
				$service_vals['is_pay'] = $vals['main_grand_use'];
				$result = $service_control->service_check_update($service_vals,"main_grand");
				$service_vals['is_pay'] = $vals['main_banner_use'];
				$result = $service_control->service_check_update($service_vals,"main_banner");
				$service_vals['is_pay'] = $vals['main_list_use'];
				$result = $service_control->service_check_update($service_vals,"main_list");
				$service_vals['is_pay'] = $vals['main_focus_use'];
				$result = $service_control->service_check_update($service_vals,"main_focus");
				$service_vals['is_pay'] = $vals['sub_platinum_use'];
				$result = $service_control->service_check_update($service_vals,"alba_platinum");
				$service_vals['is_pay'] = $vals['sub_banner_use'];
				$result = $service_control->service_check_update($service_vals,"alba_banner");
				$service_vals['is_pay'] = $vals['sub_list_use'];
				$result = $service_control->service_check_update($service_vals,"alba_list");
				$service_vals['is_pay'] = $vals['sub_focus_use'];
				$result = $service_control->service_check_update($service_vals,"alba_resume_focus");
				/* // 서비스 사용 설정 */

				if($result)
					echo ($ajax) ? $result : $utility->popup_msg_js($config->_success('0002'));
				else
					echo ($ajax) ? $result : $utility->popup_msg_js($config->_errors('0005'));

			break;

			## 서비스안내 내용 수정
			case 'service_update':
				
				$service = $_POST['service'];
				
				$vals[$service] = $_POST[$service];

				$result = $design_control->update_design($vals, $no);

				if($result)
					echo ($ajax) ? $result : $utility->popup_msg_js($config->_success('0002'));
				else
					echo ($ajax) ? $result : $utility->popup_msg_js($config->_errors('0005'));

			break;
		}		

?>