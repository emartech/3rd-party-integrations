<?php
  session_start();

  $shop = $_SESSION['shop'];

  $type = $_GET['type']; 

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


          $sql1 = "SELECT * FROM cron where store_name='" . trim($shop) . "' AND shopify_data='" . trim($type) . "'";

             $result_contact_id = $con->query($sql1);

             if ($result_contact_id->num_rows > 0) {
                
                // output data of each row
                while($row_contact_id = $result_contact_id->fetch_assoc()) {

                    $db_status = $row_contact_id["status"];

                    $db_frequency = $row_contact_id["frequency"];

                     $db_execute_min = $row_contact_id["execute_min"];

                    $db_execute_hour = $row_contact_id["execute_hour"];

                    $db_execute_day = $row_contact_id["execute_day"];

                }
            }

      ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                                Configure Automation <?php // echo ucfirst($type); ?>
                        </h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                   <div class="col-lg-12">
                        
                    <form>

                    <input type="hidden" name="type" value="<?php echo($type); ?>">


                      <div class="form-group">
                     
                        <label for="exampleInputEmail1">Store</label>
                      
                        <input class="form-control" value="<?php echo $shop; ?>" disabled="disabled">
                      </div>

                      <div class="form-group">
                      
                        <label for="exampleInputEmail1">Status:</label>

                        <select class="form-control" name="cron_status" id="cron_status" required="required">
                           
                            <option selected disabled>Select</option>

                            <option value="1" <?php if($db_status == '1'){ echo 'selected="selected"';} ?> >Enable</option>

                            <option value="0" <?php if($db_status == '0'){ echo 'selected="selected"';} ?> >Disable</option>
                            
                          </select>

                      </div>

                         

                         <div class="form-group cron-display-form">
                       
                     <label class="" for="exampleInputEmail1" style="float: left;">Background Runtime:</label>
</div><div class="col-lg-12">


                    <div class="col-lg-4"> 

                          <select class="form-control" name="cron_hour" id="cron_status" required="required">
                           
                            <option selected disabled>Select Hour</option>

                            <?php for ($j=0; $j <= 23; $j++) {?>

                                <option value="<?php echo $j; ?>" <?php if( (!empty($db_execute_hour)) && ($j == $db_execute_hour) ) { echo 'selected="selected"';} ?> > <?php echo $j; ?></option>
                            
                                <?php } ?>
                           
                            
                          </select>
                        </div>
                         

                         <div class="col-lg-4">
                          <select class="form-control" name="cron_min" id="cron_status" required="required">

                           
                            <option selected disabled>Select Minutes</option>

                            <?php for ($i=0; $i <= 59; $i++) { ?>

                            <?php if( ($i%5) == 0 ){ ?>

                              <option value="<?php echo $i; ?>" <?php if( (!empty($db_execute_min)) && ($i == $db_execute_min) ){ echo 'selected="selected"';} ?> >
                                  <?php echo $i; ?>
                                    
                              </option>
                           <?php  } ?>
                                                  
                            
                                <?php } ?>
                            
                            
                            
                          </select>
                      
                        </div>

                        
                    </div>


                      <div class="form-group cron-display-form">
                         <br>
                        <label for="exampleInputEmail1" style="float: left;">Background Frequency:</label>
                     
                      <select class="form-control" name="cron_frequency" id="cron_status" required="required">
                       
                            <option selected disabled>Select</option>

                            <option value="hour" <?php if($db_frequency == 'hour'){ echo 'selected="selected"';} ?> >Hourly</option>

                            <option value="day" <?php if($db_frequency == 'day'){ echo 'selected="selected"';} ?> >Daily</option>

                            <!-- <option value="month" <?php if($db_frequency == 'month'){ echo 'selected="selected"';} ?> >Monthly</option> -->
                            
                          </select>
                       
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
           
            url: 'cron_submit.php',
          
            data: $('form').serialize(),
          
            success: function (data) {

                // alert(data);
             
                if(data == 'success'){
                  
                    alert("Automation Configured successfully.");

                    window.location.href ='shop.php';


                   
              
                }else if(data == 'error'){
               
                    alert("Something went wrong, try again later.");

                    window.location.reload();


              
                }
            
         
            }
          });
        
        });

      });
    </script>

    <style type="text/css">
        .cron-display-form{
            display: block;
        }
    </style>


</body>

</html>