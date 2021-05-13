<?php
		/*
		* /application/nad/config/views/_load/pg.php
		* @author Harimao
		* @since 2012/09/06
		* @last update 2015/02/25
		* @Module v3.0 ( Alice )
		* @Brief :: PG pay method load
		* @Comment :: 결제 수단 정보
		*/

		$alice_path = "../../../../";
		
		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( true );	// 관리자 체크

		$mode = $_POST['mode'];

		$inicisSet_info = $payment_control->get_pgInfoCompany('inicis');	// 이니시스 설정 정보
		$allSet_info = $payment_control->get_pgInfoCompany('allthegate');	// 올더게잇 설정 정보
		$kcpSet_info = $payment_control->get_pgInfoCompany('kcp');	// KCP 설정 정보
		$niceSet_info = $payment_control->get_pgInfoCompany('nicepay');	// KCP 설정 정보

		$ini_paymethod = explode('/',$inicisSet_info['pg_method']);
		$all_paymethod = explode('/',$allSet_info['pg_method']);
		$kcp_paymethod = explode('/',$kcpSet_info['pg_method']);
		$nicepay_paymethod = explode('/',$niceSet_info['pg_method']);

		$PG_method = $payment_control->pg_method;

		switch($mode){

			## inicis pay method load
			case 'inicis':
?>
	   <tr id='inicis_method'>
		  <td class="ctlt">결제 선택</td>
		  <td class="pdlnb2">
		  <?php foreach($PG_method['inicis'] as $key => $val){?>
			<input type='checkbox' name="pg_method[]" value="<?php echo $key;?>" id='pg_method<?php echo $val['gopaymethod']?>' <?=(in_array($key, $ini_paymethod))?'checked':'';?>> <label class="m0" for='pg_method<?php echo $val['gopaymethod']?>'><?php echo $val['name']?></label> &nbsp;
		  <?php } ?>
		  </td>
	  </tr>

<?php
			break;

			## allthegate pay method load
			case 'allthegate':
?>
	   <tr id='all_method'>
		  <td class="ctlt">결제 선택</td>
		  <td class="pdlnb2">
		  <?php foreach($PG_method['inicis'] as $key => $val){?>
			<input type='checkbox' name="pg_method[]" value="<?php echo $key;?>" id='pg_method<?php echo $val['gopaymethod']?>' <?=(in_array($key, $all_paymethod))?'checked':'';?>> <label class="m0" for='pg_method<?php echo $val['gopaymethod']?>'><?php echo $val['name']?></label> &nbsp;
		  <?php } ?>
		  </td>
	  </tr>
<?php
			break;

			## allthegate pay method load
			case 'kcp':
?>
	   <tr id='kcp_method'>
		  <td class="ctlt">결제 선택</td>
		  <td class="pdlnb2">
		  <?php foreach($PG_method['kcp'] as $key => $val){?>
			<input type='checkbox' name="pg_method[]" value="<?php echo $key;?>" id='pg_method<?php echo $val['gopaymethod']?>' <?=(in_array($key, $kcp_paymethod))?'checked':'';?>> <label class="m0" for='pg_method<?php echo $val['gopaymethod']?>'><?php echo $val['name']?></label> &nbsp;
		  <?php } ?>
		  </td>
	  </tr>
<?php
			break;


		  case "nicepay":
?>
	   <tr id='kcp_method'>
		  <td class="ctlt">결제 선택</td>
		  <td class="pdlnb2">
		  <?php foreach($PG_method['nicepay'] as $key => $val){?>
			<input type='checkbox' name="pg_method[]" value="<?php echo $key;?>" id='pg_method<?php echo $val['gopaymethod']?>' <?=(in_array($key, $nicepay_paymethod))?'checked':'';?>> <label class="m0" for='pg_method<?php echo $val['gopaymethod']?>'><?php echo $val['name']?></label> &nbsp;
		  <?php } ?>
		  </td>
	  </tr>
<?php
			  break;

		}	// switch end.
?>