<style type="text/css">
.submenu_slide a { padding-left:10px; padding-right:10px; width:auto !important; }
</style>

<div class="navi_cate">
	<a href="#" class="prev_btn menu_arrow"><img src="/images/menu_arrow1.png" alt="Өмнөх"></a>
	<div class="cate_con cf submenu_slide cycle-slideshow auto_move"
	data-cycle-slides="> .item_"
	data-cycle-timeout="0"
	data-cycle-fx="carousel"
	data-cycle-carousel-visible=4
	data-cycle-carousel-fluid=true
	data-allow-wrap="false"
	data-cycle-prev=".prev_btn.menu_arrow"
	data-cycle-next=".next_btn.menu_arrow"
	>
		<?php
		if(is_array($netfu_mjob->sub_title['resume'])) { foreach($netfu_mjob->sub_title['resume'] as $k=>$v) {
		?>
		<a href="./index.php?code=<?=$k;?>" class="item_ <?=$_GET['code']==$k ? 'active' : '';?>"><?=$v;?></a>
		<?php
		} }
		?>
		<a href="./index.php?code=search" class="item_ <?=$_GET['code']=='search' ? 'active' : '';?>">Дэлгэрэнгүй хайх</a>
	</div>
	<a href="#" class="next_btn menu_arrow"><img src="/images/menu_arrow2.png" alt="Дараагийх"></a>
</div>