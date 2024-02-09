<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "u600571215_esp_data";
// REPLACE with Database user
$username = "u600571215_esp_board";
// REPLACE with Database user password
$password = "sontungMTP.123";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $location = $rain = $Temperature_DHT = $Humidity_DHT = $Temperature_BMP = $Pressure_BMP = $Altitude_BMP = $Altitude_real_BMP = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $location = test_input($_POST["location"]);
        $rain = test_input($_POST["rain"]);
        $Temperature_DHT = test_input($_POST["Temperature_DHT"]);
        $Humidity_DHT = test_input($_POST["Humidity_DHT"]);
        $Temperature_BMP = test_input($_POST["Temperature_BMP"]);
        $Pressure_BMP = test_input($_POST["Pressure_BMP"]);
        $Altitude_BMP = test_input($_POST["Altitude_BMP"]);
        $Altitude_real_BMP = test_input($_POST["Altitude_real_BMP"]);
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO SensorData (location, rain, Temperature_DHT, Humidity_DHT, Temperature_BMP, Pressure_BMP, Altitude_BMP, Altitude_real_BMP)
        VALUES ('" . $location . "', '" . $rain . "', '" . $Temperature_DHT . "', '" . $Humidity_DHT . "', '" . $Temperature_BMP . "', '" . $Pressure_BMP . "', '" . $Altitude_BMP . "', '" . $Altitude_real_BMP . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}