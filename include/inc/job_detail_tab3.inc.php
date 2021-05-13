<?php
include_once NFE_PATH."/engine/netfu_map.class.php";
$netfu_map = new netfu_map();
echo $netfu_map->js_script;

$_wr_college_area = $netfu_util->get_cate($get_alba['wr_college_area']);
$wr_college_vicinity = $netfu_util->get_cate($get_alba['wr_college_vicinity']);

$use_map = $env['use_map'];	// 사용 지도 api
$daum_local_key = $env['daum_map_key'];	// 다음 지도 local 검색 key
$naver_map_key = $env['naver_map_key'];	// 네이버 지도 key

if(preg_replace("/,/", "", $get_alba['wr_area_point']) && !$get_alba['wr_area_company']) $mb_latlng = explode(",", $get_alba['wr_area_point']);
else $mb_latlng = explode(",", $com_member['mb_latlng']);
?>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/map/<?=$use_map;?>.js?time=<?=time();?>"></script>

<div class="tab-box tab3-box">
<table>
<tr>
	<th>근무지주소</th>
	<td><?=$wr_area;?></td>
</tr>
<tr>
	<th>인근지하철</th>
	<td>
		<?php
		if(is_array($subway_cate)) foreach($subway_cate as $k=>$v) {
			$subway_txt[] =  $v[0].' > <span class="subway">'.$v[1].'</span> '.$v[2].' '.$get_alba['wr_subway_content_'.$k];
		}
		echo @implode(", &nbsp; ", $subway_txt);
		?>
	</td>
</tr>
<tr>
	<th>인근대학</th>
	<td>
		<?php
		echo $_wr_college_area['name'].' '.$wr_college_vicinity['name'];
		?>
	</td>
</tr>
</table>


<div class="loc_map">
	<div id="location_map" style="width:100%;height:400px;"></div>
</div>

<input type="hidden" name="map_arr[]" value="<?=$mb_latlng[0];?>" />
<input type="hidden" name="map_arr[]" value="<?=$mb_latlng[1];?>" />
</div>