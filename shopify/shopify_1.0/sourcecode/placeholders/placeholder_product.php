<?php
$query = "SELECT * FROM `emarsys_product_placeholders` WHERE fkShopifyEventID = ' " . $_GET['id'] . "'";
$result = $con->query($query);
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
}
if(isset($_POST['submit'])){
	$query = "INSERT INTO `emarsys_product_placeholders` (pkProductPlaceholderID, fkShopifyEventID, store_name, product_id, product_title, product_product_type, product_variants, variants_id, variants_product_id, variants_title, variants_price, variants_sku, product_images, image_id, image_product_id, image_src, product_image) VALUE ";
	$record_id = (isset($_POST['record_id'])) ? $_POST['record_id'] : '';
	$query .= "('" . $record_id .  "', '" . $_GET['id'] .  "', '" . $_SESSION['shop'] .  "', '" . $_POST['product_id'] . "', '" . $_POST['product_title'] . "', '" . $_POST['product_product_type'] . "', '" . $_POST['product_variants'] . "', '" . $_POST['variants_id'] . "', '" . $_POST['variants_product_id'] . "', '" . $_POST['variants_title'] . "', '" . $_POST['variants_price'] . "', '" . $_POST['variants_sku'] . "', '" . $_POST['product_images'] . "', '" . $_POST['image_id'] . "', '" . $_POST['image_product_id'] . "', '" . $_POST['image_src'] . "', '" . $_POST['product_image'] . "')";
	$query .= " ON DUPLICATE KEY UPDATE product_id=VALUES(product_id), product_title=VALUES(product_title), product_product_type=VALUES(product_product_type), product_variants=VALUES(product_variants), variants_id=VALUES(variants_id), variants_product_id=VALUES(variants_product_id), variants_title=VALUES(variants_title), variants_price=VALUES(variants_price), variants_sku=VALUES(variants_sku), product_images=VALUES(product_images), image_id=VALUES(image_id), image_product_id=VALUES(image_product_id), image_src=VALUES(image_src), product_image=VALUES(product_image);";
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
					<input type="hidden" name="record_id" value="<?= $row['pkProductPlaceholderID']?>">
				<?php endif; ?>
				<tr>
				    <td>{{product.id}}</td>
				    <td><input type="text" name="product_id" value="<?= (isset($row['product_id'])) ? $row['product_id'] : '';?>"></td>
				</tr>
				<tr>
				    <td>{{product.title}}</td>
				    <td><input type="text" name="product_title" value="<?= (isset($row['product_title'])) ? $row['product_title'] : '';?>"></td>
				</tr>
				<tr>
				    <td>{{product.product_type}}</td>
				    <td><input type="text" name="product_product_type" value="<?= (isset($row['product_product_type'])) ? $row['product_product_type'] : '';?>"></td>
				</tr>
				<tr>
					<td>
						{{product.variants}}
					</td>
					<td>
						<input type="text" name="product_variants" value="<?= (isset($row['product_variants'])) ? $row['product_variants'] : '';?>">
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{variants.id}}</td>
							<td><input type="text" name="variants_id" value="<?= (isset($row['variants_id'])) ? $row['variants_id'] : '';?>"></td>
						</tr>
						<tr>
							<td>{{variants.product_id}}</td>
							<td><input type="text" name="variants_product_id" value="<?= (isset($row['variants_product_id'])) ? $row['variants_product_id'] : '';?>"></td>
						</tr>
						<tr>
							<td>{{variants.title}}</td>
							<td><input type="text" name="variants_title" value="<?= (isset($row['variants_title'])) ? $row['variants_title'] : '';?>"></td>
						</tr>
						<tr>
							<td>{{variants.price}}</td>
							<td><input type="text" name="variants_price" value="<?= (isset($row['variants_price'])) ? $row['variants_price'] : '';?>"></td>
						</tr>
						<tr>
							<td>{{variants.sku}}</td>
							<td><input type="text" name="variants_sku" value="<?= (isset($row['variants_sku'])) ? $row['variants_sku'] : '';?>"></td>
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
						{{product.images}}
					</td>
					<td>
						<input type="text" name="product_images" value="<?= (isset($row['product_images'])) ? $row['product_images'] : '';?>">
						<p class="help-block">Mapper for the Section</p>

					<table class="table table-striped">
						<thead>
							<tr><td colspan="2"><p>{{segement start}}</p></td></tr>
						</thead>
						<tbody>
						<tr>
							<td>{{image.id}}</td>
							<td><input type="text" name="image_id" value="<?= (isset($row['image_id'])) ? $row['image_id'] : '';?>"></td>
						</tr>
						<tr>
							<td>{{image.product_id}}</td>
							<td><input type="text" name="image_product_id" value="<?= (isset($row['image_product_id'])) ? $row['image_product_id'] : '';?>"></td>
						</tr>
						<tr>
							<td>{{image.src}}</td>
							<td><input type="text" name="image_src" value="<?= (isset($row['image_src'])) ? $row['image_src'] : '';?>"></td>
						</tr>
						</tbody>
						<tfoot>
							<tr><td colspan="2"><p>{{segement end}}</p></td></tr>
						</tfoot>
					</table>
					</td>
				</tr>	
				<tr>
				    <td>{{product.image}}</td>
				    <td><input type="text" name="product_image" value="<?= (isset($row['product_image'])) ? $row['product_image'] : '';?>"></td>
				</tr>
				<!-- <tr>
				    <td>{{product.}}</td>
				    <td><input type="text" name="product_"></td>
				</tr> -->
				<tr class="text-center">
					<td colspan="3" class="text-center"><button type="submit" name="submit" class="btn btn-default">Save</button></td>
				</tr>
		</form>
	</tbody>
</table>