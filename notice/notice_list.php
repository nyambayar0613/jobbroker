<?php
$head_title = "Зарлалын жагсаалт";
include_once "../include/top.php";
$netfu_util->session_put('notice_list');


$_width = 1;
$_height = ($_GET['page_rows']) ? $_GET['page_rows'] : 15;
$_total = $_width*$_height;
$_li_width = 100/$_width;
$_box_num = $_width*$_height;

$con = "1 ";
//$con = " and `wr_service_basic` >= curdate() ";
if($_GET['search_field']=='wr_subject||wr_content')
	$con .= " and (`wr_subject` like '%".addslashes($_GET['search_keyword'])."%' or `wr_content` like '%".addslashes($_GET['search_keyword'])."%')";
else if($_GET['search_field'])
	$con .= " and `".addslashes($_GET['search_field'])."` like '%".addslashes($_GET['search_keyword'])."%'";

$q = "`alice_notice` where " . $con;
$query = sql_query("select * from ".$q." order by `no` desc limit 0, ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = mysql_num_rows($query);

$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($total['c']/($_width*$_height));
?>

<!-- 공지사항 리스트 -->
<section class="cont_box community_txt">
<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/title_icon02.png" alt=""></span>Анхааруулга</h2>

<!-- 검색/분류 -->
	<form name="noticeListFrm" method="GET" id="noticeListFrm" action="<?=$_SERVER['PHP_SELF'];?>">
	<div class="sort_choice cf">
		<ul class="sort_inner cf">
			<li class="sort_select">
				<select name="search_field">
					<option value="wr_subject" <?=$_GET['search_field']=='wr_subject' ? 'selected' : '';?>>Гарчиг</option>
					<option value="wr_content" <?=$_GET['search_field']=='wr_content' ? 'selected' : '';?>>Агуулга</option>
					<option value="wr_subject||wr_content" <?=$_GET['search_field']=='wr_subject||wr_content' ? 'selected' : '';?>>Гарчиг+Агуулга</option>
					<option value="wr_name" <?=$_GET['search_field']=='wr_name' ? 'selected' : '';?>>Бичсэн</option>
				</select>
			</li>
			<li class="sort_sch">
				<input type="text" id="" name="search_keyword" value="<?=$_GET['search_keyword'];?>"><button type="button" onClick="document.forms['noticeListFrm'].submit()">Хайх</button>
			</li>
			<li class="sort_bx">
				<select name="page_rows" onChange="netfu_util1.page_rows(this)">
					<option value='15' <?=$_GET['page_rows']==15 ? 'selected' : '';?>>15ш хэвлэх</option>
					<option value='30' <?=$_GET['page_rows']==30 ? 'selected' : '';?>>30ш хэвлэх</option>
					<option value='50' <?=$_GET['page_rows']==50 ? 'selected' : '';?>>50ш хэвлэх</option>
					<option value='70' <?=$_GET['page_rows']==70 ? 'selected' : '';?>>70ш хэвлэх/option>
					<option value='100' <?=$_GET['page_rows']==100 ? 'selected' : '';?>>100ш хэвлэх</option>
				</select>
			</li>
		</ul>
	</div>
	</form>

	<ul class="cont_box_inner">
		<?php
		switch($total['c']<=0) {
			case true:
		?>
				<li>
					<div class="text_box2">
						<div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">.</div>
						<div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">Бүртгэлтэй мэдээлэл байхгүй байна.</div>
					</div>
				</li>
		<?php
				break;

			default:
				while($row=sql_fetch_array($query)) {
				?>
				<li>
					<div class="text_box">
						<div class="title"><a href="<?=NFE_URL;?>/notice/notice_view.php?no=<?=$row['no'];?>"><?=$netfu_util->get_stag($row['wr_subject']);?></a></div>
						<div class="info">
							<span class="name"><?=$netfu_util->get_stag($row['wr_name']);?></span>
							<span class="date"><?=$netfu_util->get_date('', $row['wr_date']);?></span>
							<span class="hit">Хайх <?=number_format($row['wr_hit']);?></span>
						</div>
					</div>
				</li>
				<?php
				}
				break;
		}
		?>
		<div class="paging_con cf"><div id="list_con-page" class="paging center"><?=$paging;?></div></div>
</section>

<?php
include_once(NFE_PATH.'/include/tail.php');
?>