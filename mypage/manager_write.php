<?php
$page_code = 'mypage';
include_once "../include/top.php";

$q = "select * from alice_company_manager where `wr_id` = '".$member['mb_id']."' and `no`='".addslashes($_GET['no'])."'";
$manager_row = sql_fetch($q);

$_phone = explode("-", $manager_row['wr_phone']);
$_hphone = explode("-", $manager_row['wr_hphone']);
$_fax = explode("-", $manager_row['wr_fax']);
$_email = explode("@", $manager_row['wr_email']);

$tel_num_option = $config->get_tel_num($_phone[0]);	 // 전화번호 국번
$hp_num_option = $config->get_hp_num($_hphone[0]);	 // 휴대폰번호 국번
$fax_num_option = $config->get_tel_num($_fax[0]);	 // 전화번호 국번
$email_option = $config->get_email();	 // 이메일 서비스 제공자
?>

<section class="cont_box detail_con">
<?php
include NFE_PATH.'/include/inc/my_company_info.inc.php';

include NFE_PATH.'/include/inc/my_company_count.inc.php';
?>
</section>

<!-- 구인담당자 추가 -->
<form name="fwrite" action="../regist.php" method="post" onSubmit="return validate(this)">
<input type="hidden" name="mode" value="company_manager_write" />
<input type="hidden" name="no" value="<?=$manager_row['no'];?>" />
<section id="manager_write" class="cont_box add2_info">
	<h2>Ажилд авах хүний ​​мэдээллийг оруулна уу</h2>
	<ul class="info3_con">
		<li class="row1">
			<label for="manager_name">Нэр<span class="check"></span></label>
			<input type="text" name="wr_name" hname="Нэр" required value="<?=$manager_row['wr_name'];?>">
		</li>
		<li class="row2">
			<fieldset>
				<legend>Утасны дугаар</legend>
				<select name="wr_hphone[]">
				<?php echo $hp_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" hname="Утасны дугаар"  value="<?=$_hphone[1];?>" class="cel1 phone1">
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" hname="Утасны дугаар"  value="<?=$_hphone[2];?>" class="cel2 ">
			</fieldset>
		</li>
		<li class="row3">
			<fieldset>
				<legend>Холбоо барих<span class="check"></span></legend>
					<select name="wr_phone[]">
					<?php echo $tel_num_option; ?>
					</select>
					<p>-</p><input type="tel" size="4" maxlength="4" name="wr_phone[]" hname="Холбоо барих" required value="<?=$_phone[1];?>" class="tel1 phone2">
					<p>-</p><input type="tel" size="4" maxlength="4" name="wr_phone[]" hname="Холбоо барих" required value="<?=$_phone[2];?>" class="tel2 ">
			</fieldset>
		</li>
		<li class="row4">
			<fieldset>
				<legend>Шуудангын дугаар</legend>
					<select name="wr_fax[]">
					<?php echo $fax_num_option; ?>
					</select>
					<p>-</p><input type="tel" size="4" maxlength="4" name="wr_fax[]" hname="Шуудангын дугаар"  value="<?=$_fax[1];?>" class="fax1 phone2">
					<p>-</p><input type="tel" size="4" maxlength="4" name="wr_fax[]" hname="Шуудангын дугаар"  value="<?=$_fax[2];?>" class="fax2 ">
			</fieldset>
		</li>
		<li class="row5">
			<fieldset>
				<legend>И-мэйл<span class="check"></span></legend>
				<input type="text" name="wr_email[]" value="<?=$_email[0];?>" hname="И-мэйл" required class="И-мэйл">
				<p>@</p><input type="text" name="wr_email[]" value="<?=$_email[1];?>" hname="И-мэйл" required class="И-мэйл">
				<select onChange="netfu_util1.email_put(this)">
				<option value="">мэйл</option>
				<?php echo $email_option; ?>
				</select>
			</fieldset>
		</li>
</section>

<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="netfu_util1.ajax_submit(document.forms['fwrite'])"><?=$manager_row ? 'Өөрчлөх' : 'Хадгадах';?></a><a href="#" class="bottom_btn02" onClick="document.forms['fwrite'].reset()">Цуцлах</a>
</div>
</form>

<?php
include "../include/tail.php";
?>