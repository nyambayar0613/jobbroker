<?php
	header('Content-Type: text/html; charset=euc-kr');
	//**************************************************************************
	// 파일명 : hs_cnfrm_popup1.php
	//
	// 본인확인서비스 요청 정보 입력 화면
	//
	//**************************************************************************
?>
<html>
<head>
<title>KCB 본인확인서비스 샘플</title>
<style type="text/css">
.table_style ul {
 clear: left;
 margin: 0; 
 padding: 0; 
 list-style-type: none; 
}
.table_style ul li {
 float: left;
 margin: 0;
 padding: 2px 1px;
}
.table_style ul .column1 {
 width: 140px; 
}
</style>
<script>
<!--
	function jsSubmit(){	
		var form1 = document.form1;
		var inTpBit = "";

		inTpBit = form1.in_tp_bit.value;

		if (inTpBit & 1) {
			if (form1.name.value == "") {
				alert("성명을 입력해주세요");
				return;
			}
		}
		if (inTpBit & 2) {
			if (form1.birthday.value == "") {
				alert("생년월일을 입력해주세요");
				return;
			}
		}
		if (inTpBit & 8) {
			if (form1.tel_com_cd.value == "") {
				alert("통신사코드를 입력해주세요");
				return;
			}
			if (form1.tel_no.value == "") {
				alert("휴대폰번호를 입력해주세요");
				return;
			}
		}

		window.open("", "auth_popup", "width=430,height=590,scrollbar=yes");

		var form1 = document.form1;
		form1.target = "auth_popup";
		form1.submit();
	}

	function input_display() {
		if (document.form1.in_tp_bit.value == '0') {
			document.getElementById('divInput').style.display = 'none';
		}
		else {
			document.getElementById('divInput').style.display = 'block';
		}
	}
//-->
</script>
</head>
<body>
<form name="form1" action="hs_cnfrm_popup2.php" method="post">
	<div>
		<strong> - KCB 인증정보 입력용</strong>
	</div>
	<div class="table_style">
		<ul>
			<li class="column1">인증요청사유코드</li>
			<li>
				<select name="rqst_caus_cd">
					<option value="00">회원가입</option>
					<option value="01">성인인증</option>
					<option value="02">회원정보수정</option>
					<option value="03">비밀번호찾기</option>
					<option value="04">상품구매</option>
					<option value="99">기타</option>
				</select>
			</li>
		</ul>
		<ul>
			<li class="column1">입력유형</li>
			<li>
				<?php
				// 입력유형은 다음의 조합을 따릅니다.
				//  1 : 0001 - 성명
				//  2 : 0010 - 생년월일
				//  3 : 0011 - 생년월일 + 성명 
				//  4 : 0100 - 성별,내외국인구분
				//  5 : 0101 - 성별,내외국인구분 + 성명
				//  6 : 0110 - 성별,내외국인구분 + 생년월일
				//  7 : 0111 - 성별,내외국인구분 + 생년월일 + 성명
				//  8 : 1000 - 통신사,휴대폰번호
				//  9 : 1001 - 통신사,휴대폰번호 + 성명
				// 10 : 1010 - 통신사,휴대폰번호 + 생년월일
				// 11 : 1011 - 통신사,휴대폰번호 + 생년월일 + 성명
				// 12 : 1100 - 통신사,휴대폰번호 + 성별,내외국인구분
				// 13 : 1101 - 통신사,휴대폰번호 + 성별,내외국인구분 + 성명
				// 14 : 1110 - 통신사,휴대폰번호 + 성별,내외국인구분 + 생년월일
				// 15 : 1111 - 통신사,휴대폰번호 + 성별,내외국인구분 + 생년월일 + 성명
				?>
				<select name="in_tp_bit" onchange="input_display();">
					<option value="0">KCB팝업에서 모든 정보를 입력<br/>
					<option value="7">성명+생년월일+성별,내외국인구분을 파라미터로 넘김<br/>
					<option value="8">통신사,휴대폰번호를 파라미터로 넘김<br/>
					<option value="15">성명+생년월일+성별,내외국인구분+통신사,휴대폰번호를 파라미터로 넘김<br/>
				</select>
			</li>
		</ul>
		<div id="divInput" style="display: none;">
			<ul>
				<li class="column1">성명</li>
				<li>
					<input type="text" name="name" maxlength="20" size="20" value="">
				</li>
			</ul>
			<ul>
				<li class="column1">생년월일</li>
				<li>
					<input type="text" name="birthday" maxlength="8" size="10" value="">
				</li>
			</ul>
			<ul>
				<li class="column1">성별</li>
				<li>
					<input type="radio" name="sex" value="1" checked>남
					<input type="radio" name="sex" value="0">여
			</ul>
			<ul>
				<li class="column1">내외국인구분</li>
				<li>
					<input type="radio" name="nation" value="1" checked>내국인
					<input type="radio" name="nation" value="2">외국인
			</ul>
			<ul>
				<li class="column1">휴대폰</li>
				<li>
					<select name="tel_com_cd">
						<option value="">통신사선택</option>
						<option value="01">SKT</option>
						<option value="02">KT</option>
						<option value="03">LGU+</option>
						<option value="04">알뜰폰SKT</option>
						<option value="05">알뜰폰KT</option>
						<option value="06">알뜰폰LGU+</option>
					</select>
					<input type="text" name="tel_no" maxlength="11" size="15" value="">
				</li>
			</ul>
		</div>
	</div>
	<div>
		<input type="button" value="본인확인" onClick="jsSubmit();">
	</div>
</form>

<!-- 본인확인 처리결과 정보 -->
<form name="kcbResultForm" method="post" >
	<input type="hidden" name="mem_id" 					value="" 	/>
	<input type="hidden" name="svc_tx_seqno"			value=""	/>
	<input type="hidden" name="rqst_caus_cd"			value="" 	/>
	<input type="hidden" name="result_cd" 				value="" 	/>
	<input type="hidden" name="result_msg" 				value="" 	/>
	<input type="hidden" name="cert_dt_tm" 				value="" 	/>
	<input type="hidden" name="di" 						value="" 	/>
	<input type="hidden" name="ci" 						value="" 	/>
	<input type="hidden" name="name" 					value="" 	/>
	<input type="hidden" name="birthday" 				value="" 	/>
	<input type="hidden" name="sex" 					value="" 	/>
	<input type="hidden" name="nation" 					value="" 	/>
	<input type="hidden" name="tel_com_cd" 				value="" 	/>
	<input type="hidden" name="tel_no" 					value="" 	/>
	<input type="hidden" name="return_msg" 				value="" 	/>
</form>  
</body>
</html>
