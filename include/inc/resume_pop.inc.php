<?php
$my_em = sql_query("select * from alice_alba where `wr_id`='".$member['mb_id']."' order by `no` desc");
?>
<style>
.resume_pop fieldset > ul{float:left;border:1px solid #dee3eb;padding:10px;padding-bottom:5px}
.resume_pop fieldset > ul > li{margin-bottom:5px}
.resume_pop .text_area legend{float:left;letter-spacing:-0.05em;width:100%}
.resume_pop ul li{height:32px;line-height:32px}
.resume_pop .text_area legend label{float:left;width:100% !important}
.resume_pop .text_area label{width:100%}
.resume_pop .text_area select{float:right;padding:0;margin-left:10px;width:64%;
background: #f6fbff url(../images/drop_ico2.png)no-repeat 100% 50%;border:1px solid #dee3eb;height:32px;line-height:32px;padding:0 5px;}
.resume_pop .text_area input{float:right;padding:0;margin-left:10px;width:64%;
background: #f6fbff;border:1px solid #dee3eb;height:32px;line-height:32px;padding:0 5px;}
.resume_pop .text_area textarea{float:left;padding:10px;width:100%;background: #f6fbff;border:1px solid #dee3eb;border-radius:2px}
</style>
<!-- 입사지원요청 팝업 --> 
<form name="f_resume_pop1" action="<?=NFE_URL;?>/regist.php" method="post">
<input type="hidden" name="mode" value="resume_pop" />
<input type="hidden" name="wr_type" value="" />
<input type="hidden" name="resume_no" value="<?=$_GET['no'];?>" />
<div class="detail_ly mail_ly report_bx resume_pop resume_pop_bx cf" style="display:none">
	<div class="detail_inner">
		<div class="box-title"><h2><span class="_txt">Ажилд орох хүсэлт</span> хүсэлт</h2>
			<div class="btn-r">
				<button id="close_ly" type="button" onClick="$('.resume_pop_bx').css({'display':'none'})">X</button>
			</div>
		</div>
		<div class="text_area">
			<fieldset>
				<legend>Зар сонгох</legend>
				<ul>
					<li>
						<label for="resume_info1">Ажлын байрны зар сонгох
							<select id="resume_info1" name="wr_employ" required hname="Ажлын зар">
								<option value="">Зар сонгох</option>
								<?php
								while($row=sql_fetch_array($my_em)) {
								?>
								<option value="<?=$row['no'];?>"><?=stripslashes($row['wr_subject']);?></option>
								<?php
								}
								?>
							</select>
						</label>
					</li>
					<li><label for="resume_info2">Ажилд авах хүний ​​нэр<input type="text" id="resume_info2" name="wr_person" required hname="Ажилд авах хүний ​​нэр" value=""></label></li>
					<li><label for="resume_info3">Хариуцсан хүнтэй холбоо барих<input type="text" id="resume_info3" name="wr_phone" required hname="Хариуцсан хүнтэй холбоо барих" value=""></label></li>
					<li><label for="resume_info4">Хариуцсан хүний утасны дугаар<input type="text" id="resume_info4" name="wr_hphone" required hname="Хариуцсан хүний утасны дугаар" value=""></label></li>
					<li><label for="resume_info3">Хариу имэйл<input type="text" id="resume_info5" name="wr_email" required hname="Хариу имэйл" value=""></label></li>
				</ul>
			</fieldset>
			<fieldset>
				<legend>Илгээх SMS</legend>
				<label for="resume_info2"><textarea rows="5" name="wr_content" required hname="Илгээх SMS"></textarea></li>
			</fieldset>
		</div>

		<div class="btn_area">
			<ul>
				<li class="rept_bt1"><a href="#none;" onClick="netfu_util1.ajax_submit(document.forms['f_resume_pop1'], $('.resume_pop_bx'))">Илгээх</a></li>
				<li class="rept_bt2"><a href="#none;" onClick="$('.resume_pop_bx').css({'display':'none'})">Цуцлах</a></li>
			</ul>
		</div>
	</div>
</div>	
<!-- //입사지원요청 팝업 -->
</form>