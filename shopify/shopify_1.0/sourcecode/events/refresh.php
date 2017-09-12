<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
require_once '../emarsys.php';
require_once '../database.php';

$query = "SELECT * FROM `emarsys_credentials` WHERE `store_name` = '" . trim($_SESSION['shop']) . "'";
$result = $con->query($query);


if ($result->num_rows > 0){

	$query = "SELECT `eventEmarsysID` FROM `emarsys_external_events` WHERE `store_name` = '" . trim($_SESSION['shop']) . "'";
	$result = $con->query($query);
	$allEvents = [];

	while($row = $result->fetch_assoc()){
		$allEvents[] = $row;
	}
	$allEvents = array_column($allEvents, 'eventEmarsysID');
	$query = "INSERT INTO `emarsys_external_events` (store_name, eventEmarsysID, eventName) VALUES";
	$i = 0;
	$getAll = json_decode($emarsyClient->send('GET', 'event'));
	$storeName = $_SESSION['shop'];
	foreach($getAll->data as $ev){
		if(!in_array($ev->id, $allEvents)){
			if($i != 0){
				$query .= ',';
			}
			$query .= " ('" . $storeName . "', '" . $ev->id . "', '" . trim($ev->name) . "')";
			$i++;
		}
	}
	$result = $con->query($query);
	header('Location: ../events.php');
}
else{
	header('Location: ../emarsys_details.php');
}