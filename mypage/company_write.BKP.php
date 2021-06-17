<?php
$editor_use = true;
$page_code = 'mypage';
include_once "../include/top.php";
include_once NFE_PATH."/engine/netfu_map.class.php";
$netfu_map = new netfu_map();

echo $netfu_map->js_script;

$use_map = $env['use_map'];	// 사용 지도 api
$daum_local_key = $env['daum_map_key'];	// 다음 지도 local 검색 key
$naver_map_key = $env['naver_map_key'];	// 네이버 지도 key

$category_list = $category_control->category_codeList('company_form', " `rank` asc ");

if($_GET['no'])
	$get_company = $member_control->get_company_memberNo($_GET['no']);	 // 기업 정보

$company_logo = $alba_user_control->get_logo($get_company);
$mb_biz_phone = explode('-', $get_company['mb_biz_phone']);
$mb_biz_hphone = explode('-', $get_company['mb_biz_hphone']);
$biz_fax = explode('-', $get_company['mb_biz_fax']);
$map_latlng = explode(',', $get_company['mb_latlng']);
//$mb_homepage = $get_company ? $get_company['mb_homepage'] : $member['mb_homepage'];
$mb_homepage = $get_company['mb_homepage'];
$mb_email = explode('@', $get_company['mb_biz_email']);	 // 이메일
$biz_no = explode('-', $get_company['mb_biz_no']);

$phone_num_option = $config->get_tel_num($mb_biz_phone[0]); // 전화번호
$hphone_num_option = $config->get_hp_num($mb_biz_hphone[0]); // 휴대폰 번호
$fax_num_option = $config->get_tel_num($biz_fax[0]);		// 팩스번호
$biz_type_option = $config->get_biz_type($get_company['mb_biz_type']); // 업종
$email_option = $config->get_email();		// 이메일
$biz_success_option = $config->get_biz_success($get_company['mb_biz_success']);	// 상장여부
$biz_form_option = $config->get_biz_form($get_company['mb_biz_form']);	// 기업형태

