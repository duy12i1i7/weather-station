<!DOCTYPE html>
<html><body>
<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "u600571215_esp_data";
// REPLACE with Database user
$username = "u600571215_esp_board";
// REPLACE with Database user password
$password = "sontungMTP.123";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id,	location, rain,	Temperature_DHT, Humidity_DHT, Temperature_BMP,	Pressure_BMP, Altitude_BMP,	Altitude_real_BMP, reading_time FROM SensorData ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>Location</td> 
        <td>Rain</td> 
        <td>Temperature_DHT</td>
        <td>Humidity_DHT</td> 
        <td>Temperature_BMP</td>
        <td>Pressure_BMP</td>
        <td>Altitude_BMP</td>
        <td>Altitude_real_BMP</td>
        <td>Timestamp</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_location = $row["location"];
        $row_rain = $row["rain"];
        $row_Temperature_DHT = $row["Temperature_DHT"]; 
        $row_Humidity_DHT = $row["Humidity_DHT"]; 
        $row_Temperature_BMP = $row["Temperature_BMP"];
        $row_Pressure_BMP = $row["Pressure_BMP"];
        $row_Altitude_BMP = $row["Altitude_BMP"];
        $row_Altitude_real_BMP = $row["Altitude_real_BMP"];
        $row_reading_time = $row["reading_time"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_location . '</td> 
                <td>' . $row_rain . '</td> 
                <td>' . $row_Temperature_DHT . '</td>
                <td>' . $row_Humidity_DHT . '</td> 
                <td>' . $row_Temperature_BMP . '</td> 
                <td>' . $row_Pressure_BMP . '</td> 
                <td>' . $row_Altitude_BMP . '</td> 
                <td>' . $row_Altitude_real_BMP . '</td> 
                <td>' . $row_reading_time . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>