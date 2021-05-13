<div class="right_nav_body" style="display:none;">
<?php
switch($member['mb_type']) {
	case "individual":
		$_code = 'resume';
		$_read_code = 'mb_service_open_count';

		// : 진행, 마감 개수정보
		$_my_count['resume'] = sql_fetch("select count(*) as c from alice_alba_resume as aar where 1 and `wr_id`='".$member['mb_id']."' and `is_delete`=0");

		$_my_count['scrap'] = sql_fetch("select count(*) as c from `alice_scrap` where 1 and `mb_id`='".$member['mb_id']."' and scrap_rel_table='alba'");

		$_my_count['receive'] = sql_fetch("select count(*) as c from alice_receive where `type`='become_online' and `wr_id`='".$member['mb_id']."' and `is_delete_indi`=0");

		$_add = $alba_individual_control->_CustomSearch( $_GET['no'] );

		$custom_titles = $alba_individual_control->custom_titles($member['mb_id']);	 // 타이틀 뽑기

		include NFE_PATH.'/include/inc/nav_right_individual.inc.php';
		break;


	case "company":
		$_code = 'alba';
		$_read_code = 'mb_service_alba_count';
		// : 진행, 마감 개수정보

		$_job_where = $netfu_mjob->job_where.$netfu_mjob->_service_where;

		$_my_count['job_ing'] = sql_fetch("select count(*) as c from alice_alba where 1 and ".$_job_where." and `wr_id`='".$member['mb_id']."' and `is_delete`=0");
		$_my_count['job_end'] = sql_fetch("select count(*) as c from alice_alba where 1 and !(".$_job_where.") and `wr_id`='".$member['mb_id']."' and `is_delete`=0");

		$_my_count['scrap'] = sql_fetch("select count(*) as c from `alice_scrap` where 1 and `mb_id` = '".$member['mb_id']."'");

		$save_query = sql_query("select * from `alice_resume_search` where `wr_id` = '".$member['mb_id']."' order by `no` desc");
		$save_query_num_ = sql_num_rows($save_query);

		include NFE_PATH.'/include/inc/nav_right_company.inc.php';
		break;
}
?>
</div>