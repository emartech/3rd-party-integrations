<?php

require_once 'config.php';
require_once 'database.php';

class SuiteApi
{
    private
        $_username,
        $_secret,
        $_suiteApiUrl;

    public function __construct($username, $secret, $suiteApiUrl = 'https://api.emarsys.net/api/v2/')
    {
        $this->_username = $username;
        $this->_secret = $secret;
        $this->_suiteApiUrl = $suiteApiUrl;
    }

    public function send($requestType, $endPoint, $requestBody = '')
    {
        if (!in_array($requestType, array('GET', 'POST', 'PUT', 'DELETE'))) {
            throw new Exception('Send first parameter must be "GET", "POST", "PUT" or "DELETE"');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        switch ($requestType)
        {
            case 'GET':
               curl_setopt($ch, CURLOPT_HTTPGET, 1);
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
                break;
        }
        curl_setopt($ch, CURLOPT_HEADER, false);

        $requestUri = $this->_suiteApiUrl . $endPoint;
        curl_setopt($ch, CURLOPT_URL, $requestUri);

        /**
         * We add X-WSSE header for authentication.
         * Always use random 'nonce' for increased security.
         * timestamp: the current date/time in UTC format encoded as
         *   an ISO 8601 date string like '2010-12-31T15:30:59+00:00' or '2010-12-31T15:30:59Z'
         * passwordDigest looks sg like 'MDBhOTMwZGE0OTMxMjJlODAyNmE1ZWJhNTdmOTkxOWU4YzNjNWZkMw=='
         */
        $nonce = 'd36e316282959a9ed4c89851497a717f';
        $timestamp = gmdate("c");
        $passwordDigest = base64_encode(sha1($nonce . $timestamp . $this->_secret, false));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-WSSE: UsernameToken ' .
                'Username="'.$this->_username.'", ' .
                'PasswordDigest="'.$passwordDigest.'", ' .
                'Nonce="'.$nonce.'", ' .
                'Created="'.$timestamp.'"',
            'Content-type: application/json',
            )
        );
        // 'Content-type: application/json;charset=\"utf-8\"',

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
}

// $emarsyClient = new SuiteApi('shopify_synapse_integration001', 'yKGF6saTd98F9rpUC3gW');


$shop = (isset($_SESSION['shop'])) ? $_SESSION['shop'] : $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];

$query = "SELECT * FROM `emarsys_credentials` WHERE `store_name` = '" . trim($shop) . "'";

$result = $con->query($query);

if($result->num_rows > 0){
  $row = $result->fetch_assoc();
  // emarsy api connection ---------------
  $emarsyClient = new SuiteApi($row['emarsys_username'], $row['emarsys_password']);
}


