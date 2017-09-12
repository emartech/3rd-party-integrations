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
                        <h3 class="page-header">Manual Sync</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                   <div class="col-lg-12">


<?php
// shopify connection	
	$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);


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
		$orders_count = $sc->call('GET', '/admin/products/count.json', array());

		// $products_count = 749;
		
		$quotient = ($orders_count / 250);

		$total_links = intval($quotient) + 1;

		$product_array = array();

		for($i=1; $i<=$total_links; $i++){

			// put 250 records in array default
			$product_array[] = $sc->call("GET", "/admin/products.json?limit=250&page=$i", array());
					
		}

		// serialize array and write in file
		$product_array_serialized = serialize($product_array);

		$filename = "all_product-$token.txt";

		$file1 = fopen('csv/'.$filename, 'w');

		fwrite($file1, $product_array_serialized);
		// fwrite($file1, print_r($product_array, TRUE));
		fclose($file1);


		unset($product_array);



		?>

		<!-- <p><a href="sync_product_csv.php">Click Here</a> to finalized the sync.</p> -->

        <div class="alert alert-success">
                <a href="sync_product_csv_new.php" class="alert-link"><strong>Click Here</strong></a> to export the product data.
        </div>
		
		


            <div class="panel panel-default">
                <div class="panel-heading">The csv file will export on below location:</div>
                
                <div class="panel-body">
                    <p>FTP: <?php echo $db_sftp; ?> </p>
                    <p>Folder: / </p>
                    <p>Filename: sync_shopify_all_products.csv</p>
                </div>
            </div>



		
                        
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
