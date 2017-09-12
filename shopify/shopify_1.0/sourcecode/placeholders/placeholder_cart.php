<?php
$query = "SELECT * FROM `emarsys_cart_placeholders` WHERE fkShopifyEventID = ' " . $_GET['id'] . "'";
$result = $con->query($query);
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
}
if(isset($_POST['submit'])){
	$query = "INSERT INTO `emarsys_cart_placeholders` (pkCartPlaceholderID, fkShopifyEventID, store_name, cart_id, cart_token, cart_line_items, product_id, item_qty, item_title, item_price, item_discounted_price, item_line_price, item_total_discount, item_sku) VALUE ";
	$record_id = (isset($_POST['record_id'])) ? $_POST['record_id'] : '';
	$query .= "('" . $record_id .  "', '" . $_GET['id'] .  "', '" . $_SESSION['shop'] .  "', '" . $_POST['cart_id'] . "', '" . $_POST['cart_token'] . "', '" . $_POST['cart_line_items'] . "', '" . $_POST['product_id'] . "', '" . $_POST['item_qty'] . "', '" . $_POST['item_title'] . "', '" . $_POST['item_price'] . "', '" . $_POST['item_discounted_price'] . "', '" . $_POST['item_line_price'] . "', '" . $_POST['item_total_discount'] . "', '" . $_POST['item_sku'] . "')";
	$query .= " ON DUPLICATE KEY UPDATE cart_id=VALUES(cart_id), cart_token=VALUES(cart_token), cart_line_items=VALUES(cart_line_items), product_id=VALUES(product_id), item_qty=VALUES(item_qty), item_title=VALUES(item_title), item_price=VALUES(item_price), item_discounted_price=VALUES(item_discounted_price), item_line_price=VALUES(item_line_price), item_total_discount=VALUES(item_total_discount), item_sku=VALUES(item_sku);";
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
					<input type="hidden" name="record_id" value="<?= $row['pkCartPlaceholderID']?>">
				<?php endif; ?>
				<tr>
				    <td>{{cart.id}}</td>
				    <td><input type="text" name="cart_id" value="<?= (isset($row['cart_id'])) ? $row['cart_id'] : ''?>"></td>
				</tr>
				<tr>
					<td>{{cart.token}}</td>
					<td>
					<input type="text" name="cart_token" value="<?= (isset($row['cart_token'])) ? $row['cart_token'] : '' ?>">
					</td>
				</tr>
				<tr>
					<td>
						{{cart.line_items}}
					</td>
					<td>
						<input type="text" name="cart.line_items" value="<?= (isset($row['cart_line_items'])) ? $row['cart_line_items'] : '' ?>">
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{item.product_id}}</td>
							<td><input type="text" name="product_id" value="<?= (isset($row['product_id'])) ? $row['product_id'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.quantity}}</td>
							<td><input type="text" name="item_qty" value="<?= (isset($row['item_qty'])) ? $row['item_qty'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.title}}</td>
							<td><input type="text" name="item_title" value="<?= (isset($row['item_title'])) ? $row['item_title'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.price}}</td>
							<td><input type="text" name="item_price" value="<?= (isset($row['item_price'])) ? $row['item_price'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.discounted_price}}</td>
							<td><input type="text" name="item_discounted_price" value="<?= (isset($row['item_discounted_price'])) ? $row['item_discounted_price'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.line_price}}</td>
							<td><input type="text" name="item_line_price" value="<?= (isset($row['item_line_price'])) ? $row['item_line_price'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.total_discount}}</td>
							<td><input type="text" name="item_total_discount" value="<?= (isset($row['item_total_discount'])) ? $row['item_total_discount'] : '' ?>"></td>
						</tr>
						<tr>
							<td>{{item.sku}}</td>
							<td><input type="text" name="item_sku" value="<?= (isset($row['item_sku'])) ? $row['item_sku'] : '' ?>"></td>
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