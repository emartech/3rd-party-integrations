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
        <?php require('nav.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">Sync Emarsys Data On Shopify</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        
                        <form>

                        <input type="hidden" name="shop" value="<?php echo $shop; ?>">
                            
                         <div class="form-group">
                      
                            <label for="exampleInputEmail1">Date From</label>
                     
                            <input type="text" name="from" class="form-control" id="from">
                        </div>


                        <div class="form-group">
                      
                            <label for="exampleInputEmail1">Date To</label>
                     
                              <input type="text" name="to" class="form-control" id="to">
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

    <!-- jQuery -->


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script>
      $( function() {

        var dateFormat = "mm/dd/yy",

          from = $( "#from" )
            .datepicker({
              defaultDate: "+1w",
              changeMonth: true,
              changeYear: true,
              numberOfMonths: 3,
              maxDate: 0
              
               
            })
            .on( "change", function() {
              to.datepicker( "option", "minDate", getDate( this ) );
            }),
          to = $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 3,
            maxDate: 0
          })
          .on( "change", function() {
            from.datepicker( "option", "maxDate", getDate( this ) );
          });
     
        function getDate( element ) {
          var date;
          try {
            date = $.datepicker.parseDate( dateFormat, element.value );
          } catch( error ) {
            date = null;
          }
     
          return date;
        }
      } );
  </script>







    <script>
      $(function () {

        $('form').on('submit', function (e) {

          e.preventDefault();

          $(".overlay").show();

          $.ajax({
          
            type: 'post',
           
            url: 'emarsys_webhook_submit.php',
          
            data: $('form').serialize(),
          
            success: function (data) {
             
                // alert(data);

                $(".overlay").hide();

                if(data == 'success'){
                  
                    setTimeout(function() { 

                        alert("Syncing is running in background."); 
                        window.location.reload();

                    }, 1000);     

                                   
              
                }else if(data == 'error'){
               
                    setTimeout(function() { 

                        alert("Something went wrong, try again later."); 
                        window.location.reload();
                    
                    }, 1000);

                   
                }

               
            
         
            }
          });
        
        });

      });
    </script>

</body>

</html>


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

<div class="overlay">
       <div class="overlay_data">
            <div class="overlay_text">
            <br/>
                <span>Please wait just a moment. We're syncing the Emarsys contacts updates with Shopify Contacts.</span>
            </div>

            <div class="overlay_img">
                <img src="image/loader.gif" style="width:50;height:50px;">  
            </div>
       </div>
    
</div>