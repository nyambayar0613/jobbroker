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
				</div>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

			  <section class="cont_box detail_con">
                  <h2 class="top_tit">Гэрээсээ удаан хугацаанд ажиллах боломжтой цагийн ажил хайж байна.</h2>
          <div class="top_area">
            <ul>
                <li><span>Холбогдох боломжтой цаг <em>18:00~00:00</em></span></li>
                <li class="btn_report"><a href="#"><img src="/images/icon_notify.gif" alt="Мэдэгдэх">Мэдэгдэх</a></li>
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
											<li class="pf_name">Mr Hong</li>
											<li class="pf_info"><p class="gender">남</p><p class="birth">1989</p></li>
											<li class="slash">/</li>
											<li class="pf_id">test_individual</li>
										</ol>
									</p>
								</li>
								<li><span><img src="/images/info1-3.png" alt="Холбогдох дугаар"></span><p>02-000-0000</p></li>
								<li><span><img src="/images/info1-2.png" alt="Утасны дугаар"></span><p>010-1234-5678</p><em class="call_btn"><a href="#"><img src="/images/tel_ico.png" alt="Залгах">Залгах</a></em></li>
								<li><span><img src="/images/info1-4.png" alt="И-мэйл"></span><p>webmaster@test.com</p></li>
								<li class="address4"><span><img src="/images/info1-5.png" alt="Хаяг"></span><p>Namseon Building, Namseon Building, Geumnam-ro 5-ga, Dong-gu, Gwangju, БНСУ, 407 тоот.</p></li>
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
					<div class="tab-box tab2-box">

						<!-- 보유자격증 -->
					  <div class="resume_ct r_ct4 cf">
							<h3>Эзэмшиж буй мэргэжлийн үнэмлэх</h3>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:20%"><col style="width:40%"><col style="width:40%">
								</colgroup>
                <tr>
								  <th scope="row">Авсан огноо</th>
									<th scope="row">Мэргэжлийн үнэмлэх</th>
									<th scope="row">Гаргасан огноо</th>
								</tr>
                <tr>
								  <td>2018он</td>
									<td>Компьютерийн мэдлэгийн түвшин 2</td>
									<td>Худалдаа Аж Үйлдвэрийн Танхим</td>
								</tr>
                <tr>
								  <td>2019년</td>
									<td>word processor level 2</td>
									<td>Korea Chamber of Commerce and Industry</td>
								</tr>
                <tr>
								  <td>2020년</td>
                    <td>Компьютерийн мэдлэгийн түвшин 2</td>
                    <td>Худалдаа Аж Үйлдвэрийн Танхим</td>
								</tr>
                <tr>
								  <td>2021년</td>
									<<td>Компьютерийн мэдлэгийн түвшин 2</td>
                    <td>Худалдаа Аж Үйлдвэрийн Танхим</td>
							</table>
						</div>

						<!-- 외국어능력 -->
					  <div class="resume_ct r_ct5 cf">
							<h3>Гадаад хэлний түвшин</h3>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:30%"><col style="width:70%">
								</colgroup>
                <tr>
								  <th scope="row">Гадаад хэл</th>
									<th scope="row">Хэлний мэдлэг / сертификаттай / хэлний бэлтгэл</th>
								</tr>
                <tr>
								  <td>Англи хэл</td>
									<td>
									  <div><span class="txt_hd">Ярих чадвар</span> <em class="lv1">Дээд</em><span>Өдөр тутмын яриа</span></div>
										<div><span class="txt_hd">Албан ёсны шалгалт</span><span>TOEIC</span> / <span>900оноо</span> / <span>2019жил</span></div>
	                  <div><span class="txt_hd">Хэлний бэлтгэл</span> 6 жилээс дээш</div>
									</td>
								</tr>
                <tr>
                    <td>Англи хэл</td>
									<td>
                                        <div><span class="txt_hd">Ярих чадвар</span> <em class="lv1">Дээд</em><span>Өдөр тутмын яриа</span></div>
                                        <div><span class="txt_hd">Албан ёсны шалгалт</span><span>TOEIC</span> / <span>900оноо</span> / <span>2019жил</span></div>
                                        <div><span class="txt_hd">Хэлний бэлтгэл</span> 6 жилээс дээш</div>
									</td>
								</tr>
                <tr>
                    <td>Англи хэл</td>
                    <td>
                        <div><span class="txt_hd">Ярих чадвар</span> <em class="lv1">Дээд</em><span>Өдөр тутмын яриа</span></div>
                        <div><span class="txt_hd">Албан ёсны шалгалт</span><span>TOEIC</span> / <span>900оноо</span> / <span>2019жил</span></div>
                        <div><span class="txt_hd">Хэлний бэлтгэл</span> 6 жилээс дээш</div>
									</td>
								</tr>
							</table>
						</div>

            <!-- OA능력 및 특기사항 -->
					  <div class="resume_ct r_ct3 cf">
							<h3>OAчадвар ба онцлог шинж чанарууд</h3>
							<table class="edu_tb2">
							  <colgroup>
								  <col style="width:26%"><col style="width:74%">
								</colgroup>
							  <tr>
								  <th scope="row">OA чадвар</th>
                  <td>
									  <div><span class="oa_item">Hangil/MS Word</span><em class="lv1">Дээд</em> Table/tool available</div>
										<div><span class="oa_item">Power Point</span><em class="lv2">Дунд</em> Format/shape available</div>
										<div><span class="oa_item">Excel</span><em class="lv3">Доод</em>Formula/function can be used</div>
										<div><span class="oa_item">Internet</span><em class="lv1">Дээд</em> information gathering skills</div>
									</td>
								</tr>
							  <tr>
								  <th scope="row">Компьютер дээр ажиллах чадвар</th>
                  <td>Програмчлал, дизайн, компьютерийн мэдлэг, компьютер угсрах / суурилуулах</td>
								</tr>
							  <tr>
								  <th scope="row">Нэмэлт чадвар</th>
                  <td>Баримт бичгээ бичихдээ сайн, компьютер угсрах / угсрах чадвартай, хурдан тооцоолох, ярих чадвар сайтай, бие бялдар, дуу хоолой сайтай</td>
								</tr>
								  <th scope="row">Шагнал/Гэрчилгээ</th>
                  <td>Байхгүй</td>
								</tr>
							</table>
            </div>

						<!-- 부가정보 -->
					  <div class="resume_ct r_ct6 cf">
							<h3>Өрхийн мэдээлэл</h3>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:20%"><col style="width:20%"><col style="width:20%"><col style="width:40%">
								</colgroup>
                <tr>
								  <th scope="row">Хөгжлийн бэрхшээлтэй эсэх</th>
									<th scope="row">Гэрлэсэн эсэх</th>
									<th scope="row">Цэргийн алба хаасан эсэх</th>
									<th scope="row">Хүндэтгэх шалтгаан</th>
								</tr>
                <tr>
								  <td>Not applicable</td>
									<td>Ганц бие</td>
									<td>Ганц бие</td>
									<td>Хүндэтгэх шалтгаан<br><span>(хүнд хөгжлийн бэрхшээлтэй)</span></td>
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
          <h2>[공지]</h2>
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