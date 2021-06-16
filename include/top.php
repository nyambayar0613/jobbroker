<?php
$alice_path = $_SERVER['DOCUMENT_ROOT'].'/';
$cat_path = $_SERVER['DOCUMENT_ROOT'].'/';
include_once $alice_path.'conn.php';

if($page_code=='mypage') {
	$netfu_member->login_check($member_type);
}

if($is_popup) // 팝업 
	$popup_control->get_PopList($page_name);
?>
<script>
<?php if($is_popup){?>
var popup_Close = function(no){	// 팝업창 닫기
	var popupToday = $('#popupClose_' + no).is(':checked');	 // 하루동안 열지 않기 체크 유무
	if(popupToday==true)	// 체크 했다면
		$.cookie('popupClose_'+no, popupToday, { expires:1, domain:domain, path:'/', secure:0});	// 쿠키 저장
	$('#popup_' + no).hide();
}
<?php } ?>
</script>

<style>
.cheditor-tb-fullscreen { display:none; }
.fade_image { display:inline-block !important; margin:0 auto; text-align:center; }
.slide_image { /*display:inline-block;*/ margin:0 auto; }

.cycle-slideshow > div { 
    width: 100%; padding: 0;
}
</style>

<link rel="stylesheet" type="text/css" href="<?=NFE_URL;?>/plugin/jquery/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="<?=NFE_URL;?>/plugin/jquery/slick/slick-theme.css" />
<script type="text/javascript" src="<?=NFE_URL;?>/plugin/jquery/slick/slick.js"></script>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.js"></script>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.swipe.js"></script>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.carousel.js"></script>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.center.js"></script>
<script src="<?=NFE_URL;?>/plugin/jquery/cycle2/jquery.cycle2.scrollVert.js"></script>

<script type="text/javascript">
var nav_left_view = "none";
var all_menu = function() {
	nav_left_view = nav_left_view=='none' ? 'block' : 'none';
	$(".nav_left_view").css("display", nav_left_view);
}

var nav_right_view = function() {
	<?php
		if(!$member['mb_id']) {
	?>
		alert("로그인을 해야 이용가능합니다.");
		location.href = base_url+'/include/login.php';
	<?php
		} else {
	?>
		var display = $(".right_nav_body").css("display")=='none' ? 'block' : 'none';
	$(".right_nav_body").css({"display":display});
	<?php
	}?>
}
</script>
<body>
    <!-- Loader -->
<!--    <div id="preloader">-->
<!--        <div id="status">-->
<!--            <div class="spinner">-->
<!--                <div class="double-bounce1"></div>-->
<!--                <div class="double-bounce2"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- Loader -->
<!--<div id="wrap" class="<?/*=$netfu_util->mobile_is ? 'mobile_wrap' : '';*/?> layout_default">-->

	<!-- TOP배너 -->
	<?php
