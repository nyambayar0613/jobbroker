<?php
$editor_use = true;
$page_code = 'mypage';
$member_type = 'individual';
$head_title = "이력서등록";
include "../include/top.php";
// : 카테고리 모음
$_cate_['job_type'] = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = ''"));
$_cate_['area'] = $netfu_util->get_cate_array('area', array('where'=>" and `p_code` = ''"));
$_cate_['alba_date'] = $netfu_util->get_cate_array('alba_date', array('where'=>" and `p_code` = ''"));
$_cate_['alba_week'] = $netfu_util->get_cate_array('alba_week', array('where'=>" and `p_code` = ''"));
$_cate_['alba_time'] = $netfu_util->get_cate_array('alba_time', array('where'=>" and `p_code` = ''"));
$_cate_['alba_pay'] = $netfu_util->get_cate_array('alba_pay', array('where'=>" and `p_code` = ''"));
$_cate_['work_type'] = $netfu_util->get_cate_array('work_type', array('where'=>" and `p_code` = ''"));
$_cate_['job_ability'] = $netfu_util->get_cate_array('job_ability', array('where'=>" and `p_code` = ''"));
$_cate_['indi_ability'] = $netfu_util->get_cate_array('indi_ability', array('where'=>" and `p_code` = ''"));
$_cate_['indi_language'] = $netfu_util->get_cate_array('indi_language', array('where'=>" and `p_code` = ''"));
$_cate_['indi_language_license'] = $netfu_util->get_cate_array('indi_language_license', array('where'=>" and `p_code` = ''"));
$_cate_['indi_oa'] = $netfu_util->get_cate_array('indi_oa', array('where'=>" and `p_code` = ''"));
$_cate_['indi_special'] = $netfu_util->get_cate_array('indi_special', array('where'=>" and `p_code` = ''"));
$_cate_['indi_introduce'] = $netfu_util->get_cate_array('indi_introduce', array('where'=>" and `p_code` = ''"));
$_cate_['indi_treatment'] = $netfu_util->get_cate_array('indi_treatment', array('where'=>" and `p_code` = ''"));
$_cate_['impediment'] = $netfu_util->get_cate_array('impediment', array('where'=>" and `p_code` = ''"));

$indi_oa_list = $category_control->category_codeList('indi_oa', '', 'yes');	// 컴퓨터능력

// : 사용여부 체크를 위한 정보
$category_list = $category_control->category_codeList('alba_resume', " `rank` asc ");
$add_form_arr = array();
$add_form_chk = array();
if(is_array($category_list)) { foreach($category_list as $k=>$v) {
	$add_form_arr[$v['name']] = $v;
	$add_form_chk[$v['name']]['tag'] = $v['etc_0']==1 ? '<span class="check"></span>' : '';
	$add_form_chk[$v['name']]['required'] = $v['etc_0']==1 ? 'required' : '';
} }



$member_info = $netfu_member->member_info($member);

// : 회원정보박스
include NFE_PATH.'/include/inc/member_box.inc.php';

$resume_no = $_GET['no'] ? $_GET['no'] : $_GET['load_no'];
$resume_q = "select * from alice_alba_resume where wr_id='".$member['mb_id']."' order by `no` desc";
$resume_query = sql_query($resume_q);
$_nums = sql_num_rows($resume_query);
$get_resume = $netfu_mjob->get_resume_no($resume_no);
$mode = !$_GET['no'] ? 'insert' : 'update';

// : 지역값
$resume_area = array();
$resume_area[] = array($get_resume['wr_area0'], $get_resume['wr_area1']);
if($get_resume['wr_area2']) $resume_area[] = array($get_resume['wr_area2'], $get_resume['wr_area3']);
if($get_resume['wr_area4']) $resume_area[] = array($get_resume['wr_area4'], $get_resume['wr_area5']);

// : 직종값
$resume_job_type = array();
$resume_job_type[] = array($get_resume['wr_job_type0'], $get_resume['wr_job_type1'], $get_resume['wr_job_type2']);
if($get_resume['wr_job_type3']) $resume_job_type[] = array($get_resume['wr_job_type3'], $get_resume['wr_job_type4'], $get_resume['wr_job_type5']);
if($get_resume['wr_job_type6']) $resume_job_type[] = array($get_resume['wr_job_type6'], $get_resume['wr_job_type7'], $get_resume['wr_job_type8']);

// : 경력사항
$wr_career_un = unserialize($get_resume['wr_career']);

// : 학력사항
$wr_school_ability_arr = explode("/", $get_resume['wr_school_ability']);
$wr_school_type_arr = explode(",", $get_resume['wr_school_type']);
$wr_half_college_arr = unserialize($get_resume['wr_half_college']);
$wr_college_arr = unserialize($get_resume['wr_college']);
$wr_graduate_arr = unserialize($get_resume['wr_graduate']);

// : 자격증
$wr_license = unserialize($get_resume['wr_license']);

// : 외국어
$wr_language = unserialize($get_resume['wr_language']);

// : OA및 특기사항
if($get_resume['wr_oa']) $wr_oa = unserialize($get_resume['wr_oa']);
if($get_resume['wr_computer']) $wr_computer = explode(',', $get_resume['wr_computer']);
if($get_resume['wr_specialty']) $wr_specialty = explode(',', $get_resume['wr_specialty']);

if($get_resume['wr_oa']) $wr_oa = unserialize($get_resume['wr_oa']);
if($get_resume['wr_computer']) $wr_computer = explode(',',$get_resume['wr_computer']);
if($get_resume['wr_specialty']) $wr_specialty = explode(',',$get_resume['wr_specialty']);

// : 부가정보
$wr_treatment_service = explode(',', $get_resume['wr_treatment_service']); // 우대

