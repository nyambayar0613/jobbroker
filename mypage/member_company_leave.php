<?php
$page_code = 'mypage';
$menu_text = "회원탈퇴 신청";
include "../include/top.php";

$_cate_['member_left_reason'] = $netfu_util->get_cate_array('member_left_reason', array('where'=>" and `p_code` = ''"));
?>

<script type="text/javascript">
var member_left_submit = function() {
	var form = document.forms['MemberLeftFrm'];
	var agree = $(form).find("[name='left_agreement']:checked");
	var left_reason = $(form).find("[name='left_reason']:checked");
	if(agree.length<=0) {
		alert("동의을 체크해주시기 바랍니다.");
		return;
	} else {
		if(validate(form)) {
			if(left_reason.length<=0) {
				alert("탈퇴사유를 선택해주시기 바랍니다.");
				return;
			} else {
				form.submit();
				return;
			}
		}
	}
	return;
}
</script>


<form method="post" name="MemberLeftFrm" action="<?php echo $alice['member_path'];?>/process/regist.php" id="MemberLeftFrm" enctype="multipart/form-data">
<input type="hidden" name="ajax" value="false"/>
<input type="hidden" name="mode" value="member_left" id="mode"/>
<input type="hidden" name="mb_type" value="<?php echo $member['mb_type'];?>"/>
<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>
<input type="hidden" name="no" value="<?php echo $member['no'];?>"/>
<section class="cont_box remove_con">
	<h2>회원탈퇴 신청</h2>
	<div class="info4_con info_text">
		<ol>
			<li>1. 사용하고 계신 아이디 <strong><?=$member['mb_id'];?></strong>는 재사용 및 복구가 불가능합니다.</li>
			<li>2. 추후 재가입 시 동일한 아이디로 재가입하실 수 없습니다.</li>
			<li>3. 구인정보, 이력서 정보, 구인구직 활동내역, 유료서비스, e-머니가 모두 삭제됩니다.</li>
		</ol>
	</div>
	<div class="info4_con agree"><input type="checkbox" name="left_agreement">위 내용에 동의합니다.</div>
</section>

<section class="cont_box remove_con">
	<ul class="info4_con">					  
		<li class="row_con">
			<label for="member_type">회원구분</label>
			<span><?=$netfu_member->member_kind[$member['mb_type']];?></span>
		</li>
		<li class="row1">
			<label for="id">회원아이디</label>
			<span><?=$member['mb_id'];?></span>
		</li>
		<li class="row2">
			<label for="pw2">비번확인<span class="check"></span></label>
			<input type="password" id="pw2" name="mb_password" required hname="비밀번호" maxlength="16">
		</li>
		<li class="row3">
			<label for="name">이메일<span class="check"></span></label>
			<input type="text" id="name" name="mb_email"  required hname="e-mail" maxlength="">
		</li>
		<li class="row4">
		  <fieldset>
				<legend>탈퇴사유<span class="check"></span></legend>
				<ol>
					<?php
					if(is_array($_cate_['member_left_reason'])) { foreach($_cate_['member_left_reason'] as $k=>$v) {
					?>
					<li><input type="radio" name="left_reason" value="<?=$v['code'];?>"><?=$v['name'];?></li>
					<?php
					} }
					?>
				</ol>
			</fieldset>
		</li>
	</ul>
</section>

<div class="button_con">
	<a href="#none;" onClick="member_left_submit()" class="bottom_btn01">신청</a><a href="#" class="bottom_btn02">취소</a>
</div>
</form>

<?php
include "../include/tail.php";
?>