<?php
$editor_use = true;
$page_code = 'mypage';
$member_type = 'company';
$head_title = "구인정보등록";
include "../include/top.php";
include_once NFE_PATH."/engine/netfu_map.class.php";
$netfu_map = new netfu_map();

echo $netfu_map->js_script;


$category_list = $category_control->category_codeList('alba_form', " `rank` asc ");

// : 사용여부 체크를 위한 정보
$add_form_arr = array();
$add_form_chk = array();
if(is_array($category_list)) { foreach($category_list as $k=>$v) {
	$add_form_arr[$v['name']] = $v;
	$add_form_chk[$v['name']]['tag'] = $v['etc_0']==1 ? '<span class="check"></span>' : '';
	$add_form_chk[$v['name']]['required'] = $v['etc_0']==1 ? 'required' : '';
} }

// : 카테고리 모음
$_cate1_array = array('job_type', 'area', 'subway', 'alba_date', 'alba_week', 'alba_pay', 'alba_pay_type', 'job_welfare', 'job_age', 'job_ability', 'job_career', 'preferential', 'job_target', 'pt_paper', 'alba_content');
if(is_array($_cate1_array)) { foreach($_cate1_array as $k=>$v) {
	$_cate_[$v] = $netfu_util->get_cate_array($v, array('where'=>" and `p_code` = ''"));
} }


// : 기업리스트
$load_com = sql_query("select * from `alice_member_company` where `mb_id` = '".$member['mb_id']."' order by `no` desc");

// : 과거 등록한 채용정보
$load_query = sql_query("select * from alice_alba where `wr_id`='".$member['mb_id']."' order by `no` desc");

// : 담당자 리스트
$manage_query = sql_query("select * from `alice_company_manager` where `wr_id` = '".$member['mb_id']."' order by `no` desc");
$manage_query_len = sql_num_rows($manage_query);


$_no = $_GET['no'];
if($_GET['load_no']) $_no = $_GET['load_no'];
$job_row = sql_fetch("select * from alice_alba where `no`='".addslashes($_no)."' and `wr_id`='".$member['mb_id']."'");


$_phone = explode("-", $job_row['wr_phone']);
$_hphone = explode("-", $job_row['wr_hphone']);
$_fax = explode("-", $job_row['wr_fax']);
$_email = explode("@", $job_row['wr_email']);
$_wr_stime = explode(':', $job_row['wr_stime']);
$_wr_etime = explode(':', $job_row['wr_etime']);
$_wr_age_etc = explode(",", $job_row['wr_age_etc']);
$_wr_age_arr = explode("-", $job_row['wr_age']);
$_wr_preferential = explode(',', $job_row['wr_preferential']);
$_wr_requisition = explode(',', $job_row['wr_requisition']);
$_wr_area_point = explode(",", $job_row['wr_area_point']);
$_wr_pay_support = explode(',', $job_row['wr_pay_support']);
$_wr_work_type = explode(",", $job_row['wr_work_type']);	// 근무형태
$_wr_welfare = unserialize(stripslashes($job_row['wr_welfare']));
$_wr_volumes = explode(',', $job_row['wr_volumes']);
$_wr_target = explode(',', $job_row['wr_target']);
$_wr_papers = explode(',', $job_row['wr_papers']);

$tel_num_option = $config->get_tel_num($_phone[0]);	 // 전화번호 국번
$hp_num_option = $config->get_hp_num($_hphone[0]);	 // 휴대폰번호 국번
$fax_num_option = $config->get_tel_num($_fax[0]);	 // 팩스 국번
$email_option = $config->get_email();	 // 이메일 서비스 제공자

// : 지역값
$job_area = array();
$job_area[] = explode("/", $job_row['wr_area_0']);
if($job_row['wr_area_1']) $job_area[] = explode("/", $job_row['wr_area_1']);
if($job_row['wr_area_2']) $job_area[] = explode("/", $job_row['wr_area_2']);

// : 직종값
$job_job_type = array();
$job_job_type[] = array($job_row['wr_job_type0'], $job_row['wr_job_type1'], $job_row['wr_job_type2']);
if($job_row['wr_job_type3']) $job_job_type[] = array($job_row['wr_job_type3'], $job_row['wr_job_type4'], $job_row['wr_job_type5']);
if($job_row['wr_job_type6']) $job_job_type[] = array($job_row['wr_job_type6'], $job_row['wr_job_type7'], $job_row['wr_job_type8']);

// : 지하철
$job_subway = array();
$job_subway[] = array($job_row['wr_subway_area_0'], $job_row['wr_subway_line_0'], $job_row['wr_subway_station_0'], $job_row['wr_subway_content_0']);
if($job_row['wr_subway_area_1']) $job_subway[] = array($job_row['wr_subway_area_1'], $job_row['wr_subway_line_1'], $job_row['wr_subway_station_1'], $job_row['wr_subway_content_1']);
if($job_row['wr_subway_area_2']) $job_subway[] = array($job_row['wr_subway_area_2'], $job_row['wr_subway_line_2'], $job_row['wr_subway_station_2'], $job_row['wr_subway_content_2']);




// : 지도관련
$use_map = $env['use_map'];	// 사용 지도 api
$daum_local_key = $env['daum_map_key'];	// 다음 지도 local 검색 key
$naver_map_key = $env['naver_map_key'];	// 네이버 지도 key
?>
<style type="text/css">
.wr_requisition_input { display:none; }
.age_int__ { display:none; }
</style>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/mjob.class.js?time=<?=time();?>"></script>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/map/<?=$use_map;?>.js?time=<?=time();?>"></script>
<script type="text/javascript">

var time_conference = function(el) {
	var obj = $(el).closest(".select_inner").find("select");
	$(el).closest(".select_inner").find("select").prop("required", true);
	if(el.checked===true) {
		$(el).closest(".select_inner").find("select").removeAttr("required");
		obj.val('');
		obj.attr({"disabled":"disabled"});
	}
	else obj.removeAttr("disabled");
}

var pay_type_select = function(el) {
	if(el.value) {
		$("[name='wr_pay_conference']").prop("checked", false);
		$("[name='wr_pay_conference']").prop("required", false);
		$("[name='wr_pay']").prop("disabled", false);
		$("[name='wr_pay']").prop("required", true);
	}
}

