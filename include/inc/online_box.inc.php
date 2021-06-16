<form method="post" name="freceive1" action="<?=NFE_URL;?>/regist.php" enctype="multipart/form-data">
<input type="hidden" name="mode" value="receive_write"/>
<input type="hidden" name="no" value="<?php echo $_GET['no'];?>"/>
<input type="hidden" name="code" value="online"/>
<div class="detail_ly mail_ly online_bx cf">
	<div class="detail_inner">
		<div class="box-title"><h2>Онлайн өргөдөл</h2>
		<div class="btn-r">
			<button id="close_ly" type="button" onClick="netfu_util1.close('.detail_ly.mail_ly')">X</button>
		</div>
		</div>
		<div class="text_area">
			<fieldset>
			<legend>Анкет сонгох</legend>
				<ul class="inpt_bx resume_bx">
					<li><label for="">Өргөдлийн гарчиг <input type="text" name="wr_subject" hname="Өргөдлийн гарчиг" value="" required></label></li>
					<li>
						<label for="" class="resume-st">Анкет сонгох </label>
						<select name="alba_resume" hname="Анкет сонгох" required>
						<option value="">Анкет сонгох</option>
						<?php
						if(is_array($my_resume_arr)) { foreach($my_resume_arr as $k=>$row) {
						?>
						<option value="<?=$row['no'];?>"><?=$row['wr_subject'];?></option>
						<?php
						} }
						?>
						</select>
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
			<li class="sbtn"><a href="#none;" onClick="netfu_util1.ajax_submit(document.forms['freceive1'], $('.detail_ly.mail_ly'))">Өргөдөл</a></li>
			<li class="abtn"><a href="#none;" onClick="netfu_util1.close('.detail_ly.mail_ly')">Цуцлах</a></li>
		</ul>
		</div>
	</div>
</div>
</form>