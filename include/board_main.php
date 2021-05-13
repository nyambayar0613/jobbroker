<?php
// : 커뮤니티
if($_GET['code']) $_where = " and `code`='".addslashes($_GET['code'])."'";
$q = "select * from `alice_board` where 1 ".$_where." order by `b_rank` asc";
$bo_query = sql_query($q);

$_list_not_view = true;
$page_type = 'list';
if(strpos($_SERVER['PHP_SELF'], 'main/search.php')!==false) {
	$_list_not_view = false;
	$page_type = 'search';
}

while($row=sql_fetch_array($bo_query)) {
	$first_row1 = sql_fetch("select * from alice_category where `code`='".$row['code']."'");
	$first_row2 = sql_fetch("select * from alice_category where `code`='".$first_row1['p_code']."'");
	$board = $netfu_util->get_boardTable($row['bo_table']); // 게시판 정보 (단수)
	$arr = $netfu_util->get_board($print_board, $row);

	// : 검색페이지에서는 결과가 없으면 출력하지 않습니다.
	if($arr['query_total']<=0 && !$_list_not_view) continue;
	if(!$arr) continue;

	$view_count++;

	$code = $row['code'];

	$_tit_img = $netfu_util->bo_title_img[$board['bo_skin']];
	$_tit_img = $netfu_util->icon_tit($_tit_img);
	?>
	<section class="cont_box <?=$arr['section_class'];?>">
		<h2><span class="tit_ico"><img src="<?=NFE_URL;?>/images/<?=$_tit_img;?>.png" alt=""></span><?php echo stripslashes($row['bo_subject']);?><span class="bt_box"><?php /*if($page_type!='search') {?><em><?=$netfu_util->start_slide_num($arr['paging_group']);?></em>/<?=$arr['paging_group'];?>건<?php }*/?> <a href="<?=NFE_URL;?>/board/list.php?board_code=<?=$first_row2['code'];?>&code=<?=$row['code'];?>&bo_table=<?=$row['bo_table'];?>" class="more_bt">더보기<img src="<?=NFE_URL;?>/images/chevron1.png" alt=""></a></span></h2>
		<?
		// : 슬라이드용
		/*
		<div class="cycle-slideshow" 
		data-cycle-pause-on-hover="true"
		data-cycle-slides="ul.<?=$arr['slide_class'];?>"
		data-cycle-swipe=true
		data-cycle-timeout=0
		data-cycle-swipe-fx=scrollHorz
		data-cycle-pager="#<?=$arr['slide_class'];?>_page"
		data-cycle-pager-template="<a> {{slideNum}} </a>"
		>
		<?php
		*/

		// li의ㅣ class ->  class="gold1",  class="gold2"
		switch($arr['query_total']<=0) {
			case true:
			?>
			<li>
				<div class="text_box2">
					<div class="title"><img src="<?=NFE_URL;?>/images/info.png" alt="">등록된 내용이 없습니다.</div>
				</div>
			</li>
			<?php
			break;

		default:
			for($i=0; $i<$arr['query_total']; $i++) {
				$bo_row = sql_fetch_array($arr['query']);
				echo $i%$arr['box_num']==0 ? '<ul class="'.$arr['slide_class'].' cont_box_inner" style="width:100% !important;">'."\n" : '';

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
					$bo_row['wr_name'] = "익명";
				}
			?>
			<li style="width:<?=$arr['li_width'];?>%;">
			<?php
			include NFE_PATH."/include/inc/board_box.".$arr['bo_type'].".inc.php";
			?>
			</li>
			<?php
				echo $i%$arr['box_num']==$arr['box_num']-1 ? '</ul>'."\n" : '';
			}
			break;
		}
		/*
		// : 슬라이드용
		?>
		</div>
		<?php
		*/



		/*
		// : 슬라이드용 페이징
		if($page_type=='list') {
		?>
		<div class="paging_con cf"><div id="<?=$arr['slide_class'];?>_page" class="paging center"></div></div>
		<?php }
		*/
		
		if($page_type=='search') {
		?>
		<div class="list_box cont_box_inner" style="display:inline-block;width:100%;">
			<div class="text_box2">
				<div class="title" id="sch_result_more"><a href="<?=NFE_URL;?>/board/list.php?board_code=<?=$board_code;?>&code=<?=$code;?>&bo_table=<?=$row['bo_table'];?>&search_field=wr_subject||wr_content&search_keyword=<?=urlencode($_GET['top_keyword']);?>"><em><?=stripslashes($row['bo_subject']);?> 검색결과 더보기</em></a></div>
			</div>
		</div>
		<?php }?>

	</section>
	<?php
}
?>