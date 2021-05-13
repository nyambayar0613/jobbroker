<?php
$head_title = "입사지원관리";
$page_code = 'mypage';
include_once "../include/top.php";


// : 쿼리문
$_limit = $_GET['_limit']>0 ? $_GET['_limit'] : 20;
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;
$_where = " and `mb_id` = '".$member['mb_id']."' and `wr_type` = 'become'"; // 면접제의는 interview
$q = "`alice_resume_proposal` where 1 ".$_where;
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
<input type="hidden" name="mode" value="interview_delete" />
<section class="cont_box resume_list">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01 active"><a href="#">입사지원요청관리<span class="list_num"><?=number_format($total['c'])?></span></a></li>
			<li class="sort_st sort_st1">
				<span>
					<select onChange="location.replace('<?=$_SERVER['PHP_SELF'];?>?_limit='+this.value)">
						<option value="20" <?=$_GET['_limit']==20 ? 'selected' : '';?>>20개씩 보기</option>
						<option value="40" <?=$_GET['_limit']==40 ? 'selected' : '';?>>40개씩 보기</option>
						<option value="60" <?=$_GET['_limit']==60 ? 'selected' : '';?>>60개씩 보기</option>
						<option value="80" <?=$_GET['_limit']==80 ? 'selected' : '';?>>80개씩 보기</option>
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
				<div class="list_txt2"><img src="<?=NFE_URL;?>/images/info.png" alt="">등록된 공고가 없습니다.</div>
			</li>
		</ul>
		<?php
				break;


			default:
				while($row=sql_fetch_array($query)) {
					$list = $alba_resume_user_control->get_resume_service($row['wr_resume'],"",60);
					$get_resume = $alba_individual_control->get_resume_no($row['wr_resume']);	// 이력서 정보
					$get_member = $user_control->get_member($list['wr_id']);
					$re_info = $netfu_mjob->get_resume($get_resume, $get_member);
		?>
		<ul class="list_con">
			<li class="col1"><input type="checkbox" id="" name="chk[]" value="<?=$row['no'];?>"></li>
			<li class="col2"><a href="<?=NFE_URL;?>/resume/detail.php?no=<?=$row['wr_resume'];?>">
				<div class="picture_box">
					<img src="<?=$re_info['mb_photo'];?>" alt="증명사진"><!-- <img src="<?=NFE_URL;?>/images/id_pic2.png" alt="증명사진"> -->
				</div>
				<div class="profile_name pfn"><?=$get_member['mb_name'];?>(<?=$netfu_util->gender_arr[$get_member['mb_gender']];?> <?=$netfu_util->get_age($get_member['mb_birth']);?>세)</div>
				<div class="list_txt list_color"><?=$netfu_util->get_stag($get_resume['wr_subject']);?></a></div>
				<div class="list_etc"><span><?php echo $list['mb_email'];?></span></div>
				<div class="list_etc3"><span>희망지역 : <?=$re_info['area_val'][0];?></span><span><i>경력</i><?=$netfu_util->get_stag($list['career']);?></span></div>
				<div class="list_etc3"><span><em>자격증</em><?=$re_info['license'];?></span></div>
			</a></li>
			<li class="col3">
				<div class="date_box date_box2 cf"> 
					<div class="con1 cf" style="margin-bottom:0">
					  <div>요청일</div>
						<div class="date-bx"><?=date("y.m.d", strtotime($row['wdate']));?></div>
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
	</div>
</section>
</form>

<div class="button_con button_con3">
	<a href="#" class="bottom_btn03" onClick="netfu_util1.delete_select_func(document.forms['flist'])">삭제</a>
</div>

<?php
include "../include/tail.php";
?>