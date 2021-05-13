var netfu_auth = function() {

	this.auth_read = false;

	// : auth_engine변수는 adult.php에서 합니다.
	this.click_auth = function(val) {
		var func = 'netfu_auth.'+auth_engine+'_'+val+'()';
		eval(func);
	}




	// : kcb

	this.kcb_ipin = function() {
		var popupWindow = window.open("", "kcbPop", "left=200, top=100, status=0, width=450, height=550");
		var form = document.form_auth;
		form.action = form.action_ipin.value;
		form.target = "kcbPop";
		form.submit();
	}

	this.kcb_sms = function() {
		var form = document.forms['form_auth'];
		var action = form.action_sms.value;
		
		window.name ="Parent_window";
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_auth.action = action;
		document.form_auth.target = "popupChk";
		document.form_auth.submit();
	}
}

var netfu_auth = new netfu_auth();