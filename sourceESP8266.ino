#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClientSecureBearSSL.h>
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BMP085.h>
#include "DHT.h"

#define APP_DEBUG
#define USE_NODE_MCU_BOARD


#define DHTPIN 14
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

Adafruit_BMP085 bmp;  // I2C

int rainSensor = 16;


const char* ssid     = "P403";
const char* password = "sontungmtp";


const char* serverName = "https://tranhazang.site/post-esp-data.php";

// Keep this API Key value to be compatible with the PHP code provided in the project page. 
// If you change the apiKeyValue value, the PHP file /post-esp-data.php also needs to have the same key 
String apiKeyValue = "tPmAT5Ab3j7F9";


String sensorLocation = "MCUZang";



#define SEALEVELPRESSURE_HPA (1013.25)




void setup() {
  Serial.begin(115200);
  delay(1000);


  pinMode(rainSensor,INPUT);
  dht.begin();
  delay(1000);


  WiFi.begin(ssid, password);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  // (you can also pass in a Wire library object like &Wire2)
  bool status = bmp.begin();
  if (!status) {
    Serial.println("Could not find a valid BMP085 sensor, check wiring!");
    while (1);
  }
}

void loop() {
    int rain ;
    if (digitalRead(rainSensor) == HIGH) rain =0;
    else rain =1;
  //Check WiFi connection status
  if(WiFi.status()== WL_CONNECTED){

    std::unique_ptr<BearSSL::WiFiClientSecure>client(new BearSSL::WiFiClientSecure);

    // Ignore SSL certificate validation
    client->setInsecure();
    
    //create an HTTPClient instance
    HTTPClient https;
    
    // Your Domain name with URL path or IP address with path
    https.begin(*client, serverName);
    
    // Specify content-type header
    https.addHeader("Content-Type", "application/x-www-form-urlencoded");
    
    // Prepare your HTTP POST request data
    String httpRequestData = "api_key=" + apiKeyValue + 
                            "&location=" + sensorLocation + 
                            "&rain=" + String(rain) + 
                            "&Temperature_DHT=" + String(dht.readTemperature()) + 
                            "&Humidity_DHT=" + String(dht.readHumidity())  + 
                            "&Temperature_BMP=" + String(bmp.readTemperature())  + 
                            "&Pressure_BMP=" + String(bmp.readPressure())  + 
                            "&Altitude_BMP=" + String(bmp.readAltitude())  + 
                            "&Altitude_real_BMP=" + String(bmp.readAltitude(101500))  + 
                            "";
    Serial.print("httpRequestData: ");
    Serial.println(httpRequestData);
    

    // Send HTTP POST request
    int httpResponseCode = https.POST(httpRequestData);
     

        
    if (httpResponseCode>0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    // Free resources
    https.end();
  }
  else {
    Serial.println("WiFi Disconnected");
  }
  //Send an HTTP POST request every 30 seconds
  delay(30000);  
}