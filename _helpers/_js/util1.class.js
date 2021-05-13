var netfu_util1 = function() {

	this.page_rows = function(el) {
		var _lo = location.href.split("?");
		location.href = _lo[0]+"?"+_lo[1]+"&page_rows="+el.value
	}

	this.getDateStr = function(myDate){
		var _get_month = myDate.getMonth()+1;
		var _get_day = myDate.getDate();
		if(_get_month.toString().length==1) _get_month = '0'+_get_month;
		if(_get_day.toString().length==1) _get_day = '0'+_get_day;
		return (myDate.getFullYear() + '-' + (_get_month) + '-' + _get_day)
	}


	this.chk_length = function(c) {
		return $(c).find(":checked").length;
	}

	this.img_click_check = function(id) {
		$("#"+id).click();
	};

	this.close = function(c) {
		$(c).css("display", "none");
	};

	this.open = function(c) {
		$(c).css("display", "block");
	};

	this.open2 = function(el, val, c) {
		if(el.value==val) $(c).css({"display":"block"});
		else $(c).css({"display":"none"});
	}


	this.this_pos_view = function(el, c) {
		var _offset = $(el).offset();
		var _box_size = $(c)[0].offsetWidth;
		$(c).css({"top":_offset.top+'px', "left":(_offset.left-_box_size)+'px'});
	}
	this.this_pos_none = function(c) {
		$(c).css({"top":-99999+"px"});
	}

	this.checkbox_one = function(el) {
		var form = el.form;
		var el_chk = el.checked;
		$(form).find("[name='"+el.name+"']").attr("checked", false);
		if(el_chk) $(el).attr("checked", true);
	}


	this.put_text = function(el, obj) {
		obj.val(el.value);
	};

	this.put_checkbox_val = function(c, put) {

		var put_val = [];
		$(".wr_welfare_c:checked").each(function(i){
			put_val[i] = $(this).attr("txt");
		});
		$(put).val(put_val);
	}


	this.delete_func = function(no, code) {
		if(confirm("삭제하시겠습니까?")) {
			$.post(base_url+"/regist.php", "mode="+code+"_delete&chk[]="+no, function(data) {
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.move) location.href = data.move;
			});
		}
	}


	this.delete_select_func = function(el) {
		var _len = $(el).find("[name='chk[]']:checked").length;
		if(_len<=0) {
			alert("삭제할 정보를 선택해주시기 바랍니다.");
			return;
		} else {
			if(confirm("삭제하시겠습니까?")) {
				netfu_util1.ajax_submit(el);
			}
		}
	}


	this.ajax_cate = function(el, type, key, read_type) {
		var obj = $(el.form).find("[name='"+el.name+"']");
		var _put = $(el).attr("put");
		var put_obj = _put ? $("#"+_put) : obj.eq(key);
		var val = $(el).attr("val");
		var _this = $(el).attr("this");
		var _no = read_type!='auto' ? el.value : (el.value ? el.value : _this);

		var _html = '<option value="">'+put_obj.find("option").eq(0).html()+'</option>';

		if(!el.value && !read_type) {
			put_obj.html(_html);
		} else {
			if(_no) {
				$.post(base_url+"/regist.php", "mode=get_cate_array&type="+type+"&no="+_no, function(data){
					data = $.parseJSON(data);
					var len = data.cate.length;
					for(var i=0; i<len; i++) {
						var selected = val==data.cate[i]['code'] && val ? 'selected' : '';
						_html += '<option value="'+data.cate[i]['code']+'" '+selected+'>'+data.cate[i]['name']+'</option>';
					}
					put_obj.html(_html);
				});
			}
		}
	}


	this.date_put = function(date) {
		var _date1 = netfu_util1.getDateStr(new Date());
		$("[name='_sdate']").val(date);
		$("[name='_edate']").val(_date1);
	}



	this.member_logins = function() {
		var form = document.forms['MemberLoginFrm'];
		var get_para = $(form).serialize();
		if(validate(form)) {
			$.post(form.action, get_para, function(data){
				//alert(data);
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.move) location.href = data.move;
				return true;
			});
		}
		return false;
	}


	this.email_put = function(el) {
		netfu_util1.put_text(el, $("[name='wr_email[]']").eq(1));
	}


	this.photo_write_view = function(c) {
		var obj = $(c).css("display");
		$(".wrap_bg_div").css({"display":"none"});

		var _display = obj=='none' ? 'block' : 'none';
		$(c).css({"display":_display});
	}


	this.ajax_submit = function(el, noneObj) {
		var form = el;
		if(validate(form)) {
			$(form).ajaxSubmit({
				//보내기전 validation check가 필요할경우
				beforeSubmit: function (data, frm, opt) {
					//alert("전송전!!");
					return true;
				},
				//submit이후의 처리
				success: function(data, statusText) {
					//alert(data);
					data = $.parseJSON(data);
					if(data.msg) alert(data.msg);
					if(data.js) eval(data.js);
					if(data.move) location.href = data.move;
					if(noneObj) noneObj.css('display', 'none');
					return false;
				},
				//ajax error
				error: function(data,status,error){
					alert("에러발생!!");
					return false;
				}
			});
		}
		return false;
	}



	this.editor_start = function() {
		$("textarea").each(function(){
			var _type = $(this).attr("type");
			if(_type=='editor') {
				var _name = $(this).attr("name");
				var _width = $(this).css("width");
				var _height = $(this).css("height");
				if(!$(this).attr("id")) $(this).attr("id", "tx_"+_name);
				try{
					_editor_use[_name] = new cheditor('ed_'+_name);
					_editor_use[_name].config.editorHeight = _height ? _height : '250px';
					_editor_use[_name].config.editorWidth = _width ? _width : '100%';
					_editor_use[_name].inputForm = 'tx_'+_name;
					_editor_use[_name].run();
				}catch(e){
					alert(e.message);
				}
			}
		});
	}


	this.filesize_check = function(el, size) {
		var iSize = 0;
		iSize = ($(el)[0].files[0].size);
		if((size*1024)<iSize) {
			var _html = $(el).parent().html();
			alert("파일은 "+size+'kb 까지 올릴수 있습니다.');
			$(el).parent().html(_html);
		}
		return iSize;
	}
}




