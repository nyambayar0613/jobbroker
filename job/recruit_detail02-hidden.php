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
				  <h2 class="top_tit">Онлайн худалдааны төвийн цагийн ажилд зуучлах (агуулахын менежмент, бүтээгдэхүүн хүргэх, савлах)</h2>
          <div class="top_area">
            <ul>
							<li class="etc">Эцсийн хугацаа</li>
                <li class="ktid"><span>Kakao talk ID : <em>kakao-id</em></span></li>
                <li class="btn_report"><a href="#"><img src="/images/icon_notify.gif" alt="Мэдэгдэх">Мэдэгдэх</a></li>
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
										<a href="#" class="hide">Ажлын байрны мэдээллийг үзэх үйлчилгээний өргөдөл</a>
									</dd>
								</ul>
							</div>
						</div> 
					</div>
					<div class="button_group scrap_bt">
                        <button type="button" class="bt-online">Ажилд орох өргөдөл (Онлайн)</button>
                        <button type="button" class="bt-email">Ажилд орох өргөдөл (Мэйл)</button>
                        <button type="button" class="bt-scrap"><img src="/images/scrap_icon2.png" alt="scrab"><!--<img src="/images/scrap_icon1.png">-->Scrab</button>
					</div>
				</section>

				<section class="cont_box detail_con detail_con2">
				  <div class="tab1-con cf">
					  <ul>
                          <li><a href="#">Ажилд урьж байна</a></li>
                          <li class="active"><a href="#">Дэлгэрэнгүй мэдээлэ</a></li>
                          <li><a href="#">Ажлын байршил</a></li>
                          <li><a href="#">Байгуууллагын тухай</a></li>
            </ul>
					</div>
					<div class="tab-box tab4-box">
					  <div class="container cf">
              <div class="recruit_service">
							  <p>Хэрэв та дэлгэрэнгүйг уншихыг хүсвэл ажлын байрны мэдээллийг үзэх үйлчилгээнд хамрагдана уу.</p>
								<div class="member_btn">
									<div class="recruit_service_bt"><a href="#">Ажлын байрны мэдээллийг үзэх үйлчилгээний хүсэлт</a></div>
								</div>
							</div>
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
								<div class="title"><a href="#"> Худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах</a><span class="n_date">2019.10.16</span></div>
							</div>
						</li>
					</ul>
				</section>
			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>