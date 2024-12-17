<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông báo mới nhất
$sql_notifications = "SELECT * FROM notifications WHERE type IN ('Đơn Hàng Mới', 'Blog Mới') ORDER BY created_at DESC LIMIT 1";
$result_notifications = $conn->query($sql_notifications);

$notifications = [];
if ($result_notifications->num_rows > 0) {
    while ($row = $result_notifications->fetch_assoc()) {
        $notifications[] = $row;
    }
}

// Trả về kết quả dạng JSON
header('Content-Type: application/json');
echo json_encode(['notifications' => $notifications]);

$conn->close();
?>