// : 카테고리값이 있는경우 자동으로 그값이 나타나게 하기
var auto_select_selected = function() {
	$("select").each(function(){
		var sel = $(this).attr("sel");
		var type = $(this).attr("type");
		var auto_none = $(this).attr("auto_none");
		if(auto_none==undefined) {
			if(sel && type) {
				netfu_util1.ajax_cate($(this)[0], type, sel, 'auto');
			}
		}
	});
}



var date_val = new Date();
var datepicker_json = {
	dateFormat: "yy-mm-dd",    /* 날짜 포맷 */ 
	prevText: '이전달',
	nextText: '다음달',
	showButtonPanel: true,    /* 버튼 패널 사용 */ 
	changeMonth: true,        /* 월 선택박스 사용 */ 
	changeYear: true,        /* 년 선택박스 사용 */ 
	showOtherMonths: false,    /* 이전/다음 달 일수 보이기 */ 
	selectOtherMonths: true,    /* 이전/다음 달 일 선택하기 */ 
	yearSuffix: '년',
	closeText: '닫기', 
	currentText: '오늘', 
	showMonthAfterYear: true,        /* 년과 달의 위치 바꾸기 */ 
	/* 한글화 */ 
	monthNames : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'], 
	monthNamesShort : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'], 
	dayNames : ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
	dayNamesShort : ['일', '월', '화', '수', '목', '금', '토'],
	dayNamesMin : ['일', '월', '화', '수', '목', '금', '토'],
	weekHeader: 'Wk',
	yearRange :"-100:+0",
	firstDay: 0,
	isRTL: false,
	showAnim: 'slideDown',
	onSelect:function(dateText, inst){
	}
};





var _editor_use = {};
$(window).ready(function(){
	auto_select_selected();

	// : 날짜
	$( ".datepicker_inp" ).datepicker(datepicker_json).keyup(function(e) {
		if(e.keyCode == 8 || e.keyCode == 46) {
			$.datepicker._clearDate(this);
		}
	});


	// : 날짜선택 버튼형
	$(".btn_datepicker").click(function() {
		var c = $(this).attr("get");
		$(c).datepicker("show");
	});


	////// 로고효과 //////
	// : 0번로고 효과
	setInterval(function(){
		fade_images('fade_image');
	}, 3000);

	// : 1번로고 효과
	blink('blink_image',900000,1500);	// 깜빡임

	// : 2번로고 효과
	var $slide_image = $('.slide_image');
	if($slide_image.length > 0 ) {
		$slide_image.cycle({		// 슬라이드
			fx : "scrollHorz", 
			centerHorz:true,
			centerVert:true,
			slides : 'img',
			timeout:2000,
			easing : 'easeInOutBack'
		});
	}

	setTimeout(function(){
	$(".slide_image").each(function(){
		var _code = $(this).attr("_code");
		if($(this)[0].tagName!='SPAN' && !_code) {
			var _width = $(this).find("img").width();
			//$(this).css({"left":'50%', 'margin-left':'-'+(_width/2)+'px'});
		} else {
			$(this).find("img").css({"display":"inline-block", "margin-top":'0px'});
		}
	});
	},100);
	setTimeout(function(){
		$(".slide_image").each(function(){
			if($(this)[0].tagName=='SPAN') {
				$(this).closest("li").find("[type=radio]").css({"margin-top":"-24px"});
			}
		});
	},2000);
	////// 로고효과 //////



	// : 배너 width, height 없애기 - width, height대신에 max로 변환
	$(".banner_div__").each(function(){
		var _width = $(this).attr("width");
		var _height = $(this).attr("height");

		var _json = {'width':'auto', 'height':'auto', 'text-align':'center', 'margin':'0px auto'};
		$(this).css(_json);
		$(this).closest(".banner_parent_div__").css(_json);
	});




	netfu_util1.editor_start();
});


var netfu_util1 = new netfu_util1();