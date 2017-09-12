<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'config.php';
require_once 'emarsys.php';
require_once 'database.php';

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
</head>

<body>
	<div id="wrapper">
		<?php require('nav.php'); ?> 
		<div id="page-wrapper">
			<div class="container-fluid">
	            <div class="row">
	                <div class="col-lg-12">
	                    <h3 class="page-header">Sync Events</h3>
	                </div><!-- /.col-lg-12 -->
	            </div><!-- /.row -->
	            <?php if ($result->num_rows > 0): ?>
	            <div class="row">
	                <div class="col-lg-12">
	                <a href="events/refresh.php" class="btn btn-default pull-right">Refresh</a>
	                    <table class="table table-striped">
						    <thead>
						      <tr>
						      	<th>#</th>
						        <th>Shopify Event Name</th>
						        <th>Event Emarsys ID</th>
						      </tr>
						    </thead>
						    <tbody>
						    <?php $i = 1;?>
						<?php while($row = $result->fetch_assoc()): ?>
						     <tr>
						       <td><b><?= $i++?></b></td>
						       <td><?= $row['eventName'] ?></td>
						       <td><?= $row['eventEmarsysID'] ?></td>
						      </tr>
						<?php endwhile; ?>
						    </tbody>
						</table>
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

   

</body>

</html>