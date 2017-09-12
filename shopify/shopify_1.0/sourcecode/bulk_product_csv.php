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

$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);

$curr_dt_time = date("Y-m-d H:i:s");  

if($_POST){

	$date_from = date("Y-m-d", strtotime($_POST['from']));

	$date_to = date("Y-m-d", strtotime($_POST['to']));
	

	 $products_count = $sc->call('GET', '/admin/products/count.json', array());
    
	 
		// $products_count = 749;
		
		$quotient = ($products_count / 250);
		
		$total_links = intval($quotient) + 1;
        
		$product_array = array();
	    
		for($i=1; $i<=$total_links; $i++){
			// put 250 records in array default
			$product_array[] = $sc->call("GET", "/admin/products.json?limit=250&page=$i", array());		
		}
		
		
		// serialize array and write in file
		$product_array_serialized = serialize($product_array);
		
		$filename = "bulk_all_product.txt";

		$file1 = fopen('csv/'.$filename, 'w');

		fwrite($file1, $product_array_serialized);
		// fwrite($file1, print_r($product_array, TRUE));
		fclose($file1);

		
		unset($product_array);
		
		$filename = "bulk_all_product.txt";

		$product_textfile = file_get_contents("csv/$filename");
		
		$product_textfile_array = unserialize($product_textfile);

		$final_array = array();
		foreach ($product_textfile_array as $value) {
			foreach ($value as $key1 => $value1) {
			    $actual_date = explode('T', $value1['created_at']);
				
			
				if(intval(strtotime($actual_date[0])) >= intval(strtotime($date_from)) && intval(strtotime($actual_date[0])) <= intval(strtotime($date_to)))
				{
					$final_array[] = $value1;
				}

			}
		
		}
		
        $csvname = "bulk_filter_products.csv";
        
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
	
	$sftp = new Net_SFTP($sftp_hostname);
	
	if ($sftp->login($sftp_username, $sftp_password)) {
	
	    if($sftp->put("$sftp_export/$csvname", "csv/$csvname", NET_SFTP_LOCAL_FILE)){
			$finished_dt_time = date("Y-m-d H:i:s");  
			$posts[] = array('Code'=> 'Product Bulk Export', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Complete', 'Messages'=>'File successfully exported on SFTP.');
			if (!empty($tempArray[0])) {
			 $result = array_merge($tempArray, $posts);
			}
			else{
			 $result = $posts;
			}

			fwrite($log_file, json_encode($result));
	    	echo 'success';	    
	    }else{
			$finished_dt_time = date("Y-m-d H:i:s");  
			$posts[] = array('Code'=> 'Product Bulk Export', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Fail', 'Messages'=>'File not exported on SFTP.');
			if (!empty($tempArray[0])) {
			 $result = array_merge($tempArray, $posts);
			}
			else{
			 $result = $posts;
			}
			fwrite($log_file, json_encode($result));
	    	echo 'success';
	    }

	}else{
		$finished_dt_time = date("Y-m-d H:i:s");  
		$posts[] = array('Code'=> 'Product Bulk Export', 'Created'=> $curr_dt_time, 'Finished'=> $finished_dt_time, 'Type'=>'Fail', 'Messages'=>'SFTP connection failed');
		if (!empty($tempArray[0])) {
		 $result = array_merge($tempArray, $posts);
		}
		else{
		 $result = $posts;
		}
		fwrite($log_file, json_encode($result));
		echo 'fail';
	}
	fclose($log_file);

	unlink('csv/' . $csvname);

    
    $text_temp = "bulk_all_product.txt";

    unlink('csv/' . $text_temp);
		
		
		
}
?>

