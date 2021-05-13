<?php
include '../../../Libs/_php/rankup_basic.class.php';

define('ga_email',$config_info['google_id']);
define('ga_password',$config_info['google_pass']);
define('ga_profile_id',$config_info['google_profile_id']);

include_once '../gapi.class.php';

$ga = new gapi(ga_email,ga_password);


$ga->requestReportData(ga_profile_id,array($keyvalue),array('visits'),'-visits',null,$_GET["start_date"],$_GET["end_date"]);
$k=0;
foreach($ga->getResults() as $result){
$xdata['title'][]=$result;
$xdata['data'][]=$result->getVisits();
if($max<$result->getVisits()){$max=$result->getVisits();}
$k++;
}
include '../php-ofc-library/open-flash-chart.php';
$title = new title( '' );
$data=array();
for($i=0;$i<sizeof($xdata['title']);$i++){
	$data[]=new pie_value($xdata['data'][$i],$xdata['title'][$i]." (".$xdata['data'][$i].")");
}
$pie = new pie();
$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
$pie->add_animation( new pie_fade() );
$pie->gradient_fill();
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_colours( array('#1C9E05','#FF368D','#1F8FA1','#848484','#cc99ff','#92d1ed') );
$pie->set_values( $data );

$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );


$chart->x_axis = null;

echo $chart->toPrettyString();

?>