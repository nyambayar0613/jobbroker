<?php
$page_code = 'mypage';
$head_title = $menu_text = "Бэлэн мөнгөний баримт олгох";
$menu_code = 'text';
include "../include/top.php";

$_hphone = explode("-", $member['mb_hphone']);
$_email = explode("@", $member['mb_email']);
?>
<script type="text/javascript">
var email_put = function(el) {
	var form = document.forms['fwrite'];
	$(form).find("[name='wr_email[]']").eq(1).val(el.value);
}
</script>
<form name="fwrite" action="../regist.php" method="post">
<input type="hidden" name="mode" value="tax_write" />
<section class="cont_box receipt_con">
	<h2>Бэлэн мөнгөний баримт хүсэлт</h2>
	<ol class="info3_con">
		<li>1. Төлбөртэй үйлчилгээнд хамрагдаж, баримт олгох хүсэлт гаргасны дараа олгогдоно. Гэхдээ төлбөрийг бүрэн хийж дууссаны дараа бэлэн мөнгөний баримт авах боломжтой.</li>
		<li style="margin-bottom:0">2. <span class="check"></span>оруулах шаардлагатай.</li>
	</ol>
	<ul class="info3_con">
		<li class="row1">
			<label for="resume_tit">Хүсэлт гаргагчын нэр<span class="check"></span></label>
			<input type="text" id="resume_tit" name="wr_name" value="<?=$member['mb_name'];?>">
		</li>  
		<li class="row3">
			<fieldset>
				<legend>Утсаны дугаар<span class="check"></span></legend>
				<select name="wr_hphone[]" hname="Улсын дугаар">
				<?php echo $hp_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" value="<?=$_hphone[1];?>" class="cel1 phone1">
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" value="<?=$_hphone[2];?>" class="cel2 ">
			</fieldset>
		</li>
		<li class="row4">
			<fieldset>
			<legend>И-мэйл<span class="check"></span></legend>
				<input type="text" name="wr_email[]" value="<?=$_email[0];?>" class="email">
				<p>@</p><input type="text" name="wr_email[]" value="<?=$_email[1];?>" class="email">
				<select onChange="email_put(this)">
					<option value="">мэйл</option>
					<?php echo $email_option; ?>
				</select>
			</fieldset>
		</li>
		<li class="row5">
			<fieldset>
				<legend>Төлбөрийн огноо<span class="check"></span></legend>
				<input type="text" name="wr_pay_date" readOnly class="datepicker_inp paymindt" readOnly value="<?=$_get['pay_sdate'];?>">
			</fieldset>
		</li>
		<li class="row6">
			<label for="pay">Төлбөрийн хэмжээ</label>
			<input class="paymin" type="text" name="wr_price">원
		</li>
		<li class="row7">
			<label>Агуулга</label>
			<textarea name="wr_content"></textarea>
		</li>
	</ul>
</section>

<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="netfu_util1.ajax_submit(document.forms['fwrite'])">Өргөдөл гаргах </a><a href="#none;" class="bottom_btn02" onClick="document.forms['fwrite'].reset()">Цуцлах</a>
</div>
</form>

<?php
include "../include/tail.php";
?>