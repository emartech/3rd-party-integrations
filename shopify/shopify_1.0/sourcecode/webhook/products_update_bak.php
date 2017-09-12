<?php
	session_start();

	require ('../ShopifyAPI/ShopifyClient.php');

	require '../config.php';

	require '../database.php';

	require ('../emarsys.php');
	
	include('../Net/SFTP.php');


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

   
    // check the csv file nexist on server or not.	
	$filename = "sync_shopify_all_update_products_$token.csv";

/*

	$sftp = new Net_SFTP('exchange.si.emarsys.net');
	
	if ($sftp->login('shopify_synapse_integration', 'Z6Wt3v9DdjWe3NHrQftL')) {
	
	   // echo 'success';	    
		// $sftp->get('sync_shopify_all_products.csv', '/var/www/html/demo/emarsys9545/app/csv/'.$filename);

		// $test =  $sftp->get('sync_shopify_all_products.csv');

		$test = 'abhi';

		$file1 = fopen('out1_a1_json_create.txt', 'w');
			echo fwrite($file1, $test);
			fclose($file1);

	}
*/


		


	
	//-------- get the webhook data ------------

	$webhookContent = "";

	$webhook = fopen('php://input' , 'rb');
	while (!feof($webhook)) {
	    $webhookContent .= fread($webhook, 4096);
	}

	fclose($webhook);

	//--------------------------------


	$shopify_data = json_decode($webhookContent, true); 

	

	// delete the old data
	$id = $shopify_data['id'];

	if($id) {

		   	$file_handle = fopen("csv/sync_shopify_all_update_products_$token.csv", "r");

		    $fptemp = fopen("csv/sync_shopify_all_update_products_$token-final.csv", "w+");
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


	// now put the updated record in csv
	foreach ($shopify_data as $fields) {

		// fputcsv($out, $fields);

		$product_variant['id'] = $fields['id'];

		$product_variant['handle'] = $fields['handle'];


       	// variants--------
        foreach($fields['variants'] as $key => $variant) {

        	if($key == 0){
        	
        		$product_variant['title'] = $fields['title'];

        		$product_variant['body_html'] = $fields['body_html'];

        		$product_variant['vendor'] = $fields['vendor'];	

        		$product_variant['product_type'] = $fields['product_type'];	

        		$product_variant['tags'] = $fields['tags'];	

        		$product_variant['published_scope'] = $fields['published_scope'];	

        		// options--------
       			$product_variant['option1_name'] = $fields['options'][0]['name'];	

        	}


        	$product_variant['option1_value'] = $variant['option1'];

        	if($key == 0){
        		$product_variant['option2_name'] = $fields['options'][1]['name'];
        	}

        	$product_variant['option2_value'] = $variant['option2'];

        	if($key == 0){
        		$product_variant['option3_name'] = $fields['options'][2]['name'];
        	}

        	$product_variant['option3_value'] = $variant['option3'];

        	$product_variant['sku'] = $variant['sku'];	

        	$product_variant['grams'] = $variant['grams'];	

        	$product_variant['inventory_tracker'] = $variant['inventory_management'];	

        	$product_variant['inventory_quantity'] = $variant['inventory_quantity'];

        	$product_variant['inventory_policy'] = $variant['inventory_policy'];

        	$product_variant['fulfillment_service'] = $variant['fulfillment_service'];

        	$product_variant['price'] = $variant['price'];

        	$product_variant['compare_at_price'] = $variant['compare_at_price'];


        	if($variant['requires_shipping'] == 1){
        		$shipping = 'true';
        	}else{
        		$shipping = 'false';
        	}

        	$product_variant['requires_shipping'] = $shipping;


        	if($variant['taxable'] == 1){
        		$taxable = 'true';
        	}else{
        		$taxable = 'false';
        	}

        	$product_variant['taxable'] = $taxable;

        	$product_variant['barcode'] = $variant['barcode'];

        	// for image url
        	if( !empty($variant['image_id']) ){
        		
        		foreach ($fields['images'] as $image) {
        		
        			if($variant['image_id'] == $image['id']){

        				// get image src as per image id
        				$product_variant['image'] = $image['src']; 
        			}
        		}
        	}

        	$product_variant['weight_unit'] = $variant['weight_unit'];

            // create csvfile
            fputcsv($fptemp, $product_variant);
        }


	} // end of foreach to write the csvfile

	// upload the latest file on server
// 	if($sftp->put("sync_shopify_all_products1.csv", "csv/sync_shopify_all_update_products_$token-final.csv", NET_SFTP_LOCAL_FILE)) {
		
// 		unlink("csv/sync_shopify_all_update_products_$token.csv");
// 		unlink("csv/sync_shopify_all_update_products_$token-final.csv");
// 	}

	

// */
	


} // end of verification 