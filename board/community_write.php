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

			<!-- 커뮤니티 글쓰기 -->
			<div class="layer1 cf">
				<section class="cont_box community_con">
					<h2><img src="/images/write.png" alt="글작성">글작성</h2>
						<ul class="info_con">
							<li class="row1">
								<label for="sort">Төрөл<span class="check"></span></label>
								<select id="sort" class="st_sort">
									<option>Төрөл сонгох</option>
									<option></option>
									<option></option>
								</select>
							</li>					  
							<li class="row2">
								<label for="writer">Writer<span class="check"></span></label>
								<input type="text" id="writer" name="" maxlength="41">
							</li>
							<li class="row3">
								<label for="pw">Нууц дугаар<span class="check"></span></label>
								<input type="password" id="pw" name="" maxlength="16">
							</li>
							<li class="row7">
								<label for="title">Гарчиг<span class="check"></span></label>
								<input type="text" id="title" name="">
							</li>
							<li class="row8">
								<label for="content">Агуулга<span class="check"></span></label>
								<textarea id="content" name="" rows="9"></textarea>
							</li>
							<li class="row9">
								<label for="capcha">Автомат бүртгэлээс сэргийлэх</label>
								<div class="capcha_group">
									<div class="capcha_bx">1256KDS3</div>
									<input type="text" id="capcha" name=""><p>Дээрх текстийг оруулна уу.</p>
								<div>
							</li>
						</ul>
				</section>

				<div class="button_con">
					<a href="#" class="bottom_btn06">Бүртгүүлэх</a><a href="#" class="bottom_btn02">Цуцлах</a>
				</div>

			</div>
			<!-- //커뮤니티 글쓰기 -->

			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>