<?php
session_start();

    require ('ShopifyAPI/ShopifyClient.php');

    require 'config.php';

    require 'database.php';

    require ('emarsys.php');

    $shop = $_SESSION['shop'];


	// connect shopify --------
  	$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);
	

// echo("<pre>");



	// get all user in emarsys -------
	$all_conntacts_field = $emarsyClient->send('GET', 'contact/query/?return=3');

	$all_conntacts_field_array = json_decode($all_conntacts_field, true);

	$contact_fields = $all_conntacts_field_array['data']['result'];

	// print_r($contact_fields);

	foreach ($contact_fields as $value) {
		
		$contact_email[] = $value['3'];
	}


	// print_r($contact_email);

	
	// get the field_id for shopify_contact_id -------
	$sql_fieldId = "SELECT * FROM emarsys_fields  where store_name='" . trim($shop) . "' AND  fieldEmarsysName='shopify_contact_id'";
      

	  $result_fieldId = $con->query($sql_fieldId);

      if ($result_fieldId->num_rows > 0) {
                
      	// output data of each row
      	while($row_fieldId = $result_fieldId->fetch_assoc()) {

        	$db_field = $row_fieldId["fieldEmarsysID"];
        }
     }

// echo($db_field);
	
	// sent the email confirmation link to the customers ----------

	foreach ($contact_email as $key => $value) {
		# code...

		// get the shopify_customer_id
		// https://api.emarsys.net/api/v2/contact/query/?return=13762&3=apsingh%40synapseindia.email

		$shopify_customer_id_json = $emarsyClient->send('GET', 'contact/query/?return='.$db_field.'&3='.$value);

		$shopify_customer_id_array = json_decode($shopify_customer_id_json, true);

		$shopify_user_id = $shopify_customer_id_array['data']['result'][0][$db_field];

		// echo($value);
		// echo("<br>");

		// echo '<pre>';

		// print_r($shopify_customer_id_array);


		// sent verification mail to shopify user.
		if(!empty($shopify_user_id)){

			// echo $shopify_user_id;

			// $to      = 'apsingh@synapseindia.email';
		
			$to      = $value;
    	
    		$subject = 'Accepts Marketing';

			$random = rand(1000,9999);
			
			$url = APP_URI. "/optin_verify.php/?r=$random&s=$shopify_user_id";

			// insert auth in database for further verify -----
			$sql_auth = "INSERT INTO optin_verify (id, store_name, shopify_user_id, auth) VALUES ('', '" . trim($shop) . "', '" . trim($shopify_user_id) . "', '" . trim($random) . "')";

			mysqli_query($con, $sql_auth);



			// $message = "Hello \r\n <a href=\"$url\">Click Here </a> for accept marketing.";

// 			$message = '
 
// Hello,

// You will received the promotional mails after accepting the optin.
 
// Please click this link to activate your optin:
// '.$url.'
 
// ';


			$message = '
 
Thanks for signing up.<br><br>

You will received the promotional mails after accepting the optin.<br><br>
 
Please click the below link to activate your optin:<br>
<a href="'.$url.'">Click Here </a> <br><br>

Thank You.
 
';



			$headers = 'From: synapseindia8@gmail.com' . "\r\n" .
	    		'Reply-To: synapseindia8@gmail.com' . "\r\n" .
	    		'Content-type: text/html; charset=utf-8' . "\r\n".
	    		'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $message, $headers);

		}


		

	}


	// update the mail sent in databae----
	$sql_optin_update = "UPDATE emarsys_optin SET mail_sent='1' WHERE store_name='".$shop."'";

	if( mysqli_query($con, $sql_optin_update) ){

		// echo "success";
		// $status =  'fs';	// success    
	}else{
		// echo "error";
		// $status =  'fe';	// success    
	}


	header("Location: optin.php");

	


