<?php
    session_start();

    require ('ShopifyAPI/ShopifyClient.php');

    require 'config.php';

    require 'database.php';

    require ('emarsys.php');

    include('Net/SFTP.php');


    $shop = $_SESSION['shop'];

    $token = $_SESSION['token'];


    //  GET /admin/customers.json

    $sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);

    $customer_detail = $sc->call('GET', '/admin/customers.json', array());

	// echo "<pre>";
	// print_r($customer_detail);

    


// fetch the store field mapping and write csv file---------------------------------------


    // put mandatory header fields--

    $headers = array('Shopify Contact Id', 'Status', 'First Name', 'Last Name', 'Email', 'Optin', 'Verify Email');

    $sql_contact = "SELECT * FROM contact_mapping where store_name='" . trim($shop) . "'";
          
    $result_contact = mysqli_query($con, $sql_contact);

    if (mysqli_num_rows($result_contact) > 0) {

        while($row = mysqli_fetch_assoc($result_contact)){
        
            $headers_id = $row['emarsys_field_id'];

            // get emarsys fields name -------------

            $sql_contact1 = "SELECT * FROM emarsys_fields where store_name='" . trim($shop) . "' AND fieldEmarsysID='" . trim($headers_id) . "'";
          
            $result_contact1 = mysqli_query($con, $sql_contact1);

            if (mysqli_num_rows($result_contact1) > 0) {

                while($row1 = mysqli_fetch_assoc($result_contact1)){

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

        if($data['accepts_marketing']){
            $customer['accepts_marketing'] = '1';
        }


        $customer['verified_email'] = '';

        if($data['verified_email']){
            $customer['verified_email'] = '1';
        }


        // manual maaping from the store owner -----------------


        $custom_array = array('6'=>'orders_count', '8'=>'total_spent', '10'=>'note', '12'=>'tax_exempt', '14'=>'tags', '16'=>'first_name', '17'=>'last_name', '18'=>'company', '19'=>'address1', '20'=>'address2', '21'=>'city', '22'=>'province', '23'=>'country', '24'=>'zip');

        foreach ($custom_array as $custom_key => $custom_value) {

          $sql_contact_name = "SELECT * FROM contact_mapping where store_name='" . trim($shop) . "' AND shopify_field_id='" . trim($custom_key) . "'";
          
          $result_contact_name = mysqli_query($con, $sql_contact_name);

          if (mysqli_num_rows($result_contact_name) > 0) {

              while($row = mysqli_fetch_assoc($result_contact_name)){
        
                  $emarsys_field_id = $row['emarsys_field_id'];
              }    
          }

          if(!empty($emarsys_field_id)){

            $customer[$emarsys_field_id] = $data[$custom_value];

            if($custom_key > 15){
                $customer[$emarsys_field_id] = $data['default_address'][$custom_value];
            }
              
          }

        } 
        unset($custom_array);
        // end of custom foreach --------------

        
        $customer_all_data[] = $customer;

        unset($customer);

	}


	// echo "<pre>";
 //    print_r($customer_all_data);
  
     
    $csvname = "export_shopify_all_contacts_$token.csv";

	$out = fopen("csv/$csvname", "w");
	
	foreach ($customer_all_data as $fields) {
	
		fputcsv($out, $fields);
	}



    // $sql_sftp = "SELECT * FROM sftp_credentials where store_name='" . trim($shop) . "'";
          
    // $result_sftp = mysqli_query($con, $sql_sftp);

    // if (mysqli_num_rows($result_sftp) > 0) {
       
    //     while($row = mysqli_fetch_assoc($result_sftp)) {

    //         $sftp_hostname = $row["sftp_hostname"];

    //         $sftp_port = $row["sftp_port"];

    //         $sftp_username = $row["sftp_username"];

    //         $sftp_password = $row["sftp_password"];

    //         $sftp_export = $row["sftp_export"];

    //         $feed_export = $row["feed_export"];
            
        
    //     }
    // }



	// $sftp = new Net_SFTP($sftp_hostname);
	
	// if ($sftp->login($sftp_username, $sftp_password)) {
	
	//     if($sftp->put("export_shopify_all_contacts.csv", "csv/$csvname", NET_SFTP_LOCAL_FILE)){

	//     	echo 'success';	    
	//     }else{

	//     	echo "error";
	//     }

	// }else{
 //        echo "error";
 //    }






 $sql_sftp = "SELECT * FROM webdav_credentials where store_name='" . trim($shop) . "'";
          
    $result_sftp = mysqli_query($con, $sql_sftp);

    if (mysqli_num_rows($result_sftp) > 0) {
       
        while($row = mysqli_fetch_assoc($result_sftp)) {

            $remoteUrl = $row["url"];

            $webdav_user = $row["user"];

            $webdav_password = $row["password"];
        
        }
    }



// The user credentials I will use to login to the WebDav host
// $credentials = array(
//   'synapseA44',
//   'h7b;CEK(u2'
// );


$credentials = array($webdav_user, $webdav_password);


// Prepare the file we are going to upload
$filename = 'export_shopify_all_contacts.csv';

$filepath = 'csv/'.$csvname;

$filesize = filesize($filepath);

$fh = fopen($filepath, 'r');



$ch = curl_init($remoteUrl . $filename);

curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

curl_setopt($ch, CURLOPT_USERPWD, implode(':', $credentials));

curl_setopt($ch, CURLOPT_UPLOAD, true);

curl_setopt($ch, CURLOPT_INFILE, $fh);

curl_setopt($ch, CURLOPT_INFILESIZE, $filesize);

curl_exec($ch);


// Close the file handle
fclose($fh);


echo 'success';    

unlink('csv/' . $csvname);

	 // echo "done :)";

