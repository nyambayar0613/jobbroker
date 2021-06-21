<?php
#####################################################################
/*
신청상품 모음
*/
#####################################################################
?>
<section class="cont_box service_con">
	<h2>신청상품</h2>
	<ul>
		<?php
		if(is_array($_POST['service'])) { foreach($_POST['service'] as $k=>$v) {
			if(!$v) continue;
			$_arr = explode("/", $v);

			// : 가격값
			$price_row = $netfu_payment->get_price($_arr[0], $_arr[1]);

			if($_arr[0]=='package') {
				$_date_txt = $pack_service[0]['name'].'외 '.(count($pack_service)-1).'건';
			} else {
				if($price_row['etc_3']) $_date_txt = $price_row['etc_3'].'건';
				else $_date_txt = '오늘 + '.$price_row['_date'];
			}

			// : gold, logo 사용여부 체크
			$service_lists_arr = $service_control->service_lists[$_arr[0]][$price_row['_service_txt_arr'][1]];
			$_type = $_arr[0].'_'.$price_row['_service_txt_arr'][1];
		?>
		<li class="service_item cf _<?=$_type;?>">
			<?php
			include NFE_PATH.'/payment/inc/payment_tag.inc.php';
			?>
		</li>
		<?php
			if($service_lists_arr['is_gold']) {
		?>
		<li class="service_item cf _<?=$_type;?>_gold _none"></li>
		<?php
			}

			if($service_lists_arr['is_logo']) {
		?>
		<li class="service_item cf _<?=$_type;?>_logo _none"></li>
		<?php
			}
		} }
		?>
	</ul>
</section>