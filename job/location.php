<?php
$head_title = "Байршилаар хайх";
include_once "../include/top.php";
include_once NFE_PATH."/engine/netfu_map.class.php";
$netfu_map = new netfu_map();

echo $netfu_map->js_script;

$use_map = $env['use_map'];	// 사용 지도 api
$daum_local_key = $env['daum_map_key'];	// 다음 지도 local 검색 key
$naver_map_key = $env['naver_map_key'];	// 네이버 지도 key
?>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/map/<?=$use_map;?>.js?time=<?=time();?>"></script>

<?php
$_banner = 'etc_map_top';
include NFE_PATH.'/include/inc/banner.inc.php';
?>
<form name="fmap" onSubmit="return search_map()">
<section class="location_con">
	<div class="location_map">
		<div class="location_inner" id="location_map"></div>
		<div class="map_search">
			<span><input type="image" src="<?=NFE_URL;?>/images/search_icon2.png" alt="Хайх" placeholder=""></span>
			<input type="text" name="m_keyword" value="<?=$_GET['m_keyword'];?>">
		</div>
	  <!--div class="location_inner">
			<div class="spot spot1"><div class="sp_num">122</div><div class="sp_name">북창동</div></div>
			<div class="spot spot2"><div class="sp_num">122</div><div class="sp_name">북창동</div></div>
		  
		</div-->
	</div>
</section>
</form>
<div id="asdfasdf"></div>
<script type="text/javascript">
</script>


<!-- 일반형 -->
<section class="cont_box cont_list recruit1">
	<h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>Ажлын байрны сул орон тоо<span class="bt_box"><a href="#"><span class="btn">Зар сурталчилгааны мэдээлэл<img src="/images/chevron.png" alt="Зар сурталчилгааны мэдээлэл"></span></a></span></h2>
	<div class="">
		<ul class="list_box cont_box_inner map_job_list" style="width:100% !important;"></ul>
	</div>
	<div class="paging_con cf"><div id="list_con-page" class="paging center"><?=$paging;?></div></div>
</section>
<!-- //일반형 -->


<?php
$_banner = 'etc_map_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';
?>

<script type="text/javascript">
var map_lo = [];

// : watchPosition, getCurrentPosition
navigator.geolocation.getCurrentPosition(function(pos) {
	var _lat = pos.coords.latitude;
	var _lng = pos.coords.longitude;
	daum_map.map_basic('location_map', _lat, _lng);
	daum_map.load_pos(_lat, _lng, 'daum_map.map_list(lat, lng)');
}, function() {
	daum_map.map_basic('location_map');
	daum_map.load_area('110, Sejong-daero, Jung-gu, Seoul', 'daum_map.map_list(result[0].y, result[0].x)');
});

var search_map = function() {
	var keyword = $("[name='m_keyword']").val();
	daum_map.setMarkers(null);
	daum_map.map_list(daum_map.map_location[0], daum_map.map_location[1], keyword);
	return false;
}

$(window).ready(function(){
	setTimeout(function(){
		if(!daum_map.load_map) {
			daum_map.map_basic('location_map');
			daum_map.load_area('110, Sejong-daero, Jung-gu, Seoul', 'daum_map.map_list(result[0].y, result[0].x)');
		}
	},100);
});
</script>

<?php
include "../include/tail.php";
?>