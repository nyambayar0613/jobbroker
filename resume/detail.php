<?php
include_once "../include/top.php";
$_cate_['indi_language'] = $netfu_util->get_cate_array('indi_language', array('where'=>" and `p_code` = ''"));
$_cate_['indi_language_license'] = $netfu_util->get_cate_array('indi_language_license', array('where'=>" and `p_code` = ''"));
$_cate_['indi_oa'] = $netfu_util->get_cate_array('indi_oa', array('where'=>" and `p_code` = ''"));
$_cate_['indi_special'] = $netfu_util->get_cate_array('indi_special', array('where'=>" and `p_code` = ''"));
$_cate_['indi_treatment'] = $netfu_util->get_cate_array('indi_treatment', array('where'=>" and `p_code` = ''"));
$_cate_['alba_date'] = $netfu_util->get_cate_array('alba_date', array('where'=>" and `p_code` = ''"));
$_cate_['alba_week'] = $netfu_util->get_cate_array('alba_week', array('where'=>" and `p_code` = ''"));
$_cate_['alba_time'] = $netfu_util->get_cate_array('alba_time', array('where'=>" and `p_code` = ''"));
$_cate_['impediment'] = $netfu_util->get_cate_code_array('impediment', array('where'=>" and `p_code` = ''"));

$service_check = $service_control->service_check('etc_open');

$re_row = sql_fetch("select * from alice_alba_resume where `no`='".addslashes($_GET['no'])."'");
$get_member = $user_control->get_member($re_row['wr_id']);	 // 등록 회원 정보
$re_info = $netfu_mjob->get_resume($re_row, $get_member);
$list = $alba_resume_user_control->get_resume_service($re_row['no'],"",80);
$read_info = $netfu_member->get_read_info($re_row, $get_member);


$wr_calltime = explode('-',$re_row['wr_calltime']);




/*
*/
$service_open = $utility->valid_day($member_service['mb_service_open']);	// 이력서 열람 서비스 기간 체크

$is_open_count = false;
if( $utility->valid_day($member_service['mb_service_open']) && $member_service['mb_service_open_count'] ){	// 건수 사용이 가능하다면
	$is_open_count = $member_service['mb_service_open_count'];
}

$is_open_resume = $alba_resume_user_control->is_open_resume('resume',$member['mb_id'],$re_row['wr_id'], $_GET['no']);	// 열람한 정보가 있는지


// 지원한 이력서 인지 확인
$receive_info = $receive_control->get_receive_info(" where `wr_from` = '".$_GET['no']."' and `wr_to_id` = '".$member['mb_id']."' and `is_cancel` = 0 and `is_delete` = 0 ");
if($receive_info){
	//$open_is_pay = true;
	//$service_open = true;
	$is_open_resume = true;
}
?>
<style type="text/css">
.tab-box { display:none; }
</style>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/mjob.class.js?num=<?=time();?>"></script>
<script type="text/javascript">
$(window).ready(function(){

	$(".tab-box").find("td").each(function(){
		if(!$(this).text()) $(this).closest("tr").css("display", "none");
	});

	$(".tab2-con").find("li").click(function(i){
		var key = $(this).index();
		$(".tab2-con").find("li").removeClass("active");
		$(this).addClass("active");
		$(".tab-box").css("display", "none");
		$(".tab-box").eq(key).css("display", "block");
	});
});
</script>
<section class="cont_box detail_con">
<h2 class="top_tit"><?=stripslashes($re_row['wr_subject']);?></h2>
<?php
include NFE_PATH.'/include/inc/resume_pop.inc.php';
?>
<div class="top_area">
<ul>
	<li class="ktid"><span>Kakao ID : <em><?=$re_row['kakao_id'];?></em></span></li>
	<li><span>Холбогдох боломжтой цаг <em><?=$re_row['wr_calltime_always'] ? 'Үргэлж боломжтой' : $wr_calltime[0].":00~".$wr_calltime[1].":00";?></em></span></li>
	<li class="btn_report"><a onClick="netfu_util1.open($('.report_bx'))"><img src="<?=NFE_URL;?>/images/icon_notify.gif" alt="Мэдэгдэх">Мэдэгдэх</a></li>
