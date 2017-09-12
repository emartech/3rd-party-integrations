<?php
$query = "SELECT * FROM `emarsys_fulfillments_placeholders` WHERE fkShopifyEventID = ' " . $_GET['id'] . "'";
$result = $con->query($query);
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
}
if(isset($_POST['submit'])){
	$query = "INSERT INTO `emarsys_fulfillments_placeholders` (pkFulfillmentPlaceholderID, fkShopifyEventID, store_name, fulfillment_id, fulfillment_order_id, fulfillment_status, fulfillment_tracking_company, fulfillment_shipment_status, fulfillment_email, fulfillment_destination, address_first_name, address_last_name, address_address1, address_phone, address_city, address_zip, address_province, address_country, address_name, fulfillment_tracking_number, fulfillment_tracking_url, fulfillment_line_items, item_id, item_qty, item_title, item_price, item_fulfillment_service, item_requires_shipping, item_total_discount, item_sku, item_product_exists, item_fulfillable_quantity, item_fulfillment_status) VALUE ";
	$record_id = (isset($_POST['record_id'])) ? $_POST['record_id'] : '';
	$query .= "('" . $record_id .  "', '" . $_GET['id'] .  "', '" . $_SESSION['shop'] .  "', '" . $_POST['fulfillment_id'] . "', '" . $_POST['fulfillment_order_id'] . "', '" . $_POST['fulfillment_status'] . "', '" . $_POST['fulfillment_tracking_company'] . "', '" . $_POST['fulfillment_shipment_status'] . "', '" . $_POST['fulfillment_email'] . "', '" . $_POST['fulfillment_destination'] . "', '" . $_POST['address_first_name'] . "', '" . $_POST['address_last_name'] . "', '" . $_POST['address_address1'] . "', '" . $_POST['address_phone'] . "', '" . $_POST['address_city'] . "', '" . $_POST['address_zip'] . "', '" . $_POST['address_province'] . "', '" . $_POST['address_country'] . "', '" . $_POST['address_name'] . "', '" . $_POST['fulfillment_tracking_number'] . "', '" . $_POST['fulfillment_tracking_url'] . "', '" . $_POST['fulfillment_line_items'] . "', '" . $_POST['item_id'] . "', '" . $_POST['item_qty'] . "', '" . $_POST['item_title'] . "', '" . $_POST['item_price'] . "', '" . $_POST['item_fulfillment_service'] . "', '" . $_POST['item_requires_shipping'] . "', '" . $_POST['item_total_discount'] . "', '" . $_POST['item_sku'] . "', '" . $_POST['item_product_exists'] . "', '" . $_POST['item_fulfillable_quantity'] . "', '" . $_POST['item_fulfillment_status'] . "')";
	$query .= " ON DUPLICATE KEY UPDATE fulfillment_id=VALUES(fulfillment_id), fulfillment_order_id=VALUES(fulfillment_order_id), fulfillment_status=VALUES(fulfillment_status), fulfillment_tracking_company=VALUES(fulfillment_tracking_company), fulfillment_shipment_status=VALUES(fulfillment_shipment_status), fulfillment_email=VALUES(fulfillment_email), fulfillment_destination=VALUES(fulfillment_destination), address_first_name=VALUES(address_first_name), address_last_name=VALUES(address_last_name), address_address1=VALUES(address_address1), address_phone=VALUES(address_phone), address_city=VALUES(address_city), address_zip=VALUES(address_zip), address_province=VALUES(address_province), address_country=VALUES(address_country), address_name=VALUES(address_name), fulfillment_tracking_number=VALUES(fulfillment_tracking_number), fulfillment_tracking_url=VALUES(fulfillment_tracking_url), fulfillment_line_items=VALUES(fulfillment_line_items), item_id=VALUES(item_id), item_qty=VALUES(item_qty), item_title=VALUES(item_title), item_price=VALUES(item_price), item_fulfillment_service=VALUES(item_fulfillment_service), item_requires_shipping=VALUES(item_requires_shipping), item_total_discount=VALUES(item_total_discount), item_sku=VALUES(item_sku), item_product_exists=VALUES(item_product_exists), item_fulfillable_quantity=VALUES(item_fulfillable_quantity), item_fulfillment_status=VALUES(item_fulfillment_status);";
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
					<input type="hidden" name="record_id" value="<?= $row['pkFulfillmentPlaceholderID']?>">
				<?php endif; ?>
				<tr>
					<td>{{fulfillment.id}}</td>
					<td><input type="text" name="fulfillment_id" value="<?= (isset($row['fulfillment_id']) ? $row['fulfillment_id'] : '')?>" ></td>
				</tr>
				<tr>
					<td>{{fulfillment.order_id}}</td>
					<td><input type="text" name="fulfillment_order_id" value="<?= (isset($row['fulfillment_order_id']) ? $row['fulfillment_order_id'] : '')?>" ></td>
				</tr>
				<tr>
					<td>{{fulfillment.status}}</td>
					<td><input type="text" name="fulfillment_status" value="<?= (isset($row['fulfillment_status']) ? $row['fulfillment_status'] : '')?>" ></td>
				</tr>
				<tr>
					<td>{{fulfillment.tracking_company}}</td>
					<td><input type="text" name="fulfillment_tracking_company" value="<?= (isset($row['fulfillment_tracking_company']) ? $row['fulfillment_tracking_company'] : '')?>" ></td>
				</tr>
				<tr>
					<td>{{fulfillment.shipment_status}}</td>
					<td><input type="text" name="fulfillment_shipment_status" value="<?= (isset($row['fulfillment_shipment_status']) ? $row['fulfillment_shipment_status'] : '')?>" ></td>
				</tr>
				<tr>
					<td>{{fulfillment.email}}</td>
					<td><input type="text" name="fulfillment_email" value="<?= (isset($row['fulfillment_email']) ? $row['fulfillment_email'] : '')?>" ></td>
				</tr>
				<tr>
					<td>
						{{fulfillment.destination}}
					</td>
					<td>
						<input type="text" name="fulfillment_destination" value="<?= (isset($row['fulfillment_destination']) ? $row['fulfillment_destination'] : '')?>" >
						<p class="help-block">Mapper for the Section</p>
					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{address.first_name}}</td>
							<td><input type="text" name="address_first_name" value="<?= (isset($row['address_first_name']) ? $row['address_first_name'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{address.last_name}}</td>
							<td><input type="text" name="address_last_name" value="<?= (isset($row['address_last_name']) ? $row['address_last_name'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{address.address1}}</td>
							<td><textarea name="address_address1"><?= (isset($row['address_address1']) ? $row['address_address1'] : '')?></textarea></td>
						</tr>
						<tr>
							<td>{{address.phone}}</td>
							<td><input type="text" name="address_phone" value="<?= (isset($row['address_phone']) ? $row['address_phone'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{address.city}}</td>
							<td><input type="text" name="address_city" value="<?= (isset($row['address_city']) ? $row['address_city'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{address.zip}}</td>
							<td><input type="text" name="address_zip" value="<?= (isset($row['address_zip']) ? $row['address_zip'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{address.province}}</td>
							<td><input type="text" name="address_province" value="<?= (isset($row['address_province']) ? $row['address_province'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{address.country}}</td>
							<td><input type="text" name="address_country" value="<?= (isset($row['address_country']) ? $row['address_country'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{address.name}}</td>
							<td><input type="text" name="address_name" value="<?= (isset($row['address_name']) ? $row['address_name'] : '')?>" ></td>
						</tr>
						</tbody>
						<tfoot>
							<tr><td colspan="2"><p>{{segement end}}</p></td></tr>
						</tfoot>
					</table>
					</td>
				</tr>
				<tr>
					<td>{{fulfillment.tracking_number}}</td>
					<td><input type="text" name="fulfillment_tracking_number" value="<?= (isset($row['fulfillment_tracking_number']) ? $row['fulfillment_tracking_number'] : '')?>" ></td>
				</tr>
				<tr>
					<td>{{fulfillment.tracking_url}}</td>
					<td><input type="text" name="fulfillment_tracking_url" value="<?= (isset($row['fulfillment_tracking_url']) ? $row['fulfillment_tracking_url'] : '')?>" ></td>
				</tr>
				<tr>
					<td>
						{{fulfillment.line_items}}
					</td>
					<td>
						<input type="text" name="fulfillment_line_items" value="<?= (isset($row['fulfillment_line_items']) ? $row['fulfillment_line_items'] : '')?>" >
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{item.product_id}}</td>
							<td><input type="text" name="item_id" value="<?= (isset($row['item_id']) ? $row['item_id'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.quantity}}</td>
							<td><input type="text" name="item_qty" value="<?= (isset($row['item_qty']) ? $row['item_qty'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.title}}</td>
							<td><input type="text" name="item_title" value="<?= (isset($row['item_title']) ? $row['item_title'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.price}}</td>
							<td><input type="text" name="item_price" value="<?= (isset($row['item_price']) ? $row['item_price'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.fulfillment_service}}</td>
							<td><input type="text" name="item_fulfillment_service" value="<?= (isset($row['item_fulfillment_service']) ? $row['item_fulfillment_service'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.requires_shipping}}</td>
							<td><input type="text" name="item_requires_shipping" value="<?= (isset($row['item_requires_shipping']) ? $row['item_requires_shipping'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.total_discount}}</td>
							<td><input type="text" name="item_total_discount" value="<?= (isset($row['item_total_discount']) ? $row['item_total_discount'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.sku}}</td>
							<td><input type="text" name="item_sku" value="<?= (isset($row['item_sku']) ? $row['item_sku'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.product_exists}}</td>
							<td><input type="text" name="item_product_exists" value="<?= (isset($row['item_product_exists']) ? $row['item_product_exists'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.fulfillable_quantity}}</td>
							<td><input type="text" name="item_fulfillable_quantity" value="<?= (isset($row['item_fulfillable_quantity']) ? $row['item_fulfillable_quantity'] : '')?>" ></td>
						</tr>
						<tr>
							<td>{{item.fulfillment_status}}</td>
							<td><input type="text" name="item_fulfillment_status" value="<?= (isset($row['item_fulfillment_status']) ? $row['item_fulfillment_status'] : '')?>" ></td>
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