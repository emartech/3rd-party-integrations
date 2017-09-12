	<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
require_once '../emarsys.php';
require_once '../database.php';

$curr_dt_time = date("Y-m-d H:i:s");
$fields = json_decode($emarsyClient->send('GET', 'field'));

$result = $con->query("TRUNCATE TABLE `emarsys_fields`");

$query = "INSERT INTO `emarsys_fields` (`store_name`, `fieldName`, `fieldEmarsysID`, `fieldEmarsysName`) VALUES ";
$i = 0;
foreach ($fields->data as $field) {
	if($i != 0){
		$query .= ", ";
	}
	$query .= "('" . $_SESSION['shop'] . "', '" . $field->name . "', '" . $field->id . "', '" . $field->string_id . "')";
	$i++;
}

$result = $con->query($query);

$posts = array();
$tempArray = array();
$log_file_name = "logs.json"; 

$oldJSON = file_get_contents("logs/$log_file_name");
$tempArray = json_decode($oldJSON, true);
 
$log_file = fopen("../logs/$log_file_name", "w+");

if($result){
	$posts[] = array('Code'=> 'Emarsys Installation', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'Emarsys installed successfully for this store.');
	if (!empty($tempArray[0])) {
	 $result = array_merge($tempArray, $posts);
	}
	else{
	 $result = $posts;
	}

	fwrite($log_file, json_encode($result));
	header('Location: ../emarsys_fields.php');
}else {
	$posts[] = array('Code'=> 'Emarsys Installation', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'Error creating database.');
	if (!empty($tempArray[0])) {
	 $result = array_merge($tempArray, $posts);
	}
	else{
	 $result = $posts;
	}

	fwrite($log_file, json_encode($result));
    echo "Error creating database: " . $con->error;
}

