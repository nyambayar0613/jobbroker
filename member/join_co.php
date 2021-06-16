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
        <a href="#"><img src="images/top_arrow.png" alt="Өмнөх"></a><h2>Байгууллагын бүртгэл</h2>
			</div>
		</header>
		<div id="main" class="cf">
			<div class="container">

			  <section class="cont_box join_con">
					<ul class="info2_con">
						<li class="row1">
							<label for="member_id">ID<span class="check"></span></label>
							<input type="text" id="member_id" name="">
							<button type="button" class="form_bt">Шалгах</button>
						</li>
						<li class="row2">
							<label for="pw">Нууц үг<span class="check"></span></label>
							<input type="password" id="pw" name="" maxlength="16">
						</li>
						<li class="row3">
							<label for="pw2">Нууц үг дахин оруулна уу<span class="check"></span></label>
							<input type="password" id="pw2" name="" maxlength="16">
						</li>
						<li class="row4">
							<label for="name2">Элсэх нэр<span class="check"></span></label>
							<input type="text" id="name2" name="" maxlength="41">
						</li>
						<li class="row5">
							<label for="ceo">Хариуцагчын нэр<span class="check"></span></label>
							<input type="text" id="" name="ceo" maxlength="41">
						</li>
						<li class="row6">
							<label for="nickname">Нэр<span class="check"></span></label>
							<input type="text" id="nickname" name="" maxlength="41">
							<button type="button" class="form_bt">Баталгаажуулах</button>
						</li>
						<li class="row7">
							<label for="company"><span class="check"></span></label>
							<label for="company">Байгууллагын нэр<span class="check"></span></label>
							<input type="text" id="company" name="" maxlength="41">
						</li>
						<li class="row8">
							<label for="co_type">Байгууллагын төрөл<span class="check"></span></label>
							<select id="co_type">
								<option>Хувийн</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row9">
							<label for="phone1">Утасны дугаар</label>
							<select>
								<option>010</option>
								<option></option>
								<option></option>
							</select>
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone1" name="" class="phone1">
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone1" name="">
						</li>
						<li class="row10">
							<label for="phone2">Холбогдох дугаар<span class="check"></span></label>
							<select>
								<option>02</option>
								<option></option>
								<option></option>
							</select>
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="" class="phone2">
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="">
						</li>
						<li class="row11">
							<label for="address">Хаяг<span class="check"></span></label>
							<input type="text" size="4" maxlength="4" id="address" name="" class="post">
							<input type="text" maxlength="" id="" name=""  class="address1">
							<button type="botton" class="form_bt form_bt2">Шуудангын дугаар</button>
							<div class="cf">
							 <input type="text" id="address" name="" class="address2" placeholder="상세주소를 입력하세요.">
							</div>
						</li>
						<li class="row12">
							<label>Log</label>
							<div class="logo_pic">
								<div class="logo_bx"><img src="images/no-img.png" alt="No Image"></div>
								<div class="bt_group">
								  <input type="file" id="" name="">
								  <p>gif, jpg, png форматаар, 150×64пиксэлээс дээш, 100kb-ийн файл л оруулах боломжтой.</p>
								</div>
							</div>
						</li>
						<li class="row13">
							<label class="biz_num">Бизнес эрхлэгчийн дугаар</label>
							<input type="text" id="" name="">
							<p>-</p>
							<input type="text" id="" name="">
							<p>-</p>
							<input type="text" id="" name="">
						</li>
						<li class="row14">
							<label class="license_file">Бизнес эрхлэгчийн үнэмлэх</label>
							<input type="file" id="" name="">
						</li>
						<li class="row15">
							<label for="phone2">Факс</label>
							<select>
								<option>02</option>
								<option></option>
								<option></option>
							</select>
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="" class="phone2">
							<p>-</p><input type="tel" size="4" maxlength="4" id="phone2" name="">
						</li>
						<li class="row16">
							<label for="homepage">Нүүр хуудас</label>
							<span>http://</span><input type="text" name="" class="">
						</li>
						<li class="row17">
							<label for="email">и-мэйл</label>
							<input type="text" id="email" name="" class="email">
							<p>@</p><input type="tel" id="email" name="" class="email">
							<select>
								<option>шууд сануулах</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row18">
							<label for="listed">Хариуцагчын статус</label>
							<select id="listed">
								<option>Хариуцагчын статус сонгох</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row19">
							<label for="co_type2">Байгууллагын статус</label>
							<select id="co_type2">
								<option>Байгууллагын статус сонгох</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row20">
							<label for="business">Хийдэг гол ажилууд</label>
							<input type="text" id="business" name="" maxlength="">
							<div>(Жишээ: Сүлжээний менежментийн бүтээгдэхүүн боловсруулах, борлуулах)</div>
						</li>
						<li class="row21">
							<label for="year">Байгуулагдсан он</label>
							<select id="year">
								<option>Байгууллагын статус</option>
								<option></option>
								<option></option>
							</select>
						</li>
						<li class="row22">
							<label for="employee">Ажилчдын тоо</label>
							<input type="text" id="employee" name="" maxlength="">хүн
						</li>
						</li>
						<li class="row23">
							<label for="capital">Үндсэн хөрөнгө</label>
							<input type="text" id="capital" name="" maxlength="">төгрөг
						</li>
						<li class="row24">
							<label for="sales">Байгууллагын ашиг</label>
							<input type="text" id="sales" name="" maxlength="">төгрөг
						</li>
						<li class="row25">
							<label for="content">Байгууллагын тухай болон хураангй\</label>
							<textarea id="content" name="" rows="9"></textarea>
						</li>
						<li class="row26">
							<label for="content">Компанийн түүх, гүйцэтгэл</label>
							<textarea id="content" name="" rows="9"></textarea>
						</li>
					</ul>
        </section>

				<div class="button_con">
				  <a href="#" class="bottom_btn01">OK</a><a href="#" class="bottom_btn02">Цуцлах</a>
				</div>

			</div>
		</div>

<?php
include_once(NFE_PATH.'/tail.php');
?>