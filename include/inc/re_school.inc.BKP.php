<?php
## : 학력사항
$wr_school_type = @array_diff(explode(',',$re_row['wr_school_type']), array(""));
// 대학 (2,3년) 데이터
$wr_half_college = unserialize($re_row['wr_half_college']);
$wr_half_college_cnt = count($wr_half_college['college']);
// 대학 (4년) 데이터
$wr_college = unserialize($re_row['wr_college']);
$wr_college_cnt = count($wr_college['college']);
// 대학원 데이터
$wr_graduate = unserialize($re_row['wr_graduate']);
$wr_graduate_cnt = count($wr_graduate['graduate']);
// 대학원 이상 데이터
$wr_success = unserialize($re_row['wr_success']);
$wr_success_cnt = count($wr_graduate['success']);



if(count($wr_school_type)<=0) return false;
?>

<!-- 학력사항 -->
<div class="resume_ct r_ct2 cf">
<h3>학력사항</h3>

<?php
if(is_array($wr_school_type)) { foreach($wr_school_type as $k=>$v) {

	switch($v) {
		// : 고등학교
		case "high_school":
			$school_syear = $re_row['wr_high_school_syear'] . "년 입학 ";	// 입학년도
			$school_eyear = $re_row['wr_high_school_eyear'] ."년 ";		// 졸업년도
			$high_school_graduation = $re_row['wr_high_school_graduation'];	// 졸업여부
			$school_graduation = ($high_school_graduation) ? "재학" : "졸업";
			$school_name = $re_row['wr_high_school_name'];
?>
<!-- 고등학교 재학 -->
<table class="edu_tb1">
<tr>
	<th>최종학력</th>
	<td><?=$re_info['school_ability'][0];?> <?=$re_info['school_ability'][1];?><span class="off"><?=$re_row['wr_school_absence'] ? '(휴학중)' : '';?></span></td>
</tr>
</table>
<table class="edu_tb3" style="width:100%">
<colgroup>
	<col style="width:50%"><col style="width:50%">
</colgroup>
<tr>
	<th>기간</th>
	<th>학교명</th>
</tr>
<tr>
	<td><?php echo $school_syear;?>~<?php echo $school_eyear;?> <?php echo $school_graduation;?></td>
	<td><?=$school_name;?>고등학교</td>
</tr>
</table>
<?php
			break;




		// : 대학 (2,3년)
		case "half_college":
			if($wr_half_college){
?>
<!-- 대학 (2,3년) -->
<table class="edu_tb1">
<tr>
	<th>최종학력</th>
	<td><?=$re_info['school_ability'][0];?> <?=$re_info['school_ability'][1];?><span class="off"><?=$re_row['wr_school_absence'] ? '(휴학중)' : '';?></span></td>
</tr>
</table>
<table class="edu_tb3" style="width:100%">
<colgroup>
	<col style="width:40%"><col style="width:40%"><col style="width:20%">
</colgroup>
<tr>
	<th>기간</th>
	<th>학교명</th>
	<th>전공</th>
</tr>
<?php
	for($j=0;$j<$wr_half_college_cnt; $j++){
		$school_syear = $wr_half_college['college_syear'][$j] . "년 입학 ";	// 입학년도
		$school_eyear = $wr_half_college['college_eyear'][$j] . "년 ";	// 졸업년도
		$half_college_school_graduation = $wr_half_college['college_graduation'][$j];
		$school_graduation_arr = array( 0 => "졸업", 1 => "재학", 2 => "중퇴");
		$school_graduation = $school_graduation_arr[$half_college_school_graduation];
		$school_name = $wr_half_college['college'][$j];
		$school_specialize = $wr_half_college['college_specialize'][$j];
?>
<tr>
	<td>
		<?=$school_syear;?>~<?=$school_eyear;?>
		<?php if( ($j+1) ==$wr_half_college_cnt ) echo ($get_resume['wr_school_absence']) ? "휴학중" : "";?>
	</td>
	<td><?=$school_name;?>대학교</td>
	<td><?php echo $school_specialize;?></td>
</tr>
<?php }?>
</table>
<?php
		}
			break;





		// : 대학 (4년)
		case "college":
			if($wr_college){
?>
<!-- 대학교(4학년) 재학 -->
<table class="edu_tb1">
<tr>
	<th>최종학력</th>
	<td><?=$re_info['school_ability'][0];?> <?=$re_info['school_ability'][1];?> <span class="off"><?=$re_row['wr_school_absence'] ? '(휴학중)' : '';?></span></td>
</tr>
</table>
<table class="edu_tb3" style="width:100%">
<colgroup>
	<col style="width:40%"><col style="width:40%"><col style="width:20%">
</colgroup>
<tr>
	<th>기간</th>
	<th>학교명</th>
	<th>전공</th>
</tr>
<?php
for($j=0;$j<$wr_college_cnt;$j++){
	$school_syear = $wr_college['college_syear'][$j] . "년 입학 ";	// 입학년도
	$school_eyear = $wr_college['college_eyear'][$j] . "년 ";	// 졸업년도
	$college_school_graduation = $wr_college['college_graduation'][$j];
	$school_graduation_arr = array( 0 => "졸업", 1 => "재학", 2 => "중퇴");
	$school_graduation = $school_graduation_arr[$college_school_graduation];
	$school_name = $wr_college['college'][$j];
	$school_specialize = $wr_college['college_specialize'][$j];
?>
<tr>
	<td><?=$school_syear;?>~<?=$school_eyear;?> <?=$school_graduation;?></td>
	<td><?=$school_name;?>대학교</td>
	<td><?=$school_specialize;?></td>
</tr>
<?php }?>
</table>
<?php
		}
			break;




		// : // 대학원
		case "graduate":
			if($wr_graduate){
?>
<!-- 대학원 재학 -->
<table class="edu_tb1">
<tr>
	<th>최종학력</th>
	<td>대학원<span class="off">(<?=$re_info['school_ability'][1];?>)</span></td>
</tr>
</table>
<table class="edu_tb3" style="width:100%">
<colgroup>
	<col style="width:40%"><col style="width:25%"><col style="width:20%"><col style="width:15%">
</colgroup>
<tr>
	<th>기간</th>
	<th>학교명</th>
	<th>전공</th>
	<th>학위</th>
</tr>
<?php
for($j=0;$j<$wr_graduate_cnt;$j++){
	$school_syear = $wr_graduate['graduate_syear'][$j] . "년 입학 ";	// 입학년도
	$school_eyear = "~ " . $wr_graduate['graduate_eyear'][$j] . "년 ";	// 졸업년도
	$graduate_school_graduation = $wr_graduate['graduate_graduation'][$j];
	$school_graduation_arr = array( 0 => "졸업", 1 => "수료", 2 => "재학", 3 => "중퇴");
	$school_graduation = $school_graduation_arr[$graduate_school_graduation];
	$school_name = $wr_graduate['graduate'][$j];
	$school_specialize = $wr_graduate['graduate_specialize'][$j];
?>
<tr>
	<td><?=$school_syear;?>~<?=$school_eyear;?> <?=$school_graduation;?></td>
	<td><?=$school_name;?>대학교</td>
	<td><?=$school_specialize;?></td>
	<td>석사</td>
</tr>
<?php
}?>
</table>
<?php
		}
			break;




		// : // 대학원 이상
		case "success":
			if($wr_graduate){
?>
<!-- 대학원 재학 -->
<table class="edu_tb1">
<tr>
	<th>최종학력</th>
	<td>대학원 이상<span class="off">(<?=$re_info['school_ability'][1];?>)</span></td>
</tr>
</table>
<table class="edu_tb3" style="width:100%">
<colgroup>
	<col style="width:40%"><col style="width:25%"><col style="width:20%"><col style="width:15%">
</colgroup>
<tr>
	<th>기간</th>
	<th>학교명</th>
	<th>전공</th>
	<th>학위</th>
</tr>
<?php
for($j=0;$j<$wr_graduate_cnt;$j++){
	$school_syear = $wr_graduate['graduate_syear'][$j] . "년 입학 ";	// 입학년도
	$school_eyear = "~ " . $wr_graduate['graduate_eyear'][$j] . "년 ";	// 졸업년도
	$graduate_school_graduation = $wr_graduate['graduate_graduation'][$j];
	$school_graduation_arr = array( 0 => "졸업", 1 => "수료", 2 => "재학", 3 => "중퇴");
	$school_graduation = $school_graduation_arr[$graduate_school_graduation];
	$school_name = $wr_graduate['graduate'][$j];
	$school_specialize = $wr_graduate['graduate_specialize'][$j];
?>
<tr>
	<td><?=$school_syear;?>~<?=$school_eyear;?> <?=$school_graduation;?></td>
	<td><?=$school_name;?>대학교</td>
	<td><?=$school_specialize;?></td>
	<td>석사</td>
</tr>
<?php
}?>
</table>
<?php
		}
			break;
	}
?>



<?php
} } else {

	// : 학력사항 정보가 없는경우

}
?>
</div>