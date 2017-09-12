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
                        <h3 class="page-header">Opt-in</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                   <div class="col-lg-12">

<?php
                   $sql_contact_id = "SELECT * FROM emarsys_optin where store_name='" . trim($shop) . "'";
      
             $result_contact_id = $con->query($sql_contact_id);

             if ($result_contact_id->num_rows > 0) {
                
                // output data of each row
                while($row_contact_id = $result_contact_id->fetch_assoc()) {

                    $db_optin = $row_contact_id["optin"];

                    $mail = $row_contact_id["mail_sent"];

                }
            }

                            ?>
                        
                    
                        <form>
                        
                        <div class="form-group">
                          
                          <label for="sel1">Select:</label>
                          
                          <select class="form-control" name="optin">
                           
                            <option value="1" <?php if($db_optin=="1") echo 'selected="selected"'; ?> >Single Opt-in</option>
                            
                            <option value="2" <?php if($db_optin=="2") echo 'selected="selected"'; ?>>Double Opt-in</option>
                            
                          </select>
                          <br>
                          
                          <button type="submit" class="btn btn-default">Submit</button>
                          
                        </div>

                      </form>




                    </div>
               
                       <!-- /.col-lg-12 -->
                </div>

              
                        <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Shopify Event Name</th>
                                <th>Emarsys Events</th>
                                <th>JSON</th>
                              </tr>
                            </thead>
                            <tbody>
                                
                                 <tr> 
                                        <td>Welcome Email</td>

                                        <td>Shopif_welcome_email</td>
                                <td>{"name": "customer name","store": "shop name"}</td>


                                <tr> 
                                        <td>Accepts Marketing</td>

                                        <td>Shopif_optin</td>
                                <td>{"name": "test name","random": "auth code","test shopify user id": "shopify_user_id"}</td>

                            </tbody>
                            </table>
                    </div>
                </div>

               
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

   
    <script>
      $(function () {

        $('form').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
          
            type: 'post',
           
            url: 'optin_submit.php',
          
            data: $('form').serialize(),
          
            success: function (data) {

                // alert(data);
             
                if(data == 'success'){
                  
                    alert("We have update the Opt-in.");
                    
                    window.location.reload();                   
              
                }else if(data == 'error'){
               
                    alert("Something went wrong, try again later.");

                    window.location.reload();
              
                }
            
         
            }
          });
        
        });

      });

   
    </script>

</body>

</html>


<div class="overlay">
       <div class="overlay_data">
            <div class="overlay_text">
            <br/>
                <span>Please wait just a moment. We're sending verification email to customers.</span>
            </div>

            <div class="overlay_img">
                <img src="image/loader.gif" style="width:50;height:50px;">  
            </div>
       </div>
    
</div>

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
    width: 600px !important;
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