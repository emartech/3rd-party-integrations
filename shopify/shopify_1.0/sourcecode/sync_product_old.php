<?php
	session_start();

	require ('ShopifyAPI/ShopifyClient.php');

	require 'config.php';

	require 'database.php';

	require ('emarsys.php');

	include('Net/SFTP.php');

	// echo "<pre>";

	// print_r($_SESSION);

	$shop = $_SESSION['shop'];

	$token = $_SESSION['token'];


	// shopify connection	
	$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);


	// check the csv file nexist on server or not.	
	$sftp = new Net_SFTP('exchange.si.emarsys.net');

	$csvname = "sync_shopify_all_products.csv";

	$sftp_file = "error";

	if ($sftp->login('shopify_synapse_integration', 'Z6Wt3v9DdjWe3NHrQftL')) {
	
	    if($sftp->file_exists($csvname, "csv/$csvname", NET_SFTP_LOCAL_FILE)){

	    	$sftp_file = "success";	    
	    }else{

	    	$sftp_file = "error";
	    }

	}

	if($sftp_file == 'error'){
		// code for create file over sftp initially.

		// count total number of products on store.
		$products_count = $sc->call('GET', '/admin/products/count.json', array());

		// $products_count = 749;
		
		$quotient = ($products_count / 250);

		$total_links = intval($quotient) + 1;

		
		// get all product ids for a store.
		$all_product_id = $sc->call('GET', '/admin/products.json?fields=id', array());

		    // echo "<pre>";
		    // print_r($all_product_id);
		    // echo "</pre>";

		    // echo count($all_product_id);

		for($i=0; $i<$total_links; $i++){

			$j_start = 0 + ($i*250);

			if($total_links == 1){
				$j_end = count($all_product_id) -1;	
			}else{
				$j_end = 249 + ($i*250);	
			}
			

			$start = $all_product_id[$j_start]['id'];

			$end = $all_product_id[$j_end]['id'];

			// shopify api call for get products -----
			// GET /admin/products.json?ids=632910392,921728736
			$product_array[] = $sc->call('GET', '/admin/products.json?ids='. $start.','.$end, array());

		}

		// serialize array and write in file
		$product_array_serialized = serialize($product_array);

		$filename = "all_product-$token.txt";

		$file1 = fopen('csv/'.$filename, 'w');

		fwrite($file1, $product_array_serialized);
		// fwrite($file1, print_r($product_array, TRUE));
		fclose($file1);

		unset($product_array);

		?>

		<a href="sync_product_csv.php">Click Here</a> to finalized the sync.
		
		<?php

	}else{
		echo "Products already sync with SFTP.";
	}	


	/*
	   
    

		// GET /admin/products/count.json

		$webhook = $sc->call('GET', '/admin/products/count.json', array());

		    echo "<pre>";
		    echo ($webhook);
		    echo "</pre>";



		// GET /admin/products.json?fields=id,images,title

		// GET /admin/products/count.json

		$webhook1 = $sc->call('GET', '/admin/products.json?fields=id', array());

		    echo "<pre>";
		    var_dump($webhook1);
		    echo "</pre>";









	$json = '{
  "id": 327475578523353102,
  "title": "Example T-Shirt",
  "body_html": null,
  "vendor": "Acme",
  "product_type": "Shirts",
  "created_at": null,
  "handle": "example-t-shirt",
  "updated_at": null,
  "published_at": "2017-03-20T16:04:28-04:00",
  "template_suffix": null,
  "published_scope": "global",
  "tags": "mens t-shirt example",
  "variants": [
    {
      "id": 1234567,
      "product_id": 327475578523353102,
      "title": "",
      "price": "19.99",
      "sku": "example-shirt-s",
      "position": 0,
      "grams": 200,
      "inventory_policy": "deny",
      "compare_at_price": "24.99",
      "fulfillment_service": "manual",
      "inventory_management": null,
      "option1": "Small",
      "option2": null,
      "option3": null,
      "created_at": null,
      "updated_at": null,
      "taxable": true,
      "barcode": null,
      "image_id": null,
      "inventory_quantity": 75,
      "weight": 0.44,
      "weight_unit": "lb",
      "old_inventory_quantity": 75,
      "requires_shipping": true
    },
    {
      "id": 1234568,
      "product_id": 327475578523353102,
      "title": "",
      "price": "19.99",
      "sku": "example-shirt-m",
      "position": 0,
      "grams": 200,
      "inventory_policy": "deny",
      "compare_at_price": "24.99",
      "fulfillment_service": "manual",
      "inventory_management": "shopify",
      "option1": "Medium",
      "option2": null,
      "option3": null,
      "created_at": null,
      "updated_at": null,
      "taxable": true,
      "barcode": null,
      "image_id": null,
      "inventory_quantity": 50,
      "weight": 0.44,
      "weight_unit": "lb",
      "old_inventory_quantity": 50,
      "requires_shipping": true
    }
  ],
  "options": [
    {
      "id": 12345,
      "product_id": 327475578523353102,
      "name": "Title",
      "position": 1,
      "values": [
        "Small",
        "Medium"
      ]
    }
  ],
  "images": [
    {
      "id": 1234567,
      "product_id": 327475578523353102,
      "position": 0,
      "created_at": null,
      "updated_at": null,
      "src": "\/\/cdn.shopify.com\/s\/assets\/shopify_shirt-39bb555874ecaeed0a1170417d58bbcf792f7ceb56acfe758384f788710ba635.png",
      "variant_ids": [
      ]
    }
  ],
  "image": null
}';

$arr = json_decode($json, true);

echo "<pre>";
print_r($arr);