// : 이력서설정
$wr_calltime = explode('-', $get_resume['wr_calltime']);
?>
<style type="text/css">
.career_con { display:none; }
</style>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/mjob.class.js?time=<?=time();?>"></script>
<form method="post" name="fwrite" action="../regist.php" enctype="multipart/form-data">
<input type="hidden" name="mode" value="resume_write" id="mode"/>
<input type="hidden" name="mb_type" value="<?php echo $member['mb_type'];?>"/>
<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>
<input type="hidden" name="mb_no" value="<?php echo $member['no'];?>"/>
<input type="hidden" name="no" value="<?php echo $_GET['no'];?>"/>
<input type="hidden" name="page_rows" value="<?php echo $page_rows;?>"/>
<input type="hidden" name="page" value="<?php echo $page;?>"/>
<?php
if($_nums>0) {
?>
<style>
.resume_con .row{height:auto}
.resume_con .row04 legend{line-height:1.5}
.resume_con .row04 textarea{float:left;width:77%;border:1px solid #dee3eb;height:100px;padding:10px}
.resume_con .row .chk_li{padding-left:23%;line-height:1.7}
.resume_con .row .chk_li label{float:left;width:129px;margin-right:15px}
.resume_con .row .chk_li label input[type="checkbox"]{position:relative;top:-1px}
.resume_con .row .chk_li label input[type="radio"]{position:relative;top:-1px;margin-right:5px}
.resume_con .row .list2 label{width:auto}
.resume_con .row .list1 table{display:inline-block;width:100%}
.resume_con .row .list1 table th img{margin-right:2px}
.resume_con .row .list1 table th{width:25%;line-height:1.7;word-break:keep-all;padding:0 15px 10px 0}
.resume_con .row .list1 table td{width:75%;vertical-align:middle;padding-bottom:10px}
.resume_con .row .list1 table td label{width:134px;margin-right:10px}
</style>
<section class="cont_box resume_con">
<h2>과거 이력서 불러오기</h2>
	<ul class="info3_con">
		<li class="row1">
			<label for="resume_st1">이력서선택</label>
			<select name="past_list" class="resume_st1" onchange="netfu_mjob.info_load(this);">
			<option value="">이력서를 선택해주시기 바랍니다.</option>
			<?php
			while($row=sql_fetch_array($resume_query)) {
				$selected = $row['no']==$_GET['load_no'] ? 'selected' : '';
			?>
			<option value="<?=$row['no'];?>" <?=$selected;?>><?=date("Y년 m월 d일", strtotime($row['wr_wdate']));?> - <?=strip_tags(stripslashes($row['wr_subject']));?></option>
			<?php
			}
			?>
			</select>
		</li>
	</ul>
</section>
<?php }?>
<section class="cont_box resume_con">
<h2>희망근무조건</h2>
	<ul class="info3_con">
		<li class="row1">
			<label for="resume_tit">이력서제목<span class="check"></span></label>
				<input type="text" id="resume_tit" name="wr_subject" hname="이력서제목" required value="<?php echo $get_resume['wr_subject'];?>">
			</li>
			<li class="row2">
				<fieldset>
					<legend>희망 근무지<span class="check"></span></legend>
					<div class="select_area_put">
					<?php
					for($i=0; $i<count($resume_area); $i++) {
						$_name1 = $i*2;
						// : 2차카테고리값은 util1.class.js의 auto_select_selected함수에서 자동으로 보여줍니다.
					?>
					<div class="select_area select_gp cf">
						<div class="select_inner cf">
							<select name="wr_area<?=$_name1;?>" hname="희망근무지" required sel="1" type="area" val="<?=$resume_area[$i][1];?>" put="wr_area<?=$_name1+1;?>_id" onChange="netfu_util1.ajax_cate(this, 'area', 1)">
							<option value="">시·도</option>
							<?php
							if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
								$selected = $v['code']==$resume_area[$i][0] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php
							} }
							?>
							</select>
							<select name="wr_area<?=$_name1+1;?>" hname="시·군·구" required id="wr_area<?=$_name1+1;?>_id">
							<option value="">시·군·구</option>
							</select>
							<button type="button" class="plus_bt1 _add_button" onClick="netfu_mjob.area_add(this, '<?=$i==0 ? 'add' : 'del';?>')"><?=$i==0 ? '추가' : '삭제';?> +</button>
						</div>
					</div>
					<?php }?>
					</div>
					<div class="home-work"><label for="wr_home_work_1"><input type="checkbox" id="wr_home_work_1" name="wr_home_work" value="1" <?php echo ($get_resume['wr_home_work']) ? 'checked' : '';?>>재택근무가능</label></div>
				</fieldset>
			</li>
			<li class="row10">
				<fieldset>
					<legend>근무일시<span class="check"></span></legend>
					<div class="select_gp cf">
						<div class="select_inner cf">
							<select name="wr_date" hname="근무기간">
								<?php
								if(is_array($_cate_['alba_date'])) { foreach($_cate_['alba_date'] as $k=>$v) {
									$selected = $v['code']==$get_resume['wr_date'] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }?>
							</select>
							<select name="wr_week" hname="근무요일">
								<?php
								if(is_array($_cate_['alba_week'])) { foreach($_cate_['alba_week'] as $k=>$v) {
									$selected = $v['code']==$get_resume['wr_week'] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }?>
							</select>
							<select name="wr_time" hname="근무시간">
								<?php
								if(is_array($_cate_['alba_time'])) { foreach($_cate_['alba_time'] as $k=>$v) {
									$selected = $v['code']==$get_resume['wr_time'] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }?>
							</select>
						</div>
					</div>
					<div class="work"><label for="home_work"><input type="checkbox" id="work" name="wr_work_direct" value="1" <?=$get_resume['wr_work_direct'] ? 'checked' : '';?>>즉시출근가능</label></div>
				</fieldset>
			</li>
			<li class="row3">
				<fieldset>
					<legend>업직종<span class="check"></span></legend>
					<div class="select_job_type_put">
					<?php
					for($i=0; $i<count($resume_job_type); $i++) {
						$_name1 = $i*3;

						if($resume_job_type[$i][0]) $job_type1_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$resume_job_type[$i][0]."'"));

						if($resume_job_type[$i][1]) $job_type2_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$resume_job_type[$i][1]."'"));
					?>
					<div class="select_job_type select_gp cf">
						<div class="select_inner cf">
							<select name="wr_job_type<?=$_name1;?>" hname="1차직종" required sel="1" type="job_type" val="<?=$resume_job_type[$i][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 1)" put="wr_job_type<?=$_name1+1;?>_id" auto_none>
							<option value="">1차직종선택</option>
							<?php
							if(is_array($_cate_['job_type'])) { foreach($_cate_['job_type'] as $k=>$v) {
								$selected = $resume_job_type[$i][0]==$v['code'] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php
							} }
							?>
							</select>
							<select name="wr_job_type<?=$_name1+1;?>" hname="2차직종" required type="job_type" id="wr_job_type<?=$_name1+1;?>_id" put="wr_job_type<?=$_name1+2;?>_id" sel="2" type="job_type" val="<?=$resume_job_type[$i][2];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)" auto_none>
							<option value="">2차직종선택</option>
							<?php
							if(is_array($job_type1_arr)) { foreach($job_type1_arr as $k=>$v) {
								$selected = $resume_job_type[$i][1]==$v['code'] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php } }?>
							</select>
							<select name="wr_job_type<?=$_name1+2;?>" id="wr_job_type<?=$_name1+2;?>_id">
							<option value="">3차직종선택</option>
							<?php
							if(is_array($job_type2_arr)) { foreach($job_type2_arr as $k=>$v) {
								$selected = $resume_job_type[$i][2]==$v['code'] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php } }?>
							</select>
							<button type="button" class="plus_bt1 plus_bt2" onClick="netfu_mjob.job_type_add(this, '<?=$i==0 ? 'add' : 'del';?>')"><?=$i==0 ? '추가' : '삭제';?> +</button>
						</div>
					</div>
					<?php }?>
					</div>
				</fieldset>
			</li>
			<li class="row4">
				<fieldset>
					<legend>희망급여<span class="check"></span></legend>
					<select name="wr_pay_type" id="pay" class="pay_slt" <?=($get_resume['wr_pay_conference'])?'disabled':'required';?> hname="급여조건">
						<option value="">급여</option>
						<?php
						if(is_array($_cate_['alba_pay'])) { foreach($_cate_['alba_pay'] as $k=>$v) {
							$selected = ($get_resume['wr_pay_type'] == $v['code']) ? "selected" : "";
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php
						} }
						?>
					</select>
					<input type="text"  id="pay" name="wr_pay" value="<?=$get_resume['wr_pay'];?>" class="pay1" <?php echo ($get_resume['wr_pay_conference']) ? 'disabled' : 'required';?> hname="급여금액">
					<span>원</span><input type="checkbox" id="wr_pay_conference_1" value="1" name="wr_pay_conference" <?php echo ($get_resume['wr_pay_conference'])?'checked':'';?> onClick="netfu_mjob.pay_conference(this)"><label for="wr_pay_conference_1"><span>추후협의</span></label>
				</fieldset>
			</li>
			<li class="row5">
				<fieldset>
					<legend>근무형태<span class="check"></span></legend>
					<ul>
						<?php
						if(is_array($_cate_['work_type'])) { foreach($_cate_['work_type'] as $k=>$v) {
							$checked = (@in_array($v['code'],explode(",", $get_resume['wr_work_type']))) ? "checked" : "";
						?>
						<li><input type="checkbox" name="wr_work_type[]" required hname="근무형태" value="<?=$v['code'];?>" <?=$checked;?>><?=$v['name'];?></li>
						<?php
						} }
						?>
					</ul>
				</fieldset>
			</li>
		</ul>
