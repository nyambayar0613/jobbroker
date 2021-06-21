<?php
$page_code = 'mypage';
include_once "../include/top.php";

$query = sql_query("select * from `alice_resume_search` where `wr_id` = '".$member['mb_id']."' order by `no` desc");
?>

<section class="cont_box detail_con">
<?php
include NFE_PATH.'/include/inc/my_company_info.inc.php';

include NFE_PATH.'/include/inc/my_company_count.inc.php';
?>
</section>

<section class="cont_box resume_list">
	<div class="resume_list_con cf">
		<ul class="list-tab">
			<li class="tab01"><a href="#">Санал болгох хүний нөөц<span class="list_num">10</span></a></li>
			<li class="tab02 active"><a href="#">Өөрчлөх·Засах<span class="list_num">10</span></a></li>
		</ul>
		<ul class="search_area">
			<li>
				<div class="match_tit">Нөхцөл сонгоно уу</div>
				<div class="match" style="width:100%">
					<select>
					<option value="">Сонгоно уу</option>
					<?php
					$count = 1;
					while($row=sql_fetch_array($query)) {
					?>
					<option value="<?=$row['no'];?>">[<?=sprintf("%02d", $count);?>]<?=$row['wdate'];?> Хадгалах</option>
					<?php
						$count++;
					}
					?>
					</select>
				</div>
                <p>Хэрэв та сонгоод хадгалвал сонгосон утгыг өөрчлөх боломжтой.</p>
			</li>
			<li>
				<div class="search_con search_box search_co">
					<table class="search_tb co-tb">
						<!-- 검색유형1 -->
						<tr>
							<th class="sch_hd">
								<div>Ажлын төрөл</div>
							</th>
							<td class="sch_td1">
								<select>
									<option>Ажлын төрөл 1</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td2">
								<select>
									<option>Ажлын төрөл 2</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td3">
								<select>
									<option>Ажлын төрөл 3</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
						</tr>
						<!-- 검색유형2 -->
						<tr>
							<th class="sch_hd">
								<div>Ажлын байршил</div>
							</th>
							<td class="sch_td1">
								<select>
									<option>хот·дүүрэг</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td2">
								<select>
									<option>хороо·тоот·гудамж</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td3">
								<input type="checkbox" id="homejob" name=""><label for="homejob">Гэрээсээ ажиллах</label>
							</td>
						</tr>
						<!-- 검색유형3 -->
						<tr>
							<th class="sch_hd">
								<div>Ажиллах хугацаа</div>
							</th>
							<td class="sch_td1">
								<select>
									<option>Ажиллах хугацаа</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td2">
								<select>
									<option>Ажлын өдөр</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td3">
								<select>
									<option>Ажлын өдөр</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
						</tr>
						<tr>
						  <td colspan="4" class="go_work"><input type="checkbox" id="" name="">Яаралтай ажил хийх боломжтой</td>
						</tr>
						<!-- 검색유형4 -->
						<tr>
							<th class="sch_hd">
								<div>Хүйс сонгох</div>
							</th>
							<td class="sch_td2" colspan="3">
								<fieldset>
									<legend>Хүйс сонгох</legend>
									<label for="male"><input type="radio" id="male" name="gender" checked="checked">Эр</label>
									<label for="female"><input type="radio" id="female" name="gender">Эм</label>
									<label for="no-gender"><input type="radio" id="no-gender" name="gender">Хүйс хамааралгүй</label>
								</fieldset>
							</td>
						</tr>
						<!-- 검색유형5 -->
						<tr>
							<th class="sch_hd">
								<div>Нас сонгох</div>
							</th>
							<td class="sch_td1">
								<select>
									<option>нас</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td2" colspan="2">
							  <fieldset>
									<legend>Нас сонгох</legend>
									<input type="checkbox" id="under">Дээш
									<input type="checkbox" id="over">Доош
									<input type="checkbox" id="unrelated">Хамааралгүй
								</fieldset>
							</td>
						</tr>
						<!-- 검색유형6 -->
						<tr>
							<th class="sch_hd">
								<div>Ажлын төрөл</div>
							</th>
							<td class="sch_td1" colspan="3">
								<select>
									<option>Бүтэн цаг</option>
									<option>Гэрээт</option>
									<option>Хагас цаг</option>
									<option>Дадлага</option>
									<option>Түр хугацааны</option>
									<option>Цагын ажил</option>
								</select>
							</td>
						</tr>
						<!-- 검색유형7 -->
						<tr>
							<th class="sch_hd">
								<div>Mailling</div>
							</th>
							<td class="sch_td2" colspan="4">
								<label for="mailing" class="tb_chk1"><input type="checkbox" id="mailing" checked="checked">И-мэйл хүлээн авах</label>
								<label for="sms" class="tb_chk2"><input type="checkbox" id="sms">SMS хүлээн авах</label>
							</td>
						</tr>
					</table>
				</div>
			</li>
		</ul>
	</div>
</section>

<div class="button_con">
	<a href="#" class="bottom_btn01">Хадгалах</a><a href="#" class="bottom_btn02">Эхлэл</a>
</div>

<?php
include "../include/tail.php";
?>