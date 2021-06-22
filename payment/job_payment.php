<?php
$page_code = 'mypage';
$head_title = $menu_text = "Байгууллагын үйлчилгээний хүсэлт гаргах";
include_once "../include/top.php";

if($_GET['_part']) $_part_txt = preg_replace(array("/_gold/", "/_logo/"), array("", ""), $_GET['_part']);

$pack_query = sql_query("select * from `alice_payment_package` where `wr_type` = 'employ' and `wr_use`=1 order by `wr_rank` asc");
$pack_length = mysql_num_rows($pack_query);
?>
<style type="text/css">
._option_service_article._none { display:none; }
</style>
<script type="text/javascript" src="<?=NFE_URL;?>/_helpers/_js/payment.class.js?time=<?=time();?>"></script>
<!-- 서비스 신청 -->
<form name="fpayment" action="./job_order.php" method="post">
<input type="hidden" name="mode" value="job_payment" />
<input type="hidden" name="info_no" value="<?=$_GET['no'];?>" />
<input type="hidden" name="pay_type" value="alba" />
<section class="item_con">

<?php
### : 구인정보 패키지 서비스
if(!$_part_txt && $pack_length>0) {
?>
	<article>
		<h2><span>패키지상품</span></h2>
		<?php
		while($pack_row=sql_fetch_array($pack_query)) {
			$wr_content = unserialize($pack_row['wr_content']);
			$_service = array();
			foreach($wr_content as $key => $content){
				if($content['use']) {
					$service_name = $service_control->package_service['employ'][$key];
					if($service_name){
						$_service[] =$service_name." ".number_format($content['service_count'])." ".$service_control->_unit($content['service_unit']);
					}
				}
			}
		?>
		<div class="item_box cf">
			<h3><input type="checkbox" class="_service_tag" name="service[]" value="package/<?=$pack_row['no'];?>" onClick="netfu_util1.checkbox_one(this)" /><?=$pack_row['wr_subject'];?></h3>
			<ul>
				<li class="box-info1 cf">
					<p><?=@implode(" + ", $_service);?></p>
				</li>
				<li class="box-info2 cf">
					<ul>
					  <li>=</li>
						<li class="item_info4"><?=number_format($pack_row['wr_price']);?>Төгрөг</li>
					</ul>
				</li>
				<li class="box-btn">
					<a href="#none;" onClick="netfu_payment.order_move('fpayment', this)">Хүсэлт гаргах<img src="<?=NFE_URL;?>/images/chevron3.png" alt="Хүсэлт гаргах"></a>
				</li>
			</ul>
		</div>
		<?php }?>
	</article>
<?php }?>





