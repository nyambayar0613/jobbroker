<?php
if(!$member['mb_id']) return false;


?>
<style type="text/css">
.logo_change._none { display:none; }
</style>
<script type="text/javascript">
var logo_write = function() {
	var form = document.forms['flogo'];
	if(!form.logo.value) {
		alert("Логогоо бүртгүүлнэ үү.");
		return;
	} else {
		form.submit();
	}
}

$(window).ready(function(){
	$(".logo_write__").click(function(){
		$(".logo_change").removeClass("_none");
	});
});
</script>

<!-- 로고 파일 수정 -->
<form name="flogo" action="<?=NFE_URL;?>/regist.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="logo_write" />
<input type="hidden" name="ajax" value="true"/>
<input type="hidden" name="mb_type" value="<?php echo $mb_type;?>"/>
<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>
<input type="hidden" name="no" value="<?php echo $member['no'];?>"/>
<input type="hidden" name="company_no" value="<?php echo $company_member['no'];?>"/>
<input type="hidden" name="job_no" value="<?php echo $_GET['no'];?>"/>
<div class="wrap_bg_div logo_change _none">
	<h2>Лого файл бүртгэх</h2>
	<p>gif, jpeg, jpg font, 135×65 pexel, <?=$netfu_mjob->logo_size;?>Зөвхөн kb багтаамжтай файлуудыг бүртгэх боломжтой.</p>
	<div><input type="file" name="mb_logo" id="mb_logo" onChange="netfu_util1.filesize_check(this, '<?=$netfu_mjob->logo_size;?>')"></div>
	<div class="button_con">
		<a href="#none;" class="bottom_btn01" onClick="netfu_mjob.logo_submit()">Бүртгэх</a><a href="#none;" class="bottom_btn02" onClick="$('.logo_change').addClass('_none')">Цуцлах</a>
	</div>
<!--div class="wrap_bg"></div-->
</div>
</form>
<!-- //로고 파일 수정 -->