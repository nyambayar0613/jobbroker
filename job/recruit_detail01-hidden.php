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
					<a href="recruit_main.php" class="active">лбсбы</a>
					<a href="person_main.php">인хат</a>
					<a href="community_main.php">커뮤니티</a>
				</div>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

        <section class="cont_box detail_con">
				  <h2 class="top_tit">온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</h2>
          <div class="top_area">
            <ul>
							<li class="etc">마감일 상시모집</li>		
							<li class="ktid"><span>카톡ID : <em>kakao-id</em></span></li>		
							<li class="btn_report"><a href="#"><img src="/images/icon_notify.gif" alt="신고하기">신고</a></li>
						</ul>
					</div>
				  <div class="company_con cf">
						<div class="logo_box">
							<img src="/images/logo01.png" alt="LOGO">
						</div>
						<div class="text_box">
							<div class="company">(주)파이낸뷰</div>
						</div>
					</div>
					<div class="company_info cf">
						<div class="mb_info ceo_info">
							<div class="ceo_inner">
								<dl>
									<dt class="hd hd2"><span><img src="/images/info1-1.png" alt="담당자"></span>담당자</dt>
									<dd class="col1 col2">
										<a href="#" class="hide">구인정보 열람서비스 신청</a>
									</dd>
								</ul>
							</div>
						</div>
						<div class="mb_info address_info">
							<div class="address_inner">
								<dl>
									<dt class="hd hd2"><span><img src="/images/info1-2.png" alt="연락처"></span>연락처</dt>
									<dd class="col1 col2">
										<a href="#" class="hide">구인정보 열람서비스 신청</a>
									</dd>
								</ul>
							</div>
						</div> 
					</div>

					<div class="button_group scrap_bt">

						  <!-- 온라인 입사지원 -->
              <div class="detail_ly mail_ly online_bx cf" style="display:block">
                <div class="detail_inner">
                  <div class="box-title"><h2>온라인 입사지원</h2>
                    <div class="btn-r">
									    <button id="close_ly" type="button">X</button>
                    </div>
									</div>
									<div class="text_area">
										<fieldset>
										  <legend>이력서 선택</legend>
											<ul class="inpt_bx resume_bx">
											  <li><label for="">지원 제목 <input type="text" name="" id=""></label></li>
											  <li><label for="">이력서 선택 <input type="text" name="" id=""></label></li>
											</ul>
										</fieldset>
										<fieldset>
										  <legend>첨부파일 직접 등록</legend>
											<div class="inpt_bx file_bx"><input type="file" name="" id=""></div>
										</fieldset>
										<fieldset>
										  <legend>연락처공개설정</legend>
											<div class="inpt_bx contact_bx cf">
												<label><input type="checkbox" id="" name=""> 전화번호</label>
												<label><input type="checkbox" id="" name=""> 휴대폰</label>
												<label><input type="checkbox" id="" name=""> e-메일</label>
												<label><input type="checkbox" id="" name=""> 주소</label>
												<label><input type="checkbox" id="" name=""> 홈페이지</label>
											</div>
										</fieldset>
									</div>
									<div class="btn_area">
									  <ul>
											<li class="sbtn"><a href="#">지원</a></li>
											<li class="abtn"><a href="#">취소</a></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- //온라인 입사지원 -->

						  <!-- 이메일 입사지원 -->
              <div class="detail_ly mail_ly email_bx cf" style="display:none">
                <div class="detail_inner">
                  <div class="box-title"><h2>이메일 입사지원</h2>
                    <div class="btn-r">
									    <button id="close_ly" type="button">X</button>
                    </div>
									</div>
									<div class="text_area">
										<fieldset>
										  <legend>이력서 선택</legend>
											<ul class="inpt_bx resume_bx">
											  <li><label for="">이력서 양식 <span><input type="radio" name="" id=""> 회원이력서</span></label></li>
											  <li><label for="">이력서 선택 <input type="text" name="" id=""></label></li>
											</ul>
										</fieldset>
										<fieldset>
										  <legend>첨부파일 직접 등록</legend>
											<div class="inpt_bx file_bx"><input type="file" name="" id=""></div>
										</fieldset>
										<fieldset>
										  <legend>연락처공개설정</legend>
											<div class="inpt_bx contact_bx cf">
												<label><input type="checkbox" id="" name=""> 전화번호</label>
												<label><input type="checkbox" id="" name=""> 휴대폰</label>
												<label><input type="checkbox" id="" name=""> e-메일</label>
												<label><input type="checkbox" id="" name=""> 주소</label>
												<label><input type="checkbox" id="" name=""> 홈페이지</label>
											</div>
										</fieldset>
									</div>
									<div class="btn_area">
									  <ul>
											<li class="sbtn"><a href="#">지원</a></li>
											<li class="abtn"><a href="#">취소</a></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- //온라인 입사지원 -->

					  <button type="button" class="bt-online" id="show_ly">온라인 입사지원</button>
						<button type="button" class="bt-email" id="show_ly">이메일 입사지원</button>
					  <button type="button" class="bt-scrap"><img src="/images/scrap_icon2.png" alt="스크랩"><!--<img src="/images/scrap_icon1.png">-->스크랩</button>
					</div>
				</section>

				<section class="cont_box detail_con detail_con2">
				  <div class="tab1-con cf">
					  <ul>
						  <li class="active"><a href="#">모집요강</a></li>
						  <li><a href="#">상세요강</a></li>
						  <li><a href="#">근무위치</a></li>
						  <li><a href="#">회사정보</a></li>
            </ul>
					</div>
					<div class="tab-box tab2-box">
            <table>
						  <tr>
							  <th>마감일</th>
								<td>상시모집</td>
							</tr>
						  <tr>
							  <th>모집인원</th>
								<td>00명</td>
							</tr>
						  <tr>
							  <th>지원방법</th>
								<td>온라인 이메일</td>
							</tr>
						  <tr>
							  <th>제출서류</th>
								<td>이력서, 주민등록 등본</td>
							</tr>
						  <tr>
							  <th>모집직종</th>
								<td>사무·회계 > 경리·회계·총무 > 경영지원</td>
							</tr>
						  <tr>
							  <th>근무지주소</th>
								<td>강원도 원주시 문덕읍 원문로 1585(문막읍 건등리)</td>
							</tr>
						  <tr>
							  <th>경력</th>
								<td>경력무관</td>
							</tr>
						  <tr>
							  <th>급여</th>
								<td>월급 1,900,000원</td>
							</tr>
						  <tr>
							  <th>근무기간</th>
								<td>1년 이상</td>
							</tr>
						  <tr>
							  <th>근무요일</th>
								<td>월~금</td>
							</tr>
						  <tr>
							  <th>근무시간</th>
								<td>08:30~18:30</td>
							</tr>
						  <tr>
							  <th>근무형태</th>
								<td>정규직, 인턴직</td>
							</tr>
						  <tr>
							  <th>복리후생</th>
								<td>국민연금, 고용보험, 산제보험, 건강보험, 연차</td>
							</tr>
						  <tr>
							  <th>성별</th>
								<td>성별무관</td>
							</tr>
						  <tr>
							  <th>연령</th>
								<td>연령무관</td>
							</tr>
						  <tr>
							  <th>학력</th>
								<td>학력무관</td>
							</tr>
						  <tr>
							  <th>사전질문</th>
								<td>없음</td>
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