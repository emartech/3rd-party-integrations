<?php
$query = "SELECT * FROM `emarsys_customer_placeholder` WHERE fkShopifyEventID = ' " . $_GET['id'] . "'";
$result = $con->query($query);
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
	// echo '<pre>';
	// print_r($row);
}
if(isset($_POST['submit'])){
	$query = "INSERT INTO `emarsys_customer_placeholder` (pkCustomerPlaceholderID, fkShopifyEventID, store_name, customer_id, customer_email, customer_first_name, customer_last_name, customer_orders_count, customer_phone, customer_address, address_first_name, address_last_name, address_address1, address_phone, address_city, address_province, address_country, address_name) VALUE ";
	$record_id = (isset($_POST['record_id'])) ? $_POST['record_id'] : '';
	$query .= "('" . $record_id .  "', '" . $_GET['id'] .  "', '" . $_SESSION['shop'] .  "', '" . $_POST['customer_id'] . "', '" . $_POST['customer_email'] . "', '" . $_POST['customer_first_name'] . "', '" . $_POST['customer_last_name'] . "', '" . $_POST['customer_orders_count'] . "', '" . $_POST['customer_phone'] . "', '" . $_POST['customer_address'] . "', '" . $_POST['address_first_name'] . "', '" . $_POST['address_last_name'] . "', '" . $_POST['address_address1'] . "', '" . $_POST['address_phone'] . "', '" . $_POST['address_city'] . "', '" . $_POST['address_province'] . "', '" . $_POST['address_country'] . "', '" . $_POST['address_name'] . "')";
	$query .= " ON DUPLICATE KEY UPDATE customer_id=VALUES(customer_id), customer_email=VALUES(customer_email), customer_first_name=VALUES(customer_first_name), customer_last_name=VALUES(customer_last_name), customer_orders_count=VALUES(customer_orders_count), customer_phone=VALUES(customer_phone), customer_address=VALUES(customer_address), address_first_name=VALUES(address_first_name), address_last_name=VALUES(address_last_name), address_address1=VALUES(address_address1), address_phone=VALUES(address_phone), address_city=VALUES(address_city), address_province=VALUES(address_province), address_country=VALUES(address_country), address_name=VALUES(address_name);";
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
					<input type="hidden" name="record_id" value="<?= $row['pkCustomerPlaceholderID']?>">
				<?php endif; ?>
				<tr>
				    <td>{{customer.id}}</td>
				    <td><input type="text" name="customer_id" value="<?= (isset($row['customer_id'])) ? $row['customer_id'] : ''?>"></td>
				</tr>
				<tr>
					<td>{{customer.email}}</td>
					<td><input type="text" name="customer_email" value="<?= (isset($row['customer_email'])) ? $row['customer_email'] : ''?>"></td>
				</tr>
				<tr>
					<td>{{customer.first_name}}</td>
					<td><input type="text" name="customer_first_name" value="<?= (isset($row['customer_first_name'])) ? $row['customer_first_name'] : ''?>"></td>
				</tr>
				<tr>
					<td>{{customer.last_name}}</td>
					<td><input type="text" name="customer_last_name" value="<?= (isset($row['customer_last_name'])) ? $row['customer_last_name'] : ''?>"></td>
				</tr>
				<tr>
					<td>{{customer.orders_count}}</td>
					<td><input type="text" name="customer_orders_count" value="<?= (isset($row['customer_orders_count'])) ? $row['customer_orders_count'] : ''?>"></td>
				</tr>
				<tr>
					<td>{{customer.phone}}</td>
					<td><input type="text" name="customer_phone" value="<?= (isset($row['customer_phone'])) ? $row['customer_phone'] : ''?>"></td>
				</tr>
				<tr>
					<td>
						{{customer.address}}
					</td>
					<td>
						<input type="text" name="customer_address" value="<?= (isset($row['customer_address'])) ? $row['customer_address'] : ''?>">
						<p class="help-block">Mapper for the Section</p>
					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{address.first_name}}</td>
							<td><input type="text" name="address_first_name" value="<?= (isset($row['address_first_name'])) ? $row['address_first_name'] : ''?>"></td>
						</tr>
						<tr>
							<td>{{address.last_name}}</td>
							<td><input type="text" name="address_last_name" value="<?= (isset($row['address_last_name'])) ? $row['address_last_name'] : ''?>"></td>
						</tr>
						<tr>
							<td>{{address.address1}}</td>
							<td><textarea name="address_address1"><?= (isset($row['address_address1'])) ? $row['address_address1'] : ''?></textarea></td>
						</tr>
						<tr>
							<td>{{address.phone}}</td>
							<td><input type="text" name="address_phone" value="<?= (isset($row['address_address1'])) ? $row['address_address1'] : ''?>"></td>
						</tr>
						<tr>
							<td>{{address.city}}</td>
							<td><input type="text" name="address_city" value="<?= (isset($row['address_city'])) ? $row['address_city'] : ''?>"></td>
						</tr>
						<tr>
							<td>{{address.province}}</td>
							<td><input type="text" name="address_province" value="<?= (isset($row['address_province'])) ? $row['address_province'] : ''?>"></td>
						</tr>
						<tr>
							<td>{{address.country}}</td>
							<td><input type="text" name="address_country" value="<?= (isset($row['address_country'])) ? $row['address_country'] : ''?>"></td>
						</tr>
						<tr>
							<td>{{address.name}}</td>
							<td><input type="text" name="address_name" value="<?= (isset($row['address_name'])) ? $row['address_name'] : ''?>"></td>
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