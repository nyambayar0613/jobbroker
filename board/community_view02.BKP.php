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
					<a href="recruit_main.php">구인정보</a>
					<a href="person_main.php">인재정보</a>
					<a href="community_main.php" class="active">커뮤니티</a>
				</div>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

				<!-- 커뮤니티 이미지형 -->
			  <section class="cont_box community_txt">
          <h2><span class="tit_ico"><img src="/images/title_icon03.png" alt=""></span>사진이야기</h2>
          <div class="community_inner cf">
						<div class="view_wrap">
						  <div class="view_top cf">
								<div class="view_title"><a href="#">자연풍경</a></div>
								<div class="view_info">
									<span class="mb_id"><strong>넷퓨알바</strong></span>
									<span>2019.11.08&nbsp;&nbsp;12:11</span>
									<span class="hits">조회수 : <em>14</em></span>
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
							<li><a href="#">목록</a></li>
							<li><a href="#">수정</a></li>
							<li><a href="#">삭제</a></li>
							<li><a href="#">글작성</a></li>
						</ul>
					</div>
				</section>
				<!-- //커뮤니티 텍스트형 -->

				<!-- 댓글 -->
        <section class="cont_box comment_con">
				  <h2>댓글<span>999</span></h2>
				  <div class="comment_box cf">
					  <div class="cmt_write">
						  <div class="cmt_hd cf">
							  <ul>
								  <li class="wr_name"><label>이름<input type="text" name="" id=""></label></li>
									<li class="wr_pw"><label>비밀번호<input type="password" name="" id="" maxlength="16"></label></li>
									<li class="captcha_key"><label>자동등록방지문자<input type="text" name="" id=""></label><span>777777</span></li>
								</ul>
							</div>
							<div class="input_box">
							  <div class="text-box"><textarea rows="3" placeholder="댓글을 입력하세요."></textarea></div>
								<button>등록</button>
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
									<li class="rpy_name">작성자</li>
									<li class="rpy_date">2019-11-28 07:11</li>
								</ul>
							</div>
							<div class="reply_txt cf">	
								답글내용입니다.
							</div>
							<div class="rpy_etc cf">
								<span class="rpy_btn">답글</span>
								<span class="rpy_del">삭제</span>
							</div>
            </div>
					</div>
					<div class="del_con">
						<span>비밀번호 : <input type="password" name="" id="" maxlength="16"></li>
						<button>입력</button>
						<button>취소</button>
					</div>

				  <div class="reply_box depth depth2 cf">
					  <div class="rpy_icon">└</div>
						<div class="rpy_cont cf">
							<div class="reply_hd cf">
								<ul>
									<li class="rpy_name">작성자</li>
									<li class="rpy_date">2019-11-28 07:11</li>
								</ul>
							</div>
							<div class="reply_txt cf">	
								답글내용입니다.
							</div>
							<div class="rpy_etc cf">
								<span class="rpy_btn">답글</span>
								<span class="rpy_del">삭제</span>
							</div>
            </div>
					</div>

				  <div class="reply_box depth depth3 cf">
					  <div class="rpy_icon">└</div>
						<div class="rpy_cont cf">
							<div class="reply_hd cf">
								<ul>
									<li class="rpy_name">작성자</li>
									<li class="rpy_date">2019-11-28 07:11</li>
								</ul>
							</div>
							<div class="reply_txt cf">	
								답글내용입니다.
							</div>
							<div class="rpy_etc cf">
								<span class="rpy_btn">답글</span>
								<span class="rpy_del">삭제</span>
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
									<div class="title"><a href="#">100%합격하는 면접법 </a><span class="n_date">작성자</span></div>
								</div>
							</li>
						</ul>
					</div>
				  <div class="list_inner cf">
						<div class="lt_num">2364</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
									<div class="title"><a href="#">100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법</a><span class="n_date">작성자</span></div>
								</div>
							</li>
						</ul>
					</div>
				  <div class="list_inner cf">
						<div class="lt_num">2363</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
									<div class="title"><a href="#">100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법</a><span class="n_date">작성자</span></div>
								</div>
							</li>
						</ul>
					</div>
				  <div class="list_inner cf">
						<div class="lt_num">2362</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
									<div class="title"><a href="#">100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법</a><span class="n_date">작성자</span></div>
								</div>
							</li>
						</ul>
					</div>
				  <div class="list_inner cf">
						<div class="lt_num">2361</div>
						<ul class="cont_box_inner">
							<li>
								<div class="text_box">
									<div class="title"><a href="#">100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법 100%합격하는 면접법</a><span class="n_date">작성자</span></div>
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
								<div class="title"><a href="#">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집</a><span class="n_date">2019.10.16</span></div>
							</div>
						</li>
					</ul>
				</section>

			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>