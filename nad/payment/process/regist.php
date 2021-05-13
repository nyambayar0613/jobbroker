<?php
		/*
		* /application/nad/payment/process/regist.php
		* @author Harimao
		* @since 2013/09/27
		* @last update 2015/04/13
		* @Module v3.5 ( Alice )
		* @Brief :: Payment list process
		* @Comment :: 채용공고/이력서 등록 후 이동할 결제 페이지를 설정한다.
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크
	
		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$no = $_POST['no'];

		$wr_type = $_POST['wr_type'];

		switch($mode){

			## 결제 정보 삭제 (단수)
			case 'delete':

				$result = $payment_control->delete_payment($no);

				echo $result;

			break;

			## 결제 정보 삭제 (복수)
			case 'sel_delete':

				$nos = explode(',',$no);
				$nos_cnt = count($nos);
				for($i=0;$i<$nos_cnt;$i++){
					$result = $payment_control->delete_payment($nos[$i]);
				}

				echo $result;

			break;

			## 결제 상태 수정 (단수)
			case 'pay_status':

				$status = $_POST['status'];
			
				$get_payment = $payment_control->get_payment($no);
				
					if($get_payment['pay_method']=='bank' && $status==1){		// 무통장 입금 / 결제완료 시
					## 무통장 입금완료 문자 전송
					$get_member = $member_control->get_member($get_payment['pay_uid']);
					//$mb_receive = explode(",",$get_member['mb_receive']);	// 수신여부 무관
					//if(@in_array('sms',$mb_receive)){	 // 문자 수신 확인
						//$sms_control->send_sms_user('pay_online_success', $get_member, "", $get_payment);
					//}
				}

				$pay_oid = $get_payment['pay_oid'];	// 주문번호
				
				$result = $payment_control->payment_status($status,$pay_oid);

				echo $result;

			break;

			## 결제 상태 수정 (복수)
			case 'sel_status':

				$status = $_POST['status'];
				
				$nos_cnt = count($no);
				for($i=0;$i<$nos_cnt;$i++){
					$get_payment = $payment_control->get_payment($no[$i]);
					$pay_oid = $get_payment['pay_oid'];	// 주문번호
					$result = $payment_control->payment_status($status,$pay_oid);
				}

				echo $result;

			break;


			## 세금계산서 상태 변경
			case 'status':
			
				$status = $_POST['status'];

				$vals['wr_status'] = $status;

				$result = $tax_control->update_tax($vals,$no);

				echo $result;

			break;

			## 세금계산서 메모 입력 / 수정
			case 'memo':

				$vals['wr_memo'] = $_POST['wr_memo'];

				$result = $tax_control->update_tax($vals,$no);

				echo $mode . "/" . $result . "/" . $no . "/" . $vals['wr_memo'];

			break;

			## 세금계산서 정보 수정
			case 'tax_update':

				$vals['wr_biz_no'] = @implode($_POST['wr_biz_no'],'-');
				$vals['wr_company_name'] = $_POST['wr_company_name'];
				$vals['wr_ceo_name'] = $_POST['wr_ceo_name'];
				$vals['wr_zipcode'] = @implode($_POST['wr_zipcode'],'-');
				$vals['wr_address0'] = $_POST['wr_address0'];
				$vals['wr_address1'] = $_POST['wr_address1'];
				$vals['wr_condition'] = $_POST['wr_condition'];
				$vals['wr_item'] = $_POST['wr_item'];
				$vals['wr_email'] = @implode($_POST['wr_email'],'@');
				$vals['wr_manager'] = $_POST['wr_manager'];
				$vals['wr_phone'] = @implode($_POST['wr_phone'],'-');
				$vals['wr_hphone'] = @implode($_POST['wr_hphone'],'-');
				$vals['wr_pay_date'] = @implode($_POST['wr_pay_date'],'-');
				$vals['wr_price'] = $_POST['wr_price'];
				$vals['wr_content'] = $_POST['wr_content'];

				$result = $tax_control->update_tax($vals,$no);

				echo $mode . "/" . $result;

			break;

			## 세금계산서 정보 삭제
			case 'tax_delete':

				$result = $tax_control->delete_tax($no);

				echo $result;

			break;

			## 세금계산서 정보 선택 삭제
			case 'tax_sel_delete':

				$nos = explode(',',$no);
				$nos_cnt = count($nos);
				for($i=0;$i<$nos_cnt;$i++){
					
					$result = $tax_control->delete_tax($nos[$i]);

				}
				
				echo $result;

			break;

			## 패키지 설정 정보 입력	 / 수정
			case 'package_insert':
			case 'package_update':

				$no = $_POST['no'];
				$wr_type = $_POST['wr_type'];
				
				$vals['wr_type'] = $wr_type;

				$get_LastRank = $package_control->get_MaxRank(" where `wr_type` = '".$wr_type."' ");	// rank 최대값 구함

				$vals['wr_rank'] = $get_LastRank + 1;
				$vals['wr_use'] = $_POST['wr_use'];
				$vals['wr_subject'] = $_POST['wr_subject'];
				$vals['wr_brief'] = $_POST['wr_brief'];
				$vals['wr_price'] = str_replace(",","",$_POST['wr_price']);

				$vals['wr_content'] = serialize($_POST['wr_content']);
				$vals['wr_wdate'] = $alice['time_ymdhis'];

				if($mode=='package_insert'){
					$result = $package_control->insert_package($vals);
				} else if($mode=='package_update'){
					$result = $package_control->update_package($vals, $no);
				}

				echo $mode."/".$result."/".$no;

			break;

			## 패키지 순위 조절
			case 'package_rank':
			
				$result = $package_control->setRank($wr_type,$no,$next_no);

				echo $result;

			break;

			## 패키지 삭제 (단일)
			case 'package_delete':
				
				$result = $package_control->delete_noRank($no,$wr_type);

				echo $result;

			break;

			## 패키지 삭제 (복수)
			case 'package_sel_delete':

				$nos = explode(",",$no);
				$no_cnt = count($nos);
				for($i=0;$i<$no_cnt;$i++){

					$result = $package_control->delete_noRank($nos[$i],$wr_type);

				}

				echo $result;

			break;

		}	// switch end.
?>