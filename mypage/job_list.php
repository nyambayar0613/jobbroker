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
		<li class="tab01 active"><a href="#">Үргэлжилж буй ажлын зар<span class="list_num">31</span></a></li>
		<li class="tab02"><a href="#">Хугацаа дууссан ажлын зар<span class="list_num">1</span></a></li>
	</ul>
	<ul class="list_con search_gp">
		<li class="sch_bt"><input type="radio" id="" name="search_slt" checked="checked"><label for="company">Байгууллага</label></li>
		<li class="sch_bt"><input type="radio" id="" name="search_slt"><label for="title">Зарын гарчиг</label></li>
		<li class="sch_bt"><input type="radio" id="" name="search_slt"><label for="manager">Хариуцсан хүний нэр</label></li>
		<li class="sch_bar"><input type="text" id="" name=""><button class="plus_bt plus_bt3">Хайх</button></li>
	</ul>
	<ul class="list_con">
		<li class="col2 none">
			<div class="list_txt2"><img src="images/info.png" alt="">Бүртгэлтэй мэдээлэл байхгүй байна.</div>
		</li>
	</ul>
	<ul class="list_con">
		<li class="col1"><input type="checkbox" id="" name=""></li>
		<li class="col2">
			<div class="list_txt">Онлайн худалдааны төвийн цагийн ажилд зуучлах Онлайн худалдааны төвийн цагийн ажил</div>
			<div class="list_etc"><span class="co_name">Financial View Co., Ltd.</span><span>Өргөдөл гаргагч : <i>0</i>хүн</span></div>
			<div class="list_etc"><span class="date">Бичсэн : 2019.11.15</span><span>Тогтмол элсэлт</span></div>
			<div class="list_etc"><span>Оффис / нягтлан бодох бүртгэл, оффисын туслах, баримт бичгийн байгууллага</span></div>
		</li>
		<li class="col3">
			<div class="list_btn list_btn1 list_btn1-1"><button type="button">Өөрчлөх</button></div>
			<div class="list_btn list_btn1 list_btn1-2"><button type="button">Хувилах</button></div>
			<div class="list_btn list_btn1 list_btn1-1"><button type="button">Устгах</button></div>
			<div class="list_btn list_btn1 list_btn1-2"><button type="button">Хугацаа дууссан</button></div>
			<div class="list_btn list_btn1 list_btn1-1"><button type="button">Дахин бүртгэл</button></div>
			<div class="list_btn list_btn1 list_btn1-2"><button type="button">Jump</button></div>
			<div class="list_btn list_btn2"><button type="button">Үйлчилгээний програм</button></div>
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
	<a href="#" class="bottom_btn03">Устгах</a>
</div>
<?php
include "../include/tail.php";
?>