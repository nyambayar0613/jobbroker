var netfu_mjob = function() {

	// 로고 등록
	this.logo_submit = function() { // 로고 등록
		//$('#upload_mode').val('logo_upload'); // 로고 등록 모드로 변경
		var mb_logo = $('#mb_logo').val();
		if(!mb_logo || mb_logo==''){
			alert("등록할 로고를 첨부해 주세요.");
			return;
		}

		$("form[name='flogo']").ajaxSubmit({
			beforeSubmit:function(formData, jqForm, photos_options){
				return true;
			}, 
			success:function(responseText, statusText, xhr, $form){
				$('#companylogo').attr('src', responseText);
				setTimeout(function(){
					$('.logo_change').addClass("_none");
					$('#logo_remove').show();
					$('.logo_write__').html('수정');
				}, 100);
			}
		});
	}


	this.logo_delete = function(no) {
		if(confirm('회사 로고를 삭제하시겠습니까?\n\n한번 삭제된 데이터는 복구가 불가능합니다.')) {
			$.post(base_url+'/regist.php', "mode=logo_delete&company_no="+no, function(data) {
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.photo) {
					$('#companylogo').attr('src',data.photo);
					$('.logo_write__').html('등록');
					$('#logo_remove').hide();
				}
			});
		}
	}

	this.jump_func = function(code, no) {
		if(confirm("점프하시겠습니까?")) {
			$.post(base_url+"/regist.php", "mode=service_jump&code="+code+"&no="+no, function(data){
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.move) location.href = data.move
			});
		}
	}

	this.wr_requisition_click = function(el) {
		if($(".wr_requisition_"+el.value)[0]) {
			var _view = el.checked ? 'block' : 'none';
			$(".wr_requisition_"+el.value).css({"display":_view});
		}
	}

	this.reportFrmSubmit = function() {
		var len = $('#reportFrm').find("[name='wr_report']:checked").length;
		if(len<=0) {
			alert("신고사유 항목을 선택해주시기 바랍니다.");
			return false;
		}
		var report_options = { target : '', beforeSubmit : netfu_mjob.reportRequest, success : netfu_mjob.reportResponse }
		if(confirm("신고하시겠습니까?\n\n신고가 접수되면 사이트 운영자가 확인 후 처리됩니다.")){
			$('#reportFrm').ajaxSubmit(report_options);
		}
	}
	this.reportRequest = function(formData, jqForm, report_options){ // 신고 전송 전
		var reportFrm = document.forms('reportFrm');
		var queryString = $.param(formData);
		return validate(reportFrm);
	}
	this.reportResponse = function(responseText, statusText, xhr, $form){ // 신고 전송 후
		//alert(responseText);
		if(responseText){
			alert("신고되었습니다.");
			location.href = base_path;
		}
	}
	this.alba_report_close = function(){	// 신고창 닫기 (초기화)
		netfu_util1.close($('.report_bx'));
		$('#reportFrm').resetForm();
	}


// : 신고
	this.report = function(code, no) {
		var form = document.forms['reportFrm'];
		var len = $('#reportFrm').find("[name='wr_report']:checked").length;
		if(len<=0) {
			alert("신고사유 항목을 선택해주시기 바랍니다.");
			return false;
		}
		if(validate(form) && confirm("신고하시겠습니까?\n\n신고가 접수되면 사이트 운영자가 확인 후 처리됩니다.")) {
			var report_no = $(form).find("[name='wr_report']:checked").val();
			var _para = $(form).serialize();
			$.post(base_url+"/regist.php", _para+"&mode=report_write&code="+code+"&no="+no+"&report_no="+report_no, function(data){
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.move) location.href = data.move;
				netfu_mjob.alba_report_close();
			});
		}
	}

