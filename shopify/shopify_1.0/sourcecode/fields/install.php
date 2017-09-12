<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
require_once '../emarsys.php';
require_once '../database.php';
//$con->query('TRUNCATE `emarsys_fields`');
$query = "SELECT `fieldEmarsysID` FROM `emarsys_fields` WHERE `store_name` = '" . $_SESSION['shop'] . "'";
$result = $con->query($query);
$fieldsArr = [];
while($row = $result->fetch_assoc()){
	$fieldsArr[] = $row['fieldEmarsysID'];
}

$fields = json_decode($emarsyClient->send('GET', 'field'));

if($fields->replyCode == 1){
    header('Location: ../emarsys_details.php');
}

$query = "INSERT INTO `emarsys_fields` (`store_name`, `fieldName`, `fieldEmarsysID`, `fieldEmarsysName`) VALUES ";
$i = 0;
foreach ($fields->data as $field) {
	if($i != 0){
		$query .= ", ";
	}
	if(!in_array($field->id, $fieldsArr)){
		$query .= "('" . $_SESSION['shop'] . "', '" . $field->name . "', '" . $field->id . "', '" . $field->string_id . "')";
		$i++;
	}
}
if($i){
	$result = $con->query($query);
}else{

}
header('Location: ../emarsys_fields.php');
