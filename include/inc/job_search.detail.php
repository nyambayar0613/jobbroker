<?php
$_cate_['job_type'] = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = ''"));
$_cate_['area'] = $netfu_util->get_cate_array('area', array('where'=>" and `p_code` = ''"));
$_cate_['subway'] = $netfu_util->get_cate_array('subway', array('where'=>" and `p_code` = ''"));
$_cate_['job_college'] = $netfu_util->get_cate_array('job_college', array('where'=>""));
$_cate_['alba_date'] = $netfu_util->get_cate_array('alba_date', array('where'=>" and `p_code` = ''"));
$_cate_['alba_week'] = $netfu_util->get_cate_array('alba_week', array('where'=>" and `p_code` = ''"));
$_cate_['alba_pay'] = $netfu_util->get_cate_array('alba_pay', array('where'=>" and `p_code` = ''"));
$_cate_['indi_ability'] = $netfu_util->get_cate_array('indi_ability', array('where'=>" and `p_code` = ''"));
$_cate_['job_career'] = $netfu_util->get_cate_array('job_career', array('where'=>" and `p_code` = ''"));
$_cate_['job_target'] = $netfu_util->get_cate_array('job_target', array('where'=>" and `p_code` = ''"));
?>
<!-- 상세검색 -->
<style type="text/css">
<?php if($_GET['code']!='search') { ?>
.search_tb tr { display:none; }
<?php } ?>
.search_tb tr._view { display:table-row; }
.search_tb tr._<?=$_GET['code'];?> { display:table-row; }
</style>
<form name="ftsearch" action="<?=$_SERVER['PHP_SELF'];?>" method="get">
<input type="hidden" name="code" value="<?=$_GET['code'];?>" />
<div class="schbox_wrap sch_wrap cf">
	<div class="search_con search_box">
		<table class="search_tb table table-bordered">

		<!-- 근무지역 -->
		<tr class="_view">
			<th class="sch_hd">
				Ажлын барйшил
			</th>
			<td class="sch_td1">
				<select name="area[]" sel="1" class="nice-select rounded" type="area" val="<?=$_GET['area'][1];?>" onChange="netfu_util1.ajax_cate(this, 'area', 1)">
				<option value="">хот·дүүрэг</option>
				<?php
				if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
					$selected = $v['code']==$_GET['area'][0] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php } } ?>
				</select>
			</td>
			<td class="sch_td2">
				<select name="area[]" sel="2" class="nice-select rounded" type="area" this="<?=$_GET['area'][1];?>" val="<?=$_GET['area'][2];?>" onChange="netfu_util1.ajax_cate(this, 'area', 2)">
				<option value="">хороо·гудамж·тоот</option>
				</select>
			</td>
			<td class="sch_td3">
				<select name="area[]" class="nice-select rounded">
				<option value="">хороо·гудамж·тоот</option>
				</select>
			</td>
		</tr>

		<!-- 업직종 -->
		<tr class="_view">
			<th class="sch_hd">
				<div>Ажлын төрөл</div>
			</th>
			<td class="sch_td1">
				<select name="job_type[]" sel="1" class="nice-select rounded" type="job_type" val="<?=$_GET['job_type'][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 1)">
				<option value="">Төрөл 1</option>
				<?php
				if(is_array($_cate_['job_type'])) { foreach($_cate_['job_type'] as $k=>$v) {
					$selected = $_GET['job_type'][0]==$v['code'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
			<td class="sch_td2">
				<select name="job_type[]" sel="2" class="nice-select rounded" type="job_type" this="<?=$_GET['job_type'][1];?>" val="<?=$_GET['job_type'][2];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)">
				<option value="">Төрөл 2</option>
				</select>
			</td>
			<td class="sch_td3">
				<select name="job_type[]" class="nice-select rounded">
				<option value="">Төрөл 3</option>
				</select>
			</td>
		</tr>

		<!-- 역세권 -->
		<tr class="_subway">
			<th class="sch_hd">
				<div>Ойролцоох метроны буудал</div>
			</th>
			<td class="sch_td1">
				<select name="subway[]" sel="1" class="nice-select rounded" type="subway" val="<?=$_GET['subway'][1];?>" onChange="netfu_util1.ajax_cate(this, 'subway', 1)">
				<option value="">хот/дүрэг</option>
				<?php
				if(is_array($_cate_['subway'])) { foreach($_cate_['subway'] as $k=>$v) {
					$selected = $v['code']==$_GET['subway'][0] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
			<td class="sch_td2">
				<select name="subway[]" sel="2" class="nice-select rounded" type="subway" this="<?=$_GET['subway'][1];?>" val="<?=$_GET['subway'][2];?>" onChange="netfu_util1.ajax_cate(this, 'subway', 2)">
				<option value="">гарц</option>
				</select>
			</td>
			<td class="sch_td3">
				<select name="subway[]">
				<option value="">Station name</option>
				</select>
			</td>
		</tr>
 
		<!-- 대학가 -->
		<tr class="_univ">
			<th class="sch_hd">
				<div>Их сургууль</div>
			</th>
			<td class="sch_td1">
				<select name="job_college[]" sel="1" class="nice-select rounded" type="job_college" val="<?=$_GET['job_college'][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_college', 1)">
				<option value="">хот·дүүрэг</option>
				<?php
				if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
					$selected = $v['code']==$_GET['job_college'][0] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
			<td class="sch_td2" colspan="2">
				<select name="job_college[]" sel="2" class="nice-select rounded" type="job_college" val="<?=$_GET['job_college'][2];?>">
				<option value="">Ойролцоох их сургууль сонгох</option>
				</select>
			</td>
		</tr>

		<!-- 근무기간 -->
		<tr class="_date">
			<th class="sch_hd">
				<div>Ажиллах хугацаа</div>
			</th>
			<td class="sch_td1" colspan="3">
				<select name="alba_date" class="nice-select rounded">
				<option value="">Ажиллах хугацаа</option>
				<?php
				if(is_array($_cate_['alba_date'])) { foreach($_cate_['alba_date'] as $k=>$v) {
					$selected = $v['code']==$_GET['alba_date'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
		</tr>

		<!-- 근무요일 -->
		<tr>
			<th class="sch_hd">
				<div>Ажлын өдөр</div>
			</th>
			<td class="sch_td1" colspan="3">
				<select name="alba_week" class="nice-select rounded">
				<option value="">Ажлын өдөр</option>
				<?php
				if(is_array($_cate_['alba_week'])) {
				    foreach($_cate_['alba_week'] as $k=>$v) {
					$selected = $v['code']==$_GET['alba_week'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
		</tr>

		<!-- 대상별 -->
		<tr class="_job_target">
			<th class="sch_hd">
				<div>대상</div>
			</th>
			<td class="sch_td1" colspan="3">
				<select name="wr_target" class="nice-select rounded">
				<option value="">대상별</option>
				<?php
				if(is_array($_cate_['job_target'])) {
				    foreach($_cate_['job_target'] as $k=>$v) {
					$selected = $v['code']==$_GET['wr_target'] ? 'selected' : '';
				    ?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				    }
				}
				?>
				</select>
			</td>
		</tr>

		<!-- 근무시간 -->
		<tr>
			<th class="sch_hd sch_hd1-2">
				<div>Ажлын цаг</div>
			</th>
			<td class="sch_td1 sch_td1-2" colspan="3">
			  <fieldset>
					<legend>Ажлын цаг</legend>
					<select name="wr_stime[]" class="nice-select rounded">
						<option value="">Сонгох</option>
						<?php
						for($i=0; $i<24; $i++) {
							$_int = sprintf("%02d", $i);
							$selected = $_int==$_GET['wr_stime'][0] ? 'selected' : '';
						?>
						<option value="<?=$_int;?>" <?=$selected;?>><?=$_int;?>цаг</option>
						<?php
						}
						?>
					</select>
					<select name="wr_stime[]" class="nice-select rounded">
						<option value="">Сонгох</option>
						<?php
						for($i=0; $i<6; $i++) {
							$_int = sprintf("%02d", $i*10);
							$selected = $_int==$_GET['wr_stime'][1] ? 'selected' : '';
						?>
						<option value="<?=$_int;?>" <?=$selected;?>><?=$_int;?>мин</option>
						<?php
						}
						?>
					</select>
					~
					<select name="wr_etime[]" class="nice-select rounded">
						<option value="">Сонгох</option>
						<?php
						for($i=0; $i<24; $i++) {
							$_int = sprintf("%02d", $i);
							$selected = $_int==$_GET['wr_etime'][0] ? 'selected' : '';
						?>
						<option value="<?=$_int;?>" <?=$selected;?>><?=$_int;?></option>
						<?php
						}
						?>
					</select>
					<select name="wr_etime[]" class="nice-select rounded">
						<option value="">Сонгох</option>
						<?php
						for($i=0; $i<6; $i++) {
							$_int = sprintf("%02d", $i*10);
							$selected = $_int==$_GET['wr_etime'][1] ? 'selected' : '';
						?>
						<option value="<?=$_int;?>" <?=$selected;?>><?=$_int;?>мин</option>
						<?php
						}
						?>
					</select>
					<label><input type="checkbox" name="wr_time_conference" value="1" <?=$_GET['wr_time_conference']==1 ? 'checked' : '';?> onclick="time_conference(this);">Цаг тохирох</label>
				</fieldset>
			</td>
		</tr>

		<!-- 급여 -->
		<tr class="_pay">
			<th class="sch_hd">
				<div>Цалин</div>
			</th>
			<td class="sch_td2" colspan="3">
			    <fieldset>
					<legend>Цалин сонгох</legend>
					<ul>
						<?php
                            if(is_array($_cate_['alba_pay'])) {
                                foreach($_cate_['alba_pay'] as $k=>$v) {
                                $checked = @in_array($v['code'], $_GET['alba_pay']) ? 'checked' : '';
                                ?>
                                <li><input type="checkbox" name="alba_pay[]" value="<?=$v['code'];?>" <?=$checked;?>><?=$v['name'];?></li>
                                <?php
                                }
                            }
						?>
                        <li><input type="text" name="wr_pay[]" value="<?=$_GET['wr_pay'][0];?>">-с дээш~<input type="text" name="wr_pay[]" value="<?=$_GET['wr_pay'][1];?>">-с дээш</li>
					<ul>
		        </fieldset>
			</td>
		</tr>

		<!-- 성별 -->
		<tr>
			<th class="sch_hd">
				<div>Хүйс</div>
			</th>
			<td class="sch_td2" colspan="3">
			  <fieldset>
                <legend>Хүйс сонгох</legend>
                <label><input type="radio" name="wr_gender" value="1" <?=$_GET['wr_gender']==1 ? 'checked' : '';?> />Эр</label>
                <label><input type="radio" name="wr_gender" value="2" <?=$_GET['wr_gender']==2 ? 'checked' : '';?> />Эм</label>
                <label><input type="radio" name="wr_gender" value="0" <?=$_GET['wr_gender']=='0' ? 'checked' : '';?> />Хүйс хамаарахгүй</label>
		    </fieldset>
			</td>
		</tr>

		<!-- 검색유형5 -->
		<tr>
			<th class="sch_hd">
				<div>Нас</div>
			</th>
			<td class="sch_td1">
				<select name="wr_age">
					<option value="">Сонгох</option>
					<?php
					for($i=20; $i<=100; $i++) {
						$selected = $_GET['wr_age']==$i ? 'selected' : '';
					?>
					<option value="<?=$i;?>" <?=$selected;?>><?=$i;?>нас</option>
					<?php
					}
					?>
				</select>
			</td>
			<td class="sch_td2" colspan="2">
			  <fieldset>
				  <legend>Нас</legend>
					<label><input type="radio" id="under" name="wr_age_etc" <?=$_GET['wr_age_etc']=='under' ? 'checked' : '';?> value="under" />Дээш</label>
					<label><input type="radio" id="over" name="wr_age_etc" <?=$_GET['wr_age_etc']=='over' ? 'checked' : '';?> value="over" />Дээш</label>
					<label><input type="radio" id="unrelated" name="wr_age_etc" <?=$_GET['wr_age_etc']=='1' ? 'checked' : '';?> value="1" />Нас хамаарахгүй</label>
				</fieldset>
			</td>
		</tr>

		<!-- 학력 -->
		<tr>
			<th class="sch_hd">
				<div>Боловсрол</div>
			</th>
			<td class="sch_td1" colspan="3">
				<select name="wr_ability">
				<option value="">Боловсрол</option>
				<?php
				if(is_array($_cate_['indi_ability'])) { foreach($_cate_['indi_ability'] as $k=>$v) {
					$selected = $v['code']==$_GET['wr_ability'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
		</tr>

		<!-- 검색유형3 -->
		<tr>
			<th class="sch_hd">
				<div>Ажил мэргэжил</div>
			</th>
			<td class="sch_td1">
				<select name="wr_career">
				<option value="">Хугацаа</option>
				<?php
				if(is_array($_cate_['job_career'])) { foreach($_cate_['job_career'] as $k=>$v) {
					$selected = $v['code']==$_GET['wr_career'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
			<td class="sch_td2" colspan="2">
				<fieldset>
					<legend>Туршлага</legend>
					<label><input type="radio" id="unrelated" name="wr_career_type" value="0" <?=$_GET['wr_career_type']=='0' ? 'checked' : '';?> />Хамааралгүй</label>
					<label><input type="radio" id="new-recruit" name="wr_career_type" value="1" <?=$_GET['wr_career_type']=='1' ? 'checked' : '';?> />Шинэ ажилтан</label>
					<label><input type="radio" id="career" name="wr_career_type" value="2" <?=$_GET['wr_career_type']=='2' ? 'checked' : '';?> />Туршлага</label>
				</fieldset>
			</td>
		</tr>

		<!-- 검색어 입력 -->
		<tr>
			<th class="sch_hd" style="background:#fff;border-right:0">
				<div>Хайх үг</div>
			</th>
			<td class="sch_td2 sch_word" colspan="3" style="border-left:0;padding-right:5px">
			  <input type="text" id="" name="search_keyword" value="<?=$_GET['search_keyword'];?>" class="sch_in">
			</td>
		</tr>
		</table>
	</div>

		<button type="button" class="btn btn-primary btn-block" onClick="document.forms['ftsearch'].submit()"><i class="mdi mdi-search-web"></i> Хайх</button>

</div>
</form>
<!-- //상세검색 -->