var pay_conference = function(el) {
	var _len = $("[name='wr_pay_conference']:checked").length;
	if(_len>0) {
		$("[name='wr_pay_type']").prop("required", false);
		$("[name='wr_pay_type']").find("option:eq(0)").prop("selected", true);
		$("[name='wr_pay']").prop("required", false);
		$("[name='wr_pay']").prop("disabled", true);
		$("[name='wr_pay']").val('');
	}
}

var career_sel = function() {
	var val = $("[name='wr_career_type']:checked").val();
	switch(val) {
		case '2':
			$("[name='wr_career']").removeAttr("disabled");
			break;

		default:
			$("[name='wr_career']").attr({"disabled":"disabled"});
			break;
	}
}


var wr_volume_click = function() {

	var val = $("[name='volume_check']:checked").val();
	switch(val) {
		case 'wr_volume_dates':
			$("[name='wr_volume_date']").datepicker('option', 'disabled', false);
			break;

		default:
			$("[name='wr_volume_date']").datepicker('option', 'disabled', true);
			$("[name='wr_volume_date']").val('');
			break;
	}
}


var volume_click = function(el) {
	if(el) {
		netfu_util1.checkbox_one(el);
	}
	var obj = $("[name='wr_volumes[]']:checked");
	var _input = $("[name='wr_volume']");
	if(obj.length>0) {
		_input.attr({"disabled":true, "readonly":true});
		_input.removeAttr("required");
	} else {
		_input.removeAttr("disabled");
		_input.removeAttr("readonly");
		_input.attr("required", true);
	}
}


var submit_func = function() {
	var form = document.forms['fwrite'];
	var allow = true;
	if(validate(form)) {
		 form.submit();
	}
}


$(window).ready(function(){
	$("[name='volume_check']").click(function(){
		$("[name='wr_volume_date']").removeAttr("required");
		if($(this).val()=='wr_volume_dates') $("[name='wr_volume_date']").attr("required", true);
	});
});
</script>
<section class="cont_box detail_con">
	<div class="company_info_box">
	<?php
	$wr_company = $job_row['wr_company'];
	include NFE_PATH.'/include/inc/my_company_info.inc.php';
	?>
	</div>
	<?php
	include NFE_PATH.'/include/inc/my_company_count.inc.php';
	?>
</section>

<form name="fwrite" action="../regist.php" method="post">
<input type="hidden" name="mode" value="job_write" />
<input type="hidden" name="no" value="<?=$_GET['no'];?>" />
<input type="hidden" name="mode_2" value="<?=$_GET['mode'];?>" />

<?php
$_len = sql_num_rows($load_com);
?>
<section class="cont_box resume_con" style="display:<?=$_len>1 ? 'block' : 'none';?>">
	<h2>기업정보 선택</h2>
	<ul class="info3_con">
		<li class="row1">
			<p>구인공고를 작성하실때 추가 등록된 기업정보의 내용을 불러와서 사용하실 수 있습니다.</p>
			<select name="company_list" class="resume_st1" id="resume_st1" onChange="netfu_mjob.company_list_sel(this)">
			<option value="">기업선택</option>
			<?php
			$c_no = $company_member['no'];
			if($job_row['wr_company']) $c_no = $job_row['wr_company'];
			$load_com_arr = array();
			while($row=sql_fetch_array($load_com)) {
				$load_com_arr = $row;
				$selected = $c_no==$row['no'] ? 'selected' : '';
			?>
			<option value="<?=$row['no'];?>" <?=$selected;?>><?=$row['mb_ceo_name'];?> / <?=$row['mb_company_name'];?></option>
			<?php
			}
			?>
			</select>
		</li>
	</ul>
</section>
<?php

if($_len==1 && !$job_row) {
	$job_row['wr_company_name'] = $load_com_arr['mb_company_name'];
	$job_row['wr_person'] = $load_com_arr['mb_ceo_name'];
	$_phone = explode("-", $load_com_arr['mb_biz_phone']);
	$_hphone = explode("-", $load_com_arr['mb_biz_hphone']);
	$_fax = explode("-", $load_com_arr['mb_biz_fax']);
	$_email = explode("@", $load_com_arr['mb_biz_email']);
	$job_row['wr_page'] = $load_com_arr['mb_homepage'];
	$tel_num_option = $config->get_tel_num($_phone[0]);	 // 전화번호 국번
	$hp_num_option = $config->get_hp_num($_hphone[0]);	 // 휴대폰번호 국번
	$fax_num_option = $config->get_tel_num($_fax[0]);	 // 팩스 국번
}



$_len = sql_num_rows($load_query);
if($_len>0) {
?>
<section class="cont_box resume_con">
	<h2>과거 구인공고 불러오기</h2>
	<ul class="info3_con">
		<li class="row1">
			<p>구인공고를 작성하실때 과거 구인공고의 저장된 내용을 불러와서 사용하실 수 있습니다.</p>
			<select class="resume_st1" id="resume_st1" onchange="netfu_mjob.info_load(this);">
			<option>과거구인공고 불러오기</option>
			<?php
			while($row=sql_fetch_array($load_query)) {
				$selected = $row['no']==$_GET['load_no'] ? 'selected' : '';
			?>
			<option value="<?=$row['no'];?>" <?=$selected;?>><?=stripslashes($row['wr_subject']);?></option>
			<?php
			}
			?>
			</select>
		</li>
	</ul>
</section>
<?php }?>

