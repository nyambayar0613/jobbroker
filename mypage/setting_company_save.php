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
			<li class="tab01"><a href="#">맞춤 인재정보<span class="list_num">10</span></a></li>
			<li class="tab02 active"><a href="#">조건설정·수정<span class="list_num">10</span></a></li>
		</ul>
		<ul class="search_area">
			<li>
				<div class="match_tit">맞춤조건 선택</div>
				<div class="match" style="width:100%">
					<select>
					<option value="">선택해주세요</option>
					<?php
					$count = 1;
					while($row=sql_fetch_array($query)) {
					?>
					<option value="<?=$row['no'];?>">[<?=sprintf("%02d", $count);?>]<?=$row['wdate'];?> 저장</option>
					<?php
						$count++;
					}
					?>
					</select>
				</div>
				<p>선택하시고 저장하시면 선택하신 맞춤 조건이 수정됩니다.</p>
			</li>
			<li>
				<div class="search_con search_box search_co">
					<table class="search_tb co-tb">
						<!-- 검색유형1 -->
						<tr>
							<th class="sch_hd">
								<div>업직종</div>
							</th>
							<td class="sch_td1">
								<select>
									<option>업직종1차</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td2">
								<select>
									<option>업직종2차</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td3">
								<select>
									<option>업직종3차</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
						</tr>
						<!-- 검색유형2 -->
						<tr>
							<th class="sch_hd">
								<div>근무지</div>
							</th>
							<td class="sch_td1">
								<select>
									<option>시·도</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td2">
								<select>
									<option>시·군·구</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td3">
								<input type="checkbox" id="homejob" name=""><label for="homejob">재택근무</label>
							</td>
						</tr>
						<!-- 검색유형3 -->
						<tr>
							<th class="sch_hd">
								<div>근무일시</div>
							</th>
							<td class="sch_td1">
								<select>
									<option>근무기간</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td2">
								<select>
									<option>근무요일</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td3">
								<select>
									<option>근무시간</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
						</tr>
						<tr>
						  <td colspan="4" class="go_work"><input type="checkbox" id="" name="">즉시출근가능</td>
						</tr>
						<!-- 검색유형4 -->
						<tr>
							<th class="sch_hd">
								<div>성별선택</div>
							</th>
							<td class="sch_td2" colspan="3">
								<fieldset>
									<legend>성별선택</legend>
									<label for="male"><input type="radio" id="male" name="gender" checked="checked">남자</label>
									<label for="female"><input type="radio" id="female" name="gender">여자</label>
									<label for="no-gender"><input type="radio" id="no-gender" name="gender">성별무관</label>
								</fieldset>
							</td>
						</tr>
						<!-- 검색유형5 -->
						<tr>
							<th class="sch_hd">
								<div>나이선택</div>
							</th>
							<td class="sch_td1">
								<select>
									<option>나이</option>
									<option></option>
									<option></option>
									<option></option>
								</select>
							</td>
							<td class="sch_td2" colspan="2">
							  <fieldset>
									<legend>나이선택</legend>
									<input type="checkbox" id="under">이하
									<input type="checkbox" id="over">이상
									<input type="checkbox" id="unrelated">무관
								</fieldset>
							</td>
						</tr>
						<!-- 검색유형6 -->
						<tr>
							<th class="sch_hd">
								<div>근무형태</div>
							</th>
							<td class="sch_td1" colspan="3">
								<select>
									<option>정규직</option>
									<option>계약직</option>
									<option>파젼직</option>
									<option>인턴직</option>
									<option>위촉직</option>
									<option>아르바이트</option>
								</select>
							</td>
						</tr>
						<!-- 검색유형7 -->
						<tr>
							<th class="sch_hd">
								<div>메일링</div>
							</th>
							<td class="sch_td2" colspan="4">
								<label for="mailing" class="tb_chk1"><input type="checkbox" id="mailing" checked="checked">이메일수신</label>
								<label for="sms" class="tb_chk2"><input type="checkbox" id="sms">SMS수신</label>
							</td>
						</tr>
					</table>
				</div>
			</li>
		</ul>
	</div>
</section>

<div class="button_con">
	<a href="#" class="bottom_btn01">저장</a><a href="#" class="bottom_btn02">초기화</a>
</div>

<?php
include "../include/tail.php";
?>