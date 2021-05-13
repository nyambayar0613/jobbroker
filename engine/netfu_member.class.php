<?php
class netfu_member {

	var $my_uid = '';

	var $member_kind = array('individual'=>'개인회원', 'company'=>'기업회원');

	function netfu_member() {
		$this->my_uid = $_SESSION['sess_user_uid'];
	}


	function login_check($code='') {
		global $netfu_util, $member;
		if(!$_SESSION['sess_user_uid']) {
			$netfu_util->page_move('로그인하셔야 이용가능합니다.', NFE_URL.'/include/login.php');
			exit;
		}

		if($code && $member['mb_type']!=$code) {
			$netfu_util->page_move($this->member_kind[$code].'권한만 이용가능합니다.', NFE_URL.'/include/login.php');
			exit;
		}
	}


	function login_check2($mb_id) {
		$arr['msg'] = "";
		$arr['move'] = "";

		if(!$mb_id) {
			$arr['msg'] = "로그인하셔야 이용가능합니다.";
			$arr['move'] = NFE_URL.'/include/login.php';
		}
		return $arr;
	}


	function get_member($mb_id) {
		// mb_id 가 없다면 false
		if(!$mb_id) return false;
		$query = " select * from alice_member where `mb_id` = '".$mb_id."' ";
		$result = sql_fetch($query);
		return $result;
	}

	function member_info($row) {
		global $netfu_util;

		$_level_arr = $netfu_util->mb_level[$row['mb_level']];

		$arr['gender'] = $netfu_util->gender_arr[$row['mb_gender']];
		$arr['age'] = $netfu_util->get_age($row['mb_birth']);
		if($_level_arr['etc_1']) $arr['level_icon'] = '<img src="'.NFE_URL.'/data/peg/'.$_level_arr['etc_1'].'" />';

		return $arr;
	}

	// 회원별 서비스 정보 추출(단일) :: mb_id 기준
	function get_service_member( $mb_id ){
		// mb_id 가 없다면 false
		if(!$mb_id) return false;
		$query = " select * from alice_member_service where `mb_id` = '".$mb_id."' ";
		$result = sql_fetch($query);
		return $result;
	}


