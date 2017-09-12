<?php
$binding = $result->fetch_assoc();
//GENERATE PAYLOAD
$global_var = [];

if(!empty($binding['product_id'])){
	$global_var[$binding['product_id']] = $shopify_data['id'];
}
if(!empty($binding['product_title'])){
	$global_var[$binding['product_title']] = $shopify_data['title'];
}
if(!empty($binding['product_product_type'])){
	$global_var[$binding['product_product_type']] = $shopify_data['product_type'];
}
if(!empty($binding['product_image'])){
	$global_var[$binding['product_image']] = $shopify_data['image'];
}

$product_variants = [];

if(!empty($binding['product_variants'])){
	$i = 0;
	foreach($shopify_data['variants'] as $val){
		if(!empty($binding['variants_id'])){
			$product_variants[$i][$binding['variants_id']] = $val['id'];
		}
		if(!empty($binding['variants_product_id'])){
			$product_variants[$i][$binding['variants_product_id']] = $val['product_id'];
		}
		if(!empty($binding['variants_title'])){
			$product_variants[$i][$binding['variants_title']] = $val['title'];
		}
		if(!empty($binding['variants_price'])){
			$product_variants[$i][$binding['variants_price']] = $val['price'];
		}
		if(!empty($binding['variants_sku'])){
			$product_variants[$i][$binding['variants_sku']] = $val['sku'];
		}
		$i++;
	}
}

$product_images = [];

if(!empty($binding['product_images'])){
	$i = 0;
	foreach($shopify_data['images'] as $val){
		if(!empty($binding['image_id'])){
			$product_images[$i][$binding['image_id']] = $val['id'];
		}
		if(!empty($binding['image_product_id'])){
			$product_images[$i][$binding['image_product_id']] = $val['product_id'];
		}
		if(!empty($binding['image_src'])){
			$product_images[$i][$binding['image_src']] = $val['src'];
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
if(!empty($product_variants)){
	$payload['data'][$binding['product_variants']] = $product_variants;
}
if(!empty($product_images)){
	$payload['data'][$binding['product_images']] = $product_images;
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