<section class="cont_box job_con">
	<h2>담당자정보</h2>
	<ul class="info_con">
		<?php
		if($manage_query_len>0) {
		?>
		<li class="row1">
			<label for="manager">담당자선택</label>
			<select name="manager_sel" onChange="netfu_mjob.manager_sel(this)">
			<option value="">담당자선택</option>
			<?php
			while($row=sql_fetch_array($manage_query)) {
			?>
			<option value="<?=$row['no'];?>"><?=$row['wr_name'];?></option>
			<?php }?>
			</select>
		</li>
		<?php }?>
		<li class="row2">
			<label for="manager_name">담당자명<span class="check"></span></label>
			<input type="text" id="manager_name" name="wr_person" value="<?=$job_row['wr_person'];?>" hname="담당자명" requied>
		</li>
		<?php
		if($add_form_arr['전화번호']['view']=='yes'){ ?>
		<li class="row4">
			<fieldset>
			<legend>전화번호<?=$add_form_chk['전화번호']['tag'];?></legend>
				<select name="wr_phone[]" hname="전화번호" <?=$add_form_chk['전화번호']['required'];?>>
				<?php echo $tel_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_phone[]" hname="전화번호" <?=$add_form_chk['전화번호']['required'];?> value="<?=$_phone[1];?>" class="tel1 phone2">
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_phone[]" hname="전화번호" <?=$add_form_chk['전화번호']['required'];?> value="<?=$_phone[2];?>" class="tel2 ">
			</fieldset>
		</li>
		<?php }?>
		<?php if($add_form_arr['휴대폰']['view']=='yes'){ ?>
		<li class="row4">
			<fieldset>
			<legend>휴대폰<?=$add_form_chk['휴대폰']['tag'];?></legend>
				<select name="wr_hphone[]" hname="휴대폰" <?=$add_form_chk['휴대폰']['required'];?>>
				<?php echo $hp_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" hname="휴대폰" <?=$add_form_chk['휴대폰']['required'];?> value="<?=$_hphone[1];?>" class="tel1 phone2">
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_hphone[]" hname="휴대폰" <?=$add_form_chk['휴대폰']['required'];?> value="<?=$_hphone[2];?>" class="tel2 ">
			</fieldset>
		</li>
		<?php } ?>
		<?php if($add_form_arr['팩스번호']['view']=='yes'){ ?>
		<li class="row5">
			<fieldset>
			<legend>팩스번호<?=$add_form_chk['팩스번호']['tag'];?></legend>
				<select name="wr_fax[]" <?=$add_form_chk['팩스번호']['required'];?>>
				<?php echo $fax_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_fax[]" value="<?=$_fax[1];?>" <?=$add_form_chk['팩스번호']['required'];?> class="fax1 phone2">
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_fax[]" value="<?=$_fax[2];?>" <?=$add_form_chk['팩스번호']['required'];?> class="fax2 ">
			</fieldset>
		</li>
		<?php } ?>
		<?php if($add_form_arr['이메일']['view']=='yes'){ ?>
		<li class="row6">
			<fieldset>
			<legend>이메일<?=$add_form_chk['이메일']['tag'];?></legend>
				<input type="tel" name="wr_email[]" value="<?=$_email[0];?>" hname="이메일" <?=$add_form_chk['이메일']['required'];?> class="email">
				<p>@</p><input type="tel" name="wr_email[]" value="<?=$_email[1];?>" hname="이메일" <?=$add_form_chk['이메일']['required'];?> class="email">
				<select onChange="netfu_util1.email_put(this)">
				<option value="">직접입력</option>
				<?php echo $email_option; ?>
				</select>
			</fieldset>
		</li>
		<?php } ?>
		<?php if($add_form_arr['홈페이지(블로그)']['view']=='yes'){ ?>
		<li class="row7">
			<label for="homepage">홈페이지<?=$add_form_chk['홈페이지(블로그)']['tag'];?></label>
			<span>http://</span><input type="text" name="wr_page" <?=$add_form_chk['홈페이지(블로그)']['required'];?> hname="홈페이지" value="<?php echo ($job_row['wr_page']) ? $job_row['wr_page'] : $company_member['mb_homepage'];?>">
		</li>
		<?php } ?>
		<li class="row8">
		  <label for="kakao">카카오톡ID</label>
			<input type="text" id="kakao" name="kakao_id" value="<?=$job_row['kakao_id'];?>">
		</li>
	</ul>
</section>


