<?php
$head_title = "Ажлын байрны хүсэлтийн удирдлага";
$page_code = 'mypage';
include "../include/top.php";
$_GET['code'] = $_GET['code'] ? $_GET['code'] : 'online';

// : 개수정보
$_my_count['receive_online'] = sql_fetch("select count(*) as c from alice_receive where `type`='become_online' and `wr_id`='".$member['mb_id']."'");
$_my_count['receive_email'] = sql_fetch("select count(*) as c from alice_receive where `type`='become_email' and `wr_id`='".$member['mb_id']."'");

// : 쿼리문
$_limit = 10;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_where = " and `wr_id`='".$member['mb_id']."' and `is_delete_indi`=0";
$q = "alice_receive where `type`='become_".addslashes($_GET['code'])."' ".$_where;
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
			<li class="tab01 <?=$_GET['code']=='online' ? 'active' : '';?>"><a href="<?=$_SERVER['PHP_SELF'];?>?code=online">Онлайн өргөдөл<span class="list_num"><?=number_format($_my_count['receive_online']['c']);?></span></a></li>
			<li class="tab02 <?=$_GET['code']=='email' ? 'active' : '';?>"><a href="<?=$_SERVER['PHP_SELF'];?>?code=email">И-мэйл өргөдөл<span class="list_num"><?=number_format($_my_count['receive_email']['c']);?></span></a></li>
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
					$job_row = sql_fetch("select * from alice_alba where `no`='".$row['wr_to']."'");
					$info = $netfu_mjob->get_alba($job_row);

					if($row['etc_4']){
						$open_date = '<span><em>Унших</em></span> <span class="reading_date">' . strtr(substr($row['etc_4'],0,11),'-','.') . '</span>';
					} else {
						if($type=='become_email'){
							if(stristr($row['etc_1'],'email')){	// 이메일의 경우 이메일 확인
								$open_date = "<span>И-мэйл батлах</span>";
							} else {
								$open_date = "<span>Уншихийн өмнө</span>";
							}
						} else {
							$open_date = "<span>Уншихийн өмнө</span>";
						}
					}
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2">
				<div class="list_txt"><a href="../job/detail.php?no=<?=$row['wr_to'];?>"><?=stripslashes(strip_tags($job_row['wr_subject']));?></a></div>
				<div class="list_etc">
					<span>өргөдөл гаргасан огноо : <span class="join_date"><?=$netfu_util->get_date('dot', $row['wdate']);?></span></span>
				</div>
				<div class="list_etc">
					<span><?=stripslashes(strip_Tags($job_row['wr_company_name']));?></span><span><?=$info['volume_text'];?></span>
				</div>
				<div class="list_etc">
				<?=$open_date;?>
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

<div class="button_con button_con3">
	<a href="javascript:netfu_mjob.receive_all_delete()" class="bottom_btn03">Устгах</a>
</div>
</form>

<?php
include "../include/tail.php";
?>