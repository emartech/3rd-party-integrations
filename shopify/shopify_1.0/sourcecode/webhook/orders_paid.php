<?php
/*
* Cart Create
*/
session_start();

require_once '../ShopifyAPI/ShopifyClient.php';

require_once '../config.php';

require_once '../database.php';

require_once '../emarsys.php';

define('ORDER_PAID', 16);

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
// if($verified == 1){

	$webhookContent = "";

	$webhook = fopen('php://input' , 'rb');
	while (!feof($webhook)) {
	    $webhookContent .= fread($webhook, 4096);
	}
	fclose($webhook);

	$shopify_data = json_decode($webhookContent, true);
	if(DEV_ENV){
		$sfd = fopen('shopify_orders_paid.txt', 'w');
		fwrite($sfd, $webhookContent);
		fclose($sfd);
	}

$smart_time = date("Y-m-d", strtotime($shopify_data['updated_at']));

	$quantity = 0;

	foreach ($shopify_data['line_items'] as $item) {
		
		$quantity += $item['quantity'];

	}

	$webhook_id = $shopify_data['id'];

	$order_name = $shopify_data['name'];

	$smart_insight = array(
		
		'item' => $shopify_data['id'],

		'price' => $shopify_data['total_price'],

		'order' => $shopify_data['name'],

		'timestamp' => $smart_time,

		'customer' => $shopify_data['customer']['email'],

		// 'email' => $shopify_data,

		'quantity' => $quantity,

		'status' => '1'
	);

	$smart_data= serialize($smart_insight);

	if(DEV_ENV){
		$sfd = fopen('12test_shopify_orders_paid.txt', 'w');
		fwrite($sfd, $smart_data);
		fclose($sfd);
	}

	// put status = 1, because it is paid.
	$sql123 = "INSERT INTO smart_insight (id, store_name, order_name, data, webhook_id, status) VALUES ('', '" . trim($shop_name) . "', '" . trim($order_name) . "', '" . trim($smart_data) . "', '" . trim($webhook_id) . "', '1')";

	mysqli_query($con, $sql123);

		

	$query = "SELECT * FROM `emarsys_event_mapper` WHERE `fkShopifyEventID` = '" . ORDER_PAID . "' AND `store_name` = '" . trim($shop_name) . "'";
	$result = $con->query($query);
	if(DEV_ENV){
		$file = fopen('orders_paid_payload.txt', 'w');
	}
	if($result->num_rows > 0){
		$row = $result->fetch_assoc();

		if(!empty($row['fkEventID'])){
		//-------- get the webhook data ------------


			$query = "SELECT * FROM `emarsys_external_events` WHERE `pkEventID` = '" . $row['fkEventID'] . "' AND `store_name` =  '" . trim($shop_name) . "' AND eventStatus = '1'";
			$result = $con->query($query);
			if($result->num_rows > 0){
				
				$emarsys_event = $result->fetch_assoc();

				//GET emarsys event ID
				$emarsys_event_id = $emarsys_event->eventEmarsysID;

				$query = "SELECT * FROM `emarsys_order_placeholders` WHERE `fkShopifyEventID` = ' " . ORDER_PAID . "' AND `store_name` = '" . $shop_name . "'";

				$result = $con->query($query);
				if($result->num_rows > 0){
					require_once 'payload/orders.php';
				}
			}

		}
	}




	
		



	

// } // end of verification 