<?php
if(!$design['main_grand_use']) return false;

$_width = $design['main_grand_row'];
$_height = $design['main_grand_row2'];
$_total = $design['main_grand_total'];
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$con = " and `wr_service_grand` >= curdate()";
$con .= $job_where['where'];
$q = "alice_alba where " . $netfu_mjob->job_where . $con;
$query = sql_query("select * from ".$q." order by wr_jdate desc limit 0, ".$_total);
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
.service2__ li { position:relative; border:1px solid #<?=$design['main_grand_border_color'];?> !important; }
.service2__ .bg_ { background-color:#<?=$design['main_grand_background_color'];?>;  }
.service2__ a,
.service2__ div,
.service2__ span,
.service2__ p { color:#<?=$design['main_grand_font_color'];?>; }
.service2__ ul li.gold2 { border:1px solid #<?=$design['main_grand_border_gold_color'];?> !important; z-index:99 !important; } 
.service2__ .gold2 .bg_ { background-color:#<?=$design['main_grand_background_gold_color'];?>; }
.service2__ .gold2 a,
.service2__ .gold2 div,
.service2__ .gold2 span,
.service2__ .gold2 p { color:#<?=$design['main_grand_font_gold_color'];?>; }
</style>
<?php }?>
<section class="service2__ cont_box banner_con grand_con">
	<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$netfu_util->icon_tit('title_icon01');?>.png" alt=""></span>그랜드형 구인정보<span class="bt_box"><?=$_count;?> <a href="<?=NFE_URL;?>/etc/adver.php"><span class="btn">광고안내<img src="<?=NFE_URL;?>/images/chevron.png" alt="광고안내"></span></a></span></h2>
	<div class="cycle-slideshow" 
	data-cycle-pause-on-hover="true"
	data-cycle-slides="ul.grand_box"
	data-cycle-timeout=0
	data-cycle-swipe=true
	data-cycle-swipe-fx=scrollHorz
	data-cycle-pager="#grand_con-page"
	data-cycle-pager-template="<a> {{slideNum}} </a>"
	>
	<?php
	// li의ㅣ class ->  class="gold1",  class="gold2"
	switch($total['c']<=0) {
		case true:
		?>
			<li>
				<div class="text_box2">
					<div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="info">등록된 내용이 없습니다.</div>
				</div>
			</li>
		<?php
		break;

		default:
		for($i=0; $i<$_total; $i++) {
			$row = sql_fetch_array($query);
			$_li_width = 100/$_width;
			echo $i%$_box_num==0 ? '<ul class="grand_box cont_box_inner" style="width:100% !important;">'."\n" : '';
			$_gold = $row['wr_service_grand_main_gold']>=date("Y-m-d") ? 'gold2' : 'gold1'; // : 골드 클래스값
		?>
			<li style="width:<?=$_li_width;?>%" class="<?=$_gold;?>">
				<?php
				include NFE_PATH."/include/inc/job_box2.inc.php";
				?>
			</li>
		<?php
			echo $i%$_box_num==$_box_num-1 ? '</ul>'."\n" : '';
		}
		break;
	}
	?>
	</div>
	<div class="paging_con cf"><div id="grand_con-page" class="paging center"></div></div>
</section>
<!-- //그랜드형 -->