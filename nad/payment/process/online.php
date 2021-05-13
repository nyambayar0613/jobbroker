<?php
		/*
		* /application/nad/payment/process/online.php
		* @author Harimao
		* @since 2012/10/04
		* @last update 2015/02/25
		* @Module v3.0 ( Alice )
		* @Brief :: Online Bank datas
		* @Comment :: 무통장 입금 계좌관리
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$ajax = $_POST['ajax'];
		$mode = $_POST['mode'];

		$type = $_POST['type'];
		$no = $_POST['no'];
		$next_no = $_POST['next_no'];

		switch($mode){
			## 입력
			case 'insert':

				// rank 최대값 구함
				$get_LastRank = $bank_control->get_MaxRank();

				$vals['rank'] = $get_LastRank + 1;
				$vals['bank_name'] = $_POST['bank_name'];
				$vals['bank_num'] = $_POST['bank_num'];
				$vals['name'] = $_POST['name'];

				$vals['wdate'] = $now_date;

				$result = $bank_control->insert_bank($vals);

				if($result)
					$msg = $config->_success('0000');
				else
					$msg = $confg->_errors('0008');

			break;

			## 순위조절
			case 'rank':

				// 순위조절 함수 호출
				$result = $bank_control->setRank($type, $no, $next_no);

				echo $result;

			break;

			## 수정
			case 'update':

				$vals['bank_name'] = $_POST['bank_name'];
				$vals['bank_num'] = $_POST['bank_num'];
				$vals['name'] = $_POST['name'];

				$result = $bank_control->update_bank($vals, $no);

				echo $result;

			break;

			## 삭제
			case 'delete':

				$result = $bank_control->delete_noRank($no);

				echo $result;

			break;

			## 선택 삭제
			case 'sel_delete':

				$nos = explode(',',$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){

					$result = $bank_control->delete_noRank($nos[$i]);

				}

				echo $result;

			break;

		}


		if($ajax)
			echo $msg;
		else
			$utility->popup_msg_js($msg);

?>