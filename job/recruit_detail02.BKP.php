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
					<a href="recruit_main.php" class="active">구인정보</a>
					<a href="person_main.php">인재정보</a>
					<a href="community_main.php">커뮤니티</a>
				</div>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

	      <section class="cont_box detail_con">
          <div class="top_area">
            <ul>
							<li class="ktid"><span>카톡ID : <em>kakao-id</em></span></li>		
							<li class="btn_report"><a href="#"><img src="/images/icon_notify.gif" alt="신고하기">신고</a></li>
						</ul>
					</div>
					<div class="logo_box">
						<img src="/images/logo01.png" alt="LOGO">
					</div>
					<div class="text_box">
					  <div class="company">(주)파이낸뷰</div>
						<div class="title">온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</div>
						<div class="info">마감일 상시모집</div>
					</div>
					<div class="adm_name">
					  <div class="name_inner">
						  <dl>
							  <dt class="hd"><span><img src="/images/info1.png" alt="담당자"></span>담당자</dt>
								<dd class="col1">김범</dd>
							</ul>
						</div>
					</div>
					<div class="tel_info">
					  <div class="tel_inner">
						  <dl>
							  <dt class="hd"><span><img src="/images/info2.png" alt="연락처"></span>연락처</dt>
								<dd class="col1">010-1234-5678</dd>
								<dd class="col2"><a href="#"><span><img src="/images/tel_ico.png" alt="전화하기"></span><em>전화하기</em></a></dd>
							</dl>
						</div>
					</div>
					<div class="button_group scrap_bt">
					  <button type="button" class="bt-online">온라인 입사지원</button>
						<button type="button" class="bt-email">이메일 입사지원</button>
					  <button type="button" class="bt-scrap"><img src="/images/scrap_icon2.png" alt="스크랩"><!--<img src="/images/scrap_icon1.png">-->스크랩</button>
					</div>
				</section>

				<section class="cont_box detail_con detail_con2">
				  <div class="tab1-con cf">
					  <ul>
						  <li><a href="#">모집요강</a></li>
						  <li class="active"><a href="#">상세요강</a></li>
						  <li><a href="#">근무위치</a></li>
						  <li><a href="#">회사정보</a></li>
            </ul>
					</div>
					<div class="tab-box tab4-box">
            <table>
						  <tr>
							  <th>근무위치</th>
								<td>롯데마트 제주점(완구매장)</td>
							</tr>
						  <tr>
							  <th>업무내용</th>
								<td>G그린마트 완구판촉 - 아이들 좋아하시는 분 꼭 지원하세요.</td>
							</tr>
						  <tr>
							  <th>자격요건</th>
								<td>20~30세 여성 - 학력무관 - 성실한 분<br>평일 매장교육 가능하신 분 우대</td>
							</tr>
						  <tr>
							  <th>근무시간</th>
								<td>평일 롯데마트 교육 가능하신분</td>
							</tr>
						  <tr>
							  <th>홈페이지</th>
								<td>http://</td>
							</tr>
						  <tr>
							  <th>급여 및 지급일</th>
								<td>익월 15일 일괄 정산 지급(세금 33%공제)</td>
							</tr>
						</table>
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