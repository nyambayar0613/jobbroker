<?php
		/*
		* /application/nad/statistics/_data/area_chart.php
		* @author Harimao
		* @since 2014/03/19
		* @last update 2014/03/19
		* @Module v3.5 ( Alice )
		* @Brief :: Google analytics API
		* @Comment :: 구글 analytics 연동
		*/

		$alice_path = "../../../../../";

		$cat_path = "../../../../";

		include_once $alice_path . "_core.php";

		$admin_control->is_admin( $ajax );	// 관리자 체크

		include_once $alice['modules_path'] . "/chart/chart/php-ofc-library/open-flash-chart.php";

		if($statistics_control->infos!==null) {

			extract($statistics_control->infos);

		} else {

			$ga = new gapi($env['google_id'], $env['google_pass']);

			$ga->requestReportData($env['google_profile_id'], array($kind), array('visits'), '-visits', null, $sdate, $edate);

			$max = 0;
			$titles = $datas = array();
			foreach($ga->getResults() as $result) {
				$dms = $result->getDimesions();
				array_push($titles, $dms[$kind]);
				array_push($datas, $result->getVisits());
				if($max < $result->getVisits()) $max = $result->getVisits();
			}

			if(!$max) $max = 5;
			$statistics_control->keep(array(
				'kind' => $_GET['kind'],
				'sdate' => $_GET['sdate'],
				'edate' => $_GET['edate'],
				'titles' => serialize($titles),
				'datas' => serialize($datas),
				'max' => $max
			));

		}

		$title = new title('');
		foreach($titles as $key=>$_title) {
			$titles[$key] = $utility->str_cut($_title, 35);
		}

		$chart = new open_flash_chart();

		$tooltip = '#val#건';
		$hbar = new hbar('#1083F7');
		$hbar->set_tooltip($tooltip);
		$hbar->set_values($datas);

		$chart->set_title($title);
		$chart->add_element($hbar);

		$x = new x_axis();
		$x->set_offset(false);

		if($max > 100) $step = round($max /10, -1);
		else if($max > 30) $step = 5;
		else $step = 2;

		$x->set_steps($step);
		$x->set_range(0, $max+2);
		$chart->set_x_axis($x);

		$y = new y_axis();
		$y->set_offset(true);
		$y->set_labels(array_reverse($titles));
		$chart->add_y_axis($y);

		$tooltip = new tooltip();
		$tooltip->set_hover();
		$chart->set_bg_colour('#ffffff');
		$chart->set_tooltip($tooltip);


		echo $chart->toPrettyString();

?>