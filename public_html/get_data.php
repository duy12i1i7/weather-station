<?php
$servername = "localhost";
$dbname = "u600571215_esp_data";
$username = "u600571215_esp_board";
$password = "sontungMTP.123";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, location, rain, Temperature_DHT, Humidity_DHT, Temperature_BMP, Pressure_BMP, Altitude_BMP, Altitude_real_BMP, reading_time FROM SensorData ORDER BY id DESC";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
