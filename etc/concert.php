<?php
$editor_use = true;
$menu_code = 'text';
$head_title = $menu_text = 'Түншлэлийн лавлагаа';
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
<h2>Түншлэлийн лавлагаа</h2>
<ol class="info3_con">
	<li>· Бизнесийн үйл ажиллагааг амжилттай явуулах талаар таны үнэтэй санал, зөвлөмжийг бид хүлээж авах болно.</li>
	<li>· Бүртгүүлсний дараа засварлах боломжгүй.</li>
</ol>

<form name="fwrite" action="<?=NFE_URL;?>/regist.php" method="post">
<input type="hidden" name="mode" value="concert_insert"/>
<input type="hidden" name="ajax" value="1"/>
<input type="hidden" name="wr_type" value="2"/>
<ul class="info_con">
	<li class="row1">
		<fieldset>
			<legend>Түншлэлийн лавлагаа<span class="check"></span></legend>
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
	<label for="manager">Хариуцсан хүний нэр<span class="check"></span></label>
		<input type="text" id="manager" name="wr_name" maxlength="41" hname="Хариуцагчын нэр" required>
	</li>
	<li class="row3">
		<label for="company">Байгууллагын нэр<span class="check"></span></label>
		<input type="text" id="company" name="wr_biz_name" hname="Байгууллагын нэр" required>
	</li>
	<li class="row3">
		<fieldset>
		<legend>Утсаны дугаар<span class="check"></span></legend>
			<select name="wr_hphone[]">
				<option value="">Улсын дугаар</option>
				<?php echo $hp_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" id="" name="wr_hphone[]" hname="Эхний цифр" required value="<?php echo $hphone_num[1];?>" class="cel1 phone1">
			<p>-</p><input type="tel" size="4" maxlength="4" id="" name="wr_hphone[]" hname="Сүүлийн цифр" required value="<?php echo $hphone_num[2];?>" class="cel2 ">
		</fieldset>
	</li>
	<li class="row4">
		<fieldset>
		<legend>Хол</legend>
			<select name="wr_phone[]">
				<option value="">Улсын дугаар</option>
				<?php echo $tel_num_option; ?>
			</select>
		<p>-</p><input type="tel" size="4" maxlength="4" id="" name="wr_phone[]" hname="Эхний цифр" value="<?php echo $phone_num[1];?>" class="tel1 phone2">
		<p>-</p><input type="tel" size="4" maxlength="4" id="" name="wr_phone[]" hname="Сүүлийн цифр" value="<?php echo $phone_num[2];?>" class="tel2 ">
		</fieldset>
	</li>
	<li class="row_con">
		<label for="business">Явуулдаг үйл ажиллагаа<span class="check"></span></label>
		<input type="text" id="business" name="wr_biz">
	</li>
	<li class="row_con">
		<label for="partner">Түншлэлийн хэсэг<span class="check"></span></label>
			<input type="text" id="partner" name="wr_biz_type">
		</li>
		<li class="row5">
			<fieldset>
			<legend>И-мэйл<span class="check"></legend>
			<input type="tel" name="wr_email[]" hname="И-мэйл" required value="<?php echo $mb_email[0];?>" class="email">
			<p>@</p><input type="tel" name="wr_email[]" id="mb_email_put" value="<?php echo $mb_email[1];?>" class="email">
			<select onChange="netfu_util1.put_text(this, $('#mb_email_put'))">
				<option value="">мэйл</option>
				<?php echo $email_option; ?>
			</select>
			</fieldset>
		</li>
		<li class="row6">
			<label for="homepage">Вэб сайт</label>
			<p>http://</p><input type="text" id="homepage"  name="wr_site" value="<?php echo $utility->remove_http($member['mb_homepage']);?>" class="homepage">
		</li>
		<li class="row7">
			<label for="title">Гарчиг<span class="check"></span></label>
			<input type="text" id="title" name="wr_subject" hname="Гарчиг" required>
		</li>
		<li class="row8">
			Агуулга<span class="check"></span>
			<textarea type="editor" name="wr_content" hname="Агуулга" required style="width:100%;height:200px;"></textarea>
		</li>
		<?php
		if(!$member['mb_id']) {
		?>
		<li class="row9">
			<label for="capcha">Автомат бүртгэлээс сэргийлэх</label>
			<div class="capcha_group">
			<div><span class="reply_rand_text"><img src="<?=NFE_URL;?>/include/rand_text.php" /></span></div>
				<input type="text" name="wr_key" hname="Автомат бүртгэлээс сэргийлэх" required><p>Автомат бүртгэлээс урьдчилан сэргийлэхийн тулд дугаараа оруулна уу.</p>
			<div>
		</li>
		<?php }?>
	</ul>
</form>
</section>

<div class="button_con">
<a href="#none;" onClick="concert_submit()" class="bottom_btn01">Бүртгүүлэх</a><a href="#" class="bottom_btn02">Орох</a>
</div>

<?php
include_once(NFE_PATH.'/include/tail.php');
?>