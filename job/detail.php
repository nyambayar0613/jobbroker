<?php
include_once "../include/top.php";
$sns_feed = explode(',',$env['sns_feed']);

$_where = " and no=".$_GET['no']." and is_delete=0 and !(".$netfu_mjob->job_where.$netfu_mjob->_service_where.")";
$q = "alice_alba where 1 ".$_where;
$end_chk_total = sql_fetch("select no from ".$q);
if($end_chk_total['no']) { 
	echo "<script>alert('Үйлчилгээний хугацаа дууссан болохыг анхаарна уу.'); history.go(-1);</script>";
}

$_cate1_array = array('alba_pay_type', 'job_ability', 'preferential', 'job_target');
if(is_array($_cate1_array)) { foreach($_cate1_array as $k=>$v) {
	$_cate_[$v] = $netfu_util->get_cate_code_array($v, array('where'=>" and `p_code` = ''"));
} }

$get_alba = $alba_user_control->get_alba_no($_GET['no']);	// 정규직 정보
$_wr_papers = $netfu_util->get_cate_code_array('pt_paper', array('where'=>""));
$_wr_requisition = explode(",", $get_alba['wr_requisition']);

$info = $netfu_mjob->get_alba($get_alba);
if($get_alba['wr_company'])
	$com_member = sql_fetch("select * from alice_member_company where `mb_id`='".$get_alba['wr_id']."' and `no`='".$get_alba['wr_company']."'");
else
	$com_member = sql_fetch("select * from alice_member_company where `mb_id`='".$get_alba['wr_id']."' order by `no` desc limit 1");

$get_logo = $alba_user_control->get_logo($com_member, $info);
$_logo_c = $netfu_mjob->get_logo_type('', $get_alba, $get_logo);

// : 구인정보 상세 php정보
include NFE_PATH.'/include/job_detail.info.php';

$service_check = $service_control->service_check('etc_alba');
$open_is_pay = $service_check['is_pay'];

// 조회수 증가
$alba_user_control->hit_up($_GET['no']);
?>
<style type="text/css">
.tab-box { display:none; }
a, a:link, a:visited, a:active, a:hover {cursor:pointer; text-decoration:none;}
.content_editor- img { width:auto !important; height:auto !important; max-width:100% !important; }
</style>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/mjob.class.js?num=<?=time();?>"></script>
<script type="text/javascript">
var map_view = false;
$(window).ready(function(){

	$(".tab-box").find("td").each(function(){
		if(!$(this).text()) $(this).closest("tr").css("display", "none");
	});

	$(".tab1-con").find("li").click(function(i){
		var key = $(this).index();
		$(".tab1-con").find("li").removeClass("active");
		$(this).addClass("active");
		$(".tab-box").css("display", "none");
		$(".tab-box").eq(key).css("display", "block");

		if(key==2 && !map_view) {
			var map_arr = $(".tab-box").eq(key).find("[name='map_arr[]']");
			daum_map.map_basic('location_map', map_arr.eq(0).val(), map_arr.eq(1).val(), 3);
			daum_map.set_markers(map_arr.eq(0).val(), map_arr.eq(1).val());
			map_view = true;
		}
	});
});
</script>
<style>
.ph_no div{height:24px;line-height:24px}
.company_info .col2{margin-bottom:5px}
</style>


<section class="cont_box detail_con">
  <h2 class="top_tit"><?=stripslashes(strip_tags($get_alba['wr_subject']));?></h2>



