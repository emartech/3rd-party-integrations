<?php
	session_start();

	require ('ShopifyAPI/ShopifyClient.php');

	require 'config.php';

	require 'database.php';

	require ('emarsys.php');

	include('Net/SFTP.php');

	set_time_limit(0);
	ini_set('display_errors', 0);
	ini_set('memory_limit', '10240000M');

	$shop = $_SESSION['shop'];

	$token = $_SESSION['token'];

	
    $filename = "all_order-$token.txt";



	$product_textfile = file_get_contents("csv/$filename");

	$product_textfile_array = unserialize($product_textfile);

	$curr_dt_time = date("Y-m-d H:i:s");
	
	foreach ($product_textfile_array as $value) {
		foreach ($value as $key1 => $value1) {
			
			$final_array[] = $value1;

		}
	
	}

	// echo "<pre>";
	// print_r($final_array);


	// convert array into the csvfile
	$csvname = "sync_shopify_all_orders-$token.csv";

	$out = fopen("csv/$csvname", "w");



	// create headers for csv file
	$headers = ['Id', 'Name', 'Email', 'Financial Status', 'Paid At', 'Fulfillment Status', 'Accepts Marketing', 'Currency', 'Subtotal','Shipping', 'Taxes', 'Total', 'Discount Code', 'Discount Amount', 'Created at', 'Lineitem quantity', 'Lineitem name', 'Lineitem price', 'Lineitem sku', 'Lineitem requires shipping', 'Lineitem taxable', 'Lineitem fulfillment status', 'Billing Name', 'Billing Address1', 'Billing Address2', 'Billing Company', 'Billing City', 'Billing Zip', 'Billing Province', 'Billing Country', 'Billing Phone', 'Shipping Name', 'Shipping Address1', 'Shipping Address2', 'Shipping Company', 'Shipping City', 'Shipping Zip', 'Shipping Province', 'Shipping Country', 'Shipping Phone', 'Note', 'Payment Method', 'Vendor', 'Tags', 'Source', 'Tax 1 Name', 'Tax 1 Value', 'Tax 2 Name', 'Tax 2 Value', 'Tax 3 Name', 'Tax 3 Value', 'Tax 4 Name', 'Tax 4 Value', 'Tax 5 Name', 'Tax 5 Value', 'Phone' ];

	fputcsv($out, $headers);


	
	foreach ($final_array as $fields) {

        // fputcsv($out, $fields);

        $order_variant['id'] = $fields['id'];

        $order_variant['name'] = $fields['name'];

        // variants--------
        foreach($fields['line_items'] as $key => $variant) {
            
            $order_variant['email'] = '';

            // only once for a order in csv
            $order_variant['financial_status'] = '';

            $order_variant['processed_at'] = '';

            $order_variant['fulfillment_status'] = '';

            $order_variant['buyer_accepts_marketing'] = '';

            $order_variant['currency'] = '';

            $order_variant['subtotal_price'] = '';

            $order_variant['shipping'] = '';

            $order_variant['total_tax'] = '';

            $order_variant['total_price'] = '';

            $order_variant['discount_codes'] = '';

            $order_variant['discount_amount'] = '';
            
            if($key == 0){
            
                $order_variant['email'] = $fields['email'];

                // only once for a order in csv
                $order_variant['financial_status'] = $fields['financial_status'];

                $order_variant['processed_at'] = $fields['processed_at'];

                $order_variant['fulfillment_status'] = $fields['fulfillment_status'];

                $order_variant['buyer_accepts_marketing'] = $fields['buyer_accepts_marketing'];

                $order_variant['currency'] = $fields['currency'];

                $order_variant['subtotal_price'] = $fields['subtotal_price'];

                $order_variant['shipping'] = $fields['shipping_lines'][0]['price'];

                $order_variant['total_tax'] = $fields['total_tax'];

                $order_variant['total_price'] = $fields['total_price'];

                $order_variant['discount_codes'] = $fields['discount_codes'][0]['code'];

                $order_variant['discount_amount'] = $fields['discount_codes'][0]['amount'];

            }

            $order_variant['created_at'] = $fields['created_at'];


            // lineitems value
            $order_variant['quantity'] = $variant['quantity'];

            $order_variant['title'] = $variant['title'];

            $order_variant['price'] = $variant['price'];

            $order_variant['sku'] = $variant['sku'];

            $order_variant['requires_shipping'] = $variant['requires_shipping'];
            
            $order_variant['taxable'] = $variant['taxable'];
            
            $order_variant['line_item_fulfillment_status'] = $variant['fulfillment_status'];

            // billing info------
            $order_variant['billing_address_sku'] = $fields['billing_address']['name'];

            $order_variant['billing_address_address1'] = $fields['billing_address']['address1'];

            $order_variant['billing_address_address2'] = $fields['billing_address']['address2'];

            $order_variant['billing_address_company'] = $fields['billing_address']['company'];

            $order_variant['billing_address_city'] = $fields['billing_address']['city'];

            $order_variant['billing_address_zip'] = $fields['billing_address']['zip'];

            $order_variant['billing_address_province'] = $fields['billing_address']['province'];

            $order_variant['billing_address_country'] = $fields['billing_address']['country'];

            $order_variant['billing_address_phone'] = $fields['billing_address']['phone'];
 
            // shipping info -------
            $order_variant['shipping_address_name'] = $fields['shipping_address']['name'];

            $order_variant['shipping_address_address1'] = $fields['shipping_address']['address1'];

            $order_variant['shipping_address_address2'] = $fields['shipping_address']['address2'];

            $order_variant['shipping_address_company'] = $fields['shipping_address']['company'];

            $order_variant['shipping_address_city'] = $fields['shipping_address']['city'];

            $order_variant['shipping_address_zip'] = $fields['shipping_address']['zip'];

            $order_variant['shipping_address_province'] = $fields['shipping_address']['province'];

            $order_variant['shipping_address_country'] = $fields['shipping_address']['country'];

            $order_variant['shipping_address_phone'] = $fields['shipping_address']['phone'];

            $order_variant['note'] = $fields['note'];


            $order_variant['fulfillment_service'] = $variant['fulfillment_service'];

            $order_variant['vendor'] = $variant['vendor'];

            $order_variant['tags'] = $variant['tags'];


            $order_variant['source_name'] = $fields['source_name'];

            
            $order_variant['total_discount'] = $variant['total_discount'];

            // tax name
            $order_variant['tax1_name'] = $fields['tax_lines'][0]['title'];

            $order_variant['tax1_value'] = $fields['tax_lines'][0]['price'];

            $order_variant['tax2_name'] = $fields['tax_lines'][1]['title'];

            $order_variant['tax2_value'] = $fields['tax_lines'][1]['price'];

            $order_variant['tax3_name'] = $fields['tax_lines'][2]['title'];

            $order_variant['tax3_value'] = $fields['tax_lines'][2]['price'];

            $order_variant['tax4_name'] = $fields['tax_lines'][3]['title'];

            $order_variant['tax4_value'] = $fields['tax_lines'][3]['price'];

            $order_variant['tax5_name'] = $fields['tax_lines'][4]['title'];

            $order_variant['tax5_value'] = $fields['tax_lines'][4]['price'];


            $order_variant['phone'] = $fields['phone'];


            // create csvfile
            fputcsv($out, $order_variant);
        }


    }


	

    $sql_sftp = "SELECT * FROM sftp_credentials where store_name='" . trim($shop) . "'";
          
    $result_sftp = mysqli_query($con, $sql_sftp);

    if (mysqli_num_rows($result_sftp) > 0) {
       
        while($row = mysqli_fetch_assoc($result_sftp)) {

            $sftp_hostname = $row["sftp_hostname"];

            $sftp_port = $row["sftp_port"];

            $sftp_username = $row["sftp_username"];

            $sftp_password = $row["sftp_password"];

            $sftp_export = $row["sftp_export"];

            $feed_export = $row["feed_export"];
            
        
        }
    }

	$posts = array();
    $tempArray = array();
	$log_file_name = "logs.json"; 
	
	$oldJSON = file_get_contents("logs/$log_file_name");
	$tempArray = json_decode($oldJSON, true);
	 
    $log_file = fopen("logs/$log_file_name", "w+");
	
    $sftp = new Net_SFTP($sftp_hostname);
	
	if ($sftp->login($sftp_username, $sftp_password)) {
	
	    if($sftp->put("sync_shopify_all_orders.csv", "csv/$csvname", NET_SFTP_LOCAL_FILE)){
			$finished_dt_time = date("Y-m-d H:i:s");  
			$posts[] = array('Code'=> 'Purchase Data Synchronization', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'All purchase data have synchronize successfully.');
			if (!empty($tempArray[0])) {
			 $result = array_merge($tempArray, $posts);
			}
			else{
			 $result = $posts;
			}

			fwrite($log_file, json_encode($result));
	    	$status =  'fs';  // success   
	    }else{
			
			$finished_dt_time = date("Y-m-d H:i:s");  
			$posts[] = array('Code'=> 'Purchase Data Synchronization', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'Purchase data not synchronize.');
			if (!empty($tempArray[0])) {
			 $result = array_merge($tempArray, $posts);
			}
			else{
			 $result = $posts;
			}

			fwrite($log_file, json_encode($result));
	    	$status =  'fe'; // error
	    }

	}else{
			$finished_dt_time = date("Y-m-d H:i:s");  
			$posts[] = array('Code'=> 'Purchase Data Synchronization', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'SFTP connection failed.');
			if (!empty($tempArray[0])) {
			 $result = array_merge($tempArray, $posts);
			}
			else{
			 $result = $posts;
			}

			fwrite($log_file, json_encode($result));
			$status =  'fe'; // error
    }

	fclose($log_file);
	
	unlink('csv/' . $csvname);

    
    $text_temp = "all_order-$token.txt";

    unlink('csv/' . $text_temp);



	header("Location: message.php?message=$status");




