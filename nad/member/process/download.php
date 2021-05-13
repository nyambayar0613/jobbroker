<?php
		/*
		* /application/nad/member/process/download.php
		* @author Harimao
		* @since 2013/07/11
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Member data download
		* @Comment :: 회원 데이터 다운로드
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$mb_type = $_GET['mb_type'];
		$mode = $_GET['mode'];

		$admin_control->is_admin( $ajax );	// 관리자 체크
		
		$page = ($page) ? $page : 1;
		$page_rows = ($page_rows) ? $page_rows: 15;
		$sorting = ($sort) ? "&sort=" . $sort . "&flag=" . $flag . "&" : "";
		if($mb_type) {
			$where = ($mode=='search') ? "and" : "where";
			$con = $where . " a.mb_type = '".$mb_type."' and a.is_delete = 0 ";
		} else {
			$con = " where  a.is_delete = 0 ";
		}
		
		$member_list = $member_control->__MemberList($page, "", $con);	// $page_rows 뺌
		$pages = $utility->get_paging($page_rows, $page, $member_list['total_page'],"./?".$sorting."page_rows=".$page_rows."&".$member_list['send_url']."&page=");

		header('Content-Type: application/vnd.ms-excel; charset='.$alice['charset']);
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT'); 
		header('Content-Disposition: attachment; filename="member_' . date("ymd", time()) . '.xls"'); 
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
		header('Pragma: public'); 


?>

<table align=center  cellpadding="0" cellspacing="0" border="1" width="100%" class="mt20">
<colgroup>
<col width="2%"><!-- NO -->
<col width="8%"><!-- 회원구분 -->
<col width="10%"><!-- 회원ID -->
<col width="10%"><!-- 이름/대표자 -->
<col width="12%"><!-- 이메일 -->
<col width="8%"><!-- 휴대폰번호 -->
<col width="8%"><!-- 전화번호 -->
<col width="5%"><!-- 우편번호 -->
<col width="12%"><!-- 주소 -->
<col width="8%"><!-- 닉네임 -->
<col width="8%"><!-- 성별/나이 -->
<col width="8%"><!-- 회원등급 -->
<col width="8%"><!-- 포인트 -->
<col><!-- 회사명 -->
<!--<col width="5%"> 알바공고건수 -->
<!--<col width="5%"> 이력서열람서비스 -->
<!--<col width="5%"> 알바이력서건수 -->
<!--<col width="5%"> 알바지원건수 -->
<col width="10%"><!-- 홈페이지주소 -->
<col width="5%"><!-- 방문수 -->
<col width="5%"><!-- 가입일 -->
<!--<col width="5%"> 탈퇴요청일 -->
<!--<col width="5%"> 게시물수 -->
<col><!-- 메모 -->
</colgroup>
<tr>
<td colspan="17" class="ntlt">회원관리 <span class="fon11 dgr pL3 nom">| &nbsp;총 <b class="num2 col"><?=$member_list['total_count'];?></b>명의 회원이 검색되었습니다.</span></td>
</tr>
<tr><td colspan="17" height="2" class="ln_dbl"></td></tr>
<tr class="bg tc">
<td align="center">NO</td>
<td align="center">회원구분</td>
<td align="center">회원ID</td>
<td align="center">이름/대표자</td>
<td align="center">이메일</td>
<td align="center">휴대폰번호</td>
<td align="center">전화번호</td>
<td align="center">우편번호</td>
<td align="center">주소</td>
<td align="center">닉네임</td>
<td align="center">성별/나이</td>
<td align="center">회원등급</td>
<td align="center">포인트</td>
<td align="center">회사명</td>
<!-- <td align="center">알바공고건수</td>
<td align="center">이력서열람서비스(기간)</td>
<td align="center">알바이력서건수</td>
<td align="center">알바지원건수</td> -->
<td align="center">방문수</td>
<td align="center">가입일</td>
<!-- <td align="center">탈퇴요청일</td>
<td align="center">게시물수</td> -->
<td align="center">메모</td>
</tr>
<?php
	if(!$member_list){
?>
<tr>
<td class="stlt" colspan="11">등록된 내용이 없습니다.</td>
</tr>
<?php 
	} else {
	$no = 0;
	foreach($member_list['result'] as $val){
	$no++;

	if($val['mb_type']=='individual'){
		$individual_msg = "<span style='color:#dfdfdf;'>개인</span>";
		$mb_type = "개인회원";
		$mb_company_name = $individual_msg;
		$mb_service_open = $individual_msg;
		$mb_alba_resume = number_format($val['mb_alba_resume_count']);
	} else if($val['mb_type']=='company'){
		$company_msg = "<span style='color:#dfdfdf;'>기업</span>";
		$mb_type = "기업회원";
		$mb_company_name = stripslashes($val['mb_company_name']);
		$mb_service_open = $val['mb_service_open'];
		$mb_alba_resume = $company_msg;
	}
	$mb_type .= ($val['mb_badness']) ? " <b>(불량)</b>" : "";
	$mb_name  = $val['mb_name'];
	$mb_name .= ($val['mb_company_name']) ? "/" . $val['mb_company_name'] : "";

	$get_gender = $member_control->mb_gender[$val['mb_gender']];	// 성별
	$get_age = $member_control->get_age($val['mb_birth']);	// 나이
	//$mb_name .= ($val['mb_type']=='individual') ? " (".$get_gender."/".$get_age."세)" : "";

	$mb_info = ($val['mb_type']=='individual') ? $get_gender . "/" . $get_age."세" : $company_msg;

	$mb_alba_count = number_format($val['mb_alba_count']);	// 기업 :: 알바공고수 / 개인 :: 알바지원수
	$mb_wdate = substr($val['mb_wdate'],0,11);
	if($val['mb_left_request']){
		$mb_left_request_date = $val['mb_left_request_date'];
		$mb_left = $val['mb_left'];
	} else {
		$mb_left_request_date = $mb_left = "<span style='color:#dfdfdf;'>탈퇴미요청</span>";
		$mb_left = "<span style='color:#dfdfdf;'>미탈퇴</span>";
	}
	$level_name = $member_control->get_level($val['mb_level']);

?>
<tr height="30" class="wr_list">
	<td align="center"><?php echo $no;?></td>
	<td align="center"><?php echo $mb_type;?></td>
	<td align="center"><?php echo $val['mb_id'];?></td>
	<td align="center"><?php echo $mb_name;?></td>
	<td align="center"><?php echo $val['mb_email'];?></td>
	<td align="center"><?php echo $val['mb_hphone'];?></td>
	<td align="center"><?php echo $val['mb_phone'];?></td>
	<td align="center"><?php echo $val['mb_zipcode'];?></td>
	<td align="center"><?php echo $val['mb_address0']." ".$val['mb_address1'];?></td>
	<td align="center"><?php echo $val['mb_nick'];?></td>
	<td align="center"><?php echo $mb_info;?></td>
	<td align="center"><?php echo $level_name;?></td>
	<td align="center"><?php echo number_format($val['mb_point']);?></td>
	<td align="center"><?php echo $mb_company_name;?></td>
	<!-- <td align="center">알바공고건수</td>
	<td align="center">이력서열람서비스(기간)</td>
	<td align="center">알바이력서건수</td>
	<td align="center">알바지원건수</td> -->
	<td align="center"><?php echo number_format($val['mb_login_count']);?></td>
	<td align="center"><?php echo $val['mb_wdate'];?></td>
	<!-- <td align="center">탈퇴요청일</td>
	<td align="center">게시물수</td> -->
	<td align="center"><?php echo nl2br(stripslashes($val['mb_memo']));?></td>
<?php 
	} 
}
?>
</tr>
</table>