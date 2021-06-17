<!-- 공지사항 -->
<?php

//include NFE_PATH."/include/job_detail.box.php";
//include NFE_PATH."/include/resume_detail.box.php";

//include NFE_PATH.'/include/inc/notice.inc.php';



if($member['mb_id'] && $member['mb_type']=='individual') {
	$q = "select * from alice_alba_resume where `wr_id`='".$member['mb_id']."' and `wr_open`=1 order by wr_wdate desc";
	$my_reseume = sql_query($q);
	$my_resume_arr = array();
	while($row=sql_fetch_array($my_reseume)) {
		$my_resume_arr[] = $row;
	}
}

// : 온라인 입사지원 레이어
include NFE_PATH.'/include/inc/online_box.inc.php';
// : 이메일 입사지원 레이어
include NFE_PATH.'/include/inc/email_box.inc.php';
/*
?>
</div>
</div>
*/?>

<script type="text/javascript">
<?php
if($_GET['__hash_']) {
?>
$(window).load(function(){
	setTimeout(function(){
	window.location.hash = "#<?=$_GET['__hash_'];?>";
	},200);
});
<?php }?>
</script>



<footer class="cf footer">
	<!--<div class="footer_link">
		<?php
/*		if($member['mb_id']) {
		*/?>
		<a href="<?/*=NFE_URL;*/?>/regist.php?mode=logout">로그아웃</a>
		<?php
/*		} else {
		*/?>
		<a href="<?/*=NFE_URL;*/?>/include/login.php">로그인</a>
		<?php
/*		}
		*/?>
		<a href="<?/*=NFE_URL;*/?>/etc/text.php?code=site_agreement">이용약관</a>
		<a href="<?/*=NFE_URL;*/?>/etc/text.php?code=site_privacy">개인정보방침</a>
		<a href="<?/*=NFE_URL;*/?>/etc/cs_center.php">고객센터</a>
		<a href="<?/*=NFE_URL;*/?>/etc/adver.php">광고안내</a>
		<a href="<?/*=NFE_URL;*/?>/etc/concert.php">제휴문의</a>
	</div>-->
	<!--<div class="footer_info">
		<div class="top_button cf">
			<div id="topAnchor">
				<a href="#top">
					<div class="topBtn">
						<div class="up_icon"><img src="/images/icon/top_img.png" alt="TOP" width="13"></div>
						<div class="top_txt">TOP</div>
					</div>
				</a>
			</div>
		</div>
		<div class="footer_con">
		<?php
/*		echo stripslashes($env['site_bottom']);
		*/?>
		</div>
	</div>-->
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                <a href="javascript:void(0)"><img src="images/logo-light.png" height="20" alt=""></a>
                <p class="mt-4">At vero eos et accusamus et iusto odio dignissim os ducimus qui blanditiis praesentium</p>
                <ul class="social-icon social list-inline mb-0">
                    <li class="list-inline-item"><a href="#" class="rounded"><i class="mdi mdi-facebook"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="rounded"><i class="mdi mdi-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="rounded"><i class="mdi mdi-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="#" class="rounded"><i class="mdi mdi-google"></i></a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <p class="text-white mb-4 footer-list-title">Company</p>
                <ul class="list-unstyled footer-list">
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> About Us</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Media & Press</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Career</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Blog</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Pricing</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Marketing</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> CEOs </a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Agencies</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Our Apps</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <p class="text-white mb-4 footer-list-title">Resources</p>
                <ul class="list-unstyled footer-list">
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Support</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Privacy Policy</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Terms</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Accounting </a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> Billing</a></li>
                    <li><a href="#" class="text-foot"><i class="mdi mdi-chevron-right"></i> F.A.Q.</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                <p class="text-white mb-4 footer-list-title f-17">Business Hours</p>
                <ul class="list-unstyled text-foot mt-4 mb-0">
                    <li>Monday - Friday : 9:00 to 17:00</li>
                    <li class="mt-2">Saturday : 10:00 to 15:00</li>
                    <li class="mt-2">Sunday : Day Off (Holiday)</li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Back to top -->
<a href="#" class="back-to-top rounded text-center" id="back-to-top">
    <i class="mdi mdi-chevron-up d-block"> </i>
</a>
<!-- Back to top -->

<!-- javascript -->
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery.easing.min.js"></script>
<script src="/js/plugins.js"></script>

<!-- selectize js -->
<script src="/js/selectize.min.js"></script>
<script src="/js/jquery.nice-select.min.js"></script>

<script src="/js/owl.carousel.min.js"></script>
<script src="/js/counter.int.js"></script>

<script src="/js/app.js"></script>
<script src="/js/home.js"></script>

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>
<script>
$(window).scroll(function() {
    if ($(this).scrollTop()>1000)
     {
      $('#topAnchor').fadeIn();
     }
    else
     {
      $('#topAnchor').fadeOut();
     }
 });
</script>




<script type="text/javascript">
$(".button_group.resume__").find("._btn").click(function(){
	<?php
		if($member['mb_id'] && $member['mb_type']=='company') {
			if($read_info['_open_view_allow']===true) {
	?>
		var form = document.forms['f_resume_pop1'];
		var k = $(this).attr("k");
		var _txt = k=="become" ? 'Ажилд орох өргөдөл' : 'Ярилцлага';
		
		form.wr_type.value = k;
		$(".resume_pop_bx").find("._txt").html(_txt);
		if(k=='become') $(".resume_pop_bx").removeClass("interview_de");
		else $(".resume_pop_bx").addClass("interview_de");
		$(".detail_ly.mail_ly").css("display","none");
		setTimeout(function(){
			$(".detail_ly.mail_ly.resume_pop_bx").css("display","block");
		},100);
	<?php
			} else {
	?>
				if(confirm("Үйлчилгээ худалдаж авах уу?")) {
					location.href = base_url+"/payment/read_payment.php";
				}
	<?php
			}
		} else if($member['mb_id']) {
	?>
		alert("Байгууллагын гишүүн л ашиглах боломжтой.");
	<?php
		} else {
	?>
		alert("Ашиглахын тулд нэвтрэнэ үү.");
		location.href = base_url+'/include/login.php';
	<?php
		}
	?>
});




var receive_click = function(obj) {
	var _no = $(obj).attr("no");
	var obj2 = $(obj);
	var k = obj2.attr("k");

	var _form = $(".detail_ly.mail_ly."+k+'_bx').closest("form");
	var form = _form[0];
	var _offset = $(obj).offset();
	$(".detail_ly.mail_ly").css({'top':(_offset.top+40)+'px'});
	if(_no) {
		form.no.value = _no;
	}

	$.post(base_url+"/regist.php", "mode=receive_click&k="+k+"&no="+_no, function(data) {
		//alert(data);
		data = $.parseJSON(data);
		if(data.msg) alert(data.msg);
		if(data.js) eval(data.js);
		if(data.move) location.href = data.move;
	});
}

$(".button_group").find(".requisition_btn").click(function(){
	receive_click($(this)[0]);
});
</script>
</body>

<?php
if($netfu_payment->use_pg['pg_company']=='allthegate' && strpos($_SERVER['PHP_SELF'], "job_order.php")!==false) {
?>
<script type="text/javascript" src="https://www.allthegate.com/plugin/jquery-1.11.1.js"></script>
<script type="text/javascript" src="https://www.allthegate.com/payment/webPay/js/ATGClient_new.js"></script>
<?php }?>

</html>