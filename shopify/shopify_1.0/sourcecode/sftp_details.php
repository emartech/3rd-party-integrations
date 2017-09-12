<?php
  session_start();

  $shop = $_SESSION['shop'];

  require('database.php'); 
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

            $sql = "SELECT * FROM sftp_credentials where store_name='" . trim($_SESSION['shop']) . "'";
          

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                
                // output data of each row
                while($row = $result->fetch_assoc()) {

                    $sftp_hostname = $row["sftp_hostname"];

                    $sftp_port = $row["sftp_port"];

                    $sftp_username = $row["sftp_username"];

                    $sftp_password = $row["sftp_password"];

                    $sftp_export = $row["sftp_export"];

                    $feed_export = $row["feed_export"];
                    
                
                }
            }

        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Connection Settings</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                   <div class="col-lg-12">
                        
                    <form>
                      <div class="form-group">
                     
                        <label for="exampleInputEmail1">Store</label>
                      
                        <input class="form-control" value="<?php echo $shop; ?>" disabled="disabled">
                      </div>

                      <div class="form-group">
                      
                        <label for="exampleInputEmail1">SFTP Hostname</label>
                     
                        <input type="text" name="sftp_hostname" class="form-control" id="" required="required" value="<?php if(!empty($sftp_hostname)) {echo $sftp_hostname; } ?>" placeholder="Please insert Hostname">
                      </div>

                      <div class="form-group">
                       
                        <label for="exampleInputEmail1">Port</label>
                      
                        <input type="number" min="0" step="1" name="sftp_port" class="form-control" id="" required="required" value="<?php if(!empty($sftp_port)) {echo $sftp_port; } ?>" placeholder="Please insert Port number">
                      </div>

                      <div class="form-group">
                      
                        <label for="exampleInputEmail1">SFTP Username</label>
                     
                        <input type="text" name="sftp_username" class="form-control" id="" required="required" value="<?php if(!empty($sftp_username)) {echo $sftp_username; } ?>" placeholder="Please insert username">
                      </div>


                      <div class="form-group">
                       
                        <label for="exampleInputEmail1">SFTP Password</label>
                      
                        <input type="password" name="sftp_password" class="form-control" id="" required="required" value="<?php if(!empty($sftp_password)) {echo $sftp_password; } ?>"   placeholder="Please insert password">
                      </div>

                      <div class="form-group">
                      
                        <label for="exampleInputEmail1">Bulk Export Directory</label>
                     
                        <input type="text" name="sftp_export" class="form-control" id="" required="required" value="<?php if(!empty($sftp_export)) {echo $sftp_export; } ?>" placeholder="Please insert export directory">
                      </div>

                      <div class="form-group">
                      
                        <label for="exampleInputEmail1">Feeds Directory</label>
                     
                        <input type="text" name="feed_export" class="form-control" id="" required="required" value="<?php if(!empty($feed_export)) {echo $feed_export; } ?>" placeholder="Please insert feed export directory">
                      </div>

                      <button type="submit" class="btn btn-default">Submit</button>

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

    <script>
      $(function () {

        $('form').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
          
            type: 'post',
           
            url: 'sftp_details_submit.php',
          
            data: $('form').serialize(),
          
            success: function (data) {
             
                if(data == 'success'){
                  
                    alert("Thank you for sharing your SFTP details.");

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