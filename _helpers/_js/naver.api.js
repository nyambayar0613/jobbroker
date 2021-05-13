/*
* /application/_helpers/_js/daum.api.js
* @author Harimao
* @since 2013/06/11
* @last update 2013/07/04
* @Module v3.5 ( Alice )
* @Brief :: Naver map api
* @Comment :: 네이버 지도맵 api 설정 자바스크립트 클래스 입니다.
* @Comment :: 넷케이(NET.K) 지도맵 스크립트 클래스 참고 허가를 받아 개발 되었습니다.
*/
var map_api = function( path ) {

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
	this.oIcon = '';
	this.mapInfoTestWindow = '';
	this.oLabel = '';
	this.oPoint = '';
	this.click_marker = new Array();		// : 클릭한 마커의 위치정보 - 0번째 : x좌표, 1번째 : y좌표, 2번째 : zoom값

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


	this.basic_map = function(id) {

		var x_int = this.map_point[0] ? this.map_point[0] : 37.5010226;
		var y_int = this.map_point[1] ? this.map_point[1] : 127.0396037;
		var zoom_int = this.map_point[2] ? this.map_point[2] : 11;
		var oCenterPoint = new nhn.api.map.LatLng(x_int, y_int);
		var divObj = document.getElementById(id);
		nhn.api.map.setDefaultPoint('LatLng');
		this.oMap = new nhn.api.map.Map(id, {
			point : oCenterPoint,
			zoom : zoom_int, // - 초기 줌 레벨은 10으로 둔다.
			enableWheelZoom : true,
			enableDragPan : true,
			enableDblClickZoom : false,
			mapMode : 0,
			activateTrafficMap : false,
			activateBicycleMap : false,
			minMaxLevel : [ 1, 14 ]
		});
		var markerCount = 0;

		this.icon_func();

		this.mapInfoTestWindow = new nhn.api.map.InfoWindow(); // - info window 생성
		this.mapInfoTestWindow.setVisible(false); // - infowindow 표시 여부 지정.
		map_api.oMap.addOverlay(this.mapInfoTestWindow); // - 지도에 추가.

		this.oLabel = new nhn.api.map.MarkerLabel(); // - 마커 라벨 선언.
		this.oMap.addOverlay(this.oLabel); // - 마커 라벨 지도에 추가. 기본은 라벨이 보이지 않는 상태로 추가됨.

		// : 여기서 사용안할 것들은 주석처리하면 됩니다.
		this.zoom_form(); // : 줌인/줌아웃
		this.maptype_btn(); // : 맵종류 [ 일반/위성 ]
		//this.otheme_btn(); // : 주제별 지도
		//this.obicycle_func(); // : 자전거범례
		//this.otraffic_func(); // : 교통범례
		//this.trafficbutton_func(); // : 실시간 교통정보
	};

	this.icon_func = function(icon_url) {
		var oSize = new nhn.api.map.Size(this.icon_size[0], this.icon_size[1]);
		var oOffset = new nhn.api.map.Size(this.icon_size[0], this.icon_size[1]);
		var url_value = icon_url ? icon_url : 'http://static.naver.com/maps2/icons/pin_spot2.png';
		this.oIcon = new nhn.api.map.Icon(url_value, oSize, oOffset); // : 마커 아이콘
	}


	// : 마커 취소 [ 모든 마커가 취소됩니다. ] - key안에 마커관련 obj값을 넣으면 해당 마커만 삭제됩니다.
	this.marker_false = function(key) {
		var len = this.marker.length;
		for(var i=0; i<len; i++) {
			switch(!key) {
				case true:
					this.oMap.removeOverlay(this.marker[i]);
					break;
				default:
					if(this.marker[i]==key) this.oMap.removeOverlay(this.marker[i]);
					break;
			}
		}
		/*
		// : input박스의 좌표값 초기화
		if(map_api.obj) map_api.obj[0].value = '';
		if(map_api.obj) map_api.obj[1].value = '';
		if(map_api.obj) map_api.obj[2].value = '';
		*/
	};


	// : 클릭 이벤트
	// : type -> 값이 없으면 마커 모두 취소하기
	this.click_event = function(type, no, x, y, targets) {
		this.oMap.attach('click', function(oCustomEvent) {
			map_api.oPoint = oCustomEvent.point;
			var oTarget = oCustomEvent.target;
			map_api.mapInfoTestWindow.setVisible(false);

			// 마커 클릭하면
			if (oTarget instanceof nhn.api.map.Marker) {
				// 겹침 마커 클릭한거면
				if (oCustomEvent.clickCoveredMarker) {
					return;
				}
				// - InfoWindow 에 들어갈 내용은 setContent 로 자유롭게 넣을 수 있습니다. 외부 css를 이용할 수 있으며, 
				// - 외부 css에 선언된 class를 이용하면 해당 class의 스타일을 바로 적용할 수 있습니다.
				// - 단, DIV 의 position style 은 absolute 가 되면 안되며, 
				// - absolute 의 경우 autoPosition 이 동작하지 않습니다. 
				var msg = map_api.marker_msg(oTarget, no, x, y);
				return;				
			}

			if(!type) map_api.click2_event( targets );
		});
	};

	// : 검색 클릭 이벤트
	// : type -> 값이 없으면 마커 모두 취소하기
	this.search_click_event = function(type, no, data_no, x, y, targets) {
		
		//alert(type+"@"+no+"@"+data_no+"@"+x+"@"+y);

		this.oMap.attach('click', function(oCustomEvent) {
			map_api.oPoint = oCustomEvent.point;
			var oTarget = oCustomEvent.target;
			map_api.mapInfoTestWindow.setVisible(false);

			// 마커 클릭하면
			if (oTarget instanceof nhn.api.map.Marker) {
				// 겹침 마커 클릭한거면
				if (oCustomEvent.clickCoveredMarker) {
					return;
				}
				// - InfoWindow 에 들어갈 내용은 setContent 로 자유롭게 넣을 수 있습니다. 외부 css를 이용할 수 있으며, 
				// - 외부 css에 선언된 class를 이용하면 해당 class의 스타일을 바로 적용할 수 있습니다.
				// - 단, DIV 의 position style 은 absolute 가 되면 안되며, 
				// - absolute 의 경우 autoPosition 이 동작하지 않습니다. 
				var msg = map_api.search_marker_msg(oTarget, no, data_no, x, y);
				return;				
			}

			if(!type) map_api.click2_event( targets );
		});
	};

	this.click2_event = function( target ) {
		// : 클릭후 마커표시
		map_api.marker_false(); // : 마커 취소하기
		map_api.addMark();
		map_api._oPoint(map_api.oPoint);
		// : input박스의 좌표값
		map_api.map_put(map_api.marker_arr[1], map_api.marker_arr[0], map_api.oMap.getLevel(), target);
	}
	
	// 클릭 좌표 놓기 - 검색시 좌표가 있는 정보를 자동으로 지도좌표값으로 놓을때 */
	this.map_put = function(x, y, z, target) {

		map_api.map_point = [x, y, z];

		if( $('#mb_latlng').length ){
			$('#mb_latlng').val(y+","+x);
		}
		if( $('#wr_area_point').length ){
			$('#wr_area_point').val(y+","+x);
		}
		if(target){
			$('#'+target).val(y+","+x);
		}

		/*
		map_api.obj[0].value = map_api.map_point[0];
		map_api.obj[1].value = map_api.map_point[1];
		map_api.obj[2].value = map_api.map_point[2];
		*/
	};
	
	// : 마커 표시하기
	this.addMark = function() {
		var oMarker = new nhn.api.map.Marker(map_api.oIcon, { title : '마커 : ' + map_api.oPoint.toString() });
		oMarker.setPoint(map_api.oPoint);
		map_api.oMap.addOverlay(oMarker);
		map_api.marker[map_api.marker.length] = oMarker;
	};

	// : 좌표값 구하기(위도/경도) [ click해서 구해진 값입니다. ]
	this._oPoint = function(oPoint) {
		var point_val = oPoint.toString();
		map_api.marker_arr = point_val.split(",");
	};


	// : 줌인/줌아웃 관련
	this.zoom_form = function() {
		var oSlider = new nhn.api.map.ZoomControl();
		this.oMap.addControl(oSlider);
		oSlider.setPosition({
			top : 10,
			right : 10
		});
	}

	// : 맵 타입 버튼 [ 일반/위성 ]
	this.maptype_btn = function() {
		var oMapTypeBtn = new nhn.api.map.MapTypeBtn();
		this.oMap.addControl(oMapTypeBtn);
		oMapTypeBtn.setPosition({
			bottom : 18,
			//right : 10
			left: 10
		});
	};

	// : 주제별 지도
	this.otheme_btn = function() {
		var oThemeMapBtn = new nhn.api.map.ThemeMapBtn();
		oThemeMapBtn.setPosition({
			bottom : 18,
			right : 10
		});
		this.oMap.addControl(oThemeMapBtn);
	}

	// : 자전거 범례
	this.obicycle_func = function() {
		var oBicycleGuide = new nhn.api.map.BicycleGuide(); // - 자전거 범례 선언
		oBicycleGuide.setPosition({
			top : 10,
			right : 10
		}); // - 자전거 범례 위치 지정
		this.oMap.addControl(oBicycleGuide);// - 자전거 범례를 지도에 추가.
	};

	// : 교통범례
	this.otraffic_func = function() {
		var oTrafficGuide = new nhn.api.map.TrafficGuide(); // - 교통 범례 선언
		oTrafficGuide.setPosition({
			bottom : 18,
			left : 10
		});  // - 교통 범례 위치 지정.
		this.oMap.addControl(oTrafficGuide); // - 교통 범례를 지도에 추가.
	};

	// : 실시간 교통정보
	this.trafficbutton_func = function() {
		var trafficButton = new nhn.api.map.TrafficMapBtn(); // - 실시간 교통지도 버튼 선언
		trafficButton.setPosition({
			bottom:18, 
			right:150
		}); // - 실시간 교통지도 버튼 위치 지정
		this.oMap.addControl(trafficButton);
	};



	this.onload_func_map_child = function(no, icon_url, width, height) {
		//var url = this.base_url+'/views/_include/company.sample.php';
		this.point_put(this.mapapi_point_is[1], this.mapapi_point_is[0]);
		width = width ? width : this.icon_size[0];
		height = height ? height : this.icon_size[1];
		this.icon_size = [width, height];
		this.icon_func(icon_url);
		this.addMark();
		this.click_event('not_delete_marker', no, this.mapapi_point_is[1], this.mapapi_point_is[0]);
	};

	this.detail_func_map_child = function(no, data_no, icon_url, width, height) {
		//var url = this.base_url+'/views/_include/company.sample.php';
		this.point_put(this.mapapi_point_is[1], this.mapapi_point_is[0]);
		width = width ? width : this.icon_size[0];
		height = height ? height : this.icon_size[1];
		this.icon_size = [width, height];
		this.icon_func(icon_url);
		this.addMark();
		//this.click_event('not_delete_marker', no, this.mapapi_point_is[1], this.mapapi_point_is[0]);
		var oMarker = new nhn.api.map.Marker(map_api.oIcon, { title : '마커 : ' + map_api.oPoint.toString() });
		oMarker.setPoint(map_api.oPoint);
		this.detail_marker_view(oMarker,'subject',no,data_no);
	};

	this.search_func_map_child = function(no, data_no, icon_url, width, height) {
		this.point_put(this.mapapi_point_is[1], this.mapapi_point_is[0]);
		width = width ? width : this.icon_size[0];
		height = height ? height : this.icon_size[1];
		this.icon_size = [width, height];
		this.icon_func(icon_url);
		this.addMark();
		this.search_click_event('not_delete_marker', no, data_no, this.mapapi_point_is[1], this.mapapi_point_is[0]);
	};

	this.detail_marker_view = function(oTarget, mode, no, data_no) {	
		$.post(this.base_url+'/process/map.php', { mode:mode, ajax:'true', no:no, data_no:data_no }, function(data){
			var obj = $.parseJSON(data);
			var msg = obj.msg;
			if(msg){
				map_api.mapInfoTestWindow.setContent('<DIV style="border-top:1px solid; border-bottom:2px groove black; border-left:1px solid; border-right:2px groove black;margin-bottom:1px;color:black;background-color:white; width:auto; height:auto;">'+
				'<span style="color: #000000 !important;display: inline-block;font-size: 12px !important;font-weight: bold !important;letter-spacing: -1px !important;white-space: nowrap !important; padding: 2px 2px 2px 2px !important">' + msg + '<span></div>');
				map_api.mapInfoTestWindow.setPoint(oTarget.getPoint());
				map_api.mapInfoTestWindow.setVisible(true);
				map_api.mapInfoTestWindow.setPosition({left: -45, top : 35});
				map_api.mapInfoTestWindow.autoPosition();
			}
		});
	}

	this.point_put = function(x, y, type) {
		switch(type) {
			// : 내비게이션에서 공통으로 사용하는 좌표계로, 중부원점(127, 38)에서 약간 벗어난 (128, 38)을 기준으로 하는 평면 좌표계입니다. 종/횡 좌표를 사용합니다.
			case "TM128":
				map_api.oPoint = new nhn.api.map.TM128(x, y);
				break;
			// : UTM 좌표계의 한국형 좌표계입니다. - 종/횡 좌표를 사용합니다.
			case "UTMK":
				map_api.oPoint = new nhn.api.map.UTMK(x, y);
				break;
			// : 위도/경도 좌표를 사용합니다.
			default:
				map_api.oPoint = new nhn.api.map.LatLng(y, x);
				break;
		}
	}
	
	// : 마커 클릭시 메시지창 표시하기
	this.marker_msg = function(oTarget, no, x, y) {
		var x_y_int = map_api._oPoint(oTarget.getPoint());
		if(map_api.marker_arr[0]==x && map_api.marker_arr[1]==y) {
			this.marker_view(oTarget, no);
		}
	};


	this.marker_view = function(oTarget, no) {	
		$.post(this.base_url+'/process/map.php', { mode:'company_info', ajax:'true', no:no }, function(data){
			var obj = $.parseJSON(data);
			var msg = obj.msg;
			if(msg){
				map_api.mapInfoTestWindow.setContent('<DIV style="border-top:1px solid; border-bottom:2px groove black; border-left:1px solid; border-right:2px groove black;margin-bottom:1px;color:black;background-color:white; width:auto; height:auto;">'+
				'<span style="color: #000000 !important;display: inline-block;font-size: 12px !important;font-weight: bold !important;letter-spacing: -1px !important;white-space: nowrap !important; padding: 2px 2px 2px 2px !important">' + msg + '<span></div>');
				map_api.mapInfoTestWindow.setPoint(oTarget.getPoint());
				map_api.mapInfoTestWindow.setVisible(true);
				map_api.mapInfoTestWindow.setPosition({right : 15, top : 30});
				map_api.mapInfoTestWindow.autoPosition();
			}
		});
	}

	// : 마커 클릭시 메시지창 표시하기
	this.search_marker_msg = function(oTarget, no, data_no, x, y) {
		var x_y_int = map_api._oPoint(oTarget.getPoint());
		if(map_api.marker_arr[0]==x && map_api.marker_arr[1]==y) {
			this.search_marker_view(oTarget, no, data_no);
		}
	};

	this.search_marker_view = function(oTarget, no, data_no) {	
		$.post(this.base_url+'/process/map.php', { mode:'naver', ajax:'true', no:no, data_no:data_no }, function(data){			
			var obj = $.parseJSON(data);
			var x = obj.x;
			var y = obj.y;
			var msg = obj.msg;

			if(msg){
				//map_api.mapInfoTestWindow.setContent('<DIV style="border-top:1px solid; border-bottom:2px groove black; border-left:1px solid; border-right:2px groove black;margin-bottom:1px;color:black;background-color:white; width:auto; height:auto;">'+
				//'<span style="color: #000000 !important;display: inline-block;font-size: 12px !important;font-weight: bold !important;letter-spacing: -1px !important;white-space: nowrap !important; padding: 2px 2px 2px 2px !important"><span></div>');
				map_api.mapInfoTestWindow.setContent(msg);
				map_api.mapInfoTestWindow.setPoint(oTarget.getPoint());
				map_api.mapInfoTestWindow.setVisible(true);
				map_api.mapInfoTestWindow.setPosition({right : 15, top : 30});
				map_api.mapInfoTestWindow.autoPosition();
			}

		});
	}

	this.map_location_move = function(x, y, z) {
		map_api.moveObj(x, y, z, 'not_delete_marker');
	};

	this.moveObj = function(x, y, z, type) {
		z = z ? z : map_api.oMap.getLevel();
		map_api.point_put(x, y);
		map_api.oMap.setCenterAndLevel(map_api.oPoint, z); // - 지도 생성시 지정한 중심점으로 중심점을 설정한다.
	}

}