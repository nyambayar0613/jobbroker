<?php
$head_title = "Байгууллагын мэдээлэл удирдлага";
$page_code = 'mypage';
include_once "../include/top.php";

$netfu_util->get_cate_array($v, array('where'=>" and `p_code` = ''"));

// : 쿼리문
$_limit = 10;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_where = " and `mb_id` = '".$member['mb_id']."' and is_delete=0";
$q = "`alice_member_company` where 1 ".$_where;
$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
$query = sql_query("select * from ".$q." order by `no` desc limit ".$_start.", ".$_limit);
$total = sql_fetch("select count(*) as c from ".$q);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c'], 'type'=>'not_bg'));
?>
<script type="text/javascript">
var is_public_click = function(el) {
	$.post(base_url+'/regist.php', "mode=is_public_company&no="+el.value, function(data){
		data = $.parseJSON(data);
		if(data.msg) alert(data.msg);
		if(data.move) location.replace(data.move);
	});
}
</script>
<section class="cont_box detail_con">
<?php
include NFE_PATH.'/include/inc/my_company_info.inc.php';

include NFE_PATH.'/include/inc/my_company_count.inc.php';
?>
</section>

<form name="flist" action="../regist.php" method="post">
<input type="hidden" name="mode" value="company_list_delete" />
<section class="cont_box resume_list" style="box-shadow:none;border-bottom:0">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 active"><a href="#none;">Байгууллагын мэдээлэл удирдлага<span class="list_num"><?=number_format($total['c']);?></span></a></li>
			<!-- <li class="tab02"><a href="#">마감된 구인공고<span class="list_num">1</span></a></li> -->
			<li class="add_bt"><a href="./company_write.php">Байгууллагын нэмэх+</a></li>
		</ul>
		<?php
		switch($total['c']<=0) {
			case true:
		?>
		<ul class="list_con" style="border-bottom:1px solid #dee3eb">
			<li class="col2 none">
				<div class="list_txt2"><img src="images/info.png" alt="">Мэдээлэл байхгүй байна.</div>
			</li>
		</ul>
		<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
		?>
		<ul class="list_con bdr">
			<li class="col1 col1-3"><?php if(!$row['is_public']){ ?><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"><?php } else { echo '&nbsp;'; }?></li>
			<li class="col2">
				<table class="list_con2">
					<tr>
						<th>Байгууллагын нэр</th>
						<td class="company"><?php echo stripslashes(strip_tags($row['mb_company_name']));?></td>
					</tr>
					<tr>
						<th>Хариуцсан хүний нэр</th>
						<td><?php echo stripslashes(strip_tags($row['mb_ceo_name']));?></td>
					</tr>
					<tr>
						<th>Байгууллагын төрөл</th>
						<td><?=$category_control->get_categoryCodeName($row['mb_biz_type']);?></td>
					</tr>
					<tr>
						<th>Холбогдох дугаар</th>
						<td><?php echo $row['mb_biz_phone'];?></td>
					</tr>
					<tr>
						<th>Бизнесийн дугаар</th>
						<td><?php echo $row['mb_biz_no'];?></td>
					</tr>
				</table>
			</li>
			<li class="col3 col3-1">
				<div class="list_btn list_btn1 list_btn5"><input type="radio" name="is_public[]" <?php echo ($row['is_public']) ? 'checked' : '';?> value="<?=$row['no'];?>" onClick="is_public_click(this)">Захирал</div>
				<a href="./company_write.php?no=<?php echo $row['no'];?>" class="url"><div class="list_btn list_btn1 list_btn2-1" class="btn-a" style="color:#3694ed">Өөрчлөх</div></a>
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
</form>

<div class="button_con button_con3">
	<a href="#none;" class="bottom_btn03" onClick="netfu_util1.delete_select_func(document.forms['flist'])">Сонголтыг устгах</a>
</div>
<?php
include "../include/tail.php";
?>