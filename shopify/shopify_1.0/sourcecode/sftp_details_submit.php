<?php
session_start();

require 'database.php';


$shop = $_SESSION['shop'];

if($_POST){

	// $shop = $_POST['shop'];
	
	$sftp_hostname = $_POST['sftp_hostname'];
	
	$sftp_port = $_POST['sftp_port'];

	$sftp_username = $_POST['sftp_username'];
	
	$sftp_password = $_POST['sftp_password'];

	$sftp_export = $_POST['sftp_export'];

	$feed_export = $_POST['feed_export'];

	
	$sql1 = "SELECT * FROM sftp_credentials where store_name='" . trim($shop) . "'";
      
	$result = $con->query($sql1);


	if ($result->num_rows > 0) {
		### update query
		$sql_query = "UPDATE sftp_credentials SET sftp_hostname ='".$sftp_hostname."', sftp_port ='".$sftp_port."', sftp_username ='".$sftp_username."', sftp_password ='".$sftp_password."', sftp_export ='".$sftp_export."', feed_export ='".$feed_export."' WHERE store_name='".$shop."'";

		if(mysqli_query($con, $sql_query)){
		
		    $sql_query_checklist = "UPDATE checklist SET status ='' WHERE store_name='".$shop."' AND property_id='22'";

			mysqli_query($con, $sql_query_checklist);

			$status = 'success';  
		}else {
	    
	    	$status = 'error'; 
		}

	}else{
		### insert query
		
		$sql = "INSERT INTO sftp_credentials (id, store_name, sftp_hostname, sftp_port, sftp_username, sftp_password, sftp_export, feed_export) VALUES ('', '" . trim($shop) . "', '" . trim($sftp_hostname) . "', '" . trim($sftp_port) . "', '" . trim($sftp_username) . "', '" . trim($sftp_password) . "', '" . trim($sftp_export) . "', '" . trim($feed_export) . "')";

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


 

