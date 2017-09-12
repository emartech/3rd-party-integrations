<?php
$binding = $result->fetch_assoc();
//GENERATE PAYLOAD
$global_var = [];

if(!empty($binding['order_id'])){
	$global_var[$binding['order_id']] = $shopify_data['id'];
}
if(!empty($binding['order_email'])){
	$global_var[$binding['order_email']] = $shopify_data['email'];
}
if(!empty($binding['order_total_price'])){
	$global_var[$binding['order_total_price']] = $shopify_data['total_price'];
}
if(!empty($binding['order_subtotal_price'])){
	$global_var[$binding['order_subtotal_price']] = $shopify_data['subtotal_price'];
}
if(!empty($binding['order_total_line_items_price'])){
	$global_var[$binding['order_total_line_items_price']] = $shopify_data['total_line_items_price'];
}
if(!empty($binding['order_total_tax'])){
	$global_var[$binding['order_total_tax']] = $shopify_data['total_tax'];
}
if(!empty($binding['order_currency'])){
	$global_var[$binding['order_currency']] = $shopify_data['currency'];
}
if(!empty($binding['order_total_discounts'])){
	$global_var[$binding['order_total_discounts']] = $shopify_data['total_discounts'];
}
if(!empty($binding['order_total_line_items_price'])){
	$global_var[$binding['order_total_line_items_price']] = $shopify_data['total_line_items_price'];
}

$order_line_items = [];

if(!empty($binding['order_line_items'])){
	$i = 0;
	foreach($shopify_data['line_items'] as $val){
		if(!empty($binding['item_product_id'])){
			$order_line_items[$i][$binding['item_product_id']]  = $val['id'];
		}
    	if(!empty($binding['item_title'])){
			$order_line_items[$i][$binding['item_title']]  = $val['title'];
		}
    	if(!empty($binding['item_qty'])){
			$order_line_items[$i][$binding['item_qty']]  = $val['quantity'];
		}
    	if(!empty($binding['item_price'])){
			$order_line_items[$i][$binding['item_price']]  = $val['price'];
		}
    	if(!empty($binding['item_sku'])){
			$order_line_items[$i][$binding['item_sku']]  = $val['sku'];
		}
    	if(!empty($binding['item_fulfillment_service'])){
			$order_line_items[$i][$binding['item_fulfillment_service']]  = $val['fulfillment_service'];
		}
    	if(!empty($binding['item_requires_shipping'])){
			$order_line_items[$i][$binding['item_requires_shipping']]  = $val['requires_shipping'];
		}
    	if(!empty($binding['item_product_exists'])){
			$order_line_items[$i][$binding['item_product_exists']]  = $val['product_exists'];
		}
    	if(!empty($binding['item_fulfillable_quantity'])){
			$order_line_items[$i][$binding['item_fulfillable_quantity']]  = $val['fulfillable_quantity'];
		}
    	if(!empty($binding['item_total_discount'])){
			$order_line_items[$i][$binding['item_total_discount']]  = $val['total_discount'];
		}
    	if(!empty($binding['item_fulfillment_status'])){
			$order_line_items[$i][$binding['item_fulfillment_status']]  = $val['fulfillment_status'];
		}
		$i++;
	}
}

$order_shipping_address = [];

if(!empty($binding['order_shipping_address'])){
	foreach($shopify_data['shipping_address'] as $key => $val){
		switch (true) {
			case ($key == 'first_name'):
				if(!empty($binding['shipping_address_first_name'])){
					$order_shipping_address[$binding['shipping_address_first_name']] = $val;
			}
			break;
		    case ($key == 'last_name'):
		    	if(!empty($binding['shipping_address_last_name'])){
			    	$order_shipping_address[$binding['shipping_address_last_name']] = $val;
		    }
		    break;
		    case ($key == 'address1'):
		    	if(!empty($binding['shipping_address_address1'])){
			    	$order_shipping_address[$binding['shipping_address_address1']] = $val;
		    }
		    break;
		    case ($key == 'phone'):
		    	if(!empty($binding['shipping_address_phone'])){
			    	$order_shipping_address[$binding['shipping_address_phone']] = $val;
		    }
		    break;
		    case ($key == 'city'):
		    	if(!empty($binding['shipping_address_city'])){
			    	$order_shipping_address[$binding['shipping_address_city']] = $val;
		    }
		    break;
		    case ($zipkey = ''):
		    	if(!empty($binding['shipping_address_zip'])){
			    	$order_shipping_address[$binding['shipping_address_zip']] = $val;
		    }
		    case ($key == 'province'):
		    break;
		    	if(!empty($binding['shipping_address_province'])){
			    	$order_shipping_address[$binding['shipping_address_province']] = $val;
		    }
		    break;
		    case ($key == 'country'):
		    	if(!empty($binding['shipping_address_country'])){
			    	$order_shipping_address[$binding['shipping_address_country']] = $val;
		    }
		    break;
		    case ($key == 'name'):
		    	if(!empty($binding['shipping_address_name'])){
			    	$order_shipping_address[$binding['shipping_address_name']] = $val;
		    }
		    break;
		}
	}
}

