<?php
// : 실명인증해서 넘어간 값은 _core.php에 합니다.

$_cate_['biz_type'] = $netfu_util->get_cate_array('biz_type', array('where'=>" and `p_code` = ''"));
$_cate_['biz_success'] = $netfu_util->get_cate_array('biz_success', array('where'=>" and `p_code` = ''"));
$_cate_['biz_form'] = $netfu_util->get_cate_array('biz_form', array('where'=>" and `p_code` = ''"));

include_once NFE_PATH."/engine/netfu_map.class.php";
$netfu_map = new netfu_map();

echo $netfu_map->js_script;

$_html = $netfu_util->input_htmlspecialchars($member);
$_html_c = $netfu_util->input_htmlspecialchars($member_com);
$_map_latlng = explode(",", $member_com['mb_latlng']);
$_mb_biz_no = explode("-", $member_com['mb_biz_no']);

$_mb_phone = explode("-", $member['mb_phone']);
$_mb_hphone = explode("-", $_mb_hphone);
$_mb_biz_fax = explode("-", $member_com['mb_biz_fax']);

$use_map = $env['use_map'];	// 사용 지도 api
$daum_local_key = $env['daum_map_key'];	// 다음 지도 local 검색 key
$naver_map_key = $env['naver_map_key'];	// 네이버 지도 key

$_GET['kind'] = $_GET['kind'] ? $_GET['kind'] : 'company';


$category_list = $category_control->category_codeList('company_form', " `rank` asc ");
?>

