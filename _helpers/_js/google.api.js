/*
* /application/_helpers/_js/google.api.js
* @author Harimao
* @since 2013/06/11
* @last update 2013/07/05
* @Module v3.5 ( Alice )
* @Brief :: Naver map api
* @Comment :: 구글 지도맵 api 설정 자바스크립트 클래스 입니다.
* @Comment :: 넷케이(NET.K) 지도맵 스크립트 클래스 참고 허가를 받아 개발 되었습니다.
*/
var map_api = function( path ) {

	this.map;
	this.geocoder;
	this.infowindow;
	this.map_point = new Array(); // : 지도불러오기 전에 좌표 선언하기 - 선언하지 않으면 기본좌표값이 나옵니다.
	this.apikey;
	this.map_body; // : 맵 바디
	this.map_address; // : 주소1
	this.map_address2; // : 주소2
	this.obj;
	this.base_url = path;
	this.zoom_val = '';
	this.window_content = {}; // : 마커 클릭하면 나오는 창
	this.marker = new Array(); // : 마커모음
	this.oIcon = '';
	this.mapInfoTestWindow = '';
	this.oLabel = '';
	this.oPoint = '';

	this.autocomplete;

	this.map_address_find = false; // : 지도클릭시 좌표의 주소기능 [ 업체 우편번호찾기에서 사용합니다. ]

	this.click_marker = new Array(); // : 클릭한 마커의 위치정보 - 0번째 : x좌표, 1번째 : y좌표, 2번째 : zoom값
	this.marker_arr = ''; // : 클릭했던 마커위치값입니다. [ 배열로 되있습니다. ]
	this.mapapi_point_is = new Array(); // : 위치선언값. - 지도로보는딜에 사용
	this.icon_size = [28, 37]; // : 아이콘 가로,세로 크기

	// : MapTypeId.HYBRID [ 스카이뷰 ], MapTypeId.ROADMAP [ 일반지도 ]
	this.maptype = "MapTypeId.ROADMAP"; // : 지도가 처음 보이는 기본값입니다.

	// : ajax 실행했는지 확인하는 변수
	this.ajax_result = false;


	this.map_use = function(id, url, check) {

		this.basic_map(id);
	}

	// : 지도를 불러오는 기본 함수
	this.basic_map = function(id) {

		var x_int = this.map_point[0] ? this.map_point[0] : -25.96425222254128;
		var y_int = this.map_point[1] ? this.map_point[1] : 135.43001269228512;

		var zoom_int = parseInt(this.map_point[2]) ? parseInt(this.map_point[2]) : 8;

		this.geocoder = new google.maps.Geocoder();
		this.infowindow = new google.maps.InfoWindow();


		var myLatlng = new google.maps.LatLng(x_int, y_int);
		var myOptions = {
			zoom: zoom_int,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		this.map = new google.maps.Map(document.getElementById(id), myOptions);
		this.input_search_func();
	};


	// : 주소입력
	this.input_search_func = function() {
		var input = document.getElementById('fregist_address_detail');
		if(input) {
			this.autocomplete = new google.maps.places.Autocomplete(input);
			this.autocomplete.bindTo('bounds', this.map);
			this.input_search_move();
		}
	}


	// : 주소입력후 검색시 이동시키기
	this.input_search_move = function() {
		google.maps.event.addListener(this.autocomplete, 'place_changed', function() {
			//infowindow.close();
			var place = map_api.autocomplete.getPlace();
			
			if (place.geometry.viewport) {
				map_api.map.fitBounds(place.geometry.viewport);
			} else {
				map_api.map.setCenter(place.geometry.location);
				map_api.map.setZoom(17);  // Why 17? Because it looks good.
			}
			var image = new google.maps.MarkerImage(
				place.icon, new google.maps.Size(71, 71),
				new google.maps.Point(0, 0), new google.maps.Point(17, 34),
				new google.maps.Size(35, 35)
			);
			//marker.setIcon(image);
			//marker.setPosition(place.geometry.location);

			var address = '';
			if (place.address_components) {
				address = [
				(place.address_components[0] &&
				place.address_components[0].short_name || ''),
				(place.address_components[1] &&
				place.address_components[1].short_name || ''),
				(place.address_components[2] &&
				place.address_components[2].short_name || '')].join(' ');
			}
			/*

			infowindow.setContent('<div><b>' + place.name + '</b><br>' + address);
			infowindow.open(map, marker);
			*/
		});

	}


	// : 지도로 보는 딜 아이콘 표시
	this.onload_func_map_child = function(no, icon_url, width, height) {
		//var url = this.base_url+'/views/_include/company.sample.php';
		this.icon_size = [width, height];
		var image = this.icon_func(icon_url);
		var location = new google.maps.LatLng(this.mapapi_point_is[0], this.mapapi_point_is[1]);
		var marker = this.addMark(location, image);
		this.marker_view(no, marker);
	};

	this.detail_func_map_child = function(no, data_no, icon_url, width, height) {
		//var url = this.base_url+'/views/_include/company.sample.php';
		this.icon_size = [width, height];
		var image = this.icon_func(icon_url);
		var location = new google.maps.LatLng(this.mapapi_point_is[0], this.mapapi_point_is[1]);
		var marker = this.addMark(location, image);
		this.detail_marker_view(no, 'subject', marker, data_no );
	};

	this.detail_marker_view = function(no, mode, marker, data_no ) {
		$.post(this.base_url+'/process/map.php', { mode:mode, ajax:'true', no:no, data_no:data_no }, function(data){
			var obj = $.parseJSON(data);
			var msg = obj.msg;
			if(msg) {
				var infowindow = new google.maps.InfoWindow({
					content: msg
				});
				infowindow.open(map_api.map,marker);
			}
		});
	};

	this.search_func_map_child = function(no, data_no, icon_url, width, height) {
		this.icon_size = [width, height];
		var image = this.icon_func(icon_url);
		var location = new google.maps.LatLng(this.mapapi_point_is[0], this.mapapi_point_is[1]);
		var marker = this.addMark(location, image);
		this.search_marker_view(no, data_no, marker);
	};

	this.search_marker_view = function( no, data_no, marker ) {
		$.post(this.base_url+'/process/map.php', { mode:'google', ajax:'true', no:no, data_no:data_no }, function(data){
			var obj = $.parseJSON(data);
			var x = obj.x;
			var y = obj.y;
			var msg = obj.msg;
			if(msg) {
				var infowindow = new google.maps.InfoWindow({
					content: msg
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map_api.map,marker);
				});
			}
		});
	};


	this.icon_func = function(icon_url) {
		var image = new google.maps.MarkerImage(icon_url,
			// This marker is 20 pixels wide by 32 pixels tall.
			new google.maps.Size(this.icon_size[0], this.icon_size[1]),
			// The origin for this image is 0,0.
			new google.maps.Point(0,0),
			// The anchor for this image is the base of the flagpole at 0,32.
			new google.maps.Point(0, 32)
		);
		return image;
	}

	// 마커 취소 [ 모든 마커가 취소됩니다. ] - key안에 마커관련 obj값을 넣으면 해당 마커만 삭제됩니다.
	this.marker_false = function(key) {
		var len = this.marker.length;
		for (i in this.marker) {
			if(i>=0) {
				this.marker[i].setMap(null);
			}
		}
		this.marker.length = 0;
		/*
		// : input박스의 좌표값 초기화
		map_api.obj[0].value = '';
		map_api.obj[1].value = '';
		map_api.obj[2].value = '';
		*/
	};


	// 클릭 이벤트
	// type -> 값이 없으면 마커 모두 취소하기
	this.click_event = function(type, no, x, y, target) {
		google.maps.event.addListener(this.map, 'click', function(event) {
			map_api.marker_false();
			map_api.oPoint = event.latLng;
			//alert(event.latLng);
			map_api.addMark(event.latLng);
			if(map_api.map_address_find===true) map_api.map_click_address(event.latLng);
			if(!type) map_api.click2_event( target );
		});
	};

	// 클릭2 - 마커표시합니다.
	this.click2_event = function( target ) {
		map_api._oPoint(map_api.oPoint);
		// : input박스의 좌표값
		map_api.map_put(map_api.marker_arr[0], map_api.marker_arr[1], map_api.map.getZoom(), target);
	}

	// 마커 표시하기
	this.addMark = function(location, image) {
		if(!location && map_api.map_point[0]) {
			var location = new google.maps.LatLng(map_api.map_point[0], map_api.map_point[1]);
		}
		marker = new google.maps.Marker({
			position: location,
			map: this.map,
			icon: image
		});
		this.marker.push(marker);
		return marker;
	};
	// 좌표값 구하기
	this._oPoint = function(oPoint) {
		var point_val = oPoint.toString();
		map_api.marker_arr = point_val.split(",");
		marker_arr_0 = map_api.marker_arr[0].split("(");
		marker_arr_1 = map_api.marker_arr[1].split(")");
		map_api.marker_arr[0] = trim(marker_arr_0[1]);
		map_api.marker_arr[1] = trim(marker_arr_1[0]);
	};
	
	// 클릭 좌표 놓기 - 검색시 좌표가 있는 정보를 자동으로 지도좌표값으로 놓을때
	this.map_put = function(x, y, z, target) {
		map_api.map_point = [x, y, z];

		if( $('#mb_latlng').length ){
			$('#mb_latlng').val(x+","+y);
		}
		if( $('#wr_area_point').length ){
			$('#wr_area_point').val(x+","+y);
		}
		if(target){
			$('#'+target).val(x+","+y);
		}

		/*
		map_api.obj[0].value = map_api.map_point[0];
		map_api.obj[1].value = map_api.map_point[1];
		map_api.obj[2].value = map_api.map_point[2];
		*/
	};

	// : 메시지 보기 함수 - ajax
	this.marker_view = function(no, marker) {
		$.post(this.base_url+'/process/map.php', { mode:'company_info', ajax:'true', no:no }, function(data){
			var obj = $.parseJSON(data);
			var msg = obj.msg;
			if(msg) {
				var infowindow = new google.maps.InfoWindow({
					content: msg
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map_api.map,marker);
				});
			}
		});
	};

}