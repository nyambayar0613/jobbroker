<?php
$head_title = "지원자관리";
$page_code = 'mypage';
include_once "../include/top.php";
$_GET['code'] = $_GET['code'] ? $_GET['code'] : 'ing';

$_where = "";
if($_GET['code']=='end') $_where .= $netfu_mjob->end_job;
else $_where .= $netfu_mjob->ing_job;

// : 진행중인 공고선택
$q_sel = sql_query("select * from `alice_alba` where `wr_id` = '".$member['mb_id']."' ".$_where." order by `no` desc");


// : 쿼리문
$_limit = 10;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_where = " and `wr_to_id` = '".$member['mb_id']."' and ar.`is_delete` = 0";
if($_GET['job_sel']) $_where .= " and `wr_to`='".addslashes($_GET['job_sel'])."'";
if($_GET['code']=='end') $_where2 .= $netfu_mjob->end_job;
else $_where2 .= $netfu_mjob->ing_job;
$q = "alice_alba as aa join `alice_receive` as ar where aa.`no`=ar.`wr_to` ".$_where;
$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
$query = sql_query("select ar.* from ".$q.$_where2." order by ar.`no` desc limit ".$_start.", ".$_limit);
$total = sql_fetch("select count(*) as c from ".$q.$_where2);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c']));



// : 진행중인 구인공고
$_num[0] = sql_fetch("select count(*) as c from ".$q.$netfu_mjob->ing_job.$_where);
// : 마감된 구인공고
$_num[1] = sql_fetch("select count(*) as c from ".$q.$netfu_mjob->end_job.$_where);
?>
<section class="cont_box detail_con">
<?php
include NFE_PATH.'/include/inc/my_company_info.inc.php';

include NFE_PATH.'/include/inc/my_company_count.inc.php';
?>
</section>

<form name="flist" action="../regist.php" method="post">
<input type="hidden" name="mode" value="job_report_delete" />
<section class="cont_box resume_list">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 active"><a href="<?=$_SERVER['PHP_SELF'];?>?code=ing">진행중인 구인공고<span class="list_num"><?=number_format($_num[0]['c']);?></span></a></li>
			<li class="tab02"><a href="<?=$_SERVER['PHP_SELF'];?>?code=end">마감된 구인공고<span class="list_num"><?=number_format($_num[1]['c']);?></span></a></li>
		</ul>
		<ul class="search_area">
			<li>
				<div class="match select_op">
					<select name="job_sel" onChange="location.replace('<?=$_SERVER['PHP_SELF'];?>?job_sel='+this.value)">
						<option value="">---------------- <?=($_GET['code']=='end') ? '마감된' : '진행중인';?> 구인공고 선택 ---------------- </option>
						<?php
						while($row=sql_fetch_array($q_sel)) {
							$selected = $_GET['job_sel']==$row['no'] ? 'selected' : '';
						?>
						<option value="<?=$row['no'];?>" <?=$selected;?>><?=$row['wr_subject'];?></option>
						<?php
						}
						?>
					</select>
				</div>
			</li>
		</ul>

		<?php
		switch($total['c']<=0) {

			case true:
		?>
		<ul class="list_con">
			<li class="col2 none">
				<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">등록된 공고가 없습니다.</div>
			</li>
		</ul>
		<?php
				break;


			default:

				while($row=sql_fetch_array($query)) {
					$get_member = $user_control->get_member($row['wr_id']);
					$get_resume = $alba_individual_control->get_resume_no($row['wr_from']);	// 이력서 정보
					$list = $alba_resume_user_control->get_resume_service($row['wr_from'],"",80);
					$re_info = $netfu_mjob->get_resume($get_resume, $get_member);
					$mb_photo_file = $alice['data_member_path']."/".$get_member['mb_id']."/".$get_member['mb_photo'];
					$_photo_gender = $get_member['mb_gender'] ? '2' : '';
					$mb_photo = (is_file($mb_photo_file)) ? $mb_photo_file : "../images/id_pic".$_photo_gender.".png";	 // 개인회원 프로필 사진


					switch(!$get_resume) {
						case true:
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"><?=$row['no'];?></li>
			<li class="col2">
				삭제된 이력서입니다.
			</li>
		</ul>
		<?php
							break;


						default:
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2"><a href="../resume/detail.php?no=<?=$row['wr_from'];?>">
				<div class="picture_box">
					<?php echo $list['wr_photo'];?>
				</div>
				<div class="profile_name pfn"><?=$get_member['mb_name'];?>(<?=$netfu_util->gender_arr[$get_member['mb_gender']];?> <?=$netfu_util->get_age($get_member['mb_birth']);?>세)</div>
				<div class="address_con addc"><?php echo $list['mb_address'];?></div>
				<div class="list_txt list_txt3"><?=$netfu_util->get_stag($row['etc_0']);?></div>
				<div class="list_etc"><span><?php echo $get_member['mb_hphone'];?></span></div>
				<div class="list_etc"><span><?php echo $get_member['mb_email'];?></span></div>
				<div class="list_etc3"><span><i>경력</i><?=$netfu_util->get_stag($list['career']);?></span></div>
				<?php
				if($re_info['license']) {
				?>
				<div class="list_etc3"><span><em>자격증</em><?=$re_info['license'];?></span></div>
				<?php }?>
			</a></li>
		</ul>
		<?php
							break;
					}
				}
				break;

		}
		?>
		<?=$paging;?>
	</div>
</section>

<div class="button_con button_con3">
	<a href="#none;" class="bottom_btn03" onClick="netfu_util1.delete_select_func(document.forms['flist'])">삭제</a>
</div>
</form>

<?php
include "../include/tail.php";
?>