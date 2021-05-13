<?php
$menu_code = 'text';
$menu_text = '광고안내';
$head_title = $_GET['code']=='individual' ? '개인회원 서비스 광고안내' : '기업회원 서비스 광고안내';
include_once "../include/top.php";

#################################
/*
$__content_key --> 서비스 설명변수값.
*/
#################################


$_banner = 'etc_service_top';
include NFE_PATH.'/include/inc/banner.inc.php';

$wr_type = $_GET['code']=='individual' ? 'individual' : 'employ';
$q = "select * from `alice_payment_package` where `wr_type` = '".$wr_type."' and `wr_use`=1 order by `wr_rank` asc";
$pack_query = sql_query($q);
$pack_length = mysql_num_rows($pack_query);
?>
<div class="guide_tab cf">
	<ul>
		<li class="tab-1">
			<a href="<?=NFE_URL;?>/etc/adver.php" class="<?=!$_GET['code'] ? 'active' : '';?>">기업회원 서비스</a>
		</li>
		<li class="tab-2">
			<a href="<?=NFE_URL;?>/etc/adver.php?code=individual" class="<?=$_GET['code']=='individual' ? 'active' : '';?>">개인회원 서비스</a>
		</li>
	</ul>
</div>

<section class="item_con guide_con">

<?php
if($pack_length>0) {
?>
	<article>
		<h2><span>패키지상품</span></h2>
		<?php
		while($pack_row=sql_fetch_array($pack_query)) {
			$wr_content = unserialize($pack_row['wr_content']);
			$_service = array();
			foreach($wr_content as $key => $content){
				if($content['use']) {
					$service_name = $service_control->package_service[$wr_type][$key];
					if($service_name){
						$_service[] =$service_name." ".number_format($content['service_count'])." ".$service_control->_unit($content['service_unit']);
					}
				}
			}
		?>
		<div class="item_box cf">
			<h3><?=$pack_row['wr_subject'];?></h3>
			<ul>
				<li class="box-info1 cf">
					<p><?=@implode(" + ", $_service);?></p>
				</li>
				<li class="box-info2 cf">
					<ul>
					  <li>=</li>
						<li class="item_info4"><?=number_format($pack_row['wr_price']);?>원</li>
					</ul>
				</li>
			</ul>
		</div>
		<?php }?>
	</article>
<?php
}?>

<article>
		<h2><span>서비스 상품</span></h2>
		<?php
		if(is_array($service_control->service_lists)) { foreach($service_control->service_lists as $k=>$v) {
			$service_key = $_GET['code']=='individual' ? 'alba_resume_' : 'main_';
			if($k!='main' && !$_GET['code']) continue;
			if($k!='alba_resume' && $_GET['code']=='individual') continue;

			if(is_array($v)) { foreach($v as $k2=>$v2) {
				$__service_key = $service_key.$k2;
				$__content_key = $__service_key;
				if(!@array_key_exists($__service_key.'_content', $design)) $__content_key = 'main_'.$k2;
				if($service_key=='alba_resume_' && $k2=='basic') $__content_key = 'main_rbasic';
				$service_list = $service_control->__ServiceList($service_key.$k2);
				$_content = $design[$__content_key.'_content'];
				//$service_gold_list = $service_control->__ServiceList($type."_gold");
				//$service_logo_list = $service_control->__ServiceList($type."_logo");

				$alba_option = $service_control->service_check($service_key.$k2);	// 알바 급구 옵션
				if(!$alba_option['is_pay']) continue;
		?>
		<div class="item_box cf">
			<h3><?=$v2['name'];?> <?=$_GET['code']=='individual' ? '' : '구인정보';?></h3>
			<ul>
				<li class="box-info1 cf">
	<p>
<?=stripslashes($_content);?>
  </p>
				</li>
				<?php
				if(is_array($service_list)) {
					foreach($service_list as $val){
						$_sale_price = $netfu_util->sale_price($val['service_percent'], $val['service_price']);
				?>
				<li class="box-info2 cf">
					<ul>
						<li class="item_info1">오늘+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></li>
						<li class="item_info2"><?php if($val['service_price']>0 && $val['service_percent']>0) echo $val['service_price'];?><li>
						<li class="item_info3"><?php if($val['service_percent']>0) {?>(<em><?=$val['service_percent'];?>%↓</em>)<?php }?></li>
						<li class="item_info4"><?=$_sale_price>0 ? number_format($_sale_price).'원' : '무료';?></li>
					</ul>
				</li>
				<?php
					}
				}
				?>
			</ul>
		</div>
		<?php
			} }
		} }
		?>


