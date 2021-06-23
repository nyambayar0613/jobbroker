<?php
$head_title = "구인정보관리";
$page_code = 'mypage';
include_once "../include/top.php";

$_GET['code'] = $_GET['code'] ? $_GET['code'] : 'ing';

// : 쿼리문
$_limit = 10;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_where = " and `wr_id`='".$member['mb_id']."' and is_delete=0";
if($_GET['code']=='end') $_where .= " and !(".$netfu_mjob->job_where.$netfu_mjob->_service_where.")";
else $_where .= " and ".$netfu_mjob->job_where.$netfu_mjob->_service_where;
if($_GET['search_field']) $_where = " and `".addslashes($_GET['search_field'])."` like '%".addslashes($_GET['search_keyword'])."%'";
$q = "alice_alba where 1 ".$_where;
$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
$query = sql_query("select * from ".$q." order by `no` desc limit ".$_start.", ".$_limit);
$total = sql_fetch("select count(*) as c from ".$q);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c']));
?>
<script type="text/javascript">

</script>
<div class="cf logo_chg">
	<!-- 로고 파일 수정 
	<div class="logo_change">
		<h2>로고파일 수정</h2>
		<p>gif, jpeg, jpg 파일형식으로, 200×100픽셀, 100kb 용량 이내의 파일만 등록 가능합니다.</p>
		<input type="file" id="" name="">
		<div class="button_con">
			<a href="#" class="bottom_btn01">등록</a><a href="#" class="bottom_btn02">취소</a>
		</div>
	</div>
	<div class="wrap_bg"></div>
 //로고 파일 수정 -->
</div>

<section class="cont_box detail_con">
	<?php
	include NFE_PATH.'/include/inc/my_company_info.inc.php';

	include NFE_PATH.'/include/inc/my_company_count.inc.php';
	?>
</section>


