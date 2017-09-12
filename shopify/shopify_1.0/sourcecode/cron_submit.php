<?php

session_start();

	require 'database.php';

$shop = $_SESSION['shop'];



if($_POST){

	$shopify_data = $_POST['type'];

	$cron_status = $_POST['cron_status'];

	

	 $cron_day = $_POST['cron_day'];

	

	 $cron_hour = $_POST['cron_hour'];

	

	 $cron_min = $_POST['cron_min'];

	

	 $cron_frequency = $_POST['cron_frequency'];


	// default set error.
	$status = "error";


	$sql1 = "SELECT * FROM cron where store_name='" . trim($shop) . "' AND shopify_data='" . trim($shopify_data) . "'";
      
		  $result1 = $con->query($sql1);

	      if ($result1->num_rows > 0) {
	        // update optin


				$sql_update = "UPDATE cron SET status='".trim($cron_status)."', frequency='".trim($cron_frequency)."', execute_min='".trim($cron_min)."', execute_hour='".trim($cron_hour)."', execute_day='".trim($cron_day)."' WHERE store_name='".$shop."' AND shopify_data='".$shopify_data."' ";

				if(mysqli_query($con, $sql_update)){
					$status = "success";
				}


		    }else{
			    	// insert optin
			    	$sql = "INSERT INTO cron (id, store_name, shopify_data, status, frequency, execute_min, execute_hour, execute_day) VALUES ('', '" . trim($shop) . "', '" . trim($shopify_data) . "', '" . trim($cron_status) . "', '" . trim($cron_frequency) . "', '" . trim($cron_min) . "', '" . trim($cron_hour) . "', '" . trim($cron_day) . "')";

				if(mysqli_query($con, $sql)){
					$status = "success";
				}

		    }	 

	echo $status;	  


}