$order_billing_address = [];

if(!empty($binding['order_billing_address'])){
	foreach($shopify_data['billing_address'] as $key => $val){
		switch (true) {
			case ($key == 'first_name'):
				if(!empty($binding['billing_address_first_name'])){
					$order_shipping_address[$binding['billing_address_first_name']] = $val;
				}
				break;
			case ($key == 'last_name'):
			    if(!empty($binding['billing_address_last_name'])){
			    	$order_shipping_address[$binding['billing_address_last_name']] = $val;
			    }
				break;
			case ($key == 'address1'):
			    if(!empty($binding['billing_address_address1'])){
			    	$order_shipping_address[$binding['billing_address_address1']] = $val;
			    }
				break;
			case ($key == 'phone'):
			    if(!empty($binding['billing_address_phone'])){
			    	$order_shipping_address[$binding['billing_address_phone']] = $val;
			    }
				break;
			case ($key == 'city'):
				if(!empty($binding['billing_address_city'])){
			    	$order_shipping_address[$binding['billing_address_city']] = $val;
			    }
				break;
			case ($key == 'zip'):
			    if(!empty($binding['billing_address_zip'])){
			    	$order_shipping_address[$binding['billing_address_zip']] = $val;
			    }
				break;
			case ($key == 'province'):
			    if(!empty($binding['billing_address_province'])){
			    	$order_shipping_address[$binding['billing_address_province']] = $val;
			    }
				break;
			case ($key == 'country'):
				if(!empty($binding['billing_address_country'])){
			    	$order_shipping_address[$binding['billing_address_country']] = $val;
			    }
				break;
			case ($key == 'name'):
			    if(!empty($binding['billing_address_name'])){
			    	$order_shipping_address[$binding['billing_address_name']] = $val;
			    }
				break;
		}
    }
}

$order_customer = [];
if(!empty($binding['order_customer'])){
	foreach ($shopify_data['customer'] as $key => $value) {
		switch (true) {
			case ($key == 'id'):
				if(!empty($binding['customer_id'])){
					$order_customer[$binding['customer_id']] = $value;
				}
				break;
			case ($key == 'email'):
			    if(!empty($binding['customer_email'])){
			    	$order_customer[$binding['customer_email']] = $value;
			    }
				break;
			case($key == 'first_name'):
			    if(!empty($binding['customer_first_name'])){
			    	$order_customer[$binding['customer_first_name']] = $value;
			    }
			    break;
    		case($key == 'last_name'):
			    if(!empty($binding['customer_last_name'])){
			    	$order_customer[$binding['customer_last_name']] = $value;
			    }
			    break;
			case($key == 'orders_count'):
			    if(!empty($binding['customer_orders_count'])){
			    	$order_customer[$binding['customer_orders_count']] = $value;
			    }
			case($key == 'phone'):
			    if(!empty($binding['customer_phone'])){
			    	$order_customer[$binding['customer_phone']] = $value;
			    }
				break;
		}
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
if(!empty($order_line_items)){
	$payload['data'][$binding['order_line_items']] = $order_line_items;
}
if(!empty($order_shipping_address)){
	$payload['data'][$binding['order_shipping_address']] = $order_shipping_address;
}
if(!empty($order_billing_address)){
	$payload['data'][$binding['order_billing_address']] = $order_billing_address;
}
if(!empty($order_customer)){
	$payload['data'][$binding['order_customer']] = $order_customer;
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