//NFE_URL.'/images/no-img.png';
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/map/<?=$use_map;?>.js?time=<?=time();?>"></script>
<form name="fwrite" action="../regist.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="company_write" />
<input type="hidden" name="no" value="<?=$_GET['no'];?>" />
<section class="cont_box add1_info">
<h2>기업정보 추가</h2>
	<ul class="info3_con">

		<li class="row1">
			<label for="logo_bx">회사로고<span class="check"></span></label>
			<div class="logo_pic">
				<div class="logo_bx"><img src="<?=$company_logo;?>" alt="No Image"></div>
				<div class="bt_group">
					<div><input type="file" name="mb_logo" hname="회사로고" onChange="netfu_util1.filesize_check(this, '100')"></div>
					<p>gif, jpg, png 파일형식으로, 135×65픽셀 이하, 100kb이내의 파일만 등록 가능합니다.</p>
				</div>
			</div>
		</li>
		<li class="row3">
			<label for="company_name">회사명<span class="check"></span></label>
			<input type="text" id="company_name" name="mb_company_name" value="<?php echo $get_company['mb_company_name'];?>" hname="회사/점포명" required>
		</li>
		<li class="row2">
			<label for="ceo_name">대표자명<span class="check"></span></label>
			<input type="text" id="ceo_name" name="mb_ceo_name" value="<?php echo $get_company['mb_ceo_name'];?>" hname="대표자명" required>
		</li>
		<li class="row4">
			<label for="classify">회사분류<span class="check"></span></label>
			<select id="classify" name="mb_biz_type" title="회사분류 선택" required hname="회사분류" option="select">
				<option value="">회사분류 선택</option>
				<?php echo $biz_type_option; ?>
			</select>
		</li>
		<li class="row5">
			<fieldset>
				<legend>전화번호<span class="check"></span></legend>
				<select name="mb_biz_phone[]" title="지역번호 선택" required hname="지역번호">
					<?php echo $phone_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_phone[]" required hname="전화번호 앞자리" value="<?php echo $mb_biz_phone[1];?>" class="tel1 phone2">
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_phone[]" required hname="전화번호 뒷자리" value="<?php echo $mb_biz_phone[2];?>" class="tel2 ">
			</fieldset>
		</li>
		<li class="row6">
			<fieldset>
			<legend>휴대폰</legend>
				<select name="mb_biz_hphone[]" title="휴대폰 국번">
				<?php echo $hphone_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_hphone[]" hname="휴대폰 앞자리" value="<?php echo $mb_biz_hphone[1];?>" class="cel1 phone1">
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_hphone[]" hname="휴대폰 뒷자리" value="<?php echo $mb_biz_hphone[2];?>" class="cel2 ">
			</fieldset>
		</li>
		<li class="row7">
			<script type="text/javascript">
			var form = document.forms['fwrite'];
			</script>
			<?php
			$map_use = true;
			include NFE_PATH.'/include/inc/post.inc.php';
			?>
			<script type="text/javascript">
			daum_map.map_basic('address_map');
			daum_map.map_click(form);
			</script>
			<input type="hidden" name="map_latlng[]" value="<?=$map_latlng[0];?>" />
			<input type="hidden" name="map_latlng[]" value="<?=$map_latlng[1];?>" />
			<fieldset>
				<legend>주소<span class="check"></span></legend>
				<input type="text" size="4" maxlength="4" id="mb_doro_post" name="mb_doro_post" readonly required hname="도로명" value="<?php echo $get_company['mb_biz_doro_post'];?>" class="post">
				<input type="text" maxlength="" name="mb_address0" id="mb_address0" required hname="주소" value="<?php echo $get_company['mb_biz_address0'];?>"  class="address1">
				<button type="botton" class="form_bt form_bt2" onClick="post_click(); return false;">우편번호</button>
				<div class="cf">
				<input type="text" name="mb_address1" required hname="상세주소" value="<?php echo $get_company['mb_biz_address1'];?>" class="address2" placeholder="상세주소를 입력하세요.">
				</div>
			</fieldset>
		</li>

		<?php
		if(is_array($category_list)) { foreach($category_list as $k=>$v) {
			if($v['view']=='no') continue; // : 사용안함
			$_check = $v['etc_0']==1 ? '<span class="check"></span>' : '';
			$_required = $v['etc_0']==1 ? 'required' : '';

			switch($v['name']) {
				case "사업자등록번호":
		?>
		<li class="row8">
			<fieldset>
				<legend>사업자번호<?=$_check;?></legend>
				<input type="text" name="mb_biz_no[]" hname="사업자번호" <?=$_required;?> value="<?=$biz_no[0];?>">
				<p>-</p>
				<input type="text" name="mb_biz_no[]" hname="사업자번호" <?=$_required;?> value="<?=$biz_no[1];?>">
				<p>-</p>
				<input type="text" name="mb_biz_no[]" hname="사업자번호" <?=$_required;?> value="<?=$biz_no[2];?>">
			</fieldset>
		</li>
		<?php
					break;



				case "팩스번호":
		?>
		<li class="row9">
			<legend>팩스번호<?=$_check;?></legend>
			<select name="mb_biz_fax[]" hname="팩스번호">
			<?=$fax_num_option;?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_fax[]" hname="팩스번호" <?=$_required;?> value="<?=$biz_fax[1];?>" class="fax1 phone2">
			<p>-</p><input type="tel" size="4" maxlength="4" name="mb_biz_fax[]" hname="팩스번호" <?=$_required;?> value="<?=$biz_fax[2];?>" class="fax2 ">
			</fieldset>
		</li>
		<?php
					break;



				case "홈페이지주소":
		?>
		<li class="row10">
			<label for="homepage">홈페이지<?=$_check;?></label>
			<span>http://</span><input type="text" name="mb_homepage" hname="홈페이지주소" <?=$_required;?> value="<?=$utility->remove_http($mb_homepage);?>" class="">
		</li>
		<?php
					break;




				case "이메일":
		?>
		<li class="row11">
		<fieldset>
			<legend>이메일<?=$_check;?></legend>
			<input type="text" name="mb_email[]" hname="이메일" <?=$_required;?> value="<?=$mb_email[0];?>" class="email" hname="이메일" >
			<p>@</p><input type="text" name="mb_email[]" hname="이메일" value="<?=$mb_email[1];?>" id="mb_email_put" class="email" hname="이메일" >
			<select onChange="netfu_util1.put_text(this, $('#mb_email_put'))">
			<option value="">직접입력</option>
			<?=$email_option;?>
			</select>
		</fieldset>
		</li>
		<?php
					break;



				case "상장여부":
		?>
		<li class="row12">
			<label for="listed">상장여부<?=$_check;?></label>
			<select id="listed" name="mb_biz_success" hname="상장여부" <?=$_required;?>>
				<option value="">상장여부 선택</option>
				<?=$biz_success_option;?>
			</select>
		</li>
		<?php
					break;




				case "기업형태":
		?>
		<li class="row13">
			<label for="type">기업형태<?=$_check;?></label>
			<select id="type" name="mb_biz_form" hname="기업형태" <?=$_required;?>>
				<option value="">기업형태 선택</option>
				<?=$biz_form_option;?>
			</select>
		</li>
		<?php
					break;




				case "주요사업내용":
		?>
		<li class="row14">
			<label for="business">주요사업내용<?=$_check;?></label>
			<input type="text" id="business" name="mb_biz_content" hname="주요사업내용" <?=$_required;?> value="<?=$get_company['mb_biz_content'];?>" />
		</li>
		<?php
					break;




				case "설립연도":
		?>
		<li class="row15">
			<label for="f_year">설립년도<?=$_check;?></label>
			<select id="f_year" name="mb_biz_foundation" hname="설립년도" <?=$_required;?>>
				<option value="">선택</option>
				<?php
				$foundation_option = "";
				for($i=date('Y');$i>=1900;--$i){
					$selected = ($get_company['mb_biz_foundation']==$i) ? 'selected' : '';
					$foundation_option .= "<option value='".$i."' ".$selected.">".$i." 년</option>";
				}
				?>
				<?=$foundation_option;?>
			</select>
			설립
		</li>
		<?php
					break;




				case "사원수":
		?>
		<li class="row16">
			<label for="employee">사원수<?=$_check;?></label>
			<input type="text" id="employee" name="mb_biz_member_count" hname="사원수" <?=$_required;?> value="<?=$get_company['mb_biz_member_count'];?>" hname="사원수">명
		</li> 
		<?php
					break;




				case "자본금":
		?>
		<li class="row17">
			<label for="capital">자본금<?=$_check;?></label>
			<input type="text" id="capital" name="mb_biz_stock" hname="자본금" <?=$_required;?> value="<?=$get_company['mb_biz_stock'];?>" hname="자본금" /> 
		</li>
		<?php
					break;




				case "매출액":
		?>
		<li class="row18">
			<label for="sales">매출액<?=$_check;?></label>
			<input type="text" id="sales" name="mb_biz_sale" hname="매출액" <?=$_required;?> value="<?=$get_company['mb_biz_sale'];?>" hname="매출액">원
		</li> 
		<?php
					break;




				case "기업개요 및 비전":
		?>
		<li class="row19">
			기업개요 및 비전<?=$_check;?>
			<textarea type="editor" name="mb_biz_vision" rows="9" hname="기업개요 및 비전" <?=$_required;?>><?=stripslashes($get_company['mb_biz_vision']);?></textarea>
		</li> 
		<?php
					break;




				case "기업연혁 및 실적":
		?>
		<li class="row20">
			기업연혁 및 실적<?=$_check;?>
			<textarea type="editor" name="mb_biz_result" rows="9" hname="기업연혁 및 실적" <?=$_required;?>><?=stripslashes($get_company['mb_biz_result']);//$utility->make_cheditor('mb_biz_result',stripslashes($get_company['mb_biz_result']))?></textarea>
		</li> 
		<?php
					break;
			}
		?>
		<?php
		} }
		?>
	</ul>
</section>

<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="netfu_util1.ajax_submit(document.forms['fwrite'])">저장</a><a href="#none;" onClick="document.forms['fwrite'].reset()" class="bottom_btn02">취소</a>
</div>
</form>

<?php
include "../include/tail.php";
?>