</ul>
</div>
<div class="profile_con cf">
<?php
/*
NFE_URL/images/id_pic.png NFE_URL/images/id_pic2.png
*/
?>
<div class="pic_box">
	<img src="<?=$re_info['mb_photo'];?>" alt="ID зураг">
</div>
<div class="txt_box cf">
	<ul>
		<li>
		  <span><img src="<?=NFE_URL;?>/images/info1-1.png" alt="Нэр, ID"></span>
			<p>
			  <ol>
					<li class="pf_name"><?=$utility->make_pass_○○($get_member['mb_name']);?> </li>
					<li class="pf_info"><p class="gender"><?=$user_control->mb_gender[$get_member['mb_gender']];?></p><p class="birth"><?=$netfu_util->get_age($get_member['mb_birth']);?></p></li>
					<li class="slash"></li>
					<li class="pf_id"></li>
				</ol>
			</p>
		</li>
		<li><span><img src="<?=NFE_URL;?>/images/info1-3.png" alt="Холбогдох дугаар"></span><p><?=$read_info['phone'];?></p></li>
		<li><span><img src="<?=NFE_URL;?>/images/info1-2.png" alt="Утасны дугаар"></span><p><?=$read_info['hphone'];?></p><em class="msn_btn"><a href="javascript:netfu_mjob.read_func('<?=$re_row['no'];?>', 'resume', 'sms')"><img src="<?=NFE_URL;?>/images/letter_icon.png" alt="SMS илгээх">SMS</a></em><em class="call_btn"><a href="javascript:netfu_mjob.read_func('<?=$re_row['no'];?>', 'resume', 'tel')"><img src="<?=NFE_URL;?>/images/tel_ico.png" alt="Залгах">Залгах</a></em></li>
		<li><span><img src="<?=NFE_URL;?>/images/info1-4.png" alt="И-мэйл"></span><p><?=$read_info['email'];?></p></li>
		<li class="address4"><span><img src="<?=NFE_URL;?>/images/info1-5.png" alt="Хаяг"></span><p><?=$read_info['address'];?></p></li>
	</ul>
</div>
<div class="etc_box cf">
  <ul>
	  <li><span>Боловсрол</span><p><?php echo stripslashes($re_info['wr_school_ability']['name']);?></p></li>
		<li><span>Адбан тушаал</span><p><?=$list['career'];?></p></li>
		<li><span>Хүсэж буй цалин</span><p><?=$re_info['pay_type'];?></p></li>
		<li><span>Мэргэжлийн үнэмлэх</span><p><?=$re_info['license'];?></p></li>
		<li><span>Гадаад хэлний түвшин</span><p><?=$re_info['language_txt'];?></p></li>
	</ul>
</div>
</div>
<div class="button_group scrap_bt resume__">
<button type="button" class="bt-apply _btn" k="become">입사지원요청</button>
<?
/*
<button type="button" class="bt-apply _btn" k="interview">면접제의요청</button>
*/?>
<button type="button" class="bt-scrap" onClick="netfu_mjob.scrap('alba_resume', '<?=$_GET['no'];?>')"><img src="<?=NFE_URL;?>/images/scrap_icon2.png" alt="스크랩"><!--<img src="<?=NFE_URL;?>/images/scrap_icon1.png">-->스크랩</button>
</div>
</section>

<section class="cont_box detail_con detail_con2">
<div class="tab2-con cf">
<ul>
  <li class="active"><a href="#none;">CV мэдээлэл</a></li>
  <li><a href="#none;">Мэргэшсэн байдал</a></li>
  <li><a href="#none;">Миний танилцуулга</a></li>
