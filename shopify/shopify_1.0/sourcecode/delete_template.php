<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'config.php';
require_once 'database.php';

if(isset($_GET['id'])){
	$query = "SELECT * FROM `emarsys_email_templates` WHERE `store_name` = '" . trim($_SESSION['shop']) . "' AND `pkTemplateID`  =  '" . $_GET['id'] . "'";
	$result = $con->query($query);
    if(!$result){
        header('Location: templates.php');
    }else{
    	$query = "DELETE FROM `emarsys_email_templates` WHERE `store_name` = '" . trim($_SESSION['shop']) . "' AND `pkTemplateID`  =  '" . $_GET['id'] . "'";
    	$result = $con->query($query);
    }
    header('Location: templates.php');
}