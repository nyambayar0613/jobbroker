<?php
$editor_use = true;
include_once "../include/top.php";

if(!$_GET['wr_no']) $_GET['wr_no'] = $_GET['no'];

$bo_category = $category_control->category_pcodeList('board',$board['bo_table']);
$content = $write['wr_content'] ? stripslashes($utility->get_text($write['wr_content'], 0)) : $board['bo_insert_content'];

if($member['mb_level'] < $board['bo_write_level']){
	if($member['mb_id'])
		$utility->popup_msg_js($board_control->_errors('0026'));	// 글을 쓸 권한이 없습니다.
	else
		$utility->popup_msg_js($board_control->_errors('0027'), NFE_URL."/include/login.php?url=".urlencode($_SERVER['PHP_SELF']."?mode=insert&board_code=".$board_code."&code=".$code."&bo_table=".$bo_table));	// 글을 쓸 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보세요.
}

$is_file = true;	// 파일 첨부
//if($board['bo_use_upload'] && $is_member)	 // 파일 첨부 기능을 사용하고, 회원일때만 (보안상 비회원은 파일첨부 안됨)
if($board['bo_use_upload'])
	$is_file = true;

$is_file_content = false;	// 업로드 이미지 파일에 해당 하는 내용 (지금 버전에선 없다)
$is_dhtml_editor = true;	// 에디터 사용

$is_name = false;
$is_password = false;
$is_email = false;
if (!$member['mb_id'] || ($mode == 'update' && $member['mb_id'] != $write['wr_id'])) {	// 비회원의 경우 작성 항목이 늘어난다.
	$is_name = true;
	$is_password = true;
	$is_email = true;
	$is_homepage = true;
	$wr_name = stripslashes($write['wr_name']);
	$wr_password = $_GET['password'];
}

$is_category = false;
if ($board['bo_use_category']) {	// 분류 사용 유무
	$ca_name = $write['wr_category'];
	$category_option = $category_control->getOption_add('board'," and `p_code` = '".$bo_table."' ", $write['wr_category']);
	$is_category = true;
}

$file = $utility->get_file($bo_table, $write['wr_no']);
?>
<style type="text/css">
.cheditor-popup-window { z-index:99999 !important; }
</style>
<script type="text/javascript">
var rand_word_change = function() {
	$(".capcha_bx").html('<img src="<?=NFE_URL;?>/include/rand_text.php" />');
}


var submit_func = function() {
	var form = document.forms['fwrite'];
	if(validate(form)) {
		var _key = $(form).find("[name='wr_key']").val();
		$.post("<?=NFE_URL;?>/regist.php", "mode=rand_num_check&word="+_key, function(data){
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			else {
				form.submit();
				return false;
			}
		});
	}
	return false;
}
</script>

