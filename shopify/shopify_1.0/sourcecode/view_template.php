<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';
require_once 'emarsys.php';
require_once 'database.php';

if(isset($_GET['id'])){
	$query = "SELECT * FROM `emarsys_email_templates` WHERE `store_name` = '" . trim($_SESSION['shop']) . "' AND `pkTemplateID`  =  '" . $_GET['id'] . "'";
	$result = $con->query($query);
    if(!$result){
        header('Location: templates.php');
    }
    $row = $result->fetch_assoc();
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
		<?php require('nav.php'); ?> 
		<div id="page-wrapper">
			<div class="container-fluid">
	            <div class="row">
	                <div class="col-lg-12">
	                    <h1 class="page-header">Edit Template (<?= $row['templateTitle']?>)</h1>
                        <a href="templates.php" class="btn btn-default pull-right">Back</a>
	                </div><!-- /.col-lg-12 -->
	            </div><!-- /.row -->
	            <div class="row">
	                <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <label>Template Title:</label> <?= $row['templateTitle']?>
                            </div>
                            <div class="panel-body">
                                <label>Template Body:</label>
                                <?= $row['templateBody']?>
                            </div>
                            <div class="panel-footer">
                                <label>Created At:</label> <?= $row['createdAt']?>
                            </div>
                        </div>
	                </div><!-- /.col-lg-12 -->
	            </div><!-- /.row -->
	        </div><!-- /.container-fluid -->
		</div><!-- /#page-wrapper -->
	</div><!-- /#wrapper -->

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