<div class="top_area">
	<ul>
		<li class="etc">Эцсийн хугацаа <?=$job_info['volume_text'];?></li>
		<li class="ktid"><span>Kakao talk ID : <em><?=$get_alba['kakao_id'];?></em></span></li>
		<li class="btn_report"><a onClick="netfu_util1.open($('.report_bx'))"><img src="<?=NFE_URL;?>/images/icon_notify.gif" alt="Мэдэгдэх">Мэдэгдэх</a></li>
	</ul>
	</div>
	<?php
	// : 신고하기 팝업
	$category_list = $category_control->category_codeList('alba_report_reason');
	$report_code = 'job';
	include NFE_PATH.'/include/inc/report_box.inc.php';
	?>
  <div class="company_con cf">
		<div class="logo_box">
			<?=$_logo_c['img'];?>
		</div>
		<div class="text_box">
			<div class="company"><?=stripslashes($get_alba['wr_company_name']);?></div>
		</div>
	</div>
	<div class="company_info cf">
		<div class="mb_info ceo_info">
			<div class="ceo_inner">
				<dl>
					<dt class="hd hd2"><span><img src="<?=NFE_URL;?>/images/info1-1.png" alt="Хариуцсан хүн" /></span>Хариуцсан хүн</dt>
					<dd class="col1 col2" style="line-height:20px">
						<?=$job_info['wr_person'];?>
					</dd>
				</ul>
			</div>
		</div>
		<div class="mb_info address_info">
			<div class="address_inner">
				<dl>
					<dt class="hd hd2"><span><img src="<?=NFE_URL;?>/images/info1-2.png" alt="Холбоо барих дугаар" /></span>Холбоо барих</dt>
					<dd class="col1 col2 ph_no">
						<div><span class="ph_no_tx" style="color:#8895b3;font-size:.9em">Холбоо барих</span> : <?=$job_info['wr_phone'];?></div>
						<div><span class="ph_no_tx" style="color:#8895b3;font-size:.9em">Утасны дугаар</span> : <?=$job_info['wr_hphone'];?></div>
					</dd>
				</ul>
			</div>
		</div> 
		<div class="company_info2 cf">
		  <ul>
			  <li class="nvli1">
				  <button type="button" class="bt-scrap" onClick="netfu_mjob.scrap('alba', '<?=$_GET['no'];?>')"><span class="li-icon"><img src="<?=NFE_URL;?>/images/scrap_icon2.png" alt="Scrab"></span><span class="txt">Scrab</span></button>
				</li>
			  <li class="nvli2">
				  <a href="javascript:netfu_mjob.read_func('<?=$get_alba['no'];?>', 'job', 'sms')"><span class="li-icon"><img src="<?=NFE_URL;?>/images/letter_ico.png" alt="мессеж илгээх" />&nbsp</span><span class="txt">Мессеж илгээх</span></a>
				</li>
			  <li class="nvli3">
          <a href="javascript:netfu_mjob.read_func('<?=$get_alba['no'];?>', 'job', 'tel')"><span class="li-icon"><img src="<?=NFE_URL;?>/images/tel_ico.png" alt="дуудлага хийх" />&nbsp</span><span class="txt">Дуудлага хийх</span></a>
				</li>
			</ul>
		</div>
	</div>

	<div class="button_group scrap_bt">
	<?php if(@in_array("online", $_wr_requisition)) {?>
	<button type="button" class="bt-online _btn requisition_btn" k="online" no="<?=$get_alba['no'];?>">Ажилд орох өргөдөл (Онлайн)</button>
	<?php }?>
	<?php if(@in_array("email", $_wr_requisition)) {?>
	<button type="button" class="bt-email _btn requisition_btn" k="email" no="<?=$get_alba['no'];?>">Ажлын байрны өргөдөл (И-мэйл)</button>
	<?php }?>
	</div>
</section>
<?php
if(in_array($_GET['code'], array('receive_online', 'receive_email'))) {
	$_receive_arr = explode("_", $_GET['code']);
?>
<script type="text/javascript">
var _btn_code = "<?=$_receive_arr[1];?>"=='online' ? 0 : 1;
receive_click($("._btn").eq(_btn_code)[0]);
</script>
<?php
}
?>







<section class="cont_box detail_con detail_con2">
	<div class="tab1-con cf">
		<ul>
			<li class="active"><a>Ажилд урьж байна</a></li>
			<li><a>Дэлгэрэнгүй мэдээлэл</a></li>
			<li><a>Ажлын байршил</a></li>
			<li><a>Байгуууллагын тухай</a></li>
		</ul>
	</div>

	<?php
	include NFE_PATH.'/include/inc/job_detail_tab1.inc.php'; // : 모집요강
	include NFE_PATH.'/include/inc/job_detail_tab2.inc.php'; // : 상세요강
	include NFE_PATH.'/include/inc/job_detail_tab3.inc.php'; // : 근무위치
	include NFE_PATH.'/include/inc/job_detail_tab4.inc.php'; // : 회사정보
	?>


	<div class="button_group scrap_bt">
	<?php if(@in_array("online", $_wr_requisition)) {?>
        <button type="button" class="bt-online _btn requisition_btn" k="online" no="<?=$get_alba['no'];?>">Ажилд орох өргөдөл (Онлайн )</button>
    <?php }?>
        <?php if(@in_array("email", $_wr_requisition)) {?>
            <button type="button" class="bt-email _btn requisition_btn" k="email" no="<?=$get_alba['no'];?>">Ажлын байрны өргөдөл (И-мэйл)</button>
	<?php }?>
	<button type="button" class="bt-scrap" onClick="netfu_mjob.scrap('alba', '<?=$_GET['no'];?>')"><img src="<?=NFE_URL;?>/images/scrap_icon2.png" alt="scrab"><!--<img src="images/scrap_icon1.png">-->scrab</button>
	</div>

<div class="caution">
<p>Тус мэдээлэл нь <?=stripslashes($get_alba['wr_company_name']);?>ээс <?php echo strtr(substr($get_alba['wr_wdate'],0,10),'-','/');?>  хойш олгож эхэлсэн, <?php echo $env['site_name'];?>агуулгад гарсан алдаа, саатал гарсан тохиолдолд компани хариуцахгүй. <?php echo $env['site_name'];?> зөвшөөрөөгүй тохиолдолд ашиглах боломжгүй.<зохиогчийн эрх  ⓒ <?php echo $env['site_name'];?>.Зөвшөөрөлгүй ашиглах-дахин хуулбарлахыг хориглоно.>&gt;</p>
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
include_once(NFE_PATH.'/include/tail.php');
?>