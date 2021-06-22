<?php
include_once "./include/top.php";
?>


<?php
// : 플래티넘
$_banner = 'main_platinum';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service1.inc.php';




// : 그랜드
$_banner = 'main_grand';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service2.inc.php';





// : 스페셜
$_banner = 'main_special';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/service3.inc.php';



// : 포커스 인재정보
$_banner = 'main_focus';
include NFE_PATH.'/include/inc/banner.inc.php';
include NFE_PATH.'/include/inc/adver/resume_service1.inc.php';



// : 일반 구인정보
$_banner = 'main_job_list';
include NFE_PATH.'/include/inc/banner.inc.php';
$_page = 'page0';
include NFE_PATH.'/include/inc/adver/em_list.inc.php';
//include NFE_PATH.'/include/inc/adver/service4.inc.php';



// : 일반 인재정보
$_banner = 'main_indi_list_top';
include NFE_PATH.'/include/inc/banner.inc.php';
//include NFE_PATH.'/include/inc/adver/resume_service2.inc.php';
$var_page = 'page1';
include NFE_PATH.'/include/inc/adver/re_service2.inc.php';





$_banner = 'main_indi_list_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';
?>




<!-- 커뮤니티 -->
<?php
$board_main = sql_fetch("select * from `alice_board_main` where `no` = '1'");
$print_board = unserialize($board_main['print_main']);
$q = "select * from `alice_board` where 1 order by `b_rank` asc";
$bo_query = sql_query($q);
while($row=sql_fetch_array($bo_query)) {
	$first_row1 = sql_fetch("select * from alice_category where `code`='".$row['code']."'");
	$first_row2 = sql_fetch("select * from alice_category where `code`='".$first_row1['p_code']."'");
	$board = $netfu_util->get_boardTable($row['bo_table']); // 게시판 정보 (단수)
	$arr = $netfu_util->get_board($print_board, $row);
	if(!$arr) continue;// : 사용여부

	$_tit_img = $netfu_util->bo_title_img[$board['bo_skin']];
	$_tit_img = $netfu_util->icon_tit($_tit_img);

	//$_count = '<em>'.$netfu_util->start_slide_num($arr['paging_group']).'</em>/'.$arr['paging_group'].'건';
	$_count = '';
	?>
	<section class="cont_box <?=$arr['section_class'];?>">
		<h2><span class="tit_ico"><img src="images/<?=$_tit_img;?>.png" alt=""></span><?php echo stripslashes($row['bo_subject']);?><span class="bt_box"><?=$_count;?> <a href="<?=NFE_URL;?>/board/list.php?board_code=<?=$first_row2['code'];?>&code=<?=$row['code'];?>&bo_table=<?=$row['bo_table'];?>" class="more_bt">더보기<img src="images/chevron1.png" alt=""></a></span></h2>
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
		// li의ㅣ class ->  class="gold1",  class="gold2"
		switch($arr['query_total']<=0) {
			case true:
			?>
			<li>
				<div class="text_box2">
					<div class="title"><img src="images/info.png" alt="">Бүртгэлтэй мэдээлэл байхгүй байна.</div>
				</div>
			</li>
			<?php
			break;

		default:
			for($i=0; $i<$arr['query_total']; $i++) {
				$bo_row = sql_fetch_array($arr['query']);
				echo $i%$arr['box_num']==0 ? '<ul class="'.$arr['slide_class'].' cont_box_inner" style="width:100% !important;">'."\n" : '';
			?>
			<li style="width:<?=$arr['li_width'];?>%;">
			<?php
			include "./include/inc/board_box.".$arr['bo_type'].".inc.php";
			?>
			</li>
			<?php
				echo $i%$arr['box_num']==$arr['box_num']-1 ? '</ul>'."\n" : '';
			}
			break;
		}
		?>
		</div>
		<div class="paging_con cf"><div id="<?=$arr['slide_class'];?>_page" class="paging center"></div></div>
	</section>

	<?php
}



include "./include/tail.php";
?>