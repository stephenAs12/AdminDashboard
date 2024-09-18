<?php

$connection = new mysqli('localhost', 'root', '@stephen12#xampp', 'zed');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$receiverFname = 'check';
$sqlQuery = "INSERT INTO office_type(office_type_name) VALUES('$receiverFname')";

if ($connection->query($sqlQuery) === TRUE) {
    echo "Last inserted ID is: " . $connection->insert_id;
} else {
    echo "Error: " . $sqlQuery . "<br>" . $connection->error;
}

$connection->close();
?>
