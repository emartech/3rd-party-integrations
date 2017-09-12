<?php 

session_start();

define('SHOPIFY_API_KEY','');

define('SHOPIFY_SECRET','');



define('APP_URI', '');

define('REDIRECT_URI', APP_URI.'/index.php');

define('SHOPIFY_SCOPE','read_products, write_products, read_customers, write_customers, read_orders, write_orders, read_fulfillments, write_fulfillments, read_checkouts, write_checkouts, read_themes, write_themes');

define('DEV_ENV', 0);

// echo $_SERVER['PHP_SELF'];

if(!isset($_SESSION['shop']) && ($_SERVER['PHP_SELF'] != '/index.php') && ($_SERVER['PHP_SELF'] != '/optin_verify.php/') && ($_SERVER['PHP_SELF'] != '/cron/si_data.php')		 ){
	
	header('Location: ' . REDIRECT_URI);
	
}
?>