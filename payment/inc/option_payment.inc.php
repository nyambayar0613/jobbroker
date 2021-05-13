<?php
$_option_num = 0;
if(is_array($_POST['service'])) { foreach($_POST['service'] as $k=>$v) {
	$_se_arr = explode("/", $v);
	if(strpos($_se_arr[0], 'option')!==false) $_option_num++;
} }

// : 이전에 1개이상 체크해야 나옴.
if($_option_num<=0) return false;

#####################################################################
/*
강조옵션 효과 모음
*/
#####################################################################
// : 개인은 resume_payment, 기업은 job_payment
$_checkbox_is = (in_array($_POST['mode'], array('job_payment', 'resume_payment', 'jump_payment'))) ? true : false;

// : 개인은 resume_option, 기업은 alba_option
$option_key = $member['mb_type']=='individual' ? 'resume_option' : 'alba_option';
if(!$_checkbox_is) return false;
if(in_array($_POST['mode'], array('jump_payment'))) $_checkbox_is = false;
$_mode_arr = explode("_", $_POST['mode']);
?>
<li class="service_item cf">
	<table class="search_tb">
		<tr>
			<th class="sch_hd">
				<?php
				if($_checkbox_is===true) {
				?>
				<div>강조옵션</div><div class="info-txt">(로고형/배너형/박스형/줄광고와 일반채용정보 리스트 모두 적용)</div>
				<?php } else {?>
				<div><?=$netfu_payment->etc_payment_arr[$_mode_arr[0]];?> 서비스</div><div class="info-txt"></div>
				<?php }?>
			</th>
		</tr>
	</table>
	<ul>
	<?php
	$op_nos = @implode(",", $_service_no_arr[$option_key]);
	if(is_array($netfu_payment->option_se_arr)) { foreach($netfu_payment->option_se_arr as $k=>$v) {

		$chk_is = false;
		if(!$op_nos) continue;

		$chk_is = sql_fetch("select * from `alice_service` where `no` in (".$op_nos.") and `type`='".$option_key."_".$k."'");

		// : 채용,인재가 아닌 독립적 결제인경우에 실행. - 해당결제가 아닌경우 넘어가기.
		$type_arr = explode($option_key."_", $chk_is['type']);

		// : 채용,기업 결제가 아니면 사용안함.
		if(!in_array($_POST['mode'], array('job_payment', 'resume_payment')) && $type_arr[1]!=$k) continue;

		$alba_option = $service_control->service_check($option_key.'_'.$k);	// 알바 급구 옵션
		if(!$alba_option['is_pay']) continue;
		$service_list = $service_control->__ServiceList($alba_option['service']);	// 알바 급구 서비스 리스트

		// : 옵션파트
		$_option_arr = array();
		if($k=='neon')
			$_option_arr = explode("/",$alba_option['neon_color']);	 // 색상
		else if($k=='icon')
			$_option_arr = $category_control->category_codeList($alba_option['service']);
		else if($k=='color')
			$_option_arr = explode("/",$alba_option['font_color']);	// 색상

		// : 선택형 옵션 존재여부
		$_part_option = @count($_option_arr)>0 ? 'part_option' : '';
	?>
	<li class="item_inner add_item cf item_box service_li">
		<table class="search_tb">
			<tr>
				<th class="sch_hd">
					<div><label class="svc_tit"><?php if($_checkbox_is) {?><input type="checkbox" <?=$chk_is ? 'checked' : '';?> onClick="netfu_payment.use_service_check(this)" value="<?=$option_key.'_'.$k;?>"><?php }?><?=$v;?><br><span>(<?=$v;?> 강조 효과)</span></label></div><div class="sname" style="display:none;"><?=$v;?></div>
				</th>
				<td class="option_view_c sch_td1 <?=$chk_is ? '' : '_none';?>">
					<select class="<?=$_part_option;?> select_service _service_tag" name="service[]" onChange="netfu_payment.money_click(this)" style="width:100%">
						<option value="">선택</option>
						<?php
						if(is_array($service_list)) {
							foreach($service_list as $val){ 
								$_val = $option_key.'/'.$val['no'];
								$selected = @in_array($_val, $_POST['service']) ? 'selected' : '';

								if($val['etc_3']) $_txt = $val['etc_3'].'건';
								else $_txt = '오늘+'.$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);
						?>
						<option value="<?=$_val;?>" <?=$selected;?>><?=$_txt;?></option>
						<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
		</table>
		<ul class="option_view_c service_icon <?=$chk_is ? '' : '_none';?>">
			<li class="box-info1 cf <?=$_part_option;?>">
				<fieldset>
					<legend><?=$v;?></legend>
					
						<?php
						if(@count($_option_arr)>0) { foreach($_option_arr as $k3=>$v3) {
							$_val = $k=='icon' ? $v3['no'] : $v3;
							$_checked = $_val==$_POST['service_opt'][$k] ? 'checked' : '';
						?>
						<span onClick="$('#check_<?=$k;?>_<?=$_val;?>')[0].click()" style="cursor:pointer;margin-right:10px;"><input type="radio" name="service_opt[<?=$k;?>]" value="<?=$_val;?>" id="check_<?=$k;?>_<?=$_val;?>" <?=$_checked;?>><?php


						// : 강조효과 파트정보 ##############
							switch($k) {
								case 'icon':
						?>
						<img src="<?=NFE_URL;?>/data/icon/<?=$v3['name'];?>" alt="아이콘<?=$k3;?>">
						<?php
									break;

								case 'color':
						?><em style="color:#<?=$v3;?>;">글자색</em><?php
									break;

								case 'neon':
						?>
						<em style="color:#fff; background:#<?=$v3;?>;">형광펜</em>
						<?php
									break;
							}
						// : 강조효과 파트정보 ##############
						?>
						</span>
						<?php
						} }
						?>
					
				</fieldset>
			</li>
		</ul>
		<div class="option_view_c select_result box-info2 cf <?=$chk_is ? '' : '_none';?>">
			<ul class="result_inner">
				<li class="srv_info service_info1">오늘+<?=$netfu_util->date_txt($chk_is['service_cnt'].$chk_is['service_unit']);?></li>
				<li class="srv_info service_info2"><?=number_format($chk_is['service_price']);?>원</li>
				<li class="srv_info service_info3">(<em><?=$chk_is['service_percent'];?>%</em>)</li>
				<li class="srv_info service_info4"><?=number_format($netfu_util->sale_price($chk_is['service_percent'], $chk_is['service_price']));?>원</li>
			</ul>
		</div>
	</li>
	<?php
	} }
	?>
	</ul>
</li>