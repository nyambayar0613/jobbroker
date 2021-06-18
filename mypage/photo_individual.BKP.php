<?php
$head_title = $menu_text = "내사진관리";
$page_code = 'mypage';
include "../include/top.php";
?>
<script type="text/javascript">
var photo_delete = function() {
	if(confirm("사진을 삭제하시겠습니까?")) {
		$.post(base_url+"/regist.php", "mode=photo_delete", function(data) {
			data = $.parseJSON(data);
			if(data.js) eval(data.js);
			if(data.msg) alert(data.msg);
		});
	}
}
</script>
<section class="cont_box detail_con">
	<div class="picture_box">
		<img src="<?=$mb_photo;?>" alt="증명사진"><!-- <img src="images/id_pic2.png" alt="증명사진"> -->
	</div>
	<div class="file_info">
		<ul>
			<li>사진규격 : 100 × 130px</li>
			<li>파일형식 : gif, jpg, png</li>
			<li>용량 : 100kb 이내</li>
		</ul>
	</div>
	<div class="set_bt">
		<button type="button" onClick="netfu_util1.photo_write_view('.pic_change_div')">수정</button>
		<button type="button" onClick="photo_delete()">삭제</button>
	</div>
</section>

<!--
<section class="cont_box photo_con">
<h2>포토앨범</h2>
	<ul class="cont_box_inner">
		<li>
			<div class="image_box">
				<a href="#"><img src="images/sample_img03.png" alt=""></a>
			</div>
			<div class="btn_box">
<button type="button">등록</button><button type="button">삭제</button>
			</div>
		</li>
		<li>
			<div class="image_box">
				<a href="#"><img src="images/sample_img03.png" alt=""></a>
			</div>
			<div class="btn_box">
<button type="button">등록</button><button type="button">삭제</button>
			</div>
		</li>
		<li>
			<div class="image_box">
				<a href="#"><img src="images/sample_img03.png" alt=""></a>
			</div>
			<div class="btn_box">
<button type="button">등록</button><button type="button">삭제</button>
			</div>
		</li> 
		<li>
			<div class="image_box">
				<a href="#"><img src="images/no-img2.png" alt=""></a>
			</div>
			<div class="btn_box">
<button type="button">등록</button><button type="button">삭제</button>
			</div>
		</li>						
	</ul>
</section>
-->

<?php
include "../include/tail.php";
?>