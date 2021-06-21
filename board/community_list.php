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

				<!-- 커뮤니티 텍스트형 -->
			  <section class="cont_box community_txt">
          <h2><span class="tit_ico"><img src="/images/title_icon02.png" alt=""></span>Ажлын нөу хау<span class="bt_box"><a href="#" class="write_bt">Бичих</a></span></h2>

					<!--  분류탭 -->
					<div class="sort_area cf">
					  <div class="sort_tab cf">
						  <ul>
							  <li><a href="#" class="active">Төрөл 1</a></li>
							  <li><a href="#">Төрөл 2</a></li>
							  <li><a href="#">Төрөл 3</a></li>
							  <li><a href="#">Төрөл  4</a></li>
							  <li><a href="#">Төрөл 5</a></li>
							  <li><a href="#">Төрөл 6</a></li>
							  <li><a href="#">Төрөл 7</a></li>
							</ul>
						</div>
					</div>

          <!-- 검색/분류 -->
					<div class="sort_choice cf">
					  <ul class="sort_inner cf">
							<li class="sort_select">
							  <select>
								  <option>Гарчиг</option>
									<option></option>
									<option></option>
								</select>
							</li>
							<li class="sort_sch">
							  <input type="text" id="" name=""><button type="button">Хайх</button>
							</li>
							<li class="sort_bx">
							  <select>
								  <option>15ш хайх</option>
									<option></option>
									<option></option>
								</select>
							</li>
						</ul>
					</div>

					<ul class="cont_box_inner">
						<li>
							<div class="text_box">
								<div class="title"><a href="#">Худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах</a></div>
								<div class="info">
                  <span class="name">Админ</span>
									<span class="date">2019.10.16</span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box">
                                <div class="title"><a href="#">Худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах</a></div>
								<div class="info">
                                    <span class="name">Админ</span>
									<span class="date">2019.10.16</span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box">
                                <div class="title"><a href="#">Худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах</a></div>
								<div class="info">
                                    <span class="name">Админ</span>
									<span class="date">2019.10.16</span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box">
                                <div class="title"><a href="#">Худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах</a></div>
								<div class="info">
                                    <span class="name">Админ</span>
									<span class="date">2019.10.16</span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box">
                                <div class="title"><a href="#">Худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах</a></div>
								<div class="info">
                                    <span class="name">Админ</span>
									<span class="date">2019.10.16</span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box">
                                <div class="title"><a href="#">Худалдааны төв цагийн ажил ажилд зуучлах онлайн дэлгүүр худалдааны төв цагийн ажил ажилд зуучлах</a></div>
								<div class="info">
                                    <span class="name">Админ</span>
									<span class="date">2019.10.16</span>
								</div>
							</div>
						</li>
						<li>
							<div class="text_box2">
								<div class="title"><img src="/images/info.png" alt="">Бүртгэлтэй мэдээлэл байхгүй байна.</div>
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
				<!-- //커뮤니티 텍스트형 -->

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