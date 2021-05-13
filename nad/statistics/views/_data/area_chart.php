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

			$ga->requestReportData($env['google_profile_id'], array($kind), array('visits'), 'date', null, $sdate, $edate);

			$max = 0;
			$titles = $datas = array();
			foreach($ga->getResults() as $result) {
				$dms = $result->getDimesions();
				array_push($titles, date('Y.m.d', strtotime($dms[$kind])));
				array_push($datas, $result->getVisits());
				if($max < $result->getVisits()) $max = $result->getVisits();
			}

			if(!$max) $max = 5;
			$statistics_control->keep(array(
				'kind' => $kind,
				'sdate' => $sdate,
				'edate' => $edate,
				'titles' => serialize($titles),
				'datas' => serialize($datas),
				'max' => $max
			));

		}

		// 팔레트
		$palettes = array(
			array(
				'dot' => '#1083F7',
				'line' => '#1083F7',
				'fill' => '#DEEFFF',
				'rotate' => 90
			),
			array(
				'dot' => '#1083F7',
				'line' => '#1083F7',
				'fill' => '#DEEFFF',
				'rotate' => 0
			)
		);

		$palette = ($kind=='language') ? $palettes[1] : $palettes[0];

		$d = $statistics_control->dot($palette['dot']);

		$area = new area();
		$area->set_width( 2 );
		$area->set_default_dot_style( $d );
		$area->set_colour( $palette['line'] );
		$area->set_fill_colour( $palette['fill'] );
		$area->set_fill_alpha( 0.4 );
		$area->set_values( $datas );
		$area->on_show(new line_on_show('pop-up', '0', '0'));

		$chart = new open_flash_chart();
		$chart->set_title($title);
		$chart->add_element( $area );

		$x_labels = new x_axis_labels();
		$x_labels->set_labels($titles);
		$x_labels->set_size(11);
		$x_labels->set_steps(86400);
		$x_labels->visible_steps(1);
		$x_labels->rotate( $palette['rotate'] );

		$x_axis = new x_axis();
		$x_axis->colour = '#909090';
		$x_axis->set_labels($x_labels);
		$x_axis->set_steps(86400);
		$chart->set_x_axis( $x_axis );


		if($max > 50) $range = round($max /10);
		else if($max > 15) $range=5;
		else if($max < 10) $range=1;
		else $range=2;


		$y_axis = new y_axis();
		$y_axis->set_range(0, $max + 10, $range);
		$chart->add_y_axis($y_axis);
		$chart->set_bg_colour('#FFFFFF');


		echo $chart->toPrettyString();
?>