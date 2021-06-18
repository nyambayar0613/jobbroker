<?php
$page_code = 'mypage';
$head_title = $menu_text = 'Гишүүүнчлэлээс гарах хүсэлт';
include "../include/top.php";

//
$_cate_['member_left_reason'] = $netfu_util->get_cate_array('member_left_reason', array('where'=>" and `p_code` = ''"));
?>
<script type="text/javascript">
var member_left = function() {
	var form = document.forms['fwrite'];
	if(!$(form).find("[name='left_agreement']:checked").val()) {
        alert("Гишүүнчлэл цуцлах тухай мэдэгдлийг зөвшөөрч байна уу.");
	} else {
		netfu_util1.ajax_submit(form);
	}
}
</script>
<form name="fwrite" action="<?=NFE_URL;?>/regist.php" method="post">
<input type="hidden" name="mode" value="member_left" />
<section class="cont_box remove_con">
	<h2>Гишүүүнчлэлээс гарах хүсэлт</h2>
	<div class="info4_con info_text">
		<ol>
            <li>1. Таны ашиглаж буй ID <strong><?=$member['mb_id'];?></strong>дахин ашиглах эсвэл сэргээх боломжгүй.</li>
            <li>2. Дараа дахин бүртгүүлэхдээ ижил ID-гаар бүртгүүлэх боломжгүй.</li>
            <li>3. Ажлын мэдээлэл, анкет, ажил хайх, төлбөртэй үйлчилгээ зэргийг бүгдийг нь устгана.</li>
		</ol>
	</div>
	<div class="info4_con agree"><input type="checkbox" id="" name="left_agreement" value="Y">Дээрх агуулгыг зөвшөөрч байна.</div>
</section>

<section class="cont_box remove_con">
	<ul class="info4_con">
		<li class="row_con">
            <label for="member_type">Гишүүний төрөл</label>
            <span><?=$netfu_member->member_kind[$member['mb_type']];?></span>
        </li>
        <li class="row1">
            <label for="id">Гишүүний ID</label>
            <span><?=$member['mb_id'];?></span>
        </li>
        <li class="row2">
            <label for="pw2">Нууц үг батлах<span class="check"></span></label>
            <input type="password" id="pw2" name="mb_password" required hname="Нууц үг" maxlength="16">
        </li>
        <li class="row3">
            <label for="name">И-мэйл<span class="check"></span></label>
            <input type="text" id="name" name="mb_email"  required hname="e-mail" maxlength="">
        </li>
        <li class="row4">
            <fieldset>
                <legend>Цуцлах шалтгаан<span class="check"></span></legend>
				<ol>
					<?php
					if(is_array($_cate_['member_left_reason'])) { foreach($_cate_['member_left_reason'] as $k=>$v) {
					?>
					<li><input type="radio" id="" name="left_reason" value="<?=$v['name'];?>"><?=$v['name'];?></li>
					<?php
					} }
					?>
				</ol>
			</fieldset>
		</li>
	</ul>
</section>

<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="member_left()">Батлах</a><a href="#none;" class="bottom_btn02">Цуцлах</a>
</div>

</form>

<?php
include "../include/tail.php";
?>