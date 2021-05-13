<?php
$editor_use = true;
$menu_code = 'text';
$head_title = $menu_text = '제휴문의';
include_once "../include/top.php";

$hphone_num = explode("-", $member['mb_hphone']);
$phone_num = explode("-", $member['mb_phone']);

$concert_cate = $netfu_util->get_cate_array('concert');
?>
<script type="text/javascript">
var concert_submit = function() {
	var form = document.forms['fwrite'];
	var _key = form.wr_key ? form.wr_key.value : ''
	if(validate(form)) {
		$.post(base_url+"/regist.php", "mode=rand_num_check&word="+_key, function(data){
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			else netfu_util1.ajax_submit(form);
		});
	}
	return;
}
</script>
<style>
.partner_con input[type="radio"]{width:20px;height:auto}
</style>
<section class="cont_box partner_con ">
<h2>제휴문의</h2>
<ol class="info3_con">
	<li>· 성공적인 비즈니스 사업을 위하여 귀사의 소중한 의견이나 제안을 받습니다.</li>
	<li>· 한번 등록한 내용은 수정이 불가능합니다.</li>
</ol>

<form name="fwrite" action="<?=NFE_URL;?>/regist.php" method="post">
<input type="hidden" name="mode" value="concert_insert"/>
<input type="hidden" name="ajax" value="1"/>
<input type="hidden" name="wr_type" value="2"/>
<ul class="info_con">
	<li class="row1">
		<fieldset>
			<legend>제휴문의<span class="check"></span></legend>
			<ul>
				<?php
				$count = 0;
				if(is_array($concert_cate)) { foreach($concert_cate as $k=>$v) {
				?>
				<li class="item0<?=$count+1;?>"><input type="radio" name="wr_cate" value="<?=$v['code'];?>"> <?=$v['name'];?></li>
				<?php
					$count++;
				} }
				?>
			</ul>
		</fieldset>
	</li>
	<li class="row2">
	<label for="manager">담당자명<span class="check"></span></label>
		<input type="text" id="manager" name="wr_name" maxlength="41" hname="담당자명" required>
	</li>
	<li class="row3">
		<label for="company">회사명<span class="check"></span></label>
		<input type="text" id="company" name="wr_biz_name" hname="회사명" required>
	</li>
	<li class="row3">
		<fieldset>
		<legend>휴대폰<span class="check"></span></legend>
			<select name="wr_hphone[]">
				<option value="">국번</option>
				<?php echo $hp_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" id="" name="wr_hphone[]" hname="휴대폰 앞자리" required value="<?php echo $hphone_num[1];?>" class="cel1 phone1">
			<p>-</p><input type="tel" size="4" maxlength="4" id="" name="wr_hphone[]" hname="휴대폰 뒷자리" required value="<?php echo $hphone_num[2];?>" class="cel2 ">
		</fieldset>
	</li>
	<li class="row4">
		<fieldset>
		<legend>전화번호</legend>
			<select name="wr_phone[]">
				<option value="">국번</option>
				<?php echo $tel_num_option; ?>
			</select>
		<p>-</p><input type="tel" size="4" maxlength="4" id="" name="wr_phone[]" hname="전화번호 앞자리" value="<?php echo $phone_num[1];?>" class="tel1 phone2">
		<p>-</p><input type="tel" size="4" maxlength="4" id="" name="wr_phone[]" hname="전화번호 뒷자리" value="<?php echo $phone_num[2];?>" class="tel2 ">
		</fieldset>
	</li>
	<li class="row_con">
		<label for="business">주요사업<span class="check"></span></label>
		<input type="text" id="business" name="wr_biz">
	</li>
	<li class="row_con">
		<label for="partner">제휴부분<span class="check"></span></label>
			<input type="text" id="partner" name="wr_biz_type">
		</li>
		<li class="row5">
			<fieldset>
			<legend>이메일<span class="check"></legend>
			<input type="tel" name="wr_email[]" hname="이메일" required value="<?php echo $mb_email[0];?>" class="email">
			<p>@</p><input type="tel" name="wr_email[]" id="mb_email_put" value="<?php echo $mb_email[1];?>" class="email">
			<select onChange="netfu_util1.put_text(this, $('#mb_email_put'))">
				<option value="">직접입력</option>
				<?php echo $email_option; ?>
			</select>
			</fieldset>
		</li>
		<li class="row6">
			<label for="homepage">홈페이지</label>
			<p>http://</p><input type="text" id="homepage"  name="wr_site" value="<?php echo $utility->remove_http($member['mb_homepage']);?>" class="homepage">
		</li>
		<li class="row7">
			<label for="title">제목<span class="check"></span></label>
			<input type="text" id="title" name="wr_subject" hname="제목" required>
		</li>
		<li class="row8">
			내용<span class="check"></span>
			<textarea type="editor" name="wr_content" hname="내용" required style="width:100%;height:200px;"></textarea>
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
</form>
</section>

<div class="button_con">
<a href="#none;" onClick="concert_submit()" class="bottom_btn01">등록하기</a><a href="#" class="bottom_btn02">돌아가기</a>
</div>

<?php
include_once(NFE_PATH.'/include/tail.php');
?>