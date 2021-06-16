<?php
if(!$design['main_focus_use']) return false;

$_width = 3;
$_height = intval($design['main_focus_total']/3);
$_total = $design['main_focus_total'];
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$con = " and `wr_service_main_focus`>=curdate()";
$q = "alice_member as am right join alice_alba_resume as aar on am.`mb_id`=aar.`wr_id` where " . $netfu_mjob->resume_where . $con;
$query = sql_query("select * from ".$q." order by wr_jdate desc, wr_wdate desc limit 0, ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = sql_num_rows($query);
$_total = $netfu_util->get_remain($list_num, $_box_num, $_width);

$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($list_num/($_width*$_height));

//$_count = '<em>'.$netfu_util->start_slide_num($total['c']).'</em>/'.$paging_group.'건';
$_count = '';

if($total['c']>0) {
?>
<style type="text/css">
.reservice1__ li { border:1px solid #<?=$design['main_focus_border_color'];?> !important; }
.reservice1__ .bg_ { background-color:#<?=$design['main_focus_background_color'];?>; }
.reservice1__ a,
.reservice1__ div,
.reservice1__ span,
.reservice1__ p,
.reservice1__ em { color:#<?=$design['main_focus_font_color'];?>; }
.reservice1__ ul li.gold2 { border:1px solid #<?=$design['main_focus_border_gold_color'];?> !important; z-index:99 !important; } 
.reservice1__ .gold2 .bg_ { background-color:#<?=$design['main_focus_background_gold_color'];?>; }
.focus_con.reservice1__ .gold2 a,
.focus_con.reservice1__ .gold2 div,
.focus_con.reservice1__ .gold2 span,
.focus_con.reservice1__ .gold2 p,
.focus_con.reservice1__ .gold2 em { color:#<?=$design['main_focus_font_gold_color'];?>; }
</style>
<?php }?>

<section class="reservice1__ cont_box focus_con">
	<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$netfu_util->icon_tit('title_icon01');?>.png" alt=""></span>Focus хүний нөөцийн мэдээлэл<span class="bt_box"><?=$_count;?> <a href="<?=NFE_URL;?>/etc/adver.php?code=individual"><span class="btn">광고안내<img src="<?=NFE_URL;?>/images/chevron.png" alt="Зар сурталчилгаа"></span></a></span></h2>
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
                <div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">Бүртгэлтэй мэдээлэл байхгүй байна.</div>
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
			<li style="width:<?=$_li_width;?>%; !important" class="<?=$_gold;?>">
				<?php
				include NFE_PATH."/include/inc/resume_box1.inc.php";
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