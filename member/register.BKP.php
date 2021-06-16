<?php
$head_title = "회원가입약관";
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
		alert("이용약관을 체크해주시기 바랍니다.");
		return;
	}

	if(privacy.val()=='N') {
		alert("개인정보 취급방침을 체크해주시기 바랍니다.");
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
		alert("본인인증해 주시기 바랍니다.");
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
<h2>이용약관</h2>
<div class="text_box terms">
	<h3 class="register_tit">개인을 위한 서비스 이용약관</h3>
	<?=stripslashes($env['site_agreement']);?>
</div>
<div class="radio_group2">
	<label for="guide_agree"><input type="radio" id="guide_agree" name="guide" value="Y">동의합니다.</label>
	<label for="guide_disagree"><input type="radio" id="guide_disagree" value="N" name="guide" checked>동의하지 않습니다.</label>
</div>
</section>

<section class="cont_box service_con register_con">
<h2>개인정보수집이용안내</h2>
<div class="text_box terms">
	<?=stripslashes($env['privacy_info']);?>
</div>

<div class="radio_group2">
	<label for="privacy_agree"><input type="radio" id="privacy_agree" name="privacy" value="Y">동의합니다.</label>
	<label for="privacy_disagree"><input type="radio" id="privacy_disagree" value="N" name="privacy" checked>동의하지 않습니다.</label>
</div>
</section>

<?php
if(!$_SESSION['certify_info']) {
if($env['use_ipin'] || $env['use_hphone']) {
?>
<section class="confirm_con cf">
<h2>본인인증</h2>
	<div class="confirm_wrap">
		<?php
		if($env['use_ipin']) {
		?>
		<a href="#none;" onClick="netfu_auth.click_auth('ipin')">
			<div class="confirm_bt cf">
				<div class="bt-icon"><img src="<?=NFE_URL;?>/images/ipin.png" alt="아이핀 인증" width="25"></div>
				<div class="bt-txt">IPIN인증</div>
			</div>
		</a>
		<?php }
		if($env['use_hphone']) {
		?>
		<a href="#none;" onClick="netfu_auth.click_auth('sms')">
			<div class="confirm_bt cf">
				<div class="bt-icon"><img src="<?=NFE_URL;?>/images/cellPhone.png" alt="휴대폰 인증" width="15"></div>
				<div class="bt-txt">휴대폰 인증</div>
			</div>
		</a>
		<?php }?>
	</div>
</section>
<?php }
}?>

<div class="button_con">
	<a href="javascript:member_agree('individual')" class="bottom_btn07">개인회원 가입<img src="<?=NFE_URL;?>/images/icon_arrow_right2.png" alt="개인회원가입"></a><a href="javascript:member_agree('company')" class="bottom_btn08">기업회원가입<img src="<?=NFE_URL;?>/images/icon_arrow_right2.png" alt="기업회원가입"></a>
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