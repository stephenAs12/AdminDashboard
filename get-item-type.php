
<?php

$conn = mysqli_connect("localhost", "root", "@stephen12#xampp", "zed");

if ($conn === false) {
    die("ERROR: Could not connect. "
        . mysqli_connect_error());
}
$item_type_result = mysqli_query($conn, "SELECT * FROM item_type");

?>