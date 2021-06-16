<!-- 개인회원 마이페이지 메뉴 -->
<div class="right_nav right_nav1">
<div class="nav_wrap">
	<ul>
		<li class="close_btn"><a href="#none;" onClick="nav_right_view()"><img src="<?=NFE_URL;?>/images/close.png" alt="닫기"></a></li>
        <li class="title_area">Байгууллагын гишүүний үйлчилгээ</li>
		<li class="id_area"><?=$member['mb_name'];?><span>님</span></li>
		<li class="nav_menu">
			<ol>
				<li>
					<a href="<?=NFE_URL;?>/">
						<div class="nav_ico"><img src="<?=NFE_URL;?>/images/home_ico.png" alt="홈"></div>
						<div class="nav_txt">Home</div>
					</a>
				</li>
				<li>
					<a href="<?=NFE_URL;?>/mypage/member_modify.php">
						<div class="nav_ico"><img src="<?=NFE_URL;?>/images/admin_ico.png" alt="정보수정"></div>
						<div class="nav_txt">정보수정</div>
					</a>
				</li>
				<li>
					<a href="<?=NFE_URL;?>/regist.php?mode=logout">
						<div class="nav_ico"><img src="<?=NFE_URL;?>/images/login_ico.png" alt="정보수정"></div>
						<div class="nav_txt">로그아웃</div>
					</a>
				</li>
			</ol>
		</li>
		<li class="top_cate"><a href="<?=NFE_URL;?>/mypage/resume_write.php">Анкет бүртгэл</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/resume_list.php">Анкеи удирдах<em><span><?=number_format($_my_count['resume']['c']);?></span>төрөл</em></a></li>
		<li><a href="<?=NFE_URL;?>/mypage/photo_individual.php">내사진관리</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/report_individual.php">입사지원관리<em><span><?=number_format($_my_count['receive']['c']);?></span>төрөл</em></a></li>
		<!-- <li><a href="#">내이력서 열람기업<em><span>0</span>건</em></a></li> -->
		<li><a href="<?=NFE_URL;?>/mypage/report_company_request.php">입사지원요청 기업</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/scrap_individual.php">스크랩 구인정보<em><span><?=number_format($_my_count['scrap']['c']);?></span>төрөл</em></a></li>
		<li><a href="<?=NFE_URL;?>/mypage/setting_individual.php">맞춤 구인정보<em><span><?=number_format(count($custom_titles));?></span>төрөл</em></a></li>
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
        <li><a href="<?=NFE_URL;?>/mypage/member_modify.php">Компанийн мэдээллийг засах<img src="<?=NFE_URL;?>/images/adm_ico.png" alt="기업정보수정"></a></li>
        <li><a href="<?=NFE_URL;?>/mypage/password_change.php">Нууц үг солих<img src="<?=NFE_URL;?>/images/adm_ico.png" alt="비밀번호변경"></a></li>
        <li><a href="<?=NFE_URL;?>/mypage/member_leave.php">Гишүүнчлэлээс гарах хүсэлт</a></li>
        <li><a href="<?=NFE_URL;?>/mypage/payment_list.php">Төлбөртэй ашиглалтын түүх</a></li>
        <li><a href="<?=NFE_URL;?>/mypage/tax_company.php">Баримт авах өргөдөл</a></li>
	</ul>
</div>
</div>
<div class="wrap_bg"></div>
<!-- 개인회원 마이페이지 메뉴 -->