</section>

<?php if($add_form_arr['경력사항']['view']=='yes'){ ?>
<section class="cont_box resume_con">
	<h2>경력사항<?=$add_form_chk['경력사항']['tag'];?></h2>
	<ul class="info3_con career_ul">
		<li class="row_con">
			<label for="career">경력</label>
			<input type="checkbox" name="wr_career_use" value="1" id="wr_career_use_1" onClick="netfu_mjob.career_use(this)" <?php echo ($get_resume['wr_career_use'])?'checked':'';?> <?=$add_form_chk['경력사항']['required'];?> hname="경력사항"><label for="wr_career_use_1">경력있음</label>
		</li>
		<?php
		for($career_int=0; $career_int<count($wr_career_un); $career_int++) {
			$career_arr = $wr_career_un[$career_int];

			$sdate_arr = explode("-", $career_arr['sdate']);
			$edate_arr = explode("-", $career_arr['edate']);

			// : 직종
			if($career_arr['type'][0]) $career_job_type1_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$career_arr['type'][0]."'"));
			if($career_arr['type'][1]) $career_job_type2_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$career_arr['type'][1]."'"));
		?>
		<li class="career_con" style="display:<?=$get_resume['wr_career_use'] ? 'block' : 'none';?>;">
			<table>
			<tr>
				<th>회사명<?php if($add_form_chk['경력사항']['required']=='required') {?><span class="check"></span><?php }?></th>
				<td><input type="text" name="wr_career_company[]" hname="회사명" <?=$add_form_chk['경력사항']['required'];?> value="<?=$career_arr['company'];?>"></td>
			</tr>
			<tr>
				<th>근무직종<?php if($add_form_chk['경력사항']['required']=='required') {?><span class="check"></span><?php }?></th>
				<td>
					<select name="wr_career_type_<?=$career_int;?>[]" sel="1" type="job_type" val="<?=$_GET['job_type'][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 1)" auto_none hname="경력 1차직종" <?=$add_form_chk['경력사항']['required'];?>>
						<option value="">1차직종선택</option>
						<option value="">직종1차</option>
						<?php
						if(is_array($_cate_['job_type'])) { foreach($_cate_['job_type'] as $k=>$v) {
							$selected = $career_arr['type'][0]==$v['code'] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php
						} }
						?>
					</select>
					<select name="wr_career_type_<?=$career_int;?>[]" sel="2" type="job_type" val="<?=$_GET['job_type'][2];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)" auto_none hname="경력 2차직종" <?=$add_form_chk['경력사항']['required'];?>>
					<option value="0">2차직종선택</option>
					<?php
					if(is_array($career_job_type1_arr)) { foreach($career_job_type1_arr as $k=>$v) {
						$selected = $career_arr['type'][1]==$v['code'] ? 'selected' : '';
					?>
					<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
					<?php
					} }
					?>
					</select>
					<select name="wr_career_type_<?=$career_int;?>[]">
					<option value="0">3차직종선택</option>
					<?php
					if(is_array($career_job_type2_arr)) { foreach($career_job_type2_arr as $k=>$v) {
						$selected = $career_arr['type'][2]==$v['code'] ? 'selected' : '';
					?>
					<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
					<?php
					} }
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th>근무기간<?php if($add_form_chk['경력사항']['required']=='required') {?><span class="check"></span><?php }?></th>
				<td class="term">
					<select name="wr_career_syear[]" class="st_year" hname="근무기간" <?=$add_form_chk['경력사항']['required'];?>>
						<option value="">년</option>
						<?php
						for($i=date('Y');$i>=1900;--$i){
							$selected = ($sdate_arr[0]==$i)?'selected':'';
						?>
						<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
						<?php } ?>>
					</select>
					<select name="wr_career_smonth[]" class="st_month" hname="근무기간" <?=$add_form_chk['경력사항']['required'];?>>
						<option value="">월</option>
						<?php
						for($i=1;$i<=12;$i++){
							$selected = ($sdate_arr[1]==$i)?'selected':'';
						?>
						<option value="<?php echo sprintf('%02d',$i);?>" <?=$selected;?>><?php echo sprintf('%02d',$i);?></option>
						<?php } ?>
					</select>
						<span>부터</span>
					<select name="wr_career_eyear[]" class="st_year" hname="근무기간" <?=$add_form_chk['경력사항']['required'];?>>
						<option value="">년</option>
						<?php
						for($i=date('Y');$i>=1900;--$i){
							$selected = ($edate_arr[0]==$i)?'selected':'';
						?>
						<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
						<?php } ?>
					</select>
					<select name="wr_career_emonth[]" class="st_month" hname="근무기간" <?=$add_form_chk['경력사항']['required'];?>>
						<option>월</option>
						<?php
						for($i=1;$i<=12;$i++){
							$selected = ($edate_arr[1]==$i)?'selected':'';
						?>
						<option value="<?php echo sprintf('%02d',$i);?>" <?=$selected;?>><?php echo sprintf('%02d',$i);?></option>
						<?php } ?>
					</select>
					<span>까지</span>
					</td>
				</tr>
				<tr>
				  <th>담당업무<?php if($add_form_chk['경력사항']['required']=='required') {?><span class="check"></span><?php }?></th>
					<td><input type="text" name="wr_career_job[]" value="<?=$career_arr['job'];?>" hname="담당업무" <?=$add_form_chk['경력사항']['required'];?>></td>
				</tr>
				<tr>
				  <th>상세업무</th>
					<td><textarea name="wr_career_content[]"><?=$career_arr['content'];?></textarea></td>
				</tr>
			</table>
			<button type="button" class="plus_bt1 plus_bt_r" style="margin-left:10px !important" onClick="netfu_mjob.career_job_type_add(this, '<?=$career_int==0 ? 'add' : 'del';?>')"><?=$career_int==0 ? '추가' : '삭제';?> +</button>
		</li>
		<?php }?>
	</ul>
