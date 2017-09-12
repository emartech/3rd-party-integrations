<?php
/*
* Cart Create
*/
session_start();

require_once '../ShopifyAPI/ShopifyClient.php';

require_once '../config.php';

require_once '../database.php';

require_once '../emarsys.php';

define('ORDER_CREATE', 13);

// echo "<pre>";

// print_r($_SESSION);
// $shop = $_SESSION['shop'];


//-------- verify the webhook --------------

function verify_webhook($data, $hmac_header){
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRET, true));
  return hash_equals($hmac_header, $calculated_hmac);
}

$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$shop_name = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];

$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);

// verify the webhook 1 is true
if($verified == 1){

	$query = "SELECT * FROM `emarsys_event_mapper` WHERE `fkShopifyEventID` = '" . ORDER_CREATE . "' AND `store_name` = '" . trim($shop_name) . "'";
	$result = $con->query($query);
	if(DEV_ENV){
		$file = fopen('orders_create_paylooad.txt', 'w');
	}
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();

		if(!empty($row['fkEventID'])){
		//-------- get the webhook data ------------

			$webhookContent = "";

			$webhook = fopen('php://input' , 'rb');
			while (!feof($webhook)) {
			    $webhookContent .= fread($webhook, 4096);
			}
			fclose($webhook);

			$shopify_data = json_decode($webhookContent, true);

			if(DEV_ENV){
				$sfd = fopen('shopify_order_carete.txt', 'w');
				fwrite($sfd, $webhookContent);
				fclose($sfd);
			}

			$query = "SELECT * FROM `emarsys_external_events` WHERE `pkEventID` = '" . $row['fkEventID'] . "' AND `store_name` =  '" . trim($shop_name) . "' AND eventStatus = '1'";
			$result = $con->query($query);
			if($result->num_rows > 0){

				$emarsys_event = $result->fetch_assoc();

				//GET emarsys event ID
				$emarsys_event_id = $emarsys_event['eventEmarsysID'];

				$query = "SELECT * FROM `emarsys_order_placeholders` WHERE `fkShopifyEventID` = ' " . ORDER_CREATE . "' AND `store_name` = '" . $shop_name . "'";

				$result = $con->query($query);
				if($result->num_rows > 0){
					require_once 'payload/orders.php';
				}
			}
		}
	}
} // end of verification 