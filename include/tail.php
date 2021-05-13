<!-- 공지사항 -->
<?php

include NFE_PATH."/include/job_detail.box.php";
include NFE_PATH."/include/resume_detail.box.php";

include NFE_PATH.'/include/inc/notice.inc.php';



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

<footer class="cf">
	<div class="footer_link">
		<?php
		if($member['mb_id']) {
		?>
		<a href="<?=NFE_URL;?>/regist.php?mode=logout">로그아웃</a>
		<?php
		} else {
		?>
		<a href="<?=NFE_URL;?>/include/login.php">로그인</a>
		<?php
		}
		?>
		<a href="<?=NFE_URL;?>/etc/text.php?code=site_agreement">이용약관</a>
		<a href="<?=NFE_URL;?>/etc/text.php?code=site_privacy">개인정보방침</a>
		<a href="<?=NFE_URL;?>/etc/cs_center.php">고객센터</a>
		<a href="<?=NFE_URL;?>/etc/adver.php">광고안내</a>
		<a href="<?=NFE_URL;?>/etc/concert.php">제휴문의</a>
	</div>
	<div class="footer_info">
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
		echo stripslashes($env['site_bottom']);
		?>
		</div>
	</div>
</footer>
</div>

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
		var _txt = k=="become" ? '입사지원' : '면접제의';
		
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
				if(confirm("열람권 구매하시겠습니까?")) {
					location.href = base_url+"/payment/read_payment.php";
				}
	<?php
			}
		} else if($member['mb_id']) {
	?>
		alert("기업회원만 이용가능합니다.");
	<?php
		} else {
	?>
		alert("로그인하셔야 이용가능합니다.");
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