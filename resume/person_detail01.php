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
                  <a href="recruit_main.php" class="active">Ажлын байрны мэдээлэл</a>
                  <a href="person_main.php">Хүний нөөц</a>
                  <a href="community_main.php">Комиунити</a>
				</div>and bad resumes
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

			  <section class="cont_box detail_con">
				  <h2 class="top_tit">Гэрээсээ удаан хугацаанд ажиллах боломжтой цагийн ажил хайж байна.</h2>

          <!-- 신고하기 팝업 -->			 
						<div class="detail_ly mail_ly report_bx cf" style="display:block">
							<div class="detail_inner">
								<div class="box-title"><h2>Ажлын байрны талаар мэдээлэх</h2>
									<div class="btn-r">
										<button id="close_ly" type="button">X</button>
									</div>
								</div>
								<div class="text_area">
									<fieldset>
										<legend>Мэдээллэх шалтгаан</legend>
										<ul>
											<li><input type="radio" id="" name=""> Холбоо барих мэдээлэл буруу</li>
											<li><input type="radio" id="" name=""> Алдаатай анкет</li>
											<li><input type="radio" id="" name=""> Хуурамч мэдээлэл</li>
											<li><input type="radio" id="" name=""> Өөрөө шууд бичих</li>
										</ul>
									</fieldset>
								</div>
								<div class="btn_area">
									<ul>
										<li class="rept_bt1"><a href="#">Мэдэгдэх</a></li>
										<li class="rept_bt2"><a href="#">Цуцлах</a></li>
									</ul>
								</div>
							</div>
						</div>	
					<!-- //신고하기 팝업 -->

          <div class="top_area">
            <ul>
							<li class="ktid"><span>Kakao ID : <em>kakao-id</em></span></li>
							<li><span>Холбогдох боломжтой цаг <em>18:00~00:00</em></span></li>
							<li class="btn_report"><a href="#"><img src="/images/icon_notify.gif" alt="мэдэгдэх">мэдэгдэх</a></li>
						</ul>
					</div>
					<div class="profile_con cf">
						<div class="pic_box">
							<a href="#"><img src="/images/id_pic.png" alt="ID зураг"><!-- <img src="/images/id_pic2.png" alt="증명사진"> --></a>
						</div>
						<div class="txt_box cf">
							<ul>
								<li>
								  <span><img src="/images/info1-1.png" alt="Нэр, ID"></span>
									<p>
									  <ol>
											<li class="pf_name">Hong gil dong</li>
											<li class="pf_info"><p class="gender">Эр</p><p class="birth">1989</p></li>
											<li class="slash">/</li>
											<li class="pf_id">test_individual</li>
										</ol>
									</p>
								</li>
								<li><span><img src="/images/info1-3.png" alt="Холбогдох дугаар"></span><p>02-000-0000</p></li>
								<li><span><img src="/images/info1-2.png" alt="Утасны дугаар"></span><p>010-1234-5678</p><em class="call_btn"><a href="#"><img src="/images/tel_ico.png" alt="Залгах">Залгах</a></em></li>
								<li><span><img src="/images/info1-4.png" alt="И-мэйл></span><p>webmaster@test.com</p></li>
								<li class="address4"><span><img src="/images/info1-5.png" alt="хаяг"></span><p>Room 407, Namseon Building, Namseon Building, Geumnam-ro 5-ga, Dong-gu, Gwangju, Republic of Korea</p></li>
							</ul>
						</div>
						<div class="etc_box cf">
						  <ul>
							  <li><span>Боловсрол</span><p>Их сургууль(4жил)төгссөн</p></li>
								<li><span>Туршлага</span><p>Байхгүй</p></li>
								<li><span>Хүсч буй цалин</span><p>Дараа нь тохиролцох</p></li>
								<li><span>Мэргэжлийн үнэмлэх</span><p>Компьютер ашиглах түвшин 1</p></li>
								<li><span>Гадаад хэдний түвшин</span><p>Англи хэл<em>Дунд</em> 1 хэл</p></li>
							</ul>
						</div>
					</div>
					<div class="button_group scrap_bt">
					  <button type="button" class="bt-apply">Ажилд орох өргөдөл</button>
					  <button type="button" class="bt-scrap"><img src="/images/scrap_icon2.png" alt="scrab"><!--<img src="/images/scrap_icon1.png">-->scrab</button>
					</div>
				</section>

				<section class="cont_box detail_con detail_con2">
				  <div class="tab2-con cf">
					  <ul>
						  <li class="active"><a href="#">CV мэдээлэл</a></li>
						  <li><a href="#">Мэргэшсэн байдал</a></li>
						  <li><a href="#">Өөрийн танилцуулга</a></li>
            </ul>
					</div>

					<!-- 희망근무조건 -->
					<div class="tab-box tab1-box">
					  <div class="resume_ct r_ct1 cf">
							<h3>Хүсч буй ажлын нөхцөл</h3>
							<table class="cf">
								<tr>
									<th scope="row">Байржил</th>
									<td>Сөүл</td>
								</tr>
								<tr>
									<th scope="row">Салбар</th>
									<td>IT, design, site operation, management, content management, site operation, content management</td>
								</tr>
								<tr>
									<th scope="row">Ажлын өдөр</th>
									<td>3 сар хүртэл, Даваа гарагаас Бямба гараг хүртэл</td>
								</tr>
								<tr>
									<th scope="row">Цалин</th>
									<td>Тохирно</td>
								</tr>
								<tr>
									<th scope="row">Ажлын төрөл</th>
									<td>Гэрээт цагын ажилтан</td>
								</tr>
							</table>
						</div>

						<!-- 학력사항 -->
					  <div class="resume_ct r_ct2 cf">
							<h3>Боловсрол</h3>
							<!-- 대학원 재학 -->
							<table class="edu_tb1">
								<tr>
									<th scope="row">Боловсрол</th>
									<td>Магистр суралцагч<span class="off">(Чөлөө авсан)</span></td>
								</tr>
							</table>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:40%"><col style="width:25%"><col style="width:20%"><col style="width:15%">
								</colgroup>
                <tr>
								  <th scope="row">Хугацаа</th>
									<th scope="row">Сургуулийн нэр</th>
									<th scope="row">Мэргэжил</th>
									<th scope="row">Зэрэг</th>
								</tr>
                <tr>
								  <td>2019~2020 Сургуулиа орхисон</td>
									<td>00 Их сургууль</td>
									<td>전산</td>
									<td>Магистр</td>
								</tr>
                <tr>
								  <td>2019~2020 Суралцаж байгаа</td>
									<td>00 Их сургууль</td>
									<td>전산</td>
									<td>Магистр</td>
								</tr>
                <tr>
								  <td>2019~2020 Төгссөн</td>
									<td>00 Их сургууль</td>
									<td>전산</td>
									<td>Магистр</td>
								</tr>
							</table>

							<!-- 대학교(4학년) 재학 -->
							<table class="edu_tb1">
								<tr>
									<th scope="row">Боловсролын мэдээлэл</th>
                                    <td>Суралцагч<span class="off">(Чөлөө авсан)</span></td>
								</tr>
							</table>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:40%"><col style="width:40%"><col style="width:20%">
								</colgroup>
                <tr> <th scope="row">Хугацаа</th>
                    <th scope="row">Сургуулийн нэр</th>
                    <th scope="row">Мэргэжил</th>
								</tr>
                <tr>
                    <td>2019~2020 Сургуулиа орхисон</td>
                    <td>00 Их сургууль</td>
                    <td>전산</td>
                    <td>Магистр</td>
                </tr>
                                <tr>
                                    <td>2019~2020 Суралцаж байгаа</td>
                                    <td>00 Их сургууль</td>
                                    <td>전산</td>
                                    <td>Магистр</td>
                                </tr>
                                <tr>
                                    <td>2019~2020 Төгссөн</td>
                                    <td>00 Их сургууль</td>
                                    <td>전산</td>
                                    <td>Магистр</td>
								</tr>
							</table>

							<!-- 고등학교 재학 -->
							<table class="edu_tb1">
								<tr>
									<th scope="row">Боловсрол</th>
									<td>Ахлах сургууль<span class="off">(Чөлөө авсан)</span></td>
								</tr>
							</table>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:50%"><col style="width:50%">
								</colgroup>
                <tr>
								  <th scope="row">Хугацаа</th>
									<th scope="row">Сургуулийн нэр</th>
								</tr>
                <tr>
								  <td>2019~2020 Суралцаж байгаа</td>
									<td>00 Ахлах сургууль</td>
								</tr>
							</table>
						</div>

            <!-- 경력사항 -->
					  <div class="resume_ct r_ct3 cf">
							<h3>Ажлын салбар</h3>

							<!-- 경력사항1 -->
							<table class="edu_tb2">
							  <caption style="border-top:0">Ажил мэргэжил 1</caption>
							  <tr>
								  <th scope="row">Байгууллагын нэр</th>
                  <td>Netfu</td>
								</tr>
							  <tr>
								  <th scope="row">Салбар</th>
                  <td>IT, design, site operation, management, content management, site operation, content management</td>
								</tr>
							  <tr>
								  <th scope="row">Ажиллах хугацаа</th>
                  <td>2019он 11сар ~ 2020жил 12сар</td>
								</tr>
								  <th scope="row">Хариуцсан албан тушаал</th>
                  <td>Маркетинг</td>
								</tr>
								</tr>
								  <th scope="row">Дэлгэрэнгүй</th>
                  <td>Site operation/content management</td>
								</tr>
							</table>

							<!-- 경력사항1 -->
							<table class="edu_tb2">
							  <caption>Ажил мэргэжил 2</caption>
							  <tr>
                                  <th scope="row">Байгууллагын нэр</th>
                                  <td>Netfu</td>
                              </tr>
                                <tr>
                                    <th scope="row">Салбар</th>
                                    <td>IT, design, site operation, management, content management, site operation, content management</td>
                                </tr>
                                <tr>
                                    <th scope="row">Ажиллах хугацаа</th>
                                    <td>2019он 11сар ~ 2020жил 12сар</td>
                                </tr>
                                <th scope="row">Хариуцсан албан тушаал</th>
                                <td>Маркетинг</td>
                                </tr>
                                </tr>
                                <th scope="row">Дэлгэрэнгүй</th>
                                <td>Site operation/content management</td>
								</tr>
							</table>
            </div>

          </div>
					<div class="caution">
<p>Зохиогчийн эрх эзэмшигч ⓒ Нэгдсэн ажил хайх вэбсайт - Netpyu.  Зөвшөөрөлгүй хуулбарлахыг хориглоно &gt;</p>
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
          <h2>[Зарлал]</h2>
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