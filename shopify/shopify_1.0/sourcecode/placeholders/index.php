<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../config.php';
require_once '../emarsys.php';
require_once '../database.php';

$query = "SELECT * FROM `emarsys_credentials` WHERE `store_name` = '" . trim($_SESSION['shop']) . "'";
$result = $con->query($query);
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
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div id="wrapper">
		
		<div id="page-wrapper">
			<div class="container-fluid">
	            <div class="row">
	                <div class="col-lg-12">
	                    <h1 class="page-header">Shopify - Emarsys Placeholder Mapper</h1>
	                </div><!-- /.col-lg-12 -->
	            </div><!-- /.row -->
	            <?php if ($result->num_rows > 0): ?>
	            <div class="row">
	                <div class="col-lg-12">
	                    <?php
	                    switch(true){
                    		case ($_GET['id'] == 1):
                            case ($_GET['id'] == 2):
                                require_once 'placeholder_cart.php';
                            break;
                            case ($_GET['id'] == 3):
                    		case ($_GET['id'] == 4):
                            case ($_GET['id'] == 5):
                    			require_once 'placeholder_checkout.php';
                    		break;
                    		case ($_GET['id'] == 6):
                    		case ($_GET['id'] == 7):
                    		case ($_GET['id'] == 8):
                    		case ($_GET['id'] == 9):
                    		case ($_GET['id'] == 10):
                    			require_once 'placeholder_customer.php';
                    		break;
                    		case ($_GET['id'] == 11):
                    		case ($_GET['id'] == 12):
                    			require_once 'placeholder_fulfillment.php';
                    		break;
                    		case ($_GET['id'] == 13):
                    		case ($_GET['id'] == 14):
                    		case ($_GET['id'] == 15):
                    		case ($_GET['id'] == 16):
                    		case ($_GET['id'] == 17):
                    		case ($_GET['id'] == 18):
                    		case ($_GET['id'] == 19):
                    			require_once 'placeholder_order.php';
                			break;
                    		case ($_GET['id'] == 20):
                    		case ($_GET['id'] == 21):
                    		case ($_GET['id'] == 22):
                    			require_once 'placeholder_product.php';
                    		break;
                    	}
                		?>
	                </div><!-- /.col-lg-12 -->
	            </div><!-- /.row -->
	            <?php else: ?>
	            <div class="row">
	            	<div class="col-lg-12">
		                <div class="alert alert-success">
	                        <p><a href="events/install.php">Click here!</a> to install the Shopify - Emersys Events</p>        
	                    </div>
	                </div>
	            </div>
	            <?php endif; ?>
	        </div><!-- /.container-fluid -->
		</div><!-- /#page-wrapper -->
	</div><!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>