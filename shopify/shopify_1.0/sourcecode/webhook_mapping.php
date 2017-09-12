<?php 
    session_start();

    require ('ShopifyAPI/ShopifyClient.php');

    require 'config.php';

    require 'database.php';

    $shop = $_SESSION['shop'];

    // key have the shopify field.
     $id = $_GET['id']; 
    
      $key = $_GET['key']; 
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
                    <h3 class="page-header">Field Mapping.</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<?php
        
        $sql = "SELECT * FROM contact_fields where id='" . trim($id) . "'";
        
        $result = $con->query($sql);

            if ($result->num_rows > 0) {
                
                // output data of each row
                while($row = $result->fetch_assoc()) {

                    $shopify_field = $row["shopify_field"];

                    
                }
            }


        $sql1 = "SELECT * FROM emarsys_fields where store_name='" . trim($shop) . "'";
        
        $result1 = $con->query($sql1);

            if ($result1->num_rows > 0) {
                
                // output data of each row
                while($row1 = $result1->fetch_assoc()) {

                    $emarsys_field_id[] = $row1["fieldEmarsysID"];

                    $emarsys_field_name[] = $row1["fieldEmarsysName"];

                    
                }
            }

?>           


            <div class="row">
                <form>

                <input type="hidden" name="shopify_field" value="<?php echo $shopify_field; ?>">

                <input type="hidden" name="shopify_field_id" value="<?php echo $id; ?>">



                     <div class="col-md-12">
                        <div class="form-group">
                            <label>Shopify Field</label>
                            <p> <?php echo $shopify_field; ?></p>
                        </div>
                     <br>
                    </div>

                     <div class="col-md-12">
                   
                     <div class="form-group">
                       
                        <label for="exampleInputEmail1">Select Emarsys Field</label>
                      
  <select class="form-control" name="field_id">

  <?php for($i=0; $i<count($emarsys_field_name); $i++){ ?>

    <option value="<?php echo($emarsys_field_id[$i]); ?>"><?php echo($emarsys_field_name[$i]); ?></option>

    <?php } ?>
  </select>

  <br>
                      <button type="submit" class="btn btn-default">Submit</button>
                       
                    </div>
            </div> </form> </div>
    

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

     <script>
      $(function () {

        $('form').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
          
            type: 'post',
           
            url: 'webhook_mapping_submit.php',
          
            data: $('form').serialize(),
          
            success: function (data) {

                // alert(data);
             
                if(data == 'success'){
                  
                    alert("Shopify field mapped with emarsys.");

                    window.location='webhook.php';
                   
              
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

