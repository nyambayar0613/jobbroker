<?php
// : 실명인증해서 넘어간 값은 _core.php에 합니다.
$_birth_arr = explode("-", $_mb_birth);
$_phone_arr = explode("-", $member['mb_phone']);
$_hphone_arr = explode("-", $_mb_hphone);
$_zipcode_arr = explode("-", $member['mb_zipcode']);
$_email_arr = explode("@", $member['mb_email']);
$_homepage_arr = parse_url($member['mb_homepage']);
$_homepage_val = $_homepage_arr['host'];
if($_homepage_arr['query']) $_homepage_val .= '?'.$_homepage_arr['query'];

if($member['mb_id']) $_SESSION['certify_info'] = "";
$basic_update = ''; //$member['mb_id'];
?>
<style>
.info1_con .row8 .smschk{clear:both;height:32px;line-height:32px;padding-left:23%;color:#666}
.info1_con .row8 .smschk input{margin-top:9px;width:20px;margin-right:5px;}
.info1_con .row11 .smschk{clear:both;height:32px;line-height:32px;padding-left:23%;color:#666}
.info1_con .row11 .smschk input{margin-top:9px;width:20px;margin-right:5px;}
</style>
<section class="cont_box join_con">
<h2>개인정보 <?=$member['mb_id'] ? '수정' : '가입';?></h2>
<ul class="info1_con">
	<li class="row1">
		<label for="member_id">아이디<span class="check"></span></label>
		<?php
		if($member['mb_id']) {
			echo $member['mb_id'];
		} else {
		?>
		<input type="text" id="member_id" name="mb_id" maxlength="41">
            <input type="hidden" name="member_check" id="member_check" value="" message="ID-гаа давхар шалгана уу." required nofocus style="display:none;" />
		<button type="button" class="form_bt" onClick="netfu_member.dupl_mid($('#member_id').val())">Шалгах</button>
		<?php }?>
	</li>
	<li class="row2">
		<label for="name">Нэр<span class="check"></span></label>
		<?php
		if($basic_update || $_SESSION['certify_info']) {
			echo $_mb_name;
			if($_member_write_input_view) {
			?>
			<input type="hidden" id="name" name="mb_name" value="<?=$_mb_name;?>" hname="Нэр" required maxlength="41">
			<?php
			}
		} else {
		?>
		<input type="text" id="name" name="mb_name" value="<?=$member['mb_name'];?>" hname="Нэр" required maxlength="41">
		<?php }?>
	</li>
	<?php
	if(!$member['mb_id']) {
	?>
	<li class="row3">
		<label for="pw">Нууц үг<span class="check"></span></label>
		<input type="password" id="pw" name="mb_password" hname="Нууц үг" option="userpw" required maxlength="16">
	</li>
	<li class="row4">
		<label for="pw2">Нууц үг батлах<span class="check"></span></label>
		<input type="password" id="pw2" name="mb_password_re" hname="Нууц үг батлах" matching="mb_password" option="userpw" required maxlength="16">
	</li>
	<?php }?>
	<li class="row5">
		<fieldset>
			<legend>Хүйс<span class="check"></span></legend>
			<?php
			if($basic_update || $_SESSION['certify_info']) {
				echo $netfu_util->gender_arr[$_mb_gender];
				if($_member_write_input_view) {
			?>
			<input type="hidden" name="mb_gender" value="<?=$_mb_gender;?>">
			<?php
				}
			?>
			<?php } else {?>
			<label for="male"><input type="radio" id="male" name="mb_gender" value="0" <?=$member['mb_gender']==0 ? 'checked' : '';?> checked>Эр</label>
			<label for="female"><input type="radio" id="female" name="mb_gender" value="1" <?=$member['mb_gender']==1 ? 'checked' : '';?>>Эм</label>
			<?php }?>
		</fieldset>
	</li>
	<li class="row6">
		<fieldset>
			<legend>Төрсөн огноо<span class="check"></span></legend>
			<?php
			if($basic_update || $_SESSION['certify_info']) {
				echo date("Y년 m월 d일", strtotime($_mb_birth));
				if($_member_write_input_view) {
			?>
			<input type="hidden" name="mb_birth_year" value="<?=$_birth_arr[0];?>" />
			<input type="hidden" name="mb_birth_month" value="<?=$_birth_arr[1];?>" />
			<input type="hidden" name="mb_birth_day" value="<?=$_birth_arr[2];?>" />
			<?php
				}
			} else {?>
			<select name="mb_birth_year" hname="он" required>
				<option value="">он</option>
				<?php
				for($i=date('Y')-15;$i>=1900;--$i){
					$selected = $_birth_arr[0]==$i ? 'selected' : '';
				?>
					<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
				<?php } ?>
			</select>
			<p>-</p>
			<select name="mb_birth_month" hname="сар" required>
				<option value="">сар</option>
				<?php
				for($i=1;$i<=12;$i++){
					$selected = $_birth_arr[1]==$i ? 'selected' : '';
				?>
				<option value="<?php echo sprintf('%02d',$i);?>" <?=$selected;?>><?php echo sprintf('%02d',$i);?></option>
				<?php } ?>
			</select>
			<p>-</p>
			<select name="mb_birth_day" hname="өдөр" required>
				<option value="">өдөр</option>
				<?php
				for($i=1;$i<=31;$i++){
					$selected = $_birth_arr[2]==$i ? 'selected' : '';
				?>
				<option value="<?php echo sprintf('%02d',$i);?>" <?=$selected;?>><?php echo sprintf('%02d',$i);?></option>
				<?php } ?>
			</select>
			<?php }?>
		</fieldset>
	</li>
	<li class="row7">
		<label for="nickname">Nickname<span class="check"></span></label>
		<input type="text" id="nickname" name="mb_nick" value="<?=$member['mb_nick'];?>" hname="Nickname" required maxlength="41">
		<input type="hidden" name="nick_check" id="nick_check" value="<?=$member['mb_id'] ? 1 : '';?>" message="Nickname оруулна уу." required nofocus style="display:none;" />
		<button type="button" class="form_bt" onClick="netfu_member.dupl_nick($('#nickname').val())">Шалгах</button>
	</li>
	<li class="row8" style="height:auto">
		<fieldset>
			<legend>Утасны дугаар<span class="check"></span></legend>
			<?php
			if($_member_write_input_view) {
				echo @implode(" - ", $_hphone_arr);
				?>
				<input type="hidden" name="mb_hphone[]" value="<?=$_hphone_arr[0];?>" />
				<input type="hidden" name="mb_hphone[]" value="<?=$_hphone_arr[1];?>" />
				<input type="hidden" name="mb_hphone[]" value="<?=$_hphone_arr[2];?>" />
				<?php
			} else {?>
			<select name="mb_hphone[]" hname="Холбогдох дугаар" required>
				<?php echo $hp_num_option; ?>
			</select>
			<p>-</p><input type="tel" size="4" maxlength="4" name="mb_hphone[]" value="<?=$_hphone_arr[1];?>" hname="Холбогдох дугаар" required class="cel1 phone1">
			<p>-</p><input type="tel" size="4" maxlength="4" name="mb_hphone[]" value="<?=$_hphone_arr[2];?>" hname="Холбогдох дугаар" required class="cel2 ">
			<?php }?>
			<div class="receive smschk"><input type="checkbox" name="mb_receive[]" value="sms" checked="checked">Ажилд орох / ажилд зуучлахтай холбоотой мэдээний талаар SMS хүлээн авах</div>
		</fieldset>
	</li>
	<li class="row9" style="height:32px;line-height:32px">
		<fieldset>
			<legend>Холбогдох дугаар</legend>
				<select name="mb_phone[]" hname="Холбогдох дугаар" >
					<?php echo $tel_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_phone[]" value="<?=$_phone_arr[1];?>" hname="Холбогдох дугаар"  class="tel1 phone2">
				<p>-</p><input type="tel" size="4" maxlength="4" name="mb_phone[]" value="<?=$_phone_arr[2];?>" hname="Холбогдох дугаар"  class="tel2 ">
		</fieldset>
	</li>
	<li class="row10">
		<?php
		include NFE_PATH.'/include/inc/post.inc.php';
		?>
	  <fieldset>
			<legend>Хаяг<span class="check"></span></legend>
			<input type="text" size="4" maxlength="4" name="mb_doro_post" hname="замын нэр" value="<?=$member['mb_doro_post'];?>" required id="mb_doro_post" class="post">
			<input type="hidden" name="mb_zipcode[]" value="<?=$_zipcode_arr[0];?>" /><input type="hidden" name="mb_zipcode[]" value="<?=$_zipcode_arr[1];?>" />
			<input type="text" maxlength="" name="mb_address0" value="<?=$member['mb_address0'];?>" hname="Хаяг" required id="mb_address0" class="address1">
			<button class="form_bt form_bt2" onClick="post_click(); return false;">шуудангын дугаар</button>
			<div class="cf">
				<input type="text" name="mb_address1" value="<?=$member['mb_address1'];?>" hname="Дэлгэрэнгүй хаяг"  class="address2" placeholder="Дэлгэрэнгүй хаягаа оруулна уу.">
			</div>
		</fieldset>
	</li>
	<li class="row11" style="height:auto">
		<fieldset>
			<legend>И-мэйл<span class="check"></span></legend>
			<input type="text" name="mb_email[]" hname="И-мэйл" value="<?=$_email_arr[0];?>" required class="email">
			<p>@</p><input type="text" name="mb_email[]" value="<?=$_email_arr[1];?>" hname="И-мэйл required class="email">
			<select onChange="netfu_util1.put_text(this, $('[name=\'mb_email[]\']').eq(1))" style="margin-right:0">
				<option value="">мэйл</option>
				<?php echo $email_option; ?>
			</select>
			<div class="receive smschk"><input type="checkbox" name="mb_receive[]" value="email" checked="checked">Ажилд орох / ажилд зуучлахтай холбоотой мэдээний талаар SMS хүлээн авах</div>
		</fieldset>
	</li>
	<li class="row12">
		<label>Цээж зураг</label>
		<div class="member_photo">
			<img src="<?=$member['mb_id'] ? $mb_photo : NFE_URL.'/images/id_pic.png';?>" alt="Цээж зураг">
			<div><input type="file" id="" name="photo" onChange="netfu_util1.filesize_check(this, '<?=$netfu_mjob->photo_size;?>')"></div>
			<p>gif, jpg, png формат 100 × 130 пиксел, 100 кб багтаамжтай файлуудыг бүртгэх боломжтой.</p>
		</div>
	</li>
	<li class="row13">
		<label for="homepage">Homepage</label>
			<span>http://</span><input type="text" name="mb_homepage" value="<?=$_homepage_val;?>" class="">
</li>
</ul>
</section>