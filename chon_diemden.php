<?php
$activate = "index";
@include('header.php');
?>

<div class="showmap rounded">
    <div id="map"
        class="map rounded leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"
        tabindex="0">
        <div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(0px, 0px, 0px);"></div>
    </div>
    <div class="leaflet-control-container">
        <div class="leaflet-top leaflet-right"></div>
        <div class="leaflet-bottom leaflet-left"></div>
        <div class="leaflet-bottom leaflet-right"></div>
    </div>
    <div class="form-group search-group">
        <div class="d-flex">
            <input type="text" style="font-size: 14px" name="search-box" id="search-box"
				placeholder="Nhập địa điểm muốn đến (hoặc chọn trên bản đồ)" class="form-control">
            <input type="button" value="Tìm" id="search-button" class="btn btn-primary px-3 ml-3">
        </div>
        <div class="result rounded mt-2 p-2 text-center" id="result">
            <span id="dfText">Chưa có dữ liệu</span>
            <ul class="w-100" id="result-list"></ul>
        </div>
        <div class="progress-container" id="pgrBar">
            <div class="progress-bar" id="myProgressBar"></div>
        </div>
    </div>

</div>

<button class="btn btn-danger" style="
        position: fixed;
        display: none;
        bottom: 5%;
        right: 19%;
        padding: 10px 40px;
        z-index: 9999;
    " id="btnXoa">
    Xoá
