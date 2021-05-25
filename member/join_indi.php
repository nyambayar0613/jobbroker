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
        <a href="#"><img src="images/top_arrow.png" alt="이전"></a><h2>개인회원가입</h2>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">
  		  <section class="cont_box join_con">
					  <ul class="info1_con">
							<li class="row1">
							  <label for="member_id">아이디<span class="check"></span></label>
								<input type="text" id="member_id" name="" maxlength="41">
								<button type="button" class="form_bt">중복확인</button>
							</li>
							<li class="row2">
							  <label for="name">이름<span class="check"></span></label>
								<input type="text" id="name" name="" maxlength="41">
						  </li>
							<li class="row3">
							  <label for="pw">비밀번호<span class="check"></span></label>
								<input type="password" id="pw" name="" maxlength="16">
						  </li>
							<li class="row4">
							  <label for="pw2">비번확인<span class="check"></span></label>
								<input type="password" id="pw2" name="" maxlength="16">
							</li>
              <li class="row5">
							  <fieldset>
									<legend>성별<span class="check"></span></legend>
									<label for="male"><input type="radio" id="male">남자</label>
									<label for="female"><input type="radio" id="female">여자</label>
									<label for="no-gender"><input type="radio" id="no-gender">성별무관</label>
								</fieldset>
							</li>
							<li class="row6">
							  <fieldset>
									<legend>생년월일<span class="check"></span></legend>
									<select>
										<option>생일</option>
										<option></option>
										<option></option>
									</select>
									<p>-</p>
									<select>
										<option>월</option>
										<option></option>
										<option></option>
									</select>
									<p>-</p>
									<select>
										<option>일</option>
										<option></option>
										<option></option>
									</select>
								</fieldset>
							</li>
							<li class="row7">
							  <label for="nickname">닉네임<span class="check"></span></label>
								<input type="text" id="nickname" name="" maxlength="41">
								<button type="button" class="form_bt">중복확인</button>
							</li>
							<li class="row8" style="height:32px;line-height:32px">
								<fieldset>
									<legend>휴대폰<span class="check"></span></legend>
									<select>
										<option>010</option>
										<option></option>
										<option></option>
									</select>
									<p>-</p><input type="tel" size="4" maxlength="4" id="" name="" class="cel1 phone1">
									<p>-</p><input type="tel" size="4" maxlength="4" id="" name="" class="cel2 ">
								</fieldset>
							</li>
							<li class="row9" style="height:32px;line-height:32px">
								<fieldset>
									<legend>전화번호<span class="check"></span></legend>
										<select>
											<option>02</option>
											<option></option>
											<option></option>
										</select>
										<p>-</p><input type="tel" size="4" maxlength="4" id="" name="" class="tel1 phone2">
										<p>-</p><input type="tel" size="4" maxlength="4" id="" name="" class="tel2 ">
								</fieldset>
							</li>
							<li class="row10">
							  <fieldset>
									<legend>주소<span class="check"></span></legend>
									<input type="text" size="4" maxlength="4" id="" name="" class="post">
									<input type="text" maxlength="" id="" name=""  class="address1">
									<button type="botton" class="form_bt form_bt2">우편번호</button>
									<div class="cf">
									 <input type="text" id="" name="" class="address2" placeholder="상세주소를 입력하세요.">
									</div>
								</fieldset>
							</li>
							<li class="row11">
								<fieldset>
									<legend>이메일<span class="check"></span></legend>
									<input type="text" id="" name="" class="email">
									<p>@</p><input type="text" id="" name="" class="email">
									<select>
										<option>직접입력</option>
										<option></option>
										<option></option>
									</select>
								</fieldset>
							</li>
						  <li class="row12">
								<label>회원사진</label>
								<div class="member_photo">
									<img src="images/id_pic.png" alt="증명사진">
									<input type="file" id="" name="">
                  <p>gif, jpg, png 파일형식으로, 100×130픽셀, 100kb 용량 이내의 파일만 등록 가능합니다.</p>
								</div>
								
							</li>
							<li class="row13">
							  <label for="homepage">홈페이지</label>
								<span>http://</span><input type="text" name="" class="">
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