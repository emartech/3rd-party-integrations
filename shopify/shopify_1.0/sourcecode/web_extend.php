<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once 'config.php';
require_once 'emarsys.php';
require_once 'database.php';

if(isset($_POST['submit']) && ($_POST['submit'] == 'submit')){

    $query = "UPDATE `emarsys_credentials` SET `emarsys_merchant_id` = '" . $_POST['merchant_id'] . "' WHERE store_name = '" . $_SESSION['shop'] . "'";
    $result = $con->query($query);
    if($result){
        $_SESSION['message'] = 'Emarsys Credential Updated!';
    }
}

$query = "SELECT * FROM `emarsys_credentials` WHERE store_name = '" .  $_SESSION['shop'] . "'";
$result = $con->query($query);
if($result->num_rows > 0){
	$emarsysData = $result->fetch_assoc();
	$emarsysMerchantID = $emarsysData['emarsys_merchant_id'];
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
		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Web Extend</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <?php if(isset($_SESSION['message'])):?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-warning">
                            <?= $_SESSION['message']; ?>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <?php unset($_SESSION['message']);?>
            <?php endif; ?>
                <div class="row">
                   <div class="col-lg-12">
                    <form action="" method="POST">
                      <div class="form-group">
                        <label for="merchant_id">Merchant ID</label>
                        <input class="form-control" name="merchant_id" value="<?= (isset($emarsysMerchantID)) ? $emarsysMerchantID : ''; ?>" required>
                      </div>
                      	<button type="submit" class="btn btn-default" name="submit" value="submit">Save</button>


                    </form>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                	<div class="col-lg-12">
                        <div class="panel panel-default" style="margin-top: 15px;">
                            <div class="panel-heading">
                                Manage Web Extend
                            </div>
                            <div class="panel-body">
                                <blockquote>
                                <p>For Order tracking, please add the below script to the <b>settings >> checkout >> Additional scripts</b> section from the admin panel</p>
                                </blockquote>
                                <pre>
&lt;script&gt;
var ScarabQueue = ScarabQueue || [];
(function(subdomain, id) {
  if (document.getElementById(id)) return;
  var js = document.createElement('script'); js.id = id;
  js.src = subdomain + '.scarabresearch.com/js/<?= (isset($emarsysMerchantID)) ? $emarsysMerchantID : ''; ?>/scarab-v2.js';
  var fs = document.getElementsByTagName('script')[0];
  fs.parentNode.insertBefore(js, fs);
})('https:' == document.location.protocol ? 'https://recommender' : 'http://cdn', 'scarab-js-api');

// Passing on order details. The price values passed on here serve as the basis of our revenue and revenue contribution reports.
ScarabQueue.push(['purchase', {
    orderId: {{ order.order_number }},
    items: [
    {% for item in order.line_items %}
        {% if forloop.length == 1 %}
            {item: {{item.id}}, price: {{item.price}}, quantity: {{item.quantity}}}
        {% else %}
            {item: {{item.id}}, price: {{item.price}}, quantity: {{item.quantity}}},
        {% endif %}
    {% endfor %}
    ]
}]);

// Firing the ScarabQueue. Should be the last call on the page, called only once.
ScarabQueue.push(['go']);
&lt;/script&gt;
                                </pre>
                                <div class="text-center">
                                    <a class="btn btn-success" href="webextend/installer.php?id=1">Install</a>
                                    <a class="btn btn-danger" href="webextend/installer.php?id=0">Uninstall</a>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
	                	<div class="form-group">
	                	</div>
                	</div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
	</div><!-- /#wrapper -->
</body>

</html>