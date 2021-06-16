<!-- 기업회원 마이페이지 메뉴 -->
<?php
// : 진행, 마감 건수는 nav_right.php에서 실행합니다.
?>
<div class="right_nav right_nav2">
	<div class="nav_wrap">
		<ul>
			<li class="close_btn"><a href="#none;" onClick="nav_right_view()"><img src="<?=NFE_URL;?>/images/close.png" alt="Хаах"></a></li>
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
							<div class="nav_ico"><img src="<?=NFE_URL;?>/images/admin_ico.png" alt="Мэдээлэл тохиргоо"></div>
							<div class="nav_txt">Мэдээллийг өөрчлөх</div>
						</a>
					</li>
					<li>
						<a href="<?=NFE_URL;?>/regist.php?mode=logout">
							<div class="nav_ico"><img src="<?=NFE_URL;?>/images/login_ico.png" alt="Мэдээлэл тохиргоо"></div>
							<div class="nav_txt">Log out</div>
						</a>
					</li>
				</ol>
			</li>
			<li class="top_cate"><a href="<?=NFE_URL;?>/mypage/job_write.php">Ажлын байрны мэдээлэл бүртгэл</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/employ_list.php">Ажлын байрны мэдээлэл удирдах<em class="go">진행<span><?=number_format($_my_count['job_ing']['c']);?></span>төрөл</em><em>Дуусах хугацаа<span><?=number_format($_my_count['job_end']['c']);?></span>건</em></a></li>
			<li><a href="<?=NFE_URL;?>/mypage/company_list.php">Байгууллагын мэдээлэл удирдах</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/manager_info.php">Хариуцсан хүн удирдлага</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/report_company.php">Өргөдөл гаргагч</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/srcap_company.php">Scrab хүний нөөц<em><span><?=number_format($_my_count['scrap']['c']);?></span>төрөл</em></a></li>
			<li><a href="<?=NFE_URL;?>/mypage/setting_company.php">Санал болгох хүний нөөцийн мэдээлэл<em><span><?=number_format($save_query_num_);?></span>төрөл</em></a></li>
			<li><a href="<?=NFE_URL;?>/mypage/interview_company.php">Ажлын байрны өргөдөл удирдах</a></li>
			<?php
			if($netfu_mjob->resume_read_check['is_pay']) {
			?>
			<li style="height:auto"><a href="<?=NFE_URL;?>/payment/read_payment.php">Унших үйлчилгээг үргэлжлүүлэх
				<?php
				if($member_service['mb_service_open']>=$now_date) {
				?>
				<div style="display:<?=($member_service['mb_service_open']>=$now_date) ? 'block' : 'inline';?>">
				<i>Хугацааг сунгах</i>
				<?php if($member_service['mb_service_open']>=$now_date) {?>
				<em><span><?=$member_service['mb_service_open'];?></span>хүртэл</em>
				<?php }?>
				</div>
				<?php }?>
				<em style="top:0"><span><?=number_format($member_service['mb_service_open_count']);?></span>төрөл</em></a></li>
			<?php } ?>
			<?php 
			$service_jump_arr = $service_control->service_check('alba_option_jump');
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
			<li><a href="<?=NFE_URL;?>/mypage/tax_company.php">Татварын нэхэмжлэх гаргах өргөдөл</a></li>
		</ul>
	</div>
</div>
<!-- //기업회원 마이페이지 메뉴 -->
<div class="wrap_bg"></div>