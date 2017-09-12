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

	 $checklist_id = $_GET['id'];


	if(!empty($checklist_id)){
	

	switch ($checklist_id) {
		
		case '21':
			# code...

			$sql = "SELECT * FROM emarsys_credentials where store_name='". $shop ."'";

			$result = $con->query($sql);

            if ($result->num_rows > 0) {
                
                // output data of each row
                while($row = $result->fetch_assoc()) {

                    $emarsys_username = $row["emarsys_username"];

                    $emarsys_password = $row["emarsys_password"];
     
                }
            }

            // test emarsys api 
            $response = $emarsyClient->send('GET', 'settings');

            $response_json = json_decode($response, true);

            if($response_json["replyText"] == "OK"){
            	
            	$status = 'Enable';
            }else{

            	$status = 'Disable';
            }

            //update status in database---
            $sql1 = "SELECT * FROM checklist where store_name='" . trim($shop) . "' AND property_id='".$checklist_id."'";
      
			$result1 = $con->query($sql1);


			if ($result1->num_rows > 0) {
				
				### update query
				$sql_query = "UPDATE checklist SET status ='".$status."' where store_name='" . trim($shop) . "' AND property_id='".$checklist_id."'";

				mysqli_query($con, $sql_query);
		
			}else{
			
				### insert query
				$sql = "INSERT INTO checklist (id, store_name, property_id, status) VALUES ('', '" . trim($shop) . "', '" . trim($checklist_id) . "', '" . trim($status) . "')";

				mysqli_query($con, $sql);
			
			}	


			break;

		case '22':
			# code...

			$sql21 = "SELECT * FROM sftp_credentials where store_name='". $shop ."'";

			$result21 = $con->query($sql21);

            if ($result21->num_rows > 0) {
                
                // output data of each row
                while($row21 = $result21->fetch_assoc()) {

                    $sftp_hostname = $row21["sftp_hostname"];

                    $sftp_username = $row21["sftp_username"];

                    $sftp_password = $row21["sftp_password"];

                }
            }

            $sftp = new Net_SFTP($sftp_hostname);
			
			$status = 'Disable';

			if ($sftp->login($sftp_username, $sftp_password)) {
    		
    			$status = 'Enable';
			}
			
			// echo($status);

			//update status in database---
            $sql1 = "SELECT * FROM checklist where store_name='" . trim($shop) . "' AND property_id='".$checklist_id."'";
      
			$result1 = $con->query($sql1);


			if ($result1->num_rows > 0) {
				
				### update query
				$sql_query = "UPDATE checklist SET status ='".$status."' where store_name='" . trim($shop) . "' AND property_id='".$checklist_id."'";

				mysqli_query($con, $sql_query);
		
			}else{
			
				### insert query
				$sql = "INSERT INTO checklist (id, store_name, property_id, status) VALUES ('', '" . trim($shop) . "', '" . trim($checklist_id) . "', '" . trim($status) . "')";

				mysqli_query($con, $sql);
			
			}	


			break;

			
		case '23':
			# code...

		$sql21 = "SELECT * FROM sftp_si_credentials where store_name='". $shop ."'";

			$result21 = $con->query($sql21);

            if ($result21->num_rows > 0) {
                
                // output data of each row
                while($row21 = $result21->fetch_assoc()) {

                    $sftp_hostname = $row21["sftp_hostname"];

                    $sftp_username = $row21["sftp_username"];

                    $sftp_password = $row21["sftp_password"];

                }
            }

             $sftp = new Net_SFTP($sftp_hostname);
			
			$status = 'Disable';

			if ($sftp->login($sftp_username, $sftp_password)) {
    		
    			$status = 'Enable';
			}
			
			// echo($status);

			//update status in database---
            $sql1 = "SELECT * FROM checklist where store_name='" . trim($shop) . "' AND property_id='".$checklist_id."'";
      
			$result1 = $con->query($sql1);


			if ($result1->num_rows > 0) {
				
				### update query
				$sql_query = "UPDATE checklist SET status ='".$status."' where store_name='" . trim($shop) . "' AND property_id='".$checklist_id."'";

				mysqli_query($con, $sql_query);
		
			}else{
			
				### insert query
				$sql = "INSERT INTO checklist (id, store_name, property_id, status) VALUES ('', '" . trim($shop) . "', '" . trim($checklist_id) . "', '" . trim($status) . "')";

				mysqli_query($con, $sql);
			
			}
			break;
			

		// case 'value':
			
		// 	break;			
		
		
	}

}

header("Location: shop.php");


?>