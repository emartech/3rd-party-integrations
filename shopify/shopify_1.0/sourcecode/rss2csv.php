<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
    session_start();

    require ('ShopifyAPI/ShopifyClient.php');

    require 'config.php';

    require 'database.php';

    require ('emarsys.php');

    include('Net/SFTP.php');

    include ("rss2csv.inc");

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

    $csvname = fetchRSSandOutputCSV ($url);

    //upload the feed file on sftp server.
    



    $sql_sftp = "SELECT * FROM sftp_credentials where store_name='" . trim($shop) . "'";
          
    $result_sftp = mysqli_query($con, $sql_sftp);

    if (mysqli_num_rows($result_sftp) > 0) {
       
        while($row = mysqli_fetch_assoc($result_sftp)) {

            $sftp_hostname = $row["sftp_hostname"];

            $sftp_port = $row["sftp_port"];

            $sftp_username = $row["sftp_username"];

            $sftp_password = $row["sftp_password"];

            $sftp_export = $row["sftp_export"];

            $feed_export = $row["feed_export"];
            
        
        }
    }



    $sftp = new Net_SFTP($sftp_hostname);
    
    if ($sftp->login($sftp_username, $sftp_password)) {
    
        if($sftp->put("$feed_export/$csvname", "csv/$csvname", NET_SFTP_LOCAL_FILE)){

           unlink('csv/' . $csvname);


           $status = 'fs'; // success

        }else{

           $status = 'fe'; // error
        }

    }else{
        $status = 'fe'; // error
    }
    
    header("Location: message.php?msg=$status"); 

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
                       <h3 style="float: left!important;">RSS Feeds</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                   <div class="col-lg-12">


<!-- <input class="form-control" value="<?php // echo $shop; ?>" disabled="disabled"> -->


    <form action="rss2csv.php" method="get" style="float: left!important;">

        <div class="form-group">
                     
            <label for="exampleInputEmail1">Enter URL of RSS feed:</label>
                      
            

            <input type="text" name="url" size="50" value="<?php echo $url; ?>" />

        </div>
       
        <button type="submit" class="btn btn-default" style="float: left!important;">Submit</button>

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

    

    

</body>

</html>














