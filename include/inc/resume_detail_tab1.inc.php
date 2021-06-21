<!-- 희망근무조건 -->
<?php
$_wr_date = $netfu_util->get_cate(array($re_row['wr_date']));
$wr_week = $netfu_util->get_cate(array($re_row['wr_week']));
$wr_time = $netfu_util->get_cate(array($re_row['wr_time']));


$implode_tag_area = $re_info['max_area']>1 ? '<br/>' : ', ';
$implode_tag_job_type = $re_info['max_job_type']>1 ? '<br/>' : ', ';
?>
<div class="tab-box tab1-box" style="display:block;">
<div class="resume_ct r_ct1 cf">
	<h3>Хүсч буй ажлын нөхцөл</h3>
	<table>
		<tr>
			<th>Хүсч буй байршил</th>
			<td><?=@implode($implode_tag_area, $re_info['area_val']);?></td>
		</tr>
		<tr>
			<th>Хүсч буй ажлын төрөл</th>
			<td><?=@implode($implode_tag_job_type, $re_info['job_type_val']);?></td>
		</tr>
		<tr>
			<th>Ажлын цаг</th>
			<td><?=$_wr_date[0];?>, <?=$wr_week[0];?>, <?=$wr_time[0];?>, <?=$re_row['wr_work_direct'] ? 'Яаралтай ажилд орох боломжтой' : '';?></td>
		</tr>
		<tr>
			<th>Цалин</th>
			<td><?=$re_info['pay_type'];?></td>
		</tr>
		<tr>
			<th>Ажлын төрөл</th>
			<td><?=$re_info['work_type'];?></td>
		</tr>
	</table>
</div>

<?php
// : 학력사항
include NFE_PATH.'/include/inc/re_school.inc.php';


// : 경력사항
include NFE_PATH.'/include/inc/re_career.inc.php';
?>



</div>