<?php
ob_start();
if(is_array($service_control->service_lists)) { foreach($service_control->service_lists as $k=>$v) {
	if($k!='main') continue;
	if(is_array($v)) { foreach($v as $k2=>$v2) {

		if($_part_txt && $_part_txt!=$k2) continue; // : 각각의 서비스신청을 누른경우

		$__content_key = 'main_'.$k2;
		$_content = $design[$__content_key.'_content'];

		$service_list = $service_control->__ServiceList('main_'.$k2);
		$service_check = $service_control->service_check($__content_key);

		if(!$service_check['is_pay']) continue;

		//$service_gold_list = $service_control->__ServiceList($type."_gold");
		//$service_logo_list = $service_control->__ServiceList($type."_logo");
?>
<div class="item_box cf">
	<h3><?=$v2['name'];?> 구인정보</h3>
	<ul>
		<li class="box-info1 cf">
			<p>
			<?=stripslashes($_content);?>
			</p>
		</li>
		<li class="box-tit cf">
			<select class="_service_tag" name="service[]" onChange="netfu_payment.money_click(this)">
				<option value="">Сонгох</option>
				<?php
				if(is_array($service_list)) {
					foreach($service_list as $val){ 
				?>
				<option value="main/<?=$val['no'];?>">Өнөөдөр+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></option>
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
		<h2><span>Main/Ажлын зар</span></h2>

		<?php
		echo $_tag
		?>

	</article>
<?php
}




### : 구인정보 서비스
$option_service_arr = $service_control->service_lists['alba_option'];
$option_array = array(
	'busy'=>array('name'=>'급구', 'option'=>array('busy')),
	'strong'=>array('name'=>'강조옵션', 'option'=>array('neon', 'bold', 'icon', 'color', 'blink')),
	'jump'=>array('name'=>'점프', 'option'=>array('jump')),
	'open'=>array('name'=>'이력서 열람', 'option'=>array('open')),
	//'sms'=>array('name'=>'SMS충전', 'option'=>array('sms')),
);
if(is_array($option_array)) { foreach($option_array as $k=>$v) {

	$option_array_tag[$k] = 0;
	ob_start();
?>
<article class="_option_service_article">
		<h2><span><?=$v['name'];?> Үйлчилгээ</span></h2>
		<?php
		if(is_array($v['option'])) { foreach($v['option'] as $k2=>$v2) {
			if($_part_txt && $_part_txt!=$v2) continue; // : 각각의 서비스신청을 누른경우

			$_part = in_array($v2, array('open', 'sms')) ? 'etc' : 'alba_option';

			// : 이력서 열람, SMS 충전
			if(in_array($k, array('open', 'sms'))) {
				$__service_key = 'etc_'.$k;
				$__content_key = $__service_key;
				if(in_array($k, array('open'))) $__content_key = 'resume_'.$k;
				if(in_array($k, array('sms'))) $__content_key = 'etc_alba_sms';
				$alba_option = $service_control->service_check($__service_key);	// 알바 급구 옵션
				$service_list = $service_control->__ServiceList($alba_option['service']);	// 알바 급구 서비스 리스트

			// : 그외
			} else {
				$__service_key = 'alba_option_'.$v2;
				$__content_key = $__service_key;
				if(in_array($k, array('busy'))) $__content_key = 'main_'.$k;
				if(in_array($k, array('jump'))) $__content_key = preg_replace("/_option/", "", 'alba_option').'_'.$k;
				$alba_option = $service_control->service_check($__service_key);	// 알바 급구 옵션
				$service_list = $service_control->__ServiceList($alba_option['service']);	// 알바 급구 서비스 리스트
			}

			if(!$alba_option['is_pay']) continue;
			$option_array_tag[$k]++;

			if(@array_key_exists($__content_key.'_content', $design)) $_content = $design[$__content_key.'_content'];
			else $_content = $netfu_payment->option_se_content[$v2];

			$_option_arr = array();

			// : 옵션파트
			if($v2=='neon')
				$_option_arr = explode("/",$alba_option['neon_color']);	 // 색상
			else if($v2=='icon')
				$_option_arr = $category_control->category_codeList($alba_option['service']);
			else if($v2=='color')
				$_option_arr = explode("/",$alba_option['font_color']);	// 색상

			// : 선택형 옵션 존재여부
			$_part_option = @count($_option_arr)>0 ? 'part_option' : '';
		?>
		<div class="item_box cf">
			<h3 class="sname"><?=$option_service_arr[$v2]['name'];?></h3>
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
				<li class="box-tit cf">
					<?php
					############# 금액값 ############
					?>
					<select class="<?=$_part_option;?>" name="service[]" onChange="netfu_payment.money_click(this)">
						<option value="">Сонгох</option>
						<?php
						if(is_array($service_list)) {
							foreach($service_list as $val){
								$_txt = $val['etc_3'] ? number_format($val['etc_3']).'건' : '오늘+'.$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);
						?>
						<option value="<?=$_part;?>/<?=$val['no'];?>"><?=$_txt;?></option>
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
						<li class="service_info1 item_info1"></li>
						<li class="service_info2 item_info2"><li>
						<li class="service_info3 item_info3"></li>
						<li class="service_info4 item_info4"></li>
					</ul>
				</li>
				<li class="box-btn">
					<a href="#none;" onClick="netfu_payment.order_move('fpayment', this)">Хүсэлт гаргах<img src="<?=NFE_URL;?>/images/chevron3.png" alt="Хүсэлт гаргах"></a>
				</li>
			</ul>
		</div>
		<?php } }?>
	</article>
<?php
		$result = ob_get_clean();
		if($option_array_tag[$k]>0) echo $result;
	}
}?>

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