</section>
<?php }?>

<?php if($add_form_arr['학력사항']['view']=='yes'){ ?>
<section class="cont_box resume_con">
	<h2>학력사항<?=$add_form_chk['학력사항']['tag'];?></h2>
	<ul class="info3_con">
		<li class="row_con">
			<fieldset>
				<legend>최종학력<span class="check"></span></legend>
				<select name="wr_school_ability" class="resume_st2" <?=$add_form_chk['학력사항']['required'];?> hname="학력" required onChange="netfu_mjob.school_ability_change(this)">
					<option value="">학력선택</option>
					<?php
					if(is_array($_cate_['indi_ability'])) { foreach($_cate_['indi_ability'] as $k=>$v) {
						$selected = $v['code']==$wr_school_ability_arr[0] ? 'selected' : '';
					?>
					<option value="<?=$v['code']."/".$v['rank'];?>" <?=$selected;?>><?=$v['name'];?></option>
					<?php
					} }
					?>
				</select>
				<script type="text/javascript">
				netfu_mjob.school_ability_change($("[name='wr_school_ability']")[0]);
				</script>
				<input type="checkbox" name="wr_school_absence" value="1" <?php echo ($get_resume['wr_school_absence']) ? 'checked' : '';?>>휴학중

				<!-- 추가 선택박스 : 대학2,3년 이상 선택했을 경우에만 나타남 -->
				<div class="sch_select">
					<div class="st-bx cf">
						<legend>입력할 학력선택</legend>
						<?php
						$kkk = 0;
						foreach($netfu_mjob->school_arr1 as $k=>$v) {
							$checked = @in_array($k, $wr_school_type_arr) ? 'checked' : '';
						?>
						<span><input type="checkbox" name="wr_school_type[]" value="<?=$k?>" onClick="netfu_mjob.school_type_click(this, '<?=$kkk;?>')" <?=$checked;?>><?=$v;?></span>
						<?php
							$kkk++;
						}
						?>
					</div>
				</div>
			</fieldset>
			<div class="school_div">
		  <!-- 고등학교 -->
			<div class="sch1 cf _high_school" style="display:none;">
			  <fieldset>
					<legend>고등학교</legend>
					<div class="st-bx cf">
						<input type="text" id="height_sch" name="wr_high_school_name" value="<?=stripslashes($get_resume['wr_high_school_name']);?>" placeholder="출신학교 입력">
						<select name="wr_high_school_syear">
							<option value="">년도</option>
							<?php for($i=date('Y');$i>=1900;--$i){ ?>
							<option value='<?=$i?>' <?php echo ($get_resume['wr_high_school_syear']==$i)?'selected':'';?>><?=$i?></option>
							<?php } ?>
						</select>
						<span>년 </span><span> ~</span>
						<select name="wr_high_school_eyear">
							<option value="">년도</option>
							<?php for($i=date('Y');$i>=1900;--$i){ ?>
							<option value='<?=$i?>' <?php echo ($get_resume['wr_high_school_eyear']==$i)?'selected':'';?>><?=$i?></option>
							<?php } ?>
						</select>
						<select name="wr_high_school_graduation" class="sch-st2">
							<option value="">졸업여부</option>
							<option value="0" <?=($get_resume['wr_high_school_graduation']=='0')?'selected':'';?>>졸업</option>
							<option value="1" <?=($get_resume['wr_high_school_graduation']=='1')?'selected':'';?>>재학</option>
						</select>
					</div>
				</fieldset>
			</div>
		  <!-- 대학(2,3년)  -->
			<div class="sch1 cf _half_college" style="display:none;">
			  <fieldset>
					<legend>대학(2,3년)</legend>
					<?php
					$_len = count($wr_half_college_arr['college']);
					if($_len<=0) $_len = 1;
					for($co=0; $co<$_len; $co++) {
						$_college = $wr_half_college_arr['college'][$co];
						$_college_specialize = $wr_half_college_arr['college_specialize'][$co];
						$_syear = $wr_half_college_arr['college_syear'][$co];
						$_eyear = $wr_half_college_arr['college_eyear'][$co];
						$_graduation = $wr_half_college_arr['college_graduation'][$co];
					?>
					<div class="st-bx cf _school_part">
						<input type="text" id="height_sch" name="wr_half_college[]" value="<?=$_college;?>" placeholder="출신학교 입력">
						<input type="text" id="height_sch" name="wr_half_college_specialize[]" value="<?=$_college_specialize;?>" placeholder="전공입력">
						<select name="wr_half_college_syear[]">
							<option value="">년도</option>
							<?php for($i=date('Y');$i>=1900;--$i){ ?>
							<option value='<?=$i?>' <?php echo ($_syear==$i)?'selected':'';?>><?=$i?></option>
							<?php } ?>
						</select>
						<span>년 </span><span> ~</span>
						<select name="wr_half_college_eyear[]">
							<option value="">년도</option>
							<?php for($i=date('Y');$i>=1900;--$i){ ?>
							<option value='<?=$i?>' <?php echo ($_eyear==$i)?'selected':'';?>><?=$i?></option>
							<?php } ?>
						</select>
						<span>년</span>
						<select name="wr_half_college_graduation[]" class="sch-st2">
							<option value="">졸업여부</option>
							<option value="0" <?php echo ($_graduation=='0')?'selected':'';?>>졸업</option>
							<option value="1" <?php echo ($_graduation=='1')?'selected':'';?>>재학</option>
							<option value="2" <?php echo ($_graduation=='2')?'selected':'';?>>중퇴</option>
						</select>
						<span class="btn_layer cf"><button type="button" class="plus_bt1 plus_bt4" onClick="netfu_mjob.school_add(this, '<?=$co==0 ? 'add' : 'del';?>')"><?=$co==0 ? '추가' : '삭제';?> +</button></span>
					</div>
					<?php }?>
					
				</fieldset>
			</div>

		  <!-- 대학(4년) 중퇴-->
			<div class="sch1 cf _college" style="display:none;">
			  <fieldset>
					<legend>대학(4년)</legend>
					<?php
					$_len = count($wr_college_arr['college']);
					if($_len<=0) $_len = 1;

					for($co=0; $co<$_len; $co++) {
						$_college = $wr_college_arr['college'][$co];
						$_college_specialize = $wr_college_arr['college_specialize'][$co];
						$_syear = $wr_college_arr['college_syear'][$co];
						$_eyear = $wr_college_arr['college_eyear'][$co];
						$_graduation = $wr_college_arr['college_graduation'][$co];
					?>
					<div class="st-bx cf _school_part">
						<input type="text" id="height_sch" name="wr_college[]" value="<?=$_college;?>" placeholder="출신학교 입력">
						<input type="text" id="height_sch" name="wr_college_specialize[]" value="<?=$_college_specialize;?>" placeholder="전공입력">
						<select name="wr_college_syear[]">
							<option value="">년도</option>
							<?php
							for($i=date('Y');$i>=1900;--$i){
								$selected = ($_syear==$i) ? 'selected' : '';
							?>
							<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
							<?php } ?>
						</select>
						<span>년 </span><span> ~</span>
						<select name="wr_college_eyear[]">
							<option>년도</option>
							<?php
							for($i=date('Y');$i>=1900;--$i){
								$selected = ($_eyear==$i) ? 'selected' : '';
							?>
							<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
							<?php } ?>
						</select>
						<span>년 </span>
						<select name="wr_college_graduation[]" class="sch-st2">
							<option value="">졸업여부</option>
							<option value="0" <?php echo ($_graduation=='0') ? 'selected' : '';?>>졸업</option>
							<option value="1" <?php echo ($_graduation=='1') ? 'selected' : '';?>>재학</option>
							<option value="2" <?php echo ($_graduation=='2') ? 'selected' : '';?>>중퇴</option>
						</select>
						<span class="btn_layer cf"><button type="button" class="plus_bt1 plus_bt4" onClick="netfu_mjob.school_add(this, 'add')">추가 +</button></span>
					</div>
					<?php }?>
					
				</fieldset>
			</div>

		  <!-- 대학원 중퇴 -->
			<div class="sch1 cf _graduate" style="display:none;">
			  <fieldset>
					<legend>대학원</legend>
					<?php
					$_len = count($wr_graduate_arr['graduate']);
					if($_len<=0) $_len = 1;

					for($co=0; $co<$_len; $co++) {
						$_graduate = $wr_graduate_arr['graduate'][$co];
						$_specialize = $wr_graduate_arr['graduate_specialize'][$co];
						$_syear = $wr_graduate_arr['graduate_syear'][$co];
						$_eyear = $wr_graduate_arr['graduate_eyear'][$co];
						$_grade = $wr_graduate_arr['graduate_grade'][$co];
						$_graduation = $wr_graduate_arr['graduate_graduation'][$co];
					?>
					<div class="st-bx cf _school_part">
						<input type="text" id="height_sch" name="wr_graduate[]" value="<?=$_graduate;?>" placeholder="출신학교 입력">
						<input type="text" id="height_sch" name="wr_graduate_specialize[]" value="<?=$_specialize;?>" placeholder="전공입력">
						<select name="wr_graduate_grade[]" class="degree">
						<option value="">학위</option>
						<option value='0' <?php echo ($_grade=='0') ? 'selected' : '';?>>석사</option>
						<option value='1' <?php echo ($_grade=='0') ? 'selected' : '';?>>박사</option>
						</select>
						<select name="wr_graduate_syear[]">
						<option value="">년도</option>
						<?php
						for($i=date('Y');$i>=1900;--$i){
							$selected = ($_syear==$i) ? 'selected' : '';
						?>
						<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
						<?php } ?>
						</select>
						<span>년 </span><span> ~</span>
						<select name="wr_graduate_eyear[]">
						<option>년도</option>
						<?php
						for($i=date('Y');$i>=1900;--$i){
							$selected = ($_eyear==$i) ? 'selected' : '';
						?>
						<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
						<?php } ?>
						</select>
						<span>년 </span>
						<select name="wr_graduate_graduation[]" class="sch-st2">
						<option value="">졸업여부</option>
						<option value="0" <?php echo ($_graduation=='0') ? 'selected' : '';?>>졸업</option>
						<option value="1" <?php echo ($_graduation=='1') ? 'selected' : '';?>>수료</option>
						<option value="2" <?php echo ($_graduation=='2') ? 'selected' : '';?>>재학</option>
						<option value="3" <?php echo ($_graduation=='3') ? 'selected' : '';?>>중퇴</option>
						</select>
						<span class="btn_layer cf"><button type="button" class="plus_bt1 plus_bt4" onClick="netfu_mjob.school_add(this, 'add')">추가 +</button></span>
					</div>
					<?php }?>
				</fieldset>
			</div>
			</div>
			<script type="text/javascript">
			$("[name='wr_school_type[]']").each(function(){
				if($(this)[0].checked===true)
					$("._"+$(this).val()).css({"display":"block"});
			});
			</script>
		</li>
	</ul>
	</section>
	<?php }?>


