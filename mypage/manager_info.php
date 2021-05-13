<?php
$head_title = "담당자관리";
$page_code = 'mypage';
include_once "../include/top.php";

$q = "select * from alice_company_manager where `wr_id` = '".$member['mb_id']."' order by `no` desc";
$query = sql_query($q);
$_nums = mysql_num_rows($query);
?>

<section class="cont_box detail_con">
<?php
include NFE_PATH.'/include/inc/my_company_info.inc.php';

include NFE_PATH.'/include/inc/my_company_count.inc.php';
?>
</section>

<form name="flist" action="../regist.php" method="post">
<input type="hidden" name="mode" value="company_manager_delete" />
<section class="cont_box resume_list" style="box-shadow:none;border-bottom:0">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 active"><a href="#none;">구인담당자 관리<span class="list_num"><?=number_format($_nums);?></span></a></li>
			<!-- <li class="tab02"><a href="#">마감된 구인공고<span class="list_num">1</span></a></li> -->
			<li class="add_bt"><a href="./manager_write.php">구인담당자 추가 +</a></li>
		</ul>
		<?php
		switch($_nums<=0) {
			case true:
		?>
		<ul class="list_con" style="border-bottom:1px solid #dee3eb">
			<li class="col2 none">
				<div class="list_txt2"><img src="images/info.png" alt="">등록된 정보가 없습니다.</div>
			</li>
		</ul>
		<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
		?>
		<ul class="list_con bdr">
			<li class="col1 col1-3"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2">
				<table class="list_con2">
					<tr>
						<th>담당자명</th>
						<td class="company"><?=strip_tags(stripslashes($row['wr_name']));?></td>
					</tr>
					<tr>
						<th>이메일</th>
						<td><?=strip_tags(stripslashes($row['wr_email']));?></td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td><?=strip_tags(stripslashes($row['wr_phone']));?></td>
					</tr>
					<?php
					if($row['wr_hphone']) {
					?>
					<tr>
						<th>휴대폰</th>
						<td><?=strip_tags(stripslashes($row['wr_hphone']));?></td>
					</tr>
					<?php }?>
				</table>
			</li>
			<li class="col3 col3-1">
				<div class="list_btn list_btn1 list_btn2-1"><button type="button" onClick="netfu_util1.delete_func('<?=$row['no'];?>', 'company_manager')">삭제</button></div>
				<div class="list_btn list_btn1 list_btn2-1"><a href="./manager_write.php?no=<?=$row['no'];?>"  class="btn_a" style="color:#3694ed"><button type="button">수정</button></a></div>
			</li>
		</ul>
		<?php
					}
				break;
		}
		?>
	</div>
</section>
</form>

<div class="button_con button_con3">
	<a href="#" class="bottom_btn03" onClick="netfu_util1.delete_select_func(document.forms['flist'])">선택삭제</a>
</div>


<?php
include "../include/tail.php";
?>