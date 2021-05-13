<?php
		/*
		* /application/nad/member/process/point.php
		* @author Harimao
		* @since 2013/07/15
		* @last update 2015/04/14
		* @Module v3.5 ( Alice )
		* @Brief :: Level point regist
		* @Comment :: 회원 포인트 지급 설정
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$mb_id = $_POST['mb_id'];

		$po_point = $_POST['point_point'];
		$po_content = $_POST['point_content'];

		$mb = $member_control->get_member($mb_id);

		switch($mode){

			## 포인트 지급
			case 'insert':

				if(!$mb['mb_id']){
					$utility->popup_msg_js($member_control->_errors('0013'));
					exit;
				}

				if (($po_point < 0) && ($po_point * (-1) > $mb['mb_point'])) {
					$utility->popup_msg_js($point_control->_errors('0000'));
					exit;
				}

				$rel_table = $_POST['point_rel_table'];
				$rel_id = $_POST['point_rel_id'];

				$result = $point_control->point_insert($mb_id, $po_point, $po_content, $rel_table, $mb_id, $rel_id."-".uniqid(""));

				echo $result;

			break;

			## 포인트 내역 선택 삭제
			case 'sel_delete':

				$nos = explode(',',$_POST['no']);
				$nos_cnt = count($nos);

				for($i=0;$i<$nos_cnt;$i++){

					$result = $point_control->sel_point_delete($nos[$i]);

				}
			
				echo $result;

			break;

		}
?>