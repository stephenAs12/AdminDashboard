
<?php

$conn = mysqli_connect("localhost", "root", "@stephen12#xampp", "zed");

if ($conn === false) {
    die("ERROR: Could not connect. "
        . mysqli_connect_error());
}

$cityID = $_POST['city_value'];
$office_result = mysqli_query($conn, "SELECT office.office_id, office.office_name FROM office
    INNER JOIN city ON office.office_city=city.city_id WHERE office.office_city=$cityID ORDER BY office.office_name ASC");

echo "<option value='' selected hidden>Select Office *</option>";
while ($office_row = mysqli_fetch_array($office_result)) {
    echo "<option value='$office_row[office_id]'>$office_row[office_name]</option>";
}


?>