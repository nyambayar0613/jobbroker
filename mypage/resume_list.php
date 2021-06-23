<?php
$head_title = "Анкет удирдах";
$page_code = 'mypage';
include "../include/top.php";

$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_limit = 10;
$q = "alice_alba_resume where wr_id='".$member['mb_id']."' and is_delete=0";
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
		<li class="tab01 active"><a href="#">Анкет удирдах<span class="list_num"><?=number_format($total['c']);?></span></a></li>
			<!-- <li class="tab02"><a href="#">파일관리<span class="list_num">1</span></a></li> -->
		</ul>

		<?php
		switch($total['c']<=0) {
			case true:
		?>
		<ul class="list_con">
			<li class="col2 none">
				<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">Бүртгэлтэй мэдээлэл байхгүй байна.</div>
			</li>
		</ul>
		<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
					$_open = $row['wr_open'] ? 'Нээлттэй' : 'Хаалттай';
					$get_resume = $netfu_mjob->get_resume($row, $member);

					$_remain_service = $netfu_payment->service_is_check('resume', $row);
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2"><a href="<?=NFE_URL;?>/resume/detail.php?no=<?=$row['no'];?>">
				<div class="list_txt">[<?=$_open;?>] <?=stripslashes(strip_tags($row['wr_subject']));?></div>
				<div class="list_etc"><span>Ажлын төрөл : <?=$get_resume['job_type_val'][0];?></span></div>
				<div class="list_etc"><span>Сүүлд өөрчилсөн огноо : <?=date("Y.m.d", strtotime($row['wr_udate']));?></span></div>
				<div class="list_etc"><span>Үзсэн тоо : <em style="color:#24afb2"><?=number_format($row['wr_hit']);?>төрөл</em></span></a><span><em>төлбөртэй үйлчилгээ<em></span></div>
			</li>
			<li class="col3">
				<a href="./resume_write.php?no=<?=$row['no'];?>"><div class="list_btn list_btn1 list_btn1-1" class="btn-a" style="color:#3694ed">Өөрчлөх</div></a>
				<a href="javascript:netfu_mjob.resume_delete('<?=$row['no'];?>')"><div class="list_btn list_btn1 list_btn1-2" class="btn-a" style="color:#3694ed">Устгах</div></a>
				<a href="#none;" onClick="netfu_mjob.jump_func('resume', '<?=$row['no'];?>')"><div class="list_btn list_btn1"><button type="button">Jump</button></div></a>
				<a href="../payment/resume_payment.php?no=<?=$row['no'];?>"><div class="list_btn list_btn2" class="btn_a" style="color:#fff">Үйлчилгээний хүсэлт</div></a>
			</li>



			<?php
			if(count($_remain_service)>0) {
			?>
			<li class="col4 cf" style="clear:both">
				<ul>
					<h3>Төлбөртэй үйлчилгээ ашиглалтын түүх</h3>
					<?php
					if(is_array($_remain_service)) { foreach($_remain_service as $k=>$v) {
					?>
					<li>
						<p><?=$v;?></p><a href="<?=NFE_URL;?>/payment/resume_payment.php?no=<?=$row['no'];?>">Үйлчилгээ сунгах</a>
					</li>
					<?php
					} }
					?>
				</ul>
			</li>
			<?php }?>
		</ul>
		<?php
				}
				break;
		}


		echo $paging;
		?>
	</div>
</section>
</form>

<div class="button_con">
	<a href="javascript:netfu_mjob.resume_all_open(1)" class="bottom_btn01" onClick="">Нээлттэй</a><a href="javascript:netfu_mjob.resume_all_open(0)" onClick="" class="bottom_btn02">Хаалттай</a>
</div>
<div class="button_con">
	<a href="/mypage/resume_write.php" class="bottom_btn01" onClick="">Анкет бүртгүүлэх</a><a href="javascript:netfu_mjob.resume_all_delete()" onClick="" class="bottom_btn02">Устгах</a>
</div>

<!--
<div class="button_con button_con2">
	<a href="javascript:netfu_mjob.resume_all_open(1)" class="bottom_btn01">공개</a><a href="javascript:netfu_mjob.resume_all_open(0)" class="bottom_btn02">비공개</a><a href="javascript:netfu_mjob.resume_all_delete()" class="bottom_btn03">삭제</a>
</div>
-->


<?php
include "../include/tail.php";
?>