</button>
<script>

    const userMakerUrl = 'images/user-maker.png'
    const userMakerIC = L.icon({
        iconUrl: userMakerUrl,
        iconSize: [40, 50],
        iconAnchor: [15, 15]
    })

    function createMap() {

    }

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


        let pinnedLocation2 = null;
        var lng = ""
        var lat = ""
        var location = ""

        const map = L.map('map').setView([latitude, longitude], 15);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        const userMarker = L.marker([latitude, longitude], { icon: userMakerIC }).addTo(map);
        const userPopup = L.popup()
            .setLatLng([latitude, longitude])
            .setContent("Bạn đang ở đây!").openOn(map)

        //Tim kiem

        function updateProgressBar() {
            var width = 0;
            var interval = setInterval(function () {
                if (width >= 100) {
                    clearInterval(interval);
                } else {
                    width++;
                    progressBar.style.width = width + '%';
                    progressBar.innerHTML = width + '%';
                }
            }, 10);
        }

        function findMidpoint(userX, userY, toX, toY) {
            // Chuyển đổi chuỗi thành số
            const usX = parseFloat(userX);
            const usY = parseFloat(userY);
            const tX = parseFloat(toX);
            const tY = parseFloat(toY);
            // Tính toán toạ độ ở giữa
            const midLat = (usX + tX) / 2;
            const midLng = (usY + tY) / 2;

            return [midLat, midLng];
        }

        // Ví dụ sử dụng
        const coordStrA = "10.0,20.0"; // Toạ độ A dạng chuỗi
        const coordStrB = "15.0,25.0"; // Toạ độ B dạng chuỗi

        const midpoint = findMidpoint(coordStrA, coordStrB);
        console.log(midpoint); // Kết quả: [12.5, 22.5]



        function getBoundingBox(latitude, longitude, radius) {
            // Earth's radius in kilometers
            const earthRadius = 6371;

            // Convert radius from kilometers to radians
            const radiusInRadians = radius / earthRadius;

            // Convert latitude and longitude from degrees to radians
            const latInRadians = (latitude * Math.PI) / 180;
            const lonInRadians = (longitude * Math.PI) / 180;

            // Calculate the north, south, east, and west points of the bounding box
            const north = latInRadians + radiusInRadians;
            const south = latInRadians - radiusInRadians;
            const east = lonInRadians + radiusInRadians;
            const west = lonInRadians - radiusInRadians;

            // Convert the results from radians back to degrees
            const northInDegrees = (north * 180) / Math.PI;
            const southInDegrees = (south * 180) / Math.PI;
            const eastInDegrees = (east * 180) / Math.PI;
            const westInDegrees = (west * 180) / Math.PI;

            // Return the bounding box coordinates
            return [westInDegrees, southInDegrees, eastInDegrees, northInDegrees];
        }

        function getBoundingBoxString(latitude, longitude, radius) {
            const boundingBox = getBoundingBox(latitude, longitude, radius);
            return boundingBox.join(',');
        }

        const boundingBox = getBoundingBoxString(latitude, longitude, 20)

        const dfText = document.getElementById("dfText")
        const ipSearch = document.getElementById("search-box")
        const btnSearch = document.getElementById("search-button")
        const btnXoa = document.getElementById("btnXoa")
        const ulList = document.getElementById("result-list")
        const progressBar = document.getElementById('myProgressBar');
        const pgrBar = document.getElementById('pgrBar');

        var crMarker = []
        var popup = null
        var route = null

        btnXoa.addEventListener('click', () => {
            ulList.innerHTML = ""
            ipSearch.value = ""
            crMarker.forEach(mk => {
                mk.remove()
            });
            crMarker = []
            route.remove()
            popup.remove()
            map.flyTo([latitude, longitude], 15)
            btnXoa.style.display = "none"
        })

        btnSearch.addEventListener('click', () => {
            pgrBar.style.display = "block"
            updateProgressBar();
            if (marker) {
                marker.remove()
            }
            if (popup) {
                popup.remove()
            }
            if (route) {
                route.remove()
            }
            var query = ipSearch.value
            var apiUrl = "https://nominatim.openstreetmap.org/search?format=json&limit=5&viewbox=" + boundingBox + "&bounded=1&q=" + query;
            fetch(apiUrl)
                .then(result => result.json())
                .then(parsedResult => {
                    pgrBar.style.display = "none"
                    if (parsedResult.length == 0) {
                        dfText.innerHTML = "Không tìm thấy địa điểm phù hợp"
                    } else {
                        dfText.style.display = "none"
                        btnXoa.style.display = "block"
                        setResultList(parsedResult)
                    }
                })
        })

        function setResultList(parsedResult) {
            ulList.innerHTML = ""
            for (const foundMarker of crMarker) {
                map.remove(marker)
            }
            map.flyTo(new L.LatLng(latitude, longitude), 14)
            for (const rs of parsedResult) {
                console.log(rs)
                const li = document.createElement("li")
                li.classList.add('list-group-item', 'list-group-item-action')
                li.innerHTML = JSON.stringify({
                    name: rs.display_name,
                    lat: rs.lat,
                    lon: rs.lon
                }, undefined, 2)
                li.addEventListener('click', (e) => {
                    for (const child of ulList.children) {
                        child.classList.remove('active')
                    }
                    e.target.classList.add('active')
                    const clickedData = JSON.parse(e.target.innerHTML)
                    const position = new L.LatLng(clickedData.lat, clickedData.lon)

                    if (route) route.remove()
                    route = L.Routing.control({
                        waypoints: [
                            L.latLng(latitude, longitude),
                            L.latLng(clickedData.lat, clickedData.lon)
                        ],
                        draggableWaypoints: false,
                        routeWhileDragging: false,
                        fitSelectedRoutes: false,
                        lineOptions: {
                            styles: [{ color: '#19d600', opacity: 0.6, weight: 6 }]
                        },
                        createMarker: function () { return null }
                    }).addTo(map)

                    route.on('routesfound', function (event) {
                        var routes = event.routes;
                        var summary = routes[0].summary;
                        console.log(routes[0])
                        distance = (summary.totalDistance / 1000).toFixed(2);
                        console.log(distance)

                        popup = L.popup().setLatLng(position)
                            .setContent(clickedData.name + '<br><a class="justify-content-center" href="index.php?locateden=' + clickedData.name + '&latden=' + clickedData.lat + '&lngden=' + clickedData.lon + '&kcach=' + distance + '"><button style="margin: 0 !important;" class="btn btn-primary mt-1">Xác nhận</button></a>')
                            .openOn(map)
                    });



                    map.flyTo(findMidpoint(latitude, longitude, clickedData.lat, clickedData.lon), 15)
                })
                const position = new L.LatLng(rs.lat, rs.lon)
                crMarker.push(new L.marker(position).addTo(map))
                ulList.appendChild(li)
            }
        }

        //Cham diem tren map

        var popup = null
        var marker = null
        var apiUrl = ""
        map.on('click', function (e) {

            if (marker) {
                marker.remove()
            }
            if (popup) {
                popup.remove()
            }
            if (route) {
                route.remove()
            }

            pinnedLocation2 = e.latlng;
            lat = pinnedLocation2.lat
            lng = pinnedLocation2.lng

            apiUrl = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`;

            async function fetchData() {
                try {
                    const res = await fetch(apiUrl)
                    if (!res.ok) throw new Error("Loi")
                    const data = await res.json()

                    console.log(data)
                    location = data.display_name

                    marker = L.marker(pinnedLocation2).addTo(map);

                    route = L.Routing.control({
                        waypoints: [
                            L.latLng(latitude, longitude),
                            L.latLng(pinnedLocation2)
                        ],
                        draggableWaypoints: false,
                        routeWhileDragging: false,
                        fitSelectedRoutes: false,
                        lineOptions: {
                            styles: [{ color: '#19d600', opacity: 0.6, weight: 6 }]
                        },
                        createMarker: function () { return null }
                    }).addTo(map)

                    route.on('routesfound', function (event) {
                        var routes = event.routes;
                        var summary = routes[0].summary;
                        console.log(routes[0])
                        distance = (summary.totalDistance / 1000).toFixed(2);
                        console.log(distance)
                        popup = L.popup().setLatLng(pinnedLocation2)
                            .setContent(location + '<br><a class="justify-content-center" href="index.php?locateden=' + location + '&latden=' + lat + '&lngden=' + lng + '&kcach=' + distance + '"><button style="margin: 0 !important;"  class="btn btn-primary mt-1">Xác nhận</button></a>')
                            .openOn(map)
                    });



                    map.flyTo(findMidpoint(latitude, longitude, lat, lon), 17)

                } catch (e) {
                    console.error(e)
                }
            }
            btnXoa.style.display = "block"
            fetchData()
        });
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
        width: 70% !important;
    }

    .search-group {
        position: absolute;
        top: 0;
        right: 0;
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