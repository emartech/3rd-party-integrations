<div id="wrapper">

	  <!-- Navigation -->
	<?php require('nav.php'); ?>

	<!-- Page Content -->
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">Export Product Data</h3>
				</div>
				<!-- /.col-lg-12 -->
			</div>

			<div class="row">
				<div class="col-lg-12">
					
					<form>

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


<!-- Bootstrap Core JavaScript -->

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

	  $.ajax({
	  
		type: 'post',
	   
		url: 'bulk_product_csv.php',
	  
		data: $('form').serialize(),
	  
		success: function (data) {
		 
			alert(data);		
	 
		}
	  });
	
	});

  });
</script>