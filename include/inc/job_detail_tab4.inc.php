<?php
// : $com_member 변수는 /job/detail.php에 있음
$mb_id = $get_alba['wr_id'];
$no = $get_alba['no'];
$category_list = $category_control->category_codeList('company_form', " `rank` asc ");

$photo_list = $user_control->member_photo_list($mb_id," and `company_no` = " . $no," order by `no` asc ");
$mb_homepage = $com_member['mb_homepage'];
$mb_address = $com_member['mb_biz_address0']." ".$com_member['mb_biz_address1'];
$mb_phone = $com_member['mb_biz_phone'];
$mb_hphone = $com_member['mb_biz_hphone'];
$mb_fax = $com_member['mb_biz_fax'];
$mb_biz_no = $com_member['mb_biz_no'];
$mb_email = $com_member['mb_biz_email'];

$fax_arr = explode("-", $mb_fax);
$hphone_arr = explode("-", $mb_hphone);
$biz_no_arr = explode("-", $mb_biz_no);

$service_check = $service_control->service_check('etc_alba');
$open_is_pay = $service_check['is_pay'];
$service_open = $utility->valid_day($member_service['mb_service_alba_open']);	// 공고 열람 서비스 기간 체크
// 열람권 기간/건수 확인
$is_open_service = false;
if( $utility->valid_day($member_service['mb_service_alba_open']) ){
	$is_open_service = $member_service['mb_service_alba_open'];
}
$is_open_count = false;
if( $utility->valid_day($member_service['mb_service_alba_open']) && $member_service['mb_service_alba_count'] ){	// 건수 사용이 가능하다면
	$is_open_count = $member_service['mb_service_alba_count'];
}
// 채용공고 열람 정보 저장
if($is_open_service && !$is_open_count)	// 열람 기간은 있고, 열람 건수는 없는 경우
	$alba_individual_control->open_insert($no,$get_alba['wr_id'],"alba");

$is_open_alba = $alba_resume_user_control->is_open_resume('alba',$member['mb_id'],$get_alba['wr_id'], $no);	// 열람한 정보가 있는지

$wr_is_open = false;
$wr_mb_address = $wr_mb_phone = $wr_mb_hphone = $wr_mb_fax = "";
if($open_is_pay){	// 열람서비스를 사용한다면 
	if($is_open_count && !$is_open_alba){	 // 열람 건수가 있다면
		//$wr_mb_phone = $wr_mb_fax = $wr_mb_address = "<a href=\"javascript:void(0);\" onclick=\"open_alba('".$no."','".$get_alba['wr_id']."','alba', '".$is_open_count."');\"><img alt=\"열람권사용\" src=\"../images/icon/icon_used.gif\"></a>";
		$wr_mb_address = $wr_mb_phone = $wr_mb_hphone = $wr_mb_fax = "<img alt=\"열람권사용\" src=\"../images/icon/icon_used.gif\">";
	} else if( $service_open || $is_open_alba ) {
		$wr_mb_address = $mb_address;
		$wr_mb_phone = $mb_phone;
		$wr_mb_hphone = $mb_hphone;
		$wr_mb_fax = $mb_fax;
	} else {
		$wr_mb_address = $wr_mb_phone = $wr_mb_hphone = $wr_mb_fax = "<img width=\"41\" height=\"14\" alt=\"비공개\" src=\"../images/icon/icon_closed.gif\">";
	}
} else {
	$wr_mb_address = $mb_address;
	$wr_mb_phone = $mb_phone;
	$wr_mb_hphone = $mb_hphone;
	$wr_mb_fax = $mb_fax;
}

