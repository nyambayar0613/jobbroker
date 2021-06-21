<?php
$menu_code = "payment_guide";
include_once "../include/top.php";

$pack_query = sql_query("select * from `alice_payment_package` where `wr_type` = 'employ' order by `wr_rank` asc");
?>
<section class="item_con guide_con">

	<article>
		<h2><span>Package бүтээгдэхүүн</span></h2>
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
			<h3><?=$pack_row['wr_subject'];?></h3>
			<ul>
				<li class="box-info1 cf">
					<p>Main Platy<?=@implode(" + ", $_service);?></p>
				</li>
				<li class="box-info2 cf">
					<ul>
					  <li>=</li>
						<li class="item_info4"><?=number_format($pack_row['wr_price']);?>төгрөг</li>
					</ul>
				</li>
			</ul>
		</div>
		<?php }?>
	</article>

<article>
		<h2><span>Үйлчилгээ бүтээгдэхүүн</span></h2>
		<?php
		if(is_array($service_control->service_lists)) { foreach($service_control->service_lists as $k=>$v) {
			if($k!='main') continue;
			if(is_array($v)) { foreach($v as $k2=>$v2) {
				$service_list = $service_control->__ServiceList('main_'.$k2);
				//$service_gold_list = $service_control->__ServiceList($type."_gold");
				//$service_logo_list = $service_control->__ServiceList($type."_logo");
		?>
		<div class="item_box cf">
			<h3><?=$v2['name'];?> Ажлын мэдээлэл</h3>
			<ul>
				<li class="box-info1 cf">
	<p>
        Ажлын байрны үндсэн хуудасны дээд хэсэгт<br>
<span>- Ерөнхий жагсаалтад үнэгүй бүртгүүлэх</span>
  </p>
				</li>
				<?php
				if(is_array($service_list)) {
					foreach($service_list as $val){
						$price_row = $netfu_payment->get_price('', $val['no']);
				?>
				<li class="box-info2 cf">
					<ul>
						<li class="item_info1">오늘+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></li>
						<?php
						if($price_row['_sale']>0) {
						?>
						<li class="item_info2"><?=number_format($price_row['_price']);?><li>
						<li class="item_info3">(<em><?=$price_row['_sale'];?>%↓</em>)</li>
						<?php }?>
						<li class="item_info4"><?=number_format($price_row['_sale_price']);?>төгрөг</li>
					</ul>
				</li>
				<?php }
				}?>
			</ul>
		</div>
		<?php
			} }
		} }
		?>
	</article>


<?php
### : 구인정보 서비스
$option_service_arr = $service_control->service_lists['alba_option'];
$option_array = array(
    'busy'=>array('name'=>'Яаралтай', 'option'=>array('busy')),
    'strong'=>array('name'=>'Highlight option', 'option'=>array('neon', 'bold', 'icon', 'color', 'blink')),
    'jump'=>array('name'=>'Jump', 'option'=>array('jump')),
    'open'=>array('name'=>'Анкет үзэх', 'option'=>array('open')),
    'sms'=>array('name'=>'SMS цэнэглэх', 'option'=>array('sms')),
);
if(is_array($option_array)) { foreach($option_array as $k=>$v) {
?>
<article>
    <h2><span><?=$v['name'];?> Үйлчилгээ</span></h2>
	<?php
	if(is_array($v['option'])) { foreach($v['option'] as $k2=>$v2) {
		$_part = in_array($v2, array('open', 'sms')) ? 'etc' : 'alba_option';

		// : 이력서 열람, SMS 충전
		$service_list = array();
		if(in_array($k, array('open', 'sms'))) {
			$alba_option = $service_control->service_check('etc_'.$k);	// 알바 급구 옵션
			$service_list = $service_control->__ServiceList($alba_option['service']);	// 알바 급구 서비스 리스트

		// : 그외
		} else {
			$alba_option = $service_control->service_check('alba_option_'.$v2);	// 알바 급구 옵션
			$service_list = $service_control->__ServiceList($alba_option['service']);	// 알바 급구 서비스 리스트
		}
	?>
	<div class="item_box cf">
		<h3><?=$option_service_arr[$v2]['name'] ? $option_service_arr[$v2]['name'] : $v['name'].' 서비스';?></h3>
		<ul>
			<li class="box-info1 cf">
				<p>
				Ажлын байрны сайтын яаралтай хэсэг ил харагдана<br>
				<span>- Яаралтай хэсэг ил харагдаж айкон тодорно</span><br>
				<span>- Ерөнхий жагсаалтад үнэгүй бүртгүүлнэ</span>
				</p>
			</li>
			<?php
			if(is_array($service_list)) {
				foreach($service_list as $val){ 
					$price_row = $netfu_payment->get_price('', $val['no']);
			?>
			<li class="box-info2 cf">
				<ul>
					<li class="item_info1">Өнөөдөр+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></li>
					<?php
					if($price_row['_sale']>0) {
					?>
					<li class="item_info2"><?=number_format($price_row['_price']);?><li>
					<li class="item_info3">(<em><?=$price_row['_sale'];?>%↓</em>)</li>
					<?php }?>
					<li class="item_info4"><?=number_format($price_row['_sale_price']);?>төгрөг</li>
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
} }
?>
</section>

<?php
include "../include/tail.php";
?>