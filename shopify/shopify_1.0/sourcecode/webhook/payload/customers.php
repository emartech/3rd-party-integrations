<?php


$binding = $result->fetch_assoc();

$global_var = [];
//GENERATE PAYLOAD

if(!empty($binding['customer_id'])){
	$global_var[$binding['customer_id']] = $shopify_data['id'];
}
if(!empty($binding['customer_email'])){
	$global_var[$binding['customer_email']] = $shopify_data['email'];
}
if(!empty($binding['customer_first_name'])){
	$global_var[$binding['customer_first_name']] = $shopify_data['first_name'];
}
if(!empty($binding['customer_last_name'])){
	$global_var[$binding['customer_last_name']] = $shopify_data['last_name'];
}
if(!empty($binding['customer_orders_count'])){
	$global_var[$binding['customer_orders_count']] = $shopify_data['orders_count'];
}
if(!empty($binding['customer_phone'])){
	$global_var[$binding['customer_phone']] = $shopify_data['phone'];
}
if(!empty($binding['customer_address'])){
	$i = 0;
	$customer_address = [];
	foreach($shopify_data['addresses'] as $val){
		 if(!empty($binding['address_first_name'])){
		 	$customer_address[$i][$binding['address_first_name']] = $val['first_name'];
		 }
	     if(!empty($binding['address_last_name'])){
	     	$customer_address[$i][$binding['address_last_name']] = $val['last_name'];
	     }
	     if(!empty($binding['address_address1'])){
	     	$customer_address[$i][$binding['address_address1']] = $val['address1'];
	     }
	     if(!empty($binding['address_phone'])){
	     	$customer_address[$i][$binding['address_phone']] = $val['phone'];
	     }
	     if(!empty($binding['address_city'])){
	     	$customer_address[$i][$binding['address_city']] = $val['city'];
	     }
	     if(!empty($binding['address_province'])){
	     	$customer_address[$i][$binding['address_province']] = $val['province'];
	     }
	     if(!empty($binding['address_country'])){
	     	$customer_address[$i][$binding['address_country']] = $val['country'];
	     }
	     if(!empty($binding['address_name'])){
	     	$customer_address[$i][$binding['address_name']] = $val['name'];
	     }
		$i++;
	}
}

$payload = [
	"key_id" =>  "32",
		"external_id" => "1",
	'data' => []
];

if(!empty($global_var)){
	$payload['data']['global'] = $global_var;
}
if(!empty($customer_address)){
	$payload['data'][$binding['customer_address']] = $customer_address;
}



$payload = json_encode($payload);
if(DEV_ENV){
	fwrite($file, $payload);
	fclose($file);
}
/*
* https://api.emarsys.net/api/v2/event/1667/trigger
*/
$res = json_decode($emarsyClient->send('POST', 'event/' . $emarsys_event_id . '/trigger', $payload));
