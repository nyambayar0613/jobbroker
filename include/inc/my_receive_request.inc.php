<!-- 입사지원 내용보기 -->
<style type="text/css">
._receive_box { top:-999999px; position:absolute; display:block; }
</style>
<script type="text/javascript">
var get_info_func = function(el, no) {
	$.post(base_url+"/regist.php", "mode=get_receive_request&no="+no, function(data) {
		data = $.parseJSON(data);
		if(data.msg) alert(data.msg);
		if(data.move) location.href = data.move;
		if(!data.msg) {
			if(data.company_name) $("._receive_box").find("._company").html(data.company_name);
			if(data.wr_content) $("._receive_box").find("._content").html(data.wr_content);
			var _offset = $(el).offset();
			$('._receive_box').css({'top':_offset.top+'px'});
			$('._receive_box').find(".bottom_btn07").attr("no", data.no);
			$('._receive_box').find(".bottom_btn07").attr("k", 'online');
			//netfu_util1.this_pos_view(el, '._receive_box');
		}
	});
}
</script>
<ul class="list_con">
	<div class="detail_ly cf _receive_box" id="ly02">
		<div class="detail_inner">
			<div class="bx-top"><h2>Ажлын байрны өргөдлийн дэлгэрэнгүй</h2>
				<div class="btn-r btn-r2"><button id="close_ly" type="button" onClick="$('._receive_box').css({'top':'999999px'})">X</button></div>
			</div>
			<div class="content">
				<h3><strong class="_company">Financial co LLC</strong>-с илгээсэн ярилцлагын агуулга.</h3>
				<p class="_content">
                    Financial LLC дээр ярилцлага өгөхийг санал болгож байна.<br>
                    Тус компани дээр очиж ярилцлага өгнө үү.
				</p>
			</div>
		</div>
		<div class="button_con">
			<a href="#none;" class="bottom_btn07" onClick="receive_click(this)" no="" k="">지원하기<img src="<?=NFE_URL;?>/images/icon_arrow_right3.png" alt="Өргөдөл гаргах"></a>
		</div>
	</div>
</ul>
<!-- //입사지원 내용보기 -->