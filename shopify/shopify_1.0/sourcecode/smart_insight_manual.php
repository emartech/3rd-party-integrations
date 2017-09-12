<?php 
session_start();


$shop = $_SESSION['shop'];

require ('database.php');

// echo "<pre>";
// print_r($_SESSION);
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
        <?php require('nav.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Manual Sync</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <p>





                        <?php 
                            // check sftp details available or not.
                            $count_query = "SELECT * FROM sftp_si_credentials where store_name = '". $shop ."'";

                            $result = $con->query($count_query);

                            $rowcount = $result->num_rows;

                            if ($result->num_rows > 0) {
                
                                // output data of each row
                                while($row_sftp = $result->fetch_assoc()) {

                                       $db_sftp = $row_sftp["sftp_hostname"];
                                    }
                            }

                           

                             if ($rowcount == '1') { ?>
                                
                               <!--  <a href="#" class="activatewebhook">Click Here</a> to to Export Shopify contacts in SFTP . -->

                                <div class="alert alert-success">
                                        
                                        <a href="#" class="activatewebhook"><strong>Click Here</strong></a> to export the purchase data.
                                </div>


                                <!-- <p>The csv file will export on below location:</p>

                                <p>FTP: <?php echo $db_sftp; ?> </p>
                                <p>Folder: / </p>
                                <p>Filename: export_shopify_all_contacts.csv </p> -->

                                <div class="panel panel-default">
                                    
                                    <div class="panel-heading">The csv file will export on below location:</div>
                
                                    <div class="panel-body">
                                    
                                        <p>FTP: <?php echo $db_sftp; ?> </p>
                                        <p>Folder: / </p>
                                        <p>Filename: smart_insight.csv</p>
                                    </div>
                                </div>
                                

                          
                          <?php   } else{    ?>    


                       
                       <div class="alert alert-warning">
                                Kindly share the SFTP credentials for Manual Sync.</strong>.
                        </div>


                        
                        <?php } ?>

                        
                        </p>
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


    <script type="text/javascript">
        
        $('.activatewebhook').click(function(e){
            
            e.preventDefault();//in this way you have no redirect
            
              $.ajax({
          
            type: 'post',
           
            url: 'smart_insight.php',
          
            // data: $('form').serialize(),
          
            success: function (data) {

                var status = $.trim(data);
             
                if(status == 'success'){

                    alert("Contacts Export successfully over SFTP.");
                   
              
                }if(status == 'error'){
               
                    alert("Something went wrong, try again later.");
              
                }
            
         
            }
          });

        });
    </script>

</body>

</html>
