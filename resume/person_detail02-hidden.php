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
					<a href="person_main.php" class="active">인재정보</a>
					<a href="community_main.php">커뮤니티</a>
				</div>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

			  <section class="cont_box detail_con">
				  <h2 class="top_tit">오랫동안 일할 수 있는 재택알바 구합니다. 오랫동안 일할 수 있는 재택알바 구합니다.</h2>
          <div class="top_area">
            <ul>
							<li class="ktid"><span>카톡ID : <em>kakao-id</em></span></li>						  
							<li><span>통화가능시간 <em>18:00~00:00</em></span></li>
							<li class="btn_report"><a href="#"><img src="/images/icon_notify.gif" alt="신고하기">신고</a></li>
						</ul>
					</div>
					<div class="profile_con cf">
						<div class="pic_box">
							<a href="#"><img src="/images/id_pic.png" alt="증명사진"><!-- <img src="/images/id_pic2.png" alt="증명사진"> --></a>
						</div>
						<div class="txt_box cf">
							<ul class="indi-profile">
								<li><span><img src="/images/info1-1.png" alt="이름, 아이디"></span><em>비공개</em><a href="#">이력서 열람서비스 신청</a></li>
								<li><span><img src="/images/info1-3.png" alt="전화번호"></span><em>비공개</em><a href="#">이력서 열람서비스 신청</a></li>
								<li><span><img src="/images/info1-2.png" alt="휴대폰"></span><em>비공개</em><a href="#">이력서 열람서비스 신청</a></li>
								<li><span><img src="/images/info1-4.png" alt="이메일"></span><em>비공개</em><a href="#">이력서 열람서비스 신청</a></li>			
								<li class="address4"><span><img src="/images/info1-5.png" alt="주소"></span><em>비공개</em><a href="#">이력서 열람서비스 신청</a></li>								
							</ul>
						</div>

            <div class="service_info cf">
						  <div class="cf">
							  <div class="svc_info_bx">
							   	<!-- <img src="/images/icon/bg_resume1.gif"> -->
						      <p>기업회원으로 로그인 하신 후 이력서 열람서비스를 이용하시면 해당 인재의 연락처를 열람하실 수 있습니다.</p>
							    <div class="member_btn">
									  <div class="mb_login_bt"><a href="#">기업회원 로그인</a></div>
										<div class="mb_join_bt"><a href="#">기업회원 가입</a></div>
							    </div>
								</div>
							</div>
						</div>

						<div class="etc_box cf">
						  <ul>
							  <li><span>최종학력</span><p>대학(4년)졸업</p></li>
								<li><span>경력사항</span><p>없음</p></li>
								<li><span>희망급여</span><p>추후협의</p></li>
								<li><span>자격증</span><p>컴퓨터활용능력 1급</p></li>
								<li><span>외국어능력</span><p>영어<em>중</em> 외 1개국어</p></li>
							</ul>
						</div>
					</div>
					<div class="button_group scrap_bt">
					  <button type="button" class="bt-apply">입사지원요청</button>
					  <button type="button" class="bt-scrap"><img src="/images/scrap_icon2.png" alt="스크랩"><!--<img src="/images/scrap_icon1.png">-->스크랩</button>
					</div>
				</section>

				<section class="cont_box detail_con detail_con2">
				  <div class="tab2-con cf">
					  <ul>
						  <li><a href="#">이력서정보</a></li>
						  <li class="active"><a href="#">자격사항</a></li>
						  <li><a href="#">자기소개서</a></li>
            </ul>
					</div>
					<div class="tab-box tab2-box">

						<!-- 보유자격증 -->
					  <div class="resume_ct r_ct4 cf">
							<h3>보유자격증</h3>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:20%"><col style="width:40%"><col style="width:40%">
								</colgroup>
                <tr>
								  <th scope="row">취득일</th>
									<th scope="row">자격증명</th>
									<th scope="row">발행처</th>
								</tr>
                <tr>
								  <td>2018년</td>
									<td>컴퓨터활용능력2급</td>
									<td>대한상공회의소</td>
								</tr>
                <tr>
								  <td>2019년</td>
									<td>워드프로세서2급</td>
									<td>대한상공회의소</td>
								</tr>
                <tr>
								  <td>2020년</td>
									<td>컴퓨터활용능력1급</td>
									<td>대한상공회의소</td>
								</tr>
                <tr>
								  <td>2021년</td>
									<td>워드프로세서1급</td>
									<td>대한상공회의소</td>
								</tr>
							</table>
						</div>

						<!-- 외국어능력 -->
					  <div class="resume_ct r_ct5 cf">
							<h3>외국어능력</h3>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:30%"><col style="width:70%">
								</colgroup>
                <tr>
								  <th scope="row">외국어명</th>
									<th scope="row">구사능력/공인시험/어학연수</th>
								</tr>
                <tr>
								  <td>영어</td>
									<td>
									  <div><span class="txt_hd">구사능력</span> <em class="lv1">상</em><span>일상대화</span></div>
										<div><span class="txt_hd">공인시험</span><span>TOEIC</span> / <span>900점</span> / <span>2019년</span></div>
	                  <div><span class="txt_hd">어학연수</span> 6년 미만</div>
									</td>
								</tr>
                <tr>
								  <td>영어</td>
									<td>
									  <div><span class="txt_hd">구사능력</span> <em class="lv2">중</em><span>일상대화</span></div>
										<div><span class="txt_hd">공인시험</span><span>TOEIC</span> / <span>900점</span> / <span>2019년</span></div>
	                  <div><span class="txt_hd">어학연수</span> 6년 미만</div>
									</td>
								</tr>
                <tr>
								  <td>영어</td>
									<td>
									  <div><span class="txt_hd">구사능력</span> <em class="lv3">하</em><span>일상대화</span></div>
										<div><span class="txt_hd">공인시험</span><span>TOEIC</span> / <span>900점</span> / <span>2019년</span></div>
	                  <div><span class="txt_hd">어학연수</span> 6년 미만</div>
									</td>
								</tr>
							</table>
						</div>

            <!-- OA능력 및 특기사항 -->
					  <div class="resume_ct r_ct3 cf">
							<h3>OA능력 및 특기사항</h3>
							<table class="edu_tb2">
							  <colgroup>
								  <col style="width:26%"><col style="width:74%">
								</colgroup>
							  <tr>
								  <th scope="row">OA능력</th>
                  <td>
									  <div><span class="oa_item">한글/MS워드</span><em class="lv1">상</em> 표/도구 활용가능</div>
										<div><span class="oa_item">파워포인트</span><em class="lv2">중</em> 서식/도형 가능</div>
										<div><span class="oa_item">엑셀</span><em class="lv3">하</em> 수식/함수 활용가능</div>
										<div><span class="oa_item">인터넷</span><em class="lv1">상</em> 정보수집 능숙</div>
									</td>
								</tr>
							  <tr>
								  <th scope="row">컴퓨터능력</th>
                  <td>프로그래밍, 디자인, 컴퓨터활용능력, PC조립/설치</td>
								</tr>
							  <tr>
								  <th scope="row">특기사항</th>
                  <td>문서작성을 잘함, PC조립/설치에 능숙함, 숫자 계산이 빠름, 말솜씨가 좋음, 체력이 좋음, 목소리가 좋음, 인사성이 좋음</td>
								</tr>
								  <th scope="row">수상/수료</th>
                  <td>없음</td>
								</tr>
							</table>
            </div>

						<!-- 부가정보 -->
					  <div class="resume_ct r_ct6 cf">
							<h3>부가정보</h3>
							<table class="edu_tb3" style="width:100%">
							  <colgroup>
								  <col style="width:20%"><col style="width:20%"><col style="width:20%"><col style="width:40%">
								</colgroup>
                <tr>
								  <th scope="row">장애여부</th>
									<th scope="row">결혼여부</th>
									<th scope="row">병역여부</th>
									<th scope="row">채용우대</th>
								</tr>
                <tr>
								  <td>해당없음</td>
									<td>미혼</td>
									<td>군필</td>
									<td>고용지원금 대상자<br><span>(중증장애인)</span></td>
								</tr>
							</table>
						</div>

          </div>
					<div class="caution">
<p>본 정보는 취업활동을 위해 등록한 이력서 정보이며 정규직 구인구직 홈페이지 - 넷퓨는(은) 기재된 내
용에 대한 오류와 사용자가 신뢰하여 취한 조치에 대한 책임을 지지 않습니다. 누구든 본 정보를 정규직
구인구직 홈페이지 - 넷퓨의 동의없이 재배포할 수 없으며 본 정보를 출력 및 복사하더라도 채용목적 이
외의 용도로 사용할 수 없습니다. 본 정보를 출력 및 복사한 경우의 개인정보보호에 대한 책임은 출력 
및 복사한 당사자에게 있으며 정보통신부 고시 제2005-18호 (개인정보의 기술적·관리적 보호조치 기
준)에 따라 개인정보가 담긴 이력서 등을 불법유출 및 배포하게 되면 법에 따라 책임지게 됨을 양지하시
기 바랍니다. &lt;저작권자 ⓒ 정규직 구인구직 홈페이지 - 넷퓨. 무단전재-재배포 금지&gt;</p>
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