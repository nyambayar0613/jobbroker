<?php
if(class_exists("netfu_payment")) return;
class netfu_payment {

	var $use_pg = '';

	var $service_kind = array(
		'job_payment'=>'기업회원',
		'resume_payment'=>'개인회원',
		'jump_payment'=>'점프',
	);

	
	var $option_k = array('job_payment'=>'alba_option');
	var $option_se_arr = array('busy'=>'급구', 'neon'=>'형광펜', 'bold'=>'굵은글자', 'icon'=>'아이콘', 'color'=>'글자색', 'blink'=>'반짝칼라', 'jump'=>'점프');
	var $etc_se_arr = array('open'=>'이력서 열람', 'alba'=>'채용정보 열람'); // , 'sms'=>'SMS충전 '
	var $option_se_content = array(
		'neon'=>'제목을 형광펜 강조 효과',
		'bold'=>'제목을 굵은 글자로 강조 효과',
		'icon'=>'제목 앞을 아이콘으로 강조 효과',
		'color'=>'제목을 글자색으로 강조 효과',
		'blink'=>'제목을 빤짝컬러 강조 효과',
	);

	var $pay_tax_num_type = array(0=>'주민번호', 1=>'휴대폰', 2=>'카드번호');

	// : 독립적 결제하기 페이지 정보
	var $etc_payment_arr = array('jump'=>'점프', 'open'=>'열람', 'alba'=>'열람'); // , 'sms'=>'SMS'

	// : 열람서비스 종류
	var $read_service_type = array('etc_open'=>'이력서', 'etc_alba'=>'구인정보');

	// : 결제방법
	var $pay_method_arr = array('card'=>'신용카드', 'direct'=>'실시간 계좌이체', 'hphone'=>'핸드폰', 'phone'=>'일반전화', 'bank'=>'무통장입금');
	var $kcp_method_arr = array('card'=>'100000000000', 'direct'=>'010000000000', 'hphone'=>'000010000000', 'phone'=>'000000000010');
	var $kcp_method_arr_m = array("card"=>"card","hphone"=>"mobx","direct"=>"acnt");
	var $allthegate_method_arr = array('card'=>'onlycard', 'direct'=>'onlyiche', 'hphone'=>'onlyhp');
	var $allthegate_method_arr_m = array("onlycard"=>"cardnormal","onlyhpp"=>"hp","onlydbank"=>"virtualnormal");
	var $inicis_method_arr = array('card'=>'onlycard', 'direct'=>'onlydbank', 'onlyhpp'=>'onlyhp');
	var $inicis_method_arr_m = array('card'=>'wcard', 'direct'=>'bank', 'onlyhpp'=>'mobile');
	var $nicepay_method_arr = array('card'=>'CARD', 'direct'=>'BANK', 'hphone'=>'CELLPHONE');


	var $payment_service_name = array('open_payment'=>'열람 서비스', 'open_payment'=>'열람 서비스', 'jump_payment'=>'점프 서비스', 'job_payment'=>'기업회원 서비스 신청', 'resume_payment'=>'개인회원 서비스 신청');


	function netfu_payment() {

		$this->use_pg = sql_fetch("select * from alice_pg where `pg_result`=1");
	}


