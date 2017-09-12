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

	
	$sql1 = "SELECT * FROM sftp_si_credentials where store_name='" . trim($shop) . "'";
      
	$result = $con->query($sql1);


	if ($result->num_rows > 0) {
		### update query
		$sql_query = "UPDATE sftp_si_credentials SET sftp_hostname ='".$sftp_hostname."', sftp_port ='".$sftp_port."', sftp_username ='".$sftp_username."', sftp_password ='".$sftp_password."'";

		if(mysqli_query($con, $sql_query)){
		
		    $sql_query_checklist = "UPDATE checklist SET status ='' WHERE store_name='".$shop."' AND property_id='23'";

			mysqli_query($con, $sql_query_checklist);

			$status = 'success';  
		}else {
	    
	    	$status = 'error'; 
		}

	}else{
		### insert query
		
		$sql = "INSERT INTO sftp_si_credentials (id, store_name, sftp_hostname, sftp_port, sftp_username, sftp_password) VALUES ('', '" . trim($shop) . "', '" . trim($sftp_hostname) . "', '" . trim($sftp_port) . "', '" . trim($sftp_username) . "', '" . trim($sftp_password) . "')";

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


 

