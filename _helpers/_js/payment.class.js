var netfu_payment = function() {

	this.point_use = function() {
		var form = document.forms['forder'];
		var point_val = form.use_point.value;
		if(!point_val) point_val = 0;
		if(parseInt(point_val)<=0) {
			alert("포인트를 입력해주시기 바랍니다.");
			return;
		} else {
			$.post(base_url+"/regist.php", "mode=member_point_check&point="+point_val, function(data){
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.js) eval(data.js);
			});
		}

	}

	this.service_check_func = function() {
		var input_sevice = $("input[name='service[]']:checked");
		var select_len = 0;
		$("select[name='service[]']").each(function(){
			if($(this).val()) select_len++;
		});

		return input_sevice.length + select_len;
	}

	this.option_part_check = function() {
		var _allow_count = true;
		$("select.part_option").each(function(){
			var option_name = $(this).closest(".item_box").find(".sname").html();
			var option_obj = $(this).closest(".item_box").find("li.part_option");
			var part_len = option_obj.find("input:checked").length;
			if($(this).val() && part_len<=0) {
				alert(option_name+" 옵션의 종류를 선택해주시기 바랍니다.");
				option_obj.find("input").eq(0)[0].focus();
				_allow_count = false;
			}
		});

		return _allow_count;
	}

	this.order_move = function(f, el) {
		var form = document.forms[f];
		var _len, _tag, val;
		switch(el) {
			case 'all':
				_len = this.service_check_func();
				break;

			default:
				var service_obj = $(el).closest(".item_box");
				_tag = service_obj.find("[name='service[]']")[0].tagName.toLowerCase();
				if(_tag=='select') {
					val = service_obj.find("[name='service[]']").val();
				} else {
					val = service_obj.find("[name='service[]']:checked").val();
				}
				_len = 0
				if(val) _len = 1;
				break;
		}
		
		if(_len<=0) {
			alert("서비스를 하나이상 선택해주시기 바랍니다.");
			return;
		}

		var _allow_count = netfu_payment.option_part_check();
		if(!_allow_count) return;

		// : 다중서비스 신청이 아닌경우 본인 제외한 나머지 초기화시킨후 넘기기.
		if(el!='all') {
			$(form).find("[name='service[]']").each(function(){
				_tag = $(this)[0].tagName.toLowerCase();

				// : 자기자신 서비스를 제외한 모든서비스 취소시키기.
				if($(this)[0]!=service_obj.find("[name='service[]']")[0]) {
					if(_tag=='select') $(this).val('');
					else $(this)[0].checked = false;
				}
			});
		}

		form.submit();
	}


	this.logo_check = function(el, num) {
		var chk = $("[name='service_logo["+num+"]']")[0].checked;
		var _parent = $(el).closest(".service_li_");
		switch(chk) {
			case true:
				_parent.find("td.service_c_").css({"display":"table-cell"});
				_parent.find("div.service_c_").css({"display":"block"});
				break;

			default:
				_parent.find(".service_c_").css({"display":"none"});
				_parent.find("[name='service[]']").find("option").eq(0).prop("selected", true);
				netfu_payment.money_click(_parent.find("[name='service[]']")[0], 'logo');
				break;
		}
	}


	this.gold_check = function(el, num) {
		var chk = $("[name='service_gold["+num+"]']")[0].checked;
		var _parent = $(el).closest(".service_li_");
		switch(chk) {
			case true:
				_parent.find("td.service_c_").css({"display":"table-cell"});
				_parent.find("div.service_c_").css({"display":"block"});
				break;

			default:
				_parent.find(".service_c_").css({"display":"none"});
				_parent.find("[name='service[]']").find("option").eq(0).prop("selected", true);
				netfu_payment.money_click(_parent.find("[name='service[]']")[0], 'gold');
				break;
		}
	}


	this.submit = function(el) {

		var _len = 0;
		$("[name='service[]']").each(function(){
			if($(this).val()) _len++;
		});

		if(_len<=0) {
			alert("서비스를 하나이상 선택해주시기 바랍니다.");
			return;
		}
		var _allow_count = netfu_payment.option_part_check();
		var _pay_method_tag = $(".payment_method_tag");
		if(!_allow_count) return;

		var pay_method = $("[name='pay_method']:checked");
		if(_pay_method_tag.css("display")!='none' && pay_method.length<=0) {
			alert("결제방법을 선택해주시기 바랍니다.");
			return;
		}

		if(pay_method.val()=='bank' && !$("[name='bank_name']").val()) {
			alert("입금자명을 입력해주시기 바랍니다.");
			pay_method[0].focus();
			return;
		}


		if(validate(el)) {
			$.ajax({
				url:el.action,
				type:'post',
				data:$(el).serialize(),
				success:function(data){
					data = $.parseJSON(data);
					if(data.msg) alert(data.msg);
					if(data.move) location.href = data.move;
					else if(!data.msg) {
						if(data.msg) alert(data.msg);
						if(data.html_put) $("body").append(data.html_put);
						
						setTimeout(function(){
							ajax_process(data);
						},500);
					}
					return false;
				}
			});
		}
		return false;
	}


	this.pay_method_click = function() {
		var val = $("[name='pay_method']:checked").val();
		switch(val) {
			case "bank":
				$(".bank_ul").css({"display":"block"});
				break;

			default:
				$(".bank_ul").css({"display":"none"});
				break;
		}
	}


	this.money_click = function(el, part_code) {
		var form = el.form;
		var no_arr = el.value.split("/");
		var _para = $(form).serialize();
		var _put_tag = $(el).attr("put_tag");

		var _chk_se = $(el).closest("table").find("input[type=checkbox]").val();
		$.post(base_url+"/regist.php", _para+"&mode=get_money&val="+el.value+"&no="+no_arr[1]+"&part_code="+part_code+"&chk_se="+_chk_se+"&put_tag="+_put_tag, function(data){
			data = $.parseJSON(data);
			var _service_percent = data.service_percent ? data.service_percent : 0;
			if(data.msg) {
				alert(data.msg);
				$(el).closest(".item_box").find(".box-info2").css({"visibility":"hidden"});
			} else {
				var same_is = data.ori_price_txt==data.sale_price_txt ? true : false;
				$(el).closest(".item_box").find(".service_info1").html(data.service_txt);
				$(el).closest(".item_box").find(".service_info2").html(same_is ? '' : data.ori_price_txt);
				$(el).closest(".item_box").find(".service_info3").find("em").html(_service_percent+'%↓');
				$(el).closest(".item_box").find(".service_info4").html(data.sale_price_txt);
				$(el).closest(".item_box").find(".box-info2").css({"visibility":"visible"});

				if(data.js) eval(data.js);
				if(data.put_tag) {
					$(data.put_tag).html(data.tag);
				}

				if(data.price_hap>0) {
					$(".payment_price_input").find("tbody").eq(1).css({"display":"table-row-group"});
					$(".payment_method_tag").css({"display":"block"});
				} else {
					$(".payment_price_input").find("tbody").eq(1).css({"display":"none"});
					$(".payment_method_tag").css({"display":"none"});
				}

				if(data.price_hap_txt) {
					$("._hap_price").html(data.price_hap_txt);
					$("._result_price").html(data.price_result_txt);
				}
			}
		});
	}



	this.use_service_check = function(el) {
		switch(el.checked) {
			case true:
				$(el).closest(".service_li").find(".option_view_c").removeClass("_none");
				break;

			default:
				var _select = $(el).closest(".service_li").find("select");
				_select.val('');
				$(el).closest(".service_li").find(".option_view_c").addClass("_none");
				if(!el.checked) _select.find("option").removeAttr("selected");
				netfu_payment.money_click(_select[0]);
				break;
		}
	}




	this.tax_num_type = function(el) {
		var txt = $(el).find(":selected").text();
		var obj = $("[name='pay_tax_num_person']");
		obj.attr("hname", txt);
	}


	this.tax_change = function() {
		var tax_use = $("[name='tax_use']");
		var pay_tax_type = $("[name='pay_tax_type']:checked").val();
		$(".tax_type").css({"display":"none"});

		var tax_div_display = $("[name='tax_use']:checked").length<=0 ? 'none' : 'block';
		$(".tax_div").css({"display":tax_div_display});
		if(tax_div_display == 'none') {
			//$("[name='pay_tax_type']").removeAttr("checked");
			$("[name='pay_tax_num_person']").removeAttr("required");
			$("[name='pay_tax_num_biz[]']").removeAttr("required");
			$("[name='pay_tax_num_person']").val('');
			$("[name='pay_tax_num_biz[]']").val('');
		}

		// : 기업정보
		if(pay_tax_type=='2') {
			$(".tax_type_2").css({"display":"block"});
			if(tax_use[0].checked) {
				$("[name='pay_tax_num_biz[]']").attr({"required":true});
				$("[name='pay_tax_num_person']").removeAttr("required");
			}
			
		// : 개인정보
		} else {
			$(".tax_type_1").css({"display":"block"});
			var obj = $("[name='pay_tax_num_person']");
			$("[name='pay_tax_num_biz[]']").removeAttr("required");
			if(tax_use[0].checked) {
				obj.attr({"required":true});
			}
		}
	}
}

var netfu_payment = new netfu_payment();