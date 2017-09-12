<?php 
    session_start();

	require ('ShopifyAPI/ShopifyClient.php');

	require 'config.php';

	require 'database.php';

	require ('emarsys.php');

	$shop = $_SESSION['shop'];

	
	if($_POST){

		$shopify_field = $_POST['shopify_field'];
		
		$shopify_field_id = $_POST['shopify_field_id'];
		
		$field_id = $_POST['field_id'];

		if( (!empty($shopify_field)) && (!empty($shopify_field_id)) && (!empty($field_id)) ){


			$sql_verify = "SELECT * FROM contact_mapping where store_name='" . trim($shop) . "' AND shopify_field_id='".$shopify_field_id."'";
      
			$result_verify = $con->query($sql_verify);


			if ($result_verify->num_rows > 0) {
				// update the value
				$sql_query_checklist = "UPDATE contact_mapping SET emarsys_field_id ='" . trim($field_id) . "' WHERE store_name='".$shop."' AND shopify_field_id='" . trim($shopify_field_id) . "'";

				if(mysqli_query($con, $sql_query_checklist)){
		
		   			echo 'success';  
				}else {
	    
	    			echo 'error'; 
				}

			}else{
				// insert emarsys field id map by store admin
					$sql = "INSERT INTO contact_mapping (id, store_name, shopify_field, shopify_field_id, emarsys_field_id) VALUES ('', '" . trim($shop) . "', '" . trim($shopify_field) . "', '" . trim($shopify_field_id) . "', '" . trim($field_id) . "')";

					if(mysqli_query($con, $sql)){

						echo "success";
					}else{

						echo "error";
					}

			}
	
		}else{

			echo "error";
		}

	}else{

		echo "error";
	}