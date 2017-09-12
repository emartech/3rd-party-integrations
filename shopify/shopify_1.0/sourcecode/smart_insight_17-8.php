<?php
	session_start();

	error_reporting(0);
	set_time_limit(0);
	//ini_set('max_execution_time', 9000);
	ini_set('display_errors', 0);
	ini_set('memory_limit', '10240000M');


	require ('ShopifyAPI/ShopifyClient.php');

	require 'config.php';

	require 'database.php';

	require ('emarsys.php');

	include('Net/SFTP.php');

	// echo "<pre>";

	// print_r($_SESSION);

	$shop = $_SESSION['shop'];

	$token = $_SESSION['token'];
  ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Emarsys Admin</title>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php 

            require('nav.php'); 

        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Smart Insights Data</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                   <div class="col-lg-12">


<?php

	// check sftp details available or not.
	$count_query = "SELECT * FROM sftp_si_credentials where store_name = '". $shop ."'";

    $result = $con->query($count_query);

    $rowcount = $result->num_rows;

    if ($result->num_rows > 0) {
                
    // output data of each row
        while($row_sftp = $result->fetch_assoc()) {

        	$sftp_hostname = $row_sftp["sftp_hostname"];

        	$sftp_username = $row_sftp["sftp_username"];

        	$sftp_password = $row_sftp["sftp_password"];
        }
    }


    

    $server_csvname = "smart_insight.csv";

    $server_csvname_local = "server_smart_insight_$token.csv";

    $sftp_file = "error";

    $server_csv_array = array();


    // check the csv file nexist on server or not.  
    $sftp = new Net_SFTP($sftp_hostname);

    // get SI csv file from server  to local ---
    if ($sftp->login($sftp_username, $sftp_password)) {
    
        if($sftp->file_exists($server_csvname) ){

            if($sftp->get("$server_csvname", "csv/$server_csvname_local")){

                // echo("abhshek");

                // print_r(fgetcsv("$csv/$server_csvname_local"));

                // read  csv file in array
                $file_handle = fopen("csv/$server_csvname_local", "r");
      
                while (!feof($file_handle) ) {

                    $val = fgetcsv($file_handle, 1024);

                    // echo("<pre>");

    // print_r($val);


                    if(!empty($val[0])){
                
                        $server_csv_array[] = $val;
                    }
                }

            }

            $sftp_file = "success";     
        }else{

            $sftp_file = "error";
        }

    }

    // echo("<pre>");

    // print_r($server_csv_array);

    // get the SI data fro the table ------
    $si_query1 = "SELECT * FROM smart_insight_webhook where store_name = '". $shop ."'";

    $si_result1 = $con->query($si_query1);

    if ($si_result1->num_rows > 0) {
                
    // output data of each row
        while($si_row1 = $si_result1->fetch_assoc()) {

            // get webhhok id in
            $si_webhook1 = $si_row1['webhook_id'];

            // delete data from smart_insight table------
            // $delete_sql = "DELETE FROM smart_insight WHERE webhook_id='".$si_webhook1."'";

            // $con->query($delete_sql);
        }
    }     







// get the SI data for REFUND order from the table ------
    $si_query_refund = "SELECT * FROM smart_insight where store_name = '". $shop ."' AND status= 0 group by webhook_id";

    $si_result_refund = $con->query($si_query_refund);

    $si_data_refund = array();

    if ($si_result_refund->num_rows > 0) {
                
    // output data of each row
        while($si_row_refund = $si_result_refund->fetch_assoc()) {

            // store webhhok id in table for avoid in future---

            $si_webhook = $si_row_refund['webhook_id'];

            $sql_webhook = "INSERT INTO smart_insight_webhook (id, store_name, webhook_id) VALUES ('', '" . trim($shop) . "', '" . trim($si_webhook) . "')";


            mysqli_query($con, $sql_webhook);

            //----------------------------------------
            // get all the order which is refunded and need to be update on CSV.
            $si_data_refund[] = $si_row_refund['order_name'];

            
        }
    }
// echo("<pre>");
//             print_r($si_data_refund);








    // get the SI data for PAID order from the table ------
    $si_query = "SELECT * FROM smart_insight where store_name = '". $shop ."' AND status= 1 group by webhook_id";

    $si_result = $con->query($si_query);

    $si_data = array();

    if ($si_result->num_rows > 0) {
                
    // output data of each row
        while($si_row = $si_result->fetch_assoc()) {

            // store webhhok id in table for avoid in future---

            $si_webhook = $si_row['webhook_id'];

            $sql_webhook = "INSERT INTO smart_insight_webhook (id, store_name, webhook_id) VALUES ('', '" . trim($shop) . "', '" . trim($si_webhook) . "')";


            mysqli_query($con, $sql_webhook);

            //----------------------------------------

        	$si_data[] = array_values(unserialize($si_row['data']));

            
        }
    }

// echo("<pre>");
// print_r($final_array);            
// print_r($si_data);





    $server_csvname_local_updated = "smart_insight_updated_$token.csv";

    $out = fopen("csv/$server_csvname_local_updated", "w+");

  if(!empty($server_csv_array)){


    // already csv file on server----
    $final_array = array_merge($server_csv_array, $si_data);




    //update the refund status ----
    foreach ($final_array as $key => $value) {
        if($key > 0){

            if (in_array($value[2], $si_data_refund)){
                // echo "Match found";
                $value[1] = -($value[1]);
            }

        }

        fputcsv($out, $value);
    }

  }else{

    $headers = ['item', 'price', 'order', 'timestamp', 'customer', 'quantity', 's_status'];

    fputcsv($out, $headers);

    foreach ($si_data as $key => $value) {
        // create csvfile

        $si_file['item'] = $value['0'];

        $si_file['price'] = -$value['1'];    
       
        $si_file['order'] = $value['2'];

        $si_file['timestamp'] = $value['3'];

        $si_file['customer'] = $value['4'];

        $si_file['quantity'] = $value['5'];

        $si_file['s_status'] = $value['6'];

        

        fputcsv($out, $si_file);
    }

  }


    // upload the csv file on server
  // upload latest file over sftp   
        $sftp->put("$server_csvname", "csv/$server_csvname_local_updated", NET_SFTP_LOCAL_FILE);

    

    unlink("csv/smart_insight_updated_$token.csv");

    
    unset($server_csv_array);

    unset($si_data_refund);

    unset($si_data);

    unset($final_array);

    unset($si_file);

?>

FIle Exported Successfully on SFTP.


                        
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

               
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

   

    

</body>

</html>
