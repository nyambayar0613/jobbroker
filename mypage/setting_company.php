<?php
$head_title = "맞춤인재정보";
$page_code = 'mypage';
include_once "../include/top.php";

$_GET['code'] = $_GET['code'] ? $_GET['code'] : 'list';

$save_query = sql_query("select * from `alice_resume_search` where `wr_id` = '".$member['mb_id']."' order by `no` desc");

// : 쿼리문
$_limit = 10;
$_add = $alba_company_control->_CustomSearch( $_GET['sel_no'] );
$_where = " and `is_delete` = 0 ".$_add['que'];
$q = "`alice_alba_resume` where 1 ".$_where;
$total = sql_fetch("select count(*) as c from ".$q.$_where2);
if($_GET['code']=='list') {
	$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
	$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
	$query = sql_query("select * from ".$q.$_where2." order by `no` desc limit ".$_start.", ".$_limit);
	$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c']));
} else {
	$get_custom = $alba_company_control->get_custom($_GET['sel_no']);
	$_job_type_arr = array($get_custom['wr_job_type0'], $get_custom['wr_job_type1'], $get_custom['wr_job_type2']);
	$_area_arr = array($get_custom['wr_area0'], $get_custom['wr_area1'], $get_custom['wr_area2']);
}
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/mjob.class.js?time=<?=time();?>"></script>
<section class="cont_box detail_con">
<?php
include NFE_PATH.'/include/inc/my_company_info.inc.php';

include NFE_PATH.'/include/inc/my_company_count.inc.php';
?>
</section>

