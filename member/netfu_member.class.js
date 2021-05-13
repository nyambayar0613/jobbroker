var netfu_member = function() {

	this.dupl_mid = function(val) {
		$.post(base_url+"/regist.php", "mode=dupl_mid&val="+val, function(data){
			data = $.parseJSON(data);
			if(data.txt) alert(data.txt);
			if(data.js) eval(data.js);
		});
	}


	this.dupl_nick = function(val) {
		$.post(base_url+"/regist.php", "mode=dupl_nick&val="+val, function(data){
			data = $.parseJSON(data);
			if(data.txt) alert(data.txt);
			if(data.js) eval(data.js);
		});
	}



	this.find_id = function() {
		var form = document.forms['fwrite'];
		if(validate(form)) {
			var _para = $(form).serialize();
			$.post(base_url+"/regist.php", _para, function(data) {
				data = $.parseJSON(data);
				if(data.msg) alert(data.msg);
				if(data.move) location.href = data.move;
			});
		}
		return;
	}
}


var netfu_member = new netfu_member();