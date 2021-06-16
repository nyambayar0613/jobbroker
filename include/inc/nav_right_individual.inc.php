<!-- 개인회원 마이페이지 메뉴 -->
<div class="right_nav right_nav1">
<div class="nav_wrap">
	<ul>
		<li class="close_btn"><a href="#none;" onClick="nav_right_view()"><img src="<?=NFE_URL;?>/images/close.png" alt="닫기"></a></li>
        <li class="title_area">Байгууллагын гишүүний үйлчилгээ</li>
		<li class="id_area"><?=$member['mb_name'];?><span></span></li>
		<li class="nav_menu">
			<ol>
				<li>
					<a href="<?=NFE_URL;?>/">
						<div class="nav_ico"><img src="<?=NFE_URL;?>/images/home_ico.png" alt="Home"></div>
						<div class="nav_txt">Home</div>
					</a>
				</li>
				<li>
					<a href="<?=NFE_URL;?>/mypage/member_modify.php">
						<div class="nav_ico"><img src="<?=NFE_URL;?>/images/admin_ico.png" alt="Мэдээллийг өөрчлөх"></div>
						<div class="nav_txt">Мэдээллийг өөрчлөх</div>
					</a>
				</li>
				<li>
					<a href="<?=NFE_URL;?>/regist.php?mode=logout">
						<div class="nav_ico"><img src="<?=NFE_URL;?>/images/login_ico.png" alt="Мэдээллийг өөрчлөх"></div>
						<div class="nav_txt">Log out</div>
					</a>
				</li>
			</ol>
		</li>
		<li class="top_cate"><a href="<?=NFE_URL;?>/mypage/resume_write.php">Анкет бүртгэл</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/resume_list.php">Анкеи удирдах<em><span><?=number_format($_my_count['resume']['c']);?></span>төрөл</em></a></li>
		<li><a href="<?=NFE_URL;?>/mypage/photo_individual.php">Зураг удирдах</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/report_individual.php">Ажлын өргөдөл удирдах<em><span><?=number_format($_my_count['receive']['c']);?></span>төрөл</em></a></li>
		<!-- <li><a href="#">Миний анкетыг уншсан байгууллагууд<em><span>0</span>төрөл</em></a></li> -->
		<li><a href="<?=NFE_URL;?>/mypage/report_company_request.php">Ажилд орохыг хүссэн компаниуд</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/scrap_individual.php">Scrab ажлын байр<em><span><?=number_format($_my_count['scrap']['c']);?></span>төрөл</em></a></li>
		<li><a href="<?=NFE_URL;?>/mypage/setting_individual.php">Санал болгох хүний нөөц<em><span><?=number_format(count($custom_titles));?></span>төрөл</em></a></li>
		<?php
		if($netfu_mjob->job_read_check['is_pay']) {
		?>
            <li style="height:auto"><a href="<?=NFE_URL;?>/payment/read_payment.php">Унших үйлчилгээг үргэлжлүүлэх
			<?php
			if($member_service['mb_service_alba_open']>=$now_date) {
			?>
			<div style="display:<?=($member_service['mb_service_alba_open']>=$now_date) ? 'block' : 'inline';?>">
                <i>Хугацааг сунгах</i>
			<?php if($member_service['mb_service_alba_open']>=$now_date) {?>
			<em><span><?=$member_service['mb_service_alba_open'];?></span>хүртэл</em>
			<?php }?>
			</div>
			<?php }?>
			<em style="top:0"><span><?=number_format($member_service['mb_service_open_count']);?></span>төрөл</em></a></li>
		<?php }?>
		<?php 
		$service_jump_arr = $service_control->service_check('resume_option_jump');
		if($service_jump_arr['is_pay'] == 1) {
		?>
            <li style="height:65px"><a href="<?=NFE_URL;?>/payment/jump_payment.php">Jump үйлчилгээг цэнэглэх <i>хугацааг сунгах</i><em><span><?=number_format($member_service['mb_alba_jump_count']);?></span>төрөл</em></a></li>
        <?php }else{ ?>
            <li style="height:65px"><a href="#">Jump үйлчилгээг цэнэглэх <em><span><?=number_format($member_service['mb_alba_jump_count']);?></span>төрөл</em></a></li>
		<?php } ?>
        <li><a href="<?=NFE_URL;?>/mypage/member_modify.php">Компанийн мэдээллийг засах<img src="<?=NFE_URL;?>/images/adm_ico.png" alt="Компанийн мэдээллийг засах"></a></li>
        <li><a href="<?=NFE_URL;?>/mypage/password_change.php">Нууц үг солих<img src="<?=NFE_URL;?>/images/adm_ico.png" alt="Нууц үг солих"></a></li>
        <li><a href="<?=NFE_URL;?>/mypage/member_leave.php">Гишүүнчлэлээс гарах хүсэлт</a></li>
        <li><a href="<?=NFE_URL;?>/mypage/payment_list.php">Төлбөртэй ашиглалтын түүх</a></li>
        <li><a href="<?=NFE_URL;?>/mypage/tax_company.php">Баримт авах өргөдөл</a></li>
	</ul>
</div>
</div>
<div class="wrap_bg"></div>
<!-- 개인회원 마이페이지 메뉴 -->