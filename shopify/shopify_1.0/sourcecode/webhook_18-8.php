<?php 
    session_start();

    require ('ShopifyAPI/ShopifyClient.php');

    require 'config.php';

    require 'database.php';

    $shop = $_SESSION['shop'];

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
                        <h3 class="page-header">Field Mapping</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <p>
                        <!-- <span class="alert-link">Click here</span> to enable Contacts Sync from Shopify to Emarsys. -->

                        <?php 


                         // check sftp details available or not.
                            $count_query = "SELECT * FROM emarsys_credentials where store_name = '". $shop ."'";

                            $result = $con->query($count_query);

                            $rowcount = $result->num_rows;


                             // check shopify details available or not.
                            $count_query1 = "SELECT * FROM store where store_name = '". $shop ."'";

                            $result1 = $con->query($count_query1);

                            $rowcount1 = $result1->num_rows;


                            if( ($rowcount == '1') && ($rowcount1 == '1') )
                            {

                                $count_query2 = "SELECT * FROM shopify_webhook where store_name = '". $shop ."'";


                                $result2 = $con->query($count_query2);

                                $rowcount2 = $result2->num_rows;
// echo($rowcount2);
                                if($rowcount2 == '23'){ 


                                 

                                  $sql1 = "SELECT * FROM emarsys_fields where store_name='" . trim($shop) . "'";
        
                                   $result1 = $con->query($sql1);

                                    if ($result1->num_rows > 0) {
                  
                                         // output data of each row
                                         while($row1 = $result1->fetch_assoc()) {

                                             $emarsys[$row1["fieldEmarsysID"]] = $row1["fieldEmarsysName"];
                      
                                          }
                                      }


                                      $sql2 = "SELECT * FROM contact_mapping where store_name='" . trim($shop) . "'";
        
                                   $result2 = $con->query($sql2);

                                    if ($result2->num_rows > 0) {
                  
                                         // output data of each row
                                         while($row2 = $result2->fetch_assoc()) {

                                             $emarsys_map[$row2["shopify_field_id"]] = $row2["emarsys_field_id"];
                      
                                          }
                                      }

                                      // echo("<pre>");
                                      // print_r($emarsys);



                                  ?>
                                
                                        

                                        <div class="alert alert-success">
                                            Sync Enabled successfully.
                                        </div>



                                        <div class="col-lg-12">
                        
                        <table class="table table-striped table-bordered" style="text-align:center;">
                            <thead>
                              <tr>
                                <th style="text-align:center;">Shopify Fields</th>
                                <th style="text-align:center;">Emarsys Fields</th>
                                <th style="text-align:center;">Field Mapping</th>
                               
                              </tr>
                            </thead>
                            <tbody>
                             <tr>
                               <td>id</td>
                               <td>shopify_contact_id</td>
                               <td></td>
                              </tr>

                              <tr>
                                <td>first_name</td>
                                <td>first_name</td>
                                <td></td>
                              </tr>

                              <tr>
                                <td>last_name</td>
                                <td>last_name</td>
                                <td></td>
                              </tr>

                              <tr>
                                <td>email</td>
                                <td>email</td>
                                <td></td>
                              </tr>

                              <tr>
                                <td>accepts_marketing</td>
                                <td>optin</td>
                                <td></td>
                              </tr>

                              <tr>
                                <td>verified_email</td>
                                <td>email_valid</td>
                                <td></td>
                              </tr>

                              <tr>
                                <td>note</td>
                                <td>
                                    <?php 
                                          if(!empty($emarsys[$emarsys_map[10]])){
                                            echo $emarsys[$emarsys_map[10]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=10">Mapping</a></td>
                              </tr>

                              

                              <tr>
                                <td>tax_exempt</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[12]] )){
                                            echo $emarsys[$emarsys_map[12]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=12">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>orders_count</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[6]])){
                                            echo $emarsys[$emarsys_map[6]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=6">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>total_spent</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[8]])){
                                            echo $emarsys[$emarsys_map[8]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=8">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>tags</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[14]])){
                                            echo $emarsys[$emarsys_map[14]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=14">Mapping</a></td>
                              </tr>

                            </tbody>

                          </table>


                         

                          <div class="alert alert-info">Shopify Address Fields</div>


                        <table class="table table-striped table-bordered" style="text-align:center;">
                            <thead>
                              <tr>
                                <th style="text-align:center;">Shopify Fields</th>
                                <th style="text-align:center;">Emarsys Fields</th>
                                 <th style="text-align:center;">Field Mapping</th>
                               
                              </tr>
                            </thead>

                            <tbody>

                            <tr>
                                <td>first_name</td>
                                <td><?php 
                                          if(!empty($emarsys[$emarsys_map[16]])){
                                            echo $emarsys[$emarsys_map[16]];    
                                          }else{
                                            echo('');
                                          }
                                    ?></td>
                                <td><a href="webhook_mapping.php?id=16">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>last_name</td>
                                <td><?php 
                                          if(!empty($emarsys[$emarsys_map[17]])){
                                            echo $emarsys[$emarsys_map[17]];    
                                          }else{
                                            echo('');
                                          }
                                    ?></td>
                                <td><a href="webhook_mapping.php?id=17">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>address1</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[19]])){
                                            echo $emarsys[$emarsys_map[19]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=19">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>address2</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[20]])){
                                            echo $emarsys[$emarsys_map[20]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=20">Mapping</a></td>
                              </tr>
                              
                                <td>company</td> 
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[18]])){
                                            echo $emarsys[$emarsys_map[18]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                               <td><a href="webhook_mapping.php?id=18">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>city</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[21]])){
                                            echo $emarsys[$emarsys_map[21]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=21">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>province</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[22]])){
                                            echo $emarsys[$emarsys_map[22]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=22">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>country</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[23]])){
                                            echo $emarsys[$emarsys_map[23]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=23">Mapping</a></td>
                              </tr>

                              <tr>
                                <td>zip</td>
                                <td>
                                  <?php 
                                          if(!empty($emarsys[$emarsys_map[24]])){
                                            echo $emarsys[$emarsys_map[24]];    
                                          }else{
                                            echo('');
                                          }
                                    ?>
                                </td>
                                <td><a href="webhook_mapping.php?id=24">Mapping</a></td>
                              </tr>

                            </tbody>

                          </table>

                    </div>
                                
                                <?php   } else {      ?>    


                                        <a href="#" class="activatewebhook">Click Here</a> to enable Contacts Sync from Shopify to Emarsys.
                        
                                <?php }

                            }else{ ?>

                                Kindly share the Emarsys crentials through settings.

                           <?php  } ?>

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

            $(".overlay").show();
            
            $.ajax({
          
                type: 'post',

                url: 'shopify_webhook.php',
          
                // data: $('form').serialize(),
          
                success: function (data) {
                 
                    $(".overlay").hide();

                    // alert(data);
                    if(data == 'success'){
                    
                        setTimeout(function() { alert("Sync enable successfully."); }, 1000);
                    
                    }if(data == 'error'){
                  
                        setTimeout(function() { alert("Something went wrong, try again later."); }, 1000);
                    
                    }
                     
                }

            });

        });

    </script>

<style type="text/css">

 
.overlay {
    background:rgba(0, 0, 0, 0.5);
    display: none;
    position:fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    text-align: center;
    z-index: 9999;
}

.overlay_data {
    background: #fff none repeat scroll 0 0;
    display: block;
    height: 205px !important;
    left: 0;
    margin: 0 auto;
    position: absolute;
    right: 0;
    width: 535px !important;
    z-index: 9999;
    transform: translate(0px, 360px);
    padding-bottom: 30px;
}

.overlay_text {
    font-family: arial;
    font-size: 22px;
    font-weight: 900;
    text-align: center;
    margin-bottom:15px;
    
}


#loading-img > p {
    font-size: 25px;
    font-weight: bold;
    text-align: center;
    color: #fff;
}


</style>

</body>

</html>


<div class="overlay">
       <div class="overlay_data">
            <div class="overlay_text">
            <br/>
                <span>Please wait just a moment. We're syncing the Shopify contacts with Emarsys.</span>
            </div>

            <div class="overlay_img">
                <img src="image/loader.gif" style="width:50;height:50px;">  
            </div>
       </div>
    
</div>



<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>