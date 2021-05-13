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
		alert("로고를 등록해주시기 바랍니다.");
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
	<h2>로고파일 수정</h2>
	<p>gif, jpeg, jpg 파일형식으로, 135×65픽셀, <?=$netfu_mjob->logo_size;?>kb 용량 이내의 파일만 등록 가능합니다.</p>
	<div><input type="file" name="mb_logo" id="mb_logo" onChange="netfu_util1.filesize_check(this, '<?=$netfu_mjob->logo_size;?>')"></div>
	<div class="button_con">
		<a href="#none;" class="bottom_btn01" onClick="netfu_mjob.logo_submit()">등록</a><a href="#none;" class="bottom_btn02" onClick="$('.logo_change').addClass('_none')">취소</a>
	</div>
<!--div class="wrap_bg"></div-->
</div>
</form>
<!-- //로고 파일 수정 -->