<?php
// : 자격증
$wr_license = unserialize($re_row['wr_license']);

// : 외국어
$wr_language = unserialize($re_row['wr_language']);

if($re_row['wr_oa']) $wr_oa = unserialize($re_row['wr_oa']);
if($re_row['wr_computer']) $wr_computer = explode(',', $re_row['wr_computer']);
if($re_row['wr_specialty']) $wr_specialty = explode(',', $re_row['wr_specialty']);

// : 부가정보
$wr_treatment_service = explode(',', $re_row['wr_treatment_service']); // 우대
?>
<div class="tab-box tab2-box">

	<!-- 보유자격증 -->
	<?php
	if($re_row['wr_license_use']) {
	?>
	<div class="resume_ct r_ct4 cf">
		<h3>보유자격증</h3>
		<table class="edu_tb3" style="width:100%">
		<colgroup>
		<col style="width:20%"><col style="width:40%"><col style="width:40%">
		</colgroup>
		<tr>
			<th>취득일</th>
			<th>자격증명</th>
			<th>발행처</th>
		</tr>
		<?php
		$_len = count($wr_license);
		if($_len<=0) $_len = 1;
		for($license_i=0; $license_i<$_len; $license_i++) {
			$_name = $wr_license[$license_i]['name'];
			$_public = $wr_license[$license_i]['public'];
			$_year = $wr_license[$license_i]['year'];
		?>
		<tr>
			<td><?=$_year;?>년</td>
			<td><?=$_name;?></td>
			<td><?=$_public;?></td>
		</tr>
		<?php
		}?>
		</table>
	</div>
	<?php }?>





	<!-- 외국어능력 -->
	<?php
	if($re_row['wr_language_use']) {
	?>
	<div class="resume_ct r_ct5 cf">
		<h3>외국어능력</h3>
		<table class="edu_tb3" style="width:100%">
		<colgroup>
		<col style="width:30%"><col style="width:70%">
		</colgroup>
		<tr>
			<th>외국어명</th>
			<th>구사능력/공인시험/어학연수</th>
		</tr>
		<?php
		$_len = count($wr_language);
		if($_len<=0) $_len = 1;
		for($language_i=0; $language_i<$_len; $language_i++) {
			$_language = $wr_language[$language_i]['language'];
			$_level = $wr_language[$language_i]['level'];
			$_license = $wr_language[$language_i]['license'];
			$_study = $wr_language[$language_i]['study'];
			$_study_date = $wr_language[$language_i]['study_date'];

			$_level_txt = explode("(", $netfu_mjob->language_level[$_level]);

			$_language_txt = '';
			if(is_array($_cate_['indi_language'])) { foreach($_cate_['indi_language'] as $k=>$v) {
				if($_language==$v['code'])
					$_language_txt = $v['name'];
			} }
		?>
		<tr>
			<td><?=$_language_txt;?></td>
			<td>
				<div><span class="txt_hd">구사능력</span> <em class="lv1"><?=$_level_txt[0];?></em><span>(<?=$_level_txt[1];?></span></div>
				<?php
				$_len2 = count($_license['license']);
				if($_len2<=0) $_len2 = 1;
				for($_licence_i=0; $_licence_i<$_len2; $_licence_i++) {
					$__license = $_license['license'][$_licence_i];
					$__level = $_license['level'][$_licence_i];
					$__year = $_license['year'][$_licence_i];
					$__language_txt = '';
					if(is_array($_cate_['indi_language_license'])) { foreach($_cate_['indi_language_license'] as $k=>$v) {
						if($__license==$v['code']) $__language_txt = $v['name'];
					} }
				?>
				<div><span class="txt_hd">공인시험</span><span><?=$__language_txt;?></span> / <span><?=$__level;?>점</span> / <span><?=$__year;?>년</span></div>
				<?php
				}
				?>

				<div><span class="txt_hd">어학연수</span> <?=$_study ? $netfu_mjob->language_date[$_study_date] : '없음';?></div>
			</td>
		</tr>
		<?php }?>
		</table>
	</div>
	<?php }?>

	<!-- OA능력 및 특기사항 -->
	<div class="resume_ct r_ct3 cf">
		<h3>OA능력 및 특기사항</h3>
		<table class="edu_tb2">
		<colgroup>
		<col style="width:26%"><col style="width:74%">
		</colgroup>
		<tr>
			<th>OA능력</th>
			<td>
				<?php
				$count = 1;
				foreach($netfu_mjob->oa_arr2 as $k=>$v) {
					if($count==4) $count = 1;
					$_txt = explode("(", $v[$wr_oa[$k]]);
				?>
				<div><span class="oa_item"><?=htmlspecialchars($netfu_mjob->oa_s_arr[$k]);?></span><em class="lv<?=$wr_oa[$k]+1;?>"><?=$_txt[0];?></em> <?=substr($_txt[1],0,-1);?></div>
				<?php
					$count++;
				}
				?>
			</td>
		</tr>
		<tr>
			<th>컴퓨터능력</th>
			<td>
				<?php
				if(is_array($_cate_['indi_oa'])) { foreach($_cate_['indi_oa'] as $k=>$v) {
					if(!@in_array($v['code'], $wr_computer)) continue;
					$_is_arr[] = $v['name'];
				} }
				?>
				<?=@implode("<br/>", $_is_arr);?>
			</td>
		</tr>
		<tr>
			<th>특기사항</th>
			<td>
				<?php
				unset($_is_arr);
				if(is_array($_cate_['indi_special'])) { foreach($_cate_['indi_special'] as $k=>$v) {
					if(!@in_array($v['code'], $wr_specialty)) continue;
					$_is_arr[] = $v['name'];
				} }
				?>
				<?=@implode("<br/>", $_is_arr);?>
			</td>
		</tr>
			<th>수상/수료</th>
			<td><?php echo stripslashes($re_row['wr_prime']);?></td>
		</tr>
		</table>
	</div>

	<!-- 부가정보 -->
	<div class="resume_ct r_ct6 cf">
		<h3>부가정보</h3>
		<table class="edu_tb3" style="width:100%">
		<colgroup>
		<col style="width:20%"><col style="width:20%"><col style="width:20%"><col style="width:40%">
		</colgroup>
		<tr>
		<th>장애여부</th>
			<th>결혼여부</th>
			<th>병역여부</th>
			<th>채용우대</th>
		</tr>
		<tr>
			<td>
				<?php
				echo $re_row['wr_impediment_use'] ? '있음' : '해당없음';
				if($re_row['wr_impediment_use']) {
					if($re_row['wr_impediment_level']) $_arr[] = $_cate_['impediment'][$re_row['wr_impediment_level']];
					if($re_row['wr_impediment_name']) $_arr[] = stripslashes($re_row['wr_impediment_name']);
					echo '<div>'.@implode(" : ", $_arr).'</div>';
				}
				?>
			</td>
			<td><?=$re_row['wr_marriage'] ? '결혼' : '미혼';?></td>
			<td>
				<?php
				echo $netfu_util->military_arr[$re_row['wr_military']];
				if(@in_array($re_row['wr_military'], array(1,2))) {
					echo '<div>'.stripslashes($re_row['wr_military_type']).'</div>';
				}
				?>
			</td>
			<td>
				<?php
				$_txt = array();
				if($re_row['wr_preferential_use']) $_txt[] = '국가보훈 대상자<br/>';
				if($re_row['wr_treatment_use']) $_txt[] = '고용지원금 대상자<br/>';
				echo @implode(", ", $_txt);

				$_txt = array();
				if(is_array($_cate_['indi_treatment'])) { foreach($_cate_['indi_treatment'] as $k=>$v) {
					if(@in_array($v['code'], $wr_treatment_service)) $_txt[] = $v['name'];
				} }
				?>
				<span>
				<?php
				echo @implode("<br/>", $_txt);
				?>
				</span>
			</td>
		</tr>
		</table>
	</div>

</div>