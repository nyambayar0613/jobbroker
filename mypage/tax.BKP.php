<?php
$page_code = 'mypage';
$head_title = $menu_text = "현금영수증 발행신청";
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
	<h2>현금영수증 발생신청</h2>
	<ol class="info3_con">
		<li>1. 유료서비스 신청후 현금영수증 발행신청시 발행해드리고 있습니다. 단, 결제완료 후 현금영수증이 발행되오니 이 점 숙지하시기 바랍니다.</li>
		<li style="margin-bottom:0">2. <span class="check"></span>표시는 필수 입력사항입니다.</li>
	</ol>
	<ul class="info3_con">
		<li class="row1">
			<label for="resume_tit">신청자명<span class="check"></span></label>
			<input type="text" id="resume_tit" name="wr_name" value="<?=$member['mb_name'];?>">
		</li>  
		<li class="row3">
			<fieldset>
				<legend>휴대폰<span class="check"></span></legend>
				<select name="wr_hphone[]" hname="국번">
				<?php echo $hp_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" value="<?=$_hphone[1];?>" class="cel1 phone1">
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" value="<?=$_hphone[2];?>" class="cel2 ">
			</fieldset>
		</li>
		<li class="row4">
			<fieldset>
			<legend>이메일<span class="check"></span></legend>
				<input type="text" name="wr_email[]" value="<?=$_email[0];?>" class="email">
				<p>@</p><input type="text" name="wr_email[]" value="<?=$_email[1];?>" class="email">
				<select onChange="email_put(this)">
					<option value="">직접입력</option>
					<?php echo $email_option; ?>
				</select>
			</fieldset>
		</li>
		<li class="row5">
			<fieldset>
				<legend>결제일자<span class="check"></span></legend>
				<input type="text" name="wr_pay_date" readOnly class="datepicker_inp paymindt" readOnly value="<?=$_get['pay_sdate'];?>">
			</fieldset>
		</li>
		<li class="row6">
			<label for="pay">결제금액</label>
			<input class="paymin" type="text" name="wr_price">원
		</li>
		<li class="row7">
			<label>내용</label>
			<textarea name="wr_content"></textarea>
		</li>
	</ul>
</section>

<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="netfu_util1.ajax_submit(document.forms['fwrite'])">신청하기</a><a href="#none;" class="bottom_btn02" onClick="document.forms['fwrite'].reset()">취소</a>
</div>
</form>

<?php
include "../include/tail.php";
?>