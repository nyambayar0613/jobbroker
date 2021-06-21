<style type="text/css">
.service_c_ { display:none; }
</style>
<?php
$pack_key = $member['mb_type']=='individual' ? 'alba_resume' : 'main';

if(@in_array($pack_key, $_use_service['code'])) {
if(is_array($_POST['service'])) { foreach($_POST['service'] as $k=>$v) {
	if(!$v) continue;
	$_arr = explode("/", $v);
	if(in_array($_arr[0], array('package', 'alba_option', 'resume_option', 'etc'))) continue;

	// : 가격값
	$price_row = $netfu_payment->get_price($_arr[0], $_arr[1]);

	// : gold, logo 사용여부 체크
	$service_lists_arr = $service_control->service_lists[$_arr[0]][$price_row['_service_txt_arr'][1]];

	$_type = $_arr[0].'_'.$price_row['_service_txt_arr'][1];
	$_type2 = $price_row['_service_txt_arr'][1].'_'.$_arr[0];
	$service_list = $service_control->__ServiceList($_type);
	$service_gold_list = $service_control->__ServiceList($_type."_gold");
	$service_logo_list = $service_control->__ServiceList($_type."_logo");

	$service_option = $service_control->service_check($_type); // 알바 급구 옵션
	$service_option_gold = $service_control->service_check($_type.'_gold'); // 알바 급구 옵션
	$service_option_logo = $service_control->service_check($_type.'_logo'); // 알바 급구 옵션
	if(!$service_option['is_pay']) continue; // : 사용여부

	$_selected_val = '';
?>
		<li class="service_item cf">
			<ul>
				<li class="item_inner cf item_box">
					<table class="search_tb">
						<tr>
							<th class="sch_hd">
								<div><?=$price_row['_subject'];?></div>
								<div class="info-txt">(Хуудасны дээд хэсэг)</div>
							</th>
							<td class="sch_td1">
								<select class="_service_tag" name="service[]" onChange="netfu_payment.money_click(this)">
									<option value="">Сонгох</option>
									<?php
									if(is_array($service_list)) {
										foreach($service_list as $val){ 
											$_val = $_arr[0].'/'.$val['no'];
											$selected = @in_array($_val, $_POST['service']) ? 'selected' : '';
											if($selected=='selected') $_selected_val = $val;
									?>
									<option value="<?=$_val;?>" <?=$selected;?>>오늘+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></option>
									<?php
										}
									}
									?>
								</select>
							</td>
						</tr>
					</table>
					<?php
					$_date = $val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $_selected_val['service_unit']);
					?>
					<div class="select_result cf">
						<ul class="result_inner">
							<li class="srv_info service_info1">Өнөөдөр+<?=$_date;?></li>
							<li class="srv_info service_info2"><?=$_selected_val['service_price'];?> төгрөг</li>
							<li class="srv_info service_info3">(<em><?=$_selected_val['service_percent'];?>%↓</em>)</li>
							<li class="srv_info service_info4"><?=$netfu_util->sale_price($_selected_val['service_percent'], $_selected_val['service_price']);?>төгрөг</li>
						</ul>
					</div>
				</li>

				<?php
				// : 골드를 사용하는경우
				if($service_lists_arr['is_gold'] && $service_option_gold['is_pay']) {
				?>
				<li class="item_inner add_item cf item_box service_li_">
					<table class="search_tb">
						<tr>
							<th class="sch_hd">
								<div><label for="service_gold_<?=$k;?>" style="width:100%;float:none"><input type="checkbox" name="service_gold[<?=$k;?>]" id="service_gold_<?=$k;?>" value="<?=$_type2;?>_gold" onClick="netfu_payment.gold_check(this, '<?=$k;?>')">Gols<br><span>(Background color emphasis)</span></label></div>
							</th>
							<td class="sch_td1 service_c_">
								<div class="item_gold"><img src="<?=NFE_URL;?>/images/icon/gold.gif" alt="Gold"></div>
								<select class="select_service _service_tag" name="service[]" onChange="netfu_payment.money_click(this, 'gold')" put_tag="<?=$_type."_gold";?>">
									<option value="">Сонгох</option>
									<?php
									if(is_array($service_gold_list)) {
										foreach($service_gold_list as $val){ 
											$_val = $_arr[0].'/'.$val['no'];
											$selected = @in_array($_val, $_POST['service']) ? 'selected' : '';
									?>
									<option value="<?=$_val;?>" <?=$selected;?>>Өнөөдөр+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></option>
									<?php
										}
									}
									?>
								</select>
							</td>
						</tr>
					</table>
					<div class="select_result cf box-info2 service_c_" style="visibility:hidden;">
						<ul class="result_inner">
							<li class="srv_info service_info1">1 сар</li>
							<li class="srv_info service_info2">40,000 төгрөг</li>
							<li class="srv_info service_info3">(<em>10%</em>)</li>
							<li class="srv_info service_info4">36,000 төгрөг</li>
						</ul>
					</div>
				</li>
				<?php }?>


				<?php
				// : 로고를 사용하는 경우
				if($service_lists_arr['is_logo'] && $service_option_logo['is_pay']) {
				?>

				<li class="item_inner add_item cf item_box service_li_">
					<table class="search_tb">
						<tr>
							<th class="sch_hd">
								<div><label for="service_logo_<?=$k;?>" style="width:100%;float:none"><input type="checkbox" name="service_logo[<?=$k;?>]" id="service_logo_<?=$k;?>" value="<?=$_type2;?>_logo" onClick="netfu_payment.logo_check(this, '<?=$k;?>')">Logo highlight<br><span>(Хөдөлдөг лого)</span></label></div>
							</th>
							<td class="sch_td1 service_c_">
								<ol>
									<li><label for="type1"><input type="radio" name="logo_m[<?=$k;?>]" value="0" checked="checked"><img src="<?=NFE_URL;?>/images/icon/img_aniLogo1.gif"></label></li>
									<li><label for="type1"><input type="radio" name="logo_m[<?=$k;?>]" value="1"><img src="<?=NFE_URL;?>/images/icon/img_aniLogo2.gif"></label></li>
									<li style="display:inline"><label for="type1"><input type="radio" name="logo_m[<?=$k;?>]" value="2" style=""><span class="slide_image" style="display:inline-block;"><img src="<?=NFE_URL;?>/images/icon/img_aniLogo3.gif" align="absmiddle"><img src="<?=NFE_URL;?>/images/icon/img_aniLogo3.gif" align="absmiddle"></span></label></li>
								</ol>
								<select class="select_service _service_tag" name="service[]" onChange="netfu_payment.money_click(this, 'logo')" style="width:100%" put_tag="<?=$_type."_logo";?>">
									<option value="">Сонгох</option>
									<?php
									if(is_array($service_logo_list)) {
										foreach($service_logo_list as $val){ 
											$_val = $_arr[0].'/'.$val['no'];
											$selected = @in_array($_val, $_POST['service']) ? 'selected' : '';
									?>
									<option value="<?=$_val;?>" <?=$selected;?>>Өнөөдөр+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></option>
									<?php
										}
									}
									?>
								</select>
							</td>
						</tr>
					</table>
					<div class="select_result cf box-info2 service_c_" style="visibility:hidden;">
						<ul class="result_inner">
							<li class="srv_info service_info1">1 сар</li>
							<li class="srv_info service_info2">40,000 төгрөг</li>
							<li class="srv_info service_info3">(<em>10%</em>)</li>
							<li class="srv_info service_info4">36,000 төгрөг</li>
						</ul>
					</div>
				</li>

				<?php }?>

			</ul>
		</li>
<?php
} }
}
?>