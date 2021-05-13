<?php
$editor_use = true;
$menu_code = 'text';
$head_title = $menu_text = '고객센터';
include_once "../include/top.php";

$hphone_num = explode("-", $member['mb_hphone']);
$phone_num = explode("-", $member['mb_phone']);
?>
<script type="Text/javascript">
var write_click = function() {
	var form = document.forms['fwrite'];
	var _key = $(form).find("[name='wr_key']").val();

	if(chk = $("[name='agree_chk']:checked").val()!='Y') {
		alert("개인정보 취급방침에 동의해주시기 바랍니다.");
		return;
	}

	if(validate(form)) {
		$.post("<?=NFE_URL;?>/regist.php", "mode=rand_num_check&word="+_key, function(data){
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			else {
				netfu_util1.ajax_submit(form);
				return false;
			}
		});
	}
}


var email_sel = function( vals ){	// 이메일 서비스 선택
	$("[name='wr_email[]']").eq(1).val(vals.value);
}
</script>
<style>
.customer_center input[type="radio"]{width:15px;top:0;background:#fff !important}
</style>
<form name="fwrite" action="<?=NFE_URL;?>/regist.php" method="post">
<section class="cont_box service_con register_con">
<h2>개인정보 취급방침</h2>
<div class="text_box terms tbx_h">
	<?=stripslashes($env['site_privacy']);?>
</div>

<input type="hidden" name="mode" value="cs_center_write" />
<div class="radio_group2">
	<label for="agree"><input type="radio" id="agree" name="agree_chk" value="Y">동의합니다.</label>
	<label for="disagree"><input type="radio" id="disagree" name="agree_chk" value="N">동의하지 않습니다.</label>
</div>
</section>

<section class="cont_box customer_center">
<h2>고객센터</h2>
<ol class="info3_con">
	<li>· 문의사항, 불편사항 및 기타의견을 보내주시면 담당자가 확인후 연락드리겠습니다.</li>
	<li>· 의견을 보내실 때는 <span class="check"></span>표시는 필수 입력사항이니 꼭 입력하여 보내주시기 바랍니다.</li>
</ol>
<ul class="info_con">
	<li class="row2">
		<label>분류<span class="check"></span></label>
		<?php 
			$cs_category = $category_control->__CategoryList("on2on");	// 고객센터 분류
			foreach($cs_category as $val){ 
			$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
		?>
			<input type="radio" class="chk selt_chk" name="wr_cate" id="wr_cate_<?php echo $val['code'];?>" value="<?php echo $val['code'];?>" hname="문의분류" required option="radio" /> <label class="selt_chk_txt" for="wr_cate_<?php echo $val['code'];?>"><?php echo $name;?></label>
		<?php } ?>
	</li>
	<li class="row2">
		<label>이름<span class="check"></span></label>
		<input type="text" name="wr_name" value="<?=$member['mb_name'];?>" hname="이름" required maxlength="41">
	</li>
	<li class="row3">
		<fieldset>
			<legend>휴대폰<span class="check"></span></legend>
			<select name="wr_hphone[]" hname="휴대폰 국번" required option="select">
			<option value="">국번</option>
			<?php echo $hp_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" maxlength="4" name="wr_hphone[]" hname="휴대폰 앞자리" required value="<?php echo $hphone_num[1];?>" class="cel1 phone1">
			<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" hname="휴대폰 뒷자리" required value="<?php echo $hphone_num[2];?>" class="cel2 ">
		</fieldset>
	</li>
	<li class="row4">
		<fieldset>
			<legend>전화번호</legend>
			<select name="wr_phone[]" hname="전화번호 국번">
			<option value="">국번</option>
			<?php echo $tel_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" maxlength="4" name="wr_phone[]" hname="전화번호 앞자리" value="<?php echo $phone_num[1];?>" class="tel1 phone2">
			<p>-</p><input type="tel" size="4" maxlength="4" maxlength="4" name="wr_phone[]" hname="전화번호 뒷자리" value="<?php echo $phone_num[2];?>" class="tel2 ">
		</fieldset>
	</li>
	<li class="row5">
		<fieldset>
			<legend>이메일<span class="check"></span></legend>
			<input type="tel" name="wr_email[]" hname="이메일" required value="<?php echo $mb_email[0];?>" class="email">
			<p>@</p><input type="tel" name="wr_email[]" value="<?php echo $mb_email[1];?>" class="email">
			<select onchange="email_sel(this);">
			<option value="">직접입력</option>
			<?php echo $email_option; ?>
			</select>
		</fieldset>
	</li>
	<li class="row6">
		<label for="homepage">홈페이지</label>
		<p>http://</p><input type="text" name="wr_site" value="<?php echo $utility->remove_http($member['mb_homepage']);?>" class="homepage">
	</li>
	<li class="row7">
		<label for="title">제목<span class="check"></span></label>
		<input type="text" name="wr_subject" hname="제목" required>
	</li>
	<li class="row8">
		<span style="color:#75809a;">내용<span class="check"></span></span>
		<div style="height:5px;width:100%"></div>
		<textarea type="editor" name="wr_content" hname="내용" required style="padding-top:10px;width:100%;height:200px;"></textarea>
	</li>
	<?php
	if(!$member['mb_id']) {
	?>
	<li class="row9">
		<label for="capcha">자동등록방지</label>
			<div class="capcha_group">
			<div><span class="reply_rand_text"><img src="<?=NFE_URL;?>/include/rand_text.php" /></span></div>
				<input type="text" name="wr_key" hname="자동등록방지" required><p>자동등록방지 숫자를 입력하세요.</p>
			<div>
	</li>
	<?php }?>
</ul>
</section>

<div class="button_con">
	<a class="bottom_btn01" onClick="write_click()">등록하기</a><a href="#" class="bottom_btn02">돌아가기</a>
</div>
</form>

<?php
include_once(NFE_PATH.'/include/tail.php');
?>