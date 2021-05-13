<?php
// : 구인정보 php정보
$job_info = $netfu_mjob->get_alba($get_alba);

$get_logo = $alba_user_control->get_logo($com_member, $job_info);
$volume_arr = array( "volume" => $get_alba['wr_volume'], "volumes" => $get_alba['wr_volumes'] );
$volmue = $alba_user_control->list_volume($volume_arr); // : 모집인원
$wr_requisition = explode(',',$get_alba['wr_requisition']);	// 지원방법
$pt_paper = $netfu_util->get_cate_array('pt_paper');
$pay_type = $category_control->get_categoryCodeName($get_alba['wr_pay_type']);
$wr_pay = number_format($get_alba['wr_pay'])."원";
$form_question = $category_control->get_categoryCode('20130701103916_7908');	// 사전질문

for($i=0; $i<9; $i++) {
// : 직종
$job_type_arr[] = $get_alba['wr_job_type'.$i] ? $get_alba['wr_job_type'.$i] : '';
}

for($i=0; $i<3; $i++) {
	// : 지역
	if($get_alba['wr_area_'.$i])
		$area_arr[$i] = $get_alba['wr_area_'.$i] ? explode("/", $get_alba['wr_area_'.$i]) : '';

	// : 지하철
	if($get_alba['wr_subway_area_'.$i])
		$subway_arr[$i] = array($get_alba['wr_subway_area_'.$i], $get_alba['wr_subway_line_'.$i], $get_alba['wr_subway_station_'.$i]);
}

$job_type = $netfu_util->get_cate($job_type_arr);// : 직종
if(is_array($area_arr)) foreach($area_arr as $k=>$v) $area_cate[$k] = $netfu_util->get_cate($v); // : 지역
$work_type_cate = $netfu_util->get_cate(explode(",", $get_alba['wr_work_type'])); // : 
$wr_age_etc_cate = $netfu_util->get_cate(explode(",", $get_alba['wr_age_etc']));
$wr_ability_cate = $netfu_util->get_cate($get_alba['wr_ability']);
if(is_array($subway_arr)) foreach($subway_arr as $k=>$v) $subway_cate[$k] = $netfu_util->get_cate($v); // : 지하철

// 근무지역
if($get_alba['wr_area_company']){	// 근무지 주소 0 : 직접입력 / 1 : 기업정보 위치
	$area_point = $com_member['mb_latlng'];
	$wr_area = $com_member['mb_biz_address0']." ".$com_member['mb_biz_address1'];
} else {
	$area_point = $get_alba['wr_area_point'];
	$wr_area = $get_alba['wr_area'];
}




$mb_id = $_GET['mb_id'];
$no = $_GET['no'];
if($mb_id){
	$member_info = $user_control->get_member($mb_id);
	$company_info = $user_control->get_member_company($mb_id);
	$photo_list = $user_control->member_photo_list($mb_id," and `data_no` = 0 "," order by `no` asc ");
	$mb_homepage = $member_info['mb_homepage'];
	$mb_address = $member_info['mb_address0']." ".$member_info['mb_address1'];
	$mb_phone = $member_info['mb_phone'];
	$mb_fax = $member_info['mb_fax'];
} else if($no){
	$company_info = $user_control->get_member_company_no($no);
	$mb_id = $company_info['mb_id'];
	$member_info = $user_control->get_member($mb_id);
	$photo_list = $user_control->member_photo_list($mb_id," and `company_no` = " . $no," order by `no` asc ");
	$mb_homepage = $member_info['mb_homepage'];
	$mb_address = $company_info['mb_biz_address0']." ".$company_info['mb_biz_address1'];
	$mb_phone = $company_info['mb_biz_phone'];
	$mb_fax = $company_info['mb_biz_fax'];
}
?>