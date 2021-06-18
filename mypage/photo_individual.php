<?php
$head_title = $menu_text = "Зураг";
$page_code = 'mypage';
include "../include/top.php";
?>
<script type="text/javascript">
var photo_delete = function() {
	if(confirm("Зураг устгах уу?")) {
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
		<img src="<?=$mb_photo;?>" alt="Цээж зураг"><!-- <img src="images/id_pic2.png" alt="증명사진"> -->
	</div>
	<div class="file_info">
		<ul>
			<li>Зургийн хэмжээ : 100 × 130px</li>
			<li>Файлын формат : gif, jpg, png</li>
			<li>Хэмжээ : 100kb дотор</li>
		</ul>
	</div>
	<div class="set_bt">
		<button type="button" onClick="netfu_util1.photo_write_view('.pic_change_div')">Батлах</button>
		<button type="button" onClick="photo_delete()">Устгах</button>
	</div>
</section>

<!--
<section class="cont_box photo_con">
<h2>포토앨범</h2>
	<ul class="cont_box_inner">
		<li>
			<div class="image_box">
				<a href="#"><img src="images/sample_img03.png" alt=""></a>
			</div>иа
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