<?php
$menu_code = 'text';
$menu_text = 'ID хайх';
include_once "../include/top.php";
?>
<style type="text/css">
.individual_box { display:none; }

.row17 .email{width:26% !important}
.row17 input[type="tel"]{float:left;width:18% !important;float:left;background:#f6fbff;border:1px solid #dee3eb;padding:2px 5px;height:32px;line-height:32px}
</style>
<script type="text/javascript" src="<?=NFE_URL;?>/member/netfu_member.class.js?time=<?=time();?>"></script>
<!-- 개인회원 아이디 찾기 -->
<form name="fwrite" action="<?=NFE_URL;?>/regist.php" method="post" onSubmit="return false;">
<input type="hidden" name="mode" value="id_find" />
<div class="find_box">
	<section class="cont_box resume_con find_info">
		<ul class="info3_con info2_con">
			<li class="row2">
				<label for="name">Нэр</label>
				<input type="text" name="mb_name" hname="Нэр" required>
			</li>
			<li class="row17">
				<label for="email">И-мэйл</label>
				<input type="text" name="mb_email[]" class="email" hname="И-мэйл" required>
				<p>@</p><input type="tel" name="mb_email[]" class="email" hname="И-мэйл" required>
				<select onChange="netfu_util1.put_text(this, $('[name=\'mb_email[]\']').eq(1))" style="margin-right:0">
					<option value="">Мэйл</option>
					<?php echo $email_option; ?>
				</select>
			</li>
			<li class="find_bt"><button onClick="netfu_member.find_id()">ID хайх</button></li>
		</ul>
	</section>
</div>
</form>


<?php
include_once(NFE_PATH.'/include/tail.php');
?>