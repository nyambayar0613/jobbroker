<?php
/* 경력 정보 추출 */
$wr_career = unserialize($re_row['wr_career']);
if($wr_career){
	$wr_career_cnt = count($wr_career);
	$career = 0;
	for($i=0;$i<$wr_career_cnt;$i++){
		$career += $utility->date_diff($wr_career[$i]['sdate'],$wr_career[$i]['edate']);
	}							
	$strtime = time() - strtotime("-".$career.' day');
	$year = date("Y", $strtime) - 1970;
	$month = date("m", $strtime);
	$career_periods = "약 " . sprintf('%02d',$year) . "жил " . $month . "сар";
} else {
	$career_periods = "Байхгүй";
}

if($re_row['wr_career']){
	$wr_career_use = $re_row['wr_career_use'];
	if($wr_career_use){	// 경력 사항을 체크했다면
		$wr_career = unserialize($re_row['wr_career']);
	}
}


if(!$wr_career_use) return false;
?>
<!-- 경력사항 -->
<div class="resume_ct r_ct3 cf">
<h3>Туршлага</h3>

<?php
$read_is = 'N';
if($open_is_pay && $is_admin==false) {
	if($is_open_count && !$is_open_resume) $read_is = 'R'; // : 열람권 사용
	if( $service_open || $is_open_resume) $read_is = 'Y';
} else {
	$read_is = 'Y';
}
switch($read_is) {

// : 열람신청
	case "N":
?>
Дэлгэрэнгүй уншихийг хүсвэл <span class="text_color">анкет үзэх үйлчилгээнд</span>хүсэлт гаргана уу.
<?php
		break;


// : 열람사용
	case "R":
?>
<div class="resumeOpen  tc">
	<ul>
		<li class="pt20"><strong>Ашиглах боломжтой анкет үзэх үйлчилгээ<?php echo $is_open_count;?></strong></li>
		<li class="pt20">
		<a href="javascript:void(0);" onclick="open_resume('<?php echo $no;?>','<?php echo $re_row['wr_id'];?>','resume', '<?php echo $is_open_count;?>');"><img width="192" height="28" alt="Анкет үзэх үйлёилгээний хүсэлт" src="../images/basic/btn_resume6.png" class="bg_color5"></a>
		</li>
	</ul>
</div>
<?php
		break;


// : 공개
	case "Y":
		$count = 0;
		if($wr_career){
			foreach($wr_career as $key => $val){
				$date_val = "";
				$sdate = ($val['sdate']) ? explode('-',$val['sdate']) : "";
				$date_val = $sdate[0]."жил " . $sdate[1] . "월 ~ ";
				$edate = ($val['edate']) ? explode('-',$val['edate']) : "";
				$date_val .= $edate[0]."жил " . $edate[1] . "월";
				$career_type = $val['type'];
				$career_type_cnt = count($val['type']);

				// : 근무직종
				$career_jobtype = array();
				for($k=0;$k<$career_type_cnt;$k++){ 
					if($career_type[$k]){
						$career_jobtype[] = $category_control->get_categoryCodeName($career_type[$k]);
					} // if end.
				}
?>
<!-- 경력사항1 -->
<table class="edu_tb2">
<caption style="border-top:0">Туршлага<?=$count+1;?></caption>
<tr>
	<th>Байгууллагын нэр</th>
	<td><?php echo $val['company'];?></td>
</tr>
<tr>
	<th>Ажлын төрөл</th>
	<td><?=@implode(", ", $career_jobtype);?></td>
</tr>
<tr>
	<th>Ажиллах хугацаа</th>
	<td><?php echo $date_val;?></td>
</tr>
	<th>Албан тушаал</th>
	<td><?php echo $val['job'];?></td>
</tr>
</tr>
	<th>Дэлгэрэнгүй</th>
	<td><?php echo nl2br(stripslashes($val['content']));?></td>
</tr>
</table>
<?php
			}
		$count++;
		}
?>
<?php
		break;
}
?>
</div>