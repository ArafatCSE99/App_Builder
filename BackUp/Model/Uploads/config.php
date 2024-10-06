<?php
/*
 * Site : http:www.smarttutorials.net
 * Author :muni
 * 
 */
 
define('BASE_PATH','http://localhost/ajax1/');
define('DB_HOST', 'localhost');
define('DB_NAME','image_ajax');
define('DB_USER','root');
define('DB_PASSWORD','');

$con=mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>