<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // Тус тусад нь хуудас руу нэвтрэх боломжгүй

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
					<a href="recruit_main.php" class="active">Ажлын байрны мэдээлэл</a>
					<a href="person_main.php">Хүний нөөцийн мэдээлэл</a>
					<a href="community_main.php">Комиунити</a>
				</div>
				<div class="navi_cate">
				  <a href="#" class="prev_btn menu_arrow"><img src="images/menu_arrow1.png" alt="өмнөх"></a>
					<div class="cate_con cf">
						<a href="#">Яаралтай</a>
						<a href="#">Бүс нутгаар</a>
						<a href="#">Салбараар</a>
						<a href="#">Автобусны буудалтай ойр</a>
						<a href="#">Их сургуулиудтай ойр</a>
						<a href="#">Хугацаагаар</a>
						<a href="#">Цалин хөлсөөр</a>
						<a href="#">Нөхцөлөөр</a>
						<a href="#" class="active">Дэлгэрэнгүй хайх</a>
					</div>
				  <a href="#" class="next_btn menu_arrow"><img src="images/menu_arrow2.png" alt="дараагийх"></a>
				</div>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">
        
				<!-- Дэлгэрэнгүй хайх -->
				<div class="schbox_wrap sch_wrap cf">
					<div class="search_con search_box">
						<table class="search_tb">

							<!-- ажлын байршил -->
							<tr>
								<th class="sch_hd">
									<div>Ажилын байршил</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>хот</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2">
									<select>
										<option>хороо . дүүрэг</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td3">
									<select>
										<option>тоот . дугаар</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- Автобус/Метроны буудалтай ойр -->
							<tr>
								<th class="sch_hd">
									<div>Автобусны буудалтай ойр</div>
								</th>
								<td class="sch_td1" colspan="3">
									<select>
										<option>Улаанбаатар хотын бүс</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								</td>
							</tr>

							<!-- их сургууль -->
							<tr>
								<th class="sch_hd">
									<div>Их сургуультай ойр</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>Байршил</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2" colspan="2">
									<select>
										<option>Сургууль сонгох</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- Ажил мэргэжил -->
							<tr>
								<th class="sch_hd">
									<div>Ажил мэргэжил</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>Ажлын төрөл 1 </option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2">
									<select>
										<option>Ажлын төрөл 2</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td3">
									<select>
										<option>Ажлын төрөл 3</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- Ажиллах хугацаа -->
							<tr>
								<th class="sch_hd">
									<div>Ажиллах хугацаа</div>
								</th>
								<td class="sch_td1" colspan="3">
									<select>
										<option>Ажиллах хугацаа</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- Ажиллах өдөр -->
							<tr>
								<th class="sch_hd">
									<div>Ажиллах өдөр</div>
								</th>
								<td class="sch_td1" colspan="3">
									<select>
										<option>Ажиллах өдөр</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- Ажлын цаг -->
							<tr>
								<th class="sch_hd sch_hd1-2">
									<div>Ажлын цаг</div>
								</th>
								<td class="sch_td1 sch_td1-2" colspan="3">
								  <fieldset>
										<legend>Ажлын цаг</legend>
										<select>
											<option>цаг</option>
											<option></option>
											<option></option>
											<option></option>
										</select>
										<select>
											<option>минут</option>
											<option></option>
											<option></option>
											<option></option>
										</select>
										~
										<select>
											<option>цаг</option>
											<option></option>
											<option></option>
											<option></option>
										</select>
										<select>
											<option>минут</option>
											<option></option>
											<option></option>
											<option></option>
										</select>
										<label><input type="checkbox" id="" name="">Цагийн хэлэлцээ</label>
									</fieldset>
								</td>
							</tr>

							<!-- Цалин, хөлс -->
							<tr>
								<th class="sch_hd">
									<div>Цалин</div>
								</th>
								<td class="sch_td2" colspan="3">
								  <fieldset>
										<legend>Цалин сонгох</legend>
										<ul>
											<li><input type="checkbox" id="" name="">Цагын</li>
											<li><input type="checkbox" id="" name="">Өдрийн</li>
											<li><input type="checkbox" id="" name="">Долоо хоногийн</li>
											<li><input type="checkbox" id="" name="">Сарын</li>
											<li><input type="checkbox" id="" name="">Жилийн<input type="text" id="" name="">төгрөгөөс дээш~<input type="text" id="" name="">төгрөгөөс доош</li>
										<ul>
	                </fieldset>
								</td>
							</tr>

							<!-- хүйс -->
							<tr>
								<th class="sch_hd">
									<div>Хүйс сонгох</div>
								</th>
								<td class="sch_td2" colspan="3">
								  <fieldset>
										<legend>Хүйс сонгох</legend>
										<input type="radio" id="male" name="">эрэгтэй
										<input type="radio" id="female" name="">эмэгтэй
										<input type="checkbox" id="no-gender">хүйс тодорхойлохгүй
                  </fieldset>
								</td>
							</tr>

							<!-- Хайлтын төрөл 5 -->
							<tr>
								<th class="sch_hd">
									<div>нас</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>Нас</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2" colspan="2">
								  <fieldset>
									  <legend>Нас сонгох</legend>
										<input type="checkbox" id="under">доош
										<input type="checkbox" id="over">дээш
										<input type="checkbox" id="unrelated">хамааралгүй
									</fieldset>
								</td>
							</tr>

							<!-- Боловсрол -->
							<tr>
								<th class="sch_hd">
									<div>Боловсрол сонгох</div>
								</th>
								<td class="sch_td1" colspan="3">
									<select>
										<option>Боловсрол</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
							</tr>

							<!-- Хайлтын төрөл 5 -->
							<tr>
								<th class="sch_hd">
									<div>Мэргэжил сонгох</div>
								</th>
								<td class="sch_td1">
									<select>
										<option>Хугацаа</option>
										<option></option>
										<option></option>
										<option></option>
									</select>
								</td>
								<td class="sch_td2" colspan="2">
								  <fieldset>
									  <legend>Мэргэжил сонгох</legend>
										<input type="checkbox" id="unrelated">хамааралгүй
										<input type="checkbox" id="new-recruit">шинэ төгсөгч
										<input type="checkbox" id="career">ажил мэргэжил
									</fieldset>
								</td>
							</tr>

							<!-- хайх утга оруулах -->
							<tr>
								<th class="sch_hd" style="background:#fff;border-right:0">
									<div>Хайх үг</div>
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
								<button type="button" class="sch_button"><img src="images/search_icon3.png" alt="Хайх">Хайх</button>
							</li>
						</ul>
					</div>
        </div>
				<!-- //Дэлгэрэнгүй хайх -->

				<!-- banner -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner1-2.jpg" alt=""></a>
				</div>

				<!-- пилатинум -->
			  <section class="cont_box platinum_con">
          <h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>Пилатинум ажлын зар<span class="bt_box"><em>1</em>/18 тохиолдол <a href="#"><span class="btn">Зар сурталчилгаа<img src="images/chevron.png" alt="광고안내"></span></a></span></h2>
					<ul class="cont_box_inner">
						<li>

						  <!-- дэлгэрэнгүй харах
              <div class="detail_ly cf">
                <div class="detail_inner">
                  <div class="company_name"><h2>(주)</h2>
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
							<!-- //Дэлгэрэнгүй харах -->

						  <button id="show_ly" class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo01.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвд цагийн ажилд зуучлах(агуулахын бүртгэл, бүтээгдэхүүн хүргэлт сав баглаа боодол)</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo02.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвд цагийн ажилд зуучлах(агуулахын бүртгэл, бүтээгдэхүүн хүргэлт сав баглаа боодол)</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo03.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвд цагийн ажилд зуучлах(агуулахын бүртгэл, бүтээгдэхүүн хүргэлт сав баглаа боодол)</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo04.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвд цагийн ажилд зуучлах(агуулахын бүртгэл, бүтээгдэхүүн хүргэлт сав баглаа боодол)</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo05.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвд цагийн ажилд зуучлах</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
							<div class="white_box">
							  <div class="whitebox_inner">
                  <div class="text">Зар сурталчилгааны бүртгэл хүлээгдэж байна</div>
								  <a href="#"><div class="btn">Зар суртачилгаа болон танилцуулга<img src="images/chevron.png" alt="Зар суртачилгаа болон бүртгэл"></div></a>
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
				<!-- //Пилатинум -->

				<!-- banner -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner5.jpg" alt=""></a>
				  <!-- нэмэлт banner <a href="#"><img src="images/banner5.jpg" alt=""></a> -->
				</div>

				<!-- grand -->
			  <section class="cont_box banner_con">
          <h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>Ажлын байрны төрөл<span class="bt_box"><em>1</em>/18 төрөл <a href="#"><span class="btn">Зар суртачилгаа<img src="images/chevron.png" alt="Зар суртачилгаа"></span></a></span></h2>
					<ul class="cont_box_inner">
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo01.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo02.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo03.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo04.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo05.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
							<div class="white_box">
							  <div class="whitebox_inner">
                  <div class="text">Зар сурталчилгааны бүртгэл хүлээгдэж байна </div>
								  <a href="#"><div class="btn">Зар суртачилгааны танилцуулга болон бүртгэл<img src="images/chevron.png" alt="Зар суртачилгааны танилцуулга болон бүртгэл"></div></a>
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
				<!-- //Grand -->

				<!-- banner -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner3.jpg" alt=""></a>
				</div>

				<!-- Special -->
			  <section class="cont_box _con webzine_con web1">
          <h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>Special ажлын мэдээлэл<em class="ad_btn"><a href="#"><span class="btn">Зар суртачилгааны танилцуулга<img src="images/chevron.png" alt="Зар суртачилгааны танилцуулга"></span></a></em></h2>
					<ul class="cont_box_inner">
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo01.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвийн цагийн ажилд зуучлах </a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo02.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол)</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй мэдээлэл</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo03.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол)</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo04.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол)</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
						  <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="logo_box">
								<a href="#"><img src="images/logo05.png" alt="LOGO"></a>
							</div>
							<div class="text_box">
								<div class="company"><a href="#">Финанс Вью ХХК</a></div>
								<div class="title"><a href="#">Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол)</a></div>
								<div class="info">
                  <span class="area">Seongdong-gu, Сөүл</span>
									<span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="etc"><p>Тогтмол бүртгүүлэх</p></span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box2">
								<div class="title"><img src="images/info.png" alt="">Бүртгүүлсэн утга олдсонгүй.</div>
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
				<!-- //special -->

				<!-- banner -->
			  <div class="banner01">
				  <a href="#"><img src="images/banner4.jpg" alt=""></a>
				  <!-- <a href="#"><img src="images/banner1-3.jpg" alt=""></a> -->
				</div>

				<!-- 일반형 -->
			  <section class="cont_box _con cont_list recruit1">
          <h2><span class="tit_ico"><img src="/images/title_icon01.png" alt=""></span>Ерөнхий ажлын мэдээлэл<em class="ad_btn"><a href="#"><span class="btn">Зар суртачилгаа<img src="images/chevron.png" alt="Зар суртачилгаа"></span></a></em></h2>
					<ul class="cont_box_inner">
						<li>
              <button class="more_option"><span>Дэлгэрэнгүй</span></button>
							<div class="company"><a href="recruit_detail01.php">Финанс Вью ХХК</a></div>
							<div class="text_box">
								<div class="title"><a href="#"> Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол) </a></div>
								<div class="info">
                                    <span class="area">Seongdong-gu, Сөүл</span>
                                    <span class="pay"><b>Цалин</b> <em>1 сая</em></span>
									<span class="time">Цаг тохиролцох</span>
									<span class="etc"><p>Тогтмол элсэлт</p></span>
								</div>
							</div>
						</li>
						<li>
                            <button class="more_option"><span>Дэлгэрэнгүй</span></button>
                            <div class="company"><a href="recruit_detail01.php">Финанс Вью ХХК</a></div>
                            <div class="text_box">
                                <div class="title"><a href="#"> Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол) </a></div>
                                <div class="info">
                                    <span class="area">Seongdong-gu, Сөүл</span>
                                    <span class="pay"><b>Цалин</b> <em>1 сая</em></span>
                                    <span class="time">Цаг тохиролцох</span>
                                    <span class="etc"><p>Тогтмол элсэлт</p></span>
								</div>
							</div>
						</li>
						<li>
                            <button class="more_option"><span>Дэлгэрэнгүй</span></button>
                            <div class="company"><a href="recruit_detail01.php">Финанс Вью ХХК</a></div>
                            <div class="text_box">
                                <div class="title"><a href="#"> Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол) </a></div>
								<div class="info">
                                    <span class="area">Seongdong-gu, Сөүл</span>
                                    <span class="pay"><b>Цалин</b> <em>1 сая</em></span>
                                    <span class="time">Цаг тохиролцох</span>
                                    <span class="etc"><p>Тогтмол элсэлт</p></span>
								</div>
							</div>
						</li>
						<li>
                            <button class="more_option"><span>Дэлгэрэнгүй</span></button>
                            <div class="company"><a href="recruit_detail01.php">Финанс Вью ХХК</a></div>
                            <div class="text_box">
                                <div class="title"><a href="#"> Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол) </a></div>
                                <div class="info">
                                    <span class="area">Seongdong-gu, Сөүл</span>
                                    <span class="pay"><b>Цалин</b> <em>1 сая</em></span>
                                    <span class="time">Цаг тохиролцох</span>
                                    <span class="etc"><p>Тогтмол элсэлт</p></span>
								</div>
							</div>
						</li>
						<li>
                            <button class="more_option"><span>Дэлгэрэнгүй</span></button>
                            <div class="company"><a href="recruit_detail01.php">Финанс Вью ХХК</a></div>
                            <div class="text_box">
                                <div class="title"><a href="#"> Онлайн худалдааны төвийн цагийн ажилд зуучлах(агуулахын менежмент, бүтээгдэхүүн хүргэх, сав баглаа боодол) </a></div>
                                <div class="info">
                                    <span class="area">Seongdong-gu, Сөүл</span>
                                    <span class="pay"><b>Цалин</b> <em>1 сая</em></span>
                                    <span class="time">Цаг тохиролцох</span>
                                    <span class="etc"><p>Тогтмол элсэлт</p></span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box2">
								<div class="title"><img src="images/info.png" alt="">Бүртгэлтэй агуулга байхгүй байна.</div>
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
          <h2>[Зар]</h2>
					<ul class="cont_box_inner">
						<li>
							<div class="text_box">
                                <div class="title"><a href="#">Худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах</a><span class="n_date">2019.10.16</span></div>
							</div>
						</li>
					</ul>
				</section>

			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>