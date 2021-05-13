<?php
$page_code = 'sub';
if($_SERVER['PHP_SELF']=='/index.php') $page_code = 'main';
if(!$design['main_bottom_alba_use'] && $page_code=='main') return false;

// : 일반형
if(!$_page) $_page = 'page';
$_width = 1;
$_height = $design['main_bottom_alba_total'];
$_total = $design['main_bottom_alba_total'];
$_li_width = 100/$_width;
$_box_num = $_width*$_height;
$start = $netfu_util->_paging_start($_GET[$_page], $_height);

$con = "";
$service_check = $service_control->service_check('main_basic');
$con = ($service_check['is_pay'] == 1) ? " and ( `wr_service_platinum` >= curdate() or `wr_service_grand` >= curdate() or `wr_service_special` >= curdate() or `wr_service_basic` >= curdate() ) " : "";
$con .= $job_where['where'];
$q = "alice_alba where " . $netfu_mjob->job_where . $con;
$query = sql_query("select * from ".$q." order by wr_jdate desc limit ".$start.", ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = mysql_num_rows($query);

$paging = $netfu_util->_paging_(array('var'=>$_page, 'num'=>$_box_num, 'total'=>$total['c'], 'hash'=>'em_list_'));
$paging_group = ceil($total['c']/($_width*$_height));

$page_view = true;
if(strpos($_SERVER['PHP_SELF'], 'main/search.php')!==false) {
	if($total['c']<=0) return false; // : 검색결과가 없으면 출력하지 않습니다.
	$page_view = false;
}

if(!$title_txt)
	$title_txt = (array_key_exists($_GET['code'], $netfu_mjob->sub_title['job']) ? $netfu_mjob->sub_title['job'][$_GET['code']] : '일반형').' 구인정보';
?>
<!-- 일반형 -->
<section class="cont_box cont_list recruit1">
	<h2 id="em_list_<?=$_page ? $_page : 'page';?>"><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$netfu_util->icon_tit('title_icon01');?>.png" alt=""></span><?=$title_txt?><span class="bt_box"><a href="<?=NFE_URL;?>/etc/adver.php"><span class="btn">광고안내<img src="<?=NFE_URL;?>/images/chevron.png" alt="광고안내"></span></a></span></h2>
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
			$i = 0;
		?>
		<ul class="list_box cont_box_inner" style="width:100% !important;">
		<?php
			while($row=sql_fetch_array($query)) {
				$_li_width = 100/$_width;
			?>
			<li style="width:<?=$_li_width;?>% !important;">
				<?php
				include NFE_PATH."/include/inc/job_box4.inc.php";
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

		// : 더보기
		if($more_view) {
		?>
		<ul class="list_box cont_box_inner">
		<li>
			<div class="text_box2">
				<div class="title" id="sch_result_more"><a href="<?=NFE_URL;?>/job/index.php?top_keyword=<?=urlencode($_GET['top_keyword']);?>"><em>검색결과 더보기</em></a></div>
			</div>
		</li>
		</ul>
		<?php
		}
		?>
	</div>
	<?php
	// : 페이징
	if($page_view) {
	?>
	<div class="paging_con cf"><div id="list_con-page" class="paging center"><?=$paging;?></div></div>
	<?php
	}
	?>
</section>
<!-- //일반형 -->


<?php
$view_count++;
$title_txt = '';
?>