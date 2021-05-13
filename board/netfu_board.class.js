var netfu_board = function() {

// : 댓글쓰기
	this.reply_write = function(el) {
		var form = document.forms['fviewcomment'];
		if(validate(form)) {
			var _key = $(form).find("[name='wr_key']").val();
			$.post("/regist.php", "mode=rand_num_check&word="+_key, function(data){
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				else {
					form.mode.value = 'board_reply_write';
					form.text_key.value = -1;
					form.comment_id.value = "";
					netfu_util1.ajax_submit(form);
					return false;
				}
			});
		}
		return false;
	}

	this.write_required_control = function(code) {
		var form = document.forms['fviewcomment'];
		switch(code) {
			case "remove":
				$(form).find(".cmt_write").find("input").removeAttr("required");
				$(form).find(".cmt_write").find("textarea").removeAttr("required");
				break;

			default:
				$(form).find(".cmt_write").find("input").attr("required", true);
				$(form).find(".cmt_write").find("textarea").attr("required", true);
				break;
		}
	}

// : 댓글의 답글쓰기
	this.reply_reply_write = function(el, no, code) {
		var form = document.forms['fviewcomment'];
		form.mode.value = 'board_reply_write';
		var textarea_key = $(el).index("button._button");
		var _para = $(form).serialize();
		var name_obj = $("[name='reply_name[]']").eq(textarea_key);
		var password_obj = $("[name='reply_password[]']").eq(textarea_key);
		var wr_key_obj = $("[name='reply_wr_key[]']").eq(textarea_key);
		var content_obj = $("[name='wr_content[]']").eq(textarea_key);
		form.comment_id.value = no;
		form.text_key.value = textarea_key;
		this.write_required_control('remove');
		$.post(base_url+"/board/regist.php", "mode=rand_number_check&no="+no+"&wr_key="+wr_key_obj.val(), function(data){
			alert(data);
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			else netfu_util1.ajax_submit(form);
			this.write_required_control('add');
		});
		return false;
	}

// : 수정버튼
	this.reply_update = function(el, no) {
		var form = document.forms['fviewcomment'];
		form.mode.value = "board_reply_modify";
		form.comment_id.value = no;
		var _hidd = $(form).find("input[type=hidden]").serialize();
		form.reply_mode.value = "modify";
		$.post("../regist.php", _hidd+"&mode=board_reply_password", function(data){
			data = $.parseJSON(data);
			eval(data.modify);
		});
	}

// : 패스워드
	this.reply_password = function(el, no) {
		$(".del_con").addClass("_none");
		$(el).closest(".reply_box").parent().find(".del_con").removeClass("_none");
	}

// : 삭제버튼
	this.reply_delete = function(el, no) {
		var form = document.forms['fviewcomment'];
		form.mode.value = "board_reply_delete";
		form.reply_mode.value = "delete";
		form.comment_id.value = no;
		var _para = $(form).serialize();
		$.post(base_url+"/board/regist.php", _para+"&mode=reply_delete_chk", function(data){
			data = $.parseJSON(data);
			if(data.js) {
				eval(data.js);
			} else {
				$(".del_con").addClass("_none");
				$(el).closest(".reply_box").parent().find(".del_con").removeClass("_none");
			}
		});
	}

// : 답변버튼
	this.reply_reply = function(el, code, no) {
		var form = document.forms['fviewcomment'];
		if(code) form.reply_mode.value = code;
		var _parent = $("#c_"+no);
		var _content = _parent.find(".reply_txt").html();
		_parent.find("[name='reply_content[]']").val(_content.replace(/<br>/gi, '\r'));
		$(".comment_con.reply_reply_write").css("display", "none");
		setTimeout(function(){
			$(el).closest(".reply_box").parent().find(".comment_con.reply_reply_write").css("display", "block");
		},100);
	}

// : 수정,삭제 처리
	this.reply_process = function(el, no) {
		var form = document.forms['fviewcomment'];
		var _para = $(form).serialize();

		if(form.reply_mode.value=='delete' && !confirm("삭제하시겠습니까?")) return;

		var passwd = $(el).closest("#c_"+no).find("[name='reply_confirm_password[]']").val();
		$.post(base_url+"/board/regist.php", _para+"&mode=password_confirm&bo_mode=comment_update&comment_id="+no+"&passwd="+passwd, function(data){
			data = $.parseJSON(data);
			if(data.msg) alert(data.msg);
			if(data.move) location.href = data.move;
			if(data.js) eval(data.js);
			$(".del_con").addClass("_none");
			return false;
		});
		return false;
	}
}


var netfu_board = new netfu_board();