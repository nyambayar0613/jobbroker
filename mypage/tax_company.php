<?php
$editor_use = true;
$page_code = 'mypage';
$head_title = $menu_text = "Татварын нэхэмжлэх гаргах өргөдөл";
include "../include/top.php";

$_biz_no = explode("-", $member_com['mb_biz_no']);
$_mb_email = explode("@", $member_com['mb_biz_email']);
$_mb_biz_phone = explode("-", $member_com['mb_biz_phone']);
$tel_num_option = $config->get_tel_num($_mb_biz_phone[0]);
?>

<form name="fwrite" action="../regist.php" method="post">
<input type="hidden" name="mode" value="tax_write" />
<section class="cont_box taxbill_con">
	<h2>Татварын нэхэмжлэх гаргах өргөдөл</h2>
	<ol class="info3_con">
		<li>1. Төлбөртэй үйлчилгээнд хамрагдсаны дараа хүсэлтийн дагуу татварын нэхэмжлэх гаргана. Мөн төлбөрийг бүрэн хийж дууссаны дараа татварын нэхэмжлэхийг өгөх болно гэдгийг анхаарна уу.</li>
		<li>2. <span class="check"></span> тэмдэгтийг заавал оруулах шаардлагатай.</li>
	</ol>
	<ul class="info3_con">
		<li class="row1">
			<fieldset>
				<legend>Бизнесийн эхрлэгчийн дугаар<span class="check"></span></legend>
				<input type="text" id="" name="wr_biz_no[]" value="<?=$_biz_no[0];?>">
				<p>-</p>
				<input type="text" id="" name="wr_biz_no[]" value="<?=$_biz_no[1];?>">
				<p>-</p>
				<input type="text" id="" name="wr_biz_no[]" value="<?=$_biz_no[2];?>">
			</fieldset>
		</li>
		<li class="row2">
			<label for="company">Байгууллагын дугаар<span class="check"></span></label>
			<input type="text" id="company" name="wr_company_name" value="<?=$member_com['mb_company_name'];?>">
		</li>
		<li class="row3">
			<label for="ceo">Захирлын нэр<span class="check"></span></label>
			<input type="text" id="ceo" name="wr_ceo_name" value="<?=$member_com['mb_ceo_name'];?>">
		</li>
		<li class="row4">
			<?php
			include NFE_PATH.'/include/inc/post.inc.php';
			?>
			<fieldset>
				<legend>Хаяг<span class="check"></span></legend>
				<input type="text" size="4" maxlength="4" id="mb_doro_post" name="wr_doro" value="<?=$member_com['mb_biz_doro_post'];?>" class="post">
				<input type="text" maxlength="" id="mb_address0" name="wr_address0" value="<?=$member_com['mb_biz_address0'];?>" class="address1">
				<button type="botton" class="form_bt form_bt2" onClick="post_click(); return false;">Шуудангын дугаар</button>
				<div class="cf">
				 <input type="text" id="" name="wr_address1" value="<?=$member_com['mb_biz_address1'];?>" class="address2" placeholder="Дэлгэрэнгүй хаягаа оруулна уу.">
				</div>
			</fieldset>
		</li>
		<li class="row5">
			<label for="types">업태<span class="check"></span></label>
			<input type="text" id="types" name="wr_condition">
		</li>
		<li class="row6">
			<label for="items">종목</label>
			<input type="text" id="items" name="wr_item">
		</li>
		<li class="row7">
			<fieldset>
				<legend>И-мэйл<span class="check"></span></legend>
					<input type="tel" name="wr_email[]" value="<?=$_mb_email[0];?>" class="email">
					<p>@</p><input type="tel" name="wr_email[]" value="<?=$_mb_email[1];?>" id="put_email" class="email">
					<select onChange="netfu_util1.put_text(this, $('#put_email'))">
						<option value="">мэйл</option>
						<?php echo $email_option; ?>
					</select>
			</fieldset>
		</li>
		<li class="row8">
			<label for="types">Хариуцагчын нэр<span class="check"></span></label>
			<input type="text" id="types" name="wr_manager">
		</li>
		<li class="row9">
			<fieldset>
				<legend>Холбоо барих<span class="check"></span></legend>
				<select name="wr_phone[]">
					<?php echo $tel_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_phone[]" value="<?=$_mb_biz_phone[1];?>" class="cel1 phone1">
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_phone[]" value="<?=$_mb_biz_phone[2];?>" class="cel2 ">
			</fieldset>					  
		</li>
		<li class="row10">
		  <fieldset>
				<legend>Төлбөр хийсэн огноо<span class="check"></span></legend>
				<input type="text" name="wr_pay_date" class="datepicker_inp" readOnly value="<?=$_get['pay_sdate'];?>">
			</fieldset>
		</li>
		<li class="row11">
			<label for="pay">Төлбөрийн хэмжээ<span class="check"></span></label>
			<input type="text" id="pay" name="wr_price"> төгрөг
		</li>
		<li class="row12">
			Агуулга
		  <textarea type="editor" rows="9" name="wr_content" hname="Агуулга" required></textarea>
		</li>
	</ul>
</section>

<div class="button_con">
	<a href="#none" class="bottom_btn01" onClick="netfu_util1.ajax_submit(document.forms['fwrite'])">Хүсэлт гаргах</a><a href="#" class="bottom_btn02">Цуцлах</a>
</div>
</form>

<?php
include "../include/tail.php";
?>