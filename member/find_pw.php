<?php
$menu_code = 'text';
$menu_text = '비밀번호 찾기';
include_once "../include/top.php";
?>
<style>
.row17 .email{width:26% !important}
.row17 input[type="tel"]{float:left;width:18% !important;float:left;background:#f6fbff;border:1px solid #dee3eb;padding:2px 5px;height:32px;line-height:32px}
</style>
<!-- 개인회원 패스워드 찾기 -->
<script type="text/javascript" src="<?=NFE_URL;?>/member/netfu_member.class.js?time=<?=time();?>"></script>
<form name="fwrite" action="<?=NFE_URL;?>/regist.php" method="post" onSubmit="return false;">
<input type="hidden" name="mode" value="pw_find" />
<div class="find_box">
	<section class="cont_box resume_con find_info" >
		<ul class="info3_con info2_con">
			<li class="row2">
				<label for="name">이름</label>
				<input type="text" name="mb_name" hname="이름" required>
			</li>
			<li class="row2">
				<label for="name">아이디</label>
				<input type="text" name="mb_id" hname="아이디" required>
			</li>
			<li class="row17">
				<label for="email">이메일</label>
				<input type="text" name="mb_email[]" class="email" hname="이메일" required>
				<p>@</p><input type="tel" name="mb_email[]" class="email" hname="이메일" required>
				<select onChange="netfu_util1.put_text(this, $('[name=\'mb_email[]\']').eq(1))" style="margin-right:0">
					<option value="">직접입력</option>
					<?php echo $email_option; ?>
				</select>
			</li>
			<li class="find_bt"><button onClick="netfu_member.find_id()">비밀번호 찾기</button></li>
		</ul>
	</section>
</div>
</form>

<?php
include_once(NFE_PATH.'/include/tail.php');
?>