<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/map/<?=$use_map;?>.js?time=<?=time();?>"></script>
<style>
.info2_con .row9 .smschk{clear:both;height:32px;line-height:32px;padding-left:23%;color:#666}
.info2_con .row9 .smschk input{margin-top:9px;width:20px;margin-right:5px;}
.info2_con .row17 .smschk{clear:both;height:32px;line-height:32px;padding-left:23%;color:#666}
.info2_con .row17 .smschk input{margin-top:9px;width:20px;margin-right:5px;}
</style>
<section class="cont_box join_con">
	<ul class="info2_con">
		<?php
		if(!$member['mb_id']) {
		?>
		<li class="row1">
			<label for="member_id">아이디<span class="check"></span></label>
			<input type="text" id="member_id" name="mb_id" maxlength="41">
			<input type="hidden" name="member_check" id="member_check" value="" message="아이디를 중복확인해주시기 바랍니다." required nofocus style="display:none;" />
			<button type="button" class="form_bt" onClick="netfu_member.dupl_mid($('#member_id').val())">중복확인</button>
		</li>
		<?php }?>

		<?php
		if(!$member['mb_id']) {
		?>
		<li class="row2">
			<label for="pw">비밀번호<span class="check"></span></label>
			<input type="password" id="pw" name="mb_password" hname="비밀번호" required maxlength="16">
		</li>
		<li class="row3">
			<label for="pw2">비번확인<span class="check"></span></label>
			<input type="password" id="pw2" name="mb_password_re" hname="비번확인" required maxlength="16">
		</li>
		<?php }?>
		<li class="row4">
			<label for="name2">가입자명<span class="check"></span></label>
			<?php
			if($member['mb_id'] || $_SESSION['certify_info']) {
				echo $_mb_name;
				if($_member_write_input_view) {
				?>
				<input type="hidden" id="name2" name="mb_name" value="<?=$_mb_name;?>" hname="가입자명" required maxlength="41">
				<?php
				}
			} else {
			?>
			<input type="text" id="name2" name="mb_name" value="<?=$_html['mb_name'];?>" hname="가입자명" required maxlength="41">
			<?php }?>
		</li>
		<li class="row5">
			<label for="ceo">대표자명<span class="check"></span></label>
			<input type="text" name="mb_ceo_name" value="<?=$_html_c['mb_ceo_name'];?>" hname="대표자명" required maxlength="41">
		</li>
		<li class="row6">
			<label for="nickname">닉네임<span class="check"></span></label>
			<input type="text" id="nickname" name="mb_nick" value="<?=$_html['mb_nick'];?>" hname="닉네임" required maxlength="41">
			<input type="hidden" name="nick_check" id="nick_check" value="<?=$member['mb_id'] ? 1 : '';?>" message="닉네임을 중복확인해주시기 바랍니다." required nofocus style="display:none;" />
			<button type="button" class="form_bt" onClick="netfu_member.dupl_nick($('#nickname').val())">중복확인</button>
		</li>
		<li class="row7">
			<label for="company">회사명<span class="check"></span></label>
			<input type="text" id="company" name="mb_company_name" hname="회사명" required value="<?=$_html_c['mb_company_name'];?>" maxlength="41">
		</li>
		<li class="row8">
			<label for="co_type">회사분류<span class="check"></span></label>
			<select name="mb_biz_type" id="co_type" hname="회사분류" required>
				<option value="">선택</option>
				<?php
				if(is_array($_cate_['biz_type'])) { foreach($_cate_['biz_type'] as $k=>$v) {
					$selected = $member_com['mb_biz_type']==$v['code'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
			</select>
		</li>
		<li class="row9" style="height:auto">
			<label for="phone1">휴대폰</label>
			<?php
			if($_member_write_input_view) {
				echo @implode(" - ", $_mb_hphone);
				?>
				<input type="hidden" name="mb_hphone[]" value="<?=$_mb_hphone[0];?>" />
				<input type="hidden" name="mb_hphone[]" value="<?=$_mb_hphone[1];?>" />
				<input type="hidden" name="mb_hphone[]" value="<?=$_mb_hphone[2];?>" />
				<?php
			} else {?>
			<select name="mb_hphone[]">
				<?php echo $hp_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone1" name="mb_hphone[]" value="<?=$_mb_hphone[1];?>" class="phone1">
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone1" name="mb_hphone[]" value="<?=$_mb_hphone[2];?>">
			<?php }?>
			<div class="receive smschk"><input type="checkbox" name="mb_receive[]" value="sms" checked="checked">인재정보/이력서 관련소식 등의 SMS 수신</div>
		</li>
		<li class="row10">
			<label for="phone2">전화번호<span class="check"></span></label>
			<select name="mb_phone[]" hname="전화번호" required>
				<?php echo $tel_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="mb_phone[]" hname="전화번호" required value="<?=$_mb_phone[1];?>" class="phone2">
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="mb_phone[]" hname="전화번호" required value="<?=$_mb_phone[2];?>">
		</li>
		<li class="row11">
			<script type="text/javascript">
			var form = document.forms['fmember'];
			</script>
			<?php
			$map_use = true;
			include NFE_PATH.'/include/inc/post.inc.php';
			?>
			<script type="text/javascript">
			daum_map.map_basic('address_map');
			daum_map.map_click(form);
			</script>
			<input type="hidden" name="map_latlng[]" value="<?=$_map_latlng[0];?>" />
			<input type="hidden" name="map_latlng[]" value="<?=$_map_latlng[1];?>" />
			<label for="address">주소<span class="check"></span></label>
			<input type="text" size="4" maxlength="4" id="mb_doro_post" hname="우편번호" required name="mb_doro_post" value="<?=$_html['mb_address_road'];?>" class="post">
			<input type="hidden" name="mb_zipcode[]" /><input type="hidden" name="mb_zipcode[]" />
			<input type="text" maxlength="" id="mb_address0" name="mb_address0" hname="주소" required  class="address1" value="<?=$_html['mb_address0'];?>">
			<button type="botton" class="form_bt form_bt2" onClick="post_click(); return false;">우편번호</button>
			<div class="cf">
			 <input type="text" id="address" name="mb_address1" hname="상세주소" value="<?=$_html['mb_address1'];?>" class="address2" placeholder="상세주소를 입력하세요.">
			</div>
		</li>
		<li class="row12">
			<label>로고</label>
			<div class="logo_pic">
				<div class="logo_bx"><img src="<?=$member['mb_id'] ? $mb_logo : NFE_URL.'/images/no-img.png';?>" alt="No Image"></div>
				<div class="bt_group">
					<span><input type="file" name="logo" onChange="netfu_util1.filesize_check(this, '<?=$netfu_mjob->logo_size;?>')"></span>
					<p>gif, jpg, png 파일형식으로, 130×72픽셀 이하, 100kb이내의 파일만 등록 가능합니다.</p>
				</div>
			</div>
		</li>



		<?php
		if(is_array($category_list)) { foreach($category_list as $k=>$v) {

			if($v['view']=='no') continue; // : 사용안함
			$_check = $v['etc_0']==1 ? '<span class="check"></span>' : '';
			$_required = $v['etc_0']==1 ? 'required' : '';

			switch($v['name']) {
				case "사업자등록번호":
		?>
		<li class="row13">
			<label class="biz_num">사업자번호<?=$_check;?></label>
			<input type="text" name="mb_biz_no[]" hname="사업자번호" <?=$_required;?> value="<?=$_mb_biz_no[0];?>">
			<p>-</p>
			<input type="text" name="mb_biz_no[]" hname="사업자번호" <?=$_required;?> value="<?=$_mb_biz_no[1];?>">
			<p>-</p>
			<input type="text" name="mb_biz_no[]" hname="사업자번호" <?=$_required;?> value="<?=$_mb_biz_no[2];?>">
		</li>
		<li class="row12">
			<label>사업자등록증</label>
			<div class="logo_pic">
				<div class="bt_group">
					<input type="file" name="com_num_photo" style="width:100%">
				</div>
			</div>
		</li>
		<?php
					break;


				case "팩스번호":
		?>
		<li class="row15">
			<label for="phone2">팩스번호<?=$_check;?></label>
			<select name="mb_biz_fax[]" hname="팩스번호" <?=$_required;?>>
				<?php echo $fax_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="mb_biz_fax[]" <?=$_required;?> hname="팩스번호" class="phone2" value="<?=$_mb_biz_fax[1];?>">
			<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="mb_biz_fax[]" <?=$_required;?> hname="팩스번호" value="<?=$_mb_biz_fax[2];?>">
		</li>
		<?php
					break;


				case "홈페이지주소":
		?>
		<li class="row16">
			<label for="homepage">홈페이지<?=$_check;?></label>
			<span>http://</span><input type="text" name="mb_homepage" hname="홈페이지" <?=$_required;?> value="<?=$_html_c['mb_homepage'];?>" class="">
		</li>
		<?php
					break;


				case "이메일":
		?>
		<li class="row17" style="height:auto">
			<label for="email">이메일<?=$_check;?></label>
			<input type="text" id="email" name="mb_email[]" hname="이메일" <?=$_required;?> value="<?=$mb_email[0];?>" class="email">
			<p>@</p><input type="tel" name="mb_email[]" hname="이메일" <?=$_required;?> value="<?=$mb_email[1];?>" id="mb_email_put" class="email">
			<select onChange="netfu_util1.put_text(this, $('#mb_email_put'))" style="margin:0">
				<option value="">직접입력</option>
				<?php echo $email_option; ?>
			</select>
			<div class="receive smschk"><input type="checkbox" name="mb_receive[]" value="email" checked="checked">인재정보 등의 이메일 수신</div>
		</li>
		<?php
					break;


				case "상장여부":
		?>
		<li class="row18">
			<label for="listed">상장여부<?=$_check;?></label>
			<select id="listed" name="mb_biz_success" hname="상장여부" <?=$_required;?>>
				<option value="">상장여부 선택</option>
				<?php
				if(is_array($_cate_['biz_success'])) { foreach($_cate_['biz_success'] as $k=>$v) {
					$selected = $member_com['mb_biz_success']==$v['code'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
			</select>
		</li>
		<?php
					break;


				case "기업형태":
		?>
		<li class="row19">
			<label for="co_type2">기업형태<?=$_check;?></label>
			<select id="co_type2" name="mb_biz_form" hname="기업형태" <?=$_required;?>>
				<option value="">기업형태 선택</option>
				<?php
				if(is_array($_cate_['biz_form'])) { foreach($_cate_['biz_form'] as $k=>$v) {
					$selected = $member_com['mb_biz_form']==$v['code'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
			</select>
		</li>
		<?php
					break;


				case "주요사업내용":
		?>
		<li class="row20">
			<label for="business">주요사업<?=$_check;?></label>
			<input type="text" id="business" name="mb_biz_content" hname="주요사업" <?=$_required;?> value="<?=$_html_c['mb_biz_content'];?>" maxlength="">
			<div>(예:네트워크 트래픽 관리제품 개발 및 판매)</div>
		</li>
		<?php
					break;


				case "설립연도":
		?>
		<li class="row21">
			<label for="year">설립년도<?=$_check;?></label>
			<select id="year" name="mb_biz_foundation" hname="설립년도" <?=$_required;?>>
				<option value="">선택</option>
				<?php
				for($i=date('Y');$i>=1900;--$i){
					$selected = $member_com['mb_biz_foundation']==$i ? 'selected' : '';
				?>
				<option value="<?=$i;?>" <?=$selected;?>><?=$i;?>년</option>
				<?php
				}
				?>
			</select>
		</li>
		<?php
					break;


				case "사원수":
		?>
		<li class="row22">
			<label for="employee">사원수<?=$_check;?></label>
			<input type="text" id="employee" name="mb_biz_member_count" hname="사원수" <?=$_required;?> value="<?=$_html_c['mb_biz_member_count'];?>" maxlength="">명
		</li>
		<?php
					break;


				case "자본금":
		?>
		<li class="row23">
			<label for="capital">자본금<?=$_check;?></label>
			<input type="text" id="capital" name="mb_biz_stock" hname="자본금" <?=$_required;?> value="<?=$_html_c['mb_biz_stock'];?>" maxlength="">원
		</li>
		<?php
					break;


				case "매출액":
		?>
		<li class="row24">
			<label for="sales">매출액<?=$_check;?></label>
			<input type="text" id="sales" name="mb_biz_sale" hname="매출액" <?=$_required;?> value="<?=$_html_c['mb_biz_sale'];?>" maxlength="">원
		</li>
		<?php
					break;


				case "기업개요 및 비전":
		?>
		<li class="row25">
			<span>기업개요 및 비전<?=$_check;?></span>
			<textarea type="editor" name="mb_biz_vision" style="width:100%;height:250px;" hname="기업개요 및 비전" <?=$_required;?>><?=stripslashes($member_com['mb_biz_vision']);?></textarea>
		</li>
		<?php
					break;


				case "기업연혁 및 실적":
		?>
		<li class="row26">
			<span>기업연혁 및 실적<?=$_check;?></span>
			<textarea type="editor" name="mb_biz_result" style="width:100%;height:250px;"  hname="기업연혁 및 실적" <?=$_required;?>><?=stripslashes($member_com['mb_biz_result']);?></textarea>
		</li>
		<?php
					break;
			}
		} }
		?>


		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	</ul>
</section>