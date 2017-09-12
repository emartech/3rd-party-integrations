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
                        <h3 class="page-header">Sync Orders</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                   <div class="col-lg-12">


<?php
// shopify connection	
	$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);


	// check the csv file nexist on server or not.	
	$sftp = new Net_SFTP('exchange.si.emarsys.net');

	$csvname = "sync_shopify_all_orders.csv";

	$sftp_file = "error";

	if ($sftp->login('shopify_synapse_integration', 'Z6Wt3v9DdjWe3NHrQftL')) {
	
	    if($sftp->file_exists($csvname) ){

	    	$sftp_file = "success";	    
	    }else{

	    	$sftp_file = "error";
	    }

	}


	// check sftp details available or not.
	$count_query = "SELECT * FROM sftp_credentials where store_name = '". $shop ."'";

    $result = $con->query($count_query);

    $rowcount = $result->num_rows;

    if ($result->num_rows > 0) {
                
    // output data of each row
        while($row_sftp = $result->fetch_assoc()) {

        	$db_sftp = $row_sftp["sftp_hostname"];
        }
    }


	
		// code for create file over sftp initially.

		// count total number of products on store.
		$orders_count = $sc->call('GET', '/admin/orders/count.json', array());

		// $products_count = 749;
		
		$quotient = ($orders_count / 250);

		$total_links = intval($quotient) + 1;


		$order_array = array();

		for($i=1; $i<=$total_links; $i++){

			// put 250 records in array default
			$order_array[] = $sc->call("GET", "/admin/orders.json?status=any&limit=250&page=$i", array());
					
		}

		// serialize array and write in file
		$product_array_serialized = serialize($order_array);

		$filename = "all_order-$token.txt";

		$file1 = fopen('csv/'.$filename, 'w');

		fwrite($file1, $product_array_serialized);
		
		fclose($file1);


		unset($order_array);



		?>

		<!-- <p><a href="sync_purchase_csv.php">Click Here</a> to finalized the sync.</p> -->


        <div class="alert alert-success">
                <a href="sync_purchase_csv.php" class="alert-link"><strong>Click Here</strong></a>  to sync the file on SFTP..
        </div>



		
		<?php
			if($sftp_file == 'success'){ ?> 

            <div class="panel panel-default">
                <div class="panel-heading">The csv file will export on below location:</div>
                
                <div class="panel-body">
                    <p>FTP: <?php echo $db_sftp; ?> </p>
                    <p>Folder: / </p>
                    <p>Filename: sync_shopify_all_purchase.csv</p>
                </div>
            </div>

			<?php } ?>
                        
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
