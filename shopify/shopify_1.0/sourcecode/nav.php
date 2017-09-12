<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../vendor/morrisjs/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button> -->
		
		<!-- <a class="navbar-brand" href="shop.php">Emarsys Admin</a> -->

			<a class="navbar-brand heading" href="shop.php"> 
				<span><img src="emarsys.png"></span>
				<span>Admin Panel</span>
			</a>


	</div>
	<!-- /.navbar-header -->

	<ul class="nav navbar-top-links navbar-right">
		<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
		</li>
	</ul>
	<!-- /.navbar-top-links -->



	 <div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
			   
				<li>
					<a href="shop.php">Installation Dashboard</a>
				</li>
				<li>
					<a href="#">Contact Synchronization<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li>
							<a href="webhook.php">Field mapping</a>
						</li>

						<li>
							<a href="#">Connection Settings<span class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
						
								<li>
									<a href="emarsys_details.php">API</a>
								</li>

								<li>
									<a href="webdav.php">WebDAV</a>
								</li>
						
							</ul>
							<!-- /.nav-second-level -->
						</li>


						<li>
							<a href="#">Manual Sync<span class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
						
								<li>
									<a href="export_contacts_detail.php">Contacts</a>
								</li>

								<!-- <li>
									<a href="bulk_product_export.php">Product Export</a>
								</li>

								<li>
									<a href="bulk_purchase_export.php">Purchase Data Export</a>
								</li> -->
						
							</ul>
							<!-- /.nav-second-level -->
						</li>

						<li>
							<a href="cron.php?type=customer">Automation</a>
						</li>


   
					</ul>
					<!-- /.nav-second-level -->
				</li>
			   
			
				<li>
					<a href="optin.php">Opt-In</a>
				</li>

				<li>
					<a href="#">Map Shopify events to emarsys<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						
						<li>
							<a href="events.php">Sync events</a>
						</li>

						<li>
							<a href="emarsys_events_mapper.php">Event mapping</a>
						</li>
						
					</ul>
					<!-- /.nav-second-level -->
				</li>

				<li>
					<a href="#">Smart insight ( purchase data sync)<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						
						<li>
							<a href="sftp_details_si.php">Connection settings</a>
						</li>

						<li>
							<a href="smart_insight_manual.php">Manual sync</a>
						</li>

						<li>
							<a href="cron.php?type=si">Automation</a>
						</li>
						
					</ul>
					<!-- /.nav-second-level -->
				</li>

				

				<li>
					<a href="web_extend.php">Web-Extend</a>
				</li>

				<li>
					<a href="#">Peoduct catalogue<span class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						
						<li>
							<a href="sftp_details.php">Connection settings</a>
						</li>

						<li>
							<a href="sync_product.php">Manual sync</a>
						</li>

						<li>
							<a href="cron.php?type=product">Automation</a>
						</li>
						
					</ul>
					<!-- /.nav-second-level -->
				</li>

				<li>
					<a href="rss2csv.php">RSS feeds</a>
				</li>
				
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
	<!-- /.navbar-static-side -->
</nav>
		
		 <!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>
