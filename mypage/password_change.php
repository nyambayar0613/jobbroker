<?php
$head_title = '비밀번호변경';
$page_code = 'mypage';
include "../include/top.php";
?>

<form name="fwrite" action="../regist.php" method="post" onSubmit="return validate(this)">
<input type="hidden" name="mode" value="password_update" />
<section class="cont_box modify2_con">
	<h2>비밀번호 변경</h2>
		<ul class="bx_con">
			<li class="row1">
				<label for="pw1">현재비밀번호<span class="check"></span></label>
				<input type="password" id="pw1" name="mb_password" maxlength="16" required hname="비밀번호">
			</li>
			<li class="row1">
				<label for="pw2">새로운비밀번호<span class="check"></span></label>
				<input type="password" id="pw2" name="new_password" maxlength="16" required hname="비밀번호" option="userpw">
			</li>
			<li class="row1">
				<label for="pw3">새비밀번호확인<span class="check"></span></label>
				<input type="password" id="pw3" name="new_password_re" maxlength="16" required hname="비밀번호확인" option="userpw" matching="new_password">
			</li>
		</ul>
	</h2>
	<div><input type="submit" class="submit_bt" value="변경하기" style="width:98%;font-family:'NG_B';margin:1%;height:34px;line-height:34px;padding-top:0;padding-bottom:0;background:#4572a5;color:#fff;border:0"/></div>
</section>
</form>

<?php
include "../include/tail.php";
?>