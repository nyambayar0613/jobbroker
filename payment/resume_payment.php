<?php
$page_code = 'mypage';
$head_title = $menu_text = "개인회원 서비스 신청";
include "../include/top.php";

if($_GET['_part']) $_part_txt = preg_replace(array("/_gold/", "/_logo/"), array("", ""), $_GET['_part']);

$pack_query = sql_query("select * from `alice_payment_package` where `wr_type` = 'individual' and `wr_use`=1 order by `wr_rank` asc");
$pack_num = sql_num_rows($pack_query);
?>
<style type="text/css">
._option_service_article._none { display:none; }
</style>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/payment.class.js?time=<?=time();?>"></script>
<!-- 서비스 신청 -->
<form name="fpayment" action="./job_order.php" method="post">
<input type="hidden" name="mode" value="resume_payment" />
<input type="hidden" name="info_no" value="<?=$_GET['no'];?>" />
<input type="hidden" name="pay_type" value="alba_resume" />
<section class="item_con">

<?php
if(!$_part_txt && $pack_num>0) {
?>
	<article>
		<h2><span>Package бүтээгдэхүүн</span></h2>
		<?php
		while($pack_row=sql_fetch_array($pack_query)) {
			$wr_content = unserialize($pack_row['wr_content']);
			$_service = array();
			foreach($wr_content as $key => $content){
				if($content['use']) {
					$service_name = $service_control->package_service['individual'][$key];
					if($service_name){
						$_service[] =$service_name." ".number_format($content['service_count'])." ".$service_control->_unit($content['service_unit']);
					}
				}
			}
		?>
		<div class="item_box cf">
			<h3><input type="checkbox" class="_service_tag" name="service[]" value="package/<?=$pack_row['no'];?>" /><?=$pack_row['wr_subject'];?></h3>
			<ul>
				<li class="box-info1 cf">
					<p><?=@implode(" + ", $_service);?></p>
				</li>
				<li class="box-info2 cf">
					<ul>
					  <li>=</li>
						<li class="item_info4"><?=number_format($pack_row['wr_price']);?>төгрөг</li>
					</ul>
				</li>
				<li class="box-btn">
					<a href="#none;" onClick="netfu_payment.order_move('fpayment', this)">Хүсэлт гаргах<img src="<?=NFE_URL;?>/images/chevron3.png" alt="Хүсэлт гаргах"></a>
				</li>
			</ul>
		</div>
		<?php }?>
	</article>
<?php }





ob_start();
if(is_array($service_control->service_lists)) { foreach($service_control->service_lists as $k=>$v) {
		if($k!='alba_resume') continue;
		if(is_array($v)) { foreach($v as $k2=>$v2) {
			$__content_key = 'main_'.$k2;
			if(!@array_key_exists($__service_key.'_content', $design)) $__content_key = 'main_'.$k2;
			$_content = $design[$__content_key.'_content'];

			if($_part_txt && strpos($__content_key, $_part_txt)===false) continue;

			$service_list = $service_control->__ServiceList('alba_resume_'.$k2);
			$service_option = $service_control->service_check('alba_resume_'.$k2); // 알바 급구 옵션

			if(!$service_option['is_pay']) continue; // : 사용여부 체크

			//$service_gold_list = $service_control->__ServiceList($type."_gold");
			//$service_logo_list = $service_control->__ServiceList($type."_logo");
	?>
	<div class="item_box cf">
		<h3><?=$v2['name'];?></h3>
		<ul>
			<li class="box-info1 cf">
				<p>
				<?=$_content;?>
				</p>
			</li>
			<li class="box-tit cf">
				<select class="_service_tag" name="service[]" onChange="netfu_payment.money_click(this)">
					<option value="">Сонгох</option>
					<?php
					if(is_array($service_list)) {
						foreach($service_list as $val){ 
					?>
					<option value="alba_resume/<?=$val['no'];?>">Өнөөдөр+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></option>
					<?php
						}
					}
					?>
				</select>
			</li>
			<li class="box-info2 cf">
				<ul>
					<li class="item_info1 service_info1"></li>
					<li class="item_info2 service_info2"><li>
					<li class="item_info3 service_info3"></li>
					<li class="item_info4 service_info4"></li>
				</ul>
			</li>
			<li class="box-btn">
				<a href="#none;" onClick="netfu_payment.order_move('fpayment', this)">Хүсэлт гаргах<img src="<?=NFE_URL;?>/images/chevron3.png" alt="Хүсэлт гаргах"></a>
			</li>
		</ul>
	</div>
<?php
	} }
} }
$_tag = ob_get_clean();

if($_tag) {
?>
	<article>
		<h2><span>Үйлчилгээ бүтээгдэхүүн</span></h2>


		<?php
		echo $_tag;
		?>
	</article>
<?php
}



