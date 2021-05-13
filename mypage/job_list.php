<?php
$page_code = 'mypage';
include_once "../include/top.php";
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
		<li class="tab01 active"><a href="#">진행중인 구인공고<span class="list_num">31</span></a></li>
		<li class="tab02"><a href="#">마감된 구인공고<span class="list_num">1</span></a></li>
	</ul>
	<ul class="list_con search_gp">
		<li class="sch_bt"><input type="radio" id="" name="search_slt" checked="checked"><label for="company">근무회사</label></li>
		<li class="sch_bt"><input type="radio" id="" name="search_slt"><label for="title">구인공고 제목</label></li>
		<li class="sch_bt"><input type="radio" id="" name="search_slt"><label for="manager">담당자명</label></li>
		<li class="sch_bar"><input type="text" id="" name=""><button class="plus_bt plus_bt3">검색</button></li>
	</ul>
	<ul class="list_con">
		<li class="col2 none">
			<div class="list_txt2"><img src="images/info.png" alt="">등록된 공고가 없습니다.</div>
		</li>
	</ul>
	<ul class="list_con">
		<li class="col1"><input type="checkbox" id="" name=""></li>
		<li class="col2">
			<div class="list_txt">온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집 온라인 쇼핑몰 아르바이트 모집</div>
			<div class="list_etc"><span class="co_name">(주)파이낸뷰</span><span>지원자 : <i>0</i>명</span></div>
			<div class="list_etc"><span class="date">작성일 : 2019.11.15</span><span>상시모집</span></div>
			<div class="list_etc"><span>사무·회계, 사무보조, 문서정리</span></div>
		</li>
		<li class="col3">
			<div class="list_btn list_btn1 list_btn1-1"><button type="button">수정</button></div>
			<div class="list_btn list_btn1 list_btn1-2"><button type="button">복사</button></div>
			<div class="list_btn list_btn1 list_btn1-1"><button type="button">삭제</button></div>
			<div class="list_btn list_btn1 list_btn1-2"><button type="button">마감</button></div>
			<div class="list_btn list_btn1 list_btn1-1"><button type="button">재등록</button></div>
			<div class="list_btn list_btn1 list_btn1-2"><button type="button">점프</button></div>
			<div class="list_btn list_btn2"><button type="button">서비스신청</button></div>
		</li>
	</ul>
	<ul class="list_con">
		<div class="paging pg2">
			<a href="#">1</a>
			<a href="#">2</a>
			<a href="#" class="active">3</a>
			<a href="#">4</a>
			<a href="#">5</a>
			<a href="#">6</a>
			<a href="#">7</a>
		</div>
	</ul>
</div>
</section>

<div class="button_con button_con3">
	<a href="#" class="bottom_btn03">삭제</a>
</div>
<?php
include "../include/tail.php";
?>