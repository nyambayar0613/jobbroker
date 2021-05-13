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
		<div class="box-title"><h2><span class="_txt">입사지원</span> 요청</h2>
			<div class="btn-r">
				<button id="close_ly" type="button" onClick="$('.resume_pop_bx').css({'display':'none'})">X</button>
			</div>
		</div>
		<div class="text_area">
			<fieldset>
				<legend>구인공고 선택</legend>
				<ul>
					<li>
						<label for="resume_info1">구인공고선택
							<select id="resume_info1" name="wr_employ" required hname="채용공고">
								<option value="">구인공고 선택</option>
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
					<li><label for="resume_info2">구인담당자명<input type="text" id="resume_info2" name="wr_person" required hname="채용담당자명" value=""></label></li>
					<li><label for="resume_info3">담당자연락처<input type="text" id="resume_info3" name="wr_phone" required hname="담당자연락처" value=""></label></li>
					<li><label for="resume_info4">담당자휴대폰<input type="text" id="resume_info4" name="wr_hphone" required hname="담당자휴대폰" value=""></label></li>
					<li><label for="resume_info3">회신이메일<input type="text" id="resume_info5" name="wr_email" required hname="이메일주소" value=""></label></li>
				</ul>
			</fieldset>
			<fieldset>
				<legend>전달메세지</legend>
				<label for="resume_info2"><textarea rows="5" name="wr_content" required hname="전달메시지"></textarea></li>
			</fieldset>
		</div>

		<div class="btn_area">
			<ul>
				<li class="rept_bt1"><a href="#none;" onClick="netfu_util1.ajax_submit(document.forms['f_resume_pop1'], $('.resume_pop_bx'))">전송</a></li>
				<li class="rept_bt2"><a href="#none;" onClick="$('.resume_pop_bx').css({'display':'none'})">취소</a></li>
			</ul>
		</div>
	</div>
</div>	
<!-- //입사지원요청 팝업 -->
</form>