<?php

require ('emarsys.php');

require ('database.php');

$auth = trim($_GET['r']);

$shopify_user_id = trim($_GET['s']);

// get store name for the shopify user -----

$sql_optin = "SELECT * FROM optin_verify where shopify_user_id='" . trim($shopify_user_id) . "' LIMIT 1";
      

	  $result_optin = $con->query($sql_optin);

      if ($result_optin->num_rows > 0) {
                
      	// output data of each row
      	while($row_optin = $result_optin->fetch_assoc()) {

        	$db_shop = $row_optin["store_name"];

        	$db_shopify_user = $row_optin["shopify_user_id"];

        	$db_auth = $row_optin["auth"];


			// get emarsys field id for contacts -------
			$sql_contact_id = "SELECT * FROM emarsys_contacts where store_name='" . trim($db_shop) . "'";
      
			 $result_contact_id = $con->query($sql_contact_id);

			 if ($result_contact_id->num_rows > 0) {
                
      			// output data of each row
      			while($row_contact_id = $result_contact_id->fetch_assoc()) {

        			$db_contact_emarsys_id = $row_contact_id["emarsys_shopify_contact_id"];

        		}
        	}	


        		// echo "<br>";
        		// echo $auth;
        		// echo "<br>";
        		// echo $db_auth;


        	if($db_auth == $auth){
        		// update optin on database

        		$arr = array(
					'key_id' => $db_contact_emarsys_id,

					$db_contact_emarsys_id => $shopify_user_id,

					'31' => "1"
		
				);


 		      $emarsys_json =  json_encode($arr);

 		      $result = $emarsyClient->send('PUT', 'contact', $emarsys_json);

 		      // var_dump($output);

 		      $output = json_decode($result, json);

 		      // echo "<pre>";
 		      // print_r($output);
    			
    			if($output["replyText"] == "OK"){

    				$message =  "Email marketing updated over Emarsys.";

    				// $sql_delete = "DELETE FROM optin_verify WHERE auth='". $auth ."'";

                    $sql_delete = "UPDATE optin_verify SET auth='99999' WHERE shopify_user_id='".$shopify_user_id."'";

    				$con->query($sql_delete);


    			}else{
    				$message =  "Something went wrong, try again later.";
    			}
        	}

            if($db_auth == '99999'){
                $message =  "Email already verified.";
            }
        	

        }
    }else{
    	// shopify user not exists.
    	$message =  "Something went wrong.";
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Emarsys - Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <?php // require('nav.php'); ?> 
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Thank You.</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           


            <div class="row">
                    <div class="col-md-12">
                        <?php echo($message); ?>
                    </div>
            </div>
    

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>







