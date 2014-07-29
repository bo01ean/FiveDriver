<!DOCTYPE html>
<html>
<head>
<style>
    #tripmeter {
        border: 1px solid grey;
        padding: 10px;
        margin: 10px 0;
    }
    p {
        color: #222;
        font: 14px Arial;
    }
    span {
        color: #00C;
    }
</style>
    <script src="http://modernizr.com/downloads/modernizr-latest.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/apps/fiveDriver/js/app.js"></script>
</head>
<body>
<div id="tripmeter">

    <p>
        Starting Location (lat, lon):<br/>
        <span id="startLat">???</span>&deg;, <span id="startLon">???</span>&deg;
    </p>
    <p>
        Current Location (lat, lon):<br/>
        <span id="currentLat">???</span>&deg;, <span id="currentLon">???</span>&deg;
    </p>
    <p>
        Distance from starting location:<br/>
        <span id="distance">0</span> km
    </p></div><script>

    var version = ".1";
    var UID = null;
    var currentTrip = {};

    if (Modernizr.localstorage) {//http://diveintohtml5.info/storage.html
        localStorage.setItem("fiveDriver", version);
        if(localStorage.getItem("UID") == null) {
            localStorage.setItem("UID",createUID(3));
        }
        UID = localStorage.getItem("UID");
    } else {
        alert("Your browser does not support the features required to play planning poker:( Get Chrome or the Fox");
    }

    console.log("UID: " + localStorage.getItem("UID"));

    var gpsOptions = {
        enableHighAccuracy: false,
        timeout: 500,
        maximumAge: 0
    };

    window.onload = function() {

        var startPos;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                startPos = position;
                document.getElementById("startLat").innerHTML = startPos.coords.latitude;
                document.getElementById("startLon").innerHTML = startPos.coords.longitude;
            }, function(error) {
                alert("Error occurred. Error code: " + error.code);
                // error.code can be:
                //   0: unknown error
                //   1: permission denied
                //   2: position unavailable (error response from locaton provider)
                //   3: timed out
            });

            navigator.geolocation.watchPosition(function(position) {

                var now = new Date().getTime();
                var tmpObj = {};
                tmpObj.stamp = now;
                tmpObj.lat = position.coords.latitude;
                tmpObj.lon = position.coords.longitude;
                tmpObj.distance = calculateDistance(startPos.coords.latitude, startPos.coords.longitude,
                    position.coords.latitude, position.coords.longitude);

                document.getElementById("currentLat").innerHTML = tmpObj.lat;
                document.getElementById("currentLon").innerHTML = tmpObj.lon;
                document.getElementById("distance").innerHTML = tmpObj.distance;
                console.log(tmpObj);

            }, function(){ console.log('fail')}, gpsOptions);//https://developer.mozilla.org/en-US/docs/Web/API/Geolocation.watchPosition
        }
    };
</script>
</body>
</html>