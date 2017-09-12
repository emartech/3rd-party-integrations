<?php 
    require ('ShopifyAPI/ShopifyClient.php');

    require 'config.php';

    require 'database.php';

    require 'emarsys.php';

	//-------- get the webhook data ------------

	$webhookContent = "";

	$webhook = fopen('php://input' , 'rb');
	while (!feof($webhook)) {
	    $webhookContent .= fread($webhook, 4096);
	}

	fclose($webhook);

	//--------------------------------

	
	$notify_data = json_decode($webhookContent, true); 

	$export_id = $notify_data['id'];


	// get shop name
	$sql = "SELECT * FROM emarsys_contact_export where emarsys_export_id='" . trim($export_id) . "'";
          

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        
        // output data of each row
        while($row = $result->fetch_assoc()) {

            $shop = $row["store_name"];
        
        }
    }


    $sql1 = "SELECT * FROM store where store_name='" . trim($shop) . "'";
          

    $result1 = $con->query($sql1);

    if ($result1->num_rows > 0) {
        
        // output data of each row
        while($row1 = $result1->fetch_assoc()) {

            $shopify_token = $row1["token"];
        
        }
    }

 //    echo $shop;
	// echo "<br>";
 //    echo $shopify_token;

    // shopify connection--------
    $sc = new ShopifyClient($shop, $shopify_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);



    	// get the export data
 		$emarsys_export_data = $emarsyClient->send('GET', 'export/'.$export_id.'/data/?offset=0&limit=100', '');

		$export_lines = explode(PHP_EOL, $emarsys_export_data);
		
		$emarsys_export_arr = array();
		
		foreach ($export_lines as $line) {
		   
		    $emarsys_export_arr[] = str_getcsv($line);
		}
		
		// echo "<pre>";
		// print_r($emarsys_export_arr);

		foreach ($emarsys_export_arr as $key => $value) {
			
			// echo $key;
			if($key > 0){
				
				if(!empty($value[0])){
					// echo $key;

					$export_data = explode(';', $value[0]);

					// print_r($export_data);

    				$shopify_contact_id = $export_data[1];
    				
    				$email = $export_data[2];


    				// it will execute in loop for multiple email id which we found in "Export File"	
    // $email = 'abhilashpratapsingh@gmail.com'; 
    // $shopify_contact_id = '5700095378';

    $optin_response = $emarsyClient->send('GET', '/contact/last_change/?key_id=3&key_value='.$email.'&field_id=31', '');

	$response = json_decode($optin_response, true);


	// echo "<pre>";

	// print_r($response);
	

	if( !empty($response['data']) ){

		$emarsys_time = $response['data']['time'];

		$emarsys_optin = $response['data']['current_value'];

		if($emarsys_optin == '2'){
			$emarsys_optin_val = 'false';
		}

		if($emarsys_optin == '1'){
			$emarsys_optin_val = 'true';
		}



		// get the shopify time before update optin on shopify -
		// GET /admin/customers/#{id}.json
		$customer_data = $sc->call('GET', '/admin/customers/'.$shopify_contact_id.'.json', array());

		$shopify_data = json_decode($customer_data, true); 

		$shopify_optin = $shopify_data['accepts_marketing'];

		$shopify_update_time = $shopify_data['updated_at'];



		// date compare and update if the emarsys is latest
		$emarsys_day = strtotime($emarsys_time);

		$shopify_day = strtotime($shopify_update_time);

		if($emarsys_day > $shopify_day) {
		        $valid = "yes";
		    } else {
		        $valid= "no";
		}
		
		if($valid == 'yes'){

			// update the optin on shopify --------
			$customer_optin = array(

				"customer" => array(

					"id" => $shopify_contact_id,

					"accepts_marketing" => $emarsys_optin_val
				)
			);

			$sc->call('PUT', '/admin/customers/'.$shopify_contact_id.'.json', $customer_optin);

		} // end of valid if

	} // end of response['data']

			unset($export_data);	
			unset($response);
			unset($shopify_data);
			unset($customer_optin);





				} // end of !empty
				
			} // end of if($key)
		} // end of foreach loop 








    