</ul>
</div>

<?php
include NFE_PATH.'/include/inc/resume_detail_tab1.inc.php';
include NFE_PATH.'/include/inc/resume_detail_tab2.inc.php';
include NFE_PATH.'/include/inc/resume_detail_tab3.inc.php';
?>

<div class="button_group scrap_bt resume__">
<button type="button" class="bt-apply _btn" k="become">Ажилд орох өргөдөл</button>
<?
/*
<button type="button" class="bt-apply _btn" k="interview">면접제의요청</button>аэж
*/?>
<button type="button" class="bt-scrap" onClick="netfu_mjob.scrap('alba_resume', '<?=$_GET['no'];?>')"><img src="<?=NFE_URL;?>/images/scrap_icon2.png" alt="scrab"><!--<img src="<?=NFE_URL;?>/images/scrap_icon1.png">-->scrab</button>
</div>

<div class="caution">
<p>본 정보는 취업활동을 위해 등록한 이력서 정보이며 <?php echo $env['site_name'];?>는(은) 기재된 내용에 대한 오류와 사용자가 신뢰하여 취한 조치에 대한 책임을 지지 않습니다. 누구든 본 정보를 <?php echo $env['site_name'];?>의 동의없이 재배포할 수 없으며 본 정보를 출력 및 복사하더라도 채용목적 이외의 용도로 사용할 수 없습니다. 본 정보를 출력 및 복사한 경우의 개인정보보호에 대한 책임은 출력 및 복사한 당사자에게 있으며 정보통신부 고시 제2005-18호 (개인정보의 기술적·관리적 보호조치 기준)에 따라 개인정보가 담긴 이력서 등을 불법유출 및 배포하게 되면 법에 따라 책임지게 됨을 양지하시기 바랍니다. &lt;저작권자 ⓒ <?php echo $env['site_name'];?>. 무단전재-재배포 금지&gt;</p>
</div>
<div class="share-con">
	<div class="sns_btn_group cf">
		<!-- AddToAny BEGIN -->
		<!-- <style type="text/css">
				a .a2a_svg{
						height: 28px;
						line-height: 28px;
						width: 28px;
						-webkit-filter: invert(1);
						filter: invert(1);
				}
		</style> -->
		<div class="a2a_kit a2a_kit_size_20 a2a_default_style" style="float:right;">
			<?php if(in_array('facebook',$sns_feed)){ ?>
			<a class="a2a_button_facebook"></a>
			<?php }
			
			if(@in_array('twitter', $sns_feed)) {
			?>
			<a class="a2a_button_twitter"></a>
			<?php }
			
			if(@in_array('kakao_story', $sns_feed)) {
			?>
			<a class="a2a_button_kakao"></a>
			<?php }
			
			if(@in_array('line', $sns_feed)) {
			?>
			<a class="a2a_button_line"></a>
			<?php }
			
			if(@in_array('pin', $sns_feed)) {
			?>
			<a class="a2a_button_pinterest"></a>
			<?php }
			
			if(@in_array('sns_plus', $sns_feed)) {
			?>
			<div style="float:left"><a class="a2a_dd" href="https://www.addtoany.com/share"></a></div>
			<?php }?>
		</div>
		<script>
				var a2a_config = a2a_config || {};
				a2a_config.locale = "ko";
				a2a_config.icon_color = "transparent";
				a2a_config.onclick = 1;
				a2a_config.num_services = 10;
				a2a_config.icon_color = "unset,#fff"; /* #d0d0d0  original */
				a2a_config.prioritize = ["facebook_messenger", "google_plus", "tumblr", "wordpress", "google_gmail", "evernote", "sms", "instapaper", "Linkedln", "facebook"];
		</script>
		<script async src="https://static.addtoany.com/menu/page.js"></script>
	</div>
</div>
</section>

<?php
include "../include/tail.php";
?>