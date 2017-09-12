<?php
	session_start();

	require ('../ShopifyAPI/ShopifyClient.php');

	require '../config.php';

	require '../database.php';

	require ('../emarsys.php');

	define('CUSTOMER_ENABLE', 8);

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

	//-------- get the webhook data ------------

	$webhookContent = "";

	$webhook = fopen('php://input' , 'rb');
	while (!feof($webhook)) {
	    $webhookContent .= fread($webhook, 4096);
	}

	fclose($webhook);

	//--------------------------------


	$shopify_data = json_decode($webhookContent, true); 

	if(DEV_ENV){
		$sfd = fopen('shopify_customer_enable.txt', 'w');
		fwrite($sfd, $webhookContent);
		fclose($sfd);
	}

	/*
	*		TRIGGER CUSTOMER ENABLE EVENT START
	*/

	$query = "SELECT * FROM `emarsys_event_mapper` WHERE `fkShopifyEventID` = '" . CUSTOMER_ENABLE . "' AND `store_name` = '" . trim($hmac_shop) . "'";
	$result = $con->query($query);
	if(DEV_ENV){
		$file = fopen('customer_enable_paylooad.txt', 'w');
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

				$query = "SELECT * FROM `emarsys_customer_placeholder` WHERE `fkShopifyEventID` = ' " . CUSTOMER_ENABLE . "' AND `store_name` = '" . $hmac_shop . "'";
				$result = $con->query($query);
				if($result->num_rows > 0){
					$binding = $result->fetch_assoc();

					$global_var = [];
					//GENERATE PAYLOAD

					if(!empty($binding['customer_id'])){
						$global_var[$binding['customer_id']] = $shopify_data['id'];
					}
					if(!empty($binding['customer_email'])){
						$global_var[$binding['customer_email']] = $shopify_data['email'];
					}
					if(!empty($binding['customer_first_name'])){
						$global_var[$binding['customer_first_name']] = $shopify_data['first_name'];
					}
					if(!empty($binding['customer_last_name'])){
						$global_var[$binding['customer_last_name']] = $shopify_data['last_name'];
					}
					if(!empty($binding['customer_orders_count'])){
						$global_var[$binding['customer_orders_count']] = $shopify_data['orders_count'];
					}
					if(!empty($binding['customer_phone'])){
						$global_var[$binding['customer_phone']] = $shopify_data['phone'];
					}
					if(!empty($binding['customer_address'])){
						$i = 0;
						$customer_address = [];
						foreach($shopify_data['addresses'] as $val){
							 if(!empty($binding['address_first_name'])){
							 	$customer_address[$i][$binding['address_first_name']] = $val['first_name'];
							 }
						     if(!empty($binding['address_last_name'])){
						     	$customer_address[$i][$binding['address_last_name']] = $val['last_name'];
						     }
						     if(!empty($binding['address_address1'])){
						     	$customer_address[$i][$binding['address_address1']] = $val['address1'];
						     }
						     if(!empty($binding['address_phone'])){
						     	$customer_address[$i][$binding['address_phone']] = $val['phone'];
						     }
						     if(!empty($binding['address_city'])){
						     	$customer_address[$i][$binding['address_city']] = $val['city'];
						     }
						     if(!empty($binding['address_province'])){
						     	$customer_address[$i][$binding['address_province']] = $val['province'];
						     }
						     if(!empty($binding['address_country'])){
						     	$customer_address[$i][$binding['address_country']] = $val['country'];
						     }
						     if(!empty($binding['address_name'])){
						     	$customer_address[$i][$binding['address_name']] = $val['name'];
						     }
							$i++;
						}
					}

					$payload = [
						"key_id" =>  "32",
	  					"external_id" => "1",
						'data' => []
					];

					if(!empty($global_var)){
						$payload['data']['global'] = $global_var;
					}
					if(!empty($customer_address)){
						$payload['data'][$binding['customer_address']] = $customer_address;
					}


					
					$payload = json_encode($payload);
					/*
					* https://api.emarsys.net/api/v2/event/1667/trigger
					*/
					$res = json_decode($emarsyClient->send('POST', 'event/' . $emarsys_event_id . '/trigger', $payload));

				}
			}
		}
	}

	/*
	*		TRIGGER CUSTOMER ENABLE EVENT END
	*/ 
	
	// get emarsys_shopify_contact_id from db and update customewr on its behalf

     $sql = "SELECT * FROM emarsys_contacts where store_name='" . trim($hmac_shop) . "'";
      

	  $result = $con->query($sql);

      if ($result->num_rows > 0) {
                
      	// output data of each row
      	while($row = $result->fetch_assoc()) {

        	$emarsys_contact_id = $row["emarsys_shopify_contact_id"];

        	$emarsys_contact_status = $row["emarsys_shopify_contact_status"];

        }
    }


	$arr = array(
		'key_id' => $emarsys_contact_id,

		$emarsys_contact_id => $shopify_data['id'],
		
		$emarsys_contact_status => '1'
		
	);

	$emarsys_json =  json_encode($arr);

	$emarsyClient->send('PUT', 'contact', $emarsys_json);


} // end of verification 
	




