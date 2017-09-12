<?php
session_start();

require 'database.php';


$shop = $_SESSION['shop'];

if($_POST){

	// $shop = $_POST['shop'];
	
	$webdav_url = $_POST['url'];

	$webdav_user = $_POST['user'];
	
	$webdav_password = $_POST['password'];

	
	$sql1 = "SELECT * FROM webdav_credentials where store_name='" . trim($shop) . "'";
      
	$result = $con->query($sql1);


	if ($result->num_rows > 0) {
		### update query
		$sql_query = "UPDATE webdav_credentials SET url ='".$webdav_url."', user ='".$webdav_user."', password ='".$webdav_password."' WHERE store_name='".$shop."'";

		if(mysqli_query($con, $sql_query)){
		
		    $status = 'success';  
		}else {
	    
	    	$status = 'error'; 
		}

	}else{
		### insert query
		
		$sql = "INSERT INTO webdav_credentials (id, store_name, url, user, password) VALUES ('', '" . trim($shop) . "', '" . trim($webdav_url) . "', '" . trim($webdav_user) . "', '" . trim($webdav_password) . "')";

		if(mysqli_query($con, $sql)){
		
		    $status = 'success';  
		}else {
	    
	    	$status = 'error'; 
		}
	}	

}else{
	$status = 'error'; 
}

echo $status;


 

