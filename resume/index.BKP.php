<?php
$head_title = "인재정보";
if($_GET['code']=='hurry') $head_title = "급구 인재정보";
if($_GET['code']=='area') $head_title = "지역별 인재정보";
if($_GET['code']=='job_type') $head_title = "업직종별 인재정보";
if($_GET['code']=='date') $head_title = "기간별 인재정보";
if($_GET['code']=='search') $head_title = "상세검색 인재정보";

include_once "../include/top.php";

$resume_where = $netfu_mjob->resume_search_func();
?>


<!-- 검색 -->
<?php
include NFE_PATH.'/include/inc/resume_search.inc.php';

//include NFE_PATH.'/include/inc/job_search.inc.php';
?>

<!-- //검색 -->

<!-- 포커스형 -->
<?php
// : 포커스 인재정보
$_banner = 'main_focus';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/resume_service1.inc.php';

/*
$_width = 3;
$_height = 2;
$_total = 12;
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$con = " and `wr_service_main_focus`>=curdate() ".$resume_where['where'];
$q = "alice_member as am right join alice_alba_resume as aar on am.`mb_id`=aar.`wr_id` where " . $netfu_mjob->resume_where . $con;
$query = sql_query("select * from ".$q." order by wr_wdate desc limit 0, ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = mysql_num_rows($query);
$_total = $netfu_util->get_remain($list_num, $_box_num, $_width);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($list_num/($_width*$_height));

//$_count = '<em>'.$netfu_util->start_slide_num($paging_group).'</em>/'.$paging_group.'건';
$_count = '';
if($total['c']>0) {
?>
<style type="text/css">
.reservice1__ li { position:relative; border:1px solid #<?=$design['main_focus_border_color'];?> !important; z-index:9 !important; margin-left:-1px; }
.reservice1__ li:nth-child(n+4) { margin-top:-1px; }
.reservice1__ .bg_ { background-color:#<?=$design['main_focus_background_color'];?>;  }
.reservice1__ ul li.gold2 { border:1px solid #<?=$design['main_focus_border_gold_color'];?> !important; z-index:99 !important; } 
.reservice1__ .gold2 .bg_ { background-color:#<?=$design['main_focus_background_gold_color'];?>; }
</style>
<?php }?>
<section class="cont_box focus_con">
	<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$netfu_util->icon_tit('title_icon01');?>.png" alt=""></span>포커스 인재정보<span class="bt_box"><?=$_count;?> <a href="<?=NFE_URL;?>/payment/guide.php?code=individual"><span class="btn">광고안내<img src="<?=NFE_URL;?>/images/chevron.png" alt="광고안내"></span></a></span></h2>
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
				<div class="title"><img src="<?=NFE_URL;?>images/info.png" alt="">등록된 내용이 없습니다.</div>
			</div>
		</li>
		<?php
		break;

	default:
		for($i=0; $i<$_total; $i++) {
			$row = sql_fetch_array($query);
			$_li_width = 100/$_width;
			echo $i%$_box_num==0 ? '<ul class="focus_box cont_box_inner" style="width:100% !important;">'."\n" : '';
			$_gold = $row['wr_service_main_focus_gold']>=date("Y-m-d") ? 'gold2' : 'gold1'; // : 골드 클래스값
		?>
		<li style="width:<?=$_li_width;?>%;" class="<?=$_gold;?>">
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
<?php
if($total['c']>0) {
?>
<script type="text/javascript">
var _width = $(".reservice1__").find("ul").width();
$(".reservice1__").find("ul").css({"width":(_width+3)+'px'});
var _width = $(".reservice1__").find("ul").width();
</script>
<?php }
*/
?>


<!-- 일반형 -->
<?php
$_banner = 'resume_indi_list_top';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/re_service2.inc.php';




$_banner = 'resume_indi_list_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';
?>





<?php
include "../include/tail.php";
?>