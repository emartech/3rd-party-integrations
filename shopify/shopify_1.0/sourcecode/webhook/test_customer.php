<?php

	$webhookContent = "";

	$webhook = fopen('php://input' , 'rb');
	while (!feof($webhook)) {
	    $webhookContent .= fread($webhook, 4096);
	}

	fclose($webhook);

	//  $webhookContent;

	$file1 = fopen('test_create.txt', 'w');
	echo fwrite($file1, $webhookContent);
	fclose($file1);


	$shopify_data = json_decode($webhookContent, true);


	$file1 = fopen('1test_create.txt', 'w');
	echo fwrite($file1, $shopify_data);
	fclose($file1);

