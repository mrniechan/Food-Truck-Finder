<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_truck_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT name, latitude, longitude, menu, schedule FROM food_trucks";
$result = $conn->query($sql);

$trucks = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $trucks[] = $row;
    }
}

echo json_encode($trucks);

$conn->close();
?>
