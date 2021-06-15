<?php
$_GET['page'] = $_GET['page'] ? $_GET['page'] : 1;

// 검색시 사용
$section_class_txt = $netfu_util->bo_css_word[$board['bo_skin']];
$section_class_txt = $section_class_txt ? $section_class_txt : 'txt';
$section_class = 'community_'.$section_class_txt;
if($board['bo_skin']=='webzine') $section_class .= ' web_c';

// 게시판별 분류(카테고리)
$bo_category = $category_control->category_pcodeList('board',$board['bo_table']);
$use_category = true;

$page_rows = ($_GET['page_rows']) ? $_GET['page_rows'] : $board['bo_page_rows'];
$_add = $board_control->_Search();
$_table = 'alice_write_'.$_GET['bo_table'];

$q = $_table." where 1 ".$netfu_util->board_where;

if($_GET['search_field']=='wr_subject||wr_content') {
	$q .= " and (`wr_subject` like '%".addslashes($_GET['search_keyword'])."%' or `wr_content` like '%".addslashes($_GET['search_keyword'])."%')";
}else if($_GET['search_field']){
	$q .= " and `".addslashes($_GET['search_field'])."` like '%".addslashes($_GET['search_keyword'])."%'";
}

if($_GET['sca']) {
	$q .= " and `wr_category`='".addslashes($_GET['sca'])."'";
}

$start = (($_GET['page']?$_GET['page']:1)-1)*$page_rows;
$total = sql_fetch("select count(*) as c from ".$q);
$query = sql_query("select * from ".$q." order by ".$_add['order']." limit ".$start.", ".$page_rows);
$query_num = sql_num_rows($query);
$paging = $netfu_util->_paging_(array('var'=>'page', 'num'=>$page_rows, 'total'=>$total['c']));

/* 공지사항 리스트 */
$noti_list = array();
$i = 0;
$arr_notice = explode("\n", trim($board['bo_notice']));
$notice_cnt = count($arr_notice);
for($n=0;$n<$notice_cnt;$n++){
	if (trim($arr_notice[$n])=='') continue;
	// 공지사항 리스트
	$notices = $board_control->get_boardArticle( $bo_table, " where `wr_no` = '".$arr_notice[$n]."' order by `wr_no` desc ");
	if($notices == '') continue;
	$noti_list[$i] = $board_control->get_list( $notices, $board, $board_skin, $board['bo_subject_len'] );	
$i++;
}
/* //공지사항 리스트 */

?>

