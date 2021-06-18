<?php
include_once "../include/top.php";

$utility->set_session('ss_delete_token',$token);
$_GET['wr_no'] = $_GET['wr_no'] ? $_GET['wr_no'] : $_GET['no'];
?>

<script type="text/javascript">
var submit_func = function() {
	var form = document.forms['fcon_passwd'];
	form.prev_page.value = location.referer;
	if(validate(form)) {
		form.submit();
		return false;
	}
}


var false_move = function() {
	location.replace("<?=NFE_URL;?>/board/list.php?board_code=<?=$_GET['board_code'];?>&code=<?=$_GET['code'];?>&bo_table=<?=$_GET['bo_table'];?>");
}
</script>

<form name="fcon_passwd" action="<?=NFE_URL;?>/board/regist.php" method="post">
<input type="hidden" name="mode" value="password_confirm"/>
<input type="hidden" name="bo_mode" value="<?php echo $_GET['mode']?>"/>
<input type="hidden" name="prev_page" value=""/>
<input type="hidden" name="board_code" value="<?php echo $_GET['board_code']?>"/>
<input type="hidden" name="code" value="<?php echo $_GET['code']?>"/>
<input type="hidden" name="bo_table" value="<?php echo $_GET['bo_table']?>"/>
<input type="hidden" name="wr_no" value="<?php echo $_GET['wr_no'];?>"/>
<input type="hidden" name="comment_id" value="<?php echo $comment_id;?>"/>
<input type="hidden" name="token" value="<?php echo $token;?>"/>

<div class="layer1 cf passwd_confirm">
	<section class="cont_box community_con">
		<h2><img src="/images/unlock.png" alt="Writer">Нууц үг шалгах</h2>
		<div class="pw_con cf">
			<label for="pw2">Таны оруулсан нууц гү</label><input type="password" id="pw2" name="wr_password" id="password_wr_password" hname="Password" required maxlength="16" style="height:34px;line-height:34px;border:1px solid #dee3eb">
		</div>
	</section>

	<div class="button_con">
		<a href="#none;" class="bottom_btn06" onClick="submit_func()">Батлах</a><a href="javascript:false_move()" class="bottom_btn02">Цуцлах</a>
	</div>
</div>
</form>


<?php
include_once(NFE_PATH.'/include/tail.php');
?>