<?php
$head_title = '유료이용내역';
$page_code = 'mypage';
include "../include/top.php";

$_get = $netfu_util->input_htmlspecialchars($_GET);

// : 쿼리문
$_where = " and `pay_uid` = '".$member['mb_id']."' and `pay_status` = '1' and `pay_pg` != 'admin' and `pay_method` != 'service' and `is_delete` = 0";
if($_GET['_sdate']) $_where .= " and `pay_sdate`>='".addslashes($_GET['_sdate'])."'";
if($_GET['_edate']) $_where .= " and `pay_sdate`<='".addslashes($_GET['_edate'])."'";
$q = "`alice_payment` where 1 ".$_where;
$total = sql_fetch("select count(*) as c from ".$q);
$_limit = $_GET['_limit']>0 ? $_GET['_limit'] : 20;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
$query = sql_query("select * from ".$q." order by `no` desc limit ".$_start.", ".$_limit);
$list_num = mysql_num_rows($query);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c']));

parse_str($_SERVER['QUERY_STRING'], $_para_arr);
unset($_para_arr['_limit']);
unset($_para_arr['page']);
$_para = http_build_query($_para_arr, '', '&amp;');
?>
<script type="text/javascript">
var move_page = function(el) {
	var url = "./payment_list.php?"+decodeURIComponent("<?=$_para;?>")+"&_limit="+el.value+"&page=1";
	location.href = "./payment_list.php?"+decodeURIComponent("<?=$_para;?>")+"&_limit="+el.value+"&page=1";
}
</script>
<section class="cont_box detail_con">
<?php
if($member['mb_type']=='company') {
	include NFE_PATH.'/include/inc/my_company_info.inc.php';
	include NFE_PATH.'/include/inc/my_company_count.inc.php';
} else {
	include NFE_PATH.'/include/inc/member_info.inc.php';
	include NFE_PATH.'/include/inc/my_resume_count.inc.php';
}
?>
</section>

<!-- 유료이용내역 검색 -->
<form name="fsearch" action="<?=$_SERVER['PHP_SELF'];?>" method="get">
<section class="cont_box use_con">
	<h2>유료이용내역</h2>
	<div class="date_wrap cf">
		<div class="btn_group">
			<button type="button" onClick="netfu_util1.date_put('<?=date("Y-m-d", strtotime("-1 week"));?>')">최근1주일</button>
			<button type="button" onClick="netfu_util1.date_put('<?=date("Y-m-d", strtotime("-1 month"));?>')">최근1개월</button>
			<button type="button" onClick="netfu_util1.date_put('<?=date("Y-m-d", strtotime("-3 month"));?>')">최근3개월</button>
		</div>
		<div class="date_group date_gr">
			<ul>
				<li><input type="text" name="_sdate" class="datepicker_inp" readOnly value="<?=$_get['_sdate'];?>"></li>
				<li class="date_list_txt">부터 ~</li>
				<li><input type="text" name="_edate" class="datepicker_inp" readOnly value="<?=$_get['_edate'];?>"></li>
				<li class="date_list_txt">까지</li>
			</ul>
		</div>

		<div class="search_btn3 cf"><button type="button" onClick="document.forms['fsearch'].submit()"><img src="<?=NFE_URL;?>/images/search_icon.png">검색</button></div>
	</div>
</section>
</form>

<!-- 유료이용내역 -->
<section class="cont_box resume_list">

	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="sort_st sort_st2">
				<span>
					<select name="_limit" onChange="move_page(this)">
						<option value="20">20개씩 보기</option>
						<option value="40" <?=$_GET['_limit']==40 ? 'selected' : '';?>>40개씩 보기</option>
						<option value="60" <?=$_GET['_limit']==60 ? 'selected' : '';?>>60개씩 보기</option>
						<option value="80" <?=$_GET['_limit']==80 ? 'selected' : '';?>>80개씩 보기</option>
						<option value="100" <?=$_GET['_limit']==100 ? 'selected' : '';?>>100개씩 보기</option>
					</select>
				</span>
			</li>
		</ul>

		<?php
		switch($total['c']<=0) {
			case true:
		?>
		<ul class="list_con">
			<li class="col2 none">
				<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">검색된 유료이용내역이 없습니다.</div>
			</li>
		</ul>
		<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
					$pay_sdate = $netfu_util->get_date('dot', $row['pay_sdate']);
					$list = $payment_control->payment_listing($row['no']);	// 결제정보
		?>
		<ul class="list_con">
			<li class="col2 col2-1 no_chk2">
				<?php
				echo ($val['pay_service']=='direct')?"<p class='pl5'>다이렉트 결제</p>":@implode($list['user'],"<br/>");
				?>
				<div class="list_etc">
					<span><?=$netfu_util->pay_method[$row['pay_method']];?></span><span><?=$row['pay_sdate'];?></span><span><em><?=number_format($row['pay_price']);?>원</em></span>
				</div>
			</li>
		</ul>
		<?php
				}
				break;
		}
		?>

		
		<?=$paging;?>
	</div>
</section>

<?php
include "../include/tail.php";
?>