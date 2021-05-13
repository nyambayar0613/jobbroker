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

			<div class="top_title">
        <a href="#"><img src="images/top_arrow.png" alt="이전"></a><h2>기업회원가입</h2>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

			  <section class="cont_box join_con">
					<ul class="info2_con">
						<li class="row1">
							<label for="member_id">아이디<span class="check"></span></label>
							<input type="text" id="member_id" name="">
							<button type="button" class="form_bt">중복확인</button>
						</li>
						<li class="row2">
							<label for="pw">비밀번호<span class="check"></span></label>
							<input type="password" id="pw" name="" maxlength="16">
						</li>
						<li class="row3">
							<label for="pw2">비번확인<span class="check"></span></label>
							<input type="password" id="pw2" name="" maxlength="16">
						</li>
						<li class="row4">
							<label for="name2">가입자명<span class="check"></span></label>
							<input type="text" id="name2" name="" maxlength="41">
						</li>
						<li class="row5">
							<label for="ceo">대표자명<span class="check"></span></label>
							<input type="text" id="" name="ceo" maxlength="41">
						</li>
						<li class="row6">
							<label for="nickname">닉네임<span class="check"></span></label>
							<input type="text" id="nickname" name="" maxlength="41">
							<button type="button" class="form_bt">중복확인</button>
						</li>
						<li class="row7">
							<label for="company">회사명<span class="check"></span></label>
							<input type="text" id="company" name="" maxlength="41">
						</li>
						<li class="row8">
							<label for="co_type">회사분류<span class="check"></span></label>
							<select id="co_type">
								<option>자영업</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row9">
							<label for="phone1">휴대폰</label>
							<select>
								<option>010</option>
								<option></option>
								<option></option>
							</select>
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone1" name="" class="phone1">
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone1" name="">
						</li>
						<li class="row10">
							<label for="phone2">전화번호<span class="check"></span></label>
							<select>
								<option>02</option>
								<option></option>
								<option></option>
							</select>
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="" class="phone2">
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="">
						</li>
						<li class="row11">
							<label for="address">주소<span class="check"></span></label>
							<input type="text" size="4" maxlength="4" id="address" name="" class="post">
							<input type="text" maxlength="" id="" name=""  class="address1">
							<button type="botton" class="form_bt form_bt2">우편번호</button>
							<div class="cf">
							 <input type="text" id="address" name="" class="address2" placeholder="상세주소를 입력하세요.">
							</div>
						</li>
						<li class="row12">
							<label>로고</label>
							<div class="logo_pic">
								<div class="logo_bx"><img src="images/no-img.png" alt="No Image"></div>
								<div class="bt_group">
								  <input type="file" id="" name="">
								  <p>gif, jpg, png 파일형식으로, 150×64픽셀 이하, 100kb이내의 파일만 등록 가능합니다.</p>
								</div>
							</div>
						</li>
						<li class="row13">
							<label class="biz_num">사업자번호</label>
							<input type="text" id="" name="">
							<p>-</p>
							<input type="text" id="" name="">
							<p>-</p>
							<input type="text" id="" name="">
						</li>
						<li class="row14">
							<label class="license_file">사업자등록증</label>
							<input type="file" id="" name="">
						</li>
						<li class="row15">
							<label for="phone2">팩스번호</label>
							<select>
								<option>02</option>
								<option></option>
								<option></option>
							</select>
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="" class="phone2">
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="">
						</li>
						<li class="row16">
							<label for="homepage">홈페이지</label>
							<span>http://</span><input type="text" name="" class="">
						</li>
						<li class="row17">
							<label for="email">이메일</label>
							<input type="text" id="email" name="" class="email">
							<p>@</p><input type="tel" id="email" name="" class="email">
							<select>
								<option>직접입력</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row18">
							<label for="listed">상장여부</label>
							<select id="listed">
								<option>상장여부 선택</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row19">
							<label for="co_type2">기업형태</label>
							<select id="co_type2">
								<option>기업형태 선택</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row20">
							<label for="business">주요사업</label>
							<input type="text" id="business" name="" maxlength="">
							<div>(예:네트워크 트래픽 관리제품 개발 및 판매)</div>
						</li>
						<li class="row21">
							<label for="year">설립년도</label>
							<select id="year">
								<option>기업형태 선택</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row22">
							<label for="employee">사원수</label>
							<input type="text" id="employee" name="" maxlength="">명
						</li>
						</li>
						<li class="row23">
							<label for="capital">자본금</label>
							<input type="text" id="capital" name="" maxlength="">원
						</li>
						<li class="row24">
							<label for="sales">매출액</label>
							<input type="text" id="sales" name="" maxlength="">원
						</li>
						<li class="row25">
							<label for="content">기업개요 및 비전</label>
							<textarea id="content" name="" rows="9"></textarea>
						</li>
						<li class="row26">
							<label for="content">기업연혁 및 실적</label>
							<textarea id="content" name="" rows="9"></textarea>
						</li>
					</ul>
        </section>

				<div class="button_con">
				  <a href="#" class="bottom_btn01">확인</a><a href="#" class="bottom_btn02">취소</a>
				</div>

			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>