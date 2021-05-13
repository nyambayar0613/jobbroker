<?php
		/*
		* /application/nad/member/process/custom.php
		* @author Harimao
		* @since 2015/03/27
		* @last update 2015/03/27
		* @Module v3.5 ( Alice )
		* @Brief :: Customized process
		* @Comment :: 맞춤 인재/채용정보 처리
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$ajax = $_POST['ajax'];

		$admin_control->is_admin( $ajax );	// 관리자 체크

		$mode = $_POST['mode'];
		$no = $_POST['no'];

		switch($mode){

			## 맞춤인재정보 수정
			case 'individual_update':

				$vals['wr_id'] = $_POST['mb_id'];

				/* 업직종 */
				$vals['wr_job_type0'] = $_POST['wr_job_type0'];
				$vals['wr_job_type1'] = $_POST['wr_job_type1'];
				$vals['wr_job_type2'] = $_POST['wr_job_type2'];

				$vals['wr_job_type3'] = $_POST['wr_job_type3'];
				$vals['wr_job_type4'] = $_POST['wr_job_type4'];
				$vals['wr_job_type5'] = $_POST['wr_job_type5'];

				$vals['wr_job_type6'] = $_POST['wr_job_type6'];
				$vals['wr_job_type7'] = $_POST['wr_job_type7'];
				$vals['wr_job_type8'] = $_POST['wr_job_type8'];
				/* //업직종 */

				/* 근무지 */
				$vals['wr_area0'] = $_POST['wr_area0'];
				$vals['wr_area1'] = $_POST['wr_area1'];

				$vals['wr_area2'] = $_POST['wr_area2'];
				$vals['wr_area3'] = $_POST['wr_area3'];

				$vals['wr_area4'] = $_POST['wr_area4'];
				$vals['wr_area5'] = $_POST['wr_area5'];
				/* //근무지 */

				$vals['wr_home_work'] = $_POST['wr_home_work'];	// 재택가능

				/* 근무일시 */
				$vals['wr_date'] = $_POST['wr_date'];			// 근무기간
				$vals['wr_week'] = $_POST['wr_week'];		// 근무요일
				$vals['wr_time'] = $_POST['wr_time'];			// 근무시간
				$vals['wr_work_direct'] = $_POST['wr_work_direct'];	// 즉시출근가능
				/* //근무일시 */

				$vals['wr_gender'] = $_POST['wr_gender'];
				$age_limit = $_POST['wr_age_limit'];
				$vals['wr_age_limit'] = $age_limit;
				if($age_limit) {	// 연령제한이 있다면
					$vals['wr_age'] = $_POST['wr_sage'] . "-" . $_POST['wr_eage'];
				}
				$vals['wr_age_etc'] = @implode($_POST['wr_age_etc'],',');	// 연령 기타 정보

				$vals['wr_work_type'] = ($_POST['wr_work_type']) ? @implode($_POST['wr_work_type'],',') : "";		// 근무형태

				$vals['wr_email'] = $_POST['wr_email'];
				$vals['wr_sms'] = $_POST['wr_sms'];

				$vals['wdate'] = $alice['time_ymdhis'];

				$result = $alba_company_control->custom_updates($vals,$no);

				echo $result;

			break;


			## 맞춤인재정보 삭제
			case 'individual_delete':

				$result = $alba_company_control->custom_delete($no);

				echo $result;

			break;


			## 맞춤채용정보 수정
			case 'employ_update':

				$vals['wr_id'] = $_POST['mb_id'];

				/* 업직종 */
				$vals['wr_job_type0'] = $_POST['wr_job_type0'];
				$vals['wr_job_type1'] = $_POST['wr_job_type1'];
				$vals['wr_job_type2'] = $_POST['wr_job_type2'];

				$vals['wr_job_type3'] = $_POST['wr_job_type3'];
				$vals['wr_job_type4'] = $_POST['wr_job_type4'];
				$vals['wr_job_type5'] = $_POST['wr_job_type5'];

				$vals['wr_job_type6'] = $_POST['wr_job_type6'];
				$vals['wr_job_type7'] = $_POST['wr_job_type7'];
				$vals['wr_job_type8'] = $_POST['wr_job_type8'];
				/* //업직종 */

				/* 근무지 */
				$vals['wr_area0'] = $_POST['wr_area0'];
				$vals['wr_area1'] = $_POST['wr_area1'];

				$vals['wr_area2'] = $_POST['wr_area2'];
				$vals['wr_area3'] = $_POST['wr_area3'];

				$vals['wr_area4'] = $_POST['wr_area4'];
				$vals['wr_area5'] = $_POST['wr_area5'];
				/* //근무지 */

				
				/* 근무일시 */
				$vals['wr_date'] = $_POST['wr_date'];			// 근무기간
				$vals['wr_week'] = $_POST['wr_week'];		// 근무요일
				$vals['wr_stime'] = @implode($_POST['wr_stime'],":");
				$vals['wr_etime'] = @implode($_POST['wr_etime'],":");
				$vals['wr_time_conference'] = $_POST['wr_time_conference'];
				/* //근무일시 */

				$vals['wr_gender'] = $_POST['wr_gender'];
				$age_limit = $_POST['wr_age_limit'];
				$vals['wr_age_limit'] = $age_limit;
				if($age_limit) {	// 연령제한이 있다면
					$vals['wr_age'] = $_POST['wr_sage'] . "-" . $_POST['wr_eage'];
				}
				$vals['wr_age_etc'] = @implode($_POST['wr_age_etc'],',');	// 연령 기타 정보

				$vals['wr_work_type'] = ($_POST['wr_work_type']) ? @implode($_POST['wr_work_type'],',') : "";		// 근무형태

				$vals['wr_email'] = $_POST['wr_email'];
				$vals['wr_sms'] = $_POST['wr_sms'];

				$vals['wdate'] = $now_date;

				$result = $alba_individual_control->custom_updates($vals,$no);

				echo $result;

			break;

			## 맞춤채용정보
			case 'employ_delete':

				$result = $alba_individual_control->custom_delete($no);

				echo $result;

			break;

		}	// switch end.
?>