<?php
/*
* Cart Create
*/
session_start();

require_once '../ShopifyAPI/ShopifyClient.php';

require_once '../config.php';

require_once '../database.php';

require_once '../emarsys.php';

// define('ORDER_PAID', 16);

// echo "<pre>";

// print_r($_SESSION);
// $shop = $_SESSION['shop'];


//-------- verify the webhook --------------

function verify_webhook($data, $hmac_header){
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRET, true));
  return hash_equals($hmac_header, $calculated_hmac);
}

$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$hmac_shop = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];

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
		$sfd = fopen('21refund1.txt', 'w');
		fwrite($sfd, $webhookContent);
		fclose($sfd);
	}




	// get the customer email for sent the mail to the customer -----
    $sql_email = "SELECT * FROM store where store_name='" . trim($hmac_shop) . "'";
      

	  $result_email = $con->query($sql_email);

      if ($result_email->num_rows > 0) {
                
      	// output data of each row
      	while($row_email = $result_email->fetch_assoc()) {

        	$shop_token = $row_email['token'];

        }
    }

    $txt = $hmac_shop.' -> '.$shop_token;

    if(DEV_ENV){
		$sfd = fopen('21smart_refund.txt', 'w');
		fwrite($sfd, $txt);
		fclose($sfd);
	}



    $shopifyClient = new ShopifyClient(trim($hmac_shop), trim($shop_token), SHOPIFY_API_KEY, SHOPIFY_SECRET);



   

	// get order name ------
	// GET /admin/orders/#{id}.json

	$order_id = $shopify_data['order_id'];


	// GET /admin/orders/#{id}.json?fields=id,line_items,name,total_price

	$order_detail = $shopifyClient->call('GET', '/admin/orders/'.$order_id.'.json', array());


    $si_name = $order_detail['name'];

    $si_customer_email = $order_detail['customer']['email'];


	// get customer email id -----
	// GET /admin/customers/#{id}.json

	// $user_id = $shopify_data['user_id'];

	// $customer_detail = $shopifyClient->call('GET', '/admin/customers/'.$user_id.'.json');

 //    $si_customer_email = $customer_detail['email'];


    // create smart insight data ------
	$smart_time = date("Y-m-d", strtotime($shopify_data['processed_at']));


	$quantity = 0;

	foreach ($shopify_data['refund_line_items'] as $item) {
		
		$quantity += $item['quantity'];

	}


	 $txt1 = $si_name.' -> '.$si_customer_email.' -> '.$smart_time.' -> '.$quantity;

    if(DEV_ENV){
		$sfd = fopen('221smart_refund.txt', 'w');
		fwrite($sfd, $txt1);
		fclose($sfd);
	}


	$webhook_id = $shopify_data['order_id'];


	$smart_insight = array(
		
		'item' => $shopify_data['order_id'],

		'price' => $shopify_data['transactions'][0]['amount'],

		'order' => $si_name,

		'timestamp' => $smart_time,

		'customer' => $si_customer_email,

		// 'email' => $shopify_data,

		'quantity' => $quantity,

		'status' => '0'
	);

	$smart_data= serialize($smart_insight);



	if(DEV_ENV){
		$sfd = fopen('1smart_refund.txt', 'w');
		fwrite($sfd, $smart_data);
		fclose($sfd);
	}

	// put status = 0, because it is refund.
	$sql123 = "INSERT INTO smart_insight (id, store_name, order_name, data, webhook_id, status) VALUES ('', '" . trim($hmac_shop) . "', '" . trim($si_name) . "', '" . trim($smart_data) . "', '" . trim($webhook_id) . "', '0')";

	mysqli_query($con, $sql123);