	function get_read_info($re_row, $get_member) {
		global $service_check, $member_service, $is_admin, $utility, $alba_resume_user_control, $member, $netfu_mjob;
		$open_is_pay = $service_check['is_pay'];
		$service_open = $utility->valid_day($member_service['mb_service_open']);	// 이력서 열람 서비스 기간 체크

		if($member_service['mb_service_open_count']){	// 건수 사용이 가능하다면
			$is_open_count = $member_service['mb_service_open_count'];
		}

		$is_open_resume = $alba_resume_user_control->is_open_resume('resume',$member['mb_id'],$re_row['wr_id'], $re_row['no']);	// 열람한 정보가 있는지

		if($member['mb_type']=='individual' || $member['mb_type']=='')
			$tag__= '<em class="vt_n" onClick="alert(\'기업회원으로 로그인하셔야 합니다.\')" style="cursor:pointer;">열람권결제</em>';
		else
			$tag__= '<em class="vt_n" onClick="location.href=\''.NFE_URL.'/payment/read_payment.php\'" style="cursor:pointer;">열람권결제</em>';

		$not_view = 'onClick="alert(\'이력서 작성자분이 비공개설정하신 내용입니다.\')"';

		// : 열람가능 조건
		$_allow = false;
		$receve_row = sql_fetch("select * from `alice_receive` where `wr_from`='".$re_row['no']."' and `wr_to_id`='".$member['mb_id']."' and `is_delete` = 0");
		if($is_open_count && !$is_open_resume) $_allow = 'count';
		if($service_open || $is_open_resume) $_allow = true;
		if($is_admin) $_allow = true;
		if($receve_row) $_allow = true;
		if($member['mb_id'] && $member['mb_id']==$re_row['wr_id']) $_allow = true;
		if(!$netfu_mjob->resume_read_check['is_pay']) $_allow = true;
		$arr['_open_view_allow'] = $_allow;


		if($arr['_open_view_allow']===true) {
			$arr['phone'] = "<p>".$get_member['mb_phone']."</p>";
			$arr['phone_read'] = true;
			$arr['hphone'] = "<p>".$get_member['mb_hphone'].$sms_button."</p>";
			$arr['hphone_read'] = true;
			$arr['email'] = "<p>".$get_member['mb_email']."</p>";
			$arr['email_read'] = true;
			$arr['address'] = "[".$get_member['mb_doro_post']."] ".$get_member['mb_address0']." ".$get_member['mb_address1'];
			$arr['address_read'] = true;
		} else {
			// : 전화번호
			if($open_is_pay && $is_admin==false){	// 열람서비스를 사용한다면 
				if( $get_member['mb_phone_view'] && ($service_open || $is_open_resume) ) {	// 열람 기간이 있다면
					$arr['phone'] = "<p>".$get_member['mb_phone']."</p>";
					$arr['phone_read'] = true;
				} else if($get_member['mb_phone_view'] && $is_open_count && !$is_open_resume){	// 열람 건수가 있다면
					$arr['phone'] = '<em class="vt_n" onclick="netfu_mjob.open_resume(\''.$re_row['no'].'\',\''.$re_row['wr_id'].'\',\'resume\', \''.$is_open_count.'\');">열람권사용</em>';
				} else {
					if($get_member['mb_phone_view']) $arr['phone'] = $tag__;
					else $arr['phone'] = '<em class="vt_m" '.$not_view.'>비공개</em>';
				}
			} else {
				if(($is_member && $get_member['mb_phone_view']) || $is_admin){
					$arr['phone'] = "<p>".$get_member['mb_phone']."</p>";
					$arr['phone_read'] = true;
				} else {
					$arr['phone'] = '<em class="vt_m" '.$not_view.'>비공개</em>';
				}
			}

			// : 휴대전화
			if($open_is_pay && $is_admin==false){	// 열람서비스를 사용한다면 
				if( $get_member['mb_hphone_view'] && ($service_open || $is_open_resume) ) {	// 열람 기간이 있다면
					$arr['hphone'] = "<p>".$get_member['mb_hphone'].$sms_button."</p>";
					$arr['hphone_read'] = true;
				} else if($get_member['mb_hphone_view'] && $is_open_count && !$is_open_resume){	// 열람 건수가 있다면
					$arr['hphone'] = '<em class="vt_n" onclick="netfu_mjob.open_resume(\''.$no.'\',\''.$get_resume['wr_id'].'\',\'resume\', \''.$is_open_count.'\');">열람권사용</em>';
				} else {
					if($get_member['mb_hphone_view']) $arr['hphone'] = $tag__;
					else $arr['hphone'] = '<em class="vt_m" '.$not_view.'>비공개</em>';
				}
			} else {
				if(($is_member && $get_member['mb_hphone_view']) || $is_admin){
					$arr['hphone'] = "<p>".$get_member['mb_hphone'].$sms_button."</p>";
					$arr['hphone_read'] = true;
				} else {
					$arr['hphone'] = '<em class="vt_m" '.$not_view.'>비공개</em>';
				}
			}

			// : 이메일
			if($open_is_pay && $is_admin==false){	// 열람서비스를 사용한다면 
				if( $get_member['mb_email_view'] && ($service_open || $is_open_resume) ) {	// 열람 기간이 있다면
					$arr['email'] = "<p>".$get_member['mb_email']."</p>";
					$arr['email_read'] = true;
				} else if($get_member['mb_email_view'] && $is_open_count && !$is_open_resume){	// 열람 건수가 있다면
					$arr['email'] = '<em class="vt_n" onclick="netfu_mjob.open_resume(\''.$no.'\',\''.$get_resume['wr_id'].'\',\'resume\', \''.$is_open_count.'\');">열람권사용</em>';
				} else {
					if($get_member['mb_email_view']) $arr['email'] = $tag__;
					else $arr['email'] = '<em class="vt_m" '.$not_view.'>비공개</em>';
				}
			} else {
				if(($is_member && $get_member['mb_email_view']) || $is_admin){
					$arr['email'] = "<p>".$get_member['mb_email']."</p>";
					$arr['email_read'] = true;
				} else {
					$arr['email'] = '<em class="vt_m" '.$not_view.'>비공개</em>';
				}
			}

			// : 주소
			if($open_is_pay && $is_admin==false){	// 열람서비스를 사용한다면 
				if( $get_member['mb_address_view'] && ($service_open || $is_open_resume) ) {	// 열람 기간이 있다면
					$arr['address'] = "[".$get_member['mb_doro_post']."] ".$get_member['mb_address0']." ".$get_member['mb_address1'];
					$arr['address_read'] = true;
				} else if($get_member['mb_address_view'] && $is_open_count && !$is_open_resume){	// 열람 건수가 있다면
					$arr['address'] = '<em class="vt_n" onclick="netfu_mjob.open_resume(\''.$re_row['wr_id'].'\',\''.$get_resume['wr_id'].'\',\'resume\', \''.$is_open_count.'\');">열람권사용</em>';
				} else {
					if($get_member['mb_address_view']) $arr['address'] = $tag__;
					else $arr['address'] = '<em class="vt_m" '.$not_view.'>비공개</em>';
				}
			} else {
				if(($is_member && $get_member['mb_address_view']) || $is_admin){
					$arr['address'] = "[".$get_member['mb_doro_post']."] ".$get_member['mb_address0']." ".$get_member['mb_address1'];
					$arr['address_read'] = true;
				} else {
					$arr['address'] = '<em class="vt_m" '.$not_view.'>비공개</em>';
				}
			}
		}

		return $arr;
	}
}
?>