<?php
$editor_use = true;
$page_code = 'mypage';
$head_title = $menu_text = "세금계산서 발행신청";
include "../include/top.php";

$_biz_no = explode("-", $member_com['mb_biz_no']);
$_mb_email = explode("@", $member_com['mb_biz_email']);
$_mb_biz_phone = explode("-", $member_com['mb_biz_phone']);
$tel_num_option = $config->get_tel_num($_mb_biz_phone[0]);
?>

<form name="fwrite" action="../regist.php" method="post">
<input type="hidden" name="mode" value="tax_write" />
<section class="cont_box taxbill_con">
	<h2>세금계산서 발생신청</h2>
	<ol class="info3_con">
		<li>1. 유료서비스 신청후 세금계산서 발행신청시 발행해드리고 있습니다. 단, 결제완료 후 세금계산서가 발행되오니 이 점 숙지하시기 바랍니다.</li>
		<li>2. <span class="check"></span>표시는 필수 입력사항입니다.</li>
	</ol>
	<ul class="info3_con">
		<li class="row1">
			<fieldset>
				<legend>사업자번호<span class="check"></span></legend>
				<input type="text" id="" name="wr_biz_no[]" value="<?=$_biz_no[0];?>">
				<p>-</p>
				<input type="text" id="" name="wr_biz_no[]" value="<?=$_biz_no[1];?>">
				<p>-</p>
				<input type="text" id="" name="wr_biz_no[]" value="<?=$_biz_no[2];?>">
			</fieldset>
		</li>
		<li class="row2">
			<label for="company">회사명<span class="check"></span></label>
			<input type="text" id="company" name="wr_company_name" value="<?=$member_com['mb_company_name'];?>">
		</li>
		<li class="row3">
			<label for="ceo">대표자명<span class="check"></span></label>
			<input type="text" id="ceo" name="wr_ceo_name" value="<?=$member_com['mb_ceo_name'];?>">
		</li>
		<li class="row4">
			<?php
			include NFE_PATH.'/include/inc/post.inc.php';
			?>
			<fieldset>
				<legend>주소<span class="check"></span></legend>
				<input type="text" size="4" maxlength="4" id="mb_doro_post" name="wr_doro" value="<?=$member_com['mb_biz_doro_post'];?>" class="post">
				<input type="text" maxlength="" id="mb_address0" name="wr_address0" value="<?=$member_com['mb_biz_address0'];?>" class="address1">
				<button type="botton" class="form_bt form_bt2" onClick="post_click(); return false;">우편번호</button>
				<div class="cf">
				 <input type="text" id="" name="wr_address1" value="<?=$member_com['mb_biz_address1'];?>" class="address2" placeholder="상세주소를 입력하세요.">
				</div>
			</fieldset>
		</li>
		<li class="row5">
			<label for="types">업태<span class="check"></span></label>
			<input type="text" id="types" name="wr_condition">
		</li>
		<li class="row6">
			<label for="items">종목</label>
			<input type="text" id="items" name="wr_item">
		</li>
		<li class="row7">
			<fieldset>
				<legend>이메일<span class="check"></span></legend>
					<input type="tel" name="wr_email[]" value="<?=$_mb_email[0];?>" class="email">
					<p>@</p><input type="tel" name="wr_email[]" value="<?=$_mb_email[1];?>" id="put_email" class="email">
					<select onChange="netfu_util1.put_text(this, $('#put_email'))">
						<option value="">직접입력</option>
						<?php echo $email_option; ?>
					</select>
			</fieldset>
		</li>
		<li class="row8">
			<label for="types">담당자명<span class="check"></span></label>
			<input type="text" id="types" name="wr_manager">
		</li>
		<li class="row9">
			<fieldset>
				<legend>연락처<span class="check"></span></legend>
				<select name="wr_phone[]">
					<?php echo $tel_num_option; ?>
				</select>
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_phone[]" value="<?=$_mb_biz_phone[1];?>" class="cel1 phone1">
				<p>-</p><input type="tel" size="4" maxlength="4" name="wr_phone[]" value="<?=$_mb_biz_phone[2];?>" class="cel2 ">
			</fieldset>					  
		</li>
		<li class="row10">
		  <fieldset>
				<legend>결제일자<span class="check"></span></legend>
				<input type="text" name="wr_pay_date" class="datepicker_inp" readOnly value="<?=$_get['pay_sdate'];?>">
			</fieldset>
		</li>
		<li class="row11">
			<label for="pay">결제금액<span class="check"></span></label>		
			<input type="text" id="pay" name="wr_price"> 원
		</li>
		<li class="row12">
			내용
		  <textarea type="editor" rows="9" name="wr_content" hname="내용" required></textarea>
		</li>
	</ul>
</section>

<div class="button_con">
	<a href="#none" class="bottom_btn01" onClick="netfu_util1.ajax_submit(document.forms['fwrite'])">신청하기</a><a href="#" class="bottom_btn02">취소</a>
</div>
</form>

<?php
include "../include/tail.php";
?>