<?php if($add_form_arr['보유자격증']['view']=='yes'){ ?>
<section class="cont_box resume_con">
  <h2>보유자격증<?=$add_form_chk['보유자격증']['tag'];?></h2>
	  <ul class="info3_con">
			<li class="row_con">
			  <label for="license">자격증</label>
				<input type="checkbox" id="wr_license_use_1" name="wr_license_use" value="1" onClick="netfu_mjob.career_use_click(this)" <?php echo ($get_resume['wr_license_use'])?'checked':'';?> <?=$add_form_chk['보유자격증']['required'];?> hname="자격증" option="checkbox"><label for="wr_license_use_1">자격증있음</label>
			</li>
			<li class="row_con">
				<label for="license_con" style="text-indent:-9999px">자격증내용</label>
				<div class="license_body" style="display:<?=$get_resume['wr_license_use'] ? 'block' : 'none';?>;">
				<?php
				$_len = count($wr_license);
				if($_len<=0) $_len = 1;
				for($license_i=0; $license_i<$_len; $license_i++) {
					$_name = $wr_license[$license_i]['name'];
					$_public = $wr_license[$license_i]['public'];
					$_year = $wr_license[$license_i]['year'];
				?>
				<ul class="license_con">
					<li><label for="license1">자격증명</label><input type="text" id="license1" name="wr_license_name[]" hname="자격증명" value="<?=stripslashes($_name);?>"></li>
					<li><label for="license2">발행처<span class="check"></span></label></label><input type="text" id="license1" name="wr_license_public[]" hname="발행처"  value="<?=stripslashes($_public);?>"></li>
					<li>
						<label for="license3">취득년도<span class="check"></span></label></label>
						<select id="license3" name="wr_license_year[]" hname="취득년도" >
						<option value="">년</option>
						<?php
						for($i=date('Y');$i>=1900;--$i){
						$selected = $_year==$i ? 'selected' : '';
						?>
						<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
						<?php } ?>
						</select>
						년
					</li>
					<button type="button" class="plus_bt1 plus_bt_r" style="margin-left:10px !important" onClick="netfu_mjob.license_add(this, 'add')">추가 +</button>
				</ul>
				<?php }?>
				</div>
			</li>
</ul>
</section>
<?php }?>


