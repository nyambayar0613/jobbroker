<style>
#touchGuideBox{width:130px !important}
</style>
<div style="position:relative;">
<div id="post_layer" style="display:none;position:relative;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;z-index:2;height:400px">
<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:9" onclick="closeDaumPostcode()" alt="닫기 버튼">
<?php
if($map_use===true) {
?>
<style>
.post__{border:1px solid #343a41;padding:0px 8px;margin-right:8px !important;height:24px;line-height:24px;margin-top:4px;color:#fff;background:#343a41;font-size:11px}
</style>
<div id="address_map_div" style="width:100%;left:0px;top:0px;position:absolute;height:400px;z-index:0;background-color:#fff;padding:0 10px;">
	<div style="height:34px;line-height:33px;">회사위치(약도) - 클릭시 위치가 지정됩니다.</div>
	<div id="address_map" style="width:100%;height:330px;border:1px solid #000;"></div>
	<div style="height:34px;line-height:33px;">
		<span class="pst_bt pst_bt1 post__" style="cursor:pointer;" onclick="change_map_view('none')">확인</span>
		<span class="pst_bt pst_bt2 post__" style="cursor:pointer;" onclick="change_map_view('post')">우편번호찾기로 변경</span>
		<?/*<span style="cursor:pointer;" onclick="change_map_view('none')">닫기</span>*/?>
	</div>
</div>
<?php }?>
</div>
</div>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
var use_map = "<?=$map_use;?>";
var element_layer = document.getElementById('post_layer');

function closeDaumPostcode() {
	// iframe을 넣은 element를 안보이게 한다.
	element_layer.style.display = 'none';
}

function change_map_view(code) {
	switch(code) {
		case "post":
			post_click();
			break;

		case "none":
			element_layer.style.display = 'none';
			$("[name='mb_address1']")[0].focus();
			break;

		case "map":
			$("#post_layer").css({"z-index":2});
			$("#address_map_div").css({"z-index":3});
			break;
	}
}

function post_click(addressObj) {
	if(use_map) {
		$("#post_layer").css({"z-index":3});
		$("#address_map_div").css({"z-index":0});
	}

	new daum.Postcode({
		oncomplete: function(data) {
			// 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

			// 각 주소의 노출 규칙에 따라 주소를 조합한다.
			// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
			var fullAddr = data.address; // 최종 주소 변수
			var extraAddr = ''; // 조합형 주소 변수

			// 기본 주소가 도로명 타입일때 조합한다.
			if(data.addressType === 'R'){
				//법정동명이 있을 경우 추가한다.
				if(data.bname !== ''){
					extraAddr += data.bname;
				}
				// 건물명이 있을 경우 추가한다.
				if(data.buildingName !== ''){
					extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
				}
				// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
				var fullAddr2 = (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
			}

			// 우편번호와 주소 정보를 해당 필드에 넣는다.
			if(document.getElementById('mb_doro_post'))
				document.getElementById('mb_doro_post').value = data.zonecode; //5자리 새우편번호 사용

			if(document.getElementById('mb_address0'))
				document.getElementById('mb_address0').value = fullAddr;
			//document.getElementById('sample2_addressEnglish').value = data.addressEnglish;

			// iframe을 넣은 element를 안보이게 한다.
			// (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)

			// : 지도를 사용한경우
			if(use_map) {
				change_map_view('map');
				address_map_func(fullAddr);
				if(addressObj) {
					addressObj.value = fullAddr+fullAddr2;
					addressObj.focus();
				}
			} else {
				element_layer.style.display = 'none';
			}
		},
		width : '100%',
		height : '100%',
		maxSuggestItems : 5
	}).embed(element_layer);

	// iframe을 넣은 element를 보이게 한다.
	element_layer.style.display = 'block';
	//daum_map.map.relayout();

	// iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
	initLayerPosition();
	return false;
}



var address_map_func = function(fullAddr) {
	var geocoder = new daum.maps.services.Geocoder();

	// 주소로 좌표를 검색합니다
	geocoder.addressSearch(fullAddr, function(result, status) {
		daum_map.setMarkers(null);
		// 정상적으로 검색이 완료됐으면 
		 if (status === daum.maps.services.Status.OK) {

			var coords = new daum.maps.LatLng(result[0].y, result[0].x);
			if(form) {
				daum_map.input_latlng(form, result[0].y, result[0].x);
			}

			// 결과값으로 받은 위치를 마커로 표시합니다
			daum_map.markers[0] = new daum.maps.Marker({
				map: daum_map.map,
				position: coords
			});
			daum_map.markers[0].setMap(daum_map.map);
			daum_map.map.setLevel(3);
			daum_map.map.relayout();

			// 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
			setTimeout(function(){
				daum_map.map.setCenter(coords);
			},1);
		} 
	});
}



// 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
// resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
// 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
function initLayerPosition(){
	var borderWidth = 2; //샘플에서 사용하는 border의 두께

	// 위에서 선언한 값들을 실제 element에 넣는다.
	//element_layer.style.width = width + 'px';
	element_layer.style.border = borderWidth + 'px solid';
	// 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
	//element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
	//element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
}
</script>