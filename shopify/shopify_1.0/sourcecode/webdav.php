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

            $sql = "SELECT * FROM webdav_credentials where store_name='" . trim($_SESSION['shop']) . "'";
          

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                
                // output data of each row
                while($row = $result->fetch_assoc()) {

                    $webdav_url = $row["url"];

                    $webdav_user = $row["user"];

                    $webdav_password = $row["password"];
                
                }
            }

        ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Webdav</h3>
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
                      
                        <label for="exampleInputEmail1">WebDAV Url:</label>
                     
                        <input type="text" name="url" class="form-control" id="" required="required" value="<?php if(!empty($webdav_url)) {echo $webdav_url; } ?>" placeholder="Please insert url.">
                      </div>

                      <div class="form-group">
                       
                        <label for="exampleInputEmail1">WebDAV User:</label>
                      
                        <input type="text" min="0" step="1" name="user" class="form-control" id="" required="required" value="<?php if(!empty($webdav_user)) {echo $webdav_user; } ?>" placeholder="Please insert User">
                      </div>

                      <div class="form-group">
                      
                        <label for="exampleInputEmail1">WebDAV Password:</label>
                     
                        <input type="password" name="password" class="form-control" id="" required="required" value="<?php if(!empty($webdav_password)) {echo $webdav_password; } ?>" placeholder="Please insert password">
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
           
            url: 'webdav_submit.php',
          
            data: $('form').serialize(),
          
            success: function (data) {
             
                if(data == 'success'){
                  
                    alert("Thank you for sharing your WebDAV details.");
                   
              
                }else if(data == 'error'){
               
                    alert("Something went wrong, try again later.");
              
                }
            
         
            }
          });
        
        });

      });
    </script>

</body>

</html>