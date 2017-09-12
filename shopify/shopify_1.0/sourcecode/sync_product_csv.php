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

	$filename = "all_product-$token.txt";

	$product_textfile = file_get_contents("csv/$filename");

	$product_textfile_array = unserialize($product_textfile);

	$curr_dt_time = date("Y-m-d H:i:s");  
	
	foreach ($product_textfile_array as $value) {
		foreach ($value as $key1 => $value1) {
			
			$final_array[] = $value1;

		}
	
	}

	// echo "<pre>";
	// print_r($product_textfile_array);


	// convert array into the csvfile
	$csvname = "sync_shopify_all_products.csv";

	$out = fopen("csv/$csvname", "w");



	// create headers for csv file
	$headers = ['Id', 'Handle', 'Title', 'Body (HTML)', 'Vendor', 'Type', 'Tags', 'Published', 'Option1 Name', 'Option1 Value', 'Option2 Name', 'Option2 Value', 'Option3 Name', 'Option3 Value', 'Variant SKU', 'Variant Grams', 'Variant Inventory Tracker', 'Variant Inventory Qty', 'Variant Inventory Policy', 'Variant Fulfillment Service', 'Variant Price', 'Variant Compare At Price', 'Variant Requires Shipping', 'Variant Taxable', 'Variant Barcode', 'Image Src', 'Variant Weight Unit'];

	fputcsv($out, $headers);


	
	foreach ($final_array as $fields) {

		// fputcsv($out, $fields);

		$product_variant['id'] = $fields['id'];

		$product_variant['handle'] = $fields['handle'];


       	// variants--------
        foreach($fields['variants'] as $key => $variant) {

        	$product_variant['title'] = '';
               
            $product_variant['body_html'] = '';
            
            $product_variant['vendor'] = '';

            $product_variant['product_type'] = '';

            $product_variant['tags'] = '';

            $product_variant['published_scope'] = '';   

            // options--------
            $product_variant['option1_name'] = '';

            
            if($key == 0){
        	
        		$product_variant['title'] = $fields['title'];

        		$product_variant['body_html'] = $fields['body_html'];

        		$product_variant['vendor'] = $fields['vendor'];	

        		$product_variant['product_type'] = $fields['product_type'];	

        		$product_variant['tags'] = $fields['tags'];	

        		$product_variant['published_scope'] = $fields['published_scope'];	

        		// options--------
       			$product_variant['option1_name'] = $fields['options'][0]['name'];	

        	}


        	$product_variant['option1_value'] = $variant['option1'];


        	$product_variant['option2_name'] = '';
            if($key == 0){
        		$product_variant['option2_name'] = $fields['options'][1]['name'];
        	}

        	$product_variant['option2_value'] = $variant['option2'];


        	$product_variant['option3_name'] = '';
            if($key == 0){
        		$product_variant['option3_name'] = $fields['options'][2]['name'];
        	}

        	$product_variant['option3_value'] = $variant['option3'];

        	$product_variant['sku'] = $variant['sku'];	

        	$product_variant['grams'] = $variant['grams'];	

        	$product_variant['inventory_tracker'] = $variant['inventory_management'];	

        	$product_variant['inventory_quantity'] = $variant['inventory_quantity'];

        	$product_variant['inventory_policy'] = $variant['inventory_policy'];

        	$product_variant['fulfillment_service'] = $variant['fulfillment_service'];

        	$product_variant['price'] = $variant['price'];

        	$product_variant['compare_at_price'] = $variant['compare_at_price'];


        	if($variant['requires_shipping'] == 1){
        		$shipping = 'true';
        	}else{
        		$shipping = 'false';
        	}

        	$product_variant['requires_shipping'] = $shipping;


        	if($variant['taxable'] == 1){
        		$taxable = 'true';
        	}else{
        		$taxable = 'false';
        	}

        	$product_variant['taxable'] = $taxable;

        	$product_variant['barcode'] = $variant['barcode'];

            // for image url
            $position = $variant['position'];
                
                
            $product_variant['image'] = '';
            foreach ($fields['images'] as $mkey => $image) {
                   
                if( ($position == $image['position']) && ($position == 1) ){
                      
                    $product_variant['image'] = $image['src']; 
                       
                }else{
                    if( (!empty($variant['image_id']) ) && ($variant['image_id'] == $image['id']) ){
                        
                        $product_variant['image'] = $image['src']; 
                    }
                }
            } 

        	$product_variant['weight_unit'] = $variant['weight_unit'];

            // create csvfile
            fputcsv($out, $product_variant);
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
	
	

	$status = 'a';
    $sftp = new Net_SFTP($sftp_hostname);
	
	if ($sftp->login($sftp_username, $sftp_password)) {
	
	    if($sftp->put($csvname, "csv/$csvname", NET_SFTP_LOCAL_FILE)){
			$finished_dt_time = date("Y-m-d H:i:s");  
			$posts[] = array('Code'=> 'Product Synchronization', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'All products have synchronized successfully.');
			if (!empty($tempArray[0])) {
			 $result = array_merge($tempArray, $posts);
			}
			else{
			 $result = $posts;
			}

			fwrite($log_file, json_encode($result));
	    	$status =  'fs';	// success    
	    }else{
			$finished_dt_time = date("Y-m-d H:i:s");  
			$posts[] = array('Code'=> 'Product Synchronization', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'Products not synchronize.');
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
			$posts[] = array('Code'=> 'Product Synchronization', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'SFTP connection failed.');
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

    
    $text_temp = "all_product-$token.txt";

    unlink('csv/' . $text_temp);



	header("Location: message.php?message=$status");




