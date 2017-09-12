<?php
/*
* Customer Create
*/
	session_start();

	require ('../ShopifyAPI/ShopifyClient.php');

	require '../config.php';

	require '../database.php';

	require ('../emarsys.php');

	define('CUSTOMER_CREATE', 6);

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

		$shop = $hmac_shop;

		$data = file_get_contents('php://input');
		
		$verified = verify_webhook($data, $hmac_header);

// verify the webhook 1 is true
if($verified == 1){



	//-------- get the webhook data ------------

	$webhookContent = "";

	$webhook = fopen('php://input' , 'rb');
	while (!feof($webhook)) {
	    $webhookContent .= fread($webhook, 4096);
	}

	fclose($webhook);

	//  $webhookContent;

	$file1 = fopen('a1_create.txt', 'w');
	echo fwrite($file1, $verified);
	fclose($file1);

	//--------------------------------


	$shopify_data = json_decode($webhookContent, true);

	if(DEV_ENV){
		$sfd = fopen('shopify_customer_create.txt', 'w');
		fwrite($sfd, $webhookContent);
		fclose($sfd);
	}

	

	$sql_optin = "SELECT * FROM emarsys_optin where store_name='" . trim($hmac_shop) . "'";
      

	  $result_optin = $con->query($sql_optin);

      if ($result_optin->num_rows > 0) {
                
      	// output data of each row
      	while($row_optin = $result_optin->fetch_assoc()) {

        	$shop_optin = $row_optin["optin"];

        }
    }




      $sql = "SELECT * FROM emarsys_contacts where store_name='" . trim($hmac_shop) . "'";
      

	  $result = $con->query($sql);

      if ($result->num_rows > 0) {
                
      	// output data of each row
      	while($row = $result->fetch_assoc()) {

        	$emarsys_contact_id = $row["emarsys_shopify_contact_id"];

        	$emarsys_contact_status = $row["emarsys_shopify_contact_status"];

        }
    }





    // get the customer email for sent the mail to the customer -----
    $sql_email = "SELECT * FROM store where store_name='" . trim($hmac_shop) . "'";
      

	  $result_email = $con->query($sql_email);

      if ($result_email->num_rows > 0) {
                
      	// output data of each row
      	while($row_email = $result_email->fetch_assoc()) {

        	$shop_token = $row_email["token"];

        }
    }

   

    $shopifyClient = new ShopifyClient($hmac_shop, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);

    $shop_detail = $shopifyClient->call('GET', '/admin/shop.json');

  
    	$shopname = $shop_detail['name'];



    $arr = array(
		'key_id' => $emarsys_contact_id,

		$emarsys_contact_id => $shopify_data['id'],

		$emarsys_contact_status => '1',

		'1' => $shopify_data['first_name'],
		
		'2' => $shopify_data['last_name'],
		
		'3' => $shopify_data['email']

	);







 	// check if shop is single optin---
    
    if($shop_optin == 1){
    	
    	if($shopify_data['accepts_marketing']){
		
			//true on emarsys
			$arr['31'] = '1';
		
		}

    }elseif ($shop_optin == 2) {

    	$arr['31'] = '';

    	// trigger shopify_optin event for sent mail to customer ------

    }	


  


	
	// updating a contact
	// PUT https://api.emarsys.net/api/v2/contact

	if($shopify_data['verified_email']){
		$verify_email = 1;
	}else{
		$verify_email = 0;
	}	

	// get emarsys_shopify_contact_id from db and update customewr on its behalf

      // $sql = "SELECT * FROM emarsys_contacts where store_name='" . trim($_SESSION['shop']) . "'";

  




	// get store contact schema --------------


    $sql_schema = "SELECT * FROM contact_mapping where store_name='" . trim($hmac_shop) . "'";
      

	  $result_schema = $con->query($sql_schema);

      if ($result_schema->num_rows > 0) {
                
      	// output data of each row
      	while($row_schema = $result_schema->fetch_assoc()) {

        	$shopify_schema_id = $row_schema["shopify_field_id"];

        	$emarsys_schema_id = $row_schema["emarsys_field_id"];

        	$schema[$shopify_schema_id] = $emarsys_schema_id;

        	$schema_key[] = $row_schema["shopify_field_id"];
        	
        }
    }

    $test_contact_mapping1 = json_encode($schema);

    $test_contact_mapping2 = json_encode($schema_key);

    $test_contact_mapping = $test_contact_mapping1 . $test_contact_mapping2;

    $file1 = fopen('test_contact_mapping.txt', 'w');
	echo fwrite($file1, $test_contact_mapping);
	fclose($file1);




    // get customer fields -------

    $sql_contact_schema = "SELECT * FROM contact_fields";
      

	  $result_contact_schema = $con->query($sql_contact_schema);

      if ($result_contact_schema->num_rows > 0) {
                
      	// output data of each row
      	while($row_contact_schema = $result_contact_schema->fetch_assoc()) {

        	$shopify_contact_schema[] = $row_contact_schema["id"];

        	$shopify_contact_schema_name[] = $row_contact_schema["shopify_field"];

        	
        }
    }


    $shopify_contact_schema1 = json_encode($shopify_contact_schema);

    $shopify_contact_schema_name2 = json_encode($shopify_contact_schema_name);

    $test_contact_mapping1 = $shopify_contact_schema1 . $shopify_contact_schema_name2;

    $file1 = fopen('test_test_contact_mapping1.txt', 'w');
	echo fwrite($file1, $test_contact_mapping1);
	fclose($file1);






    foreach ($shopify_contact_schema as $key => $value) {
    	# code...

    	if(in_array($value, $schema_key)){

    		// put  -1 in $value

    		$final_val = $value-1;

    		$shopify_fiels_name = $shopify_contact_schema_name[$final_val];

    		if($value >= 16){

    			if(!empty($shopify_data['default_address'])){

    				$arr[$schema[$value]] = $shopify_data['default_address'][$shopify_fiels_name];
    			}

    			
    		}else{

    			$arr[$schema[$value]] = $shopify_data[$shopify_fiels_name];
    		}
    		
    	}

    }




    // get the country code for emarsys
    $shopify_country = $shop_detail['country_name'];
    
    if(!empty($shopify_data['default_address'])){

    	$shopify_country = $shopify_data['default_address']['country'];
    }

   if (array_key_exists("14",$arr)) {

   		
  		
  	  $sql_country = "SELECT * FROM country where country='" . trim($shopify_country) . "'";
      

	  $result_country = $con->query($sql_country);

      if ($result_country->num_rows > 0) {
                
      	// output data of each row
      	while($row_country = $result_country->fetch_assoc()) {

        	$emarsys_country_id = $row_country["emarsys_code"];
        	
        }
   	 }


   	 $arr['14'] = $emarsys_country_id;

  } // end of key exists 

	

	$emarsys_json =  json_encode($arr);

	$file1 = fopen('a1_json_create.txt', 'w');
	echo fwrite($file1, $emarsys_json);
	fclose($file1);

	$emarsyClient->send('POST', 'contact', $emarsys_json);


	// send the optin mail to customer ----------------------------------
	// send the optin mail to customer ----------------------------------
	if ($shop_optin == 2) {

		if($shopify_data['accepts_marketing']){

			$sql123 = "SELECT * FROM emarsys_external_events where store_name='" . trim($shop) . "' AND eventName='Shopify_confirmation_email') ";

             $result_contact_id123 = $con->query($sql123);

             if ($result_contact_id123->num_rows > 0) {
                
                // output data of each row
                while($row_contact_id123 = $result_contact_id123->fetch_assoc()) {

                    $db_external_event_optin_id = $row_contact_id123["eventEmarsysID"];
                }
            }



            //---------------------------------------------

            $sql123 = "SELECT * FROM emarsys_external_events where store_name='" . trim($shop) . "' AND eventName='Shopify_welcome_email') ";

             $result_contact_id123 = $con->query($sql123);

             if ($result_contact_id123->num_rows > 0) {
                
                // output data of each row
                while($row_contact_id123 = $result_contact_id123->fetch_assoc()) {

                    $db_external_event_welcome_id = $row_contact_id123["eventEmarsysID"];
                }
            }



		
    		$random = rand(1000,9999);
		
			$shopify_user_id = $shopify_data['id'];

			$user_email = $shopify_data['email'];

			$name = $shopify_data['first_name'];



			// trigger an external event Shopify Confirmation Email ----------

    		$email_campaign = $emarsyClient->send('POST', 'event/'.$db_external_event_optin_id.'/trigger', '{
  "key_id": "3",
  "external_id": "'.$user_email.'",
  "data": {
    "name": "'.$name.'",
    "random": "'.$random.'",
    "shopify_user_id": "'.$shopify_user_id.'"
  },
  "contacts": null
}');



    		$email_campaign = $emarsyClient->send('POST', 'event/'.$db_external_event_welcome_id.'/trigger', '{
  "key_id": "3",
  "external_id": "'.$user_email.'",
  "data": {
    "name": "'.$name.'",
    "store": "'.$shopname.'"        
  },
  "contacts": null
}');


    	}

	}  // end of shop_optin






	/*
	*		TRIGGER CUSTOMER CREATE EVENT START
	*/

	$query = "SELECT * FROM `emarsys_event_mapper` WHERE `fkShopifyEventID` = '" . CUSTOMER_CREATE . "' AND `store_name` = '" . trim($hmac_shop) . "'";
	$result = $con->query($query);
	if(DEV_ENV){
		$file = fopen('customer_create_paylooad.txt', 'w');
	}
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		if(!empty($row['fkEventID'])){
			$query = "SELECT * FROM `emarsys_external_events` WHERE `pkEventID` = '" . $row['fkEventID'] . "' AND `store_name` =  '" . trim($hmac_shop) . "' AND eventStatus = '1'";
			$result = $con->query($query);
			if($result->num_rows > 0){
				
				$emarsys_event = $result->fetch_assoc();

				//GET emarsys event ID
				$emarsys_event_id = $emarsys_event['eventEmarsysID'];

				$query = "SELECT * FROM `emarsys_customer_placeholder` WHERE `fkShopifyEventID` = ' " . CUSTOMER_CREATE . "' AND `store_name` = '" . $hmac_shop . "'";
				$result = $con->query($query);
				if($result->num_rows > 0){
					require_once 'payload/customers.php';
				}
			}
		}
	}

	/*
	*		TRIGGER CUSTOMER CREATE EVENT END
	*/ 



	unset($arr);

	unset($schema);

	unset($schema_key);

	unset($shopify_contact_schema_name);

	unset($shopify_contact_schema);

	// unset($arr);

	// unset($arr);

	// unset($arr);


} // end of verification 