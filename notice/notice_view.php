<?php
include_once "../include/top.php";

$notice_control->hitup_notice($n_row['no']);
$n_row = sql_fetch("select * from alice_notice where `no`='".addslashes($_GET['no'])."'");
?>

<!-- 공지사항 View -->
<section class="cont_box community_txt">
<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/title_icon02.png" alt=""></span>공지사항</h2>
<div class="community_inner cf">
	<div class="view_wrap">
		<div class="view_top cf">
			<div class="view_title">[<?=$netfu_util->notice_cate[$n_row['wr_type']];?>] <?=$netfu_util->get_stag($n_row['wr_subject']);?></div>
			<div class="view_info">
				<span class="mb_id"><strong><?=$netfu_util->get_stag($n_row['wr_name']);?></strong></span>
				<span><?=date("Y.m.d H:i", strtotime($n_row['wr_date']));?></span>
				<span class="hits">조회수 : <em><?=number_format($n_row['wr_hit']);?></em></span>
			</div>
		</div>
		<div class="view_con cf">
		  <?=stripslashes($n_row['wr_content']);?>
		</div>
	</div>
</div>

<div class="button-group view_bt">
	<ul>
		<li><a href="<?=NFE_URL;?>/notice/notice_list.php?<?=$netfu_util->session_get('notice_list');?>">목록보기</a></li>
	</ul>
</div>
</section>
<!-- // 공지사항 view -->





<?php
$_move_get = $netfu_util->session_get('notice_list');
$_move_get_arr = parse_str($_move_get, $_output);
//$_GET = $_output;
$_total = 15;
$con = "1 ";
//$con = " and `wr_service_basic` >= curdate() ";
if($_output['search_field']=='wr_subject||wr_content')
	$con .= " and (`wr_subject` like '%".addslashes($_output['search_keyword'])."%' or `wr_content` like '%".addslashes($_output['search_keyword'])."%')";
else if($_output['search_field'])
	$con .= " and `".addslashes($_output['search_field'])."` like '%".addslashes($_output['search_keyword'])."%'";

$q = "`alice_notice` where " . $con;
$query = sql_query("select * from ".$q." order by `no` desc limit 0, ".$_total);
$total = sql_fetch("select count(*) as c from ".$q);
$bunho = $total['c'] - ($_total*$_output['page']);
$list_num = mysql_num_rows($query);

$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_box_num, 'total'=>$total['c']));
$paging_group = ceil($total['c']/$_total);
?>
<!-- 리스트 -->
<section class="cont_box list_con">
<?php
switch($total['c']<=0) {
	case true:
		break;


	default:
		while($row=sql_fetch_array($query)) {
?>
<div class="list_inner cf">
	<div class="lt_num"><?=$bunho--;?></div>
	<ul class="cont_box_inner">
		<li>
			<div class="text_box">
				<div class="title"><a href="<?=NFE_URL;?>/notice/notice_view.php?no=<?=$row['no'];?>">[<?=$netfu_util->notice_cate[$row['wr_type']];?>] <?=$netfu_util->get_stag($row['wr_subject']);?></a><span class="n_date"><?=$netfu_util->get_stag($row['wr_name']);?></span></div>
			</div>
		</li>
	</ul>
</div>
<?php
		}
		break;

}
?>


<div class="paging_con cf"><div id="list_con-page" class="paging center"><?=$paging;?></div></div>

</section>

<!-- //리스트 --> 

<?php
include_once(NFE_PATH.'/include/tail.php');
?>