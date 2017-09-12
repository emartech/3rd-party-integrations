<?php

require ('ShopifyAPI/ShopifyClient.php');

require 'config.php';

require 'database.php';

session_start();

    $sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);

    try
    {
        
   // store token in the database---
    $token = $_SESSION['token'];

    $shop = $_SESSION['shop'];
 



    // default database requirements ------------------------
    
    $sql_token = "INSERT INTO store (store_name, token) SELECT '". $shop ."','". $token ."' FROM store WHERE NOT EXISTS (SELECT * FROM store WHERE store_name='".$shop."' AND token='".$token."') LIMIT 1";     

    mysqli_query($con, $sql_token);

    $optin = 1; // default optin is set to 1(single optin) for all user
    $sql_optin = "INSERT INTO emarsys_optin (store_name, optin) SELECT '". $shop ."','". $optin ."' FROM emarsys_optin WHERE NOT EXISTS (SELECT * FROM emarsys_optin WHERE store_name='".$shop."' ) LIMIT 1";     

    mysqli_query($con, $sql_optin);




class ChecklistData{

    public function checklist_data($con, $shop, $checklist_id){

            $checklist_query = "SELECT * from checklist where store_name='".$shop."' AND property_id='".$checklist_id."'";

           $checklist_query_result = $con->query($checklist_query);



            if ($checklist_query_result->num_rows > 0) {
               
                // output data of each row
                while($checklist_query_result_row = $checklist_query_result->fetch_assoc()) {

                    $checklist_status = $checklist_query_result_row['status'];
     
                }

            }   

            return $checklist_status;  
    }

    public function cron_data($con, $shop, $checklist_id){

           $checklist_query = "SELECT * from cron where store_name='".$shop."' AND shopify_data='".$checklist_id."'";

           $checklist_query_result = $con->query($checklist_query);



            if ($checklist_query_result->num_rows > 0) {
               
                // output data of each row
                while($checklist_query_result_row = $checklist_query_result->fetch_assoc()) {

                    $checklist_status = $checklist_query_result_row['status'];
     
                }

            }   

            return $checklist_status;  
    }
}

$checklist = new ChecklistData();

//----------- dashboard ----------------------------------
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
            
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


            <div class="row">

             <div class="col-lg-12">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                            System Requirements
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    
                                    <thead>
                                        <tr class="center-tab">
                                            <th class="center-tab">#</th>

                                            <th class="center-tab">Properties</th>

                                            <th class="center-tab">Recomended Value</th>
                                            <th class="center-tab">Current Value</th>
                                        </tr>
                                    </thead>

                                    <tbody class="center-tab">
                                        
                                        <tr class="">
                                            <td>1</td>

                                            <td>PHP Version</td>
                                            
                                            <td>>=5.6.0</td>
                                            <td><strong><?php echo(phpversion());?></strong></td>
                                        </tr>
                                        
                                        
                                        <tr class="">
                                            <td>2</td>

                                            <td>CURL Enabled</td>
                                            
                                            <td>Yes</td>
                                            <td><strong><?php echo function_exists('curl_version') ? 'Yes' : 'No';?></strong></td>
                                        </tr>
                                        
                                        <tr class="">
                                            <td>3</td>

                                            <td>SOAP Enabled</td>
                                            
                                            <td>Yes</td>
                                            <td><strong>
                                                <?php
                                                    if (extension_loaded('soap')) {
                                                        echo 'Yes';
                                                    }else{
                                                        echo('No');
                                                    }
                                                ?></strong></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>  

            <div class="row">

           

             <div class="col-lg-12">
                   <div class="panel panel-default">
                        <div class="panel-heading">
                            Extension Settings
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    
                                    <thead>
                                        <tr>
                                            <th class="center-tab">#</th>

                                            <th class="center-tab">Properties</th>

                                            <th class="center-tab">Recommended Status</th>
                                            
                                            <th class="center-tab">Current Status</th>

                                            <th class="center-tab" colspan="2">Action</th>

                                            <!-- <th class="center-tab">Share Credentials</th> -->
                                        </tr>
                                    </thead>

                                    <tbody class="center-tab">
                                        
                                        <tr class="">
                                            <td>1</td>

                                            <td>Emarsys API</td>
                                            
                                            <td>Enable</td>

                                            <td><strong><?php echo $checklist->checklist_data($con, $shop, '21'); ?></strong></td>

                                            <td>
                                                <a href="checklist_verify.php?id=21">Check</a>
                                            </td>

                                            <td>
                                                <a href="emarsys_details.php">Share</a>
                                            </td>
                                        </tr>
                                        
                                        
                                        
                                        
                                        <tr class="">
                                            <td>2</td>

                                            <td>SFTP for Store Data</td>
                                            
                                            <td>Enable</td>

                                            <td><strong><?php echo $checklist->checklist_data($con, $shop, '22'); ?></strong></td>

                                            <td>
                                                <a href="checklist_verify.php?id=22">Check</a>
                                            </td>

                                            <td>
                                                <a href="sftp_details.php">Share</a>
                                            </td>
                                        </tr>


                                        <tr class="">
                                            <td>3</td>

                                            <td>SFTP for Smart Insights</td>
                                            
                                            <td>Enable</td>
                                            
                                            <td><strong><?php echo $checklist->checklist_data($con, $shop, '23'); ?></strong></td>

                                            <td>
                                                <a href="checklist_verify.php?id=23">Check</a>
                                            </td>

                                            <td>
                                                <a href="sftp_details_si.php">Share</a>
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>


            <div class="panel panel-default">
                        <div class="panel-heading">
                            Automation Status
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    
                                    <thead>
                                        <tr class="center-tab">
                                            <th class="center-tab">#</th>

                                            <th class="center-tab">Properties</th>

                                            <th class="center-tab">Current Status</th>

                                            <th class="center-tab">Action</th>
                                           
                                        </tr>
                                    </thead>

                                    <tbody class="center-tab">
                                        
                                        <tr class="">
                                            <td>1</td>

                                            <td>Customer Data</td>
                                            
                                           <td><strong>
                                            <?php $status = $checklist->cron_data($con, $shop, 'customer');
                                                if($status == '1'){
                                                    echo 'Enable';
                                                }else{
                                                    echo('Disable');
                                                }
                                             ?> </strong></td>

                                             <td><a href="cron.php?type=customer">Share</a></td>
                                       
                                        </tr>
                                        
                                        
                                        <tr class="">
                                            <td>2</td>

                                            <td>Product Data</td>
                                            
                                            <td><strong><?php $status = $checklist->cron_data($con, $shop, 'product');
                                                if($status == '1'){
                                                    echo 'Enable';
                                                }else{
                                                    echo('Disable');
                                                }
                                             ?></strong></td>

                                             <td><a href="cron.php?type=product">Share</a></td>
                                           
                                        </tr>
                                        
                                        <tr class="">
                                            <td>3</td>

                                            <td>Purchase Data</td>
                                            
                                            <td><strong>
                                                <?php $status = $checklist->cron_data($con, $shop, 'order');
                                                if($status == '1'){
                                                    echo 'Enable';
                                                }else{
                                                    echo('Disable');
                                                }
                                             ?>
                                             </strong></td>

                                             <td><a href="cron.php?type=order">Share</a></td>
                                           
                                        </tr>

                                        <tr class="">
                                            <td>3</td>

                                            <td>Smart Insight</td>
                                            
                                            <td><strong>
                                            <?php $status = $checklist->cron_data($con, $shop, 'si');
                                                if($status == '1'){
                                                    echo 'Enable';
                                                }else{
                                                    echo('Disable');
                                                }
                                             ?></strong></td>

                                             <td><a href="cron.php?type=si">Share</a></td>
                                            
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>


            
            <?php 
                $query_emarsys_events = "SELECT * FROM `emarsys_external_events` WHERE `store_name` = '" . trim($_SESSION['shop']) . "'";
                $result_emarsys_events = $con->query($query_emarsys_events);

                
            ?> 


            <?php if($result_emarsys_events == 0){ ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Required Events On Emarsys:</div>
                
                        <div class="panel-body">
                            <a href="events.php" class="alert-link"><strong>Click Here</strong></a> to create events on Emarsys.
                    
                        </div>
                    </div>

                </div>
                
            </div>
             
             <?php } ?>

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

    <style type="text/css">
        .center-tab{
            text-align: center !important;
        }
    </style>

</body>

</html>


<?php 

//------------------------------------------------------------------        

        

    }
    catch (ShopifyApiException $e)
    {
        /* 
         $e->getMethod() -> http method (GET, POST, PUT, DELETE)
         $e->getPath() -> path of failing request
         $e->getResponseHeaders() -> actually response headers from failing request
         $e->getResponse() -> curl response object
         $e->getParams() -> optional data that may have been passed that caused the failure

        */
    }
    
?>