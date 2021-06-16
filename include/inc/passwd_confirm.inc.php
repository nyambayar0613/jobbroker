<!-- 패스워드 확인 -->
<style type="text/css">
.passwd_confirm { position:absolute; top:9999px; background-color:#fff; height:200px; border:1px solid #ddd; width:80%; text-align:center; margin:0 auto; }
</style>
<form name="fcon_passwd" action="<?=NFE_URL;?>/regist.php" method="post">
<input type="hidden" name="mode" value="passwd_confirm" />
<input type="hidden" name="board_code" value="<?=$_GET['board_code'];?>" />
<input type="hidden" name="code" value="<?=$_GET['code'];?>" />
<input type="hidden" name="bo_table" value="<?=$_GET['bo_table'];?>" />
<input type="hidden" name="no" value="<?=$_GET['no'];?>" />
<div class="layer1 cf passwd_confirm">
	<section class="cont_box community_con">
		<h2><img src="/images/unlock.png" alt="글작성">Password шалгана уу.</h2>
		<div class="pw_con cf">
			<label for="pw2">Оруулсан password</label><input type="password" id="pw2" name="" maxlength="16">
		</div>
	</section>

	<div class="button_con">
		<a href="#" class="bottom_btn06">Батлах</a><a href="#" class="bottom_btn02">Цуцлах</a>
	</div>
</div>
</form>

<script type="text/javascript">
var con_pass_form = document.forms['fcon_passwd'];
$("._con_passwd").click(function(){
	var _offset = $(this).offset();
	$(".passwd_confirm").css({"top":_offset.top});
});
</script>