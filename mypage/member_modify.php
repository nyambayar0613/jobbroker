<?php
$editor_use = true;
include "../engine/db_start.php";
$head_title = $menu_text = $member['mb_type']=='company' ? '기업정보수정' : "개인정보수정";

$page_code = 'mypage';
$menu_text = $member['mb_type']=='company' ? '기업정보수정' : "개인정보수정";
include "../include/top.php";
?>
<script type="text/javascript" src="<?=NFE_URL;?>/member/netfu_member.class.js?time=<?=time();?>"></script>
<script type="text/javascript">
var mem_submit = function(el) {
	var form = document.forms['fmember'];
	if(validate(form)) {
		form.submit();
	}
}
</script>

<form name="fmember" action="<?=NFE_URL;?>/regist.php" method="post" enctype="multipart/form-data" onSubmit="return mem_submit(this)">
<input type="hidden" name="mode" value="member_write" />
<section class="cont_box modify3_con">
	<h2>비밀번호 확인</h2>
		<ul class="bx_con">
			<li class="row_con">
				<label for="member_id">회원아이디<span class="check"></span></label>
				<span><?=$member['mb_id'];?></span>
			</li>
			<li class="row_con">
				<label for="pw3">비번확인<span class="check"></span></label>
				<input type="password" name="password_confirm" hname="비밀번호" required maxlength="16">
			</li>
		</ul>
	</h2>
</section>

<?php
include NFE_PATH.'/member/inc/'.$member['mb_type'].'.inc.php';
?>

<div class="button_con">
	<a href="javascript:mem_submit(this)" class="bottom_btn01">수정</a><a href="javascipt:document.forms[''].reset()" class="bottom_btn02">취소</a>
</div>
</form>

<?php
include "../include/tail.php";
?>