<script type="text/javascript">
var search_func = function() {
	var form = document.forms['fsearch2'];
	form.submit();
}
</script>
<section class="cont_box resume_list">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 <?=$_GET['code']=='list' ? 'active' : '';?>"><a href="./setting_company.php?code=list&sel_no=<?=$_GET['sel_no'];?>">맞춤 인재정보<span class="list_num"><?=number_format($save_query_num_);?></span></a></li>
			<li class="tab02 <?=$_GET['code']!='list' ? 'active' : '';?>"><a href="./setting_company.php?code=input&sel_no=<?=$_GET['sel_no'];?>">조건설정·수정</a></li>
		</ul>
		<form name="fsearch2" action="<?=$_SERVER['PHP_SELF']?>" method="get">
		<input type="hidden" name="code" value="<?=$_GET['code'];?>" />
		<ul class="search_area">
			<li>
				<div class="match_tit">맞춤조건 선택</div>
				<div class="match">
					<select name="sel_no">
						<option value="">선택해주세요</option>
						<?php
						$count = 1;
						// : $save_query 변수는 include/nav_right.php 페이지에 있습니다.
						while($row=sql_fetch_array($save_query)) {
							$selected = $row['no']==$_GET['sel_no'] ? 'selected' : '';
						?>
						<option value="<?=$row['no'];?>" <?=$selected;?>>[<?=sprintf("%02d", $count);?>]<?=$row['wdate'];?> 저장</option>
						<?php
							$count++;
						}
						?>
					</select>
				</div>
				<div class="search_btn2">
					<a href="#none;" onClick="search_func();"><img src="<?=NFE_URL;?>/images/search_icon.png" alt="검색">검색</a>
				</div>
				<?php
				if($_GET['code']=='input') {
				?>
				<p>선택하시고 저장하시면 선택하신 맞춤 조건이 수정됩니다.</p>
				<?php
				}
				?>
			</li>
		</ul>
		</form>
		<?php
		// : 맞춤 인재정보 리스트
		if($_GET['code']=='list') {
		?>
		<form name="flist" action="../regist.php" method="post">
		<input type="hidden" name="mode" />
		<input type="hidden" name="code" value="alba_resume" />
		<?php
		
			switch($total['c']<=0) {

				case true:
			?>
			<ul class="list_con">
				<li class="col2 none">
					<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">등록된 내용이 없습니다.</div>
				</li>
			</ul>
			<?php
					break;



				default:
					while($row=sql_fetch_array($query)) {
						$list = $alba_resume_user_control->get_resume_service($row['no'],"",60);
						$get_resume = $alba_individual_control->get_resume_no($row['no']);	// 이력서 정보
						$get_member = $user_control->get_member($list['wr_id']);
						$re_info = $netfu_mjob->get_resume($get_resume, $get_member);
			?>
			<ul class="list_con">
				<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
				<li class="col2"><a href="../resume/detail.php?no=<?=$get_resume['no'];?>">
					<div class="profile_name pfn"><?=$get_member['mb_name'];?>(<?=$netfu_util->gender_arr[$get_member['mb_gender']];?> <?=$netfu_util->get_age($get_member['mb_birth']);?>세)</div>
					<div class="list_txt list_color"><?=$re_info['job_type_val'][0];?></div>
					<div class="list_etc"><span>희망지역 : <?=$re_info['area_val'][0];?></span></div>
					<div class="list_etc"><span><?php echo $list['mb_email'];?></span></div>
					<div class="list_etc"><span><i>월급</i> <em><?=$re_info['pay_type'];?></em></span></div>
					<div class="list_etc3"><span><i>경력</i><?=$netfu_util->get_stag($list['career']);?></span></div>
					<div class="list_etc3"><span><em>자격증</em><?=$re_info['license'];?></span></div>
				</a></li>
				<li class="col3">
					<div class="date_box date_box2 cf"> 
						<div class="con1 cf" style="margin-bottom:0">
						  <div>수정일</div>
							<div class="date-bx"><?=date("y.m.d", strtotime($get_resume['wr_udate']));?></div>
						</div>
					</div>
				</li>
			</ul>
			<?php
					}
					break;
			}
			?>
			<?=$paging;?>
			</form>
			<?php








		// : 맞춤인재정보 폼
		} else {
			$_cate_['job_type'] = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = ''"));
			$_cate_['area'] = $netfu_util->get_cate_array('area', array('where'=>" and `p_code` = ''"));
			$_cate_['alba_date'] = $netfu_util->get_cate_array('alba_date', array('where'=>" and `p_code` = ''"));
			$_cate_['alba_week'] = $netfu_util->get_cate_array('alba_week', array('where'=>" and `p_code` = ''"));
			$_cate_['alba_time'] = $netfu_util->get_cate_array('alba_time', array('where'=>" and `p_code` = ''"));
			$_cate_['work_type'] = $netfu_util->get_cate_array('work_type', array('where'=>" and `p_code` = ''"));
			$_cate_['job_ability'] = $netfu_util->get_cate_array('job_ability', array('where'=>" and `p_code` = ''"));

			$_wr_work_type = explode(",", $get_custom['wr_work_type']);

			// : 직종 2,3차
			if($get_custom['wr_job_type0']) $job_type1_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$_job_type_arr[0]."'"));
			if($get_custom['wr_job_type1']) $job_type2_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$_job_type_arr[1]."'"));
		?>
		<form name="fwrite" action="../regist.php" method="post">
		<input type="hidden" name="mode" value="setting_company" />
		<input type="hidden" name="no" value="<?=addslashes($_GET['sel_no']);?>" />
		<ul>
		<li>
			<div class="search_con search_box search_co">
				<table class="search_tb co-tb">
					<!-- 검색유형1 -->
					<tr>
						<th class="sch_hd">
							<div>업직종</div>
						</th>
						<td class="sch_td1">
							<select name="wr_job_type0" sel="1" type="job_type" val="<?=$_job_type_arr[1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 1)" put="wr_job_type1_id" auto_none>
								<option value="">업직종1차</option>
								<?php
								if(is_array($_cate_['job_type'])) { foreach($_cate_['job_type'] as $k=>$v) {
									$selected = $v['code']==$_job_type_arr[0] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }
								?>
							</select>
						</td>
						<td class="sch_td2">
							<select id="wr_job_type1_id" name="wr_job_type1" sel="2" type="job_type" val="<?=$_job_type_arr[1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)" put="wr_job_type2_id" auto_none>
								<option value="">업직종2차</option>
								<?php
								if(is_array($job_type1_arr)) { foreach($job_type1_arr as $k=>$v) {
									$selected = $v['code']==$_job_type_arr[1] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }
								?>
							</select>
						</td>
						<td class="sch_td3">
							<select id="wr_job_type2_id" name="wr_job_type2">
								<option value="">업직종3차</option>
								<?php
								if(is_array($job_type2_arr)) { foreach($job_type2_arr as $k=>$v) {
									$selected = $v['code']==$_job_type_arr[2] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }
								?>
							</select>
						</td>
					</tr>
					<!-- 검색유형2 -->
					<tr>
						<th class="sch_hd">
							<div>근무지</div>
						</th>
						<td class="sch_td1">
							<select name="wr_area0" sel="1" type="area" val="<?=$_area_arr[1];?>" put="wr_area1_id" onChange="netfu_util1.ajax_cate(this, 'area', 1)">
							<option value="">시·도</option>
							<?php
							if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
								$selected = $_area_arr[0]==$v['code'] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php
							} }
							?>
							</select>
						</td>
						<td class="sch_td2">
							<select id="wr_area1_id" name="wr_area1">
								<option value="">시·군·구</option>
							</select>
						</td>
						<td class="sch_td3">
							<input type="checkbox" id="homejob" name="wr_home_work" value="1" <?php echo ($get_custom['wr_home_work']) ? 'checked' : '';?>><label for="homejob">재택근무</label>
						</td>
					</tr>
					<!-- 검색유형3 -->
					<tr>
						<th class="sch_hd">
							<div>근무일시</div>
						</th>
						<td class="sch_td1">
							<select name="wr_date">
								<option value="">근무기간</option>
								<?php
								if(is_array($_cate_['alba_date'])) { foreach($_cate_['alba_date'] as $k=>$v) {
									$selected = $get_custom['wr_date']==$v['code'] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }
								?>
							</select>
						</td>
						<td class="sch_td2">
							<select name="wr_week">
								<option value="">근무요일</option>
								<?php
								if(is_array($_cate_['alba_week'])) { foreach($_cate_['alba_week'] as $k=>$v) {
									$selected = $get_custom['wr_week']==$v['code'] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }
								?>
							</select>
						</td>
						<td class="sch_td3">
							<select class="ipSelect" name="wr_time">
								<option value=""> -- 근무시간 --</option>
								<?php
								if(is_array($_cate_['alba_time'])) { foreach($_cate_['alba_time'] as $k=>$v) {
									$selected = $get_custom['wr_time']==$v['code'] ? 'selected' : '';
								?>
								<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
								<?php
								} }
								?>
							</select>
						</td>
					</tr>
					<tr>
					  <td colspan="4" class="go_work"><input type="checkbox" id="" name="wr_work_direct" value="1" <?php echo ($get_custom['wr_work_direct'])?'checked':'';?>>즉시출근가능</td>
					</tr>
					<!-- 검색유형4 -->
					<tr>
						<th class="sch_hd">
							<div>성별선택</div>
						</th>
						<td class="sch_td2" colspan="3">
							<fieldset>
								<legend>성별선택</legend>
								<label for="no-gender"><input type="radio" id="no-gender" checked name="wr_gender" value="0">성별무관</label>
								<label for="male"><input type="radio" id="male" name="wr_gender" value="1" <?php echo ($get_custom['wr_gender']=='1') ? 'checked' : '';?>>남자</label>
								<label for="female"><input type="radio" id="female" name="wr_gender" value="2" <?php echo ($get_custom['wr_gender']=='2') ? 'checked' : '';?>>여자</label>
							</fieldset>
						</td>
					</tr>
					<!-- 검색유형5 -->
					<tr>
						<th class="sch_hd">
							<div>나이선택</div>
						</th>
						<td class="sch_td1">
							<select name="wr_sage">
								<option value="">나이</option>
								<?php
								for($i=15; $i<=100; $i++) {
									$selected = $get_custom['wr_age']==$i ? 'selected' : '';
								?>
								<option value="<?=$i;?>" <?=$selected ;?>><?=$i;?>세</option>
								<?php
								}
								?>
							</select>
						</td>
						<td class="sch_td2" colspan="2">
						  <fieldset>
								<legend>나이선택</legend>
								<input type="radio" id="unrelated" name="wr_age_limit" value="0" <?php echo ($get_custom['wr_age_limit']=='0') ? 'checked' : '';?>>무관
								<input type="radio" id="under" name="wr_age_limit" value="1" <?php echo ($get_custom['wr_age_limit']=='1') ? 'checked' : '';?>>이하
								<input type="radio" id="over" name="wr_age_limit" value="2" <?php echo ($get_custom['wr_age_limit']=='2') ? 'checked' : '';?>>이상
							</fieldset>
						</td>
					</tr>
					<!-- 검색유형6 -->
					<tr>
						<th class="sch_hd">
							<div>근무형태</div>
						</th>
						<td class="sch_td1" colspan="3">
							<select name="wr_work_type[]">
							<option value="">선택</option>
							<?php
							if(is_array($_cate_['work_type'])) { foreach($_cate_['work_type'] as $k=>$v) {
								$selected = @in_array($v['code'], $_wr_work_type) ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php
							} }
							?>
							</select>
						</td>
					</tr>
					<!-- 검색유형7 -->
					<tr>
						<th class="sch_hd">
							<div>메일링</div>
						</th>
						<td class="sch_td2" colspan="4">
							<label for="mailing" class="tb_chk1"><input type="checkbox" id="mailing" name="wr_email" value="1" <?php echo ($get_custom['wr_email']) ? 'checked' : '';?>>이메일수신</label>
							<label for="sms" class="tb_chk2"><input type="checkbox" name="wr_sms" id="sms" value="1" <?php echo ($get_custom['wr_sms']) ? 'checked' : '';?>>SMS수신</label>
						</td>
					</tr>
				</table>
			</div>
		</li>
		</ul>
		</form>
		<?php
		}
		?>

		
	</div>
</section>


<?php
// : 맞춤 인재정보 리스트
if($_GET['code']=='list') {
?>
<div class="button_con button_con3">
	<a href="#none;" class="bottom_btn03" onClick="netfu_mjob.scrap_sel('flist')"><img src="<?=NFE_URL;?>/images/scrap_icon2.png" style="top:9px"> 인재스크랩</a>
</div>
<?php
} else {
?>
<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="document.forms['fwrite'].submit()">저장</a><a href="#" class="bottom_btn02">초기화</a>
</div>
<?php
}
?>
<?php
include "../include/tail.php";
?>