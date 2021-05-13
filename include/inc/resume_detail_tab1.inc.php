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
	<h3>희망근무조건</h3>
	<table>
		<tr>
			<th>희망근무지</th>
			<td><?=@implode($implode_tag_area, $re_info['area_val']);?></td>
		</tr>
		<tr>
			<th>희망직종</th>
			<td><?=@implode($implode_tag_job_type, $re_info['job_type_val']);?></td>
		</tr>
		<tr>
			<th>근무일시</th>
			<td><?=$_wr_date[0];?>, <?=$wr_week[0];?>, <?=$wr_time[0];?>, <?=$re_row['wr_work_direct'] ? '즉시출근가능' : '';?></td>
		</tr>
		<tr>
			<th>희망급여</th>
			<td><?=$re_info['pay_type'];?></td>
		</tr>
		<tr>
			<th>근무형태</th>
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