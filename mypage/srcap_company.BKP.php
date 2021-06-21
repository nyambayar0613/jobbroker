<?php
$head_title = "스크랩인재정보";
$page_code = 'mypage';
include_once "../include/top.php";


// : 쿼리문
$_limit = $_GET['_limit']>0 ? $_GET['_limit'] : 20;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_where = " and `mb_id` = '".$member['mb_id']."'";
$q = "`alice_scrap` where 1 ".$_where;
$_start = $netfu_util->_paging_start($_GET['page'], $_limit);
$query = sql_query("select * from ".$q." order by `no` desc limit ".$_start.", ".$_limit);
$total = sql_fetch("select count(*) as c from ".$q);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$_limit, 'total'=>$total['c']));
?>

<section class="cont_box detail_con">
<?php
include NFE_PATH.'/include/inc/my_company_info.inc.php';

include NFE_PATH.'/include/inc/my_company_count.inc.php';
?>
</section>

<form name="flist" action="../regist.php" method="post">
<input type="hidden" name="mode" value="scrap_delete" />
<section class="cont_box resume_list">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 active"><a href="#none;">스크랩인재정보<span class="list_num"><?=number_format($total['c']);?></span></a></li>
			<li class="sort_st">
				<span>
					<select name="_limit" onChange="location.replace('<?=$_SERVER['PHP_SELF'];?>?_limit='+this.value)">
						<option value="20" <?=$_limit==20 ? 'selected' : '';?>>20개씩 보기</option>
						<option value="40" <?=$_limit==40 ? 'selected' : '';?>>40개씩 보기</option>
						<option value="60" <?=$_limit==60 ? 'selected' : '';?>>60개씩 보기</option>
						<option value="80" <?=$_limit==80 ? 'selected' : '';?>>80개씩 보기</option>
					</select>
				</span>
			</li>
		</ul>

		<?php
		switch($total['c']<=0) {
			case true:
		?>
		<ul class="list_con">
			<li class="col2 none">
				<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">스크랩한 인재정보 내용이 없습니다.</div>
			</li>
		</ul>
		<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
					$list = $alba_resume_user_control->get_resume_service($row['scrap_rel_id'],"",60);
					$get_resume = $alba_individual_control->get_resume_no($row['scrap_rel_id']);	// 이력서 정보
					$get_member = $user_control->get_member($list['wr_id']);
					$re_info = $netfu_mjob->get_resume($get_resume, $get_member);

					switch(!$get_resume) {
						case true:
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2">
				삭제된 인재정보입니다.
			</li>
		</ul>
		<?php
							break;


						default:
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2"><a href="../resume/detail.php?no=<?=$row['scrap_rel_id'];?>">
				<div class="picture_box">
					<?php echo $list['wr_photo'];?>
				</div>
				<div class="profile_name pfn"><?=$get_member['mb_name'];?>(<?=$netfu_util->gender_arr[$get_member['mb_gender']];?> <?=$netfu_util->get_age($get_member['mb_birth']);?>세)</div>
				<div class="address_con addc"><?php echo $list['mb_address'];?></div>
				<div class="list_txt list_txt3"><?=$netfu_util->get_stag($get_resume['wr_subject']);?></div>
				<div class="list_etc3"><span><i>경력</i><?=$netfu_util->get_stag($list['career']);?></span><span>희망지역 : <?=@implode(", ", $re_info['area_val']);?></span></div>
				<div class="list_etc"><span><?php echo $list['mb_email'];?></span></div>
				<div class="list_etc3"><span><em>자격증</em><?=$re_info['license'];?></span></div>
			</a></li>
			<li class="col3">
				<div class="date_box date_box2 cf"> 
					<div class="con1 cf" style="margin-bottom:0">
						<div>스크랩일</div>
						<div class="date-bx"><?=date("y.m.d", strtotime($row['wdate']));?></div>
					</div>
				</div>
			</li>
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