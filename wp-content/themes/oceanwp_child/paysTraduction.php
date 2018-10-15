<?php

require_once('../../../wp-config.php');


$query = isset($_GET['query']) ? $_GET['query'] : FALSE;


	$field = "label_fr";

global $wpdb;

// escape values passed to db to avoid sql-injection

$result = $wpdb->get_results( "SELECT * FROM traduction WHERE ".$field." LIKE '%".$query."%' ORDER BY ".$field." ASC" );

//var_dump($result);

$suggestions = array();
$data = array();

foreach($result as $row) {
    array_push($data, $row->label_en);
}

echo json_encode ($data);

?>