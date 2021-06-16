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
								<label for="sort">분류<span class="check"></span></label>
								<select id="sort" class="st_sort">
									<option>분류선택</option>
									<option></option>
									<option></option>
								</select>
							</li>					  
							<li class="row2">
								<label for="writer">작성자<span class="check"></span></label>
								<input type="text" id="writer" name="" maxlength="41">
							</li>
							<li class="row3">
								<label for="pw">비밀번호<span class="check"></span></label>
								<input type="password" id="pw" name="" maxlength="16">
							</li>
							<li class="row7">
								<label for="title">제목<span class="check"></span></label>
								<input type="text" id="title" name="">
							</li>
							<li class="row8">
								<label for="content">내용<span class="check"></span></label>
								<textarea id="content" name="" rows="9"></textarea>
							</li>
							<li class="row9">
								<label for="capcha">자동등록방지</label>
								<div class="capcha_group">
									<div class="capcha_bx">1256KDS3</div>
									<input type="text" id="capcha" name=""><p>위에 보이는 문자를 입력하세요.</p>
								<div>
							</li>
						</ul>
				</section>

				<div class="button_con">
					<a href="#" class="bottom_btn06">등록</a><a href="#" class="bottom_btn02">취소</a>
				</div>

			</div>
			<!-- //커뮤니티 글쓰기 -->

			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>