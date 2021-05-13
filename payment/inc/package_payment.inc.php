<?php
$package_row = $netfu_payment->get_price('package', $_use_service['package_no']);
$pack_key = $member['mb_type']=='individual' ? 'individual' : 'employ';

// : 패키지
if($package_row['wr_content']) {
	$wr_content = unserialize($package_row['wr_content']);
	$pack_service = array();
	foreach($wr_content as $key => $content){
		if($content['use']) {
			$service_name = $service_control->package_service[$pack_key][$key];
			if($service_name){
				$pack_service[] =array('name'=>$service_name, 'date'=>number_format($content['service_count'])." ".$service_control->_unit($content['service_unit']));
			}
		}
	}
}

if(@in_array('package', $_use_service['code'])) {
?>
<li class="service_item cf">
	<div class="item_tit cf"><?=$package_row['wr_subject'];?></div>
	<div class="cf">
		<table class="search_tb_bx">
			<?php
			if(is_array($pack_service)) { foreach($pack_service as $k=>$v) {
			?>
			<tr><th><?=$v['name'];?></th><td>오늘+<?=$v['date'];?></td></tr>
			<?php
			} }
			?>
			<tr><td colspan="2"><em>패키지 금액 : </em><span><?=number_format($package_row['wr_price']);?>원</span></td></tr>
		</table>
	</div>
	<input type="hidden" name="service[]" value="package/<?=$_service_no_arr['package'][0];?>" /><?=$pack_row['wr_subject'];?>
</li>
<?php }?>