<section class="cont_box job_con2">
	<h2>업무내용 및 근무지정보</h2>
	<ul class="info_con">
		<li class="row1">
			<label for="co_name">회사명<span class="check"></span></label>
			<input type="text" id="co_name" name="wr_company_name" value="<?=$job_row['wr_company_name'];?>" hname="회사명" required>
		</li>
		<li class="row2">
			<label for="title">구인제목<span class="check"></span></label>
			<input type="text" id="title" name="wr_subject" value="<?=$job_row['wr_subject'];?>" hname="구인제목" required>
		</li>
		<li class="row3">
			<fieldset>
				<legend>업직종<span class="check"></span></legend>
				<div class="select_job_type_put">
				<?php
				for($i=0; $i<count($job_job_type); $i++) {
					$_name1 = $i*3;

					if($job_job_type[$i][0]) $job_type1_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$job_job_type[$i][0]."'"));

					if($job_job_type[$i][1]) $job_type2_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$job_job_type[$i][1]."'"));
				?>
				<div class="select_job_type select_gp cf">
					<div class="select_inner cf">
						<select name="wr_job_type<?=$_name1;?>" sel="1" type="job_type" val="<?=$job_job_type[$i][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 1)" put="wr_job_type<?=$_name1+1;?>_id" auto_none hname="직종1차" required>
						<option value="">직종1차</option>
						<?php
						if(is_array($_cate_['job_type'])) { foreach($_cate_['job_type'] as $k=>$v) {
							$selected = $job_job_type[$i][0]==$v['code'] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php
						} }
						?>
						</select>
						<select name="wr_job_type<?=$_name1+1;?>" type="job_type" id="wr_job_type<?=$_name1+1;?>_id" put="wr_job_type<?=$_name1+2;?>_id" sel="2" type="job_type" val="<?=$job_job_type[$i][2];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)" auto_none hname="2차직종선택" required>
						<option value="">2차직종선택</option>
						<?php
						if(is_array($job_type1_arr)) { foreach($job_type1_arr as $k=>$v) {
							$selected = $job_job_type[$i][1]==$v['code'] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php } }?>
						</select>
						<select name="wr_job_type<?=$_name1+2;?>" id="wr_job_type<?=$_name1+2;?>_id" hname="3차직종선택" >
						<option value="">3차직종선택</option>
						<?php
						if(is_array($job_type2_arr)) { foreach($job_type2_arr as $k=>$v) {
							$selected = $job_job_type[$i][2]==$v['code'] ? 'selected' : '';
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
				<legend>근무지<span class="check"></span></legend>
				<div class="select_area_put">
				<?php
				for($i=0; $i<count($job_area); $i++) {
					$_name1 = $i;
					$_name2 = $i*3;
					// : 2차카테고리값은 util1.class.js의 auto_select_selected함수에서 자동으로 보여줍니다.

					if($job_area[$i][0]) $area1_arr = $netfu_util->get_cate_array('area', array('where'=>" and `p_code` = '".$job_area[$i][0]."'"));

					if($job_area[$i][1]) $area2_arr = $netfu_util->get_cate_array('area', array('where'=>" and `p_code` = '".$job_area[$i][1]."'"));
				?>
				<div class="select_area select_gp cf" type="[]">
					<div class="select_inner cf">
						<select name="wr_area_<?=$_name1;?>[]" sel="1" type="area" val="<?=$job_area[$i][1];?>" put="wr_area<?=$_name2+1;?>_id" onChange="netfu_util1.ajax_cate(this, 'area', 1)" auto_none hname="시·도" required>
						<option value="">시·도</option>
						<?php
						if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
							$selected = $v['code']==$job_area[$i][0] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php
						} }
						?>
						</select>
						<select name="wr_area_<?=$_name1;?>[]" id="wr_area<?=$_name2+1;?>_id" put="wr_area<?=$_name2+2;?>_id" sel="2" type="area" val="<?=$job_area[$i][2];?>" onChange="netfu_util1.ajax_cate(this, 'area', 2)" auto_none hname="시·군·구" required>
						<option value="">시·군·구</option>
						<?php
						if(is_array($area1_arr)) { foreach($area1_arr as $k=>$v) {
							$selected = $job_area[$i][1]==$v['code'] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php } }?>
						</select>
						<select name="wr_area_<?=$_name1;?>[]" id="wr_area<?=$_name2+2;?>_id" hname="읍·면·동" >
						<option value="">읍·면·동</option>
						<?php
						if(is_array($area2_arr)) { foreach($area2_arr as $k=>$v) {
							$selected = $job_area[$i][2]==$v['code'] ? 'selected' : '';
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php } }?>
						</select>
						<div class="num_box cf">
							<label for="number">번지입력 : </label><input type="text" name="wr_area_<?=$_name1;?>[]" value="<?=$job_area[$i][3];?>" id="number">
						</div>
						<button type="button" class="plus_bt1 _add_button" onClick="netfu_mjob.area_add(this, '<?=$i==0 ? 'add' : 'del';?>')"><?=$i==0 ? '추가' : '삭제';?> +</button>
					</div>
				</div>
				<?php }?>
				</div>
			</fieldset>
		</li>
		<li class="row5">
			<div class="map_con cf">
				<fieldset>
					<legend>근무지위치</legend>	
					<input type="radio" id="site" name="wr_area_company" value="0" checked><span>직접입력</span>
					<input type="radio" id="site" name="wr_area_company" value="1" <?php echo ($job_row['wr_area_company']) ? 'checked' : '';?>><span>기업정보 위치와 동일</span>
					<div class="addr_sch cf">
						<input type="text" name="wr_area" value="<?=$job_row['wr_area'];?>" onClick="post_click(this)"><button type="button" class="plus_bt" onClick="post_click(document.forms['fwrite'].wr_area); return false;">주소검색</button>
					</div>
					<div class="map_area cf">
						<?php
						$map_use = true;
						include NFE_PATH.'/include/inc/post.inc.php';
						?>
						<script type="text/javascript">
						var form = document.forms['fwrite'];
						</script>
						<script type="text/javascript">
						daum_map.map_basic('address_map');
						daum_map.map_click(form);
						</script>
						<input type="hidden" name="map_latlng[]" value="<?=$_wr_area_point[0];?>" />
						<input type="hidden" name="map_latlng[]" value="<?=$_wr_area_point[1];?>" />
						<?
						/*
						<div class="map_area_inner">
						</div>
						*/?>
					</div>
				</fieldset>
			</div>
		</li>
		<?php if($add_form_arr['인근지하철']['view']=='yes'){ ?>
		<li class="row6">
			<fieldset>
				<legend>인근지하철<?=$add_form_chk['인근지하철']['tag'];?></legend>
				<div class="select_subway_put">
				<?php
				$_len = count($job_subway);
				for($i=0; $i<$_len; $i++) {
					$_name = $i;

					$_subway2 = $netfu_util->get_cate_array('subway', array('where'=>" and `p_code` = '".$job_subway[$i][0]."'"));
					$_subway3 = $netfu_util->get_cate_array('subway', array('where'=>" and `p_code` = '".$job_subway[$i][1]."'"));
				?>
				<div class="select_subway select_gp cf">
					<div class="select_inner">
						<select name="wr_subway_area_<?=$_name;?>" id="wr_subway_area_<?=$_name;?>" put="wr_subway_line_<?=$_name;?>" onChange="netfu_util1.ajax_cate(this, 'subway', 1)" auto_none <?=$add_form_chk['인근지하철']['required'];?>>
							<option value="">지역</option>
							<?php
							if(is_array($_cate_['subway'])) { foreach($_cate_['subway'] as $k=>$v) {
								$selected = $job_subway[$i][0]==$v['code'] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=stripslashes($v['name']);?></option>
							<?php
							} }
							?>
						</select>
						<select name="wr_subway_line_<?=$_name;?>" id="wr_subway_line_<?=$_name;?>" put="wr_subway_station_<?=$_name;?>" onChange="netfu_util1.ajax_cate(this, 'subway', 2)" auto_none <?=$add_form_chk['인근지하철']['required'];?>>
							<option value="">호선</option>
							<?php
							if(is_array($_subway2)) { foreach($_subway2 as $k=>$v) {
								$selected = $job_subway[$i][1]==$v['code'] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=stripslashes($v['name']);?></option>
							<?php
							} }
							?>
						</select>
						<select name="wr_subway_station_<?=$_name;?>" id="wr_subway_station_<?=$_name;?>" onChange="netfu_util1.ajax_cate(this, 'subway', 2)" auto_none <?=$add_form_chk['인근지하철']['required'];?>>
							<option value="">지하철역<option>
							<?php
							if(is_array($_subway3)) { foreach($_subway3 as $k=>$v) {
								$selected = $job_subway[$i][2]==$v['code'] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=stripslashes($v['name']);?></option>
							<?php
							} }
							?>
						</select>
						<div class="num_box cf">
							<label for="exit">출구,소요시간 </label><input type="text" name="wr_subway_content_<?=$_name;?>" id="exit" placeholder="출구,소요시간" value="<?=$job_subway[$i][3];?>">
						</div>
						<button type="button" class="plus_bt1 plus_bt2" onClick="netfu_mjob.subway_add(this, '<?=$i==0 ? 'add' : 'del';?>')"><?=$i==0 ? '추가' : '삭제';?> +</button>
					</div>
				</div>
				<?php }?>
				</div>
			</fieldset>
		</li>
		<?php }?>
		<?php if($add_form_arr['인근대학']['view']=='yes'){ ?>
		<li class="row7">
			<fieldset>
				<legend>인근대학<?=$add_form_chk['인근대학']['tag'];?></legend>
				<div class="select_gp cf">
					<div class="select_inner">
						<select class="region1" name="wr_college_area" <?=$add_form_chk['인근대학']['required'];?> put="wr_college_vicinity" onChange="netfu_util1.ajax_cate(this, 'job_college', 1)" auto_none>
							<option value="">지역</option>
							<?php
							if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
								$selected = $v['code']==$job_row['wr_college_area'] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php
							} }
							?>
						</select>
						<select class="univ" name="wr_college_vicinity" <?=$add_form_chk['인근대학']['required'];?> id="wr_college_vicinity">
							<option value="">인근대학 선택</option>
							<?php
							if($job_row['wr_college_vicinity']){
								$_cate_['job_college'] = $netfu_util->get_cate_array('job_college', array('where'=>" and `p_code` = '".$job_row['wr_college_area']."'"));
								if(is_array($_cate_['job_college'])) { foreach($_cate_['job_college'] as $k=>$v) {
									$selected = ($job_row['wr_college_vicinity'] == $v['code']) ? "selected" : "";
							?>
									<option value="<?php echo $v['code'];?>" <?php echo $selected;?>><?php echo $v['name'];?></option>
							<?php 
								} }	// foreach end.
							}	// if end.
							?>
						</select>
					</div>
			</fieldset>
		</li>
		<?php } ?>
	</ul>
