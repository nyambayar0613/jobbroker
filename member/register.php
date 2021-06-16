<?php
$head_title = "Гишүүнчлэлийн нөхцөл, журам";
include_once "../include/top.php";

include NFE_PATH.'/engine/netfu_auth.class.php';
$netfu_auth = new netfu_auth();
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/netfu_auth.class.js?time=<?=time();?>"></script>
<script type="text/javascript">
var auth_engine = "<?=$netfu_auth->engine;?>";
var member_agree = function(val) {

	var guide = $("[name='guide']:checked");
	var privacy = $("[name='privacy']:checked");

	if(guide.val()=='N') {
		alert("Ашиглалтын нөхцөлийг бөглөнө үү.");
		return;
	}

	if(privacy.val()=='N') {
		alert("Хувийн мэдээлэлтэй харьцах нөхцөлийг бөглөнө үү.");
		return;
	}

	<?php
	if($env['use_ipin'] || $env['use_hphone']) {
		if($_SESSION['certify_info']) {
		?>
			netfu_auth.auth_read = true;
		<?php
		}
	?>
	if(!netfu_auth.auth_read) {
		alert("Та баталгаажуулалт хийнэ үү.");
		return;
	}
	<?php
	}
	?>

	location.href = "./join.php?kind="+val;
}
</script>
<form name="fagree">
<section class="cont_box service_con register_con ">
<h2>Ашиглалтын нөхцөл</h2>
<div class="text_box terms">
	<h3 class="register_tit">Хувь хүнд үзүүлэх үйлчилгээний нөхцөл</h3>
	<?=stripslashes($env['site_agreement']);?>
</div>
<div class="radio_group2">
	<label for="guide_agree"><input type="radio" id="guide_agree" name="guide" value="Y">Зөвшөөрч байна.</label>
	<label for="guide_disagree"><input type="radio" id="guide_disagree" value="N" name="guide" checked>Зөвшөөрөхгүй.</label>
</div>
</section>

<section class="cont_box service_con register_con">
<h2>Хувийн мэдээлэлтэй харьцах нөхцөл</h2>
<div class="text_box terms">
	<?=stripslashes($env['privacy_info']);?>
</div>

<div class="radio_group2">
	<label for="privacy_agree"><input type="radio" id="privacy_agree" name="privacy" value="Y">Зөвшөөрч байна.</label>
	<label for="privacy_disagree"><input type="radio" id="privacy_disagree" value="N" name="privacy" checked>Зөвшөөрөхгүй.</label>
</div>
</section>

<?php
if(!$_SESSION['certify_info']) {
if($env['use_ipin'] || $env['use_hphone']) {
?>
<section class="confirm_con cf">
<h2>Баталгаажуулалт</h2>
	<div class="confirm_wrap">
		<?php
		if($env['use_ipin']) {
		?>
		<a href="#none;" onClick="netfu_auth.click_auth('ipin')">
			<div class="confirm_bt cf">
				<div class="bt-icon"><img src="<?=NFE_URL;?>/images/ipin.png" alt="IPIN баталгаажуулалт" width="25"></div>
				<div class="bt-txt">IPIN баталгаажуулалт</div>
			</div>
		</a>
		<?php }
		if($env['use_hphone']) {
		?>
		<a href="#none;" onClick="netfu_auth.click_auth('sms')">
			<div class="confirm_bt cf">
				<div class="bt-icon"><img src="<?=NFE_URL;?>/images/cellPhone.png" alt="Дугаараар баталгаажуулах" width="15"></div>
				<div class="bt-txt">Дугаараар баталгаажуулах</div>
			</div>
		</a>
		<?php }?>
	</div>
</section>
<?php }
}?>

<div class="button_con">
	<a href="javascript:member_agree('individual')" class="bottom_btn07">Хувь хүнээр нэвтрэх<img src="<?=NFE_URL;?>/images/icon_arrow_right2.png" alt="Хувь хүнээр нэвтрэх"></a><a href="javascript:member_agree('company')" class="bottom_btn08">Байгууллагаар нэвтрэх<img src="<?=NFE_URL;?>/images/icon_arrow_right2.png" alt="Байгууллагаар нэвтрэх"></a>
</div>
</form>

<?php
if($netfu_auth->engine=='kcb') {
	include_once NFE_PATH.'/plugin/auth/kcb/auth_start.php';
} else {
	//include_once "";
}

include "../include/tail.php";
?>