<!-- 커뮤니티 텍스트형 -->
<section class="cont_box <?=$section_class;?>">

	<?php
	if(strpos($_SERVER['PHP_SELF'], 'board/list.php')!==false) {
	?>
	<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$netfu_util->bo_title_img[$board['bo_skin']];?>.png" alt=""></span><?=$board['bo_subject'];?><span class="bt_box"><a href="./write.php?mode=insert&board_code=<?=$_GET['board_code'];?>&code=<?=$_GET['code'];?>&bo_table=<?=$_GET['bo_table'];?>" class="write_bt">글쓰기</a></span></h2>


	<!--  분류탭 -->
	<?php
	$bunru_href = $_SERVER['PHP_SELF'].'?board_code='.$board_code.'&code='.$code.'&bo_table='.$board['bo_table'].'&sca='.$v['code'];
	if(count($bo_category)>0) {
	?>
	<div class="sort_area cf">
		<div class="sort_tab cf">
			<ul>
				<li><a href="<?=$bunru_href.'&sca=';?>" class="active">전체</a></li>
				<?php
				if(is_array($bo_category)) { foreach($bo_category as $k=>$v) {
				?>
				<li><a href="<?=$bunru_href.'&sca='.$v['code'];?>" class="active"><?=$v['name'];?></a></li>
				<?php
				} }
				?>
			</ul>
		</div>
	</div>
	<?php }?>
	

<!-- 검색/분류 -->
	<form name="boardListFrm" method="GET" id="boardListFrm" action="<?=$_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="mode" value="search"/>
	<input type="hidden" name="board_code" value="<?=$_GET['board_code'];?>"/>
	<input type="hidden" name="code" value="<?=$_GET['code'];?>"/>
	<input type="hidden" name="bo_table" value="<?=$_GET['bo_table'];?>"/>
	<input type="hidden" name="sca" value="<?=$_GET['sca'];?>"/>
	<input type="hidden" name="sort" value="<?=$_GET['sca'];?>"/>
	<div class="sort_choice cf">
	  <ul class="sort_inner cf">
			<li class="sort_select">
				<select name="search_field">
					<option value="wr_subject" <?=$_GET['search_field']=='wr_subject' ? 'selected' : '';?>>Гарчиг</option>
					<option value="wr_content" <?=$_GET['search_field']=='wr_content' ? 'selected' : '';?>>Агуулга</option>
					<option value="wr_subject||wr_content" <?=$_GET['search_field']=='wr_subject||wr_content' ? 'selected' : '';?>>Гарчиг+Агуулга</option>
					<option value="wr_name" <?=$_GET['search_field']=='wr_name' ? 'selected' : '';?>>Бичсэн</option>
				</select>
			</li>
			<li class="sort_sch">
			  <input type="text" id="" name="search_keyword" value="<?=$_GET['search_keyword'];?>"><button type="button" onClick="document.forms['boardListFrm'].submit()">Хайх</button>
			</li>
			<li class="sort_bx">
				<select name="page_rows" onChange="netfu_util1.page_rows(this)">
					<option value='15' <?=$_GET['page_rows']==15 ? 'selected' : '';?>>15ш хэвлэх</option>
					<option value='30' <?=$_GET['page_rows']==30 ? 'selected' : '';?>>30ш хэвлэх</option>
					<option value='50' <?=$_GET['page_rows']==50 ? 'selected' : '';?>>50ш хэвлэх</option>
					<option value='70' <?=$_GET['page_rows']==70 ? 'selected' : '';?>>70ш хэвлэх</option>
					<option value='100' <?=$_GET['page_rows']==100 ? 'selected' : '';?>>100ш хэвлэх</option>
				</select>
			</li>
		</ul>
	</div>
	</form>
	<?php }?>

	<ul class="cont_box_inner">
	<?php
	switch($total['c']<=0) {
		case true:
			?>
			<li>
				<div class="text_box2">
					<div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">Бүртгэгдсэн мэдээлэл байхгүй байна.</div>
				</div>
			</li>
			<?php
			break;

		default:
			?>
			<ul class="cont_box_inner">
			<?php
			foreach($noti_list as $no_val){			
				if($board['bo_skin']=='default') {
					echo "<li id='notice_list'><div class='text_box'><div class='title'><a href='/board/detail.php?board_code=".$board_code."&code=".$code."&bo_table=".$_GET['bo_table']."&no=".$no_val['wr_no']."'><strong>공지</strong>".$no_val['wr_subject']."</a></div></div></li>";
				}else if($board['bo_skin']=='webzine'){
					echo "<li id='notice_webzine'><div class='text_box'><div class='title'><a href='/board/detail.php?board_code=".$board_code."&code=".$code."&bo_table=".$_GET['bo_table']."&no=".$no_val['wr_no']."'><strong>공지</strong>".$no_val['wr_subject']."</a></div></div></li>";
				}

			}

			$arr['box_num'] = in_array($board['bo_skin'], array('image')) ? 2 : 1;
			$arr['li_width'] = 100/$arr['box_num'];
			$i = 0;
			$row['bo_table'] = $_GET['bo_table'];
			$remain = $netfu_util->get_remain($total['c'], $arr['box_num']);
			while($bo_row=sql_fetch_array($query)) {

				$tmp_name = $utility->get_text($utility->str_cut($bo_row['wr_name'], $board['bo_cut_name'] * 2)); // 설정된 자리수 만큼만 이름 출력 (UTF-8로 계산하기 때문에 X 2)
				$get_member = $member_control->get_member($bo_row['wr_id']);

				// 0 : 닉네임, 1 : 아이디, 2 : 이름, 3 : 익명
				if($board['bo_use_name']=='0'){
					$bo_row['wr_name'] = $tmp_name;
				} else if($board['bo_use_name']=='1'){
					$bo_row['wr_name'] = $bo_row['wr_id'];
				} else if($board['bo_use_name']=='2'){
					$bo_row['wr_name'] = ($get_member['mb_name']) ? $get_member['mb_name'] : $tmp_name;
				} else if($board['bo_use_name']=='3'){
					$bo_row['wr_name'] = "нэргүй";
				}
			?>
				<li style="<?php if($board['bo_skin']=='image') {?>width:<?=$arr['li_width'];?>%;<?php }?>">
				<?php
				include "../include/inc/board_box.".$section_class_txt.".inc.php";
				?>
				</li>
				<?php
				$i++;
				if($query_num==$i && $board['bo_skin']=='image') echo str_repeat('<li style="width:'.$arr['li_width'].'%;"></li>', $remain);
			}
			?>
			</ul>
			<?php
			break;
	}
	?>
	<?=$paging;?>
</section>
<!-- //커뮤니티 텍스트형 -->