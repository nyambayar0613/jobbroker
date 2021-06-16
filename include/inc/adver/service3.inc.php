<?php
// : 스페셜 상단
if(!$design['main_special_use']) return false;

$_width = $design['main_special_row'];
$_height = $design['main_special_row2'];
$_total = $design['main_special_total'];
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$con = " and `wr_service_special` >= curdate()";
$con .= $job_where['where'];
$q = "alice_alba where " . $netfu_mjob->job_where . $con;
$query = sql_query("select * from ".$q." order by wr_jdate desc limit 0, ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = sql_num_rows($query);
$_total = $netfu_util->get_remain($list_num, $_box_num, $_width);

$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($total['c']/($_width*$_height));

//$_count = '<em>'.$netfu_util->start_slide_num($total['c']).'</em>/'.$paging_group.'건';
$_count = '';
if($total['c']>0) {
?>

<style type="text/css">
.service3__ li {position:relative; border-top:1px solid #<?=$design['main_special_border_color'];?> !important; border-left:1px solid #<?=$design['main_special_border_color'];?> !important; border-right:1px solid #<?=$design['main_special_border_color'];?> !important; border:1px solid #<?=$design['main_special_border_color'];?> !important; z-index:9 !important; }
.service3__ li:nth-child(n+2) { margin-top:-1px !important; }
.service3__ .bg_ { background-color:#<?=$design['main_special_background_color'];?>;  }
.service3__ a,
.service3__ div,
.service3__ span,
.service3__ p,
.service3__ em { color:#<?=$design['main_grand_font_color'];?>; }

.service3__ ul li.gold2 { border:1px solid #<?=$design['main_special_border_gold_color'];?> !important; z-index:99 !important; } 
.service3__ .gold2 .bg_ { background-color:#<?=$design['main_special_background_gold_color'];?>; }
.service3__ .gold2 a,
.service3__ .gold2 div,
.service3__ .gold2 span,
.service3__ .gold2 p,
.service3__ .gold2 em { color:#<?=$design['main_special_font_gold_color'];?>; }

@media screen and (max-width:700px){
.service3__ li{border-right:0 !important;border-left:0 !important}
}

</style>
<?php }?>
<section id="service3__" class="service3__ cont_box _con webzine_con web1 special_con">
	<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$netfu_util->icon_tit('title_icon01');?>.png" alt=""></span>Special ажлын байр <span class="bt_box"><?=$_count;?> <!--em class="ad_btn"--><a href="<?=NFE_URL;?>/etc/adver.php"><span class="btn">광고안내<img src="<?=NFE_URL;?>/images/chevron.png" alt="광고안내"></span></a><!--/em--></h2>
	<div class="cycle-slideshow" 
	data-cycle-pause-on-hover="true"
	data-cycle-slides="ul.special_box"
	data-cycle-timeout=0
	data-cycle-swipe=true
	data-cycle-swipe-fx=scrollHorz
	data-cycle-pager="#special_con-page"
	data-cycle-pager-template="<a> {{slideNum}} </a>"
	>
	<?php
	// li의ㅣ class ->  class="gold1",  class="gold2"
	switch($total['c']<=0) {
		case true:
		?>
			<li class="sp_li2" style="width:100% !important">
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
			echo $i%$_box_num==0 ? '<ul class="special_box cont_box_inner" style="width:100% !important;">'."\n" : '';
			$_gold = $row['wr_service_special_main_gold']>=date("Y-m-d") ? 'gold2' : 'gold1'; // : 골드 클래스값
		?>
			<li style="width:<?=$_li_width;?>%" class="<?=$_gold;?>">
				<?php
				include NFE_PATH."/include/inc/job_box3.inc.php";
				?>
			</li>
		<?php
			echo $i%$_box_num==$_box_num-1 ? '</ul>'."\n" : '';
		}
		break;
	}
	?>
	</div>
	<div class="paging_con cf"><div id="special_con-page" class="paging center"></div></div>
</section>
<!-- //스페셜 -->