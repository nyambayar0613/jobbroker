<?php
include '../../../Libs/_php/rankup_basic.class.php';

define('ga_email',$config_info['google_id']);
define('ga_password',$config_info['google_pass']);
define('ga_profile_id',$config_info['google_profile_id']);

include_once '../gapi.class.php';

$ga = new gapi(ga_email,ga_password);


$ga->requestReportData(ga_profile_id,array('date'),array('visits'),'date',null,$_GET["start_date"],$_GET["end_date"]);
$k=0;
foreach($ga->getResults() as $result){
$xdata['title'][]=$result;
$xdata['data'][]=$result->getVisits();
if($max<$result->getVisits()){$max=$result->getVisits();}
$k++;
}
include '../php-ofc-library/open-flash-chart.php';

function dot($col)
{
    $default_dot = new dot();
    $default_dot->size(3);
	$default_dot->halo_size(1);
	$default_dot->colour($col);
	$default_dot->tooltip('X: #x_label#<br>Y: #val#<br>#date:Y-m-d at H:i#');
	return $default_dot;
}

function green_dot()
{
    return dot('#3D5C56');
}

$data_1 = array();
$data_2 = array();
// generate 31 data points
for( $i=1; $i<sizeof($xdata['title']); $i++ )
{
    $x = mktime(0, 0, 0, substr($xdata['title'][$i],4,2), substr($xdata['title'][$i],6,2), substr($xdata['title'][$i],0,4));

    $y = $xdata['data'][$i];
    $data_1[] = new scatter_value($x, $y);

    $data_2[] = (cos($i) * 1.9) + 4;
}
$def = new hollow_dot();
$def->size(3);
$def->halo_size(2);
$def->tooltip('#date:Y-m-d#<br>Value: #val#');

$line = new scatter_line( '#DB1750', 3 );
$line->set_values($data_1);
$line->set_default_dot_style( $def );


//
// create an X Axis object
//
$x = new x_axis();
// grid line and tick every 10
$x->set_range(
    mktime(0, 0, 0, substr($xdata['title'][0],4,2), substr($xdata['title'][0],6,2), substr($xdata['title'][0],0,4)),    // <-- min == 1st Jan, this year
    mktime(0, 0, 0, substr($xdata['title'][$k-1],4,2), substr($xdata['title'][$k-1],6,2), substr($xdata['title'][$k-1],0,4))    // <-- max == 31st Jan, this year
    );
// show ticks and grid lines for every day:
$x->set_steps(86400);

$labels = new x_axis_labels();
// tell the labels to render the number as a date:
$labels->text('#date:Y-m-d#');
// generate labels for every day
$labels->set_steps(86400);
// only display every other label (every other day)
$labels->visible_steps(2);
$labels->rotate(90);

// finally attach the label definition to the x axis
$x->set_labels($labels);


$y = new y_axis();
$y->set_range( 0, $max, round($max/2) );

$chart = new open_flash_chart();
$title = new title('');
$chart->set_title( $title );
$chart->add_element( $line );
$chart->set_x_axis( $x );
$chart->set_y_axis( $y );

echo $chart->toPrettyString();

?>