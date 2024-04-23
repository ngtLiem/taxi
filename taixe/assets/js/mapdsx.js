// Đường dẫn tới hình ảnh của xe ô tô
const carIconUrl = 'assets/img/iconxe.png';

// Tạo biểu tượng xe ô tô bằng hình ảnh
const carIcon = L.icon({
    iconUrl: carIconUrl,
    iconSize: [30, 30], // Kích thước của biểu tượng
    iconAnchor: [15, 15] // Điểm neo
});

// mapdsx.js
const map = L.map('mapds').setView([10.03, 105.77], 15);

const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

function onMapClick(e) {
    const popup = L.popup()
        .setLatLng(e.latlng)
        .setContent(`You clicked the map at ${e.latlng.toString()}`)
        .openOn(map);
}

map.on('click', onMapClick);

// Truy cập dữ liệu JSON từ biến jsonData
console.log(jsonData);

// Hàm ánh xạ giá trị trạng thái
function mapTrangThai(trangThai) {
    return trangThai === '1' ? 'Rảnh' : 'Bận';
}

// ...

// Ví dụ: Làm việc với dữ liệu JSON
jsonData.forEach(function (item) {
    const marker = L.marker([item.TT_TOADOX, item.TT_TOADOY], {
        icon: carIcon // Sử dụng biểu tượng xe ô tô
    }).addTo(map);

    // Ánh xạ giá trị trạng thái
    const trangThai = mapTrangThai(item.TT_TRANGTHAI);

    // Tạo popup cho mỗi marker
    const popup = L.popup()
        .setLatLng([item.TT_TOADOX, item.TT_TOADOY])
        .setContent(`<b>Tên tài xế:</b> ${item.TX_TEN}<br><b>Trạng thái:</b> ${trangThai}<br><b>Tọa độ:</b> ${item.TT_TOADOX},<b></b> ${item.TT_TOADOY}`);
    
    marker.on('click', function() {
        popup.openOn(map);
    });
});