// : 스크랩
	this.scrap = function(code, no) {
		$.post(base_url+"/regist.php", "mode=scrap_write&code="+code+"&no="+no, function(data){
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			if(data.move) location.href = data.move;
		});
	}


	this.scrap_sel = function(f) {
		var form = document.forms[f];
		form.mode.value = "scrap_select";
		var _len = $(form).find("[name='chk[]']:checked").length;
		if(_len<=0) return alert("스크랩할 정보를 선택해주시기 바랍니다.");
		netfu_util1.ajax_submit(form);
	}


	this._use_school = 0;
	this.school_ability_change = function(el) {
		var graduation_arr = ['재학', '졸업', '중퇴', '수료'];
		var _graduation_json = {'졸업':0, '재학':1, '중퇴':2};
		var _graduate_graduation_json = {'졸업':0, '수료':1, '재학':2, '중퇴':3};
		var arr = el.value.split("/");
		var _txt = $(el).find("option:selected").text();
		
		var _rank = parseInt(arr[1]);

		for(var i=0; i<graduation_arr.length; i++) {
			if(_txt.indexOf(graduation_arr[i])>=0) {
				_graduation = graduation_arr[i];
				break;
			}
		}
		// : 학교별로 display설정
		netfu_mjob._use_school = 0;
		if(_rank>=4 && _rank<=5) netfu_mjob._use_school = 1;
		if(_rank>=6) netfu_mjob._use_school = 2;
		if(_rank>=9) netfu_mjob._use_school = 3;
		if(_rank>=12) netfu_mjob._use_school = 4;

		$("._high_school").css({"display":"none"});
		$("._half_college").css({"display":"none"});
		$("._college").css({"display":"none"});
		$("._graduate").css({"display":"none"});

		if(netfu_mjob._use_school==1) {
			$("._high_school").css({"display":"block"});
		}
		if(netfu_mjob._use_school==2) {
			$("._half_college").css({"display":"block"});
		}
		if(netfu_mjob._use_school==3) {
			$("._college").css({"display":"block"});
		}
		if(netfu_mjob._use_school==4) {
			$("._graduate").css({"display":"block"});
		}


		// : 재학,졸업,중퇴,수료 선택여부에 따라 변하는 소스
		var _display = _graduation=='재학' ? 'none' : 'inline';

		if(netfu_mjob._use_school==1) {
			$("[name='wr_high_school_graduation']").val(_graduation_json[_graduation]);
			$("[name='wr_high_school_eyear']").css({"display":_display});
			if(_display=='none') $("[name='wr_high_school_eyear']").val('');
		}
		if(netfu_mjob._use_school==2) {
			$("[name='wr_half_college_graduation[]']").val(_graduation_json[_graduation]);
			$("[name='wr_half_college_eyear[]']").css({"display":_display});
			if(_display=='none') $("[name='wr_half_college_eyear[]']").val('');
		}
		if(netfu_mjob._use_school==3) {
			$("[name='wr_college_graduation[]']").val(_graduation_json[_graduation]);
			$("[name='wr_college_eyear[]']").css({"display":_display});
			if(_display=='none') $("[name='wr_college_eyear[]']").val('');
		}
		if(netfu_mjob._use_school==4) {
			$("[name='wr_graduate_graduation[]']").val(_graduate_graduation_json[_graduation]);
			$("[name='wr_graduate_eyear[]']").css({"display":_display});
			if(_display=='none') $("[name='wr_graduate_eyear[]']").val('');
		}

		// : 각 학교별로 체크시에 해당학력 초과면 비활성화하면서 체크해제
		$("[name='wr_school_type[]']").each(function(i){
			var _chk = ((netfu_mjob._use_school)>i) ? true : false;
			if(_chk) {
				if((i+1)!=netfu_mjob._use_school) _chk = false;
				$(this).attr("checked", _chk);
				$(this).attr("disabled", false);
			} else {
				$(this).attr("checked", false);
				$(this).attr("disabled", true);
			}
		});

		// 중학교 까지 (휴학 불가능)
		if(_rank<=3) {
			$("[name='wr_school_absence']").attr('checked', false); // 휴학중 체크
			$("[name='wr_school_absence']").attr('disabled', true);
		} else {
			$("[name='wr_school_absence']").attr('checked', false); // 휴학중 체크
			$("[name='wr_school_absence']").attr('disabled', false);
		}
	}

	this.school_type_click = function(el) {
		$("[name='"+el.name+"']").each(function(i){
			// : 같은학력은 체크해제가 안되게.
			if(netfu_mjob._use_school==i+1) $(this)[0].checked = true;

			if($(this)[0].checked===true) $("._"+$(this).val()).css({"display":"block"});
			else $("._"+$(this).val()).css({"display":"none"});
		});
	}


	this.area_add = function(el, code) {
		switch(code) {
			// : 삭제
			case "del":
				if(confirm("삭제하시겠습니까?")) {
					$(el).closest(".select_area").remove();
				}
				break;

			// : 추가
			default:
				var _len = $(".select_area").length;
				if(_len>=3) {
					alert("지역은 3개까지 가능합니다.");
					return false;
				}
				var _clone = $(".select_area").eq(0).clone().wrapAll("<div/>").parent().clone();
				var _clone_html = _clone.html();

				var _type = $(el).closest(".select_area").attr("type");

				if(_type=="[]") {
					switch(_len) {
						case 1:
							_clone_html = _clone_html.replace(/wr_area_0/gi, 'wr_area_1');
							_clone_html = _clone_html.replace(/wr_area1_id/gi, 'wr_area4_id');
							_clone_html = _clone_html.replace(/wr_area2_id/gi, 'wr_area5_id');
							//alert(_clone_html);
							break;

						case 2:
							_clone_html = _clone_html.replace(/wr_area_0/gi, 'wr_area_2');
							_clone_html = _clone_html.replace(/wr_area1_id/gi, 'wr_area7_id');
							_clone_html = _clone_html.replace(/wr_area2_id/gi, 'wr_area8_id');
							break;
					}
				} else {
					switch(_len) {
						case 1:
							_clone_html = _clone_html.replace(/wr_area0/gi, 'wr_area2');
							_clone_html = _clone_html.replace(/wr_area1/gi, 'wr_area3');
							_clone_html = _clone_html.replace(/wr_area1_id/gi, 'wr_area3_id');
							break;

						case 2:
							_clone_html = _clone_html.replace(/wr_area0/gi, 'wr_area4');
							_clone_html = _clone_html.replace(/wr_area1/gi, 'wr_area5');
							_clone_html = _clone_html.replace(/wr_area1_id/gi, 'wr_area5_id');
							break;
					}
				}
				_clone_html = _clone_html.replace(/this, 'add'/gi, 'this, \'del\'');
				_clone_html = _clone_html.replace(/추가/gi, '삭제');
				$(".select_area_put").append(_clone_html);
				break;
		}
	}


	this.job_type_add = function(el, code) {
		switch(code) {
			// : 삭제
			case "del":
				if(confirm("삭제하시겠습니까?")) {
					$(el).closest(".select_job_type").remove();
				}
				break;

			// : 추가
			default:
				var _len = $(".select_job_type").length;
				if(_len>=3) {
					alert("직종은 3개까지 가능합니다.");
					return false;
				}
				var _clone = $(".select_job_type").eq(0).clone().wrapAll("<div/>").parent().clone();
				var sel1 = _clone.find("select").eq(1).find("option").eq(0).text();
				var sel2 = _clone.find("select").eq(2).find("option").eq(0).text();
				_clone.find("select").eq(1).find("option").remove();
				_clone.find("select").eq(2).find("option").remove();
				_clone.find("select").eq(1).html('<option value="">'+sel1+'</option>');
				_clone.find("select").eq(2).html('<option value="">'+sel2+'</option>');
				var _clone_html = _clone.html();
				switch(_len) {
					case 1:
						_clone_html = _clone_html.replace(/wr_job_type0/gi, 'wr_job_type3');
						_clone_html = _clone_html.replace(/wr_job_type1/gi, 'wr_job_type4');
						_clone_html = _clone_html.replace(/wr_job_type2/gi, 'wr_job_type5');
						_clone_html = _clone_html.replace(/wr_job_type1_id/gi, 'wr_job_type4_id');
						_clone_html = _clone_html.replace(/wr_job_type2_id/gi, 'wr_job_type5_id');
						break;

					case 2:
						_clone_html = _clone_html.replace(/wr_job_type0/gi, 'wr_job_type6');
						_clone_html = _clone_html.replace(/wr_job_type1/gi, 'wr_job_type7');
						_clone_html = _clone_html.replace(/wr_job_type2/gi, 'wr_job_type8');
						_clone_html = _clone_html.replace(/wr_job_type1_id/gi, 'wr_job_type7_id');
						_clone_html = _clone_html.replace(/wr_job_type2_id/gi, 'wr_job_type8_id');
						break;
				}
				_clone_html = _clone_html.replace(/this, 'add'/gi, 'this, \'del\'');
				_clone_html = _clone_html.replace(/추가/gi, '삭제');
				$(".select_job_type_put").append(_clone_html);
				break;
		}
	}


	this.subway_add = function(el, code) {
		switch(code) {
			// : 삭제
			case "del":
				if(confirm("삭제하시겠습니까?")) {
					$(el).closest(".select_subway").remove();
				}
				break;

			// : 추가
			default:
				var _len = $(".select_subway").length;
				if(_len>=3) {
					alert("지하철은 3개까지 가능합니다.");
					return false;
				}
				var _clone = $(".select_subway").eq(0).clone().wrapAll("<div/>").parent().clone();

				var sel1 = _clone.find("select").eq(1).find("option").eq(0).text();
				var sel2 = _clone.find("select").eq(2).find("option").eq(0).text();

				_clone.find("select").eq(1).find("option").remove();
				_clone.find("select").eq(2).find("option").remove();
				_clone.find("select").eq(1).html('<option value="">'+sel1+'</option>');
				_clone.find("select").eq(2).html('<option value="">'+sel2+'</option>');
				var _clone_html = _clone.html();
				switch(_len) {
					case 1:
						_clone_html = _clone_html.replace(/wr_subway_area_0/gi, 'wr_subway_area_1');
						_clone_html = _clone_html.replace(/wr_subway_line_0/gi, 'wr_subway_line_1');
						_clone_html = _clone_html.replace(/wr_subway_station_0/gi, 'wr_subway_station_1');
						_clone_html = _clone_html.replace(/wr_subway_content_0/gi, 'wr_subway_content_1');
						break;

					case 2:
						_clone_html = _clone_html.replace(/wr_subway_area_0/gi, 'wr_subway_area_2');
						_clone_html = _clone_html.replace(/wr_subway_line_0/gi, 'wr_subway_line_2');
						_clone_html = _clone_html.replace(/wr_subway_station_0/gi, 'wr_subway_station_2');
						_clone_html = _clone_html.replace(/wr_subway_content_0/gi, 'wr_subway_content_2');
						break;
				}
				_clone_html = _clone_html.replace(/this, 'add'/gi, 'this, \'del\'');
				_clone_html = _clone_html.replace(/추가/gi, '삭제');
				$(".select_subway_put").append(_clone_html);
				break;
		}
	}


	this.career_use = function(el) {
		switch(el.checked) {
			case true:
				$(".career_con").css("display", "block");
				break;

			default:
				$(".career_con").css("display", "none");
				break;
		}
	}


	this.career_job_type_add = function(el, code) {
		switch(code) {
			case "del":
				if(confirm("삭제하시겠습니까?"))
					$(el).closest("li.career_con").remove();
				break;

			case "add":
				var _len = $(".career_con").length;
				var _clone = $(".career_con").eq(0).clone().wrapAll("<div/>").parent().clone();
				var sel1 = _clone.find("select").eq(1).find("option").eq(0).text();
				var sel2 = _clone.find("select").eq(2).find("option").eq(0).text();
				_clone.find("select").eq(1).find("option").remove();
				_clone.find("select").eq(2).find("option").remove();
				_clone.find("select").eq(1).html('<option value="">'+sel1+'</option>');
				_clone.find("select").eq(2).html('<option value="">'+sel2+'</option>');
				var _clone_html = _clone.html();

				_clone_html = _clone_html.replace(/wr_career_type_0/gi, 'wr_career_type_'+(_len));
				_clone_html = _clone_html.replace(/wr_career_type_0/gi, 'wr_career_type_'+(_len));
				_clone_html = _clone_html.replace(/wr_career_type_0/gi, 'wr_career_type_'+(_len));
				_clone_html = _clone_html.replace(/this, 'add'/gi, 'this, \'del\'');
				_clone_html = _clone_html.replace(/>추가/gi, '>삭제');

				$(".career_ul").append(_clone_html);
				break;
		}
	}



	this.school_add = function(el, code) {
		switch(code) {
			case "del":
				if(confirm("삭제하시겠습니까?"))
					$(el).closest("._school_part").remove();
				break;

			case "add":
				var _clone = $(el).closest("._school_part").eq(0).clone().wrapAll("<div/>").parent().clone();
				var _clone_html = _clone.html();
				_clone_html = _clone_html.replace(/this, 'add'/gi, 'this, \'del\'');
				_clone_html = _clone_html.replace(/>추가/gi, '>삭제');

				$(el).closest("fieldset").append(_clone_html);
				break;
		}
	}



	this.license_add = function(el, code) {
		switch(code) {
			case "del":
				if(confirm("삭제하시겠습니까?"))
					$(el).closest(".license_con").remove();
				break;

			case "add":
				var _clone = $(el).closest(".license_con").eq(0).clone().wrapAll("<div/>").parent().clone();
				var _clone_html = _clone.html();
				_clone_html = _clone_html.replace(/this, 'add'/gi, 'this, \'del\'');
				_clone_html = _clone_html.replace(/>추가/gi, '>삭제');

				$(el).closest(".license_body").append(_clone_html);
				break;
		}
	}


	this.career_use_click = function(el) {
		switch(el.checked) {
			case true:
				$(".license_body").css({"display":"block"});
				$(".license_con").find("input").prop("required", true);
				$(".license_con").find("select").prop("required", true);
				break;

			default:
				$(".license_body").css({"display":"none"});
				$(".license_con").find("input").prop("required", false);
				$(".license_con").find("select").prop("required", false);
				break;
		}
	}


	this.language_use_click = function() {
		var _chk = $("[name='wr_language_use']")[0];
		switch(_chk.checked) {
			case true:
				$(".language_con").css({"display":"table"});
				$("[name='wr_language_name[]']").prop("required", true);
				break;

			default:
				$(".language_con").css({"display":"none"});
				$("[name='wr_language_name[]']").removeAttr("required");
				break;
		}
	}

	this.language_part_add = function(el, code) {
		switch(code) {
			case "del":
				if(confirm("삭제하시겠습니까?"))
					$(el).closest("._language_part").remove();
				break;

			case "add":
				var _clone = $(el).closest("._language_part").eq(0).clone().wrapAll("<div/>").parent().clone();
				var _clone_html = _clone.html();
				_clone_html = _clone_html.replace(/this, 'add'/gi, 'this, \'del\'');
				_clone_html = _clone_html.replace(/시험추가/gi, '시험삭제');

				$(el).closest("._language_td").append(_clone_html);
				break;
		}
	}

	this.language_add = function(el, code) {
		switch(code) {
			case "del":
				if(confirm("삭제하시겠습니까?"))
					$(el).closest(".language_table").remove();
				break;

			case "add":
				var _len = $(".language_con").find(".language_table").length;
				var _clone = $(el).closest(".language_table").eq(0).clone().wrapAll("<div/>").parent().clone();
				var _clone_html = _clone.html();
				_clone_html = _clone_html.replace(/wr_language_level_0/gi, 'wr_language_level_'+(_len));
				_clone_html = _clone_html.replace(/language_license_0/gi, 'language_license_'+(_len));
				_clone_html = _clone_html.replace(/language_license_year_0/gi, 'language_license_year_'+(_len));
				_clone_html = _clone_html.replace(/language_license_level_0/gi, 'language_license_level_'+(_len));
				_clone_html = _clone_html.replace(/wr_language_study_0/gi, 'wr_language_study_'+(_len));
				_clone_html = _clone_html.replace(/wr_language_study_date_0/gi, 'wr_language_study_date_'+(_len));
				_clone_html = _clone_html.replace(/language_add\(this, 'add'\)">추가/gi, "language_add(this, 'del')\">삭제");

				$(el).closest(".language_con").append(_clone_html);
				break;
		}
	}



	this.wr_specialty_etc_view = function(el) {
		switch(el.checked) {
			case true:
				$("#wr_specialty_view").css({"display":"block"});
				break;

			default:
				$("#wr_specialty_view").css({"display":"none"});
				break;
		}
	}



	this.introduce_part_click = function(el, code, tname) {
		var input_form = $(_editor_use[tname].cheditor.container).find("iframe").contents();
		switch(code) {
			case 'all':
				var checked = el.checked;
				var introduce_check = $("input[name='wr_content_check']");

				if(checked==true){
					$("input[name='wr_content_check']").attr('checked',true);
					introduce_check.each(function(){
						var _id = $(this).attr('id');
						var sel = $(this).val();
						input_form.find("body").append('<div id="content_'+_id+'">* '+sel+'<br/>-<br/><br/></div>');
					});
				} else {
					$("input[name='wr_content_check']").attr('checked',false);
					introduce_check.each(function(){
						var _id = $(this).attr('id');
						input_form.find('#content_'+_id).remove();
					});
				}
				break;

			default:
				var sel = el.value;
				var checked = el.checked;

				if(checked==true){
					input_form.find("body").append('<div id="content_'+code+'">* '+sel+'<br/>- <br/><br/></div>');
				} else {
					input_form.find('#content_'+code).remove();
				}
				break;
		}
	}



	this.pay_conference = function(el) {
		switch(el.checked) {
			case true:
				$(el).closest("fieldset").find("[name='wr_pay_type']").attr("disabled", "disabled");
				$(el).closest("fieldset").find("[name='wr_pay_type']").removeAttr("required");
				$(el).closest("fieldset").find("[name='wr_pay_type']").val('');
				$(el).closest("fieldset").find("[name='wr_pay']").attr("disabled", "disabled");
				$(el).closest("fieldset").find("[name='wr_pay']").removeAttr("required");
				$(el).closest("fieldset").find("[name='wr_pay']").val('');
				break;

			default:
				$(el).closest("fieldset").find("[name='wr_pay_type']").attr("required", "required");
				$(el).closest("fieldset").find("[name='wr_pay_type']").removeAttr("disabled");
				$(el).closest("fieldset").find("[name='wr_pay']").attr("required", "required");
				$(el).closest("fieldset").find("[name='wr_pay']").removeAttr("disabled");
				break;
		}
	}



	this.resume_delete = function(no) {
		$.post(base_url+"/regist.php", "mode=resume_delete&chk[]="+no, function(data) {
			//alert(data);
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			if(data.move) location.href = data.move;
		});
	}


	this.resume_all_delete = function() {
		var form = document.forms['flist'];
		var _para = $(form).serialize();
		$.post(base_url+"/regist.php", "mode=resume_delete&"+_para, function(data) {
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			if(data.move) location.href = data.move;
		});
	}

	this.resume_all_open = function(open) {
		var form = document.forms['flist'];
		var _para = $(form).serialize();
		$.post(base_url+"/regist.php", "mode=resume_open&"+_para+"&open="+open, function(data) {
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			if(data.move) location.href = data.move;
		});
	}


	this.receive_all_delete = function() {
		var form = document.forms['flist'];
		if($(form).find("[name='chk[]']:checked").length<=0) {
			alert("한개이상 선택해주시기 바랍니다.");
		} else {
			if(confirm("삭제하시겠습니까?")) {
				var _para = $(form).serialize();
				$.post(base_url+"/regist.php", "mode=receive_delete&"+_para, function(data) {
					alert("작업해야함");
					data = $.parseJSON(data);
					if(data.msg) alert(data.msg);
					if(data.move) location.href = data.move;
				});
			}
		}
	}


	this.receive_request_all_delete =  function() {
		var form = document.forms['flist'];
		if($(form).find("[name='chk[]']:checked").length<=0) {
			alert("한개이상 선택해주시기 바랍니다.");
		} else {
			if(confirm("삭제하시겠습니까?")) {
				var _para = $(form).serialize();
				$.post(base_url+"/regist.php", "mode=receive_request_delete&"+_para, function(data) {
					alert("작업해야함");
					data = $.parseJSON(data);
					if(data.msg) alert(data.msg);
					if(data.move) location.href = data.move;
				});
			}
		}
	}



	this.scrap_all_delete = function() {
		var form = document.forms['flist'];
		if($(form).find("[name='chk[]']:checked").length<=0) {
			alert("한개이상 선택해주시기 바랍니다.");
		} else {
			if(confirm("삭제하시겠습니까?")) {
				var _para = $(form).serialize();
				$.post(base_url+"/regist.php", "mode=scrap_delete&"+_para, function(data) {
					data = $.parseJSON(data);
					if(data.msg) alert(data.msg);
					if(data.move) location.href = data.move;
				});
			}
		}
	}


	this.sms_all_delete = function() {
		var form = document.forms['flist'];
		if($(form).find("[name='chk[]']:checked").length<=0) {
			alert("한개이상 선택해주시기 바랍니다.");
		} else {
			if(confirm("삭제하시겠습니까?")) {
				var _para = $(form).serialize();
				$.post(base_url+"/regist.php", "mode=sms_delete&"+_para, function(data) {
					data = $.parseJSON(data);
					if(data.msg) alert(data.msg);
					if(data.move) location.href = data.move;
				});
			}
		}
	}


	this.info_load = function(el) {
		var _page = location.href.split("?");
		location.href = _page[0]+"?load_no="+el.value;
	}



	this.resume_submit = function() {
		var form = document.forms['fwrite'];
		if(validate(form)) {
			var re = true;
			if(re) form.submit();
		}
	}


	this.online_bx_open = function(no) {
		var form = document.forms['freceive1'];
		form.no.value = no;
		$('.detail_ly.mail_ly.online_bx').css({'display':'block'});
	}


	this.company_list_sel = function(el) {
		$.post(base_url+"/regist.php", "mode=company_list_sel&no="+el.value, function(data) {
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			if(data.move) location.href = data.move;
			if(data.row) {
				if(data.row.mb_company_name) $("[name='wr_company_name']").val(data.row.mb_company_name);
				if(data.body) $(".company_info_box").html(data.body);
			}
		});
	}



	this.manager_sel = function(el) {
		$.post(base_url+"/regist.php", "mode=manager_sel&no="+el.value, function(data) {
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			if(data.move) location.href = data.move;
			if(data.row) {
				if(data.row.wr_name) $("[name='wr_person']").val(data.row.wr_name);
				if(data.row.wr_phone) {
					var _phone = data.row.wr_phone.split("-");
					$("[name='wr_phone[]']").eq(0).val(_phone[0]);
					$("[name='wr_phone[]']").eq(1).val(_phone[1]);
					$("[name='wr_phone[]']").eq(2).val(_phone[2]);
				}
				if(data.row.wr_hphone) {
					var _hphone = data.row.wr_hphone.split("-");
					$("[name='wr_hphone[]']").eq(0).val(_hphone[0]);
					$("[name='wr_hphone[]']").eq(1).val(_hphone[1]);
					$("[name='wr_hphone[]']").eq(2).val(_hphone[2]);
				}
				if(data.row.wr_fax) {
					var _fax = data.row.wr_fax.split("-");
					$("[name='wr_fax[]']").eq(0).val(_fax[0]);
					$("[name='wr_fax[]']").eq(1).val(_fax[1]);
					$("[name='wr_fax[]']").eq(2).val(_fax[2]);
				}
				if(data.row.wr_email) {
					var _email = data.row.wr_email.split("@");
					$("[name='wr_email[]']").eq(0).val(_email[0]);
					$("[name='wr_email[]']").eq(1).val(_email[1]);
				}
			}
		});
	}


	this.read_func = function(no, code, type) {
		$.post(base_url+"/regist.php", "mode=get_sms_phone&no="+no+"&code="+code, function(data) {
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			if(data.move) location.href = data.move;
			if(data.tel && type=='tel') eval(data.tel);
			if(data.sms && type=='sms') eval(data.sms);
		});
	}


	this.alba_finish = function( no ){	// 공고 강제 마감
		if(confirm('공고를 강제 마감 하시겠습니까?')){
			$.post(base_url+'/regist.php', "mode=volume_end&no="+no, function(data){
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.move) location.href = data.move;
			});
		}
	}

	this.mb_views = function( field, vals ){  // 정보 공개 유무 체크
		var sel = vals.value;
		var fields = 'mb_' + field + '_view';
		$.post(base_url+'/regist.php', { mode:'member_views', mb_id:mb_id, field:fields, sel:sel, value:field }, function(data){
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
		});
	}

	this.open_resume = function( no, wr_id, type, open_count ){

		if(confirm('사용가능한 열람권이 '+open_count+'건 있습니다\n\n열람권을 사용 하여 이력서를 열람하시겠습니까?')){

			//alert(no+" @ "+wr_id+" @ "+type);

			$.post(base_url+'/regist.php', { mode:'resume_read', no:no, wr_id:wr_id, type:type }, function(data){
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.move) location.replace(data.move);
			});
		}
	}


	// 개인회원 이메일로 아이디찾기
	this.individual_find_id_email = function(){
		var individual_certify_name = $('#individual_certify_name').val();
		var individual_email = $('#individual_email').val();
		var individual_email_tail = $('#individual_email_tail').val();

		var find_email = individual_email+"@"+individual_email_tail;

		$.post('./process/regist.php', { mode:'email_find_id', find_name:individual_certify_name, find_email:find_email }, function(result){

			if(result=='1'){
				alert("이메일 주소 ["+find_email+"] 로 메일이 발송 되었습니다.");
			} else {
				alert("가입된 정보가 확인되지 않습니다.\n\n가입하신 회원명, 이메일주소를 확인하세요.");
			}		

		});
	}
}


var netfu_mjob = new netfu_mjob();


$(window).ready(function(){
	// : 연령클릭
	if($(".age_int__")[0]) {
		$("[name='wr_age_limit']").click(function(){
			switch($(this).val()==1 && $(this)[0].checked) {
				case true:
					$(".age_int__").css({"display":"block"});
					$(".age_int__").find("input").prop("required", true);
					break;

				default:
					$(".age_int__").css({"display":"none"});
					$(".age_int__").find("input").prop("required", false);
					$(".age_int__").find("input").val('');
					break;
			}
		});
	}


	setTimeout(function(){

		var active_num = 0;
		$(".cycle-slideshow.auto_move").find("a").each(function(i){
			var active = $(this).attr("class").indexOf("active");
			if(active>=0) active_num = i;
		});
		for(var i=0; i<active_num-2; i++)
			$(".next_btn.menu_arrow").click();

	},100);
});