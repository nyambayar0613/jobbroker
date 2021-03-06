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
		<h3>Эзэмшиж буй мэргэжлийн үнэмлэх</h3>
		<table class="edu_tb3" style="width:100%">
		<colgroup>
		<col style="width:20%"><col style="width:40%"><col style="width:40%">
		</colgroup>
		<tr>
			<th>Авсан огноо</th>
			<th>Үнэмлэхийн нэр</th>
			<th>Дуусах хугацаа</th>
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
			<td><?=$_year;?>жил</td>
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
		<h3>Гадаад хэлний түвшин</h3>
		<table class="edu_tb3" style="width:100%">
		<colgroup>
		<col style="width:30%"><col style="width:70%">
		</colgroup>
		<tr>
			<th>Гадаал хэлний нэр</th>
			<th>Хэлний мэдлэг / сертификаттай оноо / хэлний бэлтгэл</th>
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
				<div><span class="txt_hd">Ярих чадвар</span> <em class="lv1"><?=$_level_txt[0];?></em><span>(<?=$_level_txt[1];?></span></div>
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
				<div><span class="txt_hd">Албан ёсны шалгалт</span><span><?=$__language_txt;?></span> / <span><?=$__level;?>оноо</span> / <span><?=$__year;?>жил</span></div>
				<?php
				}
				?>

				<div><span class="txt_hd">Хэлний бэлтгэл</span> <?=$_study ? $netfu_mjob->language_date[$_study_date] : 'Байхгүй';?></div>
			</td>
		</tr>
		<?php }?>
		</table>
	</div>
	<?php }?>

	<!-- OA능력 및 특기사항 -->
	<div class="resume_ct r_ct3 cf">
		<h3>OA түвшин ба онцлог шинж чанарууд</h3>
		<table class="edu_tb2">
		<colgroup>
		<col style="width:26%"><col style="width:74%">
		</colgroup>
		<tr>
			<th>OA түвшин</th>
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
			<th>Компьютер дээр ажиллах чадвар</th>
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
			<th>Чадвар</th>
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
			<th>Амжилт / Шагнал</th>
			<td><?php echo stripslashes($re_row['wr_prime']);?></td>
		</tr>
		</table>
	</div>

	<!-- 부가정보 -->
	<div class="resume_ct r_ct6 cf">
		<h3>Нэмэлт мэдээлэл</h3>
		<table class="edu_tb3" style="width:100%">
		<colgroup>
		<col style="width:20%"><col style="width:20%"><col style="width:20%"><col style="width:40%">
		</colgroup>
		<tr>
		<th>Хөгжлийн бэрхшээлтэй эсэх</th>
			<th>Гэрлэсэн эсэх</th>
			<th>Цэргийн алба хаасан эсэх</th>
			<th></th>
		</tr>
		<tr>
			<td>
				<?php
				echo $re_row['wr_impediment_use'] ? 'Байгаа' : 'Байхгүй';
				if($re_row['wr_impediment_use']) {
					if($re_row['wr_impediment_level']) $_arr[] = $_cate_['impediment'][$re_row['wr_impediment_level']];
					if($re_row['wr_impediment_name']) $_arr[] = stripslashes($re_row['wr_impediment_name']);
					echo '<div>'.@implode(" : ", $_arr).'</div>';
				}
				?>
			</td>
			<td><?=$re_row['wr_marriage'] ? 'Гэрлэсэн' : 'Ганц бие';?></td>
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
				if($re_row['wr_preferential_use']) $_txt[] = 'National Veterans Recipient<br/>';
				if($re_row['wr_treatment_use']) $_txt[] = 'National Veterans Recipient<br/>';
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