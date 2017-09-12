<?php

$binding = $result->fetch_assoc();
//GENERATE PAYLOAD
$global_var = [];

if(!empty($binding['checkout_id'])){
	$global_var[$binding['checkout_id']] = $shopify_data['id'];
}
if(!empty($binding['checkout_token'])){
	$global_var[$binding['checkout_token']] = $shopify_data['token'];
}
if(!empty($binding['checkout_cart_token'])){
	$global_var[$binding['checkout_cart_token']] = $shopify_data['cart_token'];
}
if(!empty($binding['checkout_email'])){
	$global_var[$binding['checkout_email']] = $shopify_data['email'];
}
if(!empty($binding['checkout_created_at'])){
	$global_var[$binding['checkout_created_at']] = $shopify_data['created_at'];
}
if(!empty($binding['checkout_updated_at'])){
	$global_var[$binding['checkout_updated_at']] = $shopify_data['updated_at'];
}
if(!empty($binding['checkout_subtotal_price'])){
	$global_var[$binding['checkout_subtotal_price']] = $shopify_data['subtotal_price'];
}
if(!empty($binding['checkout_total_discounts'])){
	$global_var[$binding['checkout_total_discounts']] = $shopify_data['total_discounts'];
}
if(!empty($binding['checkout_total_line_items_price'])){
	$global_var[$binding['checkout_total_line_items_price']] = $shopify_data['total_line_items_price'];
}
if(!empty($binding['checkout_total_price'])){
	$global_var[$binding['checkout_total_price']] = $shopify_data['total_price'];
}
if(!empty($binding['checkout_total_tax'])){
	$global_var[$binding['checkout_total_tax']] = $shopify_data['total_tax'];
}
if(!empty($binding['checkout_currency'])){
	$global_var[$binding['checkout_currency']] = $shopify_data['currency'];
}
if(!empty($binding['checkout_user_id'])){
	$global_var[$binding['checkout_user_id']] = $shopify_data['user_id'];
}
if(!empty($binding['checkout_location_id'])){
	$global_var[$binding['checkout_location_id']] = $shopify_data['location_id'];
}
if(!empty($binding['checkout_abandoned_checkout_url'])){
	$global_var[$binding['checkout_abandoned_checkout_url']] = $shopify_data['abandoned_checkout_url'];
}

$checkout_line_items = [];
if(!empty($binding['checkout_line_items'])){
	$i = 0;
	foreach($shopify_data['line_items'] as $val){
		if(!empty($binding['item_destination_location_id'])){
			$checkout_line_items[$i][$binding['item_destination_location_id']] = $val['destination_location_id'];
		}
		if(!empty($binding['item_fulfillment_service'])){
			$checkout_line_items[$i][$binding['item_fulfillment_service']] = $val['fulfillment_service'];
		}
		if(!empty($binding['item_line_price'])){
			$checkout_line_items[$i][$binding['item_line_price']] = $val['line_price'];
		}
		if(!empty($binding['item_origin_location_id'])){
			$checkout_line_items[$i][$binding['item_origin_location_id']] = $val['origin_location_id'];
		}
		if(!empty($binding['item_price'])){
			$checkout_line_items[$i][$binding['item_price']] = $val['price'];
		}
		if(!empty($binding['item_product_id'])){
			$checkout_line_items[$i][$binding['item_product_id']] = $val['product_id'];
		}
		if(!empty($binding['item_quantity'])){
			$checkout_line_items[$i][$binding['item_quantity']] = $val['quantity'];
		}
		if(!empty($binding['item_requires_shipping'])){
			$checkout_line_items[$i][$binding['item_requires_shipping']] = $val['requires_shipping'];
		}
		if(!empty($binding['item_sku'])){
			$checkout_line_items[$i][$binding['item_sku']] = $val['sku'];
		}
		if(!empty($binding['item_title'])){
			$checkout_line_items[$i][$binding['item_title']] = $val['title'];
		}
		if(!empty($binding['item_variant_id'])){
			$checkout_line_items[$i][$binding['item_variant_id']] = $val['variant_id'];
		}
		if(!empty($binding['item_variant_title'])){
			$checkout_line_items[$i][$binding['item_variant_title']] = $val['variant_title'];
		}
		$i++;
	}
}

