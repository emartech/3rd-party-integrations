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
                        <h3 class="page-header">Contacts</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <p>





                        <?php 
                            // check sftp details available or not.
                            $count_query = "SELECT * FROM sftp_credentials where store_name = '". $shop ."'";

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
                                        
                                        <a href="#" class="activatewebhook"><strong>Click Here</strong></a> to complete the sync.
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
                                        <p>Filename: export_shopify_all_contacts.csv</p>
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

    <script type="text/javascript">
        
        $('.activatewebhook').click(function(e){
            
            e.preventDefault();//in this way you have no redirect
            
              $.ajax({
          
            type: 'post',
           
            url: 'export_contacts.php',
          
            // data: $('form').serialize(),
          
            success: function (data) {
             
                if(data == 'success'){
                  
                    alert("Contacts Export successfully over SFTP");
                   
              
                }if(data == 'error'){
               
                    alert("Something went wrong, try again later.");
              
                }
            
         
            }
          });

        });
    </script>

</body>

</html>
