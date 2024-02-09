CREATE TABLE SensorData (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(30) NOT NULL,
    rain VARCHAR(5),
    Temperature_DHT VARCHAR(10),
    Humidity_DHT VARCHAR(10),
    Temperature_BMP VARCHAR(10),
    Pressure_BMP VARCHAR(10),
    Altitude_BMP VARCHAR(10),
    Altitude_real_BMP VARCHAR(10),
    reading_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)