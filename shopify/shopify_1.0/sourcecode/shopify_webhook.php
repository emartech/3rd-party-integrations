<?php
	session_start();

	require ('ShopifyAPI/ShopifyClient.php');

	require 'config.php';

	require 'database.php';

	require ('emarsys.php');

	$shop = $_SESSION['shop'];

	
	// echo "<pre>";
	// print_r($_SESSION); 

	// echo "<br>";

	// echo SHOPIFY_API_KEY;

	// echo "<br>";

	// echo SHOPIFY_SECRET;
	


    $shopifyClient = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);

    	
	$events = array(
		//UNSTALL
		'app/uninstalled',
		//CARTS
		'carts/create',
		'carts/update',
		//CHECKOUTS
		'checkouts/create',
		'checkouts/delete',
		'checkouts/update',
		//CUSTOMERS
		'customers/create',
		'customers/delete',
		'customers/disable',
		'customers/enable',
		'customers/update',
		//OREDRS
		'orders/cancelled',
		'orders/create',
		'orders/delete',
		'orders/fulfilled',
		'orders/paid',
		'orders/partially_fulfilled',
		'orders/updated',
		//PRODUCTS
		'products/create',
		'products/delete',
		'products/update'
	);


	$hook = array(
		//UNISTALL
		'app_uninstalled.php',
		//CARTS
		'carts_create.php',
		'carts_update.php',
		//CHECKOUTS
		'checkouts_create.php',
		'checkouts_delete.php',
		'checkouts_update.php',
		//CUSTOMERS
		'customers_create.php',
		'customers_delete.php',
		'customers_disable.php',
		'customers_enable.php',
		'customers_update.php',
		//ORDERS
		'orders_cancelled.php',
		'orders_create.php',
		'orders_delete.php',
		'orders_fulfilled.php',
		'orders_paid.php',
		'orders_partially_fulfilled.php',
		'orders_updated.php',
		//PRODUCTS
		'products_create.php',
		'products_delete.php',
		'products_update.php'
	);

	// 	echo "<pre>";

	// print_r($events);

	// print_r($hook);


	/*
	// delete all webhook code ---------------

	$webhook_detail = $shopifyClient->call('GET', '/admin/webhooks.json');

	echo "<pre>";
	print_r($webhook_detail);


	echo "<br>";

	echo "now deleting the all webhooks...";

	foreach ($webhook_detail as $data) {

		$id = $data['id'];

		$shopifyClient->call('DELETE', '/admin/webhooks/'. $id .'.json');
	}

	$webhook_detail1 = $shopifyClient->call('GET', '/admin/webhooks.json');

	echo "<pre>";
	print_r($webhook_detail1);

	echo "<br>";

	echo "webhooks deleted successfully.";

	//----------------------------------------------
	
*/

	// server path is used in app so it is for emarsys where the script is located.
	
	$server_path = APP_URI;
		
	for ($i=0; $i < count($events); $i++) { 
		
		$hook_path = $server_path .'webhook/' . $hook[$i] ; 
	
		$webhook_data = array(
			
			"webhook" => array(

				"topic" => trim($events[$i]),

				"address" => $hook_path,  // path for webhook

				"format" => "json"
			)
		);	


		$webhook_detail = $shopifyClient->call('POST', '/admin/webhooks.json', $webhook_data);

		// echo "<pre>";
		// print_r($webhook_data);

		// print_r($webhook_detail);
		
		



		// insert webhook id in databse --------------------


		$webhook_id =  $webhook_detail['id'];

		$sql_query = "INSERT INTO shopify_webhook (id, store_name, shopify_webhook_id) VALUES ('', '" . trim($shop) . "', '" . trim($webhook_id) . "')";

		mysqli_query($con, $sql_query);


		//---------------------------------------------------


		unset($webhook_data);

	}


	echo "success";		
	




