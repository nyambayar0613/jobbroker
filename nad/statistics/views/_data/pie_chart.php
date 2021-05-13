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
				'kind' => $kind,
				'sdate' => $sdate,
				'edate' => $edate,
				'titles' => serialize($titles),
				'datas' => serialize($datas),
				'max' => $max
			));

		}

		$title = new title('');
		$data = array();
		for($i = 0;$i<sizeof($titles);$i++) {
			$data[] = new pie_value($datas[$i], $titles[$i]." (".$datas[$i].")");
		}

		$pie = new pie();
		$pie->set_alpha(0.6);
		$pie->set_start_angle(-135);
		$pie->add_animation(new pie_bounce(10));
		$pie->add_animation(new pie_fade());
		$pie->gradient_fill();
		$tooltip = '#val#건(총 #total#건)<br>#percent#';
		$pie->set_tooltip($tooltip);
		//$pie->set_colours( array('#ff0000','#ff8040','#ffff00','#008000','#0000ff','#0000a0','#8000ff','#ff0000','#ff8040','#ffff00','#008000','#0000ff','#0000a0','#8000ff','#ff0000','#ff8040','#ffff00','#008000','#0000ff','#0000a0','#8000ff') );
		//$pie->set_colours(array('#1F8FA1', '#FF368D', '#1C9E05', '#848484', '#cc99ff', '#92d1ed'));
		$pie->set_colours( array('#1083F7', '#ff0000','#ff8040','#1C9E05','#008000','#0000ff','#0000a0') );

		$pie->set_values($data);

		$chart = new open_flash_chart();
		$chart->set_title($title);
		$chart->set_bg_colour('#FFFFFF');
		$chart->add_element($pie);
		$chart->x_axis = null;


		echo $chart->toPrettyString();

?>