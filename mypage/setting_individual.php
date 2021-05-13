<?php
$head_title = "맞춤구인정보";
$page_code = 'mypage';
include "../include/top.php";

$_GET['code'] = $_GET['code'] ? $_GET['code'] : 'list';

// : $custom_titles 변수는 include/nav_right.php 페이지에서 생성합니다.

$_add = $alba_individual_control->_CustomSearch( $_GET['no'] );

// : 쿼리문
$_where = " and `is_delete`=0";
$q = "`alice_alba` where 1 ".$_add['que'];
$total = sql_fetch("select count(*) as c from ".$q);
if($_GET['code']=='list') {
	$_limit = 10;
	$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
	$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
	$query = sql_query("select * from ".$q." order by `no` desc limit ".$_start.", ".$_limit);
	$list_num = mysql_num_rows($query);
	$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c']));
}
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/mjob.class.js?time=<?=time();?>"></script>
<script type="text/javascript">
var save_search = function() {
	var setting_list = $("[name='setting_list']");
	location.href = "./setting_individual.php?code=<?=$_GET['code'];?>&no="+setting_list.val();
}
</script>
<section class="cont_box detail_con">
<?php
include NFE_PATH.'/include/inc/member_info.inc.php';

include NFE_PATH.'/include/inc/my_resume_count.inc.php';
?>
</section>

