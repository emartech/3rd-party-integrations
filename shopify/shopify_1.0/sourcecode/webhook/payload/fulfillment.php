<?php

$binding = $result->fetch_assoc();
//GENERATE PAYLOAD

$global_var = [];
$fulfillment_destination = [];
$fulfillment_line_items = [];

if(!empty($binding['fulfillment_id'])){
	$global_var[$binding['fulfillment_id']] = $shopify_data['id'];
}
if(!empty($binding['fulfillment_order_id'])){
	$global_var[$binding['fulfillment_order_id']] = $shopify_data['order_id'];
}
if(!empty($binding['fulfillment_status'])){
	$global_var[$binding['fulfillment_status']] = $shopify_data['status'];
}
if(!empty($binding['fulfillment_tracking_company'])){
	$global_var[$binding['fulfillment_tracking_company']] = $shopify_data['tracking_company'];
}
if(!empty($binding['fulfillment_shipment_status'])){
	$global_var[$binding['fulfillment_shipment_status']] = $shopify_data['shipment_status'];
}
if(!empty($binding['fulfillment_email'])){
	$global_var[$binding['fulfillment_email']] = $shopify_data['email'];
}

if(!empty($binding['fulfillment_destination'])){
	foreach($shopify_data['destination'] as $key => $val){
		switch (true) {

			case ($key == 'first_name'):
			if(!empty($binding['address_first_name'])){
				$fulfillment_destination[$binding['address_first_name']] = $dest;
			}
			break;
		    case ($key == 'last_name'):
		    if(!empty($binding['address_last_name'])){
		    	$fulfillment_destination[$binding['address_last_name']] = $dest;
		    }
		    break;
		    case ($key == 'address1'):
		    if(!empty($binding['address_address1'])){
		    	$fulfillment_destination[$binding['address_address1']] = $dest;
		    }
		    break;
		    case ($key == 'phone'):
		    if(!empty($binding['address_phone'])){
		    	$fulfillment_destination[$binding['address_phone']] = $dest;
		    }
		    break;
		    case ($key == 'city'):
		    if(!empty($binding['address_city'])){
		    	$fulfillment_destination[$binding['address_city']] = $dest;
		    }
		    break;
		    case ($key == 'zip'):
		    if(!empty($binding['address_zip'])){
		    	$fulfillment_destination[$binding['address_zip']] = $dest;
		    }
		    break;
		    case ($key == 'province'):
		    if(!empty($binding['address_province'])){
		    	$fulfillment_destination[$binding['address_province']] = $dest;
		    }
		    break;
		    case ($key == 'country'):
		    if(!empty($binding['address_country'])){
		    	$fulfillment_destination[$binding['address_country']] = $dest;
		    }
		    break;
		    case ($key == 'name'):
		    if(!empty($binding['address_name'])){
		    	$fulfillment_destination[$binding['address_name']] = $dest;
		    }
		    break;
		}
	}
}

if(!empty($binding['fulfillment_line_items'])){
	$i = 0;
	foreach ($shopify_data['line_items'] as $item) {
		
		if(!empty($binding['item_id'])){
			$fulfillment_line_items[$i][$binding['item_id']] = $item['id'];
		}
	    if(!empty($binding['item_title'])){
	    	$fulfillment_line_items[$i][$binding['item_title']] = $item['title'];
	    }
	    if(!empty($binding['item_qty'])){
	    	$fulfillment_line_items[$i][$binding['item_qty']] = $item['quantity'];
	    }
	    if(!empty($binding['item_price'])){
	    	$fulfillment_line_items[$i][$binding['item_price']] = $item['price'];
	    }
	    if(!empty($binding['item_sku'])){
	    	$fulfillment_line_items[$i][$binding['item_sku']] = $item['sku'];
	    }
	    if(!empty($binding['item_fulfillment_service'])){
	    	$fulfillment_line_items[$i][$binding['item_fulfillment_service']] = $item['fulfillment_service'];
	    }
	    if(!empty($binding['item_requires_shipping'])){
	    	$fulfillment_line_items[$i][$binding['item_requires_shipping']] = $item['requires_shipping'];
	    }
	    if(!empty($binding['item_product_exists'])){
	    	$fulfillment_line_items[$i][$binding['item_product_exists']] = $item['product_exists'];
	    }
	    if(!empty($binding['item_fulfillable_quantity'])){
	    	$fulfillment_line_items[$i][$binding['item_fulfillable_quantity']] = $item['fulfillable_quantity'];
	    }
	    if(!empty($binding['item_total_discount'])){
	    	$fulfillment_line_items[$i][$binding['item_total_discount']] = $item['total_discount'];
	    }
	    if(!empty($binding['item_fulfillment_status'])){
	    	$fulfillment_line_items[$i][$binding['item_fulfillment_status']] = $item['fulfillment_status'];
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
if(!empty($fulfillment_destination)){
	$payload['data'][$binding['fulfillment_destination']] = $fulfillment_destination;
}
if(!empty($fulfillment_line_items)){
	$payload['data'][$binding['fulfillment_line_items']] = $fulfillment_line_items;
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
