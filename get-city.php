
<?php

$conn = mysqli_connect("localhost", "root", "@stephen12#xampp", "zed");

if ($conn === false) {
    die("ERROR: Could not connect. "
        . mysqli_connect_error());
}

$stateID = $_POST['state_value'];
$city_result = mysqli_query($conn, "SELECT city.city_id, city.city_name FROM city
    INNER JOIN state_r ON city.city_state=state_r.state_id WHERE city.city_state=$stateID");

echo "<option value='' selected hidden>Select City *</option>";
while ($city_row = mysqli_fetch_array($city_result)) {
    echo "<option value='$city_row[city_id]'>$city_row[city_name]</option>";
}


?>