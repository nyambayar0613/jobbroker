<?php
// : 신고하기 팝업

$title_txt = $report_code=='job' ? 'Ажилд авна' : 'Хүний нөөц';
?>
<style type="text/css">
.report_content__ { display:none; }
.cont_box input[type="radio"]{margin-right:5px}
textarea{padding:5px}
</style>
<script type="text/javascript">
var report_sel = function(el) {
	switch($(el).val()) {
		case 'self':
			$(".report_content__").css({"display":"block"});
			$(".report_content__").find("textarea").prop("required", true);
			break;

		default:
			$(".report_content__").css({"display":"none"});
			$(".report_content__").find("textarea").prop("required", false);
			break;
	}
}
</script>
<div class="detail_ly mail_ly report_bx cf">
	<div class="detail_inner">
		<div class="box-title"><h2><?=$title_txt;?>Мэдээлэл мэдэгдэх</h2>
			<div class="btn-r">
				<button id="close_ly" type="button" onClick="netfu_util1.close($('.report_bx'))">X</button>
			</div>
		</div>
		<form name="reportFrm" method="post" id="reportFrm">
		<input type="hidden" name="mode" value="insert"/>
		<input type="hidden" name="no" value="<?=$_GET['no'];?>"/>
		<div class="text_area">
			<fieldset>
				<legend>Мэдэгдэх шалтгаан</legend>
				<ul>
					<?php
					if(is_array($category_list)) { foreach($category_list as $k=>$v) {
					?>
					<li><label><input type="radio" name="wr_report" value="<?=$v['code'];?>" onclick="report_sel(this);" required hname="Мэдэгдэх шалтгаан" option="radio"><?=$v['name'];?></label></li>
					<?php
					} }
					?>
					<li><label><input type="radio" name="wr_report" value="self" id="wr_report_self" onclick="report_sel(this);" required hname="Мэдэгдэх шалтгаан" option="radio"></label></li>
					<li class="report_content__" style="height:auto"><textarea name="wr_report_content" placeholder="оруулна уу." hname="Мэдэгдэх шалтгаан" style="border:1px solid #ddd;width:100%;height:100px;"></textarea></li>
				</ul>
			</fieldset>
		</div>
		<div style="clear:both"></div>
		<div class="btn_area" style="clear:both">
			<ul>
				<li class="rept_bt1 cp" onClick="netfu_mjob.report('alba', '<?=$_GET['no'];?>')">Мэдэгдэх</li>
				<li class="rept_bt2 cp" onClick="netfu_mjob.alba_report_close()">Цуцлах</li>
			</ul>
		</div>
		</form>
	</div>
</div>	