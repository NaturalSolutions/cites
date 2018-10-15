<?php

require_once('../../../wp-config.php');


$query = isset($_GET['query']) ? $_GET['query'] : FALSE;
$lang = isset($_GET['lang']) ? $_GET['lang'] : FALSE;


if($lang=="fr-FR") {
	$field = "label_fr";
} else {
	$field = "label_en";
}
//var_dump("SELECT * FROM traduction WHERE ".$field." LIKE '".$query."%' ORDER BY ".$field." ASC");
global $wpdb;

// escape values passed to db to avoid sql-injection

$result = $wpdb->get_results( "SELECT * FROM traduction WHERE ".$field." LIKE '%".$query."%' ORDER BY ".$field." ASC" );

//var_dump($result);

$suggestions = array();
$data = array();

foreach($result as $row) {
    array_push($data, $row->$field);
}
/*$response = array(
	'suggestions' => $data
);*/

echo json_encode ($data);

?>