<?php if($add_form_arr['외국어 능력']['view']=='yes'){ ?>
<section class="cont_box resume_con">
	<h2>외국어능력<?=$add_form_chk['외국어 능력']['tag'];?></h2>
	<ul class="info3_con">
		<li class="row_con">
			<label for="language">외국어능력</label>
			<input type="checkbox" id="wr_language_use_1" name="wr_language_use" onClick="netfu_mjob.language_use_click()" value="1" <?php echo ($get_resume['wr_language_use']) ? 'checked' : '';?> <?=$add_form_chk['외국어 능력']['required'];?> hname="자격증" option="checkbox"><label for="wr_language_use_1">외국어능력 있음</label>
		</li>
		<li class="language_con" style="display:<?php echo ($get_resume['wr_language_use']) ? 'table' : 'none';?>;">
			<label for="language" style="text-indent:-9999px">자격증내용</label>
			<?php
			$_len = count($wr_language);
			if($_len<=0) $_len = 1;
			for($language_i=0; $language_i<$_len; $language_i++) {
				$_language = $wr_language[$language_i]['language'];
				$_level = $wr_language[$language_i]['level'];
				$_license = $wr_language[$language_i]['license'];
				$_study = $wr_language[$language_i]['study'];
				$_study_date = $wr_language[$language_i]['study_date'];
			?>
			<table class="language_table">
			<thead>
			<tr>
				<th>외국어<span class="check"></span></th>
				<td>
					<select name="wr_language_name[]" hname="외국어" required style="width:50%">
						<option value="">외국어선택</option>
						<?php
						if(is_array($_cate_['indi_language'])) { foreach($_cate_['indi_language'] as $k=>$v) {
							$selected = $_language==$v['code'] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php } }?>
						<option></option>
					</select>
					<button type="button" class="plus_bt1 plus_bt_r" style="margin-left:10px !important" onClick="netfu_mjob.language_add(this, 'add')">추가 +</button>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<fieldset>
						<legend>외국어선택</legend>
						<ol>
							<?php
							foreach($netfu_mjob->language_level as $k=>$v) {
								$checked = $_level==$k ? 'checked' : '';
							?>
							<li><input type="radio" id="high" name="wr_language_level_<?=$language_i;?>" value="<?=$k;?>" <?=$checked;?>><?=$v;?></li>
							<?php
							}
							?>
						</ol>
					</fieldset>
				</td>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td colspan="2" class="_language_td">
					<?php
					$_len2 = count($_license['license']);
					if($_len2<=0) $_len2 = 1;
					for($_licence_i=0; $_licence_i<$_len2; $_licence_i++) {
						$__license = $_license['license'][$_licence_i];
						$__level = $_license['level'][$_licence_i];
						$__year = $_license['year'][$_licence_i];
					?>
					<ul class="_language_part">
						<li>
							<fieldset>
								<legend>공인시험</legend>
								<select name="language_license_<?=$language_i;?>[]">
									<option value="">시험선택</option>
									<?php
									if(is_array($_cate_['indi_language_license'])) { foreach($_cate_['indi_language_license'] as $k=>$v) {
										$selected = $__license==$v['code'] ? 'selected' : '';
									?>
									<option value="<?=$v['code'];?>" <?=$selected;?>><?=stripslashes($v['name']);?></option>
									<?php } }?>
								</select>
							</fieldset>
						</li>
						<li>
						<fieldset>
							<legend>취득년도</legend>
							<select name="language_license_year_<?=$language_i;?>[]" class="st-year">
							<option value="">년</option>
							<?php
							for($i=date('Y');$i>=1900;--$i){
								$selected = $__year==$i ? 'selected' : '';
							?>
							<option value='<?=$i?>' <?=$selected;?>><?=$i?></option>
							<?php } ?>
							</select>
							년
						</fieldset>
						</li>
						<li><label for="lang2">점수/등급</label><input type="text" id="lang2" name="language_license_level_<?=$language_i;?>[]" value="<?=$__level;?>"></li>
						<li><button type="button" class="plus_bt1 plus_bt4" onClick="netfu_mjob.language_part_add(this, '<?=$_licence_i==0 ? 'add' : 'del';?>')">시험<?=$_licence_i==0 ? '추가' : '삭제';?> +</button></li>
					</ul>
					<?php }?>
				</td>
			</tr>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="2">
					<div class="research_con cf">
						<input type="checkbox" name="wr_language_study_<?=$language_i?>"  <?php echo ($_study) ? 'checked' : '';?>>어학연수 경험있음
						<select name="wr_language_study_date_<?php echo $language_i;?>" class="time">
						<option value="">연수기간 선택</option>
						<?php
						foreach($netfu_mjob->language_date as $k => $v){
							$selected = ($_study_date==$k) ? 'selected' : '';
						?>
						<option value="<?=$k?>" <?=$selected;?>><?=$v;?></option>
						<?php }?>
						</select>
					</div>
				</td>
			</tr>
			</tfoot>
			</table>
			<?php }?>
		</li>
	</ul>
</section>
<script type="text/javascript">netfu_mjob.language_use_click();</script>
<?php }?>

