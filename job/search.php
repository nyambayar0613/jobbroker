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
				<div class="navi_cate">
				  <a href="#" class="prev_btn menu_arrow"><img src="images/menu_arrow1.png" alt="이전"></a>
					<div class="cate_con cf">
						<a href="#">급구</a>
						<a href="#">지역별</a>
						<a href="#">업직종별</a>
						<a href="#">역세권별</a>
						<a href="#">대학가별</a>
						<a href="#">기간별</a>
						<a href="#">급여별</a>
						<a href="#">대상별</a>
						<a href="#" class="active">상세검색</a>
					</div>
				  <a href="#" class="next_btn menu_arrow"><img src="images/menu_arrow2.png" alt="다음"></a>
				</div>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">
        
				<!-- 상세검색 -->
				<div class="schbox_wrap sch_wrap cf">
					<div class="search_con search_box">
						<table class="search_tb">

							<!-- 근무지역 -->
							<tr>
								<th class="sch_hd">
									<div>근무지역</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>시·도</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2">
									<select>
										<option>시·군·구</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td3">
									<select>
										<option>읍·면·동</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- 역세권 -->
							<tr>
								<th class="sch_hd">
									<div>역세권</div>
								</th>
								<td class="sch_td1" colspan="3">
									<select>
										<option>서울·수도권</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								</td>
							</tr>

							<!-- 대학가 -->
							<tr>
								<th class="sch_hd">
									<div>대학가</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>지역</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2" colspan="2">
									<select>
										<option>인근대학 선택</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- 업직종 -->
							<tr>
								<th class="sch_hd">
									<div>업직종</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>업직종1차</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2">
									<select>
										<option>업직종2차</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td3">
									<select>
										<option>업직종3차</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- 근무기간 -->
							<tr>
								<th class="sch_hd">
									<div>근무기간</div>
								</th>
								<td class="sch_td1" colspan="3">
									<select>
										<option>근무기간</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- 근무요일 -->
							<tr>
								<th class="sch_hd">
									<div>근무요일</div>
								</th>
								<td class="sch_td1" colspan="3">
									<select>
										<option>근무요일</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- 근무시간 -->
							<tr>
								<th class="sch_hd sch_hd1-2">
									<div>근무시간</div>
								</th>
								<td class="sch_td1 sch_td1-2" colspan="3">
								  <fieldset>
										<legend>근무시간</legend>
										<select>
											<option>시</option>
											<option></option>
											<option></option>
											<option></option>
										</select>
										<select>
											<option>분</option>
											<option></option>
											<option></option>
											<option></option>
										</select>
										~
										<select>
											<option>시</option>
											<option></option>
											<option></option>
											<option></option>
										</select>
										<select>
											<option>분</option>
											<option></option>
											<option></option>
											<option></option>
										</select>
										<label><input type="checkbox" id="" name="">시간협의</label>
									</fieldset>
								</td>
							</tr>

							<!-- 급여 -->
							<tr>
								<th class="sch_hd">
									<div>급여</div>
								</th>
								<td class="sch_td2" colspan="3">
								  <fieldset>
										<legend>급여선택</legend>
										<ul>
											<li><input type="checkbox" id="" name="">시급</li>
											<li><input type="checkbox" id="" name="">일급</li>
											<li><input type="checkbox" id="" name="">주급</li>
											<li><input type="checkbox" id="" name="">월급</li>
											<li><input type="checkbox" id="" name="">건별<input type="text" id="" name="">원 이상~<input type="text" id="" name="">원 이하</li>
										<ul>
	                </fieldset>
								</td>
							</tr>

							<!-- 성별 -->
							<tr>
								<th class="sch_hd">
									<div>성별선택</div>
								</th>
								<td class="sch_td2" colspan="3">
								  <fieldset>
										<legend>성별선택</legend>
										<input type="radio" id="male" name="">남자
										<input type="radio" id="female" name="">여자
										<input type="checkbox" id="no-gender">성별무관
                  </fieldset>
								</td>
							</tr>

							<!-- 검색유형5 -->
							<tr>
								<th class="sch_hd">
									<div>연령</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>나이</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2" colspan="2">
								  <fieldset>
									  <legend>연령선택</legend>
										<input type="checkbox" id="under">이하
										<input type="checkbox" id="over">이상
										<input type="checkbox" id="unrelated">무관
									</fieldset>
								</td>
							</tr>

							<!-- 학력 -->
							<tr>
								<th class="sch_hd">
									<div>학력선택</div>
								</th>
								<td class="sch_td1" colspan="3">
									<select>
										<option>학력</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- 검색유형3 -->
							<tr>
								<th class="sch_hd">
									<div>경력선택</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>기간</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2" colspan="2">
								  <fieldset>
									  <legend>경력선택</legend>
										<input type="checkbox" id="unrelated">무관
										<input type="checkbox" id="new-recruit">신입
										<input type="checkbox" id="career">경력
									</fieldset>
								</td>
							</tr>

							<!-- 검색어 입력 -->
							<tr>
								<th class="sch_hd" style="background:#fff;border-right:0">
									<div>검색어</div>
								</th>
								<td class="sch_td2 sch_word" colspan="3" style="border-left:0;padding-right:5px">
								  <input type="text" id="" name="" class="sch_in">
								</td>
							</tr>
						</table>
					</div>
					<div class="schbtn_con cf">
						<ul>
							<li class="search_bx sch_bt sch_bt2" style="width:100%">
								<button type="button" class="sch_button"><img src="images/search_icon3.png" alt="검색">검색</button>
							</li>
						</ul>
					</div>
        </div>
				<!-- //상세검색 -->

				<!-- 배너 -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner1-2.jpg" alt=""></a>
				</div>

				<!-- 플래티넘 -->
			  <section class="cont_box platinum_con">
          <h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>플래티넘 구인정보<span class="bt_box"><em>1</em>/18건 <a href="#"><span class="btn">광고안내<img src="images/chevron.png" alt="광고안내"></span></a></span></h2>
					<ul class="cont_box_inner">
						<li>

						  <!-- 상세보기 -->
              <div class="detail_ly cf">
                <div class="detail_inner">
                  <div class="company_name"><h2>스타뮤직(주)</h2>
                    <div class="btn-r">
									    <a>상세모집내용</a><a>공고 스크랩</a><button id="hide_ly" type="button">X</button>
                    </div>
									</div>
									<div class="title_area">
									  <p class="title_txt">부조종실 비디오 엔지니어 모집</p>
										<p class="field">서비스, 사진·촬영보조, 영상</p>
									</div>
									<div class="info_area">
									  <ul>
										  <li><span class="info_tit">근무지역</span><span>디지털미디어시티 | 서울 > 마포구</span></li>
											<li><span class="info_tit">근무기간</span><span>1년이상</span></li>
											<li><span class="info_tit">근무요일</span><span>월~금, 시간협의</span></li>
											<li><span class="info_tit">복리후생</span></li>
											<li><span class="info_tit">마감일</span><span>채용시까지</span></li>
										</ul>
									</div>
									<div class="etc_area">
									  <ul>
										  <li>
											  <div class="etc_tit"><strong>급여조건</strong></div>
												<div class="etc_txt pay"><b>월급</b><span>1,260,000원</span></div>
											</li>
											<li>
											  <div class="etc_tit"><strong>성별</strong></div>
												<div class="etc_txt">성별무관</div>
											</li>
											<li>
											  <div class="etc_tit"><strong>연령</strong></div>
												<div class="etc_txt">연령무관</div>
											</li>
											<li>
											  <div class="etc_tit"><strong>모집인원</strong></div>
												<div class="etc_txt"><span>0</span>명, <span>00<span>명</div>
											</li>
									  </ul>
									</div>
									<div class="btn_area">
									  <ul>
											<li class="sbtn"><a href="#"><img src="images/scrap_icon3.png" alt="스크랩">스크랩</a></li>
											<li class="abtn"><a href="#">지원하기</a></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- //상세보기 -->

						  <button id="show_ly" class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo01.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo02.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo03.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo04.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo05.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
							<div class="white_box">
							  <div class="whitebox_inner">
                  <div class="text">신규광고 등록 대기중</div>
								  <a href="#"><div class="btn">광고안내 및 신청<img src="images/chevron.png" alt="광고안내 및 신청"></div></a>
								</div>
							</div>
						</li>
					<div class="paging_con cf">
						<div class="paging">
							<a href="#">1</a>
							<a href="#">2</a>
							<a href="#" class="active">3</a>
							<a href="#">4</a>
							<a href="#">5</a>
							<a href="#">6</a>
							<a href="#">7</a>
						</div>
					</div>
				</section>
				<!-- //플래티넘 -->

				<!-- 배너 -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner5.jpg" alt=""></a>
				  <!-- 추가배너 <a href="#"><img src="images/banner5.jpg" alt=""></a> -->
				</div>

				<!-- 그랜드형 -->
			  <section class="cont_box banner_con">
          <h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>그랜드형 구인정보<span class="bt_box"><em>1</em>/18건 <a href="#"><span class="btn">광고안내<img src="images/chevron.png" alt="광고안내"></span></a></span></h2>
					<ul class="cont_box_inner">
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo01.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo02.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo03.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo04.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo05.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
							<div class="white_box">
							  <div class="whitebox_inner">
                  <div class="text">신규광고 등록 대기중</div>
								  <a href="#"><div class="btn">광고안내 및 신청<img src="images/chevron.png" alt="광고안내 및 신청"></div></a>
								</div>
							</div>
						</li>
					</ul>					<div class="paging_con cf">
						<div class="paging">
							<a href="#">1</a>
							<a href="#">2</a>
							<a href="#" class="active">3</a>
							<a href="#">4</a>
							<a href="#">5</a>
							<a href="#">6</a>
							<a href="#">7</a>
						</div>
					</div>
        </section>
				<!-- //그랜드형 -->

				<!-- 배너 -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner3.jpg" alt=""></a>
				</div>

				<!-- 스페셜 -->
			  <section class="cont_box _con webzine_con web1">
          <h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>스페셜 구인정보<em class="ad_btn"><a href="#"><span class="btn">광고안내<img src="images/chevron.png" alt="광고안내"></span></a></em></h2>
					<ul class="cont_box_inner">
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo01.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 </a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo02.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo03.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo04.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>더보기</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo05.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">(주)파이낸뷰</a></div>
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집(창고 물류 관리, 상품 택배 포장)</a></div>
								<div class="info">
                  <span class="area">서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box2">
								<div class="title"><img src="images/info.png" alt="">등록된 내용이 없습니다.</div>
							</div>
						</li>
					<div class="paging_con cf">
						<div class="paging">
							<a href="#">1</a>
							<a href="#">2</a>
							<a href="#" class="active">3</a>
							<a href="#">4</a>
							<a href="#">5</a>
							<a href="#">6</a>
							<a href="#">7</a>
						</div>
					</div>
				</section>
				<!-- //스페셜 -->

				<!-- 배너 -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner4.jpg" alt=""></a>
				  <!-- <a href="#"><img src="images/banner1-3.jpg" alt=""></a> -->
				</div>

				<!-- 일반형 -->
			  <section class="cont_box _con cont_list recruit1">
          <h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>일반 구인정보<em class="ad_btn"><a href="#"><span class="btn">광고안내<img src="images/chevron.png" alt="광고안내"></span></a></em></h2>
					<ul class="cont_box_inner">
						<li>
              <button class="more_option"><span>더보기</span></button>
							<div class="company"><a href="recruit_detail01.php">(주)파이낸뷰</a></div>
							<div class="text_box">
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 </a></div>
								<div class="info">
                  <span>서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="gender">남자</span>
									<span class="time">시간협의</span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
              <button class="more_option"><span>더보기</span></button>
							<div class="company"><a href="recruit_detail01.php">(주)파이낸뷰</a></div>
							<div class="text_box">
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 </a></div>
								<div class="info">
                  <span>서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="gender">남자</span>
									<span class="time">시간협의</span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
              <button class="more_option"><span>더보기</span></button>
							<div class="company"><a href="recruit_detail01.php">(주)파이낸뷰</a></div>
							<div class="text_box">
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 </a></div>
								<div class="info">
                  <span>서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="gender">남자</span>
									<span class="time">시간협의</span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
              <button class="more_option"><span>더보기</span></button>
							<div class="company"><a href="recruit_detail01.php">(주)파이낸뷰</a></div>
							<div class="text_box">
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 </a></div>
								<div class="info">
                  <span>서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="gender">남자</span>
									<span class="time">시간협의</span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
              <button class="more_option"><span>더보기</span></button>
							<div class="company"><a href="recruit_detail01.php">(주)파이낸뷰</a></div>
							<div class="text_box">
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 </a></div>
								<div class="info">
                  <span>서울 성동구</span>
									<span class="pay"><b>월급</b> <em>100만원</em></span>
									<span class="gender">남자</span>
									<span class="time">시간협의</span>
									<span class="etc"><p>상시모집</p></span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box2">
								<div class="title"><img src="images/info.png" alt="">등록된 내용이 없습니다.</div>
							</div>
						</li>
					</ul>
					<div class="paging_con cf">
						<div class="paging">
							<a href="#">1</a>
							<a href="#">2</a>
							<a href="#" class="active">3</a>
							<a href="#">4</a>
							<a href="#">5</a>
							<a href="#">6</a>
							<a href="#">7</a>
						</div>
					</div>
				</section>
				<!-- //스페셜 -->

				<!-- 배너 -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner1-5.jpg" alt=""></a>
				</div>

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