<section class="cont_box resume_list">

	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 <?=$_GET['code']!='end' ? 'active' : '';?>"><a href="<?=$_SERVER['PHP_SELF'];?>?code=ing">Үргэлжилж буй зар<span class="list_num"><?=number_format($_my_count['job_ing']['c']);?></span></a></li>
			<li class="tab02 <?=$_GET['code']=='end' ? 'active' : '';?>"><a href="<?=$_SERVER['PHP_SELF'];?>?code=end">Хугацаа дууссан ажлын зар<span class="list_num"><?=number_format($_my_count['job_end']['c']);?></span></a></li>
		</ul>
		<form name="fsearch2" action="<?=$_SERVER['PHP_SELF'];?>" method="get">
		<ul class="list_con search_gp">
			<li class="sch_bt"><input type="radio" name="search_field" checked value="wr_company_name"><label for="company">Байгууллага</label></li>
			<li class="sch_bt"><input type="radio" name="search_field" value="wr_subject" <?=$_GET['search_field']=='wr_subject' ? 'checked' : '';?>><label for="title">Зарын гарчиг</label></li>
			<li class="sch_bt"><input type="radio" name="search_field" value="wr_person" <?=$_GET['search_field']=='wr_person' ? 'checked' : '';?>><label for="manager">Хариуцагчын нэр</label></li>
			<li class="sch_bar"><input type="text" name="search_keyword" value="<?=$_GET['search_keyword'];?>"><button class="plus_bt plus_bt3" onClick="document.forms['fsearch2'].submit()">Хайх</button></li>
		</ul>
		</form>
		

		<form name="flist" action="../regist.php" method="post">
		<input type="hidden" name="mode" value="job_delete" />
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
					$info = $netfu_mjob->get_alba($row);

					// : 지역
					for($i=0; $i<8; $i++)
						$_job_type_arr[$i] = $row['wr_job_type'.$i];
					$job_type_arr = $netfu_util->get_cate($_job_type_arr);

					$count = 0;
					$job_type_arr2 = array();
					for($i=0; $i<3; $i++) {
						$job_type_arr2[$i] = array();
						for($j=0; $j<3; $j++) {
							if(!$job_type_arr[$count]) continue;
							$job_type_arr2[$i][] = $job_type_arr[$count];
							$count++;
						}
					}

					$_remain_service = $netfu_payment->service_is_check('alba', $row);
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" id="" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['no'];?>">
				<div class="list_txt"><?=strip_tags(stripslashes($row['wr_subject']));?></div>
				<div class="list_etc"><span class="co_name"><?=strip_tags(stripslashes($row['wr_company_name']));?></span><span>Хүсэлт гаргагч : <i><?=number_format($val['wr_desire']);?></i>명</span></div>
				<div class="list_etc"><span class="date">Бичсэн : <?=$netfu_util->get_date('dot', $row['wr_wdate']);?></span><span><?=$info['volume_text'];?></span></div>
				<?php
				foreach($job_type_arr2 as $k=>$v) {
					if(!$v[0]) continue;
				?>
				<div class="list_etc"><span><?=@implode(" > ", $v);?></span></div>
				<?php }?>
			</a></li>
			<li class="col3">
				<div class="list_btn list_btn1 list_btn1-1"><a href="./job_write.php?no=<?=$row['no'];?>" class="btn_a" style="color:#3694ed">Өөрчлөх</a></div>
				<div class="list_btn list_btn1 list_btn1-2"><a href="./job_write.php?mode=load&no=<?=$row['no'];?>" class="btn_a" style="color:#3694ed">Хувилах</a></div>
				<div class="list_btn list_btn1 list_btn1-1"><button type="button" onClick="netfu_util1.delete_func('<?=$row['no'];?>', 'job')">Устгах</button></div>
				<?php if($_GET['code']!='end') {?><div class="list_btn list_btn1 list_btn1-2"><a href="#none;" onClick="netfu_mjob.alba_finish('<?=$row['no'];?>')"><button type="button">마감</button></a></div><?php }?>
				<div class="list_btn list_btn1 list_btn1-1"><a href="./job_write.php" class="btn_a" style="color:#3694ed">Зар бүртгүүлэх</a></div>
				<?php if($_GET['code']!='end') {?>
				<div class="list_btn list_btn1 list_btn1-2" onClick="netfu_mjob.jump_func('alba', '<?=$row['no'];?>')" class="btn_a"><button type="button">Jump</button></div>
				<?php
				}
				$_field = 'mb_alba_jump_count';
				if($member_service[$_field]>0) {
				?>
				<div class="list_btn list_btn1-3"><button type="button">Jump ашиглаж байна</button></div>
				<?php } else {?>
				<div class="list_btn list_btn1-4"><button type="button">Jump ашиглаагүй байна</button></div>
				<?php }?>
				<a href="<?=NFE_URL;?>/payment/job_payment.php?no=<?=$row['no'];?>"><div class="list_btn list_btn2" class="btn_a" style="color:#fff">Үйлчилгээний хүсэлт</div></a>
			</li>

			<?php
			if(count($_remain_service)>0) {
			?>
			<li class="col4 cf" style="clear:both">
				<ul>
					<h3>Төлбөртэй үйлчилгээний ашиглалтын түүх</h3>
					<?php
					if(is_array($_remain_service)) { foreach($_remain_service as $k=>$v) {
					?>
					<li>
						<p><?=$v;?></p><a href="<?=NFE_URL;?>/payment/job_payment.php?no=<?=$row['no'];?>">Үйлчилгээ сунгах</a>
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
		?>
		
		
		<?=$paging?>
	</div>
</section>

<div class="button_con">
	<a href="/mypage/job_write.php" class="bottom_btn01" onClick="">Бүртгэх</a><a href="#none;" onClick="netfu_util1.delete_select_func(document.forms['flist'])" class="bottom_btn02">Устгах</a>
</div>

<!--
<div class="button_con button_con3">
	<a href="#none;" class="bottom_btn03" onClick="netfu_util1.delete_select_func(document.forms['flist'])">삭제</a>
</div>
</form>
-->

<?php
include "../include/tail.php";
?>