$checkout_billing_address = [];
if(!empty($binding['checkout_billing_address'])){
	$i = 0;
	foreach($shopify_data['line_items'] as $val){
		if(!empty($binding['product_id'])){
			$checkout_billing_address[$i][$binding['product_id']] = $val['id'];
		}
		if(!empty($binding['billing_address_first_name'])){
			$checkout_billing_address[$i][$binding['billing_address_first_name']] = $val['first_name'];
		}
		if(!empty($binding['billing_address_last_name'])){
			$checkout_billing_address[$i][$binding['billing_address_last_name']] = $val['last_name'];
		}
		if(!empty($binding['billing_address_address1'])){
			$checkout_billing_address[$i][$binding['billing_address_address1']] = $val['address1'];
		}
		if(!empty($binding['billing_address_phone'])){
			$checkout_billing_address[$i][$binding['billing_address_phone']] = $val['phone'];
		}
		if(!empty($binding['billing_address_city'])){
			$checkout_billing_address[$i][$binding['billing_address_city']] = $val['city'];
		}
		if(!empty($binding['billing_address_zip'])){
			$checkout_billing_address[$i][$binding['billing_address_zip']] = $val['zip'];
		}
		if(!empty($binding['billing_address_province'])){
			$checkout_billing_address[$i][$binding['billing_address_province']] = $val['province'];
		}
		if(!empty($binding['billing_address_country'])){
			$checkout_billing_address[$i][$binding['billing_address_country']] = $val['country'];
		}
		if(!empty($binding['billing_address_address2'])){
			$checkout_billing_address[$i][$binding['billing_address_address2']] = $val['address2'];
		}
		if(!empty($binding['billing_address_name'])){
			$checkout_billing_address[$i][$binding['billing_address_name']] = $val['name'];
		}
		$i++;
	}
}

$checkout_shipping_address = [];
if(!empty($binding['checkout_shipping_address'])){
	$i = 0;
	foreach($shopify_data['line_items'] as $val){
		if(!empty($binding['product_id'])){
			$checkout_shipping_address[$i][$binding['product_id']] = $val['id'];
		}
		if(!empty($binding['shipping_address_first_name'])){
			$checkout_shipping_address[$i][$binding['shipping_address_first_name']] = $val['first_name'];
		}
		if(!empty($binding['shipping_address_last_name'])){
			$checkout_shipping_address[$i][$binding['shipping_address_last_name']] = $val['last_name'];
		}
		if(!empty($binding['shipping_address_address1'])){
			$checkout_shipping_address[$i][$binding['shipping_address_address1']] = $val['address1'];
		}
		if(!empty($binding['shipping_address_phone'])){
			$checkout_shipping_address[$i][$binding['shipping_address_phone']] = $val['phone'];
		}
		if(!empty($binding['shipping_address_city'])){
			$checkout_shipping_address[$i][$binding['shipping_address_city']] = $val['city'];
		}
		if(!empty($binding['shipping_address_zip'])){
			$checkout_shipping_address[$i][$binding['shipping_address_zip']] = $val['zip'];
		}
		if(!empty($binding['shipping_address_province'])){
			$checkout_shipping_address[$i][$binding['shipping_address_province']] = $val['province'];
		}
		if(!empty($binding['shipping_address_country'])){
			$checkout_shipping_address[$i][$binding['shipping_address_country']] = $val['country'];
		}
		if(!empty($binding['shipping_address_address2'])){
			$checkout_shipping_address[$i][$binding['shipping_address_address2']] = $val['address2'];
		}
		if(!empty($binding['shipping_address_name'])){
			$checkout_shipping_address[$i][$binding['shipping_address_name']] = $val['name'];
		}
		$i++;
	}
}

$checkout_customer = [];
if(!empty($binding['checkout_customer'])){
	$i = 0;
	foreach($shopify_data['line_items'] as $val){
		if(!empty($binding['product_id'])){
			$checkout_customer[$i][$binding['product_id']] = $val['id'];
		}
		if(!empty($binding['customer_id'])){
			$checkout_customer[$i][$binding['customer_id']] = $val['id'];
		}
		if(!empty($binding['customer_email'])){
			$checkout_customer[$i][$binding['customer_email']] = $val['email'];
		}
		if(!empty($binding['customer_first_name'])){
			$checkout_customer[$i][$binding['customer_first_name']] = $val['first_name'];
		}
		if(!empty($binding['customer_last_name'])){
			$checkout_customer[$i][$binding['customer_last_name']] = $val['last_name'];
		}
		if(!empty($binding['customer_orders_count'])){
			$checkout_customer[$i][$binding['customer_orders_count']] = $val['orders_count'];
		}
		if(!empty($binding['customer_state'])){
			$checkout_customer[$i][$binding['customer_state']] = $val['state'];
		}
		if(!empty($binding['customer_total_spent'])){
			$checkout_customer[$i][$binding['customer_total_spent']] = $val['total_spent'];
		}
		if(!empty($binding['customer_verified_email'])){
			$checkout_customer[$i][$binding['customer_verified_email']] = $val['verified_email'];
		}
		if(!empty($binding['customer_phone'])){
			$checkout_customer[$i][$binding['customer_phone']] = $val['phone'];
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
if(!empty($checkout_line_items)){
	$payload['data'][$binding['checkout_line_items']] = $checkout_line_items;
}
if(!empty($checkout_billing_address)){
	$payload['data'][$binding['checkout_billing_address']] = $checkout_billing_address;
}
if(!empty($checkout_shipping_address)){
	$payload['data'][$binding['checkout_shipping_address']] = $checkout_shipping_address;
}
if(!empty($checkout_customer)){
	$payload['data'][$binding['checkout_customer']] = $checkout_customer;
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