<?php if($add_form_arr['OA능력 및 특기사항']['view']=='yes'){ ?>
<section class="cont_box resume_con">
	<h2>OA능력 및 특기사항</h2>
  <ul class="info3_con">
    <li class="row row01">
		  <fieldset>
			  <legend>OA능력</legend>
				<div class="chk_li list1">
				  <table>
					  <tr>
						  <th><img alt="워드" src="../images/icon/icon_word1.gif" width="16" height="16" alt="워드">워드(한글MS워드)</th>
						  <td>
					      <label for="oa_w01"><input type="radio" id="oa_w01" name="wr_oa[word]" value="0" checked>상(표/도구 활용기능)</label>
					      <label for="oa_w02"><input type="radio" id="oa_w02" name="wr_oa[word]" value="1" <?php echo ($wr_oa['word']=='1')?'checked':'';?>>중(문서편집기능)</label>
					      <label for="oa_w03"><input type="radio" id="oa_w03" name="wr_oa[word]" value="2" <?php echo ($wr_oa['word']=='2')?'checked':'';?>>하(기본사용)</label>
					    </td>
						</tr>
						<tr>
						  <th><img alt="프리젠테이션" src="../images/icon/icon_power1.gif" width="16" height="16" alt="파워포인트">프리젠테이션(파워포인트)</th>
						  <td>
					      <label for="oa_p01"><input type="radio" id="oa_p01" name="wr_oa[pt]" value="0" checked>상(챠트/효과 활용기능)</label>
					      <label for="oa_p02"><input type="radio" id="oa_p02" name="wr_oa[pt]" value="1" <?php echo ($wr_oa['pt']=='1')?'checked':'';?>>중(서식/도형 가능)</label>
					      <label for="oa_p03"><input type="radio" id="oa_p03" name="wr_oa[pt]" value="2" <?php echo ($wr_oa['pt']=='2')?'checked':'';?>>하(기본사용)</label>
					    </td>
						</tr>
						<tr>
						  <th><img alt="스프레드시트" src="../images/icon/icon_excel1.gif" width="16" height="16" alt="엑셀">스프레드시트(엑셀)</th>
						  <td>
					      <label for="oa_s01"><input type="radio" id="oa_s01" name="wr_oa[sheet]" value="0" checked>상(수식/함수 활용가능)</label>
					      <label for="oa_s02"><input type="radio" id="oa_s02" name="wr_oa[sheet]" value="1" <?php echo ($wr_oa['sheet']=='1')?'checked':'';?>>중(데이터 편집가능)</label>
					      <label for="oa_s03"><input type="radio" id="oa_s03" name="wr_oa[sheet]" value="2" <?php echo ($wr_oa['sheet']=='2')?'checked':'';?>>하(기본사용)</label>
					    </td>
						</tr>
						  <th><img alt="인터넷" src="../images/icon/icon_ie1.gif" width="16" height="16" alt="인터넷">인터넷(정보검색)</th>
						  <td>
					      <label for="oa_i01"><input type="radio" id="oa_i01" name="wr_oa[internet]" value="0" checked>상(정보수집 능숙)</label>
					      <label for="oa_i02"><input type="radio" id="oa_i02" name="wr_oa[internet]" value="1" <?php echo ($wr_oa['internet']=='1')?'checked':'';?>>중(정보수집 가능)</label>
					      <label for="oa_i03"><input type="radio" id="oa_i03" name="wr_oa[internet]" value="2" <?php echo ($wr_oa['internet']=='2')?'checked':'';?>>하(기본사용)</label>
					    </td>
						</tr>
					</table>
				</div>
			</fieldset>
		</li>
    <li class="row row02">
		  <fieldset>
			  <legend>컴퓨터능력</legend>
				<div class="chk_li list2">
					<?php 
						foreach($indi_oa_list as $val){ 
						$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
						$checked = (@in_array($val['code'],$wr_computer)) ? "checked" : "";
					?>
						<label for="<?php echo $val['code'];?>"><input type="checkbox" class="chk" id="<?php echo $val['code'];?>" name="wr_computer[]" value="<?php echo $val['code'];?>" <?php echo $checked;?> <?php echo ($form_oa['etc_0'])?'required':'';?> hname="컴퓨터능력" option="checkbox">
						<?php echo $name;?></label>
					<?php } ?>
				</div>
			</fieldset>
		</li>
    <li class="row row03">
		  <fieldset>
			  <legend>특기사항</legend>
				<div class="chk_li list3">
					<?php 
						foreach($indi_special_list as $val){ 
						$name = $utility->remove_quoted($val['name']);	 // (쌍)따옴표 등록시 필터링
						$checked = (@in_array($val['code'],$wr_specialty)) ? "checked" : "";
					?><label for="<?php echo $val['code'];?>"><input type="checkbox" class="chk" name="wr_specialty[]" id="<?php echo $val['code'];?>" value="<?php echo $val['code'];?>" <?php echo $checked;?> <?php echo ($form_oa['etc_0'])?'required':'';?> hname="특기사항" option="checkbox"> <?php echo $name;?></label>
					<?php } ?>
					<label for="wr_specialty_etc"><input type="checkbox" class="chk" name="wr_specialty_etc" id="wr_specialty_etc" value="1" onclick="wr_specialty_etc_view(this);" <?php echo ($wr_specialty_etc[0])?'checked':'';?>> 기타</label>
					<span id="wr_specialty_view" style="display:<?php echo ($wr_specialty_etc[1])?'':'none';?>;">
						<input type="text" style="width:150px; padding:0;" name="wr_specialty_etc_val" class="txt" value="<?php echo $wr_specialty_etc[1];?>">
					</span>
				</div>
			</fieldset>
		</li>
    <li class="row row04">
		  <fieldset>
			  <legend>수상수료<br>활동내역</legend>
        <textarea style="border:1px solid #ddd; height:100px; " id="wr_prime" class="txtarea" name="wr_prime" <?php echo ($form_oa['etc_0'])?'required':'';?> hname="수상·수료 활동내역"><?php echo stripslashes($get_resume['wr_prime']);?></textarea>
			</fieldset>
		</li>

	</ul>
	<div class="info3_con">

  </div>
</section>
<?php }?>

<section class="cont_box resume_con">
	<h2>자기소개서</h2>
	<ul class="info3_con">
		<li class="row_con">
			<ul class="resume_chk textarea_put_chk">
			  <legend>자기소개서 선택</legend>
				<li><label for="wr_introduce_all"><input type="checkbox" id="wr_introduce_all" onClick="netfu_mjob.introduce_part_click(this, 'all', 'wr_introduce')" name="wr_introduce_all" value="1">전체선택</label></li>
				<?php
				if(is_array($_cate_['indi_introduce'])) { foreach($_cate_['indi_introduce'] as $k=>$v) {
				?>
				<li><label><input type="checkbox" name="wr_content_check" class="introduce_part_li" name="wr_introduce_check" onClick="netfu_mjob.introduce_part_click(this, '<?=$v['code'];?>', 'wr_introduce')" value="<?=stripslashes($v['name']);?>" id="<?=$v['code'];?>"><?=stripslashes($v['name']);?></label></li>
				<?php
				} }?>
			</ul>
		</li>
		<li class="row_con">
			<textarea type="editor" name="wr_introduce" style="width:100%;height:250px;" hname="자기소개서" required ><?=stripslashes($get_resume['wr_introduce']);?></textarea>
		</li>
	</ul>
</section>


