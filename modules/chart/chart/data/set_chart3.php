<?php
include '../../../Libs/_php/rankup_basic.class.php';

define('ga_email',$config_info['google_id']);
define('ga_password',$config_info['google_pass']);
define('ga_profile_id',$config_info['google_profile_id']);

include_once '../gapi.class.php';

$ga = new gapi(ga_email,ga_password);


$ga->requestReportData(ga_profile_id,array('pagePath'),array('visits'),'-visits',null,$start_date,$end_date,null,10);
$k=0;
foreach($ga->getResults() as $result){
$xdata['title'][]=iconv("UTF-8","EUC-KR",$result);
$xdata['data'][]=$result->getVisits();
if($max<$result->getVisits()){$max=$result->getVisits();}
$k++;
}
include '../php-ofc-library/open-flash-chart.php';
for($i=0;$i<10;$i++){
	$labeltext[$i]=round($max/10*$i);
}
$x_labels = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

$title = new title( "" );

$hbar = new hbar( '#86BBEF' );
$hbar->set_tooltip( 'visitor: #val#' );
$hbar->set_values( $xdata['data'] );

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $hbar );

$x = new x_axis();
$x->set_offset( false );
$x->set_range( 0, $max );
//$x->set_labels_from_array( $x_labels );
$chart->set_x_axis( $x );

$y = new y_axis();
$y->set_offset( true );
$y->set_labels( $xdata['title'] );
$chart->add_y_axis( $y );

$tooltip = new tooltip();
//
// LOOK:
//
$tooltip->set_hover();
//
//
//
$tooltip->set_stroke( 1 );
$tooltip->set_colour( "#000000" );
$tooltip->set_background_colour( "#ffffff" ); 
$chart->set_tooltip( $tooltip );


echo $chart->toPrettyString();



?>