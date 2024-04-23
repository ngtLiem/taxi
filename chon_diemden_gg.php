<?php
$activate = "index";
@include('header.php');
?>

<script>
    (g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })({
        key: "AIzaSyCOOW03_8zw3SqGt7LSLKNgvIgKZte-U98",
        v: "weekly",
    });
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</script>
<script asyncsrc="h s.googleapis.com/maps/api/js?key=AIzaSyCOOW03_8zw3SqGt7LSLKNgvIgKZte-U98&libraries=places&callback=initMap">
    </script>

<div class="showmap rounded">
    <div id="map" class="map rounded"></div>
    <div class="form-group search-group">
        <div class="d-flex">
            <input type="text" style="font-size: 14px" name="search-box" id="search-box"
                placeholder="Nhập địa điểm muốn đến (hoặc chọn trên bản đồ)" class="form-control">
            <input type="button" value="Xác nhận" id="search-button" class="btn btn-primary px-3 ml-3">
        </div>
    </div>
    <div id="if-gr" class="card rounded p-3 info-group">
        <span class="fw-bolder">Quãng đường: <span id="spanQuangduong" class="text-dark fw-bold"></span> - (khoảng <span
                id="spanThoigian" class="text-dark fw-bold"></span>) </span>
    </div>
    <div id="wp-gr" class="card waypoint-group">
        <ul id="listwp" class="mt-3">
            <!-- append here -->
        </ul>
    </div>
</div>

<script>

const okBtn =document.getElementById('search-button')

const userMakerUrl = 'images/user-maker.png'
const userMakerIC = L.icon({
    iconUrl: userMakerUrl,
    iconSize: [40, 50],
    iconAnchor: [15, 15]
})

var latitude=0;
var longitude=0;
var locateden="";
var latden=0;
var lngden=0;

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        document.getElementById("location").innerHTML = "Trình duyệt của bạn không hỗ trợ định vị.";
    }
}
function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;


    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: latitude, lng: longitude},
          zoom: 13
        });

        var userLatLng = new google.maps.LatLng(latitude, longitude);
        const userMarker = new google.maps.Marker({
            position: userLatLng,
            map,
            title: "Bạn đang ở đây",
        });
        userMarker.setMap(map)

        var input = document.getElementById('search-box');
    
        var autocomplete = new google.maps.places.Autocomplete(input,{
            types: ['establishment'],
            fields: ['place_id', 'geometry', 'name']
        });
        autocomplete.bindTo('bounds', map);
    
        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
        
        var directionsRenderer
        var oldDirectionsDisplay
        var stepDisplay;
        var markerArray = [];

        autocomplete.addListener('place_changed', function() {

            if(oldDirectionsDisplay) {oldDirectionsDisplay.setMap(null)}
            marker.setMap(null)

            infowindow.close();
            if (marker) marker.setMap(null)
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (!place.geometry) {
                // window.alert("Autocomplete's returned place contains no geometry");
                // return;
                input.placeholder = "Nhập dịa điểm muốn đến"
            } else {
                console.log(place.name)
            }
      
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(13);
            }
            marker.setIcon(({
                url: place.icon,
                size: new google.maps.Size(50, 50),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
            oldMarker = marker;
        
            if (directionsRenderer) directionsRenderer.setMap(null)
            const directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                draggable: true,
                map,
                panel: document.getElementById("panel"),
            });

            stepDisplay = new google.maps.InfoWindow();

            origin = new google.maps.LatLng(latitude, longitude);
            destination = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());

            console.log(origin)
            console.log(destination)

            var request = {
                origin: origin,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING
            }

            var kcach = 0
            const if_gr =document.getElementById('if-gr')
            const wp_gr =document.getElementById('wp-gr')
            const listWp =document.getElementById('listwp')
            const sQuangduong =document.getElementById('spanQuangduong')
            const sThoigian =document.getElementById('spanThoigian')
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    var route = response.routes[0];
                    console.log("Khoảng cách: " + route.legs[0].distance.text);
                    console.log("Thời gian: " + route.legs[0].duration.text);

                    if_gr.style.display = "block"
                    wp_gr.style.display = "block"
                    sQuangduong.innerHTML = route.legs[0].distance.text
                    sThoigian.innerHTML = route.legs[0].duration.text
                    
                    var ways = response.routes[0].legs[0]
                    for (var i = 0; i < ways.steps.length; i++) {
                        const li = document.createElement('li')
                        li.classList.add('fs-6')
                        li.innerHTML = ways.steps[i].instructions
                        listWp.appendChild(li)
                        console.log(ways.steps[i].instructions)
                    }

                    directionsDisplay = new google.maps.DirectionsRenderer();
                    directionsDisplay.setMap(map); 
                    directionsDisplay.setDirections(response);
                    oldDirectionsDisplay = directionsDisplay;

                    showSteps(response)

                } else {
                    // Xử lý lỗi nếu có
                    console.error("Lỗi: " + status);
                }
            })

            var address = '';
            if (place.address_components) {
                address = [
                  (place.address_components[0] && place.address_components[0].short_name || ''),
                  (place.address_components[1] && place.address_components[1].short_name || ''),
                  (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
        
            infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address + '</div>');
            infowindow.open(map, marker);
        

            locateden = encodeURIComponent(place.name)
            latden =place.geometry.location.lat()
            lngden =place.geometry.location.lng()

            console.log(kcach)

            okBtn.addEventListener('click', () => {
                window.location.href ="index.php?locateden="+locateden+"&latden="+latden+"&lngden="+lngden+"&kcach="+kcach;
            })

        });

        function showSteps(directionResult) {
    
            var myRoute = directionResult.routes[0].legs[0];

            kcach = (myRoute.distanceMeters/1000).toFixed(2)

            for (var i = 0; i < myRoute.steps.length; i++) {
                var marker = new google.maps.Marker({
                    position: myRoute.steps[i].start_point,
                    map: map,
                    icon: {
                        url: 'images/dot.png',
                        scaledSize: new google.maps.Size(18, 18)
                    }
                });
                attachInstructionText(marker, myRoute.steps[i].instructions);
                markerArray[i] = marker;
                console.log(myRoute.steps[i].instructions)
            }
        }

        function attachInstructionText(marker, text) {
            google.maps.event.addListener(marker, 'click', function() {
                stepDisplay.setContent(text);
                stepDisplay.open(map, marker);
            });
        }

    }

    initMap()


}


getLocation()




</script>

<div class="hero-wrap ftco-degree-bg" style="background-image: url('images/bg_1.jpg');"
    data-stellar-background-ratio="0.5"></div>
<style>
    .showmap {
        padding: 10px;
        width: 80%;
        height: 75%;
        z-index: 99;
        background-color: white;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .map {
        height: 100% !important;
        width: 100% !important;
    }

    .search-group {
        position: absolute;
        top: 0;
        right: 0 !important;
        margin: 20px;
        width: 27%;
        z-index: 999;
    }

    .info-group {
        display: none;
        position: absolute;
        top: 4rem;
        right: 0 !important;
        margin: 20px;
        width: 27%;
        z-index: 999;
    }

    .waypoint-group {
        display: none;
        position: absolute;
        top: 8rem;
        right: 0 !important;
        margin: 20px;
        width: 27%;
        z-index: 999;
    }

    .result {
        background-color: white;
    }

    .progress-container {
        width: 100%;
        background-color: #ccc;
        display: none;
    }

    .progress-bar {
        width: 0;
        height: 10px;
        background-color: #4CAF50;
        text-align: center;
        line-height: 30px;
        color: white;
    }
</style>