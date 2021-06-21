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
	$career_periods = "약 " . sprintf('%02d',$year) . "년 " . $month . "개월";
} else {
	$career_periods = "없음";
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
<h3>경력사항</h3>

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
경력사항 내용을 열람하시려면 <span class="text_color">이력서 열람서비스</span>를 신청하세요
<?php
		break;


// : 열람사용
	case "R":
?>
<div class="resumeOpen  tc">
	<ul>
		<li class="pt20"><strong>사용가능한 이력서 열람권이 <?php echo $is_open_count;?>건 있습니다 열람권을 사용하시면 열람이 가능합니다.</strong></li>
		<li class="pt20">
		<a href="javascript:void(0);" onclick="open_resume('<?php echo $no;?>','<?php echo $re_row['wr_id'];?>','resume', '<?php echo $is_open_count;?>');"><img width="192" height="28" alt="이력서열람서비스 신청" src="../images/basic/btn_resume6.png" class="bg_color5"></a>
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
				$date_val = $sdate[0]."년 " . $sdate[1] . "월 ~ ";
				$edate = ($val['edate']) ? explode('-',$val['edate']) : "";
				$date_val .= $edate[0]."년 " . $edate[1] . "월";
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
<caption style="border-top:0">경력사항<?=$count+1;?></caption>
<tr>
	<th>회사명</th>
	<td><?php echo $val['company'];?></td>
</tr>
<tr>
	<th>근무직종</th>
	<td><?=@implode(", ", $career_jobtype);?></td>
</tr>
<tr>
	<th>근무기간</th>
	<td><?php echo $date_val;?></td>
</tr>
	<th>담당업무</th>
	<td><?php echo $val['job'];?></td>
</tr>
</tr>
	<th>상세업무</th>
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