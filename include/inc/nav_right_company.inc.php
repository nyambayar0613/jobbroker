<!-- 기업회원 마이페이지 메뉴 -->
<?php
// : 진행, 마감 건수는 nav_right.php에서 실행합니다.
?>
<div class="right_nav right_nav2">
	<div class="nav_wrap">
		<ul>
			<li class="close_btn"><a href="#none;" onClick="nav_right_view()"><img src="<?=NFE_URL;?>/images/close.png" alt="닫기"></a></li>
			<li class="title_area">기업회원 서비스</li>
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
			<li class="top_cate"><a href="<?=NFE_URL;?>/mypage/job_write.php">구인정보등록</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/employ_list.php">구인정보관리<em class="go">진행<span><?=number_format($_my_count['job_ing']['c']);?></span>건</em><em>마감<span><?=number_format($_my_count['job_end']['c']);?></span>건</em></a></li>					 
			<li><a href="<?=NFE_URL;?>/mypage/company_list.php">기업정보관리</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/manager_info.php">담당자관리</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/report_company.php">지원자관리</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/srcap_company.php">스크랩 인재정보<em><span><?=number_format($_my_count['scrap']['c']);?></span>건</em></a></li>
			<li><a href="<?=NFE_URL;?>/mypage/setting_company.php">맞춤 인재정보<em><span><?=number_format($save_query_num_);?></span>건</em></a></li>
			<li><a href="<?=NFE_URL;?>/mypage/interview_company.php">입사지원관리</a></li>
			<?php
			if($netfu_mjob->resume_read_check['is_pay']) {
			?>
			<li style="height:auto"><a href="<?=NFE_URL;?>/payment/read_payment.php">이력서열람서비스
				<?php
				if($member_service['mb_service_open']>=$now_date) {
				?>
				<div style="display:<?=($member_service['mb_service_open']>=$now_date) ? 'block' : 'inline';?>">
				<i>기간연장</i>
				<?php if($member_service['mb_service_open']>=$now_date) {?>
				<em><span><?=$member_service['mb_service_open'];?></span>까지</em>
				<?php }?>
				</div>
				<?php }?>
				<em style="top:0"><span><?=number_format($member_service['mb_service_open_count']);?></span>건</em></a></li>
			<?php } ?>
			<?php 
			$service_jump_arr = $service_control->service_check('alba_option_jump');
			if($service_jump_arr['is_pay'] == 1) { 
			?>
			<li style="height:65px"><a href="<?=NFE_URL;?>/payment/jump_payment.php">점프충전 서비스 <i>기간연장</i><em><span><?=number_format($member_service['mb_alba_jump_count']);?></span>건</em></a></li>
			<?php }else{ ?>
			<li style="height:65px"><a href="#">점프충전 서비스 <em><span><?=number_format($member_service['mb_alba_jump_count']);?></span>건</em></a></li>
			<?php } ?>
			<li><a href="<?=NFE_URL;?>/mypage/member_modify.php">기업정보수정<img src="<?=NFE_URL;?>/images/adm_ico.png" alt="기업정보수정"></a></li>
			<li><a href="<?=NFE_URL;?>/mypage/password_change.php">비밀번호변경<img src="<?=NFE_URL;?>/images/adm_ico.png" alt="비밀번호변경"></a></li>
			<li><a href="<?=NFE_URL;?>/mypage/member_leave.php">회원탈퇴신청</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/payment_list.php">유료이용내역</a></li>
			<li><a href="<?=NFE_URL;?>/mypage/tax_company.php">세금계산서 발행신청</a></li>
		</ul>
	</div>
</div>
<!-- //기업회원 마이페이지 메뉴 -->
<div class="wrap_bg"></div>