<?php

error_reporting(0);
set_time_limit(0);

require('ShopifyAPI/ShopifyClient.php');

require 'config.php';

require 'database.php';

require('emarsys.php');

include('Net/SFTP.php');

error_reporting(0);

set_time_limit(0);

ini_set('display_errors', 0);

ini_set('memory_limit', '10240000M');


// get the shopify store name and token for all store---
$sql = "SELECT * FROM store group by store_name";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        
        $store[] = $row["store_name"];
        
        $store_token[] = $row["token"];
    }
}

// echo("<pre>");

// print_r($store);

// print_r($store_token); 

$server_min = date("i");

$server_hour = date("h");


//--------- Exexute on specific time suggested by Store Admin --------------------------------

foreach ($store as $key => $shop) {
    
    $token = $store_token[$key];
    
    if (!empty($shop) && !empty($token)) {
        
        
        // get all the stores have enable cron status
        $sql1 = "SELECT * FROM cron where store_name='" . $shop . "' and shopify_data='si'";
        
        $result1 = $con->query($sql1);
        
        if ($result1->num_rows > 0) {
            
            // output data of each row
            while ($row1 = $result1->fetch_assoc()) {
                
                $status = $row1["status"];
                
                $frequency = $row1["frequency"];
                
                $execute_min = $row1["execute_min"];
                
                $execute_hour = $row1["execute_hour"];
                
                $execute_day = $row1["execute_day"];
                
            }
        }
        
        
        if ((($frequency == 'hour') && ($server_min == $execute_min)) || (($frequency == 'day') && ($server_min == $execute_min) && ($server_hour == $execute_hour))) {
            
            
            // cron logic ------------------------------------------------------------------------
            
            // shopify connection   
            $sc = new ShopifyClient($shop, $token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
            
            
            // check sftp details available or not.
            $count_query = "SELECT * FROM sftp_credentials where store_name = '" . $shop . "'";
            
            $result = $con->query($count_query);
            
            $rowcount = $result->num_rows;
            
            if ($result->num_rows > 0) {
                
                // output data of each row
                while ($row_sftp = $result->fetch_assoc()) {
                    
                    $db_sftp = $row_sftp["sftp_hostname"];
                }
            }
            
            
            
            // code for create file over sftp initially.
            
            // count total number of products on store.
            $orders_count = $sc->call('GET', '/admin/products/count.json', array());
            
            // $products_count = 749;
            
            $quotient = ($orders_count / 250);
            
            $total_links = intval($quotient) + 1;
            
            $product_array = array();
            
            for ($i = 1; $i <= $total_links; $i++) {
                
                // put 250 records in array default
                $product_array[] = $sc->call("GET", "/admin/products.json?limit=250&page=$i", array());
                
            }
            
            
            // convert array into the csvfile
            $csvname = "sync_shopify_all_products.csv";
            
            $out = fopen("csv/$csvname", "w");
            
         
            $headers = array(
                'item',
                'title',
                'link',
                'image',
                'zoom_image',
                'category',
                'available',
                'description',
                'price',
                'msrp',
                'album',
                'brand'
            );
            
            fputcsv($out, $headers);
            
            
            
            foreach ($product_array as $fields) {
                
                // fputcsv($out, $fields);
                
                
                if (!empty($fields['published_at'])) {
                    
                    // variants--------
                    foreach ($fields['variants'] as $key => $variant) {
                        
                        $product_variant['item']  = $variant['id'];
                        $product_variant['title'] = $fields['title'];
                        
                        $product_variant['link'] = 'http://' . $shop . '/products/' . $fields['handle'] . '?variant=' . $variant['id'];
                        
                        $position                 = $variant['position'];
                        $product_variant['image'] = '';
                        foreach ($fields['images'] as $mkey => $image) {
                            if (($position == $image['position']) && ($position == 1)) {
                                $product_variant['image']      = $image['src'];
                                $product_variant['zoom_image'] = $image['src'];
                            } else {
                                if ((!empty($variant['image_id'])) && ($variant['image_id'] == $image['id'])) {
                                    $product_variant['image'] = $image['src'];
                                }
                            }
                        }
                        $product_variant['category'] = $fields['product_type'];
                        
                        if ($variant['inventory_quantity'] > 0) {
                            $available = 'true';
                        } else {
                            $available = 'false';
                        }
                        
                        $product_variant['available'] = $available;
                        
                        $product_variant['description'] = $fields['body_html'];
                        $product_variant['price']       = $variant['price'];
                        $product_variant['msrp']        = $variant['compare_at_price'];
                        $product_variant['album']       = $fields['product_type'];
                        $product_variant['brand']       = $fields['vendor'];
                        
                        
                        
                        
                        // create csvfile
                        fputcsv($out, $product_variant);
                    }
                }
                
                
            }  // end of foreach 
            
            
            
            
            $sql_sftp = "SELECT * FROM sftp_credentials where store_name='" . trim($shop) . "'";
            
            $result_sftp = mysqli_query($con, $sql_sftp);
            
            if (mysqli_num_rows($result_sftp) > 0) {
                
                while ($row = mysqli_fetch_assoc($result_sftp)) {
                    
                    $sftp_hostname = $row["sftp_hostname"];
                    
                    $sftp_port = $row["sftp_port"];
                    
                    $sftp_username = $row["sftp_username"];
                    
                    $sftp_password = $row["sftp_password"];
                    
                    $sftp_export = $row["sftp_export"];
                    
                    $feed_export = $row["feed_export"];
                    
                    
                }
            }
            
            $posts         = array();
            $tempArray     = array();
            $log_file_name = "logs.json";
            
            $oldJSON   = file_get_contents("logs/$log_file_name");
            $tempArray = json_decode($oldJSON, true);
            
            $log_file = fopen("logs/$log_file_name", "w+");
            
            
            
            $status = 'a';
            $sftp   = new Net_SFTP($sftp_hostname);
            
            if ($sftp->login($sftp_username, $sftp_password)) {
                
                if ($sftp->put($csvname, "csv/$csvname", NET_SFTP_LOCAL_FILE)) {
                    $finished_dt_time = date("Y-m-d H:i:s");
                    $posts[]          = array(
                        'Code' => 'Product Synchronization',
                        'Created' => $curr_dt_time,
                        'Finished' => $finished_dt_time,
                        'Type' => 'Complete',
                        'Messages' => 'All products have synchronized successfully.'
                    );
                    if (!empty($tempArray[0])) {
                        $result = array_merge($tempArray, $posts);
                    } else {
                        $result = $posts;
                    }
                    
                    fwrite($log_file, json_encode($result));
                    $status = 'fs'; // success    
                } else {
                    $finished_dt_time = date("Y-m-d H:i:s");
                    $posts[]          = array(
                        'Code' => 'Product Synchronization',
                        'Created' => $curr_dt_time,
                        'Finished' => $finished_dt_time,
                        'Type' => 'Complete',
                        'Messages' => 'Products not synchronize.'
                    );
                    if (!empty($tempArray[0])) {
                        $result = array_merge($tempArray, $posts);
                    } else {
                        $result = $posts;
                    }
                    
                    fwrite($log_file, json_encode($result));
                    $status = 'fe'; // error
                }
                
            } 
            else 
            {
                $finished_dt_time = date("Y-m-d H:i:s");
                $posts[]          = array(
                    'Code' => 'Product Synchronization',
                    'Created' => $curr_dt_time,
                    'Finished' => $finished_dt_time,
                    'Type' => 'Complete',
                    'Messages' => 'SFTP connection failed.'
                );
                if (!empty($tempArray[0])) {
                    $result = array_merge($tempArray, $posts);
                } else {
                    $result = $posts;
                }
                
                fwrite($log_file, json_encode($result));
                $status = 'fe'; // error
            }
            fclose($log_file);
            
            unlink('csv/' . $csvname);
            
            
            $text_temp = "all_product-$token.txt";
            
            unlink('csv/' . $text_temp);


            unset($product_array);

            unset($headers);

            
            
            //------------------------------------------------------------------------------------
            
        } // end of cron exexution time.            
        else {
            // echo("<br>");
            // echo 'no execution time. for store-> '.$shop;
        }
        
    } // end of if for empty store and token
    
} // end of foreach loop.



?>