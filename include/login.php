<?php
$cat_path = $_SERVER['DOCUMENT_ROOT'].'/';
include_once $cat_path."_engine.php";
if($member['mb_id']) {
	$utility->popup_msg_js("",NFE_URL.'/');
}

include_once "../include/top.php";
?>
<script type="text/javascript">
$(window).ready(function(){
	var form = document.forms['MemberLoginFrm'];
	$(".tab_bt").click(function(){
		var k = $(this).attr("k");
		$(".tab_bt").find("a").removeClass("active");
		$(this).find("a").addClass("active");
		$(form).find("[name='mb_type']").val(k);

		<?php if($is_demo) {?>
		var login_uid = {'company':'test_company', 'individual':'test_indi'};
		form.login_id.value = login_uid[k];
		form.login_passwd.value = login_uid[k];
		<?php }?>
	});
});
</script>


<div class="top_title">
<a href="#"><img src="<?=NFE_URL;?>/images/top_arrow.png" alt="Өмнөх"></a><h2>Log in</h2>
</div>
</header>
<form method="post" name="MemberLoginFrm" action="<?=NFE_URL;?>/regist.php" onSubmit="return netfu_util1.member_logins(this)">
<input type="hidden" name="mode" value="login_process"/>
<input type="hidden" name="url" value="<?php echo urlencode($_SERVER['HTTP_REFERER']);?>"/>
<input type="hidden" name="mb_type" value="individual"/>

<?php
$_banner = 'etc_login_top';
include NFE_PATH.'/include/inc/banner.inc.php';
?>

<div id="main" class="cf">
	<div class="container">
		<div class="login_box">
			<div class="tabs cf">
				<ul>
					<li class="tab1 tab_bt" k="individual"><a href="#none;" class="active">Хувь хүн</a></li>
					<li class="tab2 tab_bt" k="company"><a href="#none;">Байгууллага</a></li>
				</ul>
			</div>
			<div class="login_con cf">
				<ul>
					<li class="id"><label for="mb_id">ID</label><input type="text" name="login_id" value="<?=($is_demo) ? 'test_indi' : '';?>" required hname="ID" id="mb_id" title="ID оруулах" maxlength="41"></li>
					<li class="pw"><label for="mb_pw">Нууц</label><input type="password" value="<?=($is_demo) ? 'test_indi' : '';?>" name="login_passwd" required hname="Нууц үг" id="mb_pw" title="Password оруулах" maxlength="16"></li>
					<li class="login_bt"><button>Log in</button></li>
					<li class="etc">
						<ol>
							<li><a href="<?=NFE_URL;?>/member/find_id.php"><span>ID хайх</span></a></li>
							<li><a href="<?=NFE_URL;?>/member/find_pw.php"><span>Нууц үг хайх</span></a></li>
							<li><a href="<?=NFE_URL;?>/member/register.php"><span>Гишүүнээр нэвтрэх</span></a></li>
						</ol>
					</li>
				</ul>
			</div>
		</div>
	<!-- </div>
</div> -->
</form>

<?php
include_once(NFE_PATH.'/include/tail.php');
?>