### : 구인정보 서비스
$option_service_arr = $service_control->service_lists['resume_option'];
$option_array = array(
    'busy'=>array('name'=>'Яаралтай', 'option'=>array('busy')),
    'strong'=>array('name'=>'Highlight option', 'option'=>array('neon', 'bold', 'icon', 'color', 'blink')),
    'jump'=>array('name'=>'Jump', 'option'=>array('jump')),
    'open'=>array('name'=>'Анкет үзэх', 'option'=>array('open')),
    'sms'=>array('name'=>'SMS цэнэглэх', 'option'=>array('sms')),
);
if(is_array($option_array)) { foreach($option_array as $k=>$v) {
?>
	<article class="_option_service_article">
		<h2><span><?=$v['name'];?> Үйлчилгээ</span></h2>
		<?php
		if(is_array($v['option'])) { foreach($v['option'] as $k2=>$v2) {
			if($_part_txt && $_part_txt!=$v2) continue; // : 각각의 서비스신청을 누른경우

			$_part = in_array($v2, array('open', 'sms', 'alba')) ? 'etc' : 'resume_option';

			// : 이력서 열람, SMS 충전
			if(in_array($k, array('open', 'sms', 'alba'))) {
				$__service_key = 'etc_'.$k;
				$__content_key = $__service_key;

				if(in_array($k, array('open'))) $__content_key = 'alba_'.$k;
				if(in_array($k, array('sms'))) $__content_key = 'etc_resume_sms';

				$resume_option = $service_control->service_check($__service_key); // 알바 급구 옵션
				$service_list = $service_control->__ServiceList($resume_option['service']); // 알바 급구 서비스 리스트

			// : 그외
			} else {
				if(in_array($k, array('busy'))) $__content_key = 'main_resume_'.$k;
				if(in_array($k, array('jump'))) $__content_key = preg_replace("/_option/", "", 'resume_option').'_'.$k;

				$resume_option = $service_control->service_check('resume_option_'.$v2); // 서비스금액 배열값
				$service_list = $service_control->__ServiceList($resume_option['service']); // 서비스금액
			}

			if(!$resume_option['is_pay']) continue; // : 사용여부체크

			if(@array_key_exists($__content_key.'_content', $design)) $_content = $design[$__content_key.'_content'];
			else $_content = $netfu_payment->option_se_content[$v2];

			$_option_arr = array();

			// : 옵션파트
			if($v2=='neon')
				$_option_arr = explode("/",$resume_option['neon_color']);	 // 색상
			else if($v2=='icon')
				$_option_arr = $category_control->category_codeList($resume_option['service']);
			else if($v2=='color')
				$_option_arr = explode("/",$resume_option['font_color']);	// 색상

			// : 선택형 옵션 존재여부
			$_part_option = @count($_option_arr)>0 ? 'part_option' : '';
		?>
		<div class="item_box cf">
			<h3 class="sname"><?=$option_service_arr[$v2]['name'];?></h3>
			<ul>
				<li class="box-info1 cf">
					<p>
					<?=$_content;?>
					</p>
				</li>
				<li class="box-info1 cf <?=$_part_option;?>">
					<?php
					if(is_array($_option_arr) && @count($_option_arr)>0) { foreach($_option_arr as $k3=>$v3) {
						$_val = $v2=='icon' ? $v3['no'] : $v3;
					?>
					<label onClick="$('#check_<?=$v2;?>_<?=$_val;?>')[0].click()"><input type="radio" name="service_opt[<?=$v2;?>]" value="<?=$_val;?>" id="check_<?=$v2;?>_<?=$_val;?>">
					<?php


					// : 강조효과 파트정보 ##############
						switch($v2) {
							case 'icon':
					?>
					<img src="<?=NFE_URL;?>/data/icon/<?=$v3['name'];?>" alt="Айкон<?=$k3;?>"></label>
					<?php
								break;

							case 'color':
					?>
					<em style="color:#<?=$v3;?>;">Текстийн өнгө</em>
					<?php
								break;

							case 'neon':
					?>
					<em style="color:#fff; background:#<?=$v3;?>;">Тодруулагч</em>
					<?php
								break;
						}
					// : 강조효과 파트정보 ##############
					?>
					</label>
					<?php
					} }
					?>
				</li>
				<li class="box-tit cf">
					<?php
					############# 금액값 ############
					?>
					<select class="<?=$_part_option;?>" name="service[]" onChange="netfu_payment.money_click(this)">
						<option value="">Сонгох</option>
						<?php
						if(is_array($service_list)) {
							foreach($service_list as $val){ 
								$_txt_int = $val['service_cnt'] ? $val['service_cnt'] : $val['etc_3'];
								$_txt_val = $val['service_unit'] ? str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']) : 'төрөл';
						?>
						<option value="<?=$_part;?>/<?=$val['no'];?>">Өнөөдөр+<?=$_txt_int.$_txt_val;?></option>
						<?php
							}
						}
						?>
					</select>
					<?php
					############# 금액값 ############
					?>
				</li>
				<li class="box-info2 cf">
					<ul>
						<li class="item_info1 service_info1"></li>
						<li class="item_info2 service_info2"><li>
						<li class="item_info3 service_info3"></li>
						<li class="item_info4 service_info4"></li>
					</ul>
				</li>
				<li class="box-btn">
					<a href="#none;" onClick="netfu_payment.order_move('fpayment', this)">Хүсэлт гаргах<img src="<?=NFE_URL;?>/images/chevron3.png" alt="Хүсэлт гаргах"></a>
				</li>
			</ul>
		</div>
		<?php } }?>
	</article>
<?php } }?>

</section>

<script type="text/javascript">
$("._option_service_article").each(function() {
	var _len = $(this).find(".item_box").length;
	if(_len<=0) $(this).addClass("_none");
});
</script>

<div class="button_con button_con4">
	<a href="#none;" class="bottom_btn04" onClick="netfu_payment.order_move('fpayment', 'all')">Үйлчилгээний хүсэлт гаргах<img src="<?=NFE_URL;?>/images/btn_arrow.png" alt="Үндсэн хуудас"></a>
</div>
</form>


<?php
include "../include/tail.php";
?>