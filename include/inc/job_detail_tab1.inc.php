<?php
$_wr_pay_support_arr = explode(",", $get_alba['wr_pay_support']);
?>
<div class="tab-box tab2-box" style="display:block;">
<table>
  <tr>
	  <th>마감일</th>
		<td><?=$job_info['volume_text'];?></td>
	</tr>
  <tr>
	  <th>모집인원</th>
		<td><?=$volmue;?></td>
	</tr>
  <tr>
	  <th>지원방법</th>
		<td>
			<div>
				<?php
				$wr_requisition_arr = explode(",", $get_alba['wr_requisition']);
				$wr_requisition_arr = array_diff($wr_requisition_arr, array('online', 'email', 'homepage'));
				echo @str_replace(array_keys($netfu_mjob->requisition_arr), $netfu_mjob->requisition_arr, @implode(", ", $wr_requisition_arr));?>
			</div>
			<div class="button_group">
				<?php if(@in_array("online", $_wr_requisition)) {?>
				<button type="button" class="bt-online bt-small requisition_btn" k="online" no="<?=$get_alba['no'];?>">온라인 입사지원</button>
				<?php }?>
				<?php if(@in_array("email", $_wr_requisition)) {?>
				<button type="button" class="bt-email bt-small requisition_btn" k="email" no="<?=$get_alba['no'];?>">이메일 입사지원</button>
				<?php }?>
				<?php if(@in_array("homepage", $_wr_requisition)) {?>
				<button type="button" class="bt-click bt-small" onClick="window.open('<?=$netfu_util->get_homepage($get_alba['wr_homepage']);?>', 'homepage_move')">홈페이지 지원하기 ⇒</button>
				<?php }?>
			</div>
		</td>
	</tr>
  <tr>
	  <th>제출서류</th>
		<td><?=preg_replace("/,/", ", ", str_replace(array_keys($_wr_papers), $_wr_papers, $get_alba['wr_papers']));?></td>
	</tr>
  <tr>
	  <th>모집직종</th>
		<td>
			<div><?=$job_type[0] ? $job_type[0].' > '.$job_type[1].' > '.$job_type[2] : '';?></div>
			<div><?=$job_type[3] ? $job_type[3].' > '.$job_type[4].' > '.$job_type[5] : '';?></div>
			<div><?=$job_type[6] ? $job_type[6].' > '.$job_type[7].' > '.$job_type[8] : '';?></div>
		</td>
	</tr>
  <tr>
	  <th>근무지주소</th>
		<td>
			<?php
			if(is_array($area_cate)) foreach($area_cate as $k=>$v)
				echo @implode(" ", $v).' '.$area_arr[$k][3].'<br/>';
			?>
		</td>
	</tr>
  <tr>
	  <th>경력</th>
		<td><?=$wr_career = ($get_alba['wr_career_type']) ? $category_control->get_categoryCodeName($get_alba['wr_career']) : "경력무관";?></td>
	</tr>
  <tr>
	  <th>급여</th>
		<td>
			<?php echo ($get_alba['wr_pay_conference']) ? $netfu_mjob->pay_conference_arr[$get_alba['wr_pay_conference']] : $pay_type." ".$wr_pay; ?><br/>
			<?php
			$alba_pay_type_arr = $_cate_['alba_pay_type'];
			$alba_pay_type_arr[','] = ', '; // : 글자사이 단어값 - 아래로 내린다면 <br/>로 변경하면 됩니다.
			echo str_replace(array_keys($alba_pay_type_arr), $alba_pay_type_arr, $get_alba['wr_pay_support']);
			?>
		</td>
	</tr>
  <tr>
	  <th>근무기간</th>
		<td><?=$category_control->get_categoryCodeName($get_alba['wr_date']);?></td>
	</tr>
  <tr>
	  <th>근무요일</th>
		<td><?=$category_control->get_categoryCodeName($get_alba['wr_week']);?></td>
	</tr>
  <tr>
	  <th>근무시간</th>
		<td>
			<?php
			if($get_alba['wr_time_conference']){	// 시간 협의
				$wr_time = "시간협의";
			} else {
				$wr_time = $get_alba['wr_stime'] . " ~ " . $get_alba['wr_etime'];	// 근무시간
			}
			echo $wr_time;
			?>
		</td>
	</tr>
  <tr>
	  <th>근무형태</th>
		<td><?=@implode(", ", $work_type_cate);?></td>
	</tr>
  <tr>
	  <th>학력조건</th>
		<td><?=$_cate_['job_ability'][$get_alba['wr_ability']];?></td>
	</tr>
  <tr>
    <tr>
	  <th>우대조건</th>
		<td>
			<?php
			$wr_preferential_arr = $_cate_['preferential'];
			$wr_preferential_arr[','] = ', '; // : 글자사이 단어값 - 아래로 내린다면 <br/>로 변경하면 됩니다.
			echo str_replace(array_keys($wr_preferential_arr), $wr_preferential_arr, $get_alba['wr_preferential']);
			?>
		</td>
	</tr>
  <tr>
    <tr>
	  <th>모집대상</th>
		<td>
			<?php
			$job_target_arr = $_cate_['job_target'];
			$job_target_arr[','] = ', '; // : 글자사이 단어값 - 아래로 내린다면 <br/>로 변경하면 됩니다.
			echo str_replace(array_keys($job_target_arr), $job_target_arr, $get_alba['wr_target']);
			?>
		</td>
	</tr>
  <tr>
	  <th>복리후생</th>
		<td><?=preg_replace("/,/", ", ", $get_alba['wr_welfare_read']);?></td>
	</tr>
  <tr>
	  <th>성별</th>
		<td><?=$alba_user_control->gender_val[$get_alba['wr_gender']];?></td>
	</tr>
  <tr>
	  <th>연령</th>
		<td>
			<?=$get_alba['wr_age_limit']==1 ? preg_replace("/-/", " ~ ", $get_alba['wr_age']).'세' : '연령무관';?>
			<?=$get_alba['wr_age_etc'] ?  '/ '.@implode(", ", $wr_age_etc_cate) : '';?>
		</td>
	</tr>
<!--
  <tr>
	  <th>학력</th>
		<td><?=$wr_ability_cate['name'];?></td>
	</tr>
-->
<?php if($form_question['view']=='yes' && $get_alba['wr_pre_question']){ ?>
  <tr>
	<th>사전질문</th>
	<td>
		<div class="inf_block"><strong>'<?php echo stripslashes($get_alba['wr_company_name']);?>'</strong>에 입사지원시 아래 질문에 대한 답변을  함께 보내주세요.</div>
		<div class="q_txt"><i><?php echo nl2br(stripslashes($get_alba['wr_pre_question']));?></i></div>
	</td>
	</tr>
<?php }?>
</table>
</div>