<!-- 커뮤니티 글쓰기 -->
<form name="fwrite" action="./regist.php" method="post" enctype="multipart/form-data">
<input type="hidden" name=null> 
<input type="hidden" name="mode" value="<?=$_GET['wr_no'] ? 'update' : 'insert'?>">
<input type="hidden" name='board_code' value='<?=$_GET['board_code']?>'>
<input type="hidden" name='code' value='<?=$_GET['code']?>'>
<input type="hidden" name='bo_table' value='<?=$_GET['bo_table']?>'>
<input type="hidden" name='wr_no' value='<?=$_GET['wr_no']?>'>
<input type="hidden" name="sca" value="<?=$sca?>">
<input type="hidden" name="page" value="<?=$_GET['page']?>">
<div class="layer1 cf">
	<section class="cont_box community_con cmt_write">
		<h2><img src="<?=NFE_URL;?>/images/write.png" alt="Бичсэн">Writer</h2>
			<ul class="info_con">
			<?php if($is_category){ ?>
				<li class="row1">
					<label for="sort">Төрөл<span class="check"></span></label>
					<select id="sort" name="wr_category" class="st_sort" hname="Төрөл" required>
						<option value="">Төрөл сонгох</option>
						<?php
						if(is_array($bo_category)) { foreach($bo_category as $k=>$v) {
							$selected = $write['wr_category']==$v['code'] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php
						} }
						?>
					</select>
				</li>
				<?php } ?>

				<?php if ($is_name) { ?>
				<li class="row2">
					<label for="writer">Writer<span class="check"></span></label>
					<input type="text" id="writer" name="wr_name" value="<?=$write['wr_name'];?>" hname="Writer" required maxlength="41">
				</li>
				<?php } ?>
				<?php if ($is_password) { ?>
				<li class="row3">
					<label for="pw">Нууц дугаар<span class="check"></span></label>
					<input type="password" id="pw" name="wr_password" hname="Нууц дугаар" required maxlength="16">
				</li>
				<?php } ?>
				<li class="row7">
					<label for="title">Гарчиг<span class="check"></span></label>
					<input type="text" id="title" name="wr_subject" hname="Гарчиг" required value="<?=$write['wr_subject'];?>" style="width:55%;margin-right:10px"><?php if($board['bo_use_secret']) {?><input type="checkbox" name="wr_secret" value="1">비밀글<?php }?>
				</li>
				<li class="row8">
					Агуулга<span class="check"></span>
					<textarea type="editor" name="wr_content" hname="Агуулга" required style="width:100%;height:250px;"><?=$content;?></textarea>
				</li>


				<?php if ($is_file) { ?>
				<li style="height:auto">
					<label for="content" style="letter-spacing:-0.1em;">Thumbnail image</label>
						<div class="file_name"><input type="file" id="" name="file_name[]" onChange="file_check(this)" title='Файлын хэмжээ <?=$upload_max_filesize?> Зөвхөн дараах хэмжээ дотор байршуулах боломжтой' class="file_in"></div>
						<table id="variableFiles" cellpadding=0 cellspacing=0>
						<?php
						for($i=1; $i<$file['count']; $i++) {
						?>
						<tr><td><input type="file" id="" name="file_name[]" title='Файлын хэмжээ <?=$upload_max_filesize?> Зөвхөн дараах хэмжээ дотор байршуулах боломжтой' class="file_in"></td></tr>
						<?php
						}
						?>
						</table>
						<script type="text/javascript">
						var flen = 1;
						var file_count = "<?=$board['bo_upload_count'];?>";
						var fileSize = "<?=$board['bo_upload_size'];?>";
						var bo_table = "<?=$board['bo_table'];?>";
						var file_name_obj = $(".file_name");
						function file_check(el) {
							$.post(base_url+"/regist.php", "mode=allow_ext&bo_table="+bo_table+"&value="+el.value, function(data){
								data = $.parseJSON(data);
								if(data.msg) {
									alert(data.msg);
									var fileObj = $(".file_name").clone(true);
									if($(el).closest("td")[0]) fileObj.find("input[type=file]").addClass("ed file_ad");
									$(el).parent().html(fileObj.html());
								}
							});
						}

						function add_file(delete_code){
							if(flen>=file_count) {
								alert("Эн мэдээллийн самбар нь "+file_count+"хүртэл орох боломжтой.");
								return;
							}
							var objTbl = $("#variableFiles");
							var fileObj = $(".file_name").eq(0).clone(true).wrapAll("<div/>").parent().clone();
							fileObj.find("input[type=file]").addClass("ed file_ad");
							objTbl.append('<tr><td>'+fileObj.html()+'</td></tr>');
							flen++;
						}

						function del_file(){
							if(confirm("Устгах уу?")) {
								var objTbl = $("#variableFiles");
								var tr_len = objTbl.find("tr").length;
								objTbl.find("tr").eq(tr_len-1).remove();
							}
						}
						</script>

						<div id="ImageAttach0" class="file_bt_gp">
							<div class="file_bt1"><a class="btn commentBtn add" href="javascript:add_file();" style="display:;"><span class="btn commentBtnBg">Нэмэх</span></a></div>
							<div class="file_bt2"><a class="btn commentBtn del" href="javascript:del_file();" style="display:;"><span class="btn commentBtnBg">Устгах</span></a></div>
						</div>
						<div class="file_bt_tx" style="clear:both">
						  <p class="pt10 pb10" style="line-height:1.8"><strong><?php echo strtoupper(strtr($board['bo_upload_ext_img'],'|',','));?></strong> Format-аар,
						  <strong>нэг файл тутамд <?php echo number_format(intval(substr(ini_get('post_max_size'),0,-1)) * 1024);?>KB</strong> Зөвхөн дараах хэмжээ дотор байршуулах боломжтой.</p>
						</div>
					
				</li>
				<?php } ?>



				<?php
				if(!$member['mb_id']) {
				?>
				<li class="row9">
					<label for="capcha">자동등록방지</label>
					<div class="capcha_group">
					  <div class="cf">
						  <div class="capcha_bx" style="float:left"><img src="<?=NFE_URL;?>/include/rand_text.php" /></div>
						  <div class="refs"><a href="javascript:rand_word_change()"><img src="../images/icon/icon0501.png" alt="Шинээр зассан">Шинээр зассан</a></div>
						</div>
						<div class="cf"><input type="text" id="capcha" hname="Автомат бүртгэлэээс сэргийлэх" required name="wr_key"></div>
						<div><p>Дээрх текстийг оруулна уу.</p></div>
					<div>
				</li>
				<?php }?>
			</ul>
	</section>


	<div class="button_con">
		<a href="#none;" onClick="submit_func()" class="bottom_btn06">Бүртгэх</a><a href="#" class="bottom_btn02">Цуцлах</a>
	</div>

</div>
</form>
<!-- //커뮤니티 글쓰기 -->


<?php
include_once(NFE_PATH.'/include/tail.php');
?>