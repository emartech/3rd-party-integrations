<?php
$query = "SELECT * FROM `emarsys_checkout_placeholders` WHERE fkShopifyEventID = ' " . $_GET['id'] . "'";
$result = $con->query($query);
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
}
if(isset($_POST['submit'])){
	$query = "INSERT INTO `emarsys_checkout_placeholders` (pkCheckoutPlaceholderID, fkShopifyEventID, store_name, checkout_id, checkout_token, checkout_cart_token, checkout_email, checkout_created_at, checkout_updated_at, checkout_subtotal_price, checkout_total_discounts, checkout_total_line_items_price, checkout_total_price, checkout_total_tax, checkout_currency, checkout_user_id, checkout_location_id, checkout_abandoned_checkout_url, checkout_line_items, item_destination_location_id, item_fulfillment_service, item_line_price, item_origin_location_id, item_price, item_product_id, item_quantity, item_requires_shipping, item_sku, item_title, item_variant_id, item_variant_title, checkout_billing_address, billing_address_first_name, billing_address_last_name, billing_address_address1, billing_address_phone, billing_address_city, billing_address_zip, billing_address_province, billing_address_country, billing_address_address2, billing_address_name, checkout_shipping_address, shipping_address_first_name, shipping_address_address1, shipping_address_phone, shipping_address_city, shipping_address_zip, shipping_address_province, shipping_address_country, shipping_address_last_name, shipping_address_address2, shipping_address_name, checkout_customer, customer_id, customer_email, customer_first_name, customer_last_name, customer_orders_count, customer_state, customer_total_spent, customer_verified_email, customer_phone) VALUE ";
	$record_id = (isset($_POST['record_id'])) ? $_POST['record_id'] : '';
	$query .= "('" . $record_id .  "', '" . $_GET['id'] .  "', '" . $_SESSION['shop'] . "', '" . $_POST['checkout_id'] . "', '" . $_POST['checkout_token'] . "', '" . $_POST['checkout_cart_token'] . "', '" . $_POST['checkout_email'] . "', '" . $_POST['checkout_created_at'] . "', '" . $_POST['checkout_updated_at'] . "', '" . $_POST['checkout_subtotal_price'] . "', '" . $_POST['checkout_total_discounts'] . "', '" . $_POST['checkout_total_line_items_price'] . "', '" . $_POST['checkout_total_price'] . "', '" . $_POST['checkout_total_tax'] . "', '" . $_POST['checkout_currency'] . "', '" . $_POST['checkout_user_id'] . "', '" . $_POST['checkout_location_id'] . "', '" . $_POST['checkout_abandoned_checkout_url'] . "', '" . $_POST['checkout_line_items'] . "', '" . $_POST['item_destination_location_id'] . "', '" . $_POST['item_fulfillment_service'] . "', '" . $_POST['item_line_price'] . "', '" . $_POST['item_origin_location_id'] . "', '" . $_POST['item_price'] . "', '" . $_POST['item_product_id'] . "', '" . $_POST['item_quantity'] . "', '" . $_POST['item_requires_shipping'] . "', '" . $_POST['item_sku'] . "', '" . $_POST['item_title'] . "', '" . $_POST['item_variant_id'] . "', '" . $_POST['item_variant_title'] . "', '" . $_POST['checkout_billing_address'] . "', '" . $_POST['billing_address_first_name'] . "', '" . $_POST['billing_address_last_name'] . "', '" . $_POST['billing_address_address1'] . "', '" . $_POST['billing_address_phone'] . "', '" . $_POST['billing_address_city'] . "', '" . $_POST['billing_address_zip'] . "', '" . $_POST['billing_address_province'] . "', '" . $_POST['billing_address_country'] . "', '" . $_POST['billing_address_address2'] . "', '" . $_POST['billing_address_name'] . "', '" . $_POST['checkout_shipping_address'] . "', '" . $_POST['shipping_address_first_name'] . "', '" . $_POST['shipping_address_address1'] . "', '" . $_POST['shipping_address_phone'] . "', '" . $_POST['shipping_address_city'] . "', '" . $_POST['shipping_address_zip'] . "', '" . $_POST['shipping_address_province'] . "', '" . $_POST['shipping_address_country'] . "', '" . $_POST['shipping_address_last_name'] . "', '" . $_POST['shipping_address_address2'] . "', '" . $_POST['shipping_address_name'] . "', '" . $_POST['checkout_customer'] . "', '" . $_POST['customer_id'] . "', '" . $_POST['customer_email'] . "', '" . $_POST['customer_first_name'] . "', '" . $_POST['customer_last_name'] . "', '" . $_POST['customer_orders_count'] . "', '" . $_POST['customer_state'] . "', '" . $_POST['customer_total_spent'] . "', '" . $_POST['customer_verified_email'] . "', '" . $_POST['customer_phone'] . "')";
	$query .= " ON DUPLICATE KEY UPDATE checkout_id=VALUES(checkout_id), checkout_token=VALUES(checkout_token), checkout_cart_token=VALUES(checkout_cart_token), checkout_email=VALUES(checkout_email), checkout_created_at=VALUES(checkout_created_at), checkout_updated_at=VALUES(checkout_updated_at), checkout_subtotal_price=VALUES(checkout_subtotal_price), checkout_total_discounts=VALUES(checkout_total_discounts), checkout_total_line_items_price=VALUES(checkout_total_line_items_price), checkout_total_price=VALUES(checkout_total_price), checkout_total_tax=VALUES(checkout_total_tax), checkout_currency=VALUES(checkout_currency), checkout_user_id=VALUES(checkout_user_id), checkout_location_id=VALUES(checkout_location_id), checkout_abandoned_checkout_url=VALUES(checkout_abandoned_checkout_url), checkout_line_items=VALUES(checkout_line_items), item_destination_location_id=VALUES(item_destination_location_id), item_fulfillment_service=VALUES(item_fulfillment_service), item_line_price=VALUES(item_line_price), item_origin_location_id=VALUES(item_origin_location_id), item_price=VALUES(item_price), item_product_id=VALUES(item_product_id), item_quantity=VALUES(item_quantity), item_requires_shipping=VALUES(item_requires_shipping), item_sku=VALUES(item_sku), item_title=VALUES(item_title), item_variant_id=VALUES(item_variant_id), item_variant_title=VALUES(item_variant_title), checkout_billing_address=VALUES(checkout_billing_address), billing_address_first_name=VALUES(billing_address_first_name), billing_address_last_name=VALUES(billing_address_last_name), billing_address_address1=VALUES(billing_address_address1), billing_address_phone=VALUES(billing_address_phone), billing_address_city=VALUES(billing_address_city), billing_address_zip=VALUES(billing_address_zip), billing_address_province=VALUES(billing_address_province), billing_address_country=VALUES(billing_address_country), billing_address_address2=VALUES(billing_address_address2), billing_address_name=VALUES(billing_address_name), checkout_shipping_address=VALUES(checkout_shipping_address), shipping_address_first_name=VALUES(shipping_address_first_name), shipping_address_address1=VALUES(shipping_address_address1), shipping_address_phone=VALUES(shipping_address_phone), shipping_address_city=VALUES(shipping_address_city), shipping_address_zip=VALUES(shipping_address_zip), shipping_address_province=VALUES(shipping_address_province), shipping_address_country=VALUES(shipping_address_country), shipping_address_last_name=VALUES(shipping_address_last_name), shipping_address_address2=VALUES(shipping_address_address2), shipping_address_name=VALUES(shipping_address_name), checkout_customer=VALUES(checkout_customer), customer_id=VALUES(customer_id), customer_email=VALUES(customer_email), customer_first_name=VALUES(customer_first_name), customer_last_name=VALUES(customer_last_name), customer_orders_count=VALUES(customer_orders_count), customer_state=VALUES(customer_state), customer_total_spent=VALUES(customer_total_spent), customer_verified_email=VALUES(customer_verified_email), customer_phone=VALUES(customer_phone);";
	//echo $query;
	$con->query($query);
	header('Location: ../emarsys_events_mapper.php');
}
?>
<a href="../emarsys_events_mapper.php" class="btn btn-default pull-right">Back</a>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Shopify store Variables</th>
			<th>Emarsys Placeholder</th>
		</tr>
	</thead>
	<tbody>
		<form method="POST">
				<?php if(isset($row)):?>
					<input type="hidden" name="record_id" value="<?= $row['pkCheckoutPlaceholderID']?>">
				<?php endif; ?>
				<tr>
				    <td>{{checkout.id}}</td>
				    <td>
				    	<input type="text" name="checkout_id" value="<?= (isset($row['checkout_id'])) ? $row['checkout_id'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.token}}</td>
				    <td>
				    	<input type="text" name="checkout_token" value="<?= (isset($row['checkout_token'])) ? $row['checkout_token'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.cart_token}}</td>
				    <td>
				    	<input type="text" name="checkout_cart_token" value="<?= (isset($row['checkout_cart_token'])) ? $row['checkout_cart_token'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.email}}</td>
				    <td>
				    	<input type="text" name="checkout_email" value="<?= (isset($row['checkout_email'])) ? $row['checkout_email'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.created_at}}</td>
				    <td>
				    	<input type="text" name="checkout_created_at" value="<?= (isset($row['checkout_created_at'])) ? $row['checkout_created_at'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.updated_at}}</td>
				    <td>
				    	<input type="text" name="checkout_updated_at" value="<?= (isset($row['checkout_updated_at'])) ? $row['checkout_updated_at'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.subtotal_price}}</td>
				    <td>
				    	<input type="text" name="checkout_subtotal_price" value="<?= (isset($row['checkout_subtotal_price'])) ? $row['checkout_subtotal_price'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.total_discounts}}</td>
				    <td>
				    	<input type="text" name="checkout_total_discounts" value="<?= (isset($row['checkout_total_discounts'])) ? $row['checkout_total_discounts'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.total_line_items_price}}</td>
				    <td>
				    	<input type="text" name="checkout_total_line_items_price" value="<?= (isset($row['checkout_total_line_items_price'])) ? $row['checkout_total_line_items_price'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.total_price}}</td>
				    <td>
				    	<input type="text" name="checkout_total_price" value="<?= (isset($row['checkout_total_price'])) ? $row['checkout_total_price'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.total_tax}}</td>
				    <td>
				    	<input type="text" name="checkout_total_tax" value="<?= (isset($row['checkout_total_tax'])) ? $row['checkout_total_tax'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.currency}}</td>
				    <td>
				    	<input type="text" name="checkout_currency" value="<?= (isset($row['checkout_currency'])) ? $row['checkout_currency'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.user_id}}</td>
				    <td>
				    	<input type="text" name="checkout_user_id" value="<?= (isset($row['checkout_user_id'])) ? $row['checkout_user_id'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.location_id}}</td>
				    <td>
				    	<input type="text" name="checkout_location_id" value="<?= (isset($row['checkout_location_id'])) ? $row['checkout_location_id'] : ''?>">
			    	</td>
				</tr>
				<tr>
				    <td>{{checkout.abandoned_checkout_url}}</td>
				    <td>
				    	<input type="text" name="checkout_abandoned_checkout_url" value="<?= (isset($row['checkout_abandoned_checkout_url'])) ? $row['checkout_abandoned_checkout_url'] : ''?>">
			    	</td>
				</tr>
				<tr>
					<td>
						{{checkout.line_items}}
					</td>
					<td>
						<input type="text" name="checkout_line_items" value="<?= (isset($row['checkout_line_items'])) ? $row['checkout_line_items'] : '' ?>">
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{item.destination_location_id}</td>
							<td><input type="text" name="item_destination_location_id" value="<?= (isset($row['item_destination_location_id'])) ? $row['item_destination_location_id'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.fulfillment_service}</td>
							<td><input type="text" name="item_fulfillment_service" value="<?= (isset($row['item_fulfillment_service'])) ? $row['item_fulfillment_service'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.line_price}</td>
							<td><input type="text" name="item_line_price" value="<?= (isset($row['item_line_price'])) ? $row['item_line_price'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.origin_location_id}</td>
							<td><input type="text" name="item_origin_location_id" value="<?= (isset($row['item_origin_location_id'])) ? $row['item_origin_location_id'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.price}</td>
							<td><input type="text" name="item_price" value="<?= (isset($row['item_price'])) ? $row['item_price'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.product_id}</td>
							<td><input type="text" name="item_product_id" value="<?= (isset($row['item_product_id'])) ? $row['item_product_id'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.quantity}</td>
							<td><input type="text" name="item_quantity" value="<?= (isset($row['item_quantity'])) ? $row['item_quantity'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.requires_shipping}</td>
							<td><input type="text" name="item_requires_shipping" value="<?= (isset($row['item_requires_shipping'])) ? $row['item_requires_shipping'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.sku}</td>
							<td><input type="text" name="item_sku" value="<?= (isset($row['item_sku'])) ? $row['item_sku'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.title}</td>
							<td><input type="text" name="item_title" value="<?= (isset($row['item_title'])) ? $row['item_title'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.variant_id}</td>
							<td><input type="text" name="item_variant_id" value="<?= (isset($row['item_variant_id'])) ? $row['item_variant_id'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.variant_title}</td>
							<td><input type="text" name="item_variant_title" value="<?= (isset($row['item_variant_title'])) ? $row['item_variant_title'] : '' ?>"></td>
						</tr>
						</tbody>
						<tfoot>
							<tr><td colspan="2"><p>{{segement end}}</p></td></tr>
						</tfoot>
					</table>
					</td>
				</tr>			
				<tr>
					<td>
						{{checkout.billing_address}}
					</td>
					<td>
						<input type="text" name="checkout_billing_address" value="<?= (isset($row['checkout_billing_address'])) ? $row['checkout_billing_address'] : '' ?>">
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{billing_address.address_first_name}</td>
							<td><input type="text" name="billing_address_first_name" value="<?= (isset($row['billing_address_first_name'])) ? $row['billing_address_first_name'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_last_name}</td>
							<td><input type="text" name="billing_address_last_name" value="<?= (isset($row['billing_address_last_name'])) ? $row['billing_address_last_name'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_address1}</td>
							<td><input type="text" name="billing_address_address1" value="<?= (isset($row['billing_address_address1'])) ? $row['billing_address_address1'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_phone}</td>
							<td><input type="text" name="billing_address_phone" value="<?= (isset($row['billing_address_phone'])) ? $row['billing_address_phone'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_city}</td>
							<td><input type="text" name="billing_address_city" value="<?= (isset($row['billing_address_city'])) ? $row['billing_address_city'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_zip}</td>
							<td><input type="text" name="billing_address_zip" value="<?= (isset($row['billing_address_zip'])) ? $row['billing_address_zip'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_province}</td>
							<td><input type="text" name="billing_address_province" value="<?= (isset($row['billing_address_province'])) ? $row['billing_address_province'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_country}</td>
							<td><input type="text" name="billing_address_country" value="<?= (isset($row['billing_address_country'])) ? $row['billing_address_country'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_address2}</td>
							<td><input type="text" name="billing_address_address2" value="<?= (isset($row['billing_address_address2'])) ? $row['billing_address_address2'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address_name}</td>
							<td><input type="text" name="billing_address_name" value="<?= (isset($row['billing_address_name'])) ? $row['billing_address_name'] : '' ?>"></td>
						</tr>
						</tbody>
						<tfoot>
							<tr><td colspan="2"><p>{{segement end}}</p></td></tr>
						</tfoot>
					</table>
					</td>
				</tr>			
				<tr>
					<td>
						{{checkout.shipping_address}}
					</td>
					<td>
						<input type="text" name="checkout_shipping_address" value="<?= (isset($row['checkout_shipping_address'])) ? $row['checkout_shipping_address'] : '' ?>">
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{shipping_address.first_name}}</td>
							<td><input type="text" name="shipping_address_first_name" value="<?= (isset($row['shipping_address_first_name'])) ? $row['shipping_address_first_name'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.last_name}}</td>
							<td><input type="text" name="shipping_address_last_name" value="<?= (isset($row['shipping_address_last_name'])) ? $row['shipping_address_last_name'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.address1}}</td>
							<td><input type="text" name="shipping_address_address1" value="<?= (isset($row['shipping_address_address1'])) ? $row['shipping_address_address1'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.phone}}</td>
							<td><input type="text" name="shipping_address_phone" value="<?= (isset($row['shipping_address_phone'])) ? $row['shipping_address_phone'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.city}}</td>
							<td><input type="text" name="shipping_address_city" value="<?= (isset($row['shipping_address_city'])) ? $row['shipping_address_city'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.zip}}</td>
							<td><input type="text" name="shipping_address_zip" value="<?= (isset($row['shipping_address_zip'])) ? $row['shipping_address_zip'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.province}}</td>
							<td><input type="text" name="shipping_address_province" value="<?= (isset($row['shipping_address_province'])) ? $row['shipping_address_province'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.country}}</td>
							<td><input type="text" name="shipping_address_country" value="<?= (isset($row['shipping_address_country'])) ? $row['shipping_address_country'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.address2}}</td>
							<td><input type="text" name="shipping_address_address2" value="<?= (isset($row['shipping_address_address2'])) ? $row['shipping_address_address2'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.name}}</td>
							<td><input type="text" name="shipping_address_name" value="<?= (isset($row['shipping_address_name'])) ? $row['shipping_address_name'] : '' ?>"></td>
						</tr>
						</tbody>
						<tfoot>
							<tr><td colspan="2"><p>{{segement end}}</p></td></tr>
						</tfoot>
					</table>
					</td>
				</tr>			
				<tr>
					<td>
						{{checkout.customer}}
					</td>
					<td>
						<input type="text" name="checkout_customer" value="<?= (isset($row['checkout_customer'])) ? $row['checkout_customer'] : '' ?>">
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{customer.id}</td>
							<td><input type="text" name="customer_id" value="<?= (isset($row['customer_id'])) ? $row['customer_id'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{customer.email}</td>
							<td><input type="text" name="customer_email" value="<?= (isset($row['customer_email'])) ? $row['customer_email'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{customer.first_name}</td>
							<td><input type="text" name="customer_first_name" value="<?= (isset($row['customer_first_name'])) ? $row['customer_first_name'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{customer.last_name}</td>
							<td><input type="text" name="customer_last_name" value="<?= (isset($row['customer_last_name'])) ? $row['customer_last_name'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{customer.orders_count}</td>
							<td><input type="text" name="customer_orders_count" value="<?= (isset($row['customer_orders_count'])) ? $row['customer_orders_count'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{customer.state}</td>
							<td><input type="text" name="customer_state" value="<?= (isset($row['customer_state'])) ? $row['customer_state'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{customer.total_spent}</td>
							<td><input type="text" name="customer_total_spent" value="<?= (isset($row['customer_total_spent'])) ? $row['customer_total_spent'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{customer.verified_email}</td>
							<td><input type="text" name="customer_verified_email" value="<?= (isset($row['customer_verified_email'])) ? $row['customer_verified_email'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{customer.phone}</td>
							<td><input type="text" name="customer_phone" value="<?= (isset($row['customer_phone'])) ? $row['customer_phone'] : '' ?>"></td>
						</tr>
						</tbody>
						<tfoot>
							<tr><td colspan="2"><p>{{segement end}}</p></td></tr>
						</tfoot>
					</table>
					</td>
				</tr>			
				<tr class="text-center">
					<td colspan="3" class="text-center"><button type="submit" name="submit" class="btn btn-default">Save</button></td>
				</tr>
		</form>
	</tbody>
</table>