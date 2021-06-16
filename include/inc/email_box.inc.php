<script type="text/javascript">
var wr_from_click =function(el) {
	var _dis = el.checked===true ? 'block' : 'none';
	$(".wr_from_c").css({"display":_dis});
}
</script>
<form method="post" name="freceive2" action="<?=NFE_URL;?>/regist.php" enctype="multipart/form-data">
<input type="hidden" name="mode" value="receive_write"/>
<input type="hidden" name="no" value="<?php echo $_GET['no'];?>"/>
<input type="hidden" name="code" value="email"/>
<div class="detail_ly mail_ly email_bx cf">
	<div class="detail_inner">
		<div class="box-title"><h2>Ажилд орох хүсэлт (Онлайн)</h2>
		<div class="btn-r">
			<button id="close_ly" type="button" onClick="netfu_util1.close('.detail_ly.mail_ly')">X</button>
		</div>
		</div>
		<div class="text_area">
			<fieldset>
				<legend>Анкет сонгох</legend>
				<ul class="inpt_bx resume_bx">
					<li><label for="wr_from">Анкетны маягт <span><input type="checkbox" name="wr_from" id="wr_from" onClick="wr_from_click(this)"> Гишүүний анкет</span></label></li>
					<li><label for="">Анкетны гарчиг<input type="text" name="wr_subject" id="" value=""></label></li>
					<li class="wr_from_c" style="display:none;"><label for="">Анкет сонгох
						<span><select name="alba_resume" hname="Анкет сонгох" required>
							<option value="">Анкет сонгох</option>
							<?php
							if(is_array($my_resume_arr)) { foreach($my_resume_arr as $k=>$row) {
							?>
							<option value="<?=$row['no'];?>"><?=$row['wr_subject'];?></option>
							<?php
							} }
							?>
							</select>
						</span></label>
					</li>
				</ul>
			</fieldset>
			<fieldset>
				<legend>Хавсралтын шууд бүртгэл</legend>
				<div class="inpt_bx file_bx"><input type="file" name="up_file"></div>
			</fieldset>
			<fieldset>
				<legend>Холбоо барих мэдээллийн тохиргоо</legend>
				<div class="inpt_bx contact_bx cf">
					<?php
					if(is_array($netfu_mjob->receive_arr)) { foreach($netfu_mjob->receive_arr as $k=>$v) {
					?>
					<label><input type="checkbox" name="mb_info[]" value="<?=$k;?>"> <?=$v;?></label>
					<?php
					} }
					?>
				</div>
			</fieldset>
		</div>
		<div class="btn_area">
			<ul>
				<li class="sbtn"><a href="#none;" onClick="netfu_util1.ajax_submit(document.forms['freceive2'], $('.detail_ly.mail_ly'))">Хүсэлт</a></li>
				<li class="abtn"><a href="#none;" onClick="netfu_util1.close('.detail_ly.mail_ly')">취소</a></li>
			</ul>
		</div>
	</div>
</div>
</form>