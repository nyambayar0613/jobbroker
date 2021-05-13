<!-- 내사진 수정 -->
<script type="text/javascript">
var photo_submit = function() {
	var form = document.forms['fphoto'];
	var file_arr = $("[name='photo_file']").val().split(".");
	var _ext = file_arr[file_arr.length-1];
	if(in_array(_ext.toLowerCase(), ['gif', 'jpeg', 'jpg', 'png'])) {
		netfu_util1.ajax_submit(form);
	} else {
		alert("gif, jpeg, jpg, png 파일형식만 가능합니다.");
	}
	return;
}
</script>
<form name="fphoto" action="<?=NFE_URL;?>/regist.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="ajax" value="true"/>
<input type="hidden" name="mode" value="profile_photo_upload"/>
<input type="hidden" name="mb_type" value="<?php echo $mb_type;?>"/>
<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>
<input type="hidden" name="no" value="<?php echo $member['no'];?>"/>
<div class="wrap_bg_div pic_change_div" style="display:none;">
<div class="pic_change">
	<h2>내사진 수정</h2>
	<p>gif, jpeg, jpg, png 파일형식으로, 100×130픽셀, <?=$netfu_mjob->logo_size;?>kb 용량 이내의 파일만 등록 가능합니다.</p>
	<div><input type="file" name="photo_file"  onChange="netfu_util1.filesize_check(this, '<?=$netfu_mjob->photo_size;?>')"></div>
	<div class="button_con">
		<a href="#none;" class="bottom_btn01" onClick="photo_submit()">등록</a><a href="#none;" class="bottom_btn02" onClick="netfu_util1.photo_write_view('.pic_change_div')">취소</a>
	</div>
</div>
<div class="wrap_bg"></div>
</div>
</form>
<!-- //내사진 수정 -->