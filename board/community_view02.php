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

				<!-- 커뮤니티 이미지형 -->
			  <section class="cont_box community_txt">
          <h2><span class="tit_ico"><img src="/images/title_icon03.png" alt=""></span>Photo булан</h2>
          <div class="community_inner cf">
						<div class="view_wrap">
						  <div class="view_top cf">
								<div class="view_title"><a href="#">Nature</a></div>
								<div class="view_info">
									<span class="mb_id"><strong>Netfu part time job</strong></span>
									<span>2019.11.08&nbsp;&nbsp;12:11</span>
									<span class="hits">Үзсэн тоо : <em>14</em></span>
								</div>
							</div>
							<div class="view_con cf">
							  <img src="/images/photo1.jpg" alt="">
							  <p>
아름다운 자연
								</p>
							</div>
						</div>
					</div>

					<div class="button-group view_bt">
						<ul>
                            <li><a href="#">Жагсаалт</a></li>
                            <li><a href="#">Өөрчлөх</a></li>
                            <li><a href="#">Устгах</a></li>
                            <li><a href="#">Бичсэн</a></li>
						</ul>
					</div>
				</section>
				<!-- //커뮤니티 텍스트형 -->

				<!-- 댓글 -->
        <section class="cont_box comment_con">
				  <h2>Сэтгэгдэл<span>999</span></h2>
				  <div class="comment_box cf">
					  <div class="cmt_write">
						  <div class="cmt_hd cf">
							  <ul>
                                  <li class="wr_name"><label>Нэр<input type="text" name="" id=""></label></li>
                                  <li class="wr_pw"><label>Нууц дугаар<input type="password" name="" id="" maxlength="16"></label></li>
                                  <li class="captcha_key"><label>Автомат бүртгэлээс сэргийлэх<input type="text" name="" id=""></label><span>777777</span></li>
								</ul>
							</div>
							<div class="input_box">
                                <div class="text-box"><textarea rows="3" placeholder="Сэтгэгдэл бичнэ үү."></textarea></div>
                                <button>Бүртгэх</button>
							</div>
						</div>
					</div>
				</section>
				<section class="reply_con cf">

				  <div class="reply_box depth depth1 cf">
					  <div class="rpy_icon"></div>
						<div class="rpy_cont cf">
							<div class="reply_hd cf">
								<ul>
                                    <li class="rpy_name">Бичсэн</li>
                                    <li class="rpy_date">2019-11-28 07:11</li>
                                </ul>
                            </div>
                            <div class="reply_txt cf">
                                Хариулт.
                            </div>
                            <div class="rpy_etc cf">
                                <span class="rpy_btn">Хариулт</span>
                                <span class="rpy_del">Устгах</span>
							</div>
            </div>
					</div>
					<div class="del_con">
						<span>Нууц дугаар : <input type="password" name="" id="" maxlength="16"></li>
                            <button>Утга оруулах</button>
						<button>Цуцлах</button>
                    </div>

                    <div class="reply_box depth depth2 cf">
                        <div class="rpy_icon">└</div>
                        <div class="rpy_cont cf">
                            <div class="reply_hd cf">
                                <ul>
                                    <li class="rpy_name">Бичсэн</li>
                                    <li class="rpy_date">2019-11-28 07:11</li>
                                </ul>
                            </div>
                            <div class="reply_txt cf">
                                Хариулт.
                            </div>
                            <div class="rpy_etc cf">
                                <span class="rpy_btn">Хариулт</span>
                                <span class="rpy_del">Устгах</span>
							</div>
            </div>
					</div>

				  <div class="reply_box depth depth3 cf">
					  <div class="rpy_icon">└</div>
						<div class="rpy_cont cf">
							<div class="reply_hd cf">
								<ul>
                                    <li class="rpy_name">Бичсэн</li>
                                    <li class="rpy_date">2019-11-28 07:11</li>
                                </ul>
                            </div>
                            <div class="reply_txt cf">
                                Хариулт.
                            </div>
                            <div class="rpy_etc cf">
                                <span class="rpy_btn">Хариулт</span>
                                <span class="rpy_del">Устгах</span>
							</div>
            </div>
					</div>

				</section>
				<!-- //댓글 -->

				<!-- 리스트 -->
			  <section class="cont_box list_con">
				  <div class="list_inner cf">
						<div class="lt_num">2365</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
                                    <div class="title"><a href="#">100% тэнцүүлэх ярилцлагын арга </a><span class="n_date">Бичсэн</span></div>								</div>
								</div>
							</li>
						</ul>
					</div>
				  <div class="list_inner cf">
						<div class="lt_num">2364</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
                                    <div class="title"><a href="#">100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга </a><span class="n_date">작성자</span></div>
								</div>
							</li>
						</ul>
					</div>
				  <div class="list_inner cf">
						<div class="lt_num">2363</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
                                    <div class="title"><a href="#">100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга </a><span class="n_date">작성자</span></div>
								</div>
							</li>
						</ul>
					</div>
				  <div class="list_inner cf">
						<div class="lt_num">2362</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
                                    <div class="title"><a href="#">100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга </a><span class="n_date">작성자</span></div>
								</div>
							</li>
						</ul>
					</div>
				  <div class="list_inner cf">
						<div class="lt_num">2361</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
                                    <div class="title"><a href="#">100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга  100% тэнцүүлэх ярилцлагын арга </a><span class="n_date">작성자</span></div>
								</div>
							</li>
						</ul>
					</div>

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
				<!-- //리스트 --> 

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