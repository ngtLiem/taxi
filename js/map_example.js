
const map = L.map('map').setView([10.03, 105.77], 13); //khu vực hiển thị theo vị trí hiện tại

var marker = L.marker([10.03, 105.77]).addTo(map); //đặt vị trí hiện tại của khách hàng

var popup = L.popup()

L.Routing.control({
    waypoints: [
      L.latLng(10.03, 105.77),
      L.latLng(10.029594, 105.776303)
    ]
  }).addTo(map);

const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent(`You clicked the map at ${e.latlng.toString()}`)
        .openOn(map);
}



map.on('click', onMapClick);

function getLocation() {
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
  } else {
      document.getElementById("location").innerHTML = "Trình duyệt của bạn không hỗ trợ định vị.";
  }
}

function showPosition(position) {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  document.getElementById("location").innerHTML = "Vĩ độ: " + latitude + "<br> Kinh độ: " + longitude;

  // Gửi vị trí đến máy chủ PHP
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "process.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("latitude=" + latitude + "&longitude=" + longitude);
}