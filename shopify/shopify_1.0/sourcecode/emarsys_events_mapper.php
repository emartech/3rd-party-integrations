<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once './config.php';
require_once './emarsys.php';
require_once './database.php';

$query = "SELECT * FROM `emarsys_credentials` WHERE `store_name` = '" . trim($_SESSION['shop']) . "'";
$result = $con->query($query);


if ($result->num_rows > 0){

	//GET SAVED DATA
	$query = "SELECT pkEventMapperID, fkShopifyEventID, fkEventID FROM `emarsys_event_mapper` WHERE `store_name` = '" . $_SESSION['shop'] . "' ORDER BY fkShopifyEventID";
	$eventConfigs = $con->query($query);
	$configs = [];
	while($e = $eventConfigs->fetch_assoc()){
		$configs[$e['fkShopifyEventID']] = [
			'pkEventMapperID' => $e['pkEventMapperID'],
			'fkEventID' => $e['fkEventID']
		];
	}

	$query = "SELECT * FROM `emarsys_external_events` WHERE `store_name` = '" . trim($_SESSION['shop']) . "'";
	$result = $con->query($query);
	$query = "SELECT * FROM `shopify_events`";
	$shopifyEvents = $con->query($query);
	$eventsList = [];
	while($eme = $result->fetch_assoc()){
		$eventsList[$eme['pkEventID']] = $eme['eventName'];
	}
	if ($result->num_rows < 1){
		header('Location: ./events.php');
	}
}
else{
	header('Location: ./emarsys_details.php');
}


if(isset($_POST['submit'])){
	$query = "INSERT INTO `emarsys_event_mapper` (pkEventMapperID, store_name, fkShopifyEventID, fkEventID) VALUES ";

	$x = 0;
	foreach($_POST['shopifyEventID'] as $key => $value){
		if($x > 0){
			$query .= ", ";
		}
		$id = (isset($_POST['eventMapperID'][$key])) ? $_POST['eventMapperID'][$key] : '';
		$query .= "('" . $id . "', '" . $_SESSION['shop'] . "', '" . $value . "', '" . $_POST['emarsysEventID'][$key] . "')";
		$x++;
	}

	$query .= " ON DUPLICATE KEY UPDATE fkEventID=VALUES(fkEventID);";
	$result = $con->query($query);
	header('Location: '. $_SERVER['PHP_SELF'] );
	Exit(); //optional
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
	                    <h3 class="page-header">Events Mapping</h3>
	                </div><!-- /.col-lg-12 -->
	            </div><!-- /.row -->
	            <?php if ($result->num_rows > 0): ?>
	            <div class="row">
	                <div class="col-lg-12">
	                    <table class="table table-striped">
						    <thead>
						      <tr>
						        <th>Shopify Event Name</th>
						        <th>Emarsys Events</th>
						        <th>Placeholder</th>
						      </tr>
						    </thead>
						    <tbody>
						    <form method="POST">
						<?php while($event = $shopifyEvents->fetch_assoc()): ?>
						     <tr>
						       <td><?= $event['shopifyEnevtName'] ?></td>
						       <td>
						       		<select name="emarsysEventID[]" class="form-control">
						       			<option value="">--Select--</option>
					       				<?php foreach($eventsList as $id => $ev):?>
					       				<option value="<?= $id ?>" <?= ((!empty($configs[$event['pkShopifyEventID']]['fkEventID'])) && ($configs[$event['pkShopifyEventID']]['fkEventID'] == $id)) ? 'selected' : ''?>><?= $ev ?></option>
					       				<?php endforeach; ?>
						       		</select>
					       			<input type="hidden" name="eventMapperID[]" value="<?= (isset($configs[$event['pkShopifyEventID']]['pkEventMapperID'])) ? $configs[$event['pkShopifyEventID']]['pkEventMapperID'] : ''?>">
						       		<input type="hidden" name="shopifyEventID[]" value="<?= $event['pkShopifyEventID']?>">
						       </td>
						       <td><a href="placeholders/index.php?id=<?= $event['pkShopifyEventID']?>" class="btn btn-default <?= (empty($configs[$event['pkShopifyEventID']]['fkEventID'])) ? 'disabled' : ''?>">Placeholder</a></td>
						      </tr>
						<?php endwhile; ?>
							<tr class="text-center">
								<td colspan="4" class="text-center"><button type="submit" name="submit" class="btn btn-default">Save</button></td>
							</tr>
							</form>
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