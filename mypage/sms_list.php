<?php
$head_title = $_GET['code']=='get' ? 'SMS 문자수신 현황' : 'SMS 문자발송 현황';
include_once '../conn.php';

$_get = $netfu_util->input_htmlspecialchars($_GET);

$_GET['code'] = $_GET['code'] ? $_GET['code'] : 'get';
$page_code = 'mypage';
$menu_text = "SMS 문자".$netfu_util->sms_type_arr[$_GET['code']]." 현황";

include_once "../include/top.php";

// : 쿼리문
$_limit = 10;
$_limit = $_GET['_limit']>0 ? $_GET['_limit'] : 20;
$_where = "";
if($_GET['_sdate']) $_where .= " and `wr_wdate`>='".addslashes($_GET['_sdate'])."'";
if($_GET['_edate']) $_where .= " and `wr_wdate`<='".addslashes($_GET['_edate'])."'";
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
if($_GET['code']=='get') $_where .= " and `wr_receive`='".$member['mb_id']."'";
else $_where .= " and `wr_id`='".$member['mb_id']."'";
$q = "alice_sms_log where 1 ".$_where;
$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
$query = sql_query("select * from ".$q." order by `no` desc limit ".$_start.", ".$_limit);
$total = sql_fetch("select count(*) as c from ".$q);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c'], 'type'=>'not_bg'));

parse_str($_SERVER['QUERY_STRING'], $_para_arr);
unset($_para_arr['_limit']);
unset($_para_arr['page']);
$_para = http_build_query($_para_arr, '', '&amp;');
?>
<script type="text/javascript">
var move_page = function(el) {
	var url = "./sms_list.php?"+decodeURIComponent("<?=$_para;?>")+"&_limit="+el.value+"&page=1";
	location.href = "./sms_list.php?"+decodeURIComponent("<?=$_para;?>")+"&_limit="+el.value+"&page=1";
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

<section class="cont_box resume_list">
	<div class="resume_list_con cf">
		<form name="fsearch" action="<?=$_SERVER['PHP_SELF'];?>" method="get">
		<input type="hidden" name="code" value="<?=$_GET['code'];?>" />
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
		<ul class="list_con list_sch">
			<h3>조회기간</h3>
			<li>
				<ol>
					<li><a href="#none;" onClick="netfu_util1.date_put('<?=date("Y-m-d", strtotime("-1 week"));?>')">최근 1주일</a></li>
					<li><a href="#none;" onClick="netfu_util1.date_put('<?=date("Y-m-d", strtotime("-1 month"));?>')">최근 1개월</a></li>
					<li><a href="#none;" onClick="netfu_util1.date_put('<?=date("Y-m-d", strtotime("-3 month"));?>')">최근 3개월</a></li>
				</ol>
			</li>
			<li class="ymd">
				<ol>
					<li><input type="text" name="_sdate" class="tday hasDatepicker" readOnly value="<?=$_get['_sdate'];?>"></li>
					<li class="date_list_txt">부터 ~</li>
					<li><input type="text" name="_edate" class="tday hasDatepicker" readOnly value="<?=$_get['_edate'];?>"></li>
					<li class="date_list_txt">까지</li>
					<li>
						<button class="plus_bt" onClick="document.forms['fsearch'].submit()"><img src="<?=NFE_URL;?>/images/search_icon.png" alt="조회기간 검색">검색</button>
					</li>
				</ol>
			</li>
		</ul>
		<ul class="list_con sms_con cf">
			<li><input type="radio" id="sms" name="sms_type" checked="checked"><label for="sms">SMS</label></li>
			<li><input type="radio" id="lms" name="sms_type"><label for="lms">LMS</label></li>
		</ul>
		</form>



		<form name="flist">
		<?php
		switch($total['c']<=0) {
			case true:
		?>
		<ul class="list_con">
			<li class="col2 none">
				<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">발송 내역이 없습니다.</div>
			</li>
		</ul>
		<?php
				break;



			default:
				while($row=sql_fetch_array($query)) {
					$_name = $_GET['code']=='get' ? 'wr_receive_name' : 'wr_name';
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2">
			  <div class="profile_name pfn"><?=$row[$_name];?></div>
				<div class="list_txt list_color" style="font-family:'NG'"><?=$netfu_util->get_stag($row['wr_content']);?></div>
			</li>
			<li class="col3">
				<div class="date_box date_box2 dbx-style cf"> 
					<div class="con1 cf">
						<div class="date-bx"><?=$netfu_util->get_date('dot', $row['wr_wdate']);?></div>
					</div>
				</div>
			</li>
		</ul>
		<?php
				}
				break;
		}
		?>
		<?=$paging;?>
		</form>
	</div>
</section>

<div class="button_con button_con3">
	<a href="#none;" onClick="netfu_mjob.sms_all_delete()" class="bottom_btn03">삭제</a>
</div>

<?php
include "../include/tail.php";
?>