<?php

$connect =  mysqli_connect('localhost', 'root', '@stephen12#xampp', 'zed');

$senderFname = ($_POST['fname']) ? $_POST['fname'] : '';
$senderLname  = ($_POST['lname']) ? $_POST['lname'] : '';
$senderPhone  = ($_POST['pnumber']) ? $_POST['pnumber'] : '';
$senderState = ($_POST['state']) ? $_POST['state'] : '';
$senderCity = ($_POST['city']) ? $_POST['city'] : '';
// $senderOffice = $_SESSION['user_office_id'];
$senderOffice = 4;

$sql = "INSERT INTO sender(sender_fname, sender_lname, sender_phone, sender_state, sender_city, sender_office) VALUES('$senderFname', '$senderLname', '$senderPhone', '$senderState', '$senderCity', '$senderOffice')";

if (mysqli_query($connect, $sql)) {
    echo true;
} else {
    echo mysqli_error($connect);
}
