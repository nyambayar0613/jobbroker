<html>
<head>
<script language="JavaScript">
//<!--
	function jsSubmit(){	
		var popupWindow = window.open("", "kcbPop", "left=200, top=100, status=0, width=450, height=550");
		var form1 = document.form1;
		form1.target = "kcbPop";
		form1.submit();

		popupWindow.focus()	;
	}
//-->
</script>
</head>
<body>
	<form name="form1" action="ipin2.php" method="post">
		<table>
			<tr>
				<td colspan="2"><strong> - 아이핀 인증</strong></td>
			</tr>
			<tr>
				<td colspan="2" align="center">	<input type="button" value="아이핀" onClick="jsSubmit();"></td>
			</tr>
		</table>
	</form>
	<form name="kcbOutForm" method="post">
		<input type="hidden" name="encPsnlInfo" />
		<input type="hidden" name="virtualno" />
		<input type="hidden" name="dupinfo" />
		<input type="hidden" name="realname" />
		<input type="hidden" name="cprequestnumber" />
		<input type="hidden" name="age" />
		<input type="hidden" name="sex" />
		<input type="hidden" name="nationalinfo" />
		<input type="hidden" name="birthdate" />
		<input type="hidden" name="coinfo1" />
		<input type="hidden" name="coinfo2" />
		<input type="hidden" name="ciupdate" />
		<input type="hidden" name="cpcode" />
		<input type="hidden" name="authinfo" />
	</form>
</body>
</html>