<?php if($add_form_arr['부가정보(결혼,장애여부등)']['view']=='yes'){ ?>
<section class="cont_box resume_con">
	<h2>부가정보<?=$add_form_chk['부가정보(결혼,장애여부등)']['tag'];?></h2>
	<ul class="info3_con">
		<li class="row_con">
			<fieldset>
				<div class="impd cf">
				<legend>장애여부</legend>
				<label for="wr_impediment_use_0"><input type="radio" id="wr_impediment_use_0" name="wr_impediment_use" value="0" checked class="first" <?=$add_form_chk['부가정보(결혼,장애여부등)']['required'];?> hname="장애여부" option="radio" onClick="netfu_util1.open2(this, '1', '._impediment')">비대상</label>
				<label for="wr_impediment_use_1"><input type="radio" id="wr_impediment_use_1" name="wr_impediment_use" value="1" <?php echo ($get_resume['wr_impediment_use']) ? 'checked' : '';?> <?=$add_form_chk['부가정보(결혼,장애여부등)']['required'];?> hname="장애여부" option="radio" onClick="netfu_util1.open2(this, '1', '._impediment')">대상</label>
				</div>
				<div class="impd_block cf _impediment" style="display:<?php echo (!$get_resume['wr_impediment_use']) ? 'none' : 'block';?>;">
					<label for="impd_lv">장애등급</label>
					<select id="impd_lv" name="wr_impediment_level">
						<option value="">장애등급 선택</option>
						<?php
						if(is_array($_cate_['impediment'])) { foreach($_cate_['impediment'] as $k=>$v) {
							$selected = $get_resume['wr_impediment_level']==$v['code'] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php
						} }
						?>
					</select>  
					<label for="impd_name">장애분류</label>
					<input type="text" id="impd_name" name="wr_impediment_name" value="<?php echo stripslashes($get_resume['wr_impediment_name']);?>">
				</div>
			</fieldset>
		</li>
		<li class="row_con">
			<fieldset>
				<legend>결혼여부</legend>
				<label for="wr_marriage_0"><input type="radio" id="wr_marriage_0" name="wr_marriage" value="0" checked class="first" <?=$add_form_chk['부가정보(결혼,장애여부등)']['required'];?> hname="결혼여부" option="radio">미혼</label>
				<label for="wr_marriage_1"><input type="radio" id="wr_marriage_1" name="wr_marriage" value="1" <?=$add_form_chk['부가정보(결혼,장애여부등)']['required'];?> <?php echo ($get_resume['wr_marriage']) ? 'checked' : '';?> hname="결혼여부" option="radio">결혼</label>
			</fieldset>
		</li>
		<li class="row_con">
			<fieldset>
				<legend>병역여부</legend>
				<div class="milt cf">
				<label for="wr_military_0"><input type="radio" id="wr_military_0" name="wr_military" value="0" checked="checked" class="first" <?=$add_form_chk['부가정보(결혼,장애여부등)']['required'];?> hname="병역여부" option="radio" onClick="netfu_util1.open2(this, '1', '._military')">미필</label>
				<label for="wr_military_1"><input type="radio" id="wr_military_1" name="wr_military" value="1" <?php echo ($get_resume['wr_military']=='1') ? 'checked' : '';?> <?=$add_form_chk['부가정보(결혼,장애여부등)']['required'];?> hname="병역여부" option="radio" onClick="netfu_util1.open2(this, '1', '._military')">군필</label>
				<label for="wr_military_2"><input type="radio" id="wr_military_2" name="wr_military" value="2" <?php echo ($get_resume['wr_military']=='2') ? 'checked' : '';?> <?=$add_form_chk['부가정보(결혼,장애여부등)']['required'];?> hname="병역여부" option="radio" onClick="netfu_util1.open2(this, '1', '._military')">면제</label>
				</div>
				<div class="milt_block cf _military" style="display:<?php echo ($get_resume['wr_military']!='1') ? 'none' : 'block';?>;">
					<label for="milt_type">병역내용(군)</label>
					<input type="text" id="" name="wr_military_type" value="<?php echo stripslashes($get_resume['wr_military_type']);?>">
				</div>
			</fieldset>
		</li>
		<?php
		if($add_form_arr['채용우대']['view']=='yes') {
		?>
		<li class="row_con spt">
			<fieldset>
				<legend>우대<?=$add_form_chk['채용우대']['tag'];?></legend>
				<ul class="spt_con">
					<li><label for="wr_preferential_use_1"><input type="checkbox" id="wr_preferential_use_1" name="wr_preferential_use" value="1" <?php echo ($get_resume['wr_preferential_use']) ? 'checked' : '';?> <?=$add_form_chk['채용우대']['required'];?> hname="채용우대" option="checkbox">국가보훈 대상자</label></li>
					<li>
						<input type="checkbox" id="wr_treatment_use_1" name="wr_treatment_use" value="1" <?php echo ($get_resume['wr_treatment_use']) ? 'checked' : '';?> <?=$add_form_chk['채용우대']['required'];?> hname="채용우대" option="checkbox">고용지원금 대상자
						<ul class="checkbox_gp cf">
							<?php
							if(is_array($_cate_['indi_treatment'])) { foreach($_cate_['indi_treatment'] as $k=>$v) {
								$checked = @in_array($v['code'], $wr_treatment_service) ? 'checked' : '';
							?>
							<li><input type="checkbox" id="" name="wr_treatment_service[]" value="<?=$v['code'];?>" <?=$checked;?>><?=stripslashes($v['name']);?></li>
							<?php
							} }?>
						</ul>
					</li>
				</ul>
			</fieldset>
		</li>
		<?php }?>
	</ul>
</section>
<?php } ?>

<section class="cont_box resume_con">
  <h2>이력서설정</h2>
	  <ul class="info3_con">
			<li class="set1">
			  <fieldset>
					<legend>공개여부</legend>
					<label for="wr_open_1"><input type="radio" id="wr_open_1" name="wr_open" value="1" checked class="first">공개</label>
					<label for="wr_open_2"><input type="radio" id="wr_open_2" name="wr_open" value="0" <?php echo ($mode=='update' && !$get_resume['wr_open']) ? 'checked':'';?>>비공개</label>
				</fieldset>
			</li>
			<li class="set3">
			  <fieldset>
					<legend>통화가능시간</legend>
					<select name="wr_calltime[]">
					<option value="">선택</option>
					<?php
					for($i=0;$i<=23;$i++) {
					?>
					<option value="<?php echo sprintf('%02d', $i);?>" <?php echo ($wr_calltime[0]==$i) ? 'selected' : '';?>><?php echo sprintf('%02d',$i);?>시</option>
					<?php } ?>
					</select>
					<select name="wr_calltime[]">
					<option value="">선택</option>
					<?php for($i=0;$i<=23;$i++){ ?>
					<option value="<?php echo sprintf('%02d', $i);?>" <?php echo ($wr_calltime[1]==$i) ? 'selected' : '';?>><?php echo sprintf('%02d',$i);?>시</option>
					<?php } ?>
					</select>
					<label for="wr_calltime_always_1"><input type="checkbox" id="wr_calltime_always_1" name="wr_calltime_always" value="1" <?php echo ($get_resume['wr_calltime_always']) ? 'checked' : '';?>>언제나 가능</label>
				</fieldset>
			</li>
			<li class="set2">
			  <label for="kakao">카카오톡ID</label>
				<input type="text" id="kakao" name="kakao_id" value="<?=$get_resume['kakao_id'];?>">
			</li>
</ul>
</section>

<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="netfu_mjob.resume_submit()"><?php echo $resume_no ? '이력서수정' : '이력서작성';?></a><a href="javascript:history.go(-1);" class="bottom_btn02" onClick="javascript:reset();">취소</a>
</div>
</form>
<?php
include "../include/tail.php";
?>