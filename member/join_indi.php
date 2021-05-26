<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // Тус тусад нь хуудас руу нэвтрэх боломжгүй

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
        <a href="#"><img src="images/top_arrow.png" alt="이전"></a><h2> Хувь хүний бүртгэл</h2>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">
  		  <section class="cont_box join_con">
					  <ul class="info1_con">
							<li class="row1">
							  <label for="member_id">ID<span class="check"></span></label>
								<input type="text" id="member_id" name="" maxlength="41">
								<button type="button" class="form_bt">Баталгаажуулах</button>
							</li>
							<li class="row2">
							  <label for="name">Нэр<span class="check"></span></label>
								<input type="text" id="name" name="" maxlength="41">
						  </li>
							<li class="row3">
							  <label for="pw">Нууц үг<span class="check"></span></label>
								<input type="password" id="pw" name="" maxlength="16">
						  </li>
							<li class="row4">
							  <label for="pw2">Нууц үг дахин оруулна уу<span class="check"></span></label>
								<input type="password" id="pw2" name="" maxlength="16">
							</li>
              <li class="row5">
							  <fieldset>
									<legend>Хүйс<span class="check"></span></legend>
									<label for="male"><input type="radio" id="male">эрэгтэй</label>
									<label for="female"><input type="radio" id="female">эмэгтэй</label>
									<label for="no-gender"><input type="radio" id="no-gender"></label>
								</fieldset>
							</li>
							<li class="row6">
							  <fieldset>
									<legend>Төрсөн он сар<span class="check"></span></legend>
									<select>
										<option>Төрсөн он сар</option>
										<option></option>
										<option></option>
									</select>
									<p>-</p>
									<select>
										<option>сар</option>
										<option></option>
										<option></option>
									</select>
									<p>-</p>
									<select>
										<option>өдөр</option>
										<option></option>
										<option></option>
									</select>
								</fieldset>
							</li>
							<li class="row7">
							  <label for="nickname">хэрэглэгчийн нэр<span class="check"></span></label>
								<input type="text" id="nickname" name="" maxlength="41">
								<button type="button" class="form_bt">Баталгаажуулах</button>
							</li>
							<li class="row8" style="height:32px;line-height:32px">
								<fieldset>
									<legend>Холбогдох дугаар<span class="check"></span></legend>
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
									<legend>Утасны дугаар<span class="check"></span></legend>
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
									<legend>Хаяг<span class="check"></span></legend>
									<input type="text" size="4" maxlength="4" id="" name="" class="post">
									<input type="text" maxlength="" id="" name=""  class="address1">
									<button type="botton" class="form_bt form_bt2">Шуудангын дугаар</button>
									<div class="cf">
									 <input type="text" id="" name="" class="address2" placeholder="Хаягаа дэлгэрэнгүй оруулна уу.">
									</div>
								</fieldset>
							</li>
							<li class="row11">
								<fieldset>
									<legend>И-мэйл<span class="check"></span></legend>
									<input type="text" id="" name="" class="email">
									<p>@</p><input type="text" id="" name="" class="email">
									<select>
										<option>шууд утга оруулах</option>
										<option></option>
										<option></option>
									</select>
								</fieldset>
							</li>
						  <li class="row12">
								<label>Цээж зураг</label>
								<div class="member_photo">
									<img src="images/id_pic.png" alt="Зураг">
									<input type="file" id="" name="">
                  <p>gif, jpg, png файлын формат, зөвхөн 100 × 130 пиксел ба 100kb хэмжээтэй файлуудыг бүртгэх боломжтой.</p>
								</div>
								
							</li>
							<li class="row13">
							  <label for="homepage">Нүүр хуудас</label>
								<span>http://</span><input type="text" name="" class="">
              </li>
						</ul>
        </section>

				<div class="button_con">
				  <a href="#" class="bottom_btn01">Батлах</a><a href="#" class="bottom_btn02">Цуцлах</a>
				</div>

			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>