<?php
include_once "../include/top.php";

$resume_where = $netfu_mjob->resume_search_func();
?>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.js"></script>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.swipe.js"></script>

<!-- 검색 -->
<div class="schbox_wrap cf">				
	<div class="search_con search_box">
		<?php
		include NFE_PATH.'/include/inc/resume_search.inc.php';
		?>
	</div>
	<div class="schbtn_con cf">
	<ul>
		<li class="search_bx sch_bt sch_bt2" style="width:100%">
			<button type="button" class="sch_button"><img src="<?=NFE_URL;?>/images/search_icon3.png" alt="Хайх">Хайх</button>
		</li>
	</ul>
	</div>
</div>
<!-- //검색 -->

<div class="banner01">
<!-- <a href="#"><img src="images/banner4.jpg" alt=""></a> -->
<a href="#"><img src="<?=NFE_URL;?>/images/banner1-3.jpg" alt=""></a>
</div>

<!-- 포커스형 -->
<?php
$_width = 3;
$_height = 2;
$_total = 12;
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$con = " and wr_service_focus>=curdate() ".$resume_where['where'];
$q = "alice_alba_resume where " . $netfu_mjob->resume_where . $con;
$query = sql_query("select * from ".$q." order by wr_wdate desc limit 0, ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = mysql_num_rows($query);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($list_num/($_width*$_height));
?>
<section class="cont_box focus_con">
	<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/title_icon01.png" alt=""></span>Focus ажлын байр<span class="bt_box"><em>1</em>/<?=$paging_group;?>төрөл <a href="#"><span class="btn">зарын танилцуулга<img src="<?=NFE_URL;?>/images/chevron.png" alt="광고안내"></span></a></span></h2>
	<div class="cycle-slideshow" 
	data-cycle-pause-on-hover="true"
	data-cycle-slides="ul.focus_box"
	data-cycle-timeout=0
	data-cycle-swipe=true
	data-cycle-swipe-fx=scrollHorz
	data-cycle-pager="#focus_con-page"
	data-cycle-pager-template="<a> {{slideNum}} </a>"
	>
	<?php
	// li의ㅣ class ->  class="gold1",  class="gold2"
	switch($total['c']<=0) {
		case true:
		?>
		<li>
			<div class="text_box2">
				<div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">Бүртгэгдсэн мэдээлэл байхгүй байна.</div>
			</div>
		</li>
		<?php
		break;

	default:
		for($i=0; $i<$_total; $i++) {
			$row = sql_fetch_array($query);
			$_li_width = 100/$_width;
			echo $i%$_box_num==0 ? '<ul class="focus_box cont_box_inner" style="width:100% !important;">'."\n" : '';
		?>
		<li style="width:<?=$_li_width;?>%;">
		<?php
		include "../include/inc/resume_box1.inc.php";
		?>
		</li>
		<?php
			echo $i%$_box_num==$_box_num-1 ? '</ul>'."\n" : '';
		}
		break;
	}
	?>
	</div>
	<div class="paging_con cf"><div id="focus_con-page" class="paging center"></div></div>
</section>
<!-- //포커스형 -->

<!-- 배너 -->
<div class="banner01">
	<a href="#"><img src="<?=NFE_URL;?>/images/banner6.jpg" alt=""></a>
</div>

<!-- 일반형 -->
<?php
$_width = 1;
$_height = 5;
$_total = 12;
$start = (($_GET['page']?$_GET['page']:1)-1)*$_total;
$_li_width = 100/$_width;

$con = " ".$resume_where['where'];
$q = "alice_alba_resume " . $_add['que'] . $con;
$query = sql_query("select * from ".$q." order by wr_wdate desc  limit ".$start.", ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_total, 'total'=>$total['c']));
$paging_group = ceil($total['c']/($_width*$_height));
?>
<section class="cont_box cont_list person1">
	<h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>Хүний нөөцийн мэдээлэл<em class="ad_btn"><a href="#"><span class="btn">Зар сурталчилгааны мэдээлэл<img src="/images/chevron.png" alt="Зар сурталчилгааны мэдээлэл"></span></a></em></h2>
	<ul class="cont_box_inner">
	<?php
	// li의ㅣ class ->  class="gold1",  class="gold2"
	switch($total['c']<=0) {
		case true:
		?>
		<li>
			<div class="text_box2">
				<div class="title"><img src="/images/info.png" alt="">Бүртгэгдсэн мэдээлэл байхгүй байна.</div>
			</div>
		</li>
		<?php
		break;

		default:
		while($row = sql_fetch_array($query)) {
			$_li_width = 100/$_width;
		?>
		<li style="width:<?=$_li_width;?>%;">
			<?php
			include "../include/inc/resume_box2.inc.php";
			?>
		</li>
		<?php }
		break;
	}
	?>
	</ul>
	<?=$paging;?>
</section>
<!-- //일반형 -->

<!-- 배너 -->
<div class="banner01">
	<a href="#"><img src="<?=NFE_URL;?>/images/banner1-5.jpg" alt=""></a>
</div>

<?php
include "../include/tail.php";
?>