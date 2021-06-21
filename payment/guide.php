<?php
$menu_code = "payment_guide";
$head_title = $menu_text = $_GET['code']=='resume' ? 'Хувь хүний үйлчилгээний хүсэлт' : "Байгууллагын үйлчилгээний хүсэлт";
include_once "../include/top.php";

$wr_type = !$_GET['code'] ? 'employ' : 'individual';
$pack_query = sql_query("select * from `alice_payment_package` where `wr_type` = '".$wr_type."' order by `wr_rank` asc");
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
						<li class="item_info4"><?=number_format($pack_row['wr_price']);?>төгрөг</li>
					</ul>
				</li>
			</ul>
		</div>
		<?php }?>
	</article>


	<?php
	$_service_key = $wr_type=='employ' ? 'main_' : 'alba_resume_';
	ob_start();
	if(is_array($service_control->service_lists)) { foreach($service_control->service_lists as $k=>$v) {
		if($k!='main' && $wr_type=='employ') continue;
		if($k!='alba_resume' && $wr_type=='individual') continue;
		if(is_array($v)) { foreach($v as $k2=>$v2) {

			if($_part_txt && $_part_txt!=$k2) continue; // : 각각의 서비스신청을 누른경우

			$__content_key = 'main_'.$k2;
			$_content = $design[$__content_key.'_content'];

			$service_list = $service_control->__ServiceList($_service_key.$k2);
			//$service_gold_list = $service_control->__ServiceList($type."_gold");
			//$service_logo_list = $service_control->__ServiceList($type."_logo");
	?>
	<div class="item_box cf">
		<h3><?=$wr_type=='employ' ? preg_replace(array('/구인정보/'), array(''), $v2['name']).' 구인정보' : $v2['name'];?></h3>
		<ul>
			<li class="box-info1 cf">
				<p>
				<?=$_content;?>
				</p>
			</li>
			<?php
			if(is_array($service_list)) {
				foreach($service_list as $val){
					$_price = $val['service_price']>0 ? number_format($val['service_price']) : '';
					$_sale = $val['service_percent']>0 ? '(<em>'.$val['service_percent'].'%↓</em>)' : '';
					$_price_txt = $netfu_util->sale_price($val['service_percent'], $val['service_price']);
			?>
			<li class="box-info2 cf">
				<ul>
					<li class="item_info1">Өнөөдөр+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></li>
					<li class="item_info2"><?=$_price;?><li>
					<li class="item_info3"><?=$_sale;?></li>
					<li class="item_info4"><?=$_price_txt ? number_format($_price_txt).'원' : '무료';?></li>
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
	$_tag = ob_get_clean();

	if($_tag) {
	?>
		<article>
			<h2><span><?=$wr_type=='employ' ? 'Үндсэн/Ажлын байрны мэдээлэл' : 'Үндсэн/ажил хайх мэдээлэл';?></span></h2>

			<?php
			echo $_tag
			?>

		</article>
	<?php
	}
	?>





	<?php
	### : 구인정보 서비스
	$_service_code = $wr_type=='employ' ? 'alba_option' : 'resume_option';
	$option_service_arr = $service_control->service_lists[$_service_code];
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

				$_part = in_array($v2, array('open', 'sms')) ? 'etc' : $_service_code;

				// : 이력서 열람, SMS 충전
				if(in_array($k, array('open', 'sms'))) {
					$__service_key = 'etc_'.$k;
					$__content_key = $__service_key;
					if(in_array($k, array('open'))) $__content_key = $wr_type=='employ' ? 'resume_'.$k : 'alba_'.$k;;
					if(in_array($k, array('sms'))) $__content_key = $wr_type=='employ' ? 'etc_alba_sms' : 'etc_resume_sms';
					$alba_option = $service_control->service_check($__service_key);	// 알바 급구 옵션
					$service_list = $service_control->__ServiceList($alba_option['service']);	// 알바 급구 서비스 리스트

				// : 그외
				} else {
					$__service_key = $_service_code.'_'.$v2;
					$__content_key = $__service_key;
					if(in_array($k, array('busy'))) $__content_key = 'main_'.$k;
					if(in_array($k, array('jump'))) $__content_key = preg_replace("/_option/", "", $_service_code).'_'.$k;
					$alba_option = $service_control->service_check($__service_key);	// 알바 급구 옵션
					$service_list = $service_control->__ServiceList($alba_option['service']);	// 알바 급구 서비스 리스트
				}
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
						<?=$_content;?>
						</p>
					</li>
					<li class="box-info1 cf <?=$_part_option;?>">
						<?php
						if(@count($_option_arr)>0) { foreach($_option_arr as $k3=>$v3) {
							$_val = $v2=='icon' ? $v3['no'] : $v3;


						// : 강조효과 파트정보 ##############
							switch($v2) {
								case 'icon':
						?>
						<img src="<?=NFE_URL;?>/data/icon/<?=$v3['name'];?>" alt="아이콘<?=$k3;?>"></label>
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
					<?php
					if(is_array($service_list)) {
						foreach($service_list as $val){ 
							$_price = $val['service_price']>0 ? number_format($val['service_price']) : '';
							$_sale = $val['service_percent']>0 ? '(<em>'.$val['service_percent'].'%↓</em>)' : '';
							$_price_txt = $netfu_util->sale_price($val['service_percent'], $val['service_price']);
					?>
					<li class="box-info2 cf">
						<ul>
							<li class="service_info1 item_info1">Өнөөдөр+<?=$val['service_cnt'].str_replace(array_keys($netfu_util->day_arr), $netfu_util->day_arr, $val['service_unit']);?></li>
							<li class="service_info2 item_info2"><?=$_price;?><li>
							<li class="service_info3 item_info3"><?=$_sale;?></li>
							<li class="service_info4 item_info4"><?=$_price_txt ? number_format($_price_txt).'төгрөг' : 'Үнэгүй';?></li>
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
	<?php }
	}
	
	
	$write_link = !$_GET['code'] ? 'job_write' : 'resume_write';
	?>
	<!-- <div><a href="<?=NFE_URL;?>/mypage/<?=$write_link;?>.php">광고신청하기</a></div> -->

	</section>

<?php
include "../include/tail.php";
?>