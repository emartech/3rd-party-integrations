<?php
$query = "SELECT * FROM `emarsys_order_placeholders` WHERE fkShopifyEventID = ' " . $_GET['id'] . "'";
$result = $con->query($query);
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
}
if(isset($_POST['submit'])){
	$query = "INSERT INTO `emarsys_order_placeholders` (pkOrderPlaceholderID, fkShopifyEventID, store_name, order_id, order_email, order_total_price, order_subtotal_price, order_total_tax, order_currency, order_total_discounts, order_total_line_items_price, order_line_items, item_product_id, item_qty, item_title, item_price, item_fulfillment_service, item_requires_shipping, item_fulfillable_quantity, item_product_exists, order_shipping_address, item_total_discount, item_sku, item_fulfillment_status, shipping_address_first_name, shipping_address_last_name, shipping_address_address1, shipping_address_phone, shipping_address_city, shipping_address_zip, shipping_address_province, shipping_address_country, shipping_address_name, order_billing_address, billing_address_first_name, billing_address_last_name, billing_address_address1, billing_address_phone, billing_address_city, billing_address_zip, billing_address_province, billing_address_country, billing_address_name, order_customer, customer_id, customer_email, customer_first_name, customer_last_name, customer_orders_count, customer_phone) VALUE ";
	$record_id = (isset($_POST['record_id'])) ? $_POST['record_id'] : '';
	$query .= "('" . $record_id .  "', '" . $_GET['id'] .  "', '" . $_SESSION['shop'] .  "', '" . $_POST['order_id'] . "', '" . $_POST['order_email'] . "', '" . $_POST['order_total_price'] . "', '" . $_POST['order_subtotal_price'] . "', '" . $_POST['order_total_tax'] . "', '" . $_POST['order_currency'] . "', '" . $_POST['order_total_discounts'] . "', '" . $_POST['order_total_line_items_price'] . "', '" . $_POST['order_line_items'] . "', '" . $_POST['item_product_id'] . "', '" . $_POST['item_qty'] . "', '" . $_POST['item_title'] . "', '" . $_POST['item_price'] . "', '" . $_POST['item_fulfillment_service'] . "', '" . $_POST['item_requires_shipping'] . "', '" . $_POST['item_fulfillable_quantity'] . "', '" . $_POST['item_product_exists'] . "', '" . $_POST['item_total_discount'] . "', '" . $_POST['item_sku'] . "', '" . $_POST['item_fulfillment_status'] . "', '" . $_POST['order_shipping_address'] . "', '" . $_POST['shipping_address_first_name'] . "', '" . $_POST['shipping_address_last_name'] . "', '" . $_POST['shipping_address_address1'] . "', '" . $_POST['shipping_address_phone'] . "', '" . $_POST['shipping_address_city'] . "', '" . $_POST['shipping_address_zip'] . "', '" . $_POST['shipping_address_province'] . "', '" . $_POST['shipping_address_country'] . "', '" . $_POST['shipping_address_name'] . "', '" . $_POST['order_billing_address'] . "', '" . $_POST['billing_address_first_name'] . "', '" . $_POST['billing_address_last_name'] . "', '" . $_POST['billing_address_address1'] . "', '" . $_POST['billing_address_phone'] . "', '" . $_POST['billing_address_city'] . "', '" . $_POST['billing_address_zip'] . "', '" . $_POST['billing_address_province'] . "', '" . $_POST['billing_address_country'] . "', '" . $_POST['billing_address_name'] . "', '" . $_POST['order_customer'] . "', '" . $_POST['customer_id'] . "', '" . $_POST['customer_email'] . "', '" . $_POST['customer_first_name'] . "', '" . $_POST['customer_last_name'] . "', '" . $_POST['customer_orders_count'] . "', '" . $_POST['customer_phone'] . "')";
	$query .= " ON DUPLICATE KEY UPDATE order_id=VALUES(order_id), order_email=VALUES(order_email), order_total_price=VALUES(order_total_price), order_subtotal_price=VALUES(order_subtotal_price), order_total_tax=VALUES(order_total_tax), order_currency=VALUES(order_currency), order_total_discounts=VALUES(order_total_discounts), order_total_line_items_price=VALUES(order_total_line_items_price), order_line_items=VALUES(order_line_items), item_product_id=VALUES(item_product_id), item_qty=VALUES(item_qty), item_title=VALUES(item_title), item_price=VALUES(item_price), item_fulfillment_service=VALUES(item_fulfillment_service), item_requires_shipping=VALUES(item_requires_shipping), item_fulfillable_quantity=VALUES(item_fulfillable_quantity), item_product_exists=VALUES(item_product_exists), item_total_discount=VALUES(item_total_discount), item_sku=VALUES(item_sku), item_fulfillment_status=VALUES(item_fulfillment_status), order_shipping_address=VALUES(order_shipping_address), shipping_address_first_name=VALUES(shipping_address_first_name), shipping_address_last_name=VALUES(shipping_address_last_name), shipping_address_address1=VALUES(shipping_address_address1), shipping_address_phone=VALUES(shipping_address_phone), shipping_address_city=VALUES(shipping_address_city), shipping_address_zip=VALUES(shipping_address_zip), shipping_address_province=VALUES(shipping_address_province), shipping_address_country=VALUES(shipping_address_country), shipping_address_name=VALUES(shipping_address_name), order_billing_address=VALUES(order_billing_address), billing_address_first_name=VALUES(billing_address_first_name), billing_address_last_name=VALUES(billing_address_last_name), billing_address_address1=VALUES(billing_address_address1), billing_address_phone=VALUES(billing_address_phone), billing_address_city=VALUES(billing_address_city), billing_address_zip=VALUES(billing_address_zip), billing_address_province=VALUES(billing_address_province), billing_address_country=VALUES(billing_address_country), billing_address_name=VALUES(billing_address_name), order_customer=VALUES(order_customer), customer_id=VALUES(customer_id), customer_email=VALUES(customer_email), customer_first_name=VALUES(customer_first_name), customer_last_name=VALUES(customer_last_name), customer_orders_count=VALUES(customer_orders_count), customer_phone=VALUES(customer_phone);";
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
					<input type="hidden" name="record_id" value="<?= $row['pkOrderPlaceholderID']?>">
				<?php endif; ?>
				<tr>
				    <td>{{order.id}}</td>
				    <td><input type="text" name="order_id" value="<?= (isset($row['order_id'])) ? $row['order_id'] : ''; ?>"></td>
				</tr>
				<tr>
				    <td>{{order.email}}</td>
				    <td><input type="text" name="order_email" value="<?= (isset($row['order_email'])) ? $row['order_email'] : ''; ?>"></td>
				</tr>
				<tr>
				    <td>{{order.total_price}}</td>
				    <td><input type="text" name="order_total_price" value="<?= (isset($row['order_total_price'])) ? $row['order_total_price'] : ''; ?>"></td>
				</tr>
				<tr>
				    <td>{{order.subtotal_price}}</td>
				    <td><input type="text" name="order_subtotal_price" value="<?= (isset($row['order_subtotal_price'])) ? $row['order_subtotal_price'] : ''; ?>"></td>
				</tr>
				<tr>
				    <td>{{order.total_tax}}</td>
				    <td><input type="text" name="order_total_tax" value="<?= (isset($row['order_total_tax'])) ? $row['order_total_tax'] : ''; ?>"></td>
				</tr>
				<tr>
				    <td>{{order.currency}}</td>
				    <td><input type="text" name="order_currency" value="<?= (isset($row['order_currency'])) ? $row['order_currency'] : ''; ?>"></td>
				</tr>
				<tr>
				    <td>{{order.total_discounts}}</td>
				    <td><input type="text" name="order_total_discounts" value="<?= (isset($row['order_total_discounts'])) ? $row['order_total_discounts'] : ''; ?>"></td>
				</tr>
				<tr>
				    <td>{{order.total_line_items_price}}</td>
				    <td><input type="text" name="order_total_line_items_price" value="<?= (isset($row['order_total_line_items_price'])) ? $row['order_total_line_items_price'] : ''; ?>"></td>
				</tr>
				<tr>
					<td>
						{{order.line_items}}
					</td>
					<td>
						<input type="text" name="order_line_items" value="<?= (isset($row['order_line_items'])) ? $row['order_line_items'] : ''; ?>">
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{item.product_id}}</td>
							<td><input type="text" name="item_product_id" value="<?= (isset($row['item_product_id'])) ? $row['item_product_id'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.quantity}}</td>
							<td><input type="text" name="item_qty" value="<?= (isset($row['item_qty'])) ? $row['item_qty'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.title}}</td>
							<td><input type="text" name="item_title" value="<?= (isset($row['item_title'])) ? $row['item_title'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.price}}</td>
							<td><input type="text" name="item_price" value="<?= (isset($row['item_price'])) ? $row['item_price'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.fulfillment_service}}</td>
							<td><input type="text" name="item_fulfillment_service" value="<?= (isset($row['item_fulfillment_service'])) ? $row['item_fulfillment_service'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.requires_shipping}}</td>
							<td><input type="text" name="item_requires_shipping" value="<?= (isset($row['item_requires_shipping'])) ? $row['item_requires_shipping'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.product_exists}}</td>
							<td><input type="text" name="item_product_exists" value="<?= (isset($row['item_product_exists'])) ? $row['item_product_exists'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.fulfillable_quantity}}</td>
							<td><input type="text" name="item_fulfillable_quantity" value="<?= (isset($row['item_fulfillable_quantity'])) ? $row['item_fulfillable_quantity'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.total_discount}}</td>
							<td><input type="text" name="item_total_discount" value="<?= (isset($row['item_total_discount'])) ? $row['item_total_discount'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.sku}}</td>
							<td><input type="text" name="item_sku" value="<?= (isset($row['item_sku'])) ? $row['item_sku'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{item.fulfillment_status}}</td>
							<td><input type="text" name="item_fulfillment_status" value="<?= (isset($row['item_fulfillment_status'])) ? $row['item_fulfillment_status'] : ''; ?>"></td>
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
						{{order.shipping_address}}
					</td>
					<td>
						<input type="text" name="order_shipping_address" value="<?= (isset($row['order_shipping_address'])) ? $row['order_shipping_address'] : ''; ?>">
						<p class="help-block">Mapper for the Section</p>
					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{shipping_address.first_name}}</td>
							<td><input type="text" name="shipping_address_first_name" value="<?= (isset($row['shipping_address_first_name'])) ? $row['shipping_address_first_name'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.last_name}}</td>
							<td><input type="text" name="shipping_address_last_name" value="<?= (isset($row['shipping_address_last_name'])) ? $row['shipping_address_last_name'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.address1}}</td>
							<td><textarea name="shipping_address_address1" ><?= (isset($row['shipping_address_address1'])) ? $row['shipping_address_address1'] : ''; ?></textarea></td>
						</tr>
						<tr>
							<td>{{shipping_address.phone}}</td>
							<td><input type="text" name="shipping_address_phone" value="<?= (isset($row['shipping_address_phone'])) ? $row['shipping_address_phone'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.city}}</td>
							<td><input type="text" name="shipping_address_city" value="<?= (isset($row['shipping_address_city'])) ? $row['shipping_address_city'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.zip}}</td>
							<td><input type="text" name="shipping_address_zip" value="<?= (isset($row['shipping_address_zip'])) ? $row['shipping_address_zip'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.province}}</td>
							<td><input type="text" name="shipping_address_province" value="<?= (isset($row['shipping_address_province'])) ? $row['shipping_address_province'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.country}}</td>
							<td><input type="text" name="shipping_address_country" value="<?= (isset($row['shipping_address_country'])) ? $row['shipping_address_country'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{shipping_address.name}}</td>
							<td><input type="text" name="shipping_address_name" value="<?= (isset($row['shipping_address_name'])) ? $row['shipping_address_name'] : ''; ?>"></td>
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
						{{order.billing_address}}
					</td>
					<td>
						<input type="text" name="order_billing_address" value="<?= (isset($row['order_billing_address'])) ? $row['order_billing_address'] : ''; ?>">
						<p class="help-block">Mapper for the Section</p>
					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{billing_address.first_name}}</td>
							<td><input type="text" name="billing_address_first_name" value="<?= (isset($row['billing_address_first_name'])) ? $row['billing_address_first_name'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.last_name}}</td>
							<td><input type="text" name="billing_address_last_name" value="<?= (isset($row['billing_address_last_name'])) ? $row['billing_address_last_name'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.address1}}</td>
							<td><textarea name="billing_address_address1"><?= (isset($row['billing_address_address1'])) ? $row['billing_address_address1'] : ''; ?></textarea></td>
						</tr>
						<tr>
							<td>{{billing_address.phone}}</td>
							<td><input type="text" name="billing_address_phone" value="<?= (isset($row['billing_address_phone'])) ? $row['billing_address_phone'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.zip}}</td>
							<td><input type="text" name="billing_address_zip" value="<?= (isset($row['billing_address_zip'])) ? $row['billing_address_zip'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.city}}</td>
							<td><input type="text" name="billing_address_city" value="<?= (isset($row['billing_address_city'])) ? $row['billing_address_city'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.province}}</td>
							<td><input type="text" name="billing_address_province" value="<?= (isset($row['billing_address_province'])) ? $row['billing_address_province'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.country}}</td>
							<td><input type="text" name="billing_address_country" value="<?= (isset($row['billing_address_country'])) ? $row['billing_address_country'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{billing_address.name}}</td>
							<td><input type="text" name="billing_address_name" value="<?= (isset($row['billing_address_name'])) ? $row['billing_address_name'] : ''; ?>"></td>
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
						{{order.customer}}
					</td>
					<td>
						<input type="text" name="order_customer" value="<?= (isset($row['order_customer'])) ? $row['order_customer'] : ''; ?>">
						<p class="help-block">Mapper for the Section</p>
					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
					    	<td>{{customer.id}}</td>
						    <td><input type="text" name="customer_id" value="<?= (isset($row['customer_id'])) ? $row['customer_id'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{customer.email}}</td>
							<td><input type="text" name="customer_email" value="<?= (isset($row['customer_email'])) ? $row['customer_email'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{customer.first_name}}</td>
							<td><input type="text" name="customer_first_name" value="<?= (isset($row['customer_first_name'])) ? $row['customer_first_name'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{customer.last_name}}</td>
							<td><input type="text" name="customer_last_name" value="<?= (isset($row['customer_last_name'])) ? $row['customer_last_name'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{customer.orders_count}}</td>
							<td><input type="text" name="customer_orders_count" value="<?= (isset($row['customer_orders_count'])) ? $row['customer_orders_count'] : ''; ?>"></td>
						</tr>
						<tr>
							<td>{{customer.phone}}</td>
							<td><input type="text" name="customer_phone" value="<?= (isset($row['customer_phone'])) ? $row['customer_phone'] : ''; ?>"></td>
						</tr>
						</tbody>
						<tfoot>
							<tr><td colspan="2"><p>{{segement end}}</p></td></tr>
						</tfoot>
					</table>
					</td>
				</tr>
				<!-- <tr>
				    <td>{{order.}}</td>
				    <td><input type="text" name="order_"></td>
				</tr> -->
				<tr class="text-center">
					<td colspan="3" class="text-center"><button type="submit" name="submit" class="btn btn-default">Save</button></td>
				</tr>
		</form>
	</tbody>
</table>