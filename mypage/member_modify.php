<?php
$editor_use = true;
include "../engine/db_start.php";
$head_title = $menu_text = $member['mb_type']=='company' ? 'Хувийн мэдээлэл засварлах' : "Хувийн мэдээлэл засварлах";

$page_code = 'mypage';
$menu_text = $member['mb_type']=='company' ? 'Байгууллагын мэдээлэл засварлах' : "Байгууллагын мэдээлэл засварлах";
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
	<h2>Нууц үг баталх</h2>
		<ul class="bx_con">
			<li class="row_con">
				<label for="member_id">Гишүүний ID<span class="check"></span></label>
				<span><?=$member['mb_id'];?></span>
			</li>
			<li class="row_con">
				<label for="pw3">Нууц үг батлах<span class="check"></span></label>
				<input type="password" name="password_confirm" hname="Нууц үг" required maxlength="16">
			</li>
		</ul>
	</h2>
</section>

<?php
include NFE_PATH.'/member/inc/'.$member['mb_type'].'.inc.php';
?>

<div class="button_con">
	<a href="javascript:mem_submit(this)" class="bottom_btn01">Батлах</a><a href="javascipt:document.forms[''].reset()" class="bottom_btn02">Цуцлах</a>
</div>
</form>

<?php
include "../include/tail.php";
?>