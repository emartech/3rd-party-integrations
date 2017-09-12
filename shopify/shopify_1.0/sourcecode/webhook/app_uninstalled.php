<?php
/*
* Customer Create
*/
	session_start();

	require ('../ShopifyAPI/ShopifyClient.php');

	require '../config.php';

	require '../database.php';

	require ('../emarsys.php');

	
	//-------- verify the webhook --------------
	

	function verify_webhook($data, $hmac_header)
	{
	  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_SECRET, true));
	  return hash_equals($hmac_header, $calculated_hmac);
	}


		$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];

		$shop = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];

		$data = file_get_contents('php://input');
		
		$verified = verify_webhook($data, $hmac_header);



	//-------- get the webhook data ------------

	$webhookContent = "";

	$webhook = fopen('php://input' , 'rb');
	while (!feof($webhook)) {
	    $webhookContent .= fread($webhook, 4096);
	}

	fclose($webhook);

	//  $webhookContent;



	$shopify_data = json_decode($webhookContent, true);

	$uninstall_store = $shopify_data['myshopify_domain'];



	 // get the customer email for sent the mail to the customer -----
    $sql_email = "SELECT * FROM store where store_name='" . trim($shop) . "'";
      

	  $result_email = $con->query($sql_email);

      if ($result_email->num_rows > 0) {
                
      	// output data of each row
      	while($row_email = $result_email->fetch_assoc()) {

        	$shop_token = $row_email["token"];

        }
    }


    $shopifyClient = new ShopifyClient($shop, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);



	// delete data after un-install the app

	if( trim($uninstall_store) == trim($shop) ){

		// delete webhook in shopify---------------------------------------------

    	$webhook_query = "SELECT * from shopify_webhook where store_name='".$shop."'";

        $webhook_query_result = $con->query($webhook_query);

            if ($webhook_query_result->num_rows > 0) {
               
                // output data of each row
                while($webhook_query_result_row = $webhook_query_result->fetch_assoc()) {

                    $shopify_webhook[] = $webhook_query_result_row['shopify_webhook_id'];
     
                }

            }   

         foreach ($shopify_webhook as $data) {

			$id = $data['id'];

			$shopifyClient->call('DELETE', '/admin/webhooks/'. $id .'.json');
	
          	
          } 


		// delete events and custom fields from emarsys --------------------------

        $sql_emarsys_fields = "delete from emarsys_fields where store_name = '".trim($uninstall_store) ."'";     

	    mysqli_query($con, $sql_emarsys_fields);

  



		// delete the data from database ----------------------------------------
	
		$delete_array = array('checklist', 'contact_mapping', 'cron', 'emarsys_cart_placeholders', 'emarsys_checkout_placeholders', 'emarsys_contacts', 'emarsys_contact_export', 'emarsys_credentials', 'emarsys_customer_placeholder', 'emarsys_email_templates', 'emarsys_event_mapper', 'emarsys_external_events', 'emarsys_fields', 'emarsys_fulfillments_placeholders', 'emarsys_optin', 'emarsys_order_placeholders', 'emarsys_product_placeholders', 'optin_campaign_id', 'optin_verify', 'sftp_credentials', 'sftp_si_credentials', 'shopify_events', 'shopify_webhook', 'smart_insight', 'smart_insight_webhook', 'store', 'webdav_credentials');

		foreach ($delete_array as $key => $value) {
			// delete query
			 $sql_token = "delete from $value where store_name = '".trim($uninstall_store) ."'";     

	    	mysqli_query($con, $sql_token);

		}
	}
