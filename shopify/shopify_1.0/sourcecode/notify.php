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

	
	// for testing---------
	// $export_id = '85379';


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



		$shopify_fields = array('first_name' => '1', 'last_name' => '2', 'email' => '3', 'company' =>'18', 'city' => '11', 'province' => '12', 'zip' => '13', 'phone' => '15', 'accepts_marketing' => '31' );

		$shopify_info = array_flip($shopify_fields);


		$shopify_field_value = array_values($shopify_fields);
		$shopify_field_key = array_keys($shopify_fields);


// echo "<pre>";
// print_r($shopify_fields);

// echo "<pre>";
// print_r($shopify_info);

// echo "<pre>";
// print_r($shopify_field_value);

// echo "<pre>";
// print_r($shopify_field_key);	



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

   					for ($i=0; $i < count($shopify_field_value)-1; $i++) { 
   

    					$optin_response = $emarsyClient->send('GET', '/contact/last_change/?key_id=3&key_value='.$email.'&field_id='.$shopify_field_value[$i], '');

						$response = json_decode($optin_response, true);


						// echo "<pre>";

						// print_r($response);
	

						if( !empty($response['data']) ){

							$emarsys_time = $response['data']['time'];

							$emarsys_optin = $response['data']['current_value'];


							$emarsys_field_id = $shopify_field_value[$i];

// echo($shopify_field_value[$i]);

// echo("<br>");


							// only in case of optin
							if($shopify_field_value[$i]  == '31'){
								
								if($emarsys_optin == '2'){
									
									$emarsys_optin_val = 'false';
								}

								if($emarsys_optin == '1'){
									$emarsys_optin_val = 'true';
								}	
							}



							// get the shopify time before update optin on shopify -
							// GET /admin/customers/#{id}.json
							$shopify_data = $sc->call('GET', '/admin/customers/'.$shopify_contact_id.'.json', array());

							// $shopify_data = json_decode($customer_data, true); 

							// echo("<pre>");
							// print_r($customer_data);



							$default_address_id = $shopify_data['default_address']['id'];


							
							// get the field name over shopify
							$shopify_name = $shopify_info[$emarsys_field_id];

							
							// if( ($shopify_field_value[$i] == '18') || ($shopify_field_value[$i] =='11') || ($shopify_field_value[$i] =='12') || ($shopify_field_value[$i] == '13') ) {

							// 	// get the field name over shopify
							// 	$shopify_name_default_address = $shopify_info[$emarsys_field_id];
							// }

// echo $shopify_contact_id. " --> ". $shopify_name;
// echo("<br>");

							$shopify_optin = $shopify_data[$shopify_name];


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
// echo("<pre>");
								if( ($shopify_field_value[$i] == '18') || ($shopify_field_value[$i] =='11') || ($shopify_field_value[$i] =='12') || ($shopify_field_value[$i] == '13') ) {

										$customer_optin = array(

											"address" => array(

												"id" => $default_address_id,

												$shopify_name => $emarsys_optin

											)
										);


									// echo("test else <br>");
									// print_r($customer_optin);

									$sc->call('PUT', '/admin/customers/'.$shopify_contact_id.'/addresses/'.$default_address_id.'.json', $customer_optin);


								}else{

									$customer_optin = array(

										"customer" => array(

											"id" => $shopify_contact_id,

											$shopify_name => $emarsys_optin

										)
									);

									// echo("test else <br>");
									// print_r($customer_optin);

									$sc->call('PUT', '/admin/customers/'.$shopify_contact_id.'.json', $customer_optin);

								}

							} // end of valid if

						} // end of response['data']



						$coptin = json_encode($customer_optin);

						
						$filedata = $filedata . ' --> ' . $coptin; 
						
						
						unset($export_data);	
						unset($response);
						unset($shopify_data);
						unset($customer_optin);


$file1 = fopen('notify_a1_create.txt', 'w');
	echo fwrite($file1, $filedata);
	fclose($file1);

					} // end of for loop  shopify_field_value


				} // end of !empty
				
			} // end of if($key)

		 

		} // end of foreach loop 


// remove export_id from database.
$sql_delete = "DELETE FROM emarsys_contact_export  WHERE store_name='".$shop."'";

				mysqli_query($con, $sql_delete); 

		