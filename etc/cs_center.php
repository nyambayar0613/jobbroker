<?php
$editor_use = true;
$menu_code = 'text';
$head_title = $menu_text = 'Хэрэглэгчийн төв';
include_once "../include/top.php";

$hphone_num = explode("-", $member['mb_hphone']);
$phone_num = explode("-", $member['mb_phone']);
?>
<script type="Text/javascript">
var write_click = function() {
	var form = document.forms['fwrite'];
	var _key = $(form).find("[name='wr_key']").val();

	if(chk = $("[name='agree_chk']:checked").val()!='Y') {
		alert("Нууцлалын бодлогыг зөвшөөрнө үү.");
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
<h2>Нууцлалын мэдэгдэл</h2>
<div class="text_box terms tbx_h">
	<?=stripslashes($env['site_privacy']);?>
</div>

<input type="hidden" name="mode" value="cs_center_write" />
<div class="radio_group2">
	<label for="agree"><input type="radio" id="agree" name="agree_chk" value="Y">Зөвшөөрч байна.</label>
	<label for="disagree"><input type="radio" id="disagree" name="agree_chk" value="N">Зөвшөөрөхгүй.</label>
</div>
</section>

<section class="cont_box customer_center">
<h2>Хэрэглэгчийн төв</h2>
<ol class="info3_con">
	<li>· 문의사항, 불편사항 및 기타의견을 보내주시면 담당자가 확인후 연락드리겠습니다.</li>
	<li>· 의견을 보내실 때는 <span class="check"></span>표시는 필수 입력사항이니 꼭 입력하여 보내주시기 바랍니다.</li>
</ol>
<ul class="info_con">
	<li class="row2">
		<label>Төрөл<span class="check"></span></label>
		<?php 
			$cs_category = $category_control->__CategoryList("on2on");	// 고객센터 분류
			foreach($cs_category as $val){ 
			$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
		?>
			<input type="radio" class="chk selt_chk" name="wr_cate" id="wr_cate_<?php echo $val['code'];?>" value="<?php echo $val['code'];?>" hname="Лавлагааны төрөл" required option="radio" /> <label class="selt_chk_txt" for="wr_cate_<?php echo $val['code'];?>"><?php echo $name;?></label>
		<?php } ?>
	</li>
	<li class="row2">
		<label>Нэр<span class="check"></span></label>
		<input type="text" name="wr_name" value="<?=$member['mb_name'];?>" hname="Нэр" required maxlength="41">
	</li>
	<li class="row3">
		<fieldset>
			<legend>Утас<span class="check"></span></legend>
			<select name="wr_hphone[]" hname="Дугаар" required option="select">
			<option value="">Улсын дугаар</option>
			<?php echo $hp_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" maxlength="4" name="wr_hphone[]" hname="Урд хэсэг" required value="<?php echo $hphone_num[1];?>" class="cel1 phone1">
			<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" hname="Хойд хэсэг" required value="<?php echo $hphone_num[2];?>" class="cel2 ">
		</fieldset>
	</li>
	<li class="row4">
		<fieldset>
			<legend>Утасны дугаар</legend>
			<select name="wr_phone[]" hname="Утасны дугаар">
			<option value="">Улсын дугаар</option>
			<?php echo $tel_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" maxlength="4" name="wr_phone[]" hname="Урд хэсэг" value="<?php echo $phone_num[1];?>" class="tel1 phone2">
			<p>-</p><input type="tel" size="4" maxlength="4" maxlength="4" name="wr_phone[]" hname="Хойд хэсэг" value="<?php echo $phone_num[2];?>" class="tel2 ">
		</fieldset>
	</li>
	<li class="row5">
		<fieldset>
			<legend>И-мэйл<span class="check"></span></legend>
			<input type="tel" name="wr_email[]" hname="И-мэйл" required value="<?php echo $mb_email[0];?>" class="email">
			<p>@</p><input type="tel" name="wr_email[]" value="<?php echo $mb_email[1];?>" class="email">
			<select onchange="email_sel(this);">
			<option value="">мэйл</option>
			<?php echo $email_option; ?>
			</select>
		</fieldset>
	</li>
	<li class="row6">
		<label for="homepage">Вэб сайт</label>
		<p>http://</p><input type="text" name="wr_site" value="<?php echo $utility->remove_http($member['mb_homepage']);?>" class="homepage">
	</li>
	<li class="row7">
		<label for="title">Гарчиг<span class="check"></span></label>
		<input type="text" name="wr_subject" hname="Гарчиг" required>
	</li>
	<li class="row8">
		<span style="color:#75809a;">Агуулга<span class="check"></span></span>
		<div style="height:5px;width:100%"></div>
		<textarea type="editor" name="wr_content" hname="Агуулга" required style="padding-top:10px;width:100%;height:200px;"></textarea>
	</li>
	<?php
	if(!$member['mb_id']) {
	?>
	<li class="row9">
		<label for="capcha">Автомат бүртгэлээс урьдчилан сэргийлэх</label>
			<div class="capcha_group">
			<div><span class="reply_rand_text"><img src="<?=NFE_URL;?>/include/rand_text.php" /></span></div>
				<input type="text" name="wr_key" hname="Автомат бүртгэлээс сэргийлэх" required><p>Автомат бүртгэлээс урьдчилан сэргийлэхийн тулд дугаараа оруулна уу</p>
			<div>
	</li>
	<?php }?>
</ul>
</section>

<div class="button_con">
	<a class="bottom_btn01" onClick="write_click()">Бүртгүүлэх</a><a href="#" class="bottom_btn02">Буцах</a>
</div>
</form>

<?php
include_once(NFE_PATH.'/include/tail.php');
?>