</section>

<section class="cont_box job_con3">
	<h2>근무조건</h2>
	<ul class="info_con3">
	<li class="row1">
		<fieldset>
			<legend>근무기간<span class="check"></span></legend>
			<div class="select_gp">
				<ul class="select_inner">
					<?php
					if(is_array($_cate_['alba_date'])) { foreach($_cate_['alba_date'] as $k=>$v) {
						$checked = ($job_row['wr_date'] == $v['code']) ? "checked" : "";
					?>
					<li><input type="radio" name="wr_date" value="<?=$v['code'];?>" hname="근무기간" <?=$checked;?> required><?=$v['name'];?></li>
					<?php
					} }
					?>
				</ul>
			</div>
		</li>
		<li class="row2">
			<label for="week">근무요일<span class="check"></span></label>
			<div class="select_gp">
				<ul class="select_inner">
					<?php
					if(is_array($_cate_['alba_week'])) { foreach($_cate_['alba_week'] as $k=>$v) {
						$checked = ($job_row['wr_week'] == $v['code']) ? "checked" : "";
					?>
					<li><input type="radio" name="wr_week" value="<?=$v['code'];?>" hname="근무요일" required <?=$checked?>><?=$v['name'];?></li>
					<?php
					} }
					?>
				</ul>
			</div>
		</fieldset>
	</li>
	<li class="row3">
		<fieldset>
			<legend>근무시간<span class="check"></span></legend>	
			<div class="select_gp">
				<ul class="select_inner">
					<div class="cf">
						<select name="wr_stime[]" <?php echo ($job_row['wr_time_conference'])?'':'required';?> hname="근무시간" option="select" <?php echo ($job_row['wr_time_conference'])?'disabled':'';?>>
							<option value="">선택</option>
							<?php
							for($i=0;$i<=23;$i++){
							?>
							<option value="<?php echo sprintf('%02d', $i);?>" <?php echo ($_wr_stime[0]&&$_wr_stime[0]==$i) ? 'selected' : '';?>><?php echo sprintf('%02d', $i);?>시</option>
							<?php } ?>
						</select>
						<select name="wr_stime[]" <?php echo ($job_row['wr_time_conference'])?'':'required';?> hname="근무시간" option="select" <?php echo ($job_row['wr_time_conference'])?'disabled':'';?>>
							<option value="">선택</option>
							<?php for($i=0;$i<=5;$i++){?>
							<option value="<?php echo $i;?>0" <?php echo ($_wr_stime[1]==$i.'0') ? 'selected' : '';?>><?php echo $i;?>0분</option>
							<?php } ?>
						</select>
					</div>
					<span>~</span>
					<div class="cf">
						<select name="wr_etime[]" <?php echo ($job_row['wr_time_conference'])?'':'required';?> hname="근무시간" option="select" <?php echo ($job_row['wr_time_conference'])?'disabled':'';?>>
							<option value="">선택</option>
							<?php for($i=0;$i<=23;$i++){ ?>
							<option value="<?php echo sprintf('%02d', $i);?>" <?php echo ($_wr_etime[0] && $_wr_etime[0]==$i) ? 'selected' : '';?>><?php echo sprintf('%02d', $i);?>시</option>
							<?php } ?>
						</select>
						<select name="wr_etime[]" <?php echo ($job_row['wr_time_conference'])?'':'required';?> hname="근무시간" option="select" <?php echo ($job_row['wr_time_conference'])?'disabled':'';?>>
							<option value="">선택</option>
							<?php for($i=0;$i<=5;$i++){?>
							<option value="<?php echo $i;?>0" <?php echo ($_wr_etime[1]==$i.'0') ? 'selected' : '';?>><?php echo $i;?>0분</option>
							<?php } ?>
						</select>
					</div>
					<div class="check_box1 cf">
						<input type="checkbox" name="wr_time_conference" id="wr_time_conference1" value="1" onClick="time_conference(this)" <?=$job_row['wr_time_conference'] ? 'checked' : '';?>><label for="wr_time_conference">시간협의</label>
					</div>
				</ul>
			</div>
		</fieldset>
	</li>
	<li class="row4">
		<fieldset>
			<legend>급여<span class="check"></span></legend>	
			<div class="select_gp cf">
				<div class="select_inner cf">
					<select class="pay_slt" name="wr_pay_type" <?php echo ($job_row['wr_pay_conference']) ? '': 'required';?> hname="급여조건" option="select" onChange="pay_type_select(this)">
						<option value="">급여</option>
						<?php
						if(is_array($_cate_['alba_pay'])) { foreach($_cate_['alba_pay'] as $k=>$v) {
							$selected = ($job_row['wr_pay_type'] == $v['code']) ? "selected" : "";
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php
						} }
						?>
					</select>
					<div class="pay_in"><input type="text" name="wr_pay"  <?php echo ($job_row['wr_pay_conference']) ? 'disabled' : 'required';?> hname="급여금액" value="<?php echo $job_row['wr_pay']>0 ? $job_row['wr_pay'] : '';?>" placeholder="" data-v-min="0" data-v-max="10000000000">원</div>
					<p style="margin-top:5px">(최저임금 : 시급 <span><?php echo number_format($env['time_pay']);?>원</span>)</p>
					<div class="check_box2 cf">
						<ul>
							<?php
							foreach($netfu_mjob->pay_conference_arr as $k=>$v) {
								$checked = ($k==0 || $job_row['wr_pay_conference']==$k) ? 'checked' : '';
							?>
							<li>
								<input type="radio" id="payment<?=$k;?>" name="wr_pay_conference" value="<?=$k;?>" <?=$checked;?> onClick="pay_conference(this)"><label for="payment<?=$k;?>"><?=$v;?></label>
							</li>
							<?php
							}
							?>
						</ul>
						<p>(당사는 본 구인건과 관련하여 '최저임금법'을 준수합니다.)</p>
						<ul>
							<?php
							if(is_array($_cate_['alba_pay_type'])) { foreach($_cate_['alba_pay_type'] as $k=>$v) {
								$checked = (@in_array($v['code'], $_wr_pay_support)) ? "checked" : "";
							?>
							<li>
								<input type="checkbox" id="etc<?=$k?>" name="wr_pay_support[]" value="<?=$v['code'];?>" <?=$checked;?>><label for="etc<?=$k?>"><?=$v['name'];?></label>
							</li>
							<?php
							} }
							?>
						</ul>
					</div>
				</div>
			</div>
		</fieldset>
		<script type="text/javascript">pay_conference();</script>
	</li>
	<li class="row5">
		<fieldset>
			<legend>근무형태<span class="check"></span></legend>
			<div class="select_gp cf">
				<ul class="select_inner cf">
					<?php
					if(is_array($work_type_list)) { foreach($work_type_list as $k=>$v) {
						$checked = (@in_array($v['code'], $_wr_work_type)) ? 'checked' : '';
					?>
					<li><input type="checkbox" name="wr_work_type[]" value="<?=$v['code'];?>" hname="근무형태" required option="checkbox" <?php echo $checked;?>><?=$v['name'];?></li>
					<?php
					} }
					?>
				</ul>
			</div>
		</fieldset>
	</li>
	<?php if($add_form_arr['복리후생']['view']=='yes'){ ?>
	<li class="row6">
		<fieldset>
			<legend>복리후생<?=$add_form_chk['복리후생']['tag'];?></legend>
			<input type="text" name="welfare_read" readonly value="<?php echo $job_row['wr_welfare_read'];?>" <?=$add_form_chk['복리후생']['required'];?> hname="복리후생" onClick="netfu_util1.open('.job_welfare_div')"><button type="button" class="plus_bt" id="show_ly" onClick="netfu_util1.open('.job_welfare_div')">선택</button>

			<!-- 상세보기 레이어 -->
			<div class="detail_ly cf job_welfare_div" id="ly01" style="display:none;">
				<div class="detail_inner">
					<div class="bx-top"><h2>복리후생 선택</h2>
						<div class="btn-r btn-r2"><button id="close_ly" type="button" onClick="netfu_util1.close('.job_welfare_div')">X</button></div>
					</div>
					<ul class="cf">
						<?php
						if(is_array($_cate_['job_welfare'])) { foreach($_cate_['job_welfare'] as $k=>$v) {
							$_cate_2 = $netfu_util->get_cate_array('job_welfare', array('where'=>" and `p_code` = '".$v['code']."'"));
						?>
						<li>
						  <fieldset>
								<legend><?=$v['name'];?></legend>
								<?php
								if(is_array($_cate_2)) { foreach($_cate_2 as $k2=>$v2) {
									$checked = @in_array($v2['code'], $_wr_welfare[$v['code']]) ? 'checked' : '';
								?>
								<span><input type="checkbox" class="wr_welfare_c" name="wr_welfare[<?php echo $v['code'];?>][]" value="<?=$v2['code'];?>" onClick="netfu_util1.put_checkbox_val('.wr_welfare_c', document.forms['fwrite'].welfare_read)" txt="<?=$v2['name'];?>" <?=$checked;?>><?=$v2['name'];?></span>
								<?php
								} }
								?>
							</fieldset>
						</li>
						<?php
						} }
						?>
					</ul>
					<div class="ly_btn_wrap cf">
						<button type="button" class="ly_btn_confirm" onClick="netfu_util1.close('.job_welfare_div')">확인</button>
					</div>
				</div>
			</div>
			<!-- //상세보기 -->
		</fieldset>
	</li>
	<?php } ?>
