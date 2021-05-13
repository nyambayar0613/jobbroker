<?php
$alice_path = "../";

$cat_path = "../";	// 변수 상대경로를 위한 cat path ( app_config.php 파일의 $cat_path 에 대입 )

include_once $cat_path . "_core.php";

$data = $db->query_fetch_rows(" select * from `alice_alba_resume` order by `no` desc ");
foreach($data as $val){
	if( $val['wr_id'] ){
		$get_member = $member_control->get_member( $val['wr_id'] );
		$query = " update `alice_alba_resume` set `wr_name` = '".$get_member['mb_name']."' where `no` = '".$val['no']."' ";
		//$db->_query($query, true);
		//echo $query."<br/><br/>";
	}
}
?>