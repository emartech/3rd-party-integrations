<?php

define('db_hostname', '');

define('db_username', '');

define('db_password', '');

define('db_name', '');

$con = mysqli_connect(db_hostname, db_username, db_password, db_name);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>