</ul>
</section>

<section class="cont_box job_con4">
	<h2>지원조건</h2>
	<ul class="info_con3">
		<?php if($add_form_arr['성별']['view']=='yes'){?>
		<li class="row1">
			<label>성별<?=$add_form_chk['성별']['tag'];?></label>
			<ul>
				<li>
					<input type="radio" name="wr_gender" id="all-gender" checked value="0"><label for="all-gender">성별무관</label>
				</li>
				<li>
					<input type="radio" name="wr_gender" id="male" value="1" <?=$add_form_chk['성별']['required'];?> <?php echo ($job_row['wr_gender']=='1') ? 'checked' : '';?>><label for="male">남자</label>
					</li>
				<li>
					<input type="radio" name="wr_gender" id="female" value="2" <?=$add_form_chk['성별']['required'];?> <?php echo ($job_row['wr_gender']=='2') ? 'checked' : '';?>><label for="female">여자</label>
				</li>
			</ul>
		<p>채용에서 남녀를 차별하거나, 여성근로자를 채용할 때 직무수행에 불필요한 용모, 키, 체중 등의 신체조건, 미혼조건을 제시 또는 요구하는 경우 남녀고용평등법 위반 에 따른 500만원이하의 벌금이 부과될 수 있습니다.</p>
		</li>
		<?php }?>
		<?php if($add_form_arr['연령']['view']=='yes'){?>
		<li class="row2">
			<label>연령<?=$add_form_chk['연령']['tag'];?></label>
			<ul>
				<li style="width:50%">
					<input type="radio" name="wr_age_limit" id="wr_age_limit_0" checked value="0" <?=$add_form_chk['연령']['required'];?> hname="연령" option="radio" checked><label for="wr_age_limit_0">연령무관</label>
				</li>
				<li style="width:50%">
					<input type="radio" name="wr_age_limit" id="wr_age_limit_1" value="1" <?=$add_form_chk['연령']['required'];?> hname="연령" option="radio" <?php echo ($job_row['wr_age_limit']=='1') ? 'checked' : '';?>><label for="wr_age_limit_1">연령제한 있음</label>
				</li>
				<li class="age_int__" style="display:<?=$job_row['wr_age_limit']==1 ? 'block' : 'none';?>;"><input type="text" hname="연령" name="wr_sage" value="<?=$_wr_age_arr[0];?>" style="width:50px;" <?php echo ($job_row['wr_age_limit']=='1') ? 'required' : '';?> /><span style="float:left;margin:0 5px">~</span> <input type="text" hname="연령" name="wr_eage" value="<?=$_wr_age_arr[1];?>" style="width:50px;" <?php echo ($job_row['wr_age_limit']=='1') ? 'required' : '';?> /> &nbsp;세</li>
				<?php
				if(is_array($_cate_['job_age'])) { foreach($_cate_['job_age'] as $k=>$v) {
					$checked = (@in_array($v['code'], $_wr_age_etc)) ? "checked" : "";
				?>
				<li>
					<input type="checkbox" name="wr_age_etc[]" id="wr_age_etc_<?=$k;?>" value="<?=$v['code'];?>" <?=$checked;?>><label for="wr_age_etc_<?=$k;?>"><?=$v['name'];?></label>
				</li>
				<?php
				} }
				?>
			</ul>
			<p>채용 시 합리적인 이유 없이 연령제한을 하는 경우 연령차별금지법 위반에 해당되어 500만원 이하의 벌금이 부과될 수 있습니다.</p>
		</li>
		<?php } ?>
		<li class="row3">
			<label>학력조건<span class="check"></span></label>
			<ul>
				<?php
				if(is_array($_cate_['job_ability'])) { foreach($_cate_['job_ability'] as $k=>$v) {
					$checked = $k==0 || $v['code']==$job_row['wr_ability'] ? 'checked' : '';
				?>
				<li>
					<input type="radio" name="wr_ability" id="wr_ability_<?=$k;?>" value="<?=$v['code'];?>" <?=$checked;?>><label for="wr_ability_<?=$k;?>"><?=$v['name'];?></label>
				</li>
				<?php
				} }
				?>
			</ul>
		</li>
		<li class="row4" style="position:relative">
			<label>경력사항<span class="check"></span></label>
			<ul>
				<li>
					<label><input type="radio" name="wr_career_type" class="no-experience" onClick="career_sel()" checked value="0" required hname="경력사항" option="radio" checked>경력무관</label>
				</li>
				<li>
					<label><input type="radio" name="wr_career_type" class="new-recruit" onClick="career_sel()" value="1" required hname="경력사항" option="radio" <?php echo ($job_row['wr_career_type']=='1') ? 'checked' : '';?>>신입</label>
				</li>
				<li>
					<label><input type="radio" name="wr_career_type" class="experience" onClick="career_sel()" value="2" required hname="경력사항" option="radio" <?php echo ($job_row['wr_career_type']=='2') ? 'checked' : '';?>>
					경력</label>
					<select name="wr_career" style="float:left">
						<option value="">경력선택</option>
						<?php
						if(is_array($_cate_['job_career'])) { foreach($_cate_['job_career'] as $k=>$v) {
							$selected = ($job_row['wr_career']==$v['code']) ? "selected" : "";
						?>
						<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
						<?php
						} }
						?>
					</select>
					<span style="position:absolute;right:-25px">이상</span>
					<script type="text/javascript">
					career_sel();
					</script>
				</li>
			</ul>
		</li>
		<li class="row5">
			<label>우대조건</label>
			<ul>
				<?php
				if(is_array($_cate_['preferential'])) { foreach($_cate_['preferential'] as $k=>$v) {
					$checked = (@in_array($v['code'], $_wr_preferential)) ? "checked" : "";
				?>
				<li>
					<input type="checkbox" name="wr_preferential[]" id="wr_preferential_<?=$k;?>" value="<?=$v['code'];?>" <?=$checked;?>><label for="wr_preferential_<?=$k;?>"><?=$v['name'];?></label>
				</li>
				<?php
				} }
				?>
			</ul>
		</li>
	</ul>
