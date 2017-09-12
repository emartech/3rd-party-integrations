<?php
session_start();

require 'database.php';


$shop = $_SESSION['shop'];

if($_POST){

	// $shop = $_POST['shop'];
	
	$emarsys_username = $_POST['emarsys_username'];
	
	$emarsys_password = $_POST['emarsys_password'];
	

	$sql = "SELECT * FROM emarsys_credentials where store_name='" . trim($_SESSION['shop']) . "'";
	
	$result = $con->query($sql);

	if ($result->num_rows > 0) {
		### update query
		$sql_query = "UPDATE emarsys_credentials SET emarsys_username ='".$emarsys_username."', emarsys_password ='".$emarsys_password."' WHERE store_name='".$shop."'";

		if(mysqli_query($con, $sql_query)){

			$sql_query_checklist = "UPDATE checklist SET status ='' WHERE store_name='".$shop."' AND property_id='21'";

			mysqli_query($con, $sql_query_checklist);
		
		    $status = 'success';  
		}else {
	    
	    	$status = 'error'; 
		}

	}else{
		### insert query
		$sql_query = "INSERT INTO emarsys_credentials (id, store_name, emarsys_username, emarsys_password) VALUES ('', '" . trim($shop) . "', '" . trim($emarsys_username) . "', '" . trim($emarsys_username) . "')";

		if(mysqli_query($con, $sql_query)){
		
		    $status = 'success';  
		}else {
	    
	    	$status = 'error'; 
		}

	}

}else{
	$status = 'error'; 
}

echo $status;


 

