<?php
$head_title = "Хариуцагч удирдах";
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
			<li class="tab01 active"><a href="#none;">Хариуцагч удирдах<span class="list_num"><?=number_format($_nums);?></span></a></li>
			<!-- <li class="tab02"><a href="#">마감된 구인공고<span class="list_num">1</span></a></li> -->
			<li class="add_bt"><a href="./manager_write.php">Ажилд авах хүн нэмэх +</a></li>
		</ul>
		<?php
		switch($_nums<=0) {
			case true:
		?>
		<ul class="list_con" style="border-bottom:1px solid #dee3eb">
			<li class="col2 none">
				<div class="list_txt2"><img src="images/info.png" alt="">Бүртгэлтэй мэдээлэл байхгүй байна.</div>
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
						<th>Хариуцсан хүний нэр</th>
						<td class="company"><?=strip_tags(stripslashes($row['wr_name']));?></td>
					</tr>
					<tr>
						<th>И-мэйл</th>
						<td><?=strip_tags(stripslashes($row['wr_email']));?></td>
					</tr>
					<tr>
						<th>Холбоо барих</th>
						<td><?=strip_tags(stripslashes($row['wr_phone']));?></td>
					</tr>
					<?php
					if($row['wr_hphone']) {
					?>
					<tr>
						<th>Утасны дугаар</th>
						<td><?=strip_tags(stripslashes($row['wr_hphone']));?></td>
					</tr>
					<?php }?>
				</table>
			</li>
			<li class="col3 col3-1">
				<div class="list_btn list_btn1 list_btn2-1"><button type="button" onClick="netfu_util1.delete_func('<?=$row['no'];?>', 'company_manager')">Устгах</button></div>
				<div class="list_btn list_btn1 list_btn2-1"><a href="./manager_write.php?no=<?=$row['no'];?>"  class="btn_a" style="color:#3694ed"><button type="button">Засварлах</button></a></div>
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
	<a href="#" class="bottom_btn03" onClick="netfu_util1.delete_select_func(document.forms['flist'])">Сонголт устгах</a>
</div>


<?php
include "../include/tail.php";
?>