<section class="cont_box resume_list">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 <?=$_GET['code']=='list' ? 'active' : '';?>"><a href="<?=$_SEVRER['PHP_SELF'];?>?code=list&no=<?=$_GET['no'];?>">맞춤 구인정보<span class="list_num"><?=number_format(count($custom_titles));?></span></a></li>
			<li class="tab02 <?=$_GET['code']=='input' ? 'active' : '';?>"><a href="<?=$_SEVRER['PHP_SELF'];?>?code=input&no=<?=$_GET['no'];?>">조건설정 · 수정</a></li>
		</ul>
		<ul class="search_area">
			<li>
				<div class="match">
					<select name="setting_list">
						<option value="">-------------- 맞춤 조건 선택 --------------</option>
						<?php
						if(is_array($custom_titles)) { foreach($custom_titles as $k=>$v) {
							$selected = $v['no']==$_GET['no'] ? 'selected' : '';
						?>
						<option value="<?=$v['no'];?>" <?=$selected;?>>[<?=$k+1;?>]<?=$v['wdate'];?> 저장</option>
						<?php
						} }
						?>
					</select>
				</div>
				<div class="search_btn2">
					<button type="button" onClick="save_search()"><img src="<?=NFE_URL;?>/images/search_icon.png" alt="검색">검색</button>
				</div>
			</li>
		</ul>


		<?php
		// : 맞춤구인정보 리스트
		if($_GET['code']=='list') {
		?>
		<div class="setting_view _list">
			
			<?php
			switch($total['c']<=0) {
				case true:
			?>
			<ul class="list_con">
				<li class="col2 none">
					<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">맞춤 구인정보가 없습니다.</div>
				</li>
			</ul>
			<?php
					break;



				default:
					while($row=sql_fetch_array($query)) {
						$info = $netfu_mjob->get_alba($row);
						$company_name = strip_tags(stripslashes($row['wr_company_name']));
						$subject = strip_tags(stripslashes($row['wr_subject']));

						// : 지역
						$_area_arr = explode("/", $row['wr_area_0']);
						$area_arr = $netfu_util->get_cate($_area_arr);
						$area_txt = $area_arr[0].' '.$area_arr[1];

						// : 급여
						$wr_pay = number_format($row['wr_pay'])."원";
						$wr_pay_type = $category_control->get_categoryCode($row['wr_pay_type']);
						$wr_pay_txt = ($row['wr_pay_conference']) ? '<i>'.$alba_user_control->pay_conference[$row['wr_pay_conference']].'</i>' : '<i>'.$wr_pay_type['name'].'</i> <em>'.$wr_pay.'</em>';

						// : 기타
						$gender_txt = $netfu_util->gender_val[$row['wr_gender']]; // : 성별
						$time_txt = $info['wr_time']; // : 시간협의
						$valume_txt = $info['volume_text']; // : 마감일
						$wdate_txt = $netfu_util->get_date('dot', $row['wr_wdate']);
			?>
			<ul class="list_con">
				<li class="col2 no_chk"><a href="<?=NFE_URL;?>/job/detail.php?no=<?=$row['no'];?>">
					<?php
					include NFE_PATH.'/include/inc/my_em_list.inc.php';
					?>
				</a></li>
				<li class="col3">
					<div class="list_btn list_btn3" onClick="netfu_mjob.scrap('alba', '<?=$row['no'];?>')"><button type="button">스크랩 <img src="<?=NFE_URL;?>/images/scrap_icon2.png"><!--<img src="<?=NFE_URL;?>/images/scrap_icon1.png">--></button></div>
					<div class="button_group"><div class="list_btn list_btn4 bt-online _btn requisition_btn" no="<?=$row['no'];?>" k="online"><button type="button">즉시지원</button></div></div>
				</li>
			</ul>
			<?php
					}
					break;
			}

			echo $paging;
			?>
		</div>

		<?php
		}




		// :  조건설정 테이블
		if($_GET['code']=='input') {
			$_cate_['job_type'] = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = ''"));
			$_cate_['area'] = $netfu_util->get_cate_array('area', array('where'=>" and `p_code` = ''"));
			$_cate_['alba_date'] = $netfu_util->get_cate_array('alba_date', array('where'=>" and `p_code` = ''"));
			$_cate_['alba_week'] = $netfu_util->get_cate_array('alba_week', array('where'=>" and `p_code` = ''"));
			$_cate_['work_type'] = $netfu_util->get_cate_array('work_type', array('where'=>" and `p_code` = ''"));
			$_cate_['job_ability'] = $netfu_util->get_cate_array('job_ability', array('where'=>" and `p_code` = ''"));

			if($_GET['no']) {
				$get_custom = $alba_individual_control->get_custom($_GET['no']);

				if($get_custom['wr_job_type0']) $resume_job_type[0] = array($get_custom['wr_job_type0'], $get_custom['wr_job_type1'], $get_custom['wr_job_type2']);

				if($get_custom['wr_area0']) $resume_area[0] = array($get_custom['wr_area0'], $get_custom['wr_area1'], $get_custom['wr_area2']);

				// : 직종 2,3차
				if($get_custom['wr_job_type0']) $job_type1_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$resume_job_type[0][0]."'"));
				if($get_custom['wr_job_type1']) $job_type2_arr = $netfu_util->get_cate_array('job_type', array('where'=>" and `p_code` = '".$resume_job_type[0][1]."'"));

				// : 시간
				$wr_stime = explode(":", $get_custom['wr_stime']);
				$wr_etime = explode(":", $get_custom['wr_etime']);

				// : 연령
				$wr_age = explode("-", $get_custom['wr_age']); // : 연령
				$wr_work_type = explode(",", $get_custom['wr_work_type']); // : 근무형태
			}
		?>
		<form name="fwrite" action="../regist.php" method="post">
		<input type="hidden" name="mode" value="setting_individual" />
		<input type="hidden" name="no" value="<?=addslashes($_GET['no']);?>" />
		<div class="setting_view _input search_con search_box sb2">
			<table class="search_tb">
				<!-- 맞춤조건1 -->
				<tr>
					<th class="sch_hd">
						<div>업직종</div>
					</th>
					<td class="sch_td1">
						<select name="wr_job_type0" sel="1" type="job_type" val="<?=$resume_job_type[0][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 1)" put="wr_job_type1_id" auto_none>
							<option value="">업직종1차</option>
							<?php
							if(is_array($_cate_['job_type'])) { foreach($_cate_['job_type'] as $k=>$v) {
								$selected = $v['code']==$resume_job_type[0][0] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php
							} }
							?>
						</select>
					</td>
					<td class="sch_td2">
						<select id="wr_job_type1_id" name="wr_job_type1" sel="2" type="job_type" val="<?=$resume_job_type[0][1];?>" onChange="netfu_util1.ajax_cate(this, 'job_type', 2)" put="wr_job_type2_id" auto_none>
							<option value="">업직종2차</option>
							<?php
							if(is_array($job_type1_arr)) { foreach($job_type1_arr as $k=>$v) {
								$selected = $v['code']==$resume_job_type[0][1] ? 'selected' : '';
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
								$selected = $v['code']==$resume_job_type[0][2] ? 'selected' : '';
							?>
							<option value="<?=$v['code'];?>" <?=$selected;?>><?=$v['name'];?></option>
							<?php
							} }
							?>
						</select>
					</td>
				</tr>
				<!-- 맞춤조건2 -->
				<tr>
					<th class="sch_hd">
						<div>근무지</div>
					</th>
					<td colspan="3">
						<table class="tb2">
							<tr>
								<td class="sch_td1">
									<select name="wr_area0" sel="1" type="area" val="<?=$resume_area[0][1];?>" put="wr_area1_id" onChange="netfu_util1.ajax_cate(this, 'area', 1)">
									<option value="">시·도</option>
									<?php
									if(is_array($_cate_['area'])) { foreach($_cate_['area'] as $k=>$v) {
										$selected = $resume_area[0][0]==$v['code'] ? 'selected' : '';
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
							</tr>
						</table>
					</td>
				</tr>
				<!-- 맞춤조건3 -->
				<tr>
					<th class="sch_hd">
						<div>근무일시</div>
					</th>
					<td colspan="3">
						<table class="tb2">
							<tr>
								<td class="tb2_sch_td1">
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
								<td class="tb2_sch_td2">
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
							</tr>
							<tr>
								<td class="tb2_sch_td1 time_slt_td" colspan="2">
									<select name="wr_stime[]">
										<option value="">선택</option>
										<?php for($i=0;$i<=23;$i++){ ?>
										<option value="<?php echo sprintf('%02d',$i);?>" <?php echo ($wr_stime[0]&&$wr_stime[0]==$i)?'selected':'';?>><?php echo sprintf('%02d',$i);?>시</option>
										<?php } ?>
									</select>
									<select name="wr_stime[]">
										<option value="">선택</option>
										<?php for($i=0;$i<=5;$i++){?>
										<option value="<?php echo $i;?>0" <?php echo ($wr_stime[1]==$i.'0')?'selected':'';?>><?php echo $i;?>0분</option>
										<?php } ?>
									</select>
									<span>~</span>
									<select name="wr_etime[]">
										<option value="">선택</option>
										<?php for($i=0;$i<=23;$i++){ ?>
										<option value="<?php echo sprintf('%02d',$i);?>" <?php echo ($wr_etime[0]&&$wr_etime[0]==$i)?'selected':'';?>><?php echo sprintf('%02d',$i);?>시</option>
										<?php } ?>
									</select>
									<select name="wr_etime[]">
										<option value="">선택</option>
										<?php for($i=0;$i<=5;$i++){?>
										<option value="<?php echo $i;?>0" <?php echo ($wr_etime[1]==$i.'0')?'selected':'';?>><?php echo $i;?>0분</option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="tb2_sch_td1 cst" colspan="2">
									<input type="checkbox" id="time_adj" name="wr_time_conference" value="1" <?=$get_custom['wr_time_conference'] ? 'checked' : '';?>><label for="time_adj">시간협의</label>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<!-- 맞춤조건4 -->
				<tr>
					<th class="sch_hd">
						<div>성별선택</div>
					</th>
					<td class="sch_td2" colspan="3">
						<fieldset>
							<legend>성별선택</legend>
							<label for="no-gender"><input type="radio" id="no-gender" name="wr_gender" value="0" <?=$get_custom['wr_gender']==='0' ? 'checked' : '';?>>성별무관</label>
							<label for="male"><input type="radio" id="male" name="wr_gender" value="1" <?=$get_custom['wr_gender']==1 ? 'checked' : '';?>>남자</label>
							<label for="female"><input type="radio" id="female" name="wr_gender" value="2" <?=$get_custom['wr_gender']==2 ? 'checked' : '';?>>여자</label>
						</fieldset>
					</td>
				</tr>
				<!-- 맞춤조건5 -->
				<tr>
					<th class="sch_hd">
						<div>연령</div>
					</th>
					<td class="sch_td2" colspan="3">
						<fieldset>
							<legend>연령선택</legend>
							<input type="radio" name="wr_age_limit" value="0" <?=$get_custom['wr_age_limit']==='0' ? 'checked' : '';?>>연령무관<br>
							<input type="radio" name="wr_age_limit" value="1" <?=$get_custom['wr_age_limit']==='1' ? 'checked' : '';?>>연령제한
							<input type="text" name="wr_sage" value="<?=$wr_age[0];?>">세 이상 ~<input type="text" name="wr_eage" value="<?=$wr_age[1];?>"> 세 이하
						</fieldset>
					</td>
				</tr>
				<!-- 맞춤조건6 -->
				<tr>
					<th class="sch_hd">
						<div>근무형태</div>
					</th>
					<td class="sch_td2" colspan="3">
						<fieldset>
							<legend>근무형태선택</legend>
							<?php
							if(is_array($_cate_['work_type'])) { foreach($_cate_['work_type'] as $k=>$v) {
								$checked = @in_array($v['code'], $wr_work_type) ? 'checked' : '';
							?>
							<input type="checkbox" name="wr_work_type[]" value="<?=$v['code'];?>" <?=$checked;?>><?=$v['name'];?>
							<?php
							} }
							?>
						</fieldset>
					</td>
				</tr>
				<!-- 맞춤조건7 -->
				<tr>
					<th class="sch_hd">
						<div>경력</div>
					</th>
					<td class="sch_td2" colspan="3">
						<fieldset>
							<legend>경력선택</legend>
							<input type="radio" name="wr_career" value="0">무관
							<input type="radio" name="wr_career" value="1">신입
							<input type="radio" name="wr_career" value="2">경력
						</fieldset>
					</td>
				</tr>
				<!-- 맞춤조건8 -->
				<tr>
					<th class="sch_hd">
						<div>학력</div>
					</th>
					<td class="sch_td2" colspan="3">
						<select name="wr_ability">
							<option value="">학력선택</option>
							<?php
							if(is_array($_cate_['job_ability'])) { foreach($_cate_['job_ability'] as $k=>$v) {
							?>
							<option value="<?=$v['code'];?>"><?=$v['name'];?></option>
							<?php
							} }
							?>
						</select>
					</td>
				</tr>
			</table>
		</div>
		</form>
		<?php }?>

	</div>
</section>

<?php
if($_GET['code']=='input') {
?>
<div class="button_con">
	<a href="#none;" class="bottom_btn01" onClick="document.forms['fwrite'].submit()">저장</a><a href="javascript:document.forms['fwrite'].reset()" class="bottom_btn02">취소</a>
</div>
<?php }



include "../include/tail.php";
?>