<?php
$service_key = $_GET['code']=='individual' ? 'resume_option' : 'alba_option';
$option_service_arr = $service_control->service_lists[$service_key];
$option_array = array(
	'busy'=>array('name'=>'급구', 'option'=>array('busy')),
	'strong'=>array('name'=>'강조옵션', 'option'=>array('neon', 'bold', 'icon', 'color', 'blink')),
	'jump'=>array('name'=>'점프', 'option'=>array('jump')),
	'open'=>array('name'=>($service_key=='resume_option' ? '채용정보 열람' : '이력서 열람'), 'option'=>array('open')),
	//'sms'=>array('name'=>'SMS충전', 'option'=>array('sms')),
);
if(is_array($option_array)) { foreach($option_array as $k=>$v) {

	$option_array_tag[$k] = 0;
	ob_start();
?>
<article>
		<h2><span><?=$v['name'];?> 서비스</span></h2>

		<?php
		if(is_array($v['option'])) { foreach($v['option'] as $k2=>$v2) {
			$_part = in_array($v2, array('open', 'sms', 'alba')) ? 'etc' : $service_key;

			// : 이력서 열람, SMS 충전
			if(in_array($k, array('open', 'sms', 'alba'))) {
				if($k=='open') $__service_key = 'etc_'.($service_key=='alba_option' ? 'open' : 'alba');
				else $__service_key = 'etc_'.$k;
				$__content_key = $__service_key;
				if(in_array($k, array('open'))) $__content_key = ($service_key=='alba_option' ? 'resume' : 'alba').'_'.$k;
				if(in_array($k, array('sms'))) $__content_key = $service_key=='alba_option' ? 'etc_alba_sms' : 'etc_resume_sms';
				$service_option_array = $service_control->service_check($__service_key);	// 알바 급구 옵션
				$service_list = $service_control->__ServiceList($service_option_array['service']);	// 알바 급구 서비스 리스트

			// : 그외
			} else {
				$__service_key = $service_key.'_'.$v2;
				if(in_array($k, array('busy'))) $__content_key = 'main_'.$k;
				if(in_array($k, array('jump'))) $__content_key = preg_replace("/_option/", "", $service_key).'_'.$k;
				$service_option_array = $service_control->service_check($__service_key);	// 알바 급구 옵션
				$service_list = $service_control->__ServiceList($service_option_array['service']);	// 알바 급구 서비스 리스트
			}

			if(!$service_option_array['is_pay']) continue;
			$option_array_tag[$k]++;

			if(@array_key_exists($__content_key.'_content', $design)) $_content = $design[$__content_key.'_content'];
			else $_content = $netfu_payment->option_se_content[$v2];
			// : 옵션파트
			if($v2=='neon')
				$_option_arr = explode("/",$service_option_array['neon_color']);	 // 색상
			else if($v2=='icon')
				$_option_arr = $category_control->category_codeList($service_option_array['service']);
			else if($v2=='color')
				$_option_arr = explode("/",$service_option_array['font_color']);	// 색상

			// : 선택형 옵션 존재여부
			$_part_option = @count($_option_arr)>0 ? 'part_option' : '';
		?>
		<div class="item_box cf">
			<h3><?=$option_service_arr[$v2]['name'];?></h3>
			<ul>
				<li class="box-info1 cf">
	<p>
<?=stripslashes($_content);?>
  </p>
				</li>

				<li class="box-info1 cf <?=$_part_option;?>">
					<?php
					if(@count($_option_arr)>0) { foreach($_option_arr as $k3=>$v3) {
						$_val = $v2=='icon' ? $v3['no'] : $v3;
					?>
					<label onClick="$('#check_<?=$v2;?>_<?=$_val;?>')[0].click()">
					<?php


					// : 강조효과 파트정보 ##############
						switch($v2) {
							case 'icon':
					?>
					<img src="<?=NFE_URL;?>/data/icon/<?=$v3['name'];?>" alt="아이콘<?=$k3;?>"></label>
					<?php
								break;

							case 'color':
					?>
					<em style="color:#<?=$v3;?>;">글자색</em>
					<?php
								break;

							case 'neon':
					?>
					<em style="color:#fff; background:#<?=$v3;?>;">형광펜</em>
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

				<?php
				if(is_array($service_list)) {
					foreach($service_list as $val){
						$_sale_price = $netfu_util->sale_price($val['service_percent'], $val['service_price']);
						$_txt = $val['etc_3'] ? number_format($val['etc_3']).'건' : '오늘+'.$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);
				?>
				<li class="box-info2 cf">
					<ul>
						<li class="item_info1"><?=$_txt;?></li>
						<li class="item_info2"><?php if($val['service_price']>0 && $val['service_percent']>0) echo number_format($val['service_price']);?><li>
						<li class="item_info3"><?php if($val['service_percent']>0) {?>(<em><?=$val['service_percent'];?>%↓</em>)<?php }?></li>
						<li class="item_info4"><?=$_sale_price>0 ? number_format($_sale_price).'원' : '무료';?></li>
					</ul>
				</li>
				<?php
					}
				}
				?>
			</ul>
		</div>
		<?php } }?>
	</article>
<?php
	$result = ob_get_clean();

	if($option_array_tag[$k]>0) echo $result;
} }



if(!$member['mb_id']) $_move = NFE_URL.'/include/login.php';
else {
	if($_GET['code']=='individual') $_move = NFE_URL.'/mypage/resume_write.php';
	else $_move = NFE_URL.'/mypage/job_write.php';
}
?>

<div class="ad_bt_wrap">
  <a href="<?=$_move;?>" class="ad_btn">광고신청하기</a>
</div>

</section>

<?php
$_banner = 'etc_service_bottom';
include NFE_PATH.'/include/inc/banner.inc.php';




include_once(NFE_PATH.'/include/tail.php');
?>