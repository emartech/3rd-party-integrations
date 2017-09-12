<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
require_once '../emarsys.php';
require_once '../database.php';

$external_events = [

	//Cart Events
	'Shopify_cart_create',
	'Shopify_cart_update',

	//Checkout Events
	'Shopify_checkouts_create',
	'Shopify_checkouts_delete',
	'Shopify_checkouts_update',

	//Customer Events
	'Shopify_customers_create',
	'Shopify_customers_delete',
	'Shopify_customers_disable',
	'Shopify_customers_enable',
	'Shopify_customers_update',

	//Fulfillments Events
	'Shopify_fulfillments_create',
	'Shopify_fulfillments_update',

	//Orders Events
	'Shopify_orders_cancelled',
	'Shopify_orders_create',
	'Shopify_orders_delete',
	'Shopify_orders_fulfilled',
	'Shopify_orders_paid',
	'Shopify_orders_partially_fulfilled',
	'Shopify_orders_updated',

	//Product Events
	'Shopify_products_create',
	'Shopify_products_delete',
	'Shopify_products_update',

	//Other Events
	'Shopify_optin',
	'Shopify_welcome_email'

];

$query = "SELECT * FROM `emarsys_credentials` WHERE `store_name` = '" . trim($_SESSION['shop']) . "'";
$result = $con->query($query);


if ($result->num_rows > 0){

	$getAll = json_decode($emarsyClient->send('GET', 'event'));
	foreach($getAll->data as $ev){
		$external_events = array_diff($external_events, [trim($ev->name)]);
	}

	//change after dynamic store
	$storeName = $_SESSION['shop'];

	$query = "INSERT INTO `emarsys_external_events` (store_name, eventEmarsysID, eventName) VALUES";
	$i = 0;
	foreach ($external_events as $event){
		$ev = json_decode($emarsyClient->send('POST', 'event', '
		{
			"name" : "' . $event . '"
		}'));

		if(isset($ev->data->id)){
			if($i != 0){
				$query .= ',';
			}
			$query .= " ('" . $storeName . "', '" . $ev->data->id . "', '" . trim($event) . "')";
		}
		$i++;
	}
	$result = $con->query($query);




	// create a custom field for shopify customer id over emarsys  -----------
		
	$field = $emarsyClient->send('POST', 'field', '{
		"name": "shopify_contact_id",
	  	"application_type": "numeric"
	}');
	
	$emarsys_field = json_decode($field, true);


	// echo "<pre>";
	// print_r($emarsys_field);


	$emarsys_shopify_contact_id = $emarsys_field['data']['id'];


	//---------------- also create a custom field for shopify customer status over emarsys  with name  "shopify_contact_status where 1 = enable and 0 = disable" -----------

	$field1 = $emarsyClient->send('POST', 'field', '{

		"name": "shopify_contact_status",
	  	"application_type": "numeric"
	}');
	
	$emarsys_field1 = json_decode($field1, true);

	// echo "<pre>";
	// print_r($emarsys_field1);

	$emarsys_shopify_contact_status = $emarsys_field1['data']['id'];


	// store emarsys_shopify_contact_id (Field Id) in database ------

	$sql_query = "INSERT INTO emarsys_contacts (id, store_name, emarsys_shopify_contact_id, emarsys_shopify_contact_status) VALUES ('', '" . trim($shop) . "', '" . trim($emarsys_shopify_contact_id) . "','" . trim($emarsys_shopify_contact_status) . "')";

	mysqli_query($con, $sql_query);
	
	//---------------------------------------------------------------------

	header('Location: ../events.php');
}
else{
	header('Location: ../emarsys_details.php');
}