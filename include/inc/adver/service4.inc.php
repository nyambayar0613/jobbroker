<?php
$page_code = 'sub';
if($_SERVER['PHP_SELF']=='/index.php') $page_code = 'main';
if(!$design['main_bottom_alba_use'] && $page_code=='main') return false;

$_width = 1;
$_height = $design['main_bottom_alba_total'];
$_total = $design['main_bottom_alba_total'];
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$service_check = $service_control->service_check('main_basic');
$con = ($service_check['is_pay'] == 1) ? " and ( `wr_service_platinum` >= curdate() or `wr_service_grand` >= curdate() or `wr_service_special` >= curdate() or `wr_service_basic` >= curdate() ) " : "";
$q = "alice_alba where " . $netfu_mjob->job_where . $con;
$query = sql_query("select * from ".$q." order by wr_jdate desc limit 0, ".$_total);

$total = sql_fetch("select count(*) as c from ".$q);
$list_num = sql_num_rows($query);
$_total = $netfu_util->get_remain($list_num, $_box_num, $_width);

$paging = $netfu_util->_paging_(array('var'=>'page0', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($list_num/($_width*$_height));

//$_count = '<em>'.$netfu_util->start_slide_num($total['c']).'</em>/'.$paging_group.'건';
$_count = '';
?>
<!-- 일반형구인상단 배너 -->
<section class="cont_box cont_list recruit1">
	<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$netfu_util->icon_tit('title_icon01');?>.png" alt=""></span>일반형 구인정보<span class="bt_box"><?=$_count;?> <a href="<?=NFE_URL;?>/payment/guide.php?"><span class="btn">광고안내<img src="<?=NFE_URL;?>/images/chevron.png" alt="광고안내"></span></a></span></h2>
	<div>
	<?php
	// li의ㅣ class ->  class="gold1",  class="gold2"
	switch($total['c']<=0) {
		case true:
		?>
			<li>
				<div class="text_box2">
					<div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">등록된 내용이 없습니다.</div>
				</div>
			</li>
		<?php
		break;

		default:
		?>
		<ul class="list_box cont_box_inner" style="width:100% !important;">
		<?php
			while($row = sql_fetch_array($query)) {
			?>
				<li style="width:100%;position:relative;" class="bxli">
				<?php
				include "./include/inc/job_box4.inc.php";
				?>
				</li>
			<?php
				$i++;
			}
		?>
		</ul>
		<?php
			break;
		}
	?>
	</div>
	<?php
	if($paging_group>1) {
	?>
	<div class="paging_con cf"><div id="list_con-page" class="paging center"><?=$paging;?></div></div>
	<?php }?>
</section>
<!-- //일반형 구인정보 -->