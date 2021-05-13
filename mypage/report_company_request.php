<?php
$head_title = "입사지원요청기업";
$page_code = 'mypage';
include "../include/top.php";



// : 쿼리문
$_limit = 10;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_where = " and `wr_id`='".$member['mb_id']."'";
$q = "alice_resume_proposal where 1 ".$_where;
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
			<li class="tab01 active"><a href="#none;">입사지원요청기업<span class="list_num"><?=number_format($total['c']);?></span></a></li>
		</ul>

		<?php
		switch($total['c']<=0) {
			case true:
		?>
		<ul class="list_con">
			<li class="col2 none">
				<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">입사제의기업이 없습니다.</div>
			</li>
		</ul>
		<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
					$get_alba = $alba_user_control->get_alba_no($row['wr_employ']);	// 정규직 정보

					$pay_type = $category_control->get_categoryCodeName($get_alba['wr_pay_type']);
					$wr_pay = number_format($get_alba['wr_pay'])."원";
		?>
		<ul class="list_con">
			<?php
			?>
			<li class="col1"><input type="checkbox" id="" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['wr_employ'];?>">
				<div class="company_name"><?=$get_alba ? strip_tags(stripslashes($get_alba['wr_company_name'])) : '삭제된 정보입니다.';?></div>
				<div class="list_txt"><?=strip_tags(stripslashes($get_alba['wr_subject']));?></div>
				<div class="list_etc">
					<span><?=$pay_type;?> <em><?=$wr_pay;?></em></span><span><?php
					if(is_array($area_cate)) foreach($area_cate as $k=>$v)
						echo @implode(" ", $v).' '.$area_arr[$k][3];
					?></span>
				</div>
				<div class="list_etc">
					<span><?=$alba_user_control->gender_val[$get_alba['wr_gender']];?></span>
					<span><?php
					if($get_alba['wr_time_conference']){	// 시간 협의
						$wr_time = "시간협의";
					} else {
						$wr_time = $get_alba['wr_stime'] . " ~ " . $get_alba['wr_etime'];	// 근무시간
					}
					echo $wr_time;
					?></span>
					<span><?=$job_info['volume_text'];?></span>
				</div>
				<div class="list_etc">
					<span>발송일 : <?=$netfu_util->get_date('dot', $row['wdate']);?></span>
				</div>
			</a></li>
			<li class="col3">
				<div class="list_btn list_btn3">
					<button type="button" id="show_ly" onClick="get_info_func(this, '<?=$row['no'];?>');"><img src="<?=NFE_URL;?>/images/folder_icon.png" alt="입사제의요청 내용보기" class="folder_icon">내용보기</button>
				</div>
				<?
				/*
				<div class="list_btn list_btn4"><button type="button" onClick="$('.online_bx').css('display','block')">즉시지원</button></div>
				*/?>
			</li>
		</ul>
		<?php
				}
				break;
		}


		echo $paging;
		?>
	</div>
</section>

<div class="button_con button_con3">
	<a href="javascript:netfu_mjob.receive_request_all_delete()" class="bottom_btn03">삭제</a>
</div>
</form>



<?php
include NFE_PATH.'/include/inc/my_receive_request.inc.php';

include "../include/tail.php";
?>