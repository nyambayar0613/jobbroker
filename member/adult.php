<?php
$allow = true;
if($member['mb_id']) $allow = false; // : 로그인 여부
if($_SESSION['certify_info']) $allow = false; // : 본인인증, IPIN체크여부
if(!$env['use_hphone'] && !$env['use_ipin']) $allow = false; // : 본인확인, IPIN 둘다 사용안하면 인증안함.
if(!$env['use_adult']) $allow = false; // : 성인인증.
if($is_admin) $allow = false; // : 관리자 로그인시
if(!$allow) return false;

include NFE_PATH.'/engine/netfu_auth.class.php';
$netfu_auth = new netfu_auth();
?>

<style type="text/css">
.adult_div { position:absolute; background-color:#fff; z-index:20001; margin:10px; margin-top:99px; }
</style>
<script type="text/javascript">
var auth_engine = "<?=$netfu_auth->engine;?>";
//var display = $(".right_nav_body").css("display")=='none' ? 'block' : 'none';
//$(".right_nav_body").css({"display":display});
$(window).ready(function(){
	var form = document.forms['MemberLoginFrm'];
	$(".tab_bt").click(function(){
		var k = $(this).attr("k");
		$(".tab_bt").find("a").removeClass("active");
		$(this).find("a").addClass("active");
		$(form).find("[name='mb_type']").val(k);
	});
});
</script>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/netfu_auth.class.js?time=<?=time();?>"></script>

<div class="wrap_bg_div">
<div class="adult_div">
<?php
if($env['use_adult']) {
?>
<section class="adult_con cf">
	<h2>Насанд хүрсэн баталгаажуулалт</h2>

	<div class="text-group cf">
		<p><img src="<?=NFE_URL;?>/images/adult.png" alt="Насанд хүрсэн баталгаажуулалт"><em>Энэхүү мэдээллийн агуулга нь Мэдээлэл, харилцаа холбооны сүлжээг ашиглах, мэдээллийн хамгаалалтыг дэмжих тухай хууль, Залуучуудыг хамгаалах тухай хуулийн дагуу.</em>
		<strong>19-өөс доош насны хүүхдийг зөвшөөрөхгүй.</strong>
		<b>19 нас хүрээгүй байгаа бол</b>
            Except for juvenile harmful media<span><?=$env['site_name'];?></span>You can use all contents and services of
		</p>
	</div>
	<div class="button_con button_con5">
		<a href="#none;" class="bottom_btn05" onClick="history.back()">19-өөс доош настай</a>
	</div>
</section>
<?php }?>
<section class="confirm_con cf">
	<h2>Баталгаажуулах</h2>
		<div class="confirm_wrap">
			<?php
			if($env['use_ipin']) {
			?>
			<a href="#none;" onClick="netfu_auth.click_auth('ipin')">
				<div class="confirm_bt cf">
					<div class="bt-icon"><img src="<?=NFE_URL;?>/images/ipin.png" alt="IPIN батлах" width="25"></div>
					<div class="bt-txt">IPIN батлах</div>
				</div>
			</a>
			<?php }
			
			if($env['use_hphone']) {
			?>
			<a href="#none;" onClick="netfu_auth.click_auth('sms')">
				<div class="confirm_bt cf">
					<div class="bt-icon"><img src="<?=NFE_URL;?>/images/cellPhone.png" alt="Дугаараар баталгаажуулах" width="15"></div>
					<div class="bt-txt">Дугаараар баталгаажуулах</div>
				</div>
			</a>
			<?php }?>
		</div>
</section>

<form method="post" name="MemberLoginFrm" action="<?=NFE_URL;?>/regist.php">
<input type="hidden" name="mode" value="login_process"/>
<input type="hidden" name="url" value="<?php echo urlencode($_SERVER['HTTP_REFERER']);?>"/>
<input type="hidden" name="mb_type" value="individual"/>
<section class="login_box cf">
	<h2>Гишүүн нэвтрэх</h2>
	<div class="tabs cf">
		<ul>
			<li class="tab1 tab_bt" k="individual"><a href="#none;" class="active">Хувь хүн</a></li>
			<li class="tab2 tab_bt" k="company"><a href="#none;">Байгууллага</a></li>
		</ul>
	</div>
	<div class="login_con cf">
		<ul>
			<li class="id"><label for="mb_id">ID</label><input type="text" id="mb_id" name="login_id" title="ID оруулах" required hname="ID" maxlength="41"></li>
			<li class="pw"><label for="mb_pw">Нууц үг</label><input type="password" id="mb_pw" name="login_passwd" required hname="Нууц үг" title="Нууц үг оруулах" maxlength="16"></li>
			<li class="login_bt"><button type="button" onClick="netfu_util1.member_logins()">Нэвтрэх</button></li>
			<!--
			<li class="etc">
				<ol>
					<li><a href="<?=NFE_URL;?>/member/find_id.php"><span>아이디 찾기</span></a></li>
					<li><a href="<?=NFE_URL;?>/member/find_pw.php"><span>비밀번호 찾기</span></a></li>
					<?
					// : 실명인증을 해야 회원가입으로 가므로 이건 없앱니다.
					/*
					<li><a href="<?=NFE_URL;?>/member/register.php"><span>회원가입</span></a></li>
					*/?>
				</ol>
			</li>
			-->
		</ul>
	</div>
</section>
</form>
<!-- //성인인증 -->
</div>
<div class="wrap_bg"></div>
</div>

<?php
if($netfu_auth->engine=='kcb') {
	include_once NFE_PATH.'/plugin/auth/kcb/auth_start.php';
} else {
	//include_once "";
}
?>