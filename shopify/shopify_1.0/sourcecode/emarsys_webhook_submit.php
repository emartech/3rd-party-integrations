<?php 
    session_start();

	require ('ShopifyAPI/ShopifyClient.php');

	require 'config.php';

	require 'database.php';

	require ('emarsys.php');

	
	if($_POST){

			 $shop = $_POST['shop'];


			 $date_from = date("Y-m-d", strtotime($_POST['from']));

			 $date_to = date("Y-m-d", strtotime($_POST['to']));



			// $date_from = "2017-01-01";

			// $date_to = "2017-07-19";

			// echo $date_from.' '. $date_to;

		  // get the shopify contact id over emarsys-----
		  $sql1 = "SELECT * FROM emarsys_contacts where store_name='" . trim($shop) . "'";
      
		  $result1 = $con->query($sql1);

	      if ($result1->num_rows > 0) {
	                
	      	// output data of each row
	      	while($row1 = $result1->fetch_assoc()) {

	        	$emarsys_contact_id = $row1["emarsys_shopify_contact_id"];
	        	

	        }
	    }	 

	    $notification_url_app = APP_URI . "/notify.php"

		// call emarsys api to export the data from selected dates by user
		$field = $emarsyClient->send('POST', 'contact/getchanges', '{
			
			"distribution_method": "local",

			"origin" : "all",

		  	"origin_id" : ["79"],  

		  	"time_range": ["'. $date_from .'","' . $date_to.'"],

		  	"contact_fields": ["3","'. $emarsys_contact_id .'"],
  			
  			"delimiter": ";",
  			
  			"add_field_names_header": 1,

  			"notification_url": "'.$notification_url_app.'",
  			
  			"language": "en"

		}');
	
		$emarsys_field = json_decode($field, true);

		$export_id = $emarsys_field['data']['id'];

		if( (!empty($shop)) && (!empty($export_id)) ){

		
			$sql = "INSERT INTO emarsys_contact_export (id, store_name, emarsys_export_id) VALUES ('', '" . trim($shop) . "', '" . trim($export_id) . "')";

			if(mysqli_query($con, $sql)){

				echo "success";
			}else{

				echo "error";
			}
		}	

		
	} // end of $_POST