<form method="post" name="MemberUpdateFrm" action="<?=NFE_URL;?>/member/regist.php" id="MemberUpdateFrm" enctype="multipart/form-data">
<input type="hidden" name="ajax" value="true"/>
<input type="hidden" name="mode" value="profile_photo_upload"/>
<input type="hidden" name="mb_type" value="<?php echo $mb_type;?>"/>
<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>"/>
<input type="hidden" name="no" value="<?php echo $member['no'];?>"/>
<section class="cont_box detail_con">
	<?php
	include NFE_PATH.'/include/inc/member_info.inc.php';
	?>
	<div class="phone_info info_bx2">
		<div class="phone_inner">
			<dl>
				<dt class="hd"><span><img src="<?=NFE_URL;?>/images/info3.png" alt="Холбогдох дугаар"></span>Холбогдох дугаар</dt>
				<dd class="col1">
					<?=$member['mb_phone'];?>
					<div class="open_info">
						<span><input type="radio" name="mb_phone_view" id="mb_phone_view_1" onClick="netfu_mjob.mb_views('phone', this)" value="1" checked><label for="mb_phone_view_1">Нээлттэй</label></span>
						<span><input type="radio" name="mb_phone_view" id="mb_phone_view_0" onClick="netfu_mjob.mb_views('phone', this)" value="0" <?php echo (!$member['mb_phone_view'])?'checked':'';?>><label for="mb_phone_view_0">비공개</label></span>
					</div>
				</dd>
			</ul>
		</div>
	</div>
	<div class="tel_info info_bx2">
		<div class="tel_inner">
			<dl>
				<dt class="hd"><span><img src="<?=NFE_URL;?>/images/info2.png" alt="Холбоглох"></span>Утасны дугаар</dt>
				<dd class="col1 col_w">
					<?=$member['mb_hphone'];?>
					<div class="open_info">
						<span><input type="radio" name="mb_hphone_view" id="mb_hphone_view_1" onClick="netfu_mjob.mb_views('hphone', this)" value="1" checked><label for="mb_hphone_view_1">Нээлттэй</label></span>
						<span><input type="radio" name="mb_hphone_view" id="mb_hphone_view_0" onClick="netfu_mjob.mb_views('hphone', this)" value="0" <?php echo (!$member['mb_hphone_view'])?'checked':'';?>><label for="mb_hphone_view_0">비공개</label></span>
					</div>
				</dd>
			</dl>
		</div>
	</div>
	<div class="mb_info email_info info_bx2">
		<div class="email_inner">
			<dl>
				<dt class="hd"><span><img src="<?=NFE_URL;?>/images/info4.png" alt="И-мэйл"></span>И-мэйл</dt>
				<dd class="col1">
					<?=$member['mb_email'];?>
					<div class="open_info">
						<span><input type="radio" name="mb_email_view" onClick="netfu_mjob.mb_views('email', this)" value="1" id="mb_email_view_1" checked><label for="mb_email_view_1">Нээлттэй</label></span>
						<span><input type="radio" name="mb_email_view" onClick="netfu_mjob.mb_views('email', this)" value="0" id="mb_email_view_0" <?php echo (!$member['mb_email_view'])?'checked':'';?>><label for="mb_email_view_0">비공개</label></span>
					</div>
				</dd>
			</ul>
		</div>
	</div>
	<div class="mb_info home_info info_bx2">
	<div class="home_inner">
		<dl>
			<dt class="hd"><span><img src="<?=NFE_URL;?>/images/info6.png" alt="Homepage"></span>Homepage</dt>
				<dd class="col1">
					<?=$member['mb_homepage'];?>
					<div class="open_info">
						<span><input type="radio" name="mb_homepage_view" onClick="netfu_mjob.mb_views('homepage', this)"  value="1" id="mb_homepage_view_1" checked><label for="mb_homepage_view_1">Нээлттэй</label></span>
						<span><input type="radio" name="mb_homepage_view" onClick="netfu_mjob.mb_views('homepage', this)" value="0" id="mb_homepage_view_0" <?php echo (!$member['mb_homepage_view'])?'checked':'';?>><label for="mb_homepage_view_0">비공개</label></span>
					</div>
				</dd>
			</ul>
		</div>
	</div>
	<div class="mb_info address_info info_bx2">
	<div class="address_inner">
		<dl>
			<dt class="hd"><span><img src="<?=NFE_URL;?>/images/info5.png" alt="Хаяг"></span>Хаяг</dt>
				<dd class="col1">
					<?=$member['mb_address0'].' '.$member['mb_address1'];?>
					<div class="open_info">
						<span><input type="radio" name="mb_address_view" onClick="netfu_mjob.mb_views('address', this)" value="1" id="mb_address_view_1" checked><label for="mb_address_view_1">Нээлттэй</label></span>
						<span><input type="radio" name="mb_address_view" onClick="netfu_mjob.mb_views('address', this)" value="0" id="mb_address_view_0" <?php echo (!$member['mb_address_view'])?'checked':'';?>><label for="mb_address_view_0">비공개</label></span>
					</div>
				</dd>
			</ul>
		</div>
	</div>
</section>
</form>