	// : 서비스 남은기간 출력하기
	function option_put_val($field, $val) {
		if($val) {
			if(strpos($field, 'logo')!==false)
				$result = '';
			if(strpos($field, 'neon')!==false)
				$result = '<span style="display:inline-block;background-color:#'.$val.';width:10px;height:10px;"></span>';
			if(strpos($field, 'color')!==false)
				$result = '<span style="display:inline-block;background-color:#'.$val.';width:10px;height:10px;"></span>';
			if(strpos($field, 'icon')!==false)
				$result = '<span style="display:inline-block;background-color:#'.$val.';width:10px;height:10px;"></span>';
		}
		return $result;
	}
	function service_is_check($code, $row) {
		global $service_control, $netfu_mjob;

		$_option = $netfu_mjob->get_service_option($code, $row);
		$_service_arr = $service_control->service_lists;

		$_arr = array();
		if(is_array($row)) { foreach($row as $k=>$v) {
			if(!$v) continue;
			if(strpos($k, '_val')!==false) continue; // : 값은 출력하지 않습니다.
			if(strpos($k, 'wr_service_')!==false) {
				if($v<0 || $v!='0000-00-00') {
					$_part_txt = '';
					$_service = preg_replace(array("/wr_service_/", "/_main_gold/", "/_main_logo/"), array("", "", ""), $k);
					if(strpos($k, '_gold')!==false) $_part_txt = ' 골드';
					if(strpos($k, '_logo')!==false) $_part_txt = ' 로고강조';
					$_k = $_service;
					if(strpos($k, '_gold')!==false) $_k .= '_gold';
					if(strpos($k, '_logo')!==false) $_k .= '_logo';
					switch($code) {
						// : 채용
						case 'alba':
							if(@array_key_exists($_service, $_service_arr['alba_option']))
								$_arr[$_k] = $_service_arr['alba_option'][$_service]['name'];
							else {
								$_arr[$_k] = $_service_arr['main'][$_service]['name'].$_part_txt.' 구인정보';
							}
							break;

						default:
							if(@array_key_exists($_service, $_service_arr['resume_option']))
								$_arr[$_k] = $_service_arr['resume_option'][$_service]['name'];
							else {
								$_service = strpos($_service, 'main_focus')!==false ? 'focus' : 'basic';
								$_arr[$_k] = $_service_arr['alba_resume'][$_service]['name'].$_part_txt;
							}
							break;
					}
					/*
					$_value = $row[$k.'_val'] ? $row[$k.'_val'] : "";
					$_value_tag = strpos($k, 'icon')!==false ? $_option['icon'] : $this->option_put_val($k, $_value);
					*/
					$_arr[$_k] .= '(~'.$v.') '.$_value_tag;
				}
			}
		} }
		return $_arr;
	}


	function get_use_service() {
		$_use_service = array();
		if(is_array($_POST['service'])) { foreach($_POST['service'] as $k=>$v) {
			if(!$v) continue;
			$_arr = explode("/", $v);
			if(!in_array($_arr[0], $_use_service)) $arr['code'][] = $_arr[0];
			if($_arr[0]=='package') $arr['package_no'] = $_arr[1];
		} }

		return $arr;
	}



// : 가격및 기타값 가져오기
	function get_price($code, $no) {
		global $service_control, $netfu_util;

		switch($code) {
			// : 패키지가격
			case "package":
				$row = sql_fetch("select * from alice_payment_package where `no`='".$no."'");
				$row['_subject'] = $row['wr_subject'];
				$row['_price'] = $row['wr_price'];
				$row['_sale'] = 0;
				break;

			// : 기타 가격정보
			default:
				$_part_arr = array('_gold', '_logo'); // : 골드나 로고형일때 사용

				$row = sql_fetch("select * from alice_service where `no`='".$no."'");
				$type_txt = str_replace($_part_arr, array('', ''), $row['type']); // : gold, logo단어 없애기 - 서비스명 알아내기
				$row['_service_txt_arr'] = explode($code.'_', $type_txt);

				// : 골드나 로고광고인경우에 이 foreach사용
				foreach($_part_arr as $k=>$v) {
					if(strpos($row['type'], $v)!==false) {
						$_tail_txt = ' '.$service_control->service_name[$type_txt]['service'][substr($v,1)];
					}
				}

				$row['_subject'] = $service_control->service_lists[$code][$row['_service_txt_arr'][1]]['name'].$_tail_txt;
				$row['_price'] = $row['service_price'];
				$row['_sale_price'] = $netfu_util->sale_price($row['service_percent'], $row['service_price']);
				$row['_sale'] = $row['service_percent'];
				break;
		}

		$row['_date'] = str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $row['service_cnt'].$row['service_unit']);

		if($code!='package') {
			if($row['service_unit']=='count')
				$row['_date_txt'] = '';
			else
				$row['_date_txt'] = date("Y.m.d").'~'.date("Y.m.d", strtotime($row['service_cnt'].$row['service_unit']));
		}
		return $row;
	}



