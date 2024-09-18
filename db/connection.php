<?php
    $hostName = "localhost";
    $userName = "root";
    $userPassword = "@stephen12#xampp";
    $db_name = "zed";


    define("MYSQL_CONN_ERROR", "Unable to connect to database.");

// Ensure reporting is setup correctly
mysqli_report(MYSQLI_REPORT_STRICT);

// Connect function for database access
function connect($hostName,$userName,$userPassword,$db_name) {
   try {
      $mysqli = new mysqli($hostName,$userName,$userPassword,$db_name);
      $connected = true;
   } catch (mysqli_sql_exception $e) {
      throw $e;
   }
}

try {
  connect($hostName,$userName,$userPassword,$db_name);
  echo 'Connected to database';
} catch (Exception $e) {
  echo $e->errorMessage();
}
?>