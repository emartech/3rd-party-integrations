<?php

require ('ShopifyAPI/ShopifyClient.php');

require 'config.php';

session_start();


 if( (isset($_SESSION['shop'])) && (isset($_SESSION['token'])) ){
    header('Location: shop.php');
}


    if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
        // Step 2: do a form POST to get the access token
        $shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
        session_unset();

        // if(!$shopifyClient->validateSignature($_GET)) die('Error: invalid signature.');
// var_dump($_GET);  
// die( "signature: " . $_GET['signature']); 


        // Now, request the token and store it in your session.
        $token =  $shopifyClient->getAccessToken($_GET['code'], REDIRECT_URI);
        $_SESSION['token'] = $token;
        if ($_SESSION['token'] != '')
            $_SESSION['shop'] = $_GET['shop'];

        echo $token;

        header("Location: shop.php");
        exit;       
    }
    // if they posted the form with the shop name
    else if (isset($_POST['shop']) || isset($_GET['shop'])) {

        // Step 1: get the shopname from the user and redirect the user to the
        // shopify authorization page where they can choose to authorize this app
        $shop = isset($_POST['shop']) ? $_POST['shop'] : $_GET['shop'];
        $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);

        // if(!$shopifyClient->validateSignature($_GET)) die('Error: invalid signature.');
        
        // redirect to authorize url
        header("Location: " . $shopifyClient->getAuthorizeUrl(SHOPIFY_SCOPE, REDIRECT_URI));
        exit;
    }

    // first time to the page, show the form below
?>
	
	<div class="home_installation_page">
		<div class="em_header first_app_section"><h1>Emarsys App Installation</h1></div>
		<div class="second_app_section">
			<p>Install this app in a shop to get access to its private admin data.</p> 

			<p style="padding-bottom: 1em;">
				<span class="hint">Don&rsquo;t have a shop to install your app in handy? <a href="https://app.shopify.com/services/partners/dev_shops/new">Create a test shop.</a></span>
			</p> 

			<form action="" method="post">
			  <label for='shop'><strong>The URL of the Shop</strong> 
				<span class="hint">(enter it exactly like this: myshop.myshopify.com)</span> 
			  </label> 
			  <p> 
				<input id="shop" name="shop" size="45" type="text" value="" placeholder="myshop.myshopify.com" /> 
				<input name="commit" type="submit" value="Install" /> 
			  </p> 
		  </div>
	  </div>
    </form>
	<style>
	 body{ background:#eee; }
	 .em_header.first_app_section{ font-size:20px; }
	.home_installation_page{
		left: 50%;
		top: 50%;
		transform: translate(-50%,-50%);
		position: fixed;
	}
	.home_installation_page #shop{
		border: 1px solid #ccc;
		padding: 8px 10px;
		box-shadow: 10px 10px 5px #888888;
	}
	.home_installation_page input[type="submit"]{
		padding: 8px 10px;
		background: #4CAF50;
		color: #fff;
		box-shadow: 10px 10px 5px #888888;
	}
	</style>