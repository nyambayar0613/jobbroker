<?php
#####################################################################
/*
기타옵션 효과 모음
// : 열람
*/
#####################################################################
if($_POST['mode']=='jump_payment') return false;

$_checkbox_is = (in_array($_POST['mode'], array('job_payment', 'resume_payment'))) ? true : false;
$op_nos = @implode(",", $_service_no_arr['etc']);
if($member['mb_type']=='individual') unset($netfu_payment->etc_se_arr['open']); // : 개인은 이력서열람 변수 없애기
if($member['mb_type']=='company') unset($netfu_payment->etc_se_arr['alba']); // : 기업은 채용열람 변수 없애기

if(is_array($netfu_payment->etc_se_arr)) { foreach($netfu_payment->etc_se_arr as $k=>$v) {

	if(!$op_nos) continue;
	$chk_is = sql_fetch("select * from `alice_service` where `no` in (".$op_nos.") and `type`='etc_".$k."'");

	// : 채용,인재가 아닌 독립적 결제인경우에 실행. - 해당결제가 아닌경우 넘어가기.
	$type_arr = explode("etc_", $chk_is['type']);
	if(!in_array($_POST['mode'], array('job_payment', 'resume_payment')) && $type_arr[1]!=$k) continue;

	$alba_option = $service_control->service_check('etc_'.$k);	// 알바 급구 옵션
	$service_list = $service_control->__ServiceList($alba_option['service']);	// 알바 급구 서비스 리스트
?>
<li class="service_item cf">
	<table class="search_tb">
		<tr>
			<th class="sch_hd"><div><?=$v;?> 서비스</div><div class="info-txt"></div></th>
		</tr>
	</table>
	<ul>
		<li class="item_inner add_item cf item_box service_li">
			<table class="search_tb">
				<tr>
					<th class="sch_hd">
						<div><label class="svc_tit"><?php if($_checkbox_is) {?><input type="checkbox" name="" <?=$chk_is ? 'checked' : '';?> onClick="netfu_payment.use_service_check(this)"><?php }?><?=$v;?><br><span>(<?=$v;?> 강조 효과)</span></label></div>
					</th>
					<td class="option_view_c sch_td1 <?=$chk_is ? '' : '_none';?>">
						<select class="select_service _service_tag" name="service[]" onChange="netfu_payment.money_click(this)" style="width:100%">
							<option value="">선택</option>
							<?php
							if(is_array($service_list)) {
								foreach($service_list as $val){ 
									$_val = 'etc/'.$val['no'];
									$selected = @in_array($_val, $_POST['service']) ? 'selected' : '';
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
			<div class="option_view_c select_result box-info2 cf <?=$chk_is ? '' : '_none';?>">
				<ul class="result_inner">
					<li class="srv_info service_info1">오늘+<?=$netfu_util->date_txt($chk_is['service_cnt'].$chk_is['service_unit']);?></li>
					<li class="srv_info service_info2"><?=number_format($chk_is['service_price']);?>원</li>
					<li class="srv_info service_info3">(<em><?=$chk_is['service_percent'];?>%</em>)</li>
					<li class="srv_info service_info4"><?=number_format($netfu_util->sale_price($chk_is['service_percent'], $chk_is['service_price']));?>원</li>
				</ul>
			</div>
		</li>
	</ul>
</li>
<?php
} }?>