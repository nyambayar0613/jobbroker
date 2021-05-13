<?php
//pg_id
//pg_passwd
//pg_method
switch($netfu_payment->use_pg['pg_company']) {

	case "kcp":
		include_once NFE_PATH."/plugin/PG/kcp/cfg/site_conf_inc.php";
		if($netfu_util->mobile_is) include NFE_PATH.'/payment/pg/kcp_start.m.inc.php';
		else include NFE_PATH.'/payment/pg/kcp_start.inc.php';
		break;

	case "inicis":
		if($netfu_util->mobile_is) include NFE_PATH.'/payment/pg/inicis_start.m.inc.php';
		else include NFE_PATH.'/payment/pg/inicis_start.inc.php';
		break;

	case "allthegate":
		if($netfu_util->mobile_is) include NFE_PATH.'/payment/pg/allthegate_start.m.inc.php';
		else include NFE_PATH.'/payment/pg/allthegate_start.inc.php';
		break;


	case "nicepay":
		if($netfu_util->mobile_is) include NFE_PATH.'/payment/pg/nicepay_start.m.inc.php';
		else include NFE_PATH.'/payment/pg/nicepay_start.inc.php';
		break;
	
}
?>