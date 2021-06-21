<?php
$head_title = "스크랩구인정보";
$page_code = 'mypage';
include "../include/top.php";

// : 쿼리문
$_limit = 10;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_where = " and `mb_id`='".$member['mb_id']."' and scrap_rel_table='alba'";
$q = "`alice_scrap` where 1 ".$_where;
$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
$query = sql_query("select * from ".$q." order by `no` desc limit ".$_start.", ".$_limit);
$total = sql_fetch("select count(*) as c from ".$q);
$list_num = mysql_num_rows($query);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c']));
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/mjob.class.js?time=<?=time();?>"></script>
<section class="cont_box detail_con">
	<?php
	include NFE_PATH.'/include/inc/member_info.inc.php';

	include NFE_PATH.'/include/inc/my_resume_count.inc.php';
	?>
</section>

<form name="flist">
<section class="cont_box resume_list">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 active"><a href="#">스크랩구인정보<span class="list_num"><?=number_format($total['c']);?></span></a></li>
			<!-- <li class="tab02"><a href="#"></a></li> -->
		</ul>

		<?php
		switch($total['c']<=0) {
			case true:
		?>
		<ul class="list_con">
			<li class="col2 none">
				<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">스크랩 정보가 없습니다.</div>
			</li>
		</ul>
		<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
					$alba_row = sql_fetch("select * from alice_alba where `no`='".$row['scrap_rel_id']."'");
					$job_info = $netfu_mjob->get_alba($alba_row);

					// : 지역
					$_area_arr = explode("/", $alba_row['wr_area_0']);
					$area_arr = $netfu_util->get_cate($_area_arr);
					$area_txt = $area_arr[0].' '.$area_arr[1];

					$wr_pay = number_format($alba_row['wr_pay'])."원";
					$wr_pay_type = $category_control->get_categoryCode($alba_row['wr_pay_type']);
					$wr_pay_txt = ($alba_row['wr_pay_conference']) ? '<i>'.$alba_user_control->pay_conference[$alba_row['wr_pay_conference']].'</i>' : '<i>'.$wr_pay_type['name'].'</i> <em>'.$wr_pay.'</em>';
		?>
		<ul class="list_con _<?=!$row ? 'none' : '';?>">
			<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2 col4"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['scrap_rel_id'];?>">
				<div class="company_name"><?=$alba_row ? strip_tags(stripslashes($alba_row['wr_company_name'])) : '삭제된 채용정보입니다.';?></div>
				<div class="list_txt"><?=strip_tags(stripslashes($alba_row['wr_subject']));?></div>
				<div class="list_etc">
					<span>
					<?php
					echo $area_txt;
					?></span><span><?=$job_info['volume_text'];?></span>
				</div>
				<div class="list_etc">
					<span>스크랩 <?=$netfu_util->get_date('dot', $row['wdate']);?></span><span><?=$wr_pay_txt;?></span>
				</div>
			</a></li>
		</ul>
		<?php
				}
				break;
		}
		?>

		<?=$paging;?>
	</div>
</section>

<div class="button_con button_con3">
	<a href="javascript:netfu_mjob.scrap_all_delete()" class="bottom_btn03">삭제</a>
</div>
</form>

<?php
include "../include/tail.php";
?>