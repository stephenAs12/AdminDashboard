<?php

$connection = new mysqli('localhost', 'root', '@stephen12#xampp', 'zed');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Sanitize and assign POST data
$receiverFname = isset($_POST['w_fname']) ? $_POST['w_fname'] : '';
$receiverLname = isset($_POST['w_lname']) ? $_POST['w_lname'] : '';
$receiverPhone = isset($_POST['w_pnumber']) ? $_POST['w_pnumber'] : '';
$receiverState = isset($_POST['w_state']) ? $_POST['w_state'] : '';
$receiverCity = isset($_POST['w_city']) ? $_POST['w_city'] : '';
$receiverOffice = isset($_POST['w_office']) ? $_POST['w_office'] : '';
$deliveryDate = isset($_POST['w_date']) ? $_POST['w_date'] : '';

// Prepare and execute the receiver insert query
$sqlQuery = $connection->prepare("INSERT INTO receiver (receiver_fname, receiver_lname, receiver_phone, receiver_state, receiver_city, receiver_office, delivery_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
if ($sqlQuery === false) {
    die("Error preparing statement: " . $connection->error);
}
$sqlQuery->bind_param("sssssss", $receiverFname, $receiverLname, $receiverPhone, $receiverState, $receiverCity, $receiverOffice, $deliveryDate);

$response_result = false;

if ($sqlQuery->execute()) {
    $receiverInfo = $connection->insert_id;
    $response_result = true;

    // Prepare the item insert query
    $itemQuery = $connection->prepare("INSERT INTO item (order_id, sender_info, receiver_info, item_type, measured_in, weight, quantity, name, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($itemQuery === false) {
        die("Error preparing statement: " . $connection->error);
    }

    foreach ($_POST['w_item_type'] as $key => $value) {
        $orderNumber = 'Lam' . rand(1000, 9999);
        $senderId = $_POST['w_sender_id'];
        $receiverId = $receiverInfo;
        $measuredIn = 'w';
        $weight = $_POST['w_weight'][$key];
        $quantity = $_POST['w_quantity'][$key];
        $item_name = $_POST['w_item_name'][$key];

        // type initial and rate value
        $type_stmt = $connection->prepare("SELECT * FROM item_type WHERE type_id = ?");
        $type_stmt->bind_param("i", $type_id);
        $type_id = $value;
        $type_stmt->execute();
        $type_result = $type_stmt->get_result();

        $type_initial = 0;
        $type_rate = 0;

        if ($type_result->num_rows > 0) {
            while ($type_row = $type_result->fetch_assoc()) {
                $type_initial = $type_row["initial"];
                $type_rate = $type_row["rate"];
            }
        } else {
            echo "0 results";
        }

        // city distance and distance rate
        $city_stmt = $connection->prepare("SELECT * FROM city WHERE city_id = ?");
        $city_stmt->bind_param("i", $city_id);
        $city_id = $receiverCity;
        $city_stmt->execute();
        $city_result = $city_stmt->get_result();

        $city_distance = 0;
        $distance_rate = 0;

        if ($city_result->num_rows > 0) {
            while ($city_row = $city_result->fetch_assoc()) {
                $city_distance = $city_row["distance"];
                $distance_rate = $city_row["distance_rate"];
            }
        } else {
            echo "0 results";
        }

        $total_price = calculate($type_initial, $type_rate, $weight, $quantity, $city_distance, $distance_rate);

        $itemQuery->bind_param('sssssssss', $orderNumber, $senderId, $receiverId, $value, $measuredIn, $weight, $quantity, $item_name, $total_price);

        if (!$itemQuery->execute()) {
            $response_result = false;
            echo "Error: " . $itemQuery->error . "<br>";
        }
    }
} else {
    $response_result = false;
    echo "Error: " . $sqlQuery->error . "<br>";
}

$sqlQuery->close();
$itemQuery->close();
$connection->close();

echo $response_result;



// calculation function 

function calculate($TypeInitial, $TypeRate, $Weight, $Quantity, $CityDistance, $DistanceRate)
{
    $weightCase = $Weight * $TypeRate;
    $distanceCase = $CityDistance * $DistanceRate;
    $totalPrice = $TypeInitial + $weightCase + $distanceCase;
    return $totalPrice * $Quantity;
}