// : 선택한 서비스의 총금액 찾기
	function all_service_price() {
		global $netfu_util;
		$price_hap = 0;
		// : 가격정보
		if(is_array($_POST['service'])) { foreach($_POST['service'] as $k=>$v) {
			$_val_arr = explode("/", $v);
			// : 가격값
			$price_row = $this->get_price($_val_arr[0], $_val_arr[1]);

			$price_hap += $netfu_util->sale_price($price_row['_sale'], $price_row['_price']);
		} }

		return $price_hap;
	}



	// : 결제시 선택한 서비스 정보모음
	function get_service_type($post) {
		global $netfu_util;
		$arr['ori_price'] = array();
		if(is_array($post['service'])) { foreach($post['service'] as $k=>$v) {
			$_ex = explode("/", $v);
			switch($_ex[0]) {
				case "package":
					$r = $this->get_price('package', $_ex[1]);
					$arr['type']['package'] = 'package/'.$_ex[1];
					$arr['package_no'] = $_ex[1];
					$arr['ori_price']['package'] = $r['wr_price'];
					$arr['price']['package'] = $r['wr_price'];
					$arr['unit']['package'] = '';
					break;


				default:
					$r = sql_fetch("select * from alice_service where `no`='".$_ex[1]."'");
					if($r) {
						$arr['type'][$r['no']] = $r['type'];
						$arr['ori_price'][$r['no']] = $r['service_price'];
						$arr['price'][$r['no']] = $netfu_util->sale_price($r['service_percent'], $r['service_price']);
						$arr['unit'][$r['no']] = $r['service_cnt'].' '.$r['service_unit'];
					}
					break;
			}
		} }

		$arr['ori_price_hap'] = array_sum($arr['ori_price']);
		$arr['price_hap'] = array_sum($arr['price']);
		$arr['use_price_hap'] = array_sum($arr['price'])-$post['use_point'];

		return $arr;
	}

// : 결제디비저장
	function payment_save() {
		global $payment_control, $utility, $member, $now_date, $service_price_moim;
		$get_price = $this->get_service_type($_POST);
		$get_pg = $payment_control->get_use_pg(1);

		$row = sql_fetch("select * from alice_payment where pay_oid='".$_SESSION['__pay_order__']."' and pay_oid!=''");
		$bank_row = sql_fetch("select * from `alice_bank` where `no`='".addslashes($_POST['bank'])."'");

		$vals['pay_no'] = $_POST['info_no'];
		if(!$row) $vals['pay_oid'] = $_SESSION['__pay_order__'];
		$vals['pay_type'] = $_POST['pay_type'];
		$vals['pay_dc'] = $_POST['use_point'];
		$vals['pay_pg'] = $get_pg['pg_company'];
		$vals['pay_method'] = $_POST['pay_method'];
		$vals['pay_service'] = @implode(",", $get_price['type']);
		$vals['pay_uid'] = $member['mb_id'];
		$vals['pay_name'] = $member['mb_name'];
		$vals['pay_phone'] = ($member['mb_hphone']) ? $member['mb_hphone'] : $member['mb_phone'];
		$vals['pay_email'] = $member['mb_email'];
		$vals['pay_package'] = $get_price['package_no'];
		$vals['pay_oid'] = $_SESSION['__pay_order__'];
		$vals['pay_total'] = $get_price['ori_price_hap'];
		$vals['pay_price'] = $get_price['use_price_hap'];
		$vals['pay_wdate'] = $now_date;
		$vals['post_un'] = serialize($_POST);
		$vals['price_un'] = serialize($service_price_moim);

		$vals['pay_bank'] = $bank_row['bank_name']."/".$bank_row['bank_num']."/".$bank_row['name'];
		$vals['pay_bank_name'] = $_POST['bank_name'];
		if($_POST['tax_use']=='Y') {
			$vals['pay_tax_type'] = $_POST['pay_tax_type'];
			$vals['pay_tax_num_type'] = $_POST['pay_tax_num_type'];
			$vals['pay_tax_num'] = $_POST['pay_tax_type']=='1' ? $_POST['pay_tax_num_person'] : @implode("-", $_POST['pay_tax_num_biz']);
		}

		$val = $utility->QueryString($vals);
		if(!$row) $q = " insert alice_payment set " . $val;
		else $q = "update alice_payment set ".$val." where `no`='".$row['no']."'";
		sql_query($q);

		if(!$row) return mysql_insert_id();
		else return $row['no'];
	}


	function get_card_info($prow) {
		$_pg_un = (array)unserialize(base64_decode($prow['pg_un']));
		switch($prow['pay_pg']) {
			case "allthegate":
				$arr['cardname'] = iconv("CP949", "UTF-8", $_pg_un['REQUEST']['card_name']);
				$arr['cardno'] = $_pg_un['REQUEST']['CardNo'];
				break;

			case "kcp":
				$arr['cardname'] = iconv("CP949", "UTF-8", $_pg_un['m_res_data']['card_name']);
				$arr['cardno'] = $_pg_un['m_res_data']['card_no'];
				break;
		}

		$arr['cardno_ch'] = substr($arr['cardno'],0,4).str_repeat("*",8).substr($arr['cardno'],12,3).'*';
		return $arr;
	}
}
?>