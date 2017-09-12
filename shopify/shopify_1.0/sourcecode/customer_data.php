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

    if(!empty($shop) && !empty($token)){
    
    
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
                
        $sc = new ShopifyClient($shop, $token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
        
        $customer_detail = $sc->call('GET', '/admin/customers.json', array());
        
        // echo "<pre>";
        // print_r($customer_detail);
        
        
        // fetch the store field mapping and write csv file---------------------------------------
        
        
        // put mandatory header fields--
        
        $headers = array(
            'Shopify Contact Id',
            'Status',
            'First Name',
            'Last Name',
            'Email',
            'Optin',
            'Verify Email'
        );
        
        $sql_contact = "SELECT * FROM contact_mapping where store_name='" . trim($shop) . "'";
        
        $result_contact = mysqli_query($con, $sql_contact);
        
        if (mysqli_num_rows($result_contact) > 0) {
            
            while ($row = mysqli_fetch_assoc($result_contact)) {
                
                $headers_id = $row['emarsys_field_id'];
                
                // get emarsys fields name -------------
                
                $sql_contact1 = "SELECT * FROM emarsys_fields where store_name='" . trim($shop) . "' AND fieldEmarsysID='" . trim($headers_id) . "'";
                
                $result_contact1 = mysqli_query($con, $sql_contact1);
                
                if (mysqli_num_rows($result_contact1) > 0) {
                    
                    while ($row1 = mysqli_fetch_assoc($result_contact1)) {
                        
                        $headers[] = $row1['fieldName'];
                    }
                }
                
            }
        }
        
        // echo("<pre>");
        
        // print_r($row_contact);
        
        
        //  echo("<pre>");
        
        // print_r($headers);
        
        
        $customer_all_data[] = $headers;
        
        // echo("<pre>");
        
        // print_r($customer_all_data);
        
        foreach ($customer_detail as $data) {
            
            // default mapping for the cusktomer ----------
            
            $customer['shopify_contact_id'] = $data['id'];
            
            $customer['shopify_contact_status'] = $data['state'];
            
            $customer['first_name'] = $data['first_name'];
            
            $customer['last_name'] = $data['last_name'];
            
            $customer['email'] = $data['email'];            
            
            $customer['accepts_marketing'] = '2';
            
            if ($data['accepts_marketing']) {
                $customer['accepts_marketing'] = '1';
            }
            
            
            $customer['verified_email'] = '';
            
            if ($data['verified_email']) {
                $customer['verified_email'] = '1';
            }
            
            
            // manual maaping from the store owner -----------------

            $custom_array = array(
                '6' => 'orders_count',
                '8' => 'total_spent',
                '10' => 'note',
                '12' => 'tax_exempt',
                '14' => 'tags',
                '16' => 'first_name',
                '17' => 'last_name',
                '18' => 'company',
                '19' => 'address1',
                '20' => 'address2',
                '21' => 'city',
                '22' => 'province',
                '23' => 'country',
                '24' => 'zip'
            );
            
            foreach ($custom_array as $custom_key => $custom_value) {
                
                $sql_contact_name = "SELECT * FROM contact_mapping where store_name='" . trim($shop) . "' AND shopify_field_id='" . trim($custom_key) . "'";
                
                $result_contact_name = mysqli_query($con, $sql_contact_name);
                
                if (mysqli_num_rows($result_contact_name) > 0) {
                    
                    while ($row = mysqli_fetch_assoc($result_contact_name)) {
                        
                        $emarsys_field_id = $row['emarsys_field_id'];
                    }
                }
                
                if (!empty($emarsys_field_id)) {
                    
                    $customer[$emarsys_field_id] = $data[$custom_value];
                    
                    if ($custom_key > 15) {
                        $customer[$emarsys_field_id] = $data['default_address'][$custom_value];
                    }
                    
                }
                
            } // end of custom foreach --------------
            
            unset($custom_array);
            
            $customer_all_data[] = $customer;
            
            unset($customer);
            
        } // end of customer detail foreach loop -----------
        
        
        // echo "<pre>";
        //    print_r($customer_all_data);
        
        
        $csvname = "export_shopify_all_contacts_$token.csv";
        
        $out = fopen("csv/$csvname", "w");
        
        foreach ($customer_all_data as $fields) {
            
            fputcsv($out, $fields);
        }
        
        
        
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
        
        
        $sftp = new Net_SFTP($sftp_hostname);
        
        if ($sftp->login($sftp_username, $sftp_password)) {
            
            $sftp->put("export_shopify_all_contacts.csv", "csv/$csvname", NET_SFTP_LOCAL_FILE);
        }
        
        // unlink('csv/' . $csvname);
        
        unset($customer_detail);
        
        unset($headers);
        
        unset($customer_all_data);
        
        
        //------------------------------------------------------------------------------------
        
    } // end of cron exexution time.            
    else{
        // echo("<br>");
        // echo 'no execution time. for store-> '.$shop;
    }  
    
} // end of if for empty store and token

} // end of foreach loop.



?>