/*	$all_top = $banner_control->get_banner_for_position('all_top');
	$logo_img = $design_control->view_logo($logo['top']);

	if($all_top) { */?><!--
	<div class="top_banner">
		<?php /*echo $all_top; */?>
	</div>
	--><?php /*} */?>

	<!--<header id="top" class="cf">-->
    <header id="topnav" class="defaultscroll scroll-active">

        <!-- Tagline STart -->
        <div class="tagline">
            <div class="container">
                <div class="float-left">
                    <div class="phone">
                        <i class="mdi mdi-phone-classic"></i> +1 800 123 45 67
                    </div>
                    <div class="email">
                        <a href="#">
                            <i class="mdi mdi-email"></i> Support@mail.com
                        </a>
                    </div>
                </div>
                <div class="float-right">
                    <ul class="topbar-list list-unstyled d-flex" style="margin: 11px 0px;">
                        <li class="list-inline-item"><a href="javascript:void(0);"><i class="mdi mdi-account mr-2"></i>Benny Simpson</a></li>

                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Tagline End -->

        <!-- Menu Start -->
        <div class="container">
            <!-- Logo container-->
            <div>
                <a href="index.html" class="logo">
                    <img src="/images/logo-light.png" alt="" class="logo-light" height="18" />
                    <img src="/images/logo-dark.png" alt="" class="logo-dark" height="18" />
                </a>
            </div>
            <div class="buy-button">
                <a href="post-a-job.html" class="btn btn-primary"><i class="mdi mdi-cloud-upload"></i> Post a Job</a>
            </div><!--end login button-->
            <!-- End Logo container-->
            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li><a href="index.html">Home</a></li>
                    <li class="has-submenu">
                        <a href="javascript:void(0)">Jobs</a><span class="menu-arrow"></span>
                        <ul class="submenu">
                            <li><a href="job-list.html">Job List</a></li>
                            <li><a href="job-grid.html">Job Grid</a></li>
                            <li><a href="job-details.html">Job Details</a></li>
                            <li><a href="job-details-2.html">Job Details-2</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="javascript:void(0)">Pages</a><span class="menu-arrow"></span>
                        <ul class="submenu">
                            <li><a href="about.html">About us</a></li>
                            <li><a href="services.html">Services</a></li>
                            <li><a href="team.html">Team</a></li>
                            <li><a href="faq.html">Faqs</a></li>
                            <li><a href="pricing.html">Pricing plans</a></li>
                            <li class="has-submenu"><a href="javascript:void(0)"> Candidates</a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="candidates-listing.html">Candidates Listing</a></li>
                                    <li><a href="candidates-profile.html">Candidates Profile</a></li>
                                    <li><a href="create-resume.html">Create Resume</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu"><a href="javascript:void(0)"> Blog</a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="blog-grid.html">Blogs</a></li>
                                    <li><a href="blog-sidebar.html">Blog Sidebar</a></li>
                                    <li><a href="blog-details.html">Blog Details</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu"><a href="javascript:void(0)"> Employers</a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="employers-list.html">Employers List</a></li>
                                    <li><a href="company-detail.html">Company Detail</a></li>
                                </ul>
                            </li>
                            <li class="has-submenu"><a href="javascript:void(0)"> User Pages</a><span class="submenu-arrow"></span>
                                <ul class="submenu">
                                    <li><a href="login.html">Login</a></li>
                                    <li><a href="signup.html">Signup</a></li>
                                    <li><a href="recovery_passward.html">Forgot Password</a></li>
                                </ul>
                            </li>
                            <li><a href="components.html"> Components</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="contact.html">contact</a>
                    </li>
                </ul><!--end navigation menu-->
            </div><!--end navigation-->
        </div><!--end container-->
        <!--end end-->

		<!--<div class="head_top gradient_img" style="height:auto">
			<div class="allmenu" style="top:50%;margin-top:-15px"><button type="button" onClick="all_menu()"><img src="<?/*=NFE_URL;*/?>/images/allmenu_icon<?/*=$icon_img;*/?>.png" width="25" alt="전체메뉴"></button></div>
			<h1 class="logo" style="height:auto"><a href="<?/*=NFE_URL;*/?>/"><?/*=$logo_img;*/?></a></h1>
			<div class="mypage" style="top:50%;margin-top:-13px">
			<?php /*if($member['mb_id']) { */?>
			<button type="button" onClick="nav_right_view()"><img src="<?/*=NFE_URL;*/?>/images/mypage_icon<?/*=$icon_img;*/?>.png" width="33" alt="마이페이지"></button>
			<?php /*}else{ */?>
			<a href="/etc/adver.php" class="ad-ico"><img src="<?/*=NFE_URL;*/?>/images/ad_icon<?/*=$icon_img;*/?>.png" width="" alt="광고안내"></a>
			<?php /*} */?>
			</div>
		</div>-->
		<!--<form name="ftop_search" action="<?/*=NFE_URL;*/?>/main/search.php" style="float:none;width:auto">
		<div class="search_bar">
			<button type="button" class="search_btn" onClick="document.forms['ftop_search'].submit()"><img src="<?/*=NFE_URL;*/?>/images/search_btn.png" alt="검색"></button>
			<input type="text" name="top_keyword" value="<?/*=$_GET['top_keyword'];*/?>">
		</div>
		</form>-->
		<!--<div class="quick_bnr cf">-->

			<!-- 우측 배너 -->
			<!--<div id="quickBanner1" class="qbnr_right" style="top:0">
				<div class="quick_wrap">
					<?php
/*					echo $banner_control->get_banner_for_position('all_right_scroll');
					*/?>
				</div>
			</div>-->


			<!-- 좌측 배너 -->
			<!--<div id="quickBanner2" class="qbnr_left" style="top:0">
				<div class="quick_wrap">
					<?php
/*					echo $banner_control->get_banner_for_position('all_left_scroll');
					*/?>
				</div>
			</div>-->

		<!--</div>-->

<!--<script type="text/javascript">
$(function(){
if( $('.top_banner01').length ){
	$('#quickBanner1').css( { 'top' : 393 + $('.top_banner01').height() } );
}
$( '#quickBanner1' ).scrollFollow();

if( $('.top_banner01').length ){
	$('#quickBanner2').css( { 'top' : 393 + $('.top_banner01').height() } );
}
$( '#quickBanner2' ).scrollFollow();
});
</script>-->

<?php
// : 좌측 사이트맵
include NFE_PATH."/include/nav_left.php";

// : 우측 사이트맵
include NFE_PATH.'/include/nav_right.php';

// : 내사진 수정
include NFE_PATH.'/include/inc/photo_write.inc.php';

// : 로고등록폼 - 로그인해야지만 나옴.
include NFE_PATH.'/include/inc/logo_write.inc.php';


// : 성인인증
include NFE_PATH.'/member/adult.php';

$menu_is = true;
if(!$menu_code) {
	if(strpos($_SERVER['PHP_SELF'], 'login.php')!==false) $menu_is = false;
	$menu_code = 'basic';

	if(strpos($_SERVER['PHP_SELF'], 'location.php')!==false) $menu_code = 'location';

	if(strpos($_SERVER['PHP_SELF'], "/mypage/")!==false && $member['mb_type']=='individual') $menu_code = 'individual1';

	if(strpos($_SERVER['PHP_SELF'], "/mypage/")!==false && $member['mb_type']=='company') $menu_code = 'company1';

	if(strpos($_SERVER['PHP_SELF'], 'text.php')!==false || $menu_text) $menu_code = 'text';
}