$mb_biz_type = $category_control->get_categoryCodeName($com_member['mb_biz_type']);
$mb_biz_form = $category_control->get_categoryCodeName($com_member['mb_biz_form']);
$mb_biz_success = $category_control->get_categoryCodeName($com_member['mb_biz_success']);
?>
<div class="tab-box tab4-box job_tab4">
	<div>
		<table>
		<tr>
			<th>회사명</th>
			<td><?=stripslashes($com_member['mb_company_name']);?></td>
		</tr>
		<tr>
			<th>대표자명</th>
			<td><?php echo $com_member['mb_ceo_name'];?></td>
		</tr>
		<tr>
			<th>회사분류</th>
			<td><?php echo $mb_biz_type;?></td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td><?=$wr_mb_phone;?></td>
		</tr>
		<tr>
			<th>휴대폰</th>
			<td><?=$wr_mb_hphone;?></td>
		</tr>
		<tr>
			<th>회사주소</th>
			<td><?=trim($wr_mb_address);?></td>
		</tr>
		<?php
		if(is_array($category_list)) { foreach($category_list as $k=>$v) {

			if($v['view']=='no') continue; // : 사용안함

			switch($v['name']) {
				case "사업자등록번호":
		?>
		<tr>
			<th>사업자번호</th>
			<td><?php echo $utility->make_pass_($mb_biz_no);?></td>
		</tr>
		<?php
					break;


				case "팩스번호":
					if(!preg_replace("/-/", "", $wr_mb_fax)) break;
		?>
		<tr>
			<th>팩스번호</th>
			<td><?php if(preg_replace("/-/", "", $wr_mb_fax)) echo $wr_mb_fax;?></td>
		</tr>
		<?php
					break;


				case "홈페이지주소":
					if(!$mb_homepage) break;
		?>
		<tr>
			<th>홈페이지</th>
			<td><a href="<?=$netfu_util->get_homepage($mb_homepage);?>" target="_blank"><?=$netfu_util->get_homepage($mb_homepage);?></a></td>
		</tr>
		<?php
					break;


				case "이메일":
					$_mb_email = explode("@", $mb_email);
					if(!$_mb_email[0]) break;
		?>
		<tr>
			<th>이메일</th>
			<td><?=$mb_email;;?></td>
		</tr>
		<?php
					break;


				case "상장여부":
		?>
		<tr>
			<th>상장여부</th>
			<td><?php echo $mb_biz_success;?></td>
		</tr>
		<?php
					break;


				case "기업형태":
		?>
		<tr>
			<th>기업형태</th>
			<td><?php echo $mb_biz_form;?></td>
		</tr>
		<?php
					break;


				case "주요사업내용":
		?>
		<tr>
			<th>사업내용</th>
			<td><?php echo $com_member['mb_biz_content'];?></td>
		</tr>
		<?php
					break;


				case "설립연도":
					if(!$com_member['mb_biz_foundation']) break;
		?>
		<tr>
			<th>설립연도</th>
			<td><?=$com_member['mb_biz_foundation'];?>년</td>
		</tr>
		<?php
					break;


				case "사원수":
					if(!$com_member['mb_biz_member_count']) break;
		?>
		<tr>
			<th>사원수</th>
			<td><?=$com_member['mb_biz_member_count'];?>명</td>
		</tr>
		<?php
					break;


				case "자본금":
					if(!$com_member['mb_biz_stock']) break;
		?>
		<tr>
			<th>자본금</th>
			<td><?php echo $com_member['mb_biz_stock'];?></td>
		</tr>
		<?php
					break;


				case "매출액":
					if(!$com_member['mb_biz_sale']) break;
		?>
		<tr>
			<th>매출액</th>
			<td><?php echo $com_member['mb_biz_sale'];?></td>
		</tr>
		<?php
					break;
			}
		} }
		?>
		</table>
	</div>



	<?php
	if($com_member['mb_biz_vision'] || $com_member['mb_biz_vision']) {
	?>
	<div class="tab4-box2 cf">
		<?php
		if($com_member['mb_biz_vision']) {
		?>
		<dl>
			<dt class="intro">기업개요 및 비전</dt>
			<dd>
				<?php echo nl2br(stripslashes($com_member['mb_biz_vision']));?>
			</dd>
		</dl>
		<?php }
		if($com_member['mb_biz_vision']) {
		?>
		<dl>
			<dt class="intro">기업연혁 및 실적</dt>
			<dd>
				<?php echo nl2br(stripslashes($com_member['mb_biz_result']));?>
			</dd>
		</dl>
		<?php
		}?>
	</div>
	<?php }?>
</div>