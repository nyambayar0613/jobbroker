<!-- 일반형 인재정보 -->
<?php
$_width = 1;
$_height = $design['main_bottom_resume_total'];
$_total = $design['main_bottom_resume_total'];
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$con = "";//" and `wr_service_list` >= curdate()";
$q = "alice_member as am right join alice_alba_resume as aar on am.`mb_id`=aar.`wr_id` where " . $netfu_mjob->resume_where . $con;
$q .= " and wr_service_basic>=curdate()";
$query = sql_query("select * from ".$q." order by wr_jdate desc, wr_wdate desc limit 0, ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = sql_num_rows($query);
$_total = $netfu_util->get_remain($list_num, $_box_num, $_width);

//$_count = '<em>'.$netfu_util->start_slide_num($total['c']).'</em>/'.$paging_group.'건';
$_count = '';
?>
<section class="cont_box cont_list recruit1">
<?php
$paging = $netfu_util->_paging_(array('var'=>'page1', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($list_num/($_width*$_height));
?>
	<h2><span class="tit_ico"><img src="images/<?=$netfu_util->icon_tit('title_icon01');?>.png" alt=""></span>일반형 인재정보<span class="bt_box"><?=$_count;?> <a href="<?=NFE_URL;?>/etc/adver.php?code=individual"><span class="btn">광고안내<img src="images/chevron.png" alt="광고안내"></span></a></span></h2>
	<div>
	<?php
	// li의ㅣ class ->  class="gold1",  class="gold2"
	switch($total['c']<=0) {
		case true:
		?>
			<li>
				<div class="text_box2">
					<div class="title"><img src="images/info.png" alt="">등록된 내용이 없습니다.</div>
				</div>
			</li>
		<?php
		break;

		default:
			$i = 0;
			?>
			<ul class="list_box cont_box_inner" style="width:100% !important;">
			<?php
			while($row = sql_fetch_array($query)) {
				$_li_width = 100/$_width;
			?>
				<li style="width:100%;" class="cf text_box2_li">
				<?php
				include NFE_PATH."/include/inc/resume_box2.inc.php";
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
	<div class="paging_con cf"><div id="list_con-page" class="paging center"><?=$paging;?></div></div>
</section>
<!-- //일반형 인재정보 -->