</section>

<section class="cont_box job_con5">
<h2>모집내용</h2>
<ul class="info_con3">
	<li class="row1">
		<label>모집인원<span class="check"></span></label>
		<ul>
			<li>
				<input type="text" id="" name="wr_volume" value="<?php echo $job_row['wr_volume'];?>" <?php echo (@in_array('0', $_wr_volumes, true) || @in_array('00', $_wr_volumes, true)) ? '' : 'required';?> hname="모집인원">명
			</li>
			<li>
				<input type="checkbox" id="" name="wr_volumes[]" value="0" <?php echo (@in_array('0', $_wr_volumes, true)) ? 'checked':'';?> onClick="volume_click(this)"> 0명
			</li>
			<li>
				<input type="checkbox" id="" name="wr_volumes[]" value="00" <?php echo (@in_array('00', $_wr_volumes, true))?'checked':'';?> onClick="volume_click(this)"> 00명
			</li>
		</ul>
		<script type="text/javascript">
		volume_click();
		</script>
	</li>
	<li class="row2">
		<label>모집대상</label>
		<ul>
			<?php
			if(is_array($_cate_['job_target'])) { foreach($_cate_['job_target'] as $k=>$v) {
				$checked = @in_array($v['code'], $_wr_target) ? 'checked' : '';
			?>
			<li>
				<input type="checkbox" name="wr_target[]" id="wr_target_<?=$k;?>" value="<?=$v['code'];?>" <?=$checked;?>><label for="wr_target_<?=$k;?>"><?=$v['name'];?></label>
			</li>
			<?php
			} }
			?>
		</ul>
	</li>
	<li class="row3">
		<label>모집종료일<span class="check"></span></label>
		<ul>
			<li style="margin-bottom:5px"><input type="radio" name="volume_check" checked value="wr_volume_dates" onClick="wr_volume_click()"><input type="text" name="wr_volume_date" class="datepicker_inp wr_volume_date_c" hname="모집종료일" value="<?php echo $job_row['wr_volume_date'];?>" <?php echo (!$job_row['wr_volume_always'] && !$job_row['wr_volume_end']) ? 'required' : '';?>><input type="button" class="plus_bt btn_datepicker" get=".wr_volume_date_c" value="날짜선택"></li>
			<li><input type="radio" id="volume_check_wr_volume_always" name="volume_check" value="wr_volume_always" onClick="wr_volume_click()" <?php echo ($job_row['wr_volume_always']) ? 'checked' : '';?>><label for="volume_check_wr_volume_always">상시모집</label></li>
			<li><input type="radio" id="volume_check_wr_volume_end" name="volume_check" value="wr_volume_end" onClick="wr_volume_click()" <?php echo ($job_row['wr_volume_end']) ? 'checked' : '';?>><label for="volume_check_wr_volume_end">채용시까지</label></li>
		</ul>
	</li>
	<?php if($add_form_arr['접수방법']['view']=='yes'){ ?>
	<li class="row4">
		<label>접수방법<?=$add_form_chk['접수방법']['tag'];?></label>
		<ul>
			<?php
			if(is_array($netfu_mjob->requisition_arr)) { foreach($netfu_mjob->requisition_arr as $k=>$v) {
				$online_c = in_array($k, array('online', 'email')) ? ' online' : '';
				$checked = (@in_array($k, $_wr_requisition)) ? 'checked' : '';
			?>
			<li><input type="checkbox" id="wr_requisition_<?=$k;?>" name="wr_requisition[]" hname="접수방법" <?=$add_form_chk['접수방법']['required'];?> value="<?=$k;?>" <?=$checked;?> onClick="netfu_mjob.wr_requisition_click(this)"><label for="wr_requisition_<?=$k;?>" class="<?=$online_c;?>" hname="접수방법" option="checkbox"><?=$v;?></label></li>
			<?php
			} }
			?>
			<li class="wr_requisition_input wr_requisition_homepage row7" style="clear:both;width:100%;display:<?=(@in_array('homepage', $_wr_requisition)) ? 'block' : 'none';?>;">
				<div style="float:left;margin-right:5px">http://</div><input type="text" name="wr_homepage" value="<?=$job_row['wr_homepage'];?>" class="" style="float:left;width:80%">
			</li>
		</ul>
	</li>
	<?php
	}

	if($add_form_arr['제출서류']['view']=='yes'){ ?>
	<li class="row5">
		<label>제출서류<?=$add_form_chk['제출서류']['tag'];?></label>
		<ul>
			<?php
			if(is_array($_cate_['pt_paper'])) { foreach($_cate_['pt_paper'] as $k=>$v) {
				$checked = (@in_array($v['code'], $_wr_papers)) ? 'checked' : '';
			?>
			<li><input type="checkbox" id="wr_papers_<?=$k;?>" name="wr_papers[]" hname="제출서류" <?=$add_form_chk['제출서류']['required'];?> value="<?=$v['code'];?>" <?=$checked;?>><label for="wr_papers_<?=$k;?>"><?=$v['name'];?></label></li>
			<?php
			} }
			?>
		</ul>
	</li>
	<?php } ?>
	<?php if($add_form_arr['사전질문']['view']=='yes'){ ?>
	<li class="row6">
		<label>사전질문<?=$add_form_chk['사전질문']['tag'];?></label>
		<div class="text_gp cf">
			<p>사전인터뷰 질문을 등록하시면 온라인 입사지원시 지원자가 이력서와 함께 질문에 대한 답변을 작성해서 보냅니다.</p>
		</div>
		<textarea style="width:100%;height:250px;" name="wr_pre_question" <?=$add_form_chk['사전질문']['required'];?> hname="사전질문"><?php echo stripslashes($job_row['wr_pre_question']);?></textarea>
	</li>
	<?php } ?>
</ul>
</section>

<section class="cont_box job_con5">
<h2>상세모집요강</h2>
<ul class="info3_con">
	<li class="row_con">
		<ul class="resume_chk textarea_put_chk">
			<li><label for="style1"><input type="checkbox" id="style1" value="1" onClick="netfu_mjob.introduce_part_click(this, 'all', 'wr_content')">전체선택</label></li>
			<?php
			if(is_array($_cate_['alba_content'])) { foreach($_cate_['alba_content'] as $k=>$v) {
			?>
			<li><label><input type="checkbox" name="wr_content_check" onClick="netfu_mjob.introduce_part_click(this, '<?=$k;?>', 'wr_content')" id="<?=$v['code'];?>" value="<?=$v['name'];?>"><?=$v['name'];?></label></li>
			<?php
			} }
			?>
		</ul>
	</li>
	<li class="row_con">
		<textarea type="editor" style="width:100%;height:250px;" name="wr_content" hname="상세모집요강" required><?=stripslashes($job_row['wr_content']);?></textarea>
	</li>
</ul>
</section>


<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="submit_func()">다음</a><a href="#none;" onClick="document.forms['fwrite'].reset()" class="bottom_btn02">취소</a>
</div>
</form>

<?php
include "../include/tail.php";
?>