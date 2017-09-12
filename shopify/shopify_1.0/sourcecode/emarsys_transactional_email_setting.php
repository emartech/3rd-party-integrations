<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';
require_once 'emarsys.php';
require_once 'database.php';

if(isset($_POST['submit'])){
	$statusIDs = implode(',', $_POST['eventStatus']);
	$query = "UPDATE `emarsys_external_events` SET `eventStatus` = '1' WHERE `pkEventID` IN (" . $statusIDs . ")";
	$result = $con->query($query);
	$query = " UPDATE `emarsys_external_events` SET `eventStatus` = '0' WHERE `pkEventID` NOT IN (" . $statusIDs . ")";
	$result = $con->query($query);
}

$query = "SELECT * FROM `emarsys_external_events` WHERE `store_name` = '" . trim($_SESSION['shop']) . "'";
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
	                    <h1 class="page-header">Transactional Email Settings</h1>
	                </div><!-- /.col-lg-12 -->
	            </div><!-- /.row -->
	            <?php if ($result->num_rows > 0): ?>
	            <div class="row">
	                <div class="col-lg-12">
	                	<form method="POST">
	                    <table class="table table-striped">
						    <thead>
						      <tr>
						      	<th>#</th>
						        <th>Emarsys Event Name</th>
						        <th>Event Emarsys ID</th>
						        <th>Status</th>
						      </tr>
						    </thead>
						    <tbody>
						    <?php $i = 1;?>
						<?php while($row = $result->fetch_assoc()): ?>
						     <tr>
						     <td><b><?= $i++; ?></b></td>
						       <td><?= $row['eventName'] ?></td>
						       <td><?= $row['eventEmarsysID'] ?></td>
						       <td>
						       		<div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="eventStatus[]" value="<?= $row['pkEventID']?>" <?= ($row['eventStatus'] == 1) ? 'checked' : ''?>>
                                            </label>
                                        </div>
                                    </div>
                                </td>
						      </tr>
						<?php endwhile; ?>
						    </tbody>
						    <tfoot>
						    	<tr>
						    		<td colspan="4" class="text-center"><button type="submit" name="submit" class="btn btn-default">Save</button></td>
						    	</tr>
						    </tfoot>
						</table>
						</form>
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