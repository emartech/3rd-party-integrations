<?php

$binding = $result->fetch_assoc();
//GENERATE PAYLOAD
$global_var = [];
$cart_line_items = [];

if(!empty($binding['cart_id'])){
	$global_var[$binding['cart_id']] = $shopify_data['id'];
}
if(!empty($binding['cart_token'])){
	$global_var[$binding['cart_token']] = $shopify_data['token'];
}

if(!empty($binding['cart_line_items'])){
	
	$i = 0;
	foreach($shopify_data['line_items'] as $val){
		if(!empty($binding['product_id'])){
			$cart_line_items[$i][$binding['product_id']] = $val['id'];
		}
		if(!empty($binding['item_qty'])){
			$cart_line_items[$i][$binding['item_qty']] = $val['quantity'];
		}
		if(!empty($binding['item_title'])){
			$cart_line_items[$i][$binding['item_title']] = $val['title'];
		}
		if(!empty($binding['item_price'])){
			$cart_line_items[$i][$binding['item_price']] = $val['price'];
		}
		if(!empty($binding['item_discounted_price'])){
			$cart_line_items[$i][$binding['item_discounted_price']] = $val['discounted_price'];
		}
		if(!empty($binding['item_line_price'])){
			$cart_line_items[$i][$binding['item_line_price']] = $val['line_price'];
		}
		if(!empty($binding['item_total_discount'])){
			$cart_line_items[$i][$binding['item_total_discount']] = $val['total_discount'];
		}
		if(!empty($binding['item_sku'])){
			$cart_line_items[$i][$binding['item_sku']] = $val['sku'];
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
if(!empty($cart_line_items)){
	$payload['data'][$binding['cart_line_items']] = $cart_line_items;
}

$payload = json_encode($payload);

fwrite($file, $payload);
fclose($file);

/*
* https://api.emarsys.net/api/v2/event/1667/trigger
*/
$res = json_decode($emarsyClient->send('POST', 'event/' . $emarsys_event_id . '/trigger', $payload));