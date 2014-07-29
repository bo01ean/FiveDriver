<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style>
        html { height: 50% }
        body { height: 100%; margin: 0; padding: 0 }
        #map-canvas { height: 100% }

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
    <script src="//modernizr.com/downloads/modernizr-latest.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/apps/fiveDriver/js/app.js"></script>
    <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyC0p2CXXzNyDGT3TB8fLsbkYmwzQmUi2eQ"></script>
    <script type="text/javascript">
        var mapOptions = {};
        var map = {};
        var version = ".1";
        var UID = null;
        var currentTrip = {};
        var gpsOptions = {
            enableHighAccuracy: false,
            //timeout: 500,
            maximumAge: 0
        };

        var route = [];


        function errorHandler(error) {
            console.log("Error occurred. Error code: " + error.code + " " + error.message);
        }

        window.onload = function() {
            mapOptions = {
                center: new google.maps.LatLng(32.750721399999996, -117.17515869999998),
                zoom: 8
            };

            map = new google.maps.Map(document.getElementById("map-canvas"),
                mapOptions);

            if (Modernizr.localstorage) {//http://diveintohtml5.info/storage.html
                localStorage.setItem("fiveDriver", version);
                if(localStorage.getItem("UID") == null) {
                    localStorage.setItem("UID",createUID(3));
                }
                UID = localStorage.getItem("UID");
            } else {
                alert("You might need to upgrade your browser for this to work.");
            }

            console.log("UID: " + localStorage.getItem("UID"));

            var startPos;

            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(loc) {
                    startPos = loc;
                    document.getElementById("startLat").innerHTML = startPos.coords.latitude;
                    document.getElementById("startLon").innerHTML = startPos.coords.longitude;
                }, errorHandler);

                var wpid = navigator.geolocation.watchPosition(function(position) {

                    var now = new Date().getTime();
                    var tmpObj = {};
                    tmpObj.stamp = now;
                    tmpObj.lat = position.coords.latitude;
                    tmpObj.lon = position.coords.longitude;
                    tmpObj.distance = calculateDistance(
                        startPos.coords.latitude, startPos.coords.longitude,
                        position.coords.latitude, position.coords.longitude
                    );

                    route.push(new google.maps.LatLng(tmpObj.lat, tmpObj.lon));

                    console.log(route);

                    var drivingRoute = new google.maps.Polyline({
                        path: route,
                        geodesic: true,
                        strokeColor: '#FF0000',
                        strokeOpacity: 1.0,
                        strokeWeight: 2
                    });

                    drivingRoute.setMap(map);

                    document.getElementById("currentLat").innerHTML = tmpObj.lat;
                    document.getElementById("currentLon").innerHTML = tmpObj.lon;
                    document.getElementById("distance").innerHTML = tmpObj.distance;

                    console.log(tmpObj);

                }, errorHandler, gpsOptions);//https://developer.mozilla.org/en-US/docs/Web/API/Geolocation.watchPosition
            }
        };
    </script>
</head>
<body>
<div id="map-canvas" style="width: 100%; height: 100%"></div>
<div id="tripmeter">
    <p>Starting Location (lat, lon):<br/>
        <span id="startLat">???</span>&deg;, <span id="startLon">???</span>&deg;</p>
    <p>Current Location (lat, lon):<br/>
        <span id="currentLat">???</span>&deg;, <span id="currentLon">???</span>&deg;</p>
    <p>Distance from starting location:<br/><span id="distance">0</span> km</p>
</div>
</body>
</html>