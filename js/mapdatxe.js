// getLocation()

//     function getLocation() {
//         if (navigator.geolocation) {
//             navigator.geolocation.getCurrentPosition(showPosition);
//         } else {
//             document.getElementById("location").innerHTML = "Trình duyệt của bạn không hỗ trợ định vị.";
//         }
//       }
    
      
//     function showPosition(position) {
//         var latitude = position.coords.latitude;
//         var longitude = position.coords.longitude;
//         const map = L.map('map').setView([latitude, longitude], 13); //khu vực hiển thị theo vị trí hiện tại
     
//         var marker = L.marker([latitude, longitude]).addTo(map); //đặt vị trí hiện tại của khách hàng
    
//         var popup = L.popup()
    
//         // L.circle([latitude, longitude], {radius: 6000}).addTo(map);
//         const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
//             maxZoom: 19,
//             attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
//         }).addTo(map)
        
        
//     }
//     // Trong tệp "mapdatxe.js"

// // Lắng nghe sự kiện click trên nút "Ghim Địa Điểm"
//         const pinLocationButton = document.getElementById('pinLocationButton');
//         pinLocationButton.addEventListener('click', function () {
//             // Hiển thị bản đồ bằng cách thiết lập style của phần tử chứa bản đồ thành "block"
//             const mapContainer = document.getElementById('mapContainer');
//             mapContainer.style.display = 'block';

//             // Bây giờ bạn có thể cho phép người dùng ghim vị trí trên bản đồ tại đây
//         });




// Khởi tạo biến để lưu vị trí
let pinnedLocation = null;
// Tạo một biểu tượng (icon)
    const pinnedIcon = L.icon({
    iconUrl: 'path/to/your/icon.png', // Đường dẫn đến biểu tượng của bạn
    iconSize: [32, 32], // Kích thước biểu tượng (tùy chỉnh cho biểu tượng của bạn)
    iconAnchor: [16, 32], // Điểm neo biểu tượng (tùy chỉnh cho biểu tượng của bạn)
});
// Tạo bản đồ với vị trí hiện tại
getLocation();

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

    const map = L.map('map').setView([latitude, longitude], 13);
    var popup = L.popup();

    // Tạo một marker tại vị trí người dùng đã nhấp vào
    var marker = L.marker([latitude, longitude]);

    // Thêm marker vào bản đồ
    marker.addTo(map);

    // Lắng nghe sự kiện click trên bản đồ để ghim vị trí
    map.on('click', function (e) {
       
        pinnedLocation = e.latlng; // Lưu vị trí khi người dùng click vào
       // Thay vì sử dụng biểu tượng, sử dụng hình ảnh từ liên kết
       var iconUrl = 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png';
       var customIcon = L.icon({
           iconUrl: iconUrl,
           iconSize: [25, 41], // Kích thước của hình ảnh
           iconAnchor: [12, 41], // Điểm neo của hình ảnh
       });
        // Tạo một marker sử dụng hình ảnh từ liên kết
        L.marker(pinnedLocation, { icon: customIcon }).addTo(map);

        popup.setLatLng(e.latlng).setContent(`Vị trí đã ghim: ${e.latlng.toString()}`).openOn(map);
        
    });

    fetch('luu_diadiem.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ latlng: pinnedLocation }),
    });
    
    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Lắng nghe sự kiện click trên nút "Ghim Địa Điểm"
    const pinLocationButton = document.getElementById('pinLocationButton');
    pinLocationButton.addEventListener('click', function () {
        // Hiển thị bản đồ bằng cách thiết lập style của phần tử chứa bản đồ thành "block"
        const mapContainer = document.getElementById('map');
        mapContainer.style.display = 'block';
    });
}


