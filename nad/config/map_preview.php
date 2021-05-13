<?php
		/*
		* /application/nad/config/map_preview.php
		* @author Harimao
		* @since 2013/06/11
		* @last update 2013/06/12
		* @Module v3.5 ( Alice )
		* @Brief :: Map preview test
		* @Comment :: 설정된 지도 엔진 미리보기/테스트
		*/

		$alice_path = "../../../";

		$cat_path = "../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin();	// 관리자 체크

		## 기본 헤더
		$style_arr = array( 'nad' );
		$plugin_arr = array( 'cookie', 'form' );
		echo $config->_admin_header( '', $style_arr, '', $plugin_arr);		// body, css style, css media, plugin

		$map_control->get_map();

		$test_maps = array("'37.538779843072824','127.00200500605618'", "'37.538635699652154','127.00030778301571'", "'37.537338259427315','126.9998325645435'", "'37.53377026138633','127.00288736856231'", "'37.534941239454476','127.00920075758009'");
		$test_maps_count = count($test_maps);

?>
<script>
window.top.resizeTo(750,650);
</script>
<body>
	
	<div id="map" style="width:100%;height:100%;"></div>

<script>
var map_load = function(){
	map_api.map_use("map", "", false);
}

$(document).ready(function() {

	map_load();

	<?php for($i=0;$i<$test_maps_count;$i++){ ?>
		map_api.mapapi_point_is = [<?php echo $test_maps[$i];?>];
		map_api.onload_func_map_child('<?php echo $i;?>', 'http://localimg.daum-img.net/localimages/07/2009/map/icon/blog_icon01_on.png', 22, 25);
	<?php } ?>

});

</script>
</body>
</html>