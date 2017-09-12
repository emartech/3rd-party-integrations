<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../ShopifyAPI/ShopifyClient.php';
require_once '../config.php';
require_once '../emarsys.php';
require_once '../database.php';

$sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);

$themes = $sc->call('GET', '/admin/themes.json');
$query = "SELECT * FROM `emarsys_credentials` WHERE `store_name` = '" . $_SESSION['shop'] . "'";
$result = $con->query($query);
$merchant_id = '';
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
	$merchant_id = $row['emarsys_merchant_id'];
}
switch (true) {
	case ($_GET['id'] == 1):
		
		if(!empty($merchant_id)){
			$fileContent = file_get_contents('./Snippet/shopify9545.php');
			$fileContent = str_replace('#MERCHANT_ID#', $merchant_id, $fileContent);
			foreach ($themes as $theme) {
				$test = '/admin/themes/' . $theme['id'] . '/assets.json';
				$layout = $sc->call('GET', '/admin/themes/' . $theme['id'] . '/assets.json?asset[key]=layout/theme.liquid&theme_id=' . $theme['id']);
				$findIn = $layout['value'];
				$output = strpos($findIn, "{% include 'shopify9545' %}");
				if($output === false){
					$findIn = str_replace('</body>', "{% include 'shopify9545' %}</body>", $findIn);
					$newlayout = $sc->call('PUT', '/admin/themes/' . $theme['id'] . '/assets.json', ['asset' => [
			            'key' => 'layout/theme.liquid',
			            'value' => $findIn
			        ]]);
			        $assetsNew = $sc->call('PUT', '/admin/themes/' . $theme['id'] . '/assets.json', ['asset' => [
			            'key' => 'snippets/shopify9545.liquid',
			            'value' => $fileContent
			        ]]);
			        $_SESSION['message'] = 'Module Installed Successfully!';
				}
			}
		}

		break;
	
	case ($_GET['id'] == 0):
		
		foreach ($themes as $theme) {
			$test = '/admin/themes/' . $theme['id'] . '/assets.json';
			$layout = $sc->call('GET', '/admin/themes/' . $theme['id'] . '/assets.json?asset[key]=layout/theme.liquid&theme_id=' . $theme['id']);
			$findIn = $layout['value'];
			$output = strpos($findIn, "{% include 'shopify9545' %}");
			if($output !== false){
				$findIn = str_replace("{% include 'shopify9545' %}", "", $findIn);
				$newlayout = $sc->call('PUT', '/admin/themes/' . $theme['id'] . '/assets.json', ['asset' => [
		            'key' => 'layout/theme.liquid',
		            'value' => $findIn
		        ]]);
		        $assetsNew = $sc->call('DELETE', '/admin/themes/' . $theme['id'] . '/assets.json?asset[key]=snippets/shopify9545.liquid');
		        $_SESSION['message'] = 'Module Removed Successfully!';
			}
		}

		break;
}

header('Location: ../web_extend.php');

