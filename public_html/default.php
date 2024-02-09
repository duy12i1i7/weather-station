<!DOCTYPE html>
<html>
<head>
<title>Tran Ha Zang</title>
</head>
<style>
@import url(https://fonts.googleapis.com/css?family=Montserrat);
@import url(https://fonts.googleapis.com/css?family=Advent+Pro:400,200);
*{margin: 0;padding: 0;}

body{
  background:#544947;
  font-family:Montserrat,Arial,sans-serif;
}
h2{
  font-size:14px;
}
.widget{
  box-shadow:0 40px 10px 5px rgba(0,0,0,0.4);
  margin:100px auto;
  height: 330px;
  position: relative;
  width: 500px;
}

.upper{
  border-radius:5px 5px 0 0;
  background:#f5f5f5;
  height:200px;
  padding:20px;
}

.date{
  font-size:40px;
}
.year{
  font-size:30px;
  color:#c1c1c1;
}
.place{
  color:#222;
  font-size:40px;
}
.lower{
  background:#00A8A9;
  border-radius:0 0 5px 5px;
  font-family:'Advent Pro';
  font-weight:200;
  height:250px;
  width:100%;
}
.clock{
  background:#00A8A9;
  border-radius:100%;
  box-shadow:0 0 0 15px #f5f5f5,0 10px 10px 5px rgba(0,0,0,0.3);
  height:150px;
  position:absolute;
  right:25px;
  top:-35px;
  width:150px;
}

.hour{
  background:#f5f5f5;
  height:50px;
  left:50%;  
  position: absolute;
  top:25px;
  width:4px;
}

.min{
  background:#f5f5f5;
  height:65px;
  left:50%;  
  position: absolute;
  top:10px;
  transform:rotate(100deg);
  width:4px;
}

.min,.hour{
  border-radius:5px;
  transform-origin:bottom center;
  transition:all .5s linear;
}

.infos{
  list-style:none;
}
.info{
  color:#fff;
  float:left;
  height:100%;
  padding-top:10px;
  text-align:center;
  width:25%;
}
.info span{
  display: inline-block;
  font-size:40px;
  margin-top:20px;
}
.weather p {
  font-size:20px;padding:10px 0;
}
.anim{animation:fade .8s linear;}

@keyframes fade{
  0%{opacity:0;}
  100%{opacity:1;}
}

a{
 text-align: center;
 text-decoration: none;
 color: white;
 font-size: 15px;
 font-weight: 500;
}
</style>
<body>

<div class="widget"> 
  <div class="clock">
    <div class="min" id="min"></div>
    <div class="hour" id="hour"></div>
  </div>
  <div class="upper">
    <div class="date" id="date">21 March</div>
    <div class="year">Temperature</div>
    <div class="place update" id="temperature">0 &deg;C</div>
  </div>
  <div style="text-align: center;"><a href="Tran Ha Giang" style="align:center">Tran Ha Giang</a></div>
  <div class="lower">    
    <ul class="infos">
      <!-- Display all the data from the "data" variable here -->
      <li class="info temp">
        <h2 class="title">RAIN</h2>
        <span class='update' id="rain">0</span>
      </li>
      <li class="info temp">
        <h2 class="title">DHT TEMPERATURE</h2>
        <span class='update' id="dht_temp">0 &deg;C</span>
      </li>
      <li class="info humidity">
        <h2 class="title">DHT HUMIDITY</h2>
        <span class='update' id="dht_humidity">0%</span>
      </li>
      <li class="info temp">
        <h2 class="title">BMP TEMPERATURE</h2>
        <span class='update' id="bmp_temp">0 &deg;C</span>
      </li>
      <li class="info weather">
        <h2 class="title">BMP PRESSURE</h2>
        <span class="update" id="bmp_pressure">0 Pa</span>
      </li>
      <li class="info wind">
        <h2 class="title">BMP ALTITUDE</h2>
        <span class='update' id="bmp_altitude">0 meters</span>
      </li>
      <li class="info wind">
        <h2 class="title">BMP REAL ALTITUDE</h2>
        <span class='update' id="bmp_real_altitude">0 meters</span>
      </li>
    </ul>
  </div>
</div>

<script>
setInterval(drawClock, 2000);
    
function drawClock(){
    var now = new Date();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    
    //Date
    var options = {year: 'numeric', month: 'long', day: 'numeric' };
	  var today  = new Date();
    document.getElementById("date").innerHTML = today.toLocaleDateString("en-US", options);
    
    //hour
    var hourAngle = (360*(hour/12))+((360/12)*(minute/60));
    var minAngle = 360*(minute/60);
    document.getElementById("hour").style.transform = "rotate("+(hourAngle)+"deg)";
    //minute
    document.getElementById("min").style.transform = "rotate("+(minAngle)+"deg)";
}

function fetchWeatherData() {
  fetch('https://tranhazang.site/get_data.php')
    .then((response) => response.json())
    .then((data) => {
      // Update the weather data on the frontend with the fetched data
      document.getElementById("rain").innerHTML = data[0].rain;
      document.getElementById("temperature").innerHTML = Math.round(data[0].Temperature_BMP) + "&deg;C";
      document.getElementById("dht_temp").innerHTML = Math.round(data[0].Temperature_DHT) + "&deg;C";
      document.getElementById("dht_humidity").innerHTML = Math.round(data[0].Humidity_DHT) + "%";
      document.getElementById("bmp_temp").innerHTML = Math.round(data[0].Temperature_BMP) + "&deg;C";
      document.getElementById("bmp_pressure").innerHTML = Math.round(data[0].Pressure_BMP) + " Pa";
      document.getElementById("bmp_altitude").innerHTML = Math.round(data[0].Altitude_BMP) + " meters";
      document.getElementById("bmp_real_altitude").innerHTML = Math.round(data[0].Altitude_real_BMP) + " meters";
    })
    .catch((error) => {
      console.error('Error fetching data from backend:', error);
    });
}

setInterval(fetchWeatherData, 2000);

</script>
</body>
</html>