if($menu_is) {
	switch($menu_code) {
		case "basic":
?>
<!--<div class="lnb">
	<?php
/*	include NFE_PATH.'/include/inc/menu.inc.php';

	// : 구인정보 서브메뉴
	if(strpos($_SERVER['PHP_SELF'], "/job/")!==false) include NFE_PATH.'/include/inc/job_submenu.inc.php';

	// : 인재정보 서브메뉴
	if(strpos($_SERVER['PHP_SELF'], "/resume/")!==false) include NFE_PATH.'/include/inc/resume_submenu.inc.php';
	*/?>
</div>-->
<?php
			break;


		case "text":
			if(!$menu_text) $menu_text = $netfu_util->site_content[$_GET['code']];
			if($not_menu_text) break;
?>
<!--<div class="top_title">
	<a href="<?/*=NFE_URL;*/?>/"><img src="<?/*=NFE_URL;*/?>/images/top_arrow.png" alt="이전"></a><h2><?/*=$menu_text;*/?></h2>
</div>-->
<?php
			break;



		case "location":
?>
<!--<div class="top_title">
	<a href="<?/*=NFE_URL;*/?>/"><img src="<?/*=NFE_URL;*/?>/images/top_arrow.png" alt="이전"></a><h2>지도검색</h2>
</div>-->
<?php break; /* 마이페이지 개인회원 상단메뉴 */ case "individual1": ?>
<div class="mypage_btn">
	<ul>
		<li><a href="<?=NFE_URL;?>/mypage/resume_write.php">이력서등록</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/resume_list.php">이력서관리</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/report_individual.php">입사지원관리</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/scrap_individual.php">스크랩구인정보</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/setting_individual.php">맞춤구인정보</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/member_modify.php">개인정보관리</a></li>
	</ul>
</div>
</header>

<?php break; case "company1": ?>

<div class="mypage_btn">
	<ul>
		<li><a href="<?=NFE_URL;?>/mypage/job_write.php">구인정보등록</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/employ_list.php">구인정보관리</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/report_company.php">지원자관리</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/company_list.php">기업정보관리</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/srcap_company.php">스크랩인재정보</a></li>
		<li><a href="<?=NFE_URL;?>/mypage/setting_company.php">맞춤인재정보</a></li>
	</ul>
</div>

<?php break; /* : 결제 서비스안내 */ case "payment_guide": ?>

<div class="guide_tab cf">
	<ul>
		<li class="tab-1">
			<a href="<?=NFE_URL;?>/payment/guide.php" class="<?=!$_GET['code'] ? 'active' : '';?>">기업회원 서비스</a>
		</li>
		<li class="tab-2">
			<a href="<?=NFE_URL;?>/payment/guide.php?code=individual" class="<?=$_GET['code']=='individual' ? 'active' : '';?>">개인회원 서비스</a>
		</li>
	</ul>
</div>
<?php
			break;


		case "adult":
?>
<section class="adult_con cf">
	<h2>성인인증</h2>

	<div class="text-group cf">
		<p><img src="images/adult.png" alt="성인인증"><em>이 정보 내용은 청소년 유해 매체물로서 정보통신망 이용 촉진 및 정보보호 등에 관한 법률 및 청소년 보호법의 규정에 의하여</em>
		<strong>19세 미만의 청소년은 사용할 수 없습니다.</strong>
		<b>19세 미만 또는 성인인증을 원하지 않으실 경우</b>
		청소년 유해 매체물을 제외한 <span>넷퓨</span>의 모든컨텐츠 및 서비스를 이용 하실 수 있습니다.
		</p>
	</div>
	<div class="button_con button_con5">
		<a href="#" class="bottom_btn05">19세 미만 나가기</a>
	</div>
</section>
<?php break; } ?>

</header>

<!-- Start home -->
<section class="bg-half page-next-level">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center text-white">
                    <h4 class="text-uppercase title mb-4">Job List view</h4>
                    <ul class="page-next d-inline-block mb-0">
                        <li><a href="index.html" class="text-uppercase font-weight-bold">Home</a></li>
                        <li><a href="#" class="text-uppercase font-weight-bold">Jobs</a></li>
                        <li>
                            <span class="text-uppercase text-white font-weight-bold">Job Listing</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end home -->
<?php }



$alba_option_logo = $service_control->service_check('alba_option_logo');        // 알바 로고 옵션
$alba_option_logo_effects = explode("/", $alba_option_logo['effect']);
?>
<!--시작태그 -- 이태그 닫는곳은 include/tail.php에 있음.-->

	<div class="container">



<script type="text/javascript">
//var cycle_direction = "<?php echo $alba_option_logo_effects[1];?>";
var cycle_direction = "scrollLeft";

$(".mypage_btn").find("a").removeClass("active");
$(".mypage_btn").find("a").each(function(){
	if(location.href.indexOf($(this).attr("href"))>=0) {
		$(this).parent().addClass("active");
	}
});
</script>