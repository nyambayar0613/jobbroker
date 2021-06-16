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
			  <section class="cont_box notice_txt">
                  <h2><span class="tit_ico"><img src="/images/title_icon02.png" alt=""></span>Ажлын нөу хау<span class="bt_box"><a href="#" class="write_bt">Бичих</a></span></h2>
                  <div class="community_inner cf">
                      <div class="view_wrap">
                          <div class="view_top cf">
                              <div class="view_title"><a href="#">Coffeeshop-т цагийн ажил хийх тухай ~ </a></div>
                              <div class="view_info">
                                  <span class="mb_id"><strong>Netfu цагын ажил</strong></span>
                                  <span>2019.11.08&nbsp;&nbsp;12:11</span>
                                  <span class="hits">Үзсэн тоо : <em>14</em></span>
								</div>
							</div>
							<div class="view_con cf">
							  <p>
다음글은 "휴먼피아..rkdgudans님"의 글을 담아온것을 미리 밝힙니다.<br>
1.면접전 대비 사항(이력서포함)</br>
1)그회사의 이력 및 현 이슈사항등에 대해 알아야합니다.(이건당근하시겠죠?)<br>
2)내가 제출한 이력서상의 내용들에대해 안보고 말할 수 있을정도가 되야한다...<br>
3)이력서 작성시 나의 장점만을 나열하지 말자! 모든 면접자들은 자기가 뭐를잘하고 무슨상을 받았고....주절주절씁니다. 그러지 마시고 잘하는점과 못하는점또는실패담을 쓰세요....<br>
4)입사지원시 희망부서를 쓰게되어있습니다. 절대로 절대로 붙기위한 부서를 쓰지마십시요. 영업하기도 싫으면서 영업관리 써서 붙으면 모합니까? 들어가서 생활하다보면 정말 다른부서 직원보다 비참해서 못다니거나, 적성에 안맞아서 못다니는 경우가 허다합니다. </br>
그리고, 결코 입사후 부서옮기기는 하늘의 별다기 만큼 힘들다는 것도 알아두세요... 절대 부서 못봐꾼다고 생각하시고 안되도 좋으니 희망부서를 쓰셔야 합니다. 당근...
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