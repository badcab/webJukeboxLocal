<?php
require('config.php');
foreach ($_POST as $key => $value) {
	$$key = $value;
}

$result = array(
	'success' => 1,
	'payload' => array();
);

//$_SESSION['heat'];
//this should be set to the greatest id in a given heat, will eventualy figure out a way to recycle

if($action == 'poll'){

} elseif($action == 'vote'){

} elseif($action == 'skip'){

}

header('Content-Type: application/json');
echo json_encode($result);

?>
