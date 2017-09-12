<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div id="wrapper">

	  <!-- Navigation -->
	<?php require('nav.php'); ?>

	<!-- Page Content -->
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">Purchase Data</h3>
				</div>
				<!-- /.col-lg-12 -->
			</div>

			<div class="row">
				<div class="col-lg-12">
					
					<form>

					 <div class="form-group">
				  
						<label for="exampleInputEmail1">From</label>
				 
						<input type="date" name="from" class="form-control" id="from" required>
					</div>


					<div class="form-group">
				  
						<label for="exampleInputEmail1">To</label>
				 
						<input type="date" name="to" class="form-control" id="to" required>
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
<div class="overlay">
       <div class="overlay_data">
            <div class="overlay_text">
            <br/>
                <span>Please wait just a moment. We're exporting products on your server.</span>
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

.form-group {
    margin-bottom: 0px;
    display: inline-block;
    margin-right: 30px;
}
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $(function () {
	$('input[type="date"]').datepicker();
	$('form').on('submit', function (e) {
      
	  e.preventDefault();
	  $(".overlay").show();
	  $.ajax({
	  
		type: 'post',
	   
		url: 'bulk_purchase_csv.php',
	  
		data: $('form').serialize(),
	  
		success: function (data) {
		    var status = $.trim(data);
		    $(".overlay").hide();
			
			setTimeout(function(){
				if(status == 'success'){
					$("#from, #to").val('');
					alert("Purchased data have been exported successfully");	
				}else{
					$("#from, #to").val('');
					alert("Something went wrong, try again later.");
				}
			},1000);
						
		}
	  });
	
	});

  });
</script>
