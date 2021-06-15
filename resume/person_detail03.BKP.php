<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/index.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

include_once(NFE_PATH.'/head.php');
?>

			<div class="lnb">
			  <div class="navi_menu">
					<a href="recruit_main.php">구인정보</a>
					<a href="person_main.php" class="active">인재정보</a>
					<a href="community_main.php">커뮤니티</a>
				</div>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

			  <section class="cont_box detail_con">
				  <h2 class="top_tit">오랫동안 일할 수 있는 재택알바 구합니다. 오랫동안 일할 수 있는 재택알바 구합니다.</h2>
          <div class="top_area">
            <ul>
							<li><span>통화가능시간 <em>18:00~00:00</em></span></li>
							<li><a href="#"><img src="/images/icon_notify.gif" alt="신고하기">신고하기</a></li>
						</ul>
					</div>
					<div class="profile_con cf">
						<div class="pic_box">
							<a href="#"><img src="/images/id_pic.png" alt="증명사진"><!-- <img src="/images/id_pic2.png" alt="증명사진"> --></a>
						</div>
						<div class="txt_box cf">
							<ul>
								<li>
								  <span><img src="/images/info1-1.png" alt="이름, 아이디"></span>
									<p>
									  <ol>
											<li class="pf_name">홍길동</li>
											<li class="pf_info"><p class="gender">남</p><p class="birth">1989</p></li>
											<li class="slash">/</li>
											<li class="pf_id">test_individual</li>
										</ol>
									</p>
								</li>
								<li><span><img src="/images/info1-3.png" alt="전화번호"></span><p>02-000-0000</p></li>
								<li><span><img src="/images/info1-2.png" alt="휴대폰"></span><p>010-1234-5678</p><em class="call_btn"><a href="#"><img src="/images/tel_ico.png" alt="전화하기">전화걸기</a></em></li>
								<li><span><img src="/images/info1-4.png" alt="이메일"></span><p>webmaster@test.com</p></li>			
								<li class="address4"><span><img src="/images/info1-5.png" alt="주소"></span><p>광주광역시 동구 금남로5가 남선빌딩 407호 광주광역시 동구 금남로5가 남선빌딩 407호</p></li>								
							</ul>
						</div>
						<div class="etc_box cf">
						  <ul>
							  <li><span>최종학력</span><p>대학(4년)졸업</p></li>
								<li><span>경력사항</span><p>없음</p></li>
								<li><span>희망급여</span><p>추후협의</p></li>
								<li><span>자격증</span><p>컴퓨터활용능력 1급</p></li>
								<li><span>외국어능력</span><p>영어중 외 1개국어</p></li>
							</ul>
						</div>
					</div>
					<div class="button_group scrap_bt">
					  <button type="button" class="bt-apply">입사지원요청</button>
					  <button type="button" class="bt-scrap"><img src="/images/scrap_icon2.png" alt="스크랩"><!--<img src="/images/scrap_icon1.png">-->스크랩</button>
					</div>
				</section>

				<section class="cont_box detail_con detail_con2">
				  <div class="tab2-con cf">
					  <ul>
						  <li><a href="#">이력서정보</a></li>
						  <li><a href="#">자격사항</a></li>
						  <li class="active"><a href="#">자기소개서</a></li>
            </ul>
					</div>
					<div class="tab5-box">
					  <div class="container cf">
							<dl>
								<dt>[성장과정]</dt>
								<dd>
	저는 자기 신념과 자애로운 마음을 가지고 계신 부모님 밑에서 2녀의 차녀로 
	태어나서 자라왔습니다. 어렸을때부터 넉넉치 않았던 형편이었으나 서로를 
	이해하고 배려하며 챙겨주는 화목한 가정이었기에 부족함없이 생활하였습니
	다. 부모님께서는 언니와 저를 독립적이고 올바른 사람으로 키우기 위해 학교
	교육뿐 아니라 가정교육을 비롯하여 여러 인성교육을 지원하셨고 도덕적 인간
	이 되기를 종용하셨습니다. 
								</dd>
							</dl>
							<dl>
								<dt>[성격의 장단점/가치관]</dt>
								<dd>
저는 자기 신념과 자애로운 마음을 가지고 계신 부모님 밑에서 2녀의 차녀로 
태어나서 자라왔습니다. 어렸을때부터 넉넉치 않았던 형편이었으나 서로를 
이해하고 배려하며 챙겨주는 화목한 가정이었기에 부족함없이 생활하였습니
다. 부모님께서는 언니와 저를 독립적이고 올바른 사람으로 키우기 위해 학교
교육뿐 아니라 가정교육을 비롯하여 여러 인성교육을 지원하셨고 도덕적 인간
이 되기를 종용하셨습니다. 
								</dd>
							</dl>
							<dl>
								<dt>[성격의 장단점/가치관]</dt>
								<dd>
저는 자기 신념과 자애로운 마음을 가지고 계신 부모님 밑에서 2녀의 차녀로 
태어나서 자라왔습니다. 어렸을때부터 넉넉치 않았던 형편이었으나 서로를 
이해하고 배려하며 챙겨주는 화목한 가정이었기에 부족함없이 생활하였습니
다. 부모님께서는 언니와 저를 독립적이고 올바른 사람으로 키우기 위해 학교
교육뿐 아니라 가정교육을 비롯하여 여러 인성교육을 지원하셨고 도덕적 인간
이 되기를 종용하셨습니다. 
								</dd>
							</dl>
						</div>
          </div>
					<div class="share-con">
						<div class="sns_btn_group cf">
								<!-- AddToAny BEGIN -->
								<!-- <style type="text/css">
										a .a2a_svg{
												height: 28px;
												line-height: 28px;
												width: 28px;
												-webkit-filter: invert(1);
												filter: invert(1);
										}
								</style> -->
								<div class="a2a_kit a2a_kit_size_20 a2a_default_style" style="float:right;">
										<a class="a2a_button_facebook"></a>
										<a class="a2a_button_twitter"></a>
										<a class="a2a_button_kakao"></a>
										<a class="a2a_button_line"></a>
										<a class="a2a_button_pinterest"></a>
										<div style="float:left"><a class="a2a_dd" href="https://www.addtoany.com/share"></a></div>
								</div>
								<script>
										var a2a_config = a2a_config || {};
										a2a_config.locale = "ko";
										a2a_config.icon_color = "transparent";
										a2a_config.onclick = 1;
										a2a_config.num_services = 10;
										a2a_config.icon_color = "unset,#fff"; /* #d0d0d0  original */
										a2a_config.prioritize = ["facebook_messenger", "google_plus", "tumblr", "wordpress", "google_gmail", "evernote", "sms", "instapaper", "Linkedln", "facebook"];
								</script>
								<script async src="https://static.addtoany.com/menu/page.js"></script>
						</div>
					</div>
				</section>

				<!-- 공지사항 -->
			  <section class="cont_box notice_con">
          <h2>[공지]</h2>
					<ul class="cont_box_inner">
						<li>
							<div class="text_box">
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집</a><span class="n_date">2019.10.16</span></div>
							</div>
						</li>
					</ul>
				</section>
			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>