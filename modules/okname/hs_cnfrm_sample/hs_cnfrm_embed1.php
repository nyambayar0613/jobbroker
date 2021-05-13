<?php
/*
 * 본인확인서비스 요청 정보 입력 화면
 * hs_cnfrm_embed1.php
 */ 
?>
<html>
<head>
<title>KCB 본인확인서비스 샘플</title>
<script>
<!--
	function jsSubmit(){	
		var form1 = document.form1;

		if (form1.name.value == "") {
			alert("성명을 입력해주세요");
			return;
		}

		if (form1.birthday.value == "") {
			alert("생년월일을 입력해주세요");
			return;
		}

		if (form1.tel_cmm_cd.value == "") {
			alert("통신사코드를 입력해주세요");
			return;
		}
		if (form1.mbphn_no.value == "") {
			alert("휴대폰번호를 입력해주세요");
			return;
		}

		form1.submit();
	}
//-->
</script>
</head>
<body>
	<form name="form1" action="hs_cnfrm_embed2.php" method="post">
		<table>
			<tr>
				<td colspan="2"><strong> - KCB 인증정보 입력용</strong></td>
			</tr>
			<tr>
				<td>성명</td>
				<td>
					<input type="text" name="name" maxlength="20" size="20" value="">
				</td>
			</tr>
			<tr>
				<td>생년월일</td>
				<td>
					<input type="text" name="birthday" maxlength="8" size="10" value=""> (예:'19700101')
				</td>
			</tr>
			<tr>
				<td>성별</td>
				<td>
					<input type="radio" name="gender" value="1" checked>남
					<input type="radio" name="gender" value="0">여
			</tr>
			<tr>
				<td>내외국인구분</td>
				<td>
					<input type="radio" name="nation" value="1" checked>내국인
					<input type="radio" name="nation" value="2">외국인
			</tr>
			<tr>
				<td>휴대폰</td>
				<td>
					<select name="tel_cmm_cd">
						<option value="01">SKT</option>
						<option value="02">KTF</option>
						<option value="03">LGU+</option>
					</select>
					<input type="text" name="mbphn_no" maxlength="11" size="15" value=""> ('-'없이 입력)
				</td>
			</tr>
			<tr>
				<td>인증요청사유코드</td>
				<td>
					<select name="rqst_caus_cd">
						<option value="00">회원가입</option>
						<option value="01">성인인증</option>
						<option value="02">회원정보수정</option>
						<option value="03">비밀번호찾기</option>
						<option value="04">상품구매</option>
						<option value="99">기타</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="button" value="확인" onClick="jsSubmit();"></td>
			</tr>
		</table>
	</form>
</body>
</html>
