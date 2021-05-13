var daum_map = function() {

	this.map;
	this.markers = new Array();
	this.map_location = [];
	this.load_map = false;

	this.map_basic = function(id, lat, lng, zoom) {
		var mapContainer = document.getElementById(id);
		lat = lat ? lat : '33.450701';
		lng = lng ? lng : '126.570667';
		zoom = zoom ? zoom : 4;
		// 지도를 표시할 div 
		var mapOption = { 
			center: new daum.maps.LatLng(lat, lng), // 지도의 중심좌표
			level: zoom // 지도의 확대 레벨
		};

		// 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
		daum_map.map = new daum.maps.Map(mapContainer, mapOption);
		daum_map.map.relayout();
	}



	this.load_area = function(area, func) {

		// 주소-좌표 변환 객체를 생성합니다
		var geocoder = new daum.maps.services.Geocoder();

		// 주소로 좌표를 검색합니다
		geocoder.addressSearch(area, function(result, status) {
			// 정상적으로 검색이 완료됐으면 
			 if (status === daum.maps.services.Status.OK) {
				 daum_map.load_map = true;

				daum_map.map_location = [result[0].y, result[0].x];
				var coords = new daum.maps.LatLng(result[0].y, result[0].x);

				// 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
				daum_map.map.setCenter(coords);

				if(func) eval(func);
			} 
		}); 
	}

	this.load_pos = function(lat, lng, func) {
		daum_map.load_map = true;
		daum_map.map_location = [lat, lng];
		if(func) eval(func);
	}

	this.setMarkers = function(map) {
		for (var i = 0; i < daum_map.markers.length; i++) {
			daum_map.markers[i].setMap(map);
		}
	}


	this.input_latlng = function(form, lat, lng) {
		$(form).find("[name='map_latlng[]']").eq(0).val(lat);
		$(form).find("[name='map_latlng[]']").eq(1).val(lng);
	}


	this.map_click = function(form) {

		// 지도에 클릭 이벤트를 등록합니다
		// 지도를 클릭하면 마지막 파라미터로 넘어온 함수를 호출합니다
		daum.maps.event.addListener(daum_map.map, 'click', function(mouseEvent) {

			daum_map.setMarkers(null);
			// 클릭한 위도, 경도 정보를 가져옵니다 
			var latlng = mouseEvent.latLng;

			var coords = new daum.maps.LatLng(latlng.getLat(), latlng.getLng());
			if(form) {
				daum_map.input_latlng(form, latlng.getLat(), latlng.getLng());
			}

			// 결과값으로 받은 위치를 마커로 표시합니다
			daum_map.markers[0] = new daum.maps.Marker({
				map: daum_map.map,
				position: coords
			});

			daum_map.markers[0].setMap(daum_map.map);
		});
	}


	this.set_markers = function(lat, lng) {
		var latlng = new daum.maps.LatLng(lat, lng);
		daum_map.markers[0] = new daum.maps.Marker({
			position: latlng
		});
		daum_map.markers[0].setMap(daum_map.map);
	}


	this.map_list = function(lat, lng, keyword) {
		var _get = location.href.split("?");
		keyword = keyword ? keyword : '';

		var geocoder = new daum.maps.services.Geocoder();
		daum_map.load_area(keyword);

		$.post(base_url+"/regist.php", _get[1]+"&mode=map_job_list&lat="+lat+"&lng="+lng+"&keyword="+encodeURIComponent(keyword), function(data){

			data = $.parseJSON(data);

			var len = data.latlng.length;
			daum_map.markers = new Array();

			for (var i = 0; i < len; i++) {
				// 마커를 생성합니다
				daum_map.markers[i] = new daum.maps.Marker({
					position: new daum.maps.LatLng(data.latlng[i].lat, data.latlng[i].lng)
				});

				daum_map.markers[i].setMap(daum_map.map);
			}
			$(".map_job_list").html(data.tag);
			$("#list_con-page").html(data.paging);
		});
	}
}

var daum_map = new daum_map();