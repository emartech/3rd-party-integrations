<?php
	session_start();

	require ('ShopifyAPI/ShopifyClient.php');

	require 'config.php';

	require 'database.php';

	require ('emarsys.php');

	include('Net/SFTP.php');

	// echo "<pre>";

	// print_r($_SESSION);

	$shop = $_SESSION['shop'];

	$token = $_SESSION['token'];


    $sql_sftp = "SELECT * FROM sftp_si_credentials where store_name='" . trim($shop) . "'";
          
    $result_sftp = mysqli_query($con, $sql_sftp);

    if (mysqli_num_rows($result_sftp) > 0) {
       
        while($row = mysqli_fetch_assoc($result_sftp)) {

            $sftp_hostname = $row["sftp_hostname"];

            $sftp_port = $row["sftp_port"];

            $sftp_username = $row["sftp_username"];

            $sftp_password = $row["sftp_password"];

            $sftp_export = $row["sftp_export"];

            $feed_export = $row["feed_export"];
            
        
        }
    }

    $csvname = "smart_insight_$token.csv";

    $sftp = new Net_SFTP($sftp_hostname);
	
	if ($sftp->login($sftp_username, $sftp_password)) {
	
	    if($sftp->put("smart_insight.csv", "csv/$csvname", NET_SFTP_LOCAL_FILE)){

	    	$status =  'fs';  // success   
	    }else{

	    	$status =  'fe'; // error
	    }

	}else{
        $status =  'fe'; // error
    }

	unlink('csv/' . $csvname);


	header("Location: message.php?message=$status");




