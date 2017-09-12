<?php 
    session_start();

	require ('ShopifyAPI/ShopifyClient.php');

	require 'config.php';

	require 'database.php';

	require ('emarsys.php');

	$shop = $_SESSION['shop'];

	$token = $_SESSION['token'];

	
	if($_POST){

		$optin = $_POST['optin'];

		$sql1 = "SELECT * FROM emarsys_optin where store_name='" . trim($shop) . "'";
      
		  $result1 = $con->query($sql1);

	      if ($result1->num_rows > 0) {
	        // update optin


				$sql_update = "UPDATE emarsys_optin SET optin='".$optin."' WHERE store_name='".$shop."'";

				mysqli_query($con, $sql_update); 


//-----------------------------------------------------------------------------------

				// if optin is det to double the we create a emai campaign----

			if($optin == '2'){

		

				$shopifyClient = new ShopifyClient($shop, $token, SHOPIFY_API_KEY, SHOPIFY_SECRET);

    			$shop_detail = $shopifyClient->call('GET', '/admin/shop.json');

				$fromemail = $shop_detail['email'];

				$fromname = $shop_detail['name'];


				// get the external even id ----

				$sql12 = "SELECT * FROM emarsys_external_events where store_name='" . trim($shop) . "' AND eventName='Shopify_confirmation_email'";

             $result_contact_id12 = $con->query($sql12);

             if ($result_contact_id12->num_rows > 0) {
                
                // output data of each row
                while($row_contact_id12 = $result_contact_id12->fetch_assoc()) {

                    $db_event = $row_contact_id12["eventEmarsysID"];
                }
            }


            //-------------------------------------
            $sql123 = "SELECT * FROM emarsys_external_events where store_name='" . trim($shop) . "' AND eventName='Shopify_welcome_email'";

             $result_contact_id123 = $con->query($sql123);

             if ($result_contact_id123->num_rows > 0) {
                
                // output data of each row
                while($row_contact_id123 = $result_contact_id123->fetch_assoc()) {

                    $db_welcome_event = $row_contact_id123["eventEmarsysID"];
                }
            }


            // create campaign for the OPTIN --------------------------------------

				$external_event_id = $db_event;

				$email_campaign = $emarsyClient->send('POST', 'email', '{
  "name": "Shopify Confirmation Email",
  "content_type": "html",
  "language": "en",
  "fromemail": "'.$fromemail.'",
  "fromname": "'.$fromname.'",
  "subject": "opt",
  "email_category": "0",
  "external_event_id": "'.$external_event_id.'",
  "html_source": "<html><head></head>\n\t<body style=\"visibility: visible;\">\n\t\t<div><br /></div><div>Hello %%name%%,</div>\n\t\t<div><br /></div>\n\t\t<div>Kindly Click the below link to verify your email address.</div><div><br /></div>\n\t\t<div>"'.APP_URI.'"/optin_verify.php/?r=%%random%%&s=%%shopify_user_id%%</div><div><br /></div><div>Thank You.<br /></div>\n\t\n</body></html>",
  "text_source": "",
  "raw_html": 1,
  "raw_text": 0,
  "unsubscribe": 0,
  "browse": 0,
  "text_only": 0
}');


            $email_campaign_array = json_decode($email_campaign, true);

            
            // get the email campaign id ----------
            $email_campaign_id = $email_campaign_array['data']['id'];

			if(!empty($email_campaign_id)){

					// launch the email campaign--------------
					$email_campaign = $emarsyClient->send('POST', 'email/'.$email_campaign_id.'/launch', '{
  "emailId": "'.$email_campaign_id.'",
  "schedule": "",
  "timezone": ""
}');

			}



	 // create campaign for the Welcome Email --------------------------------------
	 
$external_event_id_welcome = $db_welcome_event;

				$email_campaign_welcome = $emarsyClient->send('POST', 'email', '{
  "name": "Shopify Welcome Email",
  "content_type": "html",
  "language": "en",
  "fromemail": "'.$fromemail.'",
  "fromname": "'.$fromname.'",
  "subject": "opt",
  "email_category": "0",

  "external_event_id": "'.$external_event_id_welcome.'",

  "html_source": "<html><head></head><body style="visibility: visible;"><div>Hello %%name%%,</div><div><br /></div><div>Welcome in %%store%%, and hope you enjoying our services.</div><div><br /></div><div>Thank You.<br /></div></body></html>",
  
  "text_source": "",
  "raw_html": 1,
  "raw_text": 0,
  "unsubscribe": 0,
  "browse": 0,
  "text_only": 0
}');


            $email_campaign_array_welcome = json_decode($email_campaign_welcome, true);

            // echo("<pre>");
            // print_r($email_campaign_array);

            // get the email campaign id ----------
            $email_campaign_id_welcome = $email_campaign_array_welcome['data']['id'];

			if(!empty($email_campaign_id_welcome)){

				// save the email campaign id intto the database
			$sql_email_campaingn = "INSERT INTO optin_campaign_id (id, store_name, optin_campaign_id, welcome_campaign_id) VALUES ('', '" . trim($shop) . "', '" . trim($email_campaign_id) . "', '" . trim($email_campaign_id_welcome) . "')";

				mysqli_query($con, $sql_email_campaingn);



			// launch the email campaign--------------
			$email_campaign = $emarsyClient->send('POST', 'email/'.$email_campaign_id.'/launch', '{
  "emailId": "'.$email_campaign_id_welcome.'",
  "schedule": "",
  "timezone": ""
}');

			}








		}  // end of if optin = 2	

				


//----------------------------------------------------------------------------------------------

		    }else{
			    	// insert optin
			    	$sql = "INSERT INTO emarsys_optin (id, store_name, optin, 'mail_sent') VALUES ('', '" . trim($shop) . "', '" . trim($optin) . "', '0')";

				mysqli_query($con, $sql);

		    }	 

	echo "success";	    	


	}	

