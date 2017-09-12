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
	$headers = ['item','title','link','image','zoom_image','category','available','description','price','msrp','album','brand'];

	fputcsv($out, $headers);


	
	foreach ($final_array as $fields) {

		// fputcsv($out, $fields);

		
		if(!empty($fields['published_at'])){

			// variants--------
			foreach($fields['variants'] as $key => $variant) {

					$product_variant['item'] = $variant['id'];
					$product_variant['title'] = $fields['title'];
					
					$product_variant['link'] = 'http://'.$shop.'/products/'.$fields['handle'].'?variant='.$variant['id'];
					
					$position = $variant['position'];
					$product_variant['image'] = '';
					foreach ($fields['images'] as $mkey => $image) {
						if( ($position == $image['position']) && ($position == 1) ){
							$product_variant['image'] = $image['src'];
							$product_variant['zoom_image'] = $image['src'];
						}else{
							if( (!empty($variant['image_id']) ) && ($variant['image_id'] == $image['id']) ){   
								$product_variant['image'] = $image['src']; 
							}
						}
					} 
					$product_variant['category'] = $fields['product_type'];	
					
					if($variant['inventory_quantity'] > 0){
						$available = 'true';
					}else{
						$available = 'false';
					}
					
					$product_variant['available'] = $available;
					
					$product_variant['description'] = $fields['body_html'];
					$product_variant['price'] = $variant['price'];
					$product_variant['msrp'] = $variant['compare_at_price'];
					$product_variant['album'] = $fields['product_type'];
					$product_variant['brand'] = $fields['vendor'];	
	   
				
				

				// create csvfile
				fputcsv($out, $product_variant);
			}
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




