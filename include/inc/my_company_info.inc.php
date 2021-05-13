<?php
// : 이파일을 include할때 $wr_company 변수값이 있다면 그 기업정보로 출력합니다.
if($wr_company)
	$__company_row = sql_fetch("select * from `alice_member_company` where `no`='".$wr_company."'");

if(!$__company_row) {
	$__logo = $mb_logo;
	$__company_name = $member_com['mb_company_name'];
	$__no = $company_member['no'];
	$__ceo_name = $member_com['mb_ceo_name'];
	$__address = $member_com['mb_biz_address0'].' '.$member_com['mb_biz_address1'];
} else {
	$mb_logo_file = NFE_URL."/data/member/".$__company_row['mb_id']."/logo/".$__company_row['mb_logo'];
	$mb_logo = (is_file(NFE_PATH.$mb_logo_file)) ? $mb_logo_file : "../images/basic/bg_noLogo.gif";	 // 기업회원 로고 사진
	$__logo = $mb_logo;
	$__company_name = $__company_row['mb_company_name'];
	$__no = $__company_row['no'];
	$__ceo_name = $__company_row['mb_ceo_name'];
	$__address = $__company_row['mb_biz_address0'].' '.$__company_row['mb_biz_address1'];

	$get_logo = $alba_user_control->get_logo($__company_row, $job_row);
	if($get_logo) $__logo = $get_logo;
}

// : 로고등록폼은 include/top.php에 include되있으며  include/inc/logo_write.inc.php'입니다.
?>
<div class="company_con cf">
	<div class="logo_box">
		<img src="<?php echo $__logo;?>" alt="LOGO" id="companylogo">
	</div>
	<div class="text_box">
		<div class="company"><?=$__company_name;?></div>
	</div>
	<div class="btn_group">
		<a href="#none" class="bt_item1 logo_write__"><?=is_file(NFE_PATH.$mb_logo_file) ? '수정' : '등록';?></a>
		<a href="#none" class="bt_item2" id="logo_remove" onClick="netfu_mjob.logo_delete('<?=$__no;?>')" style="<?=(!is_file(NFE_PATH.$mb_logo_file)) ? 'display:none;' : '';?>;">삭제</a>
	</div>
</div>

<div class="company_info cf">
	<div class="mb_info ceo_info">
		<div class="ceo_inner">
			<dl>
				<dt class="hd hd2">대표자명</dt>
				<dd class="col1 col2">
					<?=$__ceo_name;?>
				</dd>
			</ul>
		</div>
	</div>
	<div class="mb_info address_info">
		<div class="address_inner">
			<dl>
				<dt class="hd hd2">회사주소</dt>
				<dd class="col1 col3">
					<?=$__address;?>
				</dd>
			</ul>
		</div>
	</div> 
</div>