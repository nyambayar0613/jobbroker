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
				  <h2 class="top_tit"> Онлайн худалдааны төвийн цагийн ажилд зуучлах (агуулахын менежмент, бүтээгдэхүүн хүргэх, савлах))</h2>
          <div class="top_area">
            <ul>
							<li class="etc">Ажилд авах эцсийн хугацаа</li>
							<li class="ktid"><span>Kakao ID : <em>kakao-id</em></span></li>
							<li class="btn_report"><a href="#"><img src="/images/icon_notify.gif" alt="мэдэгдэх">Мэдэгдэх</a></li>
						</ul>
					</div>
				  <div class="company_con cf">
						<div class="logo_box">
							<img src="/images/logo01.png" alt="LOGO">
						</div>
						<div class="text_box">
							<div class="company">Finance wu LLC</div>
						</div>
					</div>
					<div class="company_info cf">
						<div class="mb_info ceo_info">
							<div class="ceo_inner">
								<dl>
									<dt class="hd hd2"><span><img src="/images/info1-1.png" alt="Хариуцсан хүн"></span>Хариуцсан хүн</dt>
									<dd class="col1 col2">
										<a href="#" class="hide">Ажлын байрны мэдээллийг үзэх үйлчилгээний өргөдөл</a>
									</dd>
								</ul>
							</div>
						</div>
						<div class="mb_info address_info">
							<div class="address_inner">
								<dl>
									<dt class="hd hd2"><span><img src="/images/info1-2.png" alt="Холбогдох дугаар"></span>Холбогдох дугаар</dt>
									<dd class="col1 col2">
										<a href="#" class="hide">Ажлын байрны мэдээллийг үзэх, үйлчилгээний талаар</a>
									</dd>
								</ul>
							</div>
						</div> 
					</div>

					<div class="button_group scrap_bt">

						  <!-- 온라인 입사지원 -->
              <div class="detail_ly mail_ly online_bx cf" style="display:block">
                <div class="detail_inner">
                  <div class="box-title"><h2>Ажилд орох өргөдөл (Онлайн)</h2>
                    <div class="btn-r">
									    <button id="close_ly" type="button">X</button>
                    </div>
									</div>
									<div class="text_area">
										<fieldset>
										  <legend>Анкет сонгох</legend>
											<ul class="inpt_bx resume_bx">
											  <li><label for="">Өргөдлийн гарчиг <input type="text" name="" id=""></label></li>
											  <li><label for="">Анкет сонгох <input type="text" name="" id=""></label></li>
											</ul>
										</fieldset>
										<fieldset>
										  <legend>Хавсаргах файл бүртгэл</legend>
											<div class="inpt_bx file_bx"><input type="file" name="" id=""></div>
										</fieldset>
										<fieldset>
										  <legend>Холбоо барих мэдээллийн тохиргоо</legend>
											<div class="inpt_bx contact_bx cf">
												<label><input type="checkbox" id="" name=""> Холбогдох дугаар</label>
												<label><input type="checkbox" id="" name=""> Утасны дугаар</label>
												<label><input type="checkbox" id="" name=""> И-мэйл</label>
												<label><input type="checkbox" id="" name=""> Хаяг</label>
												<label><input type="checkbox" id="" name=""> Нүүх хуудас</label>
											</div>
										</fieldset>
									</div>
									<div class="btn_area">
									  <ul>
											<li class="sbtn"><a href="#">Хүсэлт гаргах</a></li>
											<li class="abtn"><a href="#">Цуцлах</a></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- //온라인 입사지원 -->

						  <!-- 이메일 입사지원 -->
              <div class="detail_ly mail_ly email_bx cf" style="display:none">
                <div class="detail_inner">
                  <div class="box-title"><h2>Ажлын байрны өргөдөл</h2>
                    <div class="btn-r">
									    <button id="close_ly" type="button">X</button>
                    </div>
									</div>
									<div class="text_area">
										<fieldset>
										  <legend>Анкет сонгох</legend>
											<ul class="inpt_bx resume_bx">
											  <li><label for="">Анкетны маяг <span><input type="radio" name="" id=""> Анкет</span></label></li>
											  <li><label for="">Анкет сонгох <input type="text" name="" id=""></label></li>
											</ul>
										</fieldset>
										<fieldset>
                                            <legend>Хавсаргах файл бүртгэл</legend>
											<div class="inpt_bx file_bx"><input type="file" name="" id=""></div>
										</fieldset>
										<fieldset>
										  <legend>Холбоо барих мэдээллийн тохиргоо</legend>
											<div class="inpt_bx contact_bx cf">
                                                <label><input type="checkbox" id="" name=""> Холбогдох дугаар</label>
                                                <label><input type="checkbox" id="" name=""> Утасны дугаар</label>
                                                <label><input type="checkbox" id="" name=""> И-мэйл</label>
                                                <label><input type="checkbox" id="" name=""> Хаяг</label>
                                                <label><input type="checkbox" id="" name=""> Нүүх хуудас</label>
											</div>
										</fieldset>
									</div>
									<div class="btn_area">
									  <ul>
                                          <li class="sbtn"><a href="#">Хүсэлт гаргах</a></li>
                                          <li class="abtn"><a href="#">Цуцлах</a></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- //온라인 입사지원 -->

					  <button type="button" class="bt-online" id="show_ly">Ажилд орох өргөдөл (Онлайн)</button>
						<button type="button" class="bt-email" id="show_ly">Ажилд орох өргөдөл (И-мэйл)</button>
					  <button type="button" class="bt-scrap"><img src="/images/scrap_icon2.png" alt="scrab"><!--<img src="/images/scrap_icon1.png">-->scrab</button>
					</div>
				</section>

				<section class="cont_box detail_con detail_con2">
				  <div class="tab1-con cf">
					  <ul>
                          <li class="active"><a>Ажилд урьж байна</a></li>
                          <li><a>Дэлгэрэнгүй мэдээлэл</a></li>
                          <li><a>Ажлын байршил</a></li>
                          <li><a>Байгуууллагын тухай</a></li>
            </ul>
					</div>
					<div class="tab-box tab2-box">
            <table>
						  <tr>
							  <th>Эцсийн хугацаа</th>
								<td>full-time recruitment</td>
							</tr>
						  <tr>
							  <th>Ажилд авах хүний тоо</th>
								<td>00хүн</td>
							</tr>
						  <tr>
							  <th>Хүсэлт гаргах арга</th>
								<td>Онлайн</td>
							</tr>
						  <tr>
							  <th>Бүрдүүлэх баримт бичиг</th>
								<td>Анкет, иргэний үнэмлэхний хуулбар</td>
							</tr>
						  <tr>
							  <th>Ажилд авах</th>
								<td>Нягтлан бодох бүртгэл</td>
							</tr>
						  <tr>
							  <th>Байршил</th>
								<td>1585, Wonmun-ro, Mundeok-eup, Wonju-si, Gangwon-do (Geondeung-ri, Munmak-eup)</td>
							</tr>
						  <tr>
							  <th>Ажил мэргэжил (Career) </th>
								<td>хэргэм зэрэггүй
                                </td>
							</tr>
						  <tr>
							  <th>Цалин</th>
								<td>Сарын 1,900,000 төгрөг</td>
							</tr>
						  <tr>
							  <th>Ажиллах хугацаа</th>
								<td>1жилээс дээш</td>
							</tr>
						  <tr>
							  <th>Ажлын өдөр</th>
								<td>даваа~баасан</td>
							</tr>
						  <tr>
							  <th>Ажлын цаг</th>
								<td>08:30~18:30</td>
							</tr>
						  <tr>
							  <th>Ажлын төрөл</th>
								<td>Бүтэн цаг, Дадлага</td>
							</tr>
						  <tr>
							  <th>Даатгал,Халамж</th>
								<td>Хөдөлмөрийн даатгал, Үйлдвэрлэлийн нөхөн олговрын даатгал, Эрүүл мэндийн даатгал, Жил бүрийн чөлөө</td>
							</tr>
						  <tr>
							  <th>Хүйс</th>
								<td>Хамааралгүй</td>
							</tr>
						  <tr>
							  <th>Нас</th>
								<td>Хамааралгүй</td>
							</tr>
						  <tr>
							  <th>Боловсрол</th>
								<td>Боловсролгүй</td>
							</tr>
						  <tr>
							  <th>Асуулт</th>
								<td>Байхгүй</td>
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
          <h2>[Зар]</h2>
					<ul class="cont_box_inner">
						<li>
							<div class="text_box">
								<div class="title"><a href="#">LINE худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах онлайн худалдааны төв цагийн ажил ажилд зуучлах худалдааны төвийн цагийн ажилд зуучлах онлайн худалдааны төвийн цагийн ажилд зуучлах</a><span class="n_date">2019.10.16</span></div>
							</div>
						</li>
					</ul>
				</section>
			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>