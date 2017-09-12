<?php
	session_start();

	require ('../ShopifyAPI/ShopifyClient.php');

	require '../config.php';

	require '../database.php';

	require ('../emarsys.php');

	include('../Net/SFTP.php');

	define('PRODUCTS_DELETE', 22);

	// echo "<pre>";

	// print_r($_SESSION);


	// $shop = $_SESSION['shop'];


	//-------- verify the webhook --------------
	

	function verify_webhook($data, $hmac_header)
	{
	  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRET, true));
	  return hash_equals($hmac_header, $calculated_hmac);
	}


		$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];

		$hmac_shop = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];

		$data = file_get_contents('php://input');
		
		$verified = verify_webhook($data, $hmac_header);

// verify the webhook 1 is true
if($verified == 1){

	
	$sql_store = "SELECT * FROM store where store_name='" . trim($hmac_shop) . "'";
      
	  $result_store = $con->query($sql_store);

      if ($result_store->num_rows > 0) {
                
      	// output data of each row
      	while($row_optin = $result_store->fetch_assoc()) {

        	$shop_token = $row_optin["token"];

        }
    }

    $token = $shop_token;


    //-------- get the webhook data ------------

	$webhookContent = "";

	$webhook = fopen('php://input' , 'rb');
	while (!feof($webhook)) {
	    $webhookContent .= fread($webhook, 4096);
	}

	fclose($webhook);

	//  $webhookContent;

	$file1 = fopen('delete_a3_create.txt', 'w');
	echo fwrite($file1, $webhookContent);
	fclose($file1);

	//--------------------------------


	$shopify_data = json_decode($webhookContent, true); 

	if(DEV_ENV){
		$sfd = fopen('shopify_product_delete.txt', 'w');
		fwrite($sfd, $webhookContent);
		fclose($sfd);
	}
	/*
	*		TRIGGER PRODUCT DELETE EVENT START
	*/

	$query = "SELECT * FROM `emarsys_event_mapper` WHERE `fkShopifyEventID` = '" . PRODUCTS_DELETE . "' AND `store_name` = '" . trim($shop_name) . "'";
	$result = $con->query($query);
	if(DEV_ENV){
		$file = fopen('products_delete_paylooad.txt', 'w');
	}
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();

		if(!empty($row['fkEventID'])){
			$query = "SELECT * FROM `emarsys_external_events` WHERE `pkEventID` = '" . $row['fkEventID'] . "' AND `store_name` =  '" . trim($shop_name) . "' AND eventStatus = '1'";
			$result = $con->query($query);
			if($result->num_rows > 0){
				
				$emarsys_event = $result->fetch_assoc();

				//GET emarsys event ID
				$emarsys_event_id = $emarsys_event['eventEmarsysID'];

				$query = "SELECT * FROM `emarsys_product_placeholders` WHERE `fkShopifyEventID` = ' " . PRODUCTS_DELETE . "' AND `store_name` = '" . $shop_name . "'";

				$result = $con->query($query);

				if($result->num_rows > 0){
					require_once 'payload/products.php';
				}
			}
		}

	/*
	*		TRIGGER PRODUCT DELETE EVENT END
	*/

	$id = $shopify_data['id'];


	// connect sftp
	$filename = "sync_shopify_all_products_$token.csv";

	$sftp = new Net_SFTP('exchange.si.emarsys.net');
	
	if ($sftp->login('shopify_synapse_integration', 'Z6Wt3v9DdjWe3NHrQftL')) {

		$sftp->get('sync_shopify_all_products.csv', 'csv/'.$filename);
	}



		if($id) {

		    $file_handle = fopen("csv/sync_shopify_all_products_$token.csv", "r");

		    $fptemp = fopen("csv/sync_shopify_all_products_$token-final.csv", "w+");
		    // $file_handle = $abc;

		    $myCsv = array();

		    while (!feof($file_handle) ) {

		        $line_of_text = fgetcsv($file_handle, 1024);   

		        if ($id != $line_of_text[0]) {

		            fputcsv($fptemp, $line_of_text);
		        }
		    }
		    fclose($file_handle);
		}

	// upload latest file over sftp 	
		$sftp->put("sync_shopify_all_products.csv", "csv/sync_shopify_all_products_$token-final.csv", NET_SFTP_LOCAL_FILE);

		unlink("csv/sync_shopify_all_products_$token.csv");
	unlink("csv/sync_shopify_all_products_$token-final.csv");


} // end of verification 
