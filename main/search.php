<?php
include_once "../include/top.php";

$stx = preg_replace("/\//", "\/", trim($_GET['top_keyword']));
$text_stx = $utility->get_text(stripslashes($stx));
$search_control->search_result($text_stx, "realtime");	// 검색 결과 저장

$query = sql_query(" select * from alice_search where `wr_type` = 'realtime' order by `rank` asc limit 0, 10");

$job_where = $netfu_mjob->job_search_func();
$resume_where = $netfu_mjob->resume_search_func();

$view_count = 0;


$_banner = 'etc_search_top';
include NFE_PATH.'/include/inc/banner.inc.php';
?>
<script type="text/javascript">
var real_status = "block";
var real_status_img = {"block":"<?=NFE_URL;?>/images/rt_ico_up.png", "none":"<?=NFE_URL;?>/images/rt_ico_down.png"};
var real_open = function() {
	real_status = real_status=='block' ? "none" : "block";
	$(".realtime_box").css({"display":real_status});
	$(".realtime_con").find(".rt_btn").find("img").attr("src", real_status_img[real_status]);
}
</script>
<!-- 실시간 검색어 -->
<section class="cont_box realtime_con" >
  <h2>Хайх</h2>
	<?php
	$row = sql_fetch_array($query);
	?>
	<p class="realtimeKeyword">
	  <span>1</span><a href="<?=NFE_URL;?>/main/search.php?top_keyword=<?=$netfu_util->get_stag($row['wr_content']);?>"><?=$netfu_util->get_stag($row['wr_content']);?></a> 
	</p>
	<?php
	?>
	<div class="rt_btn">
	  <a href="#none" onClick="real_open()"><img src="<?=NFE_URL;?>/images/rt_ico_up.png" alt="Нээх"></a>
	</div>

<!-- 실시간 검색어 자세히 보기 -->
	<div class="realtime_box">
		<ul>
			<?php
			$nums = 1;
			while($row = sql_fetch_array($query)) {
				$nums++;
			?>
			<li>
				<p class="realtimeKeyword">
					<span><?=$nums;?></span><a href="<?=NFE_URL;?>/main/search.php?top_keyword=<?=$netfu_util->get_stag($row['wr_content']);?>"><?=$netfu_util->get_stag($row['wr_content']);?></a>
				</p>
			</li>
			<?php
			}
			?>
		</ul>
	</div>
</section>

<?php
// : 구인정보 검색결과
$title_txt = 'Ажлын байрны хайлтын үр дүн';
$more_view = true;
include NFE_PATH.'/include/inc/adver/em_list.inc.php';

// : 인재정보 검색결과
$var_page = 'page2';
$title_txt = 'Хүний нөөцийн мэдээллийн хайлтын үр дүн';
$more_view = true;
include NFE_PATH.'/include/inc/adver/re_service2.inc.php';


// : 게시판
include NFE_PATH.'/include/board_main.php';

// : 검색결과가 없는경우
if($view_count<=0) {
?>
<section class="cont_box cont_list recruit1" id="sch_result">
<img src="/images/info.png" alt="Хайлт олдсонгүй.">Хайлт олдсонгүй.
</section>
<?php
}
?>



<?php
$_banner = 'etc_search_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';


include_once(NFE_PATH.'/include/tail.php');
?>