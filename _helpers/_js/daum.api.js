/*
* /application/_helpers/_js/daum.api.js
* @author Harimao
* @since 2013/06/11
* @last update 2013/07/30
* @Module v3.5 ( Alice )
* @Brief :: Daum map api
* @Comment :: 다음 지도맵 api 설정 자바스크립트 클래스 입니다.
* @Comment :: 넷케이(NET.K) 지도맵 스크립트 클래스 참고 허가를 받아 개발 되었습니다.
*/
var map_api = function( path ) {

	this.engine_name = 'daum_v3';

	this.map;
	this.map_point = new Array();
	this.apikey;
	this.map_address;		// : 주소1
	this.map_address2;	// : 주소2
	this.obj;
	this.base_url = path;
	this.zoom_val = '';
	this.window_content = {};		// : 마커 클릭하면 나오는 창
	this.marker = new Array();		// : 마커모음
	this.click_marker = new Array();		// : 클릭한 마커의 위치정보 - 0번째 : x좌표, 1번째 : y좌표, 2번째 : zoom값

	// : MapTypeId.HYBRID [ 스카이뷰 ], MapTypeId.ROADMAP [ 일반지도 ]
	this.maptype = "MapTypeId.ROADMAP"; // : 지도가 처음 보이는 기본값입니다.

	this.ajax_result = false;	// : ajax 실행했는지 확인하는 변수
	this.icon_size = [28, 37]; // : 아이콘 가로,세로 크기
	this.infowindowObj = new Object();	// : 마커누르면 나오는 메시지 객체모음


	this.map_use = function(obj, url, check) {
		this.basic_map(obj);
		if(check==true) this.click(url);
	}


	this.basic_map = function(id) {
		// ## : 맵 생성 기본작업
		// : 위치값
		var position = new daum.maps.LatLng(this.map_point[0], this.map_point[1]); 
		// : 맵 생성작업
		this.map = new daum.maps.Map(document.getElementById(id), { 
			center: position,
			level: this.map_point[2],
			mapTypeId: eval("daum.maps."+this.maptype)
		});
		// ## : 부가작업
		var zoomControl = new daum.maps.ZoomControl();
		this.map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);
		var mapTypeControl = new daum.maps.MapTypeControl();
		this.map.addControl(mapTypeControl, daum.maps.ControlPosition.TOPRIGHT);
	};


	this.detail_func_map_child = function(no, data_no, icon_url, width, height) {
		//var url = this.base_url+'/views/_include/company.sample.php';
		width = width ? width : this.icon_size[0];
		height = height ? height : this.icon_size[0];
		var file_size = [width, height];
		map_api.detail_marker_view(this.base_url+'/process/map.php', 'subject', this.mapapi_point_is[0], this.mapapi_point_is[1], icon_url, file_size, no, data_no);
	};

	this.detail_marker_view = function(action, mode, x, y, img_url, img_size, no, data_no) {

		// ### : 마커 표시하기
		// : 위치 설정하기
		var x = x ? x : this.map_point[0];
		var y = y ? y : this.map_point[1];
		//var z = this.map_point[2];

		// : 메시지
		var position = new daum.maps.LatLng(x, y);

		switch(img_url==null || !img_url) {
			case true:
				var marker = new daum.maps.Marker({
					position: position
				});
				marker.setMap(this.map); 
				break;
			default:
				//img_url = 'http://localimg.daum-img.net/localimages/07/2009/map/icon/blog_icon01_on.png';
				var icon = new daum.maps.MarkerImage(
					img_url,
					new daum.maps.Size(26, 32), // : 기준크기 : 31,35 [ 이 크기일때 중앙클릭시 정보가 정확히 나옵니다. ]
					new daum.maps.Point(16,34),
					"poly",
					"1,20,1,9,5,2,10,0,21,0,27,3,30,9,30,20,17,33,14,33"
				);

				var marker = new daum.maps.Marker({
					position: position,
					image: icon
				});
				marker.setMap(this.map); 
				break;
		}

		if(marker) {
			this.marker[this.marker.length] = marker;
			
			var infowindow = map_api.detail_window_url(marker, action, mode, no, data_no);

			/*
			daum.maps.event.addListener(marker, "click", function(MouseEvent) {
				var infowindow = map_api.detail_window_url(marker, action, no, data_no);
			});
			*/
		}

	}

	this.detail_window_url = function(marker, action, mode, no, data_no) {
		//$.getJSON(action, { mode:'company_info', ajax:'true', no:no }, function(data){
		$.post(action, { mode:mode, ajax:'true', no:no, data_no:data_no }, function(data){			
			var obj = $.parseJSON(data);
			var x = obj.x;
			var y = obj.y;
			var msg = obj.msg;
			map_api.infowindowObj[no] = new daum.maps.InfoWindow({
				content: msg,
				removable : false
			});
			map_api.infowindowObj[no].open(map_api.map, marker);

		});
	}

	this.search_func_map_child = function(no, data_no, icon_url, width, height) {
		//var url = this.base_url+'/views/_include/company.sample.php';
		width = width ? width : this.icon_size[0];
		height = height ? height : this.icon_size[0];
		var file_size = [width, height];
		map_api.search_marker_view(this.base_url+'/process/map.php', this.mapapi_point_is[0], this.mapapi_point_is[1], icon_url, file_size, no, data_no);
	};

	this.search_marker_view = function(action, x, y, img_url, img_size, no, data_no) {

		// ### : 마커 표시하기
		// : 위치 설정하기
		var x = x ? x : this.map_point[0];
		var y = y ? y : this.map_point[1];
		//var z = this.map_point[2];

		// : 메시지
		var position = new daum.maps.LatLng(x, y);

		switch(img_url==null || !img_url) {
			case true:
				var marker = new daum.maps.Marker({
					position: position
				});
				marker.setMap(this.map); 
				break;
			default:
				//img_url = 'http://localimg.daum-img.net/localimages/07/2009/map/icon/blog_icon01_on.png';
				var icon = new daum.maps.MarkerImage(
					img_url,
					new daum.maps.Size(26, 32), // : 기준크기 : 31,35 [ 이 크기일때 중앙클릭시 정보가 정확히 나옵니다. ]
					new daum.maps.Point(16,34),
					"poly",
					"1,20,1,9,5,2,10,0,21,0,27,3,30,9,30,20,17,33,14,33"
				);

				var marker = new daum.maps.Marker({
					position: position,
					image: icon
				});
				marker.setMap(this.map); 
				break;
		}

		if(marker) {
			this.marker[this.marker.length] = marker;
			daum.maps.event.addListener(marker, "click", function(MouseEvent) {
				var infowindow = map_api.search_window_url(marker, action, no, data_no);
			});
		}

	}

	this.search_window_url = function(marker, action, no, data_no) {
		//$.getJSON(action, { mode:'company_info', ajax:'true', no:no }, function(data){
		$.post(action, { mode:'daum', ajax:'true', no:no, data_no:data_no }, function(data){
			var obj = $.parseJSON(data);
			var x = obj.x;
			var y = obj.y;
			var msg = obj.msg;
			map_api.infowindowObj[no] = new daum.maps.InfoWindow({
				content: msg,
				removable : true
			});
			map_api.infowindowObj[no].open(map_api.map, marker);

		});
	}

	this.onload_func_map_child = function(no, icon_url, width, height) {
		//var url = this.base_url+'/views/_include/company.sample.php';
		width = width ? width : this.icon_size[0];
		height = height ? height : this.icon_size[0];
		var file_size = [width, height];
		map_api.marker_view(this.base_url+'/process/map.php', this.mapapi_point_is[0], this.mapapi_point_is[1], icon_url, file_size, no);
	};


	this.marker_view = function(action, x, y, img_url, img_size, no) {

		// ### : 마커 표시하기
		// : 위치 설정하기
		var x = x ? x : this.map_point[0];
		var y = y ? y : this.map_point[1];
		//var z = this.map_point[2];

		// : 메시지
		var position = new daum.maps.LatLng(x, y);

		switch(img_url==null || !img_url) {
			case true:
				var marker = new daum.maps.Marker({
					position: position
				});
				marker.setMap(this.map); 
				break;
			default:
				//img_url = 'http://localimg.daum-img.net/localimages/07/2009/map/icon/blog_icon01_on.png';
				var icon = new daum.maps.MarkerImage(
					img_url,
					new daum.maps.Size(26, 32), // : 기준크기 : 31,35 [ 이 크기일때 중앙클릭시 정보가 정확히 나옵니다. ]
					new daum.maps.Point(16,34),
					"poly",
					"1,20,1,9,5,2,10,0,21,0,27,3,30,9,30,20,17,33,14,33"
				);

				var marker = new daum.maps.Marker({
					position: position,
					image: icon
				});
				marker.setMap(this.map); 
				break;
		}

		if(marker) {
			this.marker[this.marker.length] = marker;
			daum.maps.event.addListener(marker, "click", function(MouseEvent) {
				var infowindow = map_api.marker_window_url(marker, action, no);
			});
		}

	}

	this.click = function(url) {
		daum.maps.event.addListener(this.map, "click", function(e) {
			var coordPoint = new daum.maps.Point(e.x, e.y);
			var zoom = map_api.map.getLevel();

			// : 마커표시취소
			map_api.marker_false();
			var x = e.latLng.getLat();
			var y = e.latLng.getLng();

			map_api.map_point = [x, y, zoom];
			/*
			map_api.obj[0].value = map_api.map_point[0];
			map_api.obj[1].value = map_api.map_point[1];
			map_api.obj[2].value = map_api.map_point[2];
			*/
			//map_api.marker_view(url);
		});
	}

	this.marker_false = function() {
		var len = this.marker.length;
		var count = 0;
		if(len>0) {
			do{
				this.marker[count].setMap(null); // : 모든 마커 취소.
				count++;
			}while(count<len);
		}

		/*
		// : input박스의 좌표값 초기화
		if(map_api.obj) map_api.obj[0].value = '';
		if(map_api.obj) map_api.obj[1].value = '';
		if(map_api.obj) map_api.obj[2].value = '';
		*/
	}

	this.marker_window_url = function(marker, action, no) {		
		//$.getJSON(action, { mode:'company_info', ajax:'true', no:no }, function(data){
		$.post(action, { mode:'company_info', ajax:'true', no:no }, function(data){
			var obj = $.parseJSON(data);
			var x = obj.x;
			var y = obj.y;
			var zoom = obj.zoom;
			var msg = obj.msg;
			map_api.click_marker = [x, y, zoom];
			return map_api.infowindow_func(marker, msg, no);
		});
	}


	this.infowindow_func = function(marker, msg, no) {
		map_api.infowindowObj[no] = new daum.maps.InfoWindow({
			content: msg,
			removable : true
		});
		map_api.infowindowObj[no].open(map_api.map, marker);
	}


	this.map_location_move = function(x, y, z) {
		x = (x) ? x : this.click_marker[0];
		y = (y) ? y : this.click_marker[1];		
		z = (z) ? z : 3;
		var point = new daum.maps.LatLng(x, y);
		this.map.setCenter(point);
		this.map.setLevel(z);
	}

	this.register_map_location_move = function(x, y, z, target) {	// 기업회원 가입시 회사위치 지정
		x = (x) ? x : this.click_marker[0];
		y = (y) ? y : this.click_marker[1];		
		var point = new daum.maps.LatLng(x, y);
		var register_map = this.map;

		register_map.setCenter(point);
		register_map.setLevel(3);

		var marker = new daum.maps.Marker({
			position: new daum.maps.LatLng(x, y)
		});

		marker.setMap(register_map); 

		$('#mb_latlng').val(x+","+y);
		if(target){
			$('#'+target).val(x+","+y);
		}

		daum.maps.event.addListener(this.map, "click", function(MouseEvent){
			var latLng = MouseEvent.latLng; 
			var latitude = latLng.getLat(); 
			var longitude = latLng.getLng(); 
			
			if(marker != null) 
				marker.setVisible(false); 

			marker = new daum.maps.Marker({
				position: new daum.maps.LatLng(latitude, longitude)
			});

			marker.setMap(register_map); 

			$('#mb_latlng').val(latitude+","+longitude);
			if(target){
				$('#'+target).val(latitude+","+longitude);
			}

		});

	}

}