<?php
	session_start();

	require ('../ShopifyAPI/ShopifyClient.php');

	require '../config.php';

	require '../database.php';

	require ('../emarsys.php');

	// echo "<pre>";

	// print_r($_SESSION);


	// $shop = $_SESSION['shop'];

	define('CUSTOMER_DELETE', 10);


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

	//  $webhookContent;

	$file1 = fopen('a3_create.txt', 'w');
	echo fwrite($file1, $verified);
	fclose($file1);

	//--------------------------------


	$shopify_data = json_decode($webhookContent, true); 
	if(DEV_ENV){
		$sfd = fopen('shopify_customer_delete.txt', 'w');
		fwrite($sfd, $webhookContent);
		fclose($sfd);
	}
	/*
	*		TRIGGER CUSTOMER DELETE EVENT START
	*/

	$query = "SELECT * FROM `emarsys_event_mapper` WHERE `fkShopifyEventID` = '" . CUSTOMER_DELETE . "' AND `store_name` = '" . trim($hmac_shop) . "'";
	$result = $con->query($query);
	if(DEV_ENV){
		$file = fopen('customer_delete_paylooad.txt', 'w');
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

				$query = "SELECT * FROM `emarsys_customer_placeholder` WHERE `fkShopifyEventID` = ' " . CUSTOMER_DELETE . "' AND `store_name` = '" . $hmac_shop . "'";
				$result = $con->query($query);
				if($result->num_rows > 0){
					require_once 'payload/customers.php';
				}
			}
		}
	}

	/*
	*		TRIGGER CUSTOMER DELETE EVENT END
	*/ 

	
	// get emarsys_shopify_contact_id from db and update customewr on its behalf

      // $sql = "SELECT * FROM emarsys_contacts where store_name='" . trim($_SESSION['shop']) . "'";

     $sql = "SELECT * FROM emarsys_contacts where store_name='" . trim($hmac_shop) . "'";
      

	  $result = $con->query($sql);

      if ($result->num_rows > 0) {
                
      	// output data of each row
      	while($row = $result->fetch_assoc()) {

        	$emarsys_contact_id = $row["emarsys_shopify_contact_id"];

        }
    }


	$arr = array(
		'key_id' => $emarsys_contact_id,

		$emarsys_contact_id => $shopify_data['id']
		
	);

	$emarsys_json =  json_encode($arr);

	$file1 = fopen('a3_json_create.txt', 'w');
	echo fwrite($file1, $emarsys_json);
	fclose($file1);

	$emarsyClient->send('POST', 'contact/delete', $emarsys_json);


} // end of verification 
