<?php
$activate = "index";
@include('header.php');
unset($_SESSION['latdi']);
unset($_SESSION['lngdi']);
?>


<?php 
if (isset($_POST['tx_ma'])) {
  $form_action = "xulydatxe.php";
  $matx = $_POST['tx_ma'];
} else {
        // Sử dụng tọa độ mặc định
        $latDi = 10.031231553362591;
        $lngDi = 105.76916077529324;
    }
  $form_action = "chon_taixe.php";
  $matx = '';

?>

<div class="showmap"> 
    <div id="map" class="map leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom" tabindex="0">
        <div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(0px, 0px, 0px);"></div>
    </div>
    <div class="leaflet-control-container">
        <div class="leaflet-top leaflet-right"></div>
        <div class="leaflet-bottom leaflet-left"></div>
        <div class="leaflet-bottom leaflet-right"></div>
    </div>
</div>

<button
    class="btn btn-success"
    style="
        position: fixed;
        bottom: 5%;
        right: 5%;
        z-index: 999;
    "
    id="confirmLocationButtonDi">
    CHẤP NHẬN
</button>
<!-- ... (Phần HTML khác) ... -->

<link rel="stylesheet" href="map_data/leaflet-search/src/leaflet-search.css">
    <script src="map_data/leaflet-search/src/leaflet-search.js"></script>
    <script src="map_data/locations.js"></script>
<script>

    var latitude = "";
    var longitude = "";

    getLocation()

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
        progress()
    }


    function progress(){

        // Tạo biến lưu trữ tọa độ đã pin
        let pinnedLocation = null;
    
        var map = L.map('map').setView([10.031231553362591, 105.76916077529324], 13);
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    
        var customIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            iconSize: [25, 41],
        });
        var userMaker = L.icon({
            iconUrl: 'images/user-maker.png',
            iconSize: [40,50],
        })
        var marker = null;
        marker = L.marker([latitude, longitude], { 
            icon: userMaker
        }).addTo(map);
    

        console.log(locationsJSON)


        map.on('click', function (e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            pinnedLocation = e.latlng;

            lat =pinnedLocation2.lat
            lng =pinnedLocation2.lng
            name = "Vị trí được chọn"
    
            if (defaultLocationMarker) {
                map.removeLayer(defaultLocationMarker);
                defaultLocationMarker = null;
            }
        });

        var dotIcon = L.icon({
            iconUrl: 'images/dot.png',
            iconSize: [13, 13], 
            iconAnchor: [7 , 0]
        });

        const searchLayer = L.geoJSON(locationsJSON, {
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, {
                    icon: dotIcon
                });
            },
            onEachFeature:function(feature, layer){
                layer.bindPopup('Bạn đang chọn: '+feature.properties.name)
            }
        }).addTo(map)
        
        const searchControl = new L.Control.Search({
            layer: searchLayer,
            propertyName: "name",
            position: 'topright',
            hideMarkerOnCollapse: true
        });

        map.addControl(searchControl)

        searchLayer.on('click', function(e) {
            var latlng = e.latlng
            var clickedFeature = e.layer.feature;
            var coordinates = clickedFeature.geometry.coordinates;
            lng = coordinates[0]; 
            lat = coordinates[1]; 
            name = clickedFeature.properties.name;
            if (marker) {
                marker.setLatLng(latlng);
            } else {
                marker = L.marker(latlng).addTo(map);
            }
        });

        searchControl.on('search:locationfound', function(e) {
            var latlng = e.latlng; 
            lng = latlng.lng; 
            lat = latlng.lat; 
            if (marker) {
                marker.setLatLng(latlng);
            } else {
                marker = L.marker(latlng).addTo(map);
            }
        });
    
        const confirmLocationButtonDi = document.getElementById('confirmLocationButtonDi');
        confirmLocationButtonDi.addEventListener('click', function () {
            window.location.href = `index.php?dr=from&locatedi=${name}&latdi=${lat}&lngdi=${lng}`;
        });
    }
    
</script>

<!-- ... (Phần HTML khác) ... -->


<div class="hero-wrap ftco-degree-bg" style="background-image: url('images/bg_1.jpg');" data-stellar-background-ratio="0.5"></div>
<style> 
    .showmap{
        padding: 10px;
        width: 80%;
        height: 55%;
        z-index: 99;
        background-color: white;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<<script>

    // Lắng nghe sự kiện click trên nút OK
const confirmLocationButtonDi = document.getElementById('confirmLocationButtonDi');
confirmLocationButtonDi.addEventListener('click', function () {
    // Kiểm tra xem đã có tọa độ đã pin
    if (pinnedLocation) {
        const defaultLat = 10.031231553362591;
        const defaultLng = 105.76916077529324;

        // Kiểm tra xem tọa độ đã pin có phải là tọa độ mặc định không
        if (pinnedLocation.lat === defaultLat && pinnedLocation.lng === defaultLng) {
            // Nếu tọa độ hiện tại là mặc định, chuyển hướng về trang index
            window.location.href = 'index.php';
        } else {
            // Nếu tọa độ khác mặc định, chuyển hướng về trang index và truyền tọa độ làm tham số URL
            window.location.href = `index.php?lat=${pinnedLocation.lat}&lng=${pinnedLocation.lng}`;
        } 
    }
    else{
             // Nếu không có tọa độ đã pin, chuyển hướng về trang index mà không cần pin tọa độ mới
            window.location.href = 'index.php';
        }
});

   
</script>

