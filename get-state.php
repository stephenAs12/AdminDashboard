
<?php

$conn = mysqli_connect("localhost", "root", "@stephen12#xampp", "zed");

if ($conn === false) {
    die("ERROR: Could not connect. "
        . mysqli_connect_error());
}

$countryID = 1;
$state_result = mysqli_query($conn, "SELECT state_r.state_id, state_r.state_name FROM state_r
    INNER JOIN country ON state_r.state_country=country.country_id WHERE state_r.state_country=$countryID");

echo "<option value='' selected hidden>Select State *</option>";
while ($state_row = mysqli_fetch_array($state_result)) {
    echo "<option value='$state_row[state_id]'>$state_row[state_name]</option>";
}


?>