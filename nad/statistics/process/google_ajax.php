<?php
		/*
		* /application/nad/config/process/google_ajax.php
		* @author Harimao
		* @since 2013/06/24
		* @last update 2015/02/25
		* @Module v3.5 ( Alice )
		* @Brief :: Google analytics API
		* @Comment :: 구글 analytics 연동
		*/

		$alice_path = "../../../";

		$cat_path = "../../../";

		include_once $alice_path . "_core.php";

		$mode = $_POST['mode'];
		$ajax = $_POST['ajax'];
		$shape = $_POST['shape'];
		$sdate = $_POST['sdate'];
		$edate = $_POST['edate'];
		$kind = $_POST['kind'];

		$admin_control->is_admin( $ajax );	// 관리자 체크
	
		$google_infos = $statistics_control->google_infos( $kind, $sdate, $edate);

		$ga = new gapi($env['google_id'], $env['google_pass']);

		switch($mode){

			case 'load':

				$max = 0;
				$titles = $datas = array();

				if($statistics_control->infos == null) {

					switch($shape) {

						case 'area_chart':

							$ga->requestReportData($env['google_profile_id'], array($kind), array('visits'), 'date', null, $sdate, $edate);

							foreach($ga->getResults() as $result) {
								$dms = $result->getDimesions();
								array_push($titles, date('Y.m.d', strtotime($dms[$kind])));
								array_push($datas, $result->getVisits());
								if($max < $result->getVisits()) $max = $result->getVisits();
							}

						break;

						case 'pie_chart':

							$ga->requestReportData($env['google_profile_id'], array($kind), array('visits'), '-visits', null, $sdate, $edate);

							foreach($ga->getResults() as $result) {
								$dms = $result->getDimesions();
								array_push($titles, $dms[$kind]);
								array_push($datas, $result->getVisits());
								if($max < $result->getVisits()) $max = $result->getVisits();
							}

						break;

						case 'bar_chart':

							$ga->requestReportData($env['google_profile_id'], array($kind), array('visits'), '-visits', null, $sdate, $edate);

							foreach($ga->getResults() as $result) {
								$dms = $result->getDimesions();
								array_push($titles, $dms[$kind]);
								array_push($datas, $result->getVisits());
								if($max < $result->getVisits()) $max = $result->getVisits();
							}

						break;

					}	// shape switch end.

					if(count($titles)) {
						if(!$max) $max = 5;
						$statistics_control->keep(array(
							'kind' => $_POST['kind'],
							'sdate' => $_POST['sdate'],
							'edate' => $_POST['edate'],
							'titles' => serialize($titles),
							'datas' => serialize($datas),
							'max' => $max
						));
					}
				}

			break;

		}	// mode switch end.
?>