<?php
		/*
		* /application/nad/statistics/views/_include/week_data.php
		* @author Harimao
		* @since 2013/06/20
		* @last update 2013/06/20
		* @Module v3.5 ( Alice )
		* @Brief :: Last week statistics data
		* @Comment :: 최근 일주일 방문자 통계
		*/

		$week_date = array();
		$week_data = array();

		$time = time();
		$week = date("w", $time);
		$sunday = mktime(0, 0, 0, date("m"), date("d") - $week, date("Y"));
		for ($i = 0, $day = $sunday; $i < 7; $i++, $day+= 86400) {
			$week_date[$i] = date("Y-m-d", $day);
			$visit_sum = $statistics_control->get_visit_sum($week_date[$i]);
			$week_data[$i] = $visit_sum['visit_count'];
		}

		$bar_blue = new bar_3d( 75, '#0080ff' );
		$bar_blue->key( '방문자수', 11 );
		
		$g = new graph();
		$g->data_sets[] = $week_data;
		$g->set_x_axis_3d( 7 );
		$g->x_axis_colour( '#909090', '#ADB5C7' );
		$g->y_axis_colour( '#909090', '#ADB5C7' );
		$g->set_x_labels( $week_date );
		$g->set_x_label_style( 15 );
		$g->set_y_max( 10 );
		$g->y_label_steps( 5 );
		$g->set_width( '100%' );
		$g->set_height( 450 );
		$g->bg_colour = '#ffffff';
		$g->set_output_type('js');

		$week_3d_bar = $g->render();

?>