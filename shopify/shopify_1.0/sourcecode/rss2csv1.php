<?php
    session_start();

    require ('ShopifyAPI/ShopifyClient.php');

    require 'config.php';

    require 'database.php';

    require ('emarsys.php');

    include('Net/SFTP.php');

    include ("rss2csv1.inc");

    // echo "<pre>";

    // print_r($_SESSION);

    $shop = $_SESSION['shop'];

    $token = $_SESSION['token'];



   
    // code for feeds
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    header ('Allow: GET');
    header ('HTTP/1.0 405 Method Not Allowed');
    exit();
}



$url = isset($_GET['url']) ? $_GET['url'] : '';
$convert = ($url <> '') ? true : false;

if ($convert) {
    // fetch RSS content using YQL and output as CSV
    // error_log (date(DATE_ISO8601) . "  $url\n",3,"./log/rss2csv.log");

    fetchRSSandOutputCSV ($url);
    exit();
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

    <title>Emarsys Admin</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <meta name=viewport content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css&amp;2.8.0r4/build/base/base-min.css">

    
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

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

        <!-- Navigation -->
        <?php 

            require('nav.php'); 

        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-lg-12">
                        <h3>Feed Export</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                   <div class="col-lg-12">

export feed on sftp

<form id="search-form" action="rss2csv.php" method="get">
  <fieldset>
    <label for="query">Enter URL of RSS feed:</label>
    <input type="text" id="query" name="url" size="50" value="<?php echo $url; ?>" />
    <button type="submit">Submit</button>
  </fieldset>
</form>



                    </div>
                    <!-- /.col-lg-12 -->
                </div>

               
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
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

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>




    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

    

</body>

</html>














