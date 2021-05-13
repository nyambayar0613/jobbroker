<!-- 일반형 -->
<?php
$page_code = 'sub';
if($_SERVER['PHP_SELF']=='/index.php') $page_code = 'main';
if(!$design['main_bottom_resume_use'] && $page_code=='main') return false;

if(!$var_page) $var_page = 'page';

$_width = 1;
$_height = $design['main_bottom_resume_total'];
$_total = $_width*$_height;
$start = $netfu_util->_paging_start($_GET[$var_page], $_height);
$_li_width = 100/$_width;

$con = " ".$resume_where['where'];
$q = "alice_member as am right join alice_alba_resume as aar on am.`mb_id`=aar.`wr_id` where " . $netfu_mjob->resume_where . $con;
$service_check = $service_control->service_check('alba_resume_basic');
if($service_check['is_pay'] == 1) {
$q .= " and ( `wr_service_main_focus`>=curdate() or wr_service_basic>=curdate() )";
}
$query = sql_query("select * from ".$q." order by wr_jdate desc, wr_wdate desc  limit ".$start.", ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$paging = $netfu_util->_paging_(array('var'=>$_page, 'num'=>$_box_num, 'total'=>$total['c'], 'hash'=>'em_list_'));
$paging_group = ceil($total['c']/($_width*$_height));

$page_view = true;
if(strpos($_SERVER['PHP_SELF'], 'main/search.php')!==false) {
	if($total['c']<=0) return false; // : 검색결과가 없으면 출력하지 않습니다.
	$page_view = false;
}

if(!$title_txt)
	$title_txt = (array_key_exists($_GET['code'], $netfu_mjob->sub_title['resume']) ? $netfu_mjob->sub_title['resume'][$_GET['code']] : '일반형').' 인재정보';
?>

<section class="cont_box cont_list person1">
	<h2 id="em_list_<?=$_page ? $_page : 'page';?>"><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$netfu_util->icon_tit('title_icon01');?>.png" alt=""></span><?=$title_txt;?><em class="bt_box"><a href="<?=NFE_URL;?>/etc/adver.php?code=individual"><span class="btn">광고안내<img src="/images/chevron.png" alt="광고안내"></span></a></em></h2>
	<ul class="cont_box_inner">
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
		while($row = sql_fetch_array($query)) {
			$_li_width = 100/$_width;
		?>
		<li style="width:<?=$_li_width;?>%;">
			<?php
			include NFE_PATH."/include/inc/resume_box2.inc.php";
			?>
		</li>
		<?php }
		break;
	}


	if($more_view) {
	?>
	<li>
		<div class="text_box2">
			<div class="title" id="sch_result_more">
				<a href="<?=NFE_URL;?>/resume/index.php?top_keyword=<?=urlencode($_GET['top_keyword']);?>"><em>인재정보 검색결과 더보기</em></a>
			</div>
		</div>
	</li>
	<?php
	}
	?>
	</ul>
	<?php
	if($page_view) echo $paging;
	?>
</section>
<!-- //일반형 -->


<?php
$view_count++;
$title_txt = '';
?>