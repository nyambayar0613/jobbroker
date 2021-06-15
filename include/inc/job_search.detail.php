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
<?php
if($_GET['code']!='search') {
?>
.search_tb tr { display:none; }
<?php }?>
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
				<div>근무지역</div>
			</th>
			<td class="sch_td1">
				<select name="area[]" sel="1" class="form-control" type="area" val="<?=$_GET['area'][1];?>" onChange="netfu_util1.ajax_cate(this, 'area', 1)">
				<option value="">시·도</option>
				<?php
				if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
					$selected = $v['code']==$_GET['area'][0] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
			<td class="sch_td2">
				<select name="area[]" sel="2" class="form-control" type="area" this="<?=$_GET['area'][1];?>" val="<?=$_GET['area'][2];?>" onChange="netfu_util1.ajax_cate(this, 'area', 2)">
				<option value="">시·군·구</option>
				</select>
			</td>
			<td class="sch_td3">
				<select name="area[]">
				<option value="">읍·면·동</option>
				</select>
			</td>
		</tr>

		<!-- 업직종 -->
		<tr class="_view">
			<th class="sch_hd">
				<div>업직종</div>
			</th>
			<td class="sch_td1">
				<select name="job_type[]" sel="1" class="form-control" type="job_type" val="<?=$_GET['job_type'][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 1)">
				<option value="">직종1차</option>
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
				<select name="job_type[]" sel="2" class="form-control" type="job_type" this="<?=$_GET['job_type'][1];?>" val="<?=$_GET['job_type'][2];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)">
				<option value="">직종2차</option>
				</select>
			</td>
			<td class="sch_td3">
				<select name="job_type[]">
				<option value="">직종3차</option>
				</select>
			</td>
		</tr>

		<!-- 역세권 -->
		<tr class="_subway">
			<th class="sch_hd">
				<div>역세권</div>
			</th>
			<td class="sch_td1">
				<select name="subway[]" sel="1" class="form-control" type="subway" val="<?=$_GET['subway'][1];?>" onChange="netfu_util1.ajax_cate(this, 'subway', 1)">
				<option value="">시/도</option>
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
				<select name="subway[]" sel="2" class="form-control" type="subway" this="<?=$_GET['subway'][1];?>" val="<?=$_GET['subway'][2];?>" onChange="netfu_util1.ajax_cate(this, 'subway', 2)">
				<option value="">호선</option>
				</select>
			</td>
			<td class="sch_td3">
				<select name="subway[]">
				<option value="">역명</option>
				</select>
			</td>
		</tr>
 
		<!-- 대학가 -->
		<tr class="_univ">
			<th class="sch_hd">
				<div>대학가</div>
			</th>
			<td class="sch_td1">
				<select name="job_college[]" sel="1" class="form-control" type="job_college" val="<?=$_GET['job_college'][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_college', 1)">
				<option value="">시·도</option>
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
				<select name="job_college[]" sel="2" class="form-control" type="job_college" val="<?=$_GET['job_college'][2];?>">
				<option value="">인근대학 선택</option>
				</select>
			</td>
		</tr>

		<!-- 근무기간 -->
		<tr class="_date">
			<th class="sch_hd">
				<div>근무기간</div>
			</th>
			<td class="sch_td1" colspan="3">
				<select name="alba_date" class="form-control">
				<option value="">근무기간</option>
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
				<div>근무요일</div>
			</th>
			<td class="sch_td1" colspan="3">
				<select name="alba_week" class="form-control">
				<option value="">근무요일</option>
				<?php
				if(is_array($_cate_['alba_week'])) { foreach($_cate_['alba_week'] as $k=>$v) {
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
				<select name="wr_target" class="form-control">
				<option value="">대상별</option>
				<?php
				if(is_array($_cate_['job_target'])) { foreach($_cate_['job_target'] as $k=>$v) {
					$selected = $v['code']==$_GET['wr_target'] ? 'selected' : '';
				?>
				<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
				<?php
				} }
				?>
				</select>
			</td>
		</tr>

		<!-- 근무시간 -->
		<tr>
			<th class="sch_hd sch_hd1-2">
				<div>근무시간</div>
			</th>
			<td class="sch_td1 sch_td1-2" colspan="3">
			  <fieldset>
					<legend>근무시간</legend>
					<select name="wr_stime[]" class="form-control">
						<option value="">선택</option>
						<?php
						for($i=0; $i<24; $i++) {
							$_int = sprintf("%02d", $i);
							$selected = $_int==$_GET['wr_stime'][0] ? 'selected' : '';
						?>
						<option value="<?=$_int;?>" <?=$selected;?>><?=$_int;?>시</option>
						<?php
						}
						?>
					</select>
					<select name="wr_stime[]" class="form-control">
						<option value="">선택</option>
						<?php
						for($i=0; $i<6; $i++) {
							$_int = sprintf("%02d", $i*10);
							$selected = $_int==$_GET['wr_stime'][1] ? 'selected' : '';
						?>
						<option value="<?=$_int;?>" <?=$selected;?>><?=$_int;?>분</option>
						<?php
						}
						?>
					</select>
					~
					<select name="wr_etime[]" class="form-control">
						<option value="">선택</option>
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
					<select name="wr_etime[]" class="form-control">
						<option value="">선택</option>
						<?php
						for($i=0; $i<6; $i++) {
							$_int = sprintf("%02d", $i*10);
							$selected = $_int==$_GET['wr_etime'][1] ? 'selected' : '';
						?>
						<option value="<?=$_int;?>" <?=$selected;?>><?=$_int;?>분</option>
						<?php
						}
						?>
					</select>
					<label><input type="checkbox" name="wr_time_conference" value="1" <?=$_GET['wr_time_conference']==1 ? 'checked' : '';?> onclick="time_conference(this);">시간협의</label>
				</fieldset>
			</td>
		</tr>

		<!-- 급여 -->
		<tr class="_pay">
			<th class="sch_hd">
				<div>급여</div>
			</th>
			<td class="sch_td2" colspan="3">
			  <fieldset>
					<legend>급여선택</legend>
					<ul>
						<?php
						if(is_array($_cate_['alba_pay'])) { foreach($_cate_['alba_pay'] as $k=>$v) {
							$checked = @in_array($v['code'], $_GET['alba_pay']) ? 'checked' : '';
						?>
						<li><input type="checkbox" name="alba_pay[]" value="<?=$v['code'];?>" <?=$checked;?>><?=$v['name'];?></li>
						<?php
						} }
						?>
						<input type="text" name="wr_pay[]" value="<?=$_GET['wr_pay'][0];?>">원 이상~<input type="text" name="wr_pay[]" value="<?=$_GET['wr_pay'][1];?>">원 이하</li>
					<ul>
		</fieldset>
			</td>
		</tr>

		<!-- 성별 -->
		<tr>
			<th class="sch_hd">
				<div>성별선택</div>
			</th>
			<td class="sch_td2" colspan="3">
			  <fieldset>
					<legend>성별선택</legend>
					<label><input type="radio" name="wr_gender" value="1" <?=$_GET['wr_gender']==1 ? 'checked' : '';?> />남자</label>
					<label><input type="radio" name="wr_gender" value="2" <?=$_GET['wr_gender']==2 ? 'checked' : '';?> />여자</label>
					<label><input type="radio" name="wr_gender" value="0" <?=$_GET['wr_gender']=='0' ? 'checked' : '';?> />성별무관</label>
		</fieldset>
			</td>
		</tr>

		<!-- 검색유형5 -->
		<tr>
			<th class="sch_hd">
				<div>연령</div>
			</th>
			<td class="sch_td1">
				<select name="wr_age">
					<option value="">선택</option>
					<?php
					for($i=20; $i<=100; $i++) {
						$selected = $_GET['wr_age']==$i ? 'selected' : '';
					?>
					<option value="<?=$i;?>" <?=$selected;?>><?=$i;?>세</option>
					<?php
					}
					?>
				</select>
			</td>
			<td class="sch_td2" colspan="2">
			  <fieldset>
				  <legend>연령선택</legend>
					<label><input type="radio" id="under" name="wr_age_etc" <?=$_GET['wr_age_etc']=='under' ? 'checked' : '';?> value="under" />이하</label>
					<label><input type="radio" id="over" name="wr_age_etc" <?=$_GET['wr_age_etc']=='over' ? 'checked' : '';?> value="over" />이상</label>
					<label><input type="radio" id="unrelated" name="wr_age_etc" <?=$_GET['wr_age_etc']=='1' ? 'checked' : '';?> value="1" />무관</label>
				</fieldset>
			</td>
		</tr>

		<!-- 학력 -->
		<tr>
			<th class="sch_hd">
				<div>학력선택</div>
			</th>
			<td class="sch_td1" colspan="3">
				<select name="wr_ability">
				<option value="">학력</option>
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
				<div>경력선택</div>
			</th>
			<td class="sch_td1">
				<select name="wr_career">
				<option value="">기간</option>
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
					<legend>경력선택</legend>
					<label><input type="radio" id="unrelated" name="wr_career_type" value="0" <?=$_GET['wr_career_type']=='0' ? 'checked' : '';?> />무관</label>
					<label><input type="radio" id="new-recruit" name="wr_career_type" value="1" <?=$_GET['wr_career_type']=='1' ? 'checked' : '';?> />신입</label>
					<label><input type="radio" id="career" name="wr_career_type" value="2" <?=$_GET['wr_career_type']=='2' ? 'checked' : '';?> />경력</label>
				</fieldset>
			</td>
		</tr>

		<!-- 검색어 입력 -->
		<tr>
			<th class="sch_hd" style="background:#fff;border-right:0">
				<div>검색어</div>
			</th>
			<td class="sch_td2 sch_word" colspan="3" style="border-left:0;padding-right:5px">
			  <input type="text" id="" name="search_keyword" value="<?=$_GET['search_keyword'];?>" class="sch_in">
			</td>
		</tr>
		</table>
	</div>
	<div class="schbtn_con cf">
	<ul>
	<li class="search_bx sch_bt sch_bt2" style="width:100%">
		<button type="button" class="sch_button" onClick="document.forms['ftsearch'].submit()"><img src="<?=NFE_URL;?>/images/search_icon3.png" alt="검색">검색</button>
	</li>
	</ul>
	</div>
</div>
</form>
<!-- //상세검색 -->