<?php
require('config.php');



foreach ($_POST as $key => $value) {
	$$key = $value;
}



$result = array(
	'success' => 1,
	'payload' => array(),
);

if(!isset($_SESSION['heat'])){
	$_SESSION['heat'] = 0;
}

$Vote = new Vote();
$currentHeat = $Vote->poll($_SESSION['heat']);
if(!$currentHeat){
	$currentHeat = $Vote->poll(0);
}

if($action == 'poll'){
	$i = 1;


//echo print_r($currentHeat,TRUE);

	foreach ($currentHeat as $key => $value) {
		$result['payload']["s{$i}"] = $value;
		$i++;
	}

} elseif($action == 'vote'){
	$Vote->cast($song_id);
	foreach ($currentHeat as $key => $value) {
		$_SESSION['heat'] = $value['id'];
	}
} elseif($action == 'skip'){
	foreach ($currentHeat as $key => $value) {
		$_SESSION['heat'] = $value['id'];
	}
